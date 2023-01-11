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
        Schema::create('sp2d', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('spm_id')->nullable();
            $table->string('nomor')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('status')->nullable();
            $table->string('nomor_cek')->nullable();
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
        Schema::dropIfExists('sp2d');
    }
};
