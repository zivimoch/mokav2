<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDokumensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dokumen', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->integer('template_id');
            $table->string('judul');
            $table->text('konten');
            $table->string('nama_template');
            $table->string('pemilik_template');
            $table->string('created_by_template');
            $table->dateTime('created_at_template');
            $table->dateTime('updated_at_template')->nullable();
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
        Schema::dropIfExists('dokumen');
    }
}
