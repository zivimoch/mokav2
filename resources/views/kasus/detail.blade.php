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
<h3 class="profile-username text-center">Nina Mcintire</h3>
<p class="text-muted text-center">(26) Perempuan</p>
<p class="text-center">0004/01/2023</p>
<ul class="list-group list-group-unbordered mb-3">
<h5><span class="float-right badge bg-danger btn-block">Pelapor/korban menyetujui laporan pengaduan</span></h5>
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
        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
        <li class="nav-item">
        <a class="nav-link {{ Request::get('tab') == 'kasus' || Request::get('tab') == '' ? 'active' : '' }}" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Kasus</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::get('tab') == 'kasus-assessment' ? 'active' : '' }}" id="kasus-assessment-tab" data-toggle="pill" href="#kasus-assessment" role="tab" aria-controls="kasus-assessment" aria-selected="false">Assessment</a>
        </li>
        <li class="nav-item">
        <a class="nav-link {{ Request::get('tab') == 'kasus-layanan' ? 'active' : '' }}" id="kasus-layanan-tab" data-toggle="pill" href="#kasus-layanan" role="tab" aria-controls="kasus-layanan" aria-selected="false">Layanan</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false">Timeline</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" id="kasus-petugas-tab" data-toggle="pill" href="#kasus-petugas" role="tab" aria-controls="kasus-petugas" aria-selected="false">Petugas</a>
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
            
            
        <div class="post clearfix">
            <b>A. IDENTITAS PELAPOR</b>
            <table class="table table-bottom table-sm">
                <tr>
                    <td style="width: 200px">Nama</td>
                    <td>:</td>
                    <td>Addzifi Mochamad Gumelar (Laki-laki)</td>
                </tr>
                <tr>
                    <td style="width: 200px">Tempat/Tgl Lahir</td>
                    <td>:</td>
                    <td>Bogor, 13 Februari 1997 (42 Tahun)</td>
                </tr>
                <tr>
                    <td style="width: 200px">Alamat</td>
                    <td>:</td>
                    <td>Jl. Diponogoro Empu Tantular 45 Jaya, <b>Kelurahan</b> Mantap, <b>Kecamatan</b> Harapan, <b>Kota</b> DKI Jakarta</td>
                </tr>
                <tr>
                    <td style="width: 200px">No Telp</td>
                    <td>:</td>
                    <td>08520885564</td>
                </tr>
                <tr>
                    <td style="width: 200px">Hubungan dengan anak</td>
                    <td>:</td>
                    <td>Ayah Kandung</td>
                </tr>
            </table>
        </div>
        <div class="post clearfix">
            <b>B. IDENTITAS ANAK</b>
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
                    <td style="width: 200px">Pendidikan</td>
                    <td>:</td>
                    <td><b>Kelas</b> 2, <b>Sekolah</b> SDN 1 Wakanda</td>
                </tr>
                <tr>
                    <td style="width: 200px">Nama Ibu</td>
                    <td>:</td>
                    <td>Siswati Karnasuryatna Gumelar</td>
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
        <div class="post clearfix">
            <b>C. IDENTITAS TERLAPOR</b>
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
        <div class="post clearfix">
            <b>D. KASUS KLIEN</b>
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
        <div class="post clearfix">
            <b>E. HASIL AKHIR</b>
            <table class="table table-bottom table-sm">
                <tr>
                    <td style="width: 200px">Catatan Akhir</td>
                    <td>:</td>
                    <td>Klien LPSK, Persidangan</td>
                </tr>
            </table>
        </div>
        <div class="post clearfix">
            <b>F. BILA DISIDANGKAN</b>
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
        <div class="post clearfix">
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
        <div class="tab-pane {{ Request::get('tab') == 'kasus-assessment' ? 'active' : '' }}" id="kasus-assessment" role="tabpanel" aria-labelledby="kasus-assessment-tab">
            
            <div class="post clearfix" style="margin: 0px">
            <b>A. KRONOLOGIS</b>
            </br>
            </br>
            <div style="overflow-x: scroll">
            <table id="example2" class="table table-sm table-bordered  table-hover" style="cursor:pointer">
                <thead>
                <tr>
                <th>Waktu Kejadian</th>
                <th>Detail Pristiwa</th>
                </tr>
                </thead>
                <tbody>
                <tr id="1">
                <td>2 Januari 2022</br><span style="font-size:14px">14:00 s/d 15:00</span></td>
                <td>Ab id, quaerat itaque ipsa, explicabo quas corporis exercitationem architecto labore placeat corrupti magni sunt quod consequuntur suscipit nemo maxime delectus sequi?
                Saepe facere repellendus repellat sunt. Vitae laudantium veritatis nobis....</td>
                </tr>
                <tr id="2">
                    <td>2 Januari 2022</br><span style="font-size:14px">14:00 s/d 15:00</span></td>
                    <td>Ab id, quaerat itaque ipsa, explicabo quas corporis exercitationem architecto labore placeat corrupti magni sunt quod consequuntur suscipit nemo maxime delectus sequi?
                    Saepe facere repellendus repellat sunt. Vitae laudantium veritatis nobis....</td>
                </tr>
                <tr id="3">
                    <td>2 Januari 2022</br><span style="font-size:14px">14:00 s/d 15:00</span></td>
                    <td>Ab id, quaerat itaque ipsa, explicabo quas corporis exercitationem architecto labore placeat corrupti magni sunt quod consequuntur suscipit nemo maxime delectus sequi?
                    Saepe facere repellendus repellat sunt. Vitae laudantium veritatis nobis....</td>
                </tr>
                <tr id="4">
                    <td>2 Januari 2022</br><span style="font-size:14px">14:00 s/d 15:00</span></td>
                    <td>Ab id, quaerat itaque ipsa, explicabo quas corporis exercitationem architecto labore placeat corrupti magni sunt quod consequuntur suscipit nemo maxime delectus sequi?
                    Saepe facere repellendus repellat sunt. Vitae laudantium veritatis nobis....</td>
                </tr>
                <tr id="5">
                    <td>2 Januari 2022</br><span style="font-size:14px">14:00 s/d 15:00</span></td>
                    <td>Ab id, quaerat itaque ipsa, explicabo quas corporis exercitationem architecto labore placeat corrupti magni sunt quod consequuntur suscipit nemo maxime delectus sequi?
                    Saepe facere repellendus repellat sunt. Vitae laudantium veritatis nobis....</td>
                </tr>
                <tr id="6">
                    <td>2 Januari 2022</br><span style="font-size:14px">14:00 s/d 15:00</span></td>
                    <td>Ab id, quaerat itaque ipsa, explicabo quas corporis exercitationem architecto labore placeat corrupti magni sunt quod consequuntur suscipit nemo maxime delectus sequi?
                    Saepe facere repellendus repellat sunt. Vitae laudantium veritatis nobis....</td>
                </tr>
                <tr id="7">
                    <td>2 Januari 2022</br><span style="font-size:14px">14:00 s/d 15:00</span></td>
                    <td>Ab id, quaerat itaque ipsa, explicabo quas corporis exercitationem architecto labore placeat corrupti magni sunt quod consequuntur suscipit nemo maxime delectus sequi?
                    Saepe facere repellendus repellat sunt. Vitae laudantium veritatis nobis....</td>
                </tr>
                <tr id="4">
                    <td>2 Januari 2022</br><span style="font-size:14px">14:00 s/d 15:00</span></td>
                    <td>Ab id, quaerat itaque ipsa, explicabo quas corporis exercitationem architecto labore placeat corrupti magni sunt quod consequuntur suscipit nemo maxime delectus sequi?
                    Saepe facere repellendus repellat sunt. Vitae laudantium veritatis nobis....</td>
                </tr>
                <tr id="10">
                    <td>2 Januari 2022</br><span style="font-size:14px">14:00 s/d 15:00</span></td>
                    <td>Ab id, quaerat itaque ipsa, explicabo quas corporis exercitationem architecto labore placeat corrupti magni sunt quod consequuntur suscipit nemo maxime delectus sequi?
                    Saepe facere repellendus repellat sunt. Vitae laudantium veritatis nobis....</td>
                </tr>
                <tr id="1">
                    <td>2 Januari 2022</br><span style="font-size:14px">14:00 s/d 15:00</span></td>
                    <td>Ab id, quaerat itaque ipsa, explicabo quas corporis exercitationem architecto labore placeat corrupti magni sunt quod consequuntur suscipit nemo maxime delectus sequi?
                    Saepe facere repellendus repellat sunt. Vitae laudantium veritatis nobis....</td>
                </tr>
                </tbody>
            </table>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleInputFile">Assessment tools</label>
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
                <b>B. DAMPAK KEKERASAN</b>
                </br>
                <div class="row">

                <div class="col-md-12">
                    <div class="form-group">
                    <label>Kesehatan Fisik</label>
                    <textarea name="" id="" cols="30" rows="2" class="form-control" style="resize: none;"></textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                    <label>Kesehatan Psikologis</label>
                    <textarea name="" id="" cols="30" rows="2" class="form-control" style="resize: none;"></textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                    <label>Kesehatan Reproduksi</label>
                    <textarea name="" id="" cols="30" rows="2" class="form-control" style="resize: none;"></textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                    <label>Sosial</label>
                    <textarea name="" id="" cols="30" rows="2" class="form-control" style="resize: none;"></textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                    <label>Ekonomi</label>
                    <textarea name="" id="" cols="30" rows="2" class="form-control" style="resize: none;"></textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                    <label>Anak/Keluarga</label>
                    <textarea name="" id="" cols="30" rows="2" class="form-control" style="resize: none;"></textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                    <label>Lain-lain</label>
                    <textarea name="" id="" cols="30" rows="2" class="form-control" style="resize: none;"></textarea>
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
                <th>Status</th>
                </tr>
                </thead>
                <tbody>
                <tr id="1">
                <td>
