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
        Schema::create('potongan_belanja_ls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('belanja_ls_id')->nullable();
            $table->unsignedBigInteger('potongan_pfk_id')->nullable();
            $table->decimal('nilai', 17, 4)->nullable();
            $table->string('nomor_billing')->nullable();
            $table->string('nomor_penyetoran')->nullable();
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
        Schema::dropIfExists('potongan_belanja_ls');
    }
};
