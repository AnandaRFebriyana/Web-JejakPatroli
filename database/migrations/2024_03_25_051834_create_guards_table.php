<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('guards', function (Blueprint $table) {
            $table->id();
            // $table->string('nik', 16)->unique();
            $table->string('name', 100);
            $table->date('birth_date')->nullable();
            $table->string('email', 50)->unique();
            $table->string('password', 100)->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->string('address')->nullable();
            $table->text('photo')->nullable();
            $table->string('token', 100)->unique()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('guards');
    }
};
