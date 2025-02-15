<?php

namespace Database\Seeders;

use App\Models\Agenda;
use App\Models\Asesmen;
use App\Models\Catatan;
use App\Models\DifabelType;
use App\Models\Dokumen;
use App\Models\DokumenKeyword;
use App\Models\DokumenTl;
use App\Models\Kasus;
use App\Models\KategoriKasus;
use App\Models\Klien;
use App\Models\TKedaruratan;
use App\Models\Layanan;
use App\Models\LogActivity;
use App\Models\MBentukKekerasan;
use App\Models\MJenisKekerasan;
use App\Models\MKategoriKasus;
use App\Models\MKeyword;
use App\Models\Notifikasi;
use App\Models\TPasal;
use App\Models\Pelapor;
use App\Models\PersetujuanIsi;
use App\Models\PersetujuanItem;
use App\Models\PersetujuanTemplate;
use App\Models\Petugas;
use App\Models\TProgramPemerintah;
use App\Models\RiwayatKejadian;
use App\Models\RKategoriJenisBentuk;
use App\Models\TBentukKekerasan;
use App\Models\Template;
use App\Models\template_keyword;
use App\Models\TemplateKeyword;
use App\Models\Terlapor;
use App\Models\TindakKekerasan;
use App\Models\TindakLanjut;
use App\Models\TJenisKekerasan;
use App\Models\TKategoriKasus;
use App\Models\TKeyword;
use App\Models\TTipeDisabilitas;
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
        $csvFile = fopen(base_path("database/data/users.csv"), "r");
        $firstline = true;
        while (($users = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                User::create([
                    "id" => $users['0'],
                    "uuid" => $users['1'],
                    "name" => $users['2'],
                    "kotkab_id" => $users['3'],
                    "email" => $users['4'],
                    "email_verified_at" => Carbon::now(),
                    "jabatan" => $users['6'],
                    // "supervisor_layanan" => 0,
                    "supervisor_id" => $users['7'],
                    "password" => $users['8'],
                    "remember_token" => NULL,
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                    "deleted_at" => NULL,
                ]);    
            }
            $firstline = false;
        }
        fclose($csvFile);
        
        // $users = [
        //     [
        //         "uuid" => "43a348be-9f12-42f5-b567-f095fc5c11cd",
        //         "name" => "Muhammad Light Yagami",
        //         "kotkab_id" => 4,
        //         "email" => 'penerima@moka.ol',
        //         "email_verified_at" => '2023-03-08 03:28:35',
        //         "jabatan" => 'Penerima Pengaduan',
        //         // "supervisor_layanan" => 0,
        //         "supervisor_id" => 11,
        //         "password" => '$2y$10$9BcBcEWaVUmAOrl2zZkaKeYRZaajkbtNFlAcpNTwkXDab9e00kqlq',
        //         "foto" => 'light.png'
        //     ],[
        //         "uuid" => "43a348be-9f12-42f5-b567-f095f25111cd",
        //         "name" => "Alex Ferguson",
        //         "kotkab_id" => 4,
        //         "email" => "mk@moka.ol",
        //         "email_verified_at" => '2023-03-08 03:28:35',
        //         "jabatan" => 'Manajer Kasus',
        //         // "supervisor_layanan" => 0,
        //         "supervisor_id" => 9,
        //         "password" => '$2y$10$9BcBcEWaVUmAOrl2zZkaKeYRZaajkbtNFlAcpNTwkXDab9e00kqlq',
        //         "foto" => 'ferguson.png'
        //     ],[
        //         "uuid" => "43a348be-9f12-42f5-b567-f09tfc5111cd",
        //         "name" => "Dominic Toretto",
        //         "kotkab_id" => 4,
        //         "email" => "pk@moka.ol",
        //         "email_verified_at" => '2023-03-08 03:28:35',
        //         "jabatan" => 'Pendamping Kasus',
        //         // "supervisor_layanan" => 0,
        //         "supervisor_id" => 9,
        //         "password" => '$2y$10$9BcBcEWaVUmAOrl2zZkaKeYRZaajkbtNFlAcpNTwkXDab9e00kqlq',
        //         "foto" => 'dominic.png'
        //     ],[
        //         "uuid" => "43a348be-9f12-42f5-b567-f0952c5111cd",
        //         "name" => "Wanda Maximoff",
        //         "kotkab_id" => 4,
        //         "email" => "psikolog@moka.ol",
        //         "email_verified_at" => '2023-03-08 03:28:35',
        //         "jabatan" => 'Psikolog',
        //         // "supervisor_layanan" => 0,
        //         "supervisor_id" => 13,
        //         "password" => '$2y$10$9BcBcEWaVUmAOrl2zZkaKeYRZaajkbtNFlAcpNTwkXDab9e00kqlq',
        //         "foto" => 'light.png'
        //     ],[
        //         "uuid" => "43a348be-9112-42f5-b567-f095fo5111cd",
        //         "name" => "Hotman Paris Hutapea",
        //         "kotkab_id" => 4,
        //         "email" => "advokat@moka.ol",
        //         "email_verified_at" => '2023-03-08 03:28:35',
        //         "jabatan" => 'Advokat',
        //         // "supervisor_layanan" => 0,
        //         "supervisor_id" => 12,
        //         "password" => '$2y$10$9BcBcEWaVUmAOrl2zZkaKeYRZaajkbtNFlAcpNTwkXDab9e00kqlq',
        //         "foto" => 'light.png'
        //     ],[
        //         "uuid" => "43a348be-9112-42f5-b567-f095fc5111cd",
        //         "name" => "John Constantine",
        //         "kotkab_id" => 4,
        //         "email" => "paralegal@moka.ol",
        //         "email_verified_at" => '2023-03-08 03:28:35',
        //         "jabatan" => 'Paralegal',
        //         // "supervisor_layanan" => 0,
        //         "supervisor_id" => 12,
        //         "password" => '$2y$10$9BcBcEWaVUmAOrl2zZkaKeYRZaajkbtNFlAcpNTwkXDab9e00kqlq',
        //         "foto" => 'light.png'
        //     ],[
        //         "uuid" => "43a348be-9112-42f5-b567-f095fc5112cd",
        //         "name" => "Bruce Wayne",
        //         "kotkab_id" => 4,
        //         "email" => "urc@moka.ol",
        //         "email_verified_at" => '2023-03-08 03:28:35',
        //         "jabatan" => 'Unit Reaksi Cepat',
        //         // "supervisor_layanan" => 0,
        //         "supervisor_id" => 12,
        //         "password" => '$2y$10$9BcBcEWaVUmAOrl2zZkaKeYRZaajkbtNFlAcpNTwkXDab9e00kqlq',
        //         "foto" => 'light.png'
        //     ],[
        //         "uuid" => "43a348be-9112-42f5-b567-f095fc5011cd",
        //         "name" => "Nick Fury",
        //         "kotkab_id" => 4,
        //         "email" => "spv@moka.ol",
        //         "email_verified_at" => '2023-03-08 03:28:35',
        //         "jabatan" => 'Supervisor Kasus',
        //         // "supervisor_layanan" => 0,
        //         "supervisor_id" => 11,
        //         "password" => '$2y$10$9BcBcEWaVUmAOrl2zZkaKeYRZaajkbtNFlAcpNTwkXDab9e00kqlq',
        //         "foto" => 'nick.jpg'
        //     ],[
        //         "uuid" => "43a348be-9112-42f5-b767-f095fc5111cd",
        //         "name" => "Tenaga Ahli",
        //         "kotkab_id" => 4,
        //         "email" => "ta@moka.ol",
        //         "email_verified_at" => '2023-03-08 03:28:35',
        //         "jabatan" => 'Tenaga Ahli',
        //         // "supervisor_layanan" => 1,
        //         "supervisor_id" => 0,
        //         "password" => '$2y$10$9BcBcEWaVUmAOrl2zZkaKeYRZaajkbtNFlAcpNTwkXDab9e00kqlq',
        //         "foto" => 'light.png'
        //     ],[
        //         "uuid" => "43a348be-9112-42f5-b537-f095fc5111cd",
        //         "name" => "Tony Stark",
        //         "kotkab_id" => 4,
        //         "email" => "superadmin@moka.ol",
        //         "email_verified_at" => '2023-03-08 03:28:35',
        //         "jabatan" => 'Super Admin',
        //         // "supervisor_layanan" => 0,
        //         "supervisor_id" => 0,
        //         "password" => '$2y$10$9BcBcEWaVUmAOrl2zZkaKeYRZaajkbtNFlAcpNTwkXDab9e00kqlq',
        //         "foto" => 'light.png'
        //     ],[
        //         "uuid" => "43a348be-9112-42fs-b567-f095fc5111cd",
        //         "name" => "Kepala Instansi",
        //         "kotkab_id" => 4,
        //         "email" => "kepala@moka.ol",
        //         "email_verified_at" => '2023-03-08 03:28:35',
        //         "jabatan" => 'Kepala Instansi',
        //         // "supervisor_layanan" => 0,
        //         "supervisor_id" => 0,
        //         "password" => '$2y$10$9BcBcEWaVUmAOrl2zZkaKeYRZaajkbtNFlAcpNTwkXDab9e00kqlq',
        //         "foto" => 'light.png'
        //     ],[
        //         "uuid" => "43a348be-9112-42f5-b567-f095fo5111td",
        //         "name" => "Advokat Sebagai SPV",
        //         "kotkab_id" => 4,
        //         "email" => "advokat.spv@moka.ol",
        //         "email_verified_at" => '2023-03-08 03:28:35',
        //         "jabatan" => 'Advokat',
        //         // "supervisor_layanan" => 1,
        //         "supervisor_id" => 9,
        //         "password" => '$2y$10$9BcBcEWaVUmAOrl2zZkaKeYRZaajkbtNFlAcpNTwkXDab9e00kqlq',
        //         "foto" => 'light.png'
        //     ],[
        //         "uuid" => "43a348be-9f12-42f5-b567-f0952a5111cd",
        //         "name" => "Psikolog Sebagai SPV",
        //         "kotkab_id" => 4,
        //         "email" => "psikolog.spv@moka.ol",
        //         "email_verified_at" => '2023-03-08 03:28:35',
        //         "jabatan" => 'Psikolog',
        //         // "supervisor_layanan" => 1,
        //         "supervisor_id" => 9,
        //         "password" => '$2y$10$9BcBcEWaVUmAOrl2zZkaKeYRZaajkbtNFlAcpNTwkXDab9e00kqlq',
        //         "foto" => 'light.png'
        //     ],[
        //         "uuid" => "43a348be-9f12-42f5-b567-f09e2c5111cd",
        //         "name" => "Konselor",
        //         "kotkab_id" => 4,
        //         "email" => "konselor@moka.ol",
        //         "email_verified_at" => '2023-03-08 03:28:35',
        //         "jabatan" => 'Konselor',
        //         // "supervisor_layanan" => 0,
        //         "supervisor_id" => 13,
        //         "password" => '$2y$10$9BcBcEWaVUmAOrl2zZkaKeYRZaajkbtNFlAcpNTwkXDab9e00kqlq',
        //         "foto" => 'light.png'
        //     ],[
        //         "uuid" => "43a348be-9f12-42f5-b567-f09s2c5111cd",
        //         "name" => "Sekretariat",
        //         "kotkab_id" => 4,
        //         "email" => "sekretariat@moka.ol",
        //         "email_verified_at" => '2023-03-08 03:28:35',
        //         "jabatan" => 'Sekretariat',
        //         // "supervisor_layanan" => 0,
        //         "supervisor_id" => 13,
        //         "password" => '$2y$10$9BcBcEWaVUmAOrl2zZkaKeYRZaajkbtNFlAcpNTwkXDab9e00kqlq',
        //         "foto" => 'light.png'
        // ]
        // ];
        // User::insert($users);

        //data kasus
        // $kasus = [
        //     [
        //         "uuid" => "5caa4c24-e49b-45c1-be5f-d5485f72753a",
        //         "no_reg" => NULL,
        //         "sumber_rujukan" => 'UPTD PPA Tangsel',
        //         "media_pengaduan" => 'Datang Langsung',
        //         "sumber_informasi" => 'UPTD PPA Tangsel',
        //         "tanggal_pelaporan" => Carbon::now(),
        //         "tanggal_kejadian" => Carbon::now()->subDays(1000),
        //         "kategori_lokasi" => 'Rumah Tinggal',
        //         "provinsi_id" => 31,
        //         "kotkab_id" => 3171,
        //         "kecamatan_id" => 317204,
        //         "kelurahan_id" => 3172041003,
        //         "alamat" => 'JL Kampung Buaran Timur RT.011 RW.002',
        //         "ringkasan" => 'Rujukan dari UPTD PPA Tangerang Selatan, KTA Seksual atau anak korban. Kekerasan seksual persetubuhan a.n Fatma usia 17 tahun. Terduga pelaku yakni Bapak Kartono ayah kandung korban. Tempat kejadian perkara terjadi di alamat domisili Korban yakni Tangerang Selatan. Alamat KTP/KK keluarga/korban beralamat Jakarta selatan',
        //         "created_by" => 1,
        //         "created_at" => Carbon::now()->subDays(150),
        //         "updated_at" => Carbon::now()->addDays(1),
        //         "deleted_at" => NULL
        //     ],
        //     [
        //         "uuid" => "5caa4c24-e49b-45c1-ce5f-d5485f72753a",
        //         "no_reg" => NULL,
        //         "sumber_rujukan" => '',
        //         "media_pengaduan" => 'Datang Langsung',
        //         "sumber_informasi" => 'UPTD PPA Tangsel',
        //         "tanggal_pelaporan" => Carbon::now()->subDays(30),
        //         "tanggal_kejadian" => Carbon::now()->subDays(45),
        //         "kategori_lokasi" => 'Rumah Tinggal',
        //         "provinsi_id" => 31,
        //         "kotkab_id" => 3175,
        //         "kecamatan_id" => 317204,
        //         "kelurahan_id" => 3172041003,
        //         "alamat" => 'JL Kampung Buaran Timur RT.011 RW.002',
        //         "ringkasan" => 'Rujukan dari UPTD PPA Tangerang Selatan, KTA Seksual atau anak korban. Kekerasan seksual persetubuhan a.n Fatma usia 17 tahun. Terduga pelaku yakni Bapak Kartono ayah kandung korban. Tempat kejadian perkara terjadi di alamat domisili Korban yakni Tangerang Selatan. Alamat KTP/KK keluarga/korban beralamat Jakarta selatan',
        //         "created_by" => 1,
        //         "created_at" => Carbon::now()->subDays(2),
        //         "updated_at" => Carbon::now()->addDays(1),
        //         "deleted_at" => NULL
        //     ],
        //     [
        //         "uuid" => "5caa4c24-e49b-45c1-ce5f-d5385f72753a",
        //         "no_reg" => NULL,
        //         "sumber_rujukan" => '',
        //         "media_pengaduan" => 'Datang Langsung',
        //         "sumber_informasi" => 'UPTD PPA Tangsel',
        //         "tanggal_pelaporan" => Carbon::now()->subDays(30),
        //         "tanggal_kejadian" => Carbon::now()->subDays(45),
        //         "kategori_lokasi" => 'Rumah Tinggal',
        //         "provinsi_id" => 31,
        //         "kotkab_id" => 3171,
        //         "kecamatan_id" => 317204,
        //         "kelurahan_id" => 3172041003,
        //         "alamat" => 'JL Kampung Buaran Timur RT.011 RW.002',
        //         "ringkasan" => 'Rujukan dari UPTD PPA Tangerang Selatan, KTA Seksual atau anak korban. Kekerasan seksual persetubuhan a.n Fatma usia 17 tahun. Terduga pelaku yakni Bapak Kartono ayah kandung korban. Tempat kejadian perkara terjadi di alamat domisili Korban yakni Tangerang Selatan. Alamat KTP/KK keluarga/korban beralamat Jakarta selatan',
        //         "created_by" => 1,
        //         "created_at" => Carbon::now(),
        //         "updated_at" => Carbon::now(),
        //         "deleted_at" => NULL
        //     ],
        //     [
        //         "uuid" => "5caa4c24-e49b-45c1-ce5f-d5385f727531",
        //         "no_reg" => NULL,
        //         "sumber_rujukan" => 'Bukan Rujukan',
        //         "media_pengaduan" => 'Datang Langsung',
        //         "sumber_informasi" => 'PUSKESMAS Kec. Jagakarsa',
        //         "tanggal_pelaporan" => Carbon::now()->subDays(30),
        //         "tanggal_kejadian" => Carbon::now()->subDays(45),
        //         "kategori_lokasi" => 'Sekolah',
        //         "provinsi_id" => 31,
        //         "kotkab_id" => 3174,
        //         "kecamatan_id" => 317409,
        //         "kelurahan_id" => 3174091002,
        //         "alamat" => 'JL Kampung Buaran Timur RT.011 RW.002',
        //         "ringkasan" => 'Team Sekian (TS) merupakan dugaan korban terhadap anak (KTA) Fisik dan Psikis yang dilakukan oleh teman sekelasnya an. Yoga (Y) Bentuk kekerasan fisik dan psikis berupa ditendang,dicekik dan diolok olok.',
        //         "created_by" => 1, // ubah ini penerima pengaduan
        //         "created_at" => Carbon::now(),
        //         "updated_at" => Carbon::now(),
        //         "deleted_at" => NULL
        //     ],
        //     [
        //         "uuid" => "5caa4c24-e49b-45c1-ce5f-d5385f727531",
        //         "no_reg" => NULL,
        //         "sumber_rujukan" => 'Bukan Rujukan',
        //         "media_pengaduan" => 'Datang Langsung',
        //         "sumber_informasi" => 'PUSKESMAS Kec. Jagakarsa',
        //         "tanggal_pelaporan" => Carbon::now()->subDays(30),
        //         "tanggal_kejadian" => Carbon::now()->subDays(45),
        //         "kategori_lokasi" => 'Sekolah',
        //         "provinsi_id" => 31,
        //         "kotkab_id" => 3174,
        //         "kecamatan_id" => 317409,
        //         "kelurahan_id" => 3174091002,
        //         "alamat" => 'JL Kampung Buaran Timur RT.011 RW.002',
        //         "ringkasan" => 'Team Sekian (TS) merupakan dugaan korban terhadap anak (KTA) Fisik dan Psikis yang dilakukan oleh teman sekelasnya an. Yoga (Y) Bentuk kekerasan fisik dan psikis berupa ditendang,dicekik dan diolok olok.',
        //         "created_by" => 1, // ubah ini penerima pengaduan
        //         "created_at" => Carbon::now(),
        //         "updated_at" => Carbon::now(),
        //         "deleted_at" => NULL
        //     ]
        // ];
        // Kasus::insert($kasus);
        $csvFile = fopen(base_path("database/data/kasus.csv"), "r");
        $firstline = true;
        while (($kasus = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                Kasus::create([
                    "id" => $kasus['0'],
                    "uuid" => $kasus['1'],
                    "no_reg" => $kasus['2'],
                    "sumber_rujukan" => $kasus['3'],
                    "media_pengaduan" => $kasus['4'],
                    "sumber_informasi" => $kasus['5'],
                    "tanggal_pelaporan" => Carbon::now(),
                    "tanggal_kejadian" => Carbon::now(),
                    "perkiraan_tanggal_kejadian" => $kasus['8'],
                    "kategori_lokasi" => $kasus['9'],
                    "ringkasan" => $kasus['10'],
                    "provinsi_id" => $kasus['11'],
                    "kotkab_id" => $kasus['12'],
                    "kecamatan_id" => $kasus['13'],
                    "kelurahan_id" => $kasus['14'],
                    "alamat" => $kasus['15'],
                    "created_by" => $kasus['16'],
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                    "deleted_at" => NULL,
                ]);    
            }
            $firstline = false;
        }
        fclose($csvFile);

        //data pelapor
        // $pelapor = [
        //     [
        //         "uuid" => "178e7zdb-f845-4abb-966b-4b727f3a1a2e",
        //         "kasus_id" => 1,
        //         "nik" => '3213029381729001',
        //         "nama" => 'Kartini',
        //         "tempat_lahir" => 'Jakarta',
        //         "tanggal_lahir" => '1984-09-07',
        //         "provinsi_id_ktp" => 31,
        //         "kotkab_id_ktp" => 3172,
        //         "kecamatan_id_ktp" => 317204,
        //         "kelurahan_id_ktp" => 3172041003,
        //         "alamat_ktp" => 'Jl. Mawar No. 9',
        //         "provinsi_id" => 31,
        //         "kotkab_id" => 3172,
        //         "kecamatan_id" => 317204,
        //         "kelurahan_id" => 3172041003,
        //         "alamat" => 'Jl. Melati No. 10',
        //         "agama" => 'Islam',
        //         "no_telp" => '082718221238',
        //         "status_kawin" => NULL,
        //         "pekerjaan" => NULL,
        //         "kewarganegaraan" => NULL,
        //         "status_pendidikan" => NULL,
        //         "pendidikan" => NULL,
        //         "desil" => NULL,
        //         "created_by" => 1,
        //         "created_at" => Carbon::now(),
        //         "updated_at" => Carbon::now(),
        //         "deleted_at" => NULL
        //     ],
        //     [
        //         "uuid" => "178e7zdb-a845-4abb-966b-4b727f3a1a2e",
        //         "kasus_id" => 2,
        //         "nik" => '3213029381729001',
        //         "nama" => 'Sunarti',
        //         "tempat_lahir" => 'Jakarta',
        //         "tanggal_lahir" => '1994-09-07',
        //         "provinsi_id_ktp" => 31,
        //         "kotkab_id_ktp" => 3172,
        //         "kecamatan_id_ktp" => 317204,
        //         "kelurahan_id_ktp" => 3172041003,
        //         "alamat_ktp" => 'Jl. Mawar No. 9',
        //         "provinsi_id" => 31,
        //         "kotkab_id" => 3172,
        //         "kecamatan_id" => 317204,
        //         "kelurahan_id" => 3172041003,
        //         "alamat" => 'Jl. Melati No. 10',
        //         "agama" => 'Islam',
        //         "no_telp" => '082718221238',
        //         "status_kawin" => NULL,
        //         "pekerjaan" => NULL,
        //         "kewarganegaraan" => NULL,
        //         "status_pendidikan" => NULL,
        //         "pendidikan" => NULL,
        //         "desil" => NULL,
        //         "created_by" => 1,
        //         "created_at" => Carbon::now(),
        //         "updated_at" => Carbon::now(),
        //         "deleted_at" => NULL
        //     ],
        //     [
        //         "uuid" => "178e7zdb-a845-4abb-966b-4b727f3a1a2a",
        //         "kasus_id" => 3,
        //         "nik" => '3213029381729001',
        //         "nama" => 'Sumanto',
        //         "tempat_lahir" => 'Jakarta',
        //         "tanggal_lahir" => '1994-09-07',
        //         "provinsi_id_ktp" => 31,
        //         "kotkab_id_ktp" => 3172,
        //         "kecamatan_id_ktp" => 317204,
        //         "kelurahan_id_ktp" => 3172041003,
        //         "alamat_ktp" => 'Jl. Mawar No. 9',
        //         "provinsi_id" => 31,
        //         "kotkab_id" => 3172,
        //         "kecamatan_id" => 317204,
        //         "kelurahan_id" => 3172041003,
        //         "alamat" => 'Jl. Melati No. 10',
        //         "agama" => 'Islam',
        //         "no_telp" => '082718221238',
        //         "status_kawin" => NULL,
        //         "pekerjaan" => NULL,
        //         "kewarganegaraan" => NULL,
        //         "status_pendidikan" => NULL,
        //         "pendidikan" => NULL,
        //         "desil" => NULL,
        //         "created_by" => 1,
        //         "created_at" => Carbon::now(),
        //         "updated_at" => Carbon::now(),
        //         "deleted_at" => NULL
        //     ]
        // ];
        // Pelapor::insert($pelapor);
        $csvFile = fopen(base_path("database/data/pelapor.csv"), "r");
        $firstline = true;
        while (($pelapor = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                Pelapor::create([
                    "id" => $pelapor['0'],
                    "uuid" => $pelapor['1'],
                    "kasus_id" => $pelapor['2'],
                    "nik" => $pelapor['3'],
                    "nama" => $pelapor['4'],
                    "tempat_lahir" => $pelapor['5'],
                    "tanggal_lahir" => $pelapor['6'],
                    "perkiraan_tanggal_lahir" => $pelapor['7'],
                    "jenis_kelamin" => $pelapor['8'],
                    "provinsi_id_ktp" => $pelapor['9'],
                    "kotkab_id_ktp" => $pelapor['10'],
                    "kecamatan_id_ktp" => $pelapor['11'],
                    "kelurahan_id_ktp" => $pelapor['12'],
                    "alamat_ktp" => $pelapor['13'],
                    "provinsi_id" => $pelapor['14'],
                    "kotkab_id" => $pelapor['15'],
                    "kecamatan_id" => $pelapor['16'],
                    "kelurahan_id" => $pelapor['17'],
                    "alamat" => $pelapor['18'],
                    "agama" => $pelapor['19'],
                    "status_kawin" => $pelapor['20'],
                    "pekerjaan" => $pelapor['21'],
                    "kewarganegaraan" => $pelapor['22'],
                    "status_pendidikan" => $pelapor['23'],
                    "pendidikan" => $pelapor['24'],
                    "no_telp" => $pelapor['25'],
                    "desil" => $pelapor['26'],
                    "created_by" => $pelapor['27'],
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                    "deleted_at" => NULL,
                ]);    
            }
            $firstline = false;
        }
        fclose($csvFile);

        //data klien
        // $klien = [
        //     [
        //         "uuid" => "456ab15f-1f30-48e1-a5c0-ke39c05a93ab",
        //         "kasus_id" => 1,
        //         "tanggal_approve" => Carbon::now(),
        //         "no_klien" => '001/'.Carbon::now()->format('m').'/'.Carbon::now()->format('Y'),
        //         "status" => 'Pelaksanaan intervensi',
        //         "nik" => '320323219209991',
        //         "nama" => 'Caca Marica Hey Hey',
        //         "tempat_lahir" => 'Surabaya',
        //         "tanggal_lahir" => '1992-11-02',
        //         "jenis_kelamin" => 'perempuan',
        //         "provinsi_id_ktp" => 31,
        //         "kotkab_id_ktp" => 3175,
        //         "kecamatan_id_ktp" => 317506,
        //         "kelurahan_id_ktp" => 9271101004,
        //         "alamat_ktp" => 'JL Kampung Buaran Cakung Timur RT.011 RW.002 Kel. Cakung Timur, Kec. Cakung Jakarta Timur',
        //         "provinsi_id" => 31,
        //         "kotkab_id" => 3175,
        //         "kecamatan_id" => 317506,
        //         "kelurahan_id" => 9271101004,
        //         "alamat" => 'JL Kampung Buaran Cakung Timur RT.011 RW.002 Kel. Cakung Timur, Kec. Cakung Jakarta Timur',
        //         "agama" => 'Islam',
        //         "no_telp" => '082718227738',
        //         "status_kawin" => 'Menikah Resmi',
        //         "pekerjaan" => 'Swasta',
        //         "kewarganegaraan" => 'WNI',
        //         "status_pendidikan" => 'Lulus dan Tidak Melanjutkan (Tamat Belajar)',
        //         "pendidikan" => 'Perguruan Tinggi',
        //         "hubungan_pelapor" => 'Teman',
        //         "desil" => NULL,
        //         "created_by" => 1,
        //         "created_at" => Carbon::now()->subDay(1),
        //         "updated_at" => Carbon::now()->subDay(1),
        //         "deleted_at" => NULL
        //     ],
        //     [
        //         "uuid" => "456ab15f-1f30-48e1-k5c0-je39c05a93ab",
        //         "kasus_id" => 2,
        //         "tanggal_approve" => Carbon::now()->subDays(2),
        //         "no_klien" => '002/'.Carbon::now()->format('m').'/'.Carbon::now()->format('Y'),
        //         "status" => 'Pelaksanaan intervensi',
        //         "nik" => '320323219219991',
        //         "nama" => 'Putri Tidur',
        //         "tempat_lahir" => 'Bandung',
        //         "tanggal_lahir" => '1991-11-02',
        //         "jenis_kelamin" => 'perempuan',
        //         "provinsi_id_ktp" => 31,
        //         "kotkab_id_ktp" => 3174,
        //         "kecamatan_id_ktp" => 317506,
        //         "kelurahan_id_ktp" => 9271101004,
        //         "alamat_ktp" => 'JL Kampung Buaran Cakung Timur RT.011 RW.002 Kel. Cakung Timur, Kec. Cakung Jakarta Timur',
        //         "provinsi_id" => 31,
        //         "kotkab_id" => 3172,
        //         "kecamatan_id" => 317506,
        //         "kelurahan_id" => 9271101004,
        //         "alamat" => 'JL Kampung Buaran Cakung Timur RT.011 RW.002 Kel. Cakung Timur, Kec. Cakung Jakarta Timur',
        //         "agama" => 'Islam',
        //         "no_telp" => '082718227738',
        //         "status_kawin" => 'Menikah Resmi',
        //         "pekerjaan" => 'Swasta',
        //         "kewarganegaraan" => 'WNI',
        //         "status_pendidikan" => 'Lulus dan Tidak Melanjutkan (Tamat Belajar)',
        //         "pendidikan" => 'Perguruan Tinggi',
        //         "hubungan_pelapor" => 'Teman',
        //         "desil" => NULL,
        //         "created_by" => 1,
        //         "created_at" => Carbon::now()->subDay(1),
        //         "updated_at" => Carbon::now()->subDay(1),
        //         "deleted_at" => NULL
        //     ],
        //     [
        //         "uuid" => "451ab15f-1f30-48e1-k5c0-je39c05a93ab",
        //         "kasus_id" => 2,
        //         "tanggal_approve" => Carbon::now()->subDays(2),
        //         "no_klien" => '003/'.Carbon::now()->format('m').'/'.Carbon::now()->format('Y'),
        //         "status" => 'Pelaksanaan intervensi',
        //         "nik" => '310323219219991',
        //         "nama" => 'Nina Bobo',
        //         "tempat_lahir" => 'Bandung',
        //         "tanggal_lahir" => '2019-11-02',
        //         "jenis_kelamin" => 'perempuan',
        //         "provinsi_id_ktp" => 31,
        //         "kotkab_id_ktp" => 3174,
        //         "kecamatan_id_ktp" => 317506,
        //         "kelurahan_id_ktp" => 9271101004,
        //         "alamat_ktp" => 'JL Kampung Buaran Cakung Timur RT.011 RW.002 Kel. Cakung Timur, Kec. Cakung Jakarta Timur',
        //         "provinsi_id" => 31,
        //         "kotkab_id" => 3172,
        //         "kecamatan_id" => 317506,
        //         "kelurahan_id" => 9271101004,
        //         "alamat" => 'JL Kampung Buaran Cakung Timur RT.011 RW.002 Kel. Cakung Timur, Kec. Cakung Jakarta Timur',
        //         "agama" => 'Islam',
        //         "no_telp" => '082718227738',
        //         "status_kawin" => 'Menikah Resmi',
        //         "pekerjaan" => 'Swasta',
        //         "kewarganegaraan" => 'WNI',
        //         "status_pendidikan" => 'Lulus dan Tidak Melanjutkan (Tamat Belajar)',
        //         "pendidikan" => 'Perguruan Tinggi',
        //         "hubungan_pelapor" => 'Teman',
        //         "desil" => NULL,
        //         "created_by" => 1,
        //         "created_at" => Carbon::now()->subDay(1),
        //         "updated_at" => Carbon::now()->subDay(1),
        //         "deleted_at" => NULL
        //     ],
        //     [
        //         "uuid" => "451ab15f-1f30-48e1-k5c0-je39c05a93ab",
        //         "kasus_id" => 3,
        //         "tanggal_approve" => NULL,
        //         "no_klien" => NULL,
        //         "status" => 'Pelaksanaan intervensi',
        //         "nik" => '310313219219991',
        //         "nama" => 'Rudy Tabootie',
        //         "tempat_lahir" => 'Bandung',
        //         "tanggal_lahir" => '2023-11-02',
        //         "jenis_kelamin" => 'laki-laki',
        //         "provinsi_id_ktp" => 31,
        //         "kotkab_id_ktp" => 3171,
        //         "kecamatan_id_ktp" => 317506,
        //         "kelurahan_id_ktp" => 9271101004,
        //         "alamat_ktp" => 'JL Kampung Buaran Cakung Timur RT.011 RW.002 Kel. Cakung Timur, Kec. Cakung Jakarta Timur',
        //         "provinsi_id" => 31,
        //         "kotkab_id" => 3172,
        //         "kecamatan_id" => 317506,
        //         "kelurahan_id" => 9271101004,
        //         "alamat" => 'JL Kampung Buaran Cakung Timur RT.011 RW.002 Kel. Cakung Timur, Kec. Cakung Jakarta Timur',
        //         "agama" => 'Islam',
        //         "no_telp" => '082718227738',
        //         "status_kawin" => 'Menikah Resmi',
        //         "pekerjaan" => 'Swasta',
        //         "kewarganegaraan" => 'WNI',
        //         "status_pendidikan" => 'Lulus dan Tidak Melanjutkan (Tamat Belajar)',
        //         "pendidikan" => 'Perguruan Tinggi',
        //         "hubungan_pelapor" => 'Teman',
        //         "desil" => NULL,
        //         "created_by" => 1,
        //         "created_at" => Carbon::now()->subDay(1),
        //         "updated_at" => Carbon::now()->subDay(1),
        //         "deleted_at" => NULL
        //     ]
        // ];
        // Klien::insert($klien);
        $csvFile = fopen(base_path("database/data/klien.csv"), "r");
        $firstline = true;
        while (($klien = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                Klien::create([
                    "id" => $klien['0'],
                    "uuid" => $klien['1'],
                    "kasus_id" => $klien['2'],
                    "tanggal_approve" => NULL,
                    "urutan" => NULL,
                    "no_klien" => $klien['5'],
                    "status" => $klien['6'],
                    "nik" => $klien['7'],
                    "nama" => $klien['8'],
                    "tempat_lahir" => $klien['9'],
                    "tanggal_lahir" => $klien['10'],
                    "perkiraan_tanggal_lahir" => $klien['11'],
                    "jenis_kelamin" => $klien['12'],
                    "provinsi_id_ktp" => $klien['13'],
                    "kotkab_id_ktp" => $klien['14'],
                    "kecamatan_id_ktp" => $klien['15'],
                    "kelurahan_id_ktp" => $klien['16'],
                    "alamat_ktp" => $klien['17'],
                    "provinsi_id" => $klien['18'],
                    "kotkab_id" => $klien['19'],
                    "kecamatan_id" => $klien['20'],
                    "kelurahan_id" => $klien['21'],
                    "alamat" => $klien['22'],
                    "agama" => $klien['23'],
                    "status_kawin" => $klien['24'],
                    "pekerjaan" => $klien['25'],
                    "kewarganegaraan" => $klien['26'],
                    "status_pendidikan" => $klien['27'],
                    "pendidikan" => $klien['28'],
                    "no_telp" => $klien['29'],
                    "kedisabilitasan" => $klien['30'],
                    "hubungan_pelapor" => $klien['31'],
                    "intervensi_ke" => $klien['32'],
                    "desil" => $klien['33'],
                    "arsip" => $klien['34'],
                    "created_by" => $klien['35'],
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                    "deleted_at" => NULL,
                ]);    
            }
            $firstline = false;
        }
        fclose($csvFile);

        //data terlapor
        // $terlapor = [
        //     [
        //         "uuid" => "178e78d2-f845-4abb-966b-4b727f3a1a2e",
        //         "kasus_id" => 1,
        //         "nik" => '3213029381729001',
        //         "nama" => 'Zoombie',
        //         "tempat_lahir" => 'Bandung',
        //         "tanggal_lahir" => '1992-10-11',
        //         "provinsi_id_ktp" => 31,
        //         "kotkab_id_ktp" => 3175,
        //         "kecamatan_id_ktp" => 317502,
        //         "kelurahan_id_ktp" => 9271101004,
        //         "alamat_ktp" => 'jl. sesama nomor 23',
        //         "provinsi_id" => 31,
        //         "kotkab_id" => 3175,
        //         "kecamatan_id" => 317502,
        //         "kelurahan_id" => 9271101004,
        //         "alamat" => 'jl. sesama nomor 23',
        //         "agama" => 'Islam',
        //         "no_telp" => '082718221238',
        //         "status_kawin" => NULL,
        //         "pekerjaan" => NULL,
        //         "kewarganegaraan" => NULL,
        //         "status_pendidikan" => NULL,
        //         "pendidikan" => NULL,
        //         "desil" => NULL,
        //         "created_by" => 1,
        //         "created_at" => Carbon::now(),
        //         "updated_at" => Carbon::now(),
        //         "deleted_at" => NULL
        //     ],
        //     [
        //         "uuid" => "178e78d2-f845-4abb-966b-4b727f3a1a2e",
        //         "kasus_id" => 2,
        //         "nik" => '3213029381729001',
        //         "nama" => 'Putin Millenix',
        //         "tempat_lahir" => 'Bandung',
        //         "tanggal_lahir" => '1992-10-11',
        //         "provinsi_id_ktp" => 31,
        //         "kotkab_id_ktp" => 3175,
        //         "kecamatan_id_ktp" => 317502,
        //         "kelurahan_id_ktp" => 9271101004,
        //         "alamat_ktp" => 'jl. sesama nomor 23',
        //         "provinsi_id" => 31,
        //         "kotkab_id" => 3175,
        //         "kecamatan_id" => 317502,
        //         "kelurahan_id" => 9271101004,
        //         "alamat" => 'jl. sesama nomor 23',
        //         "agama" => 'Islam',
        //         "no_telp" => '082718221238',
        //         "status_kawin" => NULL,
        //         "pekerjaan" => NULL,
        //         "kewarganegaraan" => NULL,
        //         "status_pendidikan" => NULL,
        //         "pendidikan" => NULL,
        //         "desil" => NULL,
        //         "created_by" => 1,
        //         "created_at" => Carbon::now(),
        //         "updated_at" => Carbon::now(),
        //         "deleted_at" => NULL
        //     ],
        //     [
        //         "uuid" => "178a78d2-f845-4abb-966b-4b727f3a1a2e",
        //         "kasus_id" => 3,
        //         "nik" => '3213029381729001',
        //         "nama" => 'Frankenstein',
        //         "tempat_lahir" => 'Bandung',
        //         "tanggal_lahir" => '1990-10-11',
        //         "provinsi_id_ktp" => 31,
        //         "kotkab_id_ktp" => 3175,
        //         "kecamatan_id_ktp" => 317502,
        //         "kelurahan_id_ktp" => 9271101004,
        //         "alamat_ktp" => 'jl. sesama nomor 23',
        //         "provinsi_id" => 31,
        //         "kotkab_id" => 3175,
        //         "kecamatan_id" => 317502,
        //         "kelurahan_id" => 9271101004,
        //         "alamat" => 'jl. sesama nomor 23',
        //         "agama" => 'Islam',
        //         "no_telp" => '082718221238',
        //         "status_kawin" => NULL,
        //         "pekerjaan" => NULL,
        //         "kewarganegaraan" => NULL,
        //         "status_pendidikan" => NULL,
        //         "pendidikan" => NULL,
        //         "desil" => NULL,
        //         "created_by" => 1,
        //         "created_at" => Carbon::now(),
        //         "updated_at" => Carbon::now(),
        //         "deleted_at" => NULL
        //     ]
        // ];
        // Terlapor::insert($terlapor);
        $csvFile = fopen(base_path("database/data/terlapor.csv"), "r");
        $firstline = true;
        while (($terlapor = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                Terlapor::create([
                    "id" => $terlapor['0'],
                    "uuid" => $terlapor['1'],
                    "kasus_id" => $terlapor['2'],
                    "nik" => $terlapor['3'],
                    "nama" => $terlapor['4'],
                    "tempat_lahir" => $terlapor['5'],
                    "tanggal_lahir" => $terlapor['6'],
                    "perkiraan_tanggal_lahir" => $terlapor['7'],
                    "jenis_kelamin" => $terlapor['8'],
                    "provinsi_id_ktp" => $terlapor['9'],
                    "kotkab_id_ktp" => $terlapor['10'],
                    "kecamatan_id_ktp" => $terlapor['11'],
                    "kelurahan_id_ktp" => $terlapor['12'],
                    "alamat_ktp" => $terlapor['13'],
                    "provinsi_id" => $terlapor['14'],
                    "kotkab_id" => $terlapor['15'],
                    "kecamatan_id" => $terlapor['16'],
                    "kelurahan_id" => $terlapor['17'],
                    "alamat" => $terlapor['18'],
                    "agama" => $terlapor['19'],
                    "status_kawin" => $terlapor['20'],
                    "pekerjaan" => $terlapor['21'],
                    "kewarganegaraan" => $terlapor['22'],
                    "status_pendidikan" => $terlapor['23'],
                    "pendidikan" => $terlapor['24'],
                    "no_telp" => $terlapor['25'],
                    "desil" => $terlapor['26'],
                    "created_by" => $terlapor['27'],
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                    "deleted_at" => NULL,
                ]);    
            }
            $firstline = false;
        }
        fclose($csvFile);

        //data petugas
        // $petugas = [
        //     [
        //         "klien_id" => 1,
        //         "user_id" => 1,
        //         "created_by" => 1,
        //         "created_at" => Carbon::now(),
        //         "updated_at" => Carbon::now()->addDays(5),
        //         "deleted_at" => NULL
        //     ],
        //     [
        //         "klien_id" => 2,
        //         "user_id" => 1,
        //         "created_by" => 1,
        //         "created_at" => Carbon::now(),
        //         "updated_at" => Carbon::now()->addDays(5),
        //         "deleted_at" => NULL
        //     ],
        //     [
        //         "klien_id" => 1,
        //         "user_id" => 8,
        //         "created_by" => 1,
        //         "created_at" => Carbon::now(),
        //         "updated_at" => Carbon::now()->addDays(5),
        //         "deleted_at" => NULL
        //     ],
        //     [
        //         "klien_id" => 1,
        //         "user_id" => 2,
        //         "created_by" => 1,
        //         "created_at" => Carbon::now(),
        //         "updated_at" => Carbon::now()->addDays(5),
        //         "deleted_at" => NULL
        //     ],
        //     [
        //         "klien_id" =>1,
        //         "user_id" => 4,
        //         "created_by" => 1,
        //         "created_at" => Carbon::now(),
        //         "updated_at" => Carbon::now()->addDays(5),
        //         "deleted_at" => NULL
        //     ],
        //     [
        //         "klien_id" =>1,
        //         "user_id" => 5,
        //         "created_by" => 1,
        //         "created_at" => Carbon::now(),
        //         "updated_at" => Carbon::now()->addDays(5),
        //         "deleted_at" => NULL
        //     ],
        //     [
        //         "klien_id" =>1,
        //         "user_id" => 3,
        //         "created_by" => 1,
        //         "created_at" => Carbon::now(),
        //         "updated_at" => Carbon::now()->addDays(5),
        //         "deleted_at" => NULL
        //     ]
        //     // DATA UNTUK UJI COBA GRAFIK, DAPAT DIDISABLED NANTI,
        //     ,[
        //         "klien_id" => 4,
        //         "user_id" => 3,
        //         "created_by" => 1,
        //         "created_at" => Carbon::now(),
        //         "updated_at" => Carbon::now()->addDays(5),
        //         "deleted_at" => NULL
        //     ],
        //     [
        //         "klien_id" => 4,
        //         "user_id" => 2,
        //         "created_by" => 1,
        //         "created_at" => Carbon::now(),
        //         "updated_at" => Carbon::now()->addDays(5),
        //         "deleted_at" => NULL
        //     ],
        //     [
        //         "klien_id" => 4,
        //         "user_id" => 8,
        //         "created_by" => 1,
        //         "created_at" => Carbon::now(),
        //         "updated_at" => Carbon::now()->addDays(5),
        //         "deleted_at" => NULL
        //     ],
        //     [
        //         "klien_id" => 4,
        //         "user_id" => 1,
        //         "created_by" => 1,
        //         "created_at" => Carbon::now(),
        //         "updated_at" => Carbon::now()->addDays(5),
        //         "deleted_at" => NULL
        //     ],
        //     [
        //         "klien_id" => 3,
        //         "user_id" => 1,
        //         "created_by" => 1,
        //         "created_at" => Carbon::now(),
        //         "updated_at" => Carbon::now()->addDays(5),
        //         "deleted_at" => NULL
        //     ],
        //     [
        //         "klien_id" => 3,
        //         "user_id" => 2,
        //         "created_by" => 1,
        //         "created_at" => Carbon::now(),
        //         "updated_at" => Carbon::now()->addDays(5),
        //         "deleted_at" => NULL
        //     ],
        //     [
        //         "klien_id" => 3,
        //         "user_id" => 3,
        //         "created_by" => 1,
        //         "created_at" => Carbon::now(),
        //         "updated_at" => Carbon::now()->addDays(5),
        //         "deleted_at" => NULL
        //     ]
        // ];
        // Petugas::insert($petugas);
        $csvFile = fopen(base_path("database/data/petugas.csv"), "r");
        $firstline = true;
        while (($petugas = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                Petugas::create([
                    "id" => $petugas['0'],
                    "klien_id" => $petugas['1'],
                    "user_id" => $petugas['2'],
                    "created_by" => $petugas['3'],
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                    "deleted_at" => NULL,
                ]);    
            }
            $firstline = false;
        }
        fclose($csvFile);

        //data Relasi Kategori kasus, Jenis Kekerasan dan Bentuk Kekerasan 
        $csvFile = fopen(base_path("database/data/r_kategori_jenis_bentuk.csv"), "r");
        $firstline = true;
        while (($r_kategori_jenis_bentuk = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                RKategoriJenisBentuk::create([
                    "id" => $r_kategori_jenis_bentuk['0'],
                    "kategori_kasus_kode" => $r_kategori_jenis_bentuk['1'],
                    "jenis_kekerasan_kode" => $r_kategori_jenis_bentuk['2'],
                    "bentuk_kekerasan_kode" => $r_kategori_jenis_bentuk['3'],
                    "created_by" => $r_kategori_jenis_bentuk['4'],
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                    "deleted_at" => NULL,
                ]);    
            }
            $firstline = false;
        }
        fclose($csvFile);
        // $r_kategori_jenis_bentuk = [
        //     [
        //         "kategori_kasus_kode" => 100,
        //         "jenis_kekerasan_kode" => 100,
        //         "bentuk_kekerasan_kode" => 100,
        //     ],
        //     [
        //         "kategori_kasus_kode" => 100,
        //         "jenis_kekerasan_kode" => 100,
        //         "bentuk_kekerasan_kode" => 102,
        //     ],
        //     [
        //         "kategori_kasus_kode" => 101,
        //         "jenis_kekerasan_kode" => 101,
        //         "bentuk_kekerasan_kode" => 103,
        //     ],
        // ];
        // RKategoriJenisBentuk::insert($r_kategori_jenis_bentuk);

        //data Master Kategori kasus
        $csvFile = fopen(base_path("database/data/m_kategori_kasus.csv"), "r");
        $firstline = true;
        while (($m_kategori_kasus = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                MKategoriKasus::create([
                    "id" => $m_kategori_kasus['0'],
                    "uuid" => $m_kategori_kasus['1'],
                    "kode" => $m_kategori_kasus['2'],
                    "nama" => $m_kategori_kasus['3'],
                    "usia" => $m_kategori_kasus['4'],
                    "jenis_kelamin" => $m_kategori_kasus['5'],
                    "terlapor" => $m_kategori_kasus['6'],
                    "lokasi" => $m_kategori_kasus['7'],
                    "definisi" => $m_kategori_kasus['8'],
                    "dasar_hukum" => $m_kategori_kasus['9'],
                    "created_by" => $m_kategori_kasus['10'],
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                    "deleted_at" => NULL,
                ]);    
            }
            $firstline = false;
        }
        fclose($csvFile);
        // $m_kategori_kasus = [
            // [
            //     "uuid" => '43a348be-9112-42f5-b537-f095fc5111cd',
            //     "kode" => 100,
            //     "nama" => 'Perempuan Korban Kekerasan Fisik',
            //     "usia" => 'dewasa',
            //     "jenis_kelamin" => 'semua',
            //     "terlapor" => '["Teman", "Ibu Kandung"]',
            //     "lokasi" => NULL, // '["miChat"]'
            //     "definisi" => 'Perempuan Korban Kekerasan Fisik adalah perempuan yang berusia 18 tahun bla bla bla bla', 
            //     "dasar_hukum" => '["UU TPKS"]'
            // ],
            // [
            //     "uuid" => '43a348be-9112-42f5-b517-f095fc5111cd',
            //     "kode" => 101,
            //     "nama" => 'Anak Korban Kekerasan Psikis',
            //     "usia" => 'anak',
            //     "jenis_kelamin" => 'semua',
            //     "terlapor" => '["Teman", "Ibu Kandung"]',
            //     "lokasi" => null, // '["miChat"]'
            //     "definisi" => 'Anak Korban Kekerasan Psikis adalah anak yang berusia dibawah 18 tahun bla bla bla bla', 
            //     "dasar_hukum" => '["UU TPKS"]'
            // ]
        // ];
        // MKategoriKasus::insert($m_kategori_kasus);

        //data Master Jenis Kekerasan
        $csvFile = fopen(base_path("database/data/m_jenis_kekerasan.csv"), "r");
        $firstline = true;
        while (($m_jenis_kekerasan = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                MJenisKekerasan::create([
                    "id" => $m_jenis_kekerasan['0'],
                    "uuid" => $m_jenis_kekerasan['1'],
                    "kode" => $m_jenis_kekerasan['2'],
                    "nama" => $m_jenis_kekerasan['3'],
                    "created_by" => $m_jenis_kekerasan['4'],
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                    "deleted_at" => NULL,
                ]);    
            }
            $firstline = false;
        }
        fclose($csvFile);
        // $m_jenis_kekerasan = [
        //     [
        //         "uuid" => '43a341be-9112-42f5-b537-f095fc5111cd',
        //         "kode" => 100,
        //         "nama" => "Kekerasan Fisik"
        //     ],
        //     [
        //         "uuid" => '43a548be-9112-42f5-b537-f095fc5111cd',
        //         "kode" => 101,
        //         "nama" => "Kekerasan Psikis"
        //     ],
        //     [
        //         "uuid" => '43a344be-9112-42f5-b537-f095fc5111cd',
        //         "kode" => 102,
        //         "nama" => "Kekerasan Seksual"
        //     ],
        //     [
        //         "uuid" => '43a648be-9112-42f5-b537-f095fc5111cd',
        //         "kode" => 103,
        //         "nama" => "Eksploitasi"
        //     ],
        //     [
        //         "uuid" => '44a348be-9112-42f5-b537-f095fc5111cd',
        //         "kode" => 104,
        //         "nama" => "Penelantaran"
        //     ],
        //     [
        //         "uuid" => '43a348be-9612-42f5-b537-f095fc5111cd',
        //         "kode" => 105,
        //         "nama" => "Tidak Diketahui"
        //     ]
        // ];
        // MJenisKekerasan::insert($m_jenis_kekerasan);

        //data Master Bentuk Kekerasan
        $csvFile = fopen(base_path("database/data/m_bentuk_kekerasan.csv"), "r");
        $firstline = true;
        while (($m_bentuk_kekerasan = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                MBentukKekerasan::create([
                    "id" => $m_bentuk_kekerasan['0'],
                    "uuid" => $m_bentuk_kekerasan['1'],
                    "kode" => $m_bentuk_kekerasan['2'],
                    "jenis_kekerasan_kode" => $m_bentuk_kekerasan['3'],
                    "nama" => $m_bentuk_kekerasan['4'],
                    "created_by" => $m_bentuk_kekerasan['5'],
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                    "deleted_at" => NULL,
                ]);    
            }
            $firstline = false;
        }
        fclose($csvFile);
        // $m_bentuk_kekerasan = [
            // [
            //     "uuid" => '43a148be-9112-42f5-b537-f095fc5111cd',
            //     "kode" => 100,
            //     "jenis_kekerasan_kode" => 100,
            //     "nama" => 'Ditonjok',
            // ],
            // [
            //     "uuid" => '43a346be-9112-42f5-b537-f095fc5111cd',
            //     "kode" => 101,
            //     "jenis_kekerasan_kode" => 100,
            //     "nama" => 'Ditendang',
            // ],
            // [
            //     "uuid" => '43a342be-9112-42f5-b537-f095fc5111cd',
            //     "kode" => 102,
            //     "jenis_kekerasan_kode" => 100,
            //     "nama" => 'Dipukul dengan benda',
            // ],
            // [
            //     "uuid" => '43a348se-9112-42f5-b537-f095fc5111cd',
            //     "kode" => 103,
            //     "jenis_kekerasan_kode" => 101,
            //     "nama" => 'Direndahkan',
            // ],
            // [
            //     "uuid" => '43l348be-9112-42f5-b537-f095fc5111cd',
            //     "kode" => 104,
            //     "jenis_kekerasan_kode" => 101,
            //     "nama" => 'Diancam/ Diintimidasi',
            // ],
            // [
            //     "uuid" => '43a358be-9112-42f5-b537-f095fc5111cd',
            //     "kode" => 105,
            //     "jenis_kekerasan_kode" => 101,
            //     "nama" => 'Dihina',
            // ],
            // [
            //     "uuid" => '48a348be-9112-42f5-b537-f095fc5111cd',
            //     "kode" => 106,
            //     "jenis_kekerasan_kode" => 102,
            //     "nama" => 'Dipegang',
            // ],
            // [
            //     "uuid" => '43a348be-9112-42f5-b537-f095fc5111cd',
            //     "kode" => 107,
            //     "jenis_kekerasan_kode" => 102,
            //     "nama" => 'Dicolek',
            // ],
            // [
            //     "uuid" => '43c348be-9112-42f5-b537-f095fc5111cd',
            //     "kode" => 108,
            //     "jenis_kekerasan_kode" => 102,
            //     "nama" => 'Disenggol',
            // ],
            // [
            //     "uuid" => '43a348be-9112-42f5-b537-f095fc5111fd',
            //     "kode" => 109,
            //     "jenis_kekerasan_kode" => 102,
            //     "nama" => 'Diraba',
            // ],
            // [
            //     "uuid" => '43a342be-9112-42f5-b537-f095fc5111cd',
            //     "kode" => 110,
            //     "jenis_kekerasan_kode" => 103,
            //     "nama" => 'Dipaksa melakukan pelacurann / prostitusi',
            // ],
            // [
            //     "uuid" => '43h348be-9112-42f5-b537-f095fc5111cd',
            //     "kode" => 111,
            //     "jenis_kekerasan_kode" => 103,
            //     "nama" => 'Dipaksa melakukan aktivitas pornografi',
            // ],
            // [
            //     "uuid" => '43a378be-9112-42f5-b537-f095fc5111cd',
            //     "kode" => 112,
            //     "jenis_kekerasan_kode" => 104,
            //     "nama" => 'Tidak dipenuhi kebutuhan dasar',
            // ],
            // [
            //     "uuid" => '43a348bk-9112-42f5-b537-f095fc5111cd',
            //     "kode" => 113,
            //     "jenis_kekerasan_kode" => 104,
            //     "nama" => 'Dibatasi dan/atau dilarang beraktivitas',
            // ],
            // [
            //     "uuid" => '43l348be-9112-42f5-b537-f095fc5111cd',
            //     "kode" => 114,
            //     "jenis_kekerasan_kode" => 105,
            //     "nama" => 'Prihal Hak asuh anak',
            // ]
        // ];
        // MBentukKekerasan::insert($m_bentuk_kekerasan);

        //data Kategori kasus
        // $kategori_kasus = [
        //     [
        //         "klien_id" => 1,
        //         "value" => 'KTP'
        //     ],
        //     [
        //         "klien_id" => 1,
        //         "value" => 'KDRT'
        //     ],
        //     [
        //         "klien_id" => 2,
        //         "value" => 'KTA'
        //     ],
        //     [
        //         "klien_id" => 2,
        //         "value" => 'KDRT'
        //     ],
        //     [
        //         "klien_id" => 3,
        //         "value" => 'KTA'
        //     ],
        //     [
        //         "klien_id" => 3,
        //         "value" => 'KDRT'
        //     ]
        // ];
        // TKategoriKasus::insert($kategori_kasus);

        //data Master Bentuk Kekerasan
        $csvFile = fopen(base_path("database/data/t_jenis_kekerasan.csv"), "r");
        $firstline = true;
        while (($t_jenis_kekerasan = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                TJenisKekerasan::create([
                    "id" => $t_jenis_kekerasan['0'],
                    "klien_id" => $t_jenis_kekerasan['1'],
                    "value" => $t_jenis_kekerasan['2'],
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                ]);    
            }
            $firstline = false;
        }
        fclose($csvFile);

        //data bentuk kekerasan
        // $bentuk_kekerasan = [
        //     [
        //         "klien_id" => 1,
        //         "value" => 'ini nanti diupdate lagi yaaaaa'
        //     ],
        //     [
        //         "klien_id" => 2,
        //         "value" => 'ini nanti diupdate lagi yaaaaa'
        //     ],
        //     [
        //         "klien_id" => 3,
        //         "value" => 'ini nanti diupdate lagi yaaaaa'
        //     ]
        // ];
        // TBentukKekerasan::insert($bentuk_kekerasan);

        //data program pemerintah
        // $program_pemerintah = [
        //     [
        //         "klien_id" => 1,
        //         "value" => 'KIS / BPJS'
        //     ],
        //     [
        //         "klien_id" => 2,
        //         "value" => 'KJP'
        //     ]
        //     // DATA UNTUK UJI COBA GRAFIK, DAPAT DIDISABLED NANTI,
        //     ,[
        //         "klien_id" => 4,
        //         "value" => 'Sembako Murah'
        //     ],[
        //         "klien_id" => 5,
        //         "value" => 'Sembako Murah'
        //     ],[
        //         "klien_id" => 6,
        //         "value" => 'Sembako Murah'
        //     ],[
        //         "klien_id" => 7,
        //         "value" => 'Sembako Murah'
        //     ]
        // ];
        // TProgramPemerintah::insert($program_pemerintah);

        //data kondisi khusus
        // $t_kedaruratan = [
        //     [
        //         "klien_id" => 1,
        //         "value" => 'Nikah siri'
        //     ],
        //     [
        //         "klien_id" => 1,
        //         "value" => 'Proses persidangan sudah berjalan'
        //     ]
        // ];
        // TKedaruratan::insert($t_kedaruratan);

        //data difable type
        // $t_tipe_disabilitas = [
        //     [
        //         "klien_id" => 1,
        //         "value" => 'Depresi'
        //     ]
        // ];
        // TTipeDisabilitas::insert($t_tipe_disabilitas);

        //data pasal
        // $pasal = [
        //     [
        //         "klien_id" => 1,
        //         "value" => 'UNDANG-UNDANG REPUBLIK INDONESIA NOMOR 12 TAHUN 2022 TENTANG TINDAK PIDANA KEKERASAN SEKSUAL'
        //     ],
        //     [
        //         "klien_id" => 2,
        //         "value" => 'UNDANG-UNDANG REPUBLIK INDONESIA NOMOR 12 TAHUN 2022 TENTANG TINDAK PIDANA KEKERASAN SEKSUAL'
        //     ]
        // ];
        // TPasal::insert($pasal);

        $persetujuan_template = [
            [
                "uuid" => '2a83d123-3c86-41f8-aee1-ca22l222f462',
                "kategori" => 'persetujuan data',
                "judul" => 'SURAT PERSETUJUAN DATA / VERIFIKASI DATA',
                "konten" => 'Saya yang bertanda tangan dibawah ini menyatakan bahwa data yang saya laporkan dan bersifat rahasia adalah benar adanya',
                "created_by" => 1
            ],
            [
                "uuid" => '2a83d123-3c86-41f8-aee1-ca22l262f462',
                "kategori" => 'persetujuan pelayanan',
                "judul" => 'SURAT PERNYATAAN PERSETUJUAN',
                "konten" => '1. Saya yang bertandatangan dibawah ini setuju / tidak setuju untuk melakukan penanganan atas diri saya / anak keluarga saya : ',
                "created_by" => 1
            ],
            [
                "uuid" => '5a83d123-3c86-41f8-aee1-ca22l262f462',
                "kategori" => 'persetujuan terminasi',
                "judul" => 'SURAT PERSETUJUAN TERMINASI (Untuk Kasus Ditutup)',
                "konten" => 'Saya yang bertandatangan dibawah ini menyatakan setuju untuk terminasi kasus',
                "created_by" => 1
            ],
            [
                "uuid" => '5a83da23-3c86-41f8-ae00-ca22l262f462',
                "kategori" => 'persetujuan rps',
                "judul" => 'SURAT PENERIMAAN AKSES PELAYANAN RUMAH PERLINDUNGAN SEMENTARA (RPS)',
                "konten" => '1. Yang bertanda tangan di bawah atas diri saya/anak keluarga saya : ',
                "created_by" => 1
            ],
            [
                "uuid" => '5a83do23-3c86-41f8-ae00-ca22l262f464',
                "kategori" => 'persetujuan rps',
                "judul" => 'SURAT PENGHENTIAN AKSES PELAYANAN RUMAH PERLINDUNGAN SEMENTARA (RPS)',
                "konten" => '1. Yang bertanda tangan di bawah atas diri saya/anak keluarga saya : ',
                "created_by" => 1
            ]
        ];
        PersetujuanTemplate::insert($persetujuan_template);

        //data persetujuan isi
        // $persetujuan_isi = [
        //     [
        //         "uuid" => 'ac162ab3-b1ce-4720-813f-3ed5621f33e0',
        //         "klien_id" => 1,
        //         "persetujuan_template_id" => 1,
        //         "no_telp" => NULL,
        //         "alamat" => NULL,
        //         "isi" => NULL,
        //         "catatan" => NULL,
        //         "tandatangan" => '652659cd9be41.png',
        //         "nama_penandatangan" => 'Caca Marica Hey Hey',
        //         "created_by" => 1,
        //         "created_at" => Carbon::now(),
        //         "updated_at" => Carbon::now()
        //     ],
        //     [
        //         "uuid" => '4daea20b-a1ab-4b8c-8ffa-49cfb06b92b0',
        //         "klien_id" => 2,
        //         "persetujuan_template_id" => 1,
        //         "no_telp" => NULL,
        //         "alamat" => NULL,
        //         "isi" => NULL,
        //         "catatan" => NULL,
        //         "tandatangan" => '652659cdda0f8.png',
        //         "nama_penandatangan" => 'Caca Marica Hey Hey',
        //         "created_by" => 1,
        //         "created_at" => Carbon::now(),
        //         "updated_at" => Carbon::now()
        //     ],
        //     [
        //         "uuid" => 'bf4aa69d-e0f7-4f5c-a7c7-94468bb58d83',
        //         "klien_id" => 1,
        //         "persetujuan_template_id" => 2,
        //         "no_telp" => '082718227738',
        //         "alamat" => 'JL Kampung Buaran Cakung Timur RT.011 RW.002 Kel. Cakung Timur, Kec. Cakung Jakarta Timur',
        //         "isi" => '{"setuju":[4,5,6,7,8,9,10,11,12,13,14,15],"tidak_setuju":[]}',
        //         "catatan" => NULL,
        //         "tandatangan" => '65265d255a475.png',
        //         "nama_penandatangan" => 'Caca Marica Hey Hey',
        //         "created_by" => 1,
        //         "created_at" => Carbon::now(),
        //         "updated_at" => Carbon::now()
        //     ],
        //     [
        //         "uuid" => '3f3f55cf-8690-4310-a070-4ded0876d775',
        //         "klien_id" => 3,
        //         "persetujuan_template_id" => 1,
        //         "no_telp" => NULL,
        //         "alamat" => NULL,
        //         "isi" => NULL,
        //         "catatan" => NULL,
        //         "tandatangan" => '6527a1a4eb826.png',
        //         "nama_penandatangan" => 'Sidney Queensland Millenix',
        //         "created_by" => NULL,
        //         "created_at" => Carbon::now(),
        //         "updated_at" => Carbon::now()
        //     ]
        // ];
        // PersetujuanIsi::insert($persetujuan_isi);

        //data persetujuan item
        $persetujuan_item = [
            [
                "uuid" => 'd54ff227-0372-4156-afcf-0ac4dd71ac57',
                "persetujuan_template_id" => 2,
                "parent_id" => 0,
                "item" => '2.  Telah mendapat penjelasan tentang tujuan, manfaat dan Langkah-langkah penanganan dari Pusat Perlindungan Perempuan dan Anak Provinsi DKI Jakarta',
                "fillable" => 0,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5)
            ],
            [
                "uuid" => 'd24ff727-0372-4156-afcf-0ac4dd71ac57',
                "persetujuan_template_id" => 2,
                "parent_id" => 0,
                "item" => '3. Telah mengisi dan memahami pernyataan berikut:',
                "fillable" => 0,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5)
            ],
            [
                "uuid" => '254ff727-0372-4156-afcf-0ac4dd71ac57',
                "persetujuan_template_id" => 2,
                "parent_id" => 2,
                "item" => 'A. Saya bersedia mendapatkan penanganan dari Pusat Perlindungan Perempuan dan Anak Provinsi DKI Jakarta berupa layanan',
                "fillable" => 0,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5)
            ],
            [
                "uuid" => '754ff727-0372-4156-afcf-0ac4dd71ac57',
                "persetujuan_template_id" => 2,
                "parent_id" => 3,
                "item" => '- Penerimaan Pengaduan dan Informasi',
                "fillable" => 1,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5)
            ],
            [
                "uuid" => 'd54ff727-0372-4156-afcf-0ac4dd71ac57',
                "persetujuan_template_id" => 2,
                "parent_id" => 3,
                "item" => '- Psikologis (Konseling, Pemeriksaan, Terapi, dsb)',
                "fillable" => 1,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5)
            ],
            [
                "uuid" => '254ff727-0372-4156-afcf-0ac4dd71ac57',
                "persetujuan_template_id" => 2,
                "parent_id" => 3,
                "item" => '- Hukum (Konsultasi, Pendampingan Kepolisian, Pendampingan Kepolisian, Mediasi, dsb)',
                "fillable" => 1,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5)
            ],
            [
                "uuid" => '454ff727-0372-4156-afcf-0ac4dd71ac57',
                "persetujuan_template_id" => 2,
                "parent_id" => 3,
                "item" => '- Sosial (Home visit, school visit, pemulangan / reintegrasi, dsb)',
                "fillable" => 1,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5)
            ],
            [
                "uuid" => 'f54ff727-0372-4156-afcf-0ac4dd71ac57',
                "persetujuan_template_id" => 2,
                "parent_id" => 3,
                "item" => '- Rujukan',
                "fillable" => 1,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5)
            ],
            [
                "uuid" => '254ff727-0372-4156-afcf-0ac4dd71ac57',
                "persetujuan_template_id" => 2,
                "parent_id" => 2,
                "item" => 'B. Saya bersedia mengikuti prosedur dan bekerja sama dengan memberikan informasi tentang saya, anak, keluarga saya, atau pihak lain yang terkait dengan masalah yang saya / anak saya alami',
                "fillable" => 1,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5)
            ],
            [
                "uuid" => '454ff727-0372-4156-afcf-0ac4dd71ac57',
                "persetujuan_template_id" => 2,
                "parent_id" => 2,
                "item" => 'C. Saya bersedia bekerja sama dengan Pusat Perlindungan Perempuan dan Anak Provinsi DKI Jakarta dalam penanganan kasus berupa pemberian informasi / keterangan dari saya atau pihak lain yang termasuk jika diperlukan',
                "fillable" => 1,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5)
            ],
            [
                "uuid" => 'g54ff727-0372-4156-afcf-0ac4dd71ac57',
                "persetujuan_template_id" => 2,
                "parent_id" => 2,
                "item" => 'D. Saya mengijinkan Tim Pelayanan untuk mencatat, merekam dan menuliskan dalam laporan semua informasi yang telah say a, anak saya atau keluarga saya berikan tentang selulita/masayah yang dialami',
                "fillable" => 1,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5)
            ],
            [
                "uuid" => 'l54ff727-0372-4156-afcf-0ac4dd71ac57',
                "persetujuan_template_id" => 2,
                "parent_id" => 2,
                "item" => 'E. Saya bersedia apabila dari Pusat Perlindungan Perempuan dan Anak Provinsi DKI Jakarta meminta bantuan pada pihak lain, termasuk jika mereka membutuhkan Informasi terkait kasus yang sedang dijalani',
                "fillable" => 1,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5)
            ],
            [
                "uuid" => 'p54ff727-0372-4156-afcf-0ac4dd71ac57',
                "persetujuan_template_id" => 2,
                "parent_id" => 2,
                "item" => 'F. Saya menyutujui bahwa dari Pusat Pwelindungan Perempuan dan Anak Provinsi DKI Jakarta dapat mengeluarkan surat pemeriksaan psikologis baik lisan maupun tulisan apabila diminta oleh pihak Penegak Hukum',
                "fillable" => 1,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5)
            ],
            [
                "uuid" => 'x54ff727-0372-4156-afcf-0ac4dd71ac57',
                "persetujuan_template_id" => 2,
                "parent_id" => 2,
                "item" => 'G. Saya bersedia untuk menginformasikan dari Pusat Perlindungan Perempuan dan Anak Provinsi DKI Jakarta apabila saya meminta bantuan dari lembaga lain dan bersedia tidak mendapatkan layanan sejenis dari Pusat Perlindungan Perempuan dan Anak Provinsi DKI Jakarta',
                "fillable" => 1,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5)
            ],
            [
                "uuid" => 'c54ff727-0372-4156-afcf-0ac4dd71ac57',
                "persetujuan_template_id" => 2,
                "parent_id" => 2,
                "item" => 'H. Apabila kesulitan / masalah saya dan keluarga telah dapat diselesaikan maka Tim Pelayanan dari Pusat Perlindungan Perempuan dan Anak Provinsi DKI Jakarta akan menghentikan tugasnya membantu saya',
                "fillable" => 1,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5)
            ],
            [
                "uuid" => 'm54ff727-0372-4156-afcf-0ac4dd71ac57',
                "persetujuan_template_id" => 2,
                "parent_id" => 0,
                "item" => '4. Semua informasi dijaga kerahasiaannya oleh Pusat Perlindungan Perempuan dan Anak Provinsi DKI Jakarta',
                "fillable" => 0,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5)
            ],
            [
                "uuid" => 'm54ff727-0372-4156-afcf-0ac4dd71ac57',
                "persetujuan_template_id" => 2,
                "parent_id" => 0,
                "item" => '5. Demikian surat pernyataan ini dibuat dengan sebenar-benarnya',
                "fillable" => 0,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5)
            ],
            [
                "uuid" => 'd54ff2c7-0372-41a6-afcf-01c4dd71ac57',
                "persetujuan_template_id" => 4,
                "parent_id" => 0,
                "item" => '2. Telah mendapatkan penjelasan tentang tujuan, manfaat, layanan dan tata tertib pelayanan selama berada di Rumah Perlindungan Sementara (RPS) Pusat Perlindungan Perempuan dan Anak (PPPA) Provinsi DKI Jakarta.',
                "fillable" => 0,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5)
            ],
            [
                "uuid" => 'd94fx2c7-0372-41a6-afcf-01c4dd71ac57',
                "persetujuan_template_id" => 4,
                "parent_id" => 0,
                "item" => '3. Telah mengisi dan memahami pernyataan di bawah ini dengan memberikan tanda centang (√) pada kolom setuju atau tidak setuju.',
                "fillable" => 0,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5)
            ],
            [
                "uuid" => 'd94fx2c7-0372-41a6-afcf-01c4dd71ac57',
                "persetujuan_template_id" => 4,
                "parent_id" => 19,
                "item" => 'a. Saya bersedia mendapatkan pendampingan dan tempat perlindungan sementara di RPS.',
                "fillable" => 1,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5)
            ],
            [
                "uuid" => 'd94fx2c7-037l-41a6-afcf-01c4dd71ac57',
                "persetujuan_template_id" => 4,
                "parent_id" => 19,
                "item" => 'b. Saya bersedia mematuhi tata tertib dan prosedur pelayanan di RPS.',
                "fillable" => 1,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5)
            ],
            [
                "uuid" => 'd94fx2c7-0z72-41a6-afcf-01c4dd71ac57',
                "persetujuan_template_id" => 4,
                "parent_id" => 19,
                "item" => 'c. Saya bersedia menjaga kerahasiaan lokasi RPS dari pihak-pihak yang tidak berkepentingan.',
                "fillable" => 1,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5)
            ],
            [
                "uuid" => 'dp4fx2c7-0372-41a6-afcf-01c4dd71lc57',
                "persetujuan_template_id" => 4,
                "parent_id" => 0,
                "item" => '4. Semua informasi dijaga kerahasiaannya oleh PPPA Provinsi DKI Jakarta.',
                "fillable" => 0,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5)
            ],
            [
                "uuid" => 'dp4fx2c7-0372-41a6-afcf-0sc4dd71lc5k',
                "persetujuan_template_id" => 4,
                "parent_id" => 0,
                "item" => '5. Demikian pernyataan ini dibuat dengan sebenar-benarnya.',
                "fillable" => 0,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5)
            ],
            [
                "uuid" => 'dp4px1c7-l37w-41a6-afcf-0kc4ddd1l05k',
                "persetujuan_template_id" => 5,
                "parent_id" => 0,
                "item" => '2. Telah selesai mendapatkan layanan di Rumah Perlindungan Sementara (RPS) Pusat Perlindungan Perempuan dan Anak (PPPA) Provinsi DKI Jakarta.',
                "fillable" => 0,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5)
            ],
            [
                "uuid" => 'dp4px1c7-l37w-41a6-afcf-0kc4ddd1l05k',
                "persetujuan_template_id" => 5,
                "parent_id" => 0,
                "item" => '3. Telah mengisi dan memahami pernyataan di bawah ini dengan memberikan tanda checklist (√) pada kolom setuju atau tidak setuju.',
                "fillable" => 0,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5)
            ],
            [
                "uuid" => 'dp4px1c7-137w-41a6-afcf-0kc4ddd1l0lk',
                "persetujuan_template_id" => 5,
                "parent_id" => 26,
                "item" => 'a. Setelah selesai mengakses pelayanan RPS, saya bersedia mengakses pelayanan rujukan ke Rumah Aman atau lembaga perlindungan lanjutan.',
                "fillable" => 1,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5)
            ],
            [
                "uuid" => 'dp4px1c7-l37w-41a6-afcf-0kc4ddd1l05k',
                "persetujuan_template_id" => 5,
                "parent_id" => 26,
                "item" => 'b. Setelah selesai mengakses pelayanan RPS, saya bersedia mengakses pelayanan pemulangan secara mandiri.',
                "fillable" => 1,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5)
            ],
            [
                "uuid" => 'dp4px1c7-l37w-41ao-afcf-0kckddd1l05k',
                "persetujuan_template_id" => 5,
                "parent_id" => 26,
                "item" => 'c. Setelah selesai mengakses pelayanan RPS, saya bersedia mengakses pelayanan pemulangan dengan dukungan dari keluarga/wali.',
                "fillable" => 1,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5)
            ],
            [
                "uuid" => 'dp4px1cl-l37w-41a6-afcf-0kc4ddd1lz5k',
                "persetujuan_template_id" => 5,
                "parent_id" => 26,
                "item" => 'd. Setelah selesai mengakses pelayanan RPS, saya berkomitmen untuk kooperatif melanjutkan pelayanan yang ada di PPPA Provinsi DKI Jakarta.',
                "fillable" => 1,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5)
            ],
            [
                "uuid" => 'dp4px1c7-l37w-4106-afcf-0kc4ddd1l05k',
                "persetujuan_template_id" => 5,
                "parent_id" => 0,
                "item" => '4. Semua informasi dijaga kerahasiaannya oleh PPPA Provinsi DKI Jakarta.',
                "fillable" => 0,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5)
            ],
            [
                "uuid" => 'dp4px1c7-l37w-41a6-rfcf-0kc4ddd1ls5k',
                "persetujuan_template_id" => 5,
                "parent_id" => 0,
                "item" => '5. Demikian pernyataan ini dibuat dengan sebenar-benarnya.',
                "fillable" => 0,
                "created_by" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()->addDays(5)
            ],
        ];
        PersetujuanItem::insert($persetujuan_item);

        //data agenda
        // $agenda = [
        //     [
        //         "uuid" => '2be785b8-995f-40dc-b826-67ad153a38c7',
        //         "klien_id" => 1,
        //         "judul_kegiatan" => "Review Kasus Caca Marica Hey Hey",
        //         "tanggal_mulai" => Carbon::today(),
        //         "jam_mulai" => '03:00:00',
        //         "keterangan" => 'Melihat kembali kebutuhan klien pada kasus',
        //         "created_by" => 2,
        //         "created_at" => Carbon::now(),
        //         "updated_at" => Carbon::now()
        //     ],
        //     [
        //         "uuid" => '90a67c58-376c-43a7-8d49-8068aae9f4dd',
        //         "klien_id" => 1,
        //         "judul_kegiatan" => "Pengukuran Awal",
        //         "tanggal_mulai" => Carbon::today(),
        //         "jam_mulai" => '02:05:00',
        //         "keterangan" => 'Mk berkoordinasi dengan Psikolog untuk melakukan pengukuran awal',
        //         "created_by" => 1,
        //         "created_at" => Carbon::now(),
        //         "updated_at" => Carbon::now()
        //     ]
        // ];
        // Agenda::insert($agenda);

        //data tindak lanjut
        // $tindak_lanjut = [
        //     [
        //         "uuid" => '2a83d123-3c16-41f8-aee1-ca22b262f462',
        //         "agenda_id" => 1,
        //         "tanggal_selesai" => Carbon::now(),
        //         "jam_selesai" => '10:00:00',
        //         "lokasi" => 'Kantor Pusat PPA DKI Jakarta',
        //         "catatan" => 'hasil koordinasi disepakati tanggal PP1 adalah minggu depan',
        //         "created_by" => 2,
        //         "validated_by" => 2,
        //         "created_at" => Carbon::now(),
        //         "updated_at" => Carbon::now()
        //     ],
        //     [
        //         "uuid" => '2a83d123-3c86-41f8-aee1-ca22b2c2f462',
        //         "agenda_id" => 2,
        //         "tanggal_selesai" => Carbon::now(),
        //         "jam_selesai" => '00:00:00',
        //         "lokasi" => 'Kantor Pusat PPA DKI Jakarta',
        //         "catatan" => 'pemberian tiket sudah dilakukan',
        //         "created_by" => 2,
        //         "validated_by" => 2,
        //         "created_at" => Carbon::now(),
        //         "updated_at" => Carbon::now()
        //     ]
        // ];
        // TindakLanjut::insert($tindak_lanjut);

        //data riwayat kejadian
        // $riwayat_kejadian = [
        //     [
        //         "uuid" => '85b605e5-7e0f-4b0d-bde4-e231175e7e7f',
        //         "klien_id" => 1,
        //         "tanggal" => Carbon::now()->subDays(154),
        //         "jam" => '17:25:00',
        //         "keterangan" => 'Keesokan harinya CM mengkonfirmasi lagi masalah perselingkuhan FV yang ternyata diketahui FV sudah melakukannya sejak 3 tahun. Seketika itu pula CM kembali berkemas dan mengajak putrinya keluar dari rumah. Namun pada saat di teras rumah FV menarik dan menonjok perut CM di depan putrinya.',
        //         "created_by" => 1
        //     ],
        //     [
        //         "uuid" => '11cc4259-1a2f-4f6d-984c-77511dc92860',
        //         "klien_id" => 1,
        //         "tanggal" => Carbon::now()->subDays(155),
        //         "jam" => '11:00:00',
        //         "keterangan" => 'Awal mulanya terjadi perselisihan diantara Caca Marica Hey Hey (CM, 30 tahun) dan Frankenstein Van Houten (FV, 32) karna FV selingkuh, CM memutuskan hendak kabur dari rumah, akan tetapi FV mencegahnya.',
        //         "created_by" => 1
        //     ],
        //     [
        //         "uuid" => 'a6290f38-83e0-41f6-a372-ee1f55418c5e',
        //         "klien_id" => 1,
        //         "tanggal" => Carbon::now()->subDays(153),
        //         "jam" => '03:55:00',
        //         "keterangan" => 'Hingga tanggal 9 Mei, CM dan anaknya berusaha pergi keluar rumah namun tidak berhasil-berhasil. CM dan putrinya semakin sering mendapatkan kekerasan berupa di tampar, di tendang, di colok matanya dan di karate.',
        //         "created_by" => 1
        //     ],
        //     [
        //         "uuid" => 'e842e0d7-e4d7-46ab-a684-ec3637a79e90',
        //         "klien_id" => 1,
        //         "tanggal" => Carbon::now()->subDays(152),
        //         "jam" => '23:10:00',
        //         "keterangan" => 'Klien dan anaknya akhirnya berhasil kabur dari rumah setelah mengendap-endap saat FV tertidur. Namun saat di jalanan FV mengejar dengan motor dan menyerempet CM dan putrinya sampai tersungkur di pinggir jalan. Warga yang melihatnya menghadang FV sehingga CM dan putrinya berhasil kabur.',
        //         "created_by" => 1
        //     ]
            
        // ];
        // RiwayatKejadian::insert($riwayat_kejadian);

        //data asesmen
        // $asesmen = [
        //     [
        //         "uuid" => '4edb3859-729f-4e7f-ae7c-05c7587db723',
        //         "klien_id" => 1,
        //         "fisik" => 'NF memiliki tubuh sedang dan berkulit putih. Pada saat masuk ke dalam ruangan, NF terlihat ramah menyambut kedatangan petugas dan merespon terbuka setiap pertanyaan yang dilontarkan. Sebelum kejadian kekerasan terakhir yang dialami NF, NF sudah pernah mendapatkan beberapa kali kekerasan yang mengakibatkan tulang hidungnya patah akibat dipukul oleh AF. Namun saat ini sudah sembuh dan tidak mengganggu jalan nafas NF sehingga pengobatan tidak dilanjutkan. Kekerasan terakhir yang NF alami, mengakibatkan beberapa keluhan pada tubuhnya yaitu badan menjadi pegal-pegal dan kepalanya sakit karena jambakan AF pada rambutnya. NF juga memiliki bekas jahitan Caesar yang masih basah setelah melahirkan anak keduanya sehingga untuk melakukan aktivitas sehari-hari cukup terbatas.',
        //         "sosial" => 'NF merupakan anak pertama. Kedua orangtuanya telah berpisah sejak NF kelas 2 SD. NF mengungkapkan bahwa pernikahan kedua orangtuanya diakibatkan karena ibu NF hamil diluar nikah. Bapaknya saat ini masih bekerja sebagai pelayar di kapal, sedangkan ibunya setelah NF bekerja sudah tidak lagi bekerja. Sebelum ke Jakarta, NF diketahui juga tinggal di Surabaya dan ketika orangtuanya berpisah NF dirawat oleh kakeknya sedangkan ibunya kerja di luar kota. Sejak masuk ke SMA, NF kemudian ikut tinggal di Jakarta bersama bapak yang mana saat itu sudah menikah kedua kalinya karena ibu NF tidak bisa membiayai sekolah NF. Selain dengan bapaknya, NF juga tinggal bersama ibu tiri dan adik tirinya. NF saat ini bekerja sebagai asisten apoteker di PKC Kelapa Gading. Kebutuhan sehari-harinya ia penuhi dengan gaji yang NF dapatkan dari pekerjaannya. NF juga ikut membantu bisnis angkot Jaklingko bersama ayahnya sehingga hal ini menambah penghasilan NF untuk memenuhi kebutuhan sehari-hari. Setelah kejadian kekerasan terakhir, NF memutuskan untuk berpisah rumah dengan menyewa sebuah kontrakan di dekat rumah saudaranya daerah Penggilingan. NF mengungkapkan juga bahwa setelah berpisah rumah dengan AF, NF merasa kerepotan karena harus mengurusi pekerjaan, ibu dan anaknya, serta bisnisnya secara bersamaan yang pada mulanya bisnis dibantu urus oleh suaminya AF. Sedangkan ibu NF hanya bisa membantu menjaga kedua anaknya namun tidak bisa membantu mengurusi urusan rumah tangga seperti memasak, menyapu, mencuci dll. Ketika NF memiliki permasalahan, NF selalu menceritakan kepada ketiga sahabatnya yang sudah ia kenal sejak SMA dan merupakan rekan kerja di kantor juga.',
        //         "psikologis" => 'Atas kejadian yang NF alami, saat ini NF merasa cemas dan syok karena harus mengurusi rumah, anak, ibu, pekerjaan dan bisnis secara bersamaan. NF mengungkapkan bahwa selama berumah tangga dengan AF, NF cukup bergantung dengan AF sehingga kewalahan ketika harus melakukan aktivitas sehari-hari sendirian. NF juga merasa khawatir atas tumbuh kembang anaknya jika NF dan AF resmi bercerai. Isu perselingkuhan suaminya AF sebelum terjadi kekerasan terakhir juga menjadi salah satu faktor NF menjadi insecure, tidak tenang dan selalu curiga. NF mengungkapkan juga bahwa kekerasan yang dialaminya bukanlah kali pertama namun sudah beberapa kali dan peristiwa kekerasan yang paling membekas dalam hatinya yang NF ingat sebanyak 4 kali. Hingga pada kejadian kekerasan ketiga, NF tidak sanggup dan akhirnya pernah mengajukan gugatan cerai namun karena AF datang meminta maaf maka gugatan perceraian di PA ia cabut.',
        //         "hukum" => 'Belum adanya dampak hukum yang dialami oleh NF atas permasalahan yang dihadapi namun NF berencana mengajukan gugatan perceraian ke Pengadilan Agama.',
        //         "lainnya" => 'Kekerasan yang NF alami dianggap olehnya sebagai ujian kesabaran. NF mengaku bahwa dirinya sebelum menikah dengan AF termasuk orang yang memiliki tingkat keegoisan yang tinggi. Namun setelah mengalami kekerasan dari suaminya AF, NF sudah mampu meredam keegoisannya.',
        //         "upaya" => 'Meminta pertolongan ke warga sekitar dan melaporkan ke CRM',
        //         "pendukung" => 'Memiliki sahabat yang menjadi tempat curhat dan mendukung penyelesaian masalah yang NF lakukan. Ibu NF support dan membantu mencarikan alternatif tempat tinggal untuk NF.',
        //         "hambatan" => 'Kedua orangtua dari AF justru tidak peduli dan membiarkan AF melakukan kekerasan kepada NF',
        //         "harapan" => 'Ingin bercerai dengan AF. Pemulihan kondisi psikologis NF dan anak pertamanya',
        //         "created_by" => 2
        //     ]
        // ];
        // Asesmen::insert($asesmen);
        $csvFile = fopen(base_path("database/data/asesmen.csv"), "r");
        $firstline = true;
        while (($asesmen = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                Asesmen::create([
                    "id" => $asesmen['0'],
                    "uuid" => $asesmen['1'],
                    "klien_id" => $asesmen['2'],
                    "fisik" => NULL,
                    "psikologis" => NULL,
                    "sosial" => NULL,
                    "hukum" => NULL,
                    "upaya" => NULL,
                    "pendukung" => NULL,
                    "hambatan" => NULL,
                    "harapan" => NULL,
                    "lainnya" => NULL,
                    "created_by" => $asesmen['12'],
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                    "deleted_at" => NULL,
                ]);    
            }
            $firstline = false;
        }
        fclose($csvFile);

        //data template
        $csvFile = fopen(base_path("database/data/template.csv"), "r");
        $firstline = true;
        while (($template = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                Template::create([
                    "id" => $template['0'],
                    "uuid" => $template['1'],
                    "nama_template" => $template['2'],
                    "pemilik" => $template['3'],
                    "konten" => $template['4'],
                    "blank_template" => $template['5'],
                    "created_by" => $template['6'],
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                    "deleted_at" => NULL,
                ]);    
            }
            $firstline = false;
        }
        fclose($csvFile);
        // $template = [
        //     [
        //         "uuid" => '8fadf1c2-aa3f-4dd0-a03d-5301a71af7ae',
        //         "nama_template" => 'Review Kasus',
        //         "pemilik" => 'Manajer Kasus',
        //         "konten" => NULL,
        //         "blank_template" => 1,
        //         "created_by" => 2,
        //         "created_at" => Carbon::now(),
        //         "updated_at" => Carbon::now()
        //     ],
        //     [
        //         "uuid" => '66a1wa23-1a16-4sf8-dee1-c322a16sfc62',
        //         "nama_template" => '[F-PSI-01] Form Pemeriksaan Psikologi',
        //         "pemilik" => 'Psikolog',
        //         "konten" => '"<p style=\"text-align: center;\"><img src=\"data:image\/png;base64,iVBORw0KGgoAAAANSUhEUgAAAioAAABiCAIAAADxxm\/MAAAACXBIWXMAAA7EAAAOxAGVKw4bAAAgAElEQVR4nO2dZ1QUSdeAa4YZcs4CkpMKKoIiBgRMIOoSRTEACgoGxJwzKwbMrmlVELMiigoiqCCKCRBRQXJGcmYIk\/r7UWt\/s5MYENd133oOhzNdU+HWrZ6+3VXV9xIwDAMIBAKBQPyzEH+2AAgEAoH4XwSZHwQCgUD8BJD5QSAQCMRPAJkfBAKBQPwEkPlBIBAIxE8AmR8EAoFA\/ASQ+UEgEAjETwCZHwQCgUD8BJD5QSAQCMRPgMSZ1L9+ENraKDV19RiGtba2SktLE4kEPR2tfqwfQiAQ+r1OBAKBQPw42M0PhmHfaX6qa+pycnMzMj6kpmXUNzQQCJi4mDiBAISEhBgMBgZAV2fnYJNh5sMHy8rImJubqygrfU9zANkeBAKB+AUhsBmbPpuf9nbKx0+fb9y6U1RUKCkpaWBgaGczXkVVRUJcQkJCHAACmUyi0egAYG3tlA5Ke1V1dWJSSltbc1Nj41zPOWbDh6uo9NEOEQgEZIEQCATi16IfzE97OyUx+eX16zfq6xtmzpxuYz3e2MiARCJhGNba2sZgMgGGUalUERHhtrZ2cXFxYWFhAoEgKSlBIBBoNNrHz9lPnybm5uXr62nP9Zw9UEOjt7YEmR8EAoH45fgu88NkMj99\/rLvwMHGpqaAJUumTLYTFxPFMKymti4942NlRVn80+eamtrlZcVfv1aZmw17l\/ZeWUVVUUGhm9rt6DCVTCLb2VrLyUoTicSm5tZHcfE3b92aNNFusa+PiIhIL\/rQH+aHTqfn5ORgGEalUiUkJPT19UkkUkdHR1FRkZKSkoqKCsz2+fNnaWlpTU1NeFhYWFhYWAgAMDAw0NHRwfMAANTV1eXk5GCezs5O1rbk5OTU1dX5tAsTWTs4ZMgQmCgjIzNw4EA24dlazM3NpdFogwcPJhKJAIDi4uKOjo4hQ4ZwzQyrFRcX19XVhRlycnIkJSU1NDR41d9jEa5dVlFR4dUpJpNJpVIlJSV1dXWFhYV5qYW\/PLASBQUFfCB6HD7BlQ8AqK+vr66uJhKJgwcPhl+Vl5e3tLRISEjo6OjgMnR3d0tISOjq6oqKiuJN9KrXnB3pl4Hu82j2SlFcu\/Y9Ku3tT7IPHexR7X1TWp8Lci2C\/\/Dhjwsf9F8b7O8wmUyGYHR2du3cE2I+auyFsMuUjk6YGP\/0eWFx6aSpjhMmThs+cpzdlJmLl68zGDRUVV3TdtK035xdR421NR89wWdJ4FzvxePt7Kc4uqzdsC0q+iGdTmcwGM0trcdPnpnu5P7yZYqAYjAYDCaTiX039fX1UCFwUNXV1ZOTk1NSUgAAGzZswLMBAFxcXDAMo9PpHh4euBqnTZsGM3z48AGmrF27FqYMGjSITeeLFy\/m3y6eCBEVFcUwrKGhAQAwd+5cNsk5W\/Ty8gIAPHr0CP50FRUVp0yZwiszrFZMTKyiogKmKCsrL1q0iE\/9PRbh2mWunWLrvqKi4rNnz3iphZc8bDVramrevXsXwzA+w9db5WMYtnXrVpjS2NgIU8aMGQMAGDduHGdVsrKyUP996zVbR\/ploPs8mr1SFNeu9YtKe\/xJ9rmD\/NXeZ6X1rSCv09vDwwPDsKysLDKZPGvWLOw\/QR\/tZ3FJmcec+aVlZZG3rnvNn8NkMvMLikOPnLh+\/WZDfb2SsrLJEOPZsz2oNGp9fe3UKVMXL15iZ2ejOXDgNPvJsrIyYqJilRUVZBJJWkqitbUlNPRIc0vrs8RkMokU4O8bun\/vyTN\/Hj72B5VK7Zt4fUBMTAwAsHLlSjqd\/v79+7a2tg0bNsA7bjKZjGcjkUhCQkIAgOfPn9+8efPAgQN0Or2lpeXEiRMww40bN8zMzEaMGHH37l2Y8uDBg\/Ly8uDgYABAbGxsUVHRrl27+LcLE5cuXVpWVlZQUJCamgoAgHfTnM+FnC3u3btXUlLy6NGjAIBbt261trYeO3aMV2YJCQn4ISgoCH4QFhaGAvS5CNcuc+0UTFy1ahWDwcjIyKBQKIcPH+alFl7ywMxr1qypqqqKiopiMBju7u5paWl8hq+3ygcA1NTUGBgYAABevHgBAGhubn737p2+vn5bWxte1dq1axkMxtu3b5ubm8+dO4en96rXnB3pl4Hu82j2SlFcu\/Y9KhX8J9nnDvJXe5+V1reCvE5vMplMpVLnzZtnamp68eJF8J+gL+Yn\/f2HRYv9ra3HHw3drzlQ\/c27dN\/FS1euXnP12nVjY6NHj594uLstmDdnqZ\/3pQunTx8PPRCye8fWjZs3rDl86ODWTeuvhP+5fvWy40cOLvZbRKPSKB2dwiKiW7bt2r5rz5GT5yorq3R1tE+fONrU1LR9V3B7e3u\/95kr8AxmMBgEAsHMzExHR6erq4vzXBcWFoY5MQwDAKSkpFRXV0tLS8NHaSaTeeXKFScnp+nTpxcWFsIzWE9PT0NDQ0ZGBgCgpKSko6OjqqrKv12YSCKRBg4cqKenZ2JigudknYPi1aKamtqmTZseP36cnZ0dGhq6adMmY2NjXplhtS4uLpGRkVFRUbCPeCt9KMKry3w6RaPRAADDhg2TlZWFkypc1cJfHhKJpKqq6uzsHBERQafTjx49ymf4eqt8AEB5efmkSZOIRGJMTAwAICoqSk9Pz8DAoLGxEa+KyWQCAJSVlYlEooWFBatsgveasyP9MtB9Hs0+nKVsXfselQr+k+xzB\/mo\/XuU1r8\/NxKJtGzZss7OztjYWNyG\/er02vykpWds3LzNe8H8wOX+oqIid+\/HlJaV02h0ExPToUOHFRWXTHOYMsPR3mz4sIbGppbm5sio+7uC9y9ZFuQXEBiwfPXmbXtu3o6qr6+XkJBwmjHtjxOH\/f28rcdZFRUXqQ9QTU19t2X7rjfv0khk0paN6zTUNXbuDm5r+ycsEBzjioqKuLi4oKCgzMxMPz8\/eJaznusiIiJwKsDW1tbBwSE6OlpbW9vHxwc+IMfHx1dUVLi5ubm4uAAArl+\/zla\/gO3CxIiICD09PU1NzWvXruE52SZ8ebUYFBSkqKi4du3axsbGTZs28ckMq50+fbq5ufmyZcuam5tFRERwaftQhFeX+XTq06dPJ0+enDlzprGx8e+\/\/85LLfzlwZ+VbWxsxMTE8vPz+Qxfb5UPACgrK1NXV7eysnrw4AGGYdeuXZsxY4aEhAQceljq5s2blpaWgwYNGjdu3LJly\/rWa86O9MtAf89o9vYsZeva96hU8J9knzvIR+3fo7T+\/bldvXr1\/Pnz06dPxxe9\/gNwee2UD5kfP2\/asn3u3DkL5s1pb2\/\/+Dln374DYuLiRKIQncE4EBJsoK\/T0tL66PHTmNiYLzm5ZLKwkaGhlaW5lJS0EInMYNAp7W0fPmbv3LOvrbXF2Nhw4sRJE23Gj7EaXV5ZdfbcxY8fM43NRxw7cdLd1dnd1TlgyaKTp8\/t2hO8Z9cOzgfb\/gXetyYkJOTl5RkZGT169Mje3j4vLw8AQKfT8Wx0Oh1OghGJxIcPH169ejUkJCQ8PDwjIyM9Pf3ChQtiYmLw0VhYWPjmzZsHDx6Evw34tARb6bFd+EsYOXLkvHnzaDTaiBEj8Jxs5odXi+Li4l5eXocOHQoNDcXn67hmxvt1\/vz5UaNGbdu2TVxcHPu2\/aQPRXDYugw\/cO1UQUHB1atX09LSbGxsZGVleamFlzwwM7zjhmXpdLqCggLsONfh663yAQClpaXS0tLu7u5BQUEJCQlJSUkhISGnT5\/u7Oxsb2+HeweMjY3nzp2bn59\/7NgxS0vLjx8\/wrK96jVnR\/ploIlEYp9Hs7dnKVvXuA69gCoV\/CfZ59OVj9r7XGffCvI5vR0cHGg0WmhoqImJCVzz+y\/AthbEZ+tBaVnFhIlTz1+8BPcIzPL0Hms9cco0JyfX2afOXGhobKLT6Vev37YabzvJfsbFS1fKKr7y2S9QVV1783aUk+tsyzETLoRdptFoNbV1x\/7402K0tb6x6dPEF7W19VQqlUqlhh4+vmrthh+99QDu1PLz82NNbG1tBQB4e3vDQ7hsuGvXLtY8dDp9zpw5AIDExERhYWETExMPDw8PDw+4tycxMRFmg4tDKSkpgrQLE1l3KOCJgYGBeEpdXR2fFs+fPw8AePLkCf\/M8CISFhaGYdju3bvJZPKQIUNWrlzZtyKssHWZT6d8fX0xDIM3xcHBwbzUwksetpojIyMBACdPnuxx+ARXfm1tLQAgPDz869evRCJxwoQJRkZGGIatWLECsOz08\/f3h\/lXrlwJAMjKyupDrzk70i8D\/T2j2duzlK1r36NSwX+Sfe4gL7V\/T539+HOD4vn4+DQ3N2toaEhJSZWWlmL\/CQQ1P11dXbPmzN+z9wCVSq2tqz96\/KT5aOvR4+yePE18l\/qewWB8yPxs7+g009n9bWo6LEKj0fLLvpRWFcFdbbzIyPw0b8Eia7spr968g0bObsr0ZYGrNbT0b92JZjAYFErH+k3bb0Xe\/aHmB6524qc1jpWVlaSk5IMHDwoKCnx8fIhE4sePHzEMKysri4uLKywszMrKcnV1JRKJcBtPTEwMLHjv3j3W6xFcW37+\/Lkg7cLf2JQpU+7fvx8ZGXn16tWKigqY093dPTo6+vbt21euXNm3bx+fFk+dOgW+bYvCMAwuSnNmhqtrZ8+exTCMTqePHDkSABAQENC3IqywdZlrp2Cil5cXhmFMJlNXV1dFRYVKpXJVCy958JoTExMPHz4sJSVlZmbW1dXFZ\/h6q3y4Wh4ZGYlhmJ2dHQBgz549GIbB+a5Xr17BUs7OztnZ2TExMXp6egoKChQKpVe95tURXh3v1UB\/z2gKriiuXYNGorcq7e1Pss8d5HP+9LnOfvy5QfHmzZuHYRhcLpo+fTr2n0Ag80On048cOzVnnk9DQ2NXV9eqtZusJ04zGzVuqqNzbV19R2fntRu3LcdO+PPipbb2dliku7vrVPTvI4NkRq2Su5F4jkaj8rFAHR2d12\/eGWNtd+KPs+3tlKeJyfO9\/UaMHHvw8IkTp\/5kMBhfq6pnOLnn5Ob9OPNTV1cHAJg9ezZbenZ29rBhwwAAAAAxMbETJ07A9NOnT4NvyMvLnzt3btSoUUQisb29HWaAy6cDBgyAhyEhIQCAp0+fCtIuTGQlISGBM3Ho0KF8Wjxy5AgAAN9Cyks8WO3Ro0dh+sePH4lEIvzN96EIK2xd5tMpT09PmGfLli3wksRVLfzlgUhKSnp7ezc0NPAfvt4qH94Rw0sDXJT+\/PkzhmFwE2N0dDRrKTk5uZkzZ3748KFvvebsCP9TS8CB\/p7R7O1Zyta1sLCwPqtU8J9knzvI5\/zpc539\/nPDN1tbW1sDAGJjY7FfH4FeOy0uKZs1Z15E2HkjQ\/2Ll659zvqSlPR05YrAYcNMhwwyOn\/xUuyjR+vXrZ0wfgxepKAye8VpF4yAAQDESVJ\/LL83QIH9hSw2Pn3+snP3HmNj403r1xQUlSxZuqK7q9PKaozXfE\/LkeYvX725FHH5zB\/H2LaXgH\/E60FFRUVdXZ2hoSHrnpPS0tL6+noZGRlNTU04T434WVCp1M7OTgzDZGRkOE8GrsPX78CbISEhIV7bTASBf0cQOP07pkjtPwWhnTt38s9BpdJ27dk7duyYGY72GZmfDh0+SmcwdHR07WwnjDQffv5iRNzjx\/tD9o60MGMtFZ92T4QkttPzzMxR87NK0hVlVHVUDfk3pKKsNNrS8l70\/Q8fP89ydTI3G\/72bVp3V+e4cWPl5GT1dLRepLzq6qYaG7HX8w+YH2lp6QEDBrDZGFlZWTU1NXl5+e+53CD6BSEhIVFRUVFRUa5nAtfh63eIRKKQkNB3vovOvyMInP4dU6T2n0LPP5X8gsLXr98sXeLb3U29dPmaoYFhZUW5grzs+LGjYx4lREVFhewNHjLYiK1USVW2vLTiQBXtgSraImSRwoovgkijpamxN3jXhw8ZtyKjRlqMmOvpsW3LpkdxcXt+308gENauDrpx83Zra1tfOopAIBCIfxM9bLym0ehnzp1f6OMtLi525+791LT0cWNGr1oVZDN+bHll1c5de44fPTRkELvtodKoX2oz2ymtnrbLOrsoH0peksiC3hJqqKuFHtjv4Tlv+LBh7m4uixYvKy4ulJOTL6+s0tRQMzI0SEp+OXO6Q1\/6ikAgEIh\/DT1YhdKysowPH+Z5zqbR6OYjzOIe3h07xkpjgIq8nOzmLdt8vBeMsRrFWaq+paa+uUZSTNon1G7lOTcJUdn8quzG1nrOnFwZMtgoePfODZs2EQjgctjZRYv86hsag0MOAgDmz5sbHx9P\/bZDH4FAIBC\/KD2Yn7vRD8daWUlLS+YXFG3ZvuvMuQtDTU3GWFm+eZtaWlrqvWAu15nusrr8mpaytKLnxU05eTWZeTWZVU3l9a3VgovlOG0qiSwcE\/uY0tH57OkTYTKpuqqqqLhMT1ero7M763NW73qJQCAQiH8Z\/MwPpaMzLS3NwcEew7Ck5Je5uXlxcY9Lyyo6O7vO\/nl+aYC\/lJQkZykMw5IyYzppHayJTR21GQWvBReLTCItC\/APvxTBZDDGjBkzfPgIPT39xOcvAAAzpju8TX0veFUIBAKB+BfCz\/wUFZdQ2inmI4YzGAwlRQV1dXUjI6MRw03zC4oKC4ucZk7nWuprfdnz7Iec6XEZtyhdvfDeZmdjTaczMj9lTZ5o87Wq6tWrlKh796lUmsmQIe9S33LuDkcgEAjELwQ\/81NZUaGorCwlKZGannnw0NH6hkZ1dXVJScmHsXEzpjuKinKPCHcnJYwsRNZSNGBN1JTVL63Je5X1hDWxvbMt4V3026znXG0JiSTkMcstKuqekaG+u8vM7u5uGWlpJsY00NdVUFCqrqntfWcRCAQC8W+B3863F6\/eWo8bAwAwG2YyfbrD3ahor3lzKJSO9+lpgYGBXItU1VfEpF5ZMnX7tZcnWNOH6oxSkFKNeHZ0wrBpwqS\/tur\/Eb0r4sURYZLISd\/osaaTOWuztLS8E3W3qrq2urZeVlbuc9bnW5HRXvM8REXFPmRkDHCw72OnEb8IfIJscoYKxcnIyCgoKFBTUxs9ejR8JSsnJ4dOpw8aNAge1tXV1dTUaGhoVFRUwECZ\/GNQssW0hZnZImzyipjJNVSloaFhXl4eWw2QlpaW8vJyDQ0N6IQU9D72JZ9QsLi6+Efg5RUmFYHoZ9i8ILA63Znl6ZWYlEyj0U6cOjt5mvPQEaPz8wuyv+TaTp7WTung6v9mR8TSdefmx765NXy5mLE\/wP9s12s+Tbtvv8Uo7t0dPLPvkanG\/mBwAPHqkxNca6PR6PbTnVLT38c\/SQpas8FrYcCBQ8cYDMatyLtRd+\/1r9MdxL8Q\/kE22UKFYhhWU1MDXZJATExM8vPzMQwbPXo0AAB6wcG+ObV8\/fo1+ObLhFcMSq4xbaEAbBEneUXM5BqqkmsNEOiK5urVq\/Cwt7Ev+YSCZVUXnwi8vMKkIhD9Dr\/Jt67ODhkZGSqNVvm1trSk2NHRUVlFpaWlWUpKWozbzFt+WfbzrIcLJq58mhndRf\/bvVVNW0VFfYmz5cLLz47TGTRo9sx1rQEAwiRRfVVTrgIQiQQNjYFlpeVGhnpFJWUNjY3lFZXd3VTNger1DS18JEf8N+ATZJMzVCiGYS4uLmlpaZGRkc3NzWFhYXl5edOnT6fRaM7OzgCAp0+fwmqTk5PNzMyGDh0KABAXFwe8Y1ByjWkLBYAF2UTljJjJNVQl1xpY68FDJ\/Q29iWv\/Gzq4hOBl1eYVASi3+FpfppbWplMppi4OElIyHTIoGHDzYqLS+h0el5+kZYW+4wBAIDBZMSm3Zw5ch5JSDi1MIntWybGTM6OmTjit8a22lefngIA8iuy7r4NAwB00zqP3NtCo3OPq62vq1tQVCIqKlpfV19QkDdk8CACkSAsLFJUUtLXLiN+GfgE2eQMFZqUlJSSkhIUFOTq6iojI+Pt7R0QEJCbmxsXF+fh4UEgEGJjYwEAlZWVmZmZ3t7erNFjecWgxLjFtOUadpZXxEyuoSq51gCBgdTgV72NfcknP5u6eEXg5RUmFYH4EfA0P03NLSQSSUpSsrOrKz4hPjcnZ4TZMAlx8faODlkZac78QkSh2TZLFk5Z+\/zjw4Y2Lq\/4fKn80EZpnm+3Mur1xYaW2qeZ0WWNBQAADGAfKlLSclK4imFspFdeUUEikeTk5Ts7OmLjHndQOsTExDM\/ZPS1y4hfBj5BNjlDhb59+xYAMGHCBLy4jY0NACAnJ0dLS2v8+PHJycltbW0PHz4UERGZN28erIf1P2cMSq4xbVmLsInKGTGTa6hKrjVA4BQZ\/N\/b2Jd88nOqi6sAfML1IhD9Ts++cISEhEaNGiUhIV5dXc1gML5WflVVVuaaU0VeTVhYJDb9BgNjcH7bSKl5lZPgZu2jqaC\/\/LjLhYR9rN\/eexvO9QGI\/O02sLW1RV1dXVtTC\/n3\/N8BD7K5Zs2asrKyR48eBQQEsMbTjIuLExISgqv0DAYDANDd3Y0Xh7f88OFg7ty5NBotISEhOjra1dVVXl4e1gOfb+B\/GIOyoaEBj0EJY9pGREQYGBiEh4dPmjQJrjXiRdhE5YyYiYeqdHBwCA0NvXTpEp4Z4\/3yAHz6wWNfXr58Gca+ZDKZXCuE8MnPqS7ALQIv1xr6MHD\/fuTk5AiInwHrfpaezQ+Dznj67PngQUa6ujoYwDQ0NKpqanhlbu9o85u4OcTjyjg9Bykx2RCPK\/ZDPWRFFTfOOB7icWWwurkQkbR61t7r215eWP5URvSvcLZDNUa\/zUmobqzgVa28nGzcgzvKqmrZOblUKvK4878CvPZ5enpmZWVFRUXBeNv49ff169cRERFPnjwJDQ0FAAwfPhwAcP\/+fbx4TEwM+PY8NGvWLGFh4QcPHiQlJfn6+uL1QKMF\/9Pp9OHDh2\/btu3s2bNdXV0wkUgkzp8\/\/9OnT3PmzMnMzPzy5QtrQTZR8aef6OhoGo3m6OgI0xUUFK5fv66hobFixYqysjKuNUC+fv0K89fX19+\/f19PT6+ioqKiosLAwKCysjI5OZlrhQAA\/vk51YXLjAeu5lXD947iv5Lm5uaftuD+v01zczM+CjzNj6SEBIPB6OzsJBCJomKisrLyjU0tdDpDTFSko6OTVykFGaVpY91nWs\/RH2AiKiw203rOIJ3hEsLSU0Y5z7SeY202Fc9JJgmTiH\/NfRtqDLUx\/e3J+2jOCnPzi5SVlLq7qU+eJjLotOHDhklKSnR3d+no6vflpEP8UsArI+3vLv7gIfw\/e\/ZsXV3dEydO0Gg0e3t7MzOzixcvbt++\/d27dzt37oyIiJg\/fz4MWiwrKzt16tQbN24oKyvDSTlYAzQYrP83b948fPjwrKwsKpVaXl7++PHjoqKi3NxcKpVKJBJVVFRYC7JJVVJSkpSUdOTIER8fHzMzM19fX1xaGRmZ48ePt7W1LVu2jGsNmZmZ6enpR48elZWVHTp06LVr16hU6v79+2\/cuHHjxg04Y3bz5k2uFQIAeszPpi48ETc\/vGrot+FEIP4OT\/OjpChPJBLbKRQRYbLZsKFv3ryq+lopTCYbGuiWlfN8TBEcMREJMvmv7T0q8mr+jltGD7LlzJaXX2hspF9XV3fi1LmRI0cONTUhEgnd3d0mQwZ\/vwyIfzldXV34fxw4vQYvnQQCYc6cOTU1Nffv3xcSEoqNjbWzs9uzZ4+lpeXvv\/\/u7+9\/\/vx5vOCMGTO6urpcXFwIBAJeD3z9hfW\/kJDQhQsXiERiZ2dnTEyMvb29np7ekCFDEhMTz5w5o6SkxFqQTar4+HhbW9vt27e7uro+efJEREQEpkNL4+zsbG1t\/fDhQxhHma0GR0dHCwuL8vLyS5cuiYqKXr16lUgk4ktZcEN5dHQ01wofPXrEPz+nunCZcfPDq4Y+Dh4C0RP8XjslC4u0t7USCEQxMVEFBaWiooK6ujoZGdmmpkYajU4m9xCsoYeGhUjSYnLNHfVEAlFeSlFVQUOVIxwqk4lVfq3U1tJsaW2j0xklRflDBhmQyeS6ujplRdnvaR3xS6CoqIhxLJCwJQYHB8MNxAAAVVXVhISEysrK2tpaHR0dfJED4ufn5+fnx7UetjpNTU3xmTEHBwe2mLa8pOru7uaMmMmW+fnz5\/DD\/Pnz2Wp4\/\/59Z2fnwIED4b4DuJMCR05ODq+Ha4UODg6C5GdV18aNGzdu3Ih\/xadFBOJHwG\/tR1lZuai4lEQSCli88G7kNY9Zs169TVNUVBATFfmUJVD4OD4MUBzoPnbx8IHjxhlMmzlqAdc85RWV3V1diopKbe3tFEqbrd3E8ePGAQBS0z\/wcvmDQKirq5uZmbHZnj6jpaVlbm6ur6\/fY2BNYWFhGRkZWVlZQp8iZiorK2tpaX1nsFQE4heC37k+YfyYlFdvAAAtLW1Hjp28fvP2h8yPigryg4wHpaRw3yctOCQhkrioBFmILEwWERflHq09IyNDQ0NdUVHhxYuXVV8rN2\/ewqDTAQAtLS16emjtB4FAIH5h+JkfPT298vJySkenpKR4Vm7RKEurkpLS0rIKF5ffbt6O+geEC4u4Ot1xWmNjU+r7T95eXg+i7yopKVRUVnW0t+rr6f4DAiAQCES\/QKFQcnJyfrYU\/y74mR9dbS0REeFPn7KIRKKEKDn5eVJxcUl9ff0gY0NlJcXH8c\/4lJWXUjJSGg4AkJNQUpXRJAmROfMoy6iZ6ozUG8B9E8Hb1Pft7W1jrCzT0jNaW5sTk57n5HwBAGRnfzEwHoTmKBAIRL\/T2to6efJkfHbH29tbwFITJ060tbV1dXW9ffs21zxfvnzZuXNnP4nJ3rSNjY2Njc2DBw84RfLy8srKygIA0Gi0oKAgGxubOXPmUCiUhoaGJUuWsFZ15syZqVOnenh4lJeXw5Ta2lpvb2\/oB+RHwG\/7gIyMtKmpadLz56MtLfHJKNIAACAASURBVJx+m15aVqGrq62uri4mKrZooc\/JU6esrceIiYoCANra24uKSoYNNcHLutsucrSaDQCwN3cfYzRZTkqes37LQTYjjcZzXd7EMOyP02fcXF2kpaWUlZUGqqu1tLTYT51CIBBiHj1eMNeDswgCgUB8J62trUVFRYGBgampqUQi8eXLl\/hXTCaT111va2trS0tLampqeXn5kiVLysrK1qxZ02Op\/hK4paXlzZs34O9uLHCRnj596uTklJ+fDzfWJyUl5eTkEAiEzs7O9PR0PP+rV6\/u3r0bExOTkJCwdOnSBw8etLe3+\/n5ycjIwHfRfgQ96MX5txmPHsd3d3fbThhPIpOzs7M3bt5aUFg0ZZINgUCMfhDLxLB2CuXo8VPrNm1LfvH\/C0LSErKqCuoAAAlRyQGKGkQiF1cFQkQhMklYmCwCAIh9\/CT9fSaV9pc30sTnL0uKS+Z4uF+5eis8PGLd2lUH9u2VkpIsLa+kUNoMDQ37UwcIBALxDS0trWHDhkVEROApTCZz4cKFDg4OFhYWrOlsEAgETU3Ny5cvHzlyhFep9vZ2W1tbtk2GvYLJZDo4OLC9DEcikUgkEueeFwKBMHHiRPiOrbi4eFZWVmtrq7GxMae729jYWE9PTxKJZG9vn5qaCgCQlJSMjo4ePPgHvuLSg\/kx0NfT0tR8EBMHAHC0nywvL79ksZ+Bvi5RSGj3ru2HDh0uKSm7Gx1TWFQyZdLE9IwPiUkve+ulo7ub+uLVuzuRUT6+i7du211bV19VXbt9565tW7dQKB1Xr117\/fbdqtXrtLU0AAAPHsSMGzuGa5BvBAKB+H6YTOaePXtCQkLwF7Pu3LlDJpMfP378\/PnzrVu3sjp24kRRUREA0NHRwVmKRqN5enquX7\/e0tKyz+IRicTZs2ez+qstLCx0cnJycnLKzMxkzdnS0nL\/\/v2lS5fCd93c3Nzs7OxMTExCQ0M555xqa2vhZlECgUAmk7m65Oh3enh3R1xcbMli33XrN7u5\/ObjNdfCfASlo2PRkuXjx49f5OXp4+MTtHrtkUMHi4qKGhvr29o7nyQ8fZ+RsdjXR0AL0dzcErAiiEggLvbzzcnNsbWzZTAYa9dvsrWxmTxxQuzjpwcP7CspKWlqagQAtFM6nj59dv7cqX7oNwKBQPBAXV3dw8MDPsQAALKzs83NzQEAEhIS6urqNTU1nHECceh0Oo1GExcX5yxVWFjIYDBYQ1L1DS8vL9ZDbW3t8PBwAICUlNSJEydiYmIGDBiwZ8+e7u7usrIyFxeXSZMmAQAIBMKOHTuWLl3q7Oysrq4+fvx4AACeX0ZGhkKhwAqFhIT+GdeaPU9KmpsN09HRunTlOoZhzS0tq9estRw16urVKwCAxYu8hwwesmnLjiV+Cxf5+NTW1tDo9Jkzpm\/curO8oofpwq9VVZu27lq+an3g8mVNzc0qKkrr168bZWG2\/+BhCUmJbVs2FBWX\/b43pLi42NV5pu9CbwzDTp4+6\/Sbo4ICl2UkBAKB6EfWr19\/5coVeEXW1NT88uULAKCrq6u2tnbAgAEYhtXwcH25f\/9+GF+Ks5SxsfHy5ctZ333uG1VVVayH0I2srKyskJDQihUr4uLiwsLCAADKysrLly+fPHkynJSrq6sDACgpKdnY2MDPAAA8\/9ChQ+GUYG5uroGBwXdKKCA9mx9RUdE1q1edOnXma1W1laXFokW+GR8yS0pKPeb65OUXbt28Xl9PNzBoXWdX55mTRw0MDd+8eycnKztAVRkA8CLlbean7LKyisqv1bV19TW1dV9y8z98zN4fejQ3rzD5RUpBXl5jY9OmDesaGppGWYxYu34ThUIJCd71OSvHZ5Efpb391Jmz1TW1AIDsnLyXL1NmzXL\/4SpBIBD\/qxCJRLhTQFJScv369dA\/5uzZs798+fLbb79NnDhx7969ZDI5Pz8fPlJARERECgoKbG1tJ0yYUF1dffDgQc5SwsLCRCJxyZIlJBLpzz\/\/7LOEDAZDT08PnwDEBebVEZzr16+PHj3a3t4+JSXFy8uLLYOHh0d2dvbMmTN9fHwOHDgAAKBSqdOmTQsLCzt16hQehrF\/IbBNAkKnpGyZMAzbsev3tva2kODdAIC9+0OZGMjOyiKRhbdv2aijrfnHmT+fPHmyZvUqkyFDIu\/en+4weaCGWvaXvEsREa6uboePHhsxYoSwsMibt2\/cXZxpdHrw73t37tiWkPBsqKkJSVh46ZKFr16\/Oxh6yNTUdHXQiqLi0mdJybdv3\/bx8tbV1bIeP4ZOZwQGrV0dtHzYUC5xUaEf7x+hHQQC8Z+EQGC\/9OGw7lXDMAy\/tlAoFHFxcfxQwC1trKUYDAYeQfF7ZrfodDrr2g8vSTjT4fqTpKQkrwwdHR1cg\/D2I6yaF8hvG4FAWLNqpfuceddu3PZa4Ll7x5bYx8+Snierq6mfvXDJ+TfHlcsDTIcM2R28d9zYMSuW+auqqLS1U\/buO9BOoXR2dubk5MhKS+obGBXk5RKJxK7OzkGDhyQ9fxHg76ehpipEIu35ff\/j+PigwBXTHR2qq2t27N5bUlwweLBJUUmxj5ensLDwnxfOammqc7U9CAQC0Y+wXpFZ72vxqLKc2fjAWgo3Od+5ssIWJ5eXJJzpIiIieBx3rhl+tO1hQ6CnH8iXnDy\/JUv37N5lO2FsUUnZiqB1RAKQEBejM5l7dmwbZGxQW9dw8o8z96LvT5k8ce5cT3W1AQwGMy8vl8EESc+T9fUNJMVF8woKp0+zl5aW0hyonl9QfPX69Xv3HkyZPHHF8qWqKsqnz118FPe4orx8w4b1mZmf9u7ZRiaTIqOiU1JSQg\/sExLirmX09INAIHoFn6cfxA+FVfM8zU9jU\/PigMCxVpZeC+bKy\/3lvTHhadLOXbuD9+y2nTAOALBu43ZDQ4NbtyOXL1tKBMwRI8zU1VRr6xqu3bj14MHDltbW8WPHDB1qqqo6QF5eXkpaqqurq6amtramOvvLl2eJzyXExR3sp86bO1tdbUBuXkHyi5RrN24OHmzy7t3rFcuWLpg3BwBw+050WHh4+MU\/lZUUcSEfxDyiUDpnz3LB+4PMDwKBEBxkfn4WApkfAMCVa7d27tptYmJyYF+woYF+VXVNeMQ1bS3Ns+fO7dy+3WbCWCqVFhZxNfpBLJ1OI2CMO7euS0pKwEraKZTa2rqXr97l5uW2NjfWNzTBaF2qyopiElKGhkYTxlupqqpKSUpAy9HZ1XU3OvbIkUP6+obHjhyUkpQQExOLjLp\/6syZVStXkkkE+6lTAABNTc0HDx9PTHz659kzJkMG4f1B5geB+JeAYdiff\/45b968f3gmhxUmkxkaGurv7y8tLc01AzI\/Pwt+5ofJZObmFbS0tNBoVEpH1+Ejx0ZZjk5OTjpz6uSmzduam5u0tXXGjhlz+cplf\/8lHm7OABCev0j54\/QZ34U+9lMm8mqyqbmV0tEhKSEuK8P9bAAAtLa1Hz\/5x\/y5nhrqahgG\/rwQHnknynfRothHsVVVVdMcpqwOWrlj914xMYnPnzOPHDpYWlqqpqauoqxEIgkh8\/NTaGpqotPpioqK\/wH9M5lMBoNBJnNxTvhvbut7huBHDB+DwViwYEFUVFRaWhqMMwv50eplqz8vL8\/MzExDQ+PJkycDBw7kzP+zzA+FQikvLzc2Nv7nm\/6XwKp59tUUBoN5+dqthX4B92Piox8+olKpTjMd9XR03Nw9TE1Nrl25pKKiHJ+Q4L\/E\/+y5P\/eHHmlobLSdMO70iWOTJ3KJVYpTV1cXF\/+Mj+0BAIiJii4L8NccqFFbV791x67o+w8C\/JfcvHVTQ0MjIvxiecXXufO9W5qb7Wyt29o7rt64ExP3NHDV2vLKH+WP6FfH2dlZW1sb7qHkpKamRvsbbC5AYEFNTc0BAwZoaGiMGTPmyJEjrCFHGQzG0aNHdXV15eXllZWVVVVVN2\/ejGeAxQcOHKiqqjpw4EBLS8vg4OCOjg4BBYDFbW1tWa8OI0eO1NbWLi4u5trHvXv34imRkZHa2tqsFz7+zbW3t+\/YsUNXV1dERERYWFhCQmL16tVcK+evT0FU19u28MPXr19ra2vr6up++vRJkCHgL22PZSFv3ryZPXu2mpoaiUQSFhbW1tbGX0vkVDvOnj17rl27dv36dTgEvLrs7u6uzY2ZM2fy0gZXrfKq39DQ8OHDh0VFRW5ubng4V0Fwd3e3+YatrW1TU5PgZQXhRzge5e8Y9MWLF9bW1tXV1XhKQ0PDwoULLSws\/Pz88B8mm79RtjrpdPrWrVunTp06Z86cxsbGfhMd+ztMJrOrq3vpitXbdwV3dXWXlJZX19TOcHJfs35LV1cXg8FobWvbd+DwmPG2N27dnTPPZ7qT2\/MXr7q7uxm8uRl5123W7MGmw7fv2F1RWcUnZ2dnV2xcwiT76UsCVly9ccdqvO2JP850dHYyGIz2doqPb8B8b7+q6trKqmoKpWPjlp2JSckMBoPJZGIIDmDU5F27dnH99uzZswAABQUFAMCmTZs4CxobGzs5OVlZWcFb4+nTp8NvGQwGfKuOTCbb2tqOGjUKZhgzZkxHRwdefNCgQU5OTuPGjYPfzp07V0ABbG3\/uo+5dOkSnqihoQEAqKio4NrHzZs34ylXr14F32KMCtKco6MjAEBeXt7BwcHe3t7IyGjLli2slW\/dulUQfQqiut62Bb\/t6uoyNTVlbbrHIeAjrSBlMQwLCQmB6WJiYpqamtLS0rKysmzdxKXFycvLI5PJbm5uPap38uTJurq6pqamSkpKcFwGDx6spaU1Y8YMXtrgqlU+KsUwDJqi06dPc44U56UPAn0WGBkZNTc30+l0PJ1KpXJqEv9Mo9FYv2I7ZC2bmprq4eHBtem+0dbWNnPmzPnz5584cYLzWxqNZmtra25unp+fjycWFhamp6dTqVRHR8dTp05hGJaSkjJlyhQajRYbGzt9+nTOOi9cuODv749h2MmTJ5cvX\/49ArNqnov5YTAYrW3tk+xnvH6TWl\/f4OLuuXL1elYjQaPR4xOeDTIdsXf\/ofNhl0dajfdfGpidk8fLqDQ3t9pMsldQHhAZdZ+P7Xmf8dFzno+13dSrN+7s3B0yYuSYhKdJNBqN1Th5LVzsu2R5U1Pzk2dJm7ftgunI\/HBl8uTJAIC9e\/dy\/dba2ppMJh8+fBgAYGhoyPrV1KlTAQDnz5+Hh7du3YL2oK6uDsOwkJAQeH3\/9OkTzBAfHy8qKgoAWL16NV48LCwMfnvhwgUAgIyMjIACODo6kkgkcXFxJSWl+vp6mKinpwcAwA\/ZRN29ezeecufOHQCAhoaGIM3h736XlJTgOfGLjr29PQAgODhYEH32qLpetcXar5UrVwIAZs+ejZ\/nPQ4BH2kFKQtDBpDJ5LNnz+KXzurqarwSNmlx4MuJb968EUS9kBUrVgAA\/Pz8WBO5aoNTq9CnAJ\/6a2trSSTSoEGDMA54mR+IkZFRW1sb\/Pzly5epU6c6OzuPHTu2tbU1IyPDwcHB0dHRxMTk+vXrtbW1kyZNcnd3V1RUPHDgANshW1msP8wPg8Gwt7dnM4chISFczc+hQ4cuXrw4ceJEVvODExgYePLkSQzDtmzZEh4ejmEYk8lUUVHhrHPNmjWXL1\/GMKysrMzc3Px75GfVPPetzBLiYiuWBRw6cuzoyTPFxUXbt25i\/ZZIJEy0mxD\/6GFBQUF4+KXFfou1dXS9fXzne\/vFxiVQKOzTLAAAD3f306fPSEtLcX7V3NJ6L\/qh40zXVWvWjrK0nOfpeerU6eqamkcPo+1sxrPuTBcWJu\/fG5yennbk+OmwsIjFvgu5Co+AwHcL2F4RgBQVFb148WLSpEmenp5EIjEvLy8jI4OtIP5UPnHiX0t6TCaTRqPB+Zzt27ebmPwVX2Py5MmBgYEAgDNnznR3d7MVt7CwAN8eOwQRQEhIiMFgeHp61tXVwWoBAPBlBc6+wLZY36LgTOHTHB4\/mzVQCl4Wnnts72pw1acgqutDW0JCQpGRkceOHZs0aVJ4eDi86xdkCHhJK0hZDMPWr18PAAgKClq8eDG+mqKiooLXwyYtzu3bt9XU1EaNGgUP+XcZAiVkewGFqzY4tYr3jlf90MHMly9fKisrQV\/R1dWNjY2NiooaNmzYixcv6HR6TU3NnTt3oqOjT548GR0dPWPGjFu3bllbW7u4uLAdspXtswyscLoc5UV1dfXjx495hSxqaGiIjY11c3MDAvgbnTBhwokTJ65fv378+PH29vbv7cM3eL45NXWynZGRYWbmR1lZuTXrNrZzGBW1ASrHj4Zu3rQh7tGj169fL1q00HL06CtXr\/3mMmtZ4Jo7UfdS0z\/U1TcAAMQlxBb5LHD5zdF6\/BhYtqy8MjUt4+btO75LVrjPnnv\/YYyzs7Obm9vj+PjEpMTt2zYfDg1RVGT37Vbf0Bi0Zp2IqFhuXp73As+BGmr9pYX\/JPA3zHVVGd7puLm5qaiojB07FgBw\/fp1\/Fv8xWx4ePHiRQCAiYmJsrJyWloanA13d\/+b96M5c+YAADo6Oj59+sRavL29\/fDhwwQCYdeuXQIKICQkhGHY0qVLJSQkrl27FhMTA76ZH87rHUyJj4\/f+I3Lly9z5uTVnLS09LRp0wAAK1asMDU1DQ8PZ10nYLNkfPQpiOp61Rb8cP\/+\/fnz5w8ZMuT+\/fv424KCDAEvaQUpm5GRAdfY+Lgm42rjKysrKysrLSws8Eb5dxnCVZ9ctcGpVX19\/R7rHzlyJADg\/fv3vPrSI21tbb6+vosWLUpOToYm0MDAQERERE1NraWlRU9P7+bNm+fOnSsvL1dXV2c75CzbL3h5efE6D0+cOGFvb+\/j4wMA2LFjx4QJEx4\/ftzQ0PDy5cvjx4\/jX1Gp1NmzZ4eGhsK7CnFxcf7+RmfMmAGn6aZMmaKsrNxfHeFpfshk8sb1q91dncXERJOTkwOWBZaVV7DlERMVnTrZ7tyZP+bP9YyPj49\/HKelpbNg\/jxdXd24hGf7Dxxc7L9s1px5ixYv8\/VfvnDxssUBgd6+Ae4enkuXrww9fCQx6eXgwYO85s+Xk1O4ezfq9es3ywKWnP7j2CS7CSLf7psgGIaVlJavWbep6mvFKIsR2zavt7Pjt9MBAb79sDlPUyaTGR4eTiaT4RoAvP25ceMGhm9HIRIBABEREU5OToaGhuvWrVNSUoJODCsqKgAAJBJJVVWVtU4tLS34obW1FRb\/\/fffDQwMlJSUbt++HR8fP2\/ePAEFgMXl5eV3794NAFi6dGlHRwfrq9qcfXz+\/Pn+b8DJN9Ze828uIiLCwcEBAPD582cfHx9TU1M8IjLbFZyXPlnho7petQUP379\/39XVlZWVdeLECbwJQYaAl7SClC0qKmJLBAC8efPmzJkzULec0kIKCgoAAPr6+qyJfLoM4apPrtrgqtUe6x8wYAAAoL6+nrMVAQkLCxsyZMiFCxfwVUkcDMPevHkzY8YMTU3NhIQEUVFRtkM+Zb8HNpejrLC6HJ0yZYqwsPDnz58pFEpeXp6\/vz\/8isFgzJ0718PD47fffoOlBPE3am5u7unpmZ6eDtfb+gV+T3DiYmJz57jPnDGtsKgk8k6U\/9LA4N07hg01YbONsrLSzk7Tx44dnZOb9+xZUsSVKzJSUto6OsbGxirKysLCJDghI0QUYjDoDAZTVEyUQumqr68rKSlOfPaMSqfZ2Uxwd9tiPmIYmdsTJZ3OePXm3dFjJ1avChw9ykKQp04EAID1as5KfHx8eXm5pKQkvOdtaWkBAJSXl8MdMuDbbWZpaSmDwTAyMgoMDPT29oZ+oqAZoNPptbW1rDdB+L4aFRUVWFxFRUVbW7utra2mpmbdunUpKSn4WyD8BYDFqVTqypUrb9++\/ebNm3379kHPJZyhpGDQrYCAgIUL\/5qJTUpKWrduHWtO\/s0pKCjExsYmJibu27cvPj4+JyfHxcUlMzMTn4LAq+KlT1b4qA4AIHhb8HDXrl0dHR3BwcGbNm2ysLCws7MTcAh4SStIWfwuuKKiQldXF35++vTp1q1bLS0tXV1dcfHYhgN655SRkWFN5NNl1p6yVcVVG1y12mP9YmJiAAA8co+AsLrjtLKy8vf3f\/\/+fWlpqY2NDYFAwK0jkUgcPHjwli1b3r17t3Pnzp07d7IdspXFS\/VKGDYYDIaenl5TUxMcTSqV6uTkVFhYKCQkVFBQcPToUTwnHCwAwOPHj319ffG50Fu3bsXFxVVVVYWHhw8dOvTUqVMeHh7Xr1+fOXNmfX39H3\/8wVlnYmLi8ePHOzs75eTkLl269D3y\/w22dSG49YArF8OvWIwe98eZ8xRKB8fmghbP+Qv9lwZ+ycnv7qa+\/\/DpyvWbW7btdPzNbdRYWwsrG7ORY0eOHm82aqyFlc3ocXYzXTx2B4fcuBX5KSsH1rB0eWDa+0zORltaWg8eOjZ7rk9Obj4vwdDWA67ABVvOBUk48aKoqKj1DbjyDHe2YBgGJzQOHjzIWWdJSQk8bfCdBRC4pK+oqMhgMGDxffv2YRjW2NgIQ9Nu2LBBQAFmzJgBAMjOzsYwLDc3V0xMTFJSEvalsbGRTR7odZh160FkZCQAQEtLS\/D+4uATgOnp6bgeQkJC+OuTFT6q61Vb8DA4OJjJZMJ2Bw4c2NLSggk2BLykFaQsfEJiFQbDsPPnzwMArK2tWcVjzYBh2N27dwHfnYFsXYbArQeLFi1izclVGz1qlWv9MGYPXDZnhfPSxwqDZVcbhmFUKrWrq4vJZMJLDb67gUajubm5webu3r0bEBDAdshZFuPYfNEH2HbW9Vd+CoXC59vW1taurq5etcsV0OPWA654zZ9z5VLYs8QkN4+571L\/NpdaWFSclpYmLCoREXGJRBIqLy\/rpHSsXrXyftTN18lP3r58mvYm+U1KUtrr5Lcvn6Y8T7h7+9qSxb5NjY2VlX+d6w9jYlcGrSot+9v8XtKLVwsWLgaAGRF+zkBfV3BREeDbzSO8+8NpbGyMjo4GAMTFxZV8A87yR0ZGwqlzeLPJ9W0JLS0teA++detW+H4AAKC0tBTupwoKCiISibAgfC6Rk5PbuHEjAODUqVPwsaNHAViLGxoaHjhwoL29\/cmTJ1xFgtlY09mEF6S\/OLNmzYKPWW1tbXgleB6u+mSDj+rY4N8WfkggEM6dOychIVFeXr5hwwYBh4CXtIKUVVdXh3Mye\/fuxaNnysvLA5alfjZpIXDtms9LIWxdZtUY21o3W\/0CapVr\/V+\/fgUAsE029gjbAwqZTBYREcG9q+DTPyQSyc\/Pb9u2bZ6enjdv3ty4cSPbIWdZwG0Js7f0dgZIwPz8vVRISUnxmgPvM73rhoG+bvj5M3ejH67bsGH4cDP\/xb7GRgYEAuHO3Wgzs+EYo8vVzaujs+vDh49vUtPVNdQnT7R1dptdWlrq5ua+ddPa7bv2vn37liwscufmlbS0tJevU6MfPITvq2IYaG5p27Zz9x\/HDktIiH\/8nH3i5CkJcfHQ\/b9ra2l+5+Pq\/yZUKhUAcPr06Xv37tHp9K6urs7OzsmTJ1OpVGVl5REjRuA5p06deuLEifr6+qSkpEmTJsGZCl4Rhc+dO2dpaVlZWTl06FBXV1chIaHbt283NTXZ2dnB6yN8HxC\/WHh4eAQGBra1tUVERKxYseL69ev8BYCt429BLlu2LCoqKjExEXCbQoHmhzXuPew1Xpx\/c7Gxsdu3bx89erSKikpXV1dycjKFQlFRUYF7t2AleFVc9RkWFjZo0CC8Zj6qa21ttba2FrAt+AG2qKmpuW3bto0bN549e9bLy2v06NE9DgEfaQUpe\/r06Q8fPpSWllpaWs6aNcvY2Pjz5894nZzSQoyMjAAA+IuxPXaZs6dsiXj9vLQqSP0fP34kEAgw6uiPYMqUKVOmTMEPNTU1WQ8RPcD2ZMRn8g2HTqdXVHwN3hc6ccq05SvXJL949TTxRUFhMfy2vKLSd8kK\/2Uryyu+MhiMh48SvHwWVdfUMhiMVes2zXSZPczCqr29vbm5ZeuOPQsXL2tqamYwGJ4L\/LKyc54nv4p7\/GTpitXeC\/3epaZ1dnb2KAyafOMF13jy8Crs5OTEmhN\/tTswMBAvuHHjRl415+XlsS6lioqKBgUF4Q\/msDjrq6Bz584FAJiammIYNm7cOP4CwOJJSUn4t7m5ufCGMScnh00SuK9pzZo1eArcFiUhIQEP+Tfn4uLCph9zc\/P379+zdgSvnKs+4SQhm865qg5a0F61hR92dXXBJfQxY8YIMgT8pe2xLIZhNTU1vr6+UlJSrNnwd4fZxMPR1dUVFRVtbm4WpMsQeG64urpyqpFNG5xa7bF+CoUiJibG9T0VwHfyDfHjYNV8LwIucFJYVBITGxefkCAlJW0zwdrO1lpdXS0jI3Pn7j3Dhg4N+X0PmUyKjXv6JCHu8KGDAIAdu\/cx6F2uLi7Dh5nW1TcuCVgmKiq2bu0qAz3d9x8+pqW9zy\/Il5aRmTFtitXo0YI\/YCKXoz+FsrKyvLw8MTGxYcOG4avrvxw1NTWFhYWtra2ioqL6+vrQvcKv0tb3DIEgZel0enFxcWtrq5yc3MCBA3v02BYcHLxt27ZDhw7hzoR+tHr513\/27Fl\/f\/9z585xbiJHLkd\/FoJ6vBaQ5pbWV6\/fxj6Ke5\/xQUdroJHxIAtzC0UFOQMDPWEyubyyqri42GHqJADA8xevyWQhc7PhNDqdQqFUVHwtr\/j66fOnosICBhObOtluwoQJGuq9fpsHmR8E4t9AY2OjiYlJZ2fnhw8fWPdt\/xSamppMTU3l5eXT09M5DScyPz+LfjY\/OFQq7fmLV7m5OW\/fpWV9yaHTaCrKSsrKSlqa6sRv5gHDsIKi0tq6egKBOMF6rKy0pKGR8SQ7m+9xhYvMDwLxLyEpKcnBwUFHRycuLk5TU\/NnidHe3j5jxozM1o3cPQAABh5JREFUzMznz59Dj3ls8DI\/ra2tzs7OTCZzwIAB69evHz58OP+G3r59e\/78+T\/\/\/LPHxB9EQ0PDunXrPn78aGZmduzYsZ8Y5EJAejA\/\/dIGNGMlZZUVFZW1dfX\/3x6BMEBVdfQoMyKR2I82A5kfBOJfwqtXrxYvXnzv3j22V1D\/SZqbmydPnnzx4kWutgfwNj8VFRVOTk6pqalPnjxZunRpfn4+TGcymVw3QDGZzK6uLvyiT6fTSSQSW+IPpaioqLm52dTU1NnZ2dHRMSAg4B9o9Htg1Tz7+kp\/XcdhPXo6mno6P+0OCIFA\/POMGTPm06dPP\/eOUFZWNjU1tc\/FCQTC8OHD4X48JpO5ePHilpaWurq6w4cPjxgxwsnJaceOHWZmZpGRkY8fP6ZSqZcuXfry5UtAQICqqqqzs7ORkdGRI0f68\/VMFphMpqOj4\/379+GMEf5qsJ6eHud72f9y0IZmBALRz\/zSsxF5eXkTJ060srKC9iM6OlpBQeH27dsnT54MDg4GADg7O1+7dg0AcO3atQkTJsAd4YmJiTY2Njdu3PDw8KDT6bzeW\/h+uLocZfUf+guBzA8CgUD8P4aGhjExMVZWVrm5uQCA7OzspKSkefPmhYSEwCilLi4uDx8+bGlpKS0txeOWzp8\/H3rW+fjx44+WkM3lKJv\/0F8I5D8NgUAg\/oaoqGhISIidnZ2fn5+Ghoa1tfXBgwfxb6WkpIYPH75x40bcqRpMDAsLe\/Hixa5duzZt2sSt1n6jqqoKvgcGAGBw+A\/9hUDmB4FAIP4CdzaqoaFhZGT07NkzDw+Pmzdvurm5kclkGxubJUuWAADmz58\/c+bMgoKChoYGmP\/48eMpKSn19fWLFi36fr+ifGD83eUop\/\/QH9TujwBtfkcgEP9z8HnvB9\/kxmAw8A26FApFSEgIOquF0Gg0uPjPYDCgV462tjYRERHoWBpP\/BHA\/XU\/qPIfDb+N1wgEAvGfB712+rNg1TzaeoBAIBCInwAyPwgEAoH4CSDzg0AgEIifADI\/CAQC0QsoFEpOTs7PlkJQMAzLysr62VJwB5kfBAKB+IuGhga4tRoAUFVVtXLlSs48X7582blz5z8qFl9qa2u9vb2joqK4fkuhUGBQJV68ffuWNSBFQ0PDwoULLSws\/Pz8Ojo6+lnWv4PMDwKBQPxFZ2dneno6\/EyhUPBw4+DvQXVZ4UzHY4ezOmHjzNYvLtra29v9\/PyYTCYMK95jE2xiMBgMCwuLY8eO4SktLS3Lly9\/\/fp1VVXVD3Jbh\/Orbh5HIBCIf4acnJygoCBxcfHa2tpHjx7xSi8sLNy8eTORSMzPz\/f394+Li6uoqAgJCTE0NOSarbS0dMuWLbNnz+6VMGwuRyUlJaOjo\/ft28eWjUajubq6tre3Kykp8ZJ2w4YNMM46q6X5J32YIvODQCAQ\/09OTs7o0aMBAN3d3TIyMgAAXV3d2NhYIpG4bNmyFy9eKCsrw5yc6bW1tSkpKa9fv162bFlqaiqcprtz5w5btpqamlevXlVWVi5YsKC35oery1FO7t27p6amdubMmdevX8MoDJzSlpWVpaenZ2dnh4aGshWHPkw3b97cK9l6CzI\/CAQC8f8YGxu\/efMGAFBQUODr6wsAaGtrW7duHYFAePfuna2tLZ6TM11fX19ERERVVVVHR0dcXFxFRaWtrY0zm4GBgYiIiJqaWktLSx8k9PLy6jFPYWEhjJWHRzziFGPYsGFcgxL9Yz5M0doPAoFA8CMsLGzIkCEXLlxgtT180gUsDvoa3rOqqqrHPCoqKjBWXkFBQa+k\/Sd9mKKnHwQCgfgL3OUo62crKyt\/f\/\/379\/DkAq4R1Fe6awfCARCj9l6BZvLUSqV6uTkVFhYKCQkVFBQcPToUZjN1dX1zJkzv\/32m5KSkoSEhCDSQv5JH6bI8RECgfifQxCXo6yfaTQak8mE7kQJBALuUZRXOu4VFH7oMVuvELxUZ2enmJhYj9L+UAepbCCXowgE4n8a5HL0Z4FcjiIQCATiJ4PMDwKBQCB+Asj8IBAIBOIngMwPAoFAIH4CaOM1AoH4n0NWVhZG0Ub8w8jKyuKf\/w+7vNTpOBZk8AAAAABJRU5ErkJggg==\" width=\"571\" height=\"101\" \/><\/p>\r\n<table style=\"border-collapse: collapse; width: 100%; height: 90px;\" border=\"1\">\r\n<tbody>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 13.4298%; height: 18px;\">No. Reg<\/td>\r\n<td style=\"width: 30.6473%; height: 18px;\">{{nomordokumen}}<\/td>\r\n<td style=\"width: 30.9229%; height: 18px;\">Tanggal Pemeriksaan<\/td>\r\n<td style=\"width: 25%; height: 18px;\">{{tangglPemerikasaan}}<\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 13.4298%; height: 18px;\">Nama<\/td>\r\n<td style=\"width: 30.6473%; height: 18px;\">{{namaKlien}}<\/td>\r\n<td style=\"width: 30.9229%; height: 18px;\">Waktu Pemeriksaan<\/td>\r\n<td style=\"width: 25%; height: 18px;\">{{waktuPemerikasaan}}<\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 13.4298%; height: 18px;\">Pertemuan ke<\/td>\r\n<td style=\"width: 30.6473%; height: 18px;\">{{pertemuanKe}}<\/td>\r\n<td style=\"width: 30.9229%; height: 18px;\">Tempat Pemeriksaan<\/td>\r\n<td style=\"width: 25%; height: 18px;\">{{tempatPemeriksaan}}<\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 13.4298%; height: 18px;\">Kasus<\/td>\r\n<td style=\"width: 30.6473%; height: 18px;\">{{kasus}}<\/td>\r\n<td style=\"width: 30.9229%; height: 36px;\" rowspan=\"2\">Koordinator Psikologi<\/td>\r\n<td style=\"width: 25%; height: 36px;\" rowspan=\"2\">{{koordinatorPeikologi}}<\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 13.4298%; height: 18px;\">Pemeriksa<\/td>\r\n<td style=\"width: 30.6473%; height: 18px;\">{{pemeriksa}}<\/td>\r\n<\/tr>\r\n<\/tbody>\r\n<\/table>\r\n<p>&nbsp;<\/p>\r\n<table style=\"height: 456px; width: 100%; border-collapse: collapse; border-style: none;\" border=\"1\">\r\n<tbody>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 14.3526%; height: 18px;\" colspan=\"2\"><strong>Penampilan<\/strong><\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 14.3526%; height: 18px;\">Keadaan Kulit<\/td>\r\n<td style=\"border: 1px solid; border-collapse: collapse; height: 18px;\">\r\n<p>{{keadaanKulit}}<\/p>\r\n<p><span style=\"font-size: 10pt;\">(Bersih, Kotor, Penyakit Kulit, Luka \/ Bekas Luka)<\/span><\/p>\r\n<\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 14.3526%; height: 18px;\">Bentuk Tubuh<\/td>\r\n<td style=\"width: 19.4491%; height: 18px;\">\r\n<p>{{bentukTubuh}}<\/p>\r\n<p><span style=\"font-size: 10pt;\">(Gemuk, Sedang, Kurus)<\/span><\/p>\r\n<\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 14.3526%; height: 18px;\">Tinggi Badan<\/td>\r\n<td style=\"width: 19.4491%; height: 18px;\">\r\n<p>{{tinggiBadan}}<\/p>\r\n<p><span style=\"font-size: 10pt;\">(Tinggi, Sedang, Pendek, Stunting)<\/span><\/p>\r\n<\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 14.3526%; height: 18px;\">Pakaian<\/td>\r\n<td style=\"width: 19.4491%; height: 18px;\">{{pakaian}}<br \/><span style=\"font-size: 10pt;\">(Rapi, Kotor, Srampangan, Sederhana, Serasi, Mewa, Bersih, Biasa)<\/span><\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 14.3526%; height: 18px;\" colspan=\"2\"><strong>Sikap<\/strong><\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 14.3526%; height: 18px;\">Tindakan<\/td>\r\n<td style=\"width: 19.4491%; height: 18px;\">\r\n<p>{{tindakan}}<\/p>\r\n<p>(Sopan, Tegas, Ramah, Garang, Percaya diri, Kaku, Sulit Fokus, Kurang tahu aturan, Ceroboh, Tertekan, Dibuat-buat, Ragu-ragu, Malu-malu, Kontak Mata, Tidak bisa diam)<\/p>\r\n<\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 14.3526%; height: 18px;\"><strong>Penyampaian<\/strong><\/td>\r\n<td style=\"width: 19.4491%; height: 18px;\">&nbsp;<\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 14.3526%; height: 18px;\">Ekspresi<\/td>\r\n<td style=\"width: 19.4491%; height: 18px;\">\r\n<p>{{expresi}}<\/p>\r\n<p><span style=\"font-size: 10pt;\">(Tertutup, Terbuka, Mudah, Hati-hati, Dingin \/ datar, Membatasi diri, Sukar mencari kata-kata, Tenang, Gugup, Takut, Lancar, Banyak gerak dan isyarat<\/span><\/p>\r\n<\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 14.3526%; height: 18px;\">Penggunaan Kata<\/td>\r\n<td style=\"width: 19.4491%; height: 18px;\">\r\n<p>{{penggunaanKata}}<\/p>\r\n<p><span style=\"font-size: 10pt;\">(Dengan tekanan suara, Terpengaruh bahasa daerah, Disertai istilah bahasa asing, Biasa)<\/span><\/p>\r\n<\/td>\r\n<\/tr>\r\n<tr style=\"height: 46px;\">\r\n<td style=\"width: 14.3526%; height: 46px;\" colspan=\"2\"><strong>Mood<\/strong><\/td>\r\n<\/tr>\r\n<tr style=\"height: 46px;\">\r\n<td style=\"width: 14.3526%; height: 46px;\">Afek<\/td>\r\n<td style=\"width: 19.4491%; height: 46px;\">\r\n<p>{{afek}}<\/p>\r\n<p><span style=\"font-size: 10pt;\">(Euthymic, Manik, Depresif)<\/span><\/p>\r\n<\/td>\r\n<\/tr>\r\n<tr style=\"height: 46px;\">\r\n<td style=\"width: 14.3526%; height: 46px;\">Ekspresi Afektif<\/td>\r\n<td style=\"width: 19.4491%; height: 46px;\">\r\n<p>{{ekspresi afektif}}<\/p>\r\n<p><span style=\"font-size: 10pt;\">(Normal, Terbatas, Tumpul, Datar)<\/span><\/p>\r\n<\/td>\r\n<\/tr>\r\n<tr style=\"height: 46px;\">\r\n<td style=\"width: 14.3526%; height: 46px;\">Kesesuaian<\/td>\r\n<td style=\"width: 19.4491%; height: 46px;\">\r\n<p>{{kesesuaian}}<\/p>\r\n<p><span style=\"font-size: 10pt;\">(Sesuai, Tidak Sesuai)<\/span><\/p>\r\n<\/td>\r\n<\/tr>\r\n<tr style=\"height: 46px;\">\r\n<td style=\"width: 14.3526%; height: 46px;\">Empati<\/td>\r\n<td style=\"width: 19.4491%; height: 46px;\">\r\n<p>{{empati}}<\/p>\r\n<p><span style=\"font-size: 10pt;\">(Bisa, Tidak Bisa)<\/span><\/p>\r\n<\/td>\r\n<\/tr>\r\n<tr style=\"height: 46px;\">\r\n<td style=\"width: 14.3526%; height: 46px;\"><strong>Symtomps<\/strong><\/td>\r\n<td style=\"width: 19.4491%; height: 46px;\">\r\n<p>{{symtomps}}<\/p>\r\n<\/td>\r\n<\/tr>\r\n<\/tbody>\r\n<\/table>\r\n<p><strong>(T)opics<\/strong><\/p>\r\n<table style=\"border-collapse: collapse; width: 100%;\" border=\"1\">\r\n<tbody>\r\n<tr>\r\n<td style=\"width: 100%;\">{{topics}}<\/td>\r\n<\/tr>\r\n<\/tbody>\r\n<\/table>\r\n<p>&nbsp;<\/p>\r\n<p><strong>(I)ntervention:<\/strong><\/p>\r\n<table style=\"border-collapse: collapse; width: 100%;\" border=\"1\">\r\n<tbody>\r\n<tr>\r\n<td style=\"width: 100%;\">{{intervention}}<\/td>\r\n<\/tr>\r\n<\/tbody>\r\n<\/table>\r\n<p>&nbsp;<\/p>\r\n<p><strong>(P)lans &amp; Progresses :<\/strong><\/p>\r\n<table style=\"border-collapse: collapse; width: 100%;\" border=\"1\">\r\n<tbody>\r\n<tr>\r\n<td style=\"width: 100%;\">{{plans}}<\/td>\r\n<\/tr>\r\n<\/tbody>\r\n<\/table>\r\n<p>&nbsp;<\/p>\r\n<p><strong>(S)pecial Issues :&nbsp;<\/strong><\/p>\r\n<table style=\"border-collapse: collapse; width: 100%;\" border=\"1\">\r\n<tbody>\r\n<tr>\r\n<td style=\"width: 100%;\">{{specialIssues}}<\/td>\r\n<\/tr>\r\n<\/tbody>\r\n<\/table>\r\n<p>&nbsp;<\/p>"',
        //         "blank_template" => 0,
        //         "created_by" => 4,
        //         "created_at" => Carbon::now(),
        //         "updated_at" => Carbon::now()->addDays(5)
        //     ]
        // ];
        // Template::insert($template);

        //data keyword template
        $csvFile = fopen(base_path("database/data/template_keyword.csv"), "r");
        $firstline = true;
        while (($template_keyword = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                TemplateKeyword::create([
                    "id" => $template_keyword['0'],
                    "template_id" => $template_keyword['1'],
                    "keyword" => $template_keyword['2'],
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now()
                ]);    
            }
            $firstline = false;
        }
        fclose($csvFile);

        // $template_keyword = [
        //     [
        //         "template_id" => 1,
        //         "keyword" => 'Review Kasus'
        //     ],
        //     [
        //         "template_id" => 2,
        //         "keyword" => 'Pemeriksaan Pertama'
        //     ],
        //     [
        //         "template_id" => 2,
        //         "keyword" => 'Pemeriksaan Kedua'
        //     ],
        //     [
        //         "template_id" => 2,
        //         "keyword" => 'Pemeriksaan Ketiga'
        //     ]
        // ];
        // TemplateKeyword::insert($template_keyword);

        //data dokumen
        $dokumen = [
            [
                "uuid" => 'ff32908a-0c04-4b80-9089-246eb6f9d541',
                "template_id" => 1,
                "judul" => 'Review Kasus Caca Marica Hey Hey',
                "konten" => '"<ol>\r\n<li><strong>Deskripsi Proses<\/strong>Menghubungi klien terkait agenda asesmen lanjutan melalui hotline<\/li>\r\n<li><strong>Deskripsi Hasil<\/strong>\r\n<ul>\r\n<li>Klien menginformasikan bahwa saat ini kondisinya lebih baik<\/li>\r\n<li>Klien sedang berencana pindah ke rumah yang dekat dengan saudaranya&nbsp;<\/li>\r\n<li>Asesmen lanjutan diagendakan pada hari Jumat, 12 Mei 2023 pukul 13.30 WIB di kantor PPPA Provinsi DKI Jakarta dan klien bersedia hadir<\/li>\r\n<\/ul>\r\n<\/li>\r\n<li><strong>Rencana Tindak Lanjut<\/strong>Asesmen lanjutan sesuai jadwal&nbsp;<\/li>\r\n<\/ol>"',
                'nama_template' => 'Review Kasus', 
                'pemilik_template' => 'Manajer Kasus', 
                'created_by_template' => 'Alex Ferguson', 
                'created_at_template' => Carbon::now(), 
                'updated_at_template' => Carbon::now(), 
                'created_by' => 2,
                'created_at' => Carbon::now()
            ]
        ];
        Dokumen::insert($dokumen);

        //data keyword dokumen
        $dokumen_keyword = [
            [
                "dokumen_id" => 1,
                "keyword" => 'Review Kasus'
            ]
        ];
        DokumenKeyword::insert($dokumen_keyword);

        //dokumen_tl
        $dokumen_tl = [
            [
                "tindak_lanjut_id" => 1,
                "dokumen_id" => 1
            ]
        ];
        DokumenTl::insert($dokumen_tl);

        //data notifikasi & task
        // $notifikasi = [
        //     [
        //         "uuid" => '5b2483dd-b3f2-45e2-a272-6d1770d24bbe',
        //         "klien_id" => 1,
        //         "receiver_id" => 1,
        //         "kode" => 'T2',
        //         "type_notif" => 'task',
        //         "no_reg" => NULL,
        //         "from" => 'System',
        //         "message" => 'Kasus baru. Silahkan pilih Supervisor & Manajer Kasus',
        //         "kasus" => 'Caca Marica Hey Hey (30)',
        //         "url" => 'http://127.0.0.1:8000/kasus/show/456ab15f-1f30-48e1-a5c0-0e39c05a93ab?tab=kasus-petugas&tambah-petugas=1',
        //         "read" => 1,
        //         "created_by" => 1,
        //         "created_at" => Carbon::now(),
        //         "updated_at" => Carbon::now(),
        //         "deleted_at" => NULL
        //     ],
        //     [
        //         "uuid" => 'e111c9ef-845a-4025-bada-34387376c123',
        //         "klien_id" => 2,
        //         "receiver_id" => 1,
        //         "kode" => 'T2',
        //         "type_notif" => 'task',
        //         "no_reg" => NULL,
        //         "from" => 'System',
        //         "message" => 'Kasus baru. Silahkan pilih Supervisor & Manajer Kasus',
        //         "kasus" => 'Nina Bobo (1)',
        //         "url" => 'http://127.0.0.1:8000/kasus/show/cd0723c3-4505-466e-89bc-e1cc8e6e8b40?tab=kasus-petugas&tambah-petugas=1',
        //         "read" => 0,
        //         "created_by" => 1,
        //         "created_at" => Carbon::now(),
        //         "updated_at" => Carbon::now(),
        //         "deleted_at" => NULL
        //     ],
        //     [
        //         "uuid" => '7280b497-e6e3-4fe3-9a50-bf277cc96e00',
        //         "klien_id" => 1,
        //         "receiver_id" => 8,
        //         "kode" => 'T3',
        //         "type_notif" => 'task',
        //         "no_reg" => NULL,
        //         "from" => 'Muhammad Light Yagami',
        //         "message" => 'Kasus baru. Meminta persetujuan Supervisor',
        //         "kasus" => 'Caca Marica Hey Hey (30)',
        //         "url" => 'http://127.0.0.1:8000/kasus/show/456ab15f-1f30-48e1-a5c0-0e39c05a93ab?tab=settings&persetujuan-supervisor=1',
        //         "read" => 0,
        //         "created_by" => 1,
        //         "created_at" => Carbon::now(),
        //         "updated_at" => Carbon::now(),
        //         "deleted_at" => NULL
        //     ],
        //     [
        //         "uuid" => 'd26c7648-6fc0-4a9a-a942-6cc9e94a4550',
        //         "klien_id" => 1,
        //         "receiver_id" => 2,
        //         "kode" => 'T7',
        //         "type_notif" => 'task',
        //         "no_reg" => NULL,
        //         "from" => 'System',
        //         "message" => 'Klien sudah mengisi Surat Persetujuan Pelayanan. Silahkan lihat isinya untuk update informasi kasus',
        //         "kasus" => 'Caca Marica Hey Hey (30)',
        //         "url" => 'http://127.0.0.1:8000/kasus/show/456ab15f-1f30-48e1-a5c0-0e39c05a93ab?tab=kasus-persetujuan&row-persetujuan=bf4aa69d-e0f7-4f5c-a7c7-94468bb58d83&user_id=2&kode=T7&type_notif=task',
        //         "read" => 0,
        //         "created_by" => 1,
        //         "created_at" => Carbon::now(),
        //         "updated_at" => Carbon::now(),
        //         "deleted_at" => NULL
        //     ]
        // ];
        // Notifikasi::insert($notifikasi);

        //data log activity
        // $log_activity = [
        //     [
        //         "uuid" => '2921de61-0439-40d4-ac46-10ebd530bd2a',
        //         "klien_id" => 2,
        //         "message" => 'Petugas Penerima Pengaduan menginputkan data kasus baru',
        //         "ip" => '127.0.0.1',
        //         "browser" => 'Chrome 103.0.0.0',
        //         "device" => 'WebKit',
        //         "created_by" => 1
        //     ],
        //     [
        //         "uuid" => '532b1e9f-c9ce-42ec-ae83-67c1fd1b55a5',
        //         "klien_id" => 3,
        //         "message" => 'Petugas Penerima Pengaduan menginputkan data kasus baru',
        //         "ip" => '127.0.0.1',
        //         "browser" => 'Chrome 103.0.0.0',
        //         "device" => 'WebKit',
        //         "created_by" => 1
        //     ]
        // ];
        // LogActivity::insert($log_activity);

        // data catatan
        // $catatan = [
        //     [
        //         "uuid" => '532b1e9f-c9ce-42ec-ae83-67c1fd1b55a5',
        //         "klien_id" => 1,
        //         "catatan" => 'Mohon di TL sesuai kebutuhan klien',
        //         "created_by" => 8
        //     ]
        //     ];
        // Catatan::insert($catatan);

        // data m_keyword keyword
        // $m_keyword = [
        //     [
        //         "uuid" => '43a148be-9112-42f5-b537-f095fc5111cd',
        //         "jabatan" => 'Konselor',
        //         "keyword" => 'Pengukuran Awal'
        //     ],
        //     [
        //         "uuid" => '43a148be-9112-42f5-b537-f09lfc5111cd',
        //         "jabatan" => 'Konselor',
        //         "keyword" => 'Administrasi Tes Psikologi'
        //     ],
        //     [
        //         "uuid" => '43a148be-9112-42f5-b537-f0c5fc5111cd',
        //         "jabatan" => 'Konselor',
        //         "keyword" => 'Psikososial / Psikoedukasi '
        //     ],
        //     [
        //         "uuid" => '4la148be-9112-42f5-b537-f095fc5111cd',
        //         "jabatan" => 'Konselor',
        //         "keyword" => 'Pendampingan Psikologi'
        //     ],
        //     [
        //         "uuid" => '43a148be-9112-42fq-b537-f095fc5111cd',
        //         "jabatan" => 'Psikolog',
        //         "keyword" => 'Pengukuran Awal'
        //     ],
        //     [
        //         "uuid" => '43a148be-9112-42l5-b537-f095fc5111cd',
        //         "jabatan" => 'Psikolog',
        //         "keyword" => 'Administrasi Tes Psikologi'
        //     ],
        //     [
        //         "uuid" => '43a148be-9112-42f5-b537-f095fc5111cd',
        //         "jabatan" => 'Psikolog',
        //         "keyword" => 'Psikososial / Psikoedukasi '
        //     ],
        //     [
        //         "uuid" => '43a148be-9112-42x5-b537-f095fc5111cd',
        //         "jabatan" => 'Psikolog',
        //         "keyword" => 'Pendampingan Psikologi'
        //     ],
        //     [
        //         "uuid" => '43a148be-9112-42f5-b537-f0d5fc5111cd',
        //         "jabatan" => 'Advokat',
        //         "keyword" => 'Konsultasi Hukum'
        //     ],
        //     [
        //         "uuid" => '43a148be-9112-41f5-b537-f095fc5111cd',
        //         "jabatan" => 'Advokat',
        //         "keyword" => 'Pendampingan Kepolisian'
        //     ],
        // ];
        // MKeyword::insert($m_keyword);

        // data t_keyword keyword
        // $t_keyword = [
        //     [
        //         "tindak_lanjut_id" => 1,
        //         "jabatan" => 'Psikolog',
        //         "value" => '4'
        //     ],
        //     [
        //         "tindak_lanjut_id" => 1,
        //         "jabatan" => 'Hukum',
        //         "value" => '2'
        //     ],
        //     [
        //         "tindak_lanjut_id" => 2,
        //         "jabatan" => 'Psikolog',
        //         "value" => '1'
        //     ],
        //     [
        //         "tindak_lanjut_id" => 3,
        //         "jabatan" => 'Psikolog',
        //         "value" => '6'
        //     ],
        //     [
        //         "tindak_lanjut_id" => 4,
        //         "jabatan" => 'Psikolog',
        //         "value" => '4'
        //     ],
        //     [
        //         "tindak_lanjut_id" => 5,
        //         "jabatan" => 'Psikolog',
        //         "value" => '6'
        //     ],
        //     [
        //         "tindak_lanjut_id" => 6,
        //         "jabatan" => 'Psikolog',
        //         "value" => '1'
        //     ],
        //     [
        //         "tindak_lanjut_id" => 7,
        //         "jabatan" => 'Psikolog',
        //         "value" => '4'
        //     ]
        // ];
        // TKeyword::insert($t_keyword);

        $csvFile = fopen(base_path("database/data/m_keyword.csv"), "r");
        $firstline = true;
        while (($m_keyword = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                MKeyword::create([
                    "id" => $m_keyword['0'],
                    "uuid" => $m_keyword['1'],
                    "jabatan" => $m_keyword['2'],
                    "keyword" => $m_keyword['3'],
                    "jenis_agenda" => $m_keyword['4'],
                    "created_by" => $m_keyword['5'],
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                    "deleted_at" => NULL,
                ]);    
            }
            $firstline = false;
        }
        fclose($csvFile);
    }
}
