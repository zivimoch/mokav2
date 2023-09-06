<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsesmensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asesmen', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->integer('klien_id')->nullable();
            $table->string('fisik')->nullable();
            $table->string('sosial')->nullable();
            $table->string('psikologis')->nullable();
            $table->string('hukum')->nullable();
            $table->string('lainnya')->nullable();
            $table->string('upaya')->nullable();
            $table->string('pendukung')->nullable();
            $table->string('hambatan')->nullable();
            $table->string('harapan')->nullable();
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
        Schema::dropIfExists('asesmen');
    }
}