2 Januari 2022
</br><span style="font-size:14px">14:00 s/d 15:00</span>
</td>
                <td>Hukum</td>
                <td>Konsultasi hukum</td>
                <td>Addzifi Mochamad Gumelar</td>
                <td><span class="badge bg-success">Terlaksana</span></td>
                </tr>
                <tr id="2">
                <td>
2 Januari 2022
</br><span style="font-size:14px">14:00 s/d 15:00</span>
</td>
                <td>Hukum</td>
                <td>Konsultasi hukum</td>
                <td>Addzifi Mochamad Gumelar</td>
                <td><span class="badge bg-danger">Dibatalkan</span></td>
                </tr>
                <tr id="3" style="background:#a2a2a2" class="hightlighting">
                <td>
2 Januari 2022
</br><span style="font-size:14px">14:00 s/d 15:00</span>
</td>
                <td>Hukum</td>
                <td></td>
                <td>Addzifi Mochamad Gumelar</td>
                <td>
                    {{-- <span class="badge bg-danger">Belum</span> --}}
                </td>
                </tr>
                <tr id="4" style="background-color:rgb(156, 240, 255)">
                <td>
2 Januari 2022
</br><span style="font-size:14px">14:00 s/d 15:00</span>
</td>
                <td>MK</td>
                <td>Monitoring 2</td>
                <td>Addzifi Mochamad Gumelar</td>
                <td><span class="badge bg-success">Terlaksana</span></td>
                </tr>
                <tr id="5">
                <td>
