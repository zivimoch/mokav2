<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMKategoriKasusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_kategori_kasus', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->integer('kode');
            $table->string('nama');
            $table->enum('usia', ['anak', 'dewasa', 'semua'])->nullable()->default('semua');
            $table->enum('jenis_kelamin',['perempuan', 'laki-laki', 'semua'])->default('semua');
            $table->text('terlapor')->nullable()->default(null);
            $table->text('lokasi')->nullable()->default(null);
            $table->text('definisi')->nullable()->default(null);
            $table->text('dasar_hukum')->nullable()->default(null);
            $table->integer('created_by')->nullable()->default(null);
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
        Schema::dropIfExists('m_kategori_kasus');
    }
}
