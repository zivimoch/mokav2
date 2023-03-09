<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTindakLanjutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tindak_lanjut', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->integer('agenda_id');
            $table->date('tanggal_selesai'); 
            $table->time('jam_selesai'); 
            $table->string('lokasi'); 
            $table->longText('catatan'); 
            $table->integer('created_by'); //pembuat
            $table->integer('validated_by'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tindak_lanjut');
    }
}
