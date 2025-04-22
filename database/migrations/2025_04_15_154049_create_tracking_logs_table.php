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
        Schema::create('tracking_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('guard_id'); // ganti dari user_id
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->timestamp('recorded_at');
            $table->timestamps();

            // relasi ke tabel guards
            $table->foreign('guard_id')->references('id')->on('guards')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracking_logs');
    }
};
