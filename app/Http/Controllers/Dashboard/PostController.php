<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ScheduledPost;
use App\Models\TikTokToken;
use App\Jobs\PublishTikTokJob;
use App\Jobs\PublishInstagramJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ScheduledPostRequest;

class PostController extends Controller
{   
    /** Editable statuses only */
    private const EDITABLE = ['queued', 'draft', 'failed'];

    public function index()
    {
        $posts = ScheduledPost::latest()->paginate(12);
        $token = TikTokToken::where('user_id', Auth::id())->first();
        return view('dashboard.tiktoks.index', compact('posts','token'));
    }

    public function create()
    {
        return view('dashboard.tiktoks.create');
    }

    public function store(Request $r)
    {
        // Validate with conditional requirements
        $data = $r->validate([
            'product' => 'required|string|max:64',
            'title'   => 'nullable|string|max:120',
            'caption' => 'nullable|string|max:2200',

            'platform' => 'required|in:tiktok,instagram',

            'video_source' => 'required|in:PULL_FROM_URL,FILE_UPLOAD',
            // 'video_url'    => 'required_if:video_source,PULL_FROM_URL|url',
            'file'         => 'required_if:video_source,FILE_UPLOAD|file|mimetypes:video/mp4,video/quicktime|max:512000', // up to 500MB

            'cover_ts_ms'  => 'nullable|integer|min:0',
            'privacy'      => 'required|in:PUBLIC_TO_EVERYONE,MUTUAL_FOLLOW_FRIENDS,FOLLOWER_OF_CREATOR,SELF_ONLY',
            'disable_duet'   => 'sometimes|boolean',
            'disable_stitch' => 'sometimes|boolean',
            'disable_comment'=> 'sometimes|boolean',
            'brand_organic_toggle' => 'sometimes|boolean',
            'publish_at'    => 'required|date',
        ], [
            'file.required_if' => 'Please choose a video file to upload.',
            'video_url.required_if' => 'Please provide a video URL when using PULL_FROM_URL.',
        ]);

        $data['user_id'] = \Auth::id();

        // If FILE_UPLOAD, store to public disk and turn it into a pullable URL
        if (($data['video_source'] ?? null) === 'FILE_UPLOAD' && $r->hasFile('file')) {
            // Store as storage/app/public/videos/xxxx.mp4
            $path = $r->file('file')->store('videos', 'public');  // public disk
            $publicUrl = \Storage::disk('public')->url($path);    // https://APP_URL/storage/videos/xxxx.mp4

            // If you want to force a specific verified base (e.g., a CDN), rewrite the host:
            if ($base = rtrim(env('MEDIA_BASE_URL', ''), '/')) {
                // Result: https://verified-domain.com/storage/videos/xxxx.mp4
                $publicUrl = $base . '/storage/' . ltrim($path, '/');
            }

            // Persist both the file path and the public URL
            $data['file_path']   = $path;
            $data['video_url']   = $publicUrl;

            // Normalize the source so the job uses the same Direct Post path
            $data['video_source'] = 'PULL_FROM_URL';
        }

        $post = \App\Models\ScheduledPost::create($data);

        return redirect()->route('posts.index')->with('ok', 'Post scheduled.');
    }

    public function publishNow(ScheduledPost $post)
    {
        logger()->info('Publishing now', ['post' => $post]);
        abort_unless($post->user_id === Auth::id(), 403);
        if($post->platform == 'instagram') {
            PublishInstagramJob::dispatch($post);
            return back()->with('ok','Publishing started.');
        }
        PublishTikTokJob::dispatch($post);
        return back()->with('ok','Publishing started.');
    }

     public function edit(ScheduledPost $post)
    {
        abort_unless($post->user_id === Auth::id(), 403);

        $locked = ! in_array($post->status, self::EDITABLE, true);

        return view('dashboard.tiktoks.edit', compact('post', 'locked'));
    }

    public function update(ScheduledPostRequest $req, ScheduledPost $post)
    {
        abort_unless($post->user_id === Auth::id(), 403);

        // Server-side lock: forbid edits when in-flight or published
        if (! in_array($post->status, self::EDITABLE, true)) {
            return back()->with('error', 'This post can no longer be edited.');
        }

        $data = $req->validated();

        // Handle FILE_UPLOAD → store to public disk and convert to pullable URL
        if (($data['video_source'] ?? null) === 'FILE_UPLOAD' && $req->hasFile('file')) {
            $path = $req->file('file')->store('videos', 'public');  // storage/app/public/videos/...
            $publicUrl = Storage::disk('public')->url($path);       // https://APP_URL/storage/videos/...

            if ($base = rtrim(env('MEDIA_BASE_URL', ''), '/')) {
                $publicUrl = $base . '/storage/' . ltrim($path, '/');
            }

            $data['file_path']   = $path;
            $data['video_url']   = $publicUrl;
            $data['video_source'] = 'PULL_FROM_URL'; // normalize so the job uses the same Direct Post flow
        }

        // Optional: enforce verified prefix to avoid 403 later
        if ($base = rtrim(env('MEDIA_BASE_URL', ''), '/')) {
            if (!empty($data['video_url']) && !str_starts_with($data['video_url'], $base.'/')) {
                return back()->withErrors(['video_url' => "Video URL must start with {$base}/ (verified domain)."])
                             ->withInput();
            }
        }

        // Booleans (checkboxes) normalize
        foreach (['disable_duet','disable_stitch','disable_comment','brand_organic_toggle'] as $flag) {
            $data[$flag] = (bool) ($data[$flag] ?? false);
        }

        $data['video_source'] = 'PULL_FROM_URL'; // normalize

        // Save
        $post->update($data);

        return redirect()->route('posts.index')->with('ok', 'Post updated.');
    }

    public function destroy(ScheduledPost $post)
    {
        abort_unless($post->user_id === Auth::id(), 403);
        $post->delete();
        return redirect()->route('posts.index')->with('ok', 'Post deleted.');
    }
}
