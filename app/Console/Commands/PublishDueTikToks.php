<?php

namespace App\Console\Commands;

use App\Jobs\PublishTikTokJob;
use App\Models\ScheduledPost;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class PublishDueTikToks extends Command
{
    protected $signature = 'tiktok:publish-due {--dry-run}';
    protected $description = 'Dispatch publish jobs for posts whose publish_at is due (status queued/draft)';

    public function handle(): int
    {
        // Prevent overlap if a previous minute is still running
        $lock = Cache::lock('tiktok:publish-due', 55); // seconds
        if (! $lock->get()) {
            $this->warn('Another run is in progress. Skipping.');
            return self::SUCCESS;
        }

        try {
            $now = now();
            $query = ScheduledPost::query()
                ->whereIn('status', ['queued', 'draft'])
                ->where('publish_at', '<=', $now);

            $total = (clone $query)->count();
            $this->info("Found {$total} due posts at {$now->toIso8601String()}");

            $query->orderBy('id')->chunkById(200, function ($posts) {
                foreach ($posts as $post) {
                    $this->line("→ Dispatching #{$post->id} ({$post->product}) {$post->publish_at}");
                    if ($this->option('dry-run')) {
                        continue;
                    }
                    PublishTikTokJob::dispatch($post);
                }
            });

            return self::SUCCESS;
        } finally {
            optional($lock)->release();
        }
    }
}
