@extends('layouts.template')

@section('content')
<style>
    .hightlighting {
    background-color: none !important; 
    -webkit-animation-name: animate1; /* Chrome, Safari, Opera */
    -webkit-animation-duration: 7s; /* Chrome, Safari, Opera */
    animation-name: animate1;
    animation-duration: 7s;
    }

    /* Chrome, Safari, Opera */
    @-webkit-keyframes animate1 {
    0%   { background-color: #ffff00; }
    50%  { background-color: #ffffd1; }
    100%  { background-color: #FFFFFF; }
    }

    /* Standard syntax */
    @keyframes animate1 {
    0%   { background-color: #ffff00; }
    50%  { background-color: #ffffd1; }
    100%  { background-color: #FFFFFF; }
    }

    .input_pelapor, #tombol_save_pelapor, .input_klien, #tombol_save_klien, .input_kasus, #tombol_save_kasus, .input_terlapor, #tombol_save_terlapor {
        display: none;
    }

    .select2-selection__rendered {
        line-height: 25px !important;
        margin-top:-6px !important;   
    }
    .select2-container .select2-selection--single {
        height: 30px !important;
        border-color: black;
    }
    .select2-selection__arrow {
        height: 30px !important;
    }
</style>

<section class="content-header">
<div class="container-fluid">
<div class="row mb-2">
<div class="col-sm-6">
<h1>Detail Kasus</h1>
</div>
<div class="col-sm-6">
<ol class="breadcrumb float-sm-right">
<li class="breadcrumb-item"><a href="#">Home</a></li>
<li class="breadcrumb-item active">Detail Kasus</li>
</ol>
</div>
</div>
</div>
</section>

<section class="content">
@if (Session::has('data'))
    <input type="hidden" id="perubahan" value="{{ Session::get('data')  }}">
@endif
<div class="container-fluid">
<div class="row">
<div class="col-md-3">

<div class="card card-primary card-outline">

    <div class="ribbon-wrapper ribbon-xl">
        <div class="ribbon bg-danger text-xl">
        CLOSED
        </div>
    </div>
<div class="card-body box-profile">
<div class="text-center">
<img class="profile-user-img img-fluid img-circle" src="{{ asset('adminlte') }}/dist/img/user4-128x128.jpg" alt="User profile picture">
</div>
<h3 class="profile-username text-center">{{ $klien->nama }}</h3>
<p class="text-muted text-center">({{ $klien->tanggal_lahir ? Carbon\Carbon::parse($klien->tanggal_lahir)->age : '' }}) {{ ucfirst($klien->jenis_kelamin) }}</p>
<p class="text-center">{{ $klien->no_klien }}</p>
<ul class="list-group list-group-unbordered mb-3">
<h5><span class="float-right badge bg-danger btn-block">Pelengkapan Data</span></h5>
<li class="list-group-item">
<b>Layanan</b> <a class="float-right">5</a>
</li>
<li class="list-group-item">
<b>Intervensi</b> <a class="float-right">10</a>
</li>
<li class="list-group-item">
<b>Petugas</b> <a class="float-right">6</a>
</li>
</ul>
</div>
</div>

<div class="card card-warning">
    <div class="card-header">
    <h3 class="card-title">Catatan Kasus</h3>
    <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="nav-icon fas fa-edit"></i>
        </button>
        <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
        </button>
    </div>
    </div>
    
    <div class="card-body" style="height: 350px; overflow-y:scroll;">
    <a href="#">
        <strong>Rudi Hartanto (Advokat)</strong>
        <p class="text-muted">
            Lorem ipsum, dolor sit amet rupti unde labore error? Ad, dolore inventore. Blanditiis incidunt...
        </p>
    </a>
    <hr>
    <a href="#">
        <strong>Adam Levine (Penerima Pengaduan)</strong>
        <p class="text-muted">
            Lorem ipsum, dolor sit amet rupti unde labore error? Ad, dolore inventore. Blanditiis incidunt...
        </p>
    </a>
    <hr>
    <a href="#">
        <strong>Berliana Dewi (Psikolog)</strong>
        <p class="text-muted">
            Lorem ipsum, dolor sit amet rupti unde labore error? Ad, dolore inventore. Blanditiis incidunt...
        </p>
    </a>
    </div>
</div>

<div class="card card-primary">
    <div class="card-header">
    <h3 class="card-title">Kasus Terkait</h3>
    </div>
    
    <div class="card-body">
        <h5 class="text-muted">Detail Kasus</h5>
        <ul class="list-unstyled">
        <li>
        <a href="" class="btn-link text-secondary"><i class="far fa-fw fa-file"></i>No Kasus : K0001/01/2023</a>
        </li>
        <li>
        <a href="" class="btn-link text-secondary"><i class="fa fa-user-secret"></i> Terlapor : Jhon F Kennedy, Frredy Mercury, Thompson n Tomphoson</a>
        </li>
        </ul>
    <hr>
    <a href="#">
        <strong>0001/01/2023</strong>
        <p class="text-muted">
            Alexander Grahambel (15)
            <br>
            (anak laki-laki)
        </p>
    </a>
    <hr>
    <a href="#">
        <strong>0002/01/2023</strong>
        <p class="text-muted">
            Thomas Alfa Edison (13)
            <br>
            (anak laki-laki)
        </p>
    </a>
    <hr>
    <a href="#">
        <strong>0003/01/2023</strong>
        <p class="text-muted">
            Christoper Colombus (11)
            <br>
            (anak laki-laki)
        </p>
    </a>
    </div>
</div>

</div>    

<div class="col-md-9">
    <div class="card card-primary card-tabs">
        <div class="card-header p-0 pt-1">
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                </button>
            </div>
        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
        <li class="nav-item">
        <a class="nav-link {{ Request::get('tab') == 'kasus' || Request::get('tab') == '' ? 'active' : '' }}" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Kasus</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::get('tab') == 'kasus-Asesmen' ? 'active' : '' }}" id="kasus-Asesmen-tab" data-toggle="pill" href="#kasus-Asesmen" role="tab" aria-controls="kasus-Asesmen" aria-selected="false">Asesmen</a>
        </li>
        <li class="nav-item">
        <a class="nav-link {{ Request::get('tab') == 'kasus-layanan' ? 'active' : '' }}" id="kasus-layanan-tab" data-toggle="pill" href="#kasus-layanan" role="tab" aria-controls="kasus-layanan" aria-selected="false">SPP & Layanan</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false">Log Activity</a>
        </li>
        <li class="nav-item">
        <a class="nav-link {{ Request::get('tab') == 'kasus-petugas' ? 'active' : '' }}" id="kasus-petugas-tab" data-toggle="pill" href="#kasus-petugas" role="tab" aria-controls="kasus-petugas" aria-selected="false">Petugas</a>
        </li>
        <li class="nav-item">
        <a class="nav-link {{ Request::get('tab') == 'settings' ? 'active' : '' }}" id="kasus-settings-tab" data-toggle="pill" href="#kasus-settings" role="tab" aria-controls="kasus-settings" aria-selected="false">Settings</a>
        </li>
        </ul>
        </div>
        <div class="card-body">
        <div class="tab-content" id="custom-tabs-one-tabContent">
        <div class="tab-pane fade show {{ Request::get('tab') == 'kasus' || Request::get('tab') == ''  ? 'active' : '' }}  {{ Request::get('hightlight') == 'formulir' ? 'hightlighting' : '' }}" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
        <div class="post">
            <div class="card card-danger" style="transition: all 0.15s ease 0s; height: inherit; width: inherit;">
                <div class="card-header">
                <h3 class="card-title">Kasus Terminasi</h3>
                <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                </button>
                </div>
                </div>
                <div class="card-body">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Pariatur maxime est asperiores aut perferendis officia consectetur in illo explicabo possimus. Veniam omnis id optio velit explicabo sapiente quaerat repellat officiis?
                Dicta facere ducimus eligendi, dolore consequatur exercitationem dolorum eum evus, cupiditate, natus molestias ratione et vel iure sequi modi maxime architecto fugit aliquid! Fugiat?
                </div>
            </div>
        </div>
            
            
        <div class="post clearfix" style="color:black">
            {{-- @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {!! Session::get('response') !!}
                </div>
            @endif --}}

            <b id="anchor_pelaporan">A. IDENTITAS PELAPOR</b>{{ isset($data) ? $data : '' }}
            <form action="{{ route('formpenerimapengaduan.update', 'uuid') }}" method="POST">
                @csrf
                @method('put')
                <input type="hidden" name="uuid" value="{{ $pelapor->uuid }}">
                <input type="hidden" name="data_update" value="pelapor">
                <span style="float:right">
                    <a class="btn btn-xs bg-gradient-warning" id="tombol_edit_pelapor" onclick="editdata('pelapor')">
                    <i class="fas fa-edit"></i> Edit
                    </a>
                    <button type="submit" class="btn btn-xs bg-gradient-success" id="tombol_save_pelapor">
                    <i class="fas fa-check"></i> Save
                    </button>
                </span>
                <table class="table table-bottom table-sm">
                    <tr id="nama_pelapor">
                        <td style="width: 200px">Nama</td>
                        <td>:</td>
                        <td><span class="data_pelapor">{{ $pelapor->nama }}</span> <input type="text" name="nama" value="{{ $pelapor->nama }}" class="input_pelapor"></td>
                    </tr>
                    <tr id="tanggal_lahir_pelapor">
                        <td style="width: 200px">Tempat/Tgl Lahir</td>
                        <td>:</td>
                        <td>
                            <span class="data_pelapor" id="tempat_lahir_pelapor">{{ $pelapor->tempat_lahir }}</span> 
                            <input type="text" name="tempat_lahir" value="{{ $pelapor->tempat_lahir }}" class="input_pelapor">, 
                            <span class="data_pelapor">
                                {{ $pelapor->tanggal_lahir ? date('d M Y', strtotime($pelapor->tanggal_lahir)) : '' }} ({{ $pelapor->tanggal_lahir ? Carbon\Carbon::parse($pelapor->tanggal_lahir)->age.' tahun' : ' '}})
                            </span> 
                            <input type="date" name="tanggal_lahir" value="{{ $pelapor->tanggal_lahir }}" class="input_pelapor">
                        </td>
                    </tr>
                    <tr id="alamat_pelapor">
                        <td style="width: 200px">Alamat</td>
                        <td>:</td>
                        <td><span class="data_pelapor">{{ $pelapor->alamat }}</span> 
                            <input type="text" name="alamat" value="{{ $pelapor->alamat }}" class="input_pelapor">, 
                            <b>Provinsi</b> <span class="data_pelapor">{{ $pelapor->provinsi }}</span> 
                            <select name="provinsi_id" class="input_pelapor select2bs4" id="provinsi_id_pelapor" onchange="getkotkab('pelapor')">
                                @foreach ($provinsi as $item)
                                    <option value="{{ $item->code }}" {{ $item->code == $pelapor->provinsi_id ? 'selected' : '' }}>{{ $item->name }}</option>
                                @endforeach
                            </select>,
                            <b>Kota</b> <span class="data_pelapor">{{ $pelapor->kota }}</span> 
                            <select name="kotkab_id" class="input_pelapor select2bs4" id="kota_id_pelapor" onchange="getkecamatan('pelapor')" style="width:100%">
                            </select>, 
                            <b>Kecamatan</b> <span class="data_pelapor">{{ $pelapor->kecamatan }}</span> 
                            <select name="kecamatan_id" class="input_pelapor select2bs4" id="kecamatan_id_pelapor" style="width:100%">
                                <option value="" selected></option>
                            </select>,
                            <b>Kelurahan</b> <span class="data_pelapor">{{ $pelapor->kelurahan }}</span> 
                            <input type="text" name="kelurahan" value="{{ $pelapor->kelurahan }}" class="input_pelapor"> 
                        </td>
                    </tr>
                    <tr id="no_telp_pelapor">
                        <td style="width: 200px">No Telp</td>
                        <td>:</td>
                        <td>
                            <span class="data_pelapor">{{ $pelapor->no_telp }}</span> 
                            <input type="text" name="no_telp" value="{{ $pelapor->no_telp }}" class="input_pelapor">
                        </td>
                    </tr>
                    <tr id="hubungan_pelapor_pelapor">
                        <td style="width: 200px">Hubungan dengan klien</td>
                        <td>:</td>
                        <td>
                            <span class="data_pelapor">{{ $pelapor->hubungan_pelapor }}</span> 
                            <select name="hubungan_pelapor" class="input_pelapor select2bs4" style="width: 100%;">
                                @foreach ($hubungan_dengan_terlapor as $item)
                                    <option value="{{ $item }}" {{ $item == $pelapor->hubungan_pelapor ? 'selected' : '' }}>{{ $item }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <div class="post clearfix" style="color:black">
            <b>B. IDENTITAS KLIEN</b>
            <span style="float:right">
                <a class="btn btn-xs bg-gradient-warning" id="tombol_edit_klien" onclick="editdata('klien')">
                <i class="fas fa-edit"></i> Edit
                </a>
                <button type="submit" class="btn btn-xs bg-gradient-success" id="tombol_save_klien">
                <i class="fas fa-check"></i> Save
                </button>
            </span>
            <table class="table table-bottom table-sm">
                <tr id="nama_klien">
                    <td style="width: 200px">Nama</td>
                    <td>:</td>
                    <td><span class="data_klien">{{ $klien->nama }}</span> <input type="text" name="nama" value="{{ $klien->nama }}" class="input_klien"></td>
                </tr>
                <tr id="tanggal_lahir_klien">
                    <td style="width: 200px">Tempat/Tgl Lahir</td>
                    <td>:</td>
                    <td>
                        <span class="data_klien" id="tempat_lahir_klien">{{ $klien->tempat_lahir }}</span> 
                        <input type="text" name="tempat_lahir" value="{{ $klien->tempat_lahir }}" class="input_klien">, 
                        <span class="data_klien">
                            {{ $klien->tanggal_lahir ? date('d M Y', strtotime($klien->tanggal_lahir)) : '' }} ({{ $klien->tanggal_lahir ? Carbon\Carbon::parse($klien->tanggal_lahir)->age.' tahun' : ' '}})
                        </span> 
                        <input type="date" name="tanggal_lahir" value="{{ $klien->tanggal_lahir }}" class="input_klien">
                    </td>
                </tr>
                <tr id="alamat_klien">
                    <td style="width: 200px">Alamat</td>
                    <td>:</td>
                    <td><span class="data_klien">{{ $pelapor->alamat }}</span> 
                        <input type="text" name="alamat" value="{{ $pelapor->alamat }}" class="input_klien">, 
                        <b>Provinsi</b> <span class="data_klien">{{ $pelapor->provinsi }}</span> 
                        <select name="provinsi_id" class="input_klien select2bs4" id="provinsi_id_klien" onchange="getkotkab('klien')">
                            @foreach ($provinsi as $item)
                                <option value="{{ $item->code }}" {{ $item->code == $klien->provinsi_id ? 'selected' : '' }}>{{ $item->name }}</option>
                            @endforeach
                        </select>,
                        <b>Kota</b> <span class="data_klien">{{ $klien->kota }}</span> 
                        <select name="kotkab_id" class="input_klien select2bs4" id="kota_id_klien" onchange="getkecamatan('klien')" style="width:100%">
                        </select>, 
                        <b>Kecamatan</b> <span class="data_klien">{{ $klien->kecamatan }}</span> 
                        <select name="kecamatan_id" class="input_klien select2bs4" id="kecamatan_id_klien" style="width:100%">
                            <option value="" selected></option>
                        </select>,
                        <b>Kelurahan</b> <span class="data_klien">{{ $klien->kelurahan }}</span> 
                        <input type="text" name="kelurahan" value="{{ $klien->kelurahan }}" class="input_klien"> 
                    </td>
                </tr>
                <tr id="pendidikan_klien">
                    <td style="width: 200px">Pendidikan</td>
                    <td>:</td>
                    <td>
                        <span class="data_klien">{{ $klien->pendidikan }}</span> <input type="text" name="pendidikan" value="{{ $klien->pendidikan }}" class="input_klien">
                        (<span class="data_klien">{{ $klien->status_pendidikan }}</span> <input type="text" name="status_pendidikan" value="{{ $klien->status_pendidikan }}" class="input_klien">)
                    </td>
                </tr>
                <tr>
                    <td style="width: 200px">Nama Ibu</td>
                    <td>:</td>
                    <td>Siswati Karnasuryatna Gumelar</td>
                </tr>
                <tr id="nama_klien">
                    <td style="width: 200px">Nama Ibu</td>
                    <td>:</td>
                    <td><span class="data_klien">{{ $klien->nama }}</span> <input type="text" name="nama" value="{{ $klien->nama }}" class="input_klien"></td>
                </tr>
                <tr>
                    <td style="width: 200px">TTL Ibu</td>
                    <td>:</td>
                    <td>Bandung, 20 Februari 1980 (42 Tahun)</td>
                </tr>
                <tr>
                    <td style="width: 200px">Nama Ayah</td>
                    <td>:</td>
                    <td>Agun Gumelar</td>
                </tr>
                <tr>
                    <td style="width: 200px">TTL Ibu</td>
                    <td>:</td>
                    <td>Subang, 20 Februari 1980 (42 Tahun)</td>
                </tr>
                <tr>
                    <td style="width: 200px">Agama / Suku</td>
                    <td>:</td>
                    <td>Islam / Sunda</td>
                </tr>
                <tr>
                    <td style="width: 200px">Anak Ke</td>
                    <td>:</td>
                    <td>2 <b>dari</b> 5 bersaudara</td>
                </tr>
                <tr>
                    <td style="width: 200px">Hubungan Terlapor</td>
                    <td>:</td>
                    <td>Teman</td>
                </tr>
                <tr>
                    <td style="width: 200px">Kekhususuan</td>
                    <td>:</td>
                    <td>Super Power Flying</td>
                </tr>
            </table>
        </div>
        <div class="post clearfix" style="color:black">
            <b>C. IDENTITAS TERLAPOR</b>
            <span style="float:right">
                <a class="btn btn-xs bg-gradient-warning" id="tombol_edit_terlapor" onclick="editdata('terlapor')">
                <i class="fas fa-edit"></i> Edit
                </a>
                <button type="submit" class="btn btn-xs bg-gradient-success" id="tombol_save_terlapor">
                <i class="fas fa-check"></i> Save
                </button>
            </span>
            <table class="table table-bottom table-sm">
                <tr>
                    <td style="width: 200px">Nama</td>
                    <td>:</td>
                    <td>Addzifi Mochamad Gumelar (Laki-laki)</td>
                </tr>
                <tr>
                    <td style="width: 200px">Tempat/Tgl Lahir</td>
                    <td>:</td>
                    <td>Bogor, 13 Februari 1997 (25 Tahun)</td>
                </tr>
                <tr>
                    <td style="width: 200px">Alamat</td>
                    <td>:</td>
                    <td>Jl. Diponogoro Empu Tantular 45 Jaya, <b>Kelurahan</b> Mantap, <b>Kecamatan</b> Harapan, <b>Kota</b> DKI Jakarta</td>
                </tr>
                <tr>
                    <td style="width: 200px">Pendidikan Terakhir</td>
                    <td>:</td>
                    <td><b>Kelas</b> 2, <b>Sekolah</b> SDN 1 Wakanda</td>
                </tr>
                <tr>
                    <td style="width: 200px">Agama / Suku</td>
                    <td>:</td>
                    <td>Islam / Sunda</td>
                </tr>
                <tr>
                    <td style="width: 200px">Pekerjaan</td>
                    <td>:</td>
                    <td>Gamer</td>
                </tr>
                <tr>
                    <td style="width: 200px">Penghasilan Perbulan</td>
                    <td>:</td>
                    <td>6.000.000.000.000</td>
                </tr>
                <tr>
                    <td style="width: 200px">Status Perkawinan</td>
                    <td>:</td>
                    <td>Single</td>
                </tr>
                <tr>
                    <td style="width: 200px">Jumlah Anak</td>
                    <td>:</td>
                    <td>6</td>
                </tr>
                <tr>
                    <td style="width: 200px">Hubungan dengan klien</td>
                    <td>:</td>
                    <td>Teman</td>
                </tr>
            </table>
        </div>
        <div class="post clearfix" style="color:black">
            <b>D. KASUS KLIEN</b>
            <span style="float:right">
                <a class="btn btn-xs bg-gradient-warning" id="tombol_edit_kasus" onclick="editdata('kasus')">
                <i class="fas fa-edit"></i> Edit
                </a>
                <button type="submit" class="btn btn-xs bg-gradient-success" id="tombol_save_kasus">
                <i class="fas fa-check"></i> Save
                </button>
            </span>
            <table class="table table-bottom table-sm">
                <tr>
                    <td style="width: 200px">Tanggal Kejadian</td>
                    <td>:</td>
                    <td>01 Januari 2023</td>
                </tr>
                <tr>
                    <td style="width: 200px">Tempat Kejadian</td>
                    <td>:</td>
                    <td><b>Kategori Lokasi : </b> Sekolah</td>
                </tr>
                <tr>
                    <td style="width: 200px">Alamat Saat Kejadian</td>
                    <td>:</td>
                    <td>Jl. Diponogoro Empu Tantular 45 Jaya, <b>Kelurahan</b> Mantap, <b>Kecamatan</b> Harapan, <b>Kota</b> DKI Jakarta</td>
                </tr>
                <tr>
                    <td style="width: 200px">Pendidikan Saat Kejadian</td>
                    <td>:</td>
                    <td><b>Kelas</b> 2, <b>Sekolah</b> SDN 1 Wakanda</td>
                </tr>
                <tr>
                    <td style="width: 200px">Pekerjaan Saat Kejadian</td>
                    <td>:</td>
                    <td>Gamer</td>
                </tr>
                <tr>
                    <td style="width: 200px">Klasifikasi Kasus</td>
                    <td>:</td>
                    <td>Publik, Perundungan</td>
                </tr>
                <tr>
                    <td style="width: 200px">Nomor LP</td>
                    <td>:</td>
                    <td>LP / B/ 2232/IX/2022/SPKT/Polres Metro Jakarta Pusat/Polda metro Jaya</td>
                </tr>
                <tr>
                    <td style="width: 200px">Pasal</td>
                    <td>:</td>
                    <td>1. UNDANG-UNDANG REPUBLIK INDONESIA NOMOR 21 TAHUN 2007 TENTANG PEMBERANTASAN TINDAK PIDANA PERDAGANGAN ORANG</td>
                </tr>
                <tr>
                    <td style="width: 200px">Putusan</td>
                    <td>:</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td style="width: 200px">Catatan Kasus</td>
                    <td>:</td>
                    <td>Klien LPSK, Persidangan</td>
                </tr>
            </table>
        </div>
        <div class="post clearfix" style="color:black">
            <b>E. HASIL AKHIR</b>
            <span style="float:right">
                <a class="btn btn-xs bg-gradient-warning" id="tombol_edit_terlapor" onclick="editdata('terlapor')">
                <i class="fas fa-edit"></i> Edit
                </a>
                <button type="submit" class="btn btn-xs bg-gradient-success" id="tombol_save_terlapor">
                <i class="fas fa-check"></i> Save
                </button>
            </span>
            <table class="table table-bottom table-sm">
                <tr>
                    <td style="width: 200px">Catatan Akhir</td>
                    <td>:</td>
                    <td>Klien LPSK, Persidangan</td>
                </tr>
            </table>
        </div>
        <div class="post clearfix" style="color:black">
            <b>F. BILA DISIDANGKAN</b>
            <span style="float:right">
                <a class="btn btn-xs bg-gradient-warning" id="tombol_edit_terlapor" onclick="editdata('terlapor')">
                <i class="fas fa-edit"></i> Edit
                </a>
                <button type="submit" class="btn btn-xs bg-gradient-success" id="tombol_save_terlapor">
                <i class="fas fa-check"></i> Save
                </button>
            </span>
            <table class="table table-bottom table-sm">
                <tr>
                    <td style="width: 200px">Pelaku Dihukum</td>
                    <td>:</td>
                    <td>1 Tahun</td>
                </tr>
                <tr>
                    <td style="width: 200px">Dengan Denda</td>
                    <td>:</td>
                    <td>Rp. 1.000.000.000.000</td>
                </tr>
            </table>
        </div>
        <div class="post clearfix" style="color:black">
            <div class="row">
                <div class="col-md-4 text-center">
                    <b>Penerima Pengaduan</b>
                    <br>
                    <br>
                    <br>
                    <br>
                    (..............................................)
                </div>
                <div class="col-md-4 text-center">
                    <b>Manager Kasus</b>
                    <br>
                    <br>
                    <br>
                    <br>
                    (..............................................)
                </div>
                <div class="col-md-4 text-center">
                    <b>Klien / Pelapor</b>
                    <br>
                    <br>
                    <br>
                    <br>
                    (..............................................)
                </div>
            </div>
        </div>
        <br>
        <br>
        <button type="button" class="btn btn-block btn-primary">Print</button>
        </div>
        <div class="tab-pane {{ Request::get('tab') == 'kasus-Asesmen' ? 'active' : '' }}" id="kasus-Asesmen" role="tabpanel" aria-labelledby="kasus-Asesmen-tab">
            
            <div class="post clearfix" style="margin: 0px">
            <b>A. RIWAYAT KEJADIAN</b>
            </br>
            </br>
            <div style="overflow-x: scroll">
            <table id="example2" class="table table-sm table-bordered  table-hover" style="cursor:pointer; color:black">
                <thead>
                <tr>
                <th>Waktu Kejadian</th>
                <th>Detail Pristiwa</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
            </div>
            <div class="row" style="margin-top: 20px">
                <div class="col-md-12">
                    <div class="form-group">
                    <label>Upaya yang pernah dilakukan : </label>
                    {{-- <textarea name="" id="" cols="30" rows="3" class="form-control" style="resize: none;" readonly>lorem ipsum dolor sit amet</textarea> --}}
                        <div class="input-group">
                            <textarea class="form-control" aria-label="With textarea" style="resize: none;"></textarea>
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-secondary" type="button"><i class="fa fa-check"></i></button>
                            </div>
                        </div>    
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                    <label>Faktor pendukung pemecahan masalah : </label>
                    {{-- <textarea name="" id="" cols="30" rows="3" class="form-control" style="resize: none;" readonly>lorem ipsum dolor sit amet</textarea> --}}
                        <div class="input-group">
                            <textarea class="form-control" aria-label="With textarea" style="resize: none;"></textarea>
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-secondary" type="button"><i class="fa fa-check"></i></button>
                            </div>
                        </div>    
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                    <label>Faktor penghambat pemecahan masalah : </label>
                    {{-- <textarea name="" id="" cols="30" rows="3" class="form-control" style="resize: none;" readonly>lorem ipsum dolor sit amet</textarea> --}}
                        <div class="input-group">
                            <textarea class="form-control" aria-label="With textarea" style="resize: none;"></textarea>
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-secondary" type="button"><i class="fa fa-check"></i></button>
                            </div>
                        </div>    
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                    <label>Harapan/Kebutuhan klien : </label>
                    {{-- <textarea name="" id="" cols="30" rows="3" class="form-control" style="resize: none;" readonly>lorem ipsum dolor sit amet</textarea> --}}
                        <div class="input-group">
                            <textarea class="form-control" aria-label="With textarea" style="resize: none;"></textarea>
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-secondary" type="button"><i class="fa fa-check"></i></button>
                            </div>
                        </div>    
                    </div>
                </div>
            </div>
        </div>

            <div class="post clearfix">
                <b>B. BIOPSIKOSOSIAL</b>
                </br>
                <div class="row">

                <div class="col-md-12">
                    <div class="form-group">
                    <label>Biologis (kondisi fisik, catatan kesehatan, pengobatan)</label>
                    <textarea name="" id="" cols="30" rows="2" class="form-control" style="resize: none;"></textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                    <label>Psikologis</label>
                    <textarea name="" id="" cols="30" rows="2" class="form-control" style="resize: none;"></textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                    <label>Sosial & Spiritual</label>
                    <textarea name="" id="" cols="30" rows="2" class="form-control" style="resize: none;"></textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                    <label>Catatan Lainnya</label>
                    <textarea name="" id="" cols="30" rows="2" class="form-control" style="resize: none;"></textarea>
                    </div>
                </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputFile">Asesmen tools</label>
                            <div class="input-group">
                            <div class="custom-file">
                            <input type="file" class="custom-file-input" id="exampleInputFile">
                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                            </div>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button">Upload</button>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="exampleInputFile">Pic 1</label>
                            <div class="input-group">
                            <input type="text" class="form-control" readonly value="oojid.png" onclick="alert('oojid.png')" style="cursor: pointer">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button"><i class="fa fa-trash" aria-hidden="true"></i></button>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="exampleInputFile">Pic 2</label>
                            <div class="input-group">
                            <input type="text" class="form-control" readonly value="oojid.png" onclick="alert('oojid.png')" style="cursor: pointer">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button"><i class="fa fa-trash" aria-hidden="true"></i></button>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="exampleInputFile">Pic 3</label>
                            <div class="input-group">
                            <input type="text" class="form-control" readonly value="oojid.png" onclick="alert('oojid.png')" style="cursor: pointer">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button"><i class="fa fa-trash" aria-hidden="true"></i></button>
                            </div>
                            </div>
                        </div>
                    </div>
                
                <button type="button" class="btn btn-block btn-primary">Simpan</button>
                </div>
            </div>
    </div>

        <div class="tab-pane {{ Request::get('tab') == 'kasus-layanan' ? 'active' : '' }}" id="kasus-layanan" role="tabpanel" aria-labelledby="kasus-layanan-tab">
            <div class="row">
            <div class="card-body" style="overflow-x: scroll">
            <table id="example1" class="table table-sm table-bordered  table-hover" style="cursor:pointer">
                <thead>
                <tr>
                <th>Waktu Kegiatan</th>
                <th>Layanan</th>
                <th>Detail Layanan</th>
                <th>Petugas</th>
                </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                <tr>
                    <th>Waktu Kegiatan</th>
                    <th>Layanan</th>
                    <th>Detail Layanan</th>
                    <th>Petugas</th>
                </tr>
                </tfoot>
            </table>
            </div>
        </div>
        </div>
        <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
            <div class="timeline timeline-inverse">

            <div class="time-label">
            <span class="bg-danger">
            01 Jan. 2023
            </span>
            </div>
            
            
            <div>
                <i class="fas fa-envelope bg-primary"></i>
                <div class="timeline-item">
                <span class="time"><i class="far fa-clock"></i> 12:05</span>
                <h3 class="timeline-header"><a href="#">Addzifi Mochamad Gumelar</a> menginputkan data kasus</h3>
                <div class="timeline-body">
                Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                weebly ning heekya handang zimbra. Babblely odeo kaboodle
                quora plaxo ideeli hulu weebly balihoo...
                </div>
                </div>
            </div>


            <div>
                <i class="fas fa-envelope bg-primary"></i>
                <div class="timeline-item">
                <span class="time"><i class="far fa-clock"></i> 12:05</span>
                <h3 class="timeline-header"><a href="#">Addzifi Mochamad Gumelar</a> menginputkan data kasus</h3>
                <div class="timeline-body">
                Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                weebly ning heekya handang zimbra. Babblely odeo kaboodle
                quora plaxo ideeli hulu weebly balihoo...
                </div>
                <div class="timeline-footer">
                <a href="#" class="btn btn-primary btn-sm"><i class="nav-icon fas fa-file-alt"></i> Dokumen Pendukung</a>
                <a href="#" class="btn btn-primary btn-sm"><i class="nav-icon fas fa-file-alt"></i> Dokumen Pendukung</a>
                <a href="#" class="btn btn-primary btn-sm"><i class="nav-icon fas fa-file-alt"></i> Dokumen Pendukung</a>
                </div>
                </div>
            </div>
            
            
            <div>
            <i class="fas fa-comments bg-warning"></i>
            <div class="timeline-item">
            <span class="time"><i class="far fa-clock"></i> 27 mins ago</span>
            <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>
            <div class="timeline-body">
            Take me to your leader!
            Switzerland is small and neutral!
            We are more like Germany, ambitious and misunderstood!
            </div>
            <div class="timeline-footer">
            <a href="#" class="btn btn-warning btn-flat btn-sm">View comment</a>
            </div>
            </div>
            </div>
            
            
            <div class="time-label">
            <span class="bg-success">
            3 Jan. 2014
            </span>
            </div>
            
            
            <div>
            <i class="fas fa-camera bg-purple"></i>
            <div class="timeline-item">
            <span class="time"><i class="far fa-clock"></i> 2 days ago</span>
            <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>
            <div class="timeline-body">
            <img src="https://placehold.it/150x100" alt="...">
            <img src="https://placehold.it/150x100" alt="...">
            <img src="https://placehold.it/150x100" alt="...">
            <img src="https://placehold.it/150x100" alt="...">
            </div>
            </div>
            </div>
            
            <div>
            <i class="far fa-clock bg-gray"></i>
            </div>
            </div>
        </div>
        <div class="tab-pane {{ Request::get('tab') == 'kasus-petugas' ? 'active' : '' }}" id="kasus-petugas" role="tabpanel" aria-labelledby="kasus-petugas-tab">
            <div class="card-body p-0 {{ Request::get('tab') == 'kasus-petugas' ? 'hightlighting' : '' }}">
            <table class="table table-striped projects">
                <thead>
                <tr>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($petugas as $item)
                    <tr>
                        <td>
                            <img alt="Avatar" class="table-avatar" src="https://adminlte.io/themes/v3/dist/img/avatar.png" style="margin-right: 10px">
                            {{ $item->name }}
                        </td>
                        <td>
                            <h6><span class="badge badge-pill badge-primary">{{ $item->jabatan }}</span></h6>
                        </td>
                        <td>
                            <form action="{{ route('petugas.destroy',$item->id) }}" method="post">
                                @csrf 
                                @method('delete')
                                <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                              </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            <br>
            <form action="{{ route('petugas.store', $klien->uuid) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-9">
                        <select name="user_id" class="select2bs4" style="width: 100%;">
                            <option>Silahkan pilih petugas</option>
                            @foreach ($users as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-success btn-sm btn-block" type="submit"><i class="nav-icon fa fa-user-plus"></i> Tambah Petugas</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="tab-pane {{ Request::get('tab') == 'settings' ? 'active' : '' }}" id="kasus-settings" role="tabpanel" aria-labelledby="kasus-settings-tab">
            <div class="row">
                <div class="col-md-12 {{ Request::get('hightlight') == 'inputsupervisor' ? 'hightlighting' : '' }}">
                    <div class="form-group">
                    <label>Supervisor</label>
                    <select class="form-control select2" style="width: 100%;">
                    <option selected="selected">Silahkan Pilih</option>
                    <option>Satpel Jakarta Pusat</option>
                    <option>Satpel Jakarta Utara & Kep. 1000</option>
                    <option>Satpel Jakarta Barat</option>
                    <option>Satpel Jakarta Selatan</option>
                    <option>Satpel Jakarta Timur</option>
                    </select>
                    </div>
                </div>
                <div class="col-md-12 {{ Request::get('hightlight') == 'inputpersetujuankasus' ? 'hightlighting' : '' }}">
                    <div class="form-group">
                    <label>Setujui Kasus?</label>
                    <select class="form-control" style="width: 100%;" name="persetujuankasus" id="persetujuankasus">
                    <option selected="selected">silahkan pilih</option>
                    <option value="ya">Ya</option>
                    <option value="tidak">Tidak</option>
                    </select>
                    </div>

                    <div class="form-group">
                        <label>Catatan Supervisor Kasus</label>
                        <textarea name="catatan_spv_kss" class="form-control" id=""></textarea>
                    </div>
                </div>
                <button type="button" class="btn btn-block btn-primary">Simpan</button>
            </div>
        </div>
        </div>
        </div>
</div>

</div>

</div>
</section>

<!-- Modal Riwayat Kejadian-->
<div class="modal fade" id="riwayatModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
  
        <div id="overlay" class="overlay dark">
          <div class="cv-spinner">
            <span class="spinner"></span>
          </div>
        </div>
        
        <div class="modal-header">
          <h5 class="modal-title" id="modelHeading"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="alert alert-danger alert-dismissible invalid-feedback" id="error-message">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h4><i class="icon fa fa-ban"></i> Gagal!</h4>
          <span id="message"></span>
        </div>
        <div class="alert alert-success alert-dismissible invalid-feedback" id="success-message">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h4><i class="icon fa fa-check"></i> Success!</h4>
          Data berhasil disimpan.
        </div>
        <div class="modal-body">
        <input type="hidden" name="uuid" id="uuid">
        <div class="row">
          <div class="col-md-6">
              <div class="form-group">
                <label><span class="text-danger">*</span>Tanggal</label>
                <input type="date" class="form-control" id="tanggal">
                <div class="invalid-feedback" id="valid-tanggal_mulai">
                  Tanggal Kejadian wajib diisi.
                </div>
            </div>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                  <label><span class="text-danger">*</span>Jam</label>
                  <input type="time" class="form-control" id="jam">
                  <div class="invalid-feedback" id="valid-jam_mulai">
                    Jam Kejadian wajib diisi.
                  </div>
              </div>
          </div>
        </div>
        <div class="form-group">
            <label>Keterangan</label>
            <textarea name="" class="form-control required-field" id="keterangan" cols="30" rows="5"></textarea>
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success btn-block" id="submitRiwayatKejadian"><i class="fa fa-check"></i> Simpan</button>
          <button type="button" class="btn btn-danger btn-block" id="deleteRiwayatKejadian"><i class="fa fa-trash"></i> Hapus</button>
        </div>
      </div>
    </div>
  </div>

<script src="{{ asset('adminlte') }}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('adminlte') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('adminlte') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('adminlte') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{ asset('adminlte') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('adminlte') }}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="{{ asset('adminlte') }}/plugins/jszip/jszip.min.js"></script>
<script src="{{ asset('adminlte') }}/plugins/pdfmake/pdfmake.min.js"></script>
<script src="{{ asset('adminlte') }}/plugins/pdfmake/vfs_fonts.js"></script>
<script src="{{ asset('adminlte') }}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{{ asset('adminlte') }}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="{{ asset('adminlte') }}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- Bootstrap -->
<script src="{{ asset('adminlte') }}/plugins/select2/js/select2.full.min.js"></script>
<script src="{{ asset('/source/js/validation.js') }}"></script>

<script>
    $(document).ready(function () {
        getkotkab('pelapor');
        getkecamatan('pelapor');
        hightlighting();
    });
    
    $(function () {

    $('.input_pelapor').next(".select2-container").hide();
    $('.input_klien').next(".select2-container").hide();

    $('#example1').DataTable({
      "ordering": true,
      "processing": true,
      "serverSide": true,
      "responsive": false, 
      "lengthChange": false, 
      "autoWidth": false,
      "ajax": "/dokumen?uuid={{ $klien->uuid }}",
      'createdRow': function( row, data, dataIndex ) {
          $(row).attr('id', data.uuid);
      },
      "columns": [
        {
            "mData": "tanggal_mulai",
            "mRender": function (data, type, row) {
                return row.tanggal_mulai+"<br><span style='font-size:13px'>"+row.jam_mulai+" s/d "+row.jam_selesai+"</span>";
            }
        },
        {"data": "pemilik_template"},
        {"data": "keyword"},
        {"data": "name"}
      ],
      "pageLength": 25,
      "lengthMenu": [
          [10, 25, 50, 100, -1],
          ['10 rows', '25 rows', '50 rows', '100 rows','All'],
      ],
      "order": [[0, 'ASC']],
      "dom": 'Blfrtip', // Blfrtip or Bfrtip
      "buttons": ["pageLength", "copy", "csv", "excel", "pdf", "print", 
              {
                className: "btn-info",
                text: 'Tambah',
                  action: function ( ) {
                    if (confirm('Untuk memasukan laporan hasil pelayanan anda, silahkan buat Agenda dan Dokumen yang ditautkan.\nApakah anda ingin membuat Dokumen sekarang?') == true) {
                        window.location.assign('{{ route("dokumen") }}');
                    }
                  }
              }]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

      $('#example1_filter').css({'float':'right','display':'inline-block; background-color:black'});
    });

    $('#example1 tbody').on('click', 'tr', function () {
      $("#success-message").hide();
      $("#error-message").hide();
      
      $.get(`/dokumen/show/`+this.id, function (data) {
          $("#overlay").hide();
          console.log(data);
          tinymce.activeEditor.setContent(JSON.parse(data.konten));
          $('#ajaxModal').modal('show');
          //munculkan tombol
          $('#buttons').html('');
          $('#buttons').append('<button type="button" class="btn btn-primary btn-block" id="detail" onclick="saveAndPrint()"><i class="fas fa-print"></i> Print Dokumen</button>');
          $('#buttons').append('<button type="button" class="btn btn-warning btn-block" id="terima"><i class="fas fa-edit"></i> Edit Dokumen</button>');
          $('#buttons').append('<button type="button" class="btn btn-danger btn-block" id="hapus"><i class="fa fa-trash"></i> Hapus Dokumen</button>');
        });
    });


    $(function () {

    $('#example2').DataTable({
      "ordering": true,
      "processing": true,
      "serverSide": true,
      "responsive": false, 
      "lengthChange": false, 
      "autoWidth": false,
      "ajax": "/riwayatkejadian/index?uuid={{ $klien->uuid }}",
      'createdRow': function( row, data, dataIndex ) {
          $(row).attr('id', data.uuid);
      },
      "columns": [
        {
            "mData": "tanggal",
            "width": "10%",
            "mRender": function (data, type, row) {
                return row.tanggal+"<br><span style='font-size:13px'>"+row.jam+"</span>";
            }
        },
        {
            "mData": "keterangan",
            "mRender": function (data, type, row) {
              return row.keterangan;
            }
        }
      ],
      "pageLength": 5,
      "lengthMenu": [
          [10, 25, 50, 100, -1],
          ['10 rows', '25 rows', '50 rows', '100 rows','All'],
      ],
      "dom": 'Blfrtip', // Blfrtip or Bfrtip
      "buttons": ["pageLength", "copy", "csv", "excel", "pdf", "print",
              {
                className: "btn-info",
                text: 'Tambah',
                action: function ( ) {
                    $('#deleteRiwayatKejadian').hide();
                    $('#tanggal').val('');
                    $('#jam').val('');
                    $('#keterangan').val('');
                    $('#modelHeading').html("Tambah Riwayat Kejadian");
                    $('#riwayatModal').modal('show'); 
                    $("#overlay").hide();
                  }
              }]
      }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');

      $('#example2_filter').css({'float':'right','display':'inline-block; background-color:black'});
    });

    $('#example2 tbody').on('click', 'tr', function () {
        $("#success-message").hide();
        $("#error-message").hide();
        $.get(`/riwayatkejadian/edit/`+this.id, function (data) {
            $("#overlay").hide();
            $('#modelHeading').html("Edit Riwayat Kegiatan");
            $('#riwayatModal').modal('show');
            $('#deleteRiwayatKejadian').show();

            $('#uuid').val(data.uuid);
            $('#tanggal').val(data.tanggal);
            $('#jam').val(data.jam);
            $('#keterangan').val(data.keterangan);
        });
    });

    function editdata(params) {
        $('.data_'+params).hide();
        $('#tombol_edit_'+params).hide();
        $('.input_'+params).show();
        $('.input_'+params).next(".select2-container").show();
        $('#tombol_save_'+params).show(); 
    }

    //Initialize Select2 Elements
    $('.select2bs4').select2();
    $('.select-tag').select2({
    tags: true,
    theme: 'bootstrap4'
    });

    function getkotkab(field_id='') {
        province_code = $('#provinsi_id_'+field_id).val();
        
        $.ajax({
          url:'{{ route("api.v1.kotkab") }}?province_code='+province_code,
          type:'GET',
          dataType: 'json',
          success: function( response ) {
                var option = '<option value="">-- Pilih Kotkab --</option>';
                var kotkabID = '{{ $pelapor->kotkab_id }}';
                $.each(response.data, function(i, value) {
                    var selected = ''
                    if (kotkabID == value.code) {
                        selected = `selected="selected"`;
                    }

                    option += `<option value="${value.code}" ${selected}>${value.name}</option>`
                });
                $('#kota_id_'+field_id).html(option);
            }
        });
    };

    function getkecamatan(field_id='') {
      kota_code = $('#kota_id_'+field_id).val();
        $.ajax({
          url:'{{ route("api.v1.kecamatan") }}?kota_code='+kota_code,
          type:'GET',
          dataType: 'json',
          success: function( response ) {
                var option = '<option value="">-- Pilih Kecamatan --</option>';
                var kecamatanID = '{{ $pelapor->kecamatan_id }}'
                $.each(response.data, function(i, value) {
                    var selected = ''
                    if (kecamatanID == value.code) {
                        selected = `selected="selected"`
                    }
                    option += `<option value="${value.code}" ${selected}>${value.name}</option>`
                });
                $('#kecamatan_id_'+field_id).html(option);
            }
        });
    }; 

    $('#submitRiwayatKejadian').click(function() {
        if(validateForm()){
            let token   = $("meta[name='csrf-token']").attr("content");
            $.ajax({
            url: `/riwayatkejadian/store/`,
            type: "POST",
            cache: false,
            data: {
                uuid: $('#uuid').val(),
                uuid_klien: '{{ $klien->uuid }}',
                tanggal: $("#tanggal").val(),
                jam: $("#jam").val(),
                keterangan: $("#keterangan").val(),
                _token: token
            },
            success: function (response){
                if (response.success != true) {
                    console.log(response);
                    $('#message').html(JSON.stringify(response));
                    $("#success-message").hide();
                    $("#error-message").show();
                }else{
                    $('#message').html(response.message);
                    $("#success-message").show();
                    $("#error-message").hide();

                    $('#example2').DataTable().ajax.reload();

                    // hapus semua inputan
                    $('#tanggal').val('');
                    $('#jam').val('');
                    $('#keterangan').val('');
                }
            },
            error: function (response){
                setTimeout(function(){
                $("#overlay").fadeOut(300);
                },500);
                console.log(response);

                $('#message').html(JSON.stringify(response));
                $("#success-message").hide();
                $("#error-message").show();
            }
            }).done(function() { //loading submit form
                setTimeout(function(){
                $("#overlay").fadeOut(300);
                },500);
            });
        }else{
            $('#message').html('Mohon cek ulang data yang wajib diinput.');
            $("#success-message").hide();
            $("#error-message").show();
        }
    })

    $('#deleteRiwayatKejadian').click(function() {
        if(validateForm()){
            let token   = $("meta[name='csrf-token']").attr("content");
            uuid = $('#uuid').val();
            $.ajax({
            url: `/riwayatkejadian/destroy/`+uuid,
            type: "DELETE",
            cache: false,
            data: {
                _token: token
            },
            success: function (response){
                if (response.success != true) {
                    console.log(response);
                    $('#message').html(JSON.stringify(response));
                    $("#success-message").hide();
                    $("#error-message").show();
                }else{
                    $('#riwayatModal').modal('hide');
                    $("#success-message").hide();
                    $("#error-message").hide();

                    $('#example2').DataTable().ajax.reload();

                    // hapus semua inputan
                    $('#tanggal').val('');
                    $('#jam').val('');
                    $('#keterangan').val('');
                }
            },
            error: function (response){
                setTimeout(function(){
                $("#overlay").fadeOut(300);
                },500);
                console.log(response);

                $('#message').html(JSON.stringify(response));
                $("#success-message").hide();
                $("#error-message").show();
            }
            }).done(function() { //loading submit form
                setTimeout(function(){
                $("#overlay").fadeOut(300);
                },500);
            });
        }else{
            $('#message').html('Mohon cek ulang data yang wajib diinput.');
            $("#success-message").hide();
            $("#error-message").show();
        }
    })

    function hightlighting() {
        var inputValue = $('#perubahan').val();

        if (inputValue) {
            toastr.success('Berhasil update data!');
            var value = JSON.parse(inputValue);
            $.each(value, function(index, element) {
                data_update = $('#data_update').val();
                $('#'+element+'_'+value[value.length - 1]).addClass('hightlighting');
            });
        } 
    }
</script>
@endsection