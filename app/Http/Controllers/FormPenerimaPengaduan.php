<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivityHelper;
use App\Helpers\NotifHelper;
use App\Models\DifabelType;
use App\Models\Kasus;
use App\Models\KategoriKasus;
use App\Models\Klien;
use App\Models\KondisiKhusus;
use App\Models\Pasal;
use App\Models\Pelapor;
use App\Models\Petugas;
use App\Models\ProgramPemerintah;
use App\Models\Terlapor;
use App\Models\TindakKekerasan;
use Illuminate\Http\Request;
use Laravolt\Indonesia\Models\Provinsi;
use Exception;
use Illuminate\Support\Facades\Auth;
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
        $status_pendidikan =  app('App\Http\Controllers\OpsiController')->api_status_pendidikan();
        $pendidikan_terakhir =  app('App\Http\Controllers\OpsiController')->api_pendidikan_terakhir();
        $kelas =  app('App\Http\Controllers\OpsiController')->api_kelas();
        $agama =  app('App\Http\Controllers\OpsiController')->api_agama();
        $suku =  app('App\Http\Controllers\OpsiController')->api_suku();
        $pekerjaan =  app('App\Http\Controllers\OpsiController')->api_pekerjaan();
        $status_perkawinan =  app('App\Http\Controllers\OpsiController')->api_status_perkawinan();
        $hubungan_dengan_terlapor =  app('App\Http\Controllers\OpsiController')->api_hubungan_dengan_terlapor();
        $hubungan_dengan_klien =  app('App\Http\Controllers\OpsiController')->api_hubungan_dengan_klien();
        $kekhususan =  app('App\Http\Controllers\OpsiController')->api_kekhususan();
        $difabel_type =  app('App\Http\Controllers\OpsiController')->api_difabel_type();
        $kategori_kasus =  app('App\Http\Controllers\OpsiController')->api_kategori_kasus();
        $tindak_kekerasan =  app('App\Http\Controllers\OpsiController')->api_tindak_kekerasan();
        $pengadilan_negri =  app('App\Http\Controllers\OpsiController')->api_pengadilan_negri();
        $pasal =  app('App\Http\Controllers\OpsiController')->api_pasal();
        $media_pengaduan =  app('App\Http\Controllers\OpsiController')->api_media_pengaduan();
        $sumber_rujukan =  app('App\Http\Controllers\OpsiController')->api_sumber_rujukan();
        $sumber_informasi =  app('App\Http\Controllers\OpsiController')->api_sumber_infromasi();
        $program_pemerintah =  app('App\Http\Controllers\OpsiController')->api_program_pemerintah();
        $tempat_kejadian =  app('App\Http\Controllers\OpsiController')->api_tempat_kejadian();
        $provinsi = Provinsi::get();
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
                                            ->with('difabel_type', $difabel_type)
                                            ->with('kategori_kasus', $kategori_kasus)
                                            ->with('tindak_kekerasan', $tindak_kekerasan)
                                            ->with('pengadilan_negri', $pengadilan_negri)
                                            ->with('pasal', $pasal)
                                            ->with('media_pengaduan', $media_pengaduan)
                                            ->with('sumber_rujukan', $sumber_rujukan)
                                            ->with('sumber_informasi', $sumber_informasi)
                                            ->with('program_pemerintah', $program_pemerintah)
                                            ->with('tempat_kejadian',$tempat_kejadian);
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
                'tanggal_kejadian' => 'required'
                ]);
                if (Auth::user()->jabatan == 'Penerima Pengaduan') {
                    $created_by = Auth::user()->id; 
                }else{
                    $created_by = NULL;
                }

                if ($validator->fails())
                {
                    throw new Exception($validator->errors());
                }
            
            //Data Kasus
            $kasus = Kasus::create([
                'tanggal_pelaporan' => $request->tanggal_pelaporan,
                'tanggal_kejadian' => $request->tanggal_kejadian,
                'tempat_kejadian' => $request->tempat_kejadian,
                'media_pengaduan' => $request->media_pengaduan,
                'sumber_rujukan' => $request->sumber_rujukan,
                'sumber_informasi' => $request->sumber_informasi,
                'deskripsi' => $request->deskripsi_kasus,
                'provinsi_id' => $request->provinsi_id_kasus,
                'kotkab_id' => $request->kota_id_kasus,
                'kecamatan_id' => $request->kecamatan_id_kasus,
                'kelurahan' => $request->kelurahan_kasus,
                'alamat' => $request->alamat_kasus,
                'created_by' => $created_by
            ]);

            //Data Pelapor
            $pelapor = Pelapor::create([
                'kasus_id' => $kasus->id,
                'nik' => $request->nik_pelapor,
                'nama' => $request->nama_pelapor,
                'tempat_lahir' => $request->tempat_lahir_pelapor,
                'tanggal_lahir' => $request->tanggal_lahir_pelapor,
                'provinsi_id' => $request->provinsi_id_pelapor,
                'kotkab_id' => $request->kota_id_pelapor,
                'kecamatan_id' => $request->kecamatan_id_pelapor,
                'kelurahan' => $request->kelurahan_pelapor,
                'alamat' => $request->alamat_pelapor,
                'no_telp' => $request->no_telp_pelapor,
                'file_ttd' => $request->file_ttd_pelapor,
                'hubungan_pelapor' => $request->hubungan_pelapor,
                'desil' => $request->desil_pelapor,
                'created_by' => $created_by
            ]);

            // return $arrayName = array('data' => $request->nik_klien, 'pasal' => $request->pasal);
            //Data Klien
            $klien = $request->nama_klien;
            foreach ($klien as $key => $value) {
                $klien = Klien::create([
                        'kasus_id' => $kasus->id,
                        'status' => 'Pelengkapan Data',
                        'nik' => isset($request->nik_klien[$key]) ? $request->nik_klien[$key] : NULL, 
                        'nama' => $request->nama_klien[$key],  
                        'tempat_lahir' => isset($request->tempat_lahir_klien[$key]) ? $request->tempat_lahir_klien[$key] : NULL,  
                        'tanggal_lahir' => isset($request->tanggal_lahir_klien[$key]) ? $request->tanggal_lahir_klien[$key] : NULL,  
                        'provinsi_id' => isset($request->provinsi_id_klien[$key]) ? $request->provinsi_id_klien[$key] : NULL,  
                        'kotkab_id' => isset($request->kota_id_klien[$key]) ? $request->kota_id_klien[$key] : NULL,  
                        'kecamatan_id' => isset($request->kecamatan_id_klien[$key]) ? $request->kecamatan_id_klien[$key] : NULL,  
                        'kelurahan' => isset($request->kelurahan_klien[$key]) ? $request->kelurahan_klien[$key] : NULL,  
                        'alamat' => isset($request->alamat_klien[$key]) ? $request->alamat_klien[$key] : NULL, 
                        'jenis_kelamin' => isset($request->jenis_kelamin_klien[$key]) ? $request->jenis_kelamin_klien[$key] : NULL,  
                        'agama' => isset($request->agama_klien[$key]) ? $request->agama_klien[$key] : NULL,  
                        'suku' => isset($request->suku_klien[$key]) ? $request->suku_klien[$key] : NULL,  
                        'no_telp' => isset($request->no_telp_klien[$key]) ? $request->no_telp_klien[$key] : NULL,  
                        'status_pendidikan' => isset($request->status_pendidikan_klien[$key]) ? $request->status_pendidikan_klien[$key] : NULL,  
                        'pendidikan' => isset($request->pendidikan_klien[$key]) ? $request->pendidikan_klien[$key] : NULL,  
                        'kelas' => isset($request->kelas[$key]) ? $request->kelas[$key] : NULL,  
                        'pekerjaan' => isset($request->pekerjaan_klien[$key]) ? $request->pekerjaan_klien[$key] : NULL,  
                        'penghasilan' => isset($request->penghasilan_klien[$key]) ? $request->penghasilan_klien[$key] : NULL,  
                        'status_kawin' => isset($request->perkawinan_klien[$key]) ? $request->perkawinan_klien[$key] : NULL,  
                        'anak_ke' => isset($request->anak_ke[$key]) ? $request->anak_ke[$key] : NULL,  
                        'jumlah_anak' => isset($request->jumlah_anak_klien[$key]) ? $request->jumlah_anak_klien[$key] : NULL,  
                        'nama_ibu' => isset($request->nama_ibu[$key]) ? $request->nama_ibu[$key] : NULL,  
                        'tempat_lahir_ibu' => isset($request->tempat_lahir_ibu[$key]) ? $request->tempat_lahir_ibu[$key] : NULL,  
                        'tanggal_lahir_ibu' => isset($request->tanggal_lahir_ibu[$key]) ? $request->tanggal_lahir_ibu[$key] : NULL,   
                        'nama_ayah' => isset($request->nama_ayah[$key]) ? $request->nama_ayah[$key] : NULL,  
                        'tempat_lahir_ayah' => isset($request->tempat_lahir_ayah[$key]) ? $request->tempat_lahir_ayah[$key] : NULL,  
                        'tanggal_lahir_ayah' => isset($request->tanggal_lahir_ayah[$key]) ? $request->tanggal_lahir_ayah[$key] : NULL,  
                        'hubungan_klien' => isset($request->hubungan_klien[$key]) ? $request->hubungan_klien[$key] : NULL,  
                        'no_lp' => isset($request->no_lp[$key]) ? $request->no_lp[$key]  : NULL,  
                        'pengadilan_negri' => isset($request->pengadilan_negri[$key]) ? $request->pengadilan_negri[$key]  : NULL,  
                        'isi_putusan' => isset($request->isi_putusan[$key]) ? $request->isi_putusan[$key] : NULL,  
                        'lpsk' => isset($request->lpsk_klien[$key]) ? $request->lpsk_klien[$key] : NULL,  
                        'file_ttd' => isset($request->file_ttd_klien[$key]) ? $request->file_ttd_klien[$key] : NULL,  
                        'desil' => isset($request->desil_klien[$key]) ? $request->desil_klien[$key] : NULL,  
                        'created_by' => $created_by  
                    ]);

                //simpan petugas yang bertanggung jawab pada kasus
                if (isset(Auth::user()->id)) {
                    if (Auth::user()->jabatan == 'Penerima Pengaduan') {
                    Petugas::create(['klien_id' => $klien->id, 'user_id' => Auth::user()->id, 'created_by' => Auth::user()->id]);
                    }
                }

                //simpan tindak kekerasan
                if (isset($request->tindak_kekerasan[$key])) {
                    $tindak_kekerasan = $request->tindak_kekerasan[$key];
                    foreach ($tindak_kekerasan as $key1 => $value) {
                        $proses['tindak_kekerasan'] = TindakKekerasan::create(['klien_id' => $klien->id, 'value' => $tindak_kekerasan[$key1]]);
                    }
                }
                //simpan program pemerintah
                if (isset($request->program_pemerintah[$key])) {
                    $program_pemerintah = $request->program_pemerintah[$key];
                    foreach ($program_pemerintah as $key2 => $value) {
                        $proses['program_pemerintah'] = ProgramPemerintah::create(['klien_id' => $klien->id, 'value' => $program_pemerintah[$key2]]);
                    }
                }
                //simpan kategori kasus
                if (isset($request->kategori_kasus[$key])) {
                    $kategori_kasus = $request->kategori_kasus[$key];
                    foreach ($kategori_kasus as $key3 => $value) {
                        $proses['kategori_kasus'] = KategoriKasus::create(['klien_id' => $klien->id, 'value' => $kategori_kasus[$key3]]);
                    }
                }
                //simpan kondisi khusus
                if (isset($request->kondisi_khusus_klien[$key])) {
                    $kondisi_khusus = $request->kondisi_khusus_klien[$key];
                    foreach ($kondisi_khusus as $key4 => $value) {
                        $proses['kondisi_khusus'] = KondisiKhusus::create(['klien_id' => $klien->id, 'value' => $kondisi_khusus[$key4]]);
                    }
                }
                //simpan difabel type
                if (isset($request->difabel_type[$key])) {
                    $difabel_type = $request->difabel_type[$key];
                    foreach ($difabel_type as $key5 => $value) {
                        $proses['difabel_type'] = DifabelType::create(['klien_id' => $klien->id, 'value' => $difabel_type[$key5]]);
                    }
                }
                //simpan pasal
                if (isset($request->pasal[$key])) {
                    $pasal = $request->pasal[$key];
                    foreach ($pasal as $key6 => $value) {
                        $proses['pasal'] = Pasal::create(['klien_id' => $klien->id, 'value' => $pasal[$key6]]);
                    }
                }


            if (isset(Auth::user()->id)) {
                if (Auth::user()->jabatan == 'Penerima Pengaduan') {
                    //push notifikasi ///////////////////////////////////////////////////////////////////////////
                    NotifHelper::push_notif(
                        Auth::user()->id , //receiver_id
                        $klien->id, //klien_id
                        'task', //type_notif
                        $klien->no_klien ? $klien->no_klien : '', //noregis
                        'System', //from
                        'Kasus baru. Silahkan pilih Supervisor & Manajer Kasus', //message
                        $request->nama_klien[$key], //nama korban 
                        isset($request->tanggal_lahir_klien[$key]) ? $request->tanggal_lahir_klien[$key] : NULL, //tanggal lahir korban
                        url('/kasus/show/'.$klien->uuid), //url
                        Auth::user()->id //sender_id
                    );
                    //write log activity ////////////////////////////////////////////////////////////////////////
                    LogActivityHelper::push_log(
                        //message
                        Auth::user()->name.' menginputkan data kasus baru', 
                        //klien_id
                        $klien->id 
                    );
                    /////////////////////////////////////////////////////////////////////////////////////////////
                }
            }

            }

            //Data Terlapor
            $terlapor = $request->nama_terlapor;
            if (isset($terlapor)) {
                foreach ($terlapor as $key => $value) {
                    Terlapor::create([
                        'kasus_id' => $kasus->id,
                        'nik' => isset($request->nik_terlapor[$key]) ? $request->nik_terlapor[$key] : NULL,
                        'nama' => isset($request->nama_terlapor[$key]) ? $request->nama_terlapor[$key] : NULL,
                        'tempat_lahir' => isset($request->tempat_lahir_terlapor[$key]) ? $request->tempat_lahir_terlapor[$key] : NULL,
                        'tanggal_lahir' => isset($request->tanggal_lahir_terlapor[$key]) ? $request->tanggal_lahir_terlapor[$key] : NULL,
                        'provinsi_id' => isset($request->provinsi_id_terlapor[$key]) ? $request->provinsi_id_terlapor[$key] : NULL,
                        'kotkab_id' => isset($request->kota_id_terlapor[$key]) ? $request->kota_id_terlapor[$key] : NULL,
                        'kecamatan_id' => isset($request->kecamatan_id_terlapor[$key]) ? $request->kecamatan_id_terlapor[$key] : NULL,
                        'kelurahan' => isset($request->kelurahan_terlapor[$key]) ? $request->kelurahan_terlapor[$key] : NULL,
                        'alamat' => isset($request->alamat_terlapor[$key]) ? $request->alamat_terlapor[$key] : NULL,
                        'jenis_kelamin' => isset($request->jenis_kelamin_terlapor[$key]) ? $request->jenis_kelamin_terlapor[$key] : NULL,
                        'agama' => isset($request->agama_terlapor[$key]) ? $request->agama_terlapor[$key] : NULL,
                        'suku' => isset($request->suku_terlapor[$key]) ? $request->suku_terlapor[$key] : NULL,
                        'no_telp' => isset($request->no_telp_terlapor[$key]) ? $request->no_telp_terlapor[$key] : NULL,
                        'status_pendidikan' => isset($request->status_pendidikan_terlapor[$key]) ? $request->status_pendidikan_terlapor[$key] : NULL,
                        'pendidikan' => isset($request->pendidikan_terlapor[$key]) ? $request->pendidikan_terlapor[$key] : NULL,
                        'pekerjaan' => isset($request->pekerjaan_telapor[$key]) ? $request->pekerjaan_telapor[$key] : NULL,
                        'status_kawin' => isset($request->perkawinan_terlapor[$key]) ? $request->perkawinan_terlapor[$key] : NULL,
                        'jumlah_anak' => isset($request->jumlah_anak_terlapor[$key]) ? $request->jumlah_anak_terlapor[$key] : NULL,
                        'hubungan_terlapor' => isset($request->hubungan_terlapor[$key]) ? $request->hubungan_terlapor[$key] : NULL,  
                        'file_ttd' => isset($request->file_ttd_terlapor[$key]) ? $request->file_ttd_terlapor[$key] : NULL,  
                        'desil' => isset($request->desil_terlapor[$key]) ? $request->desil_terlapor[$key] : NULL,  
                        'created_by' => $created_by
                    ]);
                }
            }

            //Data Petugas
            if (Auth::user()->jabatan == 'Penerima Pengaduan') {
                Petugas::create([
                    'klien_id' => $klien->id,
                    'user_id' => $created_by,
                    'created_by' => $created_by
                ]);
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
            if ($data_update == 'pelapor') {
                $data = Pelapor::where('uuid', $request->uuid)->first();
                $kasus_id = $data->kasus_id;
            }
            if ($data_update == 'klien') {
                $data = Klien::where('uuid', $request->uuid)->first();
                $kasus_id = $data->kasus_id;
                //proses update kondisi_khusus klien di tabel kondisi_khusus
                KondisiKhusus::where('klien_id', $data->id)->delete();
                //simpan kondisi_khusus
                if (isset($request->kondisi_khusus)) {
                    $kondisi_khusus = $request->kondisi_khusus;
                    foreach ($kondisi_khusus as $key4 => $value) {
                        $proses['kondisi_khusus'] = KondisiKhusus::create(['klien_id' => $data->id, 'value' => $kondisi_khusus[$key4]]);
                    }
                }

                $request->request->remove('kondisi_khusus');
                $request->request->remove('difabel_type');
            }
            $klien = Klien::where('id', $kasus_id)->first();
            //hapus value data_update
            $request->request->remove('data_update');
            $data->update($request->all());
            $perubahan = $data->getChanges();

            if (!empty($perubahan)) {
                $perubahan['pengubah'] = Auth::user()->name;
                $perubahan[$data_update] = '';
            }
            $perubahan = array_keys($perubahan);

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
                return redirect()->route('kasus.show', $klien->uuid)
                        ->with('data', json_encode($perubahan))
                        ->with('success', true)
                        ->with('response', $response);

            }
        } catch (Exception $e){
            if($request->ajax()) {
                return response()->json(['msg' => $e->getMessage()], 500);
            }else{
                return redirect()->route('kasus.show', $klien->uuid)
                        ->with('error', true)
                        ->with('response', $e->getMessage());
            }
            die();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
