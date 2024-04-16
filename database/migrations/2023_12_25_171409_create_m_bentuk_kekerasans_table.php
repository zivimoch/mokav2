<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMBentukKekerasansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_bentuk_kekerasan', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->integer('kode');
            $table->integer('jenis_kekerasan_kode');
            $table->string('nama');
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
        Schema::dropIfExists('m_bentuk_kekerasan');
    }
}