2 Januari 2022
</br><span style="font-size:14px">14:00 s/d 15:00</span>
</td>
                <td>Hukum</td>
                <td>Konsultasi hukum</td>
                <td>Addzifi Mochamad Gumelar</td>
                <td><span class="badge bg-success">Terlaksana</span></td>
                </tr>
                <tr id="6">
                <td>
2 Januari 2022
</br><span style="font-size:14px">14:00 s/d 15:00</span>
</td>
                <td>Hukum</td>
                <td>Konsultasi hukum</td>
                <td>Addzifi Mochamad Gumelar</td>
                <td><span class="badge bg-success">Terlaksana</span></td>
                </tr>
                <tr id="7">
                <td>
2 Januari 2022
</br><span style="font-size:14px">14:00 s/d 15:00</span>
</td>
                <td>Hukum</td>
                <td>Konsultasi hukum</td>
                <td>Addzifi Mochamad Gumelar</td>
                <td><span class="badge bg-success">Terlaksana</span></td>
                </tr>
                <tr id="4" style="background-color:rgb(156, 240, 255)">
                <td>
2 Januari 2022
</br><span style="font-size:14px">14:00 s/d 15:00</span>
</td>
                <td>MK</td>
                <td>Monitoring 1</td>
                <td>Addzifi Mochamad Gumelar</td>
                <td><span class="badge bg-success">Terlaksana</span></td>
                </tr>
                <tr id="10">
                <td>
