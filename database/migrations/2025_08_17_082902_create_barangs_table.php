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
        Schema::create('barangs', function (Blueprint $table) {
        $table->id();
        $table->unsignedInteger('id_users');
        $table->string('foto_barang')->nullable();
        $table->string('nama_barang')->nullable();
        $table->string('kode_barang')->unique();
        $table->enum('tipe_barang', ['default', 'addon']);
        $table->boolean('tipe_stok');
        $table->double('stok')->default(0);
        $table->decimal('harga_dasar', 15, 2)->default(0);
        $table->decimal('harga_jual', 15, 2)->default(0);
        $table->string('nama_kategori')->nullable();
        $table->boolean('tipe_diskon');
        $table->decimal('nilai_diskon', 15, 2)->default(0);
        $table->string('berat')->nullable();
        $table->string('satuan')->nullable();
        $table->boolean('tampil_transaksi');
        $table->timestamp('created_at')->nullable();
        $table->timestamp('updated_at')->nullable();
        $table->foreign('id_users')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
