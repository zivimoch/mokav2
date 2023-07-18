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
            $data = DB::table('dokumen as a')
                        ->select(DB::raw('a.*, z.keyword, b.id as status, d.tanggal_mulai, d.jam_mulai, c.tanggal_selesai, c.jam_selesai, f.name'))
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

    public function add(Request $request)
    {
        $template = DB::table('template as a')
                        ->select('a.*', 'b.name')
                        ->leftJoin('users as b', 'a.created_by', 'b.id')
                        ->get();
        return view('dokumen.add')->with('template', $template);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $template = DB::table('template as a')
                        ->select(DB::raw('a.*, b.name, GROUP_CONCAT(c.keyword) as keyword'))
                        ->leftJoin('users as b', 'a.created_by', 'b.id')
                        ->leftJoin('template_keyword as c', 'a.id', 'c.template_id')
                        ->where('a.uuid', $request->uuid)
                        ->groupBy('a.id')
                        ->first();

        $agenda = DB::table('agenda as a')
                        ->select(DB::raw('a.*, b.uuid as uuid_tindak_lanjut'))
                        ->leftJoin('tindak_lanjut as b', 'a.id', 'b.agenda_id')
                        ->where('b.created_by', Auth::user()->id)
                        ->orderBy('a.tanggal_mulai', 'DESC')
                        ->orderBy('a.jam_mulai', 'DESC')
                        ->get();
        return view('dokumen.create')
                        ->with('agenda', $agenda)
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

            $template = DB::table('template as a')
                            ->select(DB::raw('a.*, b.name, GROUP_CONCAT(c.keyword) as keyword'))
                            ->leftJoin('users as b', 'a.created_by', 'b.id')
                            ->leftJoin('template_keyword as c', 'a.id', 'c.template_id')
                            ->where('a.uuid', $request->uuid)
                            ->groupBy('a.id')
                            ->first();
            //Data Dokumen
            $dokumen = Dokumen::create([
                'template_id' => $template->id,
                'judul' => $request->judul,
                'konten' => json_encode($request->konten),
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
        if($request->ajax()) { //dipakai di datatable
            $data = DB::table('dokumen as a')
                        ->leftJoin('dokumen_keyword as b', 'a.id', 'b.dokumen_id')
                        ->where('a.uuid', $request->uuid)
                        ->first(['a.*', 'b.keyword']);
            return $data;
       }
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
