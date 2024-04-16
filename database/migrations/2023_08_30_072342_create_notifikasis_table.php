<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotifikasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->integer('klien_id')->nullable();
            $table->integer('receiver_id');
            $table->integer('agenda_id')->nullable()->default(NULL);
            $table->string('kode')->nullable();
            $table->enum('type_notif',['task', 'notif'])->default('task');
            $table->char('no_reg')->nullable();
            $table->string('from')->nullable();
            $table->text('message');
            $table->string('kasus')->nullable();
<<<<<<< HEAD
            $table->text('url')->nullable();
=======
            $table->string('url')->nullable();
>>>>>>> a5b8b868dc63aecbff731d58b225d84c5f17745f
            $table->boolean('read')->default(0);
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
        Schema::dropIfExists('notifikasi');
    }
}
