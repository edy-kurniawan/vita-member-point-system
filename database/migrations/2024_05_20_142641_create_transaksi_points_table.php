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
        Schema::create('transaksi_point', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('member_id');
            $table->string('transaksi_by');
            $table->date('tanggal_transaksi');
            $table->integer('total_pembelian');
            $table->integer('total_point');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_point');
    }
};
