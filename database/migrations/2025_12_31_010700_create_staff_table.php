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
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('id_users');
            $table->string('username');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamp('expired_user')->nullable();
            $table->string('api_token')->nullable();
            $table->string('no_hp');
            $table->string('alamat');
            $table->string('foto_profil')->nullable();
            $table->integer('nomor_struk')->nullable();
            $table->string('versi');
            $table->string('device_name');
            $table->string('device_type');
            $table->string('os_version');
            $table->foreign('id_users')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};