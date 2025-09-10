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
        Schema::create('pelanggans', function (Blueprint $table) {
            $table->id();
            // $table->timestamps();
            $table->unsignedInteger('id_users');
            $table->string('nama_pelanggan', 100);
            $table->string('email_pelanggan')->unique();
            $table->string('no_pelanggan', 20);
            $table->string('kode_pelanggan')->unique();
            $table->text('alamat_pelanggan')->nullable();
            $table->string('foto_pelanggan')->nullable();
            $table->decimal('saldo_pelanggan', 15, 2)->default(0); //$table->decimal('saldo_pelanggan', 15, 2)->default(0); biar bisa input saldo banyak
            $table->integer('poin_pelanggan')->default(0);
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
        Schema::dropIfExists('pelanggans');
    }
};
