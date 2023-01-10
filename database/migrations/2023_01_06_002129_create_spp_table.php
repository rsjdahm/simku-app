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
        Schema::create('spp', function (Blueprint $table) {
            $table->id();
            $table->string('jenis')->nullable();
            $table->unsignedBigInteger('pengajuan_up_id')->nullable();
            $table->unsignedBigInteger('spj_gu_id')->nullable();
            $table->unsignedBigInteger('belanja_ls_id')->nullable();
            $table->string('nomor')->nullable();
            $table->date('tanggal')->nullable();
            $table->text('uraian')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('spp');
    }
};
