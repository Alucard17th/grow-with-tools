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

    // ✅ This both declares AND initializes $post
    public function __construct(public ScheduledPost $post) {}

    public $tries = 40;
    public $maxExceptions = 8;
    public $timeout = 120;

    public function retryUntil() { return now()->addMinutes(30); }

    protected function nextDelay(bool $penalize = false): int
    {
        $a = method_exists($this, 'attempts') ? max(1, $this->attempts()) : 1;
        $schedule = [25, 35, 50, 70, 90, 120, 150, 180, 210, 240];
        $base = $schedule[min($a - 1, count($schedule) - 1)];
        if ($penalize) $base = min(600, (int) round($base * 1.5));
        return $base + random_int(0, 7);
    }

    public function handle(InstagramClient $api): void
    {
        $post = $this->post->fresh();

        $allowed = ['processing','publishing','init'];
        if (!$post || empty($post->publish_id) || !in_array($post->status, $allowed, true)) {
            \Log::info('IG STATUS skip', ['id'=>$post?->id, 'status'=>$post?->status, 'publish_id'=>$post?->publish_id]);
            return;
        }

        $token = InstagramToken::where('user_id', $post->user_id)->first();
        if (!$token) {
            $post->update(['status'=>'failed','error'=>"No InstagramToken for user_id={$post->user_id}"]);
            return;
        }

        try {
            $token = $api->ensureFreshToken($token);

            $status = $api->fetchContainerStatus($post->publish_id, $token->access_token);
            $code   = strtoupper((string)($status['status_code'] ?? $status['status'] ?? ''));
            \Log::info('IG STATUS response', ['id'=>$post->id, 'attempt'=>$this->attempts(), 'code'=>$code, 'resp'=>$status]);

            if ($code === 'FINISHED') {
                try {
                    $api->publishMedia($token->ig_user_id, $token->access_token, $post->publish_id);
                    $post->update(['status'=>'published','error'=>null]);
                    \Log::info('IG PUBLISH done', ['id'=>$post->id, 'creation_id'=>$post->publish_id]);
                    return;
                } catch (\Illuminate\Http\Client\RequestException $e) {
                    \Log::warning('IG PUBLISH http error', [
                        'id'=>$post->id,
                        'code'=>$e->response?->status(),
                        'body'=>$e->response?->json() ?? $e->response?->body(),
                    ]);
                    $this->release($this->nextDelay(true));
                    return;
                }
            }

            if (in_array($code, ['IN_PROGRESS','PROCESSING','PENDING','QUEUED','UPLOADING','READY'], true)) {
                $this->release($this->nextDelay());
                return;
            }

            if (in_array($code, ['ERROR','FAILED'], true)) {
                $post->update(['status'=>'failed','error'=>json_encode($status)]);
                \Log::error('IG STATUS failed', ['id'=>$post->id, 'resp'=>$status]);
                return;
            }

            \Log::warning('IG STATUS unknown', ['id'=>$post->id, 'resp'=>$status]);
            $this->release($this->nextDelay());
            return;

        } catch (\Illuminate\Http\Client\RequestException $e) {
            \Log::error('IG STATUS http error', [
                'id'=>$post->id,
                'code'=>$e->response?->status(),
                'body'=>$e->response?->json() ?? $e->response?->body(),
            ]);
            $this->release($this->nextDelay(true));
            return;

        } catch (\Throwable $e) {
            \Log::error('IG STATUS exception', ['id'=>$post->id, 'msg'=>$e->getMessage()]);
            throw $e;
        }
    }

    public function failed(\Throwable $e): void
    {
        $post = $this->post ?? null;
        $post?->fresh()?->update(['status'=>'failed','error'=>'Polling exceeded retries: '.$e->getMessage()]);
        \Log::critical('IG STATUS failed()', ['id'=>$post?->id, 'attempts'=>$this->attempts(), 'msg'=>$e->getMessage()]);
    }
}
