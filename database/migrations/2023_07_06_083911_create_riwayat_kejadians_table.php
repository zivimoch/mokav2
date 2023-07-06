<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiwayatKejadiansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('riwayat_kejadian', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->integer('klien_id');
            $table->date('tanggal')->nullable();
            $table->time('jam')->nullable();
            $table->string('keterangan');
            $table->integer('created_by');
            $table->timestamps();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('riwayat_kejadian');
    }
}
