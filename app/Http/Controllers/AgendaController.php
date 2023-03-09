<?php

namespace App\Http\Controllers;

use Exception;
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
            throw new Exception("");
        } catch (Exception $e){
            return $e->getMessage();
            die();
        }

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

        dd($data->get());

        return view('agenda.kinerja_detail');
    }

    public function kinerja_detail(Request $request)
    {
        if ($request->get('bulan') == null) {
            return redirect('kinerja');
        }

        return view('agenda.kinerja_detail');
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
        //
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
