<?php

namespace App\Http\Controllers;

use App\Models\MJenisKekerasan;
use App\Models\MKategoriKasus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravolt\Indonesia\Models\City;

class WebSettingsController extends Controller
{

    public function index()
    {
        if (Auth::user()->jabatan != 'Super Admin') {
            return abort(404);
        }

        return view('websettings.index')
                    ->with('header', ['icon'=>'fas fa-cogs', 'title' => 'General Settings'])
                    ;
    }

    // index manage kategori kasus
    public function kategori_kasus()
    {
        if (!in_array(Auth::user()->jabatan, ['Super Admin','Tenaga Ahli'])) {
            return abort(404);
        }

        $jenis_kekerasan = MJenisKekerasan::get();
        $hubungan_dengan_terlapor =  (new OpsiController)->api_hubungan_dengan_terlapor();
        $kategori_lokasi =  (new OpsiController)->api_kategori_lokasi();
        return view('websettings.kategorikasus')
                    ->with('header', ['icon'=>'fas fa-list-ol', 'title' => 'Kategori Kasus'])
                    ->with('opsi_jenis_kekerasan', $jenis_kekerasan)
                    ->with('hubungan_dengan_terlapor', $hubungan_dengan_terlapor)
                    ->with('kategori_lokasi', $kategori_lokasi)
                    ;
    }

    // index manage users
    public function users()
    {
        if (Auth::user()->jabatan != 'Super Admin') {
            return abort(404);
        }

        $jabatan =  (new OpsiController)->api_jabatan();
        $petugas =  (new OpsiController)->api_petugas();
        $kotkab = City::get();
        return view('websettings.users')
                    ->with('header', ['icon'=>'fas fa-users-cog', 'title' => 'Users'])
                    ->with('jabatan', $jabatan)
                    ->with('petugas', $petugas)
                    ->with('kotkab', $kotkab)
                    ;
    }
}
