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
            $table->date('tanggal_selesai')->nullable(); 
            $table->time('jam_selesai')->nullable(); 
            $table->string('lokasi')->nullable(); 
            $table->longText('catatan')->nullable(); 
            $table->integer('created_by'); //pembuat
            $table->integer('validated_by')->nullable(); 
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
        Schema::dropIfExists('tindak_lanjut');
    }
}
