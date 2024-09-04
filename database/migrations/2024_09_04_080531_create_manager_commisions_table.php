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
        Schema::create('manager_commisions', function (Blueprint $table) {
            $table->id();
            $table->string('mid')->nullable();
            $table->string('user_id');
            $table->integer('coins')->default(0);
            $table->string('fromPincode');
            $table->enum('claimed',['yes','no'])->default('no');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manager_commisions');
    }
};
