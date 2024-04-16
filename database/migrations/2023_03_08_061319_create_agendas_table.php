<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agenda', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('klien_id')->nullable();
<<<<<<< HEAD
            $table->text('judul_kegiatan');
=======
            $table->string('judul_kegiatan');
>>>>>>> a5b8b868dc63aecbff731d58b225d84c5f17745f
            $table->date('tanggal_mulai');
            $table->time('jam_mulai');
            $table->longText('keterangan')->nullable();
            $table->integer('created_by'); 
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
        Schema::dropIfExists('agenda');
    }
}
