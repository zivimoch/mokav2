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
            $table->char('nik')->nullable();
            $table->string('nama')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->integer('provinsi_id')->nullable();
            $table->integer('kotkab_id')->nullable();
            $table->integer('kecamatan_id')->nullable();
            $table->string('kelurahan')->nullable();
            $table->longText('alamat')->nullable();
            $table->enum('jenis_kelamin', ['perempuan', 'laki-laki'])->default('perempuan');
            $table->string('agama')->nullable();
            $table->string('suku')->nullable();
            $table->char('no_telp')->nullable();
            $table->string('status_pendidikan')->nullable();
            $table->string('pendidikan')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('status_kawin')->nullable();
            $table->integer('jumlah_anak')->nullable();
            $table->string('hubungan_terlapor')->nullable();
            $table->string('masa_hukuman')->nullable();
            $table->char('denda_hukuman')->nullable();
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
