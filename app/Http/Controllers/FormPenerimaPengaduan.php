<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivityHelper;
use App\Helpers\NotifHelper;
use App\Helpers\StatusHelper;
use App\Models\Asesmen;
use App\Models\DifabelType;
use App\Models\Kasus;
use App\Models\KategoriKasus;
use App\Models\Klien;
use App\Models\TKedaruratan;
use App\Models\MJenisKekerasan;
use App\Models\MKategoriKasus;
use App\Models\Pasal;
use App\Models\Pelapor;
use App\Models\PersetujuanIsi;
use App\Models\Petugas;
use App\Models\RHubunganTerlaporKlien;
use App\Models\TBentukKekerasan;
use App\Models\TProgramPemerintah;
use App\Models\Terlapor;
use App\Models\TindakKekerasan;
use App\Models\TJenisKekerasan;
use App\Models\TKategoriKasus;
use App\Models\TTindakLanjut;
use Illuminate\Http\Request;
use Laravolt\Indonesia\Models\Provinsi;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class FormPenerimaPengaduan extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $status_pendidikan =  (new OpsiController)->api_status_pendidikan();
        $pendidikan_terakhir =  (new OpsiController)->api_pendidikan_terakhir();
        $kelas =  (new OpsiController)->api_kelas();
        $agama =  (new OpsiController)->api_agama();
        $suku =  (new OpsiController)->api_suku();
        $pekerjaan =  (new OpsiController)->api_pekerjaan();
        $status_perkawinan =  (new OpsiController)->api_status_perkawinan();
        $hubungan_dengan_terlapor =  (new OpsiController)->api_hubungan_dengan_terlapor();
        $hubungan_dengan_klien =  (new OpsiController)->api_hubungan_dengan_klien();
        $kekhususan =  (new OpsiController)->api_kekhususan();
        $kedaruratan =  (new OpsiController)->api_kedaruratan();
        $pengadilan_negri =  (new OpsiController)->api_pengadilan_negri();
        $pasal =  (new OpsiController)->api_pasal();
        $media_pengaduan =  (new OpsiController)->api_media_pengaduan();
        $sumber_rujukan =  (new OpsiController)->api_sumber_rujukan();
        $sumber_informasi =  (new OpsiController)->api_sumber_infromasi();
        $program_pemerintah =  (new OpsiController)->api_program_pemerintah();
        $kategori_lokasi =  (new OpsiController)->api_kategori_lokasi();
        $provinsi = Provinsi::get();
        $jenis_kekerasan = MJenisKekerasan::get();
        return view('formpenerimapengaduan')->with('provinsi', $provinsi)
                                            ->with('status_pendidikan', $status_pendidikan)
                                            ->with('pendidikan_terakhir', $pendidikan_terakhir)
                                            ->with('kelas', $kelas)
                                            ->with('agama', $agama)
                                            ->with('suku', $suku)
                                            ->with('pekerjaan', $pekerjaan)
                                            ->with('status_perkawinan', $status_perkawinan)
                                            ->with('hubungan_dengan_terlapor', $hubungan_dengan_terlapor)
                                            ->with('hubungan_dengan_klien', $hubungan_dengan_klien)
                                            ->with('kekhususan', $kekhususan)
                                            ->with('kedaruratan', $kedaruratan)
                                            ->with('pengadilan_negri', $pengadilan_negri)
                                            ->with('pasal', $pasal)
                                            ->with('media_pengaduan', $media_pengaduan)
                                            ->with('sumber_rujukan', $sumber_rujukan)
                                            ->with('sumber_informasi', $sumber_informasi)
                                            ->with('program_pemerintah', $program_pemerintah)
                                            ->with('kategori_lokasi',$kategori_lokasi)
                                            ->with('jenis_kekerasan', $jenis_kekerasan)
                                            ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'tanggal_pelaporan' => 'required',
                ]);
                
                if (isset(Auth::user()->id)) {
                    if (Auth::user()->jabatan == 'Penerima Pengaduan') {
                        $created_by = Auth::user()->id; 
                    }else{
                        $created_by = NULL;
                    }
                }else{
                    $created_by = NULL;
                }

                if ($validator->fails())
                {
                    throw new Exception($validator->errors());
                }
            
            // Data Kasus
            $kasus = Kasus::create([
                'sumber_rujukan' => $request->sumber_rujukan,
                'media_pengaduan' => $request->media_pengaduan,
                'sumber_informasi' => $request->sumber_informasi,
                'tanggal_pelaporan' => $request->tanggal_pelaporan,
                'tanggal_kejadian' => $request->tanggal_kejadian,
                'perkiraan_tanggal_kejadian' => $request->perkiraan_tanggal_kejadian,
                'kategori_lokasi' => $request->kategori_lokasi,
                'provinsi_id' => isset($request->provinsi_id_kasus) ? $request->provinsi_id_kasus : 2,
                'kotkab_id' => isset($request->kota_id_kasus) ? $request->kota_id_kasus : 2,
                'kecamatan_id' =>  isset($request->kecamatan_id_kasus) ? $request->kecamatan_id_kasus : 2,
                'kelurahan_id' => isset($request->kelurahan_id_kasus) ? $request->kelurahan_id_kasus : 2,
                'alamat' => $request->alamat_kasus,
                'ringkasan' => $request->ringkasan,
                'created_by' => $created_by
            ]);

            // Data Pelapor
            $pelapor = Pelapor::create([
                'kasus_id' => $kasus->id,
                'nik' => $request->nik_pelapor,
                'nama' => $request->nama_pelapor,
                'tempat_lahir' => $request->tempat_lahir_pelapor,
                'tanggal_lahir' => $request->tanggal_lahir_pelapor,
                'perkiraan_tanggal_lahir' => $request->perkiraan_tanggal_lahir_pelapor,
                'jenis_kelamin' => $request->jenis_kelamin_pelapor,
                'provinsi_id_ktp' => isset($request->provinsi_id_pelapor_ktp) ? $request->provinsi_id_pelapor_ktp : 2,
                'kotkab_id_ktp' => isset($request->kota_id_pelapor_ktp) ? $request->kota_id_pelapor_ktp : 2,
                'kecamatan_id_ktp' => isset($request->kecamatan_id_pelapor_ktp) ? $request->kecamatan_id_pelapor_ktp : 2,
                'kelurahan_id_ktp' => isset($request->kelurahan_id_pelapor_ktp) ? $request->kelurahan_id_pelapor_ktp : 2,
                'alamat_ktp' => $request->alamat_pelapor_ktp,
                'provinsi_id' => isset($request->provinsi_id_pelapor) ? $request->provinsi_id_pelapor : 2,
                'kotkab_id' => isset($request->kota_id_pelapor) ? $request->kota_id_pelapor : 2,
                'kecamatan_id' => isset($request->kecamatan_id_pelapor) ? $request->kecamatan_id_pelapor : 2,
                'kelurahan_id' => isset($request->kelurahan_id_pelapor) ? $request->kelurahan_id_pelapor : 2,
                'alamat' => $request->alamat_pelapor,
                'agama' => $request->agama_pelapor,
                'status_kawin' => $request->perkawinan_pelapor,
                'pekerjaan' => $request->pekerjaan_pelapor,
                'kewarganegaraan' => $request->kewarganegaraan_pelapor,
                'status_pendidikan' => $request->status_pendidikan_pelapor,
                'pendidikan' => $request->pendidikan_pelapor,
                'no_telp' => $request->no_telp_pelapor,
                'desil' => $request->desil_pelapor,
                'created_by' => $created_by
            ]);

            //Data Klien
            $kliens = $request->nama_klien;
            foreach ($kliens as $key => $value) {
                // if ($request->tandatangan[$key]) {
                //     //simpan tandatangan
                //     $folderPath = public_path('img/tandatangan/ttd_klien/');
                //     $image_parts = explode(";base64,", $request->tandatangan[$key]);
                //     $image_type_aux = explode("image/", $image_parts[0]);
                //     $image_type = $image_type_aux[1];
                //     $image_base64 = base64_decode($image_parts[1]);
                //     $file = uniqid() . '.'.$image_type;
                //     $filepath = $folderPath . $file;
                //     file_put_contents($filepath, $image_base64);  
                // } else {
                //     $file = NULL;
                // }

                $klien = Klien::create([
                        'kasus_id' => $kasus->id,
                        'status' => 'Pelengkapan data',
                        'nik' => isset($request->nik_klien[$key]) ? $request->nik_klien[$key] : NULL, 
                        'nama' => $request->nama_klien[$key],  
                        'tempat_lahir' => isset($request->tempat_lahir_klien[$key]) ? $request->tempat_lahir_klien[$key] : NULL,  
                        'tanggal_lahir' => isset($request->tanggal_lahir_klien[$key]) ? $request->tanggal_lahir_klien[$key] : NULL,  
                        'perkiraan_tanggal_lahir' => $request->perkiraan_tanggal_lahir_klien[$key],
                        'jenis_kelamin' => isset($request->jenis_kelamin_klien[$key]) ? $request->jenis_kelamin_klien[$key] : NULL,  
                        'provinsi_id_ktp' => isset($request->provinsi_id_klien_ktp[$key]) ? $request->provinsi_id_klien_ktp[$key] : 2,  
                        'kotkab_id_ktp' => isset($request->kota_id_klien_ktp[$key]) ? $request->kota_id_klien_ktp[$key] : 2,  
                        'kecamatan_id_ktp' => isset($request->kecamatan_id_klien_ktp[$key]) ? $request->kecamatan_id_klien_ktp[$key] : 2,  
                        'kelurahan_id_ktp' => isset($request->kelurahan_id_klien_ktp[$key]) ? $request->kelurahan_id_klien_ktp[$key] : 2,  
                        'alamat_ktp' => isset($request->alamat_klien_ktp[$key]) ? $request->alamat_klien_ktp[$key] : NULL, 
                        'provinsi_id' => isset($request->provinsi_id_klien[$key]) ? $request->provinsi_id_klien[$key] : 2,  
                        'kotkab_id' => isset($request->kota_id_klien[$key]) ? $request->kota_id_klien[$key] : 2,  
                        'kecamatan_id' => isset($request->kecamatan_id_klien[$key]) ? $request->kecamatan_id_klien[$key] : 2,  
                        'kelurahan_id' => isset($request->kelurahan_id_klien[$key]) ? $request->kelurahan_id_klien[$key] : 2,  
                        'alamat' => isset($request->alamat_klien[$key]) ? $request->alamat_klien[$key] : NULL, 
                        'agama' => isset($request->agama_klien[$key]) ? $request->agama_klien[$key] : NULL,  
                        'status_kawin' => isset($request->perkawinan_klien[$key]) ? $request->perkawinan_klien[$key] : NULL,  
                        'pekerjaan' => isset($request->pekerjaan_klien[$key]) ? $request->pekerjaan_klien[$key] : NULL,  
                        'kewarganegaraan' => isset($request->kewarganegaraan_klien[$key]) ? $request->kewarganegaraan_klien[$key] : NULL,  
                        'status_pendidikan' => isset($request->status_pendidikan_klien[$key]) ? $request->status_pendidikan_klien[$key] : NULL,  
                        'pendidikan' => isset($request->pendidikan_klien[$key]) ? $request->pendidikan_klien[$key] : NULL,  
                        'no_telp' => isset($request->no_telp_klien[$key]) ? $request->no_telp_klien[$key] : NULL,  
                        'kedisabilitasan' => isset($request->kedisabilitasan[$key]) ? $request->kedisabilitasan[$key] : NULL,  
                        'hubungan_pelapor' => isset($request->hubungan_pelapor[$key]) ? $request->hubungan_pelapor[$key] : NULL,  
                        'desil' => isset($request->desil_klien[$key]) ? $request->desil_klien[$key] : NULL,  
                        'created_by' => $created_by  
                    ]);
                
                if (!$klien) {
                    throw new Exception($klien);
                }
                
                // //simpan jenis kekerasan
                if (isset($request->jenis_kekerasan[$key])) {
                    $jenis_kekerasan = $request->jenis_kekerasan[$key];
                    foreach ($jenis_kekerasan as $key1 => $value) {
                        $proses['jenis_kekerasan'] = TJenisKekerasan::create(['klien_id' => $klien->id, 'value' => $jenis_kekerasan[$key1]]);
                    }
                }
                //simpan kedaruratan
                if (isset($request->kedaruratan[$key])) {
                    $kedaruratan = $request->kedaruratan[$key];
                    foreach ($kedaruratan as $key2 => $value) {
                        $proses['kedaruratan'] = TKedaruratan::create(['klien_id' => $klien->id, 'value' => $kedaruratan[$key2]]);
                    }
                }
                //simpan tindak lanjut
                if (isset($request->tindak_lanjut[$key])) {
                    $tindak_lanjut = $request->tindak_lanjut[$key];
                    foreach ($tindak_lanjut as $key3 => $value) {
                        $proses['tindak_lanjut'] = TTindakLanjut::create(['klien_id' => $klien->id, 'value' => $tindak_lanjut[$key3]]);
                    }
                }
                
                // create persetujuan
                $proses_persetujuan = PersetujuanIsi::create([
                    'klien_id'   => $klien->id, 
                    'persetujuan_template_id' => 1,
                    // 1 adalah persetujuan verif data 
                    'created_by'   => $created_by
                ]);

                if (!$proses_persetujuan) {
                    throw new Exception($proses_persetujuan);
                }
                                
                // if ($file) {
                //     $nama_penandatangan = isset($request->nama_penandatangan[$key]) ? $request->nama_penandatangan[$key] : NULL;
                //     // simpan tandatangan
                //     $update_persetujuan = PersetujuanIsi::find($proses_persetujuan->id)
                //                     ->update(['tandatangan' => $file, 
                //                     'nama_penandatangan' => $nama_penandatangan,
                //                     'no_telp' => NULL,
                //                     'alamat' => NULL
                //                 ]);
                    
                //     if (!$proses_persetujuan) {
                //         throw new Exception($update_persetujuan);
                //     }
                // }

            // create asesmen untuk tiap klien
            $proses_asesmen = Asesmen::create([
                'klien_id' => $klien->id
            ]);
            
            if (!$proses_asesmen) {
                throw new Exception($proses_asesmen);
            }

            // ===========================================================================================
            //Proses read, push notif & log activity ////////////////////////////////////////////////////
            if (isset(Auth::user()->id)) {
                if (Auth::user()->jabatan == 'Penerima Pengaduan') {
                    //push notifikasi ///////////////////////////////////////////////////////////////////////////
                    // kirim notif dari setiap klien ke petugas penerima pengaduan
                    $push_notif = NotifHelper::push_notif(
                        Auth::user()->id , //receiver_id
                        $klien->id, //klien_id
                        'T2', //type_notif
                        'task', //type_notif
                        $klien->no_klien ? $klien->no_klien : NULL, //noregis
                        'System', //from
                        'Kasus baru. Silahkan pilih Supervisor & Manajer Kasus', //message
                        $request->nama_klien[$key], //nama korban 
                        isset($request->tanggal_lahir_klien[$key]) ? $request->tanggal_lahir_klien[$key] : NULL, //tanggal lahir korban
                        url('/kasus/show/'.$klien->uuid.'?tab=kasus-petugas&tambah-petugas=1'), //url
                        1, //kirim ke diri sendiri 0 / 1
                        Auth::user()->id, // created_by
                        NULL // agenda_id
                    );
                    if (!$push_notif) {
                        throw new Exception($push_notif);
                    }
                    //write log activity ////////////////////////////////////////////////////////////////////////
                    LogActivityHelper::push_log(
                        //message
                        Auth::user()->name.' menginputkan data kasus baru', 
                        //klien_id
                        $klien->id 
                    );
                    // update status klien //////////////////////////////////////////////////////////////////////
                    StatusHelper::push_status($klien->id, 'Pelengkapan data');
                    /////////////////////////////////////////////////////////////////////////////////////////////
                }
            }
            /////////////////////////////////////////////////////////////////////////////////////////////
                //Data Petugas
                if (isset(Auth::user()->id)) {
                    if (Auth::user()->jabatan == 'Penerima Pengaduan') {
                        Petugas::create([
                            'klien_id' => $klien->id,
                            'user_id' => $created_by,
                            'created_by' => $created_by
                        ]);
                    }
                }    
            }


            //Data Terlapor
            $terlapor = $request->nama_terlapor;
            if (isset($terlapor)) {
                $urutan_hubungan = 0;
                foreach ($terlapor as $key => $value) {
                    $terlapor = Terlapor::create([
                        'kasus_id' => $kasus->id,
                        'nik' => isset($request->nik_terlapor[$key]) ? $request->nik_terlapor[$key] : NULL, 
                        'nama' => $request->nama_terlapor[$key],  
                        'tempat_lahir' => isset($request->tempat_lahir_terlapor[$key]) ? $request->tempat_lahir_terlapor[$key] : NULL,  
                        'tanggal_lahir' => isset($request->tanggal_lahir_terlapor[$key]) ? $request->tanggal_lahir_terlapor[$key] : NULL,  
                        'perkiraan_tanggal_lahir' => $request->perkiraan_tanggal_lahir_terlapor[$key],
                        'jenis_kelamin' => isset($request->jenis_kelamin_terlapor[$key]) ? $request->jenis_kelamin_terlapor[$key] : NULL,  
                        'provinsi_id_ktp' => isset($request->provinsi_id_terlapor_ktp[$key]) ? $request->provinsi_id_terlapor_ktp[$key] : 2,  
                        'kotkab_id_ktp' => isset($request->kota_id_terlapor_ktp[$key]) ? $request->kota_id_terlapor_ktp[$key] : 2,  
                        'kecamatan_id_ktp' => isset($request->kecamatan_id_terlapor_ktp[$key]) ? $request->kecamatan_id_terlapor_ktp[$key] : 2,  
                        'kelurahan_id_ktp' => isset($request->kelurahan_id_terlapor_ktp[$key]) ? $request->kelurahan_id_terlapor_ktp[$key] : 2,  
                        'alamat_ktp' => isset($request->alamat_terlapor_ktp[$key]) ? $request->alamat_terlapor_ktp[$key] : NULL, 
                        'provinsi_id' => isset($request->provinsi_id_terlapor[$key]) ? $request->provinsi_id_terlapor[$key] : 2,  
                        'kotkab_id' => isset($request->kota_id_terlapor[$key]) ? $request->kota_id_terlapor[$key] : 2,  
                        'kecamatan_id' => isset($request->kecamatan_id_terlapor[$key]) ? $request->kecamatan_id_terlapor[$key] : 2,  
                        'kelurahan_id' => isset($request->kelurahan_id_terlapor[$key]) ? $request->kelurahan_id_terlapor[$key] : 2,  
                        'alamat' => isset($request->alamat_terlapor[$key]) ? $request->alamat_terlapor[$key] : NULL, 
                        'agama' => isset($request->agama_terlapor[$key]) ? $request->agama_terlapor[$key] : NULL,  
                        'status_kawin' => isset($request->perkawinan_terlapor[$key]) ? $request->perkawinan_terlapor[$key] : NULL,  
                        'pekerjaan' => isset($request->pekerjaan_terlapor[$key]) ? $request->pekerjaan_terlapor[$key] : NULL,  
                        'kewarganegaraan' => isset($request->kewarganegaraan_terlapor[$key]) ? $request->kewarganegaraan_terlapor[$key] : NULL,  
                        'status_pendidikan' => isset($request->status_pendidikan_terlapor[$key]) ? $request->status_pendidikan_terlapor[$key] : NULL,  
                        'pendidikan' => isset($request->pendidikan_terlapor[$key]) ? $request->pendidikan_terlapor[$key] : NULL,  
                        'no_telp' => isset($request->no_telp_terlapor[$key]) ? $request->no_telp_terlapor[$key] : NULL,  
                        'desil' => isset($request->desil_terlapor[$key]) ? $request->desil_terlapor[$key] : NULL,  
                        'created_by' => $created_by  
                    ]);

                    $klien = Klien::where('kasus_id', $kasus->id)->get();
                    foreach ($klien as $klien) {
                        RHubunganTerlaporKlien::create([
                            'klien_id' => $klien->id,
                            'terlapor_id' => $terlapor->id,
                            'value' => $request->hubungan[$urutan_hubungan]
                        ]);
                        $urutan_hubungan++;
                    }
                }

                // loop insert data hubungan terlapor-klien
                // dd($request->hubungan);
//                 $hubunganData = is_array($request->hubungan) ? $request->hubungan : json_decode($request->hubungan, true);
//                 dd($hubunganData);

// foreach ($hubunganData as $klienRelations) {
//     foreach ($klienRelations as $terlaporRelations) {
//         foreach ($terlaporRelations as $relation) {
//             RHubunganTerlaporKlien::create([
//                 'klien_id' => $relation['klien_id'],
//                 'terlapor_id' => $relation['terlapor_id'],
//                 'value' => $relation['value']
//             ]);
//         }
//     }
// }

            }

            //return response
            $response = "Berhasil menginputkan data";
            return redirect()->route('formpenerimapengaduan.index')
                    ->with('success', true)
                    ->with('uuid', $klien->uuid)
                    ->with('response', $response);

        } catch (Exception $e){
            return redirect()->route('formpenerimapengaduan.index')
                    ->with('error', true)
                    ->with('response', $e->getMessage());
            die();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
         try {
            $data_update = $request->data_update ;
            if ($data_update == 'kasus') {
                $data = Kasus::where('uuid', $request->uuid)->first();
                // ambil salah 1 klien aja di kasus ini, nanti akan dipakai kasus_id nya
                $klien = Klien::where('kasus_id', $data->id)->first();
            }
            if ($data_update == 'pelapor') {
                $data = Pelapor::where('uuid', $request->uuid)->first();
                $kasus = Kasus::find($data->kasus_id);
                // ambil salah 1 klien aja di kasus ini, nanti akan dipakai kasus_id nya
                $klien = Klien::where('kasus_id', $kasus->id)->first();

                // update data hubungan pelapor dengan korban
                $klien->hubungan_pelapor = $request->hubungan_pelapor;
                $klien->save();
                // hapus hubungan_pelapor dari request
                $request->request->remove('hubungan_pelapor');
            }
            if ($data_update == 'klien') {
                $data = Klien::where('uuid', $request->uuid)->first();
                // proses update kedaruratan klien di tabel kedaruratan
                TKedaruratan::where('klien_id', $data->id)->delete();
                //simpan kedaruratan
                if (isset($request->kedaruratan)) {
                    $kedaruratan = $request->kedaruratan;
                    foreach ($kedaruratan as $key4 => $value) {
                        $proses['kedaruratan'] = TKedaruratan::create(['klien_id' => $data->id, 'value' => $kedaruratan[$key4]]);
                    }
                }

                $request->request->remove('kedaruratan');

                // proses update tindak_lanjut klien di tabel t_tindak_lanjut
                TTindakLanjut::where('klien_id', $data->id)->delete();
                //simpan tindak_lanjut
                if (isset($request->tindak_lanjut)) {
                    $tindak_lanjut = $request->tindak_lanjut;
                    foreach ($tindak_lanjut as $key5 => $value) {
                        $proses['tindak_lanjut'] = TTindakLanjut::create(['klien_id' => $data->id, 'value' => $tindak_lanjut[$key5]]);
                    }
                }

                $request->request->remove('tindak_lanjut');

                $klien = Klien::where('id', $data->id)->first();
            }

            if ($data_update == 'terlapor') {
                // hapus semua hubungan_terlapor klien ini
                RHubunganTerlaporKlien::updateOrCreate(['klien_id' => $request->klien_id,
                                            'terlapor_id' => $request->terlapor_id],[
                                            'klien_id'     => $request->klien_id, 
                                            'terlapor_id'   => $request->terlapor_id, 
                                            'value'   => $request->hubungan_terlapor
                                        ]);
                // hapus semua variabel yang untuk inputan hubungan terlapor klien
                $request->request->remove('klien_id');
                $request->request->remove('terlapor_id');
                $request->request->remove('hubungan_terlapor');

                $data = Terlapor::where('uuid', $request->uuid)->first();
                $kasus = Kasus::find($data->kasus_id);
                // ambil salah 1 klien aja di kasus ini, nanti akan dipakai kasus_id nya
                $klien = Klien::where('kasus_id', $kasus->id)->first();
            }
            if ($data_update == 'klasifikasi') {
                // ambil salah 1 klien aja di kasus ini, nanti akan dipakai kasus_id nya
                $klien = Klien::where('uuid', $request->uuid)->first();
                // Jenis Kekerasan
                // hapus semua jenis_kekerasan kasus klien ini
                TJenisKekerasan::where('klien_id', $klien->id)->delete();
                // create jenis_kekerasan kasus klien ini
                if (isset($request->jenis_kekerasan)) {
                    foreach ($request->jenis_kekerasan as $item_jenis) {
                        TJenisKekerasan::create(['klien_id' => $klien->id, 'value' => $item_jenis]);
                    }
                }

                // Bentuk Kekerasan
                // hapus semua bentuk_kekerasan kasus klien ini
                TBentukKekerasan::where('klien_id', $klien->id)->delete();
                // create jenis_kekerasan kasus klien ini
                if (isset($request->bentuk_kekerasan)) {
                    foreach ($request->bentuk_kekerasan as $item_bentuk) {
                        TBentukKekerasan::create(['klien_id' => $klien->id, 'value' => $item_bentuk]);
                    }
                }
                // Kategori Kasus

                // hapus semua jenis_kekerasan kasus klien ini
                TKategoriKasus::where('klien_id', $klien->id)->delete();
                // create jenis_kekerasan kasus klien ini
                if (isset($request->kategori_kasus)) {
                    foreach ($request->kategori_kasus as $item) {
                        TKategoriKasus::create(['klien_id' => $klien->id, 'value' => $item]);
                    }
                }
            }

            if ($data_update != 'klasifikasi') {
                // jika selain klasifikasi maka savenya normal
                //hapus value data_update
                $request->request->remove('data_update');
                $data->update($request->all());

                $perubahan = $data->getChanges();
                if (!empty($perubahan)) {
                    $perubahan['pengubah'] = Auth::user()->name;
                    $perubahan[$data_update] = '';
                }
            }else{
                $perubahan = ['Jenis Kekerasan' => $request->jenis_kekerasan, 
                            'Bentuk Kekerasan' => $request->bentuk_kekerasan, 
                            'Kategori Kasus' => $request->kategori_kasus];
                $perubahan['pengubah'] = Auth::user()->name;
                $perubahan[$data_update] = '';
            }

            $perubahan = array_keys($perubahan);
            $petugas = DB::table('kasus as a')
                            ->leftJoin('klien as b', 'a.id', 'b.kasus_id')
                            ->leftJoin('petugas as c', 'b.id', 'c.klien_id')
                            ->leftJoin('users as d', 'c.user_id', 'd.id')
                            ->whereNull('c.deleted_at')
                            ->whereNull('d.deleted_at')
                            ->where('a.id', $klien->kasus_id);
            if ($data_update == 'klien') {
                // jika yang dirubah adalah data klien maka send notif ke petugas klien itu saja
                // jika yang dirubah adalah selain data klien maka kirim ke semua petugas yg menangani kasus dengan kejadian yg sama
                $petugas = $petugas->where('c.klien_id', $klien->id);
            }
            $petugas = $petugas->pluck('d.id');

            if (count($petugas) == 0) {
                // jika tidak ada satupun petugas maka ini action untuk Petugas Terima Kasus LaporKBG
                Petugas::create([
                    'klien_id' => $klien->id,
                    'user_id' => Auth::user()->id,
                    'created_by'=>  Auth::user()->id
                ]);
                
                NotifHelper::push_notif(
                    Auth::user()->id , //receiver_id
                    $klien->id, //klien_id
                    'T2', //type_notif
                    'task', //type_notif
                    $klien->no_klien ? $klien->no_klien : NULL, //noregis
                    'System', //from
                    'Kasus baru. Silahkan pilih Supervisor & Manajer Kasus', //message
                    ($klien && $klien->nama) ? $klien->nama : NULL,  //nama korban 
                    ($klien && $klien->tanggal_lahir) ? $klien->tanggal_lahir : NULL, //tanggal lahir korban
                    url('/kasus/show/'.$klien->uuid.'?tab=kasus-petugas&tambah-petugas=1'), //url
                    1, //kirim ke diri sendiri 0 / 1
                    Auth::user()->id, // created_by
                    NULL // agenda_id
                );
            }

            $klien_notifs = DB::table('kasus as a')
                            ->leftJoin('klien as b', 'a.id', 'b.kasus_id')
                            ->select('b.*')
                            ->where('a.id', $klien->kasus_id)
                            ->get();
            for ($i=0; $i < (count($perubahan) - 3); $i++) {
                // 3 adalah meta data lain yg bukan variabel inti
                //Proses read, push notif & log activity ////////////////////////////////////////////////////
                //kirim ke seluruh user yang ada di kasus ini / klien ini

                foreach ($petugas as $key => $value) {
                    // kirim ke petugas2nya
                    $perubahanjson = urlencode(json_encode($perubahan));
                    // ini untuk notifikasi ketika diklik
                    foreach ($klien_notifs as $klien_notif) {
                        // kirim sesuai kliennya
                        $petugasnya = Petugas::where('klien_id', $klien_notif->id)
                                            ->where('user_id', $value)
                                            ->count();
                        if ($petugasnya) {
                            // jika dia adalah petugas dari kliennya, maka kirim notif
                            NotifHelper::push_notif(
                                $value , //receiver_id
                                ($klien_notif && $klien_notif->id) ? $klien_notif->id : NULL, //klien_id
                                'N1', //kode
                                'notif', //type_notif
                                ($klien_notif && $klien_notif->no_klien) ? $klien_notif->no_klien : NULL, //noregis
                                Auth::user()->name, //from
                                Auth::user()->name.' mengubah variabel '.$perubahan[$i].' '.$data_update.'. Silahkan lihat perubahan untuk update informasi kasus', //message
                                ($klien_notif && $klien_notif->nama) ? $klien_notif->nama : NULL,  //nama korban 
                                ($klien_notif && $klien_notif->tanggal_lahir) ? $klien_notif->tanggal_lahir : NULL, //tanggal lahir korban
                                url('/kasus/show/'.$klien_notif->uuid.'?data='.$perubahanjson.'&kode=N1&type_notif=notif'), //url
                                0, // kirim ke diri sendiri 0 / 1
                                Auth::user()->id, // created_by
                                NULL // agenda_id
                            );
                           
                    }
                }
            }
            //  write log activity ////////////////////////////////////////////////////////////////////////
            if (Auth::user()->jabatan != 'Super Admin') {
                $message = Auth::user()->name.' mengubah variabel '.$perubahan[$i].' '.$data_update;
            } else {
                $message = Auth::user()->name.' mengubah variabel '.$perubahan[$i].' '.$data_update .'atas permohonan petugas'; 
            }
            
            LogActivityHelper::push_log(
                //message
                $message,
                //klien_id
                $klien_notif->id 
            );
            /////////////////////////////////////////////////////////////////////////////////////////////    

            }

            if($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'code'    => 200,
                    'message' => 'Data Berhasil Disimpan!',
                    'data'    => $perubahan  
                ]);
            }else{
                //return response
                $response = "Berhasil mengupdate data";
                return back()->with('data', json_encode($perubahan))
                        ->with('success', true)
                        ->with('response', $response);

            }
        } catch (Exception $e){
            if($request->ajax()) {
                return response()->json(['msg' => $e->getMessage()], 500);
            }else{
                dd($e->getMessage());
                return redirect()->back()->with('error', true)
                        ->with('response', $e->getMessage());
            }
            die();
        }
    }

    public function store_terlapor(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama' => 'required',
                ]);

                if ($validator->fails())
                {
                    throw new Exception($validator->errors());
                }
            $kasus = Kasus::find($request->kasus_id);
            //Data Terlapor
            $proses = Terlapor::create([
                'kasus_id' => $kasus->id,
                'nik' => $request->nik, 
                'nama' => $request->nama,  
                'tempat_lahir' => $request->tempat_lahir,  
                'tanggal_lahir' => $request->tanggal_lahir,  
                'jenis_kelamin' => $request->jenis_kelamin,  
                'provinsi_id_ktp' => isset($request->provinsi_id_ktp) ? $request->provinsi_id_ktp : 2,  
                'kotkab_id_ktp' => isset($request->kota_id_ktp) ? $request->kota_id_ktp : 2,  
                'kecamatan_id_ktp' => isset($request->kecamatan_id_ktp) ? $request->kecamatan_id_ktp : 2,  
                'kelurahan_id_ktp' => isset($request->kelurahan_id_ktp) ? $request->kelurahan_id_ktp : 2,  
                'alamat_ktp' => $request->alamat_ktp, 
                'provinsi_id' => isset($request->provinsi_id) ? $request->provinsi_id : 2,  
                'kotkab_id' => isset($request->kota_id) ? $request->kota_id : 2,  
                'kecamatan_id' => isset($request->kecamatan_id) ? $request->kecamatan_id : 2,  
                'kelurahan_id' => isset($request->kelurahan_id) ? $request->kelurahan_id : 2,  
                'alamat' => $request->alamat, 
                'agama' => $request->agama,  
                'status_kawin' => $request->status_kawin,  
                'pekerjaan' => $request->pekerjaan,  
                'kewarganegaraan' => $request->kewarganegaraan,  
                'pendidikan' => $request->pendidikan,  
                'status_pendidikan' => $request->status_pendidikan,  
                'no_telp' => $request->no_telp,  
                'desil' => $request->desil,  
                'created_by' => Auth::user()->id  
            ]);
        // tambah Hubungan Terlapor dengan Klien
        RHubunganTerlaporKlien::create([
            'klien_id'     => $request->klien_id, 
            'terlapor_id'   => $proses->id, 
            'value'   => $request->hubungan_terlapor
        ]);

        $klien = Klien::where('kasus_id', $request->kasus_id)->get();

        foreach ($klien as $key => $value) {
            // write log activity ////////////////////////////////////////////////////////////////////////
            LogActivityHelper::push_log(
                //message
                Auth::user()->name.' menambah terlapor '.$request->nama, 
                //klien_id
                $value->id 
            );
        }

        //return response
        $response = "Berhasil mengupdate data";
        return back()->with('success', true)
                ->with('response', $response);

        } catch (Exception $e){
            if($request->ajax()) {
                return response()->json(['msg' => $e->getMessage()], 500);
            }else{
                dd($e->getMessage());
                return redirect()->back()->with('error', true)
                        ->with('response', $e->getMessage());
            }
            die();
        }
    }

   // API CARIK
   public function carik($id)
   {
       //auth proxy
       $proxy = '10.15.3.20:80';
       $proxyauth = 'root:dki123@';

       $host = 'https://carik.jakarta.go.id/moccaapi/rest.php?nik='.$id;
       $ch = curl_init($host);
       //creds 
       $username = 'moca';
       $password = 'Moca22!';
       curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    //    curl_setopt($ch, CURLOPT_PROXY, $proxy);
    //    curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);
       curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
       curl_setopt($ch, CURLOPT_TIMEOUT, 30);
       curl_setopt($ch, CURLOPT_POST, 1);
       curl_setopt($ch, CURLOPT_POSTFIELDS, FALSE);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
       $data_korban = curl_exec($ch);
       curl_close($ch);

       $data_kasus = Kasus::leftJoin('klien', 'kasus.id', 'klien.kasus_id')
                            ->where('nik', $id)
                            ->select('klien.nama', 'kasus.uuid', 'kasus.tanggal_pelaporan')
                            ->get();

       $data = array('data_korban' => $data_korban, 'data_kasus' => $data_kasus );

       return $data;
   }

   public function deleteterlapor(Request $request)
   {
    try {
        $proses = Terlapor::where('uuid', $request->uuid)->delete();

        if (!$proses)
        {
            throw new Exception($proses);
        }

        //return response
        return response()->json([
            'success' => true,
            'code'    => 200,
            'message' => 'Data Berhasil Dihapus!'
        ]);
    } catch (Exception $e){
        return response()->json(['message' => $e->getMessage()]);
        die();
    }
   }
}
