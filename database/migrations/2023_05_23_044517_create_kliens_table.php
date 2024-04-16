<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKliensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('klien', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->integer('kasus_id');
            $table->date('tanggal_approve')->nullable()->comment('Digunakan untuk filter grouping kasus by tanggal approve');
            $table->integer('urutan')->nullable(); // ini bisa dihapus kalau tidak ada masalah no urut klien lagi
            $table->string('no_klien')->nullable();
            $table->string('status');
            $table->char('nik')->nullable();
            $table->string('nama')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['perempuan', 'laki-laki'])->default('perempuan');
            $table->char('provinsi_id_ktp')->nullable();
            $table->char('kotkab_id_ktp')->nullable();
            $table->char('kecamatan_id_ktp')->nullable();
            $table->char('kelurahan_id_ktp')->nullable();
            $table->longText('alamat_ktp')->nullable();
            $table->char('provinsi_id')->nullable(); // domisili
            $table->char('kotkab_id')->nullable(); // domisili
            $table->char('kecamatan_id')->nullable(); // domilisi
            $table->char('kelurahan_id')->nullable(); // domisili
            $table->longText('alamat')->nullable(); // domisili
            $table->string('agama')->nullable();
            $table->string('status_kawin')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('kewarganegaraan')->nullable();
            $table->string('status_pendidikan')->nullable();
            $table->string('pendidikan')->nullable();
            $table->char('no_telp')->nullable();
            $table->string('kedisabilitasan')->default('Non Disabilitas');
            $table->string('hubungan_pelapor'); // hubungan klien dengan pelapor
            $table->integer('desil')->nullable();
            $table->boolean('arsip')->nullable()->default(0);
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
        Schema::dropIfExists('klien');
    }
}
