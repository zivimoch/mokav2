@extends('layouts.template')

@section('content')
<style>
    .input_pelapor, 
    #tombol_save_pelapor, 
    .input_klien, 
    #tombol_save_klien, 
    .input_kasus, 
    #tombol_save_kasus, 
    .input_terlapor, 
    .tombol_save_terlapor, 
    .input_rekam, 
    #tombol_save_rekam, 
    .input_klasifikasi, 
    #tombol_save_klasifikasi, 
    .input_hukum, 
    #tombol_save_hukum, 
    .layanan_hukum_lp, 
    .layanan_hukum_putusan, 
    .input_psikologi, 
    #tombol_save_psikologi, 
    .layanan_psikologi_disabilitas, 
    #formTerlapor {
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

    .akses_petugas, #check_persetujuan_spv, #check_ttd_spp, #check_identifikasi, #check_asesmen, .warningAsesmen, .warningSPP, #modalAsesmen, #check_perencanaan, #check_pelaksanaan, #check_pemantauan, #check_terminasi, .warningTerminasi {
        display: none;
    }

    .cursor-disabled {
        cursor:not-allowed;
    }
</style>

<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Detail Kasus</h1>
        </div>
        <div class="col-sm-6 text-right">
          <input type="checkbox" class="btn-xs" id="kontainerwidth"
          {{ Auth::user()->settings_kontainer_width == 'normal' ? 'checked' : '' }}
                data-bootstrap-switch 
                data-on-text="Normal"
                data-off-text="Fullwidth"
                data-off-color="default" 
                data-on-color="default">
        </div>
      </div>
    </div>
  </section>

<section class="content">
@if (Session::has('data'))
    {{-- ini ketika submit perubahan --}}
    <input type="hidden" id="perubahan" value="{{ Session::get('data') }}">
