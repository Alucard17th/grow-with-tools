<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('tik_tok_tokens', function (Blueprint $t) {
      $t->id();
      $t->foreignId('user_id')->constrained()->cascadeOnDelete();
      $t->string('open_id')->nullable();
      $t->text('access_token');     // encrypted cast
      $t->text('refresh_token');    // encrypted cast
      $t->timestamp('expires_at');
      $t->string('scope')->nullable();
      $t->timestamps();
    });
  }
  public function down(): void {
    Schema::dropIfExists('tik_tok_tokens');
  }
};