2 Januari 2022
</br><span style="font-size:14px">14:00 s/d 15:00</span>
</td>
                <td>Hukum</td>
                <td>Konsultasi hukum</td>
                <td>Addzifi Mochamad Gumelar</td>
                <td><span class="badge bg-success">Terlaksana</span></td>
                </tr>
                <tr id="11">
                <td>
2 Januari 2022
</br><span style="font-size:14px">14:00 s/d 15:00</span>
</td>
                <td>Hukum</td>
                <td>Konsultasi hukum</td>
                <td>Addzifi Mochamad Gumelar</td>
                <td><span class="badge bg-success">Terlaksana</span></td>
                </tr>
                <tr id="1">
                <td>
2 Januari 2022
</br><span style="font-size:14px">14:00 s/d 15:00</span>
</td>
                <td>Hukum</td>
                <td>Konsultasi hukum</td>
                <td>Addzifi Mochamad Gumelar</td>
                <td><span class="badge bg-success">Terlaksana</span></td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <th>Waktu Kegiatan</th>
                    <th>Layanan</th>
                    <th>Detail Layanan</th>
                    <th>Petugas</th>
                    <th>Status</th>
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
        <div class="tab-pane" id="kasus-petugas" role="tabpanel" aria-labelledby="kasus-petugas-tab">
            <div class="card-body p-0">
            <table class="table table-striped projects">
                <thead>
                <tr>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <img alt="Avatar" class="table-avatar" src="https://adminlte.io/themes/v3/dist/img/avatar.png" style="margin-right: 10px">
                            Addzifi Mochamad Gumelar
                        </td>
                        <td>
                            <h6><span class="badge badge-pill badge-primary">Penerima Pengaduan</span></h6>
                        </td>
                    </tr>
                </tbody>
            </table>
            </div>
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

<script>
    $(function () {
      $("#example1").DataTable({
        "responsive": false, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print",
              {
                className: "btn-info",
                text: 'Tambah',
                  action: function ( ) {
                    window.location.assign('http://127.0.0.1:8000/dokumen/add')
                  }
              }]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });

    $('#example1 tbody').on( 'click', 'tr', function () {
        alert('redirect ke : '+this.id);
        window.location.assign('{{ route("kasus.detail") }}')
    } );


    $(function () {
      $("#example2").DataTable({
        "responsive": false, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print",
              {
                className: "btn-info",
                text: 'Tambah',
                  action: function ( ) {
                    window.location.assign('http://127.0.0.1:8000/dokumen/add')
                  }
              }],
        "pageLength": 5
      }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
    });

    $('#example2 tbody').on( 'click', 'tr', function () {
        alert('redirect ke : '+this.id);
        window.location.assign('{{ route("kasus.detail") }}')
    } );
    
    $(function () {
      //Initialize Select2 Elements
      $('.select2').select2()
  
      //Initialize Select2 Elements
      $('.select2bs4').select2({
        theme: 'bootstrap4'
      })
    });
</script>
@endsection