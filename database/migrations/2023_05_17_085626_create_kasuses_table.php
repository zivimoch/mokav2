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
            $table->string('sumber_rujukan')->nullable();
            $table->string('media_pengaduan');
            $table->string('sumber_informasi')->nullable();
            $table->date('tanggal_pelaporan');
            $table->date('tanggal_kejadian')->nullable();
            $table->boolean('perkiraan_tanggal_kejadian')->nullable()->default(0);
            $table->string('kategori_lokasi')->nullable();
            $table->text('ringkasan');
            $table->char('provinsi_id')->nullable();
            $table->char('kotkab_id')->nullable();
            $table->char('kecamatan_id')->nullable();
            $table->char('kelurahan_id')->nullable();
            $table->text('alamat')->nullable();
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
