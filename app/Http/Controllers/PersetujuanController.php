<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivityHelper;
use App\Helpers\NotifHelper;
use App\Helpers\StatusHelper;
use App\Models\Klien;
use App\Models\PersetujuanIsi;
use App\Models\PersetujuanItem;
use App\Models\PersetujuanTemplate;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class PersetujuanController extends Controller
{
    public function show(Request $request, $uuid)
    {
        try {
            $persetujuan_isi = PersetujuanIsi::where('uuid', $uuid)->first();
            $persetujuan_template = PersetujuanTemplate::where('id', $persetujuan_isi->persetujuan_template_id)->first();
            $persetujuan_item = PersetujuanItem::where('persetujuan_template_id', $persetujuan_template->id)
                                ->where('parent_id', 0)
                                ->with('children')
                                ->get();

            if ($persetujuan_isi->tandatangan != null) {
                return redirect('persetujuan/donepelayanan/'.$uuid);
            }

            $klien = Klien::where('id', $persetujuan_isi->klien_id)->first();

            return view('persetujuan.show')
                    ->with('persetujuan_template', $persetujuan_template)
                    ->with('persetujuan_item', $persetujuan_item)
                    ->with('persetujuan_isi', $persetujuan_isi)
                    ->with('klien', $klien);
        } catch (Exception $e){
            return response()->json(['message' => $e->getMessage()]);
            die();
        }
    }

    public function create($uuid, Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'persetujuan_template_uuid' => 'required'
                ]);
                if ($validator->fails())
                {
                    throw new Exception($validator->errors());
                }

                $klien = Klien::where('uuid', $uuid)->first();
                $persetujuan_template = PersetujuanTemplate::where('uuid', $request->persetujuan_template_uuid)->first();
                //create persetujuan
                $proses = PersetujuanIsi::create([
                    'klien_id'   => $klien->id, 
                    'persetujuan_template_id' => $persetujuan_template->id, 
                    'created_by'   => Auth::user()->id
                ]);
            
            // ===========================================================================================
            //Proses read, push notif & log activity ////////////////////////////////////////////////////
            // update status klien //////////////////////////////////////////////////////////////////////
            StatusHelper::push_status($klien->id, 'Menunggu tanda tangan klien');
            //write log activity ////////////////////////////////////////////////////////////////////////
            LogActivityHelper::push_log(
                //message
                Auth::user()->name.' membuat '.$persetujuan_template->judul, 
                //klien_id
                $klien->id 
            );
            /////////////////////////////////////////////////////////////////////////////////////////////


            //return response
            $response =  response()->json([
                'success' => true,
                'code'    => 200,
                'message' => 'Data Berhasil Disimpan!',
                'data'    => $proses  
            ]);
            
            return redirect()->route('kasus.show', ['uuid' => $uuid, 'tab' => 'kasus-persetujuan', 'tabel-persetujuan' => 1])
            ->with('success', true)
            ->with('response', $response);
        } catch (Exception $e){
            return response()->json(['message' => $e->getMessage()]);
            die();
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama_penandatangan' => 'required',
                'no_telp' => 'required',
                'alamat' => 'required'
                ]);
                if ($validator->fails())
                {
                    throw new Exception($validator->errors());
                }

            // handle statement
            $statement = [
                'setuju' => [],
                'tidak_setuju' => [],
            ];
            if (isset($request->statement)) {
                if (count($request->statement) > 0) {
                    foreach ($request->statement as $key => $value) {
                        if ($value == 1) {
                            $statement['setuju'][] = $key;
                        }
                        if ($value == 0) {
                            $statement['tidak_setuju'][] = $key;
                        }
                    }
                }
            }

            //simpan tandatangan
            $folderPath = public_path('img/tandatangan/ttd_klien/');
            $image_parts = explode(";base64,", $request->tandatangan);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $file = uniqid() . '.'.$image_type;
            $filepath = $folderPath . $file;
            file_put_contents($filepath, $image_base64);

            $data = [
                'alamat' => $request->alamat,
                'no_telp' => $request->no_telp,
                'isi' =>  json_encode($statement),
                'catatan' => $request->catatan,
                'tandatangan' => $file,
                'nama_penandatangan' => $request->nama_penandatangan
            ];
    
            $proses = PersetujuanIsi::updateOrCreate(['uuid' => $request->uuid], $data);

            $persetujuan_isi = PersetujuanIsi::where('uuid', $request->uuid)->first();
            
            $persetujuan_template = PersetujuanTemplate::where('id', $persetujuan_isi->persetujuan_template_id)->first();
            
            $klien = Klien::where('id', $persetujuan_isi->klien_id)->first();
            // ===========================================================================================
            //Proses read, push notif & log activity ////////////////////////////////////////////////////
            //kirim notifikasi ke MK, MK bisa jadi lebih dari 1
            $mk = DB::table('petugas as a')
                    ->leftJoin('users as b', 'a.user_id', 'b.id')
                    ->where('b.jabatan', 'Manajer Kasus')
                    ->where('a.klien_id', $klien->id)
                    ->whereNull('a.deleted_at')
                    ->whereNull('b.deleted_at')
                    ->pluck('b.id');

            $notifjson = NULL;
            foreach ($mk as $key => $value) {
                NotifHelper::push_notif(
                    $value , //receiver_id
                    ($klien && $klien->id) ? $klien->id : NULL, //klien_id
                    'T7', //kode
                    'task', //type_notif
                    ($klien && $klien->no_klien) ? $klien->no_klien : NULL, //noregis
                    'System', //from
                    'Klien sudah mengisi '.$persetujuan_template->judul.'. Silahkan lihat isinya untuk update informasi kasus', //message
                    ($klien && $klien->nama) ? $klien->nama : NULL,  //nama korban 
                    ($klien && $klien->tanggal_lahir) ? $klien->tanggal_lahir : NULL, //tanggal lahir korban
                    url('/kasus/show/'.$klien->uuid.'?tab=kasus-persetujuan&row-persetujuan='.$request->uuid.'&user_id='.$value.'&kode=T7&type_notif=task'), //url
                    1, // kirim ke diri sendiri 0 / 1
                    0, // created_by
                    NULL // agenda_id
                );
                // untuk kirim realtime notifikasi
                $notif_receiver[] = 'user_'.$value;
                $notifjson = urlencode(json_encode($notif_receiver));
            }
            // update status klien //////////////////////////////////////////////////////////////////////
            StatusHelper::push_status($persetujuan_isi->klien_id, 'Klien telah menandatangani');
            //write log activity ////////////////////////////////////////////////////////////////////////
            LogActivityHelper::push_log(
                //message
                'Klien mengisi '.$persetujuan_template->judul, 
                //klien_id
                $persetujuan_isi->klien_id 
            );
            /////////////////////////////////////////////////////////////////////////////////////////////
            
            //return response
            $response =  response()->json([
                'success' => true,
                'code'    => 200,
                'message' => 'Data Berhasil Disimpan!',
                'data'    => $proses  
            ]);
            
            return redirect('persetujuan/donepelayanan/'.$request->uuid.'?success=1&notif='.$notifjson);
        } catch (Exception $e){
            return response()->json(['message' => $e->getMessage()]);
            die();
        }
    }

    public function donepelayanan($uuid)
    {
        $persetujuan_isi = PersetujuanIsi::where('uuid', $uuid)->first();
        if (!$persetujuan_isi) {
            abort(404);
        }
        $persetujuan_template = PersetujuanTemplate::where('id', $persetujuan_isi->persetujuan_template_id)->first();
        $persetujuan_item = PersetujuanItem::where('persetujuan_template_id', $persetujuan_template->id)
                            ->where('parent_id', 0)
                            ->with('children')
                            ->get();

        $klien = Klien::where('id', $persetujuan_isi->klien_id)->first();

        return view('persetujuan.donepelayanan',)
                    ->with('persetujuan_template', $persetujuan_template)
                    ->with('persetujuan_item', $persetujuan_item)
                    ->with('persetujuan_isi', $persetujuan_isi)
                    ->with('klien', $klien);
    }

    public function isi_persetujuan_data($uuid)
    {
        //data klien 
       $klien = DB::table('klien as a')
                ->select(DB::raw('a.*, b.name as provinsi, c.name as kota, d.name as kecamatan, e.t_tipe_disabilitas, f.kondisi_khusus'))
                ->leftJoin('indonesia_provinces as b', 'a.provinsi_id', 'b.code')
                ->leftJoin('indonesia_cities as c', 'a.kotkab_id', 'c.code')
                ->leftJoin('indonesia_districts as d', 'a.kecamatan_id', 'd.code')
                ->leftJoin(DB::raw('(SELECT klien_id, GROUP_CONCAT(" ", value) as t_tipe_disabilitas FROM t_tipe_disabilitas GROUP BY klien_id) as e'), 'a.id', 'e.klien_id')
                ->leftJoin(DB::raw('(SELECT klien_id, GROUP_CONCAT(" ", value) as kondisi_khusus FROM kondisi_khusus GROUP BY klien_id) as f'), 'a.id', 'f.klien_id')
                ->where('a.uuid', $uuid)
                ->groupBy('a.id')
                ->first();

        //data kasus 
        $kasus = DB::table('kasus as a')
            ->select(DB::raw('a.*, b.name as provinsi, c.name as kota, d.name as kecamatan'))
            ->leftJoin('indonesia_provinces as b', 'a.provinsi_id', 'b.code')
            ->leftJoin('indonesia_cities as c', 'a.kotkab_id', 'c.code')
            ->leftJoin('indonesia_districts as d', 'a.kecamatan_id', 'd.code')
            ->where('a.id', $klien->kasus_id)
            ->first();
        //data pelapor
        $pelapor = DB::table('pelapor as a')
            ->select(DB::raw('a.*, b.name as provinsi, c.name as kota, d.name as kecamatan'))
            ->leftJoin('indonesia_provinces as b', 'a.provinsi_id', 'b.code')
            ->leftJoin('indonesia_cities as c', 'a.kotkab_id', 'c.code')
            ->leftJoin('indonesia_districts as d', 'a.kecamatan_id', 'd.code')
            ->where('a.kasus_id', $klien->kasus_id)
            ->first();
        //data terlapor
        $terlapor = DB::table('terlapor as a')
            ->select(DB::raw('a.*, b.name as provinsi, c.name as kota, d.name as kecamatan'))
            ->leftJoin('indonesia_provinces as b', 'a.provinsi_id', 'b.code')
            ->leftJoin('indonesia_cities as c', 'a.kotkab_id', 'c.code')
            ->leftJoin('indonesia_districts as d', 'a.kecamatan_id', 'd.code')
            ->where('a.kasus_id', $klien->kasus_id)
            ->get();

        $pelapor_tanggal_lahir = $pelapor->tanggal_lahir ? date('d M Y', strtotime($pelapor->tanggal_lahir)) : "";
        $isi = '
            <b>A. IDENTITAS PELAPOR</b>
            <table class="table table-bottom table-sm">
            <tr>
                <td style="width: 200px">Nama</td>
                <td>:</td>
                <td>'.$pelapor->nama.'</td>
            </tr>
            <tr>
                <td style="width: 200px">NIK</td>
                <td>:</td>
                <td>'.$pelapor->nik.'</td>
            </tr>
            <tr>
                <td style="width: 200px">Tempat/Tgl Lahir</td>
                <td>:</td>
                <td>'.$pelapor->tempat_lahir.', '.$pelapor_tanggal_lahir.'('. $pelapor->tanggal_lahir ? Carbon::parse($pelapor->tanggal_lahir)->age.' tahun' : "".')
                </td>
            </tr>
            <tr>
                <td style="width: 200px">Alamat</td>
                <td>:</td>
                <td>'.$pelapor->alamat.'<b>Provinsi</b> '.$pelapor->provinsi.' <b>Kota</b> '.$pelapor->kota.' <b>Kelurahan</b> '.$pelapor->kelurahan.'
                </td>
            </tr>
            <tr>
                <td style="width: 200px">No Telp</td>
                <td>:</td>
                <td>'.$pelapor->no_telp.'</td>
            </tr>
            <tr>
                <td style="width: 200px">Hubungan dengan klien</td>
                <td>:</td>
                <td>'.$pelapor->hubungan_pelapor.'
                </td>
            </tr>
        </table>';
        return $isi;
    }
}
