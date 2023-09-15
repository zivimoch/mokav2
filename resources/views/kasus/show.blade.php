@extends('layouts.template')

@section('content')
<style>
    .input_pelapor, .input_klien {
        display: none;
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
</ul>
</div>
<div class="card {{ Request::get('kolom-kelengkapan') == 1 ? 'hightlighting' : '' }}" style="margin-top:-30px; margin-bottom:0px">
    <div class="card-header" data-card-widget="collapse" style="cursor: pointer;">
      <span class="card-title">
        <b>Kelengkapan Kasus (6/6)</b>
      </span>
      <div class="card-tools">
        <button type="button" class="btn btn-tool">
          <i class="fa fa-chevron-down"></i>
        </button>
      </div>
    </div>
    <div class="card-body collapse {{ Request::get('kolom-kelengkapan') == 1 ? 'show' : '' }}">
        <ol style="padding:15px; margin :-25px 0px -20px 0px">
            <li>
                Identifikasi <i class="fa fa-check"></i>
                <ul style="margin-left: -25px">
                    <li>
                        Data Kasus (60%)
                        <div class="progress progress-xs">
                            <div class="progress-bar bg-success progress-bar-striped" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                            </div>
                        </div>
                    </li>
                    <li>
                        Persetujuan Supervisor <i class="far fa-check-circle"></i>
                    </li>
                    <li>
                        Tanda Tangan SPP <i class="far fa-check-circle"></i>
                    </li>
                </ul>
            </li>
            <li>
                Asesmen <i class="fa fa-check"></i>
            </li>
            <li>
                Perencanaan Layanan <i class="fa fa-check"></i>
            </li>
            <li>
                @php
                    if ($detail['jumlah_layanan']>0) {
                        $progres_layanan = number_format(($detail['jumlah_layanan_selesai'] / $detail['jumlah_layanan']) * 100, 2);
                    }else{
                        $progres_layanan = 0;
                    }
                @endphp
                Pelaksanaan Layanan ({{ $progres_layanan }}%)
                <div class="progress progress-xs">
                    <div class="progress-bar bg-success progress-bar-striped" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: {{ $progres_layanan }}%">
                    </div>
                </div>
            </li>
            <li>
                Monitoring <i class="fa fa-check"></i>
            </li>
            <li>
                Terminasi <i class="fa fa-check"></i>
            </li>
        </ol>
    </div>
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
    
    <div class="card-body {{ Request::get('catatan-kasus') == 1 ? 'hightlighting' : '' }}" style="height: 350px; overflow-y:scroll;">
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
            <a class="nav-link {{ Request::get('tab') == 'kasus-asesmen' ? 'active' : '' }}" id="kasus-asesmen-tab" data-toggle="pill" href="#kasus-asesmen" role="tab" aria-controls="kasus-asesmen" aria-selected="false">Asesmen <i class="fas fa-exclamation-circle warningAsesmen" style="color: red; font-size:20px"></i></a>
        </li>
        <li class="nav-item">
        <a class="nav-link {{ Request::get('tab') == 'kasus-layanan' ? 'active' : '' }}" id="kasus-layanan-tab" data-toggle="pill" href="#kasus-layanan" role="tab" aria-controls="kasus-layanan" aria-selected="false">Layanan</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false">Log Activity</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::get('tab') == 'kasus-petugas' ? 'active' : '' }}" id="kasus-petugas-tab" data-toggle="pill" href="#kasus-petugas" role="tab" aria-controls="kasus-petugas" aria-selected="false">Petugas @if(!($detail['kelengkapan_petugas']))<i class="fas fa-exclamation-circle" style="color: red; font-size:20px"></i>@endif</a>
        </li>
        <li class="nav-item">
        <a class="nav-link {{ Request::get('tab') == 'kasus-persetujuan' ? 'active' : '' }}" id="kasus-persetujuan-tab" data-toggle="pill" href="#kasus-persetujuan" role="tab" aria-controls="kasus-persetujuan" aria-selected="false">Persetujuan @if(!($detail['kelengkapan_spp']))<i class="fas fa-exclamation-circle" style="color: red; font-size:20px"></i>@endif</a>
        </li>
        <li class="nav-item">
        <a class="nav-link {{ Request::get('tab') == 'settings' ? 'active' : '' }}" id="kasus-settings-tab" data-toggle="pill" href="#kasus-settings" role="tab" aria-controls="kasus-settings" aria-selected="false">Settings</a>
        </li>
        </ul>
        </div>
        <div class="card-body">
        <div class="tab-content" id="custom-tabs-one-tabContent">
        <div class="tab-pane fade show {{ Request::get('tab') == 'kasus' || Request::get('tab') == ''  ? 'active' : '' }}  {{ Request::get('hightlight') == 'formulir' ? 'hightlighting' : '' }}  {{ Request::get('kasus-all') == 1 ? 'hightlighting' : '' }}" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
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

            <b id="anchor_pelaporan">A. IDENTITAS PELAPOR</b>
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
                                @foreach ($hubungan_dengan_klien as $item)
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
            <form action="{{ route('formpenerimapengaduan.update', 'uuid') }}" method="POST">
            @csrf
            @method('put')
            <input type="hidden" name="uuid" value="{{ $klien->uuid }}">
            <input type="hidden" name="data_update" value="klien">
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
                    <td><span class="data_klien">{{ $klien->alamat }}</span> 
                        <input type="text" name="alamat" value="{{ $klien->alamat }}" class="input_klien">, 
                        <b>Provinsi</b> <span class="data_klien">{{ $klien->provinsi }}</span> 
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
                        <span class="data_klien">{{ $klien->pendidikan }}</span> 
                        <select name="pendidikan" class="input_klien select2bs4" style="width: 100%;">
                            @foreach ($pendidikan_terakhir as $item)
                                <option value="{{ $item }}" {{ $item == $klien->pendidikan ? 'selected' : '' }}>{{ $item }}</option>
                            @endforeach
                        </select>
                        (<span class="data_klien">{{ $klien->status_pendidikan }}</span> 
                        <select name="status_pendidikan" class="input_klien select2bs4" style="width: 100%;">
                            @foreach ($status_pendidikan as $item)
                                <option value="{{ $item }}" {{ $item == $klien->status_pendidikan ? 'selected' : '' }}>{{ $item }}</option>
                            @endforeach
                        </select>
                        )
                    </td>
                </tr>
                <tr id="nama_ibu_klien">
                    <td style="width: 200px">Nama Ibu</td>
                    <td>:</td>
                    <td><span class="data_klien">{{ $klien->nama_ibu }}</span> <input type="text" name="nama_ibu" value="{{ $klien->nama_ibu }}" class="input_klien"></td>
                </tr>
                <tr id="tanggal_lahir_ibu_klien">
                    <td style="width: 200px">Tempat/Tgl Lahir Ibu</td>
                    <td>:</td>
                    <td>
                        <span class="data_klien" id="tempat_lahir_ibu">{{ $klien->tempat_lahir_ibu }}</span> 
                        <input type="text" name="tempat_lahir_ibu" value="{{ $klien->tempat_lahir_ibu }}" class="input_klien">, 
                        <span class="data_klien">
                            {{ $klien->tanggal_lahir_ibu ? date('d M Y', strtotime($klien->tanggal_lahir_ibu)) : '' }} ({{ $klien->tanggal_lahir_ibu ? Carbon\Carbon::parse($klien->tanggal_lahir_ibu)->age.' tahun' : ' '}})
                        </span> 
                        <input type="date" name="tanggal_lahir_ibu" value="{{ $klien->tanggal_lahir_ibu }}" class="input_klien">
                    </td>
                </tr>
                <tr id="nama_ayah_klien">
                    <td style="width: 200px">Nama Ayah</td>
                    <td>:</td>
                    <td><span class="data_klien">{{ $klien->nama_ayah }}</span> <input type="text" name="nama_ayah" value="{{ $klien->nama_ayah }}" class="input_klien"></td>
                </tr>
                <tr id="tanggal_lahir_ayah_klien">
                    <td style="width: 200px">Tempat/Tgl Lahir Ayah</td>
                    <td>:</td>
                    <td>
                        <span class="data_klien" id="tempat_lahir_ayah">{{ $klien->tempat_lahir_ayah }}</span> 
                        <input type="text" name="tempat_lahir_ayah" value="{{ $klien->tempat_lahir_ayah }}" class="input_klien">, 
                        <span class="data_klien">
                            {{ $klien->tanggal_lahir_ayah ? date('d M Y', strtotime($klien->tanggal_lahir_ayah)) : '' }} ({{ $klien->tanggal_lahir_ayah ? Carbon\Carbon::parse($klien->tanggal_lahir_ayah)->age.' tahun' : ' '}})
                        </span> 
                        <input type="date" name="tanggal_lahir_ayah" value="{{ $klien->tanggal_lahir_ayah }}" class="input_klien">
                    </td>
                </tr>
                <tr id="agama_klien">
                    <td style="width: 200px">Agama / Suku</td>
                    <td>:</td>
                    <td>
                        <span class="data_klien">{{ $klien->agama }}</span> 
                        <select name="agama" class="input_klien select2bs4" style="width: 100%;">
                            @foreach ($agama as $item)
                                <option value="{{ $item }}" {{ $item == $klien->agama ? 'selected' : '' }}>{{ $item }}</option>
                            @endforeach
                        </select> / 
                        <span class="data_klien">{{ $klien->suku }}</span> 
                        <select name="suku" class="input_klien select2bs4" style="width: 100%;">
                            @foreach ($suku as $item)
                                <option value="{{ $item }}" {{ $item == $klien->suku ? 'selected' : '' }}>{{ $item }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr id="anak_ke_klien">
                    <td style="width: 200px">Anak Ke</td>
                    <td>:</td>
                    <td>
                        <span class="data_klien">{{ $klien->anak_ke }}</span> <input type="text" name="anak_ke" value="{{ $klien->anak_ke }}" class="input_klien"> 
                        <b>dari</b> 
                        <span class="data_klien">{{ $klien->jumlah_anak }}</span> <input type="text" name="jumlah_anak" value="{{ $klien->jumlah_anak }}" class="input_klien"> bersaudara
                    </td>
                </tr>
                <tr id="hubungan_klien_klien">
                    <td style="width: 200px">Hubungan dengan terlapor</td>
                    <td>:</td>
                    <td>
                        <span class="data_klien">{{ $klien->hubungan_klien }}</span> 
                        <select name="hubungan_klien" class="input_klien select2bs4" style="width: 100%;">
                            @foreach ($hubungan_dengan_terlapor as $item)
                                <option value="{{ $item }}" {{ $item == $klien->hubungan_klien ? 'selected' : '' }}>{{ $item }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr id="kondisi_khusus_klien">
                    <td style="width: 200px">Kekhususan</td>
                    <td>:</td>
                    <td>
                        <span class="data_klien">{{ $klien->kondisi_khusus }}</span> 
                        <select name="kondisi_khusus[]" class="input_klien select2bs4" style="width: 100%;" multiple="multiple">
                            @php
                            $kondisi_khusus = explode(",",$klien->kondisi_khusus);
                            @endphp
                            @foreach ($kekhususan as $item)
                                <option value="{{ $item }}" {{ in_array(' '.$item, $kondisi_khusus) ? 'selected' : '' }}>{{ $item }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
            </table>
            </form>
        </div>
        <div class="post clearfix" style="color:black">
            <b>C. IDENTITAS TERLAPOR</b>
            <?php $no_terlapor = 1;?>
            @foreach ($terlapor as $item)
            <br>
            <b> Terlapor {{ $no_terlapor }}</b>
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
                        <td>{{ $item->nama }} (Laki-laki)</td>
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
                <?php $no_terlapor++;?>
            @endforeach
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
                    <b>Manajer Kasus</b>
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
        <div class="tab-pane {{ Request::get('tab') == 'kasus-asesmen' ? 'active' : '' }}" id="kasus-asesmen" role="tabpanel" aria-labelledby="kasus-asesmen-tab">
            
            <div class="post clearfix" style="margin: 0px">
            <b>RIWAYAT KEJADIAN</b>
            </br>
            </br>
            <div style="overflow-x: scroll">
            <input type="hidden" id="uuid_riwayat_hightlight" value="{{ Request::get('row-riwayat') }}">
            <table id="tabelRiwayat" class="table table-sm table-bordered  table-hover" style="cursor:pointer; color:black">
                <thead>
                <tr>
                <th>Waktu Kejadian</th>
                <th>Detail Pristiwa</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
            </div>
            <br>
            @if(!($detail['kelengkapan_spp']))
            <div class="col-md-12 warningAsesmen">
                <div class="alert alert-danger">
                <h5><i class="fas fa-exclamation-circle"></i> Perhatian!</h5>
                Silahkan buat surat persetujuan perjanjian terlebih dahulu untuk menambahkan asesmen.
                </div>
            </div>
            @else
            <div class="col-md-12 warningAsesmen">
                <div class="alert alert-danger">
                <h5><i class="fas fa-exclamation-circle"></i> Perhatian!</h5>
                Segera inputkan data asesmen pada MOKA.
                </div>
            </div>
            <div id="kolomAsesmen"></div>
            <button type="submit" class="btn btn-block btn-default {{ Request::get('tambah-asesmen') == 1 ? 'hightlighting' : '' }}" data-toggle="modal" data-target="#tambahAsesmenModal"><i class="fas fa-plus"></i> Tambah Asesmen</button>
            @endif
        </div>

    </div>
    
    <div class="tab-pane {{ Request::get('tab') == 'kasus-layanan' ? 'active' : '' }}" id="kasus-layanan" role="tabpanel" aria-labelledby="kasus-layanan-tab">
        <div class="post clearfix" style="margin: 0px">
        <h4>Progres Layanan</h4>
        <div class="progress" style="height: 25px;">
            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $progres_layanan }}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"> <span style="font-size:30px">{{ $progres_layanan }}%</span></div>
        </div>
        <br>
        <div style="overflow-x: scroll">
            <input type="hidden" id="uuid_layanan_hightlight" value="{{ Request::get('row-layanan') }}">
            <table id="tabelLayanan" class="table table-sm table-bordered  table-hover" style="cursor:pointer">
                <thead>
                <tr>
                <th>Waktu Kegiatan</th>
                <th>Agenda</th>
                <th>Tindak Lanjut</th>
                <th>Centang</th>
                </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                <tr>
                    <th>Waktu Kegiatan</th>
                    <th>Agenda</th>
                    <th>Tindak Lanjut</th>
                    <th>Centang</th>
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
            @if(!($detail['kelengkapan_petugas']))
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-danger">
                    <h5><i class="fas fa-exclamation-circle"></i> Perhatian!</h5>
                    Minimal harus ada 1 Supervisor, 1 Manajer Kasus dan 1 Petugas Penerima Pengaduan untuk meregistrasi kasus.
                    </div>
                </div>
            </div>
            @endif
            <div class="card-body p-0 {{ Request::get('tabel-petugas') == 1 ? 'hightlighting' : '' }}" style="overflow-x:scroll">
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
            @if ((Auth::user()->jabatan == 'Manajer Kasus') || (Auth::user()->jabatan == 'Penerima Pengaduan'))
            {{-- <div class="col-md-12">
                <div class="alert alert-danger">
                <h5><i class="fas fa-exclamation-circle"></i> Perhatian!</h5>
                Input data asesmen terlebih dahulu sebelum menambahkan petugas.
                </div>
            </div> --}}
            <form action="{{ route('petugas.store', $klien->uuid) }}" method="POST">
                @csrf
                <div class="row {{ Request::get('tambah-petugas') == 1 ? 'hightlighting' : '' }}" style="padding : 15px">
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
            @endif
        </div>
        <div class="tab-pane {{ Request::get('tab') == 'kasus-persetujuan' ? 'active' : '' }}" id="kasus-persetujuan" role="tabpanel" aria-labelledby="kasus-persetujuan-tab">
            @if(!($detail['kelengkapan_spp']))
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-danger">
                        <h5><i class="fas fa-exclamation-circle"></i> Perhatian!</h5>
                        Surat Persetujuan Pelayanan belum dibuat. Silahkan buat link Surat Persetujuan Pelayanan.
                        </div>
                    </div>
                </div>
            @endif
            <div class="card-body p-0 {{ Request::get('tabel-persetujuan') == 1 ? 'hightlighting' : '' }}" style="overflow-x:scroll">
                <table class="table table-striped projects">
                    <thead>
                    <tr>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($persetujuan as $item)
                            <tr class="{{ Request::get('row-persetujuan') == $item->uuid ? 'hightlighting' : '' }}">
                                <td>
                                    <a href="#" onclick="showPersetujuan('{{ $item->uuid }}')"><i class="nav-icon fas fa-file-alt"></i> {{ $item->judul }}</a>
                                </td>
                                <td>
                                    {{ $item->created_at }}
                                </td>
                                <td>
                                    @if ($item->tandatangan != null)
                                    <h6><span class="badge badge-pill badge-success">sudah ditandatangani</span></h6>
                                    @else
                                    <h6><span class="badge badge-pill badge-warning">belum ditandatangani</span></h6>
                                    @endif
                                </td>
                                <td>
                                    <input type="text" id="link-form-{{ $item->uuid }}" value="{{ route('persetujuan.persetujuan_pelayanan', $item->uuid) }}" hidden>
                                    <button type="button" class="btn btn-primary" onclick="copyClipboard('{{ $item->uuid }}')"><i class="fas fa-link"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
                <br>
                <form action="{{ route('persetujuan.create', $klien->uuid) }}" method="POST">
                    @csrf
                    <div class="row {{ Request::get('tambah-persetujuan') == 1 ? 'hightlighting' : '' }}"  style="padding : 15px">
                        <div class="col-md-9">
                            <select name="persetujuan_template_uuid" class="select2bs4" style="width: 100%;">
                                <option>Silahkan pilih surat persetujuan</option>
                                @foreach ($persetujuan_template as $item)
                                    <option value="{{ $item->uuid }}">{{ $item->judul }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-success btn-sm btn-block" type="submit"><i class="nav-icon fas fa-plus"></i> Tambah Persetujuan</button>
                        </div>
                    </div>
                </form>
        </div>
        <div class="tab-pane {{ Request::get('tab') == 'settings' ? 'active' : '' }}" id="kasus-settings" role="tabpanel" aria-labelledby="kasus-settings-tab">
            @if(Auth::user()->jabatan == 'Supervisor Kasus')
            <div class="row {{ Request::get('persetujuan-supervisor') == 1 ? 'hightlighting' : '' }}">
                <div class="col-md-12 {{ Request::get('hightlight') == 'inputpersetujuankasus' ? 'hightlighting' : '' }}">
                    <label>Apakah anda ingin menyetujui kasus ini?</label>
                </div>
                @if(!($detail['kelengkapan_petugas']))
                <div class="col-md-12">
                    <div class="alert alert-danger">
                    <h5><i class="fas fa-exclamation-circle"></i> Perhatian!</h5>
                    Petugas Penerima Pengaduan belum melengkapi kelengkapan kasus. Minimal harus ada 1 Supervisor, 1 Manajer Kasus dan 1 Petugas Penerima Pengaduan.
                    </div>
                </div>
                @else
                <div class="col-md-6">
                    <form action="{{ route('kasus.approval', $klien->uuid) }}" method="POST">
                    @csrf
                    <input type="hidden" name='approval' value="1">
                    <button type="submit" class="btn btn-block btn-success"><i class="fas fa-check"></i> Ya dan buat nomor regis klien</button>
                    </form>
                </div>
                <div class="col-md-6">
                    <form action="{{ route('kasus.approval', $klien->uuid) }}" method="POST">
                    @csrf
                    <input type="hidden" name='approval' value="0">
                    <button type="submit" class="btn btn-block btn-danger"><i class="fas fa-times"></i> Tidak dan kirim notif ke MK untuk terminasi</button>
                    </form>
                </div>
                @endif
            </div>
            @endif
            @if(Auth::user()->jabatan == 'Manajer Kasus')
            <div class="row {{ Request::get('kolom-terminasi') == 1 ? 'hightlighting' : '' }}">
                <div class="col-md-12 {{ Request::get('hightlight') == 'inputpersetujuankasus' ? 'hightlighting' : '' }}">
                    <form action="{{ route('kasus.approval', $klien->uuid) }}" method="POST">
                    @csrf
                    <input type="hidden" name='approval' value="0">
                    <button type="submit" class="btn btn-block btn-danger"><i class="fas fa-times"></i> Terminasi Kasus</button>
                    </form>
                </div>
            </div>
            @endif
            @if(Auth::user()->jabatan == 'Penerima Pengaduan')
            <div class="row {{ Request::get('kolom-terminasi') == 1 ? 'hightlighting' : '' }}">
                <div class="col-md-12 {{ Request::get('hightlight') == 'inputpersetujuankasus' ? 'hightlighting' : '' }}">
                    <form action="{{ route('kasus.approval', $klien->uuid) }}" method="POST">
                    @csrf
                    <input type="hidden" name='approval' value="0">
                    <button type="submit" class="btn btn-block btn-warning"><i class="fas fa-times"></i> Arsipkan</button>
                    </form>
                </div>
            </div>
            @endif
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
        <input type="hidden" name="uuid" id="uuid_riwayat">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                <label><span class="text-danger">*</span>Tanggal</label>
                <input type="date" class="form-control required-field-riwayat" id="tanggal">
                <div class="invalid-feedback" id="valid-tanggal_mulai">
                    Tanggal Kejadian wajib diisi.
                </div>
            </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label><span class="text-danger">*</span>Jam</label>
                    <input type="time" class="form-control required-field-riwayat" id="jam">
                    <div class="invalid-feedback" id="valid-jam_mulai">
                        Jam Kejadian wajib diisi.
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>Keterangan</label>
            <textarea name="" class="form-control required-field-riwayat" id="keterangan" cols="30" rows="5"></textarea>
        </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success btn-block" id="submitRiwayatKejadian"><i class="fa fa-check"></i> Simpan</button>
            <button type="button" class="btn btn-danger btn-block" id="deleteRiwayatKejadian"><i class="fa fa-trash"></i> Hapus</button>
        </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Asesmen-->
<div class="modal fade" id="tambahAsesmenModal" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">

        <div id="overlay" class="overlay dark">
            <div class="cv-spinner">
            <span class="spinner"></span>
            </div>
        </div>
        
        <div class="modal-header">
            <h5 class="modal-title" id="modelHeadingAsesmen">Asesmen</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="alert alert-danger alert-dismissible invalid-feedback" id="error-message-asesmen">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-ban"></i> Gagal!</h4>
            <span id="message-asesmen"></span>
        </div>
        <div class="alert alert-success alert-dismissible invalid-feedback" id="success-message-asesmen">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Success!</h4>
            Data berhasil disimpan.
        </div>
        <div class="modal-body">
        <input type="hidden" name="uuid" id="uuid_asesmen">
        <b>A. UPAYA PEMECAHAN MASALAH</b>
        </br>
        <div class="col-md-12">
            <div class="form-group">
            <label>Upaya yang pernah dilakukan : </label>
                <textarea class="form-control required-field-asesmen" id="asesmen_upaya" aria-label="With textarea" style="resize: none;" ></textarea>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
            <label>Faktor pendukung pemecahan masalah : </label>
                <textarea class="form-control required-field-asesmen" id="asesmen_pendukung" aria-label="With textarea" style="resize: none;"></textarea>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
            <label>Faktor penghambat pemecahan masalah : </label>
                <textarea class="form-control required-field-asesmen" id="asesmen_hambatan" aria-label="With textarea" style="resize: none;"></textarea>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
            <label>Harapan/Kebutuhan klien : </label>
                <textarea class="form-control required-field-asesmen" id="asesmen_harapan" aria-label="With textarea" style="resize: none;"></textarea>
            </div>
        </div>
        <div class="post clearfix"></div>
        <b>B. BIOPSIKOSOSIAL</b>
        </br>
        <div class="col-md-12">
            <div class="form-group">
            <label>Biologis (kondisi fisik, catatan kesehatan, pengobatan)</label>
            <textarea id="asesmen_fisik" cols="30" rows="2" class="form-control required-field-asesmen" style="resize: none;"></textarea>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
            <label>Psikologis</label>
            <textarea id="asesmen_psikologis" cols="30" rows="2" class="form-control required-field-asesmen" style="resize: none;"></textarea>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
            <label>Sosial & Spiritual</label>
            <textarea id="asesmen_sosial" cols="30" rows="2" class="form-control required-field-asesmen" style="resize: none;"></textarea>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
            <label>Hukum</label>
            <textarea id="asesmen_hukum" cols="30" rows="2" class="form-control required-field-asesmen" style="resize: none;"></textarea>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
            <label>Catatan Lainnya</label>
            <textarea id="asesmen_lainnya" cols="30" rows="2" class="form-control required-field-asesmen" style="resize: none;"></textarea>
            </div>
        </div>
    {{-- <div class="col-md-6">
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
        </div> --}}
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success btn-block" id="submitAsesmen"><i class="fa fa-check"></i> Simpan</button>
            <button type="button" class="btn btn-danger btn-block" id="deleteAsesmen"><i class="fa fa-trash"></i> Hapus</button>
        </div>
        </div>
    </div>
</div>

<!-- Modal Surat Persetujuan-->
<div class="modal fade" id="sppModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content card">
        <div id="overlay" class="overlay dark">
            <div class="cv-spinner">
                <span class="spinner"></span>
            </div>
        </div>
        <div class="modal-header">
            <h4 class="modal-title">Default Modal</h4>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                    <i class="fas fa-expand"></i>
                </button>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        <div class="modal-body">
            <div class="form-card">
              <div class="form-group">
                <body data-editor="DecoupledDocumentEditor" data-collaboration="false">
                  <div id="mytoolbar" style="width: 1000px"></div>
                  <main>
                    <div class="centered">
                      <iframe class="embed-responsive-item" src="http://127.0.0.1:8000/persetujuan/donepelayanan/343ff690-cfd6-41e4-b9f3-6c41cfe8e9e8" style="width: 100%; height:1000px"></iframe>
                    </div>
                  </main>
                </body>
              </div>
            </div>
          </div>            
        <div class="modal-footer justify-content-between">
        </div>
        </div>
    </div>
</div>

 <!-- Modal Agenda Layanan-->
 <div class="modal fade" id="ajaxModel" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
        <div class="form-group">
            <label><span class="text-danger">*</span>Judul kegiatan</label>
            <input type="text" class="form-control required-field-agenda" id="judul_kegiatan">
            <div class="invalid-feedback" id="valid-judul_kegiatan">
              Judul Kegiatan wajib diisi.
            </div>
        </div>
        <div class="row">
          <div class="col-md-6">
              <div class="form-group">
                <label><span class="text-danger">*</span>Tanggal</label>
                <input type="date" class="form-control required-field-agenda" id="tanggal_mulai">
                <div class="invalid-feedback" id="valid-tanggal_mulai">
                  Tanggal Mulai wajib diisi.
                </div>
            </div>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                  <label><span class="text-danger">*</span>Jam mulai</label>
                  <input type="time" class="form-control required-field-agenda" id="jam_mulai">
                  <div class="invalid-feedback" id="valid-jam_mulai">
                    Jam Mulai wajib diisi.
                  </div>
              </div>
          </div>
        </div>
        <div class="form-group">
            <label>Keterangan</label>
            <textarea name="" class="form-control" id="keterangan" cols="30" rows="2"></textarea>
        </div>
        <div class="form-group">
            <label>Penjadwalan Layanan</label>
            <select name="" class="form-control" id="penjadwalan_layanan" onchange="penjadwalan_layanan()">
              <option value="0">Tidak</option>
              <option value="1">Ya</option>
            </select>
        </div>
        <div class="form-group" id="klien_id">
          <label>Pilih Klien</label>
          <select class="form-control select2" style="width: 100%;" id="klien_id">
            <option>silahkan pilih</option>
            <option value="1">Tini</option>
            <option value="2">Tina</option>
            <option value="3">Toni</option>
            <option value="4">Tono</option>
            <option value="5">Tino</option>
            <option value="6">Tanos</option>
          </select>
        </div>
        <div class="form-group">
          <label><span class="text-danger">*</span>Tag</label>
          <select class="select2" multiple="multiple" data-placeholder="Pilih nama" style="width: 100%;" id="user_id">
          <option value="{{ Auth::user()->id }}" selected>{{ Auth::user()->name }}</option>
          <option value="22">Alexander Graham Bell</option>
          <option value="23">Thomas Alfa Edison</option>
          <option value="24">Tony Stark</option>
          <option value="25">Rudy Tabootie</option>
          </select>
          <div class="invalid-feedback" id="valid-user_id">
            Minimal tag 1 orang.
          </div>
        </div>
          <div class="col-12" id="accordion" style="padding:0px !important">
              <div class="card card-primary card-outline">
              <a class="d-block w-100" data-toggle="collapse" href="#collapseOne">
              <div class="card-header">
              <h4 class="card-title w-100">
              Tindak Lanjut
              </h4>
              </div>
              </a>
              <div id="collapseOne" class="collapse" data-parent="#accordion">
                <div class="alert alert-warning alert-dismissible">
                  <i class="icon fas fa-exclamation-triangle"></i> Data <b>Tindak Lanjut</b> hanya tercatat pada akun anda
                </div>
              <div class="card-body">
                {{-- <div class="form-group">
                  <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                  <input type="checkbox" class="custom-control-input" id="customSwitch3">
                  <label class="custom-control-label" for="customSwitch3">Terlaksana</label>
                  </div>
                </div> --}}
                  <div class="form-group">
                    <label>Lokasi Kegiatan</label>
                    <input type="text" class="form-control" id="lokasi">
                  </div>
                  <div class="form-group">
                      <label>Jam selesai</label>
                      <?php
                        date_default_timezone_set("asia/jakarta");
                        $jam_selesai = date("h:i");
                      ?>
                      <input type="time" class="form-control" id="jam_selesai" value="">
                  </div>
                  <div class="form-group">
                  <label>Dokumen pendukung <span style="font-size: 12px">(lihat dokumen tersedia <a href="{{ route('dokumen') }}" target="_blank">disini</a>)<br>*Laporan Hasil Pelayanan</span></label>
                  <select class="select2" multiple="multiple" data-placeholder="Pilih nama" style="width: 100%;" id="dokumen_pendukung">
                  <option value="31"><i class="fas fa-file-alt"></i> Dokumen konsultasi hukum kasus Eliza Thornberry</option>
                  <option value="32"><i class="fas fa-file-alt"></i> Dokumen Pendampingan pengadilan kasus eliza thornberry</option>
                  <option value="33"><i class="fas fa-file-alt"></i> Pendampingan pengadilan kasus tom delounge</option>
                  <option value="34"><i class="fas fa-file-alt"></i> Mediasi kasus tom delounge</option>
                  </select>
                  </div>
                  <div class="form-group">
                      <label>Catatan</label>
                      <textarea name="" class="form-control" id="catatan" cols="30" rows="2"></textarea>
                  </div>
                  <span style="font-size: 14px">*Laporan Tindak Lanjut tersimpan pada tanggal : <span id='ct' ></span></span>
                </div>
              </div>
              </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success btn-block" id="submit"><i class="fa fa-check"></i> Simpan</button>
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
        getkotkab('klien');
        hightlighting();
        loadAsesmen();

        //Initialize Select2 Elements
        $('.select2').select2();
        $('.select2bs4').select2();
        $('.select-tag').select2({
        tags: true,
        theme: 'bootstrap4'
        });
    });
    
    $(function () {

    $('.input_pelapor').next(".select2-container").hide();
    $('.input_klien').next(".select2-container").hide();

    $('#tabelLayanan').DataTable({
      "ordering": true,
      "processing": true,
      "serverSide": true,
      "responsive": false, 
      "lengthChange": false, 
      "autoWidth": false,
      "ajax": "/agenda/api_index?uuid={{ $klien->uuid }}",
      'createdRow': function( row, data, dataIndex ) {
          $(row).attr('id', data.uuid);

          rowHightlight = $('#uuid_layanan_hightlight').val();
          if (data.uuid == rowHightlight) {
            $(row).attr('class', 'hightlighting');
          }
      },
      "columns": [
        {
            "mData": "tanggal_mulai",
            "mRender": function (data, type, row) {
                if (row.jam_selesai != null) {
                    jam_mulai = row.jam_mulai+' - '+row.jam_selesai;
                }else{
                    jam_mulai =  row.jam_mulai;
                }
                return row.tanggal_mulai+"<br><span style='font-size:13px'>"+jam_mulai+"</span>";
            }
        },
        {
            "mData": "judul_kegiatan",
            "mRender": function (data, type, row) {
                judul_kegiatan = keterangan = '';
                if (row.judul_kegiatan != null) {
                    judul_kegiatan = '<b>'+row.judul_kegiatan+'</b>';
                }

                if (row.keterangan != null) {
                    keterangan = '</br>'+row.keterangan;
                }

                return judul_kegiatan+keterangan;
            }
        },
        {
            "mData": "catatan",
            "mRender": function (data, type, row) {
                catatan = lokasi = '';

                if (row.catatan) {
                    catatan = row.catatan+'<br>';
                }

                if (row.lokasi) {
                    lokasi = 'Lokasi : '+row.lokasi;
                }

                if(row.judul != null){
                    dokumen = row.judul;
                    dokumens = '';
                    var array = dokumen.split(",|");
                    for (i=1;i<array.length;i++){
                    dokumens += '<a href="https://facebook.com"><span class="badge bg-primary"><i class="nav-icon fas fa-file-alt"></i> '+array[i]+'</span></a> ';
                    };
                }else{
                    dokumens = '';
                }
                return catatan+lokasi+'<br>'+dokumens;
            }
        },
        {
            "mData": "ceklis",
            "mRender": function (data, type, row) {
                if (row.jam_selesai == null) {
                    done = '';
                    checked = '';
                    disabled = '';
                    selesaiLayanan = '';
                } else {
                    done = 'done';
                    checked = 'checked';
                    disabled = 'disabled';
                    selesaiLayanan = 'layananSelesai';
                }
                return '<div  class="icheck-primary d-inline ml-2"><input class="checkboxSelesai '+selesaiLayanan+'" type="checkbox" value="" id="todoCheck'+row.uuid+'" '+checked+' '+disabled+' onclick="showModal(`'+row.tanggal_mulai+'`,`'+row.uuid+'`)"><label for="todoCheck'+row.uuid+'"></label></div>';
            }
        }
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
                    if (confirm('modal input agenda') == true) {
                        window.location.assign('{{ route("dokumen") }}');
                    }
                  }
              }]
      }).buttons().container().appendTo('#tabelLayanan_wrapper .col-md-6:eq(0)');

      $('#tabelLayanan_filter').css({'float':'right','display':'inline-block; background-color:black'});
    });

    $('#tabelLayanan tbody').on('click', 'tr', function () {
      $("#success-message").hide();
      $("#error-message").hide();
      
    //   $.get(`/dokumen/show/`+this.id, function (data) {
    //       $("#overlay").hide();
    //       console.log(data);
    //       tinymce.activeEditor.setContent(JSON.parse(data.konten));
    //       $('#ajaxModal').modal('show');
    //       //munculkan tombol
    //       $('#buttons').html('');
    //       $('#buttons').append('<button type="button" class="btn btn-primary btn-block" id="detail" onclick="saveAndPrint()"><i class="fas fa-print"></i> Print Dokumen</button>');
    //       $('#buttons').append('<button type="button" class="btn btn-warning btn-block" id="terima"><i class="fas fa-edit"></i> Edit Dokumen</button>');
    //       $('#buttons').append('<button type="button" class="btn btn-danger btn-block" id="hapus"><i class="fa fa-trash"></i> Hapus Dokumen</button>');
    //     });
    });


    $(function () {

    $('#tabelRiwayat').DataTable({
      "ordering": true,
      "processing": true,
      "serverSide": true,
      "responsive": false, 
      "lengthChange": false, 
      "autoWidth": false,
      "ajax": "/riwayatkejadian/index?uuid={{ $klien->uuid }}",
      'createdRow': function( row, data, dataIndex ) {
          $(row).attr('id', data.uuid);

          rowHightlight = $('#uuid_riwayat_hightlight').val();
          if (data.uuid == rowHightlight) {
            $(row).attr('class', 'hightlighting');
          }
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
      "pageLength": 10,
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
                    //reset uuid riwayat
                    $('#uuid_riwayat').val('');
                  }
              }]
      }).buttons().container().appendTo('#tabelRiwayat_wrapper .col-md-6:eq(0)');

      $('#tabelRiwayat_filter').css({'float':'right','display':'inline-block; background-color:black'});
    });

    $('#tabelRiwayat tbody').on('click', 'tr', function () {
        $("#success-message").hide();
        $("#error-message").hide();
        $.get(`/riwayatkejadian/edit/`+this.id, function (data) {
            $("#overlay").hide();
            $('#modelHeading').html("Edit Riwayat Kegiatan");
            $('#riwayatModal').modal('show');
            $('#deleteRiwayatKejadian').show();

            $('#uuid_riwayat').val(data.uuid);
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

    function getkotkab(field_id='') {
        province_code = $('#provinsi_id_'+field_id).val();
        if (field_id == 'pelapor') { //pelapor
            var kotkabID = '{{ $pelapor->kotkab_id }}';
        } else { //klien
            var kotkabID = '{{ $klien->kotkab_id }}';
        }
        
        $.ajax({
          url:'{{ route("api.v1.kotkab") }}?province_code='+province_code,
          type:'GET',
          dataType: 'json',
          success: function( response ) {
                var option = '<option value="">-- Pilih Kotkab --</option>';
                $.each(response.data, function(i, value) {
                    var selected = ''
                    if (kotkabID == value.code) {
                        selected = `selected="selected"`;
                    }

                    option += `<option value="${value.code}" ${selected}>${value.name}</option>`
                });
                $('#kota_id_'+field_id).html(option);
                //panggil kecamatan
                getkecamatan(field_id);
            }
        });
    };

    function getkecamatan(field_id='') {
        kota_code = $('#kota_id_'+field_id).val();
        if (field_id == 'pelapor') { //pelapor
            var kecamatanID = '{{ $pelapor->kecamatan_id }}';
        } else { //klien
            var kecamatanID = '{{ $klien->kecamatan_id }}';
        }
        $.ajax({
          url:'{{ route("api.v1.kecamatan") }}?kota_code='+kota_code,
          type:'GET',
          dataType: 'json',
          success: function( response ) {
                var option = '<option value="">-- Pilih Kecamatan --</option>';
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
        if(validateForm('riwayat')){
            let token   = $("meta[name='csrf-token']").attr("content");
            $.ajax({
            url: `/riwayatkejadian/store/`,
            type: "POST",
            cache: false,
            data: {
                uuid: $('#uuid_riwayat').val(),
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

                    $('#tabelRiwayat').DataTable().ajax.reload();

                    // hapus semua inputan
                    $('#tanggal').val('');
                    $('#jam').val('');
                    $('#keterangan').val('');
                    // untuk hightlight row yang baru
                    data = response.data;
                    $('#uuid_riwayat_hightlight').val(data.uuid);
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
    });

    $('#deleteRiwayatKejadian').click(function() {
        let token   = $("meta[name='csrf-token']").attr("content");
        uuid = $('#uuid_riwayat').val();
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

                $('#tabelRiwayat').DataTable().ajax.reload();

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
    });

    function loadAsesmen() {
        $('#deleteAsesmen').hide();
        $.ajax({
            url: `/asesmen/index?uuid={{ $klien->uuid }}`,
            type: "GET",
            cache: false,
            success: function (response){
                $('#kolomAsesmen').html('');
                
                data = response.data;
                //jika asesmen tidak tersedia maka munculkan warning
                if (data.length > 0) {
                    $('.warningAsesmen').hide();
                } else {
                    $('.warningAsesmen').show();
                }
                i=1;
                data.forEach(e => {
                    $('#kolomAsesmen').prepend('<div class=\"card collapsed-card target\"> <div class=\"card-header\" data-card-widget=\"collapse\" style=\"cursor: pointer;\"> <h3 class=\"card-title\"><b>Asesmen ke-'+i+' oleh '+e.petugas+' ('+e.jabatan+')</b></h3> <div class=\"card-tools\"> <button type=\"button\" class=\"btn btn-tool\"><i class=\"fa fa-chevron-down\"></i> </button> </div> </div> <div class=\"card-body\"> <b>A. UPAYA PEMECAHAN MASALAH</b> </br> <div class=\"col-md-12\"> <div class=\"form-group\"> <label>Upaya yang pernah dilakukan : </label> <textarea readonly class=\"form-control\" style=\"resize: none;\" >'+e.upaya+'</textarea> </div> </div> <div class=\"col-md-12\"> <div class=\"form-group\"> <label>Faktor pendukung pemecahan masalah : </label> <textarea readonly class=\"form-control\" style=\"resize: none;\">'+e.pendukung+'</textarea> </div> </div> <div class=\"col-md-12\"> <div class=\"form-group\"> <label>Faktor penghambat pemecahan masalah : </label> <textarea readonly class=\"form-control\" style=\"resize: none;\">'+e.hambatan+'</textarea> </div> </div> <div class=\"col-md-12\"> <div class=\"form-group\"> <label>Harapan/Kebutuhan klien : </label> <textarea readonly class=\"form-control\" style=\"resize: none;\">'+e.harapan+'</textarea> </div> </div> <div class=\"post clearfix\"></div> <b>B. BIOPSIKOSOSIAL</b> </br> <div class=\"col-md-12\"> <div class=\"form-group\"> <label>Biologis (kondisi fisik, catatan kesehatan, pengobatan)</label> <textarea readonly cols=\"30\" rows=\"2\" class=\"form-control\" style=\"resize: none;\">'+e.fisik+'</textarea> </div> </div> <div class=\"col-md-12\"> <div class=\"form-group\"> <label>Psikologis</label> <textarea readonly cols=\"30\" rows=\"2\" class=\"form-control\" style=\"resize: none;\">'+e.psikologis+'</textarea> </div> </div> <div class=\"col-md-12\"> <div class=\"form-group\"> <label>Sosial & Spiritual</label> <textarea readonly cols=\"30\" rows=\"2\" class=\"form-control\" style=\"resize: none;\">'+e.sosial+'</textarea> </div> </div> <div class=\"col-md-12\"> <div class=\"form-group\"> <label>Hukum</label> <textarea readonly cols=\"30\" rows=\"2\" class=\"form-control\" style=\"resize: none;\">'+e.hukum+'</textarea> </div> </div> <div class=\"col-md-12\"> <div class=\"form-group\"> <label>Catatan Lainnya</label> <textarea readonly cols=\"30\" rows=\"2\" class=\"form-control\" style=\"resize: none;\">'+e.lainnya+'</textarea> </div> </div> </div> </div>');
                    i++;
                });
            },
            error: function (response){
                console.log(response);
            }
            });
    }

    $('#submitAsesmen').click(function() {
        if(validateForm('asesmen')){
            let token   = $("meta[name='csrf-token']").attr("content");
            $.ajax({
            url: `/asesmen/store/`,
            type: "POST",
            cache: false,
            data: {
                uuid: $('#uuid_asesmen').val(),
                uuid_klien: '{{ $klien->uuid }}',
                upaya: $("#asesmen_upaya").val(),
                pendukung: $("#asesmen_pendukung").val(),
                hambatan: $("#asesmen_hambatan").val(),
                harapan: $("#asesmen_harapan").val(),
                fisik: $("#asesmen_fisik").val(),
                sosial: $("#asesmen_sosial").val(),
                psikologis: $("#asesmen_psikologis").val(),
                hukum: $("#asesmen_hukum").val(),
                lainnya: $("#asesmen_lainnya").val(),
                _token: token
            },
            success: function (response){
                if (response.success != true) {
                    $('#message-asesmen').html(JSON.stringify(response));
                    $("#success-message-asesmen").hide();
                    $("#error-message-asesmen").show();
                }else{
                    $('#message-asesmen').html(response.message);
                    $("#success-message-asesmen").show();
                    $("#error-message-asesmen").hide();
                    loadAsesmen();

                    // hapus semua inputan
                    $('#uuid_asesmen').val('');
                    $("#asesmen_upaya").val('');
                    $("#asesmen_pendukung").val('');
                    $("#asesmen_hambatan").val('');
                    $("#asesmen_harapan").val('');
                    $("#asesmen_fisik").val('');
                    $("#asesmen_sosial").val('');
                    $("#asesmen_psikologis").val('');
                    $("#asesmen_hukum").val('');
                    $("#asesmen_lainnya").val('')
                    $('#tambahAsesmenModal').scrollTop(0);
                    loadNotif(0);
                }
            },
            error: function (response){
                setTimeout(function(){
                $("#overlay").fadeOut(300);
                },500);
                console.log(response);

                $('#message-asesmen').html(JSON.stringify(response));
                $("#success-message-asesmen").hide();
                $("#error-message-asesmen").show();
            }
            }).done(function() { //loading submit form
                setTimeout(function(){
                $("#overlay").fadeOut(300);
                },500);
            });
        }else{
            $('#message-asesmen').html('Mohon cek ulang data yang wajib diinput.');
            $("#success-message-asesmen").hide();
            $("#error-message-asesmen").show();
        }
    });

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

    function copyClipboard(uuid) {
        var copyText = document.getElementById("link-form-"+uuid);
        copyText.select();
        copyText.setSelectionRange(0, 99999); // For mobile devices
        navigator.clipboard.writeText(copyText.value);
        alert('Link berhasil dicopy');
    }

    function showPersetujuan(uuid){
        $('#sppModal').modal('show');
        //untuk update notif task untuk melihat SPP
        //nanti diupdate lagi saja biar shownya serverside
        $.ajax({
          url:'{{ route("persetujuan.done",'') }}/'+uuid,
          type:'GET',
          dataType: 'json',
          success: function( response ) {
            loadNotif(0);
            //tampilkan surat perjanjian serverside
            }
        });
    }

    function showModal(tanggal_mulai, agenda_id) {
    if (agenda_id != 0) {
        $.get(`/agenda/edit/`+agenda_id, function (data) {
            $('#modelHeading').html("Edit Agenda");

            $('#uuid').val(data.uuid);
            $('#judul_kegiatan').val(data.judul_kegiatan);
            $('#tanggal_mulai').val(data.tanggal_mulai);
            $('#jam_mulai').val(data.jam_mulai);
            $('#keterangan').val(data.keterangan);
            $('#klien_id').val(data.klien_id);
            $('#lokasi').val(data.lokasi);
            $('#jam_selesai').val(data.jam_selesai);
            $('#catatan').val(data.catatan);
            $('#dokumen_pendukung').val(data.dokumen_pendukung);

            if (data.klien_id != null) {
            $('#penjadwalan_layanan').val(1);
            $("#klien_id").select2("val", data.klien_id);
            }else{
            $('#penjadwalan_layanan').val(0);
            $("#klien_id").select2("val", "null");
            }
            penjadwalan_layanan();
            $("#collapseOne").addClass("show");
        
            $("#user_id").val(data.user_id);
            $('#user_id').select2();

            $("#dokumen_pendukung").val(data.dokumen_pendukung);
            $('#dokumen_pendukung').select2();
        });
    }

    $("#success-message").hide();
    $("#error-message").hide();
    $("#overlay").hide();
    
    // hapus semua inputan
    $('#judul_kegiatan').val('');
    $('#jam_mulai').val('');
    $('#keterangan').val('');
    $('#klien_id').val('');
    $('#lokasi').val('');
    $('#jam_selesai').val('');
    $('#catatan').val('');
    $('#dokumen_pendukung').val('');

    $("#klien_id").hide();

    $('#tanggal_mulai').val(tanggal_mulai); 
    $('#modelHeading').html('Tambah Agenda'); 
    $('#ajaxModel').modal('show'); 
    }

    function penjadwalan_layanan() {
        if ($('#penjadwalan_layanan').val() == 0) {
            $("#klien_id").hide();
        } else {
            $("#klien_id").show();
        }
    }
</script>
@endsection