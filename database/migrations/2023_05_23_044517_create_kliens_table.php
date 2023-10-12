<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKliensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('klien', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->integer('kasus_id');
            $table->string('no_klien')->nullable();
            $table->string('status');
            // $table->string('kategori_kasus')->nullable();
            // $table->string('tindak_kekerasan')->nullable();
            $table->char('nik')->nullable();
            $table->string('nama');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->integer('provinsi_id');
            $table->integer('kotkab_id');
            $table->integer('kecamatan_id');
            $table->string('kelurahan');
            $table->longText('alamat');
            $table->enum('jenis_kelamin', ['perempuan', 'laki-laki']);
            $table->string('agama')->nullable();
            $table->string('suku')->nullable();
            $table->char('no_telp')->nullable();
            $table->string('status_pendidikan')->nullable();
            $table->string('pendidikan')->nullable();
            $table->string('kelas')->nullable(); //bisa kelas sd smp sma, atau semester kalau kuliah
            $table->string('pekerjaan')->nullable();
            $table->char('penghasilan')->nullable();
            $table->string('status_kawin')->nullable();
            $table->integer('anak_ke')->nullable();
            $table->integer('jumlah_anak')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->string('tempat_lahir_ibu')->nullable();
            $table->date('tanggal_lahir_ibu')->nullable();
            $table->string('nama_ayah')->nullable();
            $table->string('tempat_lahir_ayah')->nullable();
            $table->date('tanggal_lahir_ayah')->nullable();
            $table->string('hubungan_klien');
            $table->char('no_lp')->nullable();
            $table->string('pengadilan_negri')->nullable();
            $table->text('isi_putusan')->nullable();
            $table->boolean('lpsk')->nullable()->default(0);
            // $table->string('tandatangan')->nullable();
            // $table->string('nama_penandatangan')->nullable();
            $table->integer('desil')->nullable();
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
        Schema::dropIfExists('klien');
    }
}
