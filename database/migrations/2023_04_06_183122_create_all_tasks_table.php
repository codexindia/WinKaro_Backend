<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('all_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('task_name');
            $table->string('title');
            $table->string('thumbnail_image')->nullable();
            $table->string('action_url');
            $table->string('publisher')->nullable();
            $table->integer('reward_coin');
           // $table->json('questions')->nullable();
            $table->string('status');
            $table->timestamp('expire_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('all_tasks');
    }
};
