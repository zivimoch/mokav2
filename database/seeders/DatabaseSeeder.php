<?php

namespace Database\Seeders;

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
        $data = [
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
        User::insert($data);
    }
}
