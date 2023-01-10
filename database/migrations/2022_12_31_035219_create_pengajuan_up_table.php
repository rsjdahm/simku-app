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
        Schema::create('pengajuan_up', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sub_unit_kerja_id')->nullable();
            $table->unsignedBigInteger('rek_sub_rincian_objek_id')->nullable();
            $table->string('nomor')->nullable();
            $table->date('tanggal')->nullable();
            $table->text('uraian')->nullable();
            $table->decimal('nilai', 17, 4)->nullable();
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
        Schema::dropIfExists('pengajuan_up');
    }
};
