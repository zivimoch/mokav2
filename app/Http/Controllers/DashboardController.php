<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('dashboard');
    }

    public function blankpage()
    {
     // Load index view
     return view('blankpage');
    }

    public function userdatatable()
    {
        return view('userdatatable');
    }

    public function datatable()
    {
        $user = User::get(['id', 'name', 'email']);
        return DataTables::of($user)->make(true);
    }
}
