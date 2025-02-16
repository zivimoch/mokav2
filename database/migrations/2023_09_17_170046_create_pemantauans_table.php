<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePemantauansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemantauan', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->integer('klien_id')->nullable();
            $table->integer('intervensi_ke')->nullable()->default(1);
            $table->text('kemajuan')->nullable();
            $table->text('tujuan')->nullable();
            $table->text('rencana')->nullable();
            $table->string('action_pemantauan')->nullable();
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
        Schema::dropIfExists('pemantauan');
    }
}
