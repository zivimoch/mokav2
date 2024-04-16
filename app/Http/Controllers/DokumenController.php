<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Dokumen;
use App\Models\DokumenKeyword;
use App\Models\DokumenTl;
use App\Models\Template;
use App\Models\TindakLanjut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Exception;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class DokumenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        if($request->ajax()) {
            // ditampilkan di index dokumen
            $data = DB::table('dokumen as a')
<<<<<<< HEAD
                        ->select(DB::raw('a.id, a.uuid, a.template_id, a.judul, a.konten, a.created_at, z.keyword, group_concat(b.id) as status, group_concat(d.tanggal_mulai) as tanggal_mulai, group_concat(d.jam_mulai) as jam_mulai, group_concat(c.tanggal_selesai) as tanggal_selesai, group_concat(c.jam_selesai) as jam_selesai, group_concat(f.name) as name, group_concat(e.nama) as nama_klien'))
=======
                        ->select(DB::raw('a.*, z.keyword, group_concat(b.id) as status, group_concat(d.tanggal_mulai) as tanggal_mulai, group_concat(d.jam_mulai) as jam_mulai, group_concat(c.tanggal_selesai) as tanggal_selesai, group_concat(c.jam_selesai) as jam_selesai, group_concat(f.name) as name, group_concat(e.nama) as nama_klien'))
>>>>>>> a5b8b868dc63aecbff731d58b225d84c5f17745f
                        ->leftJoin('dokumen_tl as b', 'a.id', 'b.dokumen_id')
                        ->leftJoin(DB::raw('(
                            SELECT dokumen_id, GROUP_CONCAT(CONCAT(" "), keyword) AS keyword FROM dokumen_keyword GROUP BY dokumen_id) z'), 
                        function($join)
                        {
                        $join->on('z.dokumen_id', '=', 'a.id');
                        })
                        ->leftJoin('tindak_lanjut as c', 'c.id', 'b.tindak_lanjut_id')
                        ->leftJoin('agenda as d', 'd.id', 'c.agenda_id')
                        ->leftJoin('klien as e', 'e.id', 'd.klien_id')
                        ->leftJoin('users as f', 'f.id', 'c.created_by')
                        ->whereNull('a.deleted_at')
<<<<<<< HEAD
                        ->groupBy('a.id', 'a.uuid', 'a.template_id', 'a.judul', 'a.konten', 'z.keyword', 'a.created_at')
=======
                        ->groupBy('a.id')
>>>>>>> a5b8b868dc63aecbff731d58b225d84c5f17745f
                        ->orderBy('a.created_at', 'DESC');

            if ($request->uuid) { //jika data ini untuk di halaman map klien digital
                $data->where('e.uuid', $request->uuid);
            } else { //ini untuk di halaman dokumen index
                $data->where('a.created_by', Auth::user()->id);
            }
            
            return DataTables::of($data->get())->make(true);
       }

       return view('dokumen.index');
    }

    //untuk select2 list dokumen, dia methodnya POST
    public function get_dokumen(Request $request)
    {
        $search = $request->search;
        if($search == ''){
            $data = Dokumen::where('created_by', Auth::user()->id)
                            ->whereNull('deleted_at')
                            ->orderBy('updated_at')
                            ->select('id','judul')
                            ->limit(10)->get();
        }else{
            $data = Dokumen::where('created_by', Auth::user()->id)
                        ->whereNull('deleted_at')
                        ->orderBy('updated_at')
                        ->where('judul', 'like', '%' .$search . '%')
                        ->select('id','judul')
                        ->limit(10)->get();
        }
  
        $response = array();
        foreach($data as $value){
            $response[] = array(
                 "id"=>$value->id,
                 "text"=>$value->judul
            );
         }
        return response()->json($response); 
    }

    public function add(Request $request)
    {
        $template = DB::table('template as a')
                        ->select('a.*', 'b.name')
                        ->leftJoin('users as b', 'a.created_by', 'b.id')
<<<<<<< HEAD
                        ->whereNull('a.deleted_at')
                        ;

        if (Auth::user()->jabatan != 'Super Admin') {
            $template = $template->where('a.pemilik', Auth::user()->jabatan);
        }

        return view('dokumen.add')->with('template', $template->get());
=======
                        ->get();
        return view('dokumen.add')->with('template', $template);
>>>>>>> a5b8b868dc63aecbff731d58b225d84c5f17745f
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $template = DB::table('template as a')
<<<<<<< HEAD
                        ->select(DB::raw('a.id, a.uuid, a.nama_template, a.pemilik, a.konten, a.blank_template, a.created_at, a.updated_at, a.created_at, b.name, GROUP_CONCAT(c.keyword) as keyword'))
                        ->leftJoin('users as b', 'a.created_by', 'b.id')
                        ->leftJoin('template_keyword as c', 'a.id', 'c.template_id')
                        ->where('a.uuid', $request->uuid)
                        ->groupBy('a.id', 'a.uuid', 'a.nama_template', 'a.pemilik', 'a.konten', 'a.blank_template', 'a.created_at', 'a.updated_at', 'b.name')
=======
                        ->select(DB::raw('a.*, b.name, GROUP_CONCAT(c.keyword) as keyword'))
                        ->leftJoin('users as b', 'a.created_by', 'b.id')
                        ->leftJoin('template_keyword as c', 'a.id', 'c.template_id')
                        ->where('a.uuid', $request->uuid)
                        ->groupBy('a.id')
>>>>>>> a5b8b868dc63aecbff731d58b225d84c5f17745f
                        ->first();
        if ($template->blank_template == 1) {
            $view = 'dokumen.create_blank';
        } else {
            $view = 'dokumen.create';
        }
        
        return view($view)
                    ->with('template', $template);
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
                'judul' => 'required'
                ]);

                if ($validator->fails())
                {
                    throw new Exception($validator->errors());
                }

<<<<<<< HEAD
                $template = DB::table('template as a')
=======
            $template = DB::table('template as a')
>>>>>>> a5b8b868dc63aecbff731d58b225d84c5f17745f
                            ->select(DB::raw('a.*, b.name, GROUP_CONCAT(c.keyword) as keyword'))
                            ->leftJoin('users as b', 'a.created_by', 'b.id')
                            ->leftJoin('template_keyword as c', 'a.id', 'c.template_id')
                            ->where('a.uuid', $request->uuid)
<<<<<<< HEAD
                            ->groupBy('a.id', 'a.uuid', 'a.nama_template', 'a.pemilik', 'a.konten', 'a.blank_template', 'a.created_by', 'a.created_at', 'a.updated_at', 'a.deleted_at', 'b.name')
=======
                            ->groupBy('a.id')
>>>>>>> a5b8b868dc63aecbff731d58b225d84c5f17745f
                            ->first();
            //Data Dokumen
            $dokumen = Dokumen::create([
                'template_id' => $template->id,
                'judul' => $request->judul,
                'konten' => json_encode($request->konten),
<<<<<<< HEAD
                'blank_template' => $template->blank_template,
=======
>>>>>>> a5b8b868dc63aecbff731d58b225d84c5f17745f
                'nama_template' => $template->nama_template,
                'pemilik_template' => $template->pemilik,
                'created_by_template' => $template->name,
                'created_at_template' => $template->created_at,
                'updated_at_template' => $template->updated_at,
                'created_by' => Auth::user()->id
            ]);
            //simpan keyword dokumen
            if (isset($template->keyword)) {
                $dokumen_keyword = explode(',', $template->keyword);
                for ($i=0; $i < count($dokumen_keyword); $i++) { 
                    $proses['keyword'] = DokumenKeyword::create(['dokumen_id' => $dokumen->id, 'keyword' => $dokumen_keyword[$i]]);
                }
            }

            //tautkan dengan agenda terkait jika ada
            if ($request->uuid_tindak_lanjut != '') {
                //update tindak lanjut
                TindakLanjut::where('uuid', $request->uuid_tindak_lanjut)
                            ->update([
                                'lokasi' => $request->lokasi,
                                'jam_selesai' => $request->jam_selesai,
                                'catatan' => $request->catatan
                            ]);
                //tambah tautan tindak lanjut dan dokumen
                $tindak_lanjut = TindakLanjut::where('uuid', $request->uuid_tindak_lanjut)->first();
                DokumenTl::create([
                    'tindak_lanjut_id' => $tindak_lanjut->id,
                    'dokumen_id' => $dokumen->id
                ]);
            }
            
            //return response
            $response = "Berhasil menginputkan data";
            return redirect()->route('dokumen.create', ['uuid' => $request->uuid])
                    ->with('success', true)
                    ->with('response', $response);

        } catch (Exception $e){
            return redirect()->route('dokumen.create', ['uuid' => $request->uuid])
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
    public function show(Request $request, $uuid)
    {
        if($request->ajax()) { 
            //dipakai di datatable di index & di agenda (kinerja & detail kasus)
            $data = DB::table('dokumen as a')
                        ->leftJoin('dokumen_keyword as b', 'a.id', 'b.dokumen_id')
                        ->where('a.uuid', $request->uuid)
                        ->first(['a.*', 'b.keyword']);
<<<<<<< HEAD
            $dokumen_tl = DB::table('dokumen_tl as a')
                        ->select(DB::raw('c.judul_kegiatan, c.tanggal_mulai, c.jam_mulai'))
                        ->leftJoin('tindak_lanjut as b', 'a.tindak_lanjut_id', 'b.id')
                        ->leftJoin('agenda as c', 'b.agenda_id', 'c.id')
                        ->where('a.dokumen_id', $data->id)
                        ->whereNull('b.deleted_at')
                        ->whereNull('c.deleted_at')
                        ->get();
             //return response
             return response()->json([
                'success' => true,
                'code'    => 200,
                'message' => 'Data Berhasil Ditampilkan!',
                'data'    => $data,
                'dokumen_tl' => $dokumen_tl  
            ]);
=======
            return $data;
>>>>>>> a5b8b868dc63aecbff731d58b225d84c5f17745f
       }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        $data = Dokumen::where('uuid',$uuid)->first();
        $template = DB::table('template as a')
                        ->select(DB::raw('a.*, b.name, GROUP_CONCAT(c.keyword) as keyword'))
                        ->leftJoin('users as b', 'a.created_by', 'b.id')
                        ->leftJoin('template_keyword as c', 'a.id', 'c.template_id')
                        ->where('a.id', $data->template_id)
<<<<<<< HEAD
                        ->groupBy('a.id', 'a.uuid', 'a.nama_template', 'a.pemilik', 'a.konten', 'a.blank_template', 'a.created_by', 'a.created_at', 'a.updated_at', 'a.deleted_at', 'b.name')
                        ->first();
        $dokumen_tl = DB::table('dokumen_tl as a')
                        ->select(DB::raw('c.judul_kegiatan, c.tanggal_mulai, c.jam_mulai'))
                        ->leftJoin('tindak_lanjut as b', 'a.tindak_lanjut_id', 'b.id')
                        ->leftJoin('agenda as c', 'b.agenda_id', 'c.id')
                        ->where('a.dokumen_id', $data->id)
                        ->where('b.created_by', Auth::user()->id)
                        ->whereNull('b.deleted_at')
                        ->whereNull('c.deleted_at')
                        ->get();
        
        if ($data->blank_template) {
            $view = 'dokumen.edit_blank';
        } else {
            $view = 'dokumen.edit';
        }

        return view($view)
                    ->with('data', $data)
                    ->with('template', $template)
                    ->with('dokumen_tl', $dokumen_tl);
=======
                        ->groupBy('a.id')
                        ->first();

        return view('dokumen.edit')
                    ->with('data', $data)
                    ->with('template', $template);
>>>>>>> a5b8b868dc63aecbff731d58b225d84c5f17745f
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
<<<<<<< HEAD
        try {
            $validator = Validator::make($request->all(), [
                'judul' => 'required'
                ]);

                if ($validator->fails())
                {
                    throw new Exception($validator->errors());
                }

            $template = DB::table('template as a')
                            ->select(DB::raw('a.*, b.name, GROUP_CONCAT(c.keyword) as keyword'))
                            ->leftJoin('users as b', 'a.created_by', 'b.id')
                            ->leftJoin('template_keyword as c', 'a.id', 'c.template_id')
                            ->where('a.uuid', $request->uuid)
                            ->groupBy('a.id', 'a.uuid', 'a.nama_template', 'a.pemilik', 'a.konten', 'a.blank_template', 'a.created_by', 'a.created_at', 'a.updated_at', 'a.deleted_at', 'b.name')
                            ->first();
            //Data Dokumen
            $dokumen = Dokumen::where('id', $id)->update([
                'template_id' => $template->id,
                'judul' => $request->judul,
                'konten' => json_encode($request->konten),
                'blank_template' => $template->blank_template,
                'nama_template' => $template->nama_template,
                'pemilik_template' => $template->pemilik,
                'created_by_template' => $template->name,
                'created_at_template' => $template->created_at,
                'updated_at_template' => $template->updated_at,
                'created_by' => Auth::user()->id
            ]);
            // definisikan ulang $dokumen untuk redirect
            $dokumen = Dokumen::find($id);

            //keyword dokumen tidak dapat dirubah karna dianggap menggunakan template lama

            //tautkan dengan agenda terkait jika ada
            if ($request->uuid_tindak_lanjut != '') {
                //update tindak lanjut
                TindakLanjut::where('uuid', $request->uuid_tindak_lanjut)
                            ->update([
                                'lokasi' => $request->lokasi,
                                'jam_selesai' => $request->jam_selesai,
                                'catatan' => $request->catatan
                            ]);
                // hapus DijynebTL untuk tindak_lanjut ini kemudain bikin baru, guananya untuk nanti ketika looping 1 dokumen lebih dari 1 agenda
                $tindak_lanjut = TindakLanjut::where('uuid', $request->uuid_tindak_lanjut)->first();
                DokumenTl::where('tindak_lanjut_id', $tindak_lanjut->id)
                        ->where('dokumen_id', $dokumen->id)
                        ->delete();
                DokumenTl::create([
                    'tindak_lanjut_id' => $tindak_lanjut->id,
                    'dokumen_id' => $dokumen->id
                ]);
            }
            
            //return response
            $response = "Berhasil menginputkan data";
            return redirect()->route('dokumen.edit', $dokumen->uuid)
                    ->with('success', true)
                    ->with('response', $response);

        } catch (Exception $e){
            dd($e);
            return redirect()->route('dokumen.edit', $dokumen->uuid)
                    ->with('error', true)
                    ->with('response', $e->getMessage());
            die();
        }
=======
        //
>>>>>>> a5b8b868dc63aecbff731d58b225d84c5f17745f
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        try {
            $proses = Dokumen::where('uuid', $uuid)->delete();

            if (!$proses) {
                throw new Exception($proses);
            }
            
            //return response
            return response()->json([
                'success' => true,
                'code'    => 200,
                'message' => 'Data Berhasil Dihapus!',
                'data'    => $proses  
            ]);

        } catch (Exception $e){
            return response()->json(['message' => $e->getMessage()]);
            die();
        }
    }
}
