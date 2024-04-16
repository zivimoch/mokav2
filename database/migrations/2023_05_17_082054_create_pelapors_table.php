<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePelaporsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pelapor', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->integer('kasus_id');
            $table->char('nik')->nullable();
<<<<<<< HEAD
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
=======
            $table->string('nama');
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->integer('provinsi_id')->nullable();
            $table->integer('kotkab_id')->nullable();
            $table->integer('kecamatan_id')->nullable();
            $table->string('kelurahan')->nullable();
            $table->text('alamat')->nullable();
            $table->char('no_telp')->nullable();
            $table->string('hubungan_pelapor')->nullable();
>>>>>>> a5b8b868dc63aecbff731d58b225d84c5f17745f
            $table->integer('desil')->nullable();
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
        Schema::dropIfExists('pelapor');
    }
}
