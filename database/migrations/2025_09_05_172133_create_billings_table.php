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
        Schema::create('billings', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('id_users');
            $table->timestamp('waktu_awal')->nullable();
            $table->timestamp('waktu_akhir')->nullable();
            $table->double('storage_size');
            $table->integer('total_staff');
            $table->integer('pro');
            $table->integer('desktop');
            $table->double('jumlah_bulan');
            $table->double('total');
            $table->integer('tipe');
            $table->integer('status');
            $table->string('detail');
            $table->string('invoice');
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
        Schema::dropIfExists('billings');
    }
};
