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
        Schema::create('refer_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('refer_by_user_id');
            $table->foreign('refer_by_user_id')->references('id')->on('users');
            $table->unsignedBigInteger('referred_user_id');
            $table->foreign('referred_user_id')->references('id')->on('users');
            $table->integer('reward_coin');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refer_histories');
    }
};
