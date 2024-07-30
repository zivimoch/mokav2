<?php

namespace App\Http\Controllers;

use App\Models\MBentukKekerasan;
use App\Models\MJenisKekerasan;
use App\Models\MKategoriKasus;
use App\Models\Petugas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OpsiController extends Controller
{
    // data kategori lokasi / tempat kejadian
    public function api_kategori_lokasi()
    {
        $data = [
            'Ranah Online' => ['MiChat', 'Facebook', 'Twitter', 'Instagram', 'WhatsApp', 'Tiktok', 'Snapchat', 'Bigo'],
            'Tempat Tinggal' => ['Rumah', 'Apartemen', 'Kos-kosan', 'Kontrakan'],
            'Tempat Pendidikan' => ['Sekolah', 'Kampus', 'Tempat Les', 'Pondok Pesantren'],
            'Tempat Ibadah' => ['Mesjid', 'Mushola', 'Gereja', 'Pura', 'Vihara', 'Kelenteng'],
            'Penginapan' => ['Hotel', 'Motel', 'Villa'],
            'Lokasi Komersial' => ['Kantor Swasta', 'Pabrik', 'Toko', 'Pasar', 'Mall'],
            'Cagar Budaya' => ['Museum', 'Tempat Wisata'],
            'Kantor Pemerintahan' => ['Kantor Pemerintahan'],
            'Transportasi' => ['Ojek Online', 'Taksi / Mobile Online', 'Taksi Konvensional', 'Bajaj', 'Transjakarta', 'MRT', 'LRT', 'KRL', 'Kereta Cepat', 'Angkot', 'Kendaraan Pribadi'],
            'Public Area' => ['Jalan', 'Taman']
        ];

        return $data;
    }

    public function api_status_pendidikan()
    {
        $data = ['Belum Sekolah',
                'Sekolah (Aktif)',
                'Putus Sekolah',
                'Lulus dan Tidak Melanjutkan (Tamat Belajar)',
                'Tidak Diketahui'
            ];

        return $data;
    }

    public function api_pendidikan_terakhir()
    {
        $data = ['Tidak Sekolah',
                'PAUD',
                'TK',
                'SD / Sederajat',
                'SMP / Sederajat',
                'SMA / Sederajat',
                'Perguruan Tinggi',
                'Tidak Diketahui'
            ];
                
        return $data;
    }

    public function api_kelas()
    {
        $data = ['1','2','3','4','5','6','7','8','9','10','11','12',
                'Semester 1', 'Semester 2', 'Semester 3', 'Semester 4', 'Semester 5', 'Semester 5', 'Semester 6', 'Semester 7', 'Semester 8', 'Semester Lanjut'];
                
        return $data;
    }

    public function api_agama()
    {
        $data = [
                'Islam',
                'Kristen Katolik',
                'Kristen Protestan',
                'Hindu',
                'Budha',
                'Kong Hu Cu',
                'Lainnya'];
                
        return $data;
    }

    public function api_suku()
    {
        // https://ppid.kaltimprov.go.id/index.php/berita/yuk-simak-berbagai-jenis-suku-di-indonesia
        $data = [
                'Luar Negri',
                'Suku Bali',
                'Suku Banjar',
                'Suku Batak',
                'Suku Betawi',
                'Suku Bugis',
                'Suku Cina',
                'Suku Dayak',
                'Suku Gorontalo',
                'Suku Jawa',
                'Suku Madura',
                'Suku Makassar',
                'Suku Melayu',
                'Suku Minahasa',
                'Suku Minangkabau',
                'Suku Nias',
                'Suku Sasak',
                'Suku Asal Aceh',
                'Suku Asal Banten',
                'Suku Asal Jambi',
                'Suku Asal Kalimantan Lainnya',
                'Suku Asal Lampung',
                'Suku Asal NTT',
                'Suku Asal Papua',
                'Suku Asal Sulawesi Lainnya',
                'Suku Asal Sumatera Lainnya',
                'Suku Asal Sumatra Selatan',
                'Suku Asal NTB',
                'Suku Sunda'];
                
        return $data;
    }

    public function api_pekerjaan()
    {
        $data = ['Tidak Bekerja', 
                'Pelajar', 
                'Ibu Rumah Tangga', 
                'Swasta', 
                'Buruh', 
                'PNS', 
                'TNI', 
                'POLRI', 
                'Dokter', 
                'Pedagang', 
                'Petani', 
                'Nelayan',
                'ART / Pembantu'
            ];
                
        return $data;
    }

    public function api_status_perkawinan()
    {
        $data = ['Belum Menikah',
                'Menikah Resmi',
                'Menikah Tidak Resmi',
                'Cerai Hidup',
                'Cerai Mati',
                'Berpisah'];
                
        return $data;
    }

    public function api_hubungan_dengan_terlapor()
    {
        $data = ['Ayah Kandung',
                'Ayah Tiri',
                'Ibu Kandung',
                'Ibu Tiri',
                'Anak Kandung',
                'Anak Tiri',
                'Adik Kandung',
                'Adik Tiri',
                'Kakak Kandung',
                'Kakak Tiri',
                'Kakak Ipar',
                'Adik Ipar',
                'Bibi',
                'Sepupu',
                'Keponakan', 
                'Nenek',
                'Istri',
                'Besan',
                'Menantu',
                'Mertua',
                'Tetangga',
                'Pacar',
                'Mantan Pacar',
                'Teman',
                'Guru',
                'Majikan',
                'Rekan Kerja',
                'Bukan Siapa-Siapa / Tak Dikenal',
                'Pedagang',
                'Pembeli',
                'Customer',
                'Driver Ojek Online',
                'Driver Taksi Online',
                'Driver Transportasi Publik',
                'Supir Pribadi'
                ];
                
        return $data;
    }

    public function api_hubungan_dengan_klien()
    {
        $data = [
                'Diri Sendiri',
                'Ayah Kandung',
                'Ayah Tiri',
                'Ibu Kandung',
                'Ibu Tiri',
                'Anak Kandung',
                'Anak Tiri',
                'Adik Kandung',
                'Adik Tiri',
                'Kakak Kandung',
                'Kakak Tiri',
                'Kakak Ipar',
                'Adik Ipar',
                'Paman',
                'Bibi',
                'Sepupu',
                'Keponakan',
                'Kakek',
                'Nenek',
                'Suami',
                'Mantan Suami',
                'Besan',
                'Menantu',
                'Mertua',
                'Tetangga',
                'Pacar',
                'Mantan Pacar',
                'Teman',
                'Guru',
                'Staff TU',
                'Majikan',
                'ART / Pembantu',
                'Rekan Kerja',
                'Bukan Siapa-Siapa / Tak Dikenal',
                'Pedagang',
                'Customer',
                'Supir Pribadi',
                'Driver Ojek Online',
                'Driver Taksi Online',
                'Driver Transportasi Publik',
                'RT',
                'RW',
                'Dokter',
                'Perawat'
                ];
                
        return $data;
    }

    public function api_kekhususan()
    {
        $data = ['Tinggal dengan Terlapor',
                'Tidak memiliki Keluarga Dekat',
                'Ancaman dibunuh',
                'Ingin menyakiti Diri Sendiri',
                'Mengalami Penyakit/Luka/Cedera Serius'
                ];
                
        return $data;
    }

    public function api_kedaruratan()
    {
        $data = ['Fasilitasi SPP',
                'Pemberian Informasi',
                'Layanan Kedaruratan'
                ];
                
        return $data;
    }

    public function api_difabel_type()
    {
        $data = ['Amputasi',
                'Lumpuh Layuh / Kaku',
                'Paraplegi',
                'Celebral Palsy',
                'Akibat Stroke',
                'Akibat Kusta',
                'Orang Kecil',
                'Lambat Belajar',
                'Disabilitas Grahita',
                'Downsyndrom',
                'Bipolar',
                'Depresi',
                'Anxietas',
                'Gangguan Kepribadian',
                'Autis',
                'Hiperaktif',
                'Disabilitas Netra',
                'Rungu dan atau Disabilitas Wicara'
                ];
                
        return $data;
    }

    public function api_kategori_kasus()
    {
        $data = ['KTA',
                'KTP',
                'KS',
                'KDRT',
                'KBGO',
                'TPPO',
                'Lainnya'];
                
        return $data;
    }

    public function api_tindak_kekerasan()
    {
        $data = ['ini nanti diupdate lagi yaaaaa'];
        
        // $data = ['Penyebaran Konten',
        //         'Grooming',
        //         'Honey Trap',
        //         'Manipulasi Konten',
        //         'Pornografi',
        //         'Hacking',
        //         'Impersonasi',
        //         'Trolling',
        //         'Stalking',
        //         'Penyadapan',
        //         'Doxing',
        //         'Outing',
        //         'Pemerasan',
        //         'Fisik'];
                
        return $data;
    }

    public function api_pengadilan_negri()
    {
        $data = ['Pengadilan Negri Jakarta Pusat',
                'Pengadilan Negri Jakarta Utara',
                'Pengadilan Negri Jakarta Barat',
                'Pengadilan Negri Jakarta Selatan',
                'Pengadilan Negri Jakarta Timur'];
                
        return $data;
    }

    public function api_pasal()
    {
        $data = [
            'UU NO 12 TAHUN 2022 TENTANG TINDAK PIDANA KEKERASAN SEKSUAL',
            'UU NO 17 TAHUN 2016 TENTANG PENETAPAN PERATURAN PEMERINTAH PENGGANTI UNDANG',
            'UU NO 1 TAHUN 2016 TENTANG PERUBAHAN KEDUA ATAS UU NO 23 TAHUN 2002 TENTANG PERLINDUNGAN ANAK MENJADI UNDANG-UNDANG',
            'UU NO 23 TAHUN 2004 TENTANG PENGHAPUSAN KEKERASAN DALAM RUMAH TANGGA',
            'UU NO NOMOR 44 TAHUN 2008 TENTANG PORNOGRAFI',
            'UU NO 19 TAHUN 2016 TENTANG PERUBAHAN ATAS UNDANG-UNDANG NOMOR 11 TAHUN 2008 TENTANG INFORMASI DAN TRANSAKSI ELEKTRONIK',
            'UU NO 21 TAHUN 2007 TENTANG PEMBERANTASAN TINDAK PIDANA PERDAGANGAN ORANG',
            'KUHP'
        ];
        // $data = ['UNDANG-UNDANG REPUBLIK INDONESIA NOMOR 12 TAHUN 2022 TENTANG TINDAK PIDANA KEKERASAN SEKSUAL',
        //         'UNDANG-UNDANG REPUBLIK INDONESIA NOMOR 17 TAHUN 2016 TENTANG PENETAPAN PERATURAN PEMERINTAH PENGGANTI UNDANG-UNDANG NOMOR 1 TAHUN 2016 TENTANG PERUBAHAN KEDUA ATAS UNDANG-UNDANG NOMOR 23 TAHUN 2002 TENTANG PERLINDUNGAN ANAK MENJADI UNDANG-UNDANG',
        //         'UNDANG-UNDANG REPUBLIK INDONESIA NOMOR 23 TAHUN 2004 TENTANG PENGHAPUSAN KEKERASAN DALAM RUMAH TANGGA',
        //         'UNDANG-UNDANG REPUBLIK INDONESIA NOMOR 44 TAHUN 2008 TENTANG PORNOGRAFI',
        //         'UNDANG-UNDANG REPUBLIK INDONESIA NOMOR 19 TAHUN 2016 TENTANG PERUBAHAN ATAS UNDANG-UNDANG NOMOR 11 TAHUN 2008 TENTANG INFORMASI DAN TRANSAKSI ELEKTRONIK',
        //         'UNDANG-UNDANG REPUBLIK INDONESIA NOMOR 21 TAHUN 2007 TENTANG PEMBERANTASAN TINDAK PIDANA PERDAGANGAN ORANG',
        //         'KITAB UNDANG-UNDANG HUKUM PIDANA'];
                
        return $data;
    }
    // data media pengaduan
    public function api_media_pengaduan()
    {
        $data = ['Datang Langsung',
                'Pos Pengaduan RPTRA',
                'Hotline',
                // 'Jakarta Siaga 112',
                // 'PUSPA',
                // 'SAPA'
            ];
                
        return $data;
    }

    public function api_sumber_rujukan()
    {
        $data = ['Komnas Perempuan',
                'KPAI',
                'Komnas HAM',
                'KemenPPA',
                'Kepolisian',
                'Masyarakat',
                'Jakarta Siaga 112',
                'PUSPA DPPAPP',
                'Media Sosial',
                'Korban / Keluarga Korban',
                'RS Abdi Waluyo',
                'RS Agung',
                'RS Asri',
                'RS Atmajaya',
                'RS Aulia',
                'RS Bakti Mulia',
                'RS Budhi Asih',
                'RS Budi Kemuliaan',
                'RS Cipto Mangunkusu',
                'RS Budi Kemuliaan',
                'RS Dharma Nugraha',
                'RS Dharmais',
                'RS Duren Sawit',
                'RS Duta Indah',
                'RS Evasari',
                'RS Family',
                'RS Fatmawati',
                'RS Gading Pluit',
                'RS Gandaria',
                'RS Gatot Subroto',
                'RS Grand Family',
                'RS Haji',
                'RS HALIM AU',
                'RS Harapan Bunda',
                'RS Harapan Jayakarta',
                'RS Harapan Kita',
                'RS Harum',
                'RS Hermina Jak-Tim',
                'RS Hermina Kalideres',
                'RS Hermina Kemayoran',
                'RS Hermina Podmoro',
                'RS Husada',
                'RS Islam Jak-Pus',
                'RS Islam Jak-Utara',
                'RS Islam Klender',
                'RS Jakarta',
                'RS Jakarta MC',
                'RS Kesdam Cijan',
                'RS Koja',
                'RS Kramat 128',
                'RS Luar DKI',
                'RS M. Ridwan M',
                'RS Manuella',
                'RS Masyarakat',
                'RS Mayapada Hospital',
                'RS Mayapada Hospital Kuningan',
                'RS Medika Permata H',
                'RS Mediros',
                'RS Medistra',
                'RS MH Thamrin',
                'RS Mintoharjo',
                'RS Mitra Kemayoran',
                'RS Mitra KlpGading',
                'RS MMC',
                'RS MRCCC Siloam Semanggi',
                'RS Muhammadyah',
                'RS Mulia Sari',
                'RS Pantai Indah Kap',
                'RS Pasar Minggu',
                'RS Pasar Rebo',
                'RS Patria IKKT',
                'RS Pelni Petamburan',
                'RS Persahabatan',
                'RS Pertamina Jaya',
                'RS PGI Cikini',
                'RS Pluit',
                'RS POLRI',
                'RS Pondok Indah',
                'RS Port Medical C',
                'RS Premier Jatinegara',
                'RS Prikasih',
                'RS Prof Sulianti S',
                'RS Puri Indah',
                'RS Puri Medika',
                'RS Pusat Pertamina',
                'RS PUSDIKKES',
                'RS Restu',
                'RS Royal Pro',
                'RS Royal Taruma',
                'RS Antam Medika',
                'RS Bhayangkara POLRI',
                'RS Bina Sehat Mandiri',
                'RS Brawijaya Saharjo',
                'RS Bunda Aliyah',
                'RS Bunda Jakarta',
                'RS Cendana',
                'RS Cinta Kasih Tzu Chi',
                'RS Columbia Asia',
                'RS Dr. Abdul Radjak',
                'RS dr. Suyoto',
                'RS FIRDAUS',
                'RS Grha Kedoya',
                'RS Jantung Harapan Kita',
                'RS Jantung Jakarta',
                'RS JIWA Dr.SOEHARTO HEERDJAN',
                'RS Kartika',
                'RS Kartini',
                'RS Menteng Mitra Afia',
                'RS Mitra Keluarga Kalideres',
                'RS OMNI',
                'RS Petukangan',
                'RS PUSAT OTAK NASIONAL',
                'RS Rawamangun',
                'RS Sibro Malisi',
                'RS Siloam TB Simatupang',
                'RS Ukrida',
                'RS Umum Pekerja',
                'RS Zahirah',
                'RSB Duren Tiga',
                'RSIA Alvernia Agusta',
                'RSIA Andhika',
                'RSIA Anggrek Mas',
                'RSIA Brawijaya',
                'RSIA Budhi Jaya',
                'RSIA Ibnu Sina',
                'RSIA Kemang',
                'RSIA RESTI MULYA',
                'RSIA SamMarie Basra',
                'RSIA Santo Yusuf',
                'RSIA Sayyidah',
                'RSIA Tambak',
                'RSIA YPK Mandiri',
                'RSUD Cempaka Putih',
                'RSUD Cilincing',
                'RSUD Johar Baru',
                'RSUD Kemayoran',
                'RSUD Kembangan',
                'RSUD Koja',
                'RSUD Mampang Prapatan',
                'RSUD Pademangan',
                'RSUD Sawah Besar',
                'RSUD tebet',
                'RSUDO Jakarta',
                'RSU Adhyaksa',
                'RSU Alfauzan',
                'RSU Bunda',
                'RSU Kec. Pesanggrahan',
                'RSU Kepulauan Seribu',
                'RSU Murni Teguh Sudirman',
                'RSU Siloam Hospitals Mampang',
                'RSU YARSI',
                'RSUD Cengkareng',
                'RSUD Cipayung',
                'RSUD Jatipadang',
                'RSUD Kebayoran Baru',
                'RSUD Kebayoran Lama',
                'RSUD Taman Sari',
                'RSUD Tanah Abang',
                'RSUD Tanjung Priok',
                'RSUD Ciracas',
                'RSUD Jagakarsa',
                'RSUD Kalideres',
                'RSUD Kramat Jati',
                'RS Abdi Waluyo',
                'RS Agung',
                'RS Asri',
                'RS Atmajaya',
                'RS Satya Negara',
                'RS Setia Mitra',
                'RS Siaga Raya',
                'RS Siloam Hospitals Agora',
                'RS Siloam Kebon Jeruk',
                'RS Sint Carolus',
                'RS Sukmul',
                'RS Sumber Waras',
                'RS Tangerang',
                'RS Tarakan',
                'RS Tebet',
                'RS Tria Dipa',
                'RS Tugu',
                'RS Tzu Chi Hospital',
                'RS UKI Cawang',
                'RS Yadika Keb. Lama',
                'RS Yadika Pd Bambu',
                'PUSKESMAS Kec. Tanah Abang',
                'PUSKESMAS Kec. Menteng',
                'PUSKESMAS Kec. Senen',
                'PUSKESMAS Kec. Johar Baru',
                'PUSKESMAS Kec. Cempaka Putih',
                'PUSKESMAS Kec. Kemayoran',
                'PUSKESMAS Kec. Sawah Besar',
                'PUSKESMAS Kec. Gambir',
                'PUSKESMAS Kec. Penjaringan',
                'PUSKESMAS Kec. Pademangan',
                'PUSKESMAS Kec. Tanjung Priok',
                'PUSKESMAS Kec. Koja',
                'PUSKESMAS Kec. Kelapa Gading',
                'PUSKESMAS Kec. Cilincing',
                'PUSKESMAS Kec. Kembangan',
                'PUSKESMAS Kec. Kebon Jeruk',
                'PUSKESMAS Kec. Palmerah',
                'PUSKESMAS Kec. Grogol Petamburan',
                'PUSKESMAS Kec. Tambora',
                'PUSKESMAS Kec. Tamansari',
                'PUSKESMAS Kec. Cengkareng',
                'PUSKESMAS Kec. Kalideres',
                'PUSKESMAS Kec. Tebet',
                'PUSKESMAS Kec. Setiabudi',
                'PUSKESMAS Kec. Mampang Prapatan',
                'PUSKESMAS Kec. Pasar Minggu',
                'PUSKESMAS Kec. Kebayoran Baru',
                'PUSKESMAS Kec. Kebayoran Lama',
                'PUSKESMAS Kec. Cilandak',
                'PUSKESMAS Kec. Pancoran',
                'PUSKESMAS Kec. Pesanggrahan',
                'PUSKESMAS Kec. Pasar Rebo',
                'PUSKESMAS Kec. Ciracas',
                'PUSKESMAS Kec. Cipayung',
                'PUSKESMAS Kec. Makasar',
                'PUSKESMAS Kec. Kramat Jati',
                'PUSKESMAS Kec. Jatinegara',
                'PUSKESMAS Kec. Duren Sawit',
                'PUSKESMAS Kec. Cakung',
                'PUSKESMAS Kec. Pulogadung',
                'PUSKESMAS Kec. Matraman',
                'PUSKESMAS Kec. Kepulauan Seribu Utara',
                'PUSKESMAS Kec. Kepulauan Seribu Selatan',
                'PUSKESMAS Kec. Jagakarsa',
                'UPTD PPA Tangsel',
                'UPT PPA Jawa Tengah'
            ];
                
        return $data;
    }

    public function api_sumber_infromasi()
    {
        $data = ['Komnas Perempuan',
                'KPAI',
                'Komnas HAM',
                'KemenPPA',
                'Kepolisian',
                'Masyarakat',
                'Jakarta Siaga 112',
                'PUSPA DPPAPP',
                'Media Sosial',
                'Korban / Keluarga Korban',
                'RS Abdi Waluyo',
                'RS Agung',
                'RS Asri',
                'RS Atmajaya',
                'RS Aulia',
                'UPTD PPA Tangsel',
                'RS Bakti Mulia',
                'RS Budhi Asih',
                'RS Budi Kemuliaan',
                'RS Cipto Mangunkusu',
                'RS Budi Kemuliaan',
                'RS Dharma Nugraha',
                'RS Dharmais',
                'RS Duren Sawit',
                'RS Duta Indah',
                'RS Evasari',
                'RS Family',
                'RS Fatmawati',
                'RS Gading Pluit',
                'RS Gandaria',
                'RS Gatot Subroto',
                'RS Grand Family',
                'RS Haji',
                'RS HALIM AU',
                'RS Harapan Bunda',
                'RS Harapan Jayakarta',
                'RS Harapan Kita',
                'RS Harum',
                'RS Hermina Jak-Tim',
                'RS Hermina Kalideres',
                'RS Hermina Kemayoran',
                'RS Hermina Podmoro',
                'RS Husada',
                'RS Islam Jak-Pus',
                'RS Islam Jak-Utara',
                'RS Islam Klender',
                'RS Jakarta',
                'RS Jakarta MC',
                'RS Kesdam Cijan',
                'RS Koja',
                'RS Kramat 128',
                'RS Luar DKI',
                'RS M. Ridwan M',
                'RS Manuella',
                'RS Masyarakat',
                'RS Mayapada Hospital',
                'RS Mayapada Hospital Kuningan',
                'RS Medika Permata H',
                'RS Mediros',
                'RS Medistra',
                'RS MH Thamrin',
                'RS Mintoharjo',
                'RS Mitra Kemayoran',
                'RS Mitra KlpGading',
                'RS MMC',
                'RS MRCCC Siloam Semanggi',
                'RS Muhammadyah',
                'RS Mulia Sari',
                'RS Pantai Indah Kap',
                'RS Pasar Minggu',
                'RS Pasar Rebo',
                'RS Patria IKKT',
                'RS Pelni Petamburan',
                'RS Persahabatan',
                'RS Pertamina Jaya',
                'RS PGI Cikini',
                'RS Pluit',
                'RS POLRI',
                'RS Pondok Indah',
                'RS Port Medical C',
                'RS Premier Jatinegara',
                'RS Prikasih',
                'RS Prof Sulianti S',
                'RS Puri Indah',
                'RS Puri Medika',
                'RS Pusat Pertamina',
                'RS PUSDIKKES',
                'RS Restu',
                'RS Royal Pro',
                'RS Royal Taruma',
                'RS Antam Medika',
                'RS Bhayangkara POLRI',
                'RS Bina Sehat Mandiri',
                'RS Brawijaya Saharjo',
                'RS Bunda Aliyah',
                'RS Bunda Jakarta',
                'RS Cendana',
                'RS Cinta Kasih Tzu Chi',
                'RS Columbia Asia',
                'RS Dr. Abdul Radjak',
                'RS dr. Suyoto',
                'RS FIRDAUS',
                'RS Grha Kedoya',
                'RS Jantung Harapan Kita',
                'RS Jantung Jakarta',
                'RS JIWA Dr.SOEHARTO HEERDJAN',
                'RS Kartika',
                'RS Kartini',
                'RS Menteng Mitra Afia',
                'RS Mitra Keluarga Kalideres',
                'RS OMNI',
                'RS Petukangan',
                'RS PUSAT OTAK NASIONAL',
                'RS Rawamangun',
                'RS Sibro Malisi',
                'RS Siloam TB Simatupang',
                'RS Ukrida',
                'RS Umum Pekerja',
                'RS Zahirah',
                'RSB Duren Tsumber_iiga',
                'RSIA Alvernia Agusta',
                'RSIA Andhika',
                'RSIA Anggrek Mas',
                'RSIA Brawijaya',
                'RSIA Budhi Jaya',
                'RSIA Ibnu Sina',
                'RSIA Kemang',
                'RSIA RESTI MULYA',
                'RSIA SamMarie Basra',
                'RSIA Santo Yusuf',
                'RSIA Sayyidah',
                'RSIA Tambak',
                'RSIA YPK Mandiri',
                'RSUD Cempaka Putih',
                'RSUD Cilincing',
                'RSUD Johar Baru',
                'RSUD Kemayoran',
                'RSUD Kembangan',
                'RSUD Koja',
                'RSUD Mampang Prapatan',
                'RSUD Pademangan',
                'RSUD Sawah Besar',
                'RSUD tebet',
                'RSUDO Jakarta',
                'RSU Adhyaksa',
                'RSU Alfauzan',
                'RSU Bunda',
                'RSU Kec. Pesanggrahan',
                'RSU Kepulauan Seribu',
                'RSU Murni Teguh Sudirman',
                'RSU Siloam Hospitals Mampang',
                'RSU YARSI',
                'RSUD Cengkareng',
                'RSUD Cipayung',
                'RSUD Jatipadang',
                'RSUD Kebayoran Baru',
                'RSUD Kebayoran Lama',
                'RSUD Taman Sari',
                'RSUD Tanah Abang',
                'RSUD Tanjung Priok',
                'RSUD Ciracas',
                'RSUD Jagakarsa',
                'RSUD Kalideres',
                'RSUD Kramat Jati',
                'RSUD Matraman',
                'RS Olahraga Nasional',
                'RS Cilandak',
                'RS Satya Negara',
                'RS Setia Mitra',
                'RS Siaga Raya',
                'RS Siloam Hospitals Agora',
                'RS Siloam Kebon Jeruk',
                'RS Sint Carolus',
                'RS Sukmul',
                'RS Sumber Waras',
                'RS Tangerang',
                'RS Tarakan',
                'RS Tebet',
                'RS Tria Dipa',
                'RS Tugu',
                'RS Tzu Chi Hospital',
                'RS UKI Cawang',
                'RS Yadika Keb. Lama',
                'RS Yadika Pd Bambu',
                'PUSKESMAS Kec. Tanah Abang',
                'PUSKESMAS Kec. Menteng',
                'PUSKESMAS Kec. Senen',
                'PUSKESMAS Kec. Johar Baru',
                'PUSKESMAS Kec. Cempaka Putih',
                'PUSKESMAS Kec. Kemayoran',
                'PUSKESMAS Kec. Sawah Besar',
                'PUSKESMAS Kec. Gambir',
                'PUSKESMAS Kec. Penjaringan',
                'PUSKESMAS Kec. Pademangan',
                'PUSKESMAS Kec. Tanjung Priok',
                'PUSKESMAS Kec. Koja',
                'PUSKESMAS Kec. Kelapa Gading',
                'PUSKESMAS Kec. Cilincing',
                'PUSKESMAS Kec. Kembangan',
                'PUSKESMAS Kec. Kebon Jeruk',
                'PUSKESMAS Kec. Palmerah',
                'PUSKESMAS Kec. Grogol Petamburan',
                'PUSKESMAS Kec. Tambora',
                'PUSKESMAS Kec. Tamansari',
                'PUSKESMAS Kec. Cengkareng',
                'PUSKESMAS Kec. Kalideres',
                'PUSKESMAS Kec. Tebet',
                'PUSKESMAS Kec. Setiabudi',
                'PUSKESMAS Kec. Mampang Prapatan',
                'PUSKESMAS Kec. Pasar Minggu',
                'PUSKESMAS Kec. Kebayoran Baru',
                'PUSKESMAS Kec. Kebayoran Lama',
                'PUSKESMAS Kec. Cilandak',
                'PUSKESMAS Kec. Pancoran',
                'PUSKESMAS Kec. Pesanggrahan',
                'PUSKESMAS Kec. Pasar Rebo',
                'PUSKESMAS Kec. Ciracas',
                'PUSKESMAS Kec. Cipayung',
                'PUSKESMAS Kec. Makasar',
                'PUSKESMAS Kec. Kramat Jati',
                'PUSKESMAS Kec. Jatinegara',
                'PUSKESMAS Kec. Duren Sawit',
                'PUSKESMAS Kec. Cakung',
                'PUSKESMAS Kec. Pulogadung',
                'PUSKESMAS Kec. Matraman',
                'PUSKESMAS Kec. Kepulauan Seribu Utara',
                'PUSKESMAS Kec. Kepulauan Seribu Selatan',
                'PUSKESMAS Kec. Jagakarsa',
                'UPTD PPA Tangsel',
                'Yayasan / NGO',
                'Pemerintah Daerah (PEMDA)'
            ];
                
        return $data;
    }

    public function api_program_pemerintah()
    {
        $data = ['PKH', 'Mekaar', 'KJP', 'Sembako Murah', 'KIS / BPJS', 'BLT Desa', 'KLJ', 'PKD', 'KPDJ'];
                
        return $data;
    }

    public function api_jabatan()
    {
        $data = ['Manajer Kasus',
                'Pendamping Kasus',
                'Advokat',
                'Paralegal',
                'Unit Reaksi Cepat',
                'Psikolog',
                'Konselor',
                'Penerima Pengaduan',
                'Tenaga Ahli',
                'Sekretariat',
                'Supervisor Kasus',
                'Tim Data',
                'Kepala Instansi'];
                
        return $data;
    }

    public function api_petugas()
    {
        $data = User::whereNull('deleted_at');
        if (Auth::user()->jabatan == 'Penerima Pengaduan') {
            $data->whereIn('jabatan', [
                'Penerima Pengaduan', 
                'Manajer Kasus', 
                'Supervisor Kasus', 
                'Pendamping Kasus', 
                'Unit Reaksi Cepat',
                'Advokat',
                'Psikolog',
                'Konselor',
                'Paralegal'
            ]);
        }
        return $data->get();
    }

    // api_jenis_kekerasan
    public function jenis_kekerasan(Request $request)
    {        
        $search = $request->search;

        $data = MJenisKekerasan::whereNull('deleted_at')
                ->select('kode','nama');
        if($search != ''){
            $data->where('nama', 'like', '%' .$search . '%');
        }
        $data = $data->limit(100)->get();
  
        $response = array();
        foreach($data as $value){
            $response[] = array(
                 "id"=>$value->kode,
                 "text"=>$value->nama
            );
         }
        return response()->json($response);  
    }

    // api_bentuk_kekerasan
    public function bentuk_kekerasan(Request $request)
    {        
        $jenis_kekerasan_kode = $request->jenis_kekerasan;
        $search = $request->search;

        if (!$jenis_kekerasan_kode) {
            $response = array(
                'status' => 400,
                'data' => []
            );
            return response()->json($response, 400);
        }                     

        $data = DB::table('m_jenis_kekerasan as a')
            ->leftJoin('m_bentuk_kekerasan as b', 'a.kode', 'b.jenis_kekerasan_kode')
            ->select('a.kode as jenis_kode', 'a.nama as jenis_nama', 'b.kode as bentuk_kode', 'b.nama as bentuk_nama')
            ->whereNull('b.deleted_at')
            ->whereIn('b.jenis_kekerasan_kode', $jenis_kekerasan_kode);
        if($search != ''){
            $data->where('b.nama', 'like', '%' .$search . '%');
        }
        
        $data = $data->limit(100)->get();

        $result = [];

        $no = 1;
        foreach ($data as $row) {
            $jenisKode = $row->jenis_kode;
            $bentukData = [
                'id'   => $row->bentuk_kode,
                'text' => $row->bentuk_nama,
            ];

            // Check if the jenis_kode is already in the result
            if (isset($result[$jenisKode])) {
                // Add bentuk data to existing jenis_kode
                $result[$jenisKode]['children'][] = $bentukData;
            } else {
                // Create a new jenis_kode entry with bentuk data
                $result[$jenisKode] = [
                    'text'     => $no.'. '.$row->jenis_nama,
                    'children' => [$bentukData],
                ];
                $no++;
            }
        }

        // Reindex the result array
        $results = array_values($result);

        // Return the results as JSON
        echo json_encode($results);
    }

    // api_kategori_kasus
    public function kategori_kasus(Request $request)
    {        
        $jenis_kekerasan_kode = $request->jenis_kekerasan;
        $bentuk_kekerasan_kode = $request->bentuk_kekerasan;
        $search = $request->search;

        if (!$jenis_kekerasan_kode || !$jenis_kekerasan_kode) {
            $response = array(
                'status' => 400,
                'data' => []
            );
            return response()->json($response, 400);
        }                     

        $data = DB::table('m_kategori_kasus as a')
            ->leftJoin('r_kategori_jenis_bentuk as b', 'a.kode', 'b.kategori_kasus_kode')
            ->leftJoin('m_jenis_kekerasan as c', 'b.jenis_kekerasan_kode', 'c.kode')
            ->leftJoin('m_bentuk_kekerasan as d', 'b.bentuk_kekerasan_kode', 'd.kode')
            ->select('a.kode as id', 'a.nama as text')
            ->whereNull('a.deleted_at')
            ->whereIn('b.jenis_kekerasan_kode', $jenis_kekerasan_kode)
            ->WhereIn('b.bentuk_kekerasan_kode', $bentuk_kekerasan_kode)
            ->groupBy('a.kode', 'a.nama')
            ;
        if($search != ''){
            $data->where('a.nama', 'like', '%' .$search . '%');
        }
        
        $data = $data->limit(100)->get();
        $array1Ids = $data->pluck('id')->toArray();

        $semua_kategori = MKategoriKasus::select('kode as id', 'nama as text')
                                        ->whereNull('deleted_at')
                                        ->get();
        $data2 = $semua_kategori->reject(function ($item) use ($array1Ids) {
                                            return in_array($item['id'], $array1Ids);
                                        });
                                        
        $result[0] = [
            'text' => 'A. Kategori Kasus yang disarankan System : ',
            'children' => $data
        ];
        $result[1] = [
            'text' => 'B. Kategori Kasus Lainnya : ',
            'children' => array_values($data2->all())
        ];
        // Return the results as JSON
        echo json_encode($result);
    }

    // ini nanti dihilangkan, ambil dari MOKI
    public function api_hari_kerja()
    {
        $data = [
            [
                "tahun" => 2024,
                "bulan" => 2,
                "hari_kerja" => 18,
            ],
            [
                "tahun" => 2024,
                "bulan" => 3,
                "hari_kerja" => 18,
            ],
            [
                "tahun" => 2024,
                "bulan" => 4,
                "hari_kerja" => 16,
            ],
            [
                "tahun" => 2024,
                "bulan" => 5,
                "hari_kerja" => 18,
            ],
            [
                "tahun" => 2024,
                "bulan" => 6,
                "hari_kerja" => 18,
            ],
            [
                "tahun" => 2024,
                "bulan" => 7,
                "hari_kerja" => 23,
            ],
        ];

        return $data;
    }
}
