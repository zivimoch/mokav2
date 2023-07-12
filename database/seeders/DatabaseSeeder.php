<?php

namespace Database\Seeders;

use App\Models\Agenda;
use App\Models\DifabelType;
use App\Models\Kasus;
use App\Models\KategoriKasus;
use App\Models\Klien;
use App\Models\KondisiKhusus;
use App\Models\Layanan;
use App\Models\Pasal;
use App\Models\Pelapor;
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
                "created_at" => '2023-05-16 03:28:35',
                "updated_at" => '2023-05-16 03:28:35',
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
                "file_ttd" => NULL,
                "desil" => NULL,
                "hubungan_pelapor" => 'Bukan Siapa-Siapa / Tak Dikenal',
                "created_by" => NULL,
                "created_at" => '2023-05-16 03:28:35',
                "updated_at" => '2023-05-16 03:28:35',
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
                "file_ttd" => NULL,
                "desil" => NULL,
                "created_by" => NULL,
                "created_at" => '2023-05-16 03:28:35',
                "updated_at" => '2023-05-16 03:28:35',
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
                "created_at" => '2023-05-16 03:28:35',
                "updated_at" => '2023-05-16 03:28:35',
                "deleted_at" => NULL
            ]
        ];
        Petugas::insert($petugas);

        //data agenda
        $agenda = [
            [
                "uuid" => '2a83d123-3c86-41f8-aee1-ca22l262f462',
                "klien_id" => NULL,
                "judul_kegiatan" => "Koordinasi Terkait PP1",
                "tanggal_mulai" => '2023-06-05',
                "jam_mulai" => '08:00:00',
                "keterangan" => 'koordinasi dengan konselor',
                "created_by" => 2,
                "created_at" => '2023-06-07 04:51:53',
                "updated_at" => '2023-06-07 04:51:53'
            ],
            [
                "uuid" => '513c0e13-75a4-4684-a5be-74426786fd8c',
                "klien_id" => NULL,
                "judul_kegiatan" => "Membuat tiket MOKA",
                "tanggal_mulai" => '2023-06-05',
                "jam_mulai" => '08:00:00',
                "keterangan" => 'koordinasi dengan konselor',
                "created_by" => 2,
                "created_at" => '2023-06-07 04:51:53',
                "updated_at" => '2023-06-07 04:51:53'
            ],
            [
                "uuid" => '513c0e13-75a4-4684-ad8e-74426786fd8c',
                "klien_id" => NULL,
                "judul_kegiatan" => "Istirahat",
                "tanggal_mulai" => '2023-06-05',
                "jam_mulai" => '12:00:00',
                "keterangan" => '',
                "created_by" => 2,
                "created_at" => '2023-06-07 04:51:53',
                "updated_at" => '2023-06-07 04:51:53'
            ],
            [
                "uuid" => '513c0e13-75a4-4684-a58e-7442a786fd8c',
                "klien_id" => NULL,
                "judul_kegiatan" => "Koordinasi dengan MK",
                "tanggal_mulai" => '2023-06-05',
                "jam_mulai" => '13:00:00',
                "keterangan" => 'Berdiskusi dengan manager kasus terkait intervensi lanjutan klien TPPO',
                "created_by" => 2,
                "created_at" => '2023-06-07 04:51:53',
                "updated_at" => '2023-06-07 04:51:53'
            ],
            [
                "uuid" => '513c0e13-75a4-46v4-a58e-74426786fd8c',
                "klien_id" => NULL,
                "judul_kegiatan" => "Koordinasi dengan Advokat",
                "tanggal_mulai" => '2023-06-05',
                "jam_mulai" => '15:00:00',
                "keterangan" => 'Berkoordinasi dengan advokat, satpel dan psikolog terkait intervensi masalah NA dan rencana reintegrasi klien NA',
                "created_by" => 2,
                "created_at" => '2023-06-07 04:51:53',
                "updated_at" => '2023-06-07 04:51:53'
            ],
            [
                "uuid" => '513c0e13-75a4-4684-a58e-74426716fd8c',
                "klien_id" => NULL,
                "judul_kegiatan" => "Koordinasi dengan satpel & tenaga layanan",
                "tanggal_mulai" => '2023-06-06',
                "jam_mulai" => '08:00:00',
                "keterangan" => 'Berdiskusi dengan satpel dan tenaga pelayanan terkait agenda visit klien',
                "created_by" => 2,
                "created_at" => '2023-06-07 06:00:14',
                "updated_at" => '2023-06-07 04:51:53'
            ],
            [
                "uuid" => '513c0e13-75a4-46a4-a58e-74426786fd8c',
                "klien_id" => NULL,
                "judul_kegiatan" => "Kunjungan rumah klien",
                "tanggal_mulai" => '2023-06-06',
                "jam_mulai" => '09:00:00',
                "keterangan" => 'Melakukan kunjungan rumah klien NA untuk persiapan reintegrasinya  ',
                "created_by" => 2,
                "created_at" => '2023-06-07 04:51:53',
                "updated_at" => '2023-06-07 04:51:53'
            ],
            [
                "uuid" => '513c0e13-75a4-4684-a58e-744f6786fd8c',
                "klien_id" => NULL,
                "judul_kegiatan" => "Istirahat",
                "tanggal_mulai" => '2023-06-06',
                "jam_mulai" => '12:00:00',
                "keterangan" => '',
                "created_by" => 2,
                "created_at" => '2023-06-07 04:51:53',
                "updated_at" => '2023-06-07 04:51:53'
            ],
            [
                "uuid" => '513c2e13-75a4-4684-a58e-74426786fd8c',
                "klien_id" => NULL,
                "judul_kegiatan" => "Koordinasi dengan advokat",
                "tanggal_mulai" => '2023-06-06',
                "jam_mulai" => '13:00:00',
                "keterangan" => 'Melakukan diskusi dengan advokat dan satpel terkait re-integrasi klien NA',
                "created_by" => 2,
                "created_at" => '2023-06-07 04:51:53',
                "updated_at" => '2023-06-07 04:51:53'
            ]
        ];
        Agenda::insert($agenda);

        //data tindak lanjut
        $tindak_lanjut = [
            [
                "uuid" => '2a83d123-3c16-41f8-aee1-ca22b262f462',
                "agenda_id" => 1,
                "tanggal_selesai" => "2023-06-05",
                "jam_selesai" => '10:00:00',
                "lokasi" => 'Kantor Pusat PPA DKI Jakarta',
                "catatan" => 'hasil koordinasi disepakati tanggal PP1 adalah minggu depan',
                "created_by" => 2,
                "validated_by" => 2,
                "created_at" => '2023-06-07 04:51:53',
                "updated_at" => '2023-06-07 04:51:53'
            ],
            [
                "uuid" => '2a83d123-3c86-41f8-aee1-ca22b2c2f462',
                "agenda_id" => 2,
                "tanggal_selesai" => "2023-06-05",
                "jam_selesai" => '00:00:00',
                "lokasi" => 'Kantor Pusat PPA DKI Jakarta',
                "catatan" => 'pemberian tiket sudah dilakukan',
                "created_by" => 2,
                "validated_by" => 2,
                "created_at" => '2023-06-07 04:51:53',
                "updated_at" => '2023-06-07 04:51:53'
            ],
            [
                "uuid" => '2a83d123-3c86-41f8-aee1-ca22b26bf462',
                "agenda_id" => 3,
                "tanggal_selesai" => "2023-06-05",
                "jam_selesai" => '13:00:00',
                "lokasi" => 'Kantor Pusat PPA DKI Jakarta',
                "catatan" => NULL,
                "created_by" => 2,
                "validated_by" => 2,
                "created_at" => '2023-06-07 04:51:53',
                "updated_at" => '2023-06-07 04:51:53'
            ],
            [
                "uuid" => '2a83d123-3c86-41f8-aee1-ca22b262f462',
                "agenda_id" => 4,
                "tanggal_selesai" => "2023-06-05",
                "jam_selesai" => '15:00:00',
                "lokasi" => 'Kantor Pusat PPA DKI Jakarta',
                "catatan" => 'hasil diskusi dengan MK lain terkait intervensi lanjutan klien TPPO adalah, perlu adanya penjadwalan / pemberian tiket ke layanan-layanan terkait',
                "created_by" => 2,
                "validated_by" => 2,
                "created_at" => '2023-06-07 04:51:53',
                "updated_at" => '2023-06-07 04:51:53'
            ],
            [
                "uuid" => '2a83d123-3c86-41f8-abe1-ca22b262f462',
                "agenda_id" => 5,
                "tanggal_selesai" => "2023-06-05",
                "jam_selesai" => '16:30:00',
                "lokasi" => 'Kantor Pusat PPA DKI Jakarta',
                "catatan" => 'Hasil koordinasi ditentukan siapa yang akan mengintervensi klien. Tiket akan segera dibuatkan',
                "created_by" => 2,
                "validated_by" => 2,
                "created_at" => '2023-06-07 04:51:53',
                "updated_at" => '2023-06-07 04:51:53'
            ],
            [
                "uuid" => '2a83d123-3c86-41f8-aee1-ca22b2t2f462',
                "agenda_id" => 6,
                "tanggal_selesai" => "2023-06-06",
                "jam_selesai" => '09:00:00',
                "lokasi" => 'Kantor Pusat PPA DKI Jakarta',
                "catatan" => 'hasil dari koordinasi adalah kesepakatan agenda visit yaitu minggu depan',
                "created_by" => 2,
                "validated_by" => 2,
                "created_at" => '2023-06-07 04:51:53',
                "updated_at" => '2023-06-07 04:51:53'
            ],
            [
                "uuid" => '2a81d123-3c86-41f8-aee1-ca22b262f462',
                "agenda_id" => 7,
                "tanggal_selesai" => "2023-06-06",
                "jam_selesai" => '00:00:00',
                "lokasi" => 'Kantor Pusat PPA DKI Jakarta',
                "catatan" => NULL,
                "created_by" => 2,
                "validated_by" => 2,
                "created_at" => '2023-06-07 04:51:53',
                "updated_at" => '2023-06-07 04:51:53'
            ],
            [
                "uuid" => '2a83d123-3c81-41f8-aee1-ca22b262f462',
                "agenda_id" => 8,
                "tanggal_selesai" => "2023-06-06",
                "jam_selesai" => '13:00:00',
                "lokasi" => NULL,
                "catatan" => NULL,
                "created_by" => 2,
                "validated_by" => 2,
                "created_at" => '2023-06-07 04:51:53',
                "updated_at" => '2023-06-07 04:51:53'
            ],
            [
                "uuid" => '2as3d123-3c86-41f8-aee1-ca22b262f462',
                "agenda_id" => 9,
                "tanggal_selesai" => "2023-06-06",
                "jam_selesai" => '15:00:00',
                "lokasi" => 'Kantor Pusat PPA DKI Jakarta',
                "catatan" => 'hasil dari diskusi adalah persiapan2nya',
                "created_by" => 2,
                "validated_by" => 2,
                "created_at" => '2023-06-07 04:51:53',
                "updated_at" => '2023-06-07 04:51:53'
            ]
        ];
        TindakLanjut::insert($tindak_lanjut);


        //data tindak lanjut
        $riwayat_kejadian = [
            [
                "uuid" => '2a81d123-3a16-41f8-aee1-ca22a262fc62',
                "klien_id" => 1,
                "tanggal" => "2023-06-05",
                "jam" => '10:00:00',
                "keterangan" => 'Klien pergi hendak pergi ke pasar menggunakan transportasi umum (angkot)',
                "created_by" => 1
            ],
            [
                "uuid" => '5a81da23-3a16-41f8-aee1-ca22a162fc62',
                "klien_id" => 1,
                "tanggal" => "2023-06-05",
                "jam" => '11:00:00',
                "keterangan" => 'Klien sampai di pasar dan berbelanja apel',
                "created_by" => 1
            ],
            [
                "uuid" => '5aa1da23-3a16-4sf8-dee1-ca22a462fc62',
                "klien_id" => 1,
                "tanggal" => "2023-06-05",
                "jam" => '12:00:00',
                "keterangan" => 'Klien pergi solat di mesjid dekat pasar',
                "created_by" => 1
            ],
            [
                "uuid" => '46a1da23-3a16-4sf8-dee1-ca22a46sfc62',
                "klien_id" => 1,
                "tanggal" => "2023-06-05",
                "jam" => '13:00:00',
                "keterangan" => 'Klien main ke TimeZone',
                "created_by" => 1
            ],
            [
                "uuid" => '56a1wa23-3a16-4sf8-dee1-ca22az6sfc62',
                "klien_id" => 1,
                "tanggal" => "2023-06-05",
                "jam" => '14:00:00',
                "keterangan" => 'Klien makan somay aa kasep',
                "created_by" => 1
            ],
            [
                "uuid" => '46a1wa23-1a16-4sf8-dee1-ca22a16sfc62',
                "klien_id" => 1,
                "tanggal" => "2023-06-05",
                "jam" => '15:00:00',
                "keterangan" => 'Klien pulang ke rumah',
                "created_by" => 1
            ],
            [
                "uuid" => '66a1wa23-1a16-4sf8-dee1-c322a16sfc62',
                "klien_id" => 1,
                "tanggal" => "2023-06-05",
                "jam" => '16:00:00',
                "keterangan" => 'Klien cuci tangan dan kaki lalu bobo',
                "created_by" => 1
            ]
        ];
        RiwayatKejadian::insert($riwayat_kejadian);

        //data template
        $template = [
            [
                "uuid" => '66a1wa23-1a16-4sf8-dee1-c322a16sfc62',
                "nama_template" => '[F-PSI-01] Form Pemeriksaan Psikologi',
                "pemilik" => 'Psikolog',
                "konten" => '"<p style=\"text-align: center;\"><img src=\"data:image\/png;base64,iVBORw0KGgoAAAANSUhEUgAAAioAAABiCAIAAADxxm\/MAAAACXBIWXMAAA7EAAAOxAGVKw4bAAAgAElEQVR4nO2dZ1QUSdeAa4YZcs4CkpMKKoIiBgRMIOoSRTEACgoGxJwzKwbMrmlVELMiigoiqCCKCRBRQXJGcmYIk\/r7UWt\/s5MYENd133oOhzNdU+HWrZ6+3VXV9xIwDAMIBAKBQPyzEH+2AAgEAoH4XwSZHwQCgUD8BJD5QSAQCMRPAJkfBAKBQPwEkPlBIBAIxE8AmR8EAoFA\/ASQ+UEgEAjETwCZHwQCgUD8BJD5QSAQCMRPgMSZ1L9+ENraKDV19RiGtba2SktLE4kEPR2tfqwfQiAQ+r1OBAKBQPw42M0PhmHfaX6qa+pycnMzMj6kpmXUNzQQCJi4mDiBAISEhBgMBgZAV2fnYJNh5sMHy8rImJubqygrfU9zANkeBAKB+AUhsBmbPpuf9nbKx0+fb9y6U1RUKCkpaWBgaGczXkVVRUJcQkJCHAACmUyi0egAYG3tlA5Ke1V1dWJSSltbc1Nj41zPOWbDh6uo9NEOEQgEZIEQCATi16IfzE97OyUx+eX16zfq6xtmzpxuYz3e2MiARCJhGNba2sZgMgGGUalUERHhtrZ2cXFxYWFhAoEgKSlBIBBoNNrHz9lPnybm5uXr62nP9Zw9UEOjt7YEmR8EAoH45fgu88NkMj99\/rLvwMHGpqaAJUumTLYTFxPFMKymti4942NlRVn80+eamtrlZcVfv1aZmw17l\/ZeWUVVUUGhm9rt6DCVTCLb2VrLyUoTicSm5tZHcfE3b92aNNFusa+PiIhIL\/rQH+aHTqfn5ORgGEalUiUkJPT19UkkUkdHR1FRkZKSkoqKCsz2+fNnaWlpTU1NeFhYWFhYWAgAMDAw0NHRwfMAANTV1eXk5GCezs5O1rbk5OTU1dX5tAsTWTs4ZMgQmCgjIzNw4EA24dlazM3NpdFogwcPJhKJAIDi4uKOjo4hQ4ZwzQyrFRcX19XVhRlycnIkJSU1NDR41d9jEa5dVlFR4dUpJpNJpVIlJSV1dXWFhYV5qYW\/PLASBQUFfCB6HD7BlQ8AqK+vr66uJhKJgwcPhl+Vl5e3tLRISEjo6OjgMnR3d0tISOjq6oqKiuJN9KrXnB3pl4Hu82j2SlFcu\/Y9Ku3tT7IPHexR7X1TWp8Lci2C\/\/Dhjwsf9F8b7O8wmUyGYHR2du3cE2I+auyFsMuUjk6YGP\/0eWFx6aSpjhMmThs+cpzdlJmLl68zGDRUVV3TdtK035xdR421NR89wWdJ4FzvxePt7Kc4uqzdsC0q+iGdTmcwGM0trcdPnpnu5P7yZYqAYjAYDCaTiX039fX1UCFwUNXV1ZOTk1NSUgAAGzZswLMBAFxcXDAMo9PpHh4euBqnTZsGM3z48AGmrF27FqYMGjSITeeLFy\/m3y6eCBEVFcUwrKGhAQAwd+5cNsk5W\/Ty8gIAPHr0CP50FRUVp0yZwiszrFZMTKyiogKmKCsrL1q0iE\/9PRbh2mWunWLrvqKi4rNnz3iphZc8bDVramrevXsXwzA+w9db5WMYtnXrVpjS2NgIU8aMGQMAGDduHGdVsrKyUP996zVbR\/ploPs8mr1SFNeu9YtKe\/xJ9rmD\/NXeZ6X1rSCv09vDwwPDsKysLDKZPGvWLOw\/QR\/tZ3FJmcec+aVlZZG3rnvNn8NkMvMLikOPnLh+\/WZDfb2SsrLJEOPZsz2oNGp9fe3UKVMXL15iZ2ejOXDgNPvJsrIyYqJilRUVZBJJWkqitbUlNPRIc0vrs8RkMokU4O8bun\/vyTN\/Hj72B5VK7Zt4fUBMTAwAsHLlSjqd\/v79+7a2tg0bNsA7bjKZjGcjkUhCQkIAgOfPn9+8efPAgQN0Or2lpeXEiRMww40bN8zMzEaMGHH37l2Y8uDBg\/Ly8uDgYABAbGxsUVHRrl27+LcLE5cuXVpWVlZQUJCamgoAgHfTnM+FnC3u3btXUlLy6NGjAIBbt261trYeO3aMV2YJCQn4ISgoCH4QFhaGAvS5CNcuc+0UTFy1ahWDwcjIyKBQKIcPH+alFl7ywMxr1qypqqqKiopiMBju7u5paWl8hq+3ygcA1NTUGBgYAABevHgBAGhubn737p2+vn5bWxte1dq1axkMxtu3b5ubm8+dO4en96rXnB3pl4Hu82j2SlFcu\/Y9KhX8J9nnDvJXe5+V1reCvE5vMplMpVLnzZtnamp68eJF8J+gL+Yn\/f2HRYv9ra3HHw3drzlQ\/c27dN\/FS1euXnP12nVjY6NHj594uLstmDdnqZ\/3pQunTx8PPRCye8fWjZs3rDl86ODWTeuvhP+5fvWy40cOLvZbRKPSKB2dwiKiW7bt2r5rz5GT5yorq3R1tE+fONrU1LR9V3B7e3u\/95kr8AxmMBgEAsHMzExHR6erq4vzXBcWFoY5MQwDAKSkpFRXV0tLS8NHaSaTeeXKFScnp+nTpxcWFsIzWE9PT0NDQ0ZGBgCgpKSko6OjqqrKv12YSCKRBg4cqKenZ2JigudknYPi1aKamtqmTZseP36cnZ0dGhq6adMmY2NjXplhtS4uLpGRkVFRUbCPeCt9KMKry3w6RaPRAADDhg2TlZWFkypc1cJfHhKJpKqq6uzsHBERQafTjx49ymf4eqt8AEB5efmkSZOIRGJMTAwAICoqSk9Pz8DAoLGxEa+KyWQCAJSVlYlEooWFBatsgveasyP9MtB9Hs0+nKVsXfselQr+k+xzB\/mo\/XuU1r8\/NxKJtGzZss7OztjYWNyG\/er02vykpWds3LzNe8H8wOX+oqIid+\/HlJaV02h0ExPToUOHFRWXTHOYMsPR3mz4sIbGppbm5sio+7uC9y9ZFuQXEBiwfPXmbXtu3o6qr6+XkJBwmjHtjxOH\/f28rcdZFRUXqQ9QTU19t2X7rjfv0khk0paN6zTUNXbuDm5r+ycsEBzjioqKuLi4oKCgzMxMPz8\/eJaznusiIiJwKsDW1tbBwSE6OlpbW9vHxwc+IMfHx1dUVLi5ubm4uAAArl+\/zla\/gO3CxIiICD09PU1NzWvXruE52SZ8ebUYFBSkqKi4du3axsbGTZs28ckMq50+fbq5ufmyZcuam5tFRERwaftQhFeX+XTq06dPJ0+enDlzprGx8e+\/\/85LLfzlwZ+VbWxsxMTE8vPz+Qxfb5UPACgrK1NXV7eysnrw4AGGYdeuXZsxY4aEhAQceljq5s2blpaWgwYNGjdu3LJly\/rWa86O9MtAf89o9vYsZeva96hU8J9knzvIR+3fo7T+\/bldvXr1\/Pnz06dPxxe9\/gNwee2UD5kfP2\/asn3u3DkL5s1pb2\/\/+Dln374DYuLiRKIQncE4EBJsoK\/T0tL66PHTmNiYLzm5ZLKwkaGhlaW5lJS0EInMYNAp7W0fPmbv3LOvrbXF2Nhw4sRJE23Gj7EaXV5ZdfbcxY8fM43NRxw7cdLd1dnd1TlgyaKTp8\/t2hO8Z9cOzgfb\/gXetyYkJOTl5RkZGT169Mje3j4vLw8AQKfT8Wx0Oh1OghGJxIcPH169ejUkJCQ8PDwjIyM9Pf3ChQtiYmLw0VhYWPjmzZsHDx6Evw34tARb6bFd+EsYOXLkvHnzaDTaiBEj8Jxs5odXi+Li4l5eXocOHQoNDcXn67hmxvt1\/vz5UaNGbdu2TVxcHPu2\/aQPRXDYugw\/cO1UQUHB1atX09LSbGxsZGVleamFlzwwM7zjhmXpdLqCggLsONfh663yAQClpaXS0tLu7u5BQUEJCQlJSUkhISGnT5\/u7Oxsb2+HeweMjY3nzp2bn59\/7NgxS0vLjx8\/wrK96jVnR\/ploIlEYp9Hs7dnKVvXuA69gCoV\/CfZ59OVj9r7XGffCvI5vR0cHGg0WmhoqImJCVzz+y\/AthbEZ+tBaVnFhIlTz1+8BPcIzPL0Hms9cco0JyfX2afOXGhobKLT6Vev37YabzvJfsbFS1fKKr7y2S9QVV1783aUk+tsyzETLoRdptFoNbV1x\/7402K0tb6x6dPEF7W19VQqlUqlhh4+vmrthh+99QDu1PLz82NNbG1tBQB4e3vDQ7hsuGvXLtY8dDp9zpw5AIDExERhYWETExMPDw8PDw+4tycxMRFmg4tDKSkpgrQLE1l3KOCJgYGBeEpdXR2fFs+fPw8AePLkCf\/M8CISFhaGYdju3bvJZPKQIUNWrlzZtyKssHWZT6d8fX0xDIM3xcHBwbzUwksetpojIyMBACdPnuxx+ARXfm1tLQAgPDz869evRCJxwoQJRkZGGIatWLECsOz08\/f3h\/lXrlwJAMjKyupDrzk70i8D\/T2j2duzlK1r36NSwX+Sfe4gL7V\/T539+HOD4vn4+DQ3N2toaEhJSZWWlmL\/CQQ1P11dXbPmzN+z9wCVSq2tqz96\/KT5aOvR4+yePE18l\/qewWB8yPxs7+g009n9bWo6LEKj0fLLvpRWFcFdbbzIyPw0b8Eia7spr968g0bObsr0ZYGrNbT0b92JZjAYFErH+k3bb0Xe\/aHmB6524qc1jpWVlaSk5IMHDwoKCnx8fIhE4sePHzEMKysri4uLKywszMrKcnV1JRKJcBtPTEwMLHjv3j3W6xFcW37+\/Lkg7cLf2JQpU+7fvx8ZGXn16tWKigqY093dPTo6+vbt21euXNm3bx+fFk+dOgW+bYvCMAwuSnNmhqtrZ8+exTCMTqePHDkSABAQENC3IqywdZlrp2Cil5cXhmFMJlNXV1dFRYVKpXJVCy958JoTExMPHz4sJSVlZmbW1dXFZ\/h6q3y4Wh4ZGYlhmJ2dHQBgz549GIbB+a5Xr17BUs7OztnZ2TExMXp6egoKChQKpVe95tURXh3v1UB\/z2gKriiuXYNGorcq7e1Pss8d5HP+9LnOfvy5QfHmzZuHYRhcLpo+fTr2n0Ag80On048cOzVnnk9DQ2NXV9eqtZusJ04zGzVuqqNzbV19R2fntRu3LcdO+PPipbb2dliku7vrVPTvI4NkRq2Su5F4jkaj8rFAHR2d12\/eGWNtd+KPs+3tlKeJyfO9\/UaMHHvw8IkTp\/5kMBhfq6pnOLnn5Ob9OPNTV1cHAJg9ezZbenZ29rBhwwAAAAAxMbETJ07A9NOnT4NvyMvLnzt3btSoUUQisb29HWaAy6cDBgyAhyEhIQCAp0+fCtIuTGQlISGBM3Ho0KF8Wjxy5AgAAN9Cyks8WO3Ro0dh+sePH4lEIvzN96EIK2xd5tMpT09PmGfLli3wksRVLfzlgUhKSnp7ezc0NPAfvt4qH94Rw0sDXJT+\/PkzhmFwE2N0dDRrKTk5uZkzZ3748KFvvebsCP9TS8CB\/p7R7O1Zyta1sLCwPqtU8J9knzvI5\/zpc539\/nPDN1tbW1sDAGJjY7FfH4FeOy0uKZs1Z15E2HkjQ\/2Ll659zvqSlPR05YrAYcNMhwwyOn\/xUuyjR+vXrZ0wfgxepKAye8VpF4yAAQDESVJ\/LL83QIH9hSw2Pn3+snP3HmNj403r1xQUlSxZuqK7q9PKaozXfE\/LkeYvX725FHH5zB\/H2LaXgH\/E60FFRUVdXZ2hoSHrnpPS0tL6+noZGRlNTU04T434WVCp1M7OTgzDZGRkOE8GrsPX78CbISEhIV7bTASBf0cQOP07pkjtPwWhnTt38s9BpdJ27dk7duyYGY72GZmfDh0+SmcwdHR07WwnjDQffv5iRNzjx\/tD9o60MGMtFZ92T4QkttPzzMxR87NK0hVlVHVUDfk3pKKsNNrS8l70\/Q8fP89ydTI3G\/72bVp3V+e4cWPl5GT1dLRepLzq6qYaG7HX8w+YH2lp6QEDBrDZGFlZWTU1NXl5+e+53CD6BSEhIVFRUVFRUa5nAtfh63eIRKKQkNB3vovOvyMInP4dU6T2n0LPP5X8gsLXr98sXeLb3U29dPmaoYFhZUW5grzs+LGjYx4lREVFhewNHjLYiK1USVW2vLTiQBXtgSraImSRwoovgkijpamxN3jXhw8ZtyKjRlqMmOvpsW3LpkdxcXt+308gENauDrpx83Zra1tfOopAIBCIfxM9bLym0ehnzp1f6OMtLi525+791LT0cWNGr1oVZDN+bHll1c5de44fPTRkELvtodKoX2oz2ymtnrbLOrsoH0peksiC3hJqqKuFHtjv4Tlv+LBh7m4uixYvKy4ulJOTL6+s0tRQMzI0SEp+OXO6Q1\/6ikAgEIh\/DT1YhdKysowPH+Z5zqbR6OYjzOIe3h07xkpjgIq8nOzmLdt8vBeMsRrFWaq+paa+uUZSTNon1G7lOTcJUdn8quzG1nrOnFwZMtgoePfODZs2EQjgctjZRYv86hsag0MOAgDmz5sbHx9P\/bZDH4FAIBC\/KD2Yn7vRD8daWUlLS+YXFG3ZvuvMuQtDTU3GWFm+eZtaWlrqvWAu15nusrr8mpaytKLnxU05eTWZeTWZVU3l9a3VgovlOG0qiSwcE\/uY0tH57OkTYTKpuqqqqLhMT1ero7M763NW73qJQCAQiH8Z\/MwPpaMzLS3NwcEew7Ck5Je5uXlxcY9Lyyo6O7vO\/nl+aYC\/lJQkZykMw5IyYzppHayJTR21GQWvBReLTCItC\/APvxTBZDDGjBkzfPgIPT39xOcvAAAzpju8TX0veFUIBAKB+BfCz\/wUFZdQ2inmI4YzGAwlRQV1dXUjI6MRw03zC4oKC4ucZk7nWuprfdnz7Iec6XEZtyhdvfDeZmdjTaczMj9lTZ5o87Wq6tWrlKh796lUmsmQIe9S33LuDkcgEAjELwQ\/81NZUaGorCwlKZGannnw0NH6hkZ1dXVJScmHsXEzpjuKinKPCHcnJYwsRNZSNGBN1JTVL63Je5X1hDWxvbMt4V3026znXG0JiSTkMcstKuqekaG+u8vM7u5uGWlpJsY00NdVUFCqrqntfWcRCAQC8W+B3863F6\/eWo8bAwAwG2YyfbrD3ahor3lzKJSO9+lpgYGBXItU1VfEpF5ZMnX7tZcnWNOH6oxSkFKNeHZ0wrBpwqS\/tur\/Eb0r4sURYZLISd\/osaaTOWuztLS8E3W3qrq2urZeVlbuc9bnW5HRXvM8REXFPmRkDHCw72OnEb8IfIJscoYKxcnIyCgoKFBTUxs9ejR8JSsnJ4dOpw8aNAge1tXV1dTUaGhoVFRUwECZ\/GNQssW0hZnZImzyipjJNVSloaFhXl4eWw2QlpaW8vJyDQ0N6IQU9D72JZ9QsLi6+Efg5RUmFYHoZ9i8ILA63Znl6ZWYlEyj0U6cOjt5mvPQEaPz8wuyv+TaTp7WTung6v9mR8TSdefmx765NXy5mLE\/wP9s12s+Tbtvv8Uo7t0dPLPvkanG\/mBwAPHqkxNca6PR6PbTnVLT38c\/SQpas8FrYcCBQ8cYDMatyLtRd+\/1r9MdxL8Q\/kE22UKFYhhWU1MDXZJATExM8vPzMQwbPXo0AAB6wcG+ObV8\/fo1+ObLhFcMSq4xbaEAbBEneUXM5BqqkmsNEOiK5urVq\/Cwt7Ev+YSCZVUXnwi8vMKkIhD9Dr\/Jt67ODhkZGSqNVvm1trSk2NHRUVlFpaWlWUpKWozbzFt+WfbzrIcLJq58mhndRf\/bvVVNW0VFfYmz5cLLz47TGTRo9sx1rQEAwiRRfVVTrgIQiQQNjYFlpeVGhnpFJWUNjY3lFZXd3VTNger1DS18JEf8N+ATZJMzVCiGYS4uLmlpaZGRkc3NzWFhYXl5edOnT6fRaM7OzgCAp0+fwmqTk5PNzMyGDh0KABAXFwe8Y1ByjWkLBYAF2UTljJjJNVQl1xpY68FDJ\/Q29iWv\/Gzq4hOBl1eYVASi3+FpfppbWplMppi4OElIyHTIoGHDzYqLS+h0el5+kZYW+4wBAIDBZMSm3Zw5ch5JSDi1MIntWybGTM6OmTjit8a22lefngIA8iuy7r4NAwB00zqP3NtCo3OPq62vq1tQVCIqKlpfV19QkDdk8CACkSAsLFJUUtLXLiN+GfgE2eQMFZqUlJSSkhIUFOTq6iojI+Pt7R0QEJCbmxsXF+fh4UEgEGJjYwEAlZWVmZmZ3t7erNFjecWgxLjFtOUadpZXxEyuoSq51gCBgdTgV72NfcknP5u6eEXg5RUmFYH4EfA0P03NLSQSSUpSsrOrKz4hPjcnZ4TZMAlx8faODlkZac78QkSh2TZLFk5Z+\/zjw4Y2Lq\/4fKn80EZpnm+3Mur1xYaW2qeZ0WWNBQAADGAfKlLSclK4imFspFdeUUEikeTk5Ts7OmLjHndQOsTExDM\/ZPS1y4hfBj5BNjlDhb59+xYAMGHCBLy4jY0NACAnJ0dLS2v8+PHJycltbW0PHz4UERGZN28erIf1P2cMSq4xbVmLsInKGTGTa6hKrjVA4BQZ\/N\/b2Jd88nOqi6sAfML1IhD9Ts++cISEhEaNGiUhIV5dXc1gML5WflVVVuaaU0VeTVhYJDb9BgNjcH7bSKl5lZPgZu2jqaC\/\/LjLhYR9rN\/eexvO9QGI\/O02sLW1RV1dXVtTC\/n3\/N8BD7K5Zs2asrKyR48eBQQEsMbTjIuLExISgqv0DAYDANDd3Y0Xh7f88OFg7ty5NBotISEhOjra1dVVXl4e1gOfb+B\/GIOyoaEBj0EJY9pGREQYGBiEh4dPmjQJrjXiRdhE5YyYiYeqdHBwCA0NvXTpEp4Z4\/3yAHz6wWNfXr58Gca+ZDKZXCuE8MnPqS7ALQIv1xr6MHD\/fuTk5AiInwHrfpaezQ+Dznj67PngQUa6ujoYwDQ0NKpqanhlbu9o85u4OcTjyjg9Bykx2RCPK\/ZDPWRFFTfOOB7icWWwurkQkbR61t7r215eWP5URvSvcLZDNUa\/zUmobqzgVa28nGzcgzvKqmrZOblUKvK4878CvPZ5enpmZWVFRUXBeNv49ff169cRERFPnjwJDQ0FAAwfPhwAcP\/+fbx4TEwM+PY8NGvWLGFh4QcPHiQlJfn6+uL1QKMF\/9Pp9OHDh2\/btu3s2bNdXV0wkUgkzp8\/\/9OnT3PmzMnMzPzy5QtrQTZR8aef6OhoGo3m6OgI0xUUFK5fv66hobFixYqysjKuNUC+fv0K89fX19+\/f19PT6+ioqKiosLAwKCysjI5OZlrhQAA\/vk51YXLjAeu5lXD947iv5Lm5uaftuD+v01zczM+CjzNj6SEBIPB6OzsJBCJomKisrLyjU0tdDpDTFSko6OTVykFGaVpY91nWs\/RH2AiKiw203rOIJ3hEsLSU0Y5z7SeY202Fc9JJgmTiH\/NfRtqDLUx\/e3J+2jOCnPzi5SVlLq7qU+eJjLotOHDhklKSnR3d+no6vflpEP8UsArI+3vLv7gIfw\/e\/ZsXV3dEydO0Gg0e3t7MzOzixcvbt++\/d27dzt37oyIiJg\/fz4MWiwrKzt16tQbN24oKyvDSTlYAzQYrP83b948fPjwrKwsKpVaXl7++PHjoqKi3NxcKpVKJBJVVFRYC7JJVVJSkpSUdOTIER8fHzMzM19fX1xaGRmZ48ePt7W1LVu2jGsNmZmZ6enpR48elZWVHTp06LVr16hU6v79+2\/cuHHjxg04Y3bz5k2uFQIAeszPpi48ETc\/vGrot+FEIP4OT\/OjpChPJBLbKRQRYbLZsKFv3ryq+lopTCYbGuiWlfN8TBEcMREJMvmv7T0q8mr+jltGD7LlzJaXX2hspF9XV3fi1LmRI0cONTUhEgnd3d0mQwZ\/vwyIfzldXV34fxw4vQYvnQQCYc6cOTU1Nffv3xcSEoqNjbWzs9uzZ4+lpeXvv\/\/u7+9\/\/vx5vOCMGTO6urpcXFwIBAJeD3z9hfW\/kJDQhQsXiERiZ2dnTEyMvb29np7ekCFDEhMTz5w5o6SkxFqQTar4+HhbW9vt27e7uro+efJEREQEpkNL4+zsbG1t\/fDhQxhHma0GR0dHCwuL8vLyS5cuiYqKXr16lUgk4ktZcEN5dHQ01wofPXrEPz+nunCZcfPDq4Y+Dh4C0RP8XjslC4u0t7USCEQxMVEFBaWiooK6ujoZGdmmpkYajU4m9xCsoYeGhUjSYnLNHfVEAlFeSlFVQUOVIxwqk4lVfq3U1tJsaW2j0xklRflDBhmQyeS6ujplRdnvaR3xS6CoqIhxLJCwJQYHB8MNxAAAVVXVhISEysrK2tpaHR0dfJED4ufn5+fnx7UetjpNTU3xmTEHBwe2mLa8pOru7uaMmMmW+fnz5\/DD\/Pnz2Wp4\/\/59Z2fnwIED4b4DuJMCR05ODq+Ha4UODg6C5GdV18aNGzdu3Ih\/xadFBOJHwG\/tR1lZuai4lEQSCli88G7kNY9Zs169TVNUVBATFfmUJVD4OD4MUBzoPnbx8IHjxhlMmzlqAdc85RWV3V1diopKbe3tFEqbrd3E8ePGAQBS0z\/wcvmDQKirq5uZmbHZnj6jpaVlbm6ur6\/fY2BNYWFhGRkZWVlZQp8iZiorK2tpaX1nsFQE4heC37k+YfyYlFdvAAAtLW1Hjp28fvP2h8yPigryg4wHpaRw3yctOCQhkrioBFmILEwWERflHq09IyNDQ0NdUVHhxYuXVV8rN2\/ewqDTAQAtLS16emjtB4FAIH5h+JkfPT298vJySkenpKR4Vm7RKEurkpLS0rIKF5ffbt6O+geEC4u4Ot1xWmNjU+r7T95eXg+i7yopKVRUVnW0t+rr6f4DAiAQCES\/QKFQcnJyfrYU\/y74mR9dbS0REeFPn7KIRKKEKDn5eVJxcUl9ff0gY0NlJcXH8c\/4lJWXUjJSGg4AkJNQUpXRJAmROfMoy6iZ6ozUG8B9E8Hb1Pft7W1jrCzT0jNaW5sTk57n5HwBAGRnfzEwHoTmKBAIRL\/T2to6efJkfHbH29tbwFITJ060tbV1dXW9ffs21zxfvnzZuXNnP4nJ3rSNjY2Njc2DBw84RfLy8srKygIA0Gi0oKAgGxubOXPmUCiUhoaGJUuWsFZ15syZqVOnenh4lJeXw5Ta2lpvb2\/oB+RHwG\/7gIyMtKmpadLz56MtLfHJKNIAACAASURBVJx+m15aVqGrq62uri4mKrZooc\/JU6esrceIiYoCANra24uKSoYNNcHLutsucrSaDQCwN3cfYzRZTkqes37LQTYjjcZzXd7EMOyP02fcXF2kpaWUlZUGqqu1tLTYT51CIBBiHj1eMNeDswgCgUB8J62trUVFRYGBgampqUQi8eXLl\/hXTCaT111va2trS0tLampqeXn5kiVLysrK1qxZ02Op\/hK4paXlzZs34O9uLHCRnj596uTklJ+fDzfWJyUl5eTkEAiEzs7O9PR0PP+rV6\/u3r0bExOTkJCwdOnSBw8etLe3+\/n5ycjIwHfRfgQ96MX5txmPHsd3d3fbThhPIpOzs7M3bt5aUFg0ZZINgUCMfhDLxLB2CuXo8VPrNm1LfvH\/C0LSErKqCuoAAAlRyQGKGkQiF1cFQkQhMklYmCwCAIh9\/CT9fSaV9pc30sTnL0uKS+Z4uF+5eis8PGLd2lUH9u2VkpIsLa+kUNoMDQ37UwcIBALxDS0trWHDhkVEROApTCZz4cKFDg4OFhYWrOlsEAgETU3Ny5cvHzlyhFep9vZ2W1tbtk2GvYLJZDo4OLC9DEcikUgkEueeFwKBMHHiRPiOrbi4eFZWVmtrq7GxMae729jYWE9PTxKJZG9vn5qaCgCQlJSMjo4ePPgHvuLSg\/kx0NfT0tR8EBMHAHC0nywvL79ksZ+Bvi5RSGj3ru2HDh0uKSm7Gx1TWFQyZdLE9IwPiUkve+ulo7ub+uLVuzuRUT6+i7du211bV19VXbt9565tW7dQKB1Xr117\/fbdqtXrtLU0AAAPHsSMGzuGa5BvBAKB+H6YTOaePXtCQkLwF7Pu3LlDJpMfP378\/PnzrVu3sjp24kRRUREA0NHRwVmKRqN5enquX7\/e0tKyz+IRicTZs2ez+qstLCx0cnJycnLKzMxkzdnS0nL\/\/v2lS5fCd93c3Nzs7OxMTExCQ0M555xqa2vhZlECgUAmk7m65Oh3enh3R1xcbMli33XrN7u5\/ObjNdfCfASlo2PRkuXjx49f5OXp4+MTtHrtkUMHi4qKGhvr29o7nyQ8fZ+RsdjXR0AL0dzcErAiiEggLvbzzcnNsbWzZTAYa9dvsrWxmTxxQuzjpwcP7CspKWlqagQAtFM6nj59dv7cqX7oNwKBQPBAXV3dw8MDPsQAALKzs83NzQEAEhIS6urqNTU1nHECceh0Oo1GExcX5yxVWFjIYDBYQ1L1DS8vL9ZDbW3t8PBwAICUlNSJEydiYmIGDBiwZ8+e7u7usrIyFxeXSZMmAQAIBMKOHTuWLl3q7Oysrq4+fvx4AACeX0ZGhkKhwAqFhIT+GdeaPU9KmpsN09HRunTlOoZhzS0tq9estRw16urVKwCAxYu8hwwesmnLjiV+Cxf5+NTW1tDo9Jkzpm\/curO8oofpwq9VVZu27lq+an3g8mVNzc0qKkrr168bZWG2\/+BhCUmJbVs2FBWX\/b43pLi42NV5pu9CbwzDTp4+6\/Sbo4ICl2UkBAKB6EfWr19\/5coVeEXW1NT88uULAKCrq6u2tnbAgAEYhtXwcH25f\/9+GF+Ks5SxsfHy5ctZ333uG1VVVayH0I2srKyskJDQihUr4uLiwsLCAADKysrLly+fPHkynJSrq6sDACgpKdnY2MDPAAA8\/9ChQ+GUYG5uroGBwXdKKCA9mx9RUdE1q1edOnXma1W1laXFokW+GR8yS0pKPeb65OUXbt28Xl9PNzBoXWdX55mTRw0MDd+8eycnKztAVRkA8CLlbean7LKyisqv1bV19TW1dV9y8z98zN4fejQ3rzD5RUpBXl5jY9OmDesaGppGWYxYu34ThUIJCd71OSvHZ5Efpb391Jmz1TW1AIDsnLyXL1NmzXL\/4SpBIBD\/qxCJRLhTQFJScv369dA\/5uzZs798+fLbb79NnDhx7969ZDI5Pz8fPlJARERECgoKbG1tJ0yYUF1dffDgQc5SwsLCRCJxyZIlJBLpzz\/\/7LOEDAZDT08PnwDEBebVEZzr16+PHj3a3t4+JSXFy8uLLYOHh0d2dvbMmTN9fHwOHDgAAKBSqdOmTQsLCzt16hQehrF\/IbBNAkKnpGyZMAzbsev3tva2kODdAIC9+0OZGMjOyiKRhbdv2aijrfnHmT+fPHmyZvUqkyFDIu\/en+4weaCGWvaXvEsREa6uboePHhsxYoSwsMibt2\/cXZxpdHrw73t37tiWkPBsqKkJSVh46ZKFr16\/Oxh6yNTUdHXQiqLi0mdJybdv3\/bx8tbV1bIeP4ZOZwQGrV0dtHzYUC5xUaEf7x+hHQQC8Z+EQGC\/9OGw7lXDMAy\/tlAoFHFxcfxQwC1trKUYDAYeQfF7ZrfodDrr2g8vSTjT4fqTpKQkrwwdHR1cg\/D2I6yaF8hvG4FAWLNqpfuceddu3PZa4Ll7x5bYx8+Snierq6mfvXDJ+TfHlcsDTIcM2R28d9zYMSuW+auqqLS1U\/buO9BOoXR2dubk5MhKS+obGBXk5RKJxK7OzkGDhyQ9fxHg76ehpipEIu35ff\/j+PigwBXTHR2qq2t27N5bUlwweLBJUUmxj5ensLDwnxfOammqc7U9CAQC0Y+wXpFZ72vxqLKc2fjAWgo3Od+5ssIWJ5eXJJzpIiIieBx3rhl+tO1hQ6CnH8iXnDy\/JUv37N5lO2FsUUnZiqB1RAKQEBejM5l7dmwbZGxQW9dw8o8z96LvT5k8ce5cT3W1AQwGMy8vl8EESc+T9fUNJMVF8woKp0+zl5aW0hyonl9QfPX69Xv3HkyZPHHF8qWqKsqnz118FPe4orx8w4b1mZmf9u7ZRiaTIqOiU1JSQg\/sExLirmX09INAIHoFn6cfxA+FVfM8zU9jU\/PigMCxVpZeC+bKy\/3lvTHhadLOXbuD9+y2nTAOALBu43ZDQ4NbtyOXL1tKBMwRI8zU1VRr6xqu3bj14MHDltbW8WPHDB1qqqo6QF5eXkpaqqurq6amtramOvvLl2eJzyXExR3sp86bO1tdbUBuXkHyi5RrN24OHmzy7t3rFcuWLpg3BwBw+050WHh4+MU\/lZUUcSEfxDyiUDpnz3LB+4PMDwKBEBxkfn4WApkfAMCVa7d27tptYmJyYF+woYF+VXVNeMQ1bS3Ns+fO7dy+3WbCWCqVFhZxNfpBLJ1OI2CMO7euS0pKwEraKZTa2rqXr97l5uW2NjfWNzTBaF2qyopiElKGhkYTxlupqqpKSUpAy9HZ1XU3OvbIkUP6+obHjhyUkpQQExOLjLp\/6syZVStXkkkE+6lTAABNTc0HDx9PTHz659kzJkMG4f1B5geB+JeAYdiff\/45b968f3gmhxUmkxkaGurv7y8tLc01AzI\/Pwt+5ofJZObmFbS0tNBoVEpH1+Ejx0ZZjk5OTjpz6uSmzduam5u0tXXGjhlz+cplf\/8lHm7OABCev0j54\/QZ34U+9lMm8mqyqbmV0tEhKSEuK8P9bAAAtLa1Hz\/5x\/y5nhrqahgG\/rwQHnknynfRothHsVVVVdMcpqwOWrlj914xMYnPnzOPHDpYWlqqpqauoqxEIgkh8\/NTaGpqotPpioqK\/wH9M5lMBoNBJnNxTvhvbut7huBHDB+DwViwYEFUVFRaWhqMMwv50eplqz8vL8\/MzExDQ+PJkycDBw7kzP+zzA+FQikvLzc2Nv7nm\/6XwKp59tUUBoN5+dqthX4B92Piox8+olKpTjMd9XR03Nw9TE1Nrl25pKKiHJ+Q4L\/E\/+y5P\/eHHmlobLSdMO70iWOTJ3KJVYpTV1cXF\/+Mj+0BAIiJii4L8NccqFFbV791x67o+w8C\/JfcvHVTQ0MjIvxiecXXufO9W5qb7Wyt29o7rt64ExP3NHDV2vLKH+WP6FfH2dlZW1sb7qHkpKamRvsbbC5AYEFNTc0BAwZoaGiMGTPmyJEjrCFHGQzG0aNHdXV15eXllZWVVVVVN2\/ejGeAxQcOHKiqqjpw4EBLS8vg4OCOjg4BBYDFbW1tWa8OI0eO1NbWLi4u5trHvXv34imRkZHa2tqsFz7+zbW3t+\/YsUNXV1dERERYWFhCQmL16tVcK+evT0FU19u28MPXr19ra2vr6up++vRJkCHgL22PZSFv3ryZPXu2mpoaiUQSFhbW1tbGX0vkVDvOnj17rl27dv36dTgEvLrs7u6uzY2ZM2fy0gZXrfKq39DQ8OHDh0VFRW5ubng4V0Fwd3e3+YatrW1TU5PgZQXhRzge5e8Y9MWLF9bW1tXV1XhKQ0PDwoULLSws\/Pz88B8mm79RtjrpdPrWrVunTp06Z86cxsbGfhMd+ztMJrOrq3vpitXbdwV3dXWXlJZX19TOcHJfs35LV1cXg8FobWvbd+DwmPG2N27dnTPPZ7qT2\/MXr7q7uxm8uRl5123W7MGmw7fv2F1RWcUnZ2dnV2xcwiT76UsCVly9ccdqvO2JP850dHYyGIz2doqPb8B8b7+q6trKqmoKpWPjlp2JSckMBoPJZGIIDmDU5F27dnH99uzZswAABQUFAMCmTZs4CxobGzs5OVlZWcFb4+nTp8NvGQwGfKuOTCbb2tqOGjUKZhgzZkxHRwdefNCgQU5OTuPGjYPfzp07V0ABbG3\/uo+5dOkSnqihoQEAqKio4NrHzZs34ylXr14F32KMCtKco6MjAEBeXt7BwcHe3t7IyGjLli2slW\/dulUQfQqiut62Bb\/t6uoyNTVlbbrHIeAjrSBlMQwLCQmB6WJiYpqamtLS0rKysmzdxKXFycvLI5PJbm5uPap38uTJurq6pqamSkpKcFwGDx6spaU1Y8YMXtrgqlU+KsUwDJqi06dPc44U56UPAn0WGBkZNTc30+l0PJ1KpXJqEv9Mo9FYv2I7ZC2bmprq4eHBtem+0dbWNnPmzPnz5584cYLzWxqNZmtra25unp+fjycWFhamp6dTqVRHR8dTp05hGJaSkjJlyhQajRYbGzt9+nTOOi9cuODv749h2MmTJ5cvX\/49ArNqnov5YTAYrW3tk+xnvH6TWl\/f4OLuuXL1elYjQaPR4xOeDTIdsXf\/ofNhl0dajfdfGpidk8fLqDQ3t9pMsldQHhAZdZ+P7Xmf8dFzno+13dSrN+7s3B0yYuSYhKdJNBqN1Th5LVzsu2R5U1Pzk2dJm7ftgunI\/HBl8uTJAIC9e\/dy\/dba2ppMJh8+fBgAYGhoyPrV1KlTAQDnz5+Hh7du3YL2oK6uDsOwkJAQeH3\/9OkTzBAfHy8qKgoAWL16NV48LCwMfnvhwgUAgIyMjIACODo6kkgkcXFxJSWl+vp6mKinpwcAwA\/ZRN29ezeecufOHQCAhoaGIM3h736XlJTgOfGLjr29PQAgODhYEH32qLpetcXar5UrVwIAZs+ejZ\/nPQ4BH2kFKQtDBpDJ5LNnz+KXzurqarwSNmlx4MuJb968EUS9kBUrVgAA\/Pz8WBO5aoNTq9CnAJ\/6a2trSSTSoEGDMA54mR+IkZFRW1sb\/Pzly5epU6c6OzuPHTu2tbU1IyPDwcHB0dHRxMTk+vXrtbW1kyZNcnd3V1RUPHDgANshW1msP8wPg8Gwt7dnM4chISFczc+hQ4cuXrw4ceJEVvODExgYePLkSQzDtmzZEh4ejmEYk8lUUVHhrHPNmjWXL1\/GMKysrMzc3Px75GfVPPetzBLiYiuWBRw6cuzoyTPFxUXbt25i\/ZZIJEy0mxD\/6GFBQUF4+KXFfou1dXS9fXzne\/vFxiVQKOzTLAAAD3f306fPSEtLcX7V3NJ6L\/qh40zXVWvWjrK0nOfpeerU6eqamkcPo+1sxrPuTBcWJu\/fG5yennbk+OmwsIjFvgu5Co+AwHcL2F4RgBQVFb148WLSpEmenp5EIjEvLy8jI4OtIP5UPnHiX0t6TCaTRqPB+Zzt27ebmPwVX2Py5MmBgYEAgDNnznR3d7MVt7CwAN8eOwQRQEhIiMFgeHp61tXVwWoBAPBlBc6+wLZY36LgTOHTHB4\/mzVQCl4Wnnts72pw1acgqutDW0JCQpGRkceOHZs0aVJ4eDi86xdkCHhJK0hZDMPWr18PAAgKClq8eDG+mqKiooLXwyYtzu3bt9XU1EaNGgUP+XcZAiVkewGFqzY4tYr3jlf90MHMly9fKisrQV\/R1dWNjY2NiooaNmzYixcv6HR6TU3NnTt3oqOjT548GR0dPWPGjFu3bllbW7u4uLAdspXtswyscLoc5UV1dfXjx495hSxqaGiIjY11c3MDAvgbnTBhwokTJ65fv378+PH29vbv7cM3eL45NXWynZGRYWbmR1lZuTXrNrZzGBW1ASrHj4Zu3rQh7tGj169fL1q00HL06CtXr\/3mMmtZ4Jo7UfdS0z\/U1TcAAMQlxBb5LHD5zdF6\/BhYtqy8MjUt4+btO75LVrjPnnv\/YYyzs7Obm9vj+PjEpMTt2zYfDg1RVGT37Vbf0Bi0Zp2IqFhuXp73As+BGmr9pYX\/JPA3zHVVGd7puLm5qaiojB07FgBw\/fp1\/Fv8xWx4ePHiRQCAiYmJsrJyWloanA13d\/+b96M5c+YAADo6Oj59+sRavL29\/fDhwwQCYdeuXQIKICQkhGHY0qVLJSQkrl27FhMTA76ZH87rHUyJj4\/f+I3Lly9z5uTVnLS09LRp0wAAK1asMDU1DQ8PZ10nYLNkfPQpiOp61Rb8cP\/+\/fnz5w8ZMuT+\/fv424KCDAEvaQUpm5GRAdfY+Lgm42rjKysrKysrLSws8Eb5dxnCVZ9ctcGpVX19\/R7rHzlyJADg\/fv3vPrSI21tbb6+vosWLUpOToYm0MDAQERERE1NraWlRU9P7+bNm+fOnSsvL1dXV2c75CzbL3h5efE6D0+cOGFvb+\/j4wMA2LFjx4QJEx4\/ftzQ0PDy5cvjx4\/jX1Gp1NmzZ4eGhsK7CnFxcf7+RmfMmAGn6aZMmaKsrNxfHeFpfshk8sb1q91dncXERJOTkwOWBZaVV7DlERMVnTrZ7tyZP+bP9YyPj49\/HKelpbNg\/jxdXd24hGf7Dxxc7L9s1px5ixYv8\/VfvnDxssUBgd6+Ae4enkuXrww9fCQx6eXgwYO85s+Xk1O4ezfq9es3ywKWnP7j2CS7CSLf7psgGIaVlJavWbep6mvFKIsR2zavt7Pjt9MBAb79sDlPUyaTGR4eTiaT4RoAvP25ceMGhm9HIRIBABEREU5OToaGhuvWrVNSUoJODCsqKgAAJBJJVVWVtU4tLS34obW1FRb\/\/fffDQwMlJSUbt++HR8fP2\/ePAEFgMXl5eV3794NAFi6dGlHRwfrq9qcfXz+\/Pn+b8DJN9Ze828uIiLCwcEBAPD582cfHx9TU1M8IjLbFZyXPlnho7petQUP379\/39XVlZWVdeLECbwJQYaAl7SClC0qKmJLBAC8efPmzJkzULec0kIKCgoAAPr6+qyJfLoM4apPrtrgqtUe6x8wYAAAoL6+nrMVAQkLCxsyZMiFCxfwVUkcDMPevHkzY8YMTU3NhIQEUVFRtkM+Zb8HNpejrLC6HJ0yZYqwsPDnz58pFEpeXp6\/vz\/8isFgzJ0718PD47fffoOlBPE3am5u7unpmZ6eDtfb+gV+T3DiYmJz57jPnDGtsKgk8k6U\/9LA4N07hg01YbONsrLSzk7Tx44dnZOb9+xZUsSVKzJSUto6OsbGxirKysLCJDghI0QUYjDoDAZTVEyUQumqr68rKSlOfPaMSqfZ2Uxwd9tiPmIYmdsTJZ3OePXm3dFjJ1avChw9ykKQp04EAID1as5KfHx8eXm5pKQkvOdtaWkBAJSXl8MdMuDbbWZpaSmDwTAyMgoMDPT29oZ+oqAZoNPptbW1rDdB+L4aFRUVWFxFRUVbW7utra2mpmbdunUpKSn4WyD8BYDFqVTqypUrb9++\/ebNm3379kHPJZyhpGDQrYCAgIUL\/5qJTUpKWrduHWtO\/s0pKCjExsYmJibu27cvPj4+JyfHxcUlMzMTn4LAq+KlT1b4qA4AIHhb8HDXrl0dHR3BwcGbNm2ysLCws7MTcAh4SStIWfwuuKKiQldXF35++vTp1q1bLS0tXV1dcfHYhgN655SRkWFN5NNl1p6yVcVVG1y12mP9YmJiAAA8co+AsLrjtLKy8vf3f\/\/+fWlpqY2NDYFAwK0jkUgcPHjwli1b3r17t3Pnzp07d7IdspXFS\/VKGDYYDIaenl5TUxMcTSqV6uTkVFhYKCQkVFBQcPToUTwnHCwAwOPHj319ffG50Fu3bsXFxVVVVYWHhw8dOvTUqVMeHh7Xr1+fOXNmfX39H3\/8wVlnYmLi8ePHOzs75eTkLl269D3y\/w22dSG49YArF8OvWIwe98eZ8xRKB8fmghbP+Qv9lwZ+ycnv7qa+\/\/DpyvWbW7btdPzNbdRYWwsrG7ORY0eOHm82aqyFlc3ocXYzXTx2B4fcuBX5KSsH1rB0eWDa+0zORltaWg8eOjZ7rk9Obj4vwdDWA67ABVvOBUk48aKoqKj1DbjyDHe2YBgGJzQOHjzIWWdJSQk8bfCdBRC4pK+oqMhgMGDxffv2YRjW2NgIQ9Nu2LBBQAFmzJgBAMjOzsYwLDc3V0xMTFJSEvalsbGRTR7odZh160FkZCQAQEtLS\/D+4uATgOnp6bgeQkJC+OuTFT6q61Vb8DA4OJjJZMJ2Bw4c2NLSggk2BLykFaQsfEJiFQbDsPPnzwMArK2tWcVjzYBh2N27dwHfnYFsXYbArQeLFi1izclVGz1qlWv9MGYPXDZnhfPSxwqDZVcbhmFUKrWrq4vJZMJLDb67gUajubm5webu3r0bEBDAdshZFuPYfNEH2HbW9Vd+CoXC59vW1taurq5etcsV0OPWA654zZ9z5VLYs8QkN4+571L\/NpdaWFSclpYmLCoREXGJRBIqLy\/rpHSsXrXyftTN18lP3r58mvYm+U1KUtrr5Lcvn6Y8T7h7+9qSxb5NjY2VlX+d6w9jYlcGrSot+9v8XtKLVwsWLgaAGRF+zkBfV3BREeDbzSO8+8NpbGyMjo4GAMTFxZV8A87yR0ZGwqlzeLPJ9W0JLS0teA++detW+H4AAKC0tBTupwoKCiISibAgfC6Rk5PbuHEjAODUqVPwsaNHAViLGxoaHjhwoL29\/cmTJ1xFgtlY09mEF6S\/OLNmzYKPWW1tbXgleB6u+mSDj+rY4N8WfkggEM6dOychIVFeXr5hwwYBh4CXtIKUVVdXh3Mye\/fuxaNnysvLA5alfjZpIXDtms9LIWxdZtUY21o3W\/0CapVr\/V+\/fgUAsE029gjbAwqZTBYREcG9q+DTPyQSyc\/Pb9u2bZ6enjdv3ty4cSPbIWdZwG0Js7f0dgZIwPz8vVRISUnxmgPvM73rhoG+bvj5M3ejH67bsGH4cDP\/xb7GRgYEAuHO3Wgzs+EYo8vVzaujs+vDh49vUtPVNdQnT7R1dptdWlrq5ua+ddPa7bv2vn37liwscufmlbS0tJevU6MfPITvq2IYaG5p27Zz9x\/HDktIiH\/8nH3i5CkJcfHQ\/b9ra2l+5+Pq\/yZUKhUAcPr06Xv37tHp9K6urs7OzsmTJ1OpVGVl5REjRuA5p06deuLEifr6+qSkpEmTJsGZCl4Rhc+dO2dpaVlZWTl06FBXV1chIaHbt283NTXZ2dnB6yN8HxC\/WHh4eAQGBra1tUVERKxYseL69ev8BYCt429BLlu2LCoqKjExEXCbQoHmhzXuPew1Xpx\/c7Gxsdu3bx89erSKikpXV1dycjKFQlFRUYF7t2AleFVc9RkWFjZo0CC8Zj6qa21ttba2FrAt+AG2qKmpuW3bto0bN549e9bLy2v06NE9DgEfaQUpe\/r06Q8fPpSWllpaWs6aNcvY2Pjz5894nZzSQoyMjAAA+IuxPXaZs6dsiXj9vLQqSP0fP34kEAgw6uiPYMqUKVOmTMEPNTU1WQ8RPcD2ZMRn8g2HTqdXVHwN3hc6ccq05SvXJL949TTxRUFhMfy2vKLSd8kK\/2Uryyu+MhiMh48SvHwWVdfUMhiMVes2zXSZPczCqr29vbm5ZeuOPQsXL2tqamYwGJ4L\/LKyc54nv4p7\/GTpitXeC\/3epaZ1dnb2KAyafOMF13jy8Crs5OTEmhN\/tTswMBAvuHHjRl415+XlsS6lioqKBgUF4Q\/msDjrq6Bz584FAJiammIYNm7cOP4CwOJJSUn4t7m5ufCGMScnh00SuK9pzZo1eArcFiUhIQEP+Tfn4uLCph9zc\/P379+zdgSvnKs+4SQhm865qg5a0F61hR92dXXBJfQxY8YIMgT8pe2xLIZhNTU1vr6+UlJSrNnwd4fZxMPR1dUVFRVtbm4WpMsQeG64urpyqpFNG5xa7bF+CoUiJibG9T0VwHfyDfHjYNV8LwIucFJYVBITGxefkCAlJW0zwdrO1lpdXS0jI3Pn7j3Dhg4N+X0PmUyKjXv6JCHu8KGDAIAdu\/cx6F2uLi7Dh5nW1TcuCVgmKiq2bu0qAz3d9x8+pqW9zy\/Il5aRmTFtitXo0YI\/YCKXoz+FsrKyvLw8MTGxYcOG4avrvxw1NTWFhYWtra2ioqL6+vrQvcKv0tb3DIEgZel0enFxcWtrq5yc3MCBA3v02BYcHLxt27ZDhw7hzoR+tHr513\/27Fl\/f\/9z585xbiJHLkd\/FoJ6vBaQ5pbWV6\/fxj6Ke5\/xQUdroJHxIAtzC0UFOQMDPWEyubyyqri42GHqJADA8xevyWQhc7PhNDqdQqFUVHwtr\/j66fOnosICBhObOtluwoQJGuq9fpsHmR8E4t9AY2OjiYlJZ2fnhw8fWPdt\/xSamppMTU3l5eXT09M5DScyPz+LfjY\/OFQq7fmLV7m5OW\/fpWV9yaHTaCrKSsrKSlqa6sRv5gHDsIKi0tq6egKBOMF6rKy0pKGR8SQ7m+9xhYvMDwLxLyEpKcnBwUFHRycuLk5TU\/NnidHe3j5jxozM1o3cPQAABh5JREFUzMznz59Dj3ls8DI\/ra2tzs7OTCZzwIAB69evHz58OP+G3r59e\/78+T\/\/\/LPHxB9EQ0PDunXrPn78aGZmduzYsZ8Y5EJAejA\/\/dIGNGMlZZUVFZW1dfX\/3x6BMEBVdfQoMyKR2I82A5kfBOJfwqtXrxYvXnzv3j22V1D\/SZqbmydPnnzx4kWutgfwNj8VFRVOTk6pqalPnjxZunRpfn4+TGcymVw3QDGZzK6uLvyiT6fTSSQSW+IPpaioqLm52dTU1NnZ2dHRMSAg4B9o9Htg1Tz7+kp\/XcdhPXo6mno6P+0OCIFA\/POMGTPm06dPP\/eOUFZWNjU1tc\/FCQTC8OHD4X48JpO5ePHilpaWurq6w4cPjxgxwsnJaceOHWZmZpGRkY8fP6ZSqZcuXfry5UtAQICqqqqzs7ORkdGRI0f68\/VMFphMpqOj4\/379+GMEf5qsJ6eHud72f9y0IZmBALRz\/zSsxF5eXkTJ060srKC9iM6OlpBQeH27dsnT54MDg4GADg7O1+7dg0AcO3atQkTJsAd4YmJiTY2Njdu3PDw8KDT6bzeW\/h+uLocZfUf+guBzA8CgUD8P4aGhjExMVZWVrm5uQCA7OzspKSkefPmhYSEwCilLi4uDx8+bGlpKS0txeOWzp8\/H3rW+fjx44+WkM3lKJv\/0F8I5D8NgUAg\/oaoqGhISIidnZ2fn5+Ghoa1tfXBgwfxb6WkpIYPH75x40bcqRpMDAsLe\/Hixa5duzZt2sSt1n6jqqoKvgcGAGBw+A\/9hUDmB4FAIP4CdzaqoaFhZGT07NkzDw+Pmzdvurm5kclkGxubJUuWAADmz58\/c+bMgoKChoYGmP\/48eMpKSn19fWLFi36fr+ifGD83eUop\/\/QH9TujwBtfkcgEP9z8HnvB9\/kxmAw8A26FApFSEgIOquF0Gg0uPjPYDCgV462tjYRERHoWBpP\/BHA\/XU\/qPIfDb+N1wgEAvGfB712+rNg1TzaeoBAIBCInwAyPwgEAoH4CSDzg0AgEIifADI\/CAQC0QsoFEpOTs7PlkJQMAzLysr62VJwB5kfBAKB+IuGhga4tRoAUFVVtXLlSs48X7582blz5z8qFl9qa2u9vb2joqK4fkuhUGBQJV68ffuWNSBFQ0PDwoULLSws\/Pz8Ojo6+lnWv4PMDwKBQPxFZ2dneno6\/EyhUPBw4+DvQXVZ4UzHY4ezOmHjzNYvLtra29v9\/PyYTCYMK95jE2xiMBgMCwuLY8eO4SktLS3Lly9\/\/fp1VVXVD3Jbh\/Orbh5HIBCIf4acnJygoCBxcfHa2tpHjx7xSi8sLNy8eTORSMzPz\/f394+Li6uoqAgJCTE0NOSarbS0dMuWLbNnz+6VMGwuRyUlJaOjo\/ft28eWjUajubq6tre3Kykp8ZJ2w4YNMM46q6X5J32YIvODQCAQ\/09OTs7o0aMBAN3d3TIyMgAAXV3d2NhYIpG4bNmyFy9eKCsrw5yc6bW1tSkpKa9fv162bFlqaiqcprtz5w5btpqamlevXlVWVi5YsKC35oery1FO7t27p6amdubMmdevX8MoDJzSlpWVpaenZ2dnh4aGshWHPkw3b97cK9l6CzI\/CAQC8f8YGxu\/efMGAFBQUODr6wsAaGtrW7duHYFAePfuna2tLZ6TM11fX19ERERVVVVHR0dcXFxFRaWtrY0zm4GBgYiIiJqaWktLSx8k9PLy6jFPYWEhjJWHRzziFGPYsGFcgxL9Yz5M0doPAoFA8CMsLGzIkCEXLlxgtT180gUsDvoa3rOqqqrHPCoqKjBWXkFBQa+k\/Sd9mKKnHwQCgfgL3OUo62crKyt\/f\/\/379\/DkAq4R1Fe6awfCARCj9l6BZvLUSqV6uTkVFhYKCQkVFBQcPToUZjN1dX1zJkzv\/32m5KSkoSEhCDSQv5JH6bI8RECgfifQxCXo6yfaTQak8mE7kQJBALuUZRXOu4VFH7oMVuvELxUZ2enmJhYj9L+UAepbCCXowgE4n8a5HL0Z4FcjiIQCATiJ4PMDwKBQCB+Asj8IBAIBOIngMwPAoFAIH4CaOM1AoH4n0NWVhZG0Ub8w8jKyuKf\/w+7vNTpOBZk8AAAAABJRU5ErkJggg==\" width=\"571\" height=\"101\" \/><\/p>\r\n<table style=\"border-collapse: collapse; width: 100%; height: 90px;\" border=\"1\">\r\n<tbody>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 13.4298%; height: 18px;\">No. Reg<\/td>\r\n<td style=\"width: 30.6473%; height: 18px;\">{{nomordokumen}}<\/td>\r\n<td style=\"width: 30.9229%; height: 18px;\">Tanggal Pemeriksaan<\/td>\r\n<td style=\"width: 25%; height: 18px;\">{{tangglPemerikasaan}}<\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 13.4298%; height: 18px;\">Nama<\/td>\r\n<td style=\"width: 30.6473%; height: 18px;\">{{namaKlien}}<\/td>\r\n<td style=\"width: 30.9229%; height: 18px;\">Waktu Pemeriksaan<\/td>\r\n<td style=\"width: 25%; height: 18px;\">{{waktuPemerikasaan}}<\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 13.4298%; height: 18px;\">Pertemuan ke<\/td>\r\n<td style=\"width: 30.6473%; height: 18px;\">{{pertemuanKe}}<\/td>\r\n<td style=\"width: 30.9229%; height: 18px;\">Tempat Pemeriksaan<\/td>\r\n<td style=\"width: 25%; height: 18px;\">{{tempatPemeriksaan}}<\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 13.4298%; height: 18px;\">Kasus<\/td>\r\n<td style=\"width: 30.6473%; height: 18px;\">{{kasus}}<\/td>\r\n<td style=\"width: 30.9229%; height: 36px;\" rowspan=\"2\">Koordinator Psikologi<\/td>\r\n<td style=\"width: 25%; height: 36px;\" rowspan=\"2\">{{koordinatorPeikologi}}<\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 13.4298%; height: 18px;\">Pemeriksa<\/td>\r\n<td style=\"width: 30.6473%; height: 18px;\">{{pemeriksa}}<\/td>\r\n<\/tr>\r\n<\/tbody>\r\n<\/table>\r\n<p>&nbsp;<\/p>\r\n<table style=\"height: 456px; width: 100%; border-collapse: collapse; border-style: none;\" border=\"1\">\r\n<tbody>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 14.3526%; height: 18px;\" colspan=\"2\"><strong>Penampilan<\/strong><\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 14.3526%; height: 18px;\">Keadaan Kulit<\/td>\r\n<td style=\"border: 1px solid; border-collapse: collapse; height: 18px;\">\r\n<p>{{keadaanKulit}}<\/p>\r\n<p><span style=\"font-size: 10pt;\">(Bersih, Kotor, Penyakit Kulit, Luka \/ Bekas Luka)<\/span><\/p>\r\n<\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 14.3526%; height: 18px;\">Bentuk Tubuh<\/td>\r\n<td style=\"width: 19.4491%; height: 18px;\">\r\n<p>{{bentukTubuh}}<\/p>\r\n<p><span style=\"font-size: 10pt;\">(Gemuk, Sedang, Kurus)<\/span><\/p>\r\n<\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 14.3526%; height: 18px;\">Tinggi Badan<\/td>\r\n<td style=\"width: 19.4491%; height: 18px;\">\r\n<p>{{tinggiBadan}}<\/p>\r\n<p><span style=\"font-size: 10pt;\">(Tinggi, Sedang, Pendek, Stunting)<\/span><\/p>\r\n<\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 14.3526%; height: 18px;\">Pakaian<\/td>\r\n<td style=\"width: 19.4491%; height: 18px;\">{{pakaian}}<br \/><span style=\"font-size: 10pt;\">(Rapi, Kotor, Srampangan, Sederhana, Serasi, Mewa, Bersih, Biasa)<\/span><\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 14.3526%; height: 18px;\" colspan=\"2\"><strong>Sikap<\/strong><\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 14.3526%; height: 18px;\">Tindakan<\/td>\r\n<td style=\"width: 19.4491%; height: 18px;\">\r\n<p>{{tindakan}}<\/p>\r\n<p>(Sopan, Tegas, Ramah, Garang, Percaya diri, Kaku, Sulit Fokus, Kurang tahu aturan, Ceroboh, Tertekan, Dibuat-buat, Ragu-ragu, Malu-malu, Kontak Mata, Tidak bisa diam)<\/p>\r\n<\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 14.3526%; height: 18px;\"><strong>Penyampaian<\/strong><\/td>\r\n<td style=\"width: 19.4491%; height: 18px;\">&nbsp;<\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 14.3526%; height: 18px;\">Ekspresi<\/td>\r\n<td style=\"width: 19.4491%; height: 18px;\">\r\n<p>{{expresi}}<\/p>\r\n<p><span style=\"font-size: 10pt;\">(Tertutup, Terbuka, Mudah, Hati-hati, Dingin \/ datar, Membatasi diri, Sukar mencari kata-kata, Tenang, Gugup, Takut, Lancar, Banyak gerak dan isyarat<\/span><\/p>\r\n<\/td>\r\n<\/tr>\r\n<tr style=\"height: 18px;\">\r\n<td style=\"width: 14.3526%; height: 18px;\">Penggunaan Kata<\/td>\r\n<td style=\"width: 19.4491%; height: 18px;\">\r\n<p>{{penggunaanKata}}<\/p>\r\n<p><span style=\"font-size: 10pt;\">(Dengan tekanan suara, Terpengaruh bahasa daerah, Disertai istilah bahasa asing, Biasa)<\/span><\/p>\r\n<\/td>\r\n<\/tr>\r\n<tr style=\"height: 46px;\">\r\n<td style=\"width: 14.3526%; height: 46px;\" colspan=\"2\"><strong>Mood<\/strong><\/td>\r\n<\/tr>\r\n<tr style=\"height: 46px;\">\r\n<td style=\"width: 14.3526%; height: 46px;\">Afek<\/td>\r\n<td style=\"width: 19.4491%; height: 46px;\">\r\n<p>{{afek}}<\/p>\r\n<p><span style=\"font-size: 10pt;\">(Euthymic, Manik, Depresif)<\/span><\/p>\r\n<\/td>\r\n<\/tr>\r\n<tr style=\"height: 46px;\">\r\n<td style=\"width: 14.3526%; height: 46px;\">Ekspresi Afektif<\/td>\r\n<td style=\"width: 19.4491%; height: 46px;\">\r\n<p>{{ekspresi afektif}}<\/p>\r\n<p><span style=\"font-size: 10pt;\">(Normal, Terbatas, Tumpul, Datar)<\/span><\/p>\r\n<\/td>\r\n<\/tr>\r\n<tr style=\"height: 46px;\">\r\n<td style=\"width: 14.3526%; height: 46px;\">Kesesuaian<\/td>\r\n<td style=\"width: 19.4491%; height: 46px;\">\r\n<p>{{kesesuaian}}<\/p>\r\n<p><span style=\"font-size: 10pt;\">(Sesuai, Tidak Sesuai)<\/span><\/p>\r\n<\/td>\r\n<\/tr>\r\n<tr style=\"height: 46px;\">\r\n<td style=\"width: 14.3526%; height: 46px;\">Empati<\/td>\r\n<td style=\"width: 19.4491%; height: 46px;\">\r\n<p>{{empati}}<\/p>\r\n<p><span style=\"font-size: 10pt;\">(Bisa, Tidak Bisa)<\/span><\/p>\r\n<\/td>\r\n<\/tr>\r\n<tr style=\"height: 46px;\">\r\n<td style=\"width: 14.3526%; height: 46px;\"><strong>Symtomps<\/strong><\/td>\r\n<td style=\"width: 19.4491%; height: 46px;\">\r\n<p>{{symtomps}}<\/p>\r\n<\/td>\r\n<\/tr>\r\n<\/tbody>\r\n<\/table>\r\n<p><strong>(T)opics<\/strong><\/p>\r\n<table style=\"border-collapse: collapse; width: 100%;\" border=\"1\">\r\n<tbody>\r\n<tr>\r\n<td style=\"width: 100%;\">{{topics}}<\/td>\r\n<\/tr>\r\n<\/tbody>\r\n<\/table>\r\n<p>&nbsp;<\/p>\r\n<p><strong>(I)ntervention:<\/strong><\/p>\r\n<table style=\"border-collapse: collapse; width: 100%;\" border=\"1\">\r\n<tbody>\r\n<tr>\r\n<td style=\"width: 100%;\">{{intervention}}<\/td>\r\n<\/tr>\r\n<\/tbody>\r\n<\/table>\r\n<p>&nbsp;<\/p>\r\n<p><strong>(P)lans &amp; Progresses :<\/strong><\/p>\r\n<table style=\"border-collapse: collapse; width: 100%;\" border=\"1\">\r\n<tbody>\r\n<tr>\r\n<td style=\"width: 100%;\">{{plans}}<\/td>\r\n<\/tr>\r\n<\/tbody>\r\n<\/table>\r\n<p>&nbsp;<\/p>\r\n<p><strong>(S)pecial Issues :&nbsp;<\/strong><\/p>\r\n<table style=\"border-collapse: collapse; width: 100%;\" border=\"1\">\r\n<tbody>\r\n<tr>\r\n<td style=\"width: 100%;\">{{specialIssues}}<\/td>\r\n<\/tr>\r\n<\/tbody>\r\n<\/table>\r\n<p>&nbsp;<\/p>"',
                "created_by" => 4,
                "created_at" => '2023-05-16 03:28:35',
                "updated_at" => '2023-05-16 03:28:35'
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
            ]
        ];
        TemplateKeyword::insert($template_keyword);
        
    }
}
