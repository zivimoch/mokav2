<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRKategoriJenisBentuksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('r_kategori_jenis_bentuk', function (Blueprint $table) {
            $table->id();
            $table->integer('kategori_kasus_kode');
            $table->integer('jenis_kekerasan_kode');
            $table->integer('bentuk_kekerasan_kode');
            $table->integer('created_by')->nullable();
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
        Schema::dropIfExists('r_kategori_jenis_bentuk');
    }
}
