<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKasusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kasus', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('no_reg')->nullable();
            $table->date('tanggal_pelaporan');
            $table->date('tanggal_kejadian');
            $table->string('media_pengaduan');
            $table->string('sumber_rujukan');
            $table->string('sumber_informasi');
            $table->text('deskripsi');
            $table->integer('provinsi_id');
            $table->integer('kotkab_id');
            $table->integer('kecamatan_id');
            $table->string('kelurahan');
            $table->text('alamat');
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
        Schema::dropIfExists('kasus');
    }
}
