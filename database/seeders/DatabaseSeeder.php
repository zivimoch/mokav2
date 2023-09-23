<?php

namespace Database\Seeders;

use App\Models\Agenda;
use App\Models\Asesmen;
use App\Models\DifabelType;
use App\Models\Dokumen;
use App\Models\DokumenKeyword;
use App\Models\DokumenTl;
use App\Models\Kasus;
use App\Models\KategoriKasus;
use App\Models\Klien;
use App\Models\KondisiKhusus;
use App\Models\Layanan;
use App\Models\LogActivity;
use App\Models\Notifikasi;
use App\Models\Pasal;
use App\Models\Pelapor;
use App\Models\PersetujuanIsi;
use App\Models\PersetujuanItem;
use App\Models\PersetujuanTemplate;
use App\Models\Petugas;
use App\Models\ProgramPemerintah;
use App\Models\RiwayatKejadian;
use App\Models\Template;
use App\Models\template_keyword;
use App\Models\TemplateKeyword;
use App\Models\Terlapor;
use App\Models\TindakKekerasan;
use App\Models\TindakLanjut;
use App\Models\User;
use Illuminate\Database\Seeder;
use Laravolt\Indonesia\Seeds\CitiesSeeder;
use Laravolt\Indonesia\Seeds\VillagesSeeder;
use Laravolt\Indonesia\Seeds\DistrictsSeeder;
use Laravolt\Indonesia\Seeds\ProvincesSeeder;
use Carbon\Carbon;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ProvincesSeeder::class,
            CitiesSeeder::class,
            DistrictsSeeder::class,
            VillagesSeeder::class,
        ]);
        // \App\Models\User::factory(12)->create();
        //data user
        $users = [
            [
                "uuid" => "43a348be-9f12-42f5-b567-f095fc5c11cd",
                "name" => "Petugas Penerima Pengaduan",
                "kotkab_id" => 4,
                "email" => 'penerima@moka.ol',
                "email_verified_at" => '2023-03-08 03:28:35',
                "jabatan" => 'Penerima Pengaduan',
                // "supervisor_layanan" => 0,
                "supervisor_id" => 0,
                "password" => '$2y$10$9BcBcEWaVUmAOrl2zZkaKeYRZaajkbtNFlAcpNTwkXDab9e00kqlq'
            ],[
                "uuid" => "43a348be-9f12-42f5-b567-f095f25111cd",
                "name" => "Manajer Kasus",
                "kotkab_id" => 4,
                "email" => "mk@moka.ol",
                "email_verified_at" => '2023-03-08 03:28:35',
                "jabatan" => 'Manajer Kasus',
                // "supervisor_layanan" => 0,
                "supervisor_id" => 9,
                "password" => '$2y$10$9BcBcEWaVUmAOrl2zZkaKeYRZaajkbtNFlAcpNTwkXDab9e00kqlq'
            ],[
                "uuid" => "43a348be-9f12-42f5-b567-f09tfc5111cd",
                "name" => "Pendamping Kasus",
                "kotkab_id" => 4,
                "email" => "pk@moka.ol",
                "email_verified_at" => '2023-03-08 03:28:35',
                "jabatan" => 'Pendamping Kasus',
                // "supervisor_layanan" => 0,
                "supervisor_id" => 9,
                "password" => '$2y$10$9BcBcEWaVUmAOrl2zZkaKeYRZaajkbtNFlAcpNTwkXDab9e00kqlq'
            ],[
                "uuid" => "43a348be-9f12-42f5-b567-f0952c5111cd",
                "name" => "Psikolog",
                "kotkab_id" => 4,
                "email" => "psikolog@moka.ol",
                "email_verified_at" => '2023-03-08 03:28:35',
                "jabatan" => 'Psikolog',
                // "supervisor_layanan" => 0,
                "supervisor_id" => 13,
                "password" => '$2y$10$9BcBcEWaVUmAOrl2zZkaKeYRZaajkbtNFlAcpNTwkXDab9e00kqlq'
            ],[
                "uuid" => "43a348be-9112-42f5-b567-f095fo5111cd",
                "name" => "Advokat",
                "kotkab_id" => 4,
                "email" => "advokat@moka.ol",
                "email_verified_at" => '2023-03-08 03:28:35',
                "jabatan" => 'Advokat',
                // "supervisor_layanan" => 0,
                "supervisor_id" => 12,
                "password" => '$2y$10$9BcBcEWaVUmAOrl2zZkaKeYRZaajkbtNFlAcpNTwkXDab9e00kqlq'
            ],[
                "uuid" => "43a348be-9112-42f5-b567-f095fc5111cd",
                "name" => "Paralegal",
                "kotkab_id" => 4,
                "email" => "paralegal@moka.ol",
                "email_verified_at" => '2023-03-08 03:28:35',
                "jabatan" => 'Paralegal',
                // "supervisor_layanan" => 0,
                "supervisor_id" => 12,
                "password" => '$2y$10$9BcBcEWaVUmAOrl2zZkaKeYRZaajkbtNFlAcpNTwkXDab9e00kqlq'
            ],[
                "uuid" => "43a348be-9112-42f5-b567-f095fc5112cd",
                "name" => "Unit Reaksi Cepat",
                "kotkab_id" => 4,
                "email" => "urc@moka.ol",
                "email_verified_at" => '2023-03-08 03:28:35',
                "jabatan" => 'Unit Reaksi Cepat',
                // "supervisor_layanan" => 0,
                "supervisor_id" => 12,
                "password" => '$2y$10$9BcBcEWaVUmAOrl2zZkaKeYRZaajkbtNFlAcpNTwkXDab9e00kqlq'
            ],[
                "uuid" => "43a348be-9112-42f5-b567-f095fc5011cd",
                "name" => "Supervisor Kasus",
                "kotkab_id" => 4,
                "email" => "spv@moka.ol",
                "email_verified_at" => '2023-03-08 03:28:35',
                "jabatan" => 'Supervisor Kasus',
                // "supervisor_layanan" => 0,
                "supervisor_id" => 0,
                "password" => '$2y$10$9BcBcEWaVUmAOrl2zZkaKeYRZaajkbtNFlAcpNTwkXDab9e00kqlq'
            ],[
                "uuid" => "43a348be-9112-42f5-b767-f095fc5111cd",
                "name" => "Tenaga Ahli",
                "kotkab_id" => 4,
                "email" => "ta@moka.ol",
                "email_verified_at" => '2023-03-08 03:28:35',
                "jabatan" => 'Tenaga Ahli',
                // "supervisor_layanan" => 1,
                "supervisor_id" => 0,
                "password" => '$2y$10$9BcBcEWaVUmAOrl2zZkaKeYRZaajkbtNFlAcpNTwkXDab9e00kqlq'
            ],[
                "uuid" => "43a348be-9112-42f5-b537-f095fc5111cd",
                "name" => "Tim Data",
                "kotkab_id" => 4,
                "email" => "timdata@moka.ol",
                "email_verified_at" => '2023-03-08 03:28:35',
                "jabatan" => 'Tim Data',
                // "supervisor_layanan" => 0,
                "supervisor_id" => 0,
                "password" => '$2y$10$9BcBcEWaVUmAOrl2zZkaKeYRZaajkbtNFlAcpNTwkXDab9e00kqlq'
            ],[
                "uuid" => "43a348be-9112-42fs-b567-f095fc5111cd",
                "name" => "Kepala Instansi",
                "kotkab_id" => 4,
                "email" => "kepala@moka.ol",
                "email_verified_at" => '2023-03-08 03:28:35',
                "jabatan" => 'Kepala Instansi',
                // "supervisor_layanan" => 0,
                "supervisor_id" => 0,
                "password" => '$2y$10$9BcBcEWaVUmAOrl2zZkaKeYRZaajkbtNFlAcpNTwkXDab9e00kqlq'
            ],[
                "uuid" => "43a348be-9112-42f5-b567-f095fo5111td",
                "name" => "Advokat Sebagai SPV",
                "kotkab_id" => 4,
                "email" => "advokat.spv@moka.ol",
                "email_verified_at" => '2023-03-08 03:28:35',
                "jabatan" => 'Advokat',
                // "supervisor_layanan" => 1,
                "supervisor_id" => 9,
                "password" => '$2y$10$9BcBcEWaVUmAOrl2zZkaKeYRZaajkbtNFlAcpNTwkXDab9e00kqlq'
            ],[
                "uuid" => "43a348be-9f12-42f5-b567-f0952a5111cd",
                "name" => "Psikolog Sebagai SPV",
                "kotkab_id" => 4,
                "email" => "psikolog.spv@moka.ol",
                "email_verified_at" => '2023-03-08 03:28:35',
                "jabatan" => 'Psikolog',
                // "supervisor_layanan" => 1,
                "supervisor_id" => 9,
                "password" => '$2y$10$9BcBcEWaVUmAOrl2zZkaKeYRZaajkbtNFlAcpNTwkXDab9e00kqlq'
            ],[
                "uuid" => "43a348be-9f12-42f5-b567-f09e2c5111cd",
                "name" => "Konselor",
                "kotkab_id" => 4,
                "email" => "konselor@moka.ol",
                "email_verified_at" => '2023-03-08 03:28:35',
                "jabatan" => 'Konselor',
                // "supervisor_layanan" => 0,
                "supervisor_id" => 13,
                "password" => '$2y$10$9BcBcEWaVUmAOrl2zZkaKeYRZaajkbtNFlAcpNTwkXDab9e00kqlq'
            ],[
                "uuid" => "43a348be-9f12-42f5-b567-f09s2c5111cd",
                "name" => "Sekretariat",
                "kotkab_id" => 4,
                "email" => "sekretariat@moka.ol",
                "email_verified_at" => '2023-03-08 03:28:35',
                "jabatan" => 'Sekretariat',
                // "supervisor_layanan" => 0,
                "supervisor_id" => 13,
                "password" => '$2y$10$9BcBcEWaVUmAOrl2zZkaKeYRZaajkbtNFlAcpNTwkXDab9e00kqlq'
        ]
        ];
        User::insert($users);

        //data kasus
        $kasus = [
            [
                "uuid" => "35db5be8-551a-4a8f-91d1-e8ea39295515",
                "no_reg" => NULL,
                "tanggal_pelaporan" => '2023-05-16',
                "tanggal_kejadian" => '2023-05-13',
                "tempat_kejadian" => 'Hotel',
                "media_pengaduan" => 'Hotline',
                "sumber_rujukan" => NULL,
                "sumber_informasi" => 'Dinas PPAPP DKI Jakarta',
                "deskripsi" => '- Menurut keterangan Heri (kakak ipar korban) bahwa pada rabu, 04 januari 2023, sekitar 19.00 WIB, awal mula kejadian, pacar korban menjemput korban ditempat kerja kemudian korban dan pacarnya mampir diwarung milik adek korban di Jembatan jelambar aladin RT. 04 RW 06, Kel. Penjagalan, Kec. Penjaringan, Jakarta Utara. Menurut keterangan Heri (kakak ipar korban) bahwa saat korban dan pacarnya duduk bersama di warung milik Adek korban (Probo Sutejo), kemudian terlapor datang dan langsung menyiram bensin kearah korban dan pacarnya kemudian menyalakan api menggunakan korek gas sehingga menyebabkan kebakar korban dan pacarnya. Ketika dibakar korban menceburkan/kecebur ke kali dan teman laki lakinya /pacar hanyut sementara korban /dewi tidak karena kecebur kali yang ada dangkal airnya... Korban Dewi dapat tertolong sementara teman laki lakinya meninggal.',
                "provinsi_id" => 31,
                "kotkab_id" => 3172,
                "kecamatan_id" => 317201,
                "kelurahan" => 'Pejagalan',
                "alamat" => 'Jembatan jelambar aladin RT/01/06 Kel; Pejagalan,Kec; penjaringan jakarta utara',
                "created_by" => NULL,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5),
                "deleted_at" => NULL
            ],
            [
                "uuid" => "3ae38e2b-f482-45f5-93d1-f50b20bc672a",
                "no_reg" => NULL,
                "tanggal_pelaporan" => '2023-08-31',
                "tanggal_kejadian" => '2023-08-31',
                "tempat_kejadian" => 'Apartemen',
                "media_pengaduan" => 'Hotline',
                "sumber_rujukan" => NULL,
                "sumber_informasi" => 'Komnas HAM',
                "deskripsi" => 'KASUS 2 : - Menurut keterangan Heri (kakak ipar korban) bahwa pada rabu, 04 januari 2023, sekitar 19.00 WIB, awal mula kejadian, pacar korban menjemput korban ditempat kerja kemudian korban dan pacarnya mampir diwarung milik adek korban di Jembatan jelambar aladin RT. 04 RW 06, Kel. Penjagalan, Kec. Penjaringan, Jakarta Utara. Menurut keterangan Heri (kakak ipar korban) bahwa saat korban dan pacarnya duduk bersama di warung milik Adek korban (Probo Sutejo), kemudian terlapor datang dan langsung menyiram bensin kearah korban dan pacarnya kemudian menyalakan api menggunakan korek gas sehingga menyebabkan kebakar korban dan pacarnya. Ketika dibakar korban menceburkan/kecebur ke kali dan teman laki lakinya /pacar hanyut sementara korban /dewi tidak karena kecebur kali yang ada dangkal airnya... Korban Dewi dapat tertolong sementara teman laki lakinya meninggal.',
                "provinsi_id" => 14,
                "kotkab_id" => 1403,
                "kecamatan_id" => 140302,
                "kelurahan" => 'Banten',
                "alamat" => 'jalan yang lurus',
                "created_by" => NULL,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->subDays(5),
                "deleted_at" => NULL
            ],
            [
                "uuid" => "2afa1f5d-fbf3-4997-b10d-4d2682238b7d",
                "no_reg" => NULL,
                "tanggal_pelaporan" => '2023-08-31',
                "tanggal_kejadian" => '2023-08-09',
                "tempat_kejadian" => 'Apartemen',
                "media_pengaduan" => 'Pos Pengaduan RPTRA',
                "sumber_rujukan" => NULL,
                "sumber_informasi" => 'Komnas HAM',
                "deskripsi" => 'KASUS 3 : - Menurut keterangan Heri (kakak ipar korban) bahwa pada rabu, 04 januari 2023, sekitar 19.00 WIB, awal mula kejadian, pacar korban menjemput korban ditempat kerja kemudian korban dan pacarnya mampir diwarung milik adek korban di Jembatan jelambar aladin RT. 04 RW 06, Kel. Penjagalan, Kec. Penjaringan, Jakarta Utara. Menurut keterangan Heri (kakak ipar korban) bahwa saat korban dan pacarnya duduk bersama di warung milik Adek korban (Probo Sutejo), kemudian terlapor datang dan langsung menyiram bensin kearah korban dan pacarnya kemudian menyalakan api menggunakan korek gas sehingga menyebabkan kebakar korban dan pacarnya. Ketika dibakar korban menceburkan/kecebur ke kali dan teman laki lakinya /pacar hanyut sementara korban /dewi tidak karena kecebur kali yang ada dangkal airnya... Korban Dewi dapat tertolong sementara teman laki lakinya meninggal.',
                "provinsi_id" => 12,
                "kotkab_id" => 1202,
                "kecamatan_id" => 120203,
                "kelurahan" => 'Adian Baru',
                "alamat" => 'jalan berlubang no 43',
                "created_by" => NULL,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->subDays(2),
                "deleted_at" => NULL
            ]
        ];
        Kasus::insert($kasus);

        //data pelapor
        $pelapor = [
            [
                "uuid" => "35d43be8-551a-4a8f-91d1-e8ea39295515",
                "kasus_id" => 1,
                "nik" => NULL,
                "nama" => 'Rudy Tabooti',
                "tempat_lahir" => 'Bandung',
                "tanggal_lahir" => '1984-01-03',
                "provinsi_id" => 31,
                "kotkab_id" => 3172,
                "kecamatan_id" => 317201,
                "kelurahan" => 'Pejagalan',
                "alamat" => 'Jembatan jelambar aladin RT/01/06 Kel; Pejagalan,Kec; penjaringan jakarta utara',
                "no_telp" => '085210885564',
                "desil" => NULL,
                "hubungan_pelapor" => 'Bukan Siapa-Siapa / Tak Dikenal',
                "created_by" => NULL,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5),
                "deleted_at" => NULL
            ],
            [
                "uuid" => "051b8f1c-73c0-40d0-bf6e-fc6256999801",
                "kasus_id" => 2,
                "nik" => '19200292109',
                "nama" => 'Addzifi Mochamad Gumelar',
                "tempat_lahir" => NULL,
                "tanggal_lahir" => NULL,
                "provinsi_id" => NULL,
                "kotkab_id" => NULL,
                "kecamatan_id" => 317201,
                "kelurahan" => NULL,
                "alamat" => NULL,
                "no_telp" => NULL,
                "desil" => NULL,
                "hubungan_pelapor" => 'Ayah Kandung',
                "created_by" => NULL,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->subDays(5),
                "deleted_at" => NULL
            ],
            [
                "uuid" => "a3da48d2-cc39-4e41-96e6-74e7f96af474",
                "kasus_id" => 3,
                "nik" => '24319228837',
                "nama" => 'Pak RT',
                "tempat_lahir" => NULL,
                "tanggal_lahir" => NULL,
                "provinsi_id" => NULL,
                "kotkab_id" => NULL,
                "kecamatan_id" => 317201,
                "kelurahan" => NULL,
                "alamat" => NULL,
                "no_telp" => NULL,
                "desil" => NULL,
                "hubungan_pelapor" => 'RT',
                "created_by" => NULL,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->subDays(2),
                "deleted_at" => NULL
            ]
        ];
        Pelapor::insert($pelapor);

        //data klien
        $klien = [
            [
                "uuid" => "35db5be8-551a-4a8f-91d1-e8ea392q5515",
                "kasus_id" => 1,
                "no_klien" => '312/02/2023',
                "status" => 'Pelengkapan Data',
                "nik" => NULL,
                "nama" => 'Ruby Cobalt Berliani',
                "tempat_lahir" => 'Bandung',
                "tanggal_lahir" => '1984-01-03',
                "provinsi_id" => 31,
                "kotkab_id" => 3172,
                "kecamatan_id" => 317201,
                "kelurahan" => 'Pejagalan',
                "alamat" => 'Jembatan jelambar aladin RT/01/06 Kel; Pejagalan,Kec; penjaringan jakarta utara',
                "jenis_kelamin" => 'perempuan',
                "agama" => 'islam',
                "suku" => 'Suku Sunda',
                "no_telp" => '085210885564',
                "status_pendidikan" => 'Lulus dan Tidak Melanjutkan (Tamat Belajar)',
                "pendidikan" => 'Perguruan Tinggi',
                "kelas" => 'semester 8',
                "pekerjaan" => 'Ibu Rumah Tangga',
                "penghasilan" => '1000000',
                "status_kawin" => 'Cerai Hidup',
                "jumlah_anak" => 0,
                "nama_ibu" => 'Siswati Karnasuryatna Gumelar',
                "tempat_lahir_ibu" => 'Bandung',
                "tanggal_lahir_ibu" => '1945-01-03',
                "nama_ayah" => 'Agun Gumelar',
                "tempat_lahir_ayah" => 'Subang',
                "tanggal_lahir_ayah" => '1945-01-03',
                "hubungan_klien" => 'Bukan Siapa-Siapa / Tak Dikenal',
                "no_lp" => NULL,
                "pengadilan_negri" => NULL,
                "isi_putusan" => NULL,
                "lpsk" => 0,
                "tandatangan" => NULL,
                "desil" => NULL,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5),
                "deleted_at" => NULL
            ],
            [
                "uuid" => "35dbs9e8-551a-4a8f-91d1-e8ea392q5515",
                "kasus_id" => 2,
                "no_klien" => NULL,
                "status" => 'Pelengkapan Data',
                "nik" => NULL,
                "nama" => 'ZiBoy',
                "tempat_lahir" => 'Bandung',
                "tanggal_lahir" => '2015-01-03',
                "provinsi_id" => 31,
                "kotkab_id" => 3172,
                "kecamatan_id" => 317201,
                "kelurahan" => 'Pejagalan',
                "alamat" => 'Jembatan jelambar aladin RT/01/06 Kel; Pejagalan,Kec; penjaringan jakarta utara',
                "jenis_kelamin" => 'perempuan',
                "agama" => 'islam',
                "suku" => 'Suku Sunda',
                "no_telp" => '085210885564',
                "status_pendidikan" => 'Lulus dan Tidak Melanjutkan (Tamat Belajar)',
                "pendidikan" => 'Perguruan Tinggi',
                "kelas" => 'semester 8',
                "pekerjaan" => 'Ibu Rumah Tangga',
                "penghasilan" => '1000000',
                "status_kawin" => 'Cerai Hidup',
                "jumlah_anak" => 0,
                "nama_ibu" => 'Siswati Karnasuryatna Gumelar',
                "tempat_lahir_ibu" => 'Bandung',
                "tanggal_lahir_ibu" => '1945-01-03',
                "nama_ayah" => 'Agun Gumelar',
                "tempat_lahir_ayah" => 'Subang',
                "tanggal_lahir_ayah" => '1945-01-03',
                "hubungan_klien" => 'Bukan Siapa-Siapa / Tak Dikenal',
                "no_lp" => NULL,
                "pengadilan_negri" => NULL,
                "isi_putusan" => NULL,
                "lpsk" => 0,
                "tandatangan" => NULL,
                "desil" => NULL,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5),
                "deleted_at" => NULL
            ],
            [
                "uuid" => "35dbsbe8-556a-4a8f-91d1-e8ea392q5515",
                "kasus_id" => 3,
                "no_klien" => NULL,
                "status" => 'Pelengkapan Data',
                "nik" => NULL,
                "nama" => 'Caca Marica Hey Hey',
                "tempat_lahir" => 'Bandung',
                "tanggal_lahir" => '1993-01-03',
                "provinsi_id" => 31,
                "kotkab_id" => 3172,
                "kecamatan_id" => 317201,
                "kelurahan" => 'Pejagalan',
                "alamat" => 'Jembatan jelambar aladin RT/01/06 Kel; Pejagalan,Kec; penjaringan jakarta utara',
                "jenis_kelamin" => 'perempuan',
                "agama" => 'islam',
                "suku" => 'Suku Sunda',
                "no_telp" => '085210885564',
                "status_pendidikan" => 'Lulus dan Tidak Melanjutkan (Tamat Belajar)',
                "pendidikan" => 'Perguruan Tinggi',
                "kelas" => 'semester 8',
                "pekerjaan" => 'Ibu Rumah Tangga',
                "penghasilan" => '1000000',
                "status_kawin" => 'Cerai Hidup',
                "jumlah_anak" => 0,
                "nama_ibu" => 'Siswati Karnasuryatna Gumelar',
                "tempat_lahir_ibu" => 'Bandung',
                "tanggal_lahir_ibu" => '1945-01-03',
                "nama_ayah" => 'Agun Gumelar',
                "tempat_lahir_ayah" => 'Subang',
                "tanggal_lahir_ayah" => '1945-01-03',
                "hubungan_klien" => 'Bukan Siapa-Siapa / Tak Dikenal',
                "no_lp" => NULL,
                "pengadilan_negri" => NULL,
                "isi_putusan" => NULL,
                "lpsk" => 0,
                "tandatangan" => NULL,
                "desil" => NULL,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5),
                "deleted_at" => NULL
            ],
            [
                "uuid" => "35dssbe8-551a-4a8f-91d1-e8ea392q5515",
                "kasus_id" => 3,
                "no_klien" => NULL,
                "status" => 'Pelengkapan Data',
                "nik" => NULL,
                "nama" => 'Anak Gembala',
                "tempat_lahir" => 'Bandung',
                "tanggal_lahir" => '2022-01-03',
                "provinsi_id" => 31,
                "kotkab_id" => 3172,
                "kecamatan_id" => 317201,
                "kelurahan" => 'Pejagalan',
                "alamat" => 'Jembatan jelambar aladin RT/01/06 Kel; Pejagalan,Kec; penjaringan jakarta utara',
                "jenis_kelamin" => 'perempuan',
                "agama" => 'islam',
                "suku" => 'Suku Sunda',
                "no_telp" => '085210885564',
                "status_pendidikan" => 'Lulus dan Tidak Melanjutkan (Tamat Belajar)',
                "pendidikan" => 'Perguruan Tinggi',
                "kelas" => 'semester 8',
                "pekerjaan" => 'Ibu Rumah Tangga',
                "penghasilan" => '1000000',
                "status_kawin" => 'Cerai Hidup',
                "jumlah_anak" => 0,
                "nama_ibu" => 'Caca Marica Hey Hey',
                "tempat_lahir_ibu" => 'Bandung',
                "tanggal_lahir_ibu" => '1993-01-03',
                "nama_ayah" => 'Agun Gumelar',
                "tempat_lahir_ayah" => 'Subang',
                "tanggal_lahir_ayah" => '1945-01-03',
                "hubungan_klien" => 'Bukan Siapa-Siapa / Tak Dikenal',
                "no_lp" => NULL,
                "pengadilan_negri" => NULL,
                "isi_putusan" => NULL,
                "lpsk" => 0,
                "tandatangan" => NULL,
                "desil" => NULL,
                "created_by" => NULL,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5),
                "deleted_at" => NULL
            ]
        ];
        Klien::insert($klien);
        //data tindak kekerasan
        $tindak_kekerasan = [
            [
                "klien_id" => 1,
                "value" => 'Penganiayaan'
            ],
            [
                "klien_id" => 1,
                "value" => 'Fisik'
            ],
            [
                "klien_id" => 1,
                "value" => 'Psikis'
            ],
            [
                "klien_id" => 2,
                "value" => 'ini nanti diupdate lagi yaaaaa'
            ],
            [
                "klien_id" => 3,
                "value" => 'ini nanti diupdate lagi yaaaaa'
            ],
            [
                "klien_id" => 4,
                "value" => 'ini nanti diupdate lagi yaaaaa'
            ]
        ];
        TindakKekerasan::insert($tindak_kekerasan);
        //data tindak kekerasan
        $program_pemerintah = [
            [
                "klien_id" => 1,
                "value" => 'Mekaar'
            ],
            [
                "klien_id" => 1,
                "value" => 'KLJ'
            ],
            [
                "klien_id" => 2,
                "value" => 'Mekaar'
            ],
            [
                "klien_id" => 2,
                "value" => 'PKD'
            ]
        ];
        ProgramPemerintah::insert($program_pemerintah);
        //data tindak kekerasan
        $kategori_kasus = [
            [
                "klien_id" => 1,
                "value" => 'KTP'
            ],
            [
                "klien_id" => 1,
                "value" => 'KDRT'
            ],
            [
                "klien_id" => 2,
                "value" => 'KS'
            ],
            [
                "klien_id" => 2,
                "value" => 'KTP'
            ],
            [
                "klien_id" => 3,
                "value" => 'KDRT'
            ],
            [
                "klien_id" => 3,
                "value" => 'KTA'
            ]
        ];
        KategoriKasus::insert($kategori_kasus);

        //data tindak kekerasan
        $kondisi_khusus = [
            [
                "klien_id" => 1,
                "value" => 'Saling lapor'
            ],
            [
                "klien_id" => 1,
                "value" => 'Terlapor sudah ditahan'
            ]
        ];
        KondisiKhusus::insert($kondisi_khusus);

        //data tindak kekerasan
        $difabel_type = [
            [
                "klien_id" => 1,
                "value" => 'Bipolar'
            ],
            [
                "klien_id" => 1,
                "value" => 'Anxietas'
            ],
            [
                "klien_id" => 2,
                "value" => 'Lumpuh Layuh / Kaku'
            ],
            [
                "klien_id" => 2,
                "value" => 'Hiperaktif'
            ],
            [
                "klien_id" => 2,
                "value" => 'Disabilitas Netra'
            ]
        ];
        DifabelType::insert($difabel_type);

        //data tindak kekerasan
        $pasal = [
            [
                "klien_id" => 1,
                "value" => 'UNDANG-UNDANG REPUBLIK INDONESIA NOMOR 12 TAHUN 2022 TENTANG TINDAK PIDANA KEKERASAN SEKSUAL'
            ],
            [
                "klien_id" => 2,
                "value" => 'UNDANG-UNDANG REPUBLIK INDONESIA NOMOR 12 TAHUN 2022 TENTANG TINDAK PIDANA KEKERASAN SEKSUAL'
            ]
        ];
        Pasal::insert($pasal);

        //data terlapor
        $terlapor = [
            [
                "uuid" => "35db5be8-a51a-4a8f-91d1-e8ea392q5515",
                "kasus_id" => 1,
                "nik" => NULL,
                "nama" => 'Frankenstein',
                "tempat_lahir" => 'Bandung',
                "tanggal_lahir" => '1901-01-03',
                "provinsi_id" => 31,
                "kotkab_id" => 3172,
                "kecamatan_id" => 317201,
                "kelurahan" => 'Pejagalan',
                "alamat" => 'Jembatan jelambar aladin RT/01/06 Kel; Pejagalan,Kec; penjaringan jakarta utara',
                "jenis_kelamin" => 'laki-laki',
                "agama" => 'islam',
                "suku" => 'Suku Sunda',
                "no_telp" => '085210885564',
                "status_pendidikan" => 'Lulusa dan Tidak Melanjutkan (Tamat Belajar)',
                "pendidikan" => 'Perguruan Tinggi',
                "pekerjaan" => 'Ibu Rumah Tangga',
                "status_kawin" => 'Cerai Hidup',
                "jumlah_anak" => 0,
                "hubungan_terlapor" => 'Bukan Siapa-Siapa / Tak Dikenal',
                "desil" => NULL,
                "created_by" => NULL,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5),
                "deleted_at" => NULL
            ],
            [
                "uuid" => "8c05719d-ac64-4dbe-a9db-87767b43959f",
                "kasus_id" => 2,
                "nik" => NULL,
                "nama" => 'Jack The Ripper',
                "tempat_lahir" => NULL,
                "tanggal_lahir" => NULL,
                "provinsi_id" => 31,
                "kotkab_id" => 3172,
                "kecamatan_id" => 317201,
                "kelurahan" => NULL,
                "alamat" => NULL,
                "jenis_kelamin" => 'laki-laki',
                "agama" => NULL,
                "suku" => NULL,
                "no_telp" => NULL,
                "status_pendidikan" => NULL,
                "pendidikan" => NULL,
                "pekerjaan" => NULL,
                "status_kawin" => NULL,
                "jumlah_anak" => 0,
                "hubungan_terlapor" => 'Bukan Siapa-Siapa / Tak Dikenal',
                "desil" => NULL,
                "created_by" => NULL,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->subDays(5),
                "deleted_at" => NULL
            ],
            [
                "uuid" => "8205719d-ac64-4dbe-a9db-87767b43959f",
                "kasus_id" => 3,
                "nik" => NULL,
                "nama" => 'Chester Bennington',
                "tempat_lahir" => NULL,
                "tanggal_lahir" => NULL,
                "provinsi_id" => 31,
                "kotkab_id" => 3172,
                "kecamatan_id" => 317201,
                "kelurahan" => NULL,
                "alamat" => NULL,
                "jenis_kelamin" => 'laki-laki',
                "agama" => NULL,
                "suku" => NULL,
                "no_telp" => NULL,
                "status_pendidikan" => NULL,
                "pendidikan" => NULL,
                "pekerjaan" => NULL,
                "status_kawin" => NULL,
                "jumlah_anak" => 0,
                "hubungan_terlapor" => 'Bukan Siapa-Siapa / Tak Dikenal',
                "desil" => NULL,
                "created_by" => NULL,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->subDays(5),
                "deleted_at" => NULL
            ]
        ];
        Terlapor::insert($terlapor);

        //data petugas
        $petugas = [
            [
                "klien_id" => 1,
                "user_id" => 1,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5),
                "deleted_at" => NULL
            ],
            [
                "klien_id" => 1,
                "user_id" => 2,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5),
                "deleted_at" => NULL
            ],
            [
                "klien_id" => 1,
                "user_id" => 3,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5),
                "deleted_at" => NULL
            ],
            [
                "klien_id" => 1,
                "user_id" => 4,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5),
                "deleted_at" => NULL
            ],
            [
                "klien_id" => 1,
                "user_id" => 5,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5),
                "deleted_at" => NULL
            ],
            [
                "klien_id" =>1,
                "user_id" => 6,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5),
                "deleted_at" => NULL
            ],
            [
                "klien_id" => 1,
                "user_id" => 7,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5),
                "deleted_at" => NULL
            ],
            [
                "klien_id" => 1,
                "user_id" => 8,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5),
                "deleted_at" => NULL
            ],
            [
                "klien_id" => 1,
                "user_id" => 12,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5),
                "deleted_at" => NULL
            ],
            [
                "klien_id" => 1,
                "user_id" => 13,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5),
                "deleted_at" => NULL
            ],
            [
                "klien_id" => 1,
                "user_id" => 14,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5),
                "deleted_at" => NULL
            ],
            [
                "klien_id" => 1,
                "user_id" => 15,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5),
                "deleted_at" => NULL
            ],
            [
                "klien_id" => 2,
                "user_id" => 1,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->subDays(5),
                "deleted_at" => NULL
            ],
            [
                "klien_id" => 3,
                "user_id" => 1,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->subDays(5),
                "deleted_at" => NULL
            ]
        ];
        Petugas::insert($petugas);

        //data persetujuan template
        $persetujuan_template = [
            [
                "uuid" => '2a83d123-3c86-41f8-aee1-ca22l262f462',
                "kategori" => 'persetujuan pelayanan',
                "judul" => 'Surat Persetujuan Pelayanan',
                "konten" => null,
                "created_by" => 1
            ],
            [
                "uuid" => '5a83d123-3c86-41f8-aee1-ca22l262f462',
                "kategori" => 'persetujuan terminasi',
                "judul" => 'Surat Persetujuan Terminasi',
                "konten" => null,
                "created_by" => 1
            ]
        ];
        PersetujuanTemplate::insert($persetujuan_template);

        //data persetujuan isi
        $persetujuan_isi = [
            [
                "uuid" => 'd54ff727-0372-4156-afcf-0ac4dd71ac57',
                "klien_id" => 1,
                "persetujuan_template_id" => 1,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5)
            ],
            [
                "uuid" => '343ff690-cfd6-41e4-b9f3-6c41cfe8e9e8',
                "klien_id" => 1,
                "persetujuan_template_id" => 1,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5)
            ]
        ];
        PersetujuanIsi::insert($persetujuan_isi);

        //data persetujuan item
        $persetujuan_item = [
            [
                "uuid" => 'd54ff227-0372-4156-afcf-0ac4dd71ac57',
                "persetujuan_template_id" => 1,
                "parent_id" => 0,
                "item" => '2.  Telah mendapat penjelasan tentang tujuan, manfaat dan Langkah-langkah penanganan dari Pusat Perlindungan Perempuan dan Anak Provinsi DKI Jakarta',
                "fillable" => 0,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5)
            ],
            [
                "uuid" => 'd24ff727-0372-4156-afcf-0ac4dd71ac57',
                "persetujuan_template_id" => 1,
                "parent_id" => 0,
                "item" => '3. Telah mengisi dan memahami pernyataan berikut:',
                "fillable" => 0,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5)
            ],
            [
                "uuid" => '254ff727-0372-4156-afcf-0ac4dd71ac57',
                "persetujuan_template_id" => 1,
                "parent_id" => 2,
                "item" => 'A. Saya bersedia mendapatkan penanganan dari Pusat Perlindungan Perempuan dan Anak Provinsi DKI Jakarta berupa layanan',
                "fillable" => 0,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5)
            ],
            [
                "uuid" => '754ff727-0372-4156-afcf-0ac4dd71ac57',
                "persetujuan_template_id" => 1,
                "parent_id" => 3,
                "item" => '- Penerimaan Pengaduan dan Informasi',
                "fillable" => 1,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5)
            ],
            [
                "uuid" => 'd54ff727-0372-4156-afcf-0ac4dd71ac57',
                "persetujuan_template_id" => 1,
                "parent_id" => 3,
                "item" => '- Psikologis (Konseling, Pemeriksaan, Terapi, dsb)',
                "fillable" => 1,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5)
            ],
            [
                "uuid" => '254ff727-0372-4156-afcf-0ac4dd71ac57',
                "persetujuan_template_id" => 1,
                "parent_id" => 3,
                "item" => '- Hukum (Konsultasi, Pendampingan Kepolisian, Pendampingan Kepolisian, Mediasi, dsb)',
                "fillable" => 1,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5)
            ],
            [
                "uuid" => '454ff727-0372-4156-afcf-0ac4dd71ac57',
                "persetujuan_template_id" => 1,
                "parent_id" => 3,
                "item" => '- Sosial (Home visit, school visit, pemulangan / reintegrasi, dsb)',
                "fillable" => 1,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5)
            ],
            [
                "uuid" => 'f54ff727-0372-4156-afcf-0ac4dd71ac57',
                "persetujuan_template_id" => 1,
                "parent_id" => 3,
                "item" => '- Rujukan',
                "fillable" => 1,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5)
            ],
            [
                "uuid" => '254ff727-0372-4156-afcf-0ac4dd71ac57',
                "persetujuan_template_id" => 1,
                "parent_id" => 2,
                "item" => 'B. Saya bersedia mengikuti prosedur dan bekerja sama dengan memberikan informasi tentang saya, anak, keluarga saya, atau pihak lain yang terkait dengan masalah yang saya / anak saya alami',
                "fillable" => 1,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5)
            ],
            [
                "uuid" => '454ff727-0372-4156-afcf-0ac4dd71ac57',
                "persetujuan_template_id" => 1,
                "parent_id" => 2,
                "item" => 'C. Saya bersedia bekerja sama dengan Pusat Perlindungan Perempuan dan Anak Provinsi DKI Jakarta dalam penanganan kasus berupa pemberian informasi / keterangan dari saya atau pihak lain yang termasuk jika diperlukan',
                "fillable" => 1,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5)
            ],
            [
                "uuid" => 'g54ff727-0372-4156-afcf-0ac4dd71ac57',
                "persetujuan_template_id" => 1,
                "parent_id" => 2,
                "item" => 'D. Saya mengijinkan Tim Pelayanan untuk mencatat, merekam dan menuliskan dalam laporan semua informasi yang telah say a, anak saya atau keluarga saya berikan tentang selulita/masayah yang dialami',
                "fillable" => 1,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5)
            ],
            [
                "uuid" => 'l54ff727-0372-4156-afcf-0ac4dd71ac57',
                "persetujuan_template_id" => 1,
                "parent_id" => 2,
                "item" => 'E. Saya bersedia apabila dari Pusat Perlindungan Perempuan dan Anak Provinsi DKI Jakarta meminta bantuan pada pihak lain, termasuk jika mereka membutuhkan Informasi terkait kasus yang sedang dijalani',
                "fillable" => 1,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5)
            ],
            [
                "uuid" => 'p54ff727-0372-4156-afcf-0ac4dd71ac57',
                "persetujuan_template_id" => 1,
                "parent_id" => 2,
                "item" => 'F. Saya menyutujui bahwa dari Pusat Pwelindungan Perempuan dan Anak Provinsi DKI Jakarta dapat mengeluarkan surat pemeriksaan psikologis baik lisan maupun tulisan apabila diminta oleh pihak Penegak Hukum',
                "fillable" => 1,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5)
            ],
            [
                "uuid" => 'x54ff727-0372-4156-afcf-0ac4dd71ac57',
                "persetujuan_template_id" => 1,
                "parent_id" => 2,
                "item" => 'G. Saya bersedia untuk menginformasikan dari Pusat Perlindungan Perempuan dan Anak Provinsi DKI Jakarta apabila saya meminta bantuan dari lembaga lain dan bersedia tidak mendapatkan layanan sejenis dari Pusat Perlindungan Perempuan dan Anak Provinsi DKI Jakarta',
                "fillable" => 1,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5)
            ],
            [
                "uuid" => 'c54ff727-0372-4156-afcf-0ac4dd71ac57',
                "persetujuan_template_id" => 1,
                "parent_id" => 2,
                "item" => 'H. Apabila kesulitan / masalah saya dan keluarga telah dapat diselesaikan maka Tim Pelayanan dari Pusat Perlindungan Perempuan dan Anak Provinsi DKI Jakarta akan menghentikan tugasnya membantu saya',
                "fillable" => 1,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5)
            ],
            [
                "uuid" => 'm54ff727-0372-4156-afcf-0ac4dd71ac57',
                "persetujuan_template_id" => 1,
                "parent_id" => 0,
                "item" => '4. Semua informasi dijaga kerahasiaannya oleh Pusat Perlindungan Perempuan dan Anak Provinsi DKI Jakarta',
                "fillable" => 0,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5)
            ],
            [
                "uuid" => 'm54ff727-0372-4156-afcf-0ac4dd71ac57',
                "persetujuan_template_id" => 1,
                "parent_id" => 0,
                "item" => '5. Demikian surat pernyataan ini dibuat dengan sebenar-benarnya',
                "fillable" => 0,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5)
            ]
        ];
        PersetujuanItem::insert($persetujuan_item);

        //data agenda
        $agenda = [
            [
                "uuid" => '2a83d123-3c86-41f8-aee1-ca22l262f462',
                "klien_id" => NULL,
                "judul_kegiatan" => "Koordinasi Terkait PP1",
                "tanggal_mulai" => Carbon::today()->subDays(1)->toDateString(),
                "jam_mulai" => '08:00:00',
                "keterangan" => 'koordinasi dengan konselor',
                "created_by" => 2,
                "created_at" => Carbon::now()->subDays(1),
                "updated_at" => Carbon::now()
            ],
            [
                "uuid" => '513c0e13-75a4-4684-a5be-74426786fd8c',
                "klien_id" => NULL,
                "judul_kegiatan" => "Membuat tiket MOKA",
                "tanggal_mulai" => Carbon::today()->subDays(1)->toDateString(),
                "jam_mulai" => '08:00:00',
                "keterangan" => 'koordinasi dengan konselor',
                "created_by" => 2,
                "created_at" => Carbon::now()->subDays(1),
                "updated_at" => Carbon::now()
            ],
            [
                "uuid" => '513c0e13-75a4-4684-ad8e-74426786fd8c',
                "klien_id" => NULL,
                "judul_kegiatan" => "Istirahat",
                "tanggal_mulai" => Carbon::today()->subDays(1)->toDateString(),
                "jam_mulai" => '12:00:00',
                "keterangan" => '',
                "created_by" => 2,
                "created_at" => Carbon::now()->subDays(1),
                "updated_at" => Carbon::now()
            ],
            [
                "uuid" => '513c0e13-75a4-4684-a58e-7442a786fd8c',
                "klien_id" => NULL,
                "judul_kegiatan" => "Koordinasi dengan MK",
                "tanggal_mulai" => Carbon::today()->subDays(1)->toDateString(),
                "jam_mulai" => '13:00:00',
                "keterangan" => 'Berdiskusi dengan manager kasus terkait intervensi lanjutan klien TPPO',
                "created_by" => 2,
                "created_at" => Carbon::now()->subDays(1),
                "updated_at" => Carbon::now()
            ],
            [
                "uuid" => '513c0e13-75a4-46v4-a58e-74426786fd8c',
                "klien_id" => 1,
                "judul_kegiatan" => "Koordinasi dengan Advokat",
                "tanggal_mulai" => Carbon::today()->subDays(1)->toDateString(),
                "jam_mulai" => '15:00:00',
                "keterangan" => 'Berkoordinasi dengan advokat, satpel dan psikolog terkait intervensi masalah NA dan rencana reintegrasi klien NA',
                "created_by" => 2,
                "created_at" => Carbon::now()->subDays(1),
                "updated_at" => Carbon::now()
            ],
            [
                "uuid" => '513c0e13-75a4-4684-a58e-74426716fd8c',
                "klien_id" => 1,
                "judul_kegiatan" => "Koordinasi dengan satpel & tenaga layanan",
                "tanggal_mulai" => Carbon::today()->subDays(2)->toDateString(),
                "jam_mulai" => '08:00:00',
                "keterangan" => 'Berdiskusi dengan satpel dan tenaga pelayanan terkait agenda visit klien',
                "created_by" => 2,
                "created_at" => Carbon::now()->subDays(1),
                "updated_at" => Carbon::now()
            ],
            [
                "uuid" => '513c0e13-75a4-46a4-a58e-74426786fd8c',
                "klien_id" => 1,
                "judul_kegiatan" => "Kunjungan rumah klien",
                "tanggal_mulai" => Carbon::today()->subDays(2)->toDateString(),
                "jam_mulai" => '09:00:00',
                "keterangan" => 'Melakukan kunjungan rumah klien NA untuk persiapan reintegrasinya',
                "created_by" => 2,
                "created_at" => Carbon::now()->subDays(2),
                "updated_at" => Carbon::now()
            ],
            [
                "uuid" => '513c0e13-75a4-4684-a58e-744f6786fd8c',
                "klien_id" => NULL,
                "judul_kegiatan" => "Istirahat",
                "tanggal_mulai" => Carbon::today(),
                "jam_mulai" => '12:00:00',
                "keterangan" => '',
                "created_by" => 2,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ],
            [
                "uuid" => '513c2e13-75a4-4684-a58e-74426786fd8c',
                "klien_id" => NULL,
                "judul_kegiatan" => "Koordinasi dengan advokat",
                "tanggal_mulai" => Carbon::today(),
                "jam_mulai" => '13:00:00',
                "keterangan" => 'Melakukan diskusi dengan advokat dan satpel terkait re-integrasi klien NA',
                "created_by" => 2,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ]
        ];
        Agenda::insert($agenda);

        //data tindak lanjut
        $tindak_lanjut = [
            [
                "uuid" => '2a83d123-3c16-41f8-aee1-ca22b262f462',
                "agenda_id" => 1,
                "tanggal_selesai" => Carbon::now(),
                "jam_selesai" => '10:00:00',
                "lokasi" => 'Kantor Pusat PPA DKI Jakarta',
                "catatan" => 'hasil koordinasi disepakati tanggal PP1 adalah minggu depan',
                "created_by" => 2,
                "validated_by" => 2,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ],
            [
                "uuid" => '2a83d123-3c86-41f8-aee1-ca22b2c2f462',
                "agenda_id" => 2,
                "tanggal_selesai" => Carbon::now(),
                "jam_selesai" => '00:00:00',
                "lokasi" => 'Kantor Pusat PPA DKI Jakarta',
                "catatan" => 'pemberian tiket sudah dilakukan',
                "created_by" => 2,
                "validated_by" => 2,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ],
            [
                "uuid" => '2a83d123-3c86-41f8-aee1-ca22b26bf462',
                "agenda_id" => 3,
                "tanggal_selesai" => Carbon::now(),
                "jam_selesai" => '13:00:00',
                "lokasi" => 'Kantor Pusat PPA DKI Jakarta',
                "catatan" => NULL,
                "created_by" => 2,
                "validated_by" => 2,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ],
            [
                "uuid" => '2a83d123-3c86-41f8-aee1-ca22b262f462',
                "agenda_id" => 4,
                "tanggal_selesai" => Carbon::now(),
                "jam_selesai" => '15:00:00',
                "lokasi" => 'Kantor Pusat PPA DKI Jakarta',
                "catatan" => 'hasil diskusi dengan MK lain terkait intervensi lanjutan klien TPPO adalah, perlu adanya penjadwalan / pemberian tiket ke layanan-layanan terkait',
                "created_by" => 2,
                "validated_by" => 2,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ],
            [
                "uuid" => '2a83d123-3c86-41f8-abe1-ca22b262f462',
                "agenda_id" => 5,
                "tanggal_selesai" => NULL,
                "jam_selesai" => NULL,
                "lokasi" => NULL,
                "catatan" => NULL,
                "created_by" => 2,
                "validated_by" => 2,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ],
            [
                "uuid" => '2a83d123-3c86-41f8-aee1-ca22b2t2f462',
                "agenda_id" => 6,
                "tanggal_selesai" => Carbon::now(),
                "jam_selesai" => '09:00:00',
                "lokasi" => 'Kantor Pusat PPA DKI Jakarta',
                "catatan" => 'hasil dari koordinasi adalah kesepakatan agenda visit yaitu minggu depan',
                "created_by" => 2,
                "validated_by" => 2,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ],
            [
                "uuid" => '2a81d123-3c86-41f8-aee1-ca22b262f462',
                "agenda_id" => 7,
                "tanggal_selesai" => Carbon::now(),
                "jam_selesai" => '00:00:00',
                "lokasi" => 'Kantor Pusat PPA DKI Jakarta',
                "catatan" => NULL,
                "created_by" => 2,
                "validated_by" => 2,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ],
            [
                "uuid" => '2a83d123-3c81-41f8-aee1-ca22b262f462',
                "agenda_id" => 8,
                "tanggal_selesai" => Carbon::now(),
                "jam_selesai" => '13:00:00',
                "lokasi" => NULL,
                "catatan" => NULL,
                "created_by" => 2,
                "validated_by" => 2,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ],
            [
                "uuid" => '2as3d123-3c86-41f8-aee1-ca22b262f462',
                "agenda_id" => 9,
                "tanggal_selesai" => Carbon::now(),
                "jam_selesai" => '15:00:00',
                "lokasi" => 'Kantor Pusat PPA DKI Jakarta',
                "catatan" => 'hasil dari diskusi adalah persiapan2nya',
                "created_by" => 2,
                "validated_by" => 2,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ]
        ];
        TindakLanjut::insert($tindak_lanjut);

        //data tindak lanjut
        $riwayat_kejadian = [
            [
                "uuid" => '2a81d123-3a16-41f8-aee1-ca22a262fc62',
                "klien_id" => 1,
                "tanggal" => Carbon::now(),
                "jam" => '10:00:00',
                "keterangan" => 'Klien pergi hendak pergi ke pasar menggunakan transportasi umum (angkot)',
                "created_by" => 1
            ],
            [
                "uuid" => '5a81da23-3a16-41f8-aee1-ca22a162fc62',
                "klien_id" => 1,
                "tanggal" => Carbon::now(),
                "jam" => '11:00:00',
                "keterangan" => 'Klien sampai di pasar dan berbelanja apel',
                "created_by" => 1
            ],
            [
                "uuid" => '5aa1da23-3a16-4sf8-dee1-ca22a462fc62',
                "klien_id" => 1,
                "tanggal" => Carbon::now(),
                "jam" => '12:00:00',
                "keterangan" => 'Klien pergi solat di mesjid dekat pasar',
                "created_by" => 1
            ],
            [
                "uuid" => '46a1da23-3a16-4sf8-dee1-ca22a46sfc62',
                "klien_id" => 1,
                "tanggal" => Carbon::now(),
                "jam" => '13:00:00',
                "keterangan" => 'Klien main ke TimeZone',
                "created_by" => 1
            ],
            [
                "uuid" => '56a1wa23-3a16-4sf8-dee1-ca22az6sfc62',
                "klien_id" => 1,
                "tanggal" => Carbon::now(),
                "jam" => '14:00:00',
                "keterangan" => 'Klien makan somay aa kasep',
                "created_by" => 1
            ],
            [
                "uuid" => '46a1wa23-1a16-4sf8-dee1-ca22a16sfc62',
                "klien_id" => 1,
                "tanggal" => Carbon::now(),
                "jam" => '15:00:00',
                "keterangan" => 'Klien pulang ke rumah',
                "created_by" => 1
            ],
            [
                "uuid" => '66a1wa23-1a16-4sf8-dee1-c322a16sfc62',
                "klien_id" => 1,
                "tanggal" => Carbon::now(),
                "jam" => '16:00:00',
                "keterangan" => 'Klien cuci tangan dan kaki lalu bobo',
                "created_by" => 1
            ]
        ];
        RiwayatKejadian::insert($riwayat_kejadian);

        //data asesmen
        $asesmen = [
            [
                "uuid" => '2a81d123-3a16-41f8-aee1-ca22a262fc62',
                "klien_id" => 1,
                "fisik" => 'lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet',
                "sosial" => 'lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet',
                "psikologis" => 'lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet',
                "hukum" => 'lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet',
                "lainnya" => 'lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet',
                "upaya" => 'lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet',
                "pendukung" => 'lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet',
                "hambatan" => 'lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet',
                "harapan" => 'lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet',
                "created_by" => 1
            ]
        ];
        Asesmen::insert($asesmen);

        //data template
        $template = [
            [
                "uuid" => '66a1wa23-1a16-4sf8-dee1-c322a16sfc62',
                "nama_template" => '[F-PSI-01] Form Pemeriksaan Psikologi',
                "pemilik" => 'Psikolog',
                "konten" => '"<p style=\"text-align: center;\"><img src=\"data:image\/png;base64,iVBORw0KGgoAAAANSUhEUgAAAioAAABiCAIAAADxxm\/MAAAACXBIWXMAAA7EAAAOxAGVKw4bAAAgAElEQVR4nO2dZ1QUSdeAa4YZcs4CkpMKKoIiBgRMIOoSRTEACgoGxJwzKwbMrmlVELMiigoiqCCKCRBRQXJGcmYIk\/r7UWt\/s5MYENd133oOhzNdU+HWrZ6+3VXV9xIwDAMIBAKBQPyzEH+2AAgEAoH4XwSZHwQCgUD8BJD5QSAQCMRPAJkfBAKBQPwEkPlBIBAIxE8AmR8EAoFA\/ASQ+UEgEAjETwCZHwQCgUD8BJD5QSAQCMRPgMSZ1L9+ENraKDV19RiGtba2SktLE4kEPR2tfqwfQiAQ+r1OBAKBQPw42M0PhmHfaX6qa+pycnMzMj6kpmXUNzQQCJi4mDiBAISEhBgMBgZAV2fnYJNh5sMHy8rImJubqygrfU9zANkeBAKB+AUhsBmbPpuf9nbKx0+fb9y6U1RUKCkpaWBgaGczXkVVRUJcQkJCHAACmUyi0egAYG3tlA5Ke1V1dWJSSltbc1Nj41zPOWbDh6uo9NEOEQgEZIEQCATi16IfzE97OyUx+eX16zfq6xtmzpxuYz3e2MiARCJhGNba2sZgMgGGUalUERHhtrZ2cXFxYWFhAoEgKSlBIBBoNNrHz9lPnybm5uXr62nP9Zw9UEOjt7YEmR8EAoH45fgu88NkMj99\/rLvwMHGpqaAJUumTLYTFxPFMKymti4942NlRVn80+eamtrlZcVfv1aZmw17l\/ZeWUVVUUGhm9rt6DCVTCLb2VrLyUoTicSm5tZHcfE3b92aNNFusa+PiIhIL\/rQH+aHTqfn5ORgGEalUiUkJPT19UkkUkdHR1FRkZKSkoqKCsz2+fNnaWlpTU1NeFhYWFhYWAgAMDAw0NHRwfMAANTV1eXk5GCezs5O1rbk5OTU1dX5tAsTWTs4ZMgQmCgjIzNw4EA24dlazM3NpdFogwcPJhKJAIDi4uKOjo4hQ4ZwzQyrFRcX19XVhRlycnIkJSU1NDR41d9jEa5dVlFR4dUpJpNJpVIlJSV1dXWFhYV5qYW\/PLASBQUFfCB6HD7BlQ8AqK+vr66uJhKJgwcPhl+Vl5e3tLRISEjo6OjgMnR3d0tISOjq6oqKiuJN9KrXnB3pl4Hu82j2SlFcu\/Y9Ku3tT7IPHexR7X1TWp8Lci2C\/\/Dhjwsf9F8b7O8wmUyGYHR2du3cE2I+auyFsMuUjk6YGP\/0eWFx6aSpjhMmThs+cpzdlJmLl68zGDRUVV3TdtK035xdR421NR89wWdJ4FzvxePt7Kc4uqzdsC0q+iGdTmcwGM0trcdPnpnu5P7yZYqAYjAYDCaTiX039fX1UCFwUNXV1ZOTk1NSUgAAGzZswLMBAFxcXDAMo9PpHh4euBqnTZsGM3z48AGmrF27FqYMGjSITeeLFy\/m3y6eCBEVFcUwrKGhAQAwd+5cNsk5W\/Ty8gIAPHr0CP50FRUVp0yZwiszrFZMTKyiogKmKCsrL1q0iE\/9PRbh2mWunWLrvqKi4rNnz3iphZc8bDVramrevXsXwzA+w9db5WMYtnXrVpjS2NgIU8aMGQMAGDduHGdVsrKyUP996zVbR\/ploPs8mr1SFNeu9YtKe\/xJ9rmD\/NXeZ6X1rSCv09vDwwPDsKysLDKZPGvWLOw\/QR\/tZ3FJmcec+aVlZZG3rnvNn8NkMvMLikOPnLh+\/WZDfb2SsrLJEOPZsz2oNGp9fe3UKVMXL15iZ2ejOXDgNPvJsrIyYqJilRUVZBJJWkqitbUlNPRIc0vrs8RkMokU4O8bun\/vyTN\/Hj72B5VK7Zt4fUBMTAwAsHLlSjqd\/v79+7a2tg0bNsA7bjKZjGcjkUhCQkIAgOfPn9+8efPAgQN0Or2lpeXEiRMww40bN8zMzEaMGHH37l2Y8uDBg\/Ly8uDgYABAbGxsUVHRrl27+LcLE5cuXVpWVlZQUJCamgoAgHfTnM+FnC3u3btXUlLy6NGjAIBbt261trYeO3aMV2YJCQn4ISgoCH4QFhaGAvS5CNcuc+0UTFy1ahWDwcjIyKBQKIcPH+alFl7ywMxr1qypqqqKiopiMBju7u5paWl8hq+3ygcA1NTUGBgYAABevHgBAGhubn737p2+vn5bWxte1dq1axkMxtu3b5ubm8+dO4en96rXnB3pl4Hu82j2SlFcu\/Y9KhX8J9nnDvJXe5+V1reCvE5vMplMpVLnzZtnamp68eJF8J+gL+Yn\/f2HRYv9ra3HHw3drzlQ\/c27dN\/FS1euXnP12nVjY6NHj594uLstmDdnqZ\/3pQunTx8PPRCye8fWjZs3rDl86ODWTeuvhP+5fvWy40cOLvZbRKPSKB2dwiKiW7bt2r5rz5GT5yorq3R1tE+fONrU1LR9V3B7e3u\/95kr8AxmMBgEAsHMzExHR6erq4vzXBcWFoY5MQwDAKSkpFRXV0tLS8NHaSaTeeXKFScnp+nTpxcWFsIzWE9PT0NDQ0ZGBgCgpKSko6OjqqrKv12YSCKRBg4cqKenZ2JigudknYPi1aKamtqmTZseP36cnZ0dGhq6adMmY2NjXplhtS4uLpGRkVFRUbCPeCt9KMKry3w6RaPRAADDhg2TlZWFkypc1cJfHhKJpKqq6uzsHBERQafTjx49ymf4eqt8AEB5efmkSZOIRGJMTAwAICoqSk9Pz8DAoLGxEa+KyWQCAJSVlYlEooWFBatsgveasyP9MtB9Hs0+nKVsXfselQr+k+xzB\/mo\/XuU1r8\/NxKJtGzZss7OztjYWNyG\/er02vykpWds3LzNe8H8wOX+oqIid+\/HlJaV02h0ExPToUOHFRWXTHOYMsPR3mz4sIbGppbm5sio+7uC9y9ZFuQXEBiwfPXmbXtu3o6qr6+XkJBwmjHtjxOH\/f28rcdZFRUXqQ9QTU19t2X7rjfv0khk0paN6zTUNXbuDm5r+ycsEBzjioqKuLi4oKCgzMxMPz8\/eJaznusiIiJwKsDW1tbBwSE6OlpbW9vHxwc+IMfHx1dUVLi5ubm4uAAArl+\/zla\/gO3CxIiICD09PU1NzWvXruE52SZ8ebUYFBSkqKi4du3axsbGTZs28ckMq50+fbq5ufmyZcuam5tFRERwaftQhFeX+XTq06dPJ0+enDlzprGx8e+\/\/85LLfzlwZ+VbWxsxMTE8vPz+Qxfb5UPACgrK1NXV7eysnrw4AGGYdeuXZsxY4aEhAQceljq5s2blpaWgwYNGjdu3LJly\/rWa86O9MtAf89o9vYsZeva96hU8J9knzvIR+3fo7T+\/bldvXr1\/Pnz06dPxxe9\/gNwee2UD5kfP2\/asn3u3DkL5s1pb2\/\/+Dln374DYuLiRKIQncE4EBJsoK\/T0tL66PHTmNiYLzm5ZLKwkaGhlaW5lJS0EInMYNAp7W0fPmbv3LOvrbXF2Nhw4sRJE23Gj7EaXV5ZdfbcxY8fM43NRxw7cdLd1dnd1TlgyaKTp8\/t2hO8Z9cOzgfb\/gXetyYkJOTl5RkZGT169Mje3j4vLw8AQKfT8Wx0Oh1OghGJxIcPH169ejUkJCQ8PDwjIyM9Pf3ChQtiYmLw0VhYWPjmzZsHDx6Evw34tARb6bFd+EsYOXLkvHnzaDTaiBEj8Jxs5odXi+Li4l5eXocOHQoNDcXn67hmxvt1\/vz5UaNGbdu2TVxcHPu2\/aQPRXDYugw\/cO1UQUHB1atX09LSbGxsZGVleamFlzwwM7zjhmXpdLqCggLsONfh663yAQClpaXS0tLu7u5BQUEJCQlJSUkhISGnT5\/u7Oxsb2+HeweMjY3nzp2bn59\/7NgxS0vLjx8\/wrK96jVnR\/ploIlEYp9Hs7dnKVvXuA69gCoV\/CfZ59OVj9r7XGffCvI5vR0cHGg0WmhoqImJCVzz+y\/AthbEZ+tBaVnFhIlTz1+8BPcIzPL0Hms9cco0JyfX2afOXGhobKLT6Vev37YabzvJfsbFS1fKKr7y2S9QVV1783aUk+tsyzETLoRdptFoNbV1x\/7402K0tb6x6dPEF7W19VQqlUqlhh4+vmrthh+99QDu1PLz82NNbG1tBQB4e3vDQ7hsuGvXLtY8dDp9zpw5AIDExERhYWETExMPDw8PDw+4tycxMRFmg4tDKSkpgrQLE1l3KOCJgYGBeEpdXR2fFs+fPw8AePLkCf\/M8CISFhaGYdju3bvJZPKQIUNWrlzZtyKssHWZT6d8fX0xDIM3xcHBwbzUwksetpojIyMBACdPnuxx+ARXfm1tLQAgPDz869evRCJxwoQJRkZGGIatWLECsOz08\/f3h\/lXrlwJAMjKyupDrzk70i8D\/T2j2duzlK1r36NSwX+Sfe4gL7V\/T539+HOD4vn4+DQ3N2toaEhJSZWWlmL\/CQQ1P11dXbPmzN+z9wCVSq2tqz96\/KT5aOvR4+yePE18l\/qewWB8yPxs7+g009n9bWo6LEKj0fLLvpRWFcFdbbzIyPw0b8Eia7spr968g0bObsr0ZYGrNbT0b92JZjAYFErH+k3bb0Xe\/aHmB6524qc1jpWVlaSk5IMHDwoKCnx8fIhE4sePHzEMKysri4uLKywszMrKcnV1JRKJcBtPTEwMLHjv3j3W6xFcW37+\/Lkg7cLf2JQpU+7fvx8ZGXn16tWKigqY093dPTo6+vbt21euXNm3bx+fFk+dOgW+bYvCMAwuSnNmhqtrZ8+exTCMTqePHDkSABAQENC3IqywdZlrp2Cil5cXhmFMJlNXV1dFRYVKpXJVCy958JoTExMPHz4sJSVlZmbW1dXFZ\/h6q3y4Wh4ZGYlhmJ2dHQBgz549GIbB+a5Xr17BUs7OztnZ2TExMXp6egoKChQKpVe95tURXh3v1UB\/z2gKriiuXYNGorcq7e1Pss8d5HP+9LnOfvy5QfHmzZuHYRhcLpo+fTr2n0Ag80On048cOzVnnk9DQ2NXV9eqtZusJ04zGzVuqqNzbV19R2fntRu3LcdO+PPipbb2dliku7vrVPTvI4NkRq2Su5F4jkaj8rFAHR2d12\/eGWNtd+KPs+3tlKeJyfO9\/UaMHHvw8IkTp\/5kMBhfq6pnOLnn5Ob9OPNTV1cHAJg9ezZbenZ29rBhwwAAAAAxMbETJ07A9NOnT4NvyMvLnzt3btSoUUQisb29HWaAy6cDBgyAhyEhIQCAp0+fCtIuTGQlISGBM3Ho0KF8Wjxy5AgAAN9Cyks8WO3Ro0dh+sePH4lEIvzN96EIK2xd5tMpT09PmGfLli3wksRVLfzlgUhKSnp7ezc0NPAfvt4qH94Rw0sDXJT+\/PkzhmFwE2N0dDRrKTk5uZkzZ3748KFvvebsCP9TS8CB\/p7R7O1Zyta1sLCwPqtU8J9knzvI5\/zpc539\/nPDN1tbW1sDAGJjY7FfH4FeOy0uKZs1Z15E2HkjQ\/2Ll659zvqSlPR05YrAYcNMhwwyOn\/xUuyjR+vXrZ0wfgxepKAye8VpF4yAAQDESVJ\/LL83QIH9hSw2Pn3+snP3HmNj403r1xQUlSxZuqK7q9PKaozXfE\/LkeYvX725FHH5zB\/H2LaXgH\/E60FFRUVdXZ2hoSHrnpPS0tL6+noZGRlNTU04T434WVCp1M7OTgzDZGRkOE8GrsPX78CbISEhIV7bTASBf0cQOP07pkjtPwWhnTt38s9BpdJ27dk7duyYGY72GZmfDh0+SmcwdHR07WwnjDQffv5iRNzjx\/tD9o60MGMtFZ92T4QkttPzzMxR87NK0hVlVHVUDfk3pKKsNNrS8l70\/Q8fP89ydTI3G\/72bVp3V+e4cWPl5GT1dLRepLzq6qYaG7HX8w+YH2lp6QEDBrDZGFlZWTU1NXl5+e+53CD6BSEhIVFRUVFRUa5nAtfh63eIRKKQkNB3vovOvyMInP4dU6T2n0LPP5X8gsLXr98sXeLb3U29dPmaoYFhZUW5grzs+LGjYx4lREVFhewNHjLYiK1USVW2vLTiQBXtgSraImSRwoovgkijpamxN3jXhw8ZtyKjRlqMmOvpsW3LpkdxcXt+308gENauDrpx83Zra1tfOopAIBCIfxM9bLym0ehnzp1f6OMtLi525+791LT0cWNGr1oVZDN+bHll1c5de44fPTRkELvtodKoX2oz2ymtnrbLOrsoH0peksiC3hJqqKuFHtjv4Tlv+LBh7m4uixYvKy4ulJOTL6+s0tRQMzI0SEp+OXO6Q1\/6ikAgEIh\/DT1YhdKysowPH+Z5zqbR6OYjzOIe3h07xkpjgIq8nOzmLdt8vBeMsRrFWaq+paa+uUZSTNon1G7lOTcJUdn8quzG1nrOnFwZMtgoePfODZs2EQjgctjZRYv86hsag0MOAgDmz5sbHx9P\/bZDH4FAIBC\/KD2Yn7vRD8daWUlLS+YXFG3ZvuvMuQtDTU3GWFm+eZtaWlrqvWAu15nusrr8mpaytKLnxU05eTWZeTWZVU3l9a3VgovlOG0qiSwcE\/uY0tH57OkTYTKpuqqqqLhMT1ero7M763NW73qJQCAQiH8Z\/MwPpaMzLS3NwcEew7Ck5Je5uXlxcY9Lyyo6O7vO\/nl+aYC\/lJQkZykMw5IyYzppHayJTR21GQWvBReLTCItC\/APvxTBZDDGjBkzfPgIPT39xOcvAAAzpju8TX0veFUIBAKB+BfCz\/wUFZdQ2inmI4YzGAwlRQV1dXUjI6MRw03zC4oKC4ucZk7nWuprfdnz7Iec6XEZtyhdvfDeZmdjTaczMj9lTZ5o87Wq6tWrlKh796lUmsmQIe9S33LuDkcgEAjELwQ\/81NZUaGorCwlKZGannnw0NH6hkZ1dXVJScmHsXEzpjuKinKPCHcnJYwsRNZSNGBN1JTVL63Je5X1hDWxvbMt4V3026znXG0JiSTkMcstKuqekaG+u8vM7u5uGWlpJsY00NdVUFCqrqntfWcRCAQC8W+B3863F6\/eWo8bAwAwG2YyfbrD3ahor3lzKJSO9+lpgYGBXItU1VfEpF5ZMnX7tZcnWNOH6oxSkFKNeHZ0wrBpwqS\/tur\/Eb0r4sURYZLISd\/osaaTOWuztLS8E3W3qrq2urZeVlbuc9bnW5HRXvM8REXFPmRkDHCw72OnEb8IfIJscoYKxcnIyCgoKFBTUxs9ejR8JSsnJ4dOpw8aNAge1tXV1dTUaGhoVFRUwECZ\/GNQssW0hZnZImzyipjJNVSloaFhXl4eWw2QlpaW8vJyDQ0N6IQU9D72JZ9QsLi6+Efg5RUmFYHoZ9i8ILA63Znl6ZWYlEyj0U6cOjt5mvPQEaPz8wuyv+TaTp7WTung6v9mR8TSdefmx765NXy5mLE\/wP9s12s+Tbtvv8Uo7t0dPLPvkanG\/mBwAPHqkxNca6PR6PbTnVLT38c\/SQpas8FrYcCBQ8cYDMatyLtRd+\/1r9MdxL8Q\/kE22UKFYhhWU1MDXZJATExM8vPzMQwbPXo0AAB6wcG+ObV8\/fo1+ObLhFcMSq4xbaEAbBEneUXM5BqqkmsNEOiK5urVq\/Cwt7Ev+YSCZVUXnwi8vMKkIhD9Dr\/Jt67ODhkZGSqNVvm1trSk2NHRUVlFpaWlWUpKWozbzFt+WfbzrIcLJq58mhndRf\/bvVVNW0VFfYmz5cLLz47TGTRo9sx1rQEAwiRRfVVTrgIQiQQNjYFlpeVGhnpFJWUNjY3lFZXd3VTNger1DS18JEf8N+ATZJMzVCiGYS4uLmlpaZGRkc3NzWFhYXl5edOnT6fRaM7OzgCAp0+fwmqTk5PNzMyGDh0KABAXFwe8Y1ByjWkLBYAF2UTljJjJNVQl1xpY68FDJ\/Q29iWv\/Gzq4hOBl1eYVASi3+FpfppbWplMppi4OElIyHTIoGHDzYqLS+h0el5+kZYW+4wBAIDBZMSm3Zw5ch5JSDi1MIntWybGTM6OmTjit8a22lefngIA8iuy7r4NAwB00zqP3NtCo3OPq62vq1tQVCIqKlpfV19QkDdk8CACkSAsLFJUUtLXLiN+GfgE2eQMFZqUlJSSkhIUFOTq6iojI+Pt7R0QEJCbmxsXF+fh4UEgEGJjYwEAlZWVmZmZ3t7erNFjecWgxLjFtOUadpZXxEyuoSq51gCBgdTgV72NfcknP5u6eEXg5RUmFYH4EfA0P03NLSQSSUpSsrOrKz4hPjcnZ4TZMAlx8faODlkZac78QkSh2TZLFk5Z+\/zjw4Y2Lq\/4fKn80EZpnm+3Mur1xYaW2qeZ0WWNBQAADGAfKlLSclK4imFspFdeUUEikeTk5Ts7OmLjHndQOsTExDM\/ZPS1y4hfBj5BNjlDhb59+xYAMGHCBLy4jY0NACAnJ0dLS2v8+PHJycltbW0PHz4UERGZN28erIf1P2cMSq4xbVmLsInKGTGTa6hKrjVA4BQZ\/N\/b2Jd88nOqi6sAfML1IhD9Ts++cISEhEaNGiUhIV5dXc1gML5WflVVVuaaU0VeTVhYJDb9BgNjcH7bSKl5lZPgZu2jqaC\/\/LjLhYR9rN\/eexvO9QGI\/O02sLW1RV1dXVtTC\/n3\/N8BD7K5Zs2asrKyR48eBQQEsMbTjIuLExISgqv0DAYDANDd3Y0Xh7f88OFg7ty5NBotISEhOjra1dVVXl4e1gOfb+B\/GIOyoaEBj0EJY9pGREQYGBiEh4dPmjQJrjXiRdhE5YyYiYeqdHBwCA0NvXTpEp4Z4\/3yAHz6wWNfXr58Gca+ZDKZXCuE8MnPqS7ALQIv1xr6MHD\/fuTk5AiInwHrfpaezQ+Dznj67PngQUa6ujoYwDQ0NKpqanhlbu9o85u4OcTjyjg9Bykx2RCPK\/ZDPWRFFTfOOB7icWWwurkQkbR61t7r215eWP5URvSvcLZDNUa\/zUmobqzgVa28nGzcgzvKqmrZOblUKvK4878CvPZ5enpmZWVFRUXBeNv49ff169cRERFPnjwJDQ0FAAwfPhwAcP\/+fbx4TEwM+PY8NGvWLGFh4QcPHiQlJfn6+uL1QKMF\/9Pp9OHDh2\/btu3s2bNdXV0wkUgkzp8\/\/9OnT3PmzMnMzPzy5QtrQTZR8aef6OhoGo3m6OgI0xUUFK5fv66hobFixYqysjKuNUC+fv0K89fX19+\/f19PT6+ioqKiosLAwKCysjI5OZlrhQAA\/vk51YXLjAeu5lXD947iv5Lm5uaftuD+v01zczM+CjzNj6SEBIPB6OzsJBCJomKisrLyjU0tdDpDTFSko6OTVykFGaVpY91nWs\/RH2AiKiw203rOIJ3hEsLSU0Y5z7SeY202Fc9JJgmTiH\/NfRtqDLUx\/e3J+2jOCnPzi5SVlLq7qU+eJjLotOHDhklKSnR3d+no6vflpEP8UsArI+3vLv7gIfw\/e\/ZsXV3dEydO0Gg0e3t7MzOzixcvbt++\/d27dzt37oyIiJg\/fz4MWiwrKzt16tQbN24oKyvDSTlYAzQYrP83b948fPjwrKwsKpVaXl7++PHjoqKi3NxcKpVKJBJVVFRYC7JJVVJSkpSUdOTIER8fHzMzM19fX1xaGRmZ48ePt7W1LVu2jGsNmZmZ6enpR48elZWVHTp06LVr16hU6v79+2\/cuHHjxg04Y3bz5k2uFQIAeszPpi48ETc\/vGrot+FEIP4OT\/OjpChPJBLbKRQRYbLZsKFv3ryq+lopTCYbGuiWlfN8TBEcMREJMvmv7T0q8mr+jltGD7LlzJaXX2hspF9XV3fi1LmRI0cONTUhEgnd3d0mQwZ\/vwyIfzldXV34fxw4vQYvnQQCYc6cOTU1Nffv3xcSEoqNjbWzs9uzZ4+lpeXvv\/\/u7+9\/\/vx5vOCMGTO6urpcXFwIBAJeD3z9hfW\/kJDQhQsXiERiZ2dnTEyMvb29np7ekCFDEhMTz5w5o6SkxFqQTar4+HhbW9vt27e7uro+efJEREQEpkNL4+zsbG1t\/fDhQxhHma0GR0dHCwuL8vLyS5cuiYqKXr16lUgk4ktZcEN5dHQ01wofPXrEPz+nunCZcfPDq4Y+Dh4C0RP8XjslC4u0t7USCEQxMVEFBaWiooK6ujoZGdmmpkYajU4m9xCsoYeGhUjSYnLNHfVEAlFeSlFVQUOVIxwqk4lVfq3U1tJsaW2j0xklRflDBhmQyeS6ujplRdnvaR3xS6CoqIhxLJCwJQYHB8MNxAAAVVXVhISEysrK2tpaHR0dfJED4ufn5+fnx7UetjpNTU3xmTEHBwe2mLa8pOru7uaMmMmW+fnz5\/DD\/Pnz2Wp4\/\/59Z2fnwIED4b4DuJMCR05ODq+Ha4UODg6C5GdV18aNGzdu3Ih\/xadFBOJHwG\/tR1lZuai4lEQSCli88G7kNY9Zs169TVNUVBATFfmUJVD4OD4MUBzoPnbx8IHjxhlMmzlqAdc85RWV3V1diopKbe3tFEqbrd3E8ePGAQBS0z\/wcvmDQKirq5uZmbHZnj6jpaVlbm6ur6\/fY2BNYWFhGRkZWVlZQp8iZiorK2tpaX1nsFQE4heC37k+YfyYlFdvAAAtLW1Hjp28fvP2h8yPigryg4wHpaRw3yctOCQhkrioBFmILEwWERflHq09IyNDQ0NdUVHhxYuXVV8rN2\/ewqDTAQAtLS16emjtB4FAIH5h+JkfPT298vJySkenpKR4Vm7RKEurkpLS0rIKF5ffbt6O+geEC4u4Ot1xWmNjU+r7T95eXg+i7yopKVRUVnW0t+rr6f4DAiAQCES\/QKFQcnJyfrYU\/y74mR9dbS0REeFPn7KIRKKEKDn5eVJxcUl9ff0gY0NlJcXH8c\/4lJWXUjJSGg4AkJNQUpXRJAmROfMoy6iZ6ozUG8B9E8Hb1Pft7W1jrCzT0jNaW5sTk57n5HwBAGRnfzEwHoTmKBAIRL\/T2to6efJkfHbH29tbwFITJ060tbV1dXW9ffs21zxfvnzZuXNnP4nJ3rSNjY2Njc2DBw84RfLy8srKygIA0Gi0oKAgGxubOXPmUCiUhoaGJUuWsFZ15syZqVOnenh4lJeXw5Ta2lpvb2\/oB+RHwG\/7gIyMtKmpadLz56MtLfHJKNIAACAASURBVJx+m15aVqGrq62uri4mKrZooc\/JU6esrceIiYoCANra24uKSoYNNcHLutsucrSaDQCwN3cfYzRZTkqes37LQTYjjcZzXd7EMOyP02fcXF2kpaWUlZUGqqu1tLTYT51CIBBiHj1eMNeDswgCgUB8J62trUVFRYGBgampqUQi8eXLl\/hXTCaT111va2trS0tLampqeXn5kiVLysrK1qxZ02Op\/hK4paXlzZs34O9uLHCRnj596uTklJ+fDzfWJyUl5eTkEAiEzs7O9PR0PP+rV6\/u3r0bExOTkJCwdOnSBw8etLe3+\/n5ycjIwHfRfgQ96MX5txmPHsd3d3fbThhPIpOzs7M3bt5aUFg0ZZINgUCMfhDLxLB2CuXo8VPrNm1LfvH\/C0LSErKqCuoAAAlRyQGKGkQiF1cFQkQhMklYmCwCAIh9\/CT9fSaV9pc30sTnL0uKS+Z4uF+5eis8PGLd2lUH9u2VkpIsLa+kUNoMDQ37UwcIBALxDS0trWHDhkVEROApTCZz4cKFDg4OFhYWrOlsEAgETU3Ny5cvHzlyhFep9vZ2W1tbtk2GvYLJZDo4OLC9DEcikUgkEueeFwKBMHHiRPiOrbi4eFZWVmtrq7GxMae729jYWE9PTxKJZG9vn5qaCgCQlJSMjo4ePPgHvuLSg\/kx0NfT0tR8EBMHAHC0nywvL79ksZ+Bvi5RSGj3ru2HDh0uKSm7Gx1TWFQyZdLE9IwPiUkve+ulo7ub+uLVuzuRUT6+i7du211bV19VXbt9565tW7dQKB1Xr117\/fbdqtXrtLU0AAAPHsSMGzuGa5BvBAKB+H6YTOaePXtCQkLwF7Pu3LlDJpMfP378\/PnzrVu3sjp24kRRUREA0NHRwVmKRqN5enquX7\/e0tKyz+IRicTZs2ez+qstLCx0cnJycnLKzMxkzdnS0nL\/\/v2lS5fCd93c3Nzs7OxMTExCQ0M555xqa2vhZlECgUAmk7m65Oh3enh3R1xcbMli33XrN7u5\/ObjNdfCfASlo2PRkuXjx49f5OXp4+MTtHrtkUMHi4qKGhvr29o7nyQ8fZ+RsdjXR0AL0dzcErAiiEggLvbzzcnNsbWzZTAYa9dvsrWxmTxxQuzjpwcP7CspKWlqagQAtFM6nj59dv7cqX7oNwKBQPBAXV3dw8MDPsQAALKzs83NzQEAEhIS6urqNTU1nHECceh0Oo1GExcX5yxVWFjIYDBYQ1L1DS8vL9ZDbW3t8PBwAICUlNSJEydiYmIGDBiwZ8+e7u7usrIyFxeXSZMmAQAIBMKOHTuWLl3q7Oysrq4+fvx4AACeX0ZGhkKhwAqFhIT+GdeaPU9KmpsN09HRunTlOoZhzS0tq9estRw16urVKwCAxYu8hwwesmnLjiV+Cxf5+NTW1tDo9Jkzpm\/curO8oofpwq9VVZu27lq+an3g8mVNzc0qKkrr168bZWG2\/+BhCUmJbVs2FBWX\/b43pLi42NV5pu9CbwzDTp4+6\/Sbo4ICl2UkBAKB6EfWr19\/5coVeEXW1NT88uULAKCrq6u2tnbAgAEYhtXwcH25f\/9+GF+Ks5SxsfHy5ctZ333uG1VVVayH0I2srKyskJDQihUr4uLiwsLCAADKysrLly+fPHkynJSrq6sDACgpKdnY2MDPAAA8\/9ChQ+GUYG5uroGBwXdKKCA9mx9RUdE1q1edOnXma1W1laXFokW+GR8yS0pKPeb65OUXbt28Xl9PNzBoXWdX55mTRw0MDd+8eycnKztAVRkA8CLlbean7LKyisqv1bV19TW1dV9y8z98zN4fejQ3rzD5RUpBXl5jY9OmDesaGppGWYxYu34ThUIJCd71OSvHZ5Efpb391Jmz1TW1AIDsnLyXL1NmzXL\/4SpBIBD\/qxCJRLhTQFJScv369dA\/5uzZs798+fLbb79NnDhx7969ZDI5Pz8fPlJARERECgoKbG1tJ0yYUF1dffDgQc5SwsLCRCJxyZIlJBLpzz\/\/7LOEDAZDT08PnwDEBebVEZzr16+PHj3a3t4+JSXFy8uLLYOHh0d2dvbMmTN9fHwOHDgAAKBSqdOmTQsLCzt16hQehrF\/IbBNAkKnpGyZMAzbsev3tva2kODdAIC9+0OZGMjOyiKRhbdv2aijrfnHmT+fPHmyZvUqkyFDIu\/en+4weaCGWvaXvEsREa6uboePHhsxYoSwsMibt2\/cXZxpdHrw73t37tiWkPBsqKkJSVh46ZKFr16\/Oxh6yNTUdHXQiqLi0mdJybdv3\/bx8tbV1bIeP4ZOZwQGrV0dtHzYUC5xUaEf7x+hHQQC8Z+EQGC\/9OGw7lXDMAy\/tlAoFHFxcfxQwC1trKUYDAYeQfF7ZrfodDrr2g8vSTjT4fqTpKQkrwwdHR1cg\/D2I6yaF8hvG4FAWLNqpfuceddu3PZa4Ll7x5bYx8+Snierq6mfvXDJ+TfHlcsDTIcM2R28d9zYMSuW+auqqLS1U\/buO9BOoXR2dubk5MhKS+obGBXk5RKJxK7OzkGDhyQ9fxHg76ehpipEIu35ff\/j+PigwBXTHR2qq2t27N5bUlwweLBJUUmxj5ensLDwnxfOammqc7U9CAQC0Y+wXpFZ72vxqLKc2fjAWgo3Od+5ssIWJ5eXJJzpIiIieBx3rhl+tO1hQ6CnH8iXnDy\/JUv37N5lO2FsUUnZiqB1RAKQEBejM5l7dmwbZGxQW9dw8o8z96LvT5k8ce5cT3W1AQwGMy8vl8EESc+T9fUNJMVF8woKp0+zl5aW0hyonl9QfPX69Xv3HkyZPHHF8qWqKsqnz118FPe4orx8w4b1mZmf9u7ZRiaTIqOiU1JSQg\/sExLirmX09INAIHoFn6cfxA+FVfM8zU9jU\/PigMCxVpZeC+bKy\/3lvTHhadLOXbuD9+y2nTAOALBu43ZDQ4NbtyOXL1tKBMwRI8zU1VRr6xqu3bj14MHDltbW8WPHDB1qqqo6QF5eXkpaqqurq6amtramOvvLl2eJzyXExR3sp86bO1tdbUBuXkHyi5RrN24OHmzy7t3rFcuWLpg3BwBw+050WHh4+MU\/lZUUcSEfxDyiUDpnz3LB+4PMDwKBEBxkfn4WApkfAMCVa7d27tptYmJyYF+woYF+VXVNeMQ1bS3Ns+fO7dy+3WbCWCqVFhZxNfpBLJ1OI2CMO7euS0pKwEraKZTa2rqXr97l5uW2NjfWNzTBaF2qyopiElKGhkYTxlupqqpKSUpAy9HZ1XU3OvbIkUP6+obHjhyUkpQQExOLjLp\/6syZVStXkkkE+6lTAABNTc0HDx9PTHz659kzJkMG4f1B5geB+JeAYdiff\/45b968f3gmhxUmkxkaGurv7y8tLc01AzI\/Pwt+5ofJZObmFbS0tNBoVEpH1+Ejx0ZZjk5OTjpz6uSmzduam5u0tXXGjhlz+cplf\/8lHm7OABCev0j54\/QZ34U+9lMm8mqyqbmV0tEhKSEuK8P9bAAAtLa1Hz\/5x\/y5nhrqahgG\/rwQHnknynfRothHsVVVVdMcpqwOWrlj914xMYnPnzOPHDpYWlqqpqauoqxEIgkh8\/NTaGpqotPpioqK\/wH9M5lMBoNBJnNxTvhvbut7huBHDB+DwViwYEFUVFRaWhqMMwv50eplqz8vL8\/MzExDQ+PJkycDBw7kzP+zzA+FQikvLzc2Nv7nm\/6XwKp59tUUBoN5+dqthX4B92Piox8+olKpTjMd9XR03Nw9TE1Nrl25pKKiHJ+Q4L\/E\/+y5P\/eHHmlobLSdMO70iWOTJ3KJVYpTV1cXF\/+Mj+0BAIiJii4L8NccqFFbV791x67o+w8C\/JfcvHVTQ0MjIvxiecXXufO9W5qb7Wyt29o7rt64ExP3NHDV2vLKH+WP6FfH2dlZW1sb7qHkpKamRvsbbC5AYEFNTc0BAwZoaGiMGTPmyJEjrCFHGQzG0aNHdXV15eXllZWVVVVVN2\/ejGeAxQcOHKiqqjpw4EBLS8vg4OCOjg4BBYDFbW1tWa8OI0eO1NbWLi4u5trHvXv34imRkZHa2tqsFz7+zbW3t+\/YsUNXV1dERERYWFhCQmL16tVcK+evT0FU19u28MPXr19ra2vr6up++vRJkCHgL22PZSFv3ryZPXu2mpoaiUQSFhbW1tbGX0vkVDvOnj17rl27dv36dTgEvLrs7u6uzY2ZM2fy0gZXrfKq39DQ8OHDh0VFRW5ubng4V0Fwd3e3+YatrW1TU5PgZQXhRzge5e8Y9MWLF9bW1tXV1XhKQ0PDwoULLSws\/Pz88B8mm79RtjrpdPrWrVunTp06Z86cxsbGfhMd+ztMJrOrq3vpitXbdwV3dXWXlJZX19TOcHJfs35LV1cXg8FobWvbd+DwmPG2N27dnTPPZ7qT2\/MXr7q7uxm8uRl5123W7MGmw7fv2F1RWcUnZ2dnV2xcwiT76UsCVly9ccdqvO2JP850dHYyGIz2doqPb8B8b7+q6trKqmoKpWPjlp2JSckMBoPJZGIIDmDU5F27dnH99uzZswAABQUFAMCmTZs4CxobGzs5OVlZWcFb4+nTp8NvGQwGfKuOTCbb2tqOGjUKZhgzZkxHRwdefNCgQU5OTuPGjYPfzp07V0ABbG3\/uo+5dOkSnqihoQEAqKio4NrHzZs34ylXr14F32KMCtKco6MjAEBeXt7BwcHe3t7IyGjLli2slW\/dulUQfQqiut62Bb\/t6uoyNTVlbbrHIeAjrSBlMQwLCQmB6WJiYpqamtLS0rKysmzdxKXFycvLI5PJbm5uPap38uTJurq6pqamSkpKcFwGDx6spaU1Y8YMXtrgqlU+KsUwDJqi06dPc44U56UPAn0WGBkZNTc30+l0PJ1KpXJqEv9Mo9FYv2I7ZC2bmprq4eHBtem+0dbWNnPmzPnz5584cYLzWxqNZmtra25unp+fjycWFhamp6dTqVRHR8dTp05hGJaSkjJlyhQajRYbGzt9+nTOOi9cuODv749h2MmTJ5cvX\/49ArNqnov5YTAYrW3tk+xnvH6TWl\/f4OLuuXL1elYjQaPR4xOeDTIdsXf\/ofNhl0dajfdfGpidk8fLqDQ3t9pMsldQHhAZdZ+P7Xmf8dFzno+13dSrN+7s3B0yYuSYhKdJNBqN1Th5LVzsu2R5U1Pzk2dJm7ftgunI\/HBl8uTJAIC9e\/dy\/dba2ppMJh8+fBgAYGhoyPrV1KlTAQDnz5+Hh7du3YL2oK6uDsOwkJAQeH3\/9OkTzBAfHy8qKgoAWL16NV48LCwMfnvhwgUAgIyMjIACODo6kkgkcXFxJSWl+vp6mKinpwcAwA\/ZRN29ezeecufOHQCAhoaGIM3h736XlJTgOfGLjr29PQAgODhYEH32qLpetcXar5UrVwIAZs+ejZ\/nPQ4BH2kFKQtDBpDJ5LNnz+KXzurqarwSNmlx4MuJb968EUS9kBUrVgAA\/Pz8WBO5aoNTq9CnAJ\/6a2trSSTSoEGDMA54mR+IkZFRW1sb\/Pzly5epU6c6OzuPHTu2tbU1IyPDwcHB0dHRxMTk+vXrtbW1kyZNcnd3V1RUPHDgANshW1msP8wPg8Gwt7dnM4chISFczc+hQ4cuXrw4ceJEVvODExgYePLkSQzDtmzZEh4ejmEYk8lUUVHhrHPNmjWXL1\/GMKysrMzc3Px75GfVPPetzBLiYiuWBRw6cuzoyTPFxUXbt25i\/ZZIJEy0mxD\/6GFBQUF4+KXFfou1dXS9fXzne\/vFxiVQKOzTLAAAD3f306fPSEtLcX7V3NJ6L\/qh40zXVWvWjrK0nOfpeerU6eqamkcPo+1sxrPuTBcWJu\/fG5yennbk+OmwsIjFvgu5Co+AwHcL2F4RgBQVFb148WLSpEmenp5EIjEvLy8jI4OtIP5UPnHiX0t6TCaTRqPB+Zzt27ebmPwVX2Py5MmBgYEAgDNnznR3d7MVt7CwAN8eOwQRQEhIiMFgeHp61tXVwWoBAPBlBc6+wLZY36LgTOHTHB4\/mzVQCl4Wnnts72pw1acgqutDW0JCQpGRkceOHZs0aVJ4eDi86xdkCHhJK0hZDMPWr18PAAgKClq8eDG+mqKiooLXwyYtzu3bt9XU1EaNGgUP+XcZAiVkewGFqzY4tYr3jlf90MHMly9fKisrQV\/R1dWNjY2NiooaNmzYixcv6HR6TU3NnTt3oqOjT548GR0dPWPGjFu3bllbW7u4uLAdspXtswyscLoc5UV1dfXjx495hSxqaGiIjY11c3MDAvgbnTBhwokTJ65fv378+PH29vbv7cM3eL45NXWynZGRYWbmR1lZuTXrNrZzGBW1ASrHj4Zu3rQh7tGj169fL1q00HL06CtXr\/3mMmtZ4Jo7UfdS0z\/U1TcAAMQlxBb5LHD5zdF6\/BhYtqy8MjUt4+btO75LVrjPnnv\/YYyzs7Obm9vj+PjEpMTt2zYfDg1RVGT37Vbf0Bi0Zp2IqFhuXp73As+BGmr9pYX\/JPA3zHVVGd7puLm5qaiojB07FgBw\/fp1\/Fv8xWx4ePHiRQCAiYmJsrJyWloanA13d\/+b96M5c+YAADo6Oj59+sRavL29\/fDhwwQCYdeuXQIKICQkhGHY0qVLJSQkrl27FhMTA76ZH87rHUyJj4\/f+I3Lly9z5uTVnLS09LRp0wAAK1asMDU1DQ8PZ10nYLNkfPQpiOp61Rb8cP\/+\/fnz5w8ZMuT+\/fv424KCDAEvaQUpm5GRAdfY+Lgm42rjKysrKysrLSws8Eb5dxnCVZ9ctcGpVX19\/R7rHzlyJADg\/fv3vPrSI21tbb6+vosWLUpOToYm0MDAQERERE1NraWlRU9P7+bNm+fOnSsvL1dXV2c75CzbL3h5efE6D0+cOGFvb+\/j4wMA2LFjx4QJEx4\/ftzQ0PDy5cvjx4\/jX1Gp1NmzZ4eGhsK7CnFxcf7+RmfMmAGn6aZMmaKsrNxfHeFpfshk8sb1q91dncXERJOTkwOWBZaVV7DlERMVnTrZ7tyZP+bP9YyPj49\/HKelpbNg\/jxdXd24hGf7Dxxc7L9s1px5ixYv8\/VfvnDxssUBgd6+Ae4enkuXrww9fCQx6eXgwYO85s+Xk1O4ezfq9es3ywKWnP7j2CS7CSLf7psgGIaVlJavWbep6mvFKIsR2zavt7Pjt9MBAb79sDlPUyaTGR4eTiaT4RoAvP25ceMGhm9HIRIBABEREU5OToaGhuvWrVNSUoJODCsqKgAAJBJJVVWVtU4tLS34obW1FRb\/\/fffDQwMlJSUbt++HR8fP2\/ePAEFgMXl5eV3794NAFi6dGlHRwfrq9qcfXz+\/Pn+b8DJN9Ze828uIiLCwcEBAPD582cfHx9TU1M8IjLbFZyXPlnho7petQUP379\/39XVlZWVdeLECbwJQYaAl7SClC0qKmJLBAC8efPmzJkzULec0kIKCgoAAPr6+qyJfLoM4apPrtrgqtUe6x8wYAAAoL6+nrMVAQkLCxsyZMiFCxfwVUkcDMPevHkzY8YMTU3NhIQEUVFRtkM+Zb8HNpejrLC6HJ0yZYqwsPDnz58pFEpeXp6\/vz\/8isFgzJ0718PD47fffoOlBPE3am5u7unpmZ6eDtfb+gV+T3DiYmJz57jPnDGtsKgk8k6U\/9LA4N07hg01YbONsrLSzk7Tx44dnZOb9+xZUsSVKzJSUto6OsbGxirKysLCJDghI0QUYjDoDAZTVEyUQumqr68rKSlOfPaMSqfZ2Uxwd9tiPmIYmdsTJZ3OePXm3dFjJ1avChw9ykKQp04EAID1as5KfHx8eXm5pKQkvOdtaWkBAJSXl8MdMuDbbWZpaSmDwTAyMgoMDPT29oZ+oqAZoNPptbW1rDdB+L4aFRUVWFxFRUVbW7utra2mpmbdunUpKSn4WyD8BYDFqVTqypUrb9++\/ebNm3379kHPJZyhpGDQrYCAgIUL\/5qJTUpKWrduHWtO\/s0pKCjExsYmJibu27cvPj4+JyfHxcUlMzMTn4LAq+KlT1b4qA4AIHhb8HDXrl0dHR3BwcGbNm2ysLCws7MTcAh4SStIWfwuuKKiQldXF35++vTp1q1bLS0tXV1dcfHYhgN655SRkWFN5NNl1p6yVcVVG1y12mP9YmJiAAA8co+AsLrjtLKy8vf3f\/\/+fWlpqY2NDYFAwK0jkUgcPHjwli1b3r17t3Pnzp07d7IdspXFS\/VKGDYYDIaenl5TUxMcTSqV6uTkVFhYKCQkVFBQcPToUTwnHCwAwOPHj319ffG50Fu3bsXFxVVVVYWHhw8dOvTUqVMeHh7Xr1+fOXNmfX39H3\/8wVlnYmLi8ePHOzs75eTkLl269D3y\/w22dSG49YArF8OvWIwe98eZ8xRKB8fmghbP+Qv9lwZ+ycnv7qa+\/\/DpyvWbW7btdPzNbdRYWwsrG7ORY0eOHm82aqyFlc3ocXYzXTx2B4fcuBX5KSsH1rB0eWDa+0zORltaWg8eOjZ7rk9Obj4vwdDWA67ABVvOBUk48aKoqKj1DbjyDHe2YBgGJzQOHjzIWWdJSQk8bfCdBRC4pK+oqMhgMGDxffv2YRjW2NgIQ9Nu2LBBQAFmzJgBAMjOzsYwLDc3V0xMTFJSEvalsbGRTR7odZh160FkZCQAQEtLS\/D+4uATgOnp6bgeQkJC+OuTFT6q61Vb8DA4OJjJZMJ2Bw4c2NLSggk2BLykFaQsfEJiFQbDsPPnzwMArK2tWcVjzYBh2N27dwHfnYFsXYbArQeLFi1izclVGz1qlWv9MGYPXDZnhfPSxwqDZVcbhmFUKrWrq4vJZMJLDb67gUajubm5webu3r0bEBDAdshZFuPYfNEH2HbW9Vd+CoXC59vW1taurq5etcsV0OPWA654zZ9z5VLYs8QkN4+571L\/NpdaWFSclpYmLCoREXGJRBIqLy\/rpHSsXrXyftTN18lP3r58mvYm+U1KUtrr5Lcvn6Y8T7h7+9qSxb5NjY2VlX+d6w9jYlcGrSot+9v8XtKLVwsWLgaAGRF+zkBfV3BREeDbzSO8+8NpbGyMjo4GAMTFxZV8A87yR0ZGwqlzeLPJ9W0JLS0teA++detW+H4AAKC0tBTupwoKCiISibAgfC6Rk5PbuHEjAODUqVPwsaNHAViLGxoaHjhwoL29\/cmTJ1xFgtlY09mEF6S\/OLNmzYKPWW1tbXgleB6u+mSDj+rY4N8WfkggEM6dOychIVFeXr5hwwYBh4CXtIKUVVdXh3Mye\/fuxaNnysvLA5alfjZpIXDtms9LIWxdZtUY21o3W\/0CapVr\/V+\/fgUAsE029gjbAwqZTBYREcG9q+DTPyQSyc\/Pb9u2bZ6enjdv3ty4cSPbIWdZwG0Js7f0dgZIwPz8vVRISUnxmgPvM73rhoG+bvj5M3ejH67bsGH4cDP\/xb7GRgYEAuHO3Wgzs+EYo8vVzaujs+vDh49vUtPVNdQnT7R1dptdWlrq5ua+ddPa7bv2vn37liwscufmlbS0tJevU6MfPITvq2IYaG5p27Zz9x\/HDktIiH\/8nH3i5CkJcfHQ\/b9ra2l+5+Pq\/yZUKhUAcPr06Xv37tHp9K6urs7OzsmTJ1OpVGVl5REjRuA5p06deuLEifr6+qSkpEmTJsGZCl4Rhc+dO2dpaVlZWTl06FBXV1chIaHbt283NTXZ2dnB6yN8HxC\/WHh4eAQGBra1tUVERKxYseL69ev8BYCt429BLlu2LCoqKjExEXCbQoHmhzXuPew1Xpx\/c7Gxsdu3bx89erSKikpXV1dycjKFQlFRUYF7t2AleFVc9RkWFjZo0CC8Zj6qa21ttba2FrAt+AG2qKmpuW3bto0bN549e9bLy2v06NE9DgEfaQUpe\/r06Q8fPpSWllpaWs6aNcvY2Pjz5894nZzSQoyMjAAA+IuxPXaZs6dsiXj9vLQqSP0fP34kEAgw6uiPYMqUKVOmTMEPNTU1WQ8RPcD2ZMRn8g2HTqdXVHwN3hc6ccq05SvXJL949TTxRUFhMfy2vKLSd8kK\/2Uryyu+MhiMh48SvHwWVdfUMhiMVes2zXSZPczCqr29vbm5ZeuOPQsXL2tqamYwGJ4L\/LKyc54nv4p7\/GTpitXeC\/3epaZ1dnb2KAyafOMF13jy8Crs5OTEmhN\/tTswMBAvuHHjRl415+XlsS6lioqKBgUF4Q\/msDjrq6Bz584FAJiammIYNm7cOP4CwOJJSUn4t7m5ufCGMScnh00SuK9pzZo1eArcFiUhIQEP+Tfn4uLCph9zc\/P379+zdgSvnKs+4SQhm865qg5a0F61hR92dXXBJfQxY8YIMgT8pe2xLIZhNTU1vr6+UlJSrNnwd4fZxMPR1dUVFRVtbm4WpMsQeG64urpyqpFNG5xa7bF+CoUiJibG9T0VwHfyDfHjYNV8LwIucFJYVBITGxefkCAlJW0zwdrO1lpdXS0jI3Pn7j3Dhg4N+X0PmUyKjXv6JCHu8KGDAIAdu\/cx6F2uLi7Dh5nW1TcuCVgmKiq2bu0qAz3d9x8+pqW9zy\/Il5aRmTFtitXo0YI\/YCKXoz+FsrKyvLw8MTGxYcOG4avrvxw1NTWFhYWtra2ioqL6+vrQvcKv0tb3DIEgZel0enFxcWtrq5yc3MCBA3v02BYcHLxt27ZDhw7hzoR+tHr513\/27Fl\/f\/9z585xbiJHLkd\/FoJ6vBaQ5pbWV6\/fxj6Ke5\/xQUdroJHxIAtzC0UFOQMDPWEyubyyqri42GHqJADA8xevyWQhc7PhNDqdQqFUVHwtr\/j66fOnosICBhObOtluwoQJGuq9fpsHmR8E4t9AY2OjiYlJZ2fnhw8fWPdt\/xSamppMTU3l5eXT09M5DScyPz+LfjY\/OFQq7fmLV7m5OW\/fpWV9yaHTaCrKSsrKSlqa6sRv5gHDsIKi0tq6egKBOMF6rKy0pKGR8SQ7m+9xhYvMDwLxLyEpKcnBwUFHRycuLk5TU\/NnidHe3j5jxozM1o3cPQAABh5JREFUzMznz59Dj3ls8DI\/ra2tzs7OTCZzwIAB69evHz58OP+G3r59e\/78+T\/\/\/LPHxB9EQ0PDunXrPn78aGZmduzYsZ8Y5EJAejA\/\/dIGNGMlZZUVFZW1dfX\/3x6BMEBVdfQoMyKR2I82A5kfBOJfwqtXrxYvXnzv3j22V1D\/SZqbmydPnnzx4kWutgfwNj8VFRVOTk6pqalPnjxZunRpfn4+TGcymVw3QDGZzK6uLvyiT6fTSSQSW+IPpaioqLm52dTU1NnZ2dHRMSAg4B9o9Htg1Tz7+kp\/XcdhPXo6mno6P+0OCIFA\/POMGTPm06dPP\/eOUFZWNjU1tc\/FCQTC8OHD4X48JpO5ePHilpaWurq6w4cPjxgxwsnJaceOHWZmZpGRkY8fP6ZSqZcuXfry5UtAQICqqqqzs7ORkdGRI0f68\/VMFphMpqOj4\/379+GMEf5qsJ6eHud72f9y0IZmBALRz\/zSsxF5eXkTJ060srKC9iM6OlpBQeH27dsnT54MDg4GADg7O1+7dg0AcO3atQkTJsAd4YmJiTY2Njdu3PDw8KDT6bzeW\/h+uLocZfUf+guBzA8CgUD8P4aGhjExMVZWVrm5uQCA7OzspKSkefPmhYSEwCilLi4uDx8+bGlpKS0txeOWzp8\/H3rW+fjx44+WkM3lKJv\/0F8I5D8NgUAg\/oaoqGhISIidnZ2fn5+Ghoa1tfXBgwfxb6WkpIYPH75x40bcqRpMDAsLe\/Hixa5duzZt2sSt1n6jqqoKvgcGAGBw+A\/9hUDmB4FAIP4CdzaqoaFhZGT07NkzDw+Pmzdvurm5kclkGxubJUuWAADmz58\/c+bMgoKChoYGmP\/48eMpKSn19fWLFi36fr+ifGD83eUop\/\/QH9TujwBtfkcgEP9z8HnvB9\/kxmAw8A26FApFSEgIOquF0Gg0uPjPYDCgV462tjYRERHoWBpP\/BHA\/XU\/qPIfDb+N1wgEAvGfB712+rNg1TzaeoBAIBCInwAyPwgEAoH4CSDzg0AgEIifADI\/CAQC0QsoFEpOTs7PlkJQMAzLysr62VJwB5kfBAKB+IuGhga4tRoAUFVVtXLlSs48X7582blz5z8qFl9qa2u9vb2joqK4fkuhUGBQJV68ffuWNSBFQ0PDwoULLSws\/Pz8Ojo6+lnWv4PMDwKBQPxFZ2dneno6\/EyhUPBw4+DvQXVZ4UzHY4ezOmHjzNYvLtra29v9\/PyYTCYMK95jE2xiMBgMCwuLY8eO4SktLS3Lly9\/\/fp1VVXVD3Jbh\/Orbh5HIBCIf4acnJygoCBxcfHa2tpHjx7xSi8sLNy8eTORSMzPz\/f394+Li6uoqAgJCTE0NOSarbS0dMuWLbNnz+6VMGwuRyUlJaOjo\/ft28eWjUajubq6tre3Kykp8ZJ2w4YNMM46q6X5J32YIvODQCAQ\/09OTs7o0aMBAN3d3TIyMgAAXV3d2NhYIpG4bNmyFy9eKCsrw5yc6bW1tSkpKa9fv162bFlqaiqcprtz5w5btpqamlevXlVWVi5YsKC35oery1FO7t27p6amdubMmdevX8MoDJzSlpWVpaenZ2dnh4aGshWHPkw3b97cK9l6CzI\/CAQC8f8YGxu\/efMGAFBQUODr6wsAaGtrW7duHYFAePfuna2tLZ6TM11fX19ERERVVVVHR0dcXFxFRaWtrY0zm4GBgYiIiJqaWktLSx8k9PLy6jFPYWEhjJWHRzziFGPYsGFcgxL9Yz5M0doPAoFA8CMsLGzIkCEXLlxgtT180gUsDvoa3rOqqqrHPCoqKjBWXkFBQa+k\/Sd9mKKnHwQCgfgL3OUo62crKyt\/f\/\/379\/DkAq4R1Fe6awfCARCj9l6BZvLUSqV6uTkVFhYKCQkVFBQcPToUZjN1dX1zJkzv\/32m5KSkoSEhCDSQv5JH6bI8RECgfifQxCXo6yfaTQak8mE7kQJBALuUZRXOu4VFH7oMVuvELxUZ2enmJhYj9L+UAepbCCXowgE4n8a5HL0Z4FcjiIQCATiJ4PMDwKBQCB+Asj8IBAIBOIngMwPAoFAIH4CaOM1AoH4n0NWVhZG0Ub8w8jKyuKf\/w+7vNTpOBZk8AAAAABJRU5ErkJggg==\" width=\"571\" height=\"101\" \/><\/p>\r\n<table style=\"border-collapse: collapse; width: 100%; height: 90px;\" border=\"1\">\r\n<tbody>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 13.4298%; height: 18px;\">No. Reg<\/td>\r\n<td style=\"width: 30.6473%; height: 18px;\">{{nomordokumen}}<\/td>\r\n<td style=\"width: 30.9229%; height: 18px;\">Tanggal Pemeriksaan<\/td>\r\n<td style=\"width: 25%; height: 18px;\">{{tangglPemerikasaan}}<\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 13.4298%; height: 18px;\">Nama<\/td>\r\n<td style=\"width: 30.6473%; height: 18px;\">{{namaKlien}}<\/td>\r\n<td style=\"width: 30.9229%; height: 18px;\">Waktu Pemeriksaan<\/td>\r\n<td style=\"width: 25%; height: 18px;\">{{waktuPemerikasaan}}<\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 13.4298%; height: 18px;\">Pertemuan ke<\/td>\r\n<td style=\"width: 30.6473%; height: 18px;\">{{pertemuanKe}}<\/td>\r\n<td style=\"width: 30.9229%; height: 18px;\">Tempat Pemeriksaan<\/td>\r\n<td style=\"width: 25%; height: 18px;\">{{tempatPemeriksaan}}<\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 13.4298%; height: 18px;\">Kasus<\/td>\r\n<td style=\"width: 30.6473%; height: 18px;\">{{kasus}}<\/td>\r\n<td style=\"width: 30.9229%; height: 36px;\" rowspan=\"2\">Koordinator Psikologi<\/td>\r\n<td style=\"width: 25%; height: 36px;\" rowspan=\"2\">{{koordinatorPeikologi}}<\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 13.4298%; height: 18px;\">Pemeriksa<\/td>\r\n<td style=\"width: 30.6473%; height: 18px;\">{{pemeriksa}}<\/td>\r\n<\/tr>\r\n<\/tbody>\r\n<\/table>\r\n<p>&nbsp;<\/p>\r\n<table style=\"height: 456px; width: 100%; border-collapse: collapse; border-style: none;\" border=\"1\">\r\n<tbody>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 14.3526%; height: 18px;\" colspan=\"2\"><strong>Penampilan<\/strong><\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 14.3526%; height: 18px;\">Keadaan Kulit<\/td>\r\n<td style=\"border: 1px solid; border-collapse: collapse; height: 18px;\">\r\n<p>{{keadaanKulit}}<\/p>\r\n<p><span style=\"font-size: 10pt;\">(Bersih, Kotor, Penyakit Kulit, Luka \/ Bekas Luka)<\/span><\/p>\r\n<\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 14.3526%; height: 18px;\">Bentuk Tubuh<\/td>\r\n<td style=\"width: 19.4491%; height: 18px;\">\r\n<p>{{bentukTubuh}}<\/p>\r\n<p><span style=\"font-size: 10pt;\">(Gemuk, Sedang, Kurus)<\/span><\/p>\r\n<\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 14.3526%; height: 18px;\">Tinggi Badan<\/td>\r\n<td style=\"width: 19.4491%; height: 18px;\">\r\n<p>{{tinggiBadan}}<\/p>\r\n<p><span style=\"font-size: 10pt;\">(Tinggi, Sedang, Pendek, Stunting)<\/span><\/p>\r\n<\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 14.3526%; height: 18px;\">Pakaian<\/td>\r\n<td style=\"width: 19.4491%; height: 18px;\">{{pakaian}}<br \/><span style=\"font-size: 10pt;\">(Rapi, Kotor, Srampangan, Sederhana, Serasi, Mewa, Bersih, Biasa)<\/span><\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 14.3526%; height: 18px;\" colspan=\"2\"><strong>Sikap<\/strong><\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 14.3526%; height: 18px;\">Tindakan<\/td>\r\n<td style=\"width: 19.4491%; height: 18px;\">\r\n<p>{{tindakan}}<\/p>\r\n<p>(Sopan, Tegas, Ramah, Garang, Percaya diri, Kaku, Sulit Fokus, Kurang tahu aturan, Ceroboh, Tertekan, Dibuat-buat, Ragu-ragu, Malu-malu, Kontak Mata, Tidak bisa diam)<\/p>\r\n<\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 14.3526%; height: 18px;\"><strong>Penyampaian<\/strong><\/td>\r\n<td style=\"width: 19.4491%; height: 18px;\">&nbsp;<\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 14.3526%; height: 18px;\">Ekspresi<\/td>\r\n<td style=\"width: 19.4491%; height: 18px;\">\r\n<p>{{expresi}}<\/p>\r\n<p><span style=\"font-size: 10pt;\">(Tertutup, Terbuka, Mudah, Hati-hati, Dingin \/ datar, Membatasi diri, Sukar mencari kata-kata, Tenang, Gugup, Takut, Lancar, Banyak gerak dan isyarat<\/span><\/p>\r\n<\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 14.3526%; height: 18px;\">Penggunaan Kata<\/td>\r\n<td style=\"width: 19.4491%; height: 18px;\">\r\n<p>{{penggunaanKata}}<\/p>\r\n<p><span style=\"font-size: 10pt;\">(Dengan tekanan suara, Terpengaruh bahasa daerah, Disertai istilah bahasa asing, Biasa)<\/span><\/p>\r\n<\/td>\r\n<\/tr>\r\n<tr style=\"height: 46px;\">\r\n<td style=\"width: 14.3526%; height: 46px;\" colspan=\"2\"><strong>Mood<\/strong><\/td>\r\n<\/tr>\r\n<tr style=\"height: 46px;\">\r\n<td style=\"width: 14.3526%; height: 46px;\">Afek<\/td>\r\n<td style=\"width: 19.4491%; height: 46px;\">\r\n<p>{{afek}}<\/p>\r\n<p><span style=\"font-size: 10pt;\">(Euthymic, Manik, Depresif)<\/span><\/p>\r\n<\/td>\r\n<\/tr>\r\n<tr style=\"height: 46px;\">\r\n<td style=\"width: 14.3526%; height: 46px;\">Ekspresi Afektif<\/td>\r\n<td style=\"width: 19.4491%; height: 46px;\">\r\n<p>{{ekspresi afektif}}<\/p>\r\n<p><span style=\"font-size: 10pt;\">(Normal, Terbatas, Tumpul, Datar)<\/span><\/p>\r\n<\/td>\r\n<\/tr>\r\n<tr style=\"height: 46px;\">\r\n<td style=\"width: 14.3526%; height: 46px;\">Kesesuaian<\/td>\r\n<td style=\"width: 19.4491%; height: 46px;\">\r\n<p>{{kesesuaian}}<\/p>\r\n<p><span style=\"font-size: 10pt;\">(Sesuai, Tidak Sesuai)<\/span><\/p>\r\n<\/td>\r\n<\/tr>\r\n<tr style=\"height: 46px;\">\r\n<td style=\"width: 14.3526%; height: 46px;\">Empati<\/td>\r\n<td style=\"width: 19.4491%; height: 46px;\">\r\n<p>{{empati}}<\/p>\r\n<p><span style=\"font-size: 10pt;\">(Bisa, Tidak Bisa)<\/span><\/p>\r\n<\/td>\r\n<\/tr>\r\n<tr style=\"height: 46px;\">\r\n<td style=\"width: 14.3526%; height: 46px;\"><strong>Symtomps<\/strong><\/td>\r\n<td style=\"width: 19.4491%; height: 46px;\">\r\n<p>{{symtomps}}<\/p>\r\n<\/td>\r\n<\/tr>\r\n<\/tbody>\r\n<\/table>\r\n<p><strong>(T)opics<\/strong><\/p>\r\n<table style=\"border-collapse: collapse; width: 100%;\" border=\"1\">\r\n<tbody>\r\n<tr>\r\n<td style=\"width: 100%;\">{{topics}}<\/td>\r\n<\/tr>\r\n<\/tbody>\r\n<\/table>\r\n<p>&nbsp;<\/p>\r\n<p><strong>(I)ntervention:<\/strong><\/p>\r\n<table style=\"border-collapse: collapse; width: 100%;\" border=\"1\">\r\n<tbody>\r\n<tr>\r\n<td style=\"width: 100%;\">{{intervention}}<\/td>\r\n<\/tr>\r\n<\/tbody>\r\n<\/table>\r\n<p>&nbsp;<\/p>\r\n<p><strong>(P)lans &amp; Progresses :<\/strong><\/p>\r\n<table style=\"border-collapse: collapse; width: 100%;\" border=\"1\">\r\n<tbody>\r\n<tr>\r\n<td style=\"width: 100%;\">{{plans}}<\/td>\r\n<\/tr>\r\n<\/tbody>\r\n<\/table>\r\n<p>&nbsp;<\/p>\r\n<p><strong>(S)pecial Issues :&nbsp;<\/strong><\/p>\r\n<table style=\"border-collapse: collapse; width: 100%;\" border=\"1\">\r\n<tbody>\r\n<tr>\r\n<td style=\"width: 100%;\">{{specialIssues}}<\/td>\r\n<\/tr>\r\n<\/tbody>\r\n<\/table>\r\n<p>&nbsp;<\/p>"',
                "created_by" => 4,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5)
            ],
            [
                "uuid" => '7adce2d4-78b8-4ccf-baf3-b4d62530cd42',
                "nama_template" => '[F-ADV-02] Konsultasi Hukum',
                "pemilik" => 'Advokat',
                "konten" => '"<p style=\"line-height: 1.3800000000000001; margin-left: 36pt; text-align: center; margin-top: 0pt; margin-bottom: 0pt;\"><img src=\"data:image\/png;base64,iVBORw0KGgoAAAANSUhEUgAAApQAAACnCAIAAAAg3FtBAAAACXBIWXMAAA7EAAAOxAGVKw4bAAAgAElEQVR4nOyddVxUW\/fw1wzD0DAgKdIgKWEgpYTdYGAr9rWu2GIjtiJgiwHYil7AQixABQQMEAQBpbubYYLz\/rH1PPMMMGDc37087\/7+MZ85O9Zee+9zzjq7KQRBAAaDwWAwmJ4D9Z9WAIPBYDAYzI+BjTcGg8FgMD0MbLwxGAwGg+lhYOONwWAwGEwPAxtvDAaDwWB6GNh4YzAYDAbTw8DGG4PBYDCYHgY23hgMBoPB9DCw8cZgMBgMpoeBjTcGg8FgMD0MbLwxGAwGg+lhYOONwWAwGEwPAxtvDAaDwWB6GNh4YzAYDAbTw8DGG4PBYDCYHgY23hgMBoPB9DCw8cZgMBgMpoeBjTcGg8FgMD0MbLwxGAwGg+lhYOONwWAwGEwPAxtvDAaDwWB6GNh4YzAYDAbTw8DGG4PBYDCYHgY23hgMBoPB9DCw8cZgMBgMpoeBjTcGg8FgMD0MbLwxGAwGg+lhYOONwWAwGEwPAxtvDAaDwWB6GNh4YzAYDAbTw8DGG4PBYDCYHgY23hgMBoPB9DBo5L+2tra\/OzEWi\/0pPTM7N7esrLSutrqkuLSssgp55ecXqKurof9mxgayveQH9h9k2s+QThemUCh\/t2IAQKXi7xgMBoPB9AwoBEGgf3+f8W5uYUZGxz58HJ6WmlxRVl7f2KigqCon10utj6qurg4Ko6HRJy+vEP3\/9Cm9pq62ldnS2lxHFaIa97PYvGGthnof6t9pxbHxxmAwGExP4W803k1NzcUlpZcu37x1+wazqV5OVs7QrP+oYSOmTR4vIy3ZHQlsDudC0I3nz158TEqob2iYNWPWqtXL5eV6SUlK\/PbmODbeGAwGg+kp\/C3Gu7ikLO5NfNj9hwmJicpKio729tZWNg72NnS68E\/LDL0fEZ\/wJjYmTlVNw3GI5ciRIzW+d7P\/FrDxxmAwGEyPgfgO93fAZLZevXln5NiJqpq6cxf8cf\/+46wv2e2DPXnx6k7Yo1P+AavcNya8\/bB46fLsnLwZs+euct949cZfSR\/TLgTeeBX7li9Wa2trZtbX0HsPp0yfN2zU2MVLllVV1\/4WtblcLvEjLFq0iCxAMTGxAQMG3Lx5E3kNHDgQAM6cOUMGfvToEQCYmpqiy0+fPk2bNk1VVZVGo0lJSdnZ2fFKvnTpEhI7aNAg5NLc3NxhxQkLC\/NGLCgoIL0oFIqqquqiRYuKi4sJgrhy5QpfXGlpaRRLR0cHAMLCwjrM5rx581D4jRs3IpeYmBjk8uHDB+RSXV1NoVDodHpJSUlnWUDo6uoCwJw5c0gXPz8\/ANizZ4\/gRAmCKCz8NqRy4cIF0tHFxQUAXr58SboILiveWkNMnDiRr+ioVKqSktKkSZM+fvyIZAqoawEK88oUERHR0tJatGhRVlYWGaDL+4REgAKo+ng5duwY8lqwYAFy4S3e48ePI8dZs2Z1KNzAwODQoUNk+M7k88YSFxc3NDQ8ePBgW1tbdzKOyM7ORmGEhITq6+sJgmhqamIwGADg4+NDBjMzMwOAu3fvki4aGhoo4sOHD4l2dOh79epVAKBQKLxqyMrKUqlUvui\/8hAhZGVlra2tQ0NDkZeAWHl5echFWFiYw+GQOvTq1Qu5Z2ZmClbpwYMHAKCkpMSbBUtLSwD466+\/SJdffB4JnuqmUCgMBsPOzs7f37\/9O\/MXC5\/kV94AnamBKsLMzAxdvnv3Dt2fOTk5nanx7+c\/E9Z+ncqqmgVLVka9eGw7ZFh8zGsVZQW+AId9zir0kg0MPJ+RmTXUfjgAJfzhX80t7Pv375v1Hxz3JqH\/AKujx3x0dPXeJsayWazdnvuCg+\/MmO46b9ZkKpVKo9F0tDV1tDXHjx2dkfF13qKlpv0HXr8caGdr\/Rtz0R3ExMQAYMiQITY2NllZWaGhoTNmzGhtbZ03bx6NRgMAYeH\/9DGIiooCgJCQEABUVFQ4OjqWl5dbWVkNHjy4oqKCr8X\/4MEDKSkpDofz7t27yspKeXl54vvDw+FwgoKCAGDevHlNTU3E9y4TXpXExMSWLFlCpVLDwsIuXrz46tWr1NRU5KWqqmpubo4Cy8rK8sZCGvLB5XLDw8MVFRXLy8sjIiIOHz4MADY2NsOGDXv+\/HlgYKCvry8A3Lp1iyCIFStWKCsrd5YF5C4uLg4AN27c8PDwMDIyAgA6nU7qICBRMi4A7N27d86cOSIiIh1GF1xWKKSpqama2rc+G1tbW9JdXFx86dKlwsLCERERYWFhiYmJBQUFVCpVQF0LUJiU6erq2tTU9OLFi4sXLwYHBz9\/\/hyZbcH3Sfua7VAB5OXo6EiWj4GBAfpTVVVFpVLb2tqSkpJIUQkJCUJCQlwut6WlhVe4vb29lZVVYWHhzZs3N2\/erKio6ObmRvq2l4\/cHRwcrK2ti4qKbt26tWXLFgaDsWzZsi4zTt4kAIDK7dmzZy4uLuLi4uvXr9+xY0dgYKC7uzsAfP78OTk5uX\/\/\/ugdDQApKSl5eXlkaY8dO5a3oDrzRcoTBLFz587r168jRzqdznvn8JbGzz1Ec+bMUVNTS0pKCg8PnzJlSnJysrGxsYBYVVVVAEClUtlsdlpaWr9+\/QDg69evVVVVvHUkQKX2t1CHd9GvPI+8GbSysjI0NPz8+fPr169fv34dGRlJFuZvKXzEL74BOlMDhSHLauvWrQCwc+dOTU3NDtXoGZBm\/FearZVV1afOXexrZDrEcfiFgGsNjU2k16e0jNy8go+p6X2N+jk4je1vaW9kamllN2LOwlVuS93lFFWMzSylZHutWLOlt5q6pZWt\/fDxjiMnDbYdvv\/wiX2HT+gYmPSzsBo90dX\/4tVrN25nZH4lJTc3t5y5EGhl57Bkufvbt+\/YHM6vZOGHPnk2bNgAACdPnkSXu3fvBoCRI0cSBGFnZwcAQUFBZODY2Fj4\/tl748YNAJg6dSrpi9oriIaGBjExsXHjxjk6OgJAYGAgb6KoWUmhUDpUqbGxEQCQsScIoqamBr0mYmNj0YuSN1ESCwsLAHjx4kV7r+fPnwOAl5cXuu9zc3OR+7t379AHeGNjI0EQJiYmCgoKNTU1XWZh8ODB6MWBCoogiIsXLwKAn59fl4miFxmKvn\/\/fuQ4d+5cAEhOTm6vfIdlxVdrfEUnJyeHLpuamuTk5AAAfZULqGsBCiOZqqqq6LK+vt7JyQkAjIyMUI0Lvk8EqM2rADKHqamp7Utg8ODBQ4YMoVAoCgoKKEUul6uoqIjUGDZsGK\/wc+fOocuFCxcCwLJly9BlZ\/JRrOPHj6PLgwcPAsD8+fO7k3HEkCFDZGRkduzYAQBubm5koamoqADA69evCYJYtWoV+R+Bwnt7ewOAlpYWn1ad+YaHh6Obh0KhxMTEIEc1NTVZWVk+CT\/3EKFSIrtqRo8eDQABAQHE98Zxh7GQVvb29ryVe\/LkSRqNNmTIEAB49eqVYJWePXvWvhxGjhwJPI3OX3weEai6z58\/jy7v3buHPg7Qh\/vvKnzEL74BOlMDVYSNjQ3SHwCsra15Ozx6Ir9hoDcrK3fdxi0nTp6aNX3mpQsXFsybIS4mCgCf0jIyv2SfvXDZ9\/hpTQ01ObleQjSqqmpvE1OzsoqSlpbm\/II8ZRX1ZmazklKf3Nw8YWE6gyHb1taWk5slIS3V2tr68NFDCXEpDpdtZGJ0+tSps\/4BK\/50J9MVEaEvXTDX\/+wZFSX5lWvW3b4byv37V7shUHOZbL6ghw1dtv8cRi7odicIAgASEhLS0tKQL+\/Mu7CwsJaWltGjR6MnMDQ0lDdRJKGzsXk+lRgMhomJCXJBXkwms30sJBNpyAf6znB2dh46dCivMv37958+fXptbe3169ejoqJSU1P37t2LOjwFZ0FISEhFRcXOzu7Jkyd3796F7x\/OvGXVWaJIz9GjR0tJSe3duzc\/P7\/D6ILLqrNyQO4sFgtdiouLi4qKSktLo74EAXUtQGE+mVJSUufOnaPRaGlpaWjoQfB90l69DhUQULPFxcUqKip6enoVFRWo8R0bG1teXj58+HAAqK2t7VBPZBi0tLR+qMTQt46+vn53Mg4AhYWFr1+\/Hj58OGoY3b9\/n8vlAoCEhMSuXbsA4PTp0w0NDUFBQTNnzkS9I4ibN28qKCisXLlSUlIyJycnOTmZV6vOfFGRTps2jSCIFStWoLTodHr7O+fnHqIuS6OzCgIAdNs8efIEOYaEhAwYMADVAqojASp12PLmu4t+8XnsMIMTJkxAVtPf358M8+uFj\/jFN0BnaqAsCAkJNTY2rl69Wk5O7vr16+2ftZ7FrxrvyOgYl2lT4uPjvQ8d3rxprbamGgDU1jVEv0p4\/\/79\/oPeixfMiYqOTP+c6TRsVEtLS8D5k9OnTaELizQ2NtoPGbpj27bYqGevoiICzh+Pev7shJ\/P3ZtBE8e7SIhLpKalZX7+ON9toZioiISIuKam6ob1az+lfmxsbNq2c+8h71NIAWPDvh5bNuzasePwoaPjJk771fLoHqjWORwOuvz06RMAGBsbk1689xOvgRw9erSCgkJ+fn6\/fv2mTZv28eNHXrGoW2ncuHFjxowBgIiIiKamJtJX8AR7PpVaW1u\/fPlCoVCMjIyQF3ps+ED3dHvJLBbr7t276urqJiYmSBn0eCN27dpFoVAuX74cEBDQr1+\/xYsXdycLQkJC1dXVqOG4du3apqYm1PdFpi4gUfLTZ82aNc3NzahblS86Lx06dlYOZNHl5OQkJCQsWbKksrLyzJkzvD2QHdZ1lwqz2WwyFV1dXTSCiypd8H3SoXrtFegsR1wut6SkRFJSEr0BUevn7t27dDodvcRramp4hVdUVKSlpV28eNHf39\/Ozm758uXdKbHKysqMjIzbt297enpaW1uvXLmyOxkHgBs3bhAEMW7cOEtLy169elVVVUVHRyOvhQsXqqur\/\/XXXwEBASwW69ChQ6ScxMTErKysMWPGiIiIoE8Q3ntSgC9SqX\/\/\/nZ2dsnJyadOnQIAERGR9jfJzz1EyKuwsDAlJcXHxyc4OHjlypXW1tYCChAA0GA2um1evHjBYrFQOTg5OaEuYlRHXarEZwX57qJfeR75ZPLW6ZQpU4CnQn9L4cMvvwG6VIPNZi9btqy0tDQ4OLhnd5gjyDb4T3Q133sQrm9iMWz0hK\/ZeciFxWYHh9wfYGlnYmphaGqpZ2j+Ke2znePYgCvX375LmTV3fn1DY\/flf\/789XPGF\/cN28wH2IwcO3m8y4xR412379rfS0l12qxFG7d6RUbFslgsFPhtUoqVncP0OQtKSkp+Ii8\/1F+xbds2AFi\/fn1SUtKJEyekpaXFxcXT09MJgkD3HO+EETQ5wtHREV0mJyebmpqiwqdSqUeOHEHuFRUVNBrN2NgYXaqqqsJ\/d0yhh0dISKhDlZAvjUbLzMx89uwZUmPBggUEQTx9+pSv0hMTE1GswYMHw3\/3TCLQB+\/KlSsJgsjKykKqklPSCIIYMWIEjUaTl5e\/du0a6Sg4C0OHDu3VqxdBEOPHjweA7du3h4WFAc+kLQGJoqUQU6ZMaWhoQD2rz549W7t2LQCgYu+wNPjKCtUaiYSEBG9gXg4fPswXq8O6FqAwkkkmgZg4cSIA+Pr6Et24T7qjAG+rFADGjRuHoiDDsGbNGlTCQ4YMIQhCQ0NjxIgRyIucNsVXJnQ6ff369ZWVlci3M\/l8sbS1tUtLS3kLU0DGCYIwNzenUqkoyuzZswFg+fLlZOB9+\/YBgLKy8pIlS3iFoPd1cHAwQRDnz58HAENDw+74vnjxAgBOnDiRkJCARnwqKystLCz4pnoRP\/sQ8ZXSpEmTWCwW8hIQC03OqKmpQUNXz58\/DwgIAICYmBjkheYGClApPj4e2s1wnDBhAgBER0cTv\/w88t2B5JuKIIj3798DAIPB+I2FT\/zyG0CAGrwVIS0tHRUV1T71HsfPT1i7dTvUc99eBwf7Xdu2KCkqAMCn9EwVZaUPHz5ISjOuBAbMXbhYUkJ+y\/Y9srIMI0MDC3OjK4GXyOg1tXXZOfmFxcWtra1139sBkhKS4lKSsrKyetqaKsqKenqaAOB9aE\/0y7jkj0mV1dVxbxKu3bgqIipqY2UZfDektqYq4V3iBvdVAGDRz+hKYMDRY36r3dedPXWCnBjyd8DlcgHA29sbDa4MGDDg1KlTaC6PhIQEAPBOe0afupKS35a2m5qaJiUlBQcH7969Oz09ffPmzcOGDbOwsLh9+zaHw6FQKGiECX19371719XVlTfRzlb0IV8Oh9O3b1+kxsaNG9F7EHmpqqqi0TgAUFD4NpeQIAjoqCv+2rVrAJCdnY2UERUVZTKZISEhZJts+vTpT58+bWlpIdUDAMFZ4HK56E10\/PjxFy9eeHt7oweMzJGARFEW2Gy2pKSkj4\/PjBkzNm7ciDpdOyyQDssKOQ4cOBA1BMlpesidSqXevXs3MzPTy8tr06ZNRkZG48aNA4F13R2FeRVAPaXok7\/L+4RP7Q4VQF4TJkxQVFQEAJQvAECditLS0iNGjBAXF3\/z5k1CQkJeXt6WLVukpKQAoL6+ns1mCwsLIwmzZ8+eNGlSSUlJUFCQt7d3RETEhw8faDRaZ\/KR+6xZs8aOHXv16tXHjx87OzvHxMRQqdQuM56WlpaUlCQjI3PkyBEAKCkpAYCQkJCTJ0+i+3D69Onbtm0rLS0lJ8yjFG\/evAkAT58+ffPmTWVlJQCkp6enp6cbGhp26YtUGjRo0LJly86ePbtv3z4JCYn2d87PPUTIa\/\/+\/fLy8kePHg0LC9u2bRuaaSUgFqojKSkpZ2fnDx8+vHjxIiMjQ0VFxcrKKjg4GABQLgSo1P4W4ruLfvF55CsW3jrlrdDfVfjwa2+A7qhhYmLSv3\/\/y5cvT5o06cOHD+TwUE+FNOM\/1E69FHBNVU1r4ZJVlVXVyKW8omrMBOex450DrwZb2TkcPHpqoLXjjZt3U1I\/ZefksdlsFCzra+6eA8dcps4abG2rb2yqpqGjoW1gbG5lOsDWxMJaq6+xqoaOjr7RgEFWE1ymbd7h9frNfxaMtbQw33\/4EPUqZqjjqNi4N3qG5npGZv7ng+4\/fv4yNgGFKS0rX7xstY3tUDLFbvJDnzybNm0CgNmzZz9+\/PjLly+8XuhjcOfOnaQL+qB2d3fnE9La2orWdRw9epRo9\/2OkJSUbGlpQeHJ\/q4OVULPMJVKvXfvXkxMDJpijXj48CEAODk5tY81YMAA4GkNIOrr6zucf07OciIIIioqCgDMzc15IwrOgrW1NdkgQ92hyDqieU+CE21tbQWelh9qf6Do5EQhXjosq40bN0JHK2H4AqNpOyYmJuiys7oWrDCSyTtjLicnh0ajiYuLo8l93b9PBNxsgwYNgnZLZQiCQG8xtOhr6tSpADBr1iwhIaGysjLyFVxUVESWCbk8rLGxEWUqLS1NgHwUa\/fu3QRBsNlsbW1tALhz5053Ms7XaidB87MQqCO0traWdGnfhEV4eXl16RsREQHfG461tbXKysri4uKOjo7kFEWSn3uIUCmhxlxWVhaVSqXT6Wg1l4BYBgYGYmJiBEGkpqYCwPDhwxUVFVevXk0WEep4EKBSXV0dANDpdCaTSTqihVKo6H7leWxf3Z6enqQL6hvYunXrbyz8X3wDCFYDVcTQoUO5XO6IESMAwNbW9kdf+\/82fnjMmyCIB48i9uzzGmw99PxZP1mGTFtb29fs3JS0dEob5XPm1+07tgrTJY\/7Hp40ccLECWOMDA36qKrUNzTce\/jM1mG0jZ2d\/5kT5ZVVVraOm7dsz83OzM769PFdzIeEl8lvX39J\/5ifnXny+BmXqbPaCKHrVwImT3YZaONw4mxgdU0NhUIxMzUd2N98vtuCG8EPuNzWo0ePxiYmzpox7dL5c0g9BfleRw\/v66XY29LatqGh4Udz103Qd5yuru6oUaP41sKi+UTXrl1DS0GYTOaFCxcAAH16Nzc3k8NXdDodPWnCwsJ5eXmxsbF0Or2hoQFVTFlZGYVCaWxsJG9K7veRM8FtzQkTJtjY2JArK0gvcr4JL0gU37KNkJAQJpOJZmYibt++DQDR0dHV1dUoDLIBZF4AoMsscDgcMvy6devMzMzQWCxST3CiKCIZ\/fTp0xISErzROywNvrLqrBzIwOjPzJkzpaSkUlNT0QSrzupasMIoFkEQ6A+TyVy9ejWHw1m9ejWa3Cf4PmmvXoc3W2c5Qn3jqGU2efJkALh3756Dg4OioiKNRkPTfCoqKtpLaGxsRIWM4gouMRSSRqOhOepnz54lvQRkHM1IevLkCVluaJ1SSEgIEo7mAMN\/311o7BZZC8SKFSvIWIJ9eW8eGRmZEydONDc3R0dHt79zfu4h4i0NXV1dJycnFouFVlcLiFVQUIAK2djYWF9f\/82bN+Xl5ahNjNx5K6hDlaSlpU1NTVksFip5ALh\/\/35eXp6VlZWMjMwvPo\/tM0h+9kVGRl6+fJnBYKxevfo3Fv4vvgEEq0HWEZVKvXTpkpSUVExMzIkTJ9rXS0+CzGo3W6gxcQkmFpZL\/viztbWVy+W2MJnXrgebDbQ16281ZcYCFTWtiS7TV6xcGxP\/DoX\/lJ55\/PiZgVb2Bv36z52\/6MyFwJzcgm6mVVFefTM47E\/39RYDbYxMB3ntPRQX\/60h\/iLy9eFjpx1GTNDUM9LUMzp1NoDL5RYUfhvtrq2tn7dw6ay58yurqrqZ1o988Xy7LTw8PNp7sVgs1LuopKQ0duxYZJ6HDRuG1smcOXNGWlraysrKyckJtVcYDEZRURHqZOP7QkeDYYsWLUKX5eXlqMp4P7RJSN\/W1lY+L\/QMMBiMcTygcW4072nEiBGTvnPo0CHUGcXbQq2urkZdmleuXEEuaOmFnp4eGabLLKBZsuR6obi4ONTAOnDgAEEQghNFnWD29vakLzmVKS4uTkBp8JYVqjUdHR3ecqirq2tfdDNmzIDvK6Y6q2vBCpMyp0yZMmPGjN69e6PbgNRH8H3Ci4CbDZk9S0tLMjsrVqwgCOLPP\/8EgEuXLhEEUVtbi+Y0nT59GsWSkZEBgKdPn5LCbW1tt23btnjxYqSnq6urYPl8Kn3+\/BkAqFRqUVGR4IwnJCQAgJiYGG+9oE4IHR0ddIkWR8H3vgFUVsjw8\/YBoAFaAMjOzhbgm5+ff+fOHQDYtWsXX92JiIjwlefPPUSolCIiIlBIZEr19fUFxEIfwerq6igK6lxRUlJCte\/j44MqRbBKBEHcunULACgUio2NjYODg7CwMI1GQys\/f\/F55AVVt56e3ty5cx0dHVHXwoMHD7qsmh8q\/F95A3SpBqoIch3msWPHAEBSUrKwsLB9qfYUfsx4Z2Rk9x9sO2nyjPyCQuTS2trqMm2unpHZIGuHB4+fqmvrxcS+bWpq5nK59fWNp\/0vDba11zMyPeLtG5fwtrauvpumlBcmszX546eLAZcHWTuYmA\/cvntvQXEpl8stLSuPjH61YMkq5T4a8Ynvd+zZ7zhi9L1HT1CsvPxCF9fZR3xPdTOVHyo11GvUvocTUVFRsXTpUhUVFRqNpqqq6u7uTn78nj17VkdHR0xMDHnNmjULzbZAc1N37NjBKwdN3yWXzJJ7LaEdqfggfXk7GxHtt3kCgPv37xMdbaHl6uqKWmbPnz\/nFYLM\/OzZs9HlX3\/9BQAaGhpkgC6zgNIiRwEIgpg5cyZ6sOvr6wUninI3ePBg0qu1tRUNuUVGRgooDd6yar\/DGgA0NDSQgck+STT2Ji8vz2azO6zrbiqMEBMTMzc39\/b2JucxIQTcJ7wIuNnaV9+AAQMIgkCTga9fv46CWVlZAQDZ5Y4GsNE2bWSZCAkJ9erVy97e\/tSpU2w2W7B8FIt3Ayw9PT0A8PHxEZxxDw8P+D6BjgQN8QIA2oSL7N0hd79CXa80Go3X5KOGKSoZAb7nz59H9\/\/mzZtJ3\/T0dGSo+D6VfuUhIpdWk3uBffjwobNYKSkpANC3b18U5fHjx8Cz2dnp06cBwMDAQLBKiDt37lhaWoqJiYmLi9vZ2aFvMuLXnke+JMibBO0\/6OrqSi6tFlw13S\/8X3wDdFMNcoc1Foulrq4OPHsM9ER+wHjXNzROmTpbRU3z3ftU5HL\/4WMVNa3RE1w1dY2nuM4pr6gsKCzhcDhcLpfFYrm4zpOWk58+Z2lJaTnnv3dQefsl8eTjE4lZ8d034RwOh8Vibd15QFZB2dLWISc3H7lfunxLz9BcRU1LW99EUkY2\/Ek0GSUyKkZP3zjra0535P+DdYDBYDAYzA8hhNb5wfeJx53B4XADLl\/766+QkydPD7WzBIDKqpr5i\/7Q0e2b\/fWLppZ2S0vLqBFO6mqqra2s2NjESVOmNzfX7\/Hcu8NjLe8hYM2s5n2PvObcXf4o+\/n5t5dZLY22mjY0WtcHllAoFCqV6uRgO8TOIeFt4tFjvnKy8jo6WpYDzKQZ8uISEl8ysywGDDY1MTxw5LidzWAJcXENjT5tILxy5fJx48bKyXUx+fz\/5tRwDAaDwWB+ne4a75zcgh07PSdPcVm2aC4ApH3OOns+SFJc7P2Ht4sWLWBIy8xwndbfwrStre12cNi23Tt1dHQPH9o\/cpg93zKkl5mRS57vA9a3DYNe5ydYKprq9zbovsZqfXoPsbNrI+Co95EWJrufsZH14AG6Orqx8QkS4pJXr1yhCVP79NHoraJMpwubmRp\/zsqNT0hwcrDvbE8fBDbeGAwGg+kpdNd4b9rq2dhQt3P7FllZBrOVtdtrL5PJEZMQp9EoSckfgy6c6aunTaPRHjx8tnHLpmnTXI8c9NLS4D+yk8VmBb4NoDa0zDd1tVezslez6kWRet+QMtnYRYj6AzvVychIW1tZSkjJnTl7urSsasyo4QwZ6bLy6tdxsfZDHcrKyu8E35RTULEwM6bRaAMHmJ88fU5fV1tLS1OATGy8MRgMBtNT6NYmLa9jEiesn6UAACAASURBVO+F3N63b7+2lgZBEE+fRca+STTtZ1ZfW62upjl+nKmoqAiHw7kb+mjlquWurtPXu6+WkZZqL6eR2fC+MHWM8fBNo7YgF79wn4uZd4pqijQVNH9IbxE6\/Y\/Fc2VlpTw8PKhCtANe27dsWL1lw+oBg4c2NNS4r9s4d+bk2tp6aWlJZSXFxQvm7z3k4+Bgjy00BoPBYP4H6Hqdd2Nj86EjR4z6mblOmwwANTV1IfcfDho44GX082ZmS3NL0+zpLm1tbZHRr7du2zJ9+sztHptlGdIdimrlMgvrSiRF\/2sPqYLmuqrGyp9RnUqd6jxhzSr3mzcuX75yHS0BHDbMwf\/sWYehtseOn\/LY6VlWXkmlUkeNHE4TgrCHET+RCgaDwWAw\/za6Nt7PX7xMTnq3bfMW1Jg+4nv6TUzMxPETHoT9JSMjt8htnpSUZElJ2b79h0xN+3vt2q6o0KszUU2cprSa\/JSCVNIlOT+hvrWxnlnzc9oLCwsvWTL\/jz9W+fj5xie8A4AdHpuzs3PmL3ALunylpKQ4IfEtAPRWUZ400Xmdu3tne4tiMBgMBtOD6MJ4NzY2hT9+qG9oNmL4UACoqa2\/dfOqqZnFunXrDhw56X\/ad6idNUHAUd\/TtbV1B\/ftlpbm35mZl08FacBt9c8IC4y+VNdcExB9MagwEpprvjbm\/HQGJCXEt21Zq6dvtHXnnsbGJhERen1D0\/jxk9lsdnFRaVJKeiuLBQArli0Qpot5+5396YQwGAwGg\/mX0IXxLiwqehX7xmPjWgDgcLiiIvTz5y\/cvHrh4gV\/JQVJLrcNAB4\/eX7nzs01f67UbDdDjY8P+R8AYJ7J2FOJF+UOWVxJvTVDZzgAfMxPZbFbfzoPwjTa7h0eddUVZ88H0enC7quX7dq2bv68RQRQIl9EHvE5jYLt2LkzPu5VS0dn62IwGAwG04PowniH3X8sK8Poq68LAOmfM9dv3PLmTUJa5ldHe1u\/Y95Kir2qqms9vbzMLfpPdpnY5dnmz7MjAeDyuzvvy1OhpSY6L\/5m2n0AyCj9ymrjP5bxhzA1Npw8ZZqPr\/fH1M8AEP8u+fnzxzVVFRoafa5fu1xZVQMAkyeNKS2vfv065lcSwmAwGAzmH6cL430nJMR54ljV3soAoKWp0c+sf\/Cdu8McnTx27eNwuQAQcPnql8yMg157O5xezktWcVZsyccOvZ7lxzI5zR16dRNhYeGVy5fQaEJoR99BFv2qKmuGOgxvaGrV0taPi38HAGKiIpaWlmjD5F9JC4PBYDCYfxZBxjs1LbO0uEBX14BCobS0MI\/5nj556lR1VZmltbWdlaUQlVpWXhHz6tWESdOMjfUEJ9PW1nY1IRCgE6tJtN1NuPuzWfhGLznGqlVr33348Co2nkqlzpw1i8thGej3tbIc+DE1paWFSaFQxo8dEfnyDe45x\/wEV69epXxHWFhYT09v79696KTCxYsXk14SEhJGRkbokE0ybkVFxZ9\/\/qmuri4iIqKjo7N161by+A1zc3MKhTJv3jwy8KdPnygUiqioKIvFQpLR8U1FRUUoCXRoKWLy5MkUCuXVq1cA0NbW5ufnZ2ZmJiUlJSoqqqqqirYNLywsRBHRCWYd5khSUtLU1HTnzp3ooEmErq4uhUIJDQ1FlxMnTqRQKH\/88QeZZaRYe06ePEmhUKZNm8brqKmpidJ69OgRnw7m5ubo8v379yjvubm5ZJiAgAAUER2hy6ceQk5OzsbGBp1FER4eTumIkSNHknHnz5+PHNGhIBhMj0OQ8b589ZaKkpK19SAAoFKpJib6\/S3MVHqrmxgbDxrYn0KhpKR8yszK3rB2ZZfJFFQX+GaGCQhw9O3F+pb6H9Wej5XL3ETFJeLj4jkc7sRxo75m54T89dfjiIiXr15n5+QBgKKSUlpaCt\/x9RhMd0AHp2pra2\/cuHHBggVlZWU7duxYvnw56eXg4ODh4TF16tTs7OwtW7b4+\/ujiDk5OQMHDjxx4gSXyzUzMysoKDhw4ICdnR0yk8OHDwcAdNwWIikpCQAcHR3pdDqSjH7J4yDJjwYAQMc5oABeXl7u7u7FxcVOTk7Dhw8XExOTlJQEniNf+c5+RZeampoLFy4cOnRoZmaml5eXjY1NbW0tbwC0NWFcXNz9+\/eVlJT2799PevEJ5JPMezxzSkpKXl4eOhMFHSPRPgkA2Lp1KwDs3LkTnTmBePDggZSUlJiY2Lt379DpUrxx58yZ4+HhYWVlFRcXN2XKlE+fPikrKy9atGjRokXIWisrK8+ePdvZ2Rmd1QEAXC43PDy8vTIYTA9CkPGOeRmlraevpCgPAEnJaTFv3otLygKFUpRfKC4mCgB\/hT00MDJQU1MVnAa3jXvr47XGmlIBYbIrskISf7XxLS4utmDO3LCHD2tqa\/vqaQdfD5joPLGqqqqqsqa6tgYADPR0TPsZ1db+6lcC5v9DkCnq37\/\/4cOH\/f3979+\/DwA3btwgCAJ5TZ48ef\/+\/UFBQZ6engAQFxcHAARBzJgxIz8\/f\/HixXl5eQkJCZ8+fVJTU0tOTl6\/fj0ATJgwAQAyMjJKSkpQQtHR0QCAmq1IMvpFtkpeXj43NxedaQjfjTf6RUdlR0VFhYWFPXjw4MuXL+h0cNKI8lpT8tLW1vbixYuPHj1KSUnp3bt3WloasqBkADqd3tbWho4ZvXjxopycHJ9i7UH60Gj\/2QMK9QFs3rwZAFDR8SWB3CMiIqytrVEwRGNjY3h4+NChQ62srNra2h4+fMgXd9OmTfv373\/06NHo0aO5XG5iYqKFhcWFCxcuXLiADhwzNDS8evVqSEgIqhdUwhUVFatXrxYTE\/v48WNeXl6ntY7B\/Fvp1HiXV1QXlxb0txiILu+G3rtxPehl1IuWpqaZs2dLSkpwONzY2Djn8WO7HO3Or8q7lRKuKKUUPDMAaO2edrrESvM5IC6z+\/3psnp+A8\/msB+nhM+6MHvVtZXv8t4SRBcLta1tLctLyysrq2g02pNnz+\/cvikrJ29mZsqQlgEAGo2mpdX3+OkLgoVgMO1Bu\/S3tHzblt\/W1pZCoaBT7ZEXi8VCXsi86evrA8Dz588TEhIUFBR8fX2RMdPT00Om9\/Lly42NjXZ2dgoKCgDw7NkzFP3Zs2d0Ot3FxYVMFP2iCaGjR4+WkpLau3dvfn4+fDd7qOWKOuqvXbvGZn+b\/om2FCTPF+A7aIBPbT09PdSqDgoKQo5kuqdOnXr79u26devGjRvHG5dPIAnKKa\/xvnnzpoKCwsqVKyUlJXNycpKTk3nlCAkJNTY2rl69Wk5O7vr167xTX8PCwlpaWkaPHo2a0WQffnv9eYsdgeS0VxJ95Tg7Ow8dOpRPJgbTU+jUeL99n8xkMkcOd0CX691XLFv6B02I0qdPn1HDhwJAbNzblqY6NXWNLtN4+vlJUmX2qVGe9S21wGk33tzWZt138GbTGfmVheFpj\/j2UUktTp79cOOtzAdnkq9ueOhRx+yi0ayipKypqXEn5CEAyMjK6ejoi9DpCYnxu7y+ndze10D\/5rXALnXGYPhAlgBt5AcA6CB2fX19Go2GvCorKzMyMm7fvu3p6WltbY3OTn7x4gUAjBw5UkJCghTl7OxMo9HYbHZycrKQkNDkyZMB4MmTJwCQmZmZk5Mzfvx4WVlZMlHeX4Ig1qxZ09zcjJqVIiIi8N1Io4HzAwcO6OjonDhxguxa78yGIXfS0gMAOgi8ubn5y5cvZICEhIQtW7aMGTPm0KFDfHE7W2DC55uYmJiVlTVmzBgRERE0THD37l0+HZYtW1ZaWhocHMzbYQ4A169fB4Bx48aNGTMGACIiIpqamnjjFhYWpqSk+Pj4BAcHr1y5kuwbh04OLGCxWHfv3lVXVzcxMUEySWUwmB5Ep8Y7MzOTAIqxUV8AqK1rWPbH8uzcPA1t3dyvX1CA67fvqqr27mdsKDiB8rry5VFHZug7jjAeeTE+sIMQnJbw9OcrHf4EYfHglLCa5v\/abS27Lru2phj9f5n\/oYXdJDg5ZSWFfv0Mn0W9AAA1VdWa6ipbWxtFeUUW+9vnua6mFo1GI1\/BGEw3QcavqakpPT09ODjY1dUVADw8PEivgwcPGhgYTJ8+XUREJCQkRFpaGgBKS0sBQFlZmVcUjUZDA65o+gXqIX\/69ClBEOHh4QAwd+5c3kSREUK\/TCZz8+bNKioqISEhz58\/R8YbsWXLlu3bt4uIiBQUFPz5558DBgwoLCzkE9I+R7zGW1JSEqmNHFEADw+P5uZmcsS9vWLt4XNHBhgNEKC2+507d3jlvHnz5vr16yIiInxfA5WVlU+ePDE2NtbS0jIzM1NVVW1paSF7zlFcZ2dnU1PTdevWjR071sfHR4AaiPDw8JqaGl5lYmJiUDVhMD2ITo13Q2O9ah8tYRoNAFgs9mBbx4L8wsT416oa35raHz6809LW69VL0DnZbW1tvhHewCUWms1P\/JIYW5LcYbBrX1\/RhYUP2fzx+MurxPwEXq\/eosogzkD\/TeQ0RKkdj7GR0Gg0DU3twuwcgiAM+uqKiwn\/sXiulqa6HIPB5XIBoL+FMV2E3tyCJ5xjfgx0\/7x+\/drIyMjV1bW+vj4wMBA1dpHXrFmzrl69Onr06OzsbGdnZ9SHhBrcyIjyiqqoqAAAFRUVAHBwcFBQUCgrK0tNTX3y5ImcnNzYsWN5E0Wi0H82my0pKYms1MaNG5FNRQGEhIS8vLyysrJWrFghJCT06dMnNBucV0j7HPEa76ampvr6egqFoq6uTgbYtGmTvLz83bt3161bxxe3s\/2GkTvq0udyuTdv3gSAp0+fbtiw4fXr1wCQnp6enp5OyjExMZk3b159ff2kSZNycv6z3+Lt27c5HA6FQtmwYcOGDRtQZsmGMoq7f\/9+f3\/\/vn37hoWFbdu2rX0G+ZS8du0aAGRnZ2\/YsOHs2bOioqJtbW0hISEdZgSD+dfSqfGuKi8lu8Tfvk9+9OB+bm72sOFjjx7aDwAsFruwIFutj7pg6XFZrw99DHQzdBqoYxn0\/nKn4Zqrbr+5NWvgTJs+FnufHWlm\/Wc2uIKUspmsCvpv0tuAyel6Iza1PuotrU2fM7MlJMR09A3\/+HNTfmFxyqePr2LeogCKiqqZmdldysFgeEE2wNTU9MGDBx8+fMjPz58\/fz7yQkaib9++s2fPvn\/\/vra29ps3b5A9GDhwIAA8efKEdwlWaGgom81WUlIyMjICACEhIWdnZxTs5cuXrq6uyOyRktub8OnTp48ZM+bDhw9oajpyRKipqZ06dQo1bdE4OvIlCIJvh4P2xhvpbG1tjTrtUYDRo0ffuXOHSqWeOHHi8ePH7RVrT1lZGQDIy8sDQGRkJGrX+vv7e3t7BwUFoTDIBiMJcnJyAQEBI0aMqKurmzt3LmluUZM9NTXV29vb29s7KysLAB49esRkMsm4NjY2S5YsefjwIZVK9fPzI+f98WacdGloaEDT5cLDw5FMJAr3nGN6HB0b75YWZkNjoyzjW5NXTU2lf38LW7shRUVFCe8+AkB61tdWJlNbV0eA6Lrm2kvvggBoHvab8ypzr+a\/EhD4bPI1aTHGdJNJcaWfbsRcRY5sDvvM6zPJJZno8mbas5PPjneZJWUVJRFh4S\/ZeQDQp3efz6kfCwvybQZbaWn1QQHEJSVz8gsFysBg+EGWQFZWdty4cebm5rwdvMgLjcXQaLSFCxcCwNmzZwFg6tSpSkpKNTU1S5YsQZ3kubm5GzduBIDNmzeT49Bo2Pv8+fONjY2zZs3ik8wrnxzxOX36tISEBOpmRwHq6\/8zI0RPTw++T2QjTSyfreUz3oWFhTt27AAA9Mubrr29PZptvnTpUrRCXYDx5nK5aG75oEGD4LsB3rp1K\/GdFStWwPcPBTIJKpV66dIlKSmpmJiYEydOAEBeXl5sbCydTm9oaEARy8rKKBRKY2Pj06dP+YpFV1fXycmJxWJdunSpw9JDhISEMJlMGxsbUpnbt28DQHR0dHV1dfu8YDD\/Wjo23jW1daXllRYW33ZO6GdkYGdrl5+fn5ryTkJCHADq6xsIglDprdxhdIQ4XXyk1vA7E0\/oKuu9zomCpgYBgdPKMxK\/Jo4zngDScudTvxnv8sZy38Qg4H4brgYO82Cif2ldF6NThno6omKiCYnvAKBPnz5sNrumpvJ9ckps\/AcUwMi438ULZwQLwWD4QPPMybnNvPA2BAFg6tSpAPDixYvi4mIJCYnr16+LiYkFBwerqqpaWFjo6+vn5ORMnz4dzThDODk5SUpKZmRkKCsr29ra8klGv0gB5vcthjQ1NXfu3IkaqchRX1\/fwMBg2LBh1tbWyHAuXryYNwrzv7cnQpepqalz5syZNGmSgYFBbm7utm3b0AIzMgCy7l5eXr179y4oKNi5cyefYiSHDh0aP368gYHB69evDQwMRowYwWazkZEmZQLAqFGjAOD9+\/cFBQW8SfTp0wet5tq+fXtRUdHt27cJgrCzs0Or1QFAUVERbeeCNmPpsNivXLnCl0HeroVbt27xKTN8+HAqlcrhcHi3jsFg\/v10bLzbAAiCIJsFbotX\/bF8cVlpyZw5C2dNmwAArSwW8d9LQdojTKNPt57pYjm5pLb4Tlr4f2xwxxChKSFqvdQixh1PrCn2fnr4U+HHq2+CgPjvT3uCezbqVJvABWMyMlI0Gu17zxtFTkFRQV6R3dr49evXb3mmUNvwhDXMD4Imb5NLxdp7kW1ifX19PT29trY21KpzcnKKj49HW6F9\/vzZyMjo7Nmz169f551ORafT7ezsAGDUqFG808KR5A6NNwC4u7ujudlMJrOxsVFXV7eysjI6OjolJcXY2NjPz+\/gwYOkEGhna5F7bW3ttWvXoqOjLS0tQ0JC9u7dyxcAfa9ISkru2rULAE6cOPH161dexUgqKyufP39eVVU1derUiIgIGo0WGRlZW1tLo9F4N0ezsbFBfyIiIniTAIBVq1apq6s3NjZu374dWX3eTxkyLuq95yv28ePHA0BGRgYaSuDTHwAaGhrQOAKvTFlZWUNDQ1ImBtNToJADQrzTOgpLypYuWz523KRVy+YDQMi9iLyczLv3HrJZrDMnT1iYGQddue2+dtX7t++0NLs4SQwAorOinC7PhdYuVnnJK2m9mRuipagV+Op8SOqDr\/Ul6XV57ZeW6Sv3feoWoirXR4Cofub9JzpP37d7s7ffOT8\/bxXl3soqyhMmTFrsNhMAVq3dlpn2\/klEOG+UzlasYjAYDAbzb0NQ05kk4mlE7pfsRQsWqSopMhgyAKCqrkqhUgtKSrtjvDMLMycpDQSAZg7zafl74DAnqTsBQFhFErRUy8uo2croAYAETbygOl9LUWuOzYIJFpMb2A3N7KZZgYtSKtNJUb2lVTNqit\/mxqnKTessOV4WzJvuONRy30Gfurq6mLgEZLwxGAwGg+nRCDLebd8Hk\/5YsnjdRo\/Nm9dLS0oePXZcS6OPCJ1OAWhtFdwT\/o0ljkuXOC4FgJLa4hHnXNKrPv+1KgQAXK5Ovffx6dYBC9eMXscbniZE6yXZqxf0amG3SFBFeL0OD9+26Pneh1+eDjceKyEiAR3BYrGhrY1GEwIAOVkGhaJVXVNbXlY2fvwEFIDD5QgL07ujOQaDwWAw\/0I6Nt5SEuJyDJnsnFx0+SbhPUFw3NesKyuvZHO+DYBRKJSampoOo\/8uKBSKjLgMr4u4iKT\/MI8Dr06UNZZqi3Q81z0jK7uJydTV0QaAuPi3cbGvZWWkW1qYTvZDUICC\/DzHEaP+Vs0xGAwGg\/n76Nh4y0hLyfeSKy0tQ5fjRjtlffn6\/NmTguKS6dOnAIChnjaVSi3IL\/pblaNQqPISDF4Xg959laWUqUCREZHpLFZhQRG7lWVipA8AR44c6aXUW0NLW1hUnMn8Nm2nqamRPIIQg8FgMJgeR6fd5pIS0jlvP6L\/KWlZAZfOqPRWk5aW7WfYFwBERUX6qOtkZqR3Fv1vQkpMSkZcdpbVXAFhSspLORyOhZkxQRD1DfUM+d7DHO2tLC3ke8kBAEEQOV8\/DzAz+b9SGYPBYDCY30ynU6wZ8r3Ky79tKj7EeqDX3gMTxo8z1tc27T+IxWIDgJGhSUFhblNzBytnfhdCQNFX0ANxaQU5TRAW669uLtL+ULL\/pq2tLS8nW1PHAAAKi0r6qOuUFBVcvRq4ZNlqFKCgsITL4YqJiggUg8FgMBjMv5dOjbeykkpzfV3W11wAkJKSWLl0wcG9u\/3PnaEK0RISPwDAyJHDiwqKPmdk\/X3KCQnRZg2cM1hRb7XBVDFpee\/hXrKicoKjVFXXfkr\/jPakFBUVKSkpYjKbxoyZ4Od7FAX4kJzKYrNERPCENQwGg8H0VDrtNjfv109ERCT6VZyejibpGPPmnbCwaExcvJ2t5ezpkzx37Uz\/\/HmAhenfpBwFKJKiknQhmqiwqDgIMcSlu1yNXVJSmvopbZ37GgAQFxPjsFsJEPbYusXL03PRgrkA8PVrtoZm385OQ8JgMJgeBDqbHPO\/x8yZXSxs7tR4m5j0ZTAY8fHxaG30m\/j3azZsaGlqMNDXr66uZjJbRUVFzPsPiHsTP8V5ophYF73Z\/2dkZGVKiEtqa2nU1tWv37C1pKREW0PdyXHYoIH9AYDD4eZkZ\/l5H\/6n1cRgMJjfgLu7+5AhQ8iTbDD\/Gzx+\/HjMmDEMBkNAGEHrvC2thmZ+Tq2qru0lx9DRVjcxMafRaPp6us8jn6dnZFmYmcycPnnP3oN19fX\/HuN91j9guNNQBkOmrq6BQ1DV1DWH2A0ZMnSokaEBABQWl3xKT9fT0\/yn1cRgMJjfAJvNPn\/+PDoFDvM\/Q3cqVFAvtIvzxOLi4o8f0wCALiLCZbNZTObF8+dLS0sL8vMAwNS0n6SE+PlLV39ILUlJpR8KDwCS9I73Y+HjYURUbvbXoUPtRUVEcnIKGAxGYV7BwSMHr12\/ik4vKCwqEpdgiIqK\/agCGAwGg8H8exBkvMeNdqQI0ZNTkwmCkJGWsh9qGRf7uqauUr+vQe\/eagRB9NXVnjh+3AV\/\/7o6\/n3LOR2dFSgjzthgteyg9bfDlFZbrNhksXSY8UgBOihIKwS4nF06fPmrObcMexsLCNnCbPX09NTV07YaPAgAjvmduHUzUE5Rwf\/sJT+fo2iGWsrHlAljnCQlu\/UpgMFgMBjMv5Mu5n+NHTfm9euY6ppaALC1sR0\/0Vmvr1Hv3kryCnKVFTUAMMl5ooSE6A7PfSyec\/eYzNbT5y7GJ7zjkyZOF3ezX7h8xAp06WTsdGDmERO1LpZcaylqUygUfVUDYZqwgGC37obm5GT+sWxFLzlGQXHp0UNeR454m5sYXb91q6GxGQAIgggJe6SiooJnq2EwGAymR9OF8Z7hOuVjSmplRQUA9NXVJto4dLpIYUHR\/AULN27bCQCG+rpL\/1j54MG9qFexKAqzlXXE5\/jpM\/47Pfe\/\/\/Dxt2v8OfPr3dBHfNuqf\/maezkoyN5h5Pgxwz+mfl6y9I\/1GzZZD7Y8dGCv9+G9sgxpAHgS+VqUTrGxsf7tKmEwGAwG87voTguzC+OtodZHW1Pr2Mlz6HLcuDEfk9+9fPlCW7vv+dO+yNF91RIllT7n\/M9XVFZzuW2Xgq7evHXn+ZNHBgb6GRnpzNZW8tTRX6StrY3N4WzftXfJ0oWusxfl5Rehznkulxt05UZBYVHQxVM0mtDLVzEcrtCXnHz39R7lFZXaWhoAQBDEkSO+crIyaJ81DAaDwWB6Ll0YbxVlJddpkyMePcrMygYAp6HWa\/5ce\/78hXOnfYSFaQlvPxQUFgHA6RM+GRmfLwQEcTjsivJKY2PDRw8fxsfHV9c2jxzjUl5RzWxt\/UVFa2vrTp295O13btnC+SpKfd69jVuwZFlkZAwA\/BUWHhx8e+P6DWKiomXllUUFBVmZKXJycu\/exlVXV6LoLyJjEuOjfXx8flENDAaDwfDi6en5T6vw\/yNdGG8AGDtmtGpv5V2e+9Dllo1\/ClFp8fHvd3kdWLN2Y+jDJ62tLGMD\/VV\/rPQ\/f\/5CwLVVK5aMHjE8JT1j04a1L1++zP6atXXb9v2HvBsaGn9F0bUbtxw+clBKXNykn1EfDTUXl6nHfbwtLS1C7j\/avHmzvaOD65SJVCo1+O69+W5zL\/qfO3Z4\/6mTflpaWgDQ2Nh0MfDSHs89soxOjzPBYDCY\/zF8fX1lZWWjoqLQ5e7du8n\/3YlLoVAoFIqFhYWnp2dtbW1nIXfv3v2riv4IsrKySDFNTc32vrm5uRQKJTAwsH14R0fH0NBQAAgMDHR2duaNwicqKirK3NzcwcHB0dGRzLifnx9vYf7jdG28lZUUXGfMefkq8t6jJwBAoVDKSopnzZ516\/bdVStXhT94UFFRTqcLL140d9TIMXu8dt+9e89t3qyjB7xaW5npGRnNTfUDB1ptWrdmyco1\/peu\/ah+eQVFm7fvXbHGY\/KUqYsWLb4QcElZSWGyy6RhTo4mRvpfs3P37vFS1dT08z7IYMgAwL0HD8PDwx0dhpqZGk+eNFGWwQCA6JjYV69erV75x4+XDwaDwfRUamtrzczMfq5lXFtbu2vXLoIgIiMjc3JyFixY8NvV+zlqa2sJgiAIIjc3t72vr6\/vpEmTkJHmCx8QEODu7h4aGurs7BwWFkZaZeTCK8TFxSUwMDAqKsre3t7d3R2JrampMTMz+xsz9oN0bbwBYM3KRbp6hsHBt2tq6ygUyqhRwy2trLyPHK6vrU5NTU1Lz8zIzKJQKGdPek+ZMt3bx\/d2cCgBhDRD1ufoITFxMW097YT3Se\/fJqKdUgCgra2tsqqGzTNBnRcul5tfUFRX39DU1DRqzMS42NhrV85TCMqKZUsYMpJeB3yXLXJznjAqLv7ths0ejF7yobeuUanUh4+erd+8Kzkp8dzFgJS0z6S0mtq6K1du5cGe9wAAIABJREFUHvc51uXWqhgMBvM\/hoODA0EQvC1RAEhKStLS0nJwcDA3N++yKclgMHx9fSMjI5GxXLt2raampqamJp85T0pK0tTU7NCg\/gouLi5JSUndDx8WFobsbntNNDU1d+\/e7evry2AweA18UFCQm5sbGSwqKsrMzAwdG+3g4JCcnAwA7u7u\/8cdDF3SXXu2e9e2d++T7j+KAABlJYUtmzZm5xYcP32KS3DdN2zZ4LE78W0yl9vmfdhr0qSJnvv2HTriZ205cJjjkGEjRrex20JCw5wnTbazHoCkNTe37Dvok52bX1xSHnj1Zll5RcqnjNiEdy9j4p5Fva6rb\/DYueeo70khIZqxsTGbzVJX17l3L4xOFz588MDokQ6tLNbVa7cXLF7aS1bu9HGfXnKML19yDh\/1zv6apa9v3NRQ73\/hMqn5xYBrTQ21aHtUDAaD+f+N3bt38zW+XVxcQkJCoqKiAgMDXVxcupTAYDDMzc1zc3MDAwNzcnJyc3Nzc3Nramp8fb9NW05KSnJ2dg4NDe2wK\/tXsLe3b79LqKenp6enJ98XCXy3uwwGAynTXpq5uXl0dDQAuLm5oQC5ubkEQSBT3R4HB4cf+nT4v0TQ9qi82A4eONVl0t69XmNHjZDvJTtogLmcnJz\/+bNz57gZ6ut7bNu0waPq2MEDlpYWO7dtUlJR3rfXMy390\/69e\/y8D5WUljc3c9avWQQAzS3Mpqbmmpra9x8SqZQFW7btSXwbq6mu\/vhpVGJiAoVCOXLAk8lkZn39+jLqhdVg6+nTXHyOnw3969a6TduLiksHDTCvq2\/YvefQ5SsBo0ZPOLJ\/l5yc7Kf0rHfvPhqbmEZFPzt21EdcnK6qoozUfhmXeM7\/9PUrV\/r0Uf27ihCDwWD+xTg4OJiZmfE2HHNzc5G5Mjc3l5GRSUpK6sx6kdTV1QEAb0hew+bs7Lx79+4uhfwEqNeaD3t7ewBgMBi5ubmoA8DMzMzX1zcwMFBLSys6OtrCwiIwMLB93NraWhkZGaSwm5tbbm5uaGgoanY7OjoiObxd6AJG+v9xumu86XS6m9v8qJevXFxnPQy9LS0lpaOlnvIuLjkl\/fbdeypKSlaWg0+fD9DW1pCSklz\/5\/IBZhZ\/rv1z\/KTJZ0+cMDUzunj2GJLzOePLoiVLRo+ZYGZi2NLMDA25oW9oVllVweFwEuNfuUyeqqGh3tzUxGxqFhMXX716xY3rN40M9NTVVMPuXG1ubvmQlOK+YUtB\/tc1azZsWrcCAF6+il+zfmNebqaMtByb1XL48KGAi\/4a6qoAUFZWsW3LZluboYMGWvxNxYfBYDD\/fnx9fS0sLObPn9\/eKy8vr8vmcm5ubk5OjoODA28fe21tLRkxMDBwwYIFzs7Ogs\/S+F04ODiQ\/yMjI8n\/YWFhZmZmHz58AICcnJz2HyVRUVGkbUat86CgoJCQEF45SUlJeXl55H\/0ofAv5AeGgbU11T08tuRlZ+\/w3F9bW4ccc\/LzH9wPE5WQ\/ZSeVlxSOG\/xilNnL9Y3NDrYW926fs3R0WHhsqWLl6669yC8uroWAHqrKDk4OBTk59kPdTztf05Hz0BCQjQr64uRkaGKskpDY9PJM\/5MFltdXcNz156lS5eIitAu+p8UFhZ+HvnSY8du58nTFBXkAi5eWr\/mDxaL9SE59cr1G62tzZMnz9DW0V2zbovbgvlSUpIAUN\/Q4HXgkI6OduDF039HwWEwGExPQVNTc82aNUFBQejS3t4edaT7+fmhfumoqKj2Y7p5eXnR0dFhYWEuLi6oh9zBwSEoKAh1mwcFBZFG1MHBYc2aNd3pgf9R1q5d281x9NDQUHt7+6jvuLm5kf3q0dHR0dHRqKedzKabm5ufnx9BEHzfLubm5gRB+Pn51dbW+vn5oXZ5bm5udHR0XV1dcnLyv6Qjvbstb8SYEU6+fj6bNm421DdYumgulUq1t7WaOHFiVPRLaCPqa+t3bd\/kd+r86FHDjQz0DA309nnunDdn1oGDx9av26irpz1k6LB5c6bv3rGVyWyVlpLU1lJbtXJ5YUFRbm6hrraWy1TXuTNdX76OV1ZU8D60V1Ojj4iISENjU8DlW4\/C76WkfFJT0\/Q\/e9LMzExZSaGuvtFjx+537961trKb6uqH2NowZKUN9HQnjBuGVD13\/nJtbY33oQN\/Q6FhMBhMD8Dc3Jzs+HV3d0dzygAgNDTU3d0dTVhDQ7\/t+4fRXLaAgABNTU0fHx9kpx0cHHx8fNzc3BgMBuk4adIkJD83NzcqKoq3Wfzr1NTU8Lmg5NqTm5vLO+\/M3d0dfXCsWbNm165d5ubmmpqaSUlJZN8AGk3gjUISGhrq6+sbEhLi5uaGAqD5ATIyMiEhITk5OeRg\/z8J8R0uD\/lFJTPmLnHfuLOlpYXN5vB6sVis3XsOySur3r77gPRKS\/9sZG75PPLVn+u2OQwbk\/klm81mF5eUcTjfArx6nTDWeQajl4K8cp9ho519T10sKSlrbm5hMplMZivrO62trUwms7mlpaKyKjjk0TiXWUqqGjJy8gOsHC7fuINEcTic5uaWgsISVQ2duQtX6Rn2k5SRXb1uE6khm80+dOyUpq5+5Ks4bjtaW1tramq8DvjwuRMYDAbT05CVla2urv6ntcD8ZmRlZWtqagSHoRDf9y5ta2vjNeqBQTc2bd6goKiyYuVytzkzJSTEyWApKZ9vBN8OCLi0f\/\/BmdNcxMXFWpjM3Lyi90kpO3ZuNzDoJyUladnfNPzpk3OnT+poaZAyP33KfBTxNDn5bW5+QWVlNY1GV1FWoYvS1VT7iEuIcTltRSXFdTV1xcXFBHDFxUR1NDUMjU3Hjh41aKAZuddrcUnppq07y8qqsrMzNdTVtm3Z9vhJhKmp8dxZ0wGgqbn5\/MUrPr7HFi5cuGvbZr4vlZTUtENHj0VGRmampZA5QuCFZBgMpschJyf39etXfJ73\/xhycnLZ2dmCJxB02m3u7DzuyvUbhQX516\/dTElNPbzfS1pKEgAOHT2RkBC\/aeM6MbrYwYP7CQ53\/rwZYqKihvo6Tc2NmzdtvHzlZq9esnv2eh7z8dNU78Mr09i4r7Fx39ZWVkFRcWFhUX19fWNDXUND4+fM7NbWVgAYPMBctbeyqKiYlLSMsrKyro6WmKgIn2K9VZR9jxz8lP7Zdbornd63trb6yME9pO\/5i1fOnT+3Zs2akU7D1qzfuGblcm1tbeR1\/9Gz8xcvfMnK3OflxWe5MRgMBoPpSZBt8PY9zA\/DI\/sa9du9z1tTu+8ct2VcLnfnnkMMOQVFFQ2boSOzsnI99x5WVFbdsn0vGaWFyTx+6ryqps5g+xHM1tb2MtvDZnNaWpjNLS3NLS0sFqs7Ubhc7ufMbF19w7r6+ubmZtJx1vw\/lFTV9x8+ll9QbNJ\/cC+l3qoaWkjm54wvfTR1TvtfNh9oVV5e3l7g39sJgsFgMH8DuNv8f5LudJv\/p+XNZLZu2bHv1etooo2gUtrExKXl5OSZ\/6+9845rInkb+IROAAmIIEUSpNkQUPH0OCVYOCsExUJRguUnp6eA\/axYsGAhKAJnI9h41UMQ7A3w7I14FkARAQ9FQQlIh7DvH885t5cAxjss6Hw\/\/LGZnZmdmV322XnmmeeprOphb8P8OWDzxnWjx\/mmi25NnTp9zFjenDkLBg0dGrNjh5KSUlT0tvz8vJAVS0xMjFSUlWf4TzK36OjQw05ZSS5rOAUFxuMnT5\/9WThkcH\/5vzlUlJR\/\/XWXpoYGfH88zs5ZEbL28qVLs4PmdbKyHMEbpclUjz8UfzQ52apLtwN796xYsSooaL6tTaf62oar1289evLswoUzbHZHaytLH8\/ROjqfYnsDgUAgEAgtwt9r3nV1dedTfl+3YUNx8evgFStZmsxHj7KuXru1dPECI6P2XW171FRXzZoxa+GCIIRQZlb2vF8WP8vPmzVrlrqK6pbISHU11cmTJ3uPG\/0vGhEesf18ysWk+H3\/omxlVfVvR5J37d6pqKQ08+efKyoqwsPDO1laBwYF9LS3qaqqDt20JfrXKH19w7u3r+Tm\/7k18lcr847m5uZvK6pD1qwexRs5aZJf+3Z6ZM2bQCC0Or6ENW\/Y\/N2yRubfOPKsef9DbV5XV\/\/gYZZ5Jxu\/qf4VFZUSieRVUXFdXd3yVaEGhh2Wr1xXXlGB9cwvCl\/Om7\/UhGMeMGfxw4ysiX7+phyLiX7+j7Kfyqn6lkgkew7Ef\/+Dk6mZOUvP4Lu+jkFzF715I5a\/eEZWtteEKQbGpvyp09Pv3p8+az7b3Grm7AUvCv9WjJeXV6xcE2rYwWxrVExtbZ1YXFpfX18iLp0+a\/bO3bFV1dVEbU4gEFopzajN6d5LgJSUlI\/RhuXLl0MIk08A+IoBH6gxMTEt0pLly5fb2tqy2WwulwvK6vT0dA6H4+TkxGaz09PTKYpKSEhgs9m2trYcDufp06cURZWUlHC5XMgj25L\/iDxq80bWvO\/dy7LsYvvbkaT6+vrq6pqwLdGGHTizZi+SlZ1VVdUbNkcYmZoN\/NFVdPf++k3brLrYdLTsGrv\/IEh9eQSwIGKHvlEHppb2CPfxhS+L5ClSW1v76lXR1shdZlZdu3bvtSMm7u69h8NGehh34Cxfsf5teYVU\/vKKyllzFmrr6EX+GlNVVS2RSNIuXXEd7f3ixUucp2WHnkAgED4B8qx50ydpH4NPLLxBdiYkJLBYrBZpCf6msbW1BTHs5uaWkJAApzgcDkVR6enpIE19fX0DAgIoioLt4xRFlZSUsFis98raD0Ie4d2IrrhLF4uhQ4cejo+vrKyK2XtgW1TklMn\/C9uwSjaniory7ICfwgVblZUVJk6aoqKENm8Kd3V1XR8a6j7Ge\/vOmAeZj6h3avmmsLJgW1l37vP9D2pqyiztNs1nRgjduJUeGb2TN8YzMnqbl+f4jZs2lpW8nug3WdJQtytGuGzJXKa6mlQRdTXVkOAlU\/1\/EmwR7Nn7f2Vvy7dF7vQYNUJfX++9lyMQCISvg+DgYC6Xy+Vy7e3twSsLl8sNCgqys7PT0dEBx2HgUpTL5TIYDPBPIhQK7ezs7OzsWCwWRASHDODz5GO3WSqqGAQ0QwiB5G6qVGJiIjTSzMwM9zQ8PBxctUjFLMEKfxaLBZmPHj0KXlS5XC74d4PuQx44EIlEUJDFYtna2n56t2uN25T5TvCa\/nPARkFkQ0NDWZm4e7duzVQxym1o7152ew\/835Zt24wMDb08fdzdXZNPnAqPiNwVE2PT3Xa0++iBXEc1mU1fAEtbN2xTaFtd3fv3H5SWvdVr2\/jiTWVV9akzKSeOHbtx+yZCil7jxjoPcLpxM33durW5OXn+P\/mPHzuqg4lRU41kMtVHDBsZKxTey3j4ZF3eyxf5w4cOaaZTBAKB8JXB5\/PBOSifz8devtlstkgkAr+h4HlNIBBwuVwI3YEQ8vPzAzEJITXFYjEIKnBDJhvaq2VpNKoY+qeXcllw0JTAwEAcoYSiKJFIBM2WLZubmwtnZWvDPtLFYvHRo0djYmIQQmlpaR8jEIv8NC687Wy6eo33DF6xzGfilOFDR0ybPo2l+5tz\/++wpxQpTIwNf5kXNHWSn6fPpIUL51hZ20RuDZ8fNGuXMG73zh3xhw8aGJlwnQZ5jxvj+H1PBg2E0He9\/4oawu7wd+AvunLg4pWbe\/YdTEs9W\/L6laEJe8ZPP\/t4jk67dH3K\/2a8KMh17D\/wyuU97Q2am0NTFJV4\/Mz\/pk7uZtO9trYhbn9UYcEzYqFGIBC+KVgs1ooVK0QiEfhJBQEGEojD4cCkk8Vigay6e\/cuSE2Q7nhWymKxwsPDwRMqROj6qDQaVSwxMTExMbH5SOTh4eEikSg1NRWHY4GeNvopIBaLwX97o2ex8\/OgoCA3NzeYcGtra4vF4k8TiKVRmtzN9fNPk9U1mLG7d72tqFZAaNJk37Wr17q6DtFgNuneRK8t69Sxw+fO\/75nb6zHuDFmHS29xnkIhTvu3H2Y\/Sgz4+H9n2ZMpxCjvaGRg0OPzpbm+vp6TKaGbD3l5W8Lnhf+cT\/z0ePsgj+fKShQ7A4mYz3G9OzZy7i9\/h\/3\/+CNHv\/ieUGf7xy8Q9c5cx2VlZvbk1ZXX3\/gwG+r1qyqrqqkGhgKSJLzOItIbgKB8K3h7OwMK7WyMUjoQHDusLAwLO0gPwjL4ODg3NxcgUDg5ubWfD0fCZFIFBgYmJqa2ozg5PP5dnZ2MTExcrbQ3d09ICCA7uccBDOEEIULgQYCezWHAOcg1\/Py8j69FG9Ohk2e6Llzx\/bp\/lMGDxlmYsJZuWb1ug3v8cauqKj4ows3OnLrr1GRTv0dd+wS8v2m\/J56Tq9dW1+\/qTt3RK8JCR7v4VZaWhp36MiyFWtnz18i+xe8av3R5JO1dTV8H4\/1a1dtDQ\/3GOvdRlvr4KEDflOmxuzdP3gANyoyIjoqwmWwU\/OSu7y8ctXaDfsPxvlP+9+2rVuW\/DI7bNNaTU3NfzNUH0JISAioFnbs2NF8zokTJ2I9xC+\/\/CJ1dvDgwXRFhbKyMofDGT169Pnz56Vy1tbW\/vrrrwMGDNDT01NVVTUxMRk\/fvzFixelsqmoqNArVFVVNTU1HTt27PXr1xttHpvNxplPnz4tddbFxQVOzZs3j56ekZHRfPeVlZUZDIauri49kaIoBQUFBoPRvn37Dx0ohNDjx4\/9\/f07derEZDKVlJS0tbWtrKwiIiLgLL4jW7dulUp57z2iZ962bRtOnD59OiSGhobSMxcXFy9btqxHjx5t2rRhMpnW1tY\/\/\/xzTk6OVJ34Xhw\/fpyeHhUVBemPHz+GFIlEsmvXrgEDBrRr105ZWZnJZBoYGDg6OpaVlUEGGE\/ZB\/vYsWNQ1apVf9ms4CcKVw5s2LCB0Sw3btyg52\/+wXhvg3Ez7t27Jzvaly5dgrOjRo2ip6empkL6+PHjIQXfl40bN0pV0qtXLwaDoaioCD8vX74MOceMGYPzHDp0CBKHDRv2oSOJaM8\/g8HYvXs3PX9OTg4+1abN+015Pg0lJSUgco4ePdpUHrFYrKOj4+zsnJeXJ36Hvb29vb393bt3ES0WOI5R9lHx8\/OjRxUTiUTOzs5BQUEQ8QzHU4FOQQtxI5vvKf0SLBYLAoGDst3X1zcoKCg1NTUoKAgkenBwsEgk8vPzgwBl6N0iukgkCg8PZ7PZn16F\/h4\/KlaWHS3MOd5e42qqa\/fEHdywIfT27fS4fbu122g1U0pLS\/PHwQMGcPsHzvzp7t2MyO27IqOiGupq27Rp07mbfffu3QcMGDRsnZNEIpFyqA4oKCjW1NReu3332tUbd0VHnzx+WFpaqqSq6sQdvC9WaG1tzmQym5fZQF5+wdwFi+\/cvpaWcsGwvQH+N\/4EMN\/pJ5hNKyoQQrW1tcnJyeidoURycvLatf8Ig6ah8ZdmQlNTU0dHp7i4OC8vLy8v78iRIyEhIYsWLYKz2dnZPB7vwYMHuGBBQcHBgwcPHjz4008\/bd26FfedyWSWlpZChVpaWkVFRc+ePXv27FlCQsKFCxf69etHv\/qNGzfy8\/O1tbWhSHJy8o8\/\/kjPgN9xERER\/v7+5ubm8FNFRUWq\/VKoq6u\/fftWXV2dnshgMFRVVaurq2Vfne8dqMuXL7u4uFRWVuKUsrKysrKy+vp6qZbgAznvkVQpNbW\/zCFPnz4dHR2NEPL09KR\/u5w8edLLy4seo+nRo0ePHj3auXNnVFSUn58fTtfU1ISISfPnz3dxcVFWVoZ0qdGjKMrDw4O+FFdfX19VVVVTU4OlgpKSUn19Pa4Bg1tLfwAa7TV96BqFfrOafzDkabDs7aCD2yb1hOCf+AlReucJqqm+447L3sHnz5\/PmDEDIdS5c+cDBw7gCuUcSYRQcXExPr5z586kSZPwz6tXr+Lj6upq2T5+SrDeODExMTg4mMViBQQEwEyRx+PB3JHD4YA2uLS0FAcJ5fP5oEmGmNYCgaCkpEQgEAQGBkK4LRB12JjrYyClmReLxQEBASUlJbARjs1m40vHxMSwWCxQs8MSPovF8vX1hQ6ChR30VGrBm81ms9lsqJDD4djZ2QkEguDgYLDvg7k7h8Nxc3PDu++cnJyCg4NhKHBktk8NXlqWZ4+WcO\/BzjZ2Dn36Hzt1trKqqpmcN2\/fdRvtfTT5xJ8FzyUSSdnb8oRjpwPmLR46ktfToY91527G7I6duvXs3tPRvnf\/QUNHDed5ugwfbefQr3tPR8su9iYc805dbBy++34Ez2POguVJJ87jmlNSL55P+b2mpjlHquXlFecupA5wGTlqnI+cO9Za0Mqfoig8Pzt8+HAz2Q4fPowQsra2DggIgPwPHjygZ4AZhoaGBr5H8fHx8B5RV1evqqqiKOrFixcdOnSA4pMnTz537tylS5dWrlyppfXXB9bMmTNxhTCpHTlyJPysqKiYP38+ZJswYYJU8+DVNm3aNFtbW4RQ+\/btpQbKy8sLP0jOzs4NDQ2Q\/uzZM0iMj49vtOMGBgYIoY4dO0qlg6+Jrl27fuhA9e\/fHyGkpqYWExOTk5NTUFBw7969ffv2ZWRkQAYQtAih\/fv3Q4qc90iq+L59+yiKys\/P19PTQwgNHjy4pqYGZ0tJSYH3vqam5sqVK69cuXLmzJkpU6YwGAyEEIPBoF\/LyOhv+8rg4GCcvnfvXkh8\/fo1RVEXLlyAn8OGDbtx48bz58+zs7PT0tL27NmDi4Aw09fXl2r2pUuXoOz69eshBc87i4qK6DklEkndO1au\/CtYwIULF968efPs2bOsrCx6N5t\/MORpMJ46FxQUyI52RkYGnJ00aRI9Hc+rZsyYASl4wh0ZGSlVyaBBg+DfBH5mZmZCzilTplAUVVtb+8MPPyCEOnTokJ+f\/y9Gknr3GMOUq1OnTvT8MM4wPgihyspK2W62CC3uHpXFYsFerLCwMBBXePczn88PCwtrwWsRmuLD3KPKwwQvD5tuXbZGRM6dt2C0G8\/Ta1xna4tGc65aE5qfl705fKu6uvrxxMMaTHXXoYNchw5CCBU8f5lf8LywsLCsRFxTXyupqyt\/W0ZRDQoKChqabRSVlZUVFXXb6hu1NzA1NTHQbytVs6u7u4WFZXRkZK8eto1eOiPz8d59+0+cOjU7MMCd5\/pZlrfxhECpWR+xoGobO3bs4MGDw8PDEUJxcXF0vRwUh\/98BoOhoKAwatQoDw+Pffv2VVVVFRcXm5iYBAUFgbDcvHlzUFAQFHR0dHRzc3N0dCwvL4+IiPD19e3Zsyeu8O3bt5CNyWSGhIQIBAIIyUpvW3V1NUxHxo4da2xsfPfu3cLCwpSUlIEDB+I8MEd0dXVNSkpKSUmJiIiYOXMmos0dZWcw9HTZs9A8XFz+gXr69ClCiM1m41UrIyOjbrRdErJTNDnvkWzmyspKd3f34uLifv36JSQk4NbW1tby+fy6ujoVFZWzZ8\/26dMH0gcPHty3b9\/JkydTFDVz5sxhw4bBzJI+eiEhISNHjuzRoweSGT3oGkLIx8fHwcEBjrGSo\/lxU1VVbaqzUr1WUFDA\/yl4iNTU1HR0dKS8d733wZC\/waiJJwQnSp3FpXBPZVOk+t5Ux2fNmnXp0iVDQ8Nz587hb1\/0ISNZU1Pz6tUrRUXFIUOGiESizMzMnJwcCINUUVFx4sQJLS2tAQMGwAdHSUmJlBbhiyUmJiYwMFAsFtvZ2QmFQrBfg6kqj8dr1HyM8HnAYlye6Snw+s2bqO1CtnkXu159dgkPVFdLByB5ml+g3VbfZQjPm+\/f1sAIEleHhjn+4LRw8Yri12\/kvFBVdfW8Rcsdf+gfvm0XTmxnaNLFrpcjd3BRcSP1RO\/a06P391P8AzMyMnE0cXlo2e+mXbt2wfAmJSU1lScvLw9el5mZmQ0NDSYmJgghMzMzeh4siujzHvhHUlNTq6mpKSwshFld9+7dZS+xevVqKB4YGAgpoDjq27cvzvPy5UvIs337dnpZmP8ZGRlJJJKsrCzIw+fz6XmmTJmCEJo7dy5MfNXV1bOysiiKwkrjEydONNp3U1NThFCXLl2k0g0NDRFCDg4OHzpQeM2Sz+dnZ2fLXhFvaDly5AikyHOPZIvv3r17yJAhCKFhw4aVl5fT8xw6dAjy0FUdGJgIIoQSExMhxcLCAiEUGxsLer+uXbtWV1dTFIVVcPDRhhebjY2N4+LiamtrZStv27at7JhQFHXnzh0oKxAIIGXChAmQUlZW1lRn169fD3muXr0qe\/a9D4Y8DcYPdqOzRmwfMH36dHo6vty8efMgBVswxMbGSlXi6uqK3u0GpigKr5v6+\/svXboUIWRubv7o0SOpUvKP5KNHjxBC2trasKCDENqwYQOc2rNnD0LI1dUV6zDu3bsn280WgQQm+Sr5l05a3gtLW\/t\/kydcv5RmZmbxy8J5Q13HPMzIqqyswjvmD8QdpqiGWknt9atpQUHzEUKFL4uOJyVYd7U\/cepMfv4zhNChQ4cNO7C1WLq2vRyPJp9ACN27\/7BTt15sMwurLt2Tj51BCNVUVx8\/fkxTx2DJor\/XFOvr6+trJdlZmRMm\/a+6ugYSKyurbt0W9Rs4dEt42ML586IjNlpZWTKa2Nj2CcCXbqYNu3btamhocHBwsLa2xjY4T58+vXz5smw9EokEIVRaWhoaGpqUlIQQ8vb2VlFRuXjxIkVRCKHhw4fLXsLNzQ0OsL4RKoSVYLFYnJqaCnnGjBlDX45FCIEZl7e3t4KCgpWVVa9evRBC8fHxVVVVUs178+aNQCBQUlKqqqri8\/kNDQ14mtJU92Hh8OHDh1JWUS9evEAysdXlGai1a9fCzEYoFFpaWg4ePPjYsWMUzYeD7B2R5x7JFp80adKpU6cQQnw+X2q9Fm9cGTFihGwNTd0LBoMBr\/gHDx4sW7YM0SZ5kMHBwcHb2xshVFBQ4OnpaWJismTJEhgoTFPzRbzaFSjwAAASmklEQVRAi+eL8vS6+QF574MhT4ObbwZudmRkJP3xsLa2hnT8hDQz84ZKZDseHR0NOpuhQ4fC9xMd+UcSFAxaWlrOzs7w7B05cgROgfAeOXIkXroqKiqS7SaB8F\/49yrldvq6+2K3b9sW2UZLnecxLnDOwqPHT74pESOElBXQSNfR508lZz28\/8u8mQghXV1WUNB8E0M9\/XbttLQ0EULOAwbOX7AUIeTn69ulcyeoU0lZOWD2Ah1d\/Tt3biKEVFRUf57+s6mJsV1PB3xdlk7b7x37rl6zzqS9\/uOcp0XFb5KPn541e96qNWt62Ha5mHJ+tLvrZxTbwHtfkRKJZOfOnQihiRMnQgq879A\/bTjxS8re3t7Y2FhPT2\/BggUNDQ1DhgwJCwtDCBUWFkIGfX192avAmhyimSNBhTdv3mQwGGBTeu3atejo6EOHDtH1qBkZGWCpjidq0Ly3b98mJCRIdbOystLe3n727NkIoatXr27ZsgWLn\/+OnAPVvXv3mzdvglkNRVHnzp0bOXLkwIEDscyQvREfJLzxjTA1NYX8np6eUlbiH3ov8OjNmDGjb9++CKFNmzbdvn0b20ZhYmNj165dCxP0V69ehYSEWFpawrAAIGyaWSHC+uf\/KLzlfDDe2+CW+g\/FUrapvuOO4wz6+vogayMiImS3Lcg\/kiC8tbW1NTQ04HPt2rVrL168eP78+YULF5SVld3d3bHwxvotAqGl+E\/rwWqqqqN4I7ZFhIdtCi0qfj1n9jwfX79NW6Jc3UauWb2cnjMp6eTKVcG30\/\/YuH5VBxMThFA7PV01VRWE0Az\/SZYWHSFbZeXb\/ftiXhcXWnbqhBBSUVHWb6d75epl607dUtL+mmaNch8zNyhg0sTxs2fPPnXqnO+kyQFBQQOcncI3bRBs2qjD+uhOA+QBz\/maegskJSU9f\/4cIfTLL7+Avz3sou\/QoUPYPBVb4z969KikpITD4fj4+Jw8efLkyZPwXsALaVhy0Hn16hUcgDoavZvBq6mpde3aFUyuEEKzZ8\/GRkYAts\/q168fNA80jejdrIJeW11dHUJo5cqVNjY2CKGlS5e+ePEClnUhgyxQxNzc\/Nk\/gSbRS8k5UAihrl27pqamXr9+3dfXF17BKSkpw4cPh9pwnfjgvfeIDi61adMm+GiQSCQ+Pj54fRf923tRV1enoKAQGxuroaEhkUimTZuG68EXVVRUXLhwYX5+fkRERKdOnRBCFRUVU6dOxVM9MLOqqKiQumh5eTkcYDNveXqNryu7GUTOB+O9DZa9HXTg8UAI+fj40B8PbOuLS2Gz86b6jjuOi4wZM+b69euwkL9+\/Xr6Nwf6kJEE3T7YQoPlJkVRx48fj4+Pb2hoGDp0aNu2bXFmfPdbBY16+hSLxfQtW4TPTgsYcxnqtxs+xCXh8L4Tx5NratGakJVO3IGBcxbdvvsAjI8RQs+eFxQXF6emnBHGxlLor9cHWEjhTV\/Kysrt2rU\/eGBfduZ9r7GjEUL19ZKUi5fynmafPnHs8tUbCCGKotaFLCkpLRvjNbl\/\/3774w4sX7Is59FDr3FjOBz2Z59wY\/BbryljqO3bt8NBeXl56TsgpbS0FK+i4XrevHlTWVn5+PHjvXv3wporgM1Zjx49KvuqxfXAlBS9e4V17tz5\/v37RUVFp0+f1tTUrKys9Pb2xq+n6upqbPCM24bPnjt3DgsnqA2uq6qqun\/\/flVV1fLy8uDg4Hbt2qHG3v4AvJ0VFRVN\/gk8LfRScg4Upnfv3kKhMDMz08rKCiGUnp5+5coVep2yB\/IYrNHl2YQJE+bMmYMQEovFvr6+uB58L7CIotPUvYDilpaWoEq5ffs23sQvNXpaWlozZsx48OAB3iaHDebBcL2goEBqVxJePGaz2fL3uinhLf+D8d4Gy94FOlh4M5lM+uOBPzdxKWyx\/+TJE6lKoO+44\/RO2djY4E+NqVOn0pst\/0jimTdCaNiwYbBYfv78+WPHjiGEYBHqs8+8BQIB7AED32pylsK+RelgJ6Ofl9zcXDMzM+jRx\/bM+oXTkpbY1pZmZ08cuXDugp+fX7n4lbeXj8P33DkLl54+c7Zvn95Xfr+YlnpxwoSJKu\/0TibGRt87\/r2xWFNT09LCXFHx7yYpKipMneR35fLVlPOnBg7ol3g0OXDu4n79XTasX6dIVV25fDn9xmXsXfWLAr8pZFWgCKG8vLwzZ84gGXsc\/NLft++v0OZ4m3JTU9hevXp16dIFIZSZmQkrppjMzMx169YhhFgsFtY5w1sPvxxdXFxgq1hhYSG2\/Tl8+DDsPz506BC9ebNmzYKWxMXFNVqbjY3Nhg0bEEJ79+6FL7Ommg1nce8wUCEuJf9ASWFmZjZt2jQ4hkkPft3LzvkavUeNNgy3OSQkBIb9999\/B+t3hNC4ceNgxr97925YF8fExcWBJ5N+\/fphZw5Sozd16lTwSYIt6RodPQUFhYULF8KUDs\/nwKhbIpFIfc2AhwotLS17e3t6nQoKCk1tBEBNS1b5H4z3Nlj2dtDBGx+knhDZUra2ttARqY\/XBw8egDgHU0okcwdHjBgB27Jfv36NHxX0ISMJwhv6paKiAqYYt27dunnzpoGBASjSsWLgcwlvsVgMbsxzc3PBM5qcpWRdjgQGBn6e3cz\/hMVipaenp6amCoVCvLnm2+TDtoq9FwUFhq1NZ1ubJcWvS\/64d\/9JdvbZlLT5C5bVNdQZGRl25JjqGxhevHyF1UbH0srcysJi1\/Zfcdn2Bu3WhQTrt9O79yCrRFz25\/OCly8KX78pev7nn7n5zyora1xcBtp0s+L+8N1gl0GaTXj\/+ELAb5+ysjKpfxhDQ0OwwEIIYRtpYODAgYqKihKJ5OTJk2\/evNHV1cX14Fe8FAwGY9u2bS4uLnV1dSEhIX\/88Qefz2\/btu21a9fWr18Pk9SoqCjsy6ympkaqthkzZoSEhNTU1ISHh8+ZM0dFRQUskpSUlFxcXOjX+vHHH7ds2YIQ2r9\/P\/zbwOyEvsds5syZp0+fPn78OCw2S20\/w0ADZDsF+fGkR\/6B2rx5s66ubqdOnVgsVlVVVWZmJlbwwoQY14mb1Pw9klq2h3HDbVZVVY2OjnZycqIoaunSpe7u7hwOx9TUdPny5YsXL5ZIJK6urv7+\/sOHD1dQUEhKSoqKikIIsVgsujc32dHbuXPnjRs38CQPTj148CA+Pv67774zNDRUUlIqKio6evQouCrDb1hvb+\/Q0NCGhoYpU6aUl5c7OzuXlpbu3r37t99+QwhNnjwZf6BAnUwmU6rLDAYDzymbeurkfDDkabDs7aCDryvVAJwZF9fS0uLxeIcPH75\/\/767u\/vixYuNjIzu3LkDWxY1NDTo+zWk6ty4cWNycnJRUVFSUtJvv\/3m4eHxQSMJwhuL5wkTJmzbti07OxshNHfuXFBsfHbhjWGxWNjbCfgWRQg5OzuHhYVBlC07OzuxWAwezrlcLsh7Ho8Hhgupqangq+TT+0Pl8XjBwcH4yaF7g8G6rm8U\/Pks\/64q+amvry8re1tUVPz48ZMdMQd4Y31tHBzbGXbQ1W9vaGxqbMrpaG4p+2fUgW1g3EFP37C9UYeDR5IzMrOeP3\/+8tUrCMX9kZDbhl8uNm3a1NSAX7t2DfaVKikpvX37Vqog3he7c+dO6t12F4RQXl5eM5dLSEjACjo6ampqQqGQnhMMpM3NzemJnp6ekH\/v3r2wAQYh1KdPH6mrlJWVYZvbx48fUxQ1cuRIhFD\/\/v3p2QoLC7F6U+rqGBCNBgYGUukwizI1NaUoSiKRyDlQ9fX1jXYfIbRo0SLIDyoBhFB0dDSkNHOPbty4IXU5XJy+oQ6bzrm6uuLEJUuWNLp806FDh1u3btHrhDYvW7aMnnj27FlcJDc3l6Jt3JLC2Ng4JycHFwwJCWk0W58+feijB7dMFiaTifNgvz3Hjx\/HifI\/GPI0GG+OyMzMpGTA7snGjRtHT8f7CyZOnIgTCwoKcNwIOkpKSnFxcTjbzZs3Id3Lywsn4m8pY2NjPEryjCT2lDBr1ixcG27GnTt3IAV7m+ndu7dsN1uE5reKLV++nMvl8vl8W1tb8K8SExPj5uYGZ21tbdPT0wMCAiBAdUxMjK+vL0VR8FWakpIC6biqTxa0m05YWBg4jcEEBASAu7T09PRP355Pw8faKiY\/DAZDQ4Opq6vTsSNn0sRx8XG7RdcuFv6Ze\/vGzbWhYX6Tpztyh8j+TfspMPlo8ssXfxY8y\/VwG2ZlaWFgYKDXtq2KSpOKvi8N+n4qKTIyMsCnSpcuXWT9gGKZBGo6bJncTIUIIR6Pl5mZOW\/evK5duzKZTCaT2blz56CgoKysLOwZEYApi9SExsfHBw6io6Oxn8jevXtLXUVLSwvv1YHtatAqKc+aBgYGoK5HTTuGhAZInaUoCtKhwt9\/\/13OgSopKXFxcbGwsGjTpo2CggKTybSwsPDy8jp79ix+EeNr4YNmhlTWnwYuhSdwCCG8iJiUlITdyK9aterWrVu+vr5sNltFRUVbW7tPnz6hoaEZGRngJwfT6OgNGjQI3w64aNu2bb\/\/\/nsDAwNVVVUlJSU9PT1HR8fVq1f\/8ccfZmZmuOCiRYvOnj3L4\/Hat2+vpKSkpaXl4OCwadOmlJQU+ug11Wt6l3Ef6dNi+R8MeRosezvo4OdT6ixuGH3QYKq9bNkyOzs7DQ0NZWVlY2NjT0\/P69evYz9uqIk76OfnBxK3oKBg8+bNkCjPSObl5cEBfc0FfMQaGxtj1To2hv+MBmtsNhteAjBnzc3NvXv3rrOzM\/ZejvXhiYmJ9MgcdnZ2IpHI3d29+eBdH5vAwECpjzOBQJCQkAAinO6H+FuDQTUdz5xAIBAIXzK6urpPnjyR8oKHwbru3NxcLpcLK99IRvsN3rz5fD4spoDaHE5B2GwI+C1b8PPC4XCEQiHefvI1oaurm5OT07zH+BZe8yYQCATClwaHwwHzbD6fz+VyYTE7LS0NJuV8Pt\/Pz08qXAfE3ORwOE19GXwapNa8hUIhg8HgcDgikahRw7qvA3km1UR4EwgEwtcJfVYqEAjAJE0oFMIxPsvj8cAuHX7CAYvFgmxg1Pa5JriwKwz\/5PF4AoEgJiYGtPqfPor2lwNRmxMIBEJrpXm1OaGVoqOj8\/Tp0+Y\/TT5DxC0CgUAgEAj\/BSK8CQQCgUD4gpAr4MInaAeBQCAQCIQWhAhvAoFAIBBaGUR4EwgEwjdNbm7uNx7kozVChDeBQCB8nQQHB9PdqjS1ktrqhHdqaqqZmdkX5THm00OEN4FAIHxzNONYVPYUPUUqpE2jkco+qtdScPfm5ub28S7RKiDCm0AgEL4t7OzseDweh8ORmrwKhUJ8CrtKdXd3hxSBQADe2SBaeW5urp2dHZ\/PB8cvCKHg4GB3d3c7Ozsulwt5WgRnZ2epxguFwm\/ZPQtAPKwRCATCV0tsbGxaWppUIrg+FYvFUspnHo8H7tUCAwOFQiGccnJywj\/BqRmDwYiJiWGxWFAPBAyFgk+fPsV+VXNzcxsN+PahODk5\/fdKvj6I8CYQCISvFl9fXyye8Zp3ampqbGysWCyW1W8HBQWJRKLc3FwckBD8h3M4HHCQjnOyWKzY2NjExER6JTgEeAsK7298bbspiNqcQCAQviFEIhG4B09JSZE6BZG\/U1JSpEIJN4pQKExISGi0HsIngAhvAoFA+IYQi8WlpaW5ubnh4eGNnhKJRPLE8BaLxQwGQywWt+DydqNIrXmLxeK0tLS8vLy8vLy0tLRvNqQ3UZsTCATC14lUKLDly5dDoq+vr0Ag4PF4kMLhcGDFWiAQCIXCp0+fQjwxhBDYo9Hz4HoCAwMRQrDaja3b8LVwwf+O1Jq3WCxOSUlhs9kIoZSUFFtb2xa5SquDRBUjEAiE1gqJKvZVoqurm5OTQ6KKEQgEAoHwVUGEN4FAIBAIXxDyaMSJ8CYQCAQCoZVBhDeBQCAQCK0MIrwJBAKBQGhlEOFNIBAIBMIXRFPx3+gQ4U0gEAgEQiuDCG8CgUAgEFoZRHgTCAQCgdDKIMKbQCAQCIRWBhHeBAKBQCC0MojwJhAIBAKhlUGEN4FAIBAIrQwivAkEAoFAaGUQ4U0gEAgEQitD6XM3gEAgEAj\/ktra2vj4eA0Njc\/dEEJLUltb+948RHgTCARCayUwMPD06dMqKiqfuyGElsTDw+O9eRjyxA0lEAgEAoHw5UDWvAkEAoFAaGUQ4U0gEAgEQiuDCG8CgUAgEFoZRHgTCAQCgdDKIMKbQCAQCIRWBhHeBAKBQCC0MojwJhAIBAKhlUGEN4FAIBAIrQwivAkEAoFAaGUQ4U0gEAgEQiuDCG8CgUAgEFoZ\/w\/p93023DP+bQAAAABJRU5ErkJggg==\" width=\"569\" height=\"144\" \/><\/p>\r\n<table style=\"border: none; border-collapse: collapse; height: 265px;\" width=\"727\">\r\n<tbody>\r\n<tr style=\"height: 24.05pt;\">\r\n<td style=\"vertical-align: middle; padding: 0pt 5.4pt; overflow: hidden; overflow-wrap: break-word; border: 0.5pt solid #000000; width: 111.562px; height: 31px;\">\r\n<p style=\"line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"font-size: 11pt; font-family: Candara,sans-serif; color: #000000; background-color: transparent_id; font-weight: 400; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">No. Reg<\/span><\/p>\r\n<\/td>\r\n<td style=\"vertical-align: middle; padding: 0pt 5.4pt; overflow: hidden; overflow-wrap: break-word; border: 0.5pt solid #000000; width: 144.766px; height: 31px;\">{{nomordokumen}}<\/td>\r\n<td style=\"vertical-align: middle; padding: 0pt 5.4pt; overflow: hidden; overflow-wrap: break-word; border: 0.5pt solid #000000; width: 147.922px; height: 31px;\">\r\n<p style=\"line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"font-size: 11pt; font-family: Candara,sans-serif; color: #000000; background-color: transparent_id; font-weight: 400; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Tanggal<\/span><\/p>\r\n<\/td>\r\n<td style=\"vertical-align: top; padding: 0pt 5.4pt; overflow: hidden; overflow-wrap: break-word; border: 0.5pt solid #000000; width: 260.25px; height: 31px;\">{{tanggal}}<\/td>\r\n<\/tr>\r\n<tr style=\"height: 23.25pt;\">\r\n<td style=\"vertical-align: middle; padding: 0pt 5.4pt; overflow: hidden; overflow-wrap: break-word; border: 0.5pt solid #000000; width: 111.562px; height: 30px;\">\r\n<p style=\"line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"font-size: 11pt; font-family: Candara,sans-serif; color: #000000; background-color: transparent_id; font-weight: 400; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Nama Klien<\/span><\/p>\r\n<\/td>\r\n<td style=\"vertical-align: middle; padding: 0pt 5.4pt; overflow: hidden; overflow-wrap: break-word; border: 0.5pt solid #000000; width: 144.766px; height: 30px;\">{{namaKlien}}<\/td>\r\n<td style=\"vertical-align: middle; padding: 0pt 5.4pt; overflow: hidden; overflow-wrap: break-word; border: 0.5pt solid #000000; width: 147.922px; height: 30px;\">\r\n<p style=\"line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"font-size: 11pt; font-family: Candara,sans-serif; color: #000000; background-color: transparent_id; font-weight: 400; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Waktu<\/span><\/p>\r\n<\/td>\r\n<td style=\"vertical-align: top; padding: 0pt 5.4pt; overflow: hidden; overflow-wrap: break-word; border: 0.5pt solid #000000; width: 260.25px; height: 30px;\">{{waktu}}<\/td>\r\n<\/tr>\r\n<tr style=\"height: 24.05pt;\">\r\n<td style=\"vertical-align: middle; padding: 0pt 5.4pt; overflow: hidden; overflow-wrap: break-word; border: 0.5pt solid #000000; width: 111.562px; height: 134px;\">\r\n<p style=\"line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"font-size: 11pt; font-family: Candara,sans-serif; color: #000000; background-color: transparent_id; font-weight: 400; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Kasus<\/span><\/p>\r\n<\/td>\r\n<td style=\"vertical-align: middle; padding: 0pt 5.4pt; overflow: hidden; overflow-wrap: break-word; border: 0.5pt solid #000000; width: 144.766px; height: 134px;\">{{kasus}}<\/td>\r\n<td style=\"vertical-align: middle; padding: 0pt 5.4pt; overflow: hidden; overflow-wrap: break-word; border: 0.5pt solid #000000; width: 147.922px; height: 134px;\">\r\n<p style=\"line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"font-size: 11pt; font-family: Candara,sans-serif; color: #000000; background-color: transparent_id; font-weight: 400; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Konsultan Hukum<\/span><\/p>\r\n<\/td>\r\n<td style=\"vertical-align: top; padding: 0pt 5.4pt; overflow: hidden; overflow-wrap: break-word; border: 0.5pt solid #000000; width: 260.25px; height: 134px;\">\r\n<p style=\"line-height: 1.2; text-align: justify; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"font-size: 11pt; font-family: Candara,sans-serif; color: #000000; background-color: transparent_id; font-weight: 400; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Advokat:<\/span><\/p>\r\n<p style=\"line-height: 1.295; margin-left: 20.55pt; text-align: justify; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"font-family: Candara, sans-serif;\"><span style=\"font-size: 14.6667px; white-space: pre-wrap;\">{{advokat}}<\/span><\/span><\/p>\r\n<p style=\"line-height: 1.295; text-indent: -20.55pt; text-align: justify; margin-top: 0pt; margin-bottom: 8pt; padding: 0pt 0pt 0pt 20.55pt;\"><span style=\"font-size: 11pt;\">?<\/span><span style=\"font-size: 11pt; font-family: Candara,sans-serif; color: #000000; background-color: transparent_id; font-weight: 400; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"> &nbsp; Paralegal Pusat<\/span><\/p>\r\n<p style=\"line-height: 1.2; text-align: justify; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"font-size: 11pt;\">? <\/span><span style=\"font-size: 11pt; font-family: Candara,sans-serif; color: #000000; background-color: transparent_id; font-weight: 400; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Paralegal Pos<\/span><\/p>\r\n<p style=\"line-height: 1.2; text-align: justify; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"font-size: 11pt;\">? <\/span><span style=\"font-size: 11pt; font-family: Candara,sans-serif; color: #000000; background-color: transparent_id; font-weight: 400; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Paralegal URC<\/span><\/p>\r\n<p style=\"line-height: 1.295; margin-left: 20.55pt; text-align: justify; margin-top: 0pt; margin-bottom: 8pt;\"><span style=\"font-size: 11pt; font-family: Candara,sans-serif; color: #000000; background-color: transparent_id; font-weight: 400; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">{{pararegalURC}}<\/span><\/p>\r\n<\/td>\r\n<\/tr>\r\n<tr style=\"height: 23.25pt;\">\r\n<td style=\"vertical-align: middle; padding: 0pt 5.4pt; overflow: hidden; overflow-wrap: break-word; border: 0.5pt solid #000000; width: 111.562px; height: 30px;\">\r\n<p style=\"line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"font-size: 11pt; font-family: Candara,sans-serif; color: #000000; background-color: transparent_id; font-weight: 400; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Pertemuan ke<\/span><\/p>\r\n<\/td>\r\n<td style=\"vertical-align: middle; padding: 0pt 5.4pt; overflow: hidden; overflow-wrap: break-word; border: 0.5pt solid #000000; width: 144.766px; height: 30px;\">{{pertemuanKe}}<\/td>\r\n<td style=\"vertical-align: middle; padding: 0pt 5.4pt; overflow: hidden; overflow-wrap: break-word; border: 0.5pt solid #000000; width: 147.922px; height: 30px;\">\r\n<p style=\"line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"font-size: 11pt; font-family: Candara,sans-serif; color: #000000; background-color: transparent_id; font-weight: 400; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Supervisor<\/span><\/p>\r\n<\/td>\r\n<td style=\"vertical-align: top; padding: 0pt 5.4pt; overflow: hidden; overflow-wrap: break-word; border: 0.5pt solid #000000; width: 260.25px; height: 30px;\">{{supervisor}}<\/td>\r\n<\/tr>\r\n<tr style=\"height: 23.75pt;\">\r\n<td style=\"vertical-align: middle; padding: 0pt 5.4pt; overflow: hidden; overflow-wrap: break-word; border: 0.5pt solid #000000; width: 111.562px; height: 30px;\">\r\n<p style=\"line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"font-size: 11pt; font-family: Candara,sans-serif; color: #000000; background-color: transparent_id; font-weight: 400; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Tempat<\/span><\/p>\r\n<\/td>\r\n<td style=\"vertical-align: middle; padding: 0pt 5.4pt; overflow: hidden; overflow-wrap: break-word; border: 0.5pt solid #000000; width: 144.766px; height: 30px;\">{{tempat}}<\/td>\r\n<td style=\"vertical-align: middle; padding: 0pt 5.4pt; overflow: hidden; overflow-wrap: break-word; border: 0.5pt solid #000000; width: 147.922px; height: 30px;\">\r\n<p style=\"line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"font-size: 11pt; font-family: Candara,sans-serif; color: #000000; background-color: transparent_id; font-weight: 400; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Koordinator Hukum<\/span><\/p>\r\n<\/td>\r\n<td style=\"vertical-align: top; padding: 0pt 5.4pt; overflow: hidden; overflow-wrap: break-word; border: 0.5pt solid #000000; width: 260.25px; height: 30px;\">{{koordinatorHukum}}<\/td>\r\n<\/tr>\r\n<\/tbody>\r\n<\/table>\r\n<p style=\"line-height: 1.2; margin-left: 36pt; margin-top: 0pt; margin-bottom: 0pt;\">&nbsp;<\/p>\r\n<p style=\"line-height: 2.4; margin-top: 0pt; margin-bottom: 0pt;\"><strong><span style=\"font-size: 12pt; font-family: Candara,sans-serif; color: #000000; background-color: transparent_id; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Permasalahan klien :<\/span><\/strong><\/p>\r\n<p style=\"line-height: 1.7999999999999998; text-align: justify; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"text-decoration: underline;\">{{permasalahan}}<\/span><\/p>\r\n<p style=\"line-height: 2.4; text-align: justify; margin-top: 0pt; margin-bottom: 0pt;\"><strong><span style=\"font-size: 12pt; font-family: Candara,sans-serif; color: #000000; background-color: transparent_id; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Harapan klien:<\/span><\/strong><\/p>\r\n<p style=\"line-height: 1.7999999999999998; text-align: justify; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"text-decoration: underline;\">{{harapan}}<\/span><\/p>\r\n<p style=\"line-height: 2.4; text-align: justify; margin-top: 0pt; margin-bottom: 0pt;\"><strong><span style=\"font-size: 12pt; font-family: Candara,sans-serif; color: #000000; background-color: transparent_id; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Legal Advice:<\/span><\/strong><\/p>\r\n<p style=\"line-height: 1.7999999999999998; text-align: justify; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"text-decoration: underline;\">{{legalAdvice}}<\/span><\/p>\r\n<p style=\"line-height: 2.4; text-align: justify; margin-top: 0pt; margin-bottom: 0pt;\"><strong><span style=\"font-size: 12pt; font-family: Candara,sans-serif; color: #000000; background-color: transparent_id; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Rencana Tindak Lanjut :<\/span><\/strong><\/p>\r\n<p style=\"line-height: 1.7999999999999998; text-align: justify; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"text-decoration: underline;\">{{tindakLanjut}}<\/span><\/p>\r\n<p style=\"line-height: 2.4; text-align: justify; margin-top: 0pt; margin-bottom: 0pt;\"><strong><span style=\"font-size: 12pt; font-family: Candara,sans-serif; color: #000000; background-color: transparent_id; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Catatan Supervisi :<\/span><\/strong><\/p>\r\n<p style=\"line-height: 1.7999999999999998; text-align: justify; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"text-decoration: underline;\">{{catatanSupervisi}}<\/span><\/p>"',
                "created_by" => 5,
                "created_at" => '2023-07-14 07:14:12',
                "updated_at" => '2023-07-14 07:14:12'
            ]
        ];
        Template::insert($template);

        //data keyword template
        $template_keyword = [
            [
                "template_id" => 1,
                "keyword" => 'Pemeriksaan Psikologi'
            ],
            [
                "template_id" => 1,
                "keyword" => 'Konseling Psikologi'
            ],
            [
                "template_id" => 2,
                "keyword" => 'Konsultasi Hukum'
            ]
        ];
        TemplateKeyword::insert($template_keyword);

        //data dokumen
        $dokumen = [
            [
                "uuid" => '9d1d7bff-59b4-41d3-b256-38892a4c9bec',
                "template_id" => 1,
                "judul" => 'Dokumen Dengan Keyword Konseling',
                "konten" => '"<p style=\"text-align: center;\"><img src=\"data:image\/png;base64,iVBORw0KGgoAAAANSUhEUgAAAioAAABiCAIAAADxxm\/MAAAACXBIWXMAAA7EAAAOxAGVKw4bAAAgAElEQVR4nO2dZ1QUSdeAa4YZcs4CkpMKKoIiBgRMIOoSRTEACgoGxJwzKwbMrmlVELMiigoiqCCKCRBRQXJGcmYIk\/r7UWt\/s5MYENd133oOhzNdU+HWrZ6+3VXV9xIwDAMIBAKBQPyzEH+2AAgEAoH4XwSZHwQCgUD8BJD5QSAQCMRPAJkfBAKBQPwEkPlBIBAIxE8AmR8EAoFA\/ASQ+UEgEAjETwCZHwQCgUD8BJD5QSAQCMRPgMSZ1L9+ENraKDV19RiGtba2SktLE4kEPR2tfqwfQiAQ+r1OBAKBQPw42M0PhmHfaX6qa+pycnMzMj6kpmXUNzQQCJi4mDiBAISEhBgMBgZAV2fnYJNh5sMHy8rImJubqygrfU9zANkeBAKB+AUhsBmbPpuf9nbKx0+fb9y6U1RUKCkpaWBgaGczXkVVRUJcQkJCHAACmUyi0egAYG3tlA5Ke1V1dWJSSltbc1Nj41zPOWbDh6uo9NEOEQgEZIEQCATi16IfzE97OyUx+eX16zfq6xtmzpxuYz3e2MiARCJhGNba2sZgMgGGUalUERHhtrZ2cXFxYWFhAoEgKSlBIBBoNNrHz9lPnybm5uXr62nP9Zw9UEOjt7YEmR8EAoH45fgu88NkMj99\/rLvwMHGpqaAJUumTLYTFxPFMKymti4942NlRVn80+eamtrlZcVfv1aZmw17l\/ZeWUVVUUGhm9rt6DCVTCLb2VrLyUoTicSm5tZHcfE3b92aNNFusa+PiIhIL\/rQH+aHTqfn5ORgGEalUiUkJPT19UkkUkdHR1FRkZKSkoqKCsz2+fNnaWlpTU1NeFhYWFhYWAgAMDAw0NHRwfMAANTV1eXk5GCezs5O1rbk5OTU1dX5tAsTWTs4ZMgQmCgjIzNw4EA24dlazM3NpdFogwcPJhKJAIDi4uKOjo4hQ4ZwzQyrFRcX19XVhRlycnIkJSU1NDR41d9jEa5dVlFR4dUpJpNJpVIlJSV1dXWFhYV5qYW\/PLASBQUFfCB6HD7BlQ8AqK+vr66uJhKJgwcPhl+Vl5e3tLRISEjo6OjgMnR3d0tISOjq6oqKiuJN9KrXnB3pl4Hu82j2SlFcu\/Y9Ku3tT7IPHexR7X1TWp8Lci2C\/\/Dhjwsf9F8b7O8wmUyGYHR2du3cE2I+auyFsMuUjk6YGP\/0eWFx6aSpjhMmThs+cpzdlJmLl68zGDRUVV3TdtK035xdR421NR89wWdJ4FzvxePt7Kc4uqzdsC0q+iGdTmcwGM0trcdPnpnu5P7yZYqAYjAYDCaTiX039fX1UCFwUNXV1ZOTk1NSUgAAGzZswLMBAFxcXDAMo9PpHh4euBqnTZsGM3z48AGmrF27FqYMGjSITeeLFy\/m3y6eCBEVFcUwrKGhAQAwd+5cNsk5W\/Ty8gIAPHr0CP50FRUVp0yZwiszrFZMTKyiogKmKCsrL1q0iE\/9PRbh2mWunWLrvqKi4rNnz3iphZc8bDVramrevXsXwzA+w9db5WMYtnXrVpjS2NgIU8aMGQMAGDduHGdVsrKyUP996zVbR\/ploPs8mr1SFNeu9YtKe\/xJ9rmD\/NXeZ6X1rSCv09vDwwPDsKysLDKZPGvWLOw\/QR\/tZ3FJmcec+aVlZZG3rnvNn8NkMvMLikOPnLh+\/WZDfb2SsrLJEOPZsz2oNGp9fe3UKVMXL15iZ2ejOXDgNPvJsrIyYqJilRUVZBJJWkqitbUlNPRIc0vrs8RkMokU4O8bun\/vyTN\/Hj72B5VK7Zt4fUBMTAwAsHLlSjqd\/v79+7a2tg0bNsA7bjKZjGcjkUhCQkIAgOfPn9+8efPAgQN0Or2lpeXEiRMww40bN8zMzEaMGHH37l2Y8uDBg\/Ly8uDgYABAbGxsUVHRrl27+LcLE5cuXVpWVlZQUJCamgoAgHfTnM+FnC3u3btXUlLy6NGjAIBbt261trYeO3aMV2YJCQn4ISgoCH4QFhaGAvS5CNcuc+0UTFy1ahWDwcjIyKBQKIcPH+alFl7ywMxr1qypqqqKiopiMBju7u5paWl8hq+3ygcA1NTUGBgYAABevHgBAGhubn737p2+vn5bWxte1dq1axkMxtu3b5ubm8+dO4en96rXnB3pl4Hu82j2SlFcu\/Y9KhX8J9nnDvJXe5+V1reCvE5vMplMpVLnzZtnamp68eJF8J+gL+Yn\/f2HRYv9ra3HHw3drzlQ\/c27dN\/FS1euXnP12nVjY6NHj594uLstmDdnqZ\/3pQunTx8PPRCye8fWjZs3rDl86ODWTeuvhP+5fvWy40cOLvZbRKPSKB2dwiKiW7bt2r5rz5GT5yorq3R1tE+fONrU1LR9V3B7e3u\/95kr8AxmMBgEAsHMzExHR6erq4vzXBcWFoY5MQwDAKSkpFRXV0tLS8NHaSaTeeXKFScnp+nTpxcWFsIzWE9PT0NDQ0ZGBgCgpKSko6OjqqrKv12YSCKRBg4cqKenZ2JigudknYPi1aKamtqmTZseP36cnZ0dGhq6adMmY2NjXplhtS4uLpGRkVFRUbCPeCt9KMKry3w6RaPRAADDhg2TlZWFkypc1cJfHhKJpKqq6uzsHBERQafTjx49ymf4eqt8AEB5efmkSZOIRGJMTAwAICoqSk9Pz8DAoLGxEa+KyWQCAJSVlYlEooWFBatsgveasyP9MtB9Hs0+nKVsXfselQr+k+xzB\/mo\/XuU1r8\/NxKJtGzZss7OztjYWNyG\/er02vykpWds3LzNe8H8wOX+oqIid+\/HlJaV02h0ExPToUOHFRWXTHOYMsPR3mz4sIbGppbm5sio+7uC9y9ZFuQXEBiwfPXmbXtu3o6qr6+XkJBwmjHtjxOH\/f28rcdZFRUXqQ9QTU19t2X7rjfv0khk0paN6zTUNXbuDm5r+ycsEBzjioqKuLi4oKCgzMxMPz8\/eJaznusiIiJwKsDW1tbBwSE6OlpbW9vHxwc+IMfHx1dUVLi5ubm4uAAArl+\/zla\/gO3CxIiICD09PU1NzWvXruE52SZ8ebUYFBSkqKi4du3axsbGTZs28ckMq50+fbq5ufmyZcuam5tFRERwaftQhFeX+XTq06dPJ0+enDlzprGx8e+\/\/85LLfzlwZ+VbWxsxMTE8vPz+Qxfb5UPACgrK1NXV7eysnrw4AGGYdeuXZsxY4aEhAQceljq5s2blpaWgwYNGjdu3LJly\/rWa86O9MtAf89o9vYsZeva96hU8J9knzvIR+3fo7T+\/bldvXr1\/Pnz06dPxxe9\/gNwee2UD5kfP2\/asn3u3DkL5s1pb2\/\/+Dln374DYuLiRKIQncE4EBJsoK\/T0tL66PHTmNiYLzm5ZLKwkaGhlaW5lJS0EInMYNAp7W0fPmbv3LOvrbXF2Nhw4sRJE23Gj7EaXV5ZdfbcxY8fM43NRxw7cdLd1dnd1TlgyaKTp8\/t2hO8Z9cOzgfb\/gXetyYkJOTl5RkZGT169Mje3j4vLw8AQKfT8Wx0Oh1OghGJxIcPH169ejUkJCQ8PDwjIyM9Pf3ChQtiYmLw0VhYWPjmzZsHDx6Evw34tARb6bFd+EsYOXLkvHnzaDTaiBEj8Jxs5odXi+Li4l5eXocOHQoNDcXn67hmxvt1\/vz5UaNGbdu2TVxcHPu2\/aQPRXDYugw\/cO1UQUHB1atX09LSbGxsZGVleamFlzwwM7zjhmXpdLqCggLsONfh663yAQClpaXS0tLu7u5BQUEJCQlJSUkhISGnT5\/u7Oxsb2+HeweMjY3nzp2bn59\/7NgxS0vLjx8\/wrK96jVnR\/ploIlEYp9Hs7dnKVvXuA69gCoV\/CfZ59OVj9r7XGffCvI5vR0cHGg0WmhoqImJCVzz+y\/AthbEZ+tBaVnFhIlTz1+8BPcIzPL0Hms9cco0JyfX2afOXGhobKLT6Vev37YabzvJfsbFS1fKKr7y2S9QVV1783aUk+tsyzETLoRdptFoNbV1x\/7402K0tb6x6dPEF7W19VQqlUqlhh4+vmrthh+99QDu1PLz82NNbG1tBQB4e3vDQ7hsuGvXLtY8dDp9zpw5AIDExERhYWETExMPDw8PDw+4tycxMRFmg4tDKSkpgrQLE1l3KOCJgYGBeEpdXR2fFs+fPw8AePLkCf\/M8CISFhaGYdju3bvJZPKQIUNWrlzZtyKssHWZT6d8fX0xDIM3xcHBwbzUwksetpojIyMBACdPnuxx+ARXfm1tLQAgPDz869evRCJxwoQJRkZGGIatWLECsOz08\/f3h\/lXrlwJAMjKyupDrzk70i8D\/T2j2duzlK1r36NSwX+Sfe4gL7V\/T539+HOD4vn4+DQ3N2toaEhJSZWWlmL\/CQQ1P11dXbPmzN+z9wCVSq2tqz96\/KT5aOvR4+yePE18l\/qewWB8yPxs7+g009n9bWo6LEKj0fLLvpRWFcFdbbzIyPw0b8Eia7spr968g0bObsr0ZYGrNbT0b92JZjAYFErH+k3bb0Xe\/aHmB6524qc1jpWVlaSk5IMHDwoKCnx8fIhE4sePHzEMKysri4uLKywszMrKcnV1JRKJcBtPTEwMLHjv3j3W6xFcW37+\/Lkg7cLf2JQpU+7fvx8ZGXn16tWKigqY093dPTo6+vbt21euXNm3bx+fFk+dOgW+bYvCMAwuSnNmhqtrZ8+exTCMTqePHDkSABAQENC3IqywdZlrp2Cil5cXhmFMJlNXV1dFRYVKpXJVCy958JoTExMPHz4sJSVlZmbW1dXFZ\/h6q3y4Wh4ZGYlhmJ2dHQBgz549GIbB+a5Xr17BUs7OztnZ2TExMXp6egoKChQKpVe95tURXh3v1UB\/z2gKriiuXYNGorcq7e1Pss8d5HP+9LnOfvy5QfHmzZuHYRhcLpo+fTr2n0Ag80On048cOzVnnk9DQ2NXV9eqtZusJ04zGzVuqqNzbV19R2fntRu3LcdO+PPipbb2dliku7vrVPTvI4NkRq2Su5F4jkaj8rFAHR2d12\/eGWNtd+KPs+3tlKeJyfO9\/UaMHHvw8IkTp\/5kMBhfq6pnOLnn5Ob9OPNTV1cHAJg9ezZbenZ29rBhwwAAAAAxMbETJ07A9NOnT4NvyMvLnzt3btSoUUQisb29HWaAy6cDBgyAhyEhIQCAp0+fCtIuTGQlISGBM3Ho0KF8Wjxy5AgAAN9Cyks8WO3Ro0dh+sePH4lEIvzN96EIK2xd5tMpT09PmGfLli3wksRVLfzlgUhKSnp7ezc0NPAfvt4qH94Rw0sDXJT+\/PkzhmFwE2N0dDRrKTk5uZkzZ3748KFvvebsCP9TS8CB\/p7R7O1Zyta1sLCwPqtU8J9knzvI5\/zpc539\/nPDN1tbW1sDAGJjY7FfH4FeOy0uKZs1Z15E2HkjQ\/2Ll659zvqSlPR05YrAYcNMhwwyOn\/xUuyjR+vXrZ0wfgxepKAye8VpF4yAAQDESVJ\/LL83QIH9hSw2Pn3+snP3HmNj403r1xQUlSxZuqK7q9PKaozXfE\/LkeYvX725FHH5zB\/H2LaXgH\/E60FFRUVdXZ2hoSHrnpPS0tL6+noZGRlNTU04T434WVCp1M7OTgzDZGRkOE8GrsPX78CbISEhIV7bTASBf0cQOP07pkjtPwWhnTt38s9BpdJ27dk7duyYGY72GZmfDh0+SmcwdHR07WwnjDQffv5iRNzjx\/tD9o60MGMtFZ92T4QkttPzzMxR87NK0hVlVHVUDfk3pKKsNNrS8l70\/Q8fP89ydTI3G\/72bVp3V+e4cWPl5GT1dLRepLzq6qYaG7HX8w+YH2lp6QEDBrDZGFlZWTU1NXl5+e+53CD6BSEhIVFRUVFRUa5nAtfh63eIRKKQkNB3vovOvyMInP4dU6T2n0LPP5X8gsLXr98sXeLb3U29dPmaoYFhZUW5grzs+LGjYx4lREVFhewNHjLYiK1USVW2vLTiQBXtgSraImSRwoovgkijpamxN3jXhw8ZtyKjRlqMmOvpsW3LpkdxcXt+308gENauDrpx83Zra1tfOopAIBCIfxM9bLym0ehnzp1f6OMtLi525+791LT0cWNGr1oVZDN+bHll1c5de44fPTRkELvtodKoX2oz2ymtnrbLOrsoH0peksiC3hJqqKuFHtjv4Tlv+LBh7m4uixYvKy4ulJOTL6+s0tRQMzI0SEp+OXO6Q1\/6ikAgEIh\/DT1YhdKysowPH+Z5zqbR6OYjzOIe3h07xkpjgIq8nOzmLdt8vBeMsRrFWaq+paa+uUZSTNon1G7lOTcJUdn8quzG1nrOnFwZMtgoePfODZs2EQjgctjZRYv86hsag0MOAgDmz5sbHx9P\/bZDH4FAIBC\/KD2Yn7vRD8daWUlLS+YXFG3ZvuvMuQtDTU3GWFm+eZtaWlrqvWAu15nusrr8mpaytKLnxU05eTWZeTWZVU3l9a3VgovlOG0qiSwcE\/uY0tH57OkTYTKpuqqqqLhMT1ero7M763NW73qJQCAQiH8Z\/MwPpaMzLS3NwcEew7Ck5Je5uXlxcY9Lyyo6O7vO\/nl+aYC\/lJQkZykMw5IyYzppHayJTR21GQWvBReLTCItC\/APvxTBZDDGjBkzfPgIPT39xOcvAAAzpju8TX0veFUIBAKB+BfCz\/wUFZdQ2inmI4YzGAwlRQV1dXUjI6MRw03zC4oKC4ucZk7nWuprfdnz7Iec6XEZtyhdvfDeZmdjTaczMj9lTZ5o87Wq6tWrlKh796lUmsmQIe9S33LuDkcgEAjELwQ\/81NZUaGorCwlKZGannnw0NH6hkZ1dXVJScmHsXEzpjuKinKPCHcnJYwsRNZSNGBN1JTVL63Je5X1hDWxvbMt4V3026znXG0JiSTkMcstKuqekaG+u8vM7u5uGWlpJsY00NdVUFCqrqntfWcRCAQC8W+B3863F6\/eWo8bAwAwG2YyfbrD3ahor3lzKJSO9+lpgYGBXItU1VfEpF5ZMnX7tZcnWNOH6oxSkFKNeHZ0wrBpwqS\/tur\/Eb0r4sURYZLISd\/osaaTOWuztLS8E3W3qrq2urZeVlbuc9bnW5HRXvM8REXFPmRkDHCw72OnEb8IfIJscoYKxcnIyCgoKFBTUxs9ejR8JSsnJ4dOpw8aNAge1tXV1dTUaGhoVFRUwECZ\/GNQssW0hZnZImzyipjJNVSloaFhXl4eWw2QlpaW8vJyDQ0N6IQU9D72JZ9QsLi6+Efg5RUmFYHoZ9i8ILA63Znl6ZWYlEyj0U6cOjt5mvPQEaPz8wuyv+TaTp7WTung6v9mR8TSdefmx765NXy5mLE\/wP9s12s+Tbtvv8Uo7t0dPLPvkanG\/mBwAPHqkxNca6PR6PbTnVLT38c\/SQpas8FrYcCBQ8cYDMatyLtRd+\/1r9MdxL8Q\/kE22UKFYhhWU1MDXZJATExM8vPzMQwbPXo0AAB6wcG+ObV8\/fo1+ObLhFcMSq4xbaEAbBEneUXM5BqqkmsNEOiK5urVq\/Cwt7Ev+YSCZVUXnwi8vMKkIhD9Dr\/Jt67ODhkZGSqNVvm1trSk2NHRUVlFpaWlWUpKWozbzFt+WfbzrIcLJq58mhndRf\/bvVVNW0VFfYmz5cLLz47TGTRo9sx1rQEAwiRRfVVTrgIQiQQNjYFlpeVGhnpFJWUNjY3lFZXd3VTNger1DS18JEf8N+ATZJMzVCiGYS4uLmlpaZGRkc3NzWFhYXl5edOnT6fRaM7OzgCAp0+fwmqTk5PNzMyGDh0KABAXFwe8Y1ByjWkLBYAF2UTljJjJNVQl1xpY68FDJ\/Q29iWv\/Gzq4hOBl1eYVASi3+FpfppbWplMppi4OElIyHTIoGHDzYqLS+h0el5+kZYW+4wBAIDBZMSm3Zw5ch5JSDi1MIntWybGTM6OmTjit8a22lefngIA8iuy7r4NAwB00zqP3NtCo3OPq62vq1tQVCIqKlpfV19QkDdk8CACkSAsLFJUUtLXLiN+GfgE2eQMFZqUlJSSkhIUFOTq6iojI+Pt7R0QEJCbmxsXF+fh4UEgEGJjYwEAlZWVmZmZ3t7erNFjecWgxLjFtOUadpZXxEyuoSq51gCBgdTgV72NfcknP5u6eEXg5RUmFYH4EfA0P03NLSQSSUpSsrOrKz4hPjcnZ4TZMAlx8faODlkZac78QkSh2TZLFk5Z+\/zjw4Y2Lq\/4fKn80EZpnm+3Mur1xYaW2qeZ0WWNBQAADGAfKlLSclK4imFspFdeUUEikeTk5Ts7OmLjHndQOsTExDM\/ZPS1y4hfBj5BNjlDhb59+xYAMGHCBLy4jY0NACAnJ0dLS2v8+PHJycltbW0PHz4UERGZN28erIf1P2cMSq4xbVmLsInKGTGTa6hKrjVA4BQZ\/N\/b2Jd88nOqi6sAfML1IhD9Ts++cISEhEaNGiUhIV5dXc1gML5WflVVVuaaU0VeTVhYJDb9BgNjcH7bSKl5lZPgZu2jqaC\/\/LjLhYR9rN\/eexvO9QGI\/O02sLW1RV1dXVtTC\/n3\/N8BD7K5Zs2asrKyR48eBQQEsMbTjIuLExISgqv0DAYDANDd3Y0Xh7f88OFg7ty5NBotISEhOjra1dVVXl4e1gOfb+B\/GIOyoaEBj0EJY9pGREQYGBiEh4dPmjQJrjXiRdhE5YyYiYeqdHBwCA0NvXTpEp4Z4\/3yAHz6wWNfXr58Gca+ZDKZXCuE8MnPqS7ALQIv1xr6MHD\/fuTk5AiInwHrfpaezQ+Dznj67PngQUa6ujoYwDQ0NKpqanhlbu9o85u4OcTjyjg9Bykx2RCPK\/ZDPWRFFTfOOB7icWWwurkQkbR61t7r215eWP5URvSvcLZDNUa\/zUmobqzgVa28nGzcgzvKqmrZOblUKvK4878CvPZ5enpmZWVFRUXBeNv49ff169cRERFPnjwJDQ0FAAwfPhwAcP\/+fbx4TEwM+PY8NGvWLGFh4QcPHiQlJfn6+uL1QKMF\/9Pp9OHDh2\/btu3s2bNdXV0wkUgkzp8\/\/9OnT3PmzMnMzPzy5QtrQTZR8aef6OhoGo3m6OgI0xUUFK5fv66hobFixYqysjKuNUC+fv0K89fX19+\/f19PT6+ioqKiosLAwKCysjI5OZlrhQAA\/vk51YXLjAeu5lXD947iv5Lm5uaftuD+v01zczM+CjzNj6SEBIPB6OzsJBCJomKisrLyjU0tdDpDTFSko6OTVykFGaVpY91nWs\/RH2AiKiw203rOIJ3hEsLSU0Y5z7SeY202Fc9JJgmTiH\/NfRtqDLUx\/e3J+2jOCnPzi5SVlLq7qU+eJjLotOHDhklKSnR3d+no6vflpEP8UsArI+3vLv7gIfw\/e\/ZsXV3dEydO0Gg0e3t7MzOzixcvbt++\/d27dzt37oyIiJg\/fz4MWiwrKzt16tQbN24oKyvDSTlYAzQYrP83b948fPjwrKwsKpVaXl7++PHjoqKi3NxcKpVKJBJVVFRYC7JJVVJSkpSUdOTIER8fHzMzM19fX1xaGRmZ48ePt7W1LVu2jGsNmZmZ6enpR48elZWVHTp06LVr16hU6v79+2\/cuHHjxg04Y3bz5k2uFQIAeszPpi48ETc\/vGrot+FEIP4OT\/OjpChPJBLbKRQRYbLZsKFv3ryq+lopTCYbGuiWlfN8TBEcMREJMvmv7T0q8mr+jltGD7LlzJaXX2hspF9XV3fi1LmRI0cONTUhEgnd3d0mQwZ\/vwyIfzldXV34fxw4vQYvnQQCYc6cOTU1Nffv3xcSEoqNjbWzs9uzZ4+lpeXvv\/\/u7+9\/\/vx5vOCMGTO6urpcXFwIBAJeD3z9hfW\/kJDQhQsXiERiZ2dnTEyMvb29np7ekCFDEhMTz5w5o6SkxFqQTar4+HhbW9vt27e7uro+efJEREQEpkNL4+zsbG1t\/fDhQxhHma0GR0dHCwuL8vLyS5cuiYqKXr16lUgk4ktZcEN5dHQ01wofPXrEPz+nunCZcfPDq4Y+Dh4C0RP8XjslC4u0t7USCEQxMVEFBaWiooK6ujoZGdmmpkYajU4m9xCsoYeGhUjSYnLNHfVEAlFeSlFVQUOVIxwqk4lVfq3U1tJsaW2j0xklRflDBhmQyeS6ujplRdnvaR3xS6CoqIhxLJCwJQYHB8MNxAAAVVXVhISEysrK2tpaHR0dfJED4ufn5+fnx7UetjpNTU3xmTEHBwe2mLa8pOru7uaMmMmW+fnz5\/DD\/Pnz2Wp4\/\/59Z2fnwIED4b4DuJMCR05ODq+Ha4UODg6C5GdV18aNGzdu3Ih\/xadFBOJHwG\/tR1lZuai4lEQSCli88G7kNY9Zs169TVNUVBATFfmUJVD4OD4MUBzoPnbx8IHjxhlMmzlqAdc85RWV3V1diopKbe3tFEqbrd3E8ePGAQBS0z\/wcvmDQKirq5uZmbHZnj6jpaVlbm6ur6\/fY2BNYWFhGRkZWVlZQp8iZiorK2tpaX1nsFQE4heC37k+YfyYlFdvAAAtLW1Hjp28fvP2h8yPigryg4wHpaRw3yctOCQhkrioBFmILEwWERflHq09IyNDQ0NdUVHhxYuXVV8rN2\/ewqDTAQAtLS16emjtB4FAIH5h+JkfPT298vJySkenpKR4Vm7RKEurkpLS0rIKF5ffbt6O+geEC4u4Ot1xWmNjU+r7T95eXg+i7yopKVRUVnW0t+rr6f4DAiAQCES\/QKFQcnJyfrYU\/y74mR9dbS0REeFPn7KIRKKEKDn5eVJxcUl9ff0gY0NlJcXH8c\/4lJWXUjJSGg4AkJNQUpXRJAmROfMoy6iZ6ozUG8B9E8Hb1Pft7W1jrCzT0jNaW5sTk57n5HwBAGRnfzEwHoTmKBAIRL\/T2to6efJkfHbH29tbwFITJ060tbV1dXW9ffs21zxfvnzZuXNnP4nJ3rSNjY2Njc2DBw84RfLy8srKygIA0Gi0oKAgGxubOXPmUCiUhoaGJUuWsFZ15syZqVOnenh4lJeXw5Ta2lpvb2\/oB+RHwG\/7gIyMtKmpadLz56MtLfHJKNIAACAASURBVJx+m15aVqGrq62uri4mKrZooc\/JU6esrceIiYoCANra24uKSoYNNcHLutsucrSaDQCwN3cfYzRZTkqes37LQTYjjcZzXd7EMOyP02fcXF2kpaWUlZUGqqu1tLTYT51CIBBiHj1eMNeDswgCgUB8J62trUVFRYGBgampqUQi8eXLl\/hXTCaT111va2trS0tLampqeXn5kiVLysrK1qxZ02Op\/hK4paXlzZs34O9uLHCRnj596uTklJ+fDzfWJyUl5eTkEAiEzs7O9PR0PP+rV6\/u3r0bExOTkJCwdOnSBw8etLe3+\/n5ycjIwHfRfgQ96MX5txmPHsd3d3fbThhPIpOzs7M3bt5aUFg0ZZINgUCMfhDLxLB2CuXo8VPrNm1LfvH\/C0LSErKqCuoAAAlRyQGKGkQiF1cFQkQhMklYmCwCAIh9\/CT9fSaV9pc30sTnL0uKS+Z4uF+5eis8PGLd2lUH9u2VkpIsLa+kUNoMDQ37UwcIBALxDS0trWHDhkVEROApTCZz4cKFDg4OFhYWrOlsEAgETU3Ny5cvHzlyhFep9vZ2W1tbtk2GvYLJZDo4OLC9DEcikUgkEueeFwKBMHHiRPiOrbi4eFZWVmtrq7GxMae729jYWE9PTxKJZG9vn5qaCgCQlJSMjo4ePPgHvuLSg\/kx0NfT0tR8EBMHAHC0nywvL79ksZ+Bvi5RSGj3ru2HDh0uKSm7Gx1TWFQyZdLE9IwPiUkve+ulo7ub+uLVuzuRUT6+i7du211bV19VXbt9565tW7dQKB1Xr117\/fbdqtXrtLU0AAAPHsSMGzuGa5BvBAKB+H6YTOaePXtCQkLwF7Pu3LlDJpMfP378\/PnzrVu3sjp24kRRUREA0NHRwVmKRqN5enquX7\/e0tKyz+IRicTZs2ez+qstLCx0cnJycnLKzMxkzdnS0nL\/\/v2lS5fCd93c3Nzs7OxMTExCQ0M555xqa2vhZlECgUAmk7m65Oh3enh3R1xcbMli33XrN7u5\/ObjNdfCfASlo2PRkuXjx49f5OXp4+MTtHrtkUMHi4qKGhvr29o7nyQ8fZ+RsdjXR0AL0dzcErAiiEggLvbzzcnNsbWzZTAYa9dvsrWxmTxxQuzjpwcP7CspKWlqagQAtFM6nj59dv7cqX7oNwKBQPBAXV3dw8MDPsQAALKzs83NzQEAEhIS6urqNTU1nHECceh0Oo1GExcX5yxVWFjIYDBYQ1L1DS8vL9ZDbW3t8PBwAICUlNSJEydiYmIGDBiwZ8+e7u7usrIyFxeXSZMmAQAIBMKOHTuWLl3q7Oysrq4+fvx4AACeX0ZGhkKhwAqFhIT+GdeaPU9KmpsN09HRunTlOoZhzS0tq9estRw16urVKwCAxYu8hwwesmnLjiV+Cxf5+NTW1tDo9Jkzpm\/curO8oofpwq9VVZu27lq+an3g8mVNzc0qKkrr168bZWG2\/+BhCUmJbVs2FBWX\/b43pLi42NV5pu9CbwzDTp4+6\/Sbo4ICl2UkBAKB6EfWr19\/5coVeEXW1NT88uULAKCrq6u2tnbAgAEYhtXwcH25f\/9+GF+Ks5SxsfHy5ctZ333uG1VVVayH0I2srKyskJDQihUr4uLiwsLCAADKysrLly+fPHkynJSrq6sDACgpKdnY2MDPAAA8\/9ChQ+GUYG5uroGBwXdKKCA9mx9RUdE1q1edOnXma1W1laXFokW+GR8yS0pKPeb65OUXbt28Xl9PNzBoXWdX55mTRw0MDd+8eycnKztAVRkA8CLlbean7LKyisqv1bV19TW1dV9y8z98zN4fejQ3rzD5RUpBXl5jY9OmDesaGppGWYxYu34ThUIJCd71OSvHZ5Efpb391Jmz1TW1AIDsnLyXL1NmzXL\/4SpBIBD\/qxCJRLhTQFJScv369dA\/5uzZs798+fLbb79NnDhx7969ZDI5Pz8fPlJARERECgoKbG1tJ0yYUF1dffDgQc5SwsLCRCJxyZIlJBLpzz\/\/7LOEDAZDT08PnwDEBebVEZzr16+PHj3a3t4+JSXFy8uLLYOHh0d2dvbMmTN9fHwOHDgAAKBSqdOmTQsLCzt16hQehrF\/IbBNAkKnpGyZMAzbsev3tva2kODdAIC9+0OZGMjOyiKRhbdv2aijrfnHmT+fPHmyZvUqkyFDIu\/en+4weaCGWvaXvEsREa6uboePHhsxYoSwsMibt2\/cXZxpdHrw73t37tiWkPBsqKkJSVh46ZKFr16\/Oxh6yNTUdHXQiqLi0mdJybdv3\/bx8tbV1bIeP4ZOZwQGrV0dtHzYUC5xUaEf7x+hHQQC8Z+EQGC\/9OGw7lXDMAy\/tlAoFHFxcfxQwC1trKUYDAYeQfF7ZrfodDrr2g8vSTjT4fqTpKQkrwwdHR1cg\/D2I6yaF8hvG4FAWLNqpfuceddu3PZa4Ll7x5bYx8+Snierq6mfvXDJ+TfHlcsDTIcM2R28d9zYMSuW+auqqLS1U\/buO9BOoXR2dubk5MhKS+obGBXk5RKJxK7OzkGDhyQ9fxHg76ehpipEIu35ff\/j+PigwBXTHR2qq2t27N5bUlwweLBJUUmxj5ensLDwnxfOammqc7U9CAQC0Y+wXpFZ72vxqLKc2fjAWgo3Od+5ssIWJ5eXJJzpIiIieBx3rhl+tO1hQ6CnH8iXnDy\/JUv37N5lO2FsUUnZiqB1RAKQEBejM5l7dmwbZGxQW9dw8o8z96LvT5k8ce5cT3W1AQwGMy8vl8EESc+T9fUNJMVF8woKp0+zl5aW0hyonl9QfPX69Xv3HkyZPHHF8qWqKsqnz118FPe4orx8w4b1mZmf9u7ZRiaTIqOiU1JSQg\/sExLirmX09INAIHoFn6cfxA+FVfM8zU9jU\/PigMCxVpZeC+bKy\/3lvTHhadLOXbuD9+y2nTAOALBu43ZDQ4NbtyOXL1tKBMwRI8zU1VRr6xqu3bj14MHDltbW8WPHDB1qqqo6QF5eXkpaqqurq6amtramOvvLl2eJzyXExR3sp86bO1tdbUBuXkHyi5RrN24OHmzy7t3rFcuWLpg3BwBw+050WHh4+MU\/lZUUcSEfxDyiUDpnz3LB+4PMDwKBEBxkfn4WApkfAMCVa7d27tptYmJyYF+woYF+VXVNeMQ1bS3Ns+fO7dy+3WbCWCqVFhZxNfpBLJ1OI2CMO7euS0pKwEraKZTa2rqXr97l5uW2NjfWNzTBaF2qyopiElKGhkYTxlupqqpKSUpAy9HZ1XU3OvbIkUP6+obHjhyUkpQQExOLjLp\/6syZVStXkkkE+6lTAABNTc0HDx9PTHz659kzJkMG4f1B5geB+JeAYdiff\/45b968f3gmhxUmkxkaGurv7y8tLc01AzI\/Pwt+5ofJZObmFbS0tNBoVEpH1+Ejx0ZZjk5OTjpz6uSmzduam5u0tXXGjhlz+cplf\/8lHm7OABCev0j54\/QZ34U+9lMm8mqyqbmV0tEhKSEuK8P9bAAAtLa1Hz\/5x\/y5nhrqahgG\/rwQHnknynfRothHsVVVVdMcpqwOWrlj914xMYnPnzOPHDpYWlqqpqauoqxEIgkh8\/NTaGpqotPpioqK\/wH9M5lMBoNBJnNxTvhvbut7huBHDB+DwViwYEFUVFRaWhqMMwv50eplqz8vL8\/MzExDQ+PJkycDBw7kzP+zzA+FQikvLzc2Nv7nm\/6XwKp59tUUBoN5+dqthX4B92Piox8+olKpTjMd9XR03Nw9TE1Nrl25pKKiHJ+Q4L\/E\/+y5P\/eHHmlobLSdMO70iWOTJ3KJVYpTV1cXF\/+Mj+0BAIiJii4L8NccqFFbV791x67o+w8C\/JfcvHVTQ0MjIvxiecXXufO9W5qb7Wyt29o7rt64ExP3NHDV2vLKH+WP6FfH2dlZW1sb7qHkpKamRvsbbC5AYEFNTc0BAwZoaGiMGTPmyJEjrCFHGQzG0aNHdXV15eXllZWVVVVVN2\/ejGeAxQcOHKiqqjpw4EBLS8vg4OCOjg4BBYDFbW1tWa8OI0eO1NbWLi4u5trHvXv34imRkZHa2tqsFz7+zbW3t+\/YsUNXV1dERERYWFhCQmL16tVcK+evT0FU19u28MPXr19ra2vr6up++vRJkCHgL22PZSFv3ryZPXu2mpoaiUQSFhbW1tbGX0vkVDvOnj17rl27dv36dTgEvLrs7u6uzY2ZM2fy0gZXrfKq39DQ8OHDh0VFRW5ubng4V0Fwd3e3+YatrW1TU5PgZQXhRzge5e8Y9MWLF9bW1tXV1XhKQ0PDwoULLSws\/Pz88B8mm79RtjrpdPrWrVunTp06Z86cxsbGfhMd+ztMJrOrq3vpitXbdwV3dXWXlJZX19TOcHJfs35LV1cXg8FobWvbd+DwmPG2N27dnTPPZ7qT2\/MXr7q7uxm8uRl5123W7MGmw7fv2F1RWcUnZ2dnV2xcwiT76UsCVly9ccdqvO2JP850dHYyGIz2doqPb8B8b7+q6trKqmoKpWPjlp2JSckMBoPJZGIIDmDU5F27dnH99uzZswAABQUFAMCmTZs4CxobGzs5OVlZWcFb4+nTp8NvGQwGfKuOTCbb2tqOGjUKZhgzZkxHRwdefNCgQU5OTuPGjYPfzp07V0ABbG3\/uo+5dOkSnqihoQEAqKio4NrHzZs34ylXr14F32KMCtKco6MjAEBeXt7BwcHe3t7IyGjLli2slW\/dulUQfQqiut62Bb\/t6uoyNTVlbbrHIeAjrSBlMQwLCQmB6WJiYpqamtLS0rKysmzdxKXFycvLI5PJbm5uPap38uTJurq6pqamSkpKcFwGDx6spaU1Y8YMXtrgqlU+KsUwDJqi06dPc44U56UPAn0WGBkZNTc30+l0PJ1KpXJqEv9Mo9FYv2I7ZC2bmprq4eHBtem+0dbWNnPmzPnz5584cYLzWxqNZmtra25unp+fjycWFhamp6dTqVRHR8dTp05hGJaSkjJlyhQajRYbGzt9+nTOOi9cuODv749h2MmTJ5cvX\/49ArNqnov5YTAYrW3tk+xnvH6TWl\/f4OLuuXL1elYjQaPR4xOeDTIdsXf\/ofNhl0dajfdfGpidk8fLqDQ3t9pMsldQHhAZdZ+P7Xmf8dFzno+13dSrN+7s3B0yYuSYhKdJNBqN1Th5LVzsu2R5U1Pzk2dJm7ftgunI\/HBl8uTJAIC9e\/dy\/dba2ppMJh8+fBgAYGhoyPrV1KlTAQDnz5+Hh7du3YL2oK6uDsOwkJAQeH3\/9OkTzBAfHy8qKgoAWL16NV48LCwMfnvhwgUAgIyMjIACODo6kkgkcXFxJSWl+vp6mKinpwcAwA\/ZRN29ezeecufOHQCAhoaGIM3h736XlJTgOfGLjr29PQAgODhYEH32qLpetcXar5UrVwIAZs+ejZ\/nPQ4BH2kFKQtDBpDJ5LNnz+KXzurqarwSNmlx4MuJb968EUS9kBUrVgAA\/Pz8WBO5aoNTq9CnAJ\/6a2trSSTSoEGDMA54mR+IkZFRW1sb\/Pzly5epU6c6OzuPHTu2tbU1IyPDwcHB0dHRxMTk+vXrtbW1kyZNcnd3V1RUPHDgANshW1msP8wPg8Gwt7dnM4chISFczc+hQ4cuXrw4ceJEVvODExgYePLkSQzDtmzZEh4ejmEYk8lUUVHhrHPNmjWXL1\/GMKysrMzc3Px75GfVPPetzBLiYiuWBRw6cuzoyTPFxUXbt25i\/ZZIJEy0mxD\/6GFBQUF4+KXFfou1dXS9fXzne\/vFxiVQKOzTLAAAD3f306fPSEtLcX7V3NJ6L\/qh40zXVWvWjrK0nOfpeerU6eqamkcPo+1sxrPuTBcWJu\/fG5yennbk+OmwsIjFvgu5Co+AwHcL2F4RgBQVFb148WLSpEmenp5EIjEvLy8jI4OtIP5UPnHiX0t6TCaTRqPB+Zzt27ebmPwVX2Py5MmBgYEAgDNnznR3d7MVt7CwAN8eOwQRQEhIiMFgeHp61tXVwWoBAPBlBc6+wLZY36LgTOHTHB4\/mzVQCl4Wnnts72pw1acgqutDW0JCQpGRkceOHZs0aVJ4eDi86xdkCHhJK0hZDMPWr18PAAgKClq8eDG+mqKiooLXwyYtzu3bt9XU1EaNGgUP+XcZAiVkewGFqzY4tYr3jlf90MHMly9fKisrQV\/R1dWNjY2NiooaNmzYixcv6HR6TU3NnTt3oqOjT548GR0dPWPGjFu3bllbW7u4uLAdspXtswyscLoc5UV1dfXjx495hSxqaGiIjY11c3MDAvgbnTBhwokTJ65fv378+PH29vbv7cM3eL45NXWynZGRYWbmR1lZuTXrNrZzGBW1ASrHj4Zu3rQh7tGj169fL1q00HL06CtXr\/3mMmtZ4Jo7UfdS0z\/U1TcAAMQlxBb5LHD5zdF6\/BhYtqy8MjUt4+btO75LVrjPnnv\/YYyzs7Obm9vj+PjEpMTt2zYfDg1RVGT37Vbf0Bi0Zp2IqFhuXp73As+BGmr9pYX\/JPA3zHVVGd7puLm5qaiojB07FgBw\/fp1\/Fv8xWx4ePHiRQCAiYmJsrJyWloanA13d\/+b96M5c+YAADo6Oj59+sRavL29\/fDhwwQCYdeuXQIKICQkhGHY0qVLJSQkrl27FhMTA76ZH87rHUyJj4\/f+I3Lly9z5uTVnLS09LRp0wAAK1asMDU1DQ8PZ10nYLNkfPQpiOp61Rb8cP\/+\/fnz5w8ZMuT+\/fv424KCDAEvaQUpm5GRAdfY+Lgm42rjKysrKysrLSws8Eb5dxnCVZ9ctcGpVX19\/R7rHzlyJADg\/fv3vPrSI21tbb6+vosWLUpOToYm0MDAQERERE1NraWlRU9P7+bNm+fOnSsvL1dXV2c75CzbL3h5efE6D0+cOGFvb+\/j4wMA2LFjx4QJEx4\/ftzQ0PDy5cvjx4\/jX1Gp1NmzZ4eGhsK7CnFxcf7+RmfMmAGn6aZMmaKsrNxfHeFpfshk8sb1q91dncXERJOTkwOWBZaVV7DlERMVnTrZ7tyZP+bP9YyPj49\/HKelpbNg\/jxdXd24hGf7Dxxc7L9s1px5ixYv8\/VfvnDxssUBgd6+Ae4enkuXrww9fCQx6eXgwYO85s+Xk1O4ezfq9es3ywKWnP7j2CS7CSLf7psgGIaVlJavWbep6mvFKIsR2zavt7Pjt9MBAb79sDlPUyaTGR4eTiaT4RoAvP25ceMGhm9HIRIBABEREU5OToaGhuvWrVNSUoJODCsqKgAAJBJJVVWVtU4tLS34obW1FRb\/\/fffDQwMlJSUbt++HR8fP2\/ePAEFgMXl5eV3794NAFi6dGlHRwfrq9qcfXz+\/Pn+b8DJN9Ze828uIiLCwcEBAPD582cfHx9TU1M8IjLbFZyXPlnho7petQUP379\/39XVlZWVdeLECbwJQYaAl7SClC0qKmJLBAC8efPmzJkzULec0kIKCgoAAPr6+qyJfLoM4apPrtrgqtUe6x8wYAAAoL6+nrMVAQkLCxsyZMiFCxfwVUkcDMPevHkzY8YMTU3NhIQEUVFRtkM+Zb8HNpejrLC6HJ0yZYqwsPDnz58pFEpeXp6\/vz\/8isFgzJ0718PD47fffoOlBPE3am5u7unpmZ6eDtfb+gV+T3DiYmJz57jPnDGtsKgk8k6U\/9LA4N07hg01YbONsrLSzk7Tx44dnZOb9+xZUsSVKzJSUto6OsbGxirKysLCJDghI0QUYjDoDAZTVEyUQumqr68rKSlOfPaMSqfZ2Uxwd9tiPmIYmdsTJZ3OePXm3dFjJ1avChw9ykKQp04EAID1as5KfHx8eXm5pKQkvOdtaWkBAJSXl8MdMuDbbWZpaSmDwTAyMgoMDPT29oZ+oqAZoNPptbW1rDdB+L4aFRUVWFxFRUVbW7utra2mpmbdunUpKSn4WyD8BYDFqVTqypUrb9++\/ebNm3379kHPJZyhpGDQrYCAgIUL\/5qJTUpKWrduHWtO\/s0pKCjExsYmJibu27cvPj4+JyfHxcUlMzMTn4LAq+KlT1b4qA4AIHhb8HDXrl0dHR3BwcGbNm2ysLCws7MTcAh4SStIWfwuuKKiQldXF35++vTp1q1bLS0tXV1dcfHYhgN655SRkWFN5NNl1p6yVcVVG1y12mP9YmJiAAA8co+AsLrjtLKy8vf3f\/\/+fWlpqY2NDYFAwK0jkUgcPHjwli1b3r17t3Pnzp07d7IdspXFS\/VKGDYYDIaenl5TUxMcTSqV6uTkVFhYKCQkVFBQcPToUTwnHCwAwOPHj319ffG50Fu3bsXFxVVVVYWHhw8dOvTUqVMeHh7Xr1+fOXNmfX39H3\/8wVlnYmLi8ePHOzs75eTkLl269D3y\/w22dSG49YArF8OvWIwe98eZ8xRKB8fmghbP+Qv9lwZ+ycnv7qa+\/\/DpyvWbW7btdPzNbdRYWwsrG7ORY0eOHm82aqyFlc3ocXYzXTx2B4fcuBX5KSsH1rB0eWDa+0zORltaWg8eOjZ7rk9Obj4vwdDWA67ABVvOBUk48aKoqKj1DbjyDHe2YBgGJzQOHjzIWWdJSQk8bfCdBRC4pK+oqMhgMGDxffv2YRjW2NgIQ9Nu2LBBQAFmzJgBAMjOzsYwLDc3V0xMTFJSEvalsbGRTR7odZh160FkZCQAQEtLS\/D+4uATgOnp6bgeQkJC+OuTFT6q61Vb8DA4OJjJZMJ2Bw4c2NLSggk2BLykFaQsfEJiFQbDsPPnzwMArK2tWcVjzYBh2N27dwHfnYFsXYbArQeLFi1izclVGz1qlWv9MGYPXDZnhfPSxwqDZVcbhmFUKrWrq4vJZMJLDb67gUajubm5webu3r0bEBDAdshZFuPYfNEH2HbW9Vd+CoXC59vW1taurq5etcsV0OPWA654zZ9z5VLYs8QkN4+571L\/NpdaWFSclpYmLCoREXGJRBIqLy\/rpHSsXrXyftTN18lP3r58mvYm+U1KUtrr5Lcvn6Y8T7h7+9qSxb5NjY2VlX+d6w9jYlcGrSot+9v8XtKLVwsWLgaAGRF+zkBfV3BREeDbzSO8+8NpbGyMjo4GAMTFxZV8A87yR0ZGwqlzeLPJ9W0JLS0teA++detW+H4AAKC0tBTupwoKCiISibAgfC6Rk5PbuHEjAODUqVPwsaNHAViLGxoaHjhwoL29\/cmTJ1xFgtlY09mEF6S\/OLNmzYKPWW1tbXgleB6u+mSDj+rY4N8WfkggEM6dOychIVFeXr5hwwYBh4CXtIKUVVdXh3Mye\/fuxaNnysvLA5alfjZpIXDtms9LIWxdZtUY21o3W\/0CapVr\/V+\/fgUAsE029gjbAwqZTBYREcG9q+DTPyQSyc\/Pb9u2bZ6enjdv3ty4cSPbIWdZwG0Js7f0dgZIwPz8vVRISUnxmgPvM73rhoG+bvj5M3ejH67bsGH4cDP\/xb7GRgYEAuHO3Wgzs+EYo8vVzaujs+vDh49vUtPVNdQnT7R1dptdWlrq5ua+ddPa7bv2vn37liwscufmlbS0tJevU6MfPITvq2IYaG5p27Zz9x\/HDktIiH\/8nH3i5CkJcfHQ\/b9ra2l+5+Pq\/yZUKhUAcPr06Xv37tHp9K6urs7OzsmTJ1OpVGVl5REjRuA5p06deuLEifr6+qSkpEmTJsGZCl4Rhc+dO2dpaVlZWTl06FBXV1chIaHbt283NTXZ2dnB6yN8HxC\/WHh4eAQGBra1tUVERKxYseL69ev8BYCt429BLlu2LCoqKjExEXCbQoHmhzXuPew1Xpx\/c7Gxsdu3bx89erSKikpXV1dycjKFQlFRUYF7t2AleFVc9RkWFjZo0CC8Zj6qa21ttba2FrAt+AG2qKmpuW3bto0bN549e9bLy2v06NE9DgEfaQUpe\/r06Q8fPpSWllpaWs6aNcvY2Pjz5894nZzSQoyMjAAA+IuxPXaZs6dsiXj9vLQqSP0fP34kEAgw6uiPYMqUKVOmTMEPNTU1WQ8RPcD2ZMRn8g2HTqdXVHwN3hc6ccq05SvXJL949TTxRUFhMfy2vKLSd8kK\/2Uryyu+MhiMh48SvHwWVdfUMhiMVes2zXSZPczCqr29vbm5ZeuOPQsXL2tqamYwGJ4L\/LKyc54nv4p7\/GTpitXeC\/3epaZ1dnb2KAyafOMF13jy8Crs5OTEmhN\/tTswMBAvuHHjRl415+XlsS6lioqKBgUF4Q\/msDjrq6Bz584FAJiammIYNm7cOP4CwOJJSUn4t7m5ufCGMScnh00SuK9pzZo1eArcFiUhIQEP+Tfn4uLCph9zc\/P379+zdgSvnKs+4SQhm865qg5a0F61hR92dXXBJfQxY8YIMgT8pe2xLIZhNTU1vr6+UlJSrNnwd4fZxMPR1dUVFRVtbm4WpMsQeG64urpyqpFNG5xa7bF+CoUiJibG9T0VwHfyDfHjYNV8LwIucFJYVBITGxefkCAlJW0zwdrO1lpdXS0jI3Pn7j3Dhg4N+X0PmUyKjXv6JCHu8KGDAIAdu\/cx6F2uLi7Dh5nW1TcuCVgmKiq2bu0qAz3d9x8+pqW9zy\/Il5aRmTFtitXo0YI\/YCKXoz+FsrKyvLw8MTGxYcOG4avrvxw1NTWFhYWtra2ioqL6+vrQvcKv0tb3DIEgZel0enFxcWtrq5yc3MCBA3v02BYcHLxt27ZDhw7hzoR+tHr513\/27Fl\/f\/9z585xbiJHLkd\/FoJ6vBaQ5pbWV6\/fxj6Ke5\/xQUdroJHxIAtzC0UFOQMDPWEyubyyqri42GHqJADA8xevyWQhc7PhNDqdQqFUVHwtr\/j66fOnosICBhObOtluwoQJGuq9fpsHmR8E4t9AY2OjiYlJZ2fnhw8fWPdt\/xSamppMTU3l5eXT09M5DScyPz+LfjY\/OFQq7fmLV7m5OW\/fpWV9yaHTaCrKSsrKSlqa6sRv5gHDsIKi0tq6egKBOMF6rKy0pKGR8SQ7m+9xhYvMDwLxLyEpKcnBwUFHRycuLk5TU\/NnidHe3j5jxozM1o3cPQAABh5JREFUzMznz59Dj3ls8DI\/ra2tzs7OTCZzwIAB69evHz58OP+G3r59e\/78+T\/\/\/LPHxB9EQ0PDunXrPn78aGZmduzYsZ8Y5EJAejA\/\/dIGNGMlZZUVFZW1dfX\/3x6BMEBVdfQoMyKR2I82A5kfBOJfwqtXrxYvXnzv3j22V1D\/SZqbmydPnnzx4kWutgfwNj8VFRVOTk6pqalPnjxZunRpfn4+TGcymVw3QDGZzK6uLvyiT6fTSSQSW+IPpaioqLm52dTU1NnZ2dHRMSAg4B9o9Htg1Tz7+kp\/XcdhPXo6mno6P+0OCIFA\/POMGTPm06dPP\/eOUFZWNjU1tc\/FCQTC8OHD4X48JpO5ePHilpaWurq6w4cPjxgxwsnJaceOHWZmZpGRkY8fP6ZSqZcuXfry5UtAQICqqqqzs7ORkdGRI0f68\/VMFphMpqOj4\/379+GMEf5qsJ6eHud72f9y0IZmBALRz\/zSsxF5eXkTJ060srKC9iM6OlpBQeH27dsnT54MDg4GADg7O1+7dg0AcO3atQkTJsAd4YmJiTY2Njdu3PDw8KDT6bzeW\/h+uLocZfUf+guBzA8CgUD8P4aGhjExMVZWVrm5uQCA7OzspKSkefPmhYSEwCilLi4uDx8+bGlpKS0txeOWzp8\/H3rW+fjx44+WkM3lKJv\/0F8I5D8NgUAg\/oaoqGhISIidnZ2fn5+Ghoa1tfXBgwfxb6WkpIYPH75x40bcqRpMDAsLe\/Hixa5duzZt2sSt1n6jqqoKvgcGAGBw+A\/9hUDmB4FAIP4CdzaqoaFhZGT07NkzDw+Pmzdvurm5kclkGxubJUuWAADmz58\/c+bMgoKChoYGmP\/48eMpKSn19fWLFi36fr+ifGD83eUop\/\/QH9TujwBtfkcgEP9z8HnvB9\/kxmAw8A26FApFSEgIOquF0Gg0uPjPYDCgV462tjYRERHoWBpP\/BHA\/XU\/qPIfDb+N1wgEAvGfB712+rNg1TzaeoBAIBCInwAyPwgEAoH4CSDzg0AgEIifADI\/CAQC0QsoFEpOTs7PlkJQMAzLysr62VJwB5kfBAKB+IuGhga4tRoAUFVVtXLlSs48X7582blz5z8qFl9qa2u9vb2joqK4fkuhUGBQJV68ffuWNSBFQ0PDwoULLSws\/Pz8Ojo6+lnWv4PMDwKBQPxFZ2dneno6\/EyhUPBw4+DvQXVZ4UzHY4ezOmHjzNYvLtra29v9\/PyYTCYMK95jE2xiMBgMCwuLY8eO4SktLS3Lly9\/\/fp1VVXVD3Jbh\/Orbh5HIBCIf4acnJygoCBxcfHa2tpHjx7xSi8sLNy8eTORSMzPz\/f394+Li6uoqAgJCTE0NOSarbS0dMuWLbNnz+6VMGwuRyUlJaOjo\/ft28eWjUajubq6tre3Kykp8ZJ2w4YNMM46q6X5J32YIvODQCAQ\/09OTs7o0aMBAN3d3TIyMgAAXV3d2NhYIpG4bNmyFy9eKCsrw5yc6bW1tSkpKa9fv162bFlqaiqcprtz5w5btpqamlevXlVWVi5YsKC35oery1FO7t27p6amdubMmdevX8MoDJzSlpWVpaenZ2dnh4aGshWHPkw3b97cK9l6CzI\/CAQC8f8YGxu\/efMGAFBQUODr6wsAaGtrW7duHYFAePfuna2tLZ6TM11fX19ERERVVVVHR0dcXFxFRaWtrY0zm4GBgYiIiJqaWktLSx8k9PLy6jFPYWEhjJWHRzziFGPYsGFcgxL9Yz5M0doPAoFA8CMsLGzIkCEXLlxgtT180gUsDvoa3rOqqqrHPCoqKjBWXkFBQa+k\/Sd9mKKnHwQCgfgL3OUo62crKyt\/f\/\/379\/DkAq4R1Fe6awfCARCj9l6BZvLUSqV6uTkVFhYKCQkVFBQcPToUZjN1dX1zJkzv\/32m5KSkoSEhCDSQv5JH6bI8RECgfifQxCXo6yfaTQak8mE7kQJBALuUZRXOu4VFH7oMVuvELxUZ2enmJhYj9L+UAepbCCXowgE4n8a5HL0Z4FcjiIQCATiJ4PMDwKBQCB+Asj8IBAIBOIngMwPAoFAIH4CaOM1AoH4n0NWVhZG0Ub8w8jKyuKf\/w+7vNTpOBZk8AAAAABJRU5ErkJggg==\" width=\"571\" height=\"101\"><\/p>\r\n<table style=\"border-collapse: collapse; width: 100%; height: 90px;\" border=\"1\">\r\n<tbody>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 13.4298%; height: 18px;\">No. Reg<\/td>\r\n<td style=\"width: 30.6473%; height: 18px;\"><span class=\"input-variable input-nomordokumen\" name=\"nomordokumen\" contenteditable=\"true\">{{nomordokumen}}<\/span><\/td>\r\n<td style=\"width: 30.9229%; height: 18px;\">Tanggal Pemeriksaan<\/td>\r\n<td style=\"width: 25%; height: 18px;\"><span class=\"input-variable input-tangglPemerikasaan\" name=\"tangglPemerikasaan\" contenteditable=\"true\">{{tangglPemerikasaan}}<\/span><\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 13.4298%; height: 18px;\">Nama<\/td>\r\n<td style=\"width: 30.6473%; height: 18px;\"><span class=\"input-variable input-namaKlien\" name=\"namaKlien\" contenteditable=\"true\">{{namaKlien}}<\/span><\/td>\r\n<td style=\"width: 30.9229%; height: 18px;\">Waktu Pemeriksaan<\/td>\r\n<td style=\"width: 25%; height: 18px;\"><span class=\"input-variable input-waktuPemerikasaan\" name=\"waktuPemerikasaan\" contenteditable=\"true\">{{waktuPemerikasaan}}<\/span><\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 13.4298%; height: 18px;\">Pertemuan ke<\/td>\r\n<td style=\"width: 30.6473%; height: 18px;\"><span class=\"input-variable input-pertemuanKe\" name=\"pertemuanKe\" contenteditable=\"true\">{{pertemuanKe}}<\/span><\/td>\r\n<td style=\"width: 30.9229%; height: 18px;\">Tempat Pemeriksaan<\/td>\r\n<td style=\"width: 25%; height: 18px;\"><span class=\"input-variable input-tempatPemeriksaan\" name=\"tempatPemeriksaan\" contenteditable=\"true\">{{tempatPemeriksaan}}<\/span><\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 13.4298%; height: 18px;\">Kasus<\/td>\r\n<td style=\"width: 30.6473%; height: 18px;\"><span class=\"input-variable input-kasus\" name=\"kasus\" contenteditable=\"true\">{{kasus}}<\/span><\/td>\r\n<td style=\"width: 30.9229%; height: 36px;\" rowspan=\"2\">Koordinator Psikologi<\/td>\r\n<td style=\"width: 25%; height: 36px;\" rowspan=\"2\"><span class=\"input-variable input-koordinatorPeikologi\" name=\"koordinatorPeikologi\" contenteditable=\"true\">{{koordinatorPeikologi}}<\/span><\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 13.4298%; height: 18px;\">Pemeriksa<\/td>\r\n<td style=\"width: 30.6473%; height: 18px;\"><span class=\"input-variable input-pemeriksa\" name=\"pemeriksa\" contenteditable=\"true\">{{pemeriksa}}<\/span><\/td>\r\n<\/tr>\r\n<\/tbody>\r\n<\/table>\r\n<p>&nbsp;<\/p>\r\n<table style=\"height: 456px; width: 100%; border-collapse: collapse; border-style: none;\" border=\"1\">\r\n<tbody>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 14.3526%; height: 18px;\" colspan=\"2\"><strong>Penampilan<\/strong><\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 14.3526%; height: 18px;\">Keadaan Kulit<\/td>\r\n<td style=\"border: 1px solid; border-collapse: collapse; height: 18px;\">\r\n<p><span class=\"input-variable input-keadaanKulit\" name=\"keadaanKulit\" contenteditable=\"true\">{{keadaanKulit}}<\/span><\/p>\r\n<p><span style=\"font-size: 10pt;\">(Bersih, Kotor, Penyakit Kulit, Luka \/ Bekas Luka)<\/span><\/p>\r\n<\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 14.3526%; height: 18px;\">Bentuk Tubuh<\/td>\r\n<td style=\"width: 19.4491%; height: 18px;\">\r\n<p><span class=\"input-variable input-bentukTubuh\" name=\"bentukTubuh\" contenteditable=\"true\">{{bentukTubuh}}<\/span><\/p>\r\n<p><span style=\"font-size: 10pt;\">(Gemuk, Sedang, Kurus)<\/span><\/p>\r\n<\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 14.3526%; height: 18px;\">Tinggi Badan<\/td>\r\n<td style=\"width: 19.4491%; height: 18px;\">\r\n<p><span class=\"input-variable input-tinggiBadan\" name=\"tinggiBadan\" contenteditable=\"true\">{{tinggiBadan}}<\/span><\/p>\r\n<p><span style=\"font-size: 10pt;\">(Tinggi, Sedang, Pendek, Stunting)<\/span><\/p>\r\n<\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 14.3526%; height: 18px;\">Pakaian<\/td>\r\n<td style=\"width: 19.4491%; height: 18px;\"><span class=\"input-variable input-pakaian\" name=\"pakaian\" contenteditable=\"true\">{{pakaian}}<\/span><br><span style=\"font-size: 10pt;\">(Rapi, Kotor, Srampangan, Sederhana, Serasi, Mewa, Bersih, Biasa)<\/span><\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 14.3526%; height: 18px;\" colspan=\"2\"><strong>Sikap<\/strong><\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 14.3526%; height: 18px;\">Tindakan<\/td>\r\n<td style=\"width: 19.4491%; height: 18px;\">\r\n<p><span class=\"input-variable input-tindakan\" name=\"tindakan\" contenteditable=\"true\">{{tindakan}}<\/span><\/p>\r\n<p>(Sopan, Tegas, Ramah, Garang, Percaya diri, Kaku, Sulit Fokus, Kurang tahu aturan, Ceroboh, Tertekan, Dibuat-buat, Ragu-ragu, Malu-malu, Kontak Mata, Tidak bisa diam)<\/p>\r\n<\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 14.3526%; height: 18px;\"><strong>Penyampaian<\/strong><\/td>\r\n<td style=\"width: 19.4491%; height: 18px;\">&nbsp;<\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 14.3526%; height: 18px;\">Ekspresi<\/td>\r\n<td style=\"width: 19.4491%; height: 18px;\">\r\n<p><span class=\"input-variable input-expresi\" name=\"expresi\" contenteditable=\"true\">{{expresi}}<\/span><\/p>\r\n<p><span style=\"font-size: 10pt;\">(Tertutup, Terbuka, Mudah, Hati-hati, Dingin \/ datar, Membatasi diri, Sukar mencari kata-kata, Tenang, Gugup, Takut, Lancar, Banyak gerak dan isyarat<\/span><\/p>\r\n<\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 14.3526%; height: 18px;\">Penggunaan Kata<\/td>\r\n<td style=\"width: 19.4491%; height: 18px;\">\r\n<p><span class=\"input-variable input-penggunaanKata\" name=\"penggunaanKata\" contenteditable=\"true\">{{penggunaanKata}}<\/span><\/p>\r\n<p><span style=\"font-size: 10pt;\">(Dengan tekanan suara, Terpengaruh bahasa daerah, Disertai istilah bahasa asing, Biasa)<\/span><\/p>\r\n<\/td>\r\n<\/tr>\r\n<tr style=\"height: 46px;\">\r\n<td style=\"width: 14.3526%; height: 46px;\" colspan=\"2\"><strong>Mood<\/strong><\/td>\r\n<\/tr>\r\n<tr style=\"height: 46px;\">\r\n<td style=\"width: 14.3526%; height: 46px;\">Afek<\/td>\r\n<td style=\"width: 19.4491%; height: 46px;\">\r\n<p><span class=\"input-variable input-afek\" name=\"afek\" contenteditable=\"true\">{{afek}}<\/span><\/p>\r\n<p><span style=\"font-size: 10pt;\">(Euthymic, Manik, Depresif)<\/span><\/p>\r\n<\/td>\r\n<\/tr>\r\n<tr style=\"height: 46px;\">\r\n<td style=\"width: 14.3526%; height: 46px;\">Ekspresi Afektif<\/td>\r\n<td style=\"width: 19.4491%; height: 46px;\">\r\n<p><span class=\"input-variable input-ekspresi afektif\" name=\"ekspresi afektif\" contenteditable=\"true\">{{ekspresi afektif}}<\/span><\/p>\r\n<p><span style=\"font-size: 10pt;\">(Normal, Terbatas, Tumpul, Datar)<\/span><\/p>\r\n<\/td>\r\n<\/tr>\r\n<tr style=\"height: 46px;\">\r\n<td style=\"width: 14.3526%; height: 46px;\">Kesesuaian<\/td>\r\n<td style=\"width: 19.4491%; height: 46px;\">\r\n<p><span class=\"input-variable input-kesesuaian\" name=\"kesesuaian\" contenteditable=\"true\">{{kesesuaian}}<\/span><\/p>\r\n<p><span style=\"font-size: 10pt;\">(Sesuai, Tidak Sesuai)<\/span><\/p>\r\n<\/td>\r\n<\/tr>\r\n<tr style=\"height: 46px;\">\r\n<td style=\"width: 14.3526%; height: 46px;\">Empati<\/td>\r\n<td style=\"width: 19.4491%; height: 46px;\">\r\n<p><span class=\"input-variable input-empati\" name=\"empati\" contenteditable=\"true\">{{empati}}<\/span><\/p>\r\n<p><span style=\"font-size: 10pt;\">(Bisa, Tidak Bisa)<\/span><\/p>\r\n<\/td>\r\n<\/tr>\r\n<tr style=\"height: 46px;\">\r\n<td style=\"width: 14.3526%; height: 46px;\"><strong>Symtomps<\/strong><\/td>\r\n<td style=\"width: 19.4491%; height: 46px;\">\r\n<p><span class=\"input-variable input-symtomps\" name=\"symtomps\" contenteditable=\"true\">{{symtomps}}<\/span><\/p>\r\n<\/td>\r\n<\/tr>\r\n<\/tbody>\r\n<\/table>\r\n<p><strong>(T)opics<\/strong><\/p>\r\n<table style=\"border-collapse: collapse; width: 100%;\" border=\"1\">\r\n<tbody>\r\n<tr>\r\n<td style=\"width: 100%;\"><span class=\"input-variable input-topics\" name=\"topics\" contenteditable=\"true\">{{topics}}<\/span><\/td>\r\n<\/tr>\r\n<\/tbody>\r\n<\/table>\r\n<p>&nbsp;<\/p>\r\n<p><strong>(I)ntervention:<\/strong><\/p>\r\n<table style=\"border-collapse: collapse; width: 100%;\" border=\"1\">\r\n<tbody>\r\n<tr>\r\n<td style=\"width: 100%;\"><span class=\"input-variable input-intervention\" name=\"intervention\" contenteditable=\"true\">{{intervention}}<\/span><\/td>\r\n<\/tr>\r\n<\/tbody>\r\n<\/table>\r\n<p>&nbsp;<\/p>\r\n<p><strong>(P)lans &amp; Progresses :<\/strong><\/p>\r\n<table style=\"border-collapse: collapse; width: 100%;\" border=\"1\">\r\n<tbody>\r\n<tr>\r\n<td style=\"width: 100%;\"><span class=\"input-variable input-plans\" name=\"plans\" contenteditable=\"true\">{{plans}}<\/span><\/td>\r\n<\/tr>\r\n<\/tbody>\r\n<\/table>\r\n<p>&nbsp;<\/p>\r\n<p><strong>(S)pecial Issues :&nbsp;<\/strong><\/p>\r\n<table style=\"border-collapse: collapse; width: 100%;\" border=\"1\">\r\n<tbody>\r\n<tr>\r\n<td style=\"width: 100%;\"><span class=\"input-variable input-specialIssues\" name=\"specialIssues\" contenteditable=\"true\">{{specialIssues}}<\/span><\/td>\r\n<\/tr>\r\n<\/tbody>\r\n<\/table>\r\n<p>&nbsp;<\/p>"',
                'nama_template' => '[F-PSI-01] Form Pemeriksaan Psikologi', 
                'pemilik_template' => 'Psikolog', 
                'created_by_template' => 'Psikolog', 
                'created_at_template' => Carbon::now(), 
                'updated_at_template' => Carbon::now(), 
                'created_by' => 2,
                'created_at' => Carbon::now()
            ],[
                "uuid" => '25g31cc3-23fb-4a32-84ff-36bae7d53f4e',
                "template_id" => 1,
                "judul" => 'lorem ipsum dolor sit amet',
                "konten" => '"<p style=\"text-align: center;\"><img src=\"data:image\/png;base64,iVBORw0KGgoAAAANSUhEUgAAAioAAABiCAIAAADxxm\/MAAAACXBIWXMAAA7EAAAOxAGVKw4bAAAgAElEQVR4nO2dZ1QUSdeAa4YZcs4CkpMKKoIiBgRMIOoSRTEACgoGxJwzKwbMrmlVELMiigoiqCCKCRBRQXJGcmYIk\/r7UWt\/s5MYENd133oOhzNdU+HWrZ6+3VXV9xIwDAMIBAKBQPyzEH+2AAgEAoH4XwSZHwQCgUD8BJD5QSAQCMRPAJkfBAKBQPwEkPlBIBAIxE8AmR8EAoFA\/ASQ+UEgEAjETwCZHwQCgUD8BJD5QSAQCMRPgMSZ1L9+ENraKDV19RiGtba2SktLE4kEPR2tfqwfQiAQ+r1OBAKBQPw42M0PhmHfaX6qa+pycnMzMj6kpmXUNzQQCJi4mDiBAISEhBgMBgZAV2fnYJNh5sMHy8rImJubqygrfU9zANkeBAKB+AUhsBmbPpuf9nbKx0+fb9y6U1RUKCkpaWBgaGczXkVVRUJcQkJCHAACmUyi0egAYG3tlA5Ke1V1dWJSSltbc1Nj41zPOWbDh6uo9NEOEQgEZIEQCATi16IfzE97OyUx+eX16zfq6xtmzpxuYz3e2MiARCJhGNba2sZgMgGGUalUERHhtrZ2cXFxYWFhAoEgKSlBIBBoNNrHz9lPnybm5uXr62nP9Zw9UEOjt7YEmR8EAoH45fgu88NkMj99\/rLvwMHGpqaAJUumTLYTFxPFMKymti4942NlRVn80+eamtrlZcVfv1aZmw17l\/ZeWUVVUUGhm9rt6DCVTCLb2VrLyUoTicSm5tZHcfE3b92aNNFusa+PiIhIL\/rQH+aHTqfn5ORgGEalUiUkJPT19UkkUkdHR1FRkZKSkoqKCsz2+fNnaWlpTU1NeFhYWFhYWAgAMDAw0NHRwfMAANTV1eXk5GCezs5O1rbk5OTU1dX5tAsTWTs4ZMgQmCgjIzNw4EA24dlazM3NpdFogwcPJhKJAIDi4uKOjo4hQ4ZwzQyrFRcX19XVhRlycnIkJSU1NDR41d9jEa5dVlFR4dUpJpNJpVIlJSV1dXWFhYV5qYW\/PLASBQUFfCB6HD7BlQ8AqK+vr66uJhKJgwcPhl+Vl5e3tLRISEjo6OjgMnR3d0tISOjq6oqKiuJN9KrXnB3pl4Hu82j2SlFcu\/Y9Ku3tT7IPHexR7X1TWp8Lci2C\/\/Dhjwsf9F8b7O8wmUyGYHR2du3cE2I+auyFsMuUjk6YGP\/0eWFx6aSpjhMmThs+cpzdlJmLl68zGDRUVV3TdtK035xdR421NR89wWdJ4FzvxePt7Kc4uqzdsC0q+iGdTmcwGM0trcdPnpnu5P7yZYqAYjAYDCaTiX039fX1UCFwUNXV1ZOTk1NSUgAAGzZswLMBAFxcXDAMo9PpHh4euBqnTZsGM3z48AGmrF27FqYMGjSITeeLFy\/m3y6eCBEVFcUwrKGhAQAwd+5cNsk5W\/Ty8gIAPHr0CP50FRUVp0yZwiszrFZMTKyiogKmKCsrL1q0iE\/9PRbh2mWunWLrvqKi4rNnz3iphZc8bDVramrevXsXwzA+w9db5WMYtnXrVpjS2NgIU8aMGQMAGDduHGdVsrKyUP996zVbR\/ploPs8mr1SFNeu9YtKe\/xJ9rmD\/NXeZ6X1rSCv09vDwwPDsKysLDKZPGvWLOw\/QR\/tZ3FJmcec+aVlZZG3rnvNn8NkMvMLikOPnLh+\/WZDfb2SsrLJEOPZsz2oNGp9fe3UKVMXL15iZ2ejOXDgNPvJsrIyYqJilRUVZBJJWkqitbUlNPRIc0vrs8RkMokU4O8bun\/vyTN\/Hj72B5VK7Zt4fUBMTAwAsHLlSjqd\/v79+7a2tg0bNsA7bjKZjGcjkUhCQkIAgOfPn9+8efPAgQN0Or2lpeXEiRMww40bN8zMzEaMGHH37l2Y8uDBg\/Ly8uDgYABAbGxsUVHRrl27+LcLE5cuXVpWVlZQUJCamgoAgHfTnM+FnC3u3btXUlLy6NGjAIBbt261trYeO3aMV2YJCQn4ISgoCH4QFhaGAvS5CNcuc+0UTFy1ahWDwcjIyKBQKIcPH+alFl7ywMxr1qypqqqKiopiMBju7u5paWl8hq+3ygcA1NTUGBgYAABevHgBAGhubn737p2+vn5bWxte1dq1axkMxtu3b5ubm8+dO4en96rXnB3pl4Hu82j2SlFcu\/Y9KhX8J9nnDvJXe5+V1reCvE5vMplMpVLnzZtnamp68eJF8J+gL+Yn\/f2HRYv9ra3HHw3drzlQ\/c27dN\/FS1euXnP12nVjY6NHj594uLstmDdnqZ\/3pQunTx8PPRCye8fWjZs3rDl86ODWTeuvhP+5fvWy40cOLvZbRKPSKB2dwiKiW7bt2r5rz5GT5yorq3R1tE+fONrU1LR9V3B7e3u\/95kr8AxmMBgEAsHMzExHR6erq4vzXBcWFoY5MQwDAKSkpFRXV0tLS8NHaSaTeeXKFScnp+nTpxcWFsIzWE9PT0NDQ0ZGBgCgpKSko6OjqqrKv12YSCKRBg4cqKenZ2JigudknYPi1aKamtqmTZseP36cnZ0dGhq6adMmY2NjXplhtS4uLpGRkVFRUbCPeCt9KMKry3w6RaPRAADDhg2TlZWFkypc1cJfHhKJpKqq6uzsHBERQafTjx49ymf4eqt8AEB5efmkSZOIRGJMTAwAICoqSk9Pz8DAoLGxEa+KyWQCAJSVlYlEooWFBatsgveasyP9MtB9Hs0+nKVsXfselQr+k+xzB\/mo\/XuU1r8\/NxKJtGzZss7OztjYWNyG\/er02vykpWds3LzNe8H8wOX+oqIid+\/HlJaV02h0ExPToUOHFRWXTHOYMsPR3mz4sIbGppbm5sio+7uC9y9ZFuQXEBiwfPXmbXtu3o6qr6+XkJBwmjHtjxOH\/f28rcdZFRUXqQ9QTU19t2X7rjfv0khk0paN6zTUNXbuDm5r+ycsEBzjioqKuLi4oKCgzMxMPz8\/eJaznusiIiJwKsDW1tbBwSE6OlpbW9vHxwc+IMfHx1dUVLi5ubm4uAAArl+\/zla\/gO3CxIiICD09PU1NzWvXruE52SZ8ebUYFBSkqKi4du3axsbGTZs28ckMq50+fbq5ufmyZcuam5tFRERwaftQhFeX+XTq06dPJ0+enDlzprGx8e+\/\/85LLfzlwZ+VbWxsxMTE8vPz+Qxfb5UPACgrK1NXV7eysnrw4AGGYdeuXZsxY4aEhAQceljq5s2blpaWgwYNGjdu3LJly\/rWa86O9MtAf89o9vYsZeva96hU8J9knzvIR+3fo7T+\/bldvXr1\/Pnz06dPxxe9\/gNwee2UD5kfP2\/asn3u3DkL5s1pb2\/\/+Dln374DYuLiRKIQncE4EBJsoK\/T0tL66PHTmNiYLzm5ZLKwkaGhlaW5lJS0EInMYNAp7W0fPmbv3LOvrbXF2Nhw4sRJE23Gj7EaXV5ZdfbcxY8fM43NRxw7cdLd1dnd1TlgyaKTp8\/t2hO8Z9cOzgfb\/gXetyYkJOTl5RkZGT169Mje3j4vLw8AQKfT8Wx0Oh1OghGJxIcPH169ejUkJCQ8PDwjIyM9Pf3ChQtiYmLw0VhYWPjmzZsHDx6Evw34tARb6bFd+EsYOXLkvHnzaDTaiBEj8Jxs5odXi+Li4l5eXocOHQoNDcXn67hmxvt1\/vz5UaNGbdu2TVxcHPu2\/aQPRXDYugw\/cO1UQUHB1atX09LSbGxsZGVleamFlzwwM7zjhmXpdLqCggLsONfh663yAQClpaXS0tLu7u5BQUEJCQlJSUkhISGnT5\/u7Oxsb2+HeweMjY3nzp2bn59\/7NgxS0vLjx8\/wrK96jVnR\/ploIlEYp9Hs7dnKVvXuA69gCoV\/CfZ59OVj9r7XGffCvI5vR0cHGg0WmhoqImJCVzz+y\/AthbEZ+tBaVnFhIlTz1+8BPcIzPL0Hms9cco0JyfX2afOXGhobKLT6Vev37YabzvJfsbFS1fKKr7y2S9QVV1783aUk+tsyzETLoRdptFoNbV1x\/7402K0tb6x6dPEF7W19VQqlUqlhh4+vmrthh+99QDu1PLz82NNbG1tBQB4e3vDQ7hsuGvXLtY8dDp9zpw5AIDExERhYWETExMPDw8PDw+4tycxMRFmg4tDKSkpgrQLE1l3KOCJgYGBeEpdXR2fFs+fPw8AePLkCf\/M8CISFhaGYdju3bvJZPKQIUNWrlzZtyKssHWZT6d8fX0xDIM3xcHBwbzUwksetpojIyMBACdPnuxx+ARXfm1tLQAgPDz869evRCJxwoQJRkZGGIatWLECsOz08\/f3h\/lXrlwJAMjKyupDrzk70i8D\/T2j2duzlK1r36NSwX+Sfe4gL7V\/T539+HOD4vn4+DQ3N2toaEhJSZWWlmL\/CQQ1P11dXbPmzN+z9wCVSq2tqz96\/KT5aOvR4+yePE18l\/qewWB8yPxs7+g009n9bWo6LEKj0fLLvpRWFcFdbbzIyPw0b8Eia7spr968g0bObsr0ZYGrNbT0b92JZjAYFErH+k3bb0Xe\/aHmB6524qc1jpWVlaSk5IMHDwoKCnx8fIhE4sePHzEMKysri4uLKywszMrKcnV1JRKJcBtPTEwMLHjv3j3W6xFcW37+\/Lkg7cLf2JQpU+7fvx8ZGXn16tWKigqY093dPTo6+vbt21euXNm3bx+fFk+dOgW+bYvCMAwuSnNmhqtrZ8+exTCMTqePHDkSABAQENC3IqywdZlrp2Cil5cXhmFMJlNXV1dFRYVKpXJVCy958JoTExMPHz4sJSVlZmbW1dXFZ\/h6q3y4Wh4ZGYlhmJ2dHQBgz549GIbB+a5Xr17BUs7OztnZ2TExMXp6egoKChQKpVe95tURXh3v1UB\/z2gKriiuXYNGorcq7e1Pss8d5HP+9LnOfvy5QfHmzZuHYRhcLpo+fTr2n0Ag80On048cOzVnnk9DQ2NXV9eqtZusJ04zGzVuqqNzbV19R2fntRu3LcdO+PPipbb2dliku7vrVPTvI4NkRq2Su5F4jkaj8rFAHR2d12\/eGWNtd+KPs+3tlKeJyfO9\/UaMHHvw8IkTp\/5kMBhfq6pnOLnn5Ob9OPNTV1cHAJg9ezZbenZ29rBhwwAAAAAxMbETJ07A9NOnT4NvyMvLnzt3btSoUUQisb29HWaAy6cDBgyAhyEhIQCAp0+fCtIuTGQlISGBM3Ho0KF8Wjxy5AgAAN9Cyks8WO3Ro0dh+sePH4lEIvzN96EIK2xd5tMpT09PmGfLli3wksRVLfzlgUhKSnp7ezc0NPAfvt4qH94Rw0sDXJT+\/PkzhmFwE2N0dDRrKTk5uZkzZ3748KFvvebsCP9TS8CB\/p7R7O1Zyta1sLCwPqtU8J9knzvI5\/zpc539\/nPDN1tbW1sDAGJjY7FfH4FeOy0uKZs1Z15E2HkjQ\/2Ll659zvqSlPR05YrAYcNMhwwyOn\/xUuyjR+vXrZ0wfgxepKAye8VpF4yAAQDESVJ\/LL83QIH9hSw2Pn3+snP3HmNj403r1xQUlSxZuqK7q9PKaozXfE\/LkeYvX725FHH5zB\/H2LaXgH\/E60FFRUVdXZ2hoSHrnpPS0tL6+noZGRlNTU04T434WVCp1M7OTgzDZGRkOE8GrsPX78CbISEhIV7bTASBf0cQOP07pkjtPwWhnTt38s9BpdJ27dk7duyYGY72GZmfDh0+SmcwdHR07WwnjDQffv5iRNzjx\/tD9o60MGMtFZ92T4QkttPzzMxR87NK0hVlVHVUDfk3pKKsNNrS8l70\/Q8fP89ydTI3G\/72bVp3V+e4cWPl5GT1dLRepLzq6qYaG7HX8w+YH2lp6QEDBrDZGFlZWTU1NXl5+e+53CD6BSEhIVFRUVFRUa5nAtfh63eIRKKQkNB3vovOvyMInP4dU6T2n0LPP5X8gsLXr98sXeLb3U29dPmaoYFhZUW5grzs+LGjYx4lREVFhewNHjLYiK1USVW2vLTiQBXtgSraImSRwoovgkijpamxN3jXhw8ZtyKjRlqMmOvpsW3LpkdxcXt+308gENauDrpx83Zra1tfOopAIBCIfxM9bLym0ehnzp1f6OMtLi525+791LT0cWNGr1oVZDN+bHll1c5de44fPTRkELvtodKoX2oz2ymtnrbLOrsoH0peksiC3hJqqKuFHtjv4Tlv+LBh7m4uixYvKy4ulJOTL6+s0tRQMzI0SEp+OXO6Q1\/6ikAgEIh\/DT1YhdKysowPH+Z5zqbR6OYjzOIe3h07xkpjgIq8nOzmLdt8vBeMsRrFWaq+paa+uUZSTNon1G7lOTcJUdn8quzG1nrOnFwZMtgoePfODZs2EQjgctjZRYv86hsag0MOAgDmz5sbHx9P\/bZDH4FAIBC\/KD2Yn7vRD8daWUlLS+YXFG3ZvuvMuQtDTU3GWFm+eZtaWlrqvWAu15nusrr8mpaytKLnxU05eTWZeTWZVU3l9a3VgovlOG0qiSwcE\/uY0tH57OkTYTKpuqqqqLhMT1ero7M763NW73qJQCAQiH8Z\/MwPpaMzLS3NwcEew7Ck5Je5uXlxcY9Lyyo6O7vO\/nl+aYC\/lJQkZykMw5IyYzppHayJTR21GQWvBReLTCItC\/APvxTBZDDGjBkzfPgIPT39xOcvAAAzpju8TX0veFUIBAKB+BfCz\/wUFZdQ2inmI4YzGAwlRQV1dXUjI6MRw03zC4oKC4ucZk7nWuprfdnz7Iec6XEZtyhdvfDeZmdjTaczMj9lTZ5o87Wq6tWrlKh796lUmsmQIe9S33LuDkcgEAjELwQ\/81NZUaGorCwlKZGannnw0NH6hkZ1dXVJScmHsXEzpjuKinKPCHcnJYwsRNZSNGBN1JTVL63Je5X1hDWxvbMt4V3026znXG0JiSTkMcstKuqekaG+u8vM7u5uGWlpJsY00NdVUFCqrqntfWcRCAQC8W+B3863F6\/eWo8bAwAwG2YyfbrD3ahor3lzKJSO9+lpgYGBXItU1VfEpF5ZMnX7tZcnWNOH6oxSkFKNeHZ0wrBpwqS\/tur\/Eb0r4sURYZLISd\/osaaTOWuztLS8E3W3qrq2urZeVlbuc9bnW5HRXvM8REXFPmRkDHCw72OnEb8IfIJscoYKxcnIyCgoKFBTUxs9ejR8JSsnJ4dOpw8aNAge1tXV1dTUaGhoVFRUwECZ\/GNQssW0hZnZImzyipjJNVSloaFhXl4eWw2QlpaW8vJyDQ0N6IQU9D72JZ9QsLi6+Efg5RUmFYHoZ9i8ILA63Znl6ZWYlEyj0U6cOjt5mvPQEaPz8wuyv+TaTp7WTung6v9mR8TSdefmx765NXy5mLE\/wP9s12s+Tbtvv8Uo7t0dPLPvkanG\/mBwAPHqkxNca6PR6PbTnVLT38c\/SQpas8FrYcCBQ8cYDMatyLtRd+\/1r9MdxL8Q\/kE22UKFYhhWU1MDXZJATExM8vPzMQwbPXo0AAB6wcG+ObV8\/fo1+ObLhFcMSq4xbaEAbBEneUXM5BqqkmsNEOiK5urVq\/Cwt7Ev+YSCZVUXnwi8vMKkIhD9Dr\/Jt67ODhkZGSqNVvm1trSk2NHRUVlFpaWlWUpKWozbzFt+WfbzrIcLJq58mhndRf\/bvVVNW0VFfYmz5cLLz47TGTRo9sx1rQEAwiRRfVVTrgIQiQQNjYFlpeVGhnpFJWUNjY3lFZXd3VTNger1DS18JEf8N+ATZJMzVCiGYS4uLmlpaZGRkc3NzWFhYXl5edOnT6fRaM7OzgCAp0+fwmqTk5PNzMyGDh0KABAXFwe8Y1ByjWkLBYAF2UTljJjJNVQl1xpY68FDJ\/Q29iWv\/Gzq4hOBl1eYVASi3+FpfppbWplMppi4OElIyHTIoGHDzYqLS+h0el5+kZYW+4wBAIDBZMSm3Zw5ch5JSDi1MIntWybGTM6OmTjit8a22lefngIA8iuy7r4NAwB00zqP3NtCo3OPq62vq1tQVCIqKlpfV19QkDdk8CACkSAsLFJUUtLXLiN+GfgE2eQMFZqUlJSSkhIUFOTq6iojI+Pt7R0QEJCbmxsXF+fh4UEgEGJjYwEAlZWVmZmZ3t7erNFjecWgxLjFtOUadpZXxEyuoSq51gCBgdTgV72NfcknP5u6eEXg5RUmFYH4EfA0P03NLSQSSUpSsrOrKz4hPjcnZ4TZMAlx8faODlkZac78QkSh2TZLFk5Z+\/zjw4Y2Lq\/4fKn80EZpnm+3Mur1xYaW2qeZ0WWNBQAADGAfKlLSclK4imFspFdeUUEikeTk5Ts7OmLjHndQOsTExDM\/ZPS1y4hfBj5BNjlDhb59+xYAMGHCBLy4jY0NACAnJ0dLS2v8+PHJycltbW0PHz4UERGZN28erIf1P2cMSq4xbVmLsInKGTGTa6hKrjVA4BQZ\/N\/b2Jd88nOqi6sAfML1IhD9Ts++cISEhEaNGiUhIV5dXc1gML5WflVVVuaaU0VeTVhYJDb9BgNjcH7bSKl5lZPgZu2jqaC\/\/LjLhYR9rN\/eexvO9QGI\/O02sLW1RV1dXVtTC\/n3\/N8BD7K5Zs2asrKyR48eBQQEsMbTjIuLExISgqv0DAYDANDd3Y0Xh7f88OFg7ty5NBotISEhOjra1dVVXl4e1gOfb+B\/GIOyoaEBj0EJY9pGREQYGBiEh4dPmjQJrjXiRdhE5YyYiYeqdHBwCA0NvXTpEp4Z4\/3yAHz6wWNfXr58Gca+ZDKZXCuE8MnPqS7ALQIv1xr6MHD\/fuTk5AiInwHrfpaezQ+Dznj67PngQUa6ujoYwDQ0NKpqanhlbu9o85u4OcTjyjg9Bykx2RCPK\/ZDPWRFFTfOOB7icWWwurkQkbR61t7r215eWP5URvSvcLZDNUa\/zUmobqzgVa28nGzcgzvKqmrZOblUKvK4878CvPZ5enpmZWVFRUXBeNv49ff169cRERFPnjwJDQ0FAAwfPhwAcP\/+fbx4TEwM+PY8NGvWLGFh4QcPHiQlJfn6+uL1QKMF\/9Pp9OHDh2\/btu3s2bNdXV0wkUgkzp8\/\/9OnT3PmzMnMzPzy5QtrQTZR8aef6OhoGo3m6OgI0xUUFK5fv66hobFixYqysjKuNUC+fv0K89fX19+\/f19PT6+ioqKiosLAwKCysjI5OZlrhQAA\/vk51YXLjAeu5lXD947iv5Lm5uaftuD+v01zczM+CjzNj6SEBIPB6OzsJBCJomKisrLyjU0tdDpDTFSko6OTVykFGaVpY91nWs\/RH2AiKiw203rOIJ3hEsLSU0Y5z7SeY202Fc9JJgmTiH\/NfRtqDLUx\/e3J+2jOCnPzi5SVlLq7qU+eJjLotOHDhklKSnR3d+no6vflpEP8UsArI+3vLv7gIfw\/e\/ZsXV3dEydO0Gg0e3t7MzOzixcvbt++\/d27dzt37oyIiJg\/fz4MWiwrKzt16tQbN24oKyvDSTlYAzQYrP83b948fPjwrKwsKpVaXl7++PHjoqKi3NxcKpVKJBJVVFRYC7JJVVJSkpSUdOTIER8fHzMzM19fX1xaGRmZ48ePt7W1LVu2jGsNmZmZ6enpR48elZWVHTp06LVr16hU6v79+2\/cuHHjxg04Y3bz5k2uFQIAeszPpi48ETc\/vGrot+FEIP4OT\/OjpChPJBLbKRQRYbLZsKFv3ryq+lopTCYbGuiWlfN8TBEcMREJMvmv7T0q8mr+jltGD7LlzJaXX2hspF9XV3fi1LmRI0cONTUhEgnd3d0mQwZ\/vwyIfzldXV34fxw4vQYvnQQCYc6cOTU1Nffv3xcSEoqNjbWzs9uzZ4+lpeXvv\/\/u7+9\/\/vx5vOCMGTO6urpcXFwIBAJeD3z9hfW\/kJDQhQsXiERiZ2dnTEyMvb29np7ekCFDEhMTz5w5o6SkxFqQTar4+HhbW9vt27e7uro+efJEREQEpkNL4+zsbG1t\/fDhQxhHma0GR0dHCwuL8vLyS5cuiYqKXr16lUgk4ktZcEN5dHQ01wofPXrEPz+nunCZcfPDq4Y+Dh4C0RP8XjslC4u0t7USCEQxMVEFBaWiooK6ujoZGdmmpkYajU4m9xCsoYeGhUjSYnLNHfVEAlFeSlFVQUOVIxwqk4lVfq3U1tJsaW2j0xklRflDBhmQyeS6ujplRdnvaR3xS6CoqIhxLJCwJQYHB8MNxAAAVVXVhISEysrK2tpaHR0dfJED4ufn5+fnx7UetjpNTU3xmTEHBwe2mLa8pOru7uaMmMmW+fnz5\/DD\/Pnz2Wp4\/\/59Z2fnwIED4b4DuJMCR05ODq+Ha4UODg6C5GdV18aNGzdu3Ih\/xadFBOJHwG\/tR1lZuai4lEQSCli88G7kNY9Zs169TVNUVBATFfmUJVD4OD4MUBzoPnbx8IHjxhlMmzlqAdc85RWV3V1diopKbe3tFEqbrd3E8ePGAQBS0z\/wcvmDQKirq5uZmbHZnj6jpaVlbm6ur6\/fY2BNYWFhGRkZWVlZQp8iZiorK2tpaX1nsFQE4heC37k+YfyYlFdvAAAtLW1Hjp28fvP2h8yPigryg4wHpaRw3yctOCQhkrioBFmILEwWERflHq09IyNDQ0NdUVHhxYuXVV8rN2\/ewqDTAQAtLS16emjtB4FAIH5h+JkfPT298vJySkenpKR4Vm7RKEurkpLS0rIKF5ffbt6O+geEC4u4Ot1xWmNjU+r7T95eXg+i7yopKVRUVnW0t+rr6f4DAiAQCES\/QKFQcnJyfrYU\/y74mR9dbS0REeFPn7KIRKKEKDn5eVJxcUl9ff0gY0NlJcXH8c\/4lJWXUjJSGg4AkJNQUpXRJAmROfMoy6iZ6ozUG8B9E8Hb1Pft7W1jrCzT0jNaW5sTk57n5HwBAGRnfzEwHoTmKBAIRL\/T2to6efJkfHbH29tbwFITJ060tbV1dXW9ffs21zxfvnzZuXNnP4nJ3rSNjY2Njc2DBw84RfLy8srKygIA0Gi0oKAgGxubOXPmUCiUhoaGJUuWsFZ15syZqVOnenh4lJeXw5Ta2lpvb2\/oB+RHwG\/7gIyMtKmpadLz56MtLfHJKNIAACAASURBVJx+m15aVqGrq62uri4mKrZooc\/JU6esrceIiYoCANra24uKSoYNNcHLutsucrSaDQCwN3cfYzRZTkqes37LQTYjjcZzXd7EMOyP02fcXF2kpaWUlZUGqqu1tLTYT51CIBBiHj1eMNeDswgCgUB8J62trUVFRYGBgampqUQi8eXLl\/hXTCaT111va2trS0tLampqeXn5kiVLysrK1qxZ02Op\/hK4paXlzZs34O9uLHCRnj596uTklJ+fDzfWJyUl5eTkEAiEzs7O9PR0PP+rV6\/u3r0bExOTkJCwdOnSBw8etLe3+\/n5ycjIwHfRfgQ96MX5txmPHsd3d3fbThhPIpOzs7M3bt5aUFg0ZZINgUCMfhDLxLB2CuXo8VPrNm1LfvH\/C0LSErKqCuoAAAlRyQGKGkQiF1cFQkQhMklYmCwCAIh9\/CT9fSaV9pc30sTnL0uKS+Z4uF+5eis8PGLd2lUH9u2VkpIsLa+kUNoMDQ37UwcIBALxDS0trWHDhkVEROApTCZz4cKFDg4OFhYWrOlsEAgETU3Ny5cvHzlyhFep9vZ2W1tbtk2GvYLJZDo4OLC9DEcikUgkEueeFwKBMHHiRPiOrbi4eFZWVmtrq7GxMae729jYWE9PTxKJZG9vn5qaCgCQlJSMjo4ePPgHvuLSg\/kx0NfT0tR8EBMHAHC0nywvL79ksZ+Bvi5RSGj3ru2HDh0uKSm7Gx1TWFQyZdLE9IwPiUkve+ulo7ub+uLVuzuRUT6+i7du211bV19VXbt9565tW7dQKB1Xr117\/fbdqtXrtLU0AAAPHsSMGzuGa5BvBAKB+H6YTOaePXtCQkLwF7Pu3LlDJpMfP378\/PnzrVu3sjp24kRRUREA0NHRwVmKRqN5enquX7\/e0tKyz+IRicTZs2ez+qstLCx0cnJycnLKzMxkzdnS0nL\/\/v2lS5fCd93c3Nzs7OxMTExCQ0M555xqa2vhZlECgUAmk7m65Oh3enh3R1xcbMli33XrN7u5\/ObjNdfCfASlo2PRkuXjx49f5OXp4+MTtHrtkUMHi4qKGhvr29o7nyQ8fZ+RsdjXR0AL0dzcErAiiEggLvbzzcnNsbWzZTAYa9dvsrWxmTxxQuzjpwcP7CspKWlqagQAtFM6nj59dv7cqX7oNwKBQPBAXV3dw8MDPsQAALKzs83NzQEAEhIS6urqNTU1nHECceh0Oo1GExcX5yxVWFjIYDBYQ1L1DS8vL9ZDbW3t8PBwAICUlNSJEydiYmIGDBiwZ8+e7u7usrIyFxeXSZMmAQAIBMKOHTuWLl3q7Oysrq4+fvx4AACeX0ZGhkKhwAqFhIT+GdeaPU9KmpsN09HRunTlOoZhzS0tq9estRw16urVKwCAxYu8hwwesmnLjiV+Cxf5+NTW1tDo9Jkzpm\/curO8oofpwq9VVZu27lq+an3g8mVNzc0qKkrr168bZWG2\/+BhCUmJbVs2FBWX\/b43pLi42NV5pu9CbwzDTp4+6\/Sbo4ICl2UkBAKB6EfWr19\/5coVeEXW1NT88uULAKCrq6u2tnbAgAEYhtXwcH25f\/9+GF+Ks5SxsfHy5ctZ333uG1VVVayH0I2srKyskJDQihUr4uLiwsLCAADKysrLly+fPHkynJSrq6sDACgpKdnY2MDPAAA8\/9ChQ+GUYG5uroGBwXdKKCA9mx9RUdE1q1edOnXma1W1laXFokW+GR8yS0pKPeb65OUXbt28Xl9PNzBoXWdX55mTRw0MDd+8eycnKztAVRkA8CLlbean7LKyisqv1bV19TW1dV9y8z98zN4fejQ3rzD5RUpBXl5jY9OmDesaGppGWYxYu34ThUIJCd71OSvHZ5Efpb391Jmz1TW1AIDsnLyXL1NmzXL\/4SpBIBD\/qxCJRLhTQFJScv369dA\/5uzZs798+fLbb79NnDhx7969ZDI5Pz8fPlJARERECgoKbG1tJ0yYUF1dffDgQc5SwsLCRCJxyZIlJBLpzz\/\/7LOEDAZDT08PnwDEBebVEZzr16+PHj3a3t4+JSXFy8uLLYOHh0d2dvbMmTN9fHwOHDgAAKBSqdOmTQsLCzt16hQehrF\/IbBNAkKnpGyZMAzbsev3tva2kODdAIC9+0OZGMjOyiKRhbdv2aijrfnHmT+fPHmyZvUqkyFDIu\/en+4weaCGWvaXvEsREa6uboePHhsxYoSwsMibt2\/cXZxpdHrw73t37tiWkPBsqKkJSVh46ZKFr16\/Oxh6yNTUdHXQiqLi0mdJybdv3\/bx8tbV1bIeP4ZOZwQGrV0dtHzYUC5xUaEf7x+hHQQC8Z+EQGC\/9OGw7lXDMAy\/tlAoFHFxcfxQwC1trKUYDAYeQfF7ZrfodDrr2g8vSTjT4fqTpKQkrwwdHR1cg\/D2I6yaF8hvG4FAWLNqpfuceddu3PZa4Ll7x5bYx8+Snierq6mfvXDJ+TfHlcsDTIcM2R28d9zYMSuW+auqqLS1U\/buO9BOoXR2dubk5MhKS+obGBXk5RKJxK7OzkGDhyQ9fxHg76ehpipEIu35ff\/j+PigwBXTHR2qq2t27N5bUlwweLBJUUmxj5ensLDwnxfOammqc7U9CAQC0Y+wXpFZ72vxqLKc2fjAWgo3Od+5ssIWJ5eXJJzpIiIieBx3rhl+tO1hQ6CnH8iXnDy\/JUv37N5lO2FsUUnZiqB1RAKQEBejM5l7dmwbZGxQW9dw8o8z96LvT5k8ce5cT3W1AQwGMy8vl8EESc+T9fUNJMVF8woKp0+zl5aW0hyonl9QfPX69Xv3HkyZPHHF8qWqKsqnz118FPe4orx8w4b1mZmf9u7ZRiaTIqOiU1JSQg\/sExLirmX09INAIHoFn6cfxA+FVfM8zU9jU\/PigMCxVpZeC+bKy\/3lvTHhadLOXbuD9+y2nTAOALBu43ZDQ4NbtyOXL1tKBMwRI8zU1VRr6xqu3bj14MHDltbW8WPHDB1qqqo6QF5eXkpaqqurq6amtramOvvLl2eJzyXExR3sp86bO1tdbUBuXkHyi5RrN24OHmzy7t3rFcuWLpg3BwBw+050WHh4+MU\/lZUUcSEfxDyiUDpnz3LB+4PMDwKBEBxkfn4WApkfAMCVa7d27tptYmJyYF+woYF+VXVNeMQ1bS3Ns+fO7dy+3WbCWCqVFhZxNfpBLJ1OI2CMO7euS0pKwEraKZTa2rqXr97l5uW2NjfWNzTBaF2qyopiElKGhkYTxlupqqpKSUpAy9HZ1XU3OvbIkUP6+obHjhyUkpQQExOLjLp\/6syZVStXkkkE+6lTAABNTc0HDx9PTHz659kzJkMG4f1B5geB+JeAYdiff\/45b968f3gmhxUmkxkaGurv7y8tLc01AzI\/Pwt+5ofJZObmFbS0tNBoVEpH1+Ejx0ZZjk5OTjpz6uSmzduam5u0tXXGjhlz+cplf\/8lHm7OABCev0j54\/QZ34U+9lMm8mqyqbmV0tEhKSEuK8P9bAAAtLa1Hz\/5x\/y5nhrqahgG\/rwQHnknynfRothHsVVVVdMcpqwOWrlj914xMYnPnzOPHDpYWlqqpqauoqxEIgkh8\/NTaGpqotPpioqK\/wH9M5lMBoNBJnNxTvhvbut7huBHDB+DwViwYEFUVFRaWhqMMwv50eplqz8vL8\/MzExDQ+PJkycDBw7kzP+zzA+FQikvLzc2Nv7nm\/6XwKp59tUUBoN5+dqthX4B92Piox8+olKpTjMd9XR03Nw9TE1Nrl25pKKiHJ+Q4L\/E\/+y5P\/eHHmlobLSdMO70iWOTJ3KJVYpTV1cXF\/+Mj+0BAIiJii4L8NccqFFbV791x67o+w8C\/JfcvHVTQ0MjIvxiecXXufO9W5qb7Wyt29o7rt64ExP3NHDV2vLKH+WP6FfH2dlZW1sb7qHkpKamRvsbbC5AYEFNTc0BAwZoaGiMGTPmyJEjrCFHGQzG0aNHdXV15eXllZWVVVVVN2\/ejGeAxQcOHKiqqjpw4EBLS8vg4OCOjg4BBYDFbW1tWa8OI0eO1NbWLi4u5trHvXv34imRkZHa2tqsFz7+zbW3t+\/YsUNXV1dERERYWFhCQmL16tVcK+evT0FU19u28MPXr19ra2vr6up++vRJkCHgL22PZSFv3ryZPXu2mpoaiUQSFhbW1tbGX0vkVDvOnj17rl27dv36dTgEvLrs7u6uzY2ZM2fy0gZXrfKq39DQ8OHDh0VFRW5ubng4V0Fwd3e3+YatrW1TU5PgZQXhRzge5e8Y9MWLF9bW1tXV1XhKQ0PDwoULLSws\/Pz88B8mm79RtjrpdPrWrVunTp06Z86cxsbGfhMd+ztMJrOrq3vpitXbdwV3dXWXlJZX19TOcHJfs35LV1cXg8FobWvbd+DwmPG2N27dnTPPZ7qT2\/MXr7q7uxm8uRl5123W7MGmw7fv2F1RWcUnZ2dnV2xcwiT76UsCVly9ccdqvO2JP850dHYyGIz2doqPb8B8b7+q6trKqmoKpWPjlp2JSckMBoPJZGIIDmDU5F27dnH99uzZswAABQUFAMCmTZs4CxobGzs5OVlZWcFb4+nTp8NvGQwGfKuOTCbb2tqOGjUKZhgzZkxHRwdefNCgQU5OTuPGjYPfzp07V0ABbG3\/uo+5dOkSnqihoQEAqKio4NrHzZs34ylXr14F32KMCtKco6MjAEBeXt7BwcHe3t7IyGjLli2slW\/dulUQfQqiut62Bb\/t6uoyNTVlbbrHIeAjrSBlMQwLCQmB6WJiYpqamtLS0rKysmzdxKXFycvLI5PJbm5uPap38uTJurq6pqamSkpKcFwGDx6spaU1Y8YMXtrgqlU+KsUwDJqi06dPc44U56UPAn0WGBkZNTc30+l0PJ1KpXJqEv9Mo9FYv2I7ZC2bmprq4eHBtem+0dbWNnPmzPnz5584cYLzWxqNZmtra25unp+fjycWFhamp6dTqVRHR8dTp05hGJaSkjJlyhQajRYbGzt9+nTOOi9cuODv749h2MmTJ5cvX\/49ArNqnov5YTAYrW3tk+xnvH6TWl\/f4OLuuXL1elYjQaPR4xOeDTIdsXf\/ofNhl0dajfdfGpidk8fLqDQ3t9pMsldQHhAZdZ+P7Xmf8dFzno+13dSrN+7s3B0yYuSYhKdJNBqN1Th5LVzsu2R5U1Pzk2dJm7ftgunI\/HBl8uTJAIC9e\/dy\/dba2ppMJh8+fBgAYGhoyPrV1KlTAQDnz5+Hh7du3YL2oK6uDsOwkJAQeH3\/9OkTzBAfHy8qKgoAWL16NV48LCwMfnvhwgUAgIyMjIACODo6kkgkcXFxJSWl+vp6mKinpwcAwA\/ZRN29ezeecufOHQCAhoaGIM3h736XlJTgOfGLjr29PQAgODhYEH32qLpetcXar5UrVwIAZs+ejZ\/nPQ4BH2kFKQtDBpDJ5LNnz+KXzurqarwSNmlx4MuJb968EUS9kBUrVgAA\/Pz8WBO5aoNTq9CnAJ\/6a2trSSTSoEGDMA54mR+IkZFRW1sb\/Pzly5epU6c6OzuPHTu2tbU1IyPDwcHB0dHRxMTk+vXrtbW1kyZNcnd3V1RUPHDgANshW1msP8wPg8Gwt7dnM4chISFczc+hQ4cuXrw4ceJEVvODExgYePLkSQzDtmzZEh4ejmEYk8lUUVHhrHPNmjWXL1\/GMKysrMzc3Px75GfVPPetzBLiYiuWBRw6cuzoyTPFxUXbt25i\/ZZIJEy0mxD\/6GFBQUF4+KXFfou1dXS9fXzne\/vFxiVQKOzTLAAAD3f306fPSEtLcX7V3NJ6L\/qh40zXVWvWjrK0nOfpeerU6eqamkcPo+1sxrPuTBcWJu\/fG5yennbk+OmwsIjFvgu5Co+AwHcL2F4RgBQVFb148WLSpEmenp5EIjEvLy8jI4OtIP5UPnHiX0t6TCaTRqPB+Zzt27ebmPwVX2Py5MmBgYEAgDNnznR3d7MVt7CwAN8eOwQRQEhIiMFgeHp61tXVwWoBAPBlBc6+wLZY36LgTOHTHB4\/mzVQCl4Wnnts72pw1acgqutDW0JCQpGRkceOHZs0aVJ4eDi86xdkCHhJK0hZDMPWr18PAAgKClq8eDG+mqKiooLXwyYtzu3bt9XU1EaNGgUP+XcZAiVkewGFqzY4tYr3jlf90MHMly9fKisrQV\/R1dWNjY2NiooaNmzYixcv6HR6TU3NnTt3oqOjT548GR0dPWPGjFu3bllbW7u4uLAdspXtswyscLoc5UV1dfXjx495hSxqaGiIjY11c3MDAvgbnTBhwokTJ65fv378+PH29vbv7cM3eL45NXWynZGRYWbmR1lZuTXrNrZzGBW1ASrHj4Zu3rQh7tGj169fL1q00HL06CtXr\/3mMmtZ4Jo7UfdS0z\/U1TcAAMQlxBb5LHD5zdF6\/BhYtqy8MjUt4+btO75LVrjPnnv\/YYyzs7Obm9vj+PjEpMTt2zYfDg1RVGT37Vbf0Bi0Zp2IqFhuXp73As+BGmr9pYX\/JPA3zHVVGd7puLm5qaiojB07FgBw\/fp1\/Fv8xWx4ePHiRQCAiYmJsrJyWloanA13d\/+b96M5c+YAADo6Oj59+sRavL29\/fDhwwQCYdeuXQIKICQkhGHY0qVLJSQkrl27FhMTA76ZH87rHUyJj4\/f+I3Lly9z5uTVnLS09LRp0wAAK1asMDU1DQ8PZ10nYLNkfPQpiOp61Rb8cP\/+\/fnz5w8ZMuT+\/fv424KCDAEvaQUpm5GRAdfY+Lgm42rjKysrKysrLSws8Eb5dxnCVZ9ctcGpVX19\/R7rHzlyJADg\/fv3vPrSI21tbb6+vosWLUpOToYm0MDAQERERE1NraWlRU9P7+bNm+fOnSsvL1dXV2c75CzbL3h5efE6D0+cOGFvb+\/j4wMA2LFjx4QJEx4\/ftzQ0PDy5cvjx4\/jX1Gp1NmzZ4eGhsK7CnFxcf7+RmfMmAGn6aZMmaKsrNxfHeFpfshk8sb1q91dncXERJOTkwOWBZaVV7DlERMVnTrZ7tyZP+bP9YyPj49\/HKelpbNg\/jxdXd24hGf7Dxxc7L9s1px5ixYv8\/VfvnDxssUBgd6+Ae4enkuXrww9fCQx6eXgwYO85s+Xk1O4ezfq9es3ywKWnP7j2CS7CSLf7psgGIaVlJavWbep6mvFKIsR2zavt7Pjt9MBAb79sDlPUyaTGR4eTiaT4RoAvP25ceMGhm9HIRIBABEREU5OToaGhuvWrVNSUoJODCsqKgAAJBJJVVWVtU4tLS34obW1FRb\/\/fffDQwMlJSUbt++HR8fP2\/ePAEFgMXl5eV3794NAFi6dGlHRwfrq9qcfXz+\/Pn+b8DJN9Ze828uIiLCwcEBAPD582cfHx9TU1M8IjLbFZyXPlnho7petQUP379\/39XVlZWVdeLECbwJQYaAl7SClC0qKmJLBAC8efPmzJkzULec0kIKCgoAAPr6+qyJfLoM4apPrtrgqtUe6x8wYAAAoL6+nrMVAQkLCxsyZMiFCxfwVUkcDMPevHkzY8YMTU3NhIQEUVFRtkM+Zb8HNpejrLC6HJ0yZYqwsPDnz58pFEpeXp6\/vz\/8isFgzJ0718PD47fffoOlBPE3am5u7unpmZ6eDtfb+gV+T3DiYmJz57jPnDGtsKgk8k6U\/9LA4N07hg01YbONsrLSzk7Tx44dnZOb9+xZUsSVKzJSUto6OsbGxirKysLCJDghI0QUYjDoDAZTVEyUQumqr68rKSlOfPaMSqfZ2Uxwd9tiPmIYmdsTJZ3OePXm3dFjJ1avChw9ykKQp04EAID1as5KfHx8eXm5pKQkvOdtaWkBAJSXl8MdMuDbbWZpaSmDwTAyMgoMDPT29oZ+oqAZoNPptbW1rDdB+L4aFRUVWFxFRUVbW7utra2mpmbdunUpKSn4WyD8BYDFqVTqypUrb9++\/ebNm3379kHPJZyhpGDQrYCAgIUL\/5qJTUpKWrduHWtO\/s0pKCjExsYmJibu27cvPj4+JyfHxcUlMzMTn4LAq+KlT1b4qA4AIHhb8HDXrl0dHR3BwcGbNm2ysLCws7MTcAh4SStIWfwuuKKiQldXF35++vTp1q1bLS0tXV1dcfHYhgN655SRkWFN5NNl1p6yVcVVG1y12mP9YmJiAAA8co+AsLrjtLKy8vf3f\/\/+fWlpqY2NDYFAwK0jkUgcPHjwli1b3r17t3Pnzp07d7IdspXFS\/VKGDYYDIaenl5TUxMcTSqV6uTkVFhYKCQkVFBQcPToUTwnHCwAwOPHj319ffG50Fu3bsXFxVVVVYWHhw8dOvTUqVMeHh7Xr1+fOXNmfX39H3\/8wVlnYmLi8ePHOzs75eTkLl269D3y\/w22dSG49YArF8OvWIwe98eZ8xRKB8fmghbP+Qv9lwZ+ycnv7qa+\/\/DpyvWbW7btdPzNbdRYWwsrG7ORY0eOHm82aqyFlc3ocXYzXTx2B4fcuBX5KSsH1rB0eWDa+0zORltaWg8eOjZ7rk9Obj4vwdDWA67ABVvOBUk48aKoqKj1DbjyDHe2YBgGJzQOHjzIWWdJSQk8bfCdBRC4pK+oqMhgMGDxffv2YRjW2NgIQ9Nu2LBBQAFmzJgBAMjOzsYwLDc3V0xMTFJSEvalsbGRTR7odZh160FkZCQAQEtLS\/D+4uATgOnp6bgeQkJC+OuTFT6q61Vb8DA4OJjJZMJ2Bw4c2NLSggk2BLykFaQsfEJiFQbDsPPnzwMArK2tWcVjzYBh2N27dwHfnYFsXYbArQeLFi1izclVGz1qlWv9MGYPXDZnhfPSxwqDZVcbhmFUKrWrq4vJZMJLDb67gUajubm5webu3r0bEBDAdshZFuPYfNEH2HbW9Vd+CoXC59vW1taurq5etcsV0OPWA654zZ9z5VLYs8QkN4+571L\/NpdaWFSclpYmLCoREXGJRBIqLy\/rpHSsXrXyftTN18lP3r58mvYm+U1KUtrr5Lcvn6Y8T7h7+9qSxb5NjY2VlX+d6w9jYlcGrSot+9v8XtKLVwsWLgaAGRF+zkBfV3BREeDbzSO8+8NpbGyMjo4GAMTFxZV8A87yR0ZGwqlzeLPJ9W0JLS0teA++detW+H4AAKC0tBTupwoKCiISibAgfC6Rk5PbuHEjAODUqVPwsaNHAViLGxoaHjhwoL29\/cmTJ1xFgtlY09mEF6S\/OLNmzYKPWW1tbXgleB6u+mSDj+rY4N8WfkggEM6dOychIVFeXr5hwwYBh4CXtIKUVVdXh3Mye\/fuxaNnysvLA5alfjZpIXDtms9LIWxdZtUY21o3W\/0CapVr\/V+\/fgUAsE029gjbAwqZTBYREcG9q+DTPyQSyc\/Pb9u2bZ6enjdv3ty4cSPbIWdZwG0Js7f0dgZIwPz8vVRISUnxmgPvM73rhoG+bvj5M3ejH67bsGH4cDP\/xb7GRgYEAuHO3Wgzs+EYo8vVzaujs+vDh49vUtPVNdQnT7R1dptdWlrq5ua+ddPa7bv2vn37liwscufmlbS0tJevU6MfPITvq2IYaG5p27Zz9x\/HDktIiH\/8nH3i5CkJcfHQ\/b9ra2l+5+Pq\/yZUKhUAcPr06Xv37tHp9K6urs7OzsmTJ1OpVGVl5REjRuA5p06deuLEifr6+qSkpEmTJsGZCl4Rhc+dO2dpaVlZWTl06FBXV1chIaHbt283NTXZ2dnB6yN8HxC\/WHh4eAQGBra1tUVERKxYseL69ev8BYCt429BLlu2LCoqKjExEXCbQoHmhzXuPew1Xpx\/c7Gxsdu3bx89erSKikpXV1dycjKFQlFRUYF7t2AleFVc9RkWFjZo0CC8Zj6qa21ttba2FrAt+AG2qKmpuW3bto0bN549e9bLy2v06NE9DgEfaQUpe\/r06Q8fPpSWllpaWs6aNcvY2Pjz5894nZzSQoyMjAAA+IuxPXaZs6dsiXj9vLQqSP0fP34kEAgw6uiPYMqUKVOmTMEPNTU1WQ8RPcD2ZMRn8g2HTqdXVHwN3hc6ccq05SvXJL949TTxRUFhMfy2vKLSd8kK\/2Uryyu+MhiMh48SvHwWVdfUMhiMVes2zXSZPczCqr29vbm5ZeuOPQsXL2tqamYwGJ4L\/LKyc54nv4p7\/GTpitXeC\/3epaZ1dnb2KAyafOMF13jy8Crs5OTEmhN\/tTswMBAvuHHjRl415+XlsS6lioqKBgUF4Q\/msDjrq6Bz584FAJiammIYNm7cOP4CwOJJSUn4t7m5ufCGMScnh00SuK9pzZo1eArcFiUhIQEP+Tfn4uLCph9zc\/P379+zdgSvnKs+4SQhm865qg5a0F61hR92dXXBJfQxY8YIMgT8pe2xLIZhNTU1vr6+UlJSrNnwd4fZxMPR1dUVFRVtbm4WpMsQeG64urpyqpFNG5xa7bF+CoUiJibG9T0VwHfyDfHjYNV8LwIucFJYVBITGxefkCAlJW0zwdrO1lpdXS0jI3Pn7j3Dhg4N+X0PmUyKjXv6JCHu8KGDAIAdu\/cx6F2uLi7Dh5nW1TcuCVgmKiq2bu0qAz3d9x8+pqW9zy\/Il5aRmTFtitXo0YI\/YCKXoz+FsrKyvLw8MTGxYcOG4avrvxw1NTWFhYWtra2ioqL6+vrQvcKv0tb3DIEgZel0enFxcWtrq5yc3MCBA3v02BYcHLxt27ZDhw7hzoR+tHr513\/27Fl\/f\/9z585xbiJHLkd\/FoJ6vBaQ5pbWV6\/fxj6Ke5\/xQUdroJHxIAtzC0UFOQMDPWEyubyyqri42GHqJADA8xevyWQhc7PhNDqdQqFUVHwtr\/j66fOnosICBhObOtluwoQJGuq9fpsHmR8E4t9AY2OjiYlJZ2fnhw8fWPdt\/xSamppMTU3l5eXT09M5DScyPz+LfjY\/OFQq7fmLV7m5OW\/fpWV9yaHTaCrKSsrKSlqa6sRv5gHDsIKi0tq6egKBOMF6rKy0pKGR8SQ7m+9xhYvMDwLxLyEpKcnBwUFHRycuLk5TU\/NnidHe3j5jxozM1o3cPQAABh5JREFUzMznz59Dj3ls8DI\/ra2tzs7OTCZzwIAB69evHz58OP+G3r59e\/78+T\/\/\/LPHxB9EQ0PDunXrPn78aGZmduzYsZ8Y5EJAejA\/\/dIGNGMlZZUVFZW1dfX\/3x6BMEBVdfQoMyKR2I82A5kfBOJfwqtXrxYvXnzv3j22V1D\/SZqbmydPnnzx4kWutgfwNj8VFRVOTk6pqalPnjxZunRpfn4+TGcymVw3QDGZzK6uLvyiT6fTSSQSW+IPpaioqLm52dTU1NnZ2dHRMSAg4B9o9Htg1Tz7+kp\/XcdhPXo6mno6P+0OCIFA\/POMGTPm06dPP\/eOUFZWNjU1tc\/FCQTC8OHD4X48JpO5ePHilpaWurq6w4cPjxgxwsnJaceOHWZmZpGRkY8fP6ZSqZcuXfry5UtAQICqqqqzs7ORkdGRI0f68\/VMFphMpqOj4\/379+GMEf5qsJ6eHud72f9y0IZmBALRz\/zSsxF5eXkTJ060srKC9iM6OlpBQeH27dsnT54MDg4GADg7O1+7dg0AcO3atQkTJsAd4YmJiTY2Njdu3PDw8KDT6bzeW\/h+uLocZfUf+guBzA8CgUD8P4aGhjExMVZWVrm5uQCA7OzspKSkefPmhYSEwCilLi4uDx8+bGlpKS0txeOWzp8\/H3rW+fjx44+WkM3lKJv\/0F8I5D8NgUAg\/oaoqGhISIidnZ2fn5+Ghoa1tfXBgwfxb6WkpIYPH75x40bcqRpMDAsLe\/Hixa5duzZt2sSt1n6jqqoKvgcGAGBw+A\/9hUDmB4FAIP4CdzaqoaFhZGT07NkzDw+Pmzdvurm5kclkGxubJUuWAADmz58\/c+bMgoKChoYGmP\/48eMpKSn19fWLFi36fr+ifGD83eUop\/\/QH9TujwBtfkcgEP9z8HnvB9\/kxmAw8A26FApFSEgIOquF0Gg0uPjPYDCgV462tjYRERHoWBpP\/BHA\/XU\/qPIfDb+N1wgEAvGfB712+rNg1TzaeoBAIBCInwAyPwgEAoH4CSDzg0AgEIifADI\/CAQC0QsoFEpOTs7PlkJQMAzLysr62VJwB5kfBAKB+IuGhga4tRoAUFVVtXLlSs48X7582blz5z8qFl9qa2u9vb2joqK4fkuhUGBQJV68ffuWNSBFQ0PDwoULLSws\/Pz8Ojo6+lnWv4PMDwKBQPxFZ2dneno6\/EyhUPBw4+DvQXVZ4UzHY4ezOmHjzNYvLtra29v9\/PyYTCYMK95jE2xiMBgMCwuLY8eO4SktLS3Lly9\/\/fp1VVXVD3Jbh\/Orbh5HIBCIf4acnJygoCBxcfHa2tpHjx7xSi8sLNy8eTORSMzPz\/f394+Li6uoqAgJCTE0NOSarbS0dMuWLbNnz+6VMGwuRyUlJaOjo\/ft28eWjUajubq6tre3Kykp8ZJ2w4YNMM46q6X5J32YIvODQCAQ\/09OTs7o0aMBAN3d3TIyMgAAXV3d2NhYIpG4bNmyFy9eKCsrw5yc6bW1tSkpKa9fv162bFlqaiqcprtz5w5btpqamlevXlVWVi5YsKC35oery1FO7t27p6amdubMmdevX8MoDJzSlpWVpaenZ2dnh4aGshWHPkw3b97cK9l6CzI\/CAQC8f8YGxu\/efMGAFBQUODr6wsAaGtrW7duHYFAePfuna2tLZ6TM11fX19ERERVVVVHR0dcXFxFRaWtrY0zm4GBgYiIiJqaWktLSx8k9PLy6jFPYWEhjJWHRzziFGPYsGFcgxL9Yz5M0doPAoFA8CMsLGzIkCEXLlxgtT180gUsDvoa3rOqqqrHPCoqKjBWXkFBQa+k\/Sd9mKKnHwQCgfgL3OUo62crKyt\/f\/\/379\/DkAq4R1Fe6awfCARCj9l6BZvLUSqV6uTkVFhYKCQkVFBQcPToUZjN1dX1zJkzv\/32m5KSkoSEhCDSQv5JH6bI8RECgfifQxCXo6yfaTQak8mE7kQJBALuUZRXOu4VFH7oMVuvELxUZ2enmJhYj9L+UAepbCCXowgE4n8a5HL0Z4FcjiIQCATiJ4PMDwKBQCB+Asj8IBAIBOIngMwPAoFAIH4CaOM1AoH4n0NWVhZG0Ub8w8jKyuKf\/w+7vNTpOBZk8AAAAABJRU5ErkJggg==\" width=\"571\" height=\"101\"><\/p>\r\n<table style=\"border-collapse: collapse; width: 100%; height: 90px;\" border=\"1\">\r\n<tbody>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 13.4298%; height: 18px;\">No. Reg<\/td>\r\n<td style=\"width: 30.6473%; height: 18px;\"><span class=\"input-variable input-nomordokumen\" name=\"nomordokumen\" contenteditable=\"true\">{{nomordokumen}}<\/span><\/td>\r\n<td style=\"width: 30.9229%; height: 18px;\">Tanggal Pemeriksaan<\/td>\r\n<td style=\"width: 25%; height: 18px;\"><span class=\"input-variable input-tangglPemerikasaan\" name=\"tangglPemerikasaan\" contenteditable=\"true\">{{tangglPemerikasaan}}<\/span><\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 13.4298%; height: 18px;\">Nama<\/td>\r\n<td style=\"width: 30.6473%; height: 18px;\"><span class=\"input-variable input-namaKlien\" name=\"namaKlien\" contenteditable=\"true\">{{namaKlien}}<\/span><\/td>\r\n<td style=\"width: 30.9229%; height: 18px;\">Waktu Pemeriksaan<\/td>\r\n<td style=\"width: 25%; height: 18px;\"><span class=\"input-variable input-waktuPemerikasaan\" name=\"waktuPemerikasaan\" contenteditable=\"true\">{{waktuPemerikasaan}}<\/span><\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 13.4298%; height: 18px;\">Pertemuan ke<\/td>\r\n<td style=\"width: 30.6473%; height: 18px;\"><span class=\"input-variable input-pertemuanKe\" name=\"pertemuanKe\" contenteditable=\"true\">{{pertemuanKe}}<\/span><\/td>\r\n<td style=\"width: 30.9229%; height: 18px;\">Tempat Pemeriksaan<\/td>\r\n<td style=\"width: 25%; height: 18px;\"><span class=\"input-variable input-tempatPemeriksaan\" name=\"tempatPemeriksaan\" contenteditable=\"true\">{{tempatPemeriksaan}}<\/span><\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 13.4298%; height: 18px;\">Kasus<\/td>\r\n<td style=\"width: 30.6473%; height: 18px;\"><span class=\"input-variable input-kasus\" name=\"kasus\" contenteditable=\"true\">{{kasus}}<\/span><\/td>\r\n<td style=\"width: 30.9229%; height: 36px;\" rowspan=\"2\">Koordinator Psikologi<\/td>\r\n<td style=\"width: 25%; height: 36px;\" rowspan=\"2\"><span class=\"input-variable input-koordinatorPeikologi\" name=\"koordinatorPeikologi\" contenteditable=\"true\">{{koordinatorPeikologi}}<\/span><\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 13.4298%; height: 18px;\">Pemeriksa<\/td>\r\n<td style=\"width: 30.6473%; height: 18px;\"><span class=\"input-variable input-pemeriksa\" name=\"pemeriksa\" contenteditable=\"true\">{{pemeriksa}}<\/span><\/td>\r\n<\/tr>\r\n<\/tbody>\r\n<\/table>\r\n<p>&nbsp;<\/p>\r\n<table style=\"height: 456px; width: 100%; border-collapse: collapse; border-style: none;\" border=\"1\">\r\n<tbody>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 14.3526%; height: 18px;\" colspan=\"2\"><strong>Penampilan<\/strong><\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 14.3526%; height: 18px;\">Keadaan Kulit<\/td>\r\n<td style=\"border: 1px solid; border-collapse: collapse; height: 18px;\">\r\n<p><span class=\"input-variable input-keadaanKulit\" name=\"keadaanKulit\" contenteditable=\"true\">{{keadaanKulit}}<\/span><\/p>\r\n<p><span style=\"font-size: 10pt;\">(Bersih, Kotor, Penyakit Kulit, Luka \/ Bekas Luka)<\/span><\/p>\r\n<\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 14.3526%; height: 18px;\">Bentuk Tubuh<\/td>\r\n<td style=\"width: 19.4491%; height: 18px;\">\r\n<p><span class=\"input-variable input-bentukTubuh\" name=\"bentukTubuh\" contenteditable=\"true\">{{bentukTubuh}}<\/span><\/p>\r\n<p><span style=\"font-size: 10pt;\">(Gemuk, Sedang, Kurus)<\/span><\/p>\r\n<\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 14.3526%; height: 18px;\">Tinggi Badan<\/td>\r\n<td style=\"width: 19.4491%; height: 18px;\">\r\n<p><span class=\"input-variable input-tinggiBadan\" name=\"tinggiBadan\" contenteditable=\"true\">{{tinggiBadan}}<\/span><\/p>\r\n<p><span style=\"font-size: 10pt;\">(Tinggi, Sedang, Pendek, Stunting)<\/span><\/p>\r\n<\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 14.3526%; height: 18px;\">Pakaian<\/td>\r\n<td style=\"width: 19.4491%; height: 18px;\"><span class=\"input-variable input-pakaian\" name=\"pakaian\" contenteditable=\"true\">{{pakaian}}<\/span><br><span style=\"font-size: 10pt;\">(Rapi, Kotor, Srampangan, Sederhana, Serasi, Mewa, Bersih, Biasa)<\/span><\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 14.3526%; height: 18px;\" colspan=\"2\"><strong>Sikap<\/strong><\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 14.3526%; height: 18px;\">Tindakan<\/td>\r\n<td style=\"width: 19.4491%; height: 18px;\">\r\n<p><span class=\"input-variable input-tindakan\" name=\"tindakan\" contenteditable=\"true\">{{tindakan}}<\/span><\/p>\r\n<p>(Sopan, Tegas, Ramah, Garang, Percaya diri, Kaku, Sulit Fokus, Kurang tahu aturan, Ceroboh, Tertekan, Dibuat-buat, Ragu-ragu, Malu-malu, Kontak Mata, Tidak bisa diam)<\/p>\r\n<\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 14.3526%; height: 18px;\"><strong>Penyampaian<\/strong><\/td>\r\n<td style=\"width: 19.4491%; height: 18px;\">&nbsp;<\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 14.3526%; height: 18px;\">Ekspresi<\/td>\r\n<td style=\"width: 19.4491%; height: 18px;\">\r\n<p><span class=\"input-variable input-expresi\" name=\"expresi\" contenteditable=\"true\">{{expresi}}<\/span><\/p>\r\n<p><span style=\"font-size: 10pt;\">(Tertutup, Terbuka, Mudah, Hati-hati, Dingin \/ datar, Membatasi diri, Sukar mencari kata-kata, Tenang, Gugup, Takut, Lancar, Banyak gerak dan isyarat<\/span><\/p>\r\n<\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 14.3526%; height: 18px;\">Penggunaan Kata<\/td>\r\n<td style=\"width: 19.4491%; height: 18px;\">\r\n<p><span class=\"input-variable input-penggunaanKata\" name=\"penggunaanKata\" contenteditable=\"true\">{{penggunaanKata}}<\/span><\/p>\r\n<p><span style=\"font-size: 10pt;\">(Dengan tekanan suara, Terpengaruh bahasa daerah, Disertai istilah bahasa asing, Biasa)<\/span><\/p>\r\n<\/td>\r\n<\/tr>\r\n<tr style=\"height: 46px;\">\r\n<td style=\"width: 14.3526%; height: 46px;\" colspan=\"2\"><strong>Mood<\/strong><\/td>\r\n<\/tr>\r\n<tr style=\"height: 46px;\">\r\n<td style=\"width: 14.3526%; height: 46px;\">Afek<\/td>\r\n<td style=\"width: 19.4491%; height: 46px;\">\r\n<p><span class=\"input-variable input-afek\" name=\"afek\" contenteditable=\"true\">{{afek}}<\/span><\/p>\r\n<p><span style=\"font-size: 10pt;\">(Euthymic, Manik, Depresif)<\/span><\/p>\r\n<\/td>\r\n<\/tr>\r\n<tr style=\"height: 46px;\">\r\n<td style=\"width: 14.3526%; height: 46px;\">Ekspresi Afektif<\/td>\r\n<td style=\"width: 19.4491%; height: 46px;\">\r\n<p><span class=\"input-variable input-ekspresi afektif\" name=\"ekspresi afektif\" contenteditable=\"true\">{{ekspresi afektif}}<\/span><\/p>\r\n<p><span style=\"font-size: 10pt;\">(Normal, Terbatas, Tumpul, Datar)<\/span><\/p>\r\n<\/td>\r\n<\/tr>\r\n<tr style=\"height: 46px;\">\r\n<td style=\"width: 14.3526%; height: 46px;\">Kesesuaian<\/td>\r\n<td style=\"width: 19.4491%; height: 46px;\">\r\n<p><span class=\"input-variable input-kesesuaian\" name=\"kesesuaian\" contenteditable=\"true\">{{kesesuaian}}<\/span><\/p>\r\n<p><span style=\"font-size: 10pt;\">(Sesuai, Tidak Sesuai)<\/span><\/p>\r\n<\/td>\r\n<\/tr>\r\n<tr style=\"height: 46px;\">\r\n<td style=\"width: 14.3526%; height: 46px;\">Empati<\/td>\r\n<td style=\"width: 19.4491%; height: 46px;\">\r\n<p><span class=\"input-variable input-empati\" name=\"empati\" contenteditable=\"true\">{{empati}}<\/span><\/p>\r\n<p><span style=\"font-size: 10pt;\">(Bisa, Tidak Bisa)<\/span><\/p>\r\n<\/td>\r\n<\/tr>\r\n<tr style=\"height: 46px;\">\r\n<td style=\"width: 14.3526%; height: 46px;\"><strong>Symtomps<\/strong><\/td>\r\n<td style=\"width: 19.4491%; height: 46px;\">\r\n<p><span class=\"input-variable input-symtomps\" name=\"symtomps\" contenteditable=\"true\">{{symtomps}}<\/span><\/p>\r\n<\/td>\r\n<\/tr>\r\n<\/tbody>\r\n<\/table>\r\n<p><strong>(T)opics<\/strong><\/p>\r\n<table style=\"border-collapse: collapse; width: 100%;\" border=\"1\">\r\n<tbody>\r\n<tr>\r\n<td style=\"width: 100%;\"><span class=\"input-variable input-topics\" name=\"topics\" contenteditable=\"true\">{{topics}}<\/span><\/td>\r\n<\/tr>\r\n<\/tbody>\r\n<\/table>\r\n<p>&nbsp;<\/p>\r\n<p><strong>(I)ntervention:<\/strong><\/p>\r\n<table style=\"border-collapse: collapse; width: 100%;\" border=\"1\">\r\n<tbody>\r\n<tr>\r\n<td style=\"width: 100%;\"><span class=\"input-variable input-intervention\" name=\"intervention\" contenteditable=\"true\">{{intervention}}<\/span><\/td>\r\n<\/tr>\r\n<\/tbody>\r\n<\/table>\r\n<p>&nbsp;<\/p>\r\n<p><strong>(P)lans &amp; Progresses :<\/strong><\/p>\r\n<table style=\"border-collapse: collapse; width: 100%;\" border=\"1\">\r\n<tbody>\r\n<tr>\r\n<td style=\"width: 100%;\"><span class=\"input-variable input-plans\" name=\"plans\" contenteditable=\"true\">{{plans}}<\/span><\/td>\r\n<\/tr>\r\n<\/tbody>\r\n<\/table>\r\n<p>&nbsp;<\/p>\r\n<p><strong>(S)pecial Issues :&nbsp;<\/strong><\/p>\r\n<table style=\"border-collapse: collapse; width: 100%;\" border=\"1\">\r\n<tbody>\r\n<tr>\r\n<td style=\"width: 100%;\"><span class=\"input-variable input-specialIssues\" name=\"specialIssues\" contenteditable=\"true\">{{specialIssues}}<\/span><\/td>\r\n<\/tr>\r\n<\/tbody>\r\n<\/table>\r\n<p>&nbsp;<\/p>"',
                'nama_template' => '[F-PSI-01] Form Pemeriksaan Psikologi', 
                'pemilik_template' => 'Psikolog', 
                'created_by_template' => 'Psikolog', 
                'created_at_template' => Carbon::now(), 
                'updated_at_template' => Carbon::now(), 
                'created_by' => 2,
                'created_at' => Carbon::now()
            ],[
                "uuid" => 'fd431cc3-23fb-4a42-84ff-36bae7d53f4e',
                "template_id" => 1,
                "judul" => 'Ini Contoh Dokumen Yang Tertaut',
                "konten" => '"<p style=\"line-height: 1.3800000000000001; margin-left: 36pt; text-align: center; margin-top: 0pt; margin-bottom: 0pt;\"><img src=\"data:image\/png;base64,iVBORw0KGgoAAAANSUhEUgAAApQAAACnCAIAAAAg3FtBAAAACXBIWXMAAA7EAAAOxAGVKw4bAAAgAElEQVR4nOyddVxUW\/fw1wzD0DAgKdIgKWEgpYTdYGAr9rWu2GIjtiJgiwHYil7AQixABQQMEAQBpbubYYLz\/rH1PPMMMGDc37087\/7+MZ85O9Zee+9zzjq7KQRBAAaDwWAwmJ4D9Z9WAIPBYDAYzI+BjTcGg8FgMD0MbLwxGAwGg+lhYOONwWAwGEwPAxtvDAaDwWB6GNh4YzAYDAbTw8DGG4PBYDCYHgY23hgMBoPB9DCw8cZgMBgMpoeBjTcGg8FgMD0MbLwxGAwGg+lhYOONwWAwGEwPAxtvDAaDwWB6GNh4YzAYDAbTw8DGG4PBYDCYHgY23hgMBoPB9DCw8cZgMBgMpoeBjTcGg8FgMD0MbLwxGAwGg+lhYOONwWAwGEwPAxtvDAaDwWB6GNh4YzAYDAbTw8DGG4PBYDCYHgY23hgMBoPB9DCw8cZgMBgMpoeBjTcGg8FgMD0MbLwxGAwGg+lhYOONwWAwGEwPAxtvDAaDwWB6GNh4YzAYDAbTw8DGG4PBYDCYHgY23hgMBoPB9DBo5L+2tra\/OzEWi\/0pPTM7N7esrLSutrqkuLSssgp55ecXqKurof9mxgayveQH9h9k2s+QThemUCh\/t2IAQKXi7xgMBoPB9AwoBEGgf3+f8W5uYUZGxz58HJ6WmlxRVl7f2KigqCon10utj6qurg4Ko6HRJy+vEP3\/9Cm9pq62ldnS2lxHFaIa97PYvGGthnof6t9pxbHxxmAwGExP4W803k1NzcUlpZcu37x1+wazqV5OVs7QrP+oYSOmTR4vIy3ZHQlsDudC0I3nz158TEqob2iYNWPWqtXL5eV6SUlK\/PbmODbeGAwGg+kp\/C3Gu7ikLO5NfNj9hwmJicpKio729tZWNg72NnS68E\/LDL0fEZ\/wJjYmTlVNw3GI5ciRIzW+d7P\/FrDxxmAwGEyPgfgO93fAZLZevXln5NiJqpq6cxf8cf\/+46wv2e2DPXnx6k7Yo1P+AavcNya8\/bB46fLsnLwZs+euct949cZfSR\/TLgTeeBX7li9Wa2trZtbX0HsPp0yfN2zU2MVLllVV1\/4WtblcLvEjLFq0iCxAMTGxAQMG3Lx5E3kNHDgQAM6cOUMGfvToEQCYmpqiy0+fPk2bNk1VVZVGo0lJSdnZ2fFKvnTpEhI7aNAg5NLc3NxhxQkLC\/NGLCgoIL0oFIqqquqiRYuKi4sJgrhy5QpfXGlpaRRLR0cHAMLCwjrM5rx581D4jRs3IpeYmBjk8uHDB+RSXV1NoVDodHpJSUlnWUDo6uoCwJw5c0gXPz8\/ANizZ4\/gRAmCKCz8NqRy4cIF0tHFxQUAXr58SboILiveWkNMnDiRr+ioVKqSktKkSZM+fvyIZAqoawEK88oUERHR0tJatGhRVlYWGaDL+4REgAKo+ng5duwY8lqwYAFy4S3e48ePI8dZs2Z1KNzAwODQoUNk+M7k88YSFxc3NDQ8ePBgW1tbdzKOyM7ORmGEhITq6+sJgmhqamIwGADg4+NDBjMzMwOAu3fvki4aGhoo4sOHD4l2dOh79epVAKBQKLxqyMrKUqlUvui\/8hAhZGVlra2tQ0NDkZeAWHl5echFWFiYw+GQOvTq1Qu5Z2ZmClbpwYMHAKCkpMSbBUtLSwD466+\/SJdffB4JnuqmUCgMBsPOzs7f37\/9O\/MXC5\/kV94AnamBKsLMzAxdvnv3Dt2fOTk5nanx7+c\/E9Z+ncqqmgVLVka9eGw7ZFh8zGsVZQW+AId9zir0kg0MPJ+RmTXUfjgAJfzhX80t7Pv375v1Hxz3JqH\/AKujx3x0dPXeJsayWazdnvuCg+\/MmO46b9ZkKpVKo9F0tDV1tDXHjx2dkfF13qKlpv0HXr8caGdr\/Rtz0R3ExMQAYMiQITY2NllZWaGhoTNmzGhtbZ03bx6NRgMAYeH\/9DGIiooCgJCQEABUVFQ4OjqWl5dbWVkNHjy4oqKCr8X\/4MEDKSkpDofz7t27yspKeXl54vvDw+FwgoKCAGDevHlNTU3E9y4TXpXExMSWLFlCpVLDwsIuXrz46tWr1NRU5KWqqmpubo4Cy8rK8sZCGvLB5XLDw8MVFRXLy8sjIiIOHz4MADY2NsOGDXv+\/HlgYKCvry8A3Lp1iyCIFStWKCsrd5YF5C4uLg4AN27c8PDwMDIyAgA6nU7qICBRMi4A7N27d86cOSIiIh1GF1xWKKSpqama2rc+G1tbW9JdXFx86dKlwsLCERERYWFhiYmJBQUFVCpVQF0LUJiU6erq2tTU9OLFi4sXLwYHBz9\/\/hyZbcH3Sfua7VAB5OXo6EiWj4GBAfpTVVVFpVLb2tqSkpJIUQkJCUJCQlwut6WlhVe4vb29lZVVYWHhzZs3N2\/erKio6ObmRvq2l4\/cHRwcrK2ti4qKbt26tWXLFgaDsWzZsi4zTt4kAIDK7dmzZy4uLuLi4uvXr9+xY0dgYKC7uzsAfP78OTk5uX\/\/\/ugdDQApKSl5eXlkaY8dO5a3oDrzRcoTBLFz587r168jRzqdznvn8JbGzz1Ec+bMUVNTS0pKCg8PnzJlSnJysrGxsYBYVVVVAEClUtlsdlpaWr9+\/QDg69evVVVVvHUkQKX2t1CHd9GvPI+8GbSysjI0NPz8+fPr169fv34dGRlJFuZvKXzEL74BOlMDhSHLauvWrQCwc+dOTU3NDtXoGZBm\/FearZVV1afOXexrZDrEcfiFgGsNjU2k16e0jNy8go+p6X2N+jk4je1vaW9kamllN2LOwlVuS93lFFWMzSylZHutWLOlt5q6pZWt\/fDxjiMnDbYdvv\/wiX2HT+gYmPSzsBo90dX\/4tVrN25nZH4lJTc3t5y5EGhl57Bkufvbt+\/YHM6vZOGHPnk2bNgAACdPnkSXu3fvBoCRI0cSBGFnZwcAQUFBZODY2Fj4\/tl748YNAJg6dSrpi9oriIaGBjExsXHjxjk6OgJAYGAgb6KoWUmhUDpUqbGxEQCQsScIoqamBr0mYmNj0YuSN1ESCwsLAHjx4kV7r+fPnwOAl5cXuu9zc3OR+7t379AHeGNjI0EQJiYmCgoKNTU1XWZh8ODB6MWBCoogiIsXLwKAn59fl4miFxmKvn\/\/fuQ4d+5cAEhOTm6vfIdlxVdrfEUnJyeHLpuamuTk5AAAfZULqGsBCiOZqqqq6LK+vt7JyQkAjIyMUI0Lvk8EqM2rADKHqamp7Utg8ODBQ4YMoVAoCgoKKEUul6uoqIjUGDZsGK\/wc+fOocuFCxcCwLJly9BlZ\/JRrOPHj6PLgwcPAsD8+fO7k3HEkCFDZGRkduzYAQBubm5koamoqADA69evCYJYtWoV+R+Bwnt7ewOAlpYWn1ad+YaHh6Obh0KhxMTEIEc1NTVZWVk+CT\/3EKFSIrtqRo8eDQABAQHE98Zxh7GQVvb29ryVe\/LkSRqNNmTIEAB49eqVYJWePXvWvhxGjhwJPI3OX3weEai6z58\/jy7v3buHPg7Qh\/vvKnzEL74BOlMDVYSNjQ3SHwCsra15Ozx6Ir9hoDcrK3fdxi0nTp6aNX3mpQsXFsybIS4mCgCf0jIyv2SfvXDZ9\/hpTQ01ObleQjSqqmpvE1OzsoqSlpbm\/II8ZRX1ZmazklKf3Nw8YWE6gyHb1taWk5slIS3V2tr68NFDCXEpDpdtZGJ0+tSps\/4BK\/50J9MVEaEvXTDX\/+wZFSX5lWvW3b4byv37V7shUHOZbL6ghw1dtv8cRi7odicIAgASEhLS0tKQL+\/Mu7CwsJaWltGjR6MnMDQ0lDdRJKGzsXk+lRgMhomJCXJBXkwms30sJBNpyAf6znB2dh46dCivMv37958+fXptbe3169ejoqJSU1P37t2LOjwFZ0FISEhFRcXOzu7Jkyd3796F7x\/OvGXVWaJIz9GjR0tJSe3duzc\/P7\/D6ILLqrNyQO4sFgtdiouLi4qKSktLo74EAXUtQGE+mVJSUufOnaPRaGlpaWjoQfB90l69DhUQULPFxcUqKip6enoVFRWo8R0bG1teXj58+HAAqK2t7VBPZBi0tLR+qMTQt46+vn53Mg4AhYWFr1+\/Hj58OGoY3b9\/n8vlAoCEhMSuXbsA4PTp0w0NDUFBQTNnzkS9I4ibN28qKCisXLlSUlIyJycnOTmZV6vOfFGRTps2jSCIFStWoLTodHr7O+fnHqIuS6OzCgIAdNs8efIEOYaEhAwYMADVAqojASp12PLmu4t+8XnsMIMTJkxAVtPf358M8+uFj\/jFN0BnaqAsCAkJNTY2rl69Wk5O7vr16+2ftZ7FrxrvyOgYl2lT4uPjvQ8d3rxprbamGgDU1jVEv0p4\/\/79\/oPeixfMiYqOTP+c6TRsVEtLS8D5k9OnTaELizQ2NtoPGbpj27bYqGevoiICzh+Pev7shJ\/P3ZtBE8e7SIhLpKalZX7+ON9toZioiISIuKam6ob1az+lfmxsbNq2c+8h71NIAWPDvh5bNuzasePwoaPjJk771fLoHqjWORwOuvz06RMAGBsbk1689xOvgRw9erSCgkJ+fn6\/fv2mTZv28eNHXrGoW2ncuHFjxowBgIiIiKamJtJX8AR7PpVaW1u\/fPlCoVCMjIyQF3ps+ED3dHvJLBbr7t276urqJiYmSBn0eCN27dpFoVAuX74cEBDQr1+\/xYsXdycLQkJC1dXVqOG4du3apqYm1PdFpi4gUfLTZ82aNc3NzahblS86Lx06dlYOZNHl5OQkJCQsWbKksrLyzJkzvD2QHdZ1lwqz2WwyFV1dXTSCiypd8H3SoXrtFegsR1wut6SkRFJSEr0BUevn7t27dDodvcRramp4hVdUVKSlpV28eNHf39\/Ozm758uXdKbHKysqMjIzbt297enpaW1uvXLmyOxkHgBs3bhAEMW7cOEtLy169elVVVUVHRyOvhQsXqqur\/\/XXXwEBASwW69ChQ6ScxMTErKysMWPGiIiIoE8Q3ntSgC9SqX\/\/\/nZ2dsnJyadOnQIAERGR9jfJzz1EyKuwsDAlJcXHxyc4OHjlypXW1tYCChAA0GA2um1evHjBYrFQOTg5OaEuYlRHXarEZwX57qJfeR75ZPLW6ZQpU4CnQn9L4cMvvwG6VIPNZi9btqy0tDQ4OLhnd5gjyDb4T3Q133sQrm9iMWz0hK\/ZeciFxWYHh9wfYGlnYmphaGqpZ2j+Ke2znePYgCvX375LmTV3fn1DY\/flf\/789XPGF\/cN28wH2IwcO3m8y4xR412379rfS0l12qxFG7d6RUbFslgsFPhtUoqVncP0OQtKSkp+Ii8\/1F+xbds2AFi\/fn1SUtKJEyekpaXFxcXT09MJgkD3HO+EETQ5wtHREV0mJyebmpqiwqdSqUeOHEHuFRUVNBrN2NgYXaqqqsJ\/d0yhh0dISKhDlZAvjUbLzMx89uwZUmPBggUEQTx9+pSv0hMTE1GswYMHw3\/3TCLQB+\/KlSsJgsjKykKqklPSCIIYMWIEjUaTl5e\/du0a6Sg4C0OHDu3VqxdBEOPHjweA7du3h4WFAc+kLQGJoqUQU6ZMaWhoQD2rz549W7t2LQCgYu+wNPjKCtUaiYSEBG9gXg4fPswXq8O6FqAwkkkmgZg4cSIA+Pr6Et24T7qjAG+rFADGjRuHoiDDsGbNGlTCQ4YMIQhCQ0NjxIgRyIucNsVXJnQ6ff369ZWVlci3M\/l8sbS1tUtLS3kLU0DGCYIwNzenUqkoyuzZswFg+fLlZOB9+\/YBgLKy8pIlS3iFoPd1cHAwQRDnz58HAENDw+74vnjxAgBOnDiRkJCARnwqKystLCz4pnoRP\/sQ8ZXSpEmTWCwW8hIQC03OqKmpQUNXz58\/DwgIAICYmBjkheYGClApPj4e2s1wnDBhAgBER0cTv\/w88t2B5JuKIIj3798DAIPB+I2FT\/zyG0CAGrwVIS0tHRUV1T71HsfPT1i7dTvUc99eBwf7Xdu2KCkqAMCn9EwVZaUPHz5ISjOuBAbMXbhYUkJ+y\/Y9srIMI0MDC3OjK4GXyOg1tXXZOfmFxcWtra1139sBkhKS4lKSsrKyetqaKsqKenqaAOB9aE\/0y7jkj0mV1dVxbxKu3bgqIipqY2UZfDektqYq4V3iBvdVAGDRz+hKYMDRY36r3dedPXWCnBjyd8DlcgHA29sbDa4MGDDg1KlTaC6PhIQEAPBOe0afupKS35a2m5qaJiUlBQcH7969Oz09ffPmzcOGDbOwsLh9+zaHw6FQKGiECX19371719XVlTfRzlb0IV8Oh9O3b1+kxsaNG9F7EHmpqqqi0TgAUFD4NpeQIAjoqCv+2rVrAJCdnY2UERUVZTKZISEhZJts+vTpT58+bWlpIdUDAMFZ4HK56E10\/PjxFy9eeHt7oweMzJGARFEW2Gy2pKSkj4\/PjBkzNm7ciDpdOyyQDssKOQ4cOBA1BMlpesidSqXevXs3MzPTy8tr06ZNRkZG48aNA4F13R2FeRVAPaXok7\/L+4RP7Q4VQF4TJkxQVFQEAJQvAECditLS0iNGjBAXF3\/z5k1CQkJeXt6WLVukpKQAoL6+ns1mCwsLIwmzZ8+eNGlSSUlJUFCQt7d3RETEhw8faDRaZ\/KR+6xZs8aOHXv16tXHjx87OzvHxMRQqdQuM56WlpaUlCQjI3PkyBEAKCkpAYCQkJCTJ0+i+3D69Onbtm0rLS0lJ8yjFG\/evAkAT58+ffPmTWVlJQCkp6enp6cbGhp26YtUGjRo0LJly86ePbtv3z4JCYn2d87PPUTIa\/\/+\/fLy8kePHg0LC9u2bRuaaSUgFqojKSkpZ2fnDx8+vHjxIiMjQ0VFxcrKKjg4GABQLgSo1P4W4ruLfvF55CsW3jrlrdDfVfjwa2+A7qhhYmLSv3\/\/y5cvT5o06cOHD+TwUE+FNOM\/1E69FHBNVU1r4ZJVlVXVyKW8omrMBOex450DrwZb2TkcPHpqoLXjjZt3U1I\/ZefksdlsFCzra+6eA8dcps4abG2rb2yqpqGjoW1gbG5lOsDWxMJaq6+xqoaOjr7RgEFWE1ymbd7h9frNfxaMtbQw33\/4EPUqZqjjqNi4N3qG5npGZv7ng+4\/fv4yNgGFKS0rX7xstY3tUDLFbvJDnzybNm0CgNmzZz9+\/PjLly+8XuhjcOfOnaQL+qB2d3fnE9La2orWdRw9epRo9\/2OkJSUbGlpQeHJ\/q4OVULPMJVKvXfvXkxMDJpijXj48CEAODk5tY81YMAA4GkNIOrr6zucf07OciIIIioqCgDMzc15IwrOgrW1NdkgQ92hyDqieU+CE21tbQWelh9qf6Do5EQhXjosq40bN0JHK2H4AqNpOyYmJuiys7oWrDCSyTtjLicnh0ajiYuLo8l93b9PBNxsgwYNgnZLZQiCQG8xtOhr6tSpADBr1iwhIaGysjLyFVxUVESWCbk8rLGxEWUqLS1NgHwUa\/fu3QRBsNlsbW1tALhz5053Ms7XaidB87MQqCO0traWdGnfhEV4eXl16RsREQHfG461tbXKysri4uKOjo7kFEWSn3uIUCmhxlxWVhaVSqXT6Wg1l4BYBgYGYmJiBEGkpqYCwPDhwxUVFVevXk0WEep4EKBSXV0dANDpdCaTSTqihVKo6H7leWxf3Z6enqQL6hvYunXrbyz8X3wDCFYDVcTQoUO5XO6IESMAwNbW9kdf+\/82fnjMmyCIB48i9uzzGmw99PxZP1mGTFtb29fs3JS0dEob5XPm1+07tgrTJY\/7Hp40ccLECWOMDA36qKrUNzTce\/jM1mG0jZ2d\/5kT5ZVVVraOm7dsz83OzM769PFdzIeEl8lvX39J\/5ifnXny+BmXqbPaCKHrVwImT3YZaONw4mxgdU0NhUIxMzUd2N98vtuCG8EPuNzWo0ePxiYmzpox7dL5c0g9BfleRw\/v66XY29LatqGh4Udz103Qd5yuru6oUaP41sKi+UTXrl1DS0GYTOaFCxcAAH16Nzc3k8NXdDodPWnCwsJ5eXmxsbF0Or2hoQFVTFlZGYVCaWxsJG9K7veRM8FtzQkTJtjY2JArK0gvcr4JL0gU37KNkJAQJpOJZmYibt++DQDR0dHV1dUoDLIBZF4AoMsscDgcMvy6devMzMzQWCxST3CiKCIZ\/fTp0xISErzROywNvrLqrBzIwOjPzJkzpaSkUlNT0QSrzupasMIoFkEQ6A+TyVy9ejWHw1m9ejWa3Cf4PmmvXoc3W2c5Qn3jqGU2efJkALh3756Dg4OioiKNRkPTfCoqKtpLaGxsRIWM4gouMRSSRqOhOepnz54lvQRkHM1IevLkCVluaJ1SSEgIEo7mAMN\/311o7BZZC8SKFSvIWIJ9eW8eGRmZEydONDc3R0dHt79zfu4h4i0NXV1dJycnFouFVlcLiFVQUIAK2djYWF9f\/82bN+Xl5ahNjNx5K6hDlaSlpU1NTVksFip5ALh\/\/35eXp6VlZWMjMwvPo\/tM0h+9kVGRl6+fJnBYKxevfo3Fv4vvgEEq0HWEZVKvXTpkpSUVExMzIkTJ9rXS0+CzGo3W6gxcQkmFpZL\/viztbWVy+W2MJnXrgebDbQ16281ZcYCFTWtiS7TV6xcGxP\/DoX\/lJ55\/PiZgVb2Bv36z52\/6MyFwJzcgm6mVVFefTM47E\/39RYDbYxMB3ntPRQX\/60h\/iLy9eFjpx1GTNDUM9LUMzp1NoDL5RYUfhvtrq2tn7dw6ay58yurqrqZ1o988Xy7LTw8PNp7sVgs1LuopKQ0duxYZJ6HDRuG1smcOXNGWlraysrKyckJtVcYDEZRURHqZOP7QkeDYYsWLUKX5eXlqMp4P7RJSN\/W1lY+L\/QMMBiMcTygcW4072nEiBGTvnPo0CHUGcXbQq2urkZdmleuXEEuaOmFnp4eGabLLKBZsuR6obi4ONTAOnDgAEEQghNFnWD29vakLzmVKS4uTkBp8JYVqjUdHR3ecqirq2tfdDNmzIDvK6Y6q2vBCpMyp0yZMmPGjN69e6PbgNRH8H3Ci4CbDZk9S0tLMjsrVqwgCOLPP\/8EgEuXLhEEUVtbi+Y0nT59GsWSkZEBgKdPn5LCbW1tt23btnjxYqSnq6urYPl8Kn3+\/BkAqFRqUVGR4IwnJCQAgJiYGG+9oE4IHR0ddIkWR8H3vgFUVsjw8\/YBoAFaAMjOzhbgm5+ff+fOHQDYtWsXX92JiIjwlefPPUSolCIiIlBIZEr19fUFxEIfwerq6igK6lxRUlJCte\/j44MqRbBKBEHcunULACgUio2NjYODg7CwMI1GQys\/f\/F55AVVt56e3ty5cx0dHVHXwoMHD7qsmh8q\/F95A3SpBqoIch3msWPHAEBSUrKwsLB9qfYUfsx4Z2Rk9x9sO2nyjPyCQuTS2trqMm2unpHZIGuHB4+fqmvrxcS+bWpq5nK59fWNp\/0vDba11zMyPeLtG5fwtrauvpumlBcmszX546eLAZcHWTuYmA\/cvntvQXEpl8stLSuPjH61YMkq5T4a8Ynvd+zZ7zhi9L1HT1CsvPxCF9fZR3xPdTOVHyo11GvUvocTUVFRsXTpUhUVFRqNpqqq6u7uTn78nj17VkdHR0xMDHnNmjULzbZAc1N37NjBKwdN3yWXzJJ7LaEdqfggfXk7GxHtt3kCgPv37xMdbaHl6uqKWmbPnz\/nFYLM\/OzZs9HlX3\/9BQAaGhpkgC6zgNIiRwEIgpg5cyZ6sOvr6wUninI3ePBg0qu1tRUNuUVGRgooDd6yar\/DGgA0NDSQgck+STT2Ji8vz2azO6zrbiqMEBMTMzc39\/b2JucxIQTcJ7wIuNnaV9+AAQMIgkCTga9fv46CWVlZAQDZ5Y4GsNE2bWSZCAkJ9erVy97e\/tSpU2w2W7B8FIt3Ayw9PT0A8PHxEZxxDw8P+D6BjgQN8QIA2oSL7N0hd79CXa80Go3X5KOGKSoZAb7nz59H9\/\/mzZtJ3\/T0dGSo+D6VfuUhIpdWk3uBffjwobNYKSkpANC3b18U5fHjx8Cz2dnp06cBwMDAQLBKiDt37lhaWoqJiYmLi9vZ2aFvMuLXnke+JMibBO0\/6OrqSi6tFlw13S\/8X3wDdFMNcoc1Foulrq4OPHsM9ER+wHjXNzROmTpbRU3z3ftU5HL\/4WMVNa3RE1w1dY2nuM4pr6gsKCzhcDhcLpfFYrm4zpOWk58+Z2lJaTnnv3dQefsl8eTjE4lZ8d034RwOh8Vibd15QFZB2dLWISc3H7lfunxLz9BcRU1LW99EUkY2\/Ek0GSUyKkZP3zjra0535P+DdYDBYDAYzA8hhNb5wfeJx53B4XADLl\/766+QkydPD7WzBIDKqpr5i\/7Q0e2b\/fWLppZ2S0vLqBFO6mqqra2s2NjESVOmNzfX7\/Hcu8NjLe8hYM2s5n2PvObcXf4o+\/n5t5dZLY22mjY0WtcHllAoFCqV6uRgO8TOIeFt4tFjvnKy8jo6WpYDzKQZ8uISEl8ysywGDDY1MTxw5LidzWAJcXENjT5tILxy5fJx48bKyXUx+fz\/5tRwDAaDwWB+ne4a75zcgh07PSdPcVm2aC4ApH3OOns+SFJc7P2Ht4sWLWBIy8xwndbfwrStre12cNi23Tt1dHQPH9o\/cpg93zKkl5mRS57vA9a3DYNe5ydYKprq9zbovsZqfXoPsbNrI+Co95EWJrufsZH14AG6Orqx8QkS4pJXr1yhCVP79NHoraJMpwubmRp\/zsqNT0hwcrDvbE8fBDbeGAwGg+kpdNd4b9rq2dhQt3P7FllZBrOVtdtrL5PJEZMQp9EoSckfgy6c6aunTaPRHjx8tnHLpmnTXI8c9NLS4D+yk8VmBb4NoDa0zDd1tVezslez6kWRet+QMtnYRYj6AzvVychIW1tZSkjJnTl7urSsasyo4QwZ6bLy6tdxsfZDHcrKyu8E35RTULEwM6bRaAMHmJ88fU5fV1tLS1OATGy8MRgMBtNT6NYmLa9jEiesn6UAACAASURBVO+F3N63b7+2lgZBEE+fRca+STTtZ1ZfW62upjl+nKmoqAiHw7kb+mjlquWurtPXu6+WkZZqL6eR2fC+MHWM8fBNo7YgF79wn4uZd4pqijQVNH9IbxE6\/Y\/Fc2VlpTw8PKhCtANe27dsWL1lw+oBg4c2NNS4r9s4d+bk2tp6aWlJZSXFxQvm7z3k4+Bgjy00BoPBYP4H6Hqdd2Nj86EjR4z6mblOmwwANTV1IfcfDho44GX082ZmS3NL0+zpLm1tbZHRr7du2zJ9+sztHptlGdIdimrlMgvrSiRF\/2sPqYLmuqrGyp9RnUqd6jxhzSr3mzcuX75yHS0BHDbMwf\/sWYehtseOn\/LY6VlWXkmlUkeNHE4TgrCHET+RCgaDwWAw\/za6Nt7PX7xMTnq3bfMW1Jg+4nv6TUzMxPETHoT9JSMjt8htnpSUZElJ2b79h0xN+3vt2q6o0KszUU2cprSa\/JSCVNIlOT+hvrWxnlnzc9oLCwsvWTL\/jz9W+fj5xie8A4AdHpuzs3PmL3ALunylpKQ4IfEtAPRWUZ400Xmdu3tne4tiMBgMBtOD6MJ4NzY2hT9+qG9oNmL4UACoqa2\/dfOqqZnFunXrDhw56X\/ad6idNUHAUd\/TtbV1B\/ftlpbm35mZl08FacBt9c8IC4y+VNdcExB9MagwEpprvjbm\/HQGJCXEt21Zq6dvtHXnnsbGJhERen1D0\/jxk9lsdnFRaVJKeiuLBQArli0Qpot5+5396YQwGAwGg\/mX0IXxLiwqehX7xmPjWgDgcLiiIvTz5y\/cvHrh4gV\/JQVJLrcNAB4\/eX7nzs01f67UbDdDjY8P+R8AYJ7J2FOJF+UOWVxJvTVDZzgAfMxPZbFbfzoPwjTa7h0eddUVZ88H0enC7quX7dq2bv68RQRQIl9EHvE5jYLt2LkzPu5VS0dn62IwGAwG04PowniH3X8sK8Poq68LAOmfM9dv3PLmTUJa5ldHe1u\/Y95Kir2qqms9vbzMLfpPdpnY5dnmz7MjAeDyuzvvy1OhpSY6L\/5m2n0AyCj9ymrjP5bxhzA1Npw8ZZqPr\/fH1M8AEP8u+fnzxzVVFRoafa5fu1xZVQMAkyeNKS2vfv065lcSwmAwGAzmH6cL430nJMR54ljV3soAoKWp0c+sf\/Cdu8McnTx27eNwuQAQcPnql8yMg157O5xezktWcVZsyccOvZ7lxzI5zR16dRNhYeGVy5fQaEJoR99BFv2qKmuGOgxvaGrV0taPi38HAGKiIpaWlmjD5F9JC4PBYDCYfxZBxjs1LbO0uEBX14BCobS0MI\/5nj556lR1VZmltbWdlaUQlVpWXhHz6tWESdOMjfUEJ9PW1nY1IRCgE6tJtN1NuPuzWfhGLznGqlVr33348Co2nkqlzpw1i8thGej3tbIc+DE1paWFSaFQxo8dEfnyDe45x\/wEV69epXxHWFhYT09v79696KTCxYsXk14SEhJGRkbokE0ybkVFxZ9\/\/qmuri4iIqKjo7N161by+A1zc3MKhTJv3jwy8KdPnygUiqioKIvFQpLR8U1FRUUoCXRoKWLy5MkUCuXVq1cA0NbW5ufnZ2ZmJiUlJSoqqqqqirYNLywsRBHRCWYd5khSUtLU1HTnzp3ooEmErq4uhUIJDQ1FlxMnTqRQKH\/88QeZZaRYe06ePEmhUKZNm8brqKmpidJ69OgRnw7m5ubo8v379yjvubm5ZJiAgAAUER2hy6ceQk5OzsbGBp1FER4eTumIkSNHknHnz5+PHNGhIBhMj0OQ8b589ZaKkpK19SAAoFKpJib6\/S3MVHqrmxgbDxrYn0KhpKR8yszK3rB2ZZfJFFQX+GaGCQhw9O3F+pb6H9Wej5XL3ETFJeLj4jkc7sRxo75m54T89dfjiIiXr15n5+QBgKKSUlpaCt\/x9RhMd0AHp2pra2\/cuHHBggVlZWU7duxYvnw56eXg4ODh4TF16tTs7OwtW7b4+\/ujiDk5OQMHDjxx4gSXyzUzMysoKDhw4ICdnR0yk8OHDwcAdNwWIikpCQAcHR3pdDqSjH7J4yDJjwYAQMc5oABeXl7u7u7FxcVOTk7Dhw8XExOTlJQEniNf+c5+RZeampoLFy4cOnRoZmaml5eXjY1NbW0tbwC0NWFcXNz9+\/eVlJT2799PevEJ5JPMezxzSkpKXl4eOhMFHSPRPgkA2Lp1KwDs3LkTnTmBePDggZSUlJiY2Lt379DpUrxx58yZ4+HhYWVlFRcXN2XKlE+fPikrKy9atGjRokXIWisrK8+ePdvZ2Rmd1QEAXC43PDy8vTIYTA9CkPGOeRmlraevpCgPAEnJaTFv3otLygKFUpRfKC4mCgB\/hT00MDJQU1MVnAa3jXvr47XGmlIBYbIrskISf7XxLS4utmDO3LCHD2tqa\/vqaQdfD5joPLGqqqqqsqa6tgYADPR0TPsZ1db+6lcC5v9DkCnq37\/\/4cOH\/f3979+\/DwA3btwgCAJ5TZ48ef\/+\/UFBQZ6engAQFxcHAARBzJgxIz8\/f\/HixXl5eQkJCZ8+fVJTU0tOTl6\/fj0ATJgwAQAyMjJKSkpQQtHR0QCAmq1IMvpFtkpeXj43NxedaQjfjTf6RUdlR0VFhYWFPXjw4MuXL+h0cNKI8lpT8tLW1vbixYuPHj1KSUnp3bt3WloasqBkADqd3tbWho4ZvXjxopycHJ9i7UH60Gj\/2QMK9QFs3rwZAFDR8SWB3CMiIqytrVEwRGNjY3h4+NChQ62srNra2h4+fMgXd9OmTfv373\/06NHo0aO5XG5iYqKFhcWFCxcuXLiADhwzNDS8evVqSEgIqhdUwhUVFatXrxYTE\/v48WNeXl6ntY7B\/Fvp1HiXV1QXlxb0txiILu+G3rtxPehl1IuWpqaZs2dLSkpwONzY2Djn8WO7HO3Or8q7lRKuKKUUPDMAaO2edrrESvM5IC6z+\/3psnp+A8\/msB+nhM+6MHvVtZXv8t4SRBcLta1tLctLyysrq2g02pNnz+\/cvikrJ29mZsqQlgEAGo2mpdX3+OkLgoVgMO1Bu\/S3tHzblt\/W1pZCoaBT7ZEXi8VCXsi86evrA8Dz588TEhIUFBR8fX2RMdPT00Om9\/Lly42NjXZ2dgoKCgDw7NkzFP3Zs2d0Ot3FxYVMFP2iCaGjR4+WkpLau3dvfn4+fDd7qOWKOuqvXbvGZn+b\/om2FCTPF+A7aIBPbT09PdSqDgoKQo5kuqdOnXr79u26devGjRvHG5dPIAnKKa\/xvnnzpoKCwsqVKyUlJXNycpKTk3nlCAkJNTY2rl69Wk5O7vr167xTX8PCwlpaWkaPHo2a0WQffnv9eYsdgeS0VxJ95Tg7Ow8dOpRPJgbTU+jUeL99n8xkMkcOd0CX691XLFv6B02I0qdPn1HDhwJAbNzblqY6NXWNLtN4+vlJUmX2qVGe9S21wGk33tzWZt138GbTGfmVheFpj\/j2UUktTp79cOOtzAdnkq9ueOhRx+yi0ayipKypqXEn5CEAyMjK6ejoi9DpCYnxu7y+ndze10D\/5rXALnXGYPhAlgBt5AcA6CB2fX19Go2GvCorKzMyMm7fvu3p6WltbY3OTn7x4gUAjBw5UkJCghTl7OxMo9HYbHZycrKQkNDkyZMB4MmTJwCQmZmZk5Mzfvx4WVlZMlHeX4Ig1qxZ09zcjJqVIiIi8N1Io4HzAwcO6OjonDhxguxa78yGIXfS0gMAOgi8ubn5y5cvZICEhIQtW7aMGTPm0KFDfHE7W2DC55uYmJiVlTVmzBgRERE0THD37l0+HZYtW1ZaWhocHMzbYQ4A169fB4Bx48aNGTMGACIiIpqamnjjFhYWpqSk+Pj4BAcHr1y5kuwbh04OLGCxWHfv3lVXVzcxMUEySWUwmB5Ep8Y7MzOTAIqxUV8AqK1rWPbH8uzcPA1t3dyvX1CA67fvqqr27mdsKDiB8rry5VFHZug7jjAeeTE+sIMQnJbw9OcrHf4EYfHglLCa5v\/abS27Lru2phj9f5n\/oYXdJDg5ZSWFfv0Mn0W9AAA1VdWa6ipbWxtFeUUW+9vnua6mFo1GI1\/BGEw3QcavqakpPT09ODjY1dUVADw8PEivgwcPGhgYTJ8+XUREJCQkRFpaGgBKS0sBQFlZmVcUjUZDA65o+gXqIX\/69ClBEOHh4QAwd+5c3kSREUK\/TCZz8+bNKioqISEhz58\/R8YbsWXLlu3bt4uIiBQUFPz5558DBgwoLCzkE9I+R7zGW1JSEqmNHFEADw+P5uZmcsS9vWLt4XNHBhgNEKC2+507d3jlvHnz5vr16yIiInxfA5WVlU+ePDE2NtbS0jIzM1NVVW1paSF7zlFcZ2dnU1PTdevWjR071sfHR4AaiPDw8JqaGl5lYmJiUDVhMD2ITo13Q2O9ah8tYRoNAFgs9mBbx4L8wsT416oa35raHz6809LW69VL0DnZbW1tvhHewCUWms1P\/JIYW5LcYbBrX1\/RhYUP2fzx+MurxPwEXq\/eosogzkD\/TeQ0RKkdj7GR0Gg0DU3twuwcgiAM+uqKiwn\/sXiulqa6HIPB5XIBoL+FMV2E3tyCJ5xjfgx0\/7x+\/drIyMjV1bW+vj4wMBA1dpHXrFmzrl69Onr06OzsbGdnZ9SHhBrcyIjyiqqoqAAAFRUVAHBwcFBQUCgrK0tNTX3y5ImcnNzYsWN5E0Wi0H82my0pKYms1MaNG5FNRQGEhIS8vLyysrJWrFghJCT06dMnNBucV0j7HPEa76ampvr6egqFoq6uTgbYtGmTvLz83bt3161bxxe3s\/2GkTvq0udyuTdv3gSAp0+fbtiw4fXr1wCQnp6enp5OyjExMZk3b159ff2kSZNycv6z3+Lt27c5HA6FQtmwYcOGDRtQZsmGMoq7f\/9+f3\/\/vn37hoWFbdu2rX0G+ZS8du0aAGRnZ2\/YsOHs2bOioqJtbW0hISEdZgSD+dfSqfGuKi8lu8Tfvk9+9OB+bm72sOFjjx7aDwAsFruwIFutj7pg6XFZrw99DHQzdBqoYxn0\/nKn4Zqrbr+5NWvgTJs+FnufHWlm\/Wc2uIKUspmsCvpv0tuAyel6Iza1PuotrU2fM7MlJMR09A3\/+HNTfmFxyqePr2LeogCKiqqZmdldysFgeEE2wNTU9MGDBx8+fMjPz58\/fz7yQkaib9++s2fPvn\/\/vra29ps3b5A9GDhwIAA8efKEdwlWaGgom81WUlIyMjICACEhIWdnZxTs5cuXrq6uyOyRktub8OnTp48ZM+bDhw9oajpyRKipqZ06dQo1bdE4OvIlCIJvh4P2xhvpbG1tjTrtUYDRo0ffuXOHSqWeOHHi8ePH7RVrT1lZGQDIy8sDQGRkJGrX+vv7e3t7BwUFoTDIBiMJcnJyAQEBI0aMqKurmzt3LmluUZM9NTXV29vb29s7KysLAB49esRkMsm4NjY2S5YsefjwIZVK9fPzI+f98WacdGloaEDT5cLDw5FMJAr3nGN6HB0b75YWZkNjoyzjW5NXTU2lf38LW7shRUVFCe8+AkB61tdWJlNbV0eA6Lrm2kvvggBoHvab8ypzr+a\/EhD4bPI1aTHGdJNJcaWfbsRcRY5sDvvM6zPJJZno8mbas5PPjneZJWUVJRFh4S\/ZeQDQp3efz6kfCwvybQZbaWn1QQHEJSVz8gsFysBg+EGWQFZWdty4cebm5rwdvMgLjcXQaLSFCxcCwNmzZwFg6tSpSkpKNTU1S5YsQZ3kubm5GzduBIDNmzeT49Bo2Pv8+fONjY2zZs3ik8wrnxzxOX36tISEBOpmRwHq6\/8zI0RPTw++T2QjTSyfreUz3oWFhTt27AAA9Mubrr29PZptvnTpUrRCXYDx5nK5aG75oEGD4LsB3rp1K\/GdFStWwPcPBTIJKpV66dIlKSmpmJiYEydOAEBeXl5sbCydTm9oaEARy8rKKBRKY2Pj06dP+YpFV1fXycmJxWJdunSpw9JDhISEMJlMGxsbUpnbt28DQHR0dHV1dfu8YDD\/Wjo23jW1daXllRYW33ZO6GdkYGdrl5+fn5ryTkJCHADq6xsIglDprdxhdIQ4XXyk1vA7E0\/oKuu9zomCpgYBgdPKMxK\/Jo4zngDScudTvxnv8sZy38Qg4H4brgYO82Cif2ldF6NThno6omKiCYnvAKBPnz5sNrumpvJ9ckps\/AcUwMi438ULZwQLwWD4QPPMybnNvPA2BAFg6tSpAPDixYvi4mIJCYnr16+LiYkFBwerqqpaWFjo6+vn5ORMnz4dzThDODk5SUpKZmRkKCsr29ra8klGv0gB5vcthjQ1NXfu3IkaqchRX1\/fwMBg2LBh1tbWyHAuXryYNwrzv7cnQpepqalz5syZNGmSgYFBbm7utm3b0AIzMgCy7l5eXr179y4oKNi5cyefYiSHDh0aP368gYHB69evDQwMRowYwWazkZEmZQLAqFGjAOD9+\/cFBQW8SfTp0wet5tq+fXtRUdHt27cJgrCzs0Or1QFAUVERbeeCNmPpsNivXLnCl0HeroVbt27xKTN8+HAqlcrhcHi3jsFg\/v10bLzbAAiCIJsFbotX\/bF8cVlpyZw5C2dNmwAArSwW8d9LQdojTKNPt57pYjm5pLb4Tlr4f2xwxxChKSFqvdQixh1PrCn2fnr4U+HHq2+CgPjvT3uCezbqVJvABWMyMlI0Gu17zxtFTkFRQV6R3dr49evXb3mmUNvwhDXMD4Imb5NLxdp7kW1ifX19PT29trY21KpzcnKKj49HW6F9\/vzZyMjo7Nmz169f551ORafT7ezsAGDUqFG808KR5A6NNwC4u7ujudlMJrOxsVFXV7eysjI6OjolJcXY2NjPz+\/gwYOkEGhna5F7bW3ttWvXoqOjLS0tQ0JC9u7dyxcAfa9ISkru2rULAE6cOPH161dexUgqKyufP39eVVU1derUiIgIGo0WGRlZW1tLo9F4N0ezsbFBfyIiIniTAIBVq1apq6s3NjZu374dWX3eTxkyLuq95yv28ePHA0BGRgYaSuDTHwAaGhrQOAKvTFlZWUNDQ1ImBtNToJADQrzTOgpLypYuWz523KRVy+YDQMi9iLyczLv3HrJZrDMnT1iYGQddue2+dtX7t++0NLs4SQwAorOinC7PhdYuVnnJK2m9mRuipagV+Op8SOqDr\/Ul6XV57ZeW6Sv3feoWoirXR4Cofub9JzpP37d7s7ffOT8\/bxXl3soqyhMmTFrsNhMAVq3dlpn2\/klEOG+UzlasYjAYDAbzb0NQ05kk4mlE7pfsRQsWqSopMhgyAKCqrkqhUgtKSrtjvDMLMycpDQSAZg7zafl74DAnqTsBQFhFErRUy8uo2croAYAETbygOl9LUWuOzYIJFpMb2A3N7KZZgYtSKtNJUb2lVTNqit\/mxqnKTessOV4WzJvuONRy30Gfurq6mLgEZLwxGAwGg+nRCDLebd8Hk\/5YsnjdRo\/Nm9dLS0oePXZcS6OPCJ1OAWhtFdwT\/o0ljkuXOC4FgJLa4hHnXNKrPv+1KgQAXK5Ovffx6dYBC9eMXscbniZE6yXZqxf0amG3SFBFeL0OD9+26Pneh1+eDjceKyEiAR3BYrGhrY1GEwIAOVkGhaJVXVNbXlY2fvwEFIDD5QgL07ujOQaDwWAw\/0I6Nt5SEuJyDJnsnFx0+SbhPUFw3NesKyuvZHO+DYBRKJSampoOo\/8uKBSKjLgMr4u4iKT\/MI8Dr06UNZZqi3Q81z0jK7uJydTV0QaAuPi3cbGvZWWkW1qYTvZDUICC\/DzHEaP+Vs0xGAwGg\/n76Nh4y0hLyfeSKy0tQ5fjRjtlffn6\/NmTguKS6dOnAIChnjaVSi3IL\/pblaNQqPISDF4Xg959laWUqUCREZHpLFZhQRG7lWVipA8AR44c6aXUW0NLW1hUnMn8Nm2nqamRPIIQg8FgMJgeR6fd5pIS0jlvP6L\/KWlZAZfOqPRWk5aW7WfYFwBERUX6qOtkZqR3Fv1vQkpMSkZcdpbVXAFhSspLORyOhZkxQRD1DfUM+d7DHO2tLC3ke8kBAEEQOV8\/DzAz+b9SGYPBYDCY30ynU6wZ8r3Ky79tKj7EeqDX3gMTxo8z1tc27T+IxWIDgJGhSUFhblNzBytnfhdCQNFX0ANxaQU5TRAW669uLtL+ULL\/pq2tLS8nW1PHAAAKi0r6qOuUFBVcvRq4ZNlqFKCgsITL4YqJiggUg8FgMBjMv5dOjbeykkpzfV3W11wAkJKSWLl0wcG9u\/3PnaEK0RISPwDAyJHDiwqKPmdk\/X3KCQnRZg2cM1hRb7XBVDFpee\/hXrKicoKjVFXXfkr\/jPakFBUVKSkpYjKbxoyZ4Od7FAX4kJzKYrNERPCENQwGg8H0VDrtNjfv109ERCT6VZyejibpGPPmnbCwaExcvJ2t5ezpkzx37Uz\/\/HmAhenfpBwFKJKiknQhmqiwqDgIMcSlu1yNXVJSmvopbZ37GgAQFxPjsFsJEPbYusXL03PRgrkA8PVrtoZm385OQ8JgMJgeBDqbHPO\/x8yZXSxs7tR4m5j0ZTAY8fHxaG30m\/j3azZsaGlqMNDXr66uZjJbRUVFzPsPiHsTP8V5ophYF73Z\/2dkZGVKiEtqa2nU1tWv37C1pKREW0PdyXHYoIH9AYDD4eZkZ\/l5H\/6n1cRgMJjfgLu7+5AhQ8iTbDD\/Gzx+\/HjMmDEMBkNAGEHrvC2thmZ+Tq2qru0lx9DRVjcxMafRaPp6us8jn6dnZFmYmcycPnnP3oN19fX\/HuN91j9guNNQBkOmrq6BQ1DV1DWH2A0ZMnSokaEBABQWl3xKT9fT0\/yn1cRgMJjfAJvNPn\/+PDoFDvM\/Q3cqVFAvtIvzxOLi4o8f0wCALiLCZbNZTObF8+dLS0sL8vMAwNS0n6SE+PlLV39ILUlJpR8KDwCS9I73Y+HjYURUbvbXoUPtRUVEcnIKGAxGYV7BwSMHr12\/ik4vKCwqEpdgiIqK\/agCGAwGg8H8exBkvMeNdqQI0ZNTkwmCkJGWsh9qGRf7uqauUr+vQe\/eagRB9NXVnjh+3AV\/\/7o6\/n3LOR2dFSgjzthgteyg9bfDlFZbrNhksXSY8UgBOihIKwS4nF06fPmrObcMexsLCNnCbPX09NTV07YaPAgAjvmduHUzUE5Rwf\/sJT+fo2iGWsrHlAljnCQlu\/UpgMFgMBjMv5Mu5n+NHTfm9euY6ppaALC1sR0\/0Vmvr1Hv3kryCnKVFTUAMMl5ooSE6A7PfSyec\/eYzNbT5y7GJ7zjkyZOF3ezX7h8xAp06WTsdGDmERO1LpZcaylqUygUfVUDYZqwgGC37obm5GT+sWxFLzlGQXHp0UNeR454m5sYXb91q6GxGQAIgggJe6SiooJnq2EwGAymR9OF8Z7hOuVjSmplRQUA9NXVJto4dLpIYUHR\/AULN27bCQCG+rpL\/1j54MG9qFexKAqzlXXE5\/jpM\/47Pfe\/\/\/Dxt2v8OfPr3dBHfNuqf\/maezkoyN5h5Pgxwz+mfl6y9I\/1GzZZD7Y8dGCv9+G9sgxpAHgS+VqUTrGxsf7tKmEwGAwG87voTguzC+OtodZHW1Pr2Mlz6HLcuDEfk9+9fPlCW7vv+dO+yNF91RIllT7n\/M9XVFZzuW2Xgq7evHXn+ZNHBgb6GRnpzNZW8tTRX6StrY3N4WzftXfJ0oWusxfl5Rehznkulxt05UZBYVHQxVM0mtDLVzEcrtCXnHz39R7lFZXaWhoAQBDEkSO+crIyaJ81DAaDwWB6Ll0YbxVlJddpkyMePcrMygYAp6HWa\/5ce\/78hXOnfYSFaQlvPxQUFgHA6RM+GRmfLwQEcTjsivJKY2PDRw8fxsfHV9c2jxzjUl5RzWxt\/UVFa2vrTp295O13btnC+SpKfd69jVuwZFlkZAwA\/BUWHhx8e+P6DWKiomXllUUFBVmZKXJycu\/exlVXV6LoLyJjEuOjfXx8flENDAaDwfDi6en5T6vw\/yNdGG8AGDtmtGpv5V2e+9Dllo1\/ClFp8fHvd3kdWLN2Y+jDJ62tLGMD\/VV\/rPQ\/f\/5CwLVVK5aMHjE8JT1j04a1L1++zP6atXXb9v2HvBsaGn9F0bUbtxw+clBKXNykn1EfDTUXl6nHfbwtLS1C7j\/avHmzvaOD65SJVCo1+O69+W5zL\/qfO3Z4\/6mTflpaWgDQ2Nh0MfDSHs89soxOjzPBYDCY\/zF8fX1lZWWjoqLQ5e7du8n\/3YlLoVAoFIqFhYWnp2dtbW1nIXfv3v2riv4IsrKySDFNTc32vrm5uRQKJTAwsH14R0fH0NBQAAgMDHR2duaNwicqKirK3NzcwcHB0dGRzLifnx9vYf7jdG28lZUUXGfMefkq8t6jJwBAoVDKSopnzZ516\/bdVStXhT94UFFRTqcLL140d9TIMXu8dt+9e89t3qyjB7xaW5npGRnNTfUDB1ptWrdmyco1\/peu\/ah+eQVFm7fvXbHGY\/KUqYsWLb4QcElZSWGyy6RhTo4mRvpfs3P37vFS1dT08z7IYMgAwL0HD8PDwx0dhpqZGk+eNFGWwQCA6JjYV69erV75x4+XDwaDwfRUamtrzczMfq5lXFtbu2vXLoIgIiMjc3JyFixY8NvV+zlqa2sJgiAIIjc3t72vr6\/vpEmTkJHmCx8QEODu7h4aGurs7BwWFkZaZeTCK8TFxSUwMDAqKsre3t7d3R2JrampMTMz+xsz9oN0bbwBYM3KRbp6hsHBt2tq6ygUyqhRwy2trLyPHK6vrU5NTU1Lz8zIzKJQKGdPek+ZMt3bx\/d2cCgBhDRD1ufoITFxMW097YT3Se\/fJqKdUgCgra2tsqqGzTNBnRcul5tfUFRX39DU1DRqzMS42NhrV85TCMqKZUsYMpJeB3yXLXJznjAqLv7ths0ejF7yobeuUanUh4+erd+8Kzkp8dzFgJS0z6S0mtq6K1du5cGe9wAAIABJREFUHvc51uXWqhgMBvM\/hoODA0EQvC1RAEhKStLS0nJwcDA3N++yKclgMHx9fSMjI5GxXLt2raampqamJp85T0pK0tTU7NCg\/gouLi5JSUndDx8WFobsbntNNDU1d+\/e7evry2AweA18UFCQm5sbGSwqKsrMzAwdG+3g4JCcnAwA7u7u\/8cdDF3SXXu2e9e2d++T7j+KAABlJYUtmzZm5xYcP32KS3DdN2zZ4LE78W0yl9vmfdhr0qSJnvv2HTriZ205cJjjkGEjRrex20JCw5wnTbazHoCkNTe37Dvok52bX1xSHnj1Zll5RcqnjNiEdy9j4p5Fva6rb\/DYueeo70khIZqxsTGbzVJX17l3L4xOFz588MDokQ6tLNbVa7cXLF7aS1bu9HGfXnKML19yDh\/1zv6apa9v3NRQ73\/hMqn5xYBrTQ21aHtUDAaD+f+N3bt38zW+XVxcQkJCoqKiAgMDXVxcupTAYDDMzc1zc3MDAwNzcnJyc3Nzc3Nramp8fb9NW05KSnJ2dg4NDe2wK\/tXsLe3b79LqKenp6enJ98XCXy3uwwGAynTXpq5uXl0dDQAuLm5oQC5ubkEQSBT3R4HB4cf+nT4v0TQ9qi82A4eONVl0t69XmNHjZDvJTtogLmcnJz\/+bNz57gZ6ut7bNu0waPq2MEDlpYWO7dtUlJR3rfXMy390\/69e\/y8D5WUljc3c9avWQQAzS3Mpqbmmpra9x8SqZQFW7btSXwbq6mu\/vhpVGJiAoVCOXLAk8lkZn39+jLqhdVg6+nTXHyOnw3969a6TduLiksHDTCvq2\/YvefQ5SsBo0ZPOLJ\/l5yc7Kf0rHfvPhqbmEZFPzt21EdcnK6qoozUfhmXeM7\/9PUrV\/r0Uf27ihCDwWD+xTg4OJiZmfE2HHNzc5G5Mjc3l5GRSUpK6sx6kdTV1QEAb0hew+bs7Lx79+4uhfwEqNeaD3t7ewBgMBi5ubmoA8DMzMzX1zcwMFBLSys6OtrCwiIwMLB93NraWhkZGaSwm5tbbm5uaGgoanY7OjoiObxd6AJG+v9xumu86XS6m9v8qJevXFxnPQy9LS0lpaOlnvIuLjkl\/fbdeypKSlaWg0+fD9DW1pCSklz\/5\/IBZhZ\/rv1z\/KTJZ0+cMDUzunj2GJLzOePLoiVLRo+ZYGZi2NLMDA25oW9oVllVweFwEuNfuUyeqqGh3tzUxGxqFhMXX716xY3rN40M9NTVVMPuXG1ubvmQlOK+YUtB\/tc1azZsWrcCAF6+il+zfmNebqaMtByb1XL48KGAi\/4a6qoAUFZWsW3LZluboYMGWvxNxYfBYDD\/fnx9fS0sLObPn9\/eKy8vr8vmcm5ubk5OjoODA28fe21tLRkxMDBwwYIFzs7Ogs\/S+F04ODiQ\/yMjI8n\/YWFhZmZmHz58AICcnJz2HyVRUVGkbUat86CgoJCQEF45SUlJeXl55H\/0ofAv5AeGgbU11T08tuRlZ+\/w3F9bW4ccc\/LzH9wPE5WQ\/ZSeVlxSOG\/xilNnL9Y3NDrYW926fs3R0WHhsqWLl6669yC8uroWAHqrKDk4OBTk59kPdTztf05Hz0BCQjQr64uRkaGKskpDY9PJM\/5MFltdXcNz156lS5eIitAu+p8UFhZ+HvnSY8du58nTFBXkAi5eWr\/mDxaL9SE59cr1G62tzZMnz9DW0V2zbovbgvlSUpIAUN\/Q4HXgkI6OduDF039HwWEwGExPQVNTc82aNUFBQejS3t4edaT7+fmhfumoqKj2Y7p5eXnR0dFhYWEuLi6oh9zBwSEoKAh1mwcFBZFG1MHBYc2aNd3pgf9R1q5d281x9NDQUHt7+6jvuLm5kf3q0dHR0dHRqKedzKabm5ufnx9BEHzfLubm5gRB+Pn51dbW+vn5oXZ5bm5udHR0XV1dcnLyv6Qjvbstb8SYEU6+fj6bNm421DdYumgulUq1t7WaOHFiVPRLaCPqa+t3bd\/kd+r86FHDjQz0DA309nnunDdn1oGDx9av26irpz1k6LB5c6bv3rGVyWyVlpLU1lJbtXJ5YUFRbm6hrraWy1TXuTNdX76OV1ZU8D60V1Ojj4iISENjU8DlW4\/C76WkfFJT0\/Q\/e9LMzExZSaGuvtFjx+537961trKb6uqH2NowZKUN9HQnjBuGVD13\/nJtbY33oQN\/Q6FhMBhMD8Dc3Jzs+HV3d0dzygAgNDTU3d0dTVhDQ7\/t+4fRXLaAgABNTU0fHx9kpx0cHHx8fNzc3BgMBuk4adIkJD83NzcqKoq3Wfzr1NTU8Lmg5NqTm5vLO+\/M3d0dfXCsWbNm165d5ubmmpqaSUlJZN8AGk3gjUISGhrq6+sbEhLi5uaGAqD5ATIyMiEhITk5OeRg\/z8J8R0uD\/lFJTPmLnHfuLOlpYXN5vB6sVis3XsOySur3r77gPRKS\/9sZG75PPLVn+u2OQwbk\/klm81mF5eUcTjfArx6nTDWeQajl4K8cp9ho519T10sKSlrbm5hMplMZivrO62trUwms7mlpaKyKjjk0TiXWUqqGjJy8gOsHC7fuINEcTic5uaWgsISVQ2duQtX6Rn2k5SRXb1uE6khm80+dOyUpq5+5Ks4bjtaW1tramq8DvjwuRMYDAbT05CVla2urv6ntcD8ZmRlZWtqagSHoRDf9y5ta2vjNeqBQTc2bd6goKiyYuVytzkzJSTEyWApKZ9vBN8OCLi0f\/\/BmdNcxMXFWpjM3Lyi90kpO3ZuNzDoJyUladnfNPzpk3OnT+poaZAyP33KfBTxNDn5bW5+QWVlNY1GV1FWoYvS1VT7iEuIcTltRSXFdTV1xcXFBHDFxUR1NDUMjU3Hjh41aKAZuddrcUnppq07y8qqsrMzNdTVtm3Z9vhJhKmp8dxZ0wGgqbn5\/MUrPr7HFi5cuGvbZr4vlZTUtENHj0VGRmampZA5QuCFZBgMpschJyf39etXfJ73\/xhycnLZ2dmCJxB02m3u7DzuyvUbhQX516\/dTElNPbzfS1pKEgAOHT2RkBC\/aeM6MbrYwYP7CQ53\/rwZYqKihvo6Tc2NmzdtvHzlZq9esnv2eh7z8dNU78Mr09i4r7Fx39ZWVkFRcWFhUX19fWNDXUND4+fM7NbWVgAYPMBctbeyqKiYlLSMsrKyro6WmKgIn2K9VZR9jxz8lP7Zdbornd63trb6yME9pO\/5i1fOnT+3Zs2akU7D1qzfuGblcm1tbeR1\/9Gz8xcvfMnK3OflxWe5MRgMBoPpSZBt8PY9zA\/DI\/sa9du9z1tTu+8ct2VcLnfnnkMMOQVFFQ2boSOzsnI99x5WVFbdsn0vGaWFyTx+6ryqps5g+xHM1tb2MtvDZnNaWpjNLS3NLS0sFqs7Ubhc7ufMbF19w7r6+ubmZtJx1vw\/lFTV9x8+ll9QbNJ\/cC+l3qoaWkjm54wvfTR1TvtfNh9oVV5e3l7g39sJgsFgMH8DuNv8f5LudJv\/p+XNZLZu2bHv1etooo2gUtrExKXl5OSZ\/6+9845rInkb+IROAAmIIEUSpNkQUPH0OCVYOCsExUJRguUnp6eA\/axYsGAhKAJnI9h41UMQ7A3w7I14FkARAQ9FQQlIh7DvH885t5cAxjss6Hw\/\/LGZnZmdmV322XnmmeeprOphb8P8OWDzxnWjx\/mmi25NnTp9zFjenDkLBg0dGrNjh5KSUlT0tvz8vJAVS0xMjFSUlWf4TzK36OjQw05ZSS5rOAUFxuMnT5\/9WThkcH\/5vzlUlJR\/\/XWXpoYGfH88zs5ZEbL28qVLs4PmdbKyHMEbpclUjz8UfzQ52apLtwN796xYsSooaL6tTaf62oar1289evLswoUzbHZHaytLH8\/ROjqfYnsDgUAgEAgtwt9r3nV1dedTfl+3YUNx8evgFStZmsxHj7KuXru1dPECI6P2XW171FRXzZoxa+GCIIRQZlb2vF8WP8vPmzVrlrqK6pbISHU11cmTJ3uPG\/0vGhEesf18ysWk+H3\/omxlVfVvR5J37d6pqKQ08+efKyoqwsPDO1laBwYF9LS3qaqqDt20JfrXKH19w7u3r+Tm\/7k18lcr847m5uZvK6pD1qwexRs5aZJf+3Z6ZM2bQCC0Or6ENW\/Y\/N2yRubfOPKsef9DbV5XV\/\/gYZZ5Jxu\/qf4VFZUSieRVUXFdXd3yVaEGhh2Wr1xXXlGB9cwvCl\/Om7\/UhGMeMGfxw4ysiX7+phyLiX7+j7Kfyqn6lkgkew7Ef\/+Dk6mZOUvP4Lu+jkFzF715I5a\/eEZWtteEKQbGpvyp09Pv3p8+az7b3Grm7AUvCv9WjJeXV6xcE2rYwWxrVExtbZ1YXFpfX18iLp0+a\/bO3bFV1dVEbU4gEFopzajN6d5LgJSUlI\/RhuXLl0MIk08A+IoBH6gxMTEt0pLly5fb2tqy2WwulwvK6vT0dA6H4+TkxGaz09PTKYpKSEhgs9m2trYcDufp06cURZWUlHC5XMgj25L\/iDxq80bWvO\/dy7LsYvvbkaT6+vrq6pqwLdGGHTizZi+SlZ1VVdUbNkcYmZoN\/NFVdPf++k3brLrYdLTsGrv\/IEh9eQSwIGKHvlEHppb2CPfxhS+L5ClSW1v76lXR1shdZlZdu3bvtSMm7u69h8NGehh34Cxfsf5teYVU\/vKKyllzFmrr6EX+GlNVVS2RSNIuXXEd7f3ixUucp2WHnkAgED4B8qx50ydpH4NPLLxBdiYkJLBYrBZpCf6msbW1BTHs5uaWkJAApzgcDkVR6enpIE19fX0DAgIoioLt4xRFlZSUsFis98raD0Ie4d2IrrhLF4uhQ4cejo+vrKyK2XtgW1TklMn\/C9uwSjaniory7ICfwgVblZUVJk6aoqKENm8Kd3V1XR8a6j7Ge\/vOmAeZj6h3avmmsLJgW1l37vP9D2pqyiztNs1nRgjduJUeGb2TN8YzMnqbl+f4jZs2lpW8nug3WdJQtytGuGzJXKa6mlQRdTXVkOAlU\/1\/EmwR7Nn7f2Vvy7dF7vQYNUJfX++9lyMQCISvg+DgYC6Xy+Vy7e3twSsLl8sNCgqys7PT0dEBx2HgUpTL5TIYDPBPIhQK7ezs7OzsWCwWRASHDODz5GO3WSqqGAQ0QwiB5G6qVGJiIjTSzMwM9zQ8PBxctUjFLMEKfxaLBZmPHj0KXlS5XC74d4PuQx44EIlEUJDFYtna2n56t2uN25T5TvCa\/nPARkFkQ0NDWZm4e7duzVQxym1o7152ew\/835Zt24wMDb08fdzdXZNPnAqPiNwVE2PT3Xa0++iBXEc1mU1fAEtbN2xTaFtd3fv3H5SWvdVr2\/jiTWVV9akzKSeOHbtx+yZCil7jxjoPcLpxM33durW5OXn+P\/mPHzuqg4lRU41kMtVHDBsZKxTey3j4ZF3eyxf5w4cOaaZTBAKB8JXB5\/PBOSifz8devtlstkgkAr+h4HlNIBBwuVwI3YEQ8vPzAzEJITXFYjEIKnBDJhvaq2VpNKoY+qeXcllw0JTAwEAcoYSiKJFIBM2WLZubmwtnZWvDPtLFYvHRo0djYmIQQmlpaR8jEIv8NC687Wy6eo33DF6xzGfilOFDR0ybPo2l+5tz\/++wpxQpTIwNf5kXNHWSn6fPpIUL51hZ20RuDZ8fNGuXMG73zh3xhw8aGJlwnQZ5jxvj+H1PBg2E0He9\/4oawu7wd+AvunLg4pWbe\/YdTEs9W\/L6laEJe8ZPP\/t4jk67dH3K\/2a8KMh17D\/wyuU97Q2am0NTFJV4\/Mz\/pk7uZtO9trYhbn9UYcEzYqFGIBC+KVgs1ooVK0QiEfhJBQEGEojD4cCkk8Vigay6e\/cuSE2Q7nhWymKxwsPDwRMqROj6qDQaVSwxMTExMbH5SOTh4eEikSg1NRWHY4GeNvopIBaLwX97o2ex8\/OgoCA3NzeYcGtra4vF4k8TiKVRmtzN9fNPk9U1mLG7d72tqFZAaNJk37Wr17q6DtFgNuneRK8t69Sxw+fO\/75nb6zHuDFmHS29xnkIhTvu3H2Y\/Sgz4+H9n2ZMpxCjvaGRg0OPzpbm+vp6TKaGbD3l5W8Lnhf+cT\/z0ePsgj+fKShQ7A4mYz3G9OzZy7i9\/h\/3\/+CNHv\/ieUGf7xy8Q9c5cx2VlZvbk1ZXX3\/gwG+r1qyqrqqkGhgKSJLzOItIbgKB8K3h7OwMK7WyMUjoQHDusLAwLO0gPwjL4ODg3NxcgUDg5ubWfD0fCZFIFBgYmJqa2ozg5PP5dnZ2MTExcrbQ3d09ICCA7uccBDOEEIULgQYCezWHAOcg1\/Py8j69FG9Ohk2e6Llzx\/bp\/lMGDxlmYsJZuWb1ug3v8cauqKj4ows3OnLrr1GRTv0dd+wS8v2m\/J56Tq9dW1+\/qTt3RK8JCR7v4VZaWhp36MiyFWtnz18i+xe8av3R5JO1dTV8H4\/1a1dtDQ\/3GOvdRlvr4KEDflOmxuzdP3gANyoyIjoqwmWwU\/OSu7y8ctXaDfsPxvlP+9+2rVuW\/DI7bNNaTU3NfzNUH0JISAioFnbs2NF8zokTJ2I9xC+\/\/CJ1dvDgwXRFhbKyMofDGT169Pnz56Vy1tbW\/vrrrwMGDNDT01NVVTUxMRk\/fvzFixelsqmoqNArVFVVNTU1HTt27PXr1xttHpvNxplPnz4tddbFxQVOzZs3j56ekZHRfPeVlZUZDIauri49kaIoBQUFBoPRvn37Dx0ohNDjx4\/9\/f07derEZDKVlJS0tbWtrKwiIiLgLL4jW7dulUp57z2iZ962bRtOnD59OiSGhobSMxcXFy9btqxHjx5t2rRhMpnW1tY\/\/\/xzTk6OVJ34Xhw\/fpyeHhUVBemPHz+GFIlEsmvXrgEDBrRr105ZWZnJZBoYGDg6OpaVlUEGGE\/ZB\/vYsWNQ1apVf9ms4CcKVw5s2LCB0Sw3btyg52\/+wXhvg3Ez7t27Jzvaly5dgrOjRo2ip6empkL6+PHjIQXfl40bN0pV0qtXLwaDoaioCD8vX74MOceMGYPzHDp0CBKHDRv2oSOJaM8\/g8HYvXs3PX9OTg4+1abN+015Pg0lJSUgco4ePdpUHrFYrKOj4+zsnJeXJ36Hvb29vb393bt3ES0WOI5R9lHx8\/OjRxUTiUTOzs5BQUEQ8QzHU4FOQQtxI5vvKf0SLBYLAoGDst3X1zcoKCg1NTUoKAgkenBwsEgk8vPzgwBl6N0iukgkCg8PZ7PZn16F\/h4\/KlaWHS3MOd5e42qqa\/fEHdywIfT27fS4fbu122g1U0pLS\/PHwQMGcPsHzvzp7t2MyO27IqOiGupq27Rp07mbfffu3QcMGDRsnZNEIpFyqA4oKCjW1NReu3332tUbd0VHnzx+WFpaqqSq6sQdvC9WaG1tzmQym5fZQF5+wdwFi+\/cvpaWcsGwvQH+N\/4EMN\/pJ5hNKyoQQrW1tcnJyeidoURycvLatf8Ig6ah8ZdmQlNTU0dHp7i4OC8vLy8v78iRIyEhIYsWLYKz2dnZPB7vwYMHuGBBQcHBgwcPHjz4008\/bd26FfedyWSWlpZChVpaWkVFRc+ePXv27FlCQsKFCxf69etHv\/qNGzfy8\/O1tbWhSHJy8o8\/\/kjPgN9xERER\/v7+5ubm8FNFRUWq\/VKoq6u\/fftWXV2dnshgMFRVVaurq2Vfne8dqMuXL7u4uFRWVuKUsrKysrKy+vp6qZbgAznvkVQpNbW\/zCFPnz4dHR2NEPL09KR\/u5w8edLLy4seo+nRo0ePHj3auXNnVFSUn58fTtfU1ISISfPnz3dxcVFWVoZ0qdGjKMrDw4O+FFdfX19VVVVTU4OlgpKSUn19Pa4Bg1tLfwAa7TV96BqFfrOafzDkabDs7aCD2yb1hOCf+AlReucJqqm+447L3sHnz5\/PmDEDIdS5c+cDBw7gCuUcSYRQcXExPr5z586kSZPwz6tXr+Lj6upq2T5+SrDeODExMTg4mMViBQQEwEyRx+PB3JHD4YA2uLS0FAcJ5fP5oEmGmNYCgaCkpEQgEAQGBkK4LRB12JjrYyClmReLxQEBASUlJbARjs1m40vHxMSwWCxQs8MSPovF8vX1hQ6ChR30VGrBm81ms9lsqJDD4djZ2QkEguDgYLDvg7k7h8Nxc3PDu++cnJyCg4NhKHBktk8NXlqWZ4+WcO\/BzjZ2Dn36Hzt1trKqqpmcN2\/fdRvtfTT5xJ8FzyUSSdnb8oRjpwPmLR46ktfToY91527G7I6duvXs3tPRvnf\/QUNHDed5ugwfbefQr3tPR8su9iYc805dbBy++34Ez2POguVJJ87jmlNSL55P+b2mpjlHquXlFecupA5wGTlqnI+cO9Za0Mqfoig8Pzt8+HAz2Q4fPowQsra2DggIgPwPHjygZ4AZhoaGBr5H8fHx8B5RV1evqqqiKOrFixcdOnSA4pMnTz537tylS5dWrlyppfXXB9bMmTNxhTCpHTlyJPysqKiYP38+ZJswYYJU8+DVNm3aNFtbW4RQ+\/btpQbKy8sLP0jOzs4NDQ2Q\/uzZM0iMj49vtOMGBgYIoY4dO0qlg6+Jrl27fuhA9e\/fHyGkpqYWExOTk5NTUFBw7969ffv2ZWRkQAYQtAih\/fv3Q4qc90iq+L59+yiKys\/P19PTQwgNHjy4pqYGZ0tJSYH3vqam5sqVK69cuXLmzJkpU6YwGAyEEIPBoF\/LyOhv+8rg4GCcvnfvXkh8\/fo1RVEXLlyAn8OGDbtx48bz58+zs7PT0tL27NmDi4Aw09fXl2r2pUuXoOz69eshBc87i4qK6DklEkndO1au\/CtYwIULF968efPs2bOsrCx6N5t\/MORpMJ46FxQUyI52RkYGnJ00aRI9Hc+rZsyYASl4wh0ZGSlVyaBBg+DfBH5mZmZCzilTplAUVVtb+8MPPyCEOnTokJ+f\/y9Gknr3GMOUq1OnTvT8MM4wPgihyspK2W62CC3uHpXFYsFerLCwMBBXePczn88PCwtrwWsRmuLD3KPKwwQvD5tuXbZGRM6dt2C0G8\/Ta1xna4tGc65aE5qfl705fKu6uvrxxMMaTHXXoYNchw5CCBU8f5lf8LywsLCsRFxTXyupqyt\/W0ZRDQoKChqabRSVlZUVFXXb6hu1NzA1NTHQbytVs6u7u4WFZXRkZK8eto1eOiPz8d59+0+cOjU7MMCd5\/pZlrfxhECpWR+xoGobO3bs4MGDw8PDEUJxcXF0vRwUh\/98BoOhoKAwatQoDw+Pffv2VVVVFRcXm5iYBAUFgbDcvHlzUFAQFHR0dHRzc3N0dCwvL4+IiPD19e3Zsyeu8O3bt5CNyWSGhIQIBAIIyUpvW3V1NUxHxo4da2xsfPfu3cLCwpSUlIEDB+I8MEd0dXVNSkpKSUmJiIiYOXMmos0dZWcw9HTZs9A8XFz+gXr69ClCiM1m41UrIyOjbrRdErJTNDnvkWzmyspKd3f34uLifv36JSQk4NbW1tby+fy6ujoVFZWzZ8\/26dMH0gcPHty3b9\/JkydTFDVz5sxhw4bBzJI+eiEhISNHjuzRoweSGT3oGkLIx8fHwcEBjrGSo\/lxU1VVbaqzUr1WUFDA\/yl4iNTU1HR0dKS8d733wZC\/waiJJwQnSp3FpXBPZVOk+t5Ux2fNmnXp0iVDQ8Nz587hb1\/0ISNZU1Pz6tUrRUXFIUOGiESizMzMnJwcCINUUVFx4sQJLS2tAQMGwAdHSUmJlBbhiyUmJiYwMFAsFtvZ2QmFQrBfg6kqj8dr1HyM8HnAYlye6Snw+s2bqO1CtnkXu159dgkPVFdLByB5ml+g3VbfZQjPm+\/f1sAIEleHhjn+4LRw8Yri12\/kvFBVdfW8Rcsdf+gfvm0XTmxnaNLFrpcjd3BRcSP1RO\/a06P391P8AzMyMnE0cXlo2e+mXbt2wfAmJSU1lScvLw9el5mZmQ0NDSYmJgghMzMzeh4siujzHvhHUlNTq6mpKSwshFld9+7dZS+xevVqKB4YGAgpoDjq27cvzvPy5UvIs337dnpZmP8ZGRlJJJKsrCzIw+fz6XmmTJmCEJo7dy5MfNXV1bOysiiKwkrjEydONNp3U1NThFCXLl2k0g0NDRFCDg4OHzpQeM2Sz+dnZ2fLXhFvaDly5AikyHOPZIvv3r17yJAhCKFhw4aVl5fT8xw6dAjy0FUdGJgIIoQSExMhxcLCAiEUGxsLer+uXbtWV1dTFIVVcPDRhhebjY2N4+LiamtrZStv27at7JhQFHXnzh0oKxAIIGXChAmQUlZW1lRn169fD3muXr0qe\/a9D4Y8DcYPdqOzRmwfMH36dHo6vty8efMgBVswxMbGSlXi6uqK3u0GpigKr5v6+\/svXboUIWRubv7o0SOpUvKP5KNHjxBC2trasKCDENqwYQOc2rNnD0LI1dUV6zDu3bsn280WgQQm+Sr5l05a3gtLW\/t\/kydcv5RmZmbxy8J5Q13HPMzIqqyswjvmD8QdpqiGWknt9atpQUHzEUKFL4uOJyVYd7U\/cepMfv4zhNChQ4cNO7C1WLq2vRyPJp9ACN27\/7BTt15sMwurLt2Tj51BCNVUVx8\/fkxTx2DJor\/XFOvr6+trJdlZmRMm\/a+6ugYSKyurbt0W9Rs4dEt42ML586IjNlpZWTKa2Nj2CcCXbqYNu3btamhocHBwsLa2xjY4T58+vXz5smw9EokEIVRaWhoaGpqUlIQQ8vb2VlFRuXjxIkVRCKHhw4fLXsLNzQ0OsL4RKoSVYLFYnJqaCnnGjBlDX45FCIEZl7e3t4KCgpWVVa9evRBC8fHxVVVVUs178+aNQCBQUlKqqqri8\/kNDQ14mtJU92Hh8OHDh1JWUS9evEAysdXlGai1a9fCzEYoFFpaWg4ePPjYsWMUzYeD7B2R5x7JFp80adKpU6cQQnw+X2q9Fm9cGTFihGwNTd0LBoMBr\/gHDx4sW7YM0SZ5kMHBwcHb2xshVFBQ4OnpaWJismTJEhgoTFPzRbzaFSjwAAASmklEQVRAi+eL8vS6+QF574MhT4ObbwZudmRkJP3xsLa2hnT8hDQz84ZKZDseHR0NOpuhQ4fC9xMd+UcSFAxaWlrOzs7w7B05cgROgfAeOXIkXroqKiqS7SaB8F\/49yrldvq6+2K3b9sW2UZLnecxLnDOwqPHT74pESOElBXQSNfR508lZz28\/8u8mQghXV1WUNB8E0M9\/XbttLQ0EULOAwbOX7AUIeTn69ulcyeoU0lZOWD2Ah1d\/Tt3biKEVFRUf57+s6mJsV1PB3xdlk7b7x37rl6zzqS9\/uOcp0XFb5KPn541e96qNWt62Ha5mHJ+tLvrZxTbwHtfkRKJZOfOnQihiRMnQgq879A\/bTjxS8re3t7Y2FhPT2\/BggUNDQ1DhgwJCwtDCBUWFkIGfX192avAmhyimSNBhTdv3mQwGGBTeu3atejo6EOHDtH1qBkZGWCpjidq0Ly3b98mJCRIdbOystLe3n727NkIoatXr27ZsgWLn\/+OnAPVvXv3mzdvglkNRVHnzp0bOXLkwIEDscyQvREfJLzxjTA1NYX8np6eUlbiH3ov8OjNmDGjb9++CKFNmzbdvn0b20ZhYmNj165dCxP0V69ehYSEWFpawrAAIGyaWSHC+uf\/KLzlfDDe2+CW+g\/FUrapvuOO4wz6+vogayMiImS3Lcg\/kiC8tbW1NTQ04HPt2rVrL168eP78+YULF5SVld3d3bHwxvotAqGl+E\/rwWqqqqN4I7ZFhIdtCi0qfj1n9jwfX79NW6Jc3UauWb2cnjMp6eTKVcG30\/\/YuH5VBxMThFA7PV01VRWE0Az\/SZYWHSFbZeXb\/ftiXhcXWnbqhBBSUVHWb6d75epl607dUtL+mmaNch8zNyhg0sTxs2fPPnXqnO+kyQFBQQOcncI3bRBs2qjD+uhOA+QBz\/maegskJSU9f\/4cIfTLL7+Avz3sou\/QoUPYPBVb4z969KikpITD4fj4+Jw8efLkyZPwXsALaVhy0Hn16hUcgDoavZvBq6mpde3aFUyuEEKzZ8\/GRkYAts\/q168fNA80jejdrIJeW11dHUJo5cqVNjY2CKGlS5e+ePEClnUhgyxQxNzc\/Nk\/gSbRS8k5UAihrl27pqamXr9+3dfXF17BKSkpw4cPh9pwnfjgvfeIDi61adMm+GiQSCQ+Pj54fRf923tRV1enoKAQGxuroaEhkUimTZuG68EXVVRUXLhwYX5+fkRERKdOnRBCFRUVU6dOxVM9MLOqqKiQumh5eTkcYDNveXqNryu7GUTOB+O9DZa9HXTg8UAI+fj40B8PbOuLS2Gz86b6jjuOi4wZM+b69euwkL9+\/Xr6Nwf6kJEE3T7YQoPlJkVRx48fj4+Pb2hoGDp0aNu2bXFmfPdbBY16+hSLxfQtW4TPTgsYcxnqtxs+xCXh8L4Tx5NratGakJVO3IGBcxbdvvsAjI8RQs+eFxQXF6emnBHGxlLor9cHWEjhTV\/Kysrt2rU\/eGBfduZ9r7GjEUL19ZKUi5fynmafPnHs8tUbCCGKotaFLCkpLRvjNbl\/\/3774w4sX7Is59FDr3FjOBz2Z59wY\/BbryljqO3bt8NBeXl56TsgpbS0FK+i4XrevHlTWVn5+PHjvXv3wporgM1Zjx49KvuqxfXAlBS9e4V17tz5\/v37RUVFp0+f1tTUrKys9Pb2xq+n6upqbPCM24bPnjt3DgsnqA2uq6qqun\/\/flVV1fLy8uDg4Hbt2qHG3v4AvJ0VFRVN\/gk8LfRScg4Upnfv3kKhMDMz08rKCiGUnp5+5coVep2yB\/IYrNHl2YQJE+bMmYMQEovFvr6+uB58L7CIotPUvYDilpaWoEq5ffs23sQvNXpaWlozZsx48OAB3iaHDebBcL2goEBqVxJePGaz2fL3uinhLf+D8d4Gy94FOlh4M5lM+uOBPzdxKWyx\/+TJE6lKoO+44\/RO2djY4E+NqVOn0pst\/0jimTdCaNiwYbBYfv78+WPHjiGEYBHqs8+8BQIB7AED32pylsK+RelgJ6Ofl9zcXDMzM+jRx\/bM+oXTkpbY1pZmZ08cuXDugp+fX7n4lbeXj8P33DkLl54+c7Zvn95Xfr+YlnpxwoSJKu\/0TibGRt87\/r2xWFNT09LCXFHx7yYpKipMneR35fLVlPOnBg7ol3g0OXDu4n79XTasX6dIVV25fDn9xmXsXfWLAr8pZFWgCKG8vLwzZ84gGXsc\/NLft++v0OZ4m3JTU9hevXp16dIFIZSZmQkrppjMzMx169YhhFgsFtY5w1sPvxxdXFxgq1hhYSG2\/Tl8+DDsPz506BC9ebNmzYKWxMXFNVqbjY3Nhg0bEEJ79+6FL7Ommg1nce8wUCEuJf9ASWFmZjZt2jQ4hkkPft3LzvkavUeNNgy3OSQkBIb9999\/B+t3hNC4ceNgxr97925YF8fExcWBJ5N+\/fphZw5Sozd16lTwSYIt6RodPQUFhYULF8KUDs\/nwKhbIpFIfc2AhwotLS17e3t6nQoKCk1tBEBNS1b5H4z3Nlj2dtDBGx+knhDZUra2ttARqY\/XBw8egDgHU0okcwdHjBgB27Jfv36NHxX0ISMJwhv6paKiAqYYt27dunnzpoGBASjSsWLgcwlvsVgMbsxzc3PBM5qcpWRdjgQGBn6e3cz\/hMVipaenp6amCoVCvLnm2+TDtoq9FwUFhq1NZ1ubJcWvS\/64d\/9JdvbZlLT5C5bVNdQZGRl25JjqGxhevHyF1UbH0srcysJi1\/Zfcdn2Bu3WhQTrt9O79yCrRFz25\/OCly8KX78pev7nn7n5zyora1xcBtp0s+L+8N1gl0GaTXj\/+ELAb5+ysjKpfxhDQ0OwwEIIYRtpYODAgYqKihKJ5OTJk2\/evNHV1cX14Fe8FAwGY9u2bS4uLnV1dSEhIX\/88Qefz2\/btu21a9fWr18Pk9SoqCjsy6ympkaqthkzZoSEhNTU1ISHh8+ZM0dFRQUskpSUlFxcXOjX+vHHH7ds2YIQ2r9\/P\/zbwOyEvsds5syZp0+fPn78OCw2S20\/w0ADZDsF+fGkR\/6B2rx5s66ubqdOnVgsVlVVVWZmJlbwwoQY14mb1Pw9klq2h3HDbVZVVY2OjnZycqIoaunSpe7u7hwOx9TUdPny5YsXL5ZIJK6urv7+\/sOHD1dQUEhKSoqKikIIsVgsujc32dHbuXPnjRs38CQPTj148CA+Pv67774zNDRUUlIqKio6evQouCrDb1hvb+\/Q0NCGhoYpU6aUl5c7OzuXlpbu3r37t99+QwhNnjwZf6BAnUwmU6rLDAYDzymbeurkfDDkabDs7aCDryvVAJwZF9fS0uLxeIcPH75\/\/767u\/vixYuNjIzu3LkDWxY1NDTo+zWk6ty4cWNycnJRUVFSUtJvv\/3m4eHxQSMJwhuL5wkTJmzbti07OxshNHfuXFBsfHbhjWGxWNjbCfgWRQg5OzuHhYVBlC07OzuxWAwezrlcLsh7Ho8Hhgupqangq+TT+0Pl8XjBwcH4yaF7g8G6rm8U\/Pks\/64q+amvry8re1tUVPz48ZMdMQd4Y31tHBzbGXbQ1W9vaGxqbMrpaG4p+2fUgW1g3EFP37C9UYeDR5IzMrOeP3\/+8tUrCMX9kZDbhl8uNm3a1NSAX7t2DfaVKikpvX37Vqog3he7c+dO6t12F4RQXl5eM5dLSEjACjo6ampqQqGQnhMMpM3NzemJnp6ekH\/v3r2wAQYh1KdPH6mrlJWVYZvbx48fUxQ1cuRIhFD\/\/v3p2QoLC7F6U+rqGBCNBgYGUukwizI1NaUoSiKRyDlQ9fX1jXYfIbRo0SLIDyoBhFB0dDSkNHOPbty4IXU5XJy+oQ6bzrm6uuLEJUuWNLp806FDh1u3btHrhDYvW7aMnnj27FlcJDc3l6Jt3JLC2Ng4JycHFwwJCWk0W58+feijB7dMFiaTifNgvz3Hjx\/HifI\/GPI0GG+OyMzMpGTA7snGjRtHT8f7CyZOnIgTCwoKcNwIOkpKSnFxcTjbzZs3Id3Lywsn4m8pY2NjPEryjCT2lDBr1ixcG27GnTt3IAV7m+ndu7dsN1uE5reKLV++nMvl8vl8W1tb8K8SExPj5uYGZ21tbdPT0wMCAiBAdUxMjK+vL0VR8FWakpIC6biqTxa0m05YWBg4jcEEBASAu7T09PRP355Pw8faKiY\/DAZDQ4Opq6vTsSNn0sRx8XG7RdcuFv6Ze\/vGzbWhYX6Tpztyh8j+TfspMPlo8ssXfxY8y\/VwG2ZlaWFgYKDXtq2KSpOKvi8N+n4qKTIyMsCnSpcuXWT9gGKZBGo6bJncTIUIIR6Pl5mZOW\/evK5duzKZTCaT2blz56CgoKysLOwZEYApi9SExsfHBw6io6Oxn8jevXtLXUVLSwvv1YHtatAqKc+aBgYGoK5HTTuGhAZInaUoCtKhwt9\/\/13OgSopKXFxcbGwsGjTpo2CggKTybSwsPDy8jp79ix+EeNr4YNmhlTWnwYuhSdwCCG8iJiUlITdyK9aterWrVu+vr5sNltFRUVbW7tPnz6hoaEZGRngJwfT6OgNGjQI3w64aNu2bb\/\/\/nsDAwNVVVUlJSU9PT1HR8fVq1f\/8ccfZmZmuOCiRYvOnj3L4\/Hat2+vpKSkpaXl4OCwadOmlJQU+ug11Wt6l3Ef6dNi+R8MeRosezvo4OdT6ixuGH3QYKq9bNkyOzs7DQ0NZWVlY2NjT0\/P69evYz9uqIk76OfnBxK3oKBg8+bNkCjPSObl5cEBfc0FfMQaGxtj1To2hv+MBmtsNhteAjBnzc3NvXv3rrOzM\/ZejvXhiYmJ9MgcdnZ2IpHI3d29+eBdH5vAwECpjzOBQJCQkAAinO6H+FuDQTUdz5xAIBAIXzK6urpPnjyR8oKHwbru3NxcLpcLK99IRvsN3rz5fD4spoDaHE5B2GwI+C1b8PPC4XCEQiHefvI1oaurm5OT07zH+BZe8yYQCATClwaHwwHzbD6fz+VyYTE7LS0NJuV8Pt\/Pz08qXAfE3ORwOE19GXwapNa8hUIhg8HgcDgikahRw7qvA3km1UR4EwgEwtcJfVYqEAjAJE0oFMIxPsvj8cAuHX7CAYvFgmxg1Pa5JriwKwz\/5PF4AoEgJiYGtPqfPor2lwNRmxMIBEJrpXm1OaGVoqOj8\/Tp0+Y\/TT5DxC0CgUAgEAj\/BSK8CQQCgUD4gpAr4MInaAeBQCAQCIQWhAhvAoFAIBBaGUR4EwgEwjdNbm7uNx7kozVChDeBQCB8nQQHB9PdqjS1ktrqhHdqaqqZmdkX5THm00OEN4FAIHxzNONYVPYUPUUqpE2jkco+qtdScPfm5ub28S7RKiDCm0AgEL4t7OzseDweh8ORmrwKhUJ8CrtKdXd3hxSBQADe2SBaeW5urp2dHZ\/PB8cvCKHg4GB3d3c7Ozsulwt5WgRnZ2epxguFwm\/ZPQtAPKwRCATCV0tsbGxaWppUIrg+FYvFUspnHo8H7tUCAwOFQiGccnJywj\/BqRmDwYiJiWGxWFAPBAyFgk+fPsV+VXNzcxsN+PahODk5\/fdKvj6I8CYQCISvFl9fXyye8Zp3ampqbGysWCyW1W8HBQWJRKLc3FwckBD8h3M4HHCQjnOyWKzY2NjExER6JTgEeAsK7298bbspiNqcQCAQviFEIhG4B09JSZE6BZG\/U1JSpEIJN4pQKExISGi0HsIngAhvAoFA+IYQi8WlpaW5ubnh4eGNnhKJRPLE8BaLxQwGQywWt+DydqNIrXmLxeK0tLS8vLy8vLy0tLRvNqQ3UZsTCATC14lUKLDly5dDoq+vr0Ag4PF4kMLhcGDFWiAQCIXCp0+fQjwxhBDYo9Hz4HoCAwMRQrDaja3b8LVwwf+O1Jq3WCxOSUlhs9kIoZSUFFtb2xa5SquDRBUjEAiE1gqJKvZVoqurm5OTQ6KKEQgEAoHwVUGEN4FAIBAIXxDyaMSJ8CYQCAQCoZVBhDeBQCAQCK0MIrwJBAKBQGhlEOFNIBAIBMIXRFPx3+gQ4U0gEAgEQiuDCG8CgUAgEFoZRHgTCAQCgdDKIMKbQCAQCIRWBhHeBAKBQCC0MojwJhAIBAKhlUGEN4FAIBAIrQwivAkEAoFAaGUQ4U0gEAgEQitD6XM3gEAgEAj\/ktra2vj4eA0Njc\/dEEJLUltb+948RHgTCARCayUwMPD06dMqKiqfuyGElsTDw+O9eRjyxA0lEAgEAoHw5UDWvAkEAoFAaGUQ4U0gEAgEQiuDCG8CgUAgEFoZRHgTCAQCgdDKIMKbQCAQCIRWBhHeBAKBQCC0MojwJhAIBAKhlUGEN4FAIBAIrQwivAkEAoFAaGUQ4U0gEAgEQiuDCG8CgUAgEFoZ\/w\/p93023DP+bQAAAABJRU5ErkJggg==\" width=\"569\" height=\"144\"><\/p>\r\n<table style=\"border: none; border-collapse: collapse; height: 265px;\" width=\"727\">\r\n<tbody>\r\n<tr style=\"height: 24.05pt;\">\r\n<td style=\"vertical-align: middle; padding: 0pt 5.4pt; overflow: hidden; overflow-wrap: break-word; border: 0.5pt solid #000000; width: 111.562px; height: 31px;\">\r\n<p style=\"line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"font-size: 11pt; font-family: Candara,sans-serif; color: #000000; background-color: transparent_id; font-weight: 400; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">No. Reg<\/span><\/p>\r\n<\/td>\r\n<td style=\"vertical-align: middle; padding: 0pt 5.4pt; overflow: hidden; overflow-wrap: break-word; border: 0.5pt solid #000000; width: 144.766px; height: 31px;\"><span class=\"input-variable input-nomordokumen\" name=\"nomordokumen\" contenteditable=\"true\">200\/02\/2023<\/span><\/td>\r\n<td style=\"vertical-align: middle; padding: 0pt 5.4pt; overflow: hidden; overflow-wrap: break-word; border: 0.5pt solid #000000; width: 147.922px; height: 31px;\">\r\n<p style=\"line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"font-size: 11pt; font-family: Candara,sans-serif; color: #000000; background-color: transparent_id; font-weight: 400; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Tanggal<\/span><\/p>\r\n<\/td>\r\n<td style=\"vertical-align: top; padding: 0pt 5.4pt; overflow: hidden; overflow-wrap: break-word; border: 0.5pt solid #000000; width: 260.25px; height: 31px;\"><span class=\"input-variable input-tanggal\" name=\"tanggal\" contenteditable=\"true\">{{tanggal}}<\/span><\/td>\r\n<\/tr>\r\n<tr style=\"height: 23.25pt;\">\r\n<td style=\"vertical-align: middle; padding: 0pt 5.4pt; overflow: hidden; overflow-wrap: break-word; border: 0.5pt solid #000000; width: 111.562px; height: 30px;\">\r\n<p style=\"line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"font-size: 11pt; font-family: Candara,sans-serif; color: #000000; background-color: transparent_id; font-weight: 400; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Nama Klien<\/span><\/p>\r\n<\/td>\r\n<td style=\"vertical-align: middle; padding: 0pt 5.4pt; overflow: hidden; overflow-wrap: break-word; border: 0.5pt solid #000000; width: 144.766px; height: 30px;\"><span class=\"input-variable input-namaKlien\" name=\"namaKlien\" contenteditable=\"true\">{{namaKlien}}<\/span><\/td>\r\n<td style=\"vertical-align: middle; padding: 0pt 5.4pt; overflow: hidden; overflow-wrap: break-word; border: 0.5pt solid #000000; width: 147.922px; height: 30px;\">\r\n<p style=\"line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"font-size: 11pt; font-family: Candara,sans-serif; color: #000000; background-color: transparent_id; font-weight: 400; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Waktu<\/span><\/p>\r\n<\/td>\r\n<td style=\"vertical-align: top; padding: 0pt 5.4pt; overflow: hidden; overflow-wrap: break-word; border: 0.5pt solid #000000; width: 260.25px; height: 30px;\"><span class=\"input-variable input-waktu\" name=\"waktu\" contenteditable=\"true\">{{waktu}}<\/span><\/td>\r\n<\/tr>\r\n<tr style=\"height: 24.05pt;\">\r\n<td style=\"vertical-align: middle; padding: 0pt 5.4pt; overflow: hidden; overflow-wrap: break-word; border: 0.5pt solid #000000; width: 111.562px; height: 134px;\">\r\n<p style=\"line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"font-size: 11pt; font-family: Candara,sans-serif; color: #000000; background-color: transparent_id; font-weight: 400; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Kasus<\/span><\/p>\r\n<\/td>\r\n<td style=\"vertical-align: middle; padding: 0pt 5.4pt; overflow: hidden; overflow-wrap: break-word; border: 0.5pt solid #000000; width: 144.766px; height: 134px;\"><span class=\"input-variable input-kasus\" name=\"kasus\" contenteditable=\"true\">{{kasus}}<\/span><\/td>\r\n<td style=\"vertical-align: middle; padding: 0pt 5.4pt; overflow: hidden; overflow-wrap: break-word; border: 0.5pt solid #000000; width: 147.922px; height: 134px;\">\r\n<p style=\"line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"font-size: 11pt; font-family: Candara,sans-serif; color: #000000; background-color: transparent_id; font-weight: 400; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Konsultan Hukum<\/span><\/p>\r\n<\/td>\r\n<td style=\"vertical-align: top; padding: 0pt 5.4pt; overflow: hidden; overflow-wrap: break-word; border: 0.5pt solid #000000; width: 260.25px; height: 134px;\">\r\n<p style=\"line-height: 1.2; text-align: justify; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"font-size: 11pt; font-family: Candara,sans-serif; color: #000000; background-color: transparent_id; font-weight: 400; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Advokat:<\/span><\/p>\r\n<p style=\"line-height: 1.295; margin-left: 20.55pt; text-align: justify; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"font-family: Candara, sans-serif;\"><span style=\"font-size: 14.6667px; white-space: pre-wrap;\"><span class=\"input-variable input-advokat\" name=\"advokat\" contenteditable=\"true\">{{advokat}}<\/span><\/span><\/span><\/p>\r\n<p style=\"line-height: 1.295; text-indent: -20.55pt; text-align: justify; margin-top: 0pt; margin-bottom: 8pt; padding: 0pt 0pt 0pt 20.55pt;\"><span style=\"font-size: 11pt;\">?<\/span><span style=\"font-size: 11pt; font-family: Candara,sans-serif; color: #000000; background-color: transparent_id; font-weight: 400; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"> &nbsp; Paralegal Pusat<\/span><\/p>\r\n<p style=\"line-height: 1.2; text-align: justify; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"font-size: 11pt;\">? <\/span><span style=\"font-size: 11pt; font-family: Candara,sans-serif; color: #000000; background-color: transparent_id; font-weight: 400; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Paralegal Pos<\/span><\/p>\r\n<p style=\"line-height: 1.2; text-align: justify; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"font-size: 11pt;\">? <\/span><span style=\"font-size: 11pt; font-family: Candara,sans-serif; color: #000000; background-color: transparent_id; font-weight: 400; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Paralegal URC<\/span><\/p>\r\n<p style=\"line-height: 1.295; margin-left: 20.55pt; text-align: justify; margin-top: 0pt; margin-bottom: 8pt;\"><span style=\"font-size: 11pt; font-family: Candara,sans-serif; color: #000000; background-color: transparent_id; font-weight: 400; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\"><span class=\"input-variable input-pararegalURC\" name=\"pararegalURC\" contenteditable=\"true\">{{pararegalURC}}<\/span><\/span><\/p>\r\n<\/td>\r\n<\/tr>\r\n<tr style=\"height: 23.25pt;\">\r\n<td style=\"vertical-align: middle; padding: 0pt 5.4pt; overflow: hidden; overflow-wrap: break-word; border: 0.5pt solid #000000; width: 111.562px; height: 30px;\">\r\n<p style=\"line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"font-size: 11pt; font-family: Candara,sans-serif; color: #000000; background-color: transparent_id; font-weight: 400; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Pertemuan ke<\/span><\/p>\r\n<\/td>\r\n<td style=\"vertical-align: middle; padding: 0pt 5.4pt; overflow: hidden; overflow-wrap: break-word; border: 0.5pt solid #000000; width: 144.766px; height: 30px;\"><span class=\"input-variable input-pertemuanKe\" name=\"pertemuanKe\" contenteditable=\"true\">{{pertemuanKe}}<\/span><\/td>\r\n<td style=\"vertical-align: middle; padding: 0pt 5.4pt; overflow: hidden; overflow-wrap: break-word; border: 0.5pt solid #000000; width: 147.922px; height: 30px;\">\r\n<p style=\"line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"font-size: 11pt; font-family: Candara,sans-serif; color: #000000; background-color: transparent_id; font-weight: 400; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Supervisor<\/span><\/p>\r\n<\/td>\r\n<td style=\"vertical-align: top; padding: 0pt 5.4pt; overflow: hidden; overflow-wrap: break-word; border: 0.5pt solid #000000; width: 260.25px; height: 30px;\"><span class=\"input-variable input-supervisor\" name=\"supervisor\" contenteditable=\"true\">{{supervisor}}<\/span><\/td>\r\n<\/tr>\r\n<tr style=\"height: 23.75pt;\">\r\n<td style=\"vertical-align: middle; padding: 0pt 5.4pt; overflow: hidden; overflow-wrap: break-word; border: 0.5pt solid #000000; width: 111.562px; height: 30px;\">\r\n<p style=\"line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"font-size: 11pt; font-family: Candara,sans-serif; color: #000000; background-color: transparent_id; font-weight: 400; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Tempat<\/span><\/p>\r\n<\/td>\r\n<td style=\"vertical-align: middle; padding: 0pt 5.4pt; overflow: hidden; overflow-wrap: break-word; border: 0.5pt solid #000000; width: 144.766px; height: 30px;\"><span class=\"input-variable input-tempat\" name=\"tempat\" contenteditable=\"true\">{{tempat}}<\/span><\/td>\r\n<td style=\"vertical-align: middle; padding: 0pt 5.4pt; overflow: hidden; overflow-wrap: break-word; border: 0.5pt solid #000000; width: 147.922px; height: 30px;\">\r\n<p style=\"line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"font-size: 11pt; font-family: Candara,sans-serif; color: #000000; background-color: transparent_id; font-weight: 400; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Koordinator Hukum<\/span><\/p>\r\n<\/td>\r\n<td style=\"vertical-align: top; padding: 0pt 5.4pt; overflow: hidden; overflow-wrap: break-word; border: 0.5pt solid #000000; width: 260.25px; height: 30px;\"><span class=\"input-variable input-koordinatorHukum\" name=\"koordinatorHukum\" contenteditable=\"true\">{{koordinatorHukum}}<\/span><\/td>\r\n<\/tr>\r\n<\/tbody>\r\n<\/table>\r\n<p style=\"line-height: 1.2; margin-left: 36pt; margin-top: 0pt; margin-bottom: 0pt;\">&nbsp;<\/p>\r\n<p style=\"line-height: 2.4; margin-top: 0pt; margin-bottom: 0pt;\"><strong><span style=\"font-size: 12pt; font-family: Candara,sans-serif; color: #000000; background-color: transparent_id; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Permasalahan klien :<\/span><\/strong><\/p>\r\n<p style=\"line-height: 1.7999999999999998; text-align: justify; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"text-decoration: underline;\"><span class=\"input-variable input-permasalahan\" name=\"permasalahan\" contenteditable=\"true\">{{permasalahan}}<\/span><\/span><\/p>\r\n<p style=\"line-height: 2.4; text-align: justify; margin-top: 0pt; margin-bottom: 0pt;\"><strong><span style=\"font-size: 12pt; font-family: Candara,sans-serif; color: #000000; background-color: transparent_id; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Harapan klien:<\/span><\/strong><\/p>\r\n<p style=\"line-height: 1.7999999999999998; text-align: justify; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"text-decoration: underline;\"><span class=\"input-variable input-harapan\" name=\"harapan\" contenteditable=\"true\">{{harapan}}<\/span><\/span><\/p>\r\n<p style=\"line-height: 2.4; text-align: justify; margin-top: 0pt; margin-bottom: 0pt;\"><strong><span style=\"font-size: 12pt; font-family: Candara,sans-serif; color: #000000; background-color: transparent_id; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Legal Advice:<\/span><\/strong><\/p>\r\n<p style=\"line-height: 1.7999999999999998; text-align: justify; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"text-decoration: underline;\"><span class=\"input-variable input-legalAdvice\" name=\"legalAdvice\" contenteditable=\"true\">{{legalAdvice}}<\/span><\/span><\/p>\r\n<p style=\"line-height: 2.4; text-align: justify; margin-top: 0pt; margin-bottom: 0pt;\"><strong><span style=\"font-size: 12pt; font-family: Candara,sans-serif; color: #000000; background-color: transparent_id; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Rencana Tindak Lanjut :<\/span><\/strong><\/p>\r\n<p style=\"line-height: 1.7999999999999998; text-align: justify; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"text-decoration: underline;\"><span class=\"input-variable input-tindakLanjut\" name=\"tindakLanjut\" contenteditable=\"true\">{{tindakLanjut}}<\/span><\/span><\/p>\r\n<p style=\"line-height: 2.4; text-align: justify; margin-top: 0pt; margin-bottom: 0pt;\"><strong><span style=\"font-size: 12pt; font-family: Candara,sans-serif; color: #000000; background-color: transparent_id; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;\">Catatan Supervisi :<\/span><\/strong><\/p>\r\n<p style=\"line-height: 1.7999999999999998; text-align: justify; margin-top: 0pt; margin-bottom: 0pt;\"><span style=\"text-decoration: underline;\"><span class=\"input-variable input-catatanSupervisi\" name=\"catatanSupervisi\" contenteditable=\"true\">{{catatanSupervisi}}<\/span><\/span><\/p>"',
                'nama_template' => '[F-ADV-02] Konsultasi Hukum', 
                'pemilik_template' => 'Advokat', 
                'created_by_template' => 'Advokat', 
                'created_at_template' => '2023-07-14 07:14:12', 
                'updated_at_template' => '2023-07-14 07:14:12', 
                'created_by' => 2,
                'created_at' => Carbon::now()
            ]
        ];
        Dokumen::insert($dokumen);

        //data keyword dokumen
        $dokumen_keyword = [
            [
                "dokumen_id" => 1,
                "keyword" => 'Pemeriksaan Psikologi'
            ],
            [
                "dokumen_id" => 1,
                "keyword" => 'Konseling Psikologi'
            ],
            [
                "dokumen_id" => 2,
                "keyword" => 'Pemeriksaan Psikologi'
            ],
            [
                "dokumen_id" => 2,
                "keyword" => 'Konseling Psikologi'
            ],
            [
                "dokumen_id" => 3,
                "keyword" => 'Konsultasi Hukum'
            ],
            [
                "dokumen_id" => 3,
                "keyword" => 'Konsultasi Hukum'
            ]
        ];
        DokumenKeyword::insert($dokumen_keyword);

        //dokumen_tl
        $dokumen_tl = [
            [
                "tindak_lanjut_id" => 6,
                "dokumen_id" => 3
            ],
            [
                "tindak_lanjut_id" => 7,
                "dokumen_id" => 3
            ]
        ];
        DokumenTl::insert($dokumen_tl);

        //data notifikasi & task
        $notifikasi = [
            [
                "uuid" => '8bf11224-1018-411d-97c0-342ab598c2cf',
                "klien_id" => 2,
                "receiver_id" => 1,
                "kode" => 'T2',
                "type_notif" => 'task',
                "no_reg" => NULL,
                "from" => 'System',
                "message" => 'Kasus baru. Silahkan pilih Supervisor & Manajer Kasus',
                "kasus" => 'Ziboy (5)',
                "url" => 'http://127.0.0.1:8000/kasus/show/35dbs9e8-551a-4a8f-91d1-e8ea392q5515?tab=kasus-petugas&tambah-petugas=1',
                "read" => 0,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
                "deleted_at" => NULL
            ],
            [
                "uuid" => '5f585c2c-852d-4823-995a-6f9b2b16f07d',
                "klien_id" => 3,
                "receiver_id" => 1,
                "kode" => 'T2',
                "type_notif" => 'task',
                "no_reg" => NULL,
                "from" => 'System',
                "message" => 'Kasus baru. Silahkan pilih Supervisor & Manajer Kasus',
                "kasus" => 'Caca Marica Hey Hey (27)',
                "url" => 'http://127.0.0.1:8000/kasus/show/35dbsbe8-556a-4a8f-91d1-e8ea392q5515?tab=kasus-petugas&tambah-petugas=1',
                "read" => 0,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
                "deleted_at" => NULL
            ]
        ];
        Notifikasi::insert($notifikasi);

        //data log activity
        $log_activity = [
            [
                "uuid" => '2921de61-0439-40d4-ac46-10ebd530bd2a',
                "klien_id" => 2,
                "message" => 'Petugas Penerima Pengaduan menginputkan data kasus baru',
                "ip" => '127.0.0.1',
                "browser" => 'Chrome 103.0.0.0',
                "device" => 'WebKit',
                "created_by" => 1
            ],
            [
                "uuid" => '532b1e9f-c9ce-42ec-ae83-67c1fd1b55a5',
                "klien_id" => 3,
                "message" => 'Petugas Penerima Pengaduan menginputkan data kasus baru',
                "ip" => '127.0.0.1',
                "browser" => 'Chrome 103.0.0.0',
                "device" => 'WebKit',
                "created_by" => 1
            ]
        ];
        LogActivity::insert($log_activity);
    }
}
