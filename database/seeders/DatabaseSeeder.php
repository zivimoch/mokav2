<?php

namespace Database\Seeders;

use App\Models\DifabelType;
use App\Models\Kasus;
use App\Models\KategoriKasus;
use App\Models\Klien;
use App\Models\KondisiKhusus;
use App\Models\Pasal;
use App\Models\ProgramPemerintah;
use App\Models\TindakKekerasan;
use App\Models\TindakLanjut;
use App\Models\User;
use Illuminate\Database\Seeder;
use Laravolt\Indonesia\Seeds\CitiesSeeder;
use Laravolt\Indonesia\Seeds\VillagesSeeder;
use Laravolt\Indonesia\Seeds\DistrictsSeeder;
use Laravolt\Indonesia\Seeds\ProvincesSeeder;

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
                "supervisor_layanan" => 0,
                "supervisor_id" => 0,
                "password" => '$2y$10$9BcBcEWaVUmAOrl2zZkaKeYRZaajkbtNFlAcpNTwkXDab9e00kqlq'
            ],[
                "uuid" => "43a348be-9f12-42f5-b567-f095f25111cd",
                "name" => "Manajer Kasus",
                "kotkab_id" => 4,
                "email" => "mk@moka.ol",
                "email_verified_at" => '2023-03-08 03:28:35',
                "jabatan" => 'Manajer Kasus',
                "supervisor_layanan" => 0,
                "supervisor_id" => 9,
                "password" => '$2y$10$9BcBcEWaVUmAOrl2zZkaKeYRZaajkbtNFlAcpNTwkXDab9e00kqlq'
            ],[
                "uuid" => "43a348be-9f12-42f5-b567-f09tfc5111cd",
                "name" => "Pendamping Kasus",
                "kotkab_id" => 4,
                "email" => "pk@moka.ol",
                "email_verified_at" => '2023-03-08 03:28:35',
                "jabatan" => 'Pendamping Kasus',
                "supervisor_layanan" => 0,
                "supervisor_id" => 9,
                "password" => '$2y$10$9BcBcEWaVUmAOrl2zZkaKeYRZaajkbtNFlAcpNTwkXDab9e00kqlq'
            ],[
                "uuid" => "43a348be-9f12-42f5-b567-f0952c5111cd",
                "name" => "Psikolog",
                "kotkab_id" => 4,
                "email" => "psikolog@moka.ol",
                "email_verified_at" => '2023-03-08 03:28:35',
                "jabatan" => 'Psikolog',
                "supervisor_layanan" => 0,
                "supervisor_id" => 13,
                "password" => '$2y$10$9BcBcEWaVUmAOrl2zZkaKeYRZaajkbtNFlAcpNTwkXDab9e00kqlq'
            ],[
                "uuid" => "43a348be-9112-42f5-b567-f095fo5111cd",
                "name" => "Advokat",
                "kotkab_id" => 4,
                "email" => "advokat@moka.ol",
                "email_verified_at" => '2023-03-08 03:28:35',
                "jabatan" => 'Advokat',
                "supervisor_layanan" => 0,
                "supervisor_id" => 12,
                "password" => '$2y$10$9BcBcEWaVUmAOrl2zZkaKeYRZaajkbtNFlAcpNTwkXDab9e00kqlq'
            ],[
                "uuid" => "43a348be-9112-42f5-b567-f095fc5111cd",
                "name" => "Paralegal",
                "kotkab_id" => 4,
                "email" => "paralegal@moka.ol",
                "email_verified_at" => '2023-03-08 03:28:35',
                "jabatan" => 'Paralegal',
                "supervisor_layanan" => 0,
                "supervisor_id" => 12,
                "password" => '$2y$10$9BcBcEWaVUmAOrl2zZkaKeYRZaajkbtNFlAcpNTwkXDab9e00kqlq'
            ],[
                "uuid" => "43a348be-9112-42f5-b567-f095fc5112cd",
                "name" => "Unit Reaksi Cepat",
                "kotkab_id" => 4,
                "email" => "urc@moka.ol",
                "email_verified_at" => '2023-03-08 03:28:35',
                "jabatan" => 'Unit Reaksi Cepat',
                "supervisor_layanan" => 0,
                "supervisor_id" => 12,
                "password" => '$2y$10$9BcBcEWaVUmAOrl2zZkaKeYRZaajkbtNFlAcpNTwkXDab9e00kqlq'
            ],[
                "uuid" => "43a348be-9112-42f5-b567-f095fc5011cd",
                "name" => "Supervisor Kasus",
                "kotkab_id" => 4,
                "email" => "spv@moka.ol",
                "email_verified_at" => '2023-03-08 03:28:35',
                "jabatan" => 'Supervisor Kasus',
                "supervisor_layanan" => 0,
                "supervisor_id" => 0,
                "password" => '$2y$10$9BcBcEWaVUmAOrl2zZkaKeYRZaajkbtNFlAcpNTwkXDab9e00kqlq'
            ],[
                "uuid" => "43a348be-9112-42f5-b767-f095fc5111cd",
                "name" => "Tenaga Ahli",
                "kotkab_id" => 4,
                "email" => "ta@moka.ol",
                "email_verified_at" => '2023-03-08 03:28:35',
                "jabatan" => 'Tenaga Ahli',
                "supervisor_layanan" => 1,
                "supervisor_id" => 0,
                "password" => '$2y$10$9BcBcEWaVUmAOrl2zZkaKeYRZaajkbtNFlAcpNTwkXDab9e00kqlq'
            ],[
                "uuid" => "43a348be-9112-42f5-b537-f095fc5111cd",
                "name" => "Tim Data",
                "kotkab_id" => 4,
                "email" => "timdata@moka.ol",
                "email_verified_at" => '2023-03-08 03:28:35',
                "jabatan" => 'Tim Data',
                "supervisor_layanan" => 0,
                "supervisor_id" => 0,
                "password" => '$2y$10$9BcBcEWaVUmAOrl2zZkaKeYRZaajkbtNFlAcpNTwkXDab9e00kqlq'
            ],[
                "uuid" => "43a348be-9112-42fs-b567-f095fc5111cd",
                "name" => "Kepala Instansi",
                "kotkab_id" => 4,
                "email" => "kepala@moka.ol",
                "email_verified_at" => '2023-03-08 03:28:35',
                "jabatan" => 'Kepala Instansi',
                "supervisor_layanan" => 0,
                "supervisor_id" => 0,
                "password" => '$2y$10$9BcBcEWaVUmAOrl2zZkaKeYRZaajkbtNFlAcpNTwkXDab9e00kqlq'
            ],[
                "uuid" => "43a348be-9112-42f5-b567-f095fo5111td",
                "name" => "Advokat Sebagai SPV",
                "kotkab_id" => 4,
                "email" => "advokat.spv@moka.ol",
                "email_verified_at" => '2023-03-08 03:28:35',
                "jabatan" => 'Advokat',
                "supervisor_layanan" => 1,
                "supervisor_id" => 9,
                "password" => '$2y$10$9BcBcEWaVUmAOrl2zZkaKeYRZaajkbtNFlAcpNTwkXDab9e00kqlq'
            ],[
                "uuid" => "43a348be-9f12-42f5-b567-f0952a5111cd",
                "name" => "Psikolog Sebagai SPV",
                "kotkab_id" => 4,
                "email" => "psikolog.spv@moka.ol",
                "email_verified_at" => '2023-03-08 03:28:35',
                "jabatan" => 'Psikolog',
                "supervisor_layanan" => 1,
                "supervisor_id" => 9,
                "password" => '$2y$10$9BcBcEWaVUmAOrl2zZkaKeYRZaajkbtNFlAcpNTwkXDab9e00kqlq'
            ],[
                "uuid" => "43a348be-9f12-42f5-b567-f09e2c5111cd",
                "name" => "Konselor",
                "kotkab_id" => 4,
                "email" => "konselor@moka.ol",
                "email_verified_at" => '2023-03-08 03:28:35',
                "jabatan" => 'Konselor',
                "supervisor_layanan" => 0,
                "supervisor_id" => 13,
                "password" => '$2y$10$9BcBcEWaVUmAOrl2zZkaKeYRZaajkbtNFlAcpNTwkXDab9e00kqlq'
            ],[
                "uuid" => "43a348be-9f12-42f5-b567-f09s2c5111cd",
                "name" => "Sekretariat",
                "kotkab_id" => 4,
                "email" => "sekretariat@moka.ol",
                "email_verified_at" => '2023-03-08 03:28:35',
                "jabatan" => 'Sekretariat',
                "supervisor_layanan" => 0,
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
                "created_at" => '2023-05-16 03:28:35',
                "updated_at" => '2023-05-16 03:28:35',
                "deleted_at" => NULL
            ]
        ];
        Kasus::insert($kasus);

        //data klien
        $klien = [
            [
                "uuid" => "35db5be8-551a-4a8f-91d1-e8ea392q5515",
                "kasus_id" => 1,
                "no_klien" => NULL,
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
                "status_pendidikan" => 'Lulusa dan Tidak Melanjutkan (Tamat Belajar)',
                "pendidikan" => 'Perguruan Tinggi',
                "pekerjaan" => 'Ibu Rumah Tangga',
                "status_kawin" => 'Cerai Hidup',
                "jumlah_anak" => 0,
                "hubungan_klien" => 'Bukan Siapa-Siapa / Tak Dikenal',
                "no_lp" => NULL,
                "pengadilan_negri" => NULL,
                "isi_putusan" => NULL,
                "lpsk" => 0,
                "file_ttd" => NULL,
                "desil" => NULL,
                "created_by" => NULL,
                "created_at" => '2023-05-16 03:28:35',
                "updated_at" => '2023-05-16 03:28:35',
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
            ]
        ];
        DifabelType::insert($difabel_type);
        //data tindak kekerasan
        $pasal = [
            [
                "klien_id" => 1,
                "value" => 'UNDANG-UNDANG REPUBLIK INDONESIA NOMOR 12 TAHUN 2022 TENTANG TINDAK PIDANA KEKERASAN SEKSUAL'
            ]
        ];
        Pasal::insert($pasal);
    }
}
