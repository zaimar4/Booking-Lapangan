<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('lapangans')) {
            Schema::create('lapangans', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('nama_lapangan');
                $table->foreignId('jenis_lapangan')
                    ->constrained('jenis_lapangans')
                        ->cascadeOnDelete();
                    $table->string('gambar_lapangan')->nullable();
                    $table->text('deskripsi_lapangan')->nullable();
                    $table->integer('harga_sewa');
                    $table->enum('status', ['Tersedia', 'Penuh'])->default('Tersedia');
                    $table->time('jam_buka');
                    $table->time('jam_tutup');
                });
            
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lapangans');
    }
};
