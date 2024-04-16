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
<<<<<<< HEAD
                        ;

            if (Auth::user()->jabatan != 'Super Admin') {
                $data = $data->where('a.pemilik', Auth::user()->jabatan);
            }
            
            return DataTables::of($data->get(['a.*', 'b.name as petugas']))->make(true);
=======
                        ->get(['a.*', 'b.name as petugas']);
            return DataTables::of($data)->make(true);
>>>>>>> a5b8b868dc63aecbff731d58b225d84c5f17745f
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
        $jabatan =  (new OpsiController)->api_jabatan();
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
                'blank_template' => $request->blank_template,
                'created_by' => Auth::user()->id
            ]);

            //simpan tindak kekerasan
            if (isset($request->keyword)) {
                $keyword = $request->keyword;
<<<<<<< HEAD
                foreach ($keyword as $item) {
                    TemplateKeyword::create(['template_id' => $template->id, 'keyword' => $item]);
=======
                foreach ($keyword as $key1 => $value) {
                    $proses['keyword'] = TemplateKeyword::create(['template_id' => $template->id, 'keyword' => $keyword[$key1]]);
>>>>>>> a5b8b868dc63aecbff731d58b225d84c5f17745f
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
<<<<<<< HEAD
    public function show(Request $request, $uuid)
    {
        if($request->ajax()) { 
            //dipakai di datatable di index
            $data = DB::table('template as a')
                        ->leftJoin('users as b', 'b.id', 'a.created_by')
                        ->select('a.*', 'b.name')
                        ->where('a.uuid', $uuid)
                        ->first();
            $keyword = TemplateKeyword::where('template_id', $data->id)->pluck('keyword');
             //return response
             return response()->json([
                'success' => true,
                'code'    => 200,
                'message' => 'Data Berhasil Ditampilkan!',
                'data'    => $data,
                'keyword' => $keyword
            ]);
       }
=======
    public function show($id)
    {
        //
>>>>>>> a5b8b868dc63aecbff731d58b225d84c5f17745f
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
<<<<<<< HEAD
    public function edit($uuid)
    {
        $data = Template::where('uuid',$uuid)->first();
        $data_keyword = TemplateKeyword::where('template_id', $data->id)->pluck('keyword');
        $keyword = TemplateKeyword::pluck('keyword');
        $jabatan =  (new OpsiController)->api_jabatan();

        return view('template.edit')
                    ->with('data', $data)
                    ->with('data_keyword', $data_keyword)
                    ->with('keyword', $keyword)
                    ->with('jabatan', $jabatan);
=======
    public function edit($id)
    {
        //
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
                'nama_template' => 'required'
                ]);

                if ($validator->fails())
                {
                    throw new Exception($validator->errors());
                }
            //Data Template
            $template = Template::where('uuid', $request->uuid)->first();
            $proses = Template::where('uuid', $request->uuid)
                ->update([
                'nama_template' => $request->nama_template,
                'pemilik' => $request->pemilik,
                'konten' => json_encode($request->konten),
                'blank_template' => $request->blank_template,
                'created_by' => Auth::user()->id
            ]);
            
            // hapus keywrod
            TemplateKeyword::where('template_id', $template->id)->delete();
            //simpan keyword
            if (isset($request->keyword)) {
                $keyword = $request->keyword;
                foreach ($keyword as $item) {
                    TemplateKeyword::create(['template_id' => $template->id, 'keyword' => $item]);
                }
            }
            
            //return response
            $response = "Berhasil mengupdate data";
            return redirect()->route('template.edit', $request->uuid)
                    ->with('success', true)
                    ->with('response', $response);

        } catch (Exception $e){
            return redirect()->route('template.edit', $request->uuid)
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
<<<<<<< HEAD
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        try {
            $proses = Template::where('uuid', $uuid)->delete();

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
=======
    public function destroy($id)
    {
        //
>>>>>>> a5b8b868dc63aecbff731d58b225d84c5f17745f
    }
}
