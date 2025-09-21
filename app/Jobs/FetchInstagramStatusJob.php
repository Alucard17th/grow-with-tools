<?php

namespace App\Jobs;

use App\Models\ScheduledPost;
use App\Models\InstagramToken;
use App\Services\InstagramClient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchInstagramStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public ScheduledPost $post) {}

    public function handle(InstagramClient $api): void
    {
        $post = $this->post->fresh();
        if (!$post || $post->status !== 'publishing' || empty($post->publish_id)) {
            \Log::info('IG STATUS skip', ['id'=>$post?->id, 'status'=>$post?->status]);
            return;
        }

        $token = InstagramToken::where('user_id', $post->user_id)->firstOrFail();

        try {
            $status = $api->fetchContainerStatus($post->publish_id, $token->access_token);
            $code   = strtoupper((string)($status['status_code'] ?? $status['status'] ?? ''));
            \Log::info('IG STATUS response', ['id'=>$post->id, 'resp'=>$status]);

            if (in_array($code, ['FINISHED','PUBLISHED','READY','PUBLISHED_READY'])) {
                $post->update(['status'=>'published']);
                return;
            }

            if (in_array($code, ['ERROR','FAILED'])) {
                $post->update(['status'=>'failed','error'=>json_encode($status)]);
                return;
            }

            // Still processing; re-check later
            self::dispatch($post)->delay(now()->addSeconds(25));

        } catch (\Throwable $e) {
            \Log::error('IG STATUS error', [
                'id'=>$post->id, 'msg'=>$e->getMessage(),
                'file'=>$e->getFile(), 'line'=>$e->getLine(),
            ]);
            // Backoff retry
            self::dispatch($post)->delay(now()->addMinutes(2));
        }
    }
}
