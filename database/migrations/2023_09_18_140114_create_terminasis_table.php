<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTerminasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('terminasi', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->integer('klien_id');
            $table->enum('jenis_terminasi', ['selesai', 'ditutup']);
            $table->text('alasan')->nullable();
            $table->integer('validated_by')->nullable();
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
        Schema::dropIfExists('terminasi');
    }
}
