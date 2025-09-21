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

class FetchTikTokStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public ScheduledPost $post) {}

    public function handle(TikTokClient $api): void
    {
        $post = $this->post->fresh();
        if (!$post || !$post->publish_id || $post->status !== 'publishing') return;

        $token = TikTokToken::where('user_id', $post->user_id)->firstOrFail();
        $status = $api->fetchPublishStatus($post->publish_id, $token);

        $state = $status['data']['status'] ?? null; // SUCCEEDED / FAILED / PROCESSING

        if ($state === 'SUCCEEDED') {
            $url = $status['data']['video_url'] ?? null;
            $post->update(['status'=>'published','tiktok_post_url'=>$url]);
            return;
        }

        if ($state === 'FAILED') {
            $post->update(['status'=>'failed','error'=>json_encode($status)]);
            return;
        }

        // still processing → re-check
        self::dispatch($post)->delay(now()->addSeconds(30));
    }
}
