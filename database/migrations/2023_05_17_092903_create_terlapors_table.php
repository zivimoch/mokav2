<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTerlaporsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('terlapor', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->integer('kasus_id');
            $table->string('nama');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->integer('provinsi_id');
            $table->integer('kotkab_id');
            $table->integer('kecamatan_id');
            $table->string('kelurahan');
            $table->longText('alamat');
            $table->enum('jenis_kelamin', ['perempuan', 'laki-laki']);
            $table->string('agama')->nullable();
            $table->string('suku')->nullable();
            $table->char('no_telp')->nullable();
            $table->string('status_pendidikan')->nullable();
            $table->string('pendidikan')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('status_kawin')->nullable();
            $table->integer('jumlah_anak')->nullable();
            $table->string('hubungan_terlapor');
            $table->string('file_ttd')->nullable();
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
        Schema::dropIfExists('terlapor');
    }
}
