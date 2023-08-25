<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersetujuanIsisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persetujuan_isi', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->integer('klien_id');
            $table->integer('persetujuan_template_id');
            $table->char('no_telp')->nullable();
            $table->text('alamat')->nullable();
            $table->text('isi')->nullable();
            $table->text('catatan')->nullable();
            $table->string('tandatangan')->nullable();
            $table->string('nama_penandatangan')->nullable();
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
        Schema::dropIfExists('persetujuan_isi');
    }
}
