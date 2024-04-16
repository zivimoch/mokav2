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
            $table->text('fisik')->nullable();
            $table->text('psikologis')->nullable();
            $table->text('sosial')->nullable();
            $table->text('hukum')->nullable();
            $table->text('upaya')->nullable();
            $table->text('pendukung')->nullable();
            $table->text('hambatan')->nullable();
            $table->text('harapan')->nullable();
            $table->text('lainnya')->nullable();
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
