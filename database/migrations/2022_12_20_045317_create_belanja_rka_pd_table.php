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
        Schema::create('belanja_rka_pd', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rka_pd_id')->nullable();
            $table->unsignedBigInteger('sub_kegiatan_id')->nullable();
            $table->unsignedBigInteger('rek_sub_rincian_objek_id')->nullable();
            $table->text('uraian')->nullable();
            $table->decimal('harga_satuan', 17, 4)->nullable();
            $table->decimal('volume', 17, 4)->nullable();
            $table->string('satuan')->nullable();
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
        Schema::dropIfExists('belanja_rka_pd');
    }
};
