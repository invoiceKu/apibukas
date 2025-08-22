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
        Schema::create('kota', function (Blueprint $table) {
            $table->string('id');
            $table->string('provinsi_id')->nullable();
            $table->string('name')->nullable();
            $table->string('kota_id_ro')->nullable();
            $table->string('provinsi_id_ro')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('type_ro')->nullable();
            $table->string('kota_nama_ro')->nullable();
            $table->string('provinsi_nama_ro')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kota');
    }
};
