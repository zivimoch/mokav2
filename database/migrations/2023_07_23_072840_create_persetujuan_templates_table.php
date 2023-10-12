<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersetujuanTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persetujuan_template', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->enum('kategori', ['persetujuan data', 'persetujuan pelayanan', 'persetujuan terminasi']);
            $table->string('judul');
            $table->text('konten')->nullable();
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
        Schema::dropIfExists('persetujuan_template');
    }
}
