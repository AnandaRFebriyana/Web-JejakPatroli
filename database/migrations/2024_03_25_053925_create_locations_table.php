<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->decimal('latitude', 10, 8); // Kolom untuk menyimpan latitude
            $table->decimal('longitude', 11, 8); // Kolom untuk menyimpan longitude
            $table->foreignId('shift_id') // Kolom foreign key
                  ->constrained('shifts') // Mengacu ke tabel shifts
                  ->onDelete('cascade'); // Hapus data jika parent dihapus
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations'); // Hapus tabel locations
    }
};