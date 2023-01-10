<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rek_kelompok', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rek_akun_id')->nullable();
            $table->unsignedBigInteger('kode')->nullable();
            $table->string('nama')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rek_kelompok');
    }
};
