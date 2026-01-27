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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('id_users');
            $table->string('company_logo')->nullable();
            $table->string('company_name', 30);
            $table->string('company_address', 80)->nullable();
            $table->string('company_owners', 30);
            $table->string('company_telp', 15);
            $table->string('motto', 125)->nullable();
            $table->string('sub_business')->nullable();
            $table->string('currency')->nullable();
            $table->string('currency_code')->nullable();
            $table->string('currency_country')->nullable();
            $table->string('stok_mode')->nullable();
            $table->string('negara')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kota')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->integer('staff')->nullable();
            $table->timestamps();

            $table->foreign('id_users')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
