<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guard_id')->constrained()->onDelete('cascade')->OnUpdate('cascade');
            $table->date('permission_date');
            $table->string('reason');
            $table->text('information')->nullable();
            // $table->enum('status', ['Menunggu Persetujuan', 'Disetujui', 'Ditolak'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
