<?php

namespace App\Http\Controllers;

use App\Models\Kasus;
use App\Models\Klien;
use App\Models\Pelapor;
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
        $provinsi = Provinsi::get();
        return view('formpenerimapengaduan')->with('provinsi', $provinsi)
                                            ->with('status_pendidikan', $status_pendidikan)
                                            ->with('pendidikan_terakhir', $pendidikan_terakhir)
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
                                            ->with('program_pemerintah', $program_pemerintah);
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
                $created_by = isset(Auth::user()->id) ? Auth::user()->id : NULL; 

                if ($validator->fails())
                {
                    return response()->json([
                        'success' => false,
                        'code'    => 422,
                        'message' => $validator->errors(),
                        'data'    => $request  
                    ]);
                }
            
            //Data Kasus
            $kasus = Kasus::create([
                'tanggal_pelaporan' => $request->tanggal_pelaporan,
                'tanggal_kejadian' => $request->tanggal_kejadian,
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
                'desil' => $request->desil_pelapor,
                'created_by' => $created_by
            ]);

            //Data Klien
            $klien = $request->nama_klien;
            foreach ($klien as $key => $value) {
                    Klien::create([
                    'kasus_id' => $kasus->id,
                    'status' => 'Pelengkapan Data',
                    'nik' => isset($request->nik_klien[$key]) ? $request->nik_klien[$key] : NULL, 
                    'nama' => isset($request->nama_klien[$key]) ? $request->nama_klien[$key] : NULL,  
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
                    'pekerjaan' => isset($request->pekerjaan_klien[$key]) ? $request->pekerjaan_klien[$key] : NULL,  
                    'status_kawin' => isset($request->perkawinan_klien[$key]) ? $request->perkawinan_klien[$key] : NULL,  
                    'jumlah_anak' => isset($request->jumlah_anak_klien[$key]) ? $request->jumlah_anak_klien[$key] : NULL,  
                    'no_lp' => isset($request->no_lp[$key]) ? $request->no_lp[$key]  : NULL,  
                    'pasal' => isset($request->pasal[$key]) ? $request->pasal[$key]  : NULL,  
                    'pengadilan_negri' => isset($request->pengadilan_negri[$key]) ? $request->pengadilan_negri[$key]  : NULL,  
                    'isi_putusan' => isset($request->isi_putusan[$key]) ? $request->isi_putusan[$key] : NULL,  
                    'lpsk' => isset($request->lpsk_klien[$key]) ? $request->lpsk_klien[$key] : NULL,  
                    'file_ttd' => isset($request->file_ttd_klien[$key]) ? $request->file_ttd_klien[$key] : NULL,  
                    'desil' => isset($request->desil_klien[$key]) ? $request->desil_klien[$key] : NULL,  
                    'created_by' => $created_by  
                ]);
            }

            //return response
            $response = "Berhasil menginputkan data";
            return redirect()->route('formpenerimapengaduan.index')
                    ->with('success', true)
                    ->with('response', $response);

        } catch (Exception $e){
            return redirect()->route('formpenerimapengaduan.index')
                    ->with('error', true)
                    ->with('response', $e->getMessage());
            die();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
