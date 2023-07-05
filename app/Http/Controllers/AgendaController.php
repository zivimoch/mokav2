<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\DokumenTl;
use App\Models\TindakLanjut;
use Exception;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\New_;
use Yajra\DataTables\Facades\DataTables;

class AgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {

    }

    public function api_index(Request $request)
    {
        // return Auth::user()->id;
        if (isset($request->user_id)) {
            $user_id = $request->user_id;
        }else{
            $user_id = Auth::user()->id;
        }
        $data = DB::table('agenda as a')
                    ->leftJoin('tindak_lanjut as b', 'b.agenda_id', 'a.id')
                    ->leftJoin('users as c', 'c.id', 'b.validated_by')
                    ->where('b.created_by', $user_id)
                    ->whereYear('a.tanggal_mulai', $request->tahun)
                    ->whereMonth('a.tanggal_mulai', $request->bulan)
                    ->orderBy('a.tanggal_mulai')
                    ->orderBy('a.jam_mulai')
                    ->get(['a.tanggal_mulai', 'a.jam_mulai', 'a.klien_id', 'b.tanggal_selesai', 'b.jam_selesai', 'a.judul_kegiatan', 'a.keterangan', 'a.uuid', 'b.lokasi', 'b.catatan', 'c.name', 'b.created_by']);
        return DataTables::of($data)->make(true);
    }

    public function kinerja(Request $request)
    {
        try {
            return view('agenda.kinerja');
        } catch (Exception $e){
            return response()->json(['msg' => $e->getMessage()], 404);
            die();
        }
    }

    public function kinerja_detail(Request $request)
    {
        if ($request->get('bulan') == null) {
            return redirect('kinerja');
        }

        return view('agenda.kinerja_detail');
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
                'judul_kegiatan' => 'required',
                'tanggal_mulai' => 'required',
                'jam_mulai' => 'required'
                ]);
                if ($validator->fails())
                {
                    return response()->json([
                        'success' => false,
                        'code'    => 422,
                        'message' => $validator->errors(),
                        'data'    => $request  
                    ]);
                }

                //create post
                $proses = Agenda::updateOrCreate(['uuid' => $request->uuid],[
                    'klien_id'     => $request->klien_id, 
                    'judul_kegiatan'   => $request->judul_kegiatan, 
                    'tanggal_mulai'   => $request->tanggal_mulai,
                    'jam_mulai'   => $request->jam_mulai,
                    'keterangan'   => $request->keterangan,
                    'created_by'   => Auth::user()->id
                ]);

                $hapus_user = 1;
                if (!empty($request->user_id)) {
                    foreach ($request->user_id as $value) {
                        if (!isset($request->uuid)) { //jika tidak ada maka tambah
                            TindakLanjut::create([
                                'agenda_id' => $proses->id,
                                'created_by' => $value
                            ]);

                            //kirim notifikasi "anda ditambahkan ke agenda. silahkan isi tindak lanjutnya"
                        }else{
                            // buat baru saat edit, cek dulu sudah ada apa belum
                            $tindak_lanjut = TindakLanjut::where('created_by', $value)->where('agenda_id', $proses->id)->first();
                            if (empty($tindak_lanjut)) {
                                TindakLanjut::create([
                                    'agenda_id' => $proses->id,
                                    'created_by' => $value
                                ]);

                                //kirim notifikasi "anda ditambahkan ke agenda. silahkan isi tindak lanjutnya"
                            }
                        }

                        if ($value == Auth::user()->id) {
                            TindakLanjut::where('created_by', $value)->where('agenda_id', $proses->id)->update([
                                'lokasi' => $request->lokasi,
                                'tanggal_selesai' => $request->tanggal_mulai, //tanggal selesai = tanggal mulai, karna kita main jadwanya per tanggal
                                'jam_selesai' => $request->jam_selesai,
                                'catatan' => $request->catatan
                            ]);

                            if (isset($request->dokumen_pendukung)) {
                                foreach ($request->dokumen_pendukung as $value_dokumen) {
                                    DokumenTl::create([
                                        'tindak_lanjut_id' => $value,
                                        'dokumen_id' => $value_dokumen
                                    ]);
                                }
                            }
                            $hapus_user = 0;
                        }
                    }
                }

                //jika tidak ada user_id sesuai dengan yg login, berarti hapus user_id yg login pada tabel tindak lanjut
                if ($hapus_user) {
                    TindakLanjut::where('created_by', Auth::user()->id)->where('agenda_id', $proses->id)->delete();
                }
            //return response
            return response()->json([
                'success' => true,
                'code'    => 200,
                'message' => 'Data Berhasil Disimpan!',
                'data'    => $proses  
            ]);
        } catch (Exception $e){
            return response()->json(['msg' => $e->getMessage()]);
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
    public function edit($uuid)
    {
        $data = DB::table('agenda as a')
                    ->leftJoin('tindak_lanjut as b', 'b.agenda_id', 'a.id')
                    ->leftJoin('users as c', 'c.id', 'b.validated_by')
                    ->where('b.created_by', Auth::user()->id)
                    ->where('a.uuid', $uuid)
                    ->select('a.id', 'a.tanggal_mulai', 'a.jam_mulai', 'a.klien_id', 'a.uuid', 'b.tanggal_selesai', 'b.jam_selesai', 'a.judul_kegiatan', 'a.keterangan', 'b.lokasi', 'b.catatan', 'c.name', 'b.created_by')
                    ->first();
        $agenda_id = TindakLanjut::where('agenda_id', $data->id)->where('created_by', Auth::user()->id)->pluck('agenda_id');
        $user_id = TindakLanjut::where('agenda_id', $agenda_id[0])->pluck('created_by');
        $data->user_id = $user_id;
        
        return response()->json($data);
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
