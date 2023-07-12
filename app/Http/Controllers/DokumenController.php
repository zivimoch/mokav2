<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\DokumenKeyword;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Exception;
use Illuminate\Support\Facades\Auth;

class DokumenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        return view('dokumen.create')->with('template', $template);
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
