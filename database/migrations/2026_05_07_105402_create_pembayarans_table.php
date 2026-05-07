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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking')->constrained()->cascadeOnDelete();
            $table->enum('metode_pembayaran',['Bayar di tempat','transfer']);
            $table->string('bukti_pembayaran')->nullable();
            $table->enum('status',[
                'pending',
                'paid',
                'rejected'
            ]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
