<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('scheduled_posts', function (Blueprint $t) {
      $t->id();
      $t->foreignId('user_id')->constrained()->cascadeOnDelete();

      $t->string('product')->index();           // e.g., doctor_native, habit_tracker
      $t->string('title')->nullable();          // label for you
      $t->text('caption');                      // up to 2200 chars
      $t->enum('video_source', ['PULL_FROM_URL','FILE_UPLOAD'])->default('PULL_FROM_URL');
      $t->string('video_url')->nullable();      // required if PULL_FROM_URL
      $t->string('file_path')->nullable();      // if FILE_UPLOAD is implemented later
      $t->unsignedBigInteger('cover_ts_ms')->nullable();
      $t->enum('privacy', ['PUBLIC_TO_EVERYONE','FRIENDS','SELF'])->default('PUBLIC_TO_EVERYONE');
      $t->boolean('disable_duet')->default(false);
      $t->boolean('disable_stitch')->default(false);
      $t->boolean('disable_comment')->default(false);
      $t->boolean('brand_organic_toggle')->default(true); // own brand promotion

      $t->timestampTz('publish_at')->index();   // Africa/Casablanca in app config
      $t->enum('status', ['draft','queued','init','publishing','published','failed'])->default('queued');
      $t->string('publish_id')->nullable();     // TikTok publish id
      $t->string('tiktok_post_url')->nullable();
      $t->text('error')->nullable();

      $t->timestamps();
    });
  }
  public function down(): void {
    Schema::dropIfExists('scheduled_posts');
  }
};
