<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDifabelTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
<<<<<<< HEAD
        Schema::create('t_tipe_disabilitas', function (Blueprint $table) {
=======
        Schema::create('difabel_type', function (Blueprint $table) {
>>>>>>> a5b8b868dc63aecbff731d58b225d84c5f17745f
            $table->id();
            $table->integer('klien_id');
            $table->string('value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
<<<<<<< HEAD
        Schema::dropIfExists('t_tipe_disabilitas');
=======
        Schema::dropIfExists('difabel_type');
>>>>>>> a5b8b868dc63aecbff731d58b225d84c5f17745f
    }
}
