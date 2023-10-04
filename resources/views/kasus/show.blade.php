@extends('layouts.template')

@section('content')
<style>
    .input_pelapor, .input_klien, .input_kasus {
        display: none;
    }

    .input_pelapor, #tombol_save_pelapor, .input_klien, #tombol_save_klien, .input_kasus, #tombol_save_kasus, .input_terlapor, .tombol_save_terlapor {
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

    #check_persetujuan_spv, #check_ttd_spp, #check_identifikasi, #check_asesmen, .warningAsesmen, .warningSPP, #modalAsesmen, #check_perencanaan, #check_pelaksanaan, #check_monitoring, #check_terminasi, .warningTerminasi {
        display: none;
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
    {{-- ini ketika submit perubahan --}}
    <input type="" id="perubahan" value="{{ Session::get('data') }}">
@elseif(Request::get('data'))
    {{-- ini untuk notifikasi ketika diklik redirect --}}
    <input type="" id="perubahan" value="{{ Request::get('data') }}">
@endif
<div class="container-fluid">
<div class="row">
<div class="col-md-3">

<div class="card card-primary card-outline">

    <div class="ribbon-wrapper ribbon-xl">
        <div class="ribbon bg-danger text-xl warningTerminasi">
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
<h5><span class="float-right badge bg-primary btn-block">{{ $klien->status }}</span></h5>
</ul>
</div>
<div class="card" style="margin-top:-30px; margin-bottom:0px">
    <div id="accordionKelengkapan" style="margin-bottom:-15px">
        <div class="card card-light">
        <div class="card-header {{ Request::get('kolom-kelengkapan') == 1 ? 'hightlighting' : '' }}">
        <h4 class="card-title w-100">
        <a class="d-block w-100" data-toggle="collapse" href="#collapseKelengkapan">
        <b>Kelengkapan Kasus (<span id="kelengkapan_kasus"></span>/6) </b>
        </a>
        </h4>
        </div>
        <div id="collapseKelengkapan" class="collapse {{ Request::get('kolom-kelengkapan') == 1 ? 'show' : '' }} {{ Request::get('kolom-kelengkapan') == 1 ? 'hightlighting' : '' }}" data-parent="#accordionKelengkapan">
        <div class="card-body">
            <ol style="padding:15px; margin :-25px 0px -20px 0px">
                <li>
                    Identifikasi <i class="fa fa-check" id="check_identifikasi"></i>
                    <ul style="margin-left: -25px">
                        <li>
                            Data Kasus (<span id="persen_title_data"></span>%) <i class="far fa-check-circle"></i>
                        </li>
                            <div class="progress progress-xs">
                                <div class="progress-bar bg-success progress-bar-striped" id="persen_data" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                        </li>
                        <li>
                            Persetujuan Supervisor <i class="far fa-check-circle" id="check_persetujuan_spv"></i>
                        </li>
                        <li>
                            Tanda Tangan SPP <i class="far fa-check-circle" id="check_ttd_spp"></i>
                        </li>
                    </ul>
                </li>
                <li>
                    Asesmen <i class="fa fa-check" id="check_asesmen"></i>
                </li>
                <li>
                    Perencanaan Layanan <i class="fa fa-check" id="check_perencanaan"></i>
                </li>
                <li>
                    Pelaksanaan Layanan  <i class="fa fa-check" id="check_pelaksanaan"></i>
                    <br>
                    (<span class="persen_title_layanan"></span>)
                    <div class="progress progress-xs">
                        <div class="progress-bar bg-success progress-bar-striped persen_layanan" role="progressbar" aria-valuemin="0">
                        </div>
                    </div>
                </li>
                <li>
                    Monitoring <i class="fa fa-check" id="check_monitoring"></i>
                </li>
                <li>
                    Terminasi <i class="fa fa-check" id="check_terminasi"></i>
                </li>
            </ol>
        </div>
        </div>
        </div>
    </div>
  </div>
</div>

