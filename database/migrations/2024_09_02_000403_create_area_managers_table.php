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
        Schema::create('area_managers', function (Blueprint $table) {
            $table->id();
            $table->string('fullName');
            $table->integer('assignedPincode');
            $table->string('phoneNumber', 10)->unique();
            $table->decimal('availableBalance', 10, 2)->default(0);
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('area_managers');
    }
};