@elseif(Request::get('data'))
    {{-- ini untuk notifikasi ketika diklik redirect --}}
    <input type="hidden" id="perubahan" value="{{ Request::get('data') }}">
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
<img class="profile-user-img img-fluid img-circle" src="{{ asset('adminlte') }}/dist/img/default-150x150.png" alt="User profile picture">
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

            <div class="card-header {{ Request::get('kolom-kelengkapan') == 1 ? 'hightlighting' : '' }}" data-toggle="collapse" data-target="#collapseKelengkapan" aria-expanded="true" aria-controls="collapseKelengkapan" style="cursor: pointer;">
                <h3 class="card-title">
                    <b>Kelengkapan Kasus (<span id="kelengkapan_kasus"></span>/6) </b>
                </h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool">
                    <i class="fas fa-chevron-down"></i>
                  </button>
                </div>
              </div>
        <div id="collapseKelengkapan" class="collapse {{ Request::get('kolom-kelengkapan') == 1 ? 'show' : '' }} {{ Request::get('kolom-kelengkapan') == 1 ? 'hightlighting' : '' }}" data-parent="#accordionKelengkapan">
        <div class="card-body">
            <ol style="padding:15px; margin :-25px 0px -20px 0px">
                <li>
                    Identifikasi <i class="fa fa-check" id="check_identifikasi"></i>
                    <ul style="margin-left: -25px">
                        <li style="color: blue; cursor: pointer; font-weight:bold" onclick="alert('Field yang dibutuhkan untuk diisi :\n1. Data Kasus : \nMedia Pengagduan, Sumber Informasi, Tanggal Pelaporan, Tanggal Kejadian, Kategori Lokasi, Ringkasan, TKP\n2. Data Pelapor :\n Nama Lengkap, Jenis Kelamin\n3. Data Korban :\nNama Lengkap, Tempat Lahir, Tanggal Lahir, Jenis Kelamin, Alamat KTP, Alamat Domisili, Agama, Status Kawin, Pekerjaan, Kewargangaraan, Status Pendidikan, Pendidikan, Hubungan dengan Pelapor\n4. Data Terlapor :\nNama Lengkap, Tempat Lahir, Tanggal Lahir, Jenis Kelamin, Agama, Pekerjaan, Kewarganegaraan, Status Pendidikan, Pendidikan')">
                            Kelengkapan Data (<span id="persen_title_data"></span>%) <i class="far fa-check-circle"></i>
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
                    Perencanaan Intervensi <i class="fa fa-check" id="check_perencanaan"></i>
                </li>
                <li>
                    Pelaksanaan Intervensi  <i class="fa fa-check" id="check_pelaksanaan"></i>
                    <br>
                    (<span class="persen_title_layanan"></span>)
                    <div class="progress progress-xs">
                        <div class="progress-bar bg-success progress-bar-striped persen_layanan" role="progressbar" aria-valuemin="0">
                        </div>
                    </div>
                </li>
                <li>
                    Pemantauan & Evaluasi <i class="fa fa-check" id="check_pemantauan"></i>
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
    <a href="{{ route('kasus.show', $item->uuid) }}">
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
        <a class="nav-link {{ Request::get('tab') == 'kasus-layanan' ? 'active' : '' }}" id="kasus-layanan-tab" data-toggle="pill" href="#kasus-layanan" role="tab" aria-controls="kasus-layanan" aria-selected="false">Intervensi</a>
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
        <li class="nav-item akses_petugas">
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
            
        <style> input { width: 100%; }</style>
        <div class="post clearfix" style="color:black">
            <b>A. DATA KASUS</b>
            <form action="{{ route('formpenerimapengaduan.update', 'uuid') }}" method="POST">
            @csrf
            @method('put')
            <input type="hidden" name="uuid" value="{{ $kasus->uuid }}">
            <input type="hidden" name="data_update" value="kasus">
            <span style="float:right" class="akses_petugas">
                <a class="btn btn-xs bg-gradient-warning" id="tombol_edit_kasus" onclick="editdata('kasus')">
                <i class="fas fa-edit"></i> Edit
                </a>
                <button type="submit" class="btn btn-xs bg-gradient-success" id="tombol_save_kasus">
                <i class="fas fa-check"></i> Save
                </button>
            </span>
            <span style="color: red" class="input_kasus">*merubah data ini akan merubah pula data pada kasus yang terkait</span>
            <table class="table table-bottom table-sm">
                <tr id="sumber_rujukan_kasus">
                    <td style="width: 200px">Rujukan</td>
                    <td style="width: 1%">:</td>
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
                <tr id="media_pengaduan_kasus">
                    <td style="width: 200px">Media Pengaduan</td>
                    <td style="width: 1%">:</td>
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
                <tr id="sumber_informasi_kasus">
                    <td style="width: 200px">Sumber Informasi</td>
                    <td style="width: 1%">:</td>
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
                <tr id="tanggal_pelaporan_kasus">
                    <td style="width: 200px">Tanggal Pelaporan</td>
                    <td style="width: 1%">:</td>
                    <td>
                        <span class="data_kasus">
                            {{ $kasus->tanggal_pelaporan ? date('d M Y', strtotime($kasus->tanggal_pelaporan)) : '' }}
                        </span> 
                        <input type="date" name="tanggal_pelaporan" value="{{ $kasus->tanggal_pelaporan }}" class="input_kasus">
                    </td>
                </tr>
                <tr id="tanggal_kejadian_kasus">
                    <td style="width: 200px">Tanggal Kejadian</td>
                    <td style="width: 1%">:</td>
                    <td>
                        <span class="data_kasus">
                            {{ $kasus->tanggal_kejadian ? date('d M Y', strtotime($kasus->tanggal_kejadian)) : '' }}
                        </span> 
                        <input type="date" name="tanggal_kejadian" value="{{ $kasus->tanggal_kejadian }}" class="input_kasus">
                    </td>
                </tr>
                <tr id="kategori_lokasi_kasus">
                    <td style="width: 200px">Kategori Lokasi TKP</td>
                    <td style="width: 1%">:</td>
                    <td>
                        <span class="data_kasus">{{ $kasus->kategori_lokasi }}</span> 
                        <select name="kategori_lokasi" class="input_kasus select2bs4" style="width: 100%;">
                            <option value=""></option>
                            @php
                            $no_kategori_lokasi = 1;   
                            @endphp
                            @foreach ($kategori_lokasi as $group => $groupItems)
                                <optgroup label="{{ $no_kategori_lokasi.'. '. $group }}">
                                    @foreach ($groupItems as $item)
                                        <option value="{{ $item }}" {{ $item == $kasus->kategori_lokasi ? 'selected' : '' }}>{{ $item }}</option>
                                    @endforeach
                                </optgroup>
                                @php
                                $no_kategori_lokasi++;
                                @endphp
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr id="alamat_kasus">
                    <td style="width: 200px">Alamat TKP</td>
                    <td style="width: 1%">:</td>
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
                        <select name="kecamatan_id" class="input_kasus select2bs4" id="kecamatan_id_kasus" onchange="getkelurahan('kasus')" style="width:100%">
                            <option value="" selected></option>
                        </select>,
                        <b>Kelurahan</b> <span class="data_kasus">{{ $kasus->kelurahan }}</span> 
                        <select name="kelurahan_id" class="input_kasus select2bs4" id="kelurahan_id_kasus" style="width:100%">
                            <option value="" selected></option>
                        </select>
                    </td>
                </tr>
                <tr id="ringkasan_kasus">
                    <td style="width: 200px">Ringkasan</td>
                    <td style="width: 1%">:</td>
                    <td><span class="data_kasus">{!! nl2br($kasus->ringkasan) !!}</span> <textarea name="ringkasan" class="input_kasus" style="width:100%" rows="10">{{ $kasus->ringkasan }}</textarea></td>
                </tr>
            </table>
            </form>
            <div id="accordionCatatanLayananHukum" style="margin-bottom:-15px">
                <div class="card card-light">
                    <div class="card-header" data-toggle="collapse" data-target="#collapseCatatanLayananHukum" aria-expanded="true" aria-controls="collapseCatatanLayananHukum" style="cursor: pointer;">
                        <h3 class="card-title">
                            <b>Catatan Layanan Hukum</b>
                                <br>
                                @if ($catatan_hukum->name != null)
                                    <span style="font-size:15px;">*Terakhir diupdate oleh {{ $catatan_hukum->name }} ({{ $catatan_hukum->updated_at }})</span>
                                @endif
                        </h3>
                        <div class="card-tools">
                          <button type="button" class="btn btn-tool">
                            <i class="fas fa-chevron-down"></i>
                          </button>
                        </div>
                      </div>
                <div id="collapseCatatanLayananHukum" class="collapse {{ Request::get('catatan-layanan') == 'Layanan Hukum' ? 'show hightlighting' : '' }}" data-parent="#accordionCatatanLayananHukum">
                <div class="card-body">
                    <form action="{{ route('catatan.store_hukum') }}" method="POST">
                    @csrf
                    @method('post')
                    <input type="hidden" name="uuid_klien" value="{{ $klien->uuid }}">
                    <input type="hidden" name="nama_layanan" value="Layanan Hukum">
                    @if (in_array(Auth::user()->jabatan, ['Advokat', 'Paralegal', 'Unit Reaksi Cepat']))
                        <span style="float:right" class="akses_petugas">
                            <a class="btn btn-xs bg-gradient-warning" id="tombol_edit_hukum" onclick="editdata('hukum')">
                            <i class="fas fa-edit"></i> Edit
                            </a>
                            <button type="submit" class="btn btn-xs bg-gradient-success" id="tombol_save_hukum">
                            <i class="fas fa-check"></i> Save
                            </button>
                        </span>
                    @endif
                    <table class="table table-bottom table-sm">
                        <tr id="no_lp">
                            <td style="width: 200px">Laporan Polisi / Tidak</td>
                            <td style="width: 1%">:</td>
                            <td>
                                <span class="data_hukum">{{ $catatan_hukum->no_lp != null || $catatan_hukum->no_lp != '' ? 'Ya':'Tidak' }}</span>
                                <select name="laporan_polisi" class="input_hukum" style="width: 100%;" id="input_layanan_hukum_lp" onchange="show_catatan('layanan_hukum_lp')">
                                    <option value="1" {{ $catatan_hukum->no_lp != null || $catatan_hukum->no_lp != '' ? 'selected' : '' }}>Ya</option>
                                    <option value="0" {{ $catatan_hukum->no_lp == null || $catatan_hukum->no_lp == ''  ? 'selected' : '' }}>Tidak</option>
                                </select>
                                </br> 
                                <div class="layanan_hukum_lp">
                                    <b>No LP : </b> <span class="data_hukum">{{ $catatan_hukum->no_lp }}</span> <input type="text" name="no_lp" value="{{ $catatan_hukum->no_lp }}" class="input_hukum"><br>
                                    <b>Undang-Undang : </b> 
                                    <span class="data_hukum">
                                        @php
                                            $hukum_pasal = $catatan_hukum->pasal;
                                        @endphp
                                        @if ($hukum_pasal)
                                            <ul>
                                                @foreach ($hukum_pasal as $item_pasal)
                                                    <li>{{ $item_pasal->value }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </span> 
                                    <select class="input_hukum select2bs4" id="pasal" name="pasal[]" multiple="multiple" style="width: 100%"  data-placeholder="Dapat dipilih lebih dari 1 Undang-Undang">
                                        @php
                                            if ($hukum_pasal) {
                                                $hukum_pasal_values = collect($hukum_pasal)->pluck('value')->toArray();
                                            } else {
                                                $hukum_pasal_values = [];
                                            }
                                        @endphp
                                    
                                        @if ($hukum_pasal)
                                            @foreach ($hukum_pasal as $item_pasal)
                                                <option value="{{ $item_pasal->value }}" selected>{{ $item_pasal->value }}</option>
                                            @endforeach
                                        @endif
                                    
                                        @foreach ($pasal as $item_pasals)
                                            @if (!in_array($item_pasals, $hukum_pasal_values))
                                                <option value="{{ $item_pasals }}">{{ $item_pasals }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <br>
                                </div>
                            </td>
                        </tr>
                        <tr id="putusan">
                            <td style="width: 200px">Ada Putusan / Tidak</td>
                            <td style="width: 1%">:</td>
                            <td>
                                <span class="data_hukum">{{ $catatan_hukum->pengadilan_negeri != null || $catatan_hukum->pengadilan_negeri != '' ? 'Ya':'Tidak' }}</span>
                                <select name="putusan" class="input_hukum" style="width: 100%;" id="input_layanan_hukum_putusan" onchange="show_catatan('layanan_hukum_putusan')">
                                    <option value="1" {{ $catatan_hukum->pengadilan_negeri != null || $catatan_hukum->pengadilan_negeri != '' ? 'selected' : '' }}>Ya</option>
                                    <option value="0" {{ $catatan_hukum->pengadilan_negeri == null || $catatan_hukum->pengadilan_negeri == ''  ? 'selected' : '' }}>Tidak</option>
                                </select>
                                </br> 
                                <div class="layanan_hukum_putusan">
                                    <b>Pengadilan Negeri : </b> <span class="data_hukum">{{ $catatan_hukum->pengadilan_negeri }}</span> 
                                    <select name="pengadilan_negeri" class="input_hukum select2bs4" style="width: 100%;">
                                        <option value=""></option>
                                        @foreach ($pengadilan_negri as $item_pengadilan_negeri)
                                            <option value="{{ $item_pengadilan_negeri }}" {{ $item_pengadilan_negeri == $catatan_hukum->pengadilan_negeri ? 'selected' : '' }}>{{ $item_pengadilan_negeri }}</option>
                                        @endforeach
                                    </select>
                                    <br>
                                    <b>Isi Putusan : </b> <span class="data_hukum">{{ $catatan_hukum->isi_putusan }}</span> 
                                    <textarea name="isi_putusan" style="width: 100%" class="input_hukum">{{ $catatan_hukum->isi_putusan }}</textarea>
                                    <br>
                                </div>
                            </td>
                        </tr>
                        <tr id="lpsk">
                            <td style="width: 200px">Klien LPSK / Bukan</td>
                            <td style="width: 1%">:</td>
                            <td>
                                <span class="data_hukum">{{ $catatan_hukum->lpsk == 1 ? 'Ya':'Tidak' }}</span>
                                <select name="lpsk" class="input_hukum" style="width: 100%;">
                                    <option value="1" {{ $catatan_hukum->lpsk == 1 ? 'selected' : '' }}>Ya</option>
                                    <option value="0" {{ $catatan_hukum->lpsk == 0 ? 'selected' : '' }}>Tidak</option>
                                </select>
                            </br> 
                            </td>
                        </tr>
                    </table>
                    </form>
                </div>
                </div>
                </div>
            </div>
            <div id="accordionCatatanLayananPsikolog" style="margin-bottom:-15px">
                <div class="card card-light">
        
                    <div class="card-header" data-toggle="collapse" data-target="#collapseCatatanLayananPsikolog" aria-expanded="true" aria-controls="collapseCatatanLayananPsikolog" style="cursor: pointer;">
                        <h3 class="card-title">
                            <b>Catatan Layanan Psikologi</b>
                            <br>
                            @if ($catatan_psikologis->name != null)
                                <span style="font-size:15px;">*Terakhir diupdate oleh {{ $catatan_psikologis->name }} ({{ $catatan_psikologis->updated_at }})</span>
                            @endif
                        </h3>
                        <div class="card-tools">
                          <button type="button" class="btn btn-tool">
                            <i class="fas fa-chevron-down"></i>
                          </button>
                        </div>
                      </div>
                <div id="collapseCatatanLayananPsikolog" class="collapse {{ Request::get('catatan-layanan') == 'Layanan Psikologi' ? 'show hightlighting' : '' }}" data-parent="#accordionCatatanLayananPsikolog">
                <div class="card-body">
                    <form action="{{ route('catatan.store_psikologis') }}" method="POST">
                        @csrf
                        @method('post')
                        <input type="hidden" name="uuid_klien" value="{{ $klien->uuid }}">
                        <input type="hidden" name="nama_layanan" value="Layanan Psikologi">
                        @if (in_array(Auth::user()->jabatan, ['Psikolog', 'Konselor']))
                            <span style="float:right" class="akses_petugas">
                                <a class="btn btn-xs bg-gradient-warning" id="tombol_edit_psikologi" onclick="editdata('psikologi')">
                                <i class="fas fa-edit"></i> Edit
                                </a>
                                <button type="submit" class="btn btn-xs bg-gradient-success" id="tombol_save_psikologi">
                                <i class="fas fa-check"></i> Save
                                </button>
                            </span>
                        @endif
                        <table class="table table-bottom table-sm">
                            <tr id="no_lp">
                                <td style="width: 200px">Disabilitas / Tidak</td>
                                <td style="width: 1%">: </td>
                                <td>
                                    <span class="data_psikologi">{{ $catatan_psikologis->disabilitas == 1 ? 'Ya':'Tidak' }}</span>
                                    <select name="disabilitas" class="input_psikologi" style="width: 100%;" id="input_layanan_psikologi_disabilitas" onchange="show_catatan('layanan_psikologi_disabilitas')">
                                        <option value="1" {{ $catatan_psikologis->disabilitas == 1 ? 'selected' : '' }}>Ya</option>
                                        <option value="0" {{ $catatan_psikologis->disabilitas == 0 ? 'selected' : '' }}>Tidak</option>
                                    </select>
                                    </br> 
                                    <div class="layanan_psikologi_disabilitas">
                                        <b>Detail Disabilitas : </b> 
                                        <span class="data_psikologi">
                                            @php
                                                $psikologis_disabilitas = $catatan_psikologis->disabilitases;
                                            @endphp
                                            @if ($psikologis_disabilitas)
                                                <ul>
                                                    @foreach ($psikologis_disabilitas as $item_disabilitas)
                                                        <li>{{ $item_disabilitas->value }}</li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </span> 
                                        <select class="input_psikologi select2bs4" id="tipe_disabilitas" name="tipe_disabilitas[]" multiple="multiple" style="width: 100%"  data-placeholder="Dapat dipilih lebih dari 1 Detail Disabilitas">
                                            @php
                                                $psikologis_disabilitas_values = $psikologis_disabilitas ? collect($psikologis_disabilitas)->pluck('value')->toArray() : [];
                                            @endphp
                                        
                                            @if ($psikologis_disabilitas)
                                                @foreach ($psikologis_disabilitas as $item_disabilitas)
                                                    <option value="{{ $item_disabilitas->value }}" selected>{{ $item_disabilitas->value }}</option>
                                                @endforeach
                                            @endif
                                        
                                            @foreach ($tipe_disabilitas as $item_disabilitas)
                                                @if (!in_array($item_disabilitas, $psikologis_disabilitas_values))
                                                    <option value="{{ $item_disabilitas }}">{{ $item_disabilitas }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <br>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        </form>
                </div>
                </div>
                </div>
            </div>
        </div>

        <div class="post clearfix" style="color:black">
            <b>KLASIFIKASI KASUS</b>
            <form action="{{ route('formpenerimapengaduan.update', 'uuid') }}" method="POST">
            @csrf
            @method('put')
            <input type="hidden" name="uuid" value="{{ $klien->uuid }}">
            <input type="hidden" name="data_update" value="klasifikasi">
            <span style="float:right" class="akses_petugas">
                <a class="btn btn-xs bg-gradient-warning" id="tombol_edit_klasifikasi" onclick="editdata('klasifikasi')">
                <i class="fas fa-edit"></i> Edit
                </a>
                <button type="submit" class="btn btn-xs bg-gradient-success" id="tombol_save_klasifikasi">
                <i class="fas fa-check"></i> Save
                </button>
            </span>
            <table class="table table-bottom table-sm">
                <tr id="sumber_rujukan_kasus">
                    <td style="width: 200px">Jenis Kekerasan</td>
                    <td style="width: 1%">:</td>
                    <td>
                        <span class="data_klasifikasi">
                            @foreach ($jenis_kekerasan as $item)
                                {{ $item->nama }}@if (!$loop->last), @endif 
                            @endforeach
                        </span> 
                        <div class="input_klasifikasi">
                            <select name="jenis_kekerasan[]" id="jenis_kekerasan" onchange="getBentukKekerasan()" multiple="multiple" style="width: 100%"  data-placeholder="Dapat dipilih lebih dari 1 jenis kekerasan" required>
                                @foreach ($jenis_kekerasan as $item)
                                    <option value="{{ $item->value }}" selected>{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </td>
                </tr>
                <tr id="sumber_rujukan_kasus">
                    <td style="width: 200px">Bentuk Kekerasan</td>
                    <td style="width: 1%">:</td>
                    <td>
                        <span class="data_klasifikasi">
                            @php
                                $no_jenis = 1;
                            @endphp
                            @foreach($bentuk_kekerasan_sets as $jenisNama => $bentukKekerasans)
                                <b>{{ $no_jenis.'. '.$jenisNama }}</b><br>
                                    @foreach($bentukKekerasans as $bentukNama)
                                        {{ $bentukNama }}@if (!$loop->last), @endif
                                    @endforeach
                                <br>
                                @php
                                    $no_jenis++;
                                @endphp
                            @endforeach
                        </span> 
                        <div class="input_klasifikasi">
                            <select name="bentuk_kekerasan[]" id="bentuk_kekerasan" onchange="getKategoriKasus()" multiple="multiple" style="width: 100%"  data-placeholder="Dapat dipilih lebih dari 1 bentuk kekerasan">
                                @if (count($bentuk_kekerasan) > 0)
                                    @foreach ($bentuk_kekerasan as $item)
                                        <option value="{{ $item->value }}" selected>{{ $item->nama }}</option>
                                    @endforeach
                                @endif
                            </select> 
                        </div>
                    </td>
                </tr>
                <tr id="sumber_rujukan_kasus">
                    <td style="width: 200px">Kategori Kasus</td>
                    <td style="width: 1%">:</td>
                    <td>
                        <span class="data_klasifikasi">
                            @foreach ($kategori_kasus as $item)
                                {{ $item->nama }}@if (!$loop->last), @endif 
                            @endforeach
                        </span> 
                        <div class="input_klasifikasi">
                            <select name="kategori_kasus[]" id="kategori_kasus" multiple="multiple" style="width: 100%"  data-placeholder="Dapat dipilih lebih dari 1 kategori kasus">
                                @if (count($kategori_kasus) > 0)
                                    @foreach ($kategori_kasus as $item)
                                        <option value="{{ $item->value }}" selected>{{ $item->nama }}</option>
                                    @endforeach
                                @endif
                            </select> 
                        </div>
                    </td>
                </tr>
            </table>
            </form>
        </div>

        <div class="post clearfix" style="color:black">
            <b id="anchor_pelaporan">B. IDENTITAS PELAPOR</b>
            <br>
            <form action="{{ route('formpenerimapengaduan.update', 'uuid') }}" method="POST">
                @csrf
                @method('put')
                <input type="hidden" name="uuid" value="{{ $pelapor->uuid }}">
                <input type="hidden" name="data_update" value="pelapor">
                <span style="float:right" class="akses_petugas">
                    <a class="btn btn-xs bg-gradient-warning" id="tombol_edit_pelapor" onclick="editdata('pelapor')">
                    <i class="fas fa-edit"></i> Edit
                    </a>
                    <button type="submit" class="btn btn-xs bg-gradient-success" id="tombol_save_pelapor">
                    <i class="fas fa-check"></i> Save
                    </button>
                </span>
                <span style="color: red" class="input_pelapor">*merubah data ini akan merubah pula data pada kasus yang terkait</span>
                <table class="table table-bottom table-sm">
                    <tr id="nik_pelapor">
                        <td style="width: 200px">NIK</td>
                        <td style="width: 1%">:</td>
                        <td><span class="data_pelapor">{{ $pelapor->nik }}</span> <input type="number" name="nik" value="{{ $pelapor->nik }}" class="input_pelapor"></td>
                    </tr>
                    <tr id="nama_pelapor">
                        <td style="width: 200px">Nama</td>
                        <td style="width: 1%">:</td>
                        <td><span class="data_pelapor">{{ $pelapor->nama }}</span> <input type="text" name="nama" value="{{ $pelapor->nama }}" class="input_pelapor"></td>
                    </tr>
                    <tr id="tanggal_lahir_pelapor">
                        <td style="width: 200px">Tempat/Tgl Lahir</td>
                        <td style="width: 1%">:</td>
                        <td>
                            <span class="data_pelapor" id="tempat_lahir_pelapor">{{ $pelapor->tempat_lahir }}</span> 
                            <input type="text" name="tempat_lahir" value="{{ $pelapor->tempat_lahir }}" class="input_pelapor">, 
                            <span class="data_pelapor">
                                {{ $pelapor->tanggal_lahir ? date('d M Y', strtotime($pelapor->tanggal_lahir)) : '' }} ({{ $pelapor->tanggal_lahir ? Carbon\Carbon::parse($pelapor->tanggal_lahir)->age.' tahun' : ' '}})
                            </span> 
                            <input type="date" name="tanggal_lahir" value="{{ $pelapor->tanggal_lahir }}" class="input_pelapor">
                        </td>
                    </tr>
                    <tr id="jenis_kelamin_pelapor">
                        <td style="width: 200px">Jenis Kelamin</td>
                        <td style="width: 1%">:</td>
                        <td>
                            <span class="data_pelapor">{{ $pelapor->jenis_kelamin }}</span> 
                            <select name="jenis_kelamin" class="input_pelapor select2bs4" style="width: 100%;">
                                <option value="perempuan" {{ "perempuan" == $pelapor->jenis_kelamin ? 'selected' : '' }}>Perempuan</option>
                                <option value="laki-laki" {{ "laki-laki" == $pelapor->jenis_kelamin ? 'selected' : '' }}>Laki-laki</option>
                            </select>
                        </td>
                    </tr>
                    <tr id="alamat_ktp_pelapor">
                        <td style="width: 200px">Alamat KTP</td>
                        <td style="width: 1%">:</td>
                        <td><span class="data_pelapor">{{ $pelapor->alamat_ktp }}</span> 
                            <input type="text" name="alamat_ktp" value="{{ $pelapor->alamat_ktp }}" class="input_pelapor">, 
                            <b>Provinsi</b> <span class="data_pelapor">{{ $pelapor->provinsi_ktp }}</span> 
                            <select name="provinsi_id_ktp" class="input_pelapor select2bs4" id="provinsi_id_pelapor_ktp" onchange="getkotkab('pelapor_ktp')" style="width:100%">
                                <option value=""></option>
                                @foreach ($provinsi as $item)
                                    <option value="{{ $item->code }}" {{ $item->code == $pelapor->provinsi_id_ktp ? 'selected' : '' }}>{{ $item->name }}</option>
                                @endforeach
                            </select>,
                            <b>Kota</b> <span class="data_pelapor">{{ $pelapor->kota_ktp }}</span> 
                            <select name="kotkab_id_ktp" class="input_pelapor select2bs4" id="kota_id_pelapor_ktp" onchange="getkecamatan('pelapor_ktp')" style="width:100%">
                            </select>, 
                            <b>Kecamatan</b> <span class="data_pelapor">{{ $pelapor->kecamatan_ktp }}</span> 
                            <select name="kecamatan_id_ktp" class="input_pelapor select2bs4" id="kecamatan_id_pelapor_ktp" onchange="getkelurahan('pelapor_ktp')" style="width:100%">
                            </select>,
                            <b>Kelurahan</b> <span class="data_pelapor">{{ $pelapor->kelurahan_ktp }}</span> 
                            <select name="kelurahan_id_ktp" class="input_pelapor select2bs4" id="kelurahan_id_pelapor_ktp" style="width:100%">
                            </select>
                        </td>
                    </tr>
                    <tr id="alamat_pelapor">
                        <td style="width: 200px">Alamat Domisili</td>
                        <td style="width: 1%">:</td>
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
                            <select name="kecamatan_id" class="input_pelapor select2bs4" id="kecamatan_id_pelapor" onchange="getkelurahan('pelapor')" style="width:100%">
                            </select>,
                            <b>Kelurahan</b> <span class="data_pelapor">{{ $pelapor->kelurahan }}</span> 
                            <select name="kelurahan_id" class="input_pelapor select2bs4" id="kelurahan_id_pelapor" style="width:100%">
                            </select>
                        </td>
                    </tr>
                    <tr id="agama_pelapor">
                        <td style="width: 200px">Agama</td>
                        <td style="width: 1%">:</td>
                        <td>
                            <span class="data_pelapor">{{ $pelapor->agama }}</span> 
                            <select name="agama" class="input_pelapor select2bs4" style="width: 100%;">
                                @foreach ($agama as $item)
                                    <option value="{{ $item }}" {{ $item == $pelapor->agama ? 'selected' : '' }}>{{ $item }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr id="status_kawin_pelapor">
                        <td style="width: 200px">Status Perkawinan</td>
                        <td style="width: 1%">:</td>
                        <td>
                            <span class="data_pelapor">{{ $pelapor->status_kawin }}</span> 
                            <select name="status_kawin" class="input_pelapor select2bs4" style="width: 100%;">
                                @foreach ($status_perkawinan as $item)
                                    <option value="{{ $item }}" {{ $item == $pelapor->status_kawin ? 'selected' : '' }}>{{ $item }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr id="pekerjaan_pelapor">
                        <td style="width: 200px">Pekerjaan</td>
                        <td style="width: 1%">:</td>
                        <td>
                            <span class="data_pelapor">{{ $pelapor->pekerjaan }}</span> 
                            <select name="pekerjaan" class="input_pelapor select2bs4" style="width: 100%;">
                                @foreach ($pekerjaan as $item)
                                    <option value="{{ $item }}" {{ $item == $pelapor->pekerjaan ? 'selected' : '' }}>{{ $item }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr id="kewarganegaraan_pelapor">
                        <td style="width: 200px">Kewarganegaraan</td>
                        <td style="width: 1%">:</td>
                        <td>
                            <span class="data_pelapor">{{ $pelapor->kewarganegaraan }}</span> 
                            <select name="kewarganegaraan" class="input_pelapor select2bs4" style="width: 100%;">
                                <option value="WNI" {{ "WNI" == $pelapor->kewarganegaraan ? 'selected' : '' }}>WNI</option>
                                <option value="WNA" {{ "WNA" == $pelapor->kewarganegaraan ? 'selected' : '' }}>WNA</option>
                            </select>
                        </td>
                    </tr>
                    <tr id="pendidikan_pelapor">
                        <td style="width: 200px">Pendidikan</td>
                        <td style="width: 1%">:</td>
                        <td>
                            <span class="data_pelapor">{{ $pelapor->pendidikan }}</span> 
                            <select name="pendidikan" class="input_pelapor select2bs4" style="width: 100%;">
                                <option value=""></option>
                                @foreach ($pendidikan_terakhir as $item)
                                    <option value="{{ $item }}" {{ $item == $pelapor->pendidikan ? 'selected' : '' }}>{{ $item }}</option>
                                @endforeach
                            </select>
                            (<span class="data_pelapor">{{ $pelapor->status_pendidikan }}</span> 
                            <select name="status_pendidikan" class="input_pelapor select2bs4" style="width: 100%;">
                                <option value=""></option>
                                @foreach ($status_pendidikan as $item)
                                    <option value="{{ $item }}" {{ $item == $pelapor->status_pendidikan ? 'selected' : '' }}>{{ $item }}</option>
                                @endforeach
                            </select>
                            )
                        </td>
                    </tr>
                    <tr id="no_telp_pelapor">
                        <td style="width: 200px">No Telp</td>
                        <td style="width: 1%">:</td>
                        <td>
                            <span class="data_pelapor">{{ $pelapor->no_telp }}</span> 
                            <input type="text" name="no_telp" value="{{ $pelapor->no_telp }}" class="input_pelapor">
                        </td>
                    </tr>
                    <tr class="input_pelapor">
                        <td colspan="3">
                            <span style="color: green">*merubah data "Hubungan dengan klien" tidak merubah data pada kasus terkait. Hubungan dengan Klien tergantung masing-masing klien </span>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <div class="post clearfix" style="color:black">
            <b>C. IDENTITAS KORBAN</b>
            {{-- id_klien_modal_agenda untuk modal agenda  --}}
            <input type="hidden" id="id_klien_modal_agenda" value="{{ $klien->id }}">
            <input type="hidden" id="nama_klien_modal_agenda" value="{{ $klien->nama }}">
            <form action="{{ route('formpenerimapengaduan.update', 'uuid') }}" method="POST">
            @csrf
            @method('put')
            <input type="hidden" name="uuid" value="{{ $klien->uuid }}">
            <input type="hidden" name="data_update" value="klien">
            <span style="float:right" class="akses_petugas">
                <a class="btn btn-xs bg-gradient-warning" id="tombol_edit_klien" onclick="editdata('klien')">
                <i class="fas fa-edit"></i> Edit
                </a>
                <button type="submit" class="btn btn-xs bg-gradient-success" id="tombol_save_klien">
                <i class="fas fa-check"></i> Save
                </button>
            </span>
            <table class="table table-bottom table-sm">
                <tr id="nik_klien">
                    <td style="width: 200px">NIK</td>
                    <td style="width: 1%">:</td>
                    <td><span class="data_klien">{{ $klien->nik }}</span> <input type="number" name="nik" value="{{ $klien->nik }}" class="input_klien"></td>
                </tr>
                <tr id="nama_klien">
                    <td style="width: 200px">Nama</td>
                    <td style="width: 1%">:</td>
                    <td><span class="data_klien">{{ $klien->nama }}</span> <input type="text" name="nama" value="{{ $klien->nama }}" class="input_klien"></td>
                </tr>
                <tr id="tanggal_lahir_klien">
                    <td style="width: 200px">Tempat/Tgl Lahir</td>
                    <td style="width: 1%">:</td>
                    <td>
                        <span class="data_klien" id="tempat_lahir_klien">{{ $klien->tempat_lahir }}</span> 
                        <input type="text" name="tempat_lahir" value="{{ $klien->tempat_lahir }}" class="input_klien">, 
                        <span class="data_klien">
                            {{ $klien->tanggal_lahir ? date('d M Y', strtotime($klien->tanggal_lahir)) : '' }} ({{ $klien->tanggal_lahir ? Carbon\Carbon::parse($klien->tanggal_lahir)->age.' tahun' : ' '}})
                        </span> 
                        <input type="date" name="tanggal_lahir" value="{{ $klien->tanggal_lahir }}" class="input_klien">
                    </td>
                </tr>
                <tr id="jenis_kelamin_klien">
                    <td style="width: 200px">Jenis Kelamin</td>
                    <td style="width: 1%">:</td>
                    <td>
                        <span class="data_klien">{{ $klien->jenis_kelamin }}</span> 
                        <select name="jenis_kelamin" class="input_klien select2bs4" style="width: 100%;">
                            <option value="perempuan" {{ "perempuan" == $klien->jenis_kelamin ? 'selected' : '' }}>Perempuan</option>
                            <option value="laki-laki" {{ "laki-laki" == $klien->jenis_kelamin ? 'selected' : '' }}>Laki-laki</option>
                        </select>
                    </td>
                </tr>
                <tr id="alamat_ktp_klien">
                    <td style="width: 200px">Alamat KTP</td>
                    <td style="width: 1%">:</td>
                    <td>
                        <span class="data_klien">{{ $klien->alamat_ktp }}</span> 
                        <input type="text" name="alamat_ktp" value="{{ $klien->alamat_ktp }}" class="input_klien">, 
                        <b>Provinsi</b> <span class="data_klien">{{ $klien->provinsi_ktp }}</span> 
                        <select name="provinsi_id_ktp" class="input_klien select2bs4" id="provinsi_id_klien_ktp" onchange="getkotkab('klien_ktp')" style="width:100%">
                            <option value=""></option>
                            @foreach ($provinsi as $item)
                                <option value="{{ $item->code }}" {{ $item->code == $klien->provinsi_id_ktp ? 'selected' : '' }}>{{ $item->name }}</option>
                            @endforeach
                        </select>,
                        <b>Kota</b> <span class="data_klien">{{ $klien->kota_ktp }}</span> 
                        <select name="kotkab_id_ktp" class="input_klien select2bs4" id="kota_id_klien_ktp" onchange="getkecamatan('klien_ktp')" style="width:100%">
                        </select>, 
                        <b>Kecamatan</b> <span class="data_klien">{{ $klien->kecamatan_ktp }}</span> 
                        <select name="kecamatan_id_ktp" class="input_klien select2bs4" id="kecamatan_id_klien_ktp" onchange="getkelurahan('klien_ktp')" style="width:100%">
                            <option value="" selected></option>
                        </select>,
                        <b>Kelurahan</b> <span class="data_klien">{{ $klien->kelurahan_ktp }}</span> 
                        <select name="kelurahan_id_ktp" class="input_klien select2bs4" id="kelurahan_id_klien_ktp" style="width:100%">
                            <option value="" selected></option>
                        </select>
                    </td>
                </tr>
                <tr id="alamat_klien">
                    <td style="width: 200px">Alamat Domisili</td>
                    <td style="width: 1%">:</td>
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
                        <select name="kecamatan_id" class="input_klien select2bs4" id="kecamatan_id_klien" onchange="getkelurahan('klien')" style="width:100%">
                            <option value="" selected></option>
                        </select>,
                        <b>Kelurahan</b> <span class="data_klien">{{ $klien->kelurahan }}</span> 
                        <select name="kelurahan_id" class="input_klien select2bs4" id="kelurahan_id_klien" style="width:100%">
                            <option value="" selected></option>
                        </select>
                    </td>
                </tr>
                <tr id="agama_klien">
                    <td style="width: 200px">Agama</td>
                    <td style="width: 1%">:</td>
                    <td>
                        <span class="data_klien">{{ $klien->agama }}</span> 
                        <select name="agama" class="input_klien select2bs4" style="width: 100%;">
                            @foreach ($agama as $item)
                                <option value="{{ $item }}" {{ $item == $klien->agama ? 'selected' : '' }}>{{ $item }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr id="status_kawin_klien">
                    <td style="width: 200px">Status Perkawinan</td>
                    <td style="width: 1%">:</td>
                    <td>
                        <span class="data_klien">{{ $klien->status_kawin }}</span> 
                        <select name="status_kawin" class="input_klien select2bs4" style="width: 100%;">
                            @foreach ($status_perkawinan as $item)
                                <option value="{{ $item }}" {{ $item == $klien->status_kawin ? 'selected' : '' }}>{{ $item }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr id="pekerjaan_klien">
                    <td style="width: 200px">Pekerjaan</td>
                    <td style="width: 1%">:</td>
                    <td>
                        <span class="data_klien">{{ $klien->pekerjaan }}</span> 
                        <select name="pekerjaan" class="input_klien select2bs4" style="width: 100%;">
                            @foreach ($pekerjaan as $item)
                                <option value="{{ $item }}" {{ $item == $klien->pekerjaan ? 'selected' : '' }}>{{ $item }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr id="kewarganegaraan_klien">
                    <td style="width: 200px">Kewarganegaraan</td>
                    <td style="width: 1%">:</td>
                    <td>
                        <span class="data_klien">{{ $klien->kewarganegaraan }}</span> 
                        <select name="kewarganegaraan" class="input_klien select2bs4" style="width: 100%;">
                            <option value="WNI" {{ "WNI" == $klien->kewarganegaraan ? 'selected' : '' }}>WNI</option>
                            <option value="WNA" {{ "WNA" == $klien->kewarganegaraan ? 'selected' : '' }}>WNA</option>
                        </select>
                    </td>
                </tr>
                <tr id="pendidikan_klien">
                    <td style="width: 200px">Pendidikan</td>
                    <td style="width: 1%">:</td>
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
                <tr id="no_telp_klien">
                    <td style="width: 200px">No Telp</td>
                    <td style="width: 1%">:</td>
                    <td>
                        <span class="data_klien">{{ $klien->no_telp }}</span> 
                        <input type="text" name="no_telp" value="{{ $klien->no_telp }}" class="input_klien">
                    </td>
                </tr>
                <tr id="kedisabilitasan_klien">
                    <td style="width: 200px">Kedisabilitasan</td>
                    <td style="width: 1%">:</td>
                    <td>
                        <span class="data_klien">{{ $klien->kedisabilitasan }}</span> 
                        <select name="kedisabilitasan" class="input_klien select2bs4" style="width: 100%;">
                                <option value="Non Disabilitas" {{ "Non Disabilitas" == $klien->kedisabilitasan ? 'selected' : '' }}>Non Disabilitas</option>
                                <option value="Disabilitas" {{ "Disabilitas" == $klien->kedisabilitasan ? 'selected' : '' }}>Disabilitas</option>
                                <option value="Tidak Diketahui" {{ "Tidak Diketahui" == $klien->kedisabilitasan ? 'selected' : '' }}>Tidak Diketahui</option>
                        </select>
                    </td>
                </tr>
            </table>
            </form>
        </div>
        <div class="post clearfix" id="data_terlapor" style="color:black">
            <b>D. IDENTITAS TERLAPOR</b>
            <?php $no_terlapor = 1;?>
            @foreach ($terlapor as $item_terlapor)
            <form action="{{ route('formpenerimapengaduan.update', 'uuid') }}" method="POST" id="terlapor{{ $item_terlapor->uuid }}">
            @csrf
            @method('put')
            <input type="hidden" name="uuid" value="{{ $item_terlapor->uuid }}">
            <input type="hidden" name="klien_id" value="{{ $klien->id }}">
            <input type="hidden" name="terlapor_id" value="{{ $item_terlapor->id }}">
            <input type="hidden" name="data_update" value="terlapor">
            <span style="color: red" class="input_terlapor">*merubah data ini akan merubah pula data pada kasus yang terkait</span>
            <br>
            <b> Terlapor {{ $no_terlapor }}</b>
            <span style="float:right" class="akses_petugas">
                <a class="btn btn-xs bg-gradient-danger" onclick="deleteTerlapor('{{ $item_terlapor->uuid }}')">
                <i class="fas fa-trash"></i> Delete
                </a>
                <a class="btn btn-xs bg-gradient-warning" id="tombol_edit_terlapor{{ $no_terlapor }}" onclick="editdata('terlapor{{ $no_terlapor }}')">
                <i class="fas fa-edit"></i> Edit
                </a>
                <button type="submit" class="btn btn-xs bg-gradient-success tombol_save_terlapor" id="tombol_save_terlapor{{ $no_terlapor }}">
                <i class="fas fa-check"></i> Save
                </button>
            </span>
                <table class="table table-bottom table-sm">
                    <tr id="nik_terlapor{{ $no_terlapor }}">
                        <td style="width: 200px">NIK</td>
                        <td style="width: 1%">:</td>
                        <td><span class="data_terlapor{{ $no_terlapor }}">{{ $item_terlapor->nik }}</span> <input type="number" name="nik" value="{{ $item_terlapor->nik }}" class="input_terlapor input_terlapor{{ $no_terlapor }}"></td>
                    </tr>
                    <tr id="nama_terlapor{{ $no_terlapor }}">
                        <td style="width: 200px">Nama</td>
                        <td style="width: 1%">:</td>
                        <td><span class="data_terlapor{{ $no_terlapor }}">{{ $item_terlapor->nama }}</span> <input type="text" name="nama" value="{{ $item_terlapor->nama }}" class="input_terlapor input_terlapor{{ $no_terlapor }}"></td>
                    </tr>
                    <tr id="tempat_tanggal_lahir_terlapor{{ $no_terlapor }}">
                        <td style="width: 200px">Tempat/Tgl Lahir</td>
                        <td style="width: 1%">:</td>
                        <td>
                            <span class="data_terlapor{{ $no_terlapor }}" id="tempat_lahir_terlapor{{ $no_terlapor }}">{{ $item_terlapor->tempat_lahir }}</span> 
                            <input type="text" name="tempat_lahir" value="{{ $item_terlapor->tempat_lahir }}" class="input_terlapor input_terlapor{{ $no_terlapor }}">, 
                            <span class="data_terlapor{{ $no_terlapor }}">
                                {{ $item_terlapor->tanggal_lahir ? date('d M Y', strtotime($item_terlapor->tanggal_lahir)) : '' }} ({{ $item_terlapor->tanggal_lahir ? Carbon\Carbon::parse($item_terlapor->tanggal_lahir)->age.' tahun' : ' '}})
                            </span> 
                            <input type="date" name="tanggal_lahir" value="{{ $item_terlapor->tanggal_lahir }}" class="input_terlapor input_terlapor{{ $no_terlapor }}">
                        </td>
                    </tr>
                    <tr id="jenis_kelamin_terlapor{{ $no_terlapor }}">
                        <td style="width: 200px">Jenis Kelamin</td>
                        <td style="width: 1%">:</td>
                        <td>
                            <span class="data_terlapor{{ $no_terlapor }}">{{ $item_terlapor->jenis_kelamin }}</span> 
                            <select name="jenis_kelamin" class="input_terlapor input_terlapor{{ $no_terlapor }} select2bs4" style="width: 100%;">
                                <option value="perempuan" {{ 'perempuan' == $item_terlapor->jenis_kelamin ? 'selected' : '' }}>Perempuan</option>
                                <option value="laki-laki" {{ 'laki-laki' == $item_terlapor->jenis_kelamin ? 'selected' : '' }}>Laki-laki</option>
                            </select>
                        </td>
                    </tr>
                    <tr id="alamat_terlapor_ktp{{ $no_terlapor }}">
                        <td style="width: 200px">Alamat KTP</td>
                    <td style="width: 1%">:</td>
                    <td><span class="data_terlapor{{ $no_terlapor }}">{{ $item_terlapor->alamat_ktp }}</span> 
                        <input type="text" name="alamat_ktp" value="{{ $item_terlapor->alamat_ktp }}" class="input_terlapor input_terlapor{{ $no_terlapor }}">, 
                        <b>Provinsi</b> <span class="data_terlapor{{ $no_terlapor }}">{{ $item_terlapor->provinsi_ktp }}</span> 
                        <select name="provinsi_id_ktp" class="input_terlapor input_terlapor{{ $no_terlapor }} select2bs4" id="provinsi_id_terlapor_ktp{{ $no_terlapor }}" onchange="getkotkab('terlapor_ktp{{ $no_terlapor }}')" style="width:100%">
                            <option value=""></option>
                            @foreach ($provinsi as $item)
                                <option value="{{ $item->code }}" {{ $item->code == $item_terlapor->provinsi_id_ktp ? 'selected' : '' }}>{{ $item->name }}</option>
                            @endforeach
                        </select>,
                        <b>Kota</b> <span class="data_terlapor{{ $no_terlapor }}">{{ $item_terlapor->kota_ktp }}</span> 
                        <select name="kotkab_id_ktp" class="input_terlapor input_terlapor{{ $no_terlapor }} select2bs4" id="kota_id_terlapor_ktp{{ $no_terlapor }}" onchange="getkecamatan('terlapor_ktp{{ $no_terlapor }}')" style="width:100%">
                        </select>, 
                        <b>Kecamatan</b> <span class="data_terlapor{{ $no_terlapor }}">{{ $item_terlapor->kecamatan_ktp }}</span> 
                        <select name="kecamatan_id_ktp" class="input_terlapor input_terlapor{{ $no_terlapor }} select2bs4" id="kecamatan_id_terlapor_ktp{{ $no_terlapor }}" onchange="getkelurahan('terlapor_ktp{{ $no_terlapor }}')" style="width:100%">
                            <option value="" selected></option>
                        </select>,
                        <b>Kelurahan</b> <span class="data_terlapor{{ $no_terlapor }}">{{ $item_terlapor->kelurahan_ktp }}</span> 
                        <select name="kelurahan_id_ktp" class="input_terlapor input_terlapor{{ $no_terlapor }} select2bs4" id="kelurahan_id_terlapor_ktp{{ $no_terlapor }}" style="width:100%">
                            <option value="" selected></option>
                        </select>
                    </td>
                    </tr>
                    <tr id="alamat_terlapor{{ $no_terlapor }}">
                        <td style="width: 200px">Alamat Domisili</td>
                    <td style="width: 1%">:</td>
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
                        <select name="kecamatan_id" class="input_terlapor input_terlapor{{ $no_terlapor }} select2bs4" id="kecamatan_id_terlapor{{ $no_terlapor }}" onchange="getkelurahan('terlapor{{ $no_terlapor }}')" style="width:100%">
                            <option value="" selected></option>
                        </select>,
                        <b>Kelurahan</b> <span class="data_terlapor{{ $no_terlapor }}">{{ $item_terlapor->kelurahan }}</span> 
                        <select name="kelurahan_id" class="input_terlapor input_terlapor{{ $no_terlapor }} select2bs4" id="kelurahan_id_terlapor{{ $no_terlapor }}" style="width:100%">
                            <option value="" selected></option>
                        </select>
                    </td>
                    </tr>
                    <tr id="agama_terlapor{{ $no_terlapor }}">
                        <td style="width: 200px">Agama</td>
                        <td style="width: 1%">:</td>
                        <td>
                            <span class="data_terlapor{{ $no_terlapor }}">{{ $item_terlapor->agama }}</span> 
                            <select name="agama" class="input_terlapor input_terlapor{{ $no_terlapor }} select2bs4" style="width: 100%;">
                                @foreach ($agama as $item)
                                    <option value="{{ $item }}" {{ $item == $item_terlapor->agama ? 'selected' : '' }}>{{ $item }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr id="status_kawin_terlapor{{ $no_terlapor }}">
                        <td style="width: 200px">Status Perkawinan</td>
                        <td style="width: 1%">:</td>
                        <td>
                            <span class="data_terlapor{{ $no_terlapor }}">{{ $item_terlapor->status_kawin }}</span> 
                            <select name="status_kawin" class="input_terlapor input_terlapor{{ $no_terlapor }} select2bs4" style="width: 100%;">
                                @foreach ($status_perkawinan as $item)
                                    <option value="{{ $item }}" {{ $item == $item_terlapor->status_kawin ? 'selected' : '' }}>{{ $item }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr id="pekerjaan_terlapor{{ $no_terlapor }}">
                        <td style="width: 200px">Pekerjaan</td>
                        <td style="width: 1%">:</td>
                        <td>
                            <span class="data_terlapor{{ $no_terlapor }}">{{ $item_terlapor->pekerjaan }}</span> 
                            <select name="pekerjaan" class="input_terlapor input_terlapor{{ $no_terlapor }} select2bs4" style="width: 100%;">
                                @foreach ($pekerjaan as $item)
                                    <option value="{{ $item }}" {{ $item == $item_terlapor->pekerjaan ? 'selected' : '' }}>{{ $item }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr id="kewarganegaraan_terlapor{{ $no_terlapor }}">
                        <td style="width: 200px">Kewarganegaraan</td>
                        <td style="width: 1%">:</td>
                        <td>
                            <span class="data_terlapor{{ $no_terlapor }}">{{ $item_terlapor->kewarganegaraan }}</span> 
                            <select name="kewarganegaraan" class="input_terlapor input_terlapor{{ $no_terlapor }} select2bs4" style="width: 100%;">
                                <option value="WNI" {{ "WNI" == $item_terlapor->kewarganegaraan ? 'selected' : '' }}>WNI</option>
                                <option value="WNA" {{ "WNA" == $item_terlapor->kewarganegaraan ? 'selected' : '' }}>WNA</option>
                            </select>
                        </td>
                    </tr>
                    <tr id="pendidikan_terlapor{{ $no_terlapor }}">
                        <td style="width: 200px">Pendidikan</td>
                        <td style="width: 1%">:</td>
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
                    <tr id="no_telp_terlapor{{ $no_terlapor }}">
                        <td style="width: 200px">No Telp</td>
                        <td style="width: 1%">:</td>
                        <td>
                            <span class="data_terlapor{{ $no_terlapor }}">{{ $item_terlapor->no_telp }}</span> 
                            <input type="text" name="no_telp" value="{{ $item_terlapor->no_telp }}" class="input_terlapor input_terlapor{{ $no_terlapor }}">
                        </td>
                    </tr>
                    <tr id="hubungan_terlapor{{ $no_terlapor }}">
                        <td style="width: 200px">Hubungan dengan klien (Terlapor siapanya Klien?)</td>
                        <td style="width: 1%">:</td>
                        <td>
                            <span class="data_terlapor{{ $no_terlapor }}">{{ $item_terlapor->hubungan_terlapor }}</span> 
                            <select name="hubungan_terlapor" class="input_terlapor input_terlapor{{ $no_terlapor }} select2bs4" style="width: 100%;" required>
                                <option value=""></option>
                                @foreach ($hubungan_dengan_klien as $item)
                                    <option value="{{ $item }}" {{ $item_terlapor->hubungan_terlapor == $item ? 'selected' : '' }}>{{ $item }}</option>
                                @endforeach
                            </select>
                        </td>
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

            <div class="akses_petugas" style="width:100%">
                <button type="submit" class="btn btn-block btn-default" id="buttonTerlapor" onclick="TambahTerlapor()"><i class="fas fa-plus"></i> Tambah Terlapor</button>
            </div>
            <form action="{{ route('formpenerimapengaduan.store_terlapor') }}" method="POST" id="formTerlapor">
                @csrf
                <input type="hidden" name="klien_id" value="{{ $klien->id }}">
                <input type="hidden" name="kasus_id" value="{{ $kasus->id }}">
                <input type="hidden" name="data_update" value="terlapor">
                <span style="color: red" class="input_terlapor">*merubah data ini akan merubah pula data pada kasus yang terkait</span>
                <br>
                <b> Terlapor {{ $no_terlapor }}</b>
                <span style="float:right" class="akses_petugas">
                    <button type="submit" class="btn btn-xs bg-gradient-success" id="tombol_save_terlapor{{ $no_terlapor }}">
                    <i class="fas fa-check"></i> Save
                    </button>
                </span>
                    <table class="table table-bottom table-sm">
                        <tr id="nik_terlapor{{ $no_terlapor }}">
                            <td style="width: 200px">NIK</td>
                            <td style="width: 1%">:</td>
                            <td><input type="number" name="nik" class=" input_terlapor{{ $no_terlapor }}"></td>
                        </tr>
                        <tr id="nama_terlapor{{ $no_terlapor }}">
                            <td style="width: 200px">Nama</td>
                            <td style="width: 1%">:</td>
                            <td><input type="text" name="nama" class=" input_terlapor{{ $no_terlapor }}"></td>
                        </tr>
                        <tr id="tempat_tanggal_lahir_terlapor{{ $no_terlapor }}">
                            <td style="width: 200px">Tempat/Tgl Lahir</td>
                            <td style="width: 1%">:</td>
                            <td>
                                <input type="text" name="tempat_lahir" class=" input_terlapor{{ $no_terlapor }}" placeholder="Tempat Lahir">,
                                <input type="date" name="tanggal_lahir" class=" input_terlapor{{ $no_terlapor }}" placeholder="Tanggal Lahir">
                            </td>
                        </tr>
                        <tr id="jenis_kelamin_terlapor{{ $no_terlapor }}">
                            <td style="width: 200px">Jenis Kelamin</td>
                            <td style="width: 1%">:</td>
                            <td>
                                <select name="jenis_kelamin" class=" input_terlapor{{ $no_terlapor }} select2bs4" style="width: 100%;">
                                    <option value="perempuan">Perempuan</option>
                                    <option value="laki-laki">Laki-laki</option>
                                </select>
                            </td>
                        </tr>
                        <tr id="alamat_terlapor_ktp{{ $no_terlapor }}">
                            <td style="width: 200px">Alamat KTP</td>
                            <td style="width: 1%">:</td>
                            <td>
                                <input type="text" name="alamat_ktp" lass=" input_terlapor{{ $no_terlapor }}">, 
                                <b>Provinsi</b> 
                                <select name="provinsi_id_ktp" class=" input_terlapor{{ $no_terlapor }} select2bs4" id="provinsi_id_terlapor_ktp{{ $no_terlapor }}" onchange="getkotkab('terlapor_ktp{{ $no_terlapor }}')" style="width:100%">
                                    <option value=""></option>
                                    @foreach ($provinsi as $item)
                                        <option value="{{ $item->code }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>,
                                <b>Kota</b> 
                                <select name="kotkab_id_ktp" class=" input_terlapor{{ $no_terlapor }} select2bs4" id="kota_id_terlapor_ktp{{ $no_terlapor }}" onchange="getkecamatan('terlapor_ktp{{ $no_terlapor }}')" style="width:100%">
                                </select>, 
                                <b>Kecamatan</b> 
                                <select name="kecamatan_id_ktp" class=" input_terlapor{{ $no_terlapor }} select2bs4" id="kecamatan_id_terlapor_ktp{{ $no_terlapor }}" onchange="getkelurahan('terlapor_ktp{{ $no_terlapor }}')" style="width:100%">
                                    <option value="" selected></option>
                                </select>,
                                <b>Kelurahan</b> 
                                <select name="kelurahan_id_ktp" class=" input_terlapor{{ $no_terlapor }} select2bs4" id="kelurahan_id_terlapor_ktp{{ $no_terlapor }}" style="width:100%">
                                    <option value="" selected></option>
                                </select>
                            </td>
                        </tr>
                        <tr id="alamat_terlapor{{ $no_terlapor }}">
                            <td style="width: 200px">Alamat Domisili</td>
                        <td style="width: 1%">:</td>
                        <td>
                            <input type="text" name="alamat" class=" input_terlapor{{ $no_terlapor }}">, 
                            <b>Provinsi</b>
                            <select name="provinsi_id" class=" input_terlapor{{ $no_terlapor }} select2bs4" id="provinsi_id_terlapor{{ $no_terlapor }}" onchange="getkotkab('terlapor{{ $no_terlapor }}')" style="width:100%">
                                <option value=""></option>
                                @foreach ($provinsi as $item)
                                    <option value="{{ $item->code }}">{{ $item->name }}</option>
                                @endforeach
                            </select>,
                            <b>Kota</b> 
                            <select name="kotkab_id" class=" input_terlapor{{ $no_terlapor }} select2bs4" id="kota_id_terlapor{{ $no_terlapor }}" onchange="getkecamatan('terlapor{{ $no_terlapor }}')" style="width:100%">
                            </select>, 
                            <b>Kecamatan</b>
                            <select name="kecamatan_id" class=" input_terlapor{{ $no_terlapor }} select2bs4" id="kecamatan_id_terlapor{{ $no_terlapor }}" onchange="getkelurahan('terlapor{{ $no_terlapor }}')" style="width:100%">
                                <option value="" selected></option>
                            </select>,
                            <b>Kelurahan</b>
                            <select name="kelurahan_id" class=" input_terlapor{{ $no_terlapor }} select2bs4" id="kelurahan_id_terlapor{{ $no_terlapor }}" style="width:100%">
                                <option value="" selected></option>
                            </select>
                        </td>
                        </tr>
                        <tr id="agama_terlapor{{ $no_terlapor }}">
                            <td style="width: 200px">Agama</td>
                            <td style="width: 1%">:</td>
                            <td>
                                <select name="agama" class=" input_terlapor{{ $no_terlapor }} select2bs4" style="width: 100%;">
                                    @foreach ($agama as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr id="status_kawin_terlapor{{ $no_terlapor }}">
                            <td style="width: 200px">Status Perkawinan</td>
                            <td style="width: 1%">:</td>
                            <td>
                                <select name="status_kawin" class=" input_terlapor{{ $no_terlapor }} select2bs4" style="width: 100%;">
                                    @foreach ($status_perkawinan as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr id="pekerjaan_terlapor{{ $no_terlapor }}">
                            <td style="width: 200px">Pekerjaan</td>
                            <td style="width: 1%">:</td>
                            <td>
                                <select name="pekerjaan" class=" input_terlapor{{ $no_terlapor }} select2bs4" style="width: 100%;">
                                    @foreach ($pekerjaan as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr id="kewarganegaraan_terlapor{{ $no_terlapor }}">
                            <td style="width: 200px">Kewarganegaraan</td>
                            <td style="width: 1%">:</td>
                            <td>
                                <select name="kewarganegaraan" class=" input_terlapor{{ $no_terlapor }} select2bs4" style="width: 100%;">
                                    <option value="WNI">WNI</option>
                                    <option value="WNA">WNA</option>
                                </select>
                            </td>
                        </tr>
                        <tr id="pendidikan_terlapor{{ $no_terlapor }}">
                            <td style="width: 200px">Pendidikan</td>
                            <td style="width: 1%">:</td>
                            <td>
                                <select name="pendidikan" class=" input_terlapor{{ $no_terlapor }} select2bs4" style="width: 100%;">
                                    <option value=""></option>
                                    @foreach ($pendidikan_terakhir as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                                (
                                <select name="status_pendidikan" class=" input_terlapor{{ $no_terlapor }} select2bs4" style="width: 100%;">
                                    <option value=""></option>
                                    @foreach ($status_pendidikan as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                                )
                            </td>
                        </tr>
                        <tr id="no_telp_terlapor{{ $no_terlapor }}">
                            <td style="width: 200px">No Telp</td>
                            <td style="width: 1%">:</td>
                            <td>
                                <input type="text" name="no_telp" class=" input_terlapor{{ $no_terlapor }}">
                            </td>
                        </tr>
                        <tr id="hubungan_terlapor{{ $no_terlapor }}">
                            <td style="width: 200px">Hubungan dengan klien (Terlapor siapanya Klien?)</td>
                            <td style="width: 1%">:</td>
                            <td>
                                <select name="hubungan_terlapor" class=" input_terlapor{{ $no_terlapor }} select2bs4" style="width: 100%;">
                                    <option value=""></option>
                                    @foreach ($hubungan_dengan_klien as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                    </table>
                </form>
        </div>
        {{-- <div class="post clearfix" style="color:black">
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
        </div> --}}
        <br>
        <br>
        {{-- <button type="button" class="btn btn-block btn-primary akses_petugas"><i class="fas fa-print"></i> Print Formulir</button> --}}
        <br>
        {{-- <div id="kolomPublicUrl" class="akses_petugas"></div>
        <button type="button" class="btn btn-block btn-primary akses_petugas" onclick="submitPublicURL('url-kasus')"><i class="fas fa-link"></i> Generate URL</button> --}}
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
                Mohon melengkapi data asesmen pada MOKA.
                </div>
            </div>

            <div class="post clearfix" style="color:black">
                <b>ASESMEN</b>
                <form action="{{ route('asesmen.update', 'uuid') }}" method="POST">
                @csrf
                @method('put')
                <input type="hidden" name="uuid" value="{{ $rekam_kasus->uuid }}">
                <input type="hidden" name="uuid_klien" value="{{ $klien->uuid }}">
                <input type="hidden" name="data_update" value="rekam">
                <span style="float:right" class="akses_petugas">
                    <a class="btn btn-xs bg-gradient-warning" id="tombol_edit_rekam" onclick="editdata('rekam')">
                    <i class="fas fa-edit"></i> Edit
                    </a>
                    <button type="submit" class="btn btn-xs bg-gradient-success" id="tombol_save_rekam">
                    <i class="fas fa-check"></i> Save
                    </button>
                </span>
                <table class="table table-bottom table-sm">
                    <tr id="fisik_rekam">
                        <td style="width: 200px">Kondisi Fisik</td>
                        <td style="width: 1%">:</td>
                        <td>
                            <span class="data_rekam">{!! nl2br($rekam_kasus->fisik) !!}</span> <textarea name="fisik" class="input_rekam" style="width:100%" rows="10">{{ $rekam_kasus->fisik }}</textarea></span> 
                        </td>
                    </tr>
                    <tr id="psikis_rekam">
                        <td style="width: 200px">Kondisi Psikologis</td>
                        <td style="width: 1%">:</td>
                        <td>
                            <span class="data_rekam">{!! nl2br($rekam_kasus->psikologis) !!}</span> <textarea name="psikologis" class="input_rekam" style="width:100%" rows="10">{{ $rekam_kasus->psikologis }}</textarea></span> 
                        </td>
                    </tr>
                    <tr id="sosial_rekam">
                        <td style="width: 200px">Kondisi Sosial/Ekonomi</td>
                        <td style="width: 1%">:</td>
                        <td>
                            <span class="data_rekam">{!! nl2br($rekam_kasus->sosial) !!}</span> <textarea name="sosial" class="input_rekam" style="width:100%" rows="10">{{ $rekam_kasus->sosial }}</textarea></span> 
                        </td>
                    </tr>
                    <tr id="hukum_rekam">
                        <td style="width: 200px">Kondisi Hukum</td>
                        <td style="width: 1%">:</td>
                        <td>
                            <span class="data_rekam">{!! nl2br($rekam_kasus->hukum) !!}</span> <textarea name="hukum" class="input_rekam" style="width:100%" rows="10">{{ $rekam_kasus->hukum }}</textarea></span> 
                        </td>
                    </tr>
                    <tr id="upaya_rekam">
                        <td style="width: 200px">Upaya Pemecahan Masalah</td>
                        <td style="width: 1%">:</td>
                        <td>
                            <span class="data_rekam">{!! nl2br($rekam_kasus->upaya) !!}</span> <textarea name="upaya" class="input_rekam" style="width:100%" rows="10">{{ $rekam_kasus->upaya }}</textarea></span> 
                        </td>
                    </tr>
                    <tr id="pendukung_rekam">
                        <td style="width: 200px">Faktor Pendukung</td>
                        <td style="width: 1%">:</td>
                        <td>
                            <span class="data_rekam">{!! nl2br($rekam_kasus->pendukung) !!}</span> <textarea name="pendukung" class="input_rekam" style="width:100%" rows="10">{{ $rekam_kasus->pendukung }}</textarea></span> 
                        </td>
                    </tr>
                    <tr id="hambatan_rekam">
                        <td style="width: 200px">Hambatan</td>
                        <td style="width: 1%">:</td>
                        <td>
                            <span class="data_rekam">{!! nl2br($rekam_kasus->hambatan) !!}</span> <textarea name="hambatan" class="input_rekam" style="width:100%" rows="10">{{ $rekam_kasus->hambatan }}</textarea></span> 
                        </td>
                    </tr>
                    <tr id="harapan_rekam">
                        <td style="width: 200px">Harapan</td>
                        <td style="width: 1%">:</td>
                        <td>
                            <span class="data_rekam">{!! nl2br($rekam_kasus->harapan) !!}</span> <textarea name="harapan" class="input_rekam" style="width:100%" rows="10">{{ $rekam_kasus->harapan }}</textarea></span> 
                        </td>
                    </tr>
                    <tr id="lainnya_rekam">
                        <td style="width: 200px">Informasi Lainnya</td>
                        <td style="width: 1%">:</td>
                        <td>
                            <span class="data_rekam">{!! nl2br($rekam_kasus->lainnya) !!}</span> <textarea name="lainnya" class="input_rekam" style="width:100%" rows="10">{{ $rekam_kasus->lainnya }}</textarea></span> 
                        </td>
                    </tr>
                </table>
                </form>
            </div>
            {{-- <div id="kolomAsesmen"></div>
            @if (in_array(Auth::user()->jabatan, ['Manajer Kasus', 'Penerima Pengaduan', 'Unit Reaksi Cepat']) && $akses_petugas == 1)
            <button type="buttons" class="btn btn-block btn-default {{ Request::get('tambah-asesmen') == 1 ? 'hightlighting' : '' }}" id="modalAsesmen" data-toggle="modal" data-target="#tambahAsesmenModal"><i class="fas fa-plus"></i> Tambah Asesmen</button>
            @endif --}}
        </div>

    </div>
    
    <div class="tab-pane {{ Request::get('tab') == 'kasus-layanan' ? 'active' : '' }}" id="kasus-layanan" role="tabpanel" aria-labelledby="kasus-layanan-tab">
        <div class="post clearfix" style="margin: 0px">
        <b id="anchor_pelaporan">PROGRES INTERVENSI / LAYANAN</b>
        <div class="progress" style="height: 25px;">
            <div class="progress-bar bg-success persen_layanan" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"> <span style="font-size:30px" class="persen_title_layanan">100%</span></div>
        </div>
        <br>
        {{-- include tabel intervensi --}}
        @if (Auth::user()->settings_tabel_intervensi == 2)
            @include('kasus.intervensiv2')
        @else
            @include('kasus.intervensiv1')
        @endif
        <br>
        {{-- <div id="accordionResumeLayanan" >
            <div class="card card-light">
            <div class="card-header">
            <h4 class="card-title w-100">
            <a class="d-block w-100" data-toggle="collapse" href="#collapseResumeLayanan">
            <b>Resume Intervensi / Layanan</b>
            </a>
            </h4>
            </div>
            <div id="collapseResumeLayanan" class="collapse" data-parent="#accordionResumeLayanan">
            <div class="card-body">
                <div style="overflow-x: scroll">
                    <table id="tabelResumeLayanan" class="table table-sm table-bordered  table-hover" style="cursor:pointer; color:black">
                        <thead>
                        <tr>
                        <th>Waktu Kegiatan</th>
                        <th>Keyword</th>
                        <th>Petugas</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                        <tr>
                            <th>Waktu Kegiatan</th>
                            <th>Keyword</th>
                            <th>Petugas</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            </div>
            </div>
        </div>
        <br> --}}
        <div id="kolomPemantauan"></div>
        @if (Auth::user()->jabatan == 'Manajer Kasus' && $akses_petugas == 1)
        <button type="submit" class="btn btn-block btn-default" data-toggle="modal" data-target="#tambahPemantauanModal"><i class="fas fa-plus"></i> Tambah Laporan Pemantauan & Evaluasi</button>
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
                            <img alt="Avatar" class="table-avatar" src="{{ asset('img/profile/'.$item->foto) }}" style="margin-right: 10px"
                            onerror="this.onerror=null; this.src='{{ asset('adminlte/dist/img/default-150x150.png') }}'" >
                            {{ $item->name }}
                        </td>
                        <td>
                            <h6><span class="badge badge-pill badge-primary">{{ $item->jabatan }}</span></h6>
                        </td>
                        <td>
                            @if (in_array(Auth::user()->jabatan, ['Manajer Kasus', 'Penerima Pengaduan', 'Supervisor Kasus']))
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
            @if (in_array(Auth::user()->jabatan, ['Manajer Kasus', 'Penerima Pengaduan', 'Supervisor Kasus']) && $akses_petugas == 1)
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
                        <select name="user_id" class="select2bs4" style="width: 100%;" required>
                            <option></option>
                            @foreach ($users as $item)
                                <option value="{{ $item->id }}">{{ $item->name }} ({{ $item->jabatan }})</option>
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
                                    @if ($item->deleted_at)
                                        [Link Expired]
                                    @else
                                        <input hidden type="text" id="link-form-{{ $item->uuid }}" value="{{ route('persetujuan.show', $item->uuid) }}">
                                        <button type="button" class="btn btn-primary" onclick="copyClipboard('{{ $item->uuid }}')"><i class="fas fa-link"></i></button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
                *Link akan kadaluarsa setelah 2 hari
                <br>
                @if ($akses_petugas == 1)                    
                <form action="{{ route('persetujuan.create', $klien->uuid) }}" method="POST">
                    @csrf
                    <div class="row {{ Request::get('tambah-persetujuan') == 1 ? 'hightlighting' : '' }}"  style="padding : 15px">
                        <div class="col-md-9">
                            <select name="persetujuan_template_uuid" class="select2bs4" style="width: 100%;" required>
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
                @endif
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
                        @if (Auth::user()->jabatan == 'Penerima Pengaduan')
                        {{-- 
                        dibuat hanya petugas penerima pengaduan saja yang bisa mengarsipkan karena : 
                        1. banyak kasus2 yang belum sampai supervisor kasus tapi diarsipkan dahulu
                        2. yang mengarsipkan walau atas persetujuan spv tapi yang mengklik adalah penerima pengaduan  
                        --}}
                            @if (!$klien->no_klien)
                                {{-- jika tidak ada no klien berarti belum diapprove / ditolak, jadi bisa di arsipkan --}}
                                {{-- hanya Supervisor Kasus yang bisa mengarsipkan --}}
                                <input type="checkbox" class="btn-sm" id="arsipkan" 
                                {{ $klien->arsip == 0 ? 'checked' : '' }} 
                                data-bootstrap-switch 
                                data-on-text="Aktif"
                                data-off-text="Diarsipkan"
                                data-off-color="danger" 
                                data-on-color="success">
                            @else
                                Tidak dapat mengarsipkan kasus yang sudah ada no regisnya. Silahkan lakukan rapat jika kasus ini ingin diarsipkan.
                            @endif
                        @endif

                        <br>
                        <span style="display: {{ $klien->arsip == 0 ? 'show' : 'none' }}" id="status_arsip_on">Status kasus saat ini aktif, akan muncul di pencarian kasus</span>
                        <span style="display: {{ $klien->arsip == 1 ? 'show' : 'none' }}" id="status_arsip_off">Status kasus saat ini diarsipkan, tidak akan muncul di pencarian kasus</span>
                    </td>
                </tr>
                <tr class="{{ Request::get('persetujuan-supervisor') == 1 ? 'hightlighting' : '' }}">
                    <td style="width: 200px"><b>Approval<b></td>
                    <td>
                        <div class="row">
                            <div class="col-md-12 m-0 {{ Request::get('hightlight') == 'inputpersetujuankasus' ? 'hightlighting' : '' }}">
                                Apakah anda ingin menyetujui kasus ini?
                            </div>
                            @if ($klien->arsip == 1)
                                @if (Auth::user()->jabatan == 'Supervisor Kasus')
                                    <div class="col-md-12" style="color: red">
                                        *Kasus sedang diarsipkan, minta Penerima Pengaduan untuk mengaktifkan kasus ini agar bisa Approve. Atau hapus diri anda dari list petugas di kasus ini agar notifikasi hilang
                                    </div>
                                @endif
                            @else
                                @if ($klien->no_klien == null)
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

@if ($akses_petugas == 1)
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
                    <input type="text" class="form-control required-field-riwayat time-picker" id="jam">
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
@endif

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
        </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Pemantauan-->
<div class="modal fade" id="tambahPemantauanModal" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">

        <div id="overlay" class="overlay dark">
            <div class="cv-spinner">
            <span class="spinner"></span>
            </div>
        </div>
        
        <div class="modal-header">
            <h5 class="modal-title" id="modelHeadingPemantauan">Pemantauan & Evaluasi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="alert alert-danger alert-dismissible invalid-feedback" id="error-message-pemantauan">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-ban"></i> Gagal!</h4>
            <span id="message-pemantauan"></span>
        </div>
        <div class="alert alert-success alert-dismissible invalid-feedback" id="success-message-pemantauan">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Success!</h4>
            Data berhasil disimpan.
        </div>
        <div class="modal-body">
        <input type="hidden" id="uuid_pemantauan">
        <div class="col-md-12">
            <div class="form-group">
            <label>Kemajuan yang Dicapai / Kondisi Klien Saat Pemantauan : </label>
                <textarea class="form-control required-field-pemantauan" id="pemantauan_kemajuan" aria-label="With textarea" style="resize: none;" ></textarea>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
            <label>Tujuan yang Belum Tercapai : </label>
                <textarea class="form-control required-field-pemantauan" id="pemantauan_tujuan" aria-label="With textarea" style="resize: none;"></textarea>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
            <label>Rencana Tindak Lanjut : </label>
                <textarea class="form-control required-field-pemantauan" id="pemantauan_rencana" aria-label="With textarea" style="resize: none;"></textarea>
            </div>
        </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success btn-block" id="submitPemantauan"><i class="fa fa-check"></i> Simpan</button>
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
                        <div id="kontenDokumen"></div>
                      <textarea name="konten" readonly class="textarea-replace editor textarea-tinymce" id="konten">
                      </textarea>
                    </div>
                  </div>
                </main>
              </body>
            </div>
          </div>
          <b>Agenda Terkait :</b>
          <div id="dokumen_tl"></div>
        </div>
        <div class="modal-footer" id="buttonsDokumen">
        </div>
      </div>
    </div>
  </div>


<!-- Modal Filter Layanan-->
<div class="modal fade" id="modalFilterLayanan" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

        <div id="overlay" class="overlay dark">
            <div class="cv-spinner">
            <span class="spinner"></span>
            </div>
        </div>
        
        <div class="modal-header">
            <h5 class="modal-title" id="modelHeadingCatatan">Filter Agenda</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">
        <input type="hidden" id="uuid_catatan">
        <div class="col-md-12">
            <div class="form-group">
              <label>Agenda Layanan Berdasarkan Jabatan : </label>
              <select multiple="multiple" style="width: 100%;" class="select-tag" id="filterJabatan">
                <option value="Advokat">Advokat</option>
                <option value="Paralegal">Paralegal</option>
                <option value="Unit Reaksi Cepat">Unit Reaksi Cepat</option>
                <option value="Psikolog">Psikolog</option>
                <option value="Konselor">Konselor</option>
                <option value="Manajer Kasus">Manajer Kasus</option>
                <option value="Pendamping Kasus">Pendamping Kasus</option>
              </select>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="">Agenda Ditindak Lanjut</label>
                <br>
                <div class="icheck-primary d-inline" style="margin-right:15px">
                  <input type="radio" id="radioPrimary1a" name="filter1TL" checked value="0">
                  <label for="radioPrimary1a">
                      Seluruh agenda
                  </label>
                </div>
                <div class="icheck-primary d-inline">
                  <input type="radio" id="radioPrimary2a" name="filter1TL" value="1">
                  <label for="radioPrimary2a">
                      Agenda yang BELUM ditindak lanjuti saja
                  </label>
                </div>
              </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="">Agenda Anda</label>
                <br>
                <div class="icheck-primary d-inline" style="margin-right:15px">
                  <input type="radio" id="radioPrimary1b" name="filter1Anda" checked value="0">
                  <label for="radioPrimary1b">
                      Seluruh agenda
                  </label>
                </div>
                <div class="icheck-primary d-inline">
                  <input type="radio" id="radioPrimary2b" name="filter1Anda" value="1">
                  <label for="radioPrimary2b">
                      Agenda yang dilakukan oleh anda saja
                  </label>
                </div>
              </div>
        </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success btn-block" onclick="submitFilterLayanan()"><i class="fa fa-check"></i> Terapkan</button>
            <button type="button" class="btn btn-warning btn-block" onclick="resetFilterLayanan()"><i class="fas fa-undo"></i> Reset</button>
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
<script src="{{ asset('vendor/tinymce4/tinymce.min.js') }}"></script>
<script>
    $(document).ready(function () {
        getkotkab('kasus');
        getkotkab('pelapor');
        getkotkab('pelapor_ktp');
        getkotkab('klien');
        getkotkab('klien_ktp');
        hightlighting();
        loadAsesmen();
        loadPemantauan();
        loadTerminasi();
        loadCatatan();
        show_catatan('layanan_hukum_lp');
        show_catatan('layanan_hukum_putusan');
        show_catatan('layanan_psikologi_disabilitas');
        // loadPublicUrl();
        check_kelengkapan_data('{{ $klien->id }}');
        check_kelengkapan_persetujuan_spv('{{ $klien->id }}');
        check_kelengkapan_spp('{{ $klien->id }}');
        check_kelengkapan_asesmen('{{ $klien->id }}');
        check_kelengkapan_perencanaan('{{ $klien->id }}');
        check_kelengkapan_pemantauan('{{ $klien->id }}');
        check_kelengkapan_terminasi('{{ $klien->id }}');
        kelengkapan_kasus = 0;
        kelengkapan_identifikasi = 0;
        $('#kelengkapan_kasus').html(kelengkapan_kasus);

        $('#arsipkan').on('switchChange.bootstrapSwitch', function (event, state) {
                let token   = $("meta[name='csrf-token']").attr("content");
                $.ajax({
                url: "{{ route('kasus.arsip', $klien->uuid) }}",
                type: "POST",
                cache: false,
                data: {
                    _token: token,
                    _method:'PUT'
                },
                success: function (response){
                    if (response.arsip) {
                        // jika true maka munculkan pesan kasus sedang diarsipkan
                        $('#status_arsip_on').hide();
                        $('#status_arsip_off').show();
                    } else {
                        // jika false maka munculkan pesan kasus sedang aktif
                        $('#status_arsip_on').show();
                        $('#status_arsip_off').hide();
                    }
                    if (response.success != true) {
                        console.log(response);
                    }else{
                        $('#tabelKasus').DataTable().ajax.reload();
                        $('#ajaxModal').modal('hide');
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
        }); 

        //Initialize Select2 Elements
        $('.select2').select2();
        $('.select2bs4').select2();
        $('.select-tag').select2({
        tags: true,
        theme: 'bootstrap4'
        });
    });
    
    function show_catatan(params) {
        if ($('#input_' + params).val() == 1) {
            $('.'+params).show();
        } else {
            $('.'+params).hide();
        }
    }

    function submitFilterLayanan() {
        var jabatanValue = $('#filterJabatan').val();
        var tl = $('input[name="filter1TL"]:checked').val();
        var anda = $('input[name="filter1Anda"]:checked').val();
        var url = "{{ env('APP_URL') }}/agenda/api_index?uuid={{ $klien->uuid }}&jabatan=" + encodeURIComponent(JSON.stringify(jabatanValue)) + "&tl=" + tl + "&anda=" + anda;
        
        $('#tabelLayanan').DataTable().ajax.url(url).load();

        $('#modalFilterLayanan').modal('hide');
    }

    function resetFilterLayanan() {
        $('#filterJabatan').val([]).change();
        $('input[name="filter1TL"]').filter('[value="0"]').prop('checked', true);
        $('input[name="filter1Anda"]').filter('[value="0"]').prop('checked', true);
        var url = "{{ env('APP_URL') }}/agenda/api_index?uuid={{ $klien->uuid }}";
        
        $('#tabelLayanan').DataTable().ajax.url(url).load();

        $('#modalFilterLayanan').modal('hide');
    }

    $(function () {

    $('.input_pelapor').next(".select2-container").hide();
    $('.input_klien').next(".select2-container").hide();
    $('.input_kasus').next(".select2-container").hide();
    $('.input_hukum').next(".select2-container").hide();
    $('.input_psikologi').next(".select2-container").hide();
    $('.input_terlapor').next(".select2-container").hide();

      $('#tabelLayanan_filter').css({'float':'right','display':'inline-block; background-color:black'});
    });

    $('#tabelLayanan tbody').on('click', 'tr', function (evt) {
        $("#success-message").hide();
        $("#error-message").hide();
        $("#editAgenda").hide();
        $("#viewAgenda").show();
        var table = $('#tabelLayanan').DataTable();
        var rowData = table.row(this).data();

        // if (($(evt.target).closest('td').index() !== 2)) {
            showModalAgenda('',rowData.uuid_agenda, rowData.created_by);
        // }

        if (rowData.created_by == {{ Auth::user()->id }}) {
            $('#tombol_edit_agenda').show();
        } else {
            $('#tombol_edit_agenda').hide();
        }
    });

    // $(function () {
    //     $('#tabelResumeLayanan').DataTable({
    //     "ordering": false,
    //     "processing": true,
    //     "serverSide": true,
    //     "responsive": false, 
    //     "lengthChange": false, 
    //     "autoWidth": false,
    //     "ajax": "{{ env('APP_URL') }}/agenda/resume_layanan?uuid={{ $klien->uuid }}",
    //     "columns": [
    //         {
    //             "mData": "tanggal_mulai",
    //             "mRender": function (data, type, row) {
    //                 if (row.jam_selesai != null) {
    //                     jam_mulai = row.jam_mulai+' - '+row.jam_selesai;
    //                 }else{
    //                     jam_mulai =  row.jam_mulai;
    //                 }
    //                 return '<b>'+row.hari+'</b>, '+row.tanggal_mulai_formatted+"<br><span style='font-size:13px'>"+jam_mulai+"</span>";
    //             }
    //         },
    //         {"data": "keyword"},
    //         {"data": "name"}
    //     ],
    //     "pageLength": 10,
    //     "lengthMenu": [
    //         [10, 25, 50, 100, -1],
    //         ['10 rows', '25 rows', '50 rows', '100 rows','All'],
    //     ],
    //     "order": [[0, 'ASC']],
    //     "dom": 'Blfrtip', // Blfrtip or Bfrtip
    //     "buttons": ["pageLength", "copy", "csv", "excel", "pdf", "print"]
    //     }).buttons().container().appendTo('#tabelResumeLayanan_wrapper .col-md-6:eq(0)');

    //     $('#tabelResumeLayanan_filter').css({'float':'right','display':'inline-block; background-color:black'});
    // });

    function showModalDokumen(uuid) { 
        $.ajax({
          url:"{{ env('APP_URL') }}/dokumen/show/"+uuid,
          type:'GET',
          dataType: 'json',
          success: function( data ) {
            $("#overlay").hide();
            dokumen_tl = data.dokumen_tl;
            data = data.data;
            $('#kontenDokumen').html(data.konten);
            tinymce.activeEditor.setContent(JSON.parse(data.konten));
            $('#dokumenModal').modal('show');
            //munculkan agenda terkait
            $('#dokumen_tl').html('');
            no_agenda = 1;
            dokumen_tl.forEach(e => {
                $('#dokumen_tl').append(no_agenda+'. '+e.judul_kegiatan+' (Tanggal '+e.tanggal_mulai+', Pukul '+e.jam_mulai+')</br>');
                no_agenda++;
            });
            //munculkan tombol
            $('#buttonsDokumen').html('');
            $('#buttonsDokumen').append('<button type="button" class="btn btn-primary btn-block" id="detail" onclick="saveAndPrint()"><i class="fas fa-print"></i> Print Dokumen</button>');
            if (data.created_by == '{{ Auth::user()->id }}') {
                $('#buttonsDokumen').append('<button type="button" onclick="window.location.assign(`'+"{{route('dokumen.edit', '')}}"+"/"+data.uuid+'`)" class="btn btn-warning btn-block" id="Edit"><i class="fas fa-edit"></i> Edit Dokumen</button>');
                $('#buttonsDokumen').append('<button type="button" onclick="hapus(`'+data.uuid+'`)" class="btn btn-danger btn-block" id="hapus"><i class="fa fa-trash"></i> Hapus Dokumen</button>');
            }
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

    function editdata(params) {
        $('.data_'+params).hide();
        $('#tombol_edit_'+params).hide();
        $('.input_'+params).show();
        $('.input_'+params).next(".select2-container").show();
        $('#tombol_save_'+params).show(); 
    }

    function deleteTerlapor(terlapor_id = '') {
        if (confirm("Apakah anda yakin ingin menghapus terlapor ini?") == true) {
            let token   = $("meta[name='csrf-token']").attr("content");
            $.ajax({
            url: "{{ route('formpenerimapengaduan.deleteterlapor') }}",
            type: "POST",
            cache: false,
            data: {
                uuid: terlapor_id,
                _token: token
            },
            success: function (response){
                $('#terlapor'+terlapor_id).hide();
                console.log(response);
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
    }

    function getkotkab(field_id='') {
        province_code = $('#provinsi_id_'+field_id).val();
        if (field_id == 'kasus') { //kasus tkp
            var kotkabID = '{{ $kasus->kotkab_id }}';
        } else if (field_id == 'pelapor') { // pelapor domisili
            var kotkabID = '{{ $pelapor->kotkab_id }}';
        } else if (field_id == 'klien') { // klien domisili
            var kotkabID = '{{ $klien->kotkab_id }}';
        } else if (field_id == 'terlapor') { // terlapor domisili (bisa lebih dari 1)
            var kotkabID = '{{ isset($terlapor[0]->kotkab_id_ktp) ? $terlapor[0]->kotkab_id_ktp : "" }}';
        } else if (field_id == 'pelapor_ktp') { // pelapor ktp
            var kotkabID = '{{ $pelapor->kotkab_id_ktp }}';
        } else if (field_id == 'klien_ktp') { // klien domisili
            var kotkabID = '{{ $klien->kotkab_id_ktp }}';
        }  else { // terlapor domisili (bisa lebih dari 1)
            var kotkabID = '{{ isset($terlapor[0]->kotkab_id) ? $terlapor[0]->kotkab_id : "" }}';
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
        if (field_id == 'kasus') { //kasus tkp
            var kecamatanID = '{{ $kasus->kecamatan_id }}';
        } else if (field_id == 'pelapor') { // pelapor domisili
            var kecamatanID = '{{ $pelapor->kecamatan_id }}';
        } else if (field_id == 'klien') { // klien domisili
            var kecamatanID = '{{ $klien->kecamatan_id }}';
        } else if (field_id == 'terlapor') { // terlapor domisili (bisa lebih dari 1)
            var kecamatanID = '{{ isset($terlapor[0]->kecamatan_id_ktp) ? $terlapor[0]->kecamatan_id_ktp : "" }}';
        } else if (field_id == 'pelapor_ktp') { // pelapor ktp
            var kecamatanID = '{{ $pelapor->kecamatan_id_ktp }}';
        } else if (field_id == 'klien_ktp') { // klien domisili
            var kecamatanID = '{{ $klien->kecamatan_id_ktp }}';
        }  else { // terlapor domisili (bisa lebih dari 1)
            var kecamatanID = '{{ isset($terlapor[0]->kecamatan_id) ? $terlapor[0]->kecamatan_id : "" }}';
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
                //panggil kelurahan
                getkelurahan(field_id);
            }
        });
    }; 

    function getkelurahan(field_id='') {
        kecamatan_code = $('#kecamatan_id_'+field_id).val();
        if (field_id == 'kasus') { //kasus tkp
            var kelurahanID = '{{ $kasus->kelurahan_id }}';
        } else if (field_id == 'pelapor') { // pelapor domisili
            var kelurahanID = '{{ $pelapor->kelurahan_id }}';
        } else if (field_id == 'klien') { // klien domisili
            var kelurahanID = '{{ $klien->kelurahan_id }}';
        } else if (field_id == 'terlapor') { // terlapor domisili (bisa lebih dari 1)
            var kelurahanID = '{{ isset($terlapor[0]->kelurahan_id_ktp) ? $terlapor[0]->kelurahan_id_ktp : "" }}';
        } else if (field_id == 'pelapor_ktp') { // pelapor ktp
            var kelurahanID = '{{ $pelapor->kelurahan_id_ktp }}';
        } else if (field_id == 'klien_ktp') { // klien domisili
            var kelurahanID = '{{ $klien->kelurahan_id_ktp }}';
        }  else { // terlapor domisili (bisa lebih dari 1)
            var kelurahanID = '{{ isset($terlapor[0]->kelurahan_id) ? $terlapor[0]->kelurahan_id : "" }}';
        }

        $.ajax({
          url:'{{ route("api.v1.kelurahan") }}?kecamatan_code='+kecamatan_code,
          type:'GET',
          dataType: 'json',
          success: function( response ) {
                var option = '<option value="">-- Pilih Kelurahan --</option>';
                $.each(response.data, function(i, value) {
                    var selected = ''
                    if (kelurahanID == value.code) {
                        selected = `selected="selected"`
                    }
                    option += `<option value="${value.code}" ${selected}>${value.name}</option>`
                });
                $('#kelurahan_id_'+field_id).html(option);
            }
        });
    }; 
    
    $(function () {

    $('#tabelLogActivity').DataTable({
      "ordering": true,
      "processing": true,
      "serverSide": true,
      "responsive": false, 
      "lengthChange": false, 
      "autoWidth": false,
      "ajax": "{{ env('APP_URL') }}/logactivity/index?uuid={{ $klien->uuid }}",
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
      "buttons": ["pageLength", "copy", "csv", "excel", "pdf", "print", 
              {
                className: "btn-info",
                text: 'Refresh',
                  action: function ( ) {
                    $('#tabelLogActivity').DataTable().ajax.reload();
                  }
              }]
      }).buttons().container().appendTo('#tabelLogActivity_wrapper .col-md-6:eq(0)');

      $('#tabelLogActivity_filter').css({'float':'right','display':'inline-block; background-color:black'});
    

    $('#tabelRiwayat').DataTable({
      "ordering": false,
      "processing": true,
      "serverSide": true,
      "responsive": false, 
      "lengthChange": false, 
      "autoWidth": false,
      "ajax": "{{ env('APP_URL') }}/riwayatkejadian/index?uuid={{ $klien->uuid }}",
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
              return row.keterangan.replace(/\n/g, '<br>');
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
        $.get(`{{ env('APP_URL') }}/riwayatkejadian/edit/`+this.id, function (data) {
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

    $('#submitRiwayatKejadian').click(function() {
        if(validateForm('riwayat')){
            let token   = $("meta[name='csrf-token']").attr("content");
            $.ajax({
            url: "{{ route('riwayatkejadian.store') }}",
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
        url: `{{ env('APP_URL') }}/riwayatkejadian/destroy/`+uuid,
        type: "POST",
        cache: false,
        data: {
            _method:'DELETE',
            _token: token
        },
        success: function (response){
            if (response.success != true) {
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
            url: `{{ env('APP_URL') }}/asesmen/index?uuid={{ $klien->uuid }}`,
            type: "GET",
            cache: false,
            success: function (response){
                data = response.data;
                $('#kolomAsesmen').html('');
                i=1;
                data.forEach(e => {
                    tombolHapus = '';
                    if (e.created_by == '{{ Auth::user()->id }}' || '{{ Auth::user()->jabatan }}' == 'Manajer Kasus') {
                        tombolHapus = '<button type="button" class="btn btn-danger btn-block" id="deleteAsesmen" onclick="deleteAsesmen(`'+e.uuid+'`)"><i class="fa fa-trash"></i> Hapus</button>';
                    }
                    $('#kolomAsesmen').prepend('<div class=\"card collapsed-card target\"> <div class=\"card-header\" data-card-widget=\"collapse\" style=\"cursor: pointer;\"> <h3 class=\"card-title\"><b>Asesmen ke-'+i+' oleh '+e.petugas+' ('+e.jabatan+')</b></h3> <div class=\"card-tools\"> <button type=\"button\" class=\"btn btn-tool\"><i class=\"fa fa-chevron-down\"></i> </button> </div> </div> <div class=\"card-body\"> <b>A. UPAYA PEMECAHAN MASALAH</b> </br> <div class=\"col-md-12\"> <div class=\"form-group\"> <label>Upaya yang pernah dilakukan : </label> <textarea readonly class=\"form-control\" style=\"resize: none;\" >'+e.upaya+'</textarea> </div> </div> <div class=\"col-md-12\"> <div class=\"form-group\"> <label>Faktor pendukung pemecahan masalah : </label> <textarea readonly class=\"form-control\" style=\"resize: none;\">'+e.pendukung+'</textarea> </div> </div> <div class=\"col-md-12\"> <div class=\"form-group\"> <label>Faktor penghambat pemecahan masalah : </label> <textarea readonly class=\"form-control\" style=\"resize: none;\">'+e.hambatan+'</textarea> </div> </div> <div class=\"col-md-12\"> <div class=\"form-group\"> <label>Harapan/Kebutuhan klien : </label> <textarea readonly class=\"form-control\" style=\"resize: none;\">'+e.harapan+'</textarea> </div> </div> <div class=\"post clearfix\"></div> <b>B. BIOPSIKOSOSIAL</b> </br> <div class=\"col-md-12\"> <div class=\"form-group\"> <label>Biologis (kondisi fisik, catatan kesehatan, pengobatan)</label> <textarea readonly cols=\"30\" rows=\"2\" class=\"form-control\" style=\"resize: none;\">'+e.fisik+'</textarea> </div> </div> <div class=\"col-md-12\"> <div class=\"form-group\"> <label>Psikologis</label> <textarea readonly cols=\"30\" rows=\"2\" class=\"form-control\" style=\"resize: none;\">'+e.psikologis+'</textarea> </div> </div> <div class=\"col-md-12\"> <div class=\"form-group\"> <label>Sosial & Spiritual</label> <textarea readonly cols=\"30\" rows=\"2\" class=\"form-control\" style=\"resize: none;\">'+e.sosial+'</textarea> </div> </div> <div class=\"col-md-12\"> <div class=\"form-group\"> <label>Hukum</label> <textarea readonly cols=\"30\" rows=\"2\" class=\"form-control\" style=\"resize: none;\">'+e.hukum+'</textarea> </div> </div> <div class=\"col-md-12\"> <div class=\"form-group\"> <label>Catatan Lainnya</label> <textarea readonly cols=\"30\" rows=\"2\" class=\"form-control\" style=\"resize: none;\">'+e.lainnya+'</textarea> </div> '+tombolHapus+'</div> </div> </div>');
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
            url: "{{ route('asesmen.store') }}",
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

    function deleteAsesmen(uuid) {
        if (confirm("Apakah anda yakin ingin menghapus laporan asesmen ini?") == true) {
            let token   = $("meta[name='csrf-token']").attr("content");
            $.ajax({
            url : `{{ env('APP_URL') }}/asesmen/destroy/`+uuid,
            type: "POST",
            cache: false,
            data: {
                _method:'DELETE',
                _token: token
            },
            success: function (response){
                if (response.success != true) {
                    console.log(response);
                }else{
                    loadAsesmen();
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
        }
    }

    function loadPemantauan() {
        $('#deletePemantauan').hide();
        $.ajax({
            url: `{{ env('APP_URL') }}/pemantauan/index?uuid={{ $klien->uuid }}`,
            type: "GET",
            cache: false,
            success: function (response){
                $('#kolomPemantauan').html('');
                
                data = response.data;
                i=1;
                data.forEach(e => {
                    tombolHapus = '';
                    if (e.created_by == '{{ Auth::user()->id }}' || '{{ Auth::user()->jabatan }}' == 'Manajer Kasus') {
                        tombolHapus = '<button type="button" class="btn btn-danger btn-block" id="deletePemantauan" onclick="deletePemantauan(`'+e.uuid+'`)"><i class="fa fa-trash"></i> Hapus</button>';
                    }
                    $('#kolomPemantauan').prepend('<div class=\"card collapsed-card target\"> <div class=\"card-header\" data-card-widget=\"collapse\" style=\"cursor: pointer;\"> <h3 class=\"card-title\"><b>Pemantauan & Evaluasi tanggal '+e.created_at_formatted+' oleh '+e.petugas+' ('+e.jabatan+')</b></h3> <div class=\"card-tools\"> <button type=\"button\" class=\"btn btn-tool\"><i class=\"fa fa-chevron-down\"></i> </button> </div> </div> <div class=\"card-body\"> <div class=\"col-md-12\"> <div class=\"form-group\"> <label>Kemajuan yang Dicapai / Kondisi Klien Saat Pemantauan & Evaluasi : </label> <textarea readonly class=\"form-control\" style=\"resize: none;\" >'+e.kemajuan+'</textarea> </div> </div> <div class=\"col-md-12\"> <div class=\"form-group\"> <label>Tujuan yang Belum Tercapai : </label> <textarea readonly class=\"form-control\" style=\"resize: none;\">'+e.tujuan+'</textarea> </div> </div> <div class=\"col-md-12\"> <div class=\"form-group\"> <label>Rencana Tindak Lanjut : </label> <textarea readonly class=\"form-control\" style=\"resize: none;\">'+e.rencana+'</textarea> </div> '+tombolHapus+' </div> </div> </div>');
                    i++;
                });
            },
            error: function (response){
                console.log(response);
            }
            });
    }

    $('#submitPemantauan').click(function() {
        if(validateForm('pemantauan')){
            let token   = $("meta[name='csrf-token']").attr("content");
            $.ajax({
            url: "{{ route('pemantauan.store') }}",
            type: "POST",
            cache: false,
            data: {
                uuid: $('#uuid_pemantauan').val(),
                uuid_klien: '{{ $klien->uuid }}',
                kemajuan: $("#pemantauan_kemajuan").val(),
                tujuan: $("#pemantauan_tujuan").val(),
                rencana: $("#pemantauan_rencana").val(),
                _token: token
            },
            success: function (response){
                if (response.success != true) {
                    $('#message-pemantauan').html(JSON.stringify(response));
                    $("#success-message-pemantauan").hide();
                    $("#error-message-pemantauan").show();
                }else{
                    $('#message-pemantauan').html(response.message);
                    $("#success-message-pemantauan").show();
                    $("#error-message-pemantauan").hide();
                    loadPemantauan();

                    // hapus semua inputan
                    $('#uuid_pemantauan').val('');
                    $("#pemantauan_kemajuan").val('');
                    $("#pemantauan_tujuan").val('');
                    $("#pemantauan_rencana").val('');
                    $('#tambahPemantauanModal').scrollTop(0);
                }
            },
            error: function (response){
                setTimeout(function(){
                $("#overlay").fadeOut(300);
                },500);
                console.log(response);

                $('#message-pemantauan').html(JSON.stringify(response));
                $("#success-message-pemantauan").hide();
                $("#error-message-pemantauan").show();
            }
            }).done(function() { //loading submit form
                setTimeout(function(){
                $("#overlay").fadeOut(300);
                },500);
            });
        }else{
            $('#message-pemantauan').html('Mohon cek ulang data yang wajib diinput.');
            $("#success-message-pemantauan").hide();
            $("#error-message-pemantauan").show();
        }
    });

    function deletePemantauan(uuid) {
        if (confirm("Apakah anda yakin ingin menghapus laporan pemantauan ini?") == true) {
            let token   = $("meta[name='csrf-token']").attr("content");
            $.ajax({
            url: `{{ env('APP_URL') }}/pemantauan/destroy/`+uuid,
            type: "POST",
            cache: false,
            data: {
                _method:'DELETE',
                _token: token
            },
            success: function (response){
                if (response.success != true) {
                    console.log(response);
                }else{
                    loadPemantauan();
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
        }
    }

    function loadTerminasi() {
        $.ajax({
            url: `{{ env('APP_URL') }}/terminasi/index?uuid={{ $klien->uuid }}`,
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
            url: "{{ route('terminasi.store') }}",
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
            url: `{{ env('APP_URL') }}/catatan/index?uuid={{ $klien->uuid }}`,
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
            url: "{{ route('catatan.store') }}",
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
                    notif_receiver = response.notif_receiver;
                    if (notif_receiver.length > 0) {
                        socket.emit('notif_count', {
                            receiver_id : response.notif_receiver
                        });
                    }
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
            url: "{{ route('catatan.store') }}",
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
        // gak ada edit langsung hapus saja, ini cuman show
        $("#success-message-catatan").hide();
        $("#error-message-catatan").hide();
        $('#submitCatatan').hide();
        $('#catatan_kasus').prop('disabled', true);
        $('#tambahCatatanModal').modal('show');
        let token   = $("meta[name='csrf-token']").attr("content");
        $.ajax({
        url: `{{ env('APP_URL') }}/catatan/edit/`+uuid,
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
        $.ajax({
            url: `{{ env('APP_URL') }}/publicurl/index?uuid={{ $klien->uuid }}`,
            type: "GET",
            cache: false,
            success: function (response){
                $('#kolomPublicUrl').html('');
                
                data = response.data;
                i=1;
                data.forEach(e => {
                    console.log(e.kadaluarsa);
                    const originalDate = new Date(e.created_at);
                    originalDate.setDate(originalDate.getDate() + 2);
                    const formattedDate = originalDate.toLocaleString();
                    $('#kolomPublicUrl').prepend("<div class=\"input-group\"> <input type=\"text\" class=\"form-control\" id=\"link-form-{{ route('publicurl.show', '') }}/"+e.uuid+"\" value=\"{{ route('publicurl.show', '') }}/"+e.uuid+"\" tabindex=\"-1\" aria-hidden=\"true\" style=\"background: #eaebeb;font-size: 14px;font-weight: bold;\"> <div class=\"input-group-append\"> <button class=\"input-group-text pointer\" onclick=\"copyClipboard('{{ route('publicurl.show','') }}/"+e.uuid+"')\"> <i class=\"fa fa-fw\" aria-hidden=\"true\"></i> </button> </div> </div><span style=\"color:red;font-size:15px\">Link ini berlaku hingga tanggal : "+formattedDate+"</span>");
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
        url: "{{ route('publicurl.store') }}",
        type: "POST",
        cache: false,
        data: {
            uuid: $('#uuid_pemantauan').val(),
            uuid_klien: '{{ $klien->uuid }}',
            function: functions,
            _token: token
        },
        success: function (response){
            if (response.success != true) {
                $('#message-pemantauan').html(JSON.stringify(response));
                $("#success-message-pemantauan").hide();
                $("#error-message-pemantauan").show();
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
        if (alasan_approve != '') {
        if (alasan_approve || approval == 1) {
            let token = $("meta[name='csrf-token']").attr("content");
            $.ajax({
            url: "{{ route('terminasi.store') }}",
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
        }else{
            alert('Masukan alasan tidak menerima pengajuan terminasi');
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
        // Get the text field

        var temp = $("<input>");
        $("body").append(temp);
        temp.val($("#link-form-"+uuid).val()).select();
        document.execCommand("copy");
        temp.remove();

        // Alert the copied text
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
            url: `{{ env('APP_URL') }}/check_kelengkapan_data/`+klien_id,
            type: "GET",
            cache: false,
            success: function (response){
                // nol kan dulu persentasenya 
                $('.persen_data').css('width','0%');
                // update persentase
                $('#persen_title_data').html(response);
                $('#persen_data').css('width', response+'%');
            },
            error: function (response){
                alert("Error");
                console.log(response);
            }
        });
    }

function check_kelengkapan_persetujuan_spv(klien_id) {
    $.ajax({
        url: `{{ env('APP_URL') }}/check_kelengkapan_persetujuan_spv/`+klien_id,
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
        url: `{{ env('APP_URL') }}/check_kelengkapan_spp/`+klien_id,
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
                    $('#tombol_edit_rekam').show();
                }
                // $('#modalAsesmen').show();
            }else{
                $('.warningSPP').show();
                $('#tombol_edit_rekam').hide();
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
        url: `{{ env('APP_URL') }}/check_kelengkapan_asesmen/`+klien_id,
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
        url: `{{ env('APP_URL') }}/check_kelengkapan_perencanaan/`+klien_id,
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
        url: `{{ env('APP_URL') }}/check_kelengkapan_pelaksanaan/`+klien_id,
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

function check_kelengkapan_pemantauan(klien_id) {
    $.ajax({
        url: `{{ env('APP_URL') }}/check_kelengkapan_pemantauan/`+klien_id,
        type: "GET",
        cache: false,
        success: function (response){
            if (response > 0) {
                $('#check_pemantauan').show();
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
        url: `{{ env('APP_URL') }}/check_kelengkapan_terminasi/`+klien_id,
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

$(function(){
    $('.dt-buttons').addClass('akses_petugas');
    
    if ('{{ $akses_petugas }}' == 1) {
        $('.akses_petugas').css('display', 'inline-flex');
    }else{
        $('.akses_petugas').css('display', 'none');
    }


    getJenisKekerasan();
    getBentukKekerasan();
    getKategoriKasus();
})

function getJenisKekerasan() {
    $("#jenis_kekerasan").select2({
        ajax: { 
          url: '{{ route("api.v1.jeniskekerasan") }}',
          type: "GET",
          dataType: 'json',
          delay: 250,
          data: function (params) {
            return {
              search: params.term, // search term
            };
          },
          processResults: function (response) {
          $("#overlay").hide();
            return {
              results: response
            };
          },
          cache: false
        }
    });
  }

  function getBentukKekerasan() {
    jenis_kekerasan = $('#jenis_kekerasan').val();
    $("#bentuk_kekerasan").select2({
        ajax: { 
          url: '{{ route("api.v1.bentukkekerasan") }}',
          type: "GET",
          dataType: 'json',
          delay: 250,
          data: function (params) {
            return {
              jenis_kekerasan: jenis_kekerasan, // munculkan bentuk berdasarkan jenis kekerasan yang sudah dipilih
              search: params.term, // search term
            };
          },
          processResults: function (response) {
          $("#overlay").hide();
            return {
              results: response
            };
          },
          cache: false
        }
    });
  }

  function getKategoriKasus() {
    jenis_kekerasan = $('#jenis_kekerasan').val();
    bentuk_kekerasan = $('#bentuk_kekerasan').val();
    $("#kategori_kasus").select2({
        ajax: { 
          url: '{{ route("api.v1.kategorikasus") }}',
          type: "GET",
          dataType: 'json',
          delay: 250,
          data: function (params) {
            return {
              jenis_kekerasan: jenis_kekerasan, // munculkan kategori kasus berdasarkan jenis kekerasan yang sudah dipilih
              bentuk_kekerasan: bentuk_kekerasan, // munculkan kategori kasus berdasarkan jenis kekerasan yang sudah dipilih
              search: params.term, // search term
            };
          },
          processResults: function (response) {
          $("#overlay").hide();
            return {
              results: response
            };
          },
          cache: false
        }
    });
  }

  function TambahTerlapor() {
    $('#formTerlapor').show();
    $('#buttonTerlapor').hide();
  }
</script>
{{-- include modal agenda --}}
@include('agenda.modal')
@endsection