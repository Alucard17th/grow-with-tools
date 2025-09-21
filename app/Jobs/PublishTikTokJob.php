<?php

namespace App\Jobs;

use App\Models\ScheduledPost;
use App\Models\TikTokToken;
use App\Services\TikTokClient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class PublishTikTokJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public ScheduledPost $post) {}

    public function handle(TikTokClient $api): void
    {
        $post = $this->post->fresh();

        \Log::info('TTK JOB start', [
            'id' => $post?->id,
            'status' => $post?->status,
            'video_source' => $post?->video_source,
        ]);

        if (!$post || in_array($post->status, ['init','publishing','published'])) {
            \Log::info('TTK JOB skip', ['id'=>$post?->id, 'status'=>$post?->status]);
            return;
        }

        // Block FILE_UPLOAD path (not implemented)
        if ($post->video_source !== 'PULL_FROM_URL') {
            $post->update(['status'=>'failed','error'=>'FILE_UPLOAD flow not implemented. Use PULL_FROM_URL with a direct MP4.']);
            \Log::warning('TTK JOB aborted: FILE_UPLOAD not implemented', ['id'=>$post->id]);
            return;
        }

        $token = TikTokToken::where('user_id', $post->user_id)->firstOrFail();
        $token = $api->ensureFreshToken($token);

        $postInfo = [
            'privacy_level' => $post->privacy,
            'disable_duet'  => (bool)$post->disable_duet,
            'disable_stitch'=> (bool)$post->disable_stitch,
            'disable_comment'=> (bool)$post->disable_comment,
            'brand_organic_toggle' => (bool)$post->brand_organic_toggle,
        ];
        if (!is_null($post->cover_ts_ms)) $postInfo['video_cover_timestamp_ms'] = (int) $post->cover_ts_ms;
        if (filled($post->caption)) $postInfo['title'] = mb_substr($post->caption, 0, 2200);

        $payload = [
            'post_info'   => $postInfo,
            'source_info' => [
                'source'    => 'PULL_FROM_URL',
                'video_url' => $post->video_url,
            ],
        ];

        \Log::info('TTK INIT payload', [
            'id' => $post->id,
            'privacy' => $postInfo['privacy_level'],
            'video_url' => $post->video_url,
        ]);

        $post->update(['status'=>'init']);

        try {
            $init = $api->directPostInit($payload, $token);
            \Log::info('TTK INIT response', ['id'=>$post->id, 'resp' => $init]);

            $publishId = $init['data']['publish_id'] ?? null;
            if (!$publishId) {
                $post->update(['status'=>'failed','error'=>json_encode($init)]);
                return;
            }

            $post->update(['status'=>'publishing','publish_id'=>$publishId]);
            \App\Jobs\FetchTikTokStatusJob::dispatch($post)->delay(now()->addSeconds(25));
        } catch (\Throwable $e) {
            \Log::error('TTK INIT error', [
                'id'=>$post->id,
                'msg'=>$e->getMessage(),
                'file'=>$e->getFile(),
                'line'=>$e->getLine(),
            ]);
            $post->update(['status'=>'failed','error'=>$e->getMessage()]);
            throw $e;
        }
    }

}
