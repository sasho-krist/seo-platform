<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('keyword_suggestions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('blog_post_id')->nullable()->constrained()->nullOnDelete();
            $table->string('seed_topic')->nullable();
            $table->json('keywords');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keyword_suggestions');
    }
};
