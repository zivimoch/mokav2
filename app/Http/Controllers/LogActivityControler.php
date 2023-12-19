<?php

namespace App\Http\Controllers;

use App\Models\Klien;
use App\Models\LogActivity;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LogActivityControler extends Controller
{/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $klien = Klien::where('uuid', $request->uuid)->first();
        $data = LogActivity::where('klien_id', $klien->id)->orderBy('id')->get();
        foreach ($data as $datas) {
            $datas->tanggal_formatted = date('d M Y', strtotime($datas->created_at));
            $datas->jam_formatted = date('h:i:s', strtotime($datas->created_at));
        }
        return DataTables::of($data)->make(true);
    }
}
