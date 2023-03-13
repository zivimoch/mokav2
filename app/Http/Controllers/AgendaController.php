<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Exception;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\New_;

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

    public function kinerja(Request $request)
    {
        try {
            if ($request->get('bulan')) {
                $bulan = $request->get('bulan');
            }else{
                $bulan = date(('m'));
            }
            
            $data = DB::table('agenda as a')
                        ->select('c.name')
                        ->leftJoin('tindak_lanjut as b', 'a.id', 'b.agenda_id')
                        ->leftJoin('users as c', 'c.id', 'b.created_by')
                        ->whereMonth('a.tanggal_mulai', '=' , $bulan);
    
            if (Auth::user()->jabatan != 'Sekretariat') {
                $data->where('b.created_by', Auth::user()->id);
            }else{
                $data->groupBy('c.id');
            }

            if (empty($data->get())) {
                throw new Exception("Data not found");
            }
    
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
                'jam_kegiatan' => 'required',
                'judul_kegiatan' => 'required'
                ]);
                if ($validator->fails())
                {
                    return response()->json($validator->errors(), 422);
                }

                //create post
                $proses = Agenda::create([
                    'title'     => $request->title, 
                    'content'   => $request->content
                ]);
                //return response
                return response()->json([
                    'success' => true,
                    'message' => 'Data Berhasil Disimpan!',
                    'data'    => $proses  
                ]);
        } catch (Exception $e){
            return response()->json(['msg' => $e->getMessage()], 500);
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
