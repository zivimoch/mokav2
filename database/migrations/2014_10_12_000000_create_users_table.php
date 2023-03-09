<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('name');
            $table->integer('kotkab_id');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->enum('jabatan', ['Penerima Pengaduan', 'Manajer Kasus', 'Pendamping Kasus', 'Psikolog', 'Konselor', 'Advokat', 'Paralegal', 'Unit Reaksi Cepat', 'Supervisor Kasus', 'Tenaga Ahli', 'Tim Data', 'Sekretariat', 'Kepala Instansi']);
            $table->integer('supervisor_layanan')->default(0);
            $table->integer('supervisor_id')->default(0);
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
