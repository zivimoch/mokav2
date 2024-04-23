<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatatanHukumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catatan_hukum', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->integer('klien_id');
            $table->char('no_lp')->nullable();
            $table->string('pengadilan_negeri')->nullable();
            $table->text('isi_putusan')->nullable();
            $table->boolean('lpsk')->nullable()->default(0);
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
        Schema::dropIfExists('catatan_hukum');
    }
}