<div class="card card-warning">
    <div class="card-header">
    <h3 class="card-title">Catatan Kasus</h3>
    <div class="card-tools">
        <button type="button" class="btn btn-tool" onclick="tambahCatatan()"><i class="nav-icon fas fa-edit"></i>
        </button>
        <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
        </button>
    </div>
    </div>
    
    <div class="card-body {{ Request::get('catatan-kasus') == 1 ? 'hightlighting' : '' }}" style="height: 150px; overflow-y:scroll;">
    <div id="kolomCatatan"></div>
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
        <a href="" class="btn-link text-secondary"><i class="far fa-fw fa-file"></i>No Kasus : {{ $kasus_terkait->no_reg }}</a>
        </li>
        <li>
        <a href="" class="btn-link text-secondary"><i class="fa fa-user-secret"></i> Terlapor :
            @php
                $no_terlapor = 1;
            @endphp
            @foreach ($kasus_terkait->terlapor as $item)
                {{ $no_terlapor }}. {{ $item }}
                @php $no_terlapor++ @endphp
            @endforeach 
        </a>
        </li>
        </ul>
    <hr>
    @foreach ($kasus_terkait as $item)
    <a href="#">
        <strong>{{ $item->no_klien }}</strong>
        <p class="text-muted">
            @php
            if($item->tanggal_lahir){
                $tanggal_lahir = Carbon\Carbon::parse($item->tanggal_lahir)->age;
            }else{
                $tanggal_lahir = 0;
            }
            @endphp
            {{ $item->nama }} ({{ $tanggal_lahir }})
            <br>
            @if ($item->jenis_kelamin == 'laki-laki')
                (Anak Laki-laki) 
            @elseif($tanggal_lahir >= 18)
                (Dewasa)
            @else
                (Anak Perempuan)
            @endif
        </p>
    </a>
    <hr>
    @endforeach
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
            <a class="nav-link {{ Request::get('tab') == 'kasus-petugas' ? 'active' : '' }}" id="kasus-petugas-tab" data-toggle="pill" href="#kasus-petugas" role="tab" aria-controls="kasus-petugas" aria-selected="false">Petugas @if(!($detail['kelengkapan_petugas']))<i class="fas fa-exclamation-circle" style="color: red; font-size:20px"></i>@endif</a>
        </li>
        <li class="nav-item">
        <a class="nav-link {{ Request::get('tab') == 'kasus-persetujuan' ? 'active' : '' }}" id="kasus-persetujuan-tab" data-toggle="pill" href="#kasus-persetujuan" role="tab" aria-controls="kasus-persetujuan" aria-selected="false">Persetujuan <i class="fas fa-exclamation-circle warningSPP" style="color: red; font-size:20px"></i></a>
        </li>
        <li class="nav-item">
        <a class="nav-link" id="kasus-log-tab" data-toggle="pill" href="#kasus-log" role="tab" aria-controls="kasus-log" aria-selected="false">Log Activity</a>
        </li>
        <li class="nav-item">
        <a class="nav-link {{ Request::get('tab') == 'settings' ? 'active' : '' }}" id="kasus-settings-tab" data-toggle="pill" href="#kasus-settings" role="tab" aria-controls="kasus-settings" aria-selected="false">Settings</a>
        </li>
        </ul>
        </div>
        <div class="card-body">
        <div class="tab-content" id="custom-tabs-one-tabContent">
        <div class="tab-pane fade show {{ Request::get('tab') == 'kasus' || Request::get('tab') == ''  ? 'active' : '' }}  {{ Request::get('hightlight') == 'formulir' ? 'hightlighting' : '' }}  {{ Request::get('kasus-all') == 1 ? 'hightlighting' : '' }}" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
        <div class="post warningTerminasi">
            <div class="card card-danger" style="transition: all 0.15s ease 0s; height: inherit; width: inherit;">
                <div class="card-header">
                <h3 class="card-title">Kasus Terminasi</h3>
                <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                </button>
                </div>
                </div>
                <div class="card-body" id="alasan_terminasi"></div>
            </div>
        </div>
            
            
        <div class="post clearfix" style="color:black">
            <style> input { width: 100%; }</style>
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
                    <tr id="nik_pelapor">
                        <td style="width: 200px">NIK</td>
                        <td>:</td>
                        <td><span class="data_pelapor">{{ $pelapor->nik }}</span> <input type="number" name="nik" value="{{ $pelapor->nik }}" class="input_pelapor"></td>
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
                            <select name="provinsi_id" class="input_pelapor select2bs4" id="provinsi_id_pelapor" onchange="getkotkab('pelapor')" style="width:100%">
                                <option value=""></option>
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
                                <option value=""></option>
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
                <tr id="nik_klien">
                    <td style="width: 200px">NIK</td>
                    <td>:</td>
                    <td><span class="data_klien">{{ $klien->nik }}</span> <input type="number" name="nik" value="{{ $klien->nik }}" class="input_klien"></td>
                </tr>
                <tr id="jenis_kelamin_klien">
                    <td style="width: 200px">Jenis Kelamin</td>
                    <td>:</td>
                    <td>
                        <span class="data_klien">{{ $klien->jenis_kelamin }}</span> 
                        <select name="jenis_kelamin" class="input_klien select2bs4" style="width: 100%;">
                            <option value="perempuan" {{ 'perempuan' == $klien->jenis_kelamin ? 'selected' : '' }}>Perempuan</option>
                            <option value="laki-laki" {{ 'laki-laki' == $klien->jenis_kelamin ? 'selected' : '' }}>Laki-laki</option>
                        </select>
                    </td>
                </tr>
                <tr id="nik_klien">
                    <td style="width: 200px">Kategori Kasus</td>
                    <td>:</td>
                    <td>xxx</td>
                </tr>
                <tr id="nik_klien">
                    <td style="width: 200px">Bentuk Kekerasan</td>
                    <td>:</td>
                    <td>xxx</td>
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
                        <select name="provinsi_id" class="input_klien select2bs4" id="provinsi_id_klien" onchange="getkotkab('klien')" style="width:100%">
                            <option value=""></option>
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
                            <option value=""></option>
                            @foreach ($pendidikan_terakhir as $item)
                                <option value="{{ $item }}" {{ $item == $klien->pendidikan ? 'selected' : '' }}>{{ $item }}</option>
                            @endforeach
                        </select>
                        (<span class="data_klien">{{ $klien->status_pendidikan }}</span> 
                        <select name="status_pendidikan" class="input_klien select2bs4" style="width: 100%;">
                            <option value=""></option>
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
                            <option value=""></option>
                            @foreach ($agama as $item)
                                <option value="{{ $item }}" {{ $item == $klien->agama ? 'selected' : '' }}>{{ $item }}</option>
                            @endforeach
                        </select> / 
                        <span class="data_klien">{{ $klien->suku }}</span> 
                        <select name="suku" class="input_klien select2bs4" style="width: 100%;">
                            <option value=""></option>
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
                            <option value=""></option>
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
        <div class="post clearfix" id="data_terlapor" style="color:black">
            <b>C. IDENTITAS TERLAPOR</b>
            <?php $no_terlapor = 1;?>
            @foreach ($terlapor as $item_terlapor)
            <br>
            <form action="{{ route('formpenerimapengaduan.update', 'uuid') }}" method="POST">
            @csrf
            @method('put')
            <input type="hidden" name="uuid" value="{{ $item_terlapor->uuid }}">
            <input type="hidden" name="data_update" value="terlapor">
            <b> Terlapor {{ $no_terlapor }}</b>
            <span style="float:right">
                <a class="btn btn-xs bg-gradient-warning" id="tombol_edit_terlapor{{ $no_terlapor }}" onclick="editdata('terlapor{{ $no_terlapor }}')">
                <i class="fas fa-edit"></i> Edit
                </a>
                <button type="submit" class="btn btn-xs bg-gradient-success tombol_save_terlapor" id="tombol_save_terlapor{{ $no_terlapor }}">
                <i class="fas fa-check"></i> Save
                </button>
            </span>
                <table class="table table-bottom table-sm">
                    <tr id="nama_terlapor{{ $no_terlapor }}">
                        <td style="width: 200px">Nama</td>
                        <td>:</td>
                        <td><span class="data_terlapor{{ $no_terlapor }}">{{ $item_terlapor->nama }}</span> <input type="text" name="nama" value="{{ $item_terlapor->nama }}" class="input_terlapor input_terlapor{{ $no_terlapor }}"></td>
                    </tr>
                    <tr id="nik_terlapor{{ $no_terlapor }}">
                        <td style="width: 200px">NIK</td>
                        <td>:</td>
                        <td><span class="data_terlapor{{ $no_terlapor }}">{{ $item_terlapor->nik }}</span> <input type="number" name="nik" value="{{ $item_terlapor->nik }}" class="input_terlapor input_terlapor{{ $no_terlapor }}"></td>
                    </tr>
                    <tr id="jenis_kelamin_terlapor{{ $no_terlapor }}">
                        <td style="width: 200px">Jenis Kelamin</td>
                        <td>:</td>
                        <td>
                            <span class="data_terlapor{{ $no_terlapor }}">{{ $item_terlapor->jenis_kelamin }}</span> 
                            <select name="jenis_kelamin" class="input_terlapor input_terlapor{{ $no_terlapor }} select2bs4" style="width: 100%;">
                                <option value="perempuan" {{ 'perempuan' == $item_terlapor->jenis_kelamin ? 'selected' : '' }}>Perempuan</option>
                                <option value="laki-laki" {{ 'laki-laki' == $item_terlapor->jenis_kelamin ? 'selected' : '' }}>Laki-laki</option>
                            </select>
                        </td>
                    </tr>
                    <tr id="tempat_tanggal_lahir_terlapor{{ $no_terlapor }}">
                        <td style="width: 200px">Tempat/Tgl Lahir</td>
                        <td>:</td>
                        <td>
                            <span class="data_terlapor{{ $no_terlapor }}" id="tempat_lahir_terlapor{{ $no_terlapor }}">{{ $item_terlapor->tempat_lahir }}</span> 
                            <input type="text" name="tempat_lahir" value="{{ $item_terlapor->tempat_lahir }}" class="input_terlapor input_terlapor{{ $no_terlapor }}">, 
                            <span class="data_terlapor{{ $no_terlapor }}">
                                {{ $item_terlapor->tanggal_lahir ? date('d M Y', strtotime($item_terlapor->tanggal_lahir)) : '' }} ({{ $item_terlapor->tanggal_lahir ? Carbon\Carbon::parse($item_terlapor->tanggal_lahir)->age.' tahun' : ' '}})
                            </span> 
                            <input type="date" name="tanggal_lahir" value="{{ $item_terlapor->tanggal_lahir }}" class="input_terlapor input_terlapor{{ $no_terlapor }}">
                        </td>
                    </tr>
                    <tr id="alamat_terlapor{{ $no_terlapor }}">
                        <td style="width: 200px">Alamat</td>
                    <td>:</td>
                    <td><span class="data_terlapor{{ $no_terlapor }}">{{ $item_terlapor->alamat }}</span> 
                        <input type="text" name="alamat" value="{{ $item_terlapor->alamat }}" class="input_terlapor input_terlapor{{ $no_terlapor }}">, 
                        <b>Provinsi</b> <span class="data_terlapor{{ $no_terlapor }}">{{ $item_terlapor->provinsi }}</span> 
                        <select name="provinsi_id" class="input_terlapor input_terlapor{{ $no_terlapor }} select2bs4" id="provinsi_id_terlapor{{ $no_terlapor }}" onchange="getkotkab('terlapor{{ $no_terlapor }}')" style="width:100%">
                            <option value=""></option>
                            @foreach ($provinsi as $item)
                                <option value="{{ $item->code }}" {{ $item->code == $item_terlapor->provinsi_id ? 'selected' : '' }}>{{ $item->name }}</option>
                            @endforeach
                        </select>,
                        <b>Kota</b> <span class="data_terlapor{{ $no_terlapor }}">{{ $item_terlapor->kota }}</span> 
                        <select name="kotkab_id" class="input_terlapor input_terlapor{{ $no_terlapor }} select2bs4" id="kota_id_terlapor{{ $no_terlapor }}" onchange="getkecamatan('terlapor{{ $no_terlapor }}')" style="width:100%">
                        </select>, 
                        <b>Kecamatan</b> <span class="data_terlapor{{ $no_terlapor }}">{{ $item_terlapor->kecamatan }}</span> 
                        <select name="kecamatan_id" class="input_terlapor input_terlapor{{ $no_terlapor }} select2bs4" id="kecamatan_id_terlapor{{ $no_terlapor }}" style="width:100%">
                            <option value="" selected></option>
                        </select>,
                        <b>Kelurahan</b> <span class="data_terlapor{{ $no_terlapor }}">{{ $item_terlapor->kelurahan }}</span> 
                        <input type="text" name="kelurahan" value="{{ $item_terlapor->kelurahan }}" class="input_terlapor input_terlapor{{ $no_terlapor }}"> 
                    </td>
                    </tr>
                    <tr id="pendidikan_terakhir_terlapor{{ $no_terlapor }}">
                        <td style="width: 200px">Pendidikan</td>
                        <td>:</td>
                        <td>
                            <span class="data_terlapor{{ $no_terlapor }}">{{ $item_terlapor->pendidikan }}</span> 
                            <select name="pendidikan" class="input_terlapor input_terlapor{{ $no_terlapor }} select2bs4" style="width: 100%;">
                                <option value=""></option>
                                @foreach ($pendidikan_terakhir as $item)
                                    <option value="{{ $item }}" {{ $item == $item_terlapor->pendidikan ? 'selected' : '' }}>{{ $item }}</option>
                                @endforeach
                            </select>
                            (<span class="data_terlapor{{ $no_terlapor }}">{{ $item_terlapor->status_pendidikan }}</span> 
                            <select name="status_pendidikan" class="input_terlapor input_terlapor{{ $no_terlapor }} select2bs4" style="width: 100%;">
                                <option value=""></option>
                                @foreach ($status_pendidikan as $item)
                                    <option value="{{ $item }}" {{ $item == $item_terlapor->status_pendidikan ? 'selected' : '' }}>{{ $item }}</option>
                                @endforeach
                            </select>
                            )
                        </td>
                    </tr>
                    <tr id="agama_terlapor{{ $no_terlapor }}">
                        <td style="width: 200px">Agama / Suku</td>
                    <td>:</td>
                    <td>
                        <span class="data_terlapor{{ $no_terlapor }}">{{ $item_terlapor->agama }}</span> 
                        <select name="agama" class="input_klien input_terlapor{{ $no_terlapor }} select2bs4" style="width: 100%;">
                            <option value=""></option>
                            @foreach ($agama as $item)
                                <option value="{{ $item }}" {{ $item == $item_terlapor->agama ? 'selected' : '' }}>{{ $item }}</option>
                            @endforeach
                        </select> / 
                        <span class="data_terlapor{{ $no_terlapor }}">{{ $klien->suku }}</span> 
                        <select name="suku" class="input_klien input_terlapor{{ $no_terlapor }} select2bs4" style="width: 100%;">
                            <option value=""></option>
                            @foreach ($suku as $item)
                                <option value="{{ $item }}" {{ $item == $item_terlapor->suku ? 'selected' : '' }}>{{ $item }}</option>
                            @endforeach
                        </select>
                    </td>
                    </tr>
                    <tr id="pekerjaan_terlapor{{ $no_terlapor }}">
                        <td style="width: 200px">Pekerjaan</td>
                        <td>:</td>
                        <td>
                            <span class="data_terlapor{{ $no_terlapor }}">{{ $item_terlapor->pekerjaan }}</span> 
                            <select name="pekerjaan" class="input_terlapor input_terlapor{{ $no_terlapor }} select2bs4" style="width: 100%;">
                                <option value=""></option>
                                @foreach ($pekerjaan as $item)
                                    <option value="{{ $item }}" {{ $item == $item_terlapor->pekerjaan ? 'selected' : '' }}>{{ $item }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr id="pengahsilan_terlapor{{ $no_terlapor }}">
                        <td style="width: 200px">Penghasilan Perbulan</td>
                        <td>:</td>
                        <td>Rp.<span class="data_terlapor{{ $no_terlapor }}">{{ $item_terlapor->penghasilan }}</span> <input type="number" name="penghasilan" value="{{ $item_terlapor->penghasilan }}" class="input_terlapor input_terlapor{{ $no_terlapor }}"></td>
                    </tr>
                    <tr id="status_kawin_terlapor{{ $no_terlapor }}">
                        <td style="width: 200px">Status Perkawinan</td>
                        <td>:</td>
                        <td>
                            <span class="data_terlapor{{ $no_terlapor }}">{{ $item_terlapor->status_kawin }}</span> 
                            <select name="status_kawin" class="input_terlapor input_terlapor{{ $no_terlapor }} select2bs4" style="width: 100%;">
                                <option value=""></option>
                                @foreach ($status_perkawinan as $item)
                                    <option value="{{ $item }}" {{ $item == $item_terlapor->status_kawin ? 'selected' : '' }}>{{ $item }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr id="jumlah_anak_terlapor{{ $no_terlapor }}">
                        <td style="width: 200px">Jumlah Anak</td>
                        <td>:</td>
                        <td><span class="data_terlapor{{ $no_terlapor }}">{{ $item_terlapor->jumlah_anak }}</span> <input type="number" name="jumlah_anak" value="{{ $item_terlapor->jumlah_anak }}" class="input_terlapor input_terlapor{{ $no_terlapor }}"></td>
                    </tr>
                    <tr id="hubungan_terlapor{{ $no_terlapor }}">
                        <td style="width: 200px">Hubungan dengan klien</td>
                        <td>:</td>
                        <td>
                            <span class="data_terlapor{{ $no_terlapor }}">{{ $item_terlapor->hubungan_terlapor }}</span> 
                            <select name="hubungan_terlapor" class="input_terlapor input_terlapor{{ $no_terlapor }} select2bs4" style="width: 100%;">
                                <option value=""></option>
                                @foreach ($hubungan_dengan_klien as $item)
                                    <option value="{{ $item }}" {{ $item == $item_terlapor->hubungan_terlapor ? 'selected' : '' }}>{{ $item }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr id="masa_hukuman_terlapor{{ $no_terlapor }}">
                        <td style="width: 200px">Masa Hukuman</td>
                        <td>:</td>
                        <td><span class="data_terlapor{{ $no_terlapor }}">{{ $item_terlapor->masa_hukuman }}</span> <input type="text" name="masa_hukuman" value="{{ $item_terlapor->masa_hukuman }}" class="input_terlapor input_terlapor{{ $no_terlapor }}"></td>
                    </tr>
                    <tr id="denda_hukuman_terlapor{{ $no_terlapor }}">
                        <td style="width: 200px">Denda</td>
                        <td>:</td>
                        <td>Rp. <span class="data_terlapor{{ $no_terlapor }}">{{ $item_terlapor->denda_hukuman }}</span> <input type="number" name="denda_hukuman" value="{{ $item_terlapor->denda_hukuman }}" class="input_terlapor input_terlapor{{ $no_terlapor }}"></td>
                    </tr>
                </table>
                </form>
                <script>
                    $(document).ready(function () {
                        getkotkab('terlapor{{ $no_terlapor }}');
                    });
                </script>
                <?php $no_terlapor++;?>
            @endforeach
        </div>
        <div class="post clearfix" style="color:black">
            <b>D. KASUS KLIEN</b>
            <form action="{{ route('formpenerimapengaduan.update', 'uuid') }}" method="POST">
            @csrf
            @method('put')
            <input type="hidden" name="uuid" value="{{ $kasus->uuid }}">
            <input type="hidden" name="data_update" value="kasus">
            <span style="float:right">
                <a class="btn btn-xs bg-gradient-warning" id="tombol_edit_kasus" onclick="editdata('kasus')">
                <i class="fas fa-edit"></i> Edit
                </a>
                <button type="submit" class="btn btn-xs bg-gradient-success" id="tombol_save_kasus">
                <i class="fas fa-check"></i> Save
                </button>
            </span>
            <table class="table table-bottom table-sm">
                <tr id="tanggal_kejadian_kasus">
                    <td style="width: 200px">Tanggal Kejadian</td>
                    <td>:</td>
                    <td>
                        <span class="data_kasus">
                            {{ $kasus->tanggal_kejadian ? date('d M Y', strtotime($kasus->tanggal_kejadian)) : '' }}
                        </span> 
                        <input type="date" name="tanggal_kejadian" value="{{ $kasus->tanggal_kejadian }}" class="input_kasus">
                    </td>
                </tr>
                <tr id="tempat_kejadian_kasus">
                    <td style="width: 200px">Kategori Lokasi</td>
                    <td>:</td>
                    <td>
                        <span class="data_kasus">{{ $kasus->tempat_kejadian }}</span> 
                        <select name="tempat_kejadian" class="input_kasus select2bs4" style="width: 100%;">
                            <option value=""></option>
                            @foreach ($tempat_kejadian as $item_tempat_kejadian)
                                <option value="{{ $item_tempat_kejadian }}" {{ $item_tempat_kejadian == $kasus->tempat_kejadian ? 'selected' : '' }}>{{ $item_tempat_kejadian }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr id="media_pengaduan_kasus">
                    <td style="width: 200px">Media Pengaduan</td>
                    <td>:</td>
                    <td>
                        <span class="data_kasus">{{ $kasus->media_pengaduan }}</span> 
                        <select name="media_pengaduan" class="input_kasus select2bs4" style="width: 100%;">
                            <option value=""></option>
                            @foreach ($media_pengaduan as $item_media_pengaduan)
                                <option value="{{ $item_media_pengaduan }}" {{ $item_media_pengaduan == $kasus->media_pengaduan ? 'selected' : '' }}>{{ $item_media_pengaduan }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr id="sumber_rujukan_kasus">
                    <td style="width: 200px">Sumber Rujukan</td>
                    <td>:</td>
                    <td>
                        <span class="data_kasus">{{ $kasus->sumber_rujukan }}</span> 
                        <select name="sumber_rujukan" class="input_kasus select2bs4" style="width: 100%;">
                            <option value=""></option>
                            @foreach ($sumber_rujukan as $item_sumber_rujukan)
                                <option value="{{ $item_sumber_rujukan }}" {{ $item_sumber_rujukan == $kasus->sumber_rujukan ? 'selected' : '' }}>{{ $item_sumber_rujukan }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr id="sumber_informasi_kasus">
                    <td style="width: 200px">Sumber Informasi</td>
                    <td>:</td>
                    <td>
                        <span class="data_kasus">{{ $kasus->sumber_informasi }}</span> 
                        <select name="sumber_informasi" class="input_kasus select2bs4" style="width: 100%;">
                            <option value=""></option>
                            @foreach ($sumber_informasi as $item_sumber_informasi)
                                <option value="{{ $item_sumber_informasi }}" {{ $item_sumber_informasi == $kasus->sumber_informasi ? 'selected' : '' }}>{{ $item_sumber_informasi }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr id="deskripsi_kasus">
                    <td style="width: 200px">Deskripsi</td>
                    <td>:</td>
                    <td><span class="data_kasus">{{ $kasus->deskripsi }}</span> <textarea name="deskripsi" class="input_kasus" style="width:100%" rows="10">{{ $kasus->deskripsi }}</textarea></td>
                </tr>
                <tr id="alamat_kasus">
                    <td style="width: 200px">Alamat</td>
                    <td>:</td>
                    <td>
                        <span class="data_kasus">{{ $kasus->alamat }}</span> 
                        <input type="text" name="alamat" value="{{ $kasus->alamat }}" class="input_kasus">, 
                        <b>Provinsi</b> <span class="data_kasus">{{ $kasus->provinsi }}</span> 
                        <select name="provinsi_id" class="input_kasus select2bs4" id="provinsi_id_kasus" onchange="getkotkab('kasus')" style="width:100%">
                            @foreach ($provinsi as $item)
                                <option value="{{ $item->code }}" {{ $item->code == $kasus->provinsi_id ? 'selected' : '' }}>{{ $item->name }}</option>
                            @endforeach
                        </select>,
                        <b>Kota</b> <span class="data_kasus">{{ $kasus->kota }}</span> 
                        <select name="kotkab_id" class="input_kasus select2bs4" id="kota_id_kasus" onchange="getkecamatan('kasus')" style="width:100%">
                        </select>, 
                        <b>Kecamatan</b> <span class="data_kasus">{{ $kasus->kecamatan }}</span> 
                        <select name="kecamatan_id" class="input_kasus select2bs4" id="kecamatan_id_kasus" style="width:100%">
                            <option value="" selected></option>
                        </select>,
                        <b>Kelurahan</b> <span class="data_kasus">{{ $kasus->kelurahan }}</span> 
                        <input type="text" name="kelurahan" value="{{ $kasus->kelurahan }}" class="input_kasus"> 
                    </td>
                </tr>
            </table>
            </form>
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
        <button type="button" class="btn btn-block btn-primary"><i class="fas fa-print"></i> Print Formulir</button>
        <br>
        <div id="kolomPublicUrl"></div>
        <button type="button" class="btn btn-block btn-primary" onclick="submitPublicURL('url-kasus')"><i class="fas fa-link"></i> Generate URL</button>
        </div>
        <div class="tab-pane {{ Request::get('tab') == 'kasus-asesmen' ? 'active' : '' }}" id="kasus-asesmen" role="tabpanel" aria-labelledby="kasus-asesmen-tab">
            
        <div class="post clearfix" style="margin: 0px">
            <b>RIWAYAT KEJADIAN</b>
            </br>
            </br>
            <div style="overflow-x: scroll">
            <input type="hidden" id="uuid_riwayat_hightlight" value="{{ Request::get('row-riwayat') }}">
            <table id="tabelRiwayat" class="table table-sm table-bordered table-hover" style="cursor:pointer; color:black">
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
            <div class="col-md-12 warningSPP">
                <div class="alert alert-danger">
                <h5><i class="fas fa-exclamation-circle"></i> Perhatian!</h5>
                Surat Persetujuan Pelayanan perlu ditanda tangani terlebih dahulu sebelum menambahkan asesmen.
                </div>
            </div>
            <div class="col-md-12 warningAsesmen">
                <div class="alert alert-danger">
                <h5><i class="fas fa-exclamation-circle"></i> Perhatian!</h5>
                Segera inputkan data asesmen pada MOKA.
                </div>
            </div>
            <div id="kolomAsesmen"></div>
            @if (in_array(Auth::user()->jabatan, ['Manajer Kasus', 'Penerima Pengaduan', 'Unit Reaksi Cepat']))
            <button type="buttons" class="btn btn-block btn-default {{ Request::get('tambah-asesmen') == 1 ? 'hightlighting' : '' }}" id="modalAsesmen" data-toggle="modal" data-target="#tambahAsesmenModal"><i class="fas fa-plus"></i> Tambah Asesmen</button>
            @endif
        </div>

    </div>
    
    <div class="tab-pane {{ Request::get('tab') == 'kasus-layanan' ? 'active' : '' }}" id="kasus-layanan" role="tabpanel" aria-labelledby="kasus-layanan-tab">
        <div class="post clearfix" style="margin: 0px">
        <b id="anchor_pelaporan">PROGRES LAYANAN</b>
        <div class="progress" style="height: 25px;">
            <div class="progress-bar bg-success persen_layanan" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"> <span style="font-size:30px" class="persen_title_layanan">100%</span></div>
        </div>
        <br>
        <div style="overflow-x: scroll">
            <input type="hidden" id="uuid_layanan_hightlight" value="{{ Request::get('row-layanan') }}">
            <table id="tabelLayanan" class="table table-sm table-bordered  table-hover" style="cursor:pointer; color:black">
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
        <br>
        @if (Auth::user()->jabatan == 'Manajer Kasus')
        <div id="kolomMonitoring"></div>
        <button type="submit" class="btn btn-block btn-default" data-toggle="modal" data-target="#tambahMonitoringModal"><i class="fas fa-plus"></i> Tambah Laporan Monitoring</button>
        @endif
    </div>
    </div>
    <div class="tab-pane {{ Request::get('tab') == 'kasus-petugas' ? 'active' : '' }}" id="kasus-petugas" role="tabpanel" aria-labelledby="kasus-petugas-tab">
        <b id="anchor_petugas">PETUGAS PADA KASUS</b>
            
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
                            @if (in_array(Auth::user()->jabatan, ['Manajer Kasus', 'Penerima Pengaduan']))
                            <form action="{{ route('petugas.destroy',$item->id) }}" method="post">
                                @csrf 
                                @method('delete')
                                <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            <br>
            @if (in_array(Auth::user()->jabatan, ['Manajer Kasus', 'Penerima Pengaduan']))
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
        <b id="anchor_persetujuan">SURAT-SURAT PERSETUJUAN PADA KASUS</b>
        <div class="row warningSPP">
            <div class="col-md-12">
                <div class="alert alert-danger">
                <h5><i class="fas fa-exclamation-circle"></i> Perhatian!</h5>
                Belum ada tanda tangan pada Surat Persetujuan Pelayanan. Silahkan buat link dan berikan pada klien / wali.
                </div>
            </div>
        </div>
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


        <div class="tab-pane fade" id="kasus-log" role="tabpanel" aria-labelledby="kasus-log-tab">
            <div class="post clearfix" style="margin: 0px">
                <b>LOG ACTIVITY</b>
                </br>
                </br>
                <div style="overflow-x: scroll">
                <table id="tabelLogActivity" class="table table-sm table-bordered" style="cursor:pointer; color:#fff;background-color:black">
                    <thead>
                    <tr>
                    <th>Waktu</th>
                    <th>Activity</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                </div>
            </div>
        </div>
        <div class="tab-pane {{ Request::get('tab') == 'settings' ? 'active' : '' }}" id="kasus-settings" role="tabpanel" aria-labelledby="kasus-settings-tab">
        <b id="anchor_setting">SETTINGS KASUS</b>
        <table class="table table-bottom table-sm">
                <tr>
                    <td style="width: 200px"><b>Arsipkan Kasus<b></td>
                    <td>
                        <input type="checkbox" name="arsipkan" class="btn-sm" 
                        checked 
                        data-bootstrap-switch 
                        data-on-text="Aktif"
                        data-off-text="Diarsipkan"
                        data-off-color="danger" 
                        data-on-color="success">
                        <br>
                        <span>Status kasus saat ini sedang aktif, akan muncul di pencarian kasus</span>
                    </td>
                </tr>
                <tr class="{{ Request::get('persetujuan-supervisor') == 1 ? 'hightlighting' : '' }}">
                    <td style="width: 200px"><b>Approval<b></td>
                    <td>
                        <div class="row">
                            <div class="col-md-12 {{ Request::get('hightlight') == 'inputpersetujuankasus' ? 'hightlighting' : '' }}">
                                Apakah anda ingin menyetujui kasus ini?
                            </div>
                                @if (!$klien->no_klien)
                                {{-- jika tidak ada no klien berarti belum diapprove / ditolak --}}
                                    @if(in_array(Auth::user()->jabatan, ['Supervisor Kasus']))
                                        @if(!($detail['kelengkapan_petugas']))
                                            <div class="col-md-12">
                                                <div class="alert alert-danger">
                                                Petugas Penerima Pengaduan belum melengkapi kelengkapan kasus. Minimal harus ada 1 Supervisor, 1 Manajer Kasus dan 1 Petugas Penerima Pengaduan.
                                                </div>
                                            </div>
                                        @else
                                            {{-- jika no kliennya masih null artinya belum diterima / tolak  --}}
                                            <div class="col-md-6">
                                                <form action="{{ route('kasus.approval', $klien->uuid) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name='approval' value="1">
                                                <button type="submit" class="btn btn-block btn-success btn-sm"><i class="fas fa-check"></i> Ya dan buat nomor regis klien</button>
                                                </form>
                                            </div>
                                            <div class="col-md-6">
                                                <form action="{{ route('kasus.approval', $klien->uuid) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name='approval' value="0">
                                                <button type="submit" class="btn btn-block btn-danger btn-sm"><i class="fas fa-times"></i> Tidak dan minta MK untuk terminasi</button>
                                                </form>
                                            </div>
                                        @endif
                                    @endif

                                @elseif($klien->no_klien != '[REJECTED]')
                                    <div class="col-md-12">
                                        Ya, kasus telah disetujui oleh Supervisor
                                    </div>
                                @else
                                    <div class="col-md-12">
                                        Tidak, kasus tidak disetujui oleh Supervisor
                                    </div>
                                @endif
                        </div>
                    </td>
                </tr>
                <tr class="{{ Request::get('kolom-terminasi') == 1 ? 'hightlighting' : '' }}">
                    <td style="width: 200px"><b>Terminasi Kasus<b></td>
                    <td>
                        <div id="kolomTerminasi"></div>
                        @if (in_array(Auth::user()->jabatan, ['Manajer Kasus']))
                            <div id="accordionTerminasi">
                                <div class="card card-danger">
                                <div class="card-header">
                                <h4 class="card-title w-100">
                                <a class="d-block w-100" data-toggle="collapse" href="#collapseTerminasi">
                                Ajukan Terminasi
                                </a>
                                </h4>
                                </div>
                                <div id="collapseTerminasi" class="collapse {{ Request::get('hightlight') == 'inputpersetujuankasus' ? 'show' : '' }}" data-parent="#accordionTerminasi" style="">
                                <div class="card-body">
                                    <div class="alert alert-danger alert-dismissible invalid-feedback" id="error-message-terminasi">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <h4><i class="icon fa fa-ban"></i> Gagal!</h4>
                                        <span id="message-terminasi"></span>
                                    </div>
                                    <div class="alert alert-success alert-dismissible invalid-feedback" id="success-message-terminasi">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <h4><i class="icon fa fa-check"></i> Success!</h4>
                                        Data berhasil disimpan.
                                    </div>
                                    <div class="form-group clearfix">
                                        <div class="icheck-primary d-inline" style="margin-right:15px">
                                        <input type="radio" id="radioPrimary1" name="jenis_terminasi" checked value="selesai">
                                        <label for="radioPrimary1">
                                            Terminasi Kasus Selesai
                                        </label>
                                        </div>
                                        <div class="icheck-primary d-inline">
                                        <input type="radio" id="radioPrimary2" name="jenis_terminasi" value="ditutup">
                                        <label for="radioPrimary2">
                                            Terminasi Kasus Ditutup
                                        </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Alasan Terminasi </label>
                                        <textarea class="form-control required-field-terminasi" id="terminasi_alasan" aria-label="With textarea" style="resize: none;" rows="5"></textarea>
                                    </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-block btn-danger" id="submitTerminasi"><i class="fas fa-times"></i> Terminasi Kasus</button>
                                    </div>
                                </div>
                                </div>
                                </div>
                                </div>
                            </div>
                        @endif
                    </td>
                </tr>
            </table>
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
        <input type="hidden" id="uuid_asesmen">
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

<!-- Modal Tambah Monitoring-->
<div class="modal fade" id="tambahMonitoringModal" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">

        <div id="overlay" class="overlay dark">
            <div class="cv-spinner">
            <span class="spinner"></span>
            </div>
        </div>
        
        <div class="modal-header">
            <h5 class="modal-title" id="modelHeadingMonitoring">Monitoring</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="alert alert-danger alert-dismissible invalid-feedback" id="error-message-monitoring">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-ban"></i> Gagal!</h4>
            <span id="message-monitoring"></span>
        </div>
        <div class="alert alert-success alert-dismissible invalid-feedback" id="success-message-monitoring">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Success!</h4>
            Data berhasil disimpan.
        </div>
        <div class="modal-body">
        <input type="hidden" id="uuid_monitoring">
        <div class="col-md-12">
            <div class="form-group">
            <label>Kemajuan yang Dicapai / Kondisi Klien Saat Monitoring : </label>
                <textarea class="form-control required-field-monitoring" id="monitoring_kemajuan" aria-label="With textarea" style="resize: none;" ></textarea>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
            <label>Tujuan yang Belum Tercapai : </label>
                <textarea class="form-control required-field-monitoring" id="monitoring_tujuan" aria-label="With textarea" style="resize: none;"></textarea>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
            <label>Rencana Tindak Lanjut : </label>
                <textarea class="form-control required-field-monitoring" id="monitoring_rencana" aria-label="With textarea" style="resize: none;"></textarea>
            </div>
        </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success btn-block" id="submitMonitoring"><i class="fa fa-check"></i> Simpan</button>
            <button type="button" class="btn btn-danger btn-block" id="deleteMonitoring"><i class="fa fa-trash"></i> Hapus</button>
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
            <h4 class="modal-title">Persetujuan</h4>
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
                      <iframe class="embed-responsive-item" id="showPersetujuan" src="about:blank" style="width: 100%; height:1000px"></iframe>
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


<!-- Modal Catatan-->
<div class="modal fade" id="tambahCatatanModal" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

        <div id="overlay" class="overlay dark">
            <div class="cv-spinner">
            <span class="spinner"></span>
            </div>
        </div>
        
        <div class="modal-header">
            <h5 class="modal-title" id="modelHeadingCatatan">Catatan Kasus</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="alert alert-danger alert-dismissible invalid-feedback" id="error-message-catatan">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-ban"></i> Gagal!</h4>
            <span id="message-catatan"></span>
        </div>
        <div class="alert alert-success alert-dismissible invalid-feedback" id="success-message-catatan">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Success!</h4>
            Data berhasil disimpan.
        </div>
        <div class="modal-body">
        <input type="hidden" id="uuid_catatan">
        <div class="col-md-12">
            <div class="form-group">
            <label>Isi Catatan : </label>
                <textarea class="form-control required-field-catatan" id="catatan_kasus" aria-label="With textarea" style="resize: none;" rows="5"></textarea>
            </div>
        </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success btn-block" id="submitCatatan"><i class="fa fa-check"></i> Simpan</button>
            <button type="button" class="btn btn-danger btn-block" id="deleteCatatan"><i class="fa fa-trash"></i> Hapus</button>
        </div>
        </div>
    </div>
</div>

<!-- Modal Dokumen -->
<div class="modal fade" id="dokumenModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
  
        <div id="overlay" class="overlay dark">
          <div class="cv-spinner">
            <span class="spinner"></span>
          </div>
        </div>
        
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-card">
            <div class="form-group">
  
              <body data-editor="DecoupledDocumentEditor" data-collaboration="false">
                <div id="mytoolbar" style="width: 1000px"></div>
                <main>
                  <div class="centered">
                    <div class="row-editor">
                      <textarea name="konten" readonly class="textarea-replace editor textarea-tinymce" id="konten">
                      </textarea>
                    </div>
                  </div>
                </main>
              </body>
            </div>
          </div>
        </div>
        <div class="modal-footer" id="buttonsDokumen">
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
<script src="https://cdn.rawgit.com/ashl1/datatables-rowsgroup/fbd569b8768155c7a9a62568e66a64115887d7d0/dataTables.rowsGroup.js"></script>
<script src="{{ asset('adminlte') }}/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script src="{{ asset('vendor/tinymce4/tinymce.min.js') }}"></script>
<script>
    $(document).ready(function () {
        getkotkab('pelapor');
        getkotkab('klien');
        getkotkab('kasus');
        hightlighting();
        loadAsesmen();
        loadMonitoring();
        loadTerminasi();
        loadCatatan();
        loadPublicUrl();
        check_kelengkapan_data('{{ $klien->id }}');
        check_kelengkapan_persetujuan_spv('{{ $klien->id }}');
        check_kelengkapan_spp('{{ $klien->id }}');
        check_kelengkapan_asesmen('{{ $klien->id }}');
        check_kelengkapan_perencanaan('{{ $klien->id }}');
        check_kelengkapan_monitoring('{{ $klien->id }}');
        check_kelengkapan_terminasi('{{ $klien->id }}');
        kelengkapan_kasus = 0;
        kelengkapan_identifikasi = 0;
        $('#kelengkapan_kasus').html(kelengkapan_kasus);

        $("input[data-bootstrap-switch]").each(function(){
        $(this).bootstrapSwitch('state', $(this).prop('checked'));
        })

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
    $('.input_kasus').next(".select2-container").hide();
    $('.input_terlapor').next(".select2-container").hide();

    $('#tabelLayanan').DataTable({
      "ordering": false,
      "processing": true,
      "serverSide": true,
      "responsive": false, 
      "lengthChange": false, 
      "autoWidth": false,
      "ajax": "/agenda/api_index?uuid={{ $klien->uuid }}",
      "rowsGroup": [1],
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
                return row.tanggal_mulai_formatted+"<br><span style='font-size:13px'>"+jam_mulai+"</span>";
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
                    uuid_dokumen = row.uuid_dokumen;
                    var array2 = uuid_dokumen.split(",|");

                    dokumen = row.judul;
                    dokumens = '';
                    var array = dokumen.split(",|");
                    for (i=1;i<array.length;i++){
                    string = array2[i];
                    uuid_dokumen = string.replace(/,/g, "");
                    dokumens += '<a href="#" onclick="showModalDokumen(`'+uuid_dokumen+'`)"><span class="badge bg-primary"><i class="nav-icon fas fa-file-alt"></i> '+array[i]+'</span></a> ';
                    };
                }else{
                    dokumens = '';
                }

                if (row.terlaksana) {
                    return 'Petugas : '+row.petugas+' ('+row.jabatan+')<br>'+lokasi+'<br>'+catatan+dokumens;
                } else {
                    return '<span class="badge bg-danger">Dibatalkan</span>';
                }
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
                if (row.created_by == {{ Auth::user()->id }}) {
                    return '<div  class="icheck-primary d-inline ml-2"><input class="checkboxSelesai '+selesaiLayanan+'" type="checkbox" value="" id="todoCheck'+row.uuid+'" '+checked+' '+disabled+' onclick="showModalAgenda(`'+row.tanggal_mulai+'`,`'+row.uuid+'`)"><label for="todoCheck'+row.uuid+'"></label></div>';
                } else {
                    return '<div  class="icheck-primary d-inline ml-2" onclick="alert(`Anda tidak memiliki hak akses untuk menginputkan laproan tindak lanjut untuk agenda ini. Minta seseorang yang ada di agenda untuk mentag/menambahkan anda.`)"><input type="checkbox" value=""><label for="todoCheck'+row.uuid+'"></label></div>';
                }
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
                    showModalAgenda("{{ date('Y-m-d') }}",0);
                  }
              }]
      }).buttons().container().appendTo('#tabelLayanan_wrapper .col-md-6:eq(0)');

      $('#tabelLayanan_filter').css({'float':'right','display':'inline-block; background-color:black'});
    });

    $('#tabelLayanan tbody').on('click', 'tr', function () {
      $("#success-message").hide();
      $("#error-message").hide();
    });

    function showModalDokumen(uuid) { 
        $.ajax({
          url:'/dokumen/show/'+uuid,
          type:'GET',
          dataType: 'json',
          success: function( response ) {
            $("#overlay").hide();
            tinymce.activeEditor.setContent(JSON.parse(response.konten));
            $('#dokumenModal').modal('show');
            //munculkan tombol
            $('#buttonsDokumen').html('');
            $('#buttonsDokumen').append('<button type="button" class="btn btn-primary btn-block" id="detail" onclick="saveAndPrint()"><i class="fas fa-print"></i> Print Dokumen</button>');
            // $('#buttons').append('<button type="button" onclick="window.location.assign(`'+"{{route('dokumen.edit', '')}}"+"/"+data.uuid+'`)" class="btn btn-warning btn-block" id="terima"><i class="fas fa-edit"></i> Edit Dokumen</button>');
            // $('#buttonsDokumen').append('<button type="button" onclick="hapus(`'+data.uuid+'`)" class="btn btn-danger btn-block" id="hapus"><i class="fa fa-trash"></i> Hapus Dokumen</button>');
            }
        });
    };

    tinymce.init({
        selector: ".textarea-tinymce",
        toolbar: '#mytoolbar',
        lineheight_formats: "8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 20pt 22pt 24pt 26pt 36pt",
        // ukuran A4 Potrait
        height: "500",
        readonly: 1,
        menubar: false,
        toolbar: false,
        plugins: 'textcolor table paste',
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern"
        ],
        visual: false,
        toolbar: "saveandprint",
        convert_fonts_to_spans: true,
        paste_word_valid_elements: "b,strong,i,em,h1,h2,u,p,ol,ul,li,a[href],span,color,font-size,font-color,font-family,mark,table,tr,td",
        paste_retain_style_properties: "all",
        automatic_uploads: true,
        image_advtab: true,
        file_picker_types: 'image',
        paste_data_images: true,
        relative_urls: false,
        remove_script_host: false,
        file_picker_callback: function(cb, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');
            input.onchange = function() {
                var file = this.files[0];
                var reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function() {
                    var id = 'post-image-' + (new Date()).getTime();
                    var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                    var blobInfo = blobCache.create(id, file, reader.result);
                    blobCache.add(blobInfo);
                    cb(blobInfo.blobUri(), {
                        title: file.name
                    });
                };
            };
            input.click();
        }
    });

    function saveAndPrint() {
        tinymce.activeEditor.execCommand('mcePrint');
    }


    $(function () {

    $('#tabelLogActivity').DataTable({
      "ordering": true,
      "processing": true,
      "serverSide": true,
      "responsive": false, 
      "lengthChange": false, 
      "autoWidth": false,
      "ajax": "/logactivity/index?uuid={{ $klien->uuid }}",
      "columns": [
        {
            "mData": "tanggal",
            "width": "20%",
            "mRender": function (data, type, row) {
                return "<span style='font-size:14px'>"+row.tanggal_formatted+", "+row.jam_formatted+"</span>";
            }
        },
        {
            "mData": "message",
            "mRender": function (data, type, row) {
              return row.message;
            }
        }
      ],
      "pageLength": 10,
      "lengthMenu": [
          [10, 25, 50, 100, -1],
          ['10 rows', '25 rows', '50 rows', '100 rows','All'],
      ],
      "dom": 'Blfrtip', // Blfrtip or Bfrtip
      "buttons": ["pageLength", "copy", "csv", "excel", "pdf", "print"]
      }).buttons().container().appendTo('#tabelRiwayat_wrapper .col-md-6:eq(0)');

      $('#tabelLogActivity_filter').css({'float':'right','display':'inline-block; background-color:black'});
    

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
                return row.tanggal_formatted+"<br><span style='font-size:13px'>"+row.jam+"</span>";
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
      if (confirm("Apakah anda yakin ingin menghapus riwayat kejadian ini?") == true) {
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
    }
    });

    function loadAsesmen() {
        $('#deleteAsesmen').hide();
        $.ajax({
            url: `/asesmen/index?uuid={{ $klien->uuid }}`,
            type: "GET",
            cache: false,
            success: function (response){
                data = response.data;
                $('#kolomAsesmen').html('');
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
                    check_kelengkapan_asesmen('{{ $klien->id }}');
                    loadnotif();

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

    function loadMonitoring() {
        $('#deleteMonitoring').hide();
        $.ajax({
            url: `/monitoring/index?uuid={{ $klien->uuid }}`,
            type: "GET",
            cache: false,
            success: function (response){
                $('#kolomMonitoring').html('');
                
                data = response.data;
                i=1;
                data.forEach(e => {
                    $('#kolomMonitoring').prepend('<div class=\"card collapsed-card target\"> <div class=\"card-header\" data-card-widget=\"collapse\" style=\"cursor: pointer;\"> <h3 class=\"card-title\"><b>Monitoring tanggal '+e.created_at_formatted+' oleh '+e.petugas+' ('+e.jabatan+')</b></h3> <div class=\"card-tools\"> <button type=\"button\" class=\"btn btn-tool\"><i class=\"fa fa-chevron-down\"></i> </button> </div> </div> <div class=\"card-body\"> <div class=\"col-md-12\"> <div class=\"form-group\"> <label>Kemajuan yang Dicapai / Kondisi Klien Saat Monitoring : </label> <textarea readonly class=\"form-control\" style=\"resize: none;\" >'+e.kemajuan+'</textarea> </div> </div> <div class=\"col-md-12\"> <div class=\"form-group\"> <label>Tujuan yang Belum Tercapai : </label> <textarea readonly class=\"form-control\" style=\"resize: none;\">'+e.tujuan+'</textarea> </div> </div> <div class=\"col-md-12\"> <div class=\"form-group\"> <label>Rencana Tindak Lanjut : </label> <textarea readonly class=\"form-control\" style=\"resize: none;\">'+e.rencana+'</textarea> </div> </div> </div> </div>');
                    i++;
                });
            },
            error: function (response){
                console.log(response);
            }
            });
    }

    $('#submitMonitoring').click(function() {
        if(validateForm('monitoring')){
            let token   = $("meta[name='csrf-token']").attr("content");
            $.ajax({
            url: `/monitoring/store/`,
            type: "POST",
            cache: false,
            data: {
                uuid: $('#uuid_monitoring').val(),
                uuid_klien: '{{ $klien->uuid }}',
                kemajuan: $("#monitoring_kemajuan").val(),
                tujuan: $("#monitoring_tujuan").val(),
                rencana: $("#monitoring_rencana").val(),
                _token: token
            },
            success: function (response){
                if (response.success != true) {
                    $('#message-monitoring').html(JSON.stringify(response));
                    $("#success-message-monitoring").hide();
                    $("#error-message-monitoring").show();
                }else{
                    $('#message-monitoring').html(response.message);
                    $("#success-message-monitoring").show();
                    $("#error-message-monitoring").hide();
                    loadMonitoring();

                    // hapus semua inputan
                    $('#uuid_monitoring').val('');
                    $("#monitoring_kemajuan").val('');
                    $("#monitoring_tujuan").val('');
                    $("#monitoring_rencana").val('');
                    $('#tambahMonitoringModal').scrollTop(0);
                }
            },
            error: function (response){
                setTimeout(function(){
                $("#overlay").fadeOut(300);
                },500);
                console.log(response);

                $('#message-monitoring').html(JSON.stringify(response));
                $("#success-message-monitoring").hide();
                $("#error-message-monitoring").show();
            }
            }).done(function() { //loading submit form
                setTimeout(function(){
                $("#overlay").fadeOut(300);
                },500);
            });
        }else{
            $('#message-monitoring').html('Mohon cek ulang data yang wajib diinput.');
            $("#success-message-monitoring").hide();
            $("#error-message-monitoring").show();
        }
    });

    function loadTerminasi() {
        $.ajax({
            url: `/terminasi/index?uuid={{ $klien->uuid }}`,
            type: "GET",
            cache: false,
            success: function (response){
                $('#kolomTerminasi').html('');
                
                data = response.data;
                i=1;
                data.forEach(e => {
                    if (!e.validated_by && !e.alasan_approve) {
                        // jika validated_by & alasan_approve kosong maka tombol approval
                        if ('{{ Auth::user()->jabatan }}' == 'Supervisor Kasus') {
                            kolomapproval = '<div class=\"row\"> <div class=\"col-md-6\"> <button type=\"button\" class=\"btn btn-block btn-success btn-sm\" onclick=\"approveTerminasi(`'+e.uuid+'`,1)\"><i class=\"fas fa-check\"></i> Ya setuju terminasi</button> </div> <div class=\"col-md-6\"> <button type=\"button\" class=\"btn btn-block btn-danger btn-sm\" onclick=\"approveTerminasi(`'+e.uuid+'`,0)\"><i class=\"fas fa-times\"></i> Tidak setuju terminasi</button> </div></div>';
                        }else{
                            kolomapproval = '<div class=\"row\"> Terminasi belum disetujui. Menunggu persetujuan Supervisor Kasus </div>';
                        }
                    } else if (e.validated_by) {
                        // jika adavalidasinya berarti sudah diapprove
                        kolomapproval = '<div class=\"col-md-12\"> <div class=\"form-group\"> <label>Catatan Supervisor : </label> <textarea readonly class=\"form-control\" style=\"resize: none;\">Kasus disetujui untuk terminasi</textarea> </div> </div> ';
                    } else {
                        // else ditolak
                        kolomapproval = '<div class=\"col-md-12\"> <div class=\"form-group\"> <label>Catatan Supervisor : </label> <textarea readonly class=\"form-control\" style=\"resize: none;\">'+e.alasan_approve+'</textarea> </div> </div> ';
                    }
                    $('#kolomTerminasi').prepend('<div class=\"card collapsed-card target\"> <div class=\"card-header\" data-card-widget=\"collapse\" style=\"cursor: pointer;\"> <h3 class=\"card-title\"><b>Pengajuan Terminasi tanggal '+e.created_at_formatted+' oleh '+e.petugas+' ('+e.jabatan+')</b></h3> </div> <div class=\"card-body\"> <div class=\"col-md-12\"> <div class=\"form-group\"> <label>Jenis Terminasi : </label> <textarea readonly class=\"form-control\" style=\"resize: none;\" rows=\"1\"">'+e.jenis_terminasi+'</textarea> </div> </div> <div class=\"col-md-12\"> <div class=\"form-group\"> <label>Alasan Terminasi : </label> <textarea readonly class=\"form-control\" style=\"resize: none;\">'+e.alasan+'</textarea> </div> </div>'+kolomapproval+' </div> </div>');
                    i++;
                });
            },
            error: function (response){
                console.log(response);
            }
            });
    }

    $('#submitTerminasi').click(function() {
        if(validateForm('terminasi')){
            let token   = $("meta[name='csrf-token']").attr("content");
            $.ajax({
            url: `/terminasi/store/`,
            type: "POST",
            cache: false,
            data: {
                uuid: $('#uuid_terminasi').val(),
                uuid_klien: '{{ $klien->uuid }}',
                jenis_terminasi: $("input[name=jenis_terminasi]:checked").val(),
                alasan: $("#terminasi_alasan").val(),
                _token: token
            },
            success: function (response){
                if (response.success != true) {
                    $('#message-terminasi').html(JSON.stringify(response));
                    $("#success-message-terminasi").hide();
                    $("#error-message-terminasi").show();
                }else{
                    $('#message-terminasi').html(response.message);
                    $("#success-message-terminasi").show();
                    $("#error-message-terminasi").hide();
                    loadTerminasi();                    
                    
                    // kirim realtime notifikasi
                    socket.emit('notif_count', {
                        receiver_id : response.notif_receiver
                    });

                    // hapus semua inputan
                    $('#uuid_terminasi').val('');
                    $("#terminasi_alasan").val('');
                }
            },
            error: function (response){
                setTimeout(function(){
                $("#overlay").fadeOut(300);
                },500);
                console.log(response);

                $('#message-terminasi').html(JSON.stringify(response));
                $("#success-message-terminasi").hide();
                $("#error-message-terminasi").show();
            }
            }).done(function() { //loading submit form
                setTimeout(function(){
                $("#overlay").fadeOut(300);
                },500);
            });
        }else{
            $('#message-terminasi').html('Mohon cek ulang data yang wajib diinput.');
            $("#success-message-terminasi").hide();
            $("#error-message-terminasi").show();
        }
    });

    function loadCatatan() {
        $.ajax({
            url: `/catatan/index?uuid={{ $klien->uuid }}`,
            type: "GET",
            cache: false,
            success: function (response){
                $('#kolomCatatan').html('');
                
                data = response.data;
                data.forEach(e => {
                    $('#kolomCatatan').prepend('<div style=\"cursor:pointer\" onclick=\"editCatatan(`'+e.uuid+'`)\"> <strong>'+e.petugas+' ('+e.jabatan+')</strong> - <small>'+e.created_at_formatted+'</small><p class=\"text-muted\"> '+e.catatan+' </p> </div> <hr>');
                });
            },
            error: function (response){
                console.log(response);
            }
            });
    }

    function tambahCatatan() {
        $("#success-message-catatan").hide();
        $("#error-message-catatan").hide();
        $('#uuid_catatan').val('');
        $('#deleteCatatan').hide();
        $('#submitCatatan').show();
        $('#catatan_kasus').val('');
        $('#catatan_kasus').prop('disabled', false);
        $('#tambahCatatanModal').modal('show');
    }

    $('#submitCatatan').click(function() {
        if(validateForm('catatan')){
            let token   = $("meta[name='csrf-token']").attr("content");
            $.ajax({
            url: `/catatan/store/`,
            type: "POST",
            cache: false,
            data: {
                uuid: $('#uuid_catatan').val(),
                uuid_klien: '{{ $klien->uuid }}',
                catatan: $("#catatan_kasus").val(),
                _token: token
            },
            success: function (response){
                if (response.success != true) {
                    $('#message-catatan').html(JSON.stringify(response));
                    $("#success-message-catatan").hide();
                    $("#error-message-catatan").show();
                }else{
                    $('#message-catatan').html(response.message);
                    $("#success-message-catatan").show();
                    $("#error-message-catatan").hide();
                    loadCatatan();

                    // hapus semua inputan
                    $('#uuid_catatan').val('');
                    $("#catatan_kasus").val('');
                    $('#tambahCatatanModal').scrollTop(0);

                    // kirim realtime notifikasi
                    socket.emit('notif_count', {
                        receiver_id : response.notif_receiver
                    });
                }
            },
            error: function (response){
                setTimeout(function(){
                $("#overlay").fadeOut(300);
                },500);
                console.log(response);

                $('#message-catatan').html(JSON.stringify(response));
                $("#success-message-catatan").hide();
                $("#error-message-catatan").show();
            }
            }).done(function() { //loading submit form
                setTimeout(function(){
                $("#overlay").fadeOut(300);
                },500);
            });
        }else{
            $('#message-catatan').html('Mohon cek ulang data yang wajib diinput.');
            $("#success-message-catatan").hide();
            $("#error-message-catatan").show();
        }
    });

    $('#deleteCatatan').click(function() {
        if(validateForm('catatan')){
            let token   = $("meta[name='csrf-token']").attr("content");
            $.ajax({
            url: `/catatan/store/`,
            type: "POST",
            cache: false,
            data: {
                uuid: $('#uuid_catatan').val(),
                uuid_klien: '{{ $klien->uuid }}',
                _token: token
            },
            success: function (response){
                if (response.success != true) {
                    $('#message-catatan').html(JSON.stringify(response));
                    $("#success-message-catatan").hide();
                    $("#error-message-catatan").show();
                }else{
                    $('#message-catatan').html(response.message);
                    $("#success-message-catatan").show();
                    $("#error-message-catatan").hide();
                    loadCatatan();

                    // hapus semua inputan
                    $('#uuid_catatan').val('');
                    $("#catatan_kasus").val('');
                    $('#tambahCatatanModal').scrollTop(0);
                }
            },
            error: function (response){
                setTimeout(function(){
                $("#overlay").fadeOut(300);
                },500);
                console.log(response);

                $('#message-catatan').html(JSON.stringify(response));
                $("#success-message-catatan").hide();
                $("#error-message-catatan").show();
            }
            }).done(function() { //loading submit form
                setTimeout(function(){
                $("#overlay").fadeOut(300);
                },500);
            });
        }else{
            $('#message-catatan').html('Mohon cek ulang data yang wajib diinput.');
            $("#success-message-catatan").hide();
            $("#error-message-catatan").show();
        }
    });

    function editCatatan(uuid) {
        // gak ada edit langsung hapus saja
        $("#success-message-catatan").hide();
        $("#error-message-catatan").hide();
        $('#submitCatatan').hide();
        $('#catatan_kasus').prop('disabled', true);
        $('#tambahCatatanModal').modal('show');
        let token   = $("meta[name='csrf-token']").attr("content");
        $.ajax({
        url: `/catatan/edit/`+uuid,
        type: "GET",
        cache: false,
        success: function (response){
            data = response.data;
            if (data.created_by == '{{ Auth::user()->id }}') {
                $('#deleteCatatan').show();
            }else{
                $('#deleteCatatan').hide();
            }
            $('#uuid_catatan').val(data.uuid);
            $("#catatan_kasus").val(data.catatan);
            $('#tambahCatatanModal').scrollTop(0);
        },
        error: function (response){
            setTimeout(function(){
            $("#overlay").fadeOut(300);
            },500);
            console.log(response);

            $('#message-catatan').html(JSON.stringify(response));
            $("#success-message-catatan").hide();
            $("#error-message-catatan").show();
        }
        }).done(function() { //loading submit form
            setTimeout(function(){
            $("#overlay").fadeOut(300);
            },500);
        });
    }

    function loadPublicUrl() {
        $('#deleteMonitoring').hide();
        $.ajax({
            url: `/publicurl/index?uuid={{ $klien->uuid }}`,
            type: "GET",
            cache: false,
            success: function (response){
                $('#kolomPublicUrl').html('');
                
                data = response.data;
                i=1;
                data.forEach(e => {
                    $('#kolomPublicUrl').prepend("<div class=\"input-group\"> <input type=\"text\" class=\"form-control\" id=\"link-form-{{ route('publicurl.show', '') }}/"+e.uuid+"\" value=\"{{ route('publicurl.show', '') }}/"+e.uuid+"\" tabindex=\"-1\" aria-hidden=\"true\" style=\"background: #eaebeb;font-size: 14px;font-weight: bold;\"> <div class=\"input-group-append\"> <button class=\"input-group-text pointer\" onclick=\"copyClipboard('{{ route('publicurl.show','') }}/"+e.uuid+"')\"> <i class=\"fa fa-fw\" aria-hidden=\"true\"></i> </button> </div> </div>");
                    i++;
                });
            },
            error: function (response){
                console.log(response);
            }
            });
    }

    function submitPublicURL(functions) {
        let token   = $("meta[name='csrf-token']").attr("content");
        $.ajax({
        url: `/publicurl/store/`,
        type: "POST",
        cache: false,
        data: {
            uuid: $('#uuid_monitoring').val(),
            uuid_klien: '{{ $klien->uuid }}',
            function: functions,
            _token: token
        },
        success: function (response){
            if (response.success != true) {
                $('#message-monitoring').html(JSON.stringify(response));
                $("#success-message-monitoring").hide();
                $("#error-message-monitoring").show();
            }else{
                loadPublicUrl();
            }
        },
        error: function (response){
            setTimeout(function(){
            $("#overlay").fadeOut(300);
            },500);
            console.log(response);
        }
        }).done(function() { //loading submit form
            setTimeout(function(){
            $("#overlay").fadeOut(300);
            },500);
        });
    };
    
    function approveTerminasi(uuid, approval) {
        alasan_approve = null;
        if (approval == '0') {
            alasan_approve = prompt("Masukan alasan tidak menerima pengajuan terminasi : ");
        }
        
        if (alasan_approve || approval == 1) {
            let token = $("meta[name='csrf-token']").attr("content");
            $.ajax({
            url: `/terminasi/store/`,
            type: "POST",
            cache: false,
            data: {
                uuid: uuid,
                uuid_klien: '{{ $klien->uuid }}',
                alasan_approve: alasan_approve,
                _token: token
            },
            success: function (response){
                loadTerminasi();
                check_kelengkapan_terminasi('{{ $klien->id }}');
                // kirim realtime notifikasi
                socket.emit('notif_count', {
                    receiver_id : response.notif_receiver
                });
            },
            error: function (response){
                setTimeout(function(){
                $("#overlay").fadeOut(300);
                },500);
                console.log(response);
            }
            }).done(function() { //loading submit form
                setTimeout(function(){
                $("#overlay").fadeOut(300);
                },500);
            });
            
        }
    }

    function hightlighting() {
        var inputValue = $('#perubahan').val();

        if (inputValue) {
            toastr.success('Berhasil update data!');
            var value = JSON.parse(inputValue);

            if (value[value.length - 1] == 'terlapor') {
                $('#data_terlapor').addClass('hightlighting');
            }
            
            $.each(value, function(index, element) {
                data_update = $('#data_update').val();
                $('#'+element+'_'+value[value.length - 1]).addClass('hightlighting');
            });
        } 
    }

    function copyClipboard(uuid) {
        // alert('hiha');
        var copyText = document.getElementById("link-form-"+uuid);
        copyText.select();
        copyText.setSelectionRange(0, 99999); // For mobile devices
        navigator.clipboard.writeText(copyText.value);
        alert('Link berhasil dicopy');
    }

    function showPersetujuan(uuid){
        //tampilkan surat perjanjian serverside
        url = '{{ route("persetujuan.done", "") }}/'+uuid;
        $('#showPersetujuan').attr('src', url);
        $('#sppModal').modal('show');
    }

    function penjadwalan_layanan() {
        if ($('#penjadwalan_layanan').val() == 0) {
            $("#klien_id").hide();
        } else {
            $("#klien_id").show();
        }
    }

    function check_kelengkapan_data(klien_id) {
    $.ajax({
        url: `/check_kelengkapan_data/`+klien_id,
        type: "GET",
        cache: false,
        success: function (response){
            jml_null_kasus = response.nullKasus;
            jml_null_klien = response.nullKlien;
            jml_null_pelapor = response.nullPelapor;
            total_null = jml_null_kasus.length + jml_null_klien.length + jml_null_pelapor.length;
            total_all = parseInt(response.kolomKasus) + parseInt(response.kolomKlien) + parseInt(response.kolomPelapor);
            total_isi = total_all - total_null;
            persentase = (total_isi / total_all) * 100;
            persentase = persentase.toFixed(2);
            $('#persen_title_data').html(persentase);
            $('#persen_data').css('width', persentase+'%');
        },
        error: function (response){
            alert("Error");
            console.log(response);
        }
        });
}

function check_kelengkapan_persetujuan_spv(klien_id) {
    $.ajax({
        url: `/check_kelengkapan_persetujuan_spv/`+klien_id,
        type: "GET",
        cache: false,
        success: function (response){
            if (response) {
                $('#check_persetujuan_spv').show();
                kelengkapan_identifikasi = kelengkapan_identifikasi + 1;
                if (kelengkapan_identifikasi > 1) {
                    $('#check_identifikasi').show();
                    kelengkapan_kasus = kelengkapan_kasus + 1;
                    $('#kelengkapan_kasus').html(kelengkapan_kasus);
                }
            }
        },
        error: function (response){
            alert("Error");
            console.log(response);
        }
        });
}

function check_kelengkapan_spp(klien_id) {
    $.ajax({
        url: `/check_kelengkapan_spp/`+klien_id,
        type: "GET",
        cache: false,
        success: function (response){
            if (response) {
                $('#check_ttd_spp').show();
                kelengkapan_identifikasi = kelengkapan_identifikasi + 1;
                if (kelengkapan_identifikasi > 1) {
                    $('#check_identifikasi').show();
                    kelengkapan_kasus = kelengkapan_kasus + 1;
                    $('#kelengkapan_kasus').html(kelengkapan_kasus);
                }
                $('#modalAsesmen').show();
            }else{
                $('.warningSPP').show();
            }
        },
        error: function (response){
            alert("Error");
            console.log(response);
        }
        });
}

function check_kelengkapan_asesmen(klien_id) {
    $.ajax({
        url: `/check_kelengkapan_asesmen/`+klien_id,
        type: "GET",
        cache: false,
        success: function (response){
            if (response) {
                $('#check_asesmen').show();
                kelengkapan_kasus = kelengkapan_kasus + 1;
                $('#kelengkapan_kasus').html(kelengkapan_kasus);
                $('.warningAsesmen').hide();
            }else{
                $('.warningAsesmen').show();
            }
        },
        error: function (response){
            alert("Error");
            console.log(response);
        }
        });
}

function check_kelengkapan_perencanaan(klien_id) {
    $.ajax({
        url: `/check_kelengkapan_perencanaan/`+klien_id,
        type: "GET",
        cache: false,
        success: function (response){
            if (response > 0) {
                $('#check_perencanaan').show();
                kelengkapan_kasus = kelengkapan_kasus + 1;
                $('#kelengkapan_kasus').html(kelengkapan_kasus);
            }
            check_kelengkapan_pelaksanaan(response, '{{ $klien->id }}');
        },
        error: function (response){
            alert("Error");
            console.log(response);
        }
        });
}

function check_kelengkapan_pelaksanaan(jml_perencanaan, klien_id) {
    $.ajax({
        url: `/check_kelengkapan_pelaksanaan/`+klien_id,
        type: "GET",
        cache: false,
        success: function (response){
            persentase = (response / jml_perencanaan) * 100
            persentase = persentase.toFixed(2);
            $('.persen_title_layanan').html(persentase+'%');
            $('.persen_layanan').css('width', persentase+'%');
            if (persentase == 100) {
                $('#check_pelaksanaan').show();
                kelengkapan_kasus = kelengkapan_kasus + 1;
                $('#kelengkapan_kasus').html(kelengkapan_kasus);
            }
        },
        error: function (response){
            alert("Error");
            console.log(response);
        }
        });
}

function check_kelengkapan_monitoring(klien_id) {
    $.ajax({
        url: `/check_kelengkapan_monitoring/`+klien_id,
        type: "GET",
        cache: false,
        success: function (response){
            if (response > 0) {
                $('#check_monitoring').show();
                kelengkapan_kasus = kelengkapan_kasus + 1;
                $('#kelengkapan_kasus').html(kelengkapan_kasus);
            }
        },
        error: function (response){
            alert("Error");
            console.log(response);
        }
        });
}

function check_kelengkapan_terminasi(klien_id) {
    $.ajax({
        url: `/check_kelengkapan_terminasi/`+klien_id,
        type: "GET",
        cache: false,
        success: function (response){
            if (response!='') {
                $('#check_terminasi').show();
                kelengkapan_kasus = kelengkapan_kasus + 1;
                $('#kelengkapan_kasus').html(kelengkapan_kasus);
                $('.warningTerminasi').show();
                $('#alasan_terminasi').html(response.alasan);
            }
        },
        error: function (response){
            alert("Error");
            console.log(response);
        }
        });
}
</script>
{{-- include modal agenda --}}
@include('agenda.modal')
@endsection