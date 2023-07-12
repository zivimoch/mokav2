<?php

namespace App\Http\Controllers;

use App\Models\Template;
use App\Models\TemplateKeyword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Validator;
use Exception;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            $data = DB::table('template as a')
                        ->leftJoin('users as b', 'b.id', 'a.created_by')
                        ->whereNotNULL('a.konten')
                        ->whereNULL('a.deleted_at')
                        ->get(['a.*', 'b.name as petugas']);
            return DataTables::of($data)->make(true);
       }

       return view('template.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jabatan =  app('App\Http\Controllers\OpsiController')->api_jabatan();
        $keyword = TemplateKeyword::select('keyword')->groupBy('keyword')->get();

        return view('template.create')
                ->with('jabatan', $jabatan)
                ->with('keyword', $keyword);
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
                'nama_template' => 'required'
                ]);

                if ($validator->fails())
                {
                    throw new Exception($validator->errors());
                }
            
            //Data Template
            $template = Template::create([
                'nama_template' => $request->nama_template,
                'pemilik' => $request->pemilik,
                'konten' => json_encode($request->konten),
                'created_by' => Auth::user()->id
            ]);

            //simpan tindak kekerasan
            if (isset($request->keyword)) {
                $keyword = $request->keyword;
                foreach ($keyword as $key1 => $value) {
                    $proses['keyword'] = TemplateKeyword::create(['template_id' => $template->id, 'keyword' => $keyword[$key1]]);
                }
            }
            
            //return response
            $response = "Berhasil menginputkan data";
            return redirect()->route('template.create')
                    ->with('success', true)
                    ->with('response', $response);

        } catch (Exception $e){
            return redirect()->route('template.create')
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
