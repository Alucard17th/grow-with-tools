<?php

namespace App\Console\Commands;

use App\Jobs\PublishInstagramJob;
use App\Models\ScheduledPost;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class PublishDueInstagrams extends Command
{
    // Add an optional --dry-run like your TikTok command,
    // plus an optional --platform to override the default.
    protected $signature = 'instagram:publish-due {--dry-run} {--platform=instagram}';
    protected $description = 'Dispatch publish jobs for Instagram posts whose publish_at is due (status queued/draft)';

    public function handle(): int
    {
        // Prevent overlapping runs (1-minute window)
        $lock = Cache::lock('instagram:publish-due', 55);
        if (!$lock->get()) {
            $this->warn('Another run is in progress. Skipping.');
            return self::SUCCESS;
        }

        try {
            $now      = now();
            // $platform = $this->option('platform');
            $platform = 'instagram';

            $query = ScheduledPost::query()
                ->whereIn('status', ['queued', 'draft'])
                ->where('publish_at', '<=', $now);

            // If your table has a 'platform' or 'network' column, filter for Instagram.
            if (Schema::hasColumn('scheduled_posts', 'platform')) {
                $query->where('platform', $platform);
            } elseif (Schema::hasColumn('scheduled_posts', 'network')) {
                $query->where('network', $platform);
            } elseif (Schema::hasColumn('scheduled_posts', 'provider')) {
                $query->where('provider', $platform);
            }
            // Otherwise, remove these 3 lines and filter however you tag IG posts.

            $total = (clone $query)->count();
            $this->info("Found {$total} due IG posts at {$now->toIso8601String()}");

            $query->orderBy('id')->chunkById(200, function ($posts) {
                foreach ($posts as $post) {
                    $label = trim(($post->product ?? '') . ' ' . ($post->caption ? '(' . mb_strimwidth($post->caption, 0, 40, '…') . ')' : ''));
                    $this->line("→ Dispatching #{$post->id} {$label} {$post->publish_at}");

                    if ($this->option('dry-run')) {
                        continue;
                    }

                    PublishInstagramJob::dispatch($post);
                }
            });

            return self::SUCCESS;
        } finally {
            optional($lock)->release();
        }
    }
}