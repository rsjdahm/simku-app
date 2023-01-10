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
        Schema::create('rka_pd', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sub_unit_kerja_id')->nullable();
            $table->string('nomor')->nullable();
            $table->text('uraian')->nullable();
            $table->string('status')->nullable();
            $table->date('tanggal')->nullable();
            $table->decimal('pagu_pendapatan', 17, 4)->nullable();
            $table->decimal('pagu_pengeluaran', 17, 4)->nullable();
            $table->decimal('pagu_pembiayaan', 17, 4)->nullable();
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
        Schema::dropIfExists('rka_pd');
    }
};
