<?php

namespace App\Jobs;

use App\Models\ScheduledPost;
use App\Models\InstagramToken;
use App\Services\InstagramClient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
// use Illuminate\Queue\SerializesModels;

class PublishInstagramJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    public function __construct(public int $postId) {}

    public function handle(InstagramClient $api): void
    {
        $post = ScheduledPost::find($this->postId); // Reload model
        \Log::info('IG JOB start', [
            'id'          => $post?->id,
            'status'      => $post?->status,
            'video_source'=> $post?->video_source,
        ]);

        if (!$post || in_array($post->status, ['init','publishing','published'])) {
            \Log::info('IG JOB skip', ['id'=>$post?->id, 'status'=>$post?->status]);
            return;
        }

        if ($post->video_source !== 'PULL_FROM_URL') {
            $post->update(['status'=>'failed','error'=>'FILE_UPLOAD flow not implemented. Use PULL_FROM_URL with a direct MP4.']);
            \Log::warning('IG JOB aborted: FILE_UPLOAD not implemented', ['id'=>$post->id]);
            return;
        }

        try {
            $token = InstagramToken::where('user_id', $post->user_id)->firstOrFail();
            $token = $api->ensureFreshToken($token);

            // Build container payload
            $isReel = (bool) ($post->is_reel ?? true); // default to Reels
            $mediaType = $isReel ? 'REELS' : 'VIDEO';

            $payload = [
                'media_type' => $mediaType,
                'video_url'  => $post->video_url,            // must be publicly accessible
                'caption'    => mb_substr((string)$post->caption, 0, 2200),
            ];

            // Optional: pick a cover frame (in seconds)
            if (!is_null($post->cover_ts_ms)) {
                $payload['thumb_offset'] = (int) floor(((int)$post->cover_ts_ms) / 1000);
            }

            \Log::info('IG INIT payload', [
                'id'        => $post->id,
                'mediaType' => $mediaType,
                'video_url' => $post->video_url,
            ]);

            $post->update(['status'=>'init']);

            // Step 1: create media container
            $container = $api->createMediaContainer($token->ig_user_id, $token->access_token, $payload);
            \Log::info('IG INIT response', ['id'=>$post->id, 'resp' => $container]);

            $creationId = $container['id'] ?? null;
            if (!$creationId) {
                $post->update(['status'=>'failed','error'=>json_encode($container)]);
                return;
            }

            // Step 2: publish
            // $publish = $api->publishMedia($token->ig_user_id, $token->access_token, $creationId);
            // \Log::info('IG PUBLISH response', ['id'=>$post->id, 'resp' => $publish]);

            // Don't publish yet for video! Wait until status_code == FINISHED
            $post->update(['status'=>'publishing', 'publish_id'=>$creationId]);

            // Poll in ~25s (IG can take time to finish transcoding)
            \App\Jobs\FetchInstagramStatusJob::dispatch($post)->delay(now()->addSeconds(25));

        } catch (\Throwable $e) {
            \Log::error('IG INIT/PUBLISH error', [
                'id'  => $post->id,
                'msg' => $e->getMessage(),
                'file'=> $e->getFile(),
                'line'=> $e->getLine(),
            ]);
            $post->update(['status'=>'failed','error'=>$e->getMessage()]);
            throw $e;
        }
    }
}
