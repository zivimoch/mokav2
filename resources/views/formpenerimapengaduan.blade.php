<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>LAPOR KBG</title>
    <!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Bootstrap CSS CDN -->
<link
  rel="stylesheet"
  href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
/>

<!-- Bootstrap JS CDN (popper.js is required for dropdowns and tooltips) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">

    <style>
        .tab-pane {
            padding: 10px;
        }
        .wrap { max-width: 980px; margin: 10px auto 0; }
        #steps { margin: 80px 0 0 0 }
        .commands { overflow: hidden; margin-top: 30px; }
        .prev {float:left}
        .next, .submit {float:right}
        .error { color: #b33; }
        #progress { position: relative; height: 5px; background-color: #eee; margin-bottom: 20px; }
        #progress-complete { border: 0; position: absolute; height: 5px; min-width: 10px; background-color: #337ab7; transition: width .2s ease-in-out; }

        .add-tab {
            position: relative;
        }

        .add-tab a {
            position: absolute;
            right: 0;
            top: -2px;
            background-color: #eee;
            padding: 5px 10px;
            border-radius: 4px;
        }

        .kbw-signature { width: 100%; height: 200px;}
        .sig canvas{
            width: 100% !important;
            height: auto;
            border-style: solid;
        }
        
        .select2-selection__choice {
          background-color: #007bff !important;
          color: #eee !important;
          font-weight: bold;
        }

        .select2-selection__choice__remove {
          color: #fff !important;
        }
        
    </style>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js"></script>
    <script src="{{ asset('source/js//formtowizard.js') }}"></script>
    {{-- <script src="{{ asset('adminlte') }}/plugins/select2/js/select2.full.min.js"></script> --}}
    <link rel="stylesheet" href="{{ asset('adminlte') }}/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('adminlte') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <script src="{{ asset('adminlte') }}/plugins/select2/js/select2.full.min.js"></script>
  
    <script>
        $( function() {
            //Initialize Select2 Elements
            $( ".select2_field" ).select2();

            var $formulirPelaporan = $( '#FormulirPelaporan' );
            
            $formulirPelaporan.validate({errorElement: 'em'});
            
            $formulirPelaporan.formToWizard({
                submitButton: 'SaveAccount',
                nextBtnClass: 'btn btn-primary next',
                prevBtnClass: 'btn btn-default prev',
                buttonTag:    'button',
                validateBeforeNext: function(form, step) {
                    var stepIsValid = true;
                    var validator = form.validate();
                    $(':input', step).each( function(index) {
                        var xy = validator.element(this);
                        stepIsValid = stepIsValid && (typeof xy == 'undefined' || xy);
                    });
                    return stepIsValid;
                },
                progress: function (i, count) {
                  count = count - 1;
                    $('#progress-complete').width(''+(i/count*100)+'%');
                }
            });
        });
    </script>
    
</head>
{{-- ubah ini dan style wrapper saat production  --}}
@php
    $url = request()->url();
    $urlSegments = explode('/', $url);
    $firstSegment = isset($urlSegments[3]) ? $urlSegments[3] : null;
@endphp
@if($firstSegment === 'latihan')
<div class="alert alert-danger" style="position: fixed; z-index:10000; width:100%;">
  <center><b>MOKA.V2 (LATIHAN)</b></center>
</div>
<div class="alert alert-danger" style="width:100%;"></div>
@endif
@if (((env('APP_URL') == 'http://127.0.0.1:8000') || ($firstSegment === 'latihan')) && isset(Auth::user()->id))
{{-- MOKA V2.0 ANNOUCMENT BOX  --}}
<style>
  .chat-box {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 500px;
    background: #f2f2f2;
    border: 1px solid #ccc;
    border-radius: 5px;
    z-index:10000000;
  }

  .chat-header {
    background: #333;
    color: #fff;
    padding: 0px 15px 0px 15px ;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .chat-title {
    margin: 0;
  }

  .toggle-button {
    background: none;
    border: none;
    color: #fff;
    font-size: 30px;
    cursor: pointer;
    padding: 0;
    margin: 0;
  }

  .chat-body {
    display: block;
    padding: 15px;
  }

  .chat-body.hidden {
    display: none;
  }
  .custom-rounded-image {
    width: 100px; /* Set the desired width */
    height: 100px; /* Set the desired height */
    object-fit: cover; /* Crop the image to cover the entire circular area */
    border-radius: 50%; /* Create a circular shape */
}
</style>
<div class="chat-box">
  <div class="chat-header">
    <div class="chat-title">Anda Login Sebagai : </div>
    <button class="toggle-button">-</button>
  </div>
  <div class="chat-body">
    <div class="card card-widget widget-user-2">
      <!-- Add the bg color to the header using any of the bg-* classes -->
      <div class="widget-user-header bg-warning">
        <div class="row">
          <div class="col-md-3">
            <div class="widget-user-image">
              <img class="custom-rounded-image" src="{{ asset('img/profile/'.Auth::user()->foto) }}" alt="User Avatar"
              onerror="this.onerror=null; this.src='{{ asset('adminlte/dist/img/default-150x150.png') }}'" >
            </div>
          </div>
          <div class="col-md-8">
            <!-- /.widget-user-image -->
            <h3 class="widget-user-username">{{ Auth::user()->name }}</h3>
            <h5 class="widget-user-desc">{{ Auth::user()->jabatan }}</h5>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const chatBody = document.querySelector(".chat-body");
    const toggleButton = document.querySelector(".toggle-button");

    toggleButton.addEventListener("click", function () {
      chatBody.classList.toggle("hidden");
      toggleButton.textContent = chatBody.classList.contains("hidden")
        ? "+"
        : "-";
    });
  });

  $(document).ready(function () {
    $(".toggle-button").click(function () {
      $(".chat-body").slideToggle();
      if ($(".toggle-button").text() === "-") {
        $(".toggle-button").text("+");
      } else {
        $(".toggle-button").text("-");
      }
    });
  });
</script>
{{-- END MOKA V2.0  --}}
@endif

<body style="background-color:#e4f1ff">
@if (isset(Auth::user()->id))
  <a href="{{ route('dashboard') }}"><- Kembali Ke MOKA</a>
@endif
<div class="row wrap" style="background-color:#fff">
  <h1 style="margin:45px auto 30px auto;" class="text-center">LAPOR KEKERASAN BERBASIS GENDER</h1>
  <div class="col-lg-12">
    <div id='progress'><div id='progress-complete'></div></div>
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <b>GAGAL ! </b>
                <ul>
                <?php
                $error = $response->errors;
                ?>
                @foreach ($error->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('response') }}
            @if (isset(Auth::user()->id))
              @if (Auth::user()->jabatan == "Penerima Pengaduan")
                  <a href="{{ route('kasus.show', session('uuid')) }}" class="btn btn-success">Lihat Kasus</a>
              @endif
            @endif
        </div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <b>GAGAL ! </b>
            <br>
            {{ session('response') }}
        </div>
        @endif
    <form id="FormulirPelaporan" action="{{ route('formpenerimapengaduan.store') }}" method="POST">
      @csrf

      <fieldset>
        
        <legend>A. Data Kasus</legend>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label>Rujukan <span style="color:red">*</span></label>
              <select name="sumber_rujukan" id="sumber_rujukan" class="form-control select2bs4" style="width: 100%" required>
                <option value="Bukan Rujukan" selected>Bukan Rujukan</option>
                @foreach ($sumber_rujukan as $item) 
                <option value="{{ $item }}" >{{ $item }}</option> 
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Media Pengaduan <span style="color:red">*</span></label>
              <select name="media_pengaduan" id="media_pengaduan" class="form-control select2bs4" style="width: 100%" required>
                <option value="" selected></option>
                @foreach ($media_pengaduan as $item) 
                <option value="{{ $item }}" >{{ $item }}</option> 
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Sumber Informasi Mengetahui PPPA <span style="color:red" class="required-lables">*</span></label>
              <select name="sumber_informasi" id="sumber_informasi" class="form-control select2bs4 required-field" style="width: 100%" required>
                <option value="" selected></option>
                @foreach ($sumber_informasi as $item) 
                <option value="{{ $item }}" >{{ $item }}</option> 
                @endforeach
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label>Tanggal Pelaporan <span style="color:red">*</span></label>
              <input name="tanggal_pelaporan" type="date" class="form-control" required />
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Tanggal Kejadian <span style="color:red">*</span></label>
              <div class="input-group">
                <input name="tanggal_kejadian" type="date" class="form-control" required/>
                <div class="input-group-append">
                  <select name="perkiraan_tanggal_kejadian">
                    <option value="0" selected>Bukan Perkiraan</option>
                    <option value="1">Perkiraan</option>
                  </select>
                </div>
              </div> 
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Kategori Lokasi TKP <span style="color:red" class="required-lables">*</span></label>
              <select name="kategori_lokasi" id="kategori_lokasi" class="form-control select2bs4 required-field" style="width: 100%" required>
                <option value=""></option>
                @php
                 $no_kategori_lokasi = 1;   
                @endphp
                  @foreach ($kategori_lokasi as $group => $groupItems)
                    <optgroup label="{{ $no_kategori_lokasi.'. '. $group }}">
                        @foreach ($groupItems as $item)
                            <option value="{{ $item }}">{{ $item }}</option>
                        @endforeach
                    </optgroup>
                    @php
                      $no_kategori_lokasi++;
                    @endphp
                  @endforeach
              </select>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
              <div class="col-md-3">
                  <label>Provinsi TKP <span style="color:red" class="required-lables">*</span></label>
                  <select name="provinsi_id_kasus" class="form-control select2bs4 required-field" id="provinsi_id_kasus" style="width:100%" onchange="getkotkab('kasus')" required>
                      <option value="" selected></option>
                      @foreach ($provinsi as $item) 
                      <option value="{{ $item->code }}" >{{ $item->name }}</option> 
                      @endforeach
                  </select>
              </div>
              <div class="col-md-3">
                  <div>
                      <label>Kota TKP <span style="color:red" class="required-lables">*</span></label>
                      <select name="kota_id_kasus" class="form-control select2bs4 required-field" id="kota_id_kasus" style="width: 100%" onchange="getkecamatan('kasus')" required>
                          <option value="" selected></option>
                      </select>
                  </div>
              </div>
              <div class="col-md-3">
                  <div class="form-group">
                      <label>Kecamatan TKP <span style="color:red" class="required-lables">*</span></label>
                      <select name="kecamatan_id_kasus" class="form-control select2bs4 required-field" id="kecamatan_id_kasus" style="width: 100%" onchange="getkelurahan('kasus')" required>
                          <option value="" selected></option>
                      </select>
                  </div>
              </div>
              <div class="col-md-3">
                  <div class="form-group">
                      <label>Kelurahan TKP <span style="color:red" class="required-lables">*</span></label>
                      <select name="kelurahan_id_kasus" class="form-control select2bs4 required-field" id="kelurahan_id_kasus" style="width: 100%" required>
                        <option value="" selected></option>
                      </select>
                  </div>
              </div>
              </div>
          </div>
          <div class="form-group">
          <label>Alamat Lengkap TKP</label>
          <textarea class="form-control" name="alamat_kasus"></textarea>
          </div>
          <div class="form-group">
          <label>Ringkasan Kasus <span style="color:red">*</span></label>
          <textarea class="form-control" name="ringkasan" required></textarea>
          </div>
      </fieldset>

        <fieldset>
            <legend>B. Identitas Pelapor</legend>
            <div class="row"> 
              <div class="col-md-6"> 
                  <div class="form-group"> 
                      <label>NIK</label> 
                      <div class="input-group">
                        <input name="nik_pelapor" id="nik_pelapor" type="number" class="form-control" maxlength="16">
                        <div class="input-group-append">
                          <button class="btn btn-outline-secondary" type="button" onclick="cariData('pelapor')">Cari</button>
                        </div>
                      </div> 
                    </div>
                  <div id="check_kasus"></div>
              </div> 
              <div class="col-md-6"> 
                  <div class="form-group"> 
                      <label>Nama Lengkap <span style="color:red">*</span></label> 
                      <input name="nama_pelapor" id="nama_pelapor" type="text" class="form-control titlecase" required /> 
                  </div> 
              </div> 
          </div> 
          <div class="row"> 
              <div class="col-md-4"> 
                  <div class="form-group"> 
                      <label>Tempat Lahir</label> 
                      <input name="tempat_lahir_pelapor" id="tempat_lahir_pelapor" type="text" class="form-control titlecase"/> 
                  </div> 
              </div> 
              <div class="col-md-4"> 
                  <div class="form-group"> 
                      <label>Tanggal Lahir  <span style="color:red">*</span></label> 
                      <div class="input-group">
                        <input name="tanggal_lahir_pelapor" id="tanggal_lahir_pelapor" type="date" class="form-control" required/> 
                        <div class="input-group-append">
                          <select name="perkiraan_tanggal_lahir_pelapor" class="perkiraan-dropdown" onchange="perkiraan_umur()">
                            <option value="0" selected>Bukan Perkiraan</option>
                            <option value="1">Perkiraan</option>
                          </select>
                        </div>
                      </div> 
                  </div> 
              </div> 
              <div class="col-md-4"> 
                  <div class="form-group"> 
                      <label>Jenis Kelamin</label> 
                      <select name="jenis_kelamin_pelapor" id="jenis_kelamin_pelapor" class="form-control select2bs4" style="width:100%"> 
                          <option value="perempuan" selected>Perempuan</option> 
                          <option value="laki-laki">Laki-Laki</option> 
                      </select> 
                  </div> 
              </div> 
          </div> 
          {{-- alamat  --}}
          <div style="border: 1px dashed; padding:10px 10px 5px 10px; margin-bottom:15px">
            <legend>Alamat</legend>
            <div class="form-group"> 
              <div class="row"> 
                <div class="col-md-3"> 
                    <label>Provinsi KTP</label> 
                    <select name="provinsi_id_pelapor_ktp" id="provinsi_id_pelapor_ktp" class="form-control select2bs4" onchange="getkotkab('pelapor_ktp')" style="width:100%"> 
                        <option value="" selected></option> 
                        @foreach ($provinsi as $item) 
                            <option value="{{ $item->code }}" >{{ $item->name }}</option> 
                        @endforeach 
                    </select> 
                </div> 
                <div class="col-md-3"> 
                    <div class="form-group"> 
                        <label>Kota KTP</label> 
                        <select name="kota_id_pelapor_ktp" id="kota_id_pelapor_ktp" class="form-control select2bs4" style="width:100%" onchange="getkecamatan('pelapor_ktp')"> 
                            <option value="" selected></option> 
                        </select> 
                    </div> 
                </div> 
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Kecamatan KTP</label>
                        <select name="kecamatan_id_pelapor_ktp" class="form-control select2bs4" id="kecamatan_id_pelapor_ktp" style="width: 100%" onchange="getkelurahan('pelapor_ktp')">
                            <option value="" selected></option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Kelurahan KTP</label>
                        <select name="kelurahan_id_pelapor_ktp" class="form-control select2bs4" id="kelurahan_id_pelapor_ktp" style="width: 100%">
                          <option value="" selected></option>
                        </select>
                    </div>
                </div>
            </div> 
            </div> 
            <div class="form-group"> 
                <label>Alamat Lengkap KTP</label> 
                <textarea name="alamat_pelapor_ktp" class="form-control" id="alamat_pelapor_ktp"></textarea> 
            </div> 

            <div class="form-group"> 
              <div class="row"> 
                <div class="col-md-3"> 
                    <label>Provinsi Domisili</label> 
                    <select name="provinsi_id_pelapor" id="provinsi_id_pelapor" class="form-control select2bs4" onchange="getkotkab('pelapor')" style="width:100%"> 
                        <option value="" selected></option> 
                        @foreach ($provinsi as $item) 
                            <option value="{{ $item->code }}" >{{ $item->name }}</option> 
                        @endforeach 
                    </select> 
                </div> 
                <div class="col-md-3"> 
                    <div class="form-group"> 
                        <label>Kota Domisili</label> 
                        <select name="kota_id_pelapor" id="kota_id_pelapor" class="form-control select2bs4" style="width:100%" onchange="getkecamatan('pelapor')"> 
                            <option value="" selected></option> 
                        </select> 
                    </div> 
                </div> 
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Kecamatan Domisili</label>
                        <select name="kecamatan_id_pelapor" class="form-control select2bs4" id="kecamatan_id_pelapor" style="width: 100%" onchange="getkelurahan('pelapor')">
                            <option value="" selected></option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Kelurahan Domisili</label>
                        <select name="kelurahan_id_pelapor" class="form-control select2bs4" id="kelurahan_id_pelapor" style="width: 100%">
                          <option value="" selected></option>
                        </select>
                    </div>
                </div>
            </div> 
            </div> 
            <div class="form-group"> 
                <label>Alamat Lengkap Domisili </label> 
                <textarea name="alamat_pelapor" class="form-control" id="alamat_pelapor"></textarea> 
            </div> 
          </div>
          {{-- alamat end  --}}
          <div class="row"> 
            <div class="col-md-6">
                <div class="form-group"> 
                    <label>Agama</label> 
                    <select name="agama_pelapor" id="agama_pelapor" class="form-control select2bs4" style="width:100%"> 
                        <option value="" selected></option> 
                        @foreach ($agama as $item) 
                            <option value="{{ $item }}" >{{ $item }}</option> 
                        @endforeach 
                    </select> 
                </div>
            </div> 
            <div class="col-md-6">
                <div class="form-group"> 
                    <label>Status Perkawinan</label> 
                    <select name="perkawinan_pelapor" id="perkawinan_pelapor" class="form-control select2bs4" style="width:100%"> 
                        <option value="" ></option> 
                        @foreach ($status_perkawinan as $item) 
                        <option value="{{ $item }}" >{{ $item }}</option> 
                        @endforeach
                    </select> 
                </div>
            </div> 
        </div> 
        <div class="row"> 
          <div class="col-md-6">
              <div class="form-group"> 
                  <label>Pekerjaan</label> 
                  <select name="pekerjaan_pelapor" id="pekerjaan_pelapor" class="form-control select2bs4" style="width:100%"> 
                      <option value="" selected></option>  
                      @foreach ($pekerjaan as $item) 
                          <option value="{{ $item }}" >{{ $item }}</option> 
                      @endforeach 
                  </select> 
              </div>
          </div> 
          <div class="col-md-6"> 
              <div class="form-group"> 
                  <label>Kewarganegaraan</label> 
                  <select name="kewarganegaraan_pelapor" id="kewarganegaraan_pelapor" class="form-control">
                    <option value="WNI" selected>WNI</option>
                    <option value="WNA">WNA</option>
                  </select>
              </div> 
          </div> 
      </div> 
          <div class="row"> 
              <div class="col-md-6">
                  <div class="form-group"> <label>Status Pendidikan</label> 
                      <select name="status_pendidikan_pelapor" id="status_pendidikan_pelapor" class="form-control select2bs4" style="width:100%"> 
                          <option value="" selected></option> 
                          @foreach ($status_pendidikan as $item) 
                              <option value="{{ $item }}" >{{ $item }}</option> 
                          @endforeach 
                      </select> 
                  </div>
              </div> 
              <div class="col-md-6">
                  <div class="form-group"> 
                      <label>Pendidikan terakhir</label> 
                      <select name="pendidikan_pelapor" id="pendidikan_pelapor" class="form-control select2bs4" style="width:100%"> 
                          <option value="" selected></option> 
                          @foreach ($pendidikan_terakhir as $item) 
                              <option value="{{ $item }}" >{{ $item }}</option> 
                          @endforeach 
                      </select> 
                  </div>
              </div> 
          </div> 
          <div class="form-group"> 
              <label>No Telp</label> 
              <input name="no_telp_pelapor" id="no_telp_pelapor" type="number" class="form-control"/> 
          </div> 
        </fieldset>

        <fieldset>
            <legend>C. Identitas Korban</legend>
            <ul class="nav nav-tabs" id="myTab">
              <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#klien1"><span  class="tab_title_klien1">Nama Korban</span> <button type="button" class="close" aria-label="Close" style="margin-left:10px; margin-right:-5px" onclick="return confirm('Hapus data klien ini?');"><span aria-hidden="true">&times;</span></button></a>
              </li>
            
              <li class="nav-item add-tab-item add-tab">
                <span id="add-tab" class="btn btn-primary" style="margin-bottom: -18px;">
                  Tambah Korban
                </span>
              </li>
            </ul>

            <div class="tab-content" style="padding-top: 25px">

              <div id="klien1" class="tab-pane fade show active">

                <div class="form-group"> 
                  <label>Hubungan Pelapor Dengan Korban (Pelapor siapanya Korban?) <span style="color:red">*</span></label> 
                  <select name="hubungan_pelapor[]" class="form-control select2bs4" id="hubungan_pelapor_klien1" style="width:100%" onchange="copyDataPelapor('klien1')" required> 
                          <option value="" selected></option>
                          @foreach ($hubungan_dengan_klien as $item) 
                          <option value="{{ $item }}" >{{ $item }}</option> 
                          @endforeach  
                      </select> 
                </div>

              <hr style="border-top: 1px dashed;">

              <div class="row"> 
                <div class="col-md-6"> 
                    <div class="form-group"> 
                        <label>NIK</label> 
                        <div class="input-group">
                          <input name="nik_klien[]" id="nik_klien_klien1" type="number" class="form-control nik_klien" maxlength="16">
                          <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" onclick="cariData('klien_klien1')">Cari</button>
                          </div>
                        </div> 
                      </div>
                    <div id="check_kasus"></div>
                </div> 
                  <div class="col-md-6"> 
                      <div class="form-group"> 
                          <label>Nama Lengkap <span style="color:red">*</span></label> 
                          <input name="nama_klien[]" id="nama_klien_klien1" type="text" class="form-control titlecase nama_klien" onkeyup="ubahtabtitle('klien1')" required /> 
                      </div> 
                  </div> 
              </div> 
              <div class="row"> 
                  <div class="col-md-4"> 
                      <div class="form-group"> 
                          <label>Tempat Lahir <span style="color:red" class="required-lables">*</span></label> 
                          <input name="tempat_lahir_klien[]" id="tempat_lahir_klien_klien1" type="text" class="form-control titlecase required-field" required/> 
                      </div> 
                  </div> 
                  <div class="col-md-4"> 
                      <div class="form-group"> 
                          <label>Tanggal Lahir <span style="color:red">*</span></label> 
                          <div class="input-group">
                          <input name="tanggal_lahir_klien[]" id="tanggal_lahir_klien_klien1" type="date" class="form-control" required/> 
                            <div class="input-group-append">
                              <select name="perkiraan_tanggal_lahir_klien[]" class="perkiraan-dropdown" onchange="perkiraan_umur()">
                                <option value="0" selected>Bukan Perkiraan</option>
                                <option value="1">Perkiraan</option>
                              </select>
                            </div>
                          </div> 
                      </div> 
                  </div> 
                  <div class="col-md-4"> 
                      <div class="form-group"> 
                          <label>Jenis Kelamin <span style="color:red">*</span></label> 
                          <select name="jenis_kelamin_klien[]" id="jenis_kelamin_klien_klien1" class="form-control select2bs4" style="width:100%" required> 
                              <option value="perempuan" selected>Perempuan</option> 
                              <option value="laki-laki">Laki-Laki</option> 
                          </select> 
                      </div> 
                  </div> 
              </div> 
              
          {{-- alamat  --}}
          <div style="border: 1px dashed; padding:10px 10px 5px 10px; margin-bottom:15px">
            <legend>Alamat</legend>
              <div class="form-group"> 
                <div class="row"> 
                  <div class="col-md-3"> 
                      <label>Provinsi KTP</label> 
                      <select name="provinsi_id_klien_ktp[]" id="provinsi_id_klien_ktp_klien1" class="form-control select2bs4" onchange="getkotkab('klien_ktp_klien1')" style="width:100%"> 
                          <option value="" selected></option> 
                          @foreach ($provinsi as $item) 
                              <option value="{{ $item->code }}" >{{ $item->name }}</option> 
                          @endforeach 
                      </select> 
                  </div> 
                  <div class="col-md-3"> 
                      <div class="form-group"> 
                          <label>Kota KTP</label> 
                          <select name="kota_id_klien_ktp[]" id="kota_id_klien_ktp_klien1" class="form-control select2bs4" style="width:100%" onchange="getkecamatan('klien_ktp_klien1')"> 
                          </select> 
                      </div> 
                  </div> 
                  <div class="col-md-3">
                      <div class="form-group">
                          <label>Kecamatan KTP</label>
                          <input type="text" id="kecamatan_klien_ktp_klien1" hidden>
                          <select name="kecamatan_id_klien_ktp[]" class="form-control select2bs4" id="kecamatan_id_klien_ktp_klien1" style="width: 100%" onchange="getkelurahan('klien_ktp_klien1')">
                          </select>
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="form-group">
                          <label>Kelurahan KTP</label>
                          <select name="kelurahan_id_klien_ktp[]" class="form-control select2bs4" id="kelurahan_id_klien_ktp_klien1" style="width: 100%">
                          </select>
                      </div>
                  </div>
              </div> 
              </div> 
              <div class="form-group"> 
                  <label>Alamat Lengkap KTP</label> 
                  <textarea name="alamat_klien_ktp[]" class="form-control" id="alamat_klien_ktp_klien1"></textarea> 
              </div> 
              <div class="form-group"> 
                <div class="row"> 
                  <div class="col-md-3"> 
                      <label>Provinsi Domisili</label> 
                      <select name="provinsi_id_klien[]" id="provinsi_id_klien_klien1" class="form-control select2bs4" onchange="getkotkab('klien_klien1')" style="width:100%"> 
                          <option value="" selected></option> 
                          @foreach ($provinsi as $item) 
                              <option value="{{ $item->code }}" >{{ $item->name }}</option> 
                          @endforeach 
                      </select> 
                  </div> 
                  <div class="col-md-3"> 
                      <div class="form-group"> 
                          <label>Kota Domisili</label> 
                          <select name="kota_id_klien[]" id="kota_id_klien_klien1" class="form-control select2bs4" style="width:100%" onchange="getkecamatan('klien_klien1')"> 
                              <option value="" selected></option> 
                          </select> 
                      </div> 
                  </div> 
                  <div class="col-md-3">
                      <div class="form-group">
                          <label>Kecamatan Domisili</label>
                          <input type="text" id="kecamatan_klien_klien1" hidden>
                          <select name="kecamatan_id_klien[]" class="form-control select2bs4" id="kecamatan_id_klien_klien1" style="width: 100%" onchange="getkelurahan('klien_klien1')">
                              <option value="" selected></option>
                          </select>
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="form-group">
                          <label>Kelurahan Domisili</label>
                          <select name="kelurahan_id_klien[]" class="form-control select2bs4" id="kelurahan_id_klien_klien1" style="width: 100%">
                            <option value="" selected></option>
                          </select>
                      </div>
                  </div>
              </div> 
              </div> 
              <div class="form-group"> 
                  <label>Alamat Lengkap Domisili </label> 
                  <textarea name="alamat_klien[]" class="form-control" id="alamat_klien_klien1"></textarea> 
              </div>
          </div>

            <div class="row"> 
                <div class="col-md-6">
                    <div class="form-group"> 
                        <label>Agama</label> 
                        <select name="agama_klien[]" id="agama_klien_klien1" class="form-control select2bs4" style="width:100%"> 
                            <option value="" selected></option> 
                            @foreach ($agama as $item) 
                                <option value="{{ $item }}" >{{ $item }}</option> 
                            @endforeach 
                        </select> 
                    </div>
                </div> 
                <div class="col-md-6">
                    <div class="form-group"> 
                        <label>Status Perkawinan</label> 
                        <select name="perkawinan_klien[]" id="perkawinan_klien_klien1" class="form-control select2bs4" style="width:100%"> 
                            <option value="" ></option> 
                            @foreach ($status_perkawinan as $item) 
                            <option value="{{ $item }}" >{{ $item }}</option> 
                            @endforeach
                        </select> 
                    </div>
                </div> 
            </div> 

              <div class="row"> 
                <div class="col-md-6">
                    <div class="form-group"> 
                        <label>Pekerjaan</label> 
                        <select name="pekerjaan_klien[]" id="pekerjaan_klien_klien1" class="form-control select2bs4" style="width:100%"> 
                            <option value="" selected></option>  
                            @foreach ($pekerjaan as $item) 
                                <option value="{{ $item }}" >{{ $item }}</option> 
                            @endforeach 
                        </select> 
                    </div>
                </div> 
                <div class="col-md-6"> 
                    <div class="form-group"> 
                        <label>Kewarganegaraan</label> 
                        <select name="kewarganegaraan_klien[]" id="kewarganegaraan_klien_klien1" class="form-control">
                          <option value="WNI" selected>WNI</option>
                          <option value="WNA">WNA</option>
                        </select>
                    </div> 
                </div> 
            </div> 
            
              <div class="row"> 
                  <div class="col-md-6">
                      <div class="form-group"> <label>Status Pendidikan <span style="color:red" class="required-lables">*</span></label> 
                          <select name="status_pendidikan_klien[]" id="status_pendidikan_klien_klien1" class="form-control select2bs4 required-field" style="width:100%" required> 
                              <option value="" selected></option> 
                              @foreach ($status_pendidikan as $item) 
                                  <option value="{{ $item }}" >{{ $item }}</option> 
                              @endforeach 
                          </select> 
                      </div>
                  </div> 
                  <div class="col-md-6">
                      <div class="form-group"> 
                          <label>Pendidikan terakhir <span style="color:red" class="required-lables">*</span>
                          </label> 
                          <select name="pendidikan_klien[]" id="pendidikan_klien_klien1" class="form-control select2bs4 required-field" style="width:100%" required> 
                              <option value="" selected></option> 
                              @foreach ($pendidikan_terakhir as $item) 
                                  <option value="{{ $item }}" >{{ $item }}</option> 
                              @endforeach 
                          </select> 
                      </div>
                  </div> 
              </div> 
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group"> 
                    <label>No Telp</label> 
                    <input name="no_telp_klien[]" id="no_telp_klien_klien1" type="number" class="form-control"/> 
                  </div> 
                </div>
                <div class="col-md-6">
                    <div class="form-group"> 
                        <label>Kedisabilitasan</label> 
                        <select name="kedisabilitasan[]" id="kedisabilitasan_klien1" class="form-control select2bs4" style="width:100%"> 
                            <option value="Non Disabilitas" selected>Non Disabilitas</option> 
                            <option value="Disabilitas">Disabilitas</option> 
                          </select> 
                        </div>
                    </div>
              </div>
              <div class="row"> 
                <div class="col-md-12"> 
                    <div class="form-group"> 
                        <label>Jenis Kekerasan <span style="color:red">*</span></label> 
                        <select name="jenis_kekerasan[0][]" id="jenis_kekerasan_klien1" multiple="multiple" style="width: 100%"  data-placeholder="Dapat dipilih lebih dari 1 jenis kekerasan" required></select>
                    </div> 
                </div> 
                </div>  
                <div class="row">   
                  <div class="col-md-6">
                      <div class="form-group"> 
                          <label>Kondisi Kedaruratan</label> 
                          <select name="kedaruratan[0][]" id="kedaruratan_klien1" class="form-control select2bs4" style="width:100%" multiple="multiple"> 
                            <option value="Tidak Ada" selected>Tidak Ada</option>  
                            @foreach ($kekhususan as $item) 
                                  <option value="{{ $item }}" >{{ $item }}</option> 
                              @endforeach 
                          </select> 
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group"> 
                          <label>Tindak Lanjut</label> 
                          <select name="tindak_lanjut[0][]" id="layanan_kedaruratan_klien1" class="form-control select2bs4" style="width:100%" multiple="multiple"> 
                            @foreach ($kedaruratan as $item) 
                              <option value="{{ $item }}" >{{ $item }}</option> 
                            @endforeach 
                          </select> 
                      </div>
                  </div> 
                </div>
            </div>
            
            </div>
        </fieldset>

        <fieldset>
          <legend>D. Identitas Terlapor</legend>

          <ul class="nav nav-tabs" id="myTab-terlapor">
            <li class="nav-item">
              <a class="nav-link active" data-toggle="tab" href="#terlapor1"><span  class="tab_title_terlapor1">Nama Terlapor</span> <button type="button" class="close" aria-label="Close" style="margin-left:10px; margin-right:-5px" onclick="return confirm('Hapus data klien ini?');"><span aria-hidden="true">&times;</span></button></a>
            </li>
          
            <li class="nav-item add-tab-item add-tab">
              <span id="add-tab-terlapor" class="btn btn-primary" style="margin-bottom: -18px;">
                Tambah Terlapor
              </span>
            </li>
          </ul>

          <div class="tab-content tab-content-terlapor" style="padding-top: 20px">

            <div id="terlapor1" class="tab-pane fade show active">
              <div class="row"> 
                <div class="col-md-6"> 
                    <div class="form-group"> 
                        <label>NIK</label> 
                        <div class="input-group">
                          <input name="nik_terlapor[]" id="nik_terlapor_terlapor1" type="number" class="form-control nik_terlapor" maxlength="16">
                          <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" onclick="cariData('terlapor_terlapor1')">Cari</button>
                          </div>
                        </div> 
                      </div>
                    <div id="check_kasus"></div>
                </div> 
                  <div class="col-md-6"> 
                      <div class="form-group"> 
                          <label>Nama Lengkap <span style="color:red">*</span></label> 
                          <input name="nama_terlapor[]" id="nama_terlapor_terlapor1" type="text" class="form-control titlecase" onkeyup="ubahtabtitle2('terlapor1')" required /> 
                      </div> 
                  </div> 
              </div> 
              <div class="row"> 
                  <div class="col-md-4"> 
                      <div class="form-group"> 
                          <label>Tempat Lahir</label> 
                          <input name="tempat_lahir_terlapor[]" id="tempat_lahir_terlapor_terlapor1" type="text" class="form-control titlecase"/> 
                      </div> 
                  </div> 
                  <div class="col-md-4"> 
                      <div class="form-group"> 
                          <label>Tanggal Lahir <span style="color:red">*</span></label> 
                          <div class="input-group">
                          <input name="tanggal_lahir_terlapor[]" id="tanggal_lahir_terlapor_terlapor1" type="date" class="form-control" required/> 
                              <div class="input-group-append">
                                <select name="perkiraan_tanggal_lahir_terlapor[]" class="perkiraan-dropdown" onchange="perkiraan_umur()">
                                  <option value="0" selected>Bukan Perkiraan</option>
                                  <option value="1">Perkiraan</option>
                                </select>
                              </div>
                            </div> 
                      </div> 
                  </div> 
                  <div class="col-md-4"> 
                      <div class="form-group"> 
                          <label>Jenis Kelamin <span style="color:red" class="required-lables">*</span></label> 
                          <select name="jenis_kelamin_terlapor[]" id="jenis_kelamin_terlapor_terlapor1" class="form-control select2bs4 required-field" style="width:100%" required> 
                              <option value="perempuan" selected>Perempuan</option> 
                              <option value="laki-laki">Laki-Laki</option> 
                          </select> 
                      </div> 
                  </div> 
              </div> 
              
              {{-- alamat  --}}
              <div style="border: 1px dashed; padding:10px 10px 5px 10px; margin-bottom:15px">
              <legend>Alamat</legend>
              <div class="form-group"> 
                <div class="row"> 
                  <div class="col-md-3"> 
                      <label>Provinsi KTP</label> 
                      <select name="provinsi_id_terlapor_ktp[]" id="provinsi_id_terlapor_ktp_terlapor1" class="form-control select2bs4" onchange="getkotkab('terlapor_ktp_terlapor1')" style="width:100%"> 
                          <option value="" selected></option> 
                          @foreach ($provinsi as $item) 
                              <option value="{{ $item->code }}" >{{ $item->name }}</option> 
                          @endforeach 
                      </select> 
                  </div> 
                  <div class="col-md-3"> 
                      <div class="form-group"> 
                          <label>Kota KTP</label> 
                          <select name="kota_id_terlapor_ktp[]" id="kota_id_terlapor_ktp_terlapor1" class="form-control select2bs4" style="width:100%" onchange="getkecamatan('terlapor_ktp_terlapor1')"> 
                          </select> 
                      </div> 
                  </div> 
                  <div class="col-md-3">
                      <div class="form-group">
                          <label>Kecamatan KTP</label>
                          <input type="text" id="kecamatan_terlapor_ktp_terlapor1" hidden>
                          <select name="kecamatan_id_terlapor_ktp[]" class="form-control select2bs4" id="kecamatan_id_terlapor_ktp_terlapor1" style="width: 100%" onchange="getkelurahan('terlapor_ktp_terlapor1')">
                          </select>
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="form-group">
                          <label>Kelurahan KTP</label>
                          <select name="kelurahan_id_terlapor_ktp[]" class="form-control select2bs4" id="kelurahan_id_terlapor_ktp_terlapor1" style="width: 100%">
                          </select>
                      </div>
                  </div>
              </div> 
              </div> 
              <div class="form-group"> 
                  <label>Alamat Lengkap KTP</label> 
                  <textarea name="alamat_terlapor_ktp[]" class="form-control" id="alamat_terlapor_ktp_terlapor1"></textarea> 
              </div> 
              <div class="form-group"> 
                <div class="row"> 
                  <div class="col-md-3"> 
                      <label>Provinsi Domisili</label> 
                      <select name="provinsi_id_terlapor[]" id="provinsi_id_terlapor_terlapor1" class="form-control select2bs4" onchange="getkotkab('terlapor_terlapor1')" style="width:100%"> 
                          <option value="" selected></option> 
                          @foreach ($provinsi as $item) 
                              <option value="{{ $item->code }}" >{{ $item->name }}</option> 
                          @endforeach 
                      </select> 
                  </div> 
                  <div class="col-md-3"> 
                      <div class="form-group"> 
                          <label>Kota Domisili</label> 
                          <select name="kota_id_terlapor[]" id="kota_id_terlapor_terlapor1" class="form-control select2bs4" style="width:100%" onchange="getkecamatan('terlapor_terlapor1')"> 
                              <option value="" selected></option> 
                          </select> 
                      </div> 
                  </div> 
                  <div class="col-md-3">
                      <div class="form-group">
                          <label>Kecamatan Domisili</label>
                          <input type="text" id="kecamatan_terlapor_terlapor1" hidden>
                          <select name="kecamatan_id_terlapor[]" class="form-control select2bs4" id="kecamatan_id_terlapor_terlapor1" style="width: 100%" onchange="getkelurahan('terlapor_terlapor1')">
                              <option value="" selected></option>
                          </select>
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="form-group">
                          <label>Kelurahan Domisili</label>
                          <select name="kelurahan_id_terlapor[]" class="form-control select2bs4" id="kelurahan_id_terlapor_terlapor1" style="width: 100%">
                            <option value="" selected></option>
                          </select>
                      </div>
                  </div>
              </div> 
              </div> 
              <div class="form-group"> 
                  <label>Alamat Lengkap Domisili </label> 
                  <textarea name="alamat_terlapor[]" class="form-control" id="alamat_terlapor_terlapor1"></textarea> 
              </div>
              </div>
              
              <div class="row"> 
                <div class="col-md-6">
                    <div class="form-group"> 
                        <label>Agama</label> 
                        <select name="agama_terlapor[]" id="agama_terlapor_terlapor1" class="form-control select2bs4" style="width:100%"> 
                            <option value="" selected></option> 
                            @foreach ($agama as $item) 
                                <option value="{{ $item }}" >{{ $item }}</option> 
                            @endforeach 
                        </select> 
                    </div>
                </div> 
                <div class="col-md-6">
                    <div class="form-group"> 
                        <label>Status Perkawinan</label> 
                        <select name="perkawinan_terlapor[]" id="perkawinan_terlapor_terlapor1" class="form-control select2bs4" style="width:100%"> 
                            <option value="" ></option> 
                            @foreach ($status_perkawinan as $item) 
                            <option value="{{ $item }}" >{{ $item }}</option> 
                            @endforeach
                        </select> 
                    </div>
                </div> 
              </div> 
              
              <div class="row"> 
                <div class="col-md-6">
                    <div class="form-group"> 
                        <label>Pekerjaan</label> 
                        <select name="pekerjaan_terlapor[]" id="pekerjaan_terlapor_terlapor1" class="form-control select2bs4" style="width:100%"> 
                            <option value="" selected></option>  
                            @foreach ($pekerjaan as $item) 
                                <option value="{{ $item }}" >{{ $item }}</option> 
                            @endforeach 
                        </select> 
                    </div>
                </div> 
                <div class="col-md-6"> 
                    <div class="form-group"> 
                        <label>Kewarganegaraan</label> 
                        <select name="kewarganegaraan_terlapor[]" id="kewarganegaraan_terlapor_terlapor1" class="form-control">
                          <option value="WNI" selected>WNI</option>
                          <option value="WNA">WNA</option>
                        </select>
                    </div> 
                </div> 
              </div> 
              
              <div class="row"> 
                  <div class="col-md-6">
                      <div class="form-group"> <label>Status Pendidikan</label> 
                          <select name="status_pendidikan_terlapor[]" id="status_pendidikan_terlapor_terlapor1" class="form-control select2bs4" style="width:100%"> 
                              <option value="" selected></option> 
                              @foreach ($status_pendidikan as $item) 
                                  <option value="{{ $item }}" >{{ $item }}</option> 
                              @endforeach 
                          </select> 
                      </div>
                  </div> 
                  <div class="col-md-6">
                      <div class="form-group"> 
                          <label>Pendidikan terakhir</label> 
                          <select name="pendidikan_terlapor[]" id="pendidikan_terlapor_terlapor1" class="form-control select2bs4" style="width:100%"> 
                              <option value="" selected></option> 
                              @foreach ($pendidikan_terakhir as $item) 
                                  <option value="{{ $item }}" >{{ $item }}</option> 
                              @endforeach 
                          </select> 
                      </div>
                  </div> 
              </div> 
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group"> 
                    <label>No Telp</label> 
                    <input name="no_telp_terlapor[]" id="no_telp_terlapor_terlapor1" type="number" class="form-control"/> 
                  </div> 
                </div>
              </div>

            </div>

          </div>
      </fieldset>

      {{-- <fieldset>
        <legend>E. Surat Persetujuan Data</legend>
          Dengan menandatangani formulir ini kami menyatakan bahwa data yang diinputkan adalah benar adanya dan dapat dipertanggungjawabkan
          <div class="row" id="ttd_klien"></div>
        </fieldset> --}}
        <p>
            <button id="SaveAccount" class="btn btn-primary submit">Submit form</button>
        </p>
    </form>
</div>
</div>
<center style="margin-top:10px;">formulir ini menggunakan substansi 2.0 || <label style="cursor: pointer"> Required Mode : <input type="checkbox" id="required_mode" checked onchange="required_mode()"></label></center>

{{-- tanda tangan / signature pad --}}
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js" ></script>
<script type="text/javascript" src="{{ asset('source/js/jquery.signature.js') }}"></script>
<link rel="stylesheet" type="text/css" href="http://keith-wood.name/css/jquery.signature.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js" ></script>

<script type="text/javascript">
   
$(document).ready(function () {
  $('.titlecase').on('input', function() {
    var text = $(this).val();
    $(this).val(
      text.replace(
        /\w\S*/g,
        function(txt) {
          return txt.charAt(0).toUpperCase() + txt.substr(1);
        }
      )
    );
  });

  function toTitleCase(text) {
    return text.replace(/\w\S*/g, function(word) {
      return word.charAt(0).toUpperCase() + word.substr(1).toLowerCase();
    });
  }
      
    // Add Tab Function Klien
    $("#add-tab").click(function () {
       // Generate Unique ID for new tab Terlapor
      var newTabId =
        Math.random().toString(36).substring(2, 15) +
        Math.random().toString(36).substring(2, 15);
        
      let no_form_klien = $(".nik_klien").length;

      // Add New Tab Klien
      $("#myTab li.add-tab").before(
        '<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#' +
          newTabId +
          '"><span  class="tab_title_'+ newTabId +'">Nama Korban ' +
          ($("#myTab li:not(.add-tab)").length + 1) +
          '</span> <button type="button" class="close" aria-label="Close" style="margin-left:10px; margin-right:-5px"><span aria-hidden="true">&times;</span></button></a></li>'
      );

      // Add New Tab Content Klien
      $(".tab-content").append(
        '<div id="' + newTabId + '" class="tab-pane fade"></div>'
      );
      $("#" + newTabId).append(
        '<div class="form-group"> <label>Hubungan Pelapor Dengan Korban (Pelapor siapanya Korban?) <span style="color:red">*</span></label> <select name="hubungan_pelapor[]" class="form-control select2bs4" id="hubungan_pelapor_klien" style="width:100%" onchange="copyDataPelapor(\'' + newTabId + '\')" required><option value="" selected></option> <option value="Diri Sendiri">Diri Sendiri</option>@foreach ($hubungan_dengan_klien as $item)<option value="{{ $item }}" >{{ $item }}</option>@endforeach</select> </div><hr style="border-top: 1px dashed;"><div class="row"><div class="col-md-6"><div class="form-group"><label>NIK</label><div class="input-group"> <input name="nik_klien[]" id="nik_klien_' + newTabId + '" type="number" class="form-control nik_klien" maxlength="16"> <div class="input-group-append"> <button class="btn btn-outline-secondary" type="button" onclick="cariData(\'klien_' + newTabId + '\')">Cari</button> </div></div></div><div id="check_kasus"></div></div> <div class="col-md-6"><div class="form-group"><label>Nama Lengkap <span style="color:red">*</span></label><input name="nama_klien[]" id="nama_klien_' + newTabId + '" type="text" class="form-control titlecase nama_klien" onkeyup="ubahtabtitle(\'' + newTabId + '\')" required /></div> </div>  </div> <div class="row"> <div class="col-md-4"><div class="form-group"><label>Tempat Lahir <span style="color:red">*</span></label><input name="tempat_lahir_klien[]" id="tempat_lahir_klien_' + newTabId + '" type="text" class="form-control titlecase" required/></div> </div> <div class="col-md-4"><div class="form-group"> <label>Tanggal Lahir <span style="color:red">*</span></label> <div class="input-group"> <input name="tanggal_lahir_klien[]" id="tanggal_lahir_klien_klien_' + newTabId + '" type="date" class="form-control" required/> <div class="input-group-append"> <select name="perkiraan_tanggal_lahir_klien[]" class="perkiraan-dropdown" onchange="perkiraan_umur()"> <option value="0" selected>Bukan Perkiraan</option> <option value="1">Perkiraan</option> </select> </div> </div> </div> </div> <div class="col-md-4"><div class="form-group"><label>Jenis Kelamin <span style="color:red" class="required-lables">*</span></label><select name="jenis_kelamin_klien[]" id="jenis_kelamin_klien_' + newTabId + '" class="form-control select2bs4 required-field" style="width:100%" required><option value="perempuan" selected>Perempuan</option><option value="laki-laki">Laki-Laki</option></select></div> </div> </div> <div style="border: 1px dashed; padding:10px 10px 5px 10px; margin-bottom:15px"><legend>Alamat</legend><div class="form-group"><div class="row"> <div class="col-md-3"><label>Provinsi KTP</label><select name="provinsi_id_klien_ktp[]" id="provinsi_id_klien_ktp_' + newTabId + '" class="form-control select2bs4" onchange="getkotkab(\'klien_ktp_' + newTabId + '\')" style="width:100%"><option value="" selected></option>@foreach ($provinsi as $item)<option value="{{ $item->code }}" >{{ $item->name }}</option>@endforeach</select> </div> <div class="col-md-3"><div class="form-group"><label>Kota KTP</label><select name="kota_id_klien_ktp[]" id="kota_id_klien_ktp_' + newTabId + '" class="form-control select2bs4" style="width:100%" onchange="getkecamatan(\'klien_ktp_' + newTabId + '\')"></select></div> </div> <div class="col-md-3"> <div class="form-group"> <label>Kecamatan KTP</label> <input type="text" id="kecamatan_klien_ktp_' + newTabId + '" hidden> <select name="kecamatan_id_klien_ktp[]" class="form-control select2bs4" id="kecamatan_id_klien_ktp_' + newTabId + '" style="width: 100%" onchange="getkelurahan(\'klien_ktp_' + newTabId + '\')"> </select> </div></div><div class="col-md-3"> <div class="form-group"> <label>Kelurahan KTP</label> <select name="kelurahan_id_klien_ktp[]" class="form-control select2bs4" id="kelurahan_id_klien_ktp_' + newTabId + '" style="width: 100%"> </select> </div></div></div> </div> <div class="form-group"> <label>Alamat Lengkap KTP</label> <textarea name="alamat_klien_ktp[]" class="form-control" id="alamat_klien_ktp_' + newTabId + '"></textarea> </div> <div class="form-group"><div class="row"> <div class="col-md-3"><label>Provinsi Domisili</label><select name="provinsi_id_klien[]" id="provinsi_id_klien_' + newTabId + '" class="form-control select2bs4" onchange="getkotkab(\'klien_' + newTabId + '\')" style="width:100%"><option value="" selected></option>@foreach ($provinsi as $item)<option value="{{ $item->code }}" >{{ $item->name }}</option>@endforeach</select> </div> <div class="col-md-3"><div class="form-group"><label>Kota Domisili</label><select name="kota_id_klien[]" id="kota_id_klien_' + newTabId + '" class="form-control select2bs4" style="width:100%" onchange="getkecamatan(\'klien_' + newTabId + '\')"><option value="" selected></option></select></div> </div> <div class="col-md-3"> <div class="form-group"> <label>Kecamatan Domisili</label> <input type="text" id="kecamatan_klien_' + newTabId + '" hidden> <select name="kecamatan_id_klien[]" class="form-control select2bs4" id="kecamatan_id_klien_' + newTabId + '" style="width: 100%" onchange="getkelurahan(\'klien_' + newTabId + '\')"> <option value="" selected></option> </select> </div></div><div class="col-md-3"> <div class="form-group"> <label>Kelurahan Domisili</label> <select name="kelurahan_id_klien[]" class="form-control select2bs4" id="kelurahan_id_klien_' + newTabId + '" style="width: 100%"> <option value="" selected></option> </select> </div></div></div> </div> <div class="form-group"> <label>Alamat Lengkap Domisili </label> <textarea name="alamat_klien[]" class="form-control" id="alamat_klien_' + newTabId + '"></textarea> </div></div><div class="row"><div class="col-md-6"><div class="form-group"><label>Agama</label><select name="agama_klien[]" id="agama_klien_' + newTabId + '" class="form-control select2bs4" style="width:100%"><option value="" selected></option>@foreach ($agama as $item)<option value="{{ $item }}" >{{ $item }}</option>@endforeach</select></div></div><div class="col-md-6"><div class="form-group"><label>Status Perkawinan</label><select name="perkawinan_klien[]" id="perkawinan_klien_' + newTabId + '" class="form-control select2bs4" style="width:100%"><option value="" ></option>@foreach ($status_perkawinan as $item)<option value="{{ $item }}" >{{ $item }}</option>@endforeach</select></div></div> </div> <div class="row"><div class="col-md-6"><div class="form-group"><label>Pekerjaan</label><select name="pekerjaan_klien[]" id="pekerjaan_klien_' + newTabId + '" class="form-control select2bs4" style="width:100%"><option value="" selected></option> @foreach ($pekerjaan as $item)<option value="{{ $item }}" >{{ $item }}</option>@endforeach</select></div></div><div class="col-md-6"><div class="form-group"><label>Kewarganegaraan</label><select name="kewarganegaraan_klien[]" id="kewarganegaraan_klien_' + newTabId + '" class="form-control"> <option value="WNI" selected>WNI</option> <option value="WNA">WNA</option></select></div></div> </div> <div class="row"> <div class="col-md-6"> <div class="form-group"> <label>Status Pendidikan <span style="color:red">*</span></label><select name="status_pendidikan_klien[]" id="status_pendidikan_klien_' + newTabId + '" class="form-control select2bs4" style="width:100%" required><option value="" selected></option>@foreach ($status_pendidikan as $item)<option value="{{ $item }}" >{{ $item }}</option>@endforeach</select></div></div> <div class="col-md-6"> <div class="form-group"><label>Pendidikan terakhir <span style="color:red">*</span> </label><select name="pendidikan_klien[]" id="pendidikan_klien_' + newTabId + '" class="form-control select2bs4" style="width:100%" required><option value="" selected></option>@foreach ($pendidikan_terakhir as $item)<option value="{{ $item }}" >{{ $item }}</option>@endforeach</select></div></div> </div> <div class="row"><div class="col-md-6"><div class="form-group"><label>No Telp</label><input name="no_telp_klien[]" id="no_telp_klien_' + newTabId + '" type="number" class="form-control"/> </div></div><div class="col-md-6"><div class="form-group"><label>Kedisabilitasan</label><select name="kedisabilitasan[]" id="kedisabilitasan_' + newTabId + '" class="form-control select2bs4" style="width:100%"><option value="Non Disabilitas" selected>Non Disabilitas</option><option value="Disabilitas">Disabilitas</option></select></div></div></div><div class="row"><div class="col-md-12"><div class="form-group"><label>Jenis Kekerasan <span style="color:red">*</span></label><select name="jenis_kekerasan['+no_form_klien+'][]" id="jenis_kekerasan_' + newTabId + '" multiple="multiple" style="width: 100%" data-placeholder="Dapat dipilih lebih dari 1 jenis kekerasan" required></select></div></div></div><div class="row"><div class="col-md-6"> <div class="form-group"><label>Kondisi Kedaruratan</label><select name="kedaruratan['+no_form_klien+'][]" id="kedaruratan_' + newTabId + '" class="form-control select2bs4" style="width:100%" multiple="multiple"><option value="Tidak Ada" selected>Tidak Ada</option>@foreach ($kekhususan as $item)<option value="{{ $item }}" >{{ $item }}</option>@endforeach</select></div></div><div class="col-md-6"> <div class="form-group"><label>Tindak Lanjut</label><select name="tindak_lanjut['+no_form_klien+'][]" id="layanan_kedaruratan_' + newTabId + '" class="form-control select2bs4" style="width:100%" multiple="multiple"><option value="{{ $item }}" >Fasilitasi SPP</option><option value="{{ $item }}" >Pemberian Informasi</option><option value="{{ $item }}" >Layanan Kedaruratan</option></select></div></div></div>'
      );
      //Initialize Select2 Elements
      $('.select2bs4').select2({
        theme: 'bootstrap4'
        });
      $('.select-tag').select2({
        tags: true,
        theme: 'bootstrap4'
      });      
      getJenisKekerasan(newTabId);

      // Activate New Tab Klien
      $('.titlecase').on('input', function() {
        var text = $(this).val();
        $(this).val(
          text.replace(
            /\w\S*/g,
            function(txt) {
              return txt.charAt(0).toUpperCase() + txt.substr(1);
            }
          )
        );
      });
            
      // tanda tangan verifikasi data klien
      $('#ttd_klien').append("<div class=\"col-md-4 align-self-center\" id=\"kolomTTD_"+newTabId+"\"> <label class=\"\" for=\"\">Tanda tangan untuk klien <span id=\"nama_klien_ttd_"+newTabId+"\"></span> :</label> <br/> <div id=\"sig_"+newTabId+"\" class=\"sig\" > <button onclick=\"hapusTTD('sig_"+newTabId+"','signature_"+newTabId+"')\" type=\"button\" id=\"clear\" class=\"btn btn-danger btn-sm\" style=\"position: absolute\">Hapus</button> </div> <textarea id=\"signature_"+newTabId+"\" name=\"tandatangan[]\" style=\"display: none\"></textarea> <br/> <input type=\"text\" name=\"nama_penandatangan[]\" class=\"form-control\" style=\"border: none; border-bottom: 2px solid black;\" placeholder=\"Nama Lengkap\" /> </div>");
      $('#sig_'+newTabId).signature({syncField: '#signature_'+newTabId, syncFormat: 'PNG'});
      $("canvas").attr("width", 295);
    });

    // Remove Tab Function Klien
    $(document).on("click", "#myTab .close", function () {
      var tabId = $(this).parent().attr("href");
      $(this).parent().parent().remove(); // remove the tab title
      $(tabId).remove(); // remove the tab content
      $("#kolomTTD_"+newTabId).html(''); // remove ttd
    });

    // Add Tab Function Terlapor
    no_form_terlapor = 0;
    $("#add-tab-terlapor").click(function () {
      // Generate Unique ID for new tab Terlapor
      var newTabId =
        Math.random().toString(36).substring(2, 15) +
        Math.random().toString(36).substring(2, 15);
      let no_form_terlapor = $(".nik_terlapor").length;

      // Add New Tab Terlapor
      $("#myTab-terlapor li.add-tab").before(
        '<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#' +
          newTabId +
          '"><span  class="tab_title_'+ newTabId +'">Nama Terlapor ' +
          ($("#myTab-terlapor li:not(.add-tab)").length + 1) +
          '</span> <button type="button" class="close" aria-label="Close" style="margin-left:10px; margin-right:-5px"><span aria-hidden="true">&times;</span></button></a></li>'
      );

      // Add New Tab Content Terlapor
      $(".tab-content-terlapor").append(
        '<div id="' + newTabId + '" class="tab-pane fade"></div>'
      );
      $("#" + newTabId).append(
        '<div class="row"><div class="col-md-6"><div class="form-group"><label>NIK</label><div class="input-group"> <input name="nik_terlapor[]" id="nik_terlapor_' + newTabId + '" type="number" class="form-control nik_terlapor" maxlength="16"> <div class="input-group-append"> <button class="btn btn-outline-secondary" type="button" onclick="cariData(\'terlapor_' + newTabId + '\')">Cari</button> </div></div></div><div id="check_kasus"></div></div> <div class="col-md-6"><div class="form-group"><label>Nama Lengkap <span style="color:red">*</span></label><input name="nama_terlapor[]" id="nama_terlapor_' + newTabId + '" type="text" class="form-control titlecase" onkeyup="ubahtabtitle2(\'' + newTabId + '\')" required /></div> </div>  </div> <div class="row"> <div class="col-md-4"><div class="form-group"><label>Tempat Lahir</label><input name="tempat_lahir_terlapor[]" id="tempat_lahir_terlapor_' + newTabId + '" type="text" class="form-control titlecase"/></div> </div> <div class="col-md-4"><div class="form-group"> <label>Tanggal Lahir <span style="color:red">*</span></label> <div class="input-group"> <input name="tanggal_lahir_terlapor[]" id="tanggal_lahir_terlapor_terlapor_' + newTabId + '" type="date" class="form-control" required/> <div class="input-group-append"> <select name="perkiraan_tanggal_lahir_terlapor[]" class="perkiraan-dropdown" onchange="perkiraan_umur()"> <option value="0" selected>Bukan Perkiraan</option> <option value="1">Perkiraan</option> </select> </div> </div> </div> </div> <div class="col-md-4"><div class="form-group"><label>Jenis Kelamin <span style="color:red" class="required-lables">*</span></label><select name="jenis_kelamin_terlapor[]" id="jenis_kelamin_terlapor_' + newTabId + '" class="form-control select2bs4 required-field" style="width:100%" required><option value="perempuan" selected>Perempuan</option><option value="laki-laki">Laki-Laki</option></select></div> </div> </div> <div style="border: 1px dashed; padding:10px 10px 5px 10px; margin-bottom:15px"><legend>Alamat</legend><div class="form-group"><div class="row"> <div class="col-md-3"><label>Provinsi KTP</label><select name="provinsi_id_terlapor_ktp[]" id="provinsi_id_terlapor_ktp_' + newTabId + '" class="form-control select2bs4" onchange="getkotkab(\'terlapor_ktp_' + newTabId + '\')" style="width:100%"><option value="" selected></option>@foreach ($provinsi as $item)<option value="{{ $item->code }}" >{{ $item->name }}</option>@endforeach</select> </div> <div class="col-md-3"><div class="form-group"><label>Kota KTP</label><select name="kota_id_terlapor_ktp[]" id="kota_id_terlapor_ktp_' + newTabId + '" class="form-control select2bs4" style="width:100%" onchange="getkecamatan(\'terlapor_ktp_' + newTabId + '\')"></select></div> </div> <div class="col-md-3"> <div class="form-group"> <label>Kecamatan KTP</label> <input type="text" id="kecamatan_terlapor_ktp_' + newTabId + '" hidden> <select name="kecamatan_id_terlapor_ktp[]" class="form-control select2bs4" id="kecamatan_id_terlapor_ktp_' + newTabId + '" style="width: 100%" onchange="getkelurahan(\'terlapor_ktp_' + newTabId + '\')"> </select> </div></div><div class="col-md-3"> <div class="form-group"> <label>Kelurahan KTP</label> <select name="kelurahan_id_terlapor_ktp[]" class="form-control select2bs4" id="kelurahan_id_terlapor_ktp_' + newTabId + '" style="width: 100%"> </select> </div></div></div> </div> <div class="form-group"> <label>Alamat Lengkap KTP</label> <textarea name="alamat_terlapor_ktp[]" class="form-control" id="alamat_terlapor_ktp_' + newTabId + '"></textarea> </div> <div class="form-group"><div class="row"> <div class="col-md-3"><label>Provinsi Domisili</label><select name="provinsi_id_terlapor[]" id="provinsi_id_terlapor_' + newTabId + '" class="form-control select2bs4" onchange="getkotkab(\'terlapor_' + newTabId + '\')" style="width:100%"><option value="" selected></option>@foreach ($provinsi as $item)<option value="{{ $item->code }}" >{{ $item->name }}</option>@endforeach</select> </div> <div class="col-md-3"><div class="form-group"><label>Kota Domisili</label><select name="kota_id_terlapor[]" id="kota_id_terlapor_' + newTabId + '" class="form-control select2bs4" style="width:100%" onchange="getkecamatan(\'terlapor_' + newTabId + '\')"><option value="" selected></option></select></div> </div> <div class="col-md-3"> <div class="form-group"> <label>Kecamatan Domisili</label> <input type="text" id="kecamatan_terlapor_' + newTabId + '" hidden> <select name="kecamatan_id_terlapor[]" class="form-control select2bs4" id="kecamatan_id_terlapor_' + newTabId + '" style="width: 100%" onchange="getkelurahan(\'terlapor_' + newTabId + '\')"> <option value="" selected></option> </select> </div></div><div class="col-md-3"> <div class="form-group"> <label>Kelurahan Domisili</label> <select name="kelurahan_id_terlapor[]" class="form-control select2bs4" id="kelurahan_id_terlapor_' + newTabId + '" style="width: 100%"> <option value="" selected></option> </select> </div></div></div> </div> <div class="form-group"> <label>Alamat Lengkap Domisili </label> <textarea name="alamat_terlapor[]" class="form-control" id="alamat_terlapor_' + newTabId + '"></textarea> </div></div><div class="row"><div class="col-md-6"><div class="form-group"><label>Agama</label><select name="agama_terlapor[]" id="agama_terlapor_' + newTabId + '" class="form-control select2bs4" style="width:100%"><option value="" selected></option>@foreach ($agama as $item)<option value="{{ $item }}" >{{ $item }}</option>@endforeach</select></div></div><div class="col-md-6"><div class="form-group"><label>Status Perkawinan</label><select name="perkawinan_terlapor[]" id="perkawinan_terlapor_' + newTabId + '" class="form-control select2bs4" style="width:100%"><option value="" ></option>@foreach ($status_perkawinan as $item)<option value="{{ $item }}" >{{ $item }}</option>@endforeach</select></div></div> </div> <div class="row"><div class="col-md-6"><div class="form-group"><label>Pekerjaan</label><select name="pekerjaan_terlapor[]" id="pekerjaan_terlapor_' + newTabId + '" class="form-control select2bs4" style="width:100%"><option value="" selected></option> @foreach ($pekerjaan as $item)<option value="{{ $item }}" >{{ $item }}</option>@endforeach</select></div></div><div class="col-md-6"><div class="form-group"><label>Kewarganegaraan</label><select name="kewarganegaraan_terlapor[]" id="kewarganegaraan_terlapor_' + newTabId + '" class="form-control"> <option value="WNI" selected>WNI</option> <option value="WNA">WNA</option></select></div></div> </div> <div class="row"> <div class="col-md-6"> <div class="form-group"> <label>Status Pendidikan</label><select name="status_pendidikan_terlapor[]" id="status_pendidikan_terlapor_' + newTabId + '" class="form-control select2bs4" style="width:100%"><option value="" selected></option>@foreach ($status_pendidikan as $item)<option value="{{ $item }}" >{{ $item }}</option>@endforeach</select></div></div> <div class="col-md-6"> <div class="form-group"><label>Pendidikan terakhir </label><select name="pendidikan_terlapor[]" id="pendidikan_terlapor_' + newTabId + '" class="form-control select2bs4" style="width:100%"><option value="" selected></option>@foreach ($pendidikan_terakhir as $item)<option value="{{ $item }}" >{{ $item }}</option>@endforeach</select></div></div> </div> <div class="row"><div class="col-md-12"><div class="form-group"><label>No Telp</label><input name="no_telp_terlapor[]" id="no_telp_terlapor_' + newTabId + '" type="number" class="form-control"/> </div></div></div>'
      );
      //Initialize Select2 Elements
      $('.select2bs4').select2({
        theme: 'bootstrap4'
        });
      $('.select-tag').select2({
        tags: true,
        theme: 'bootstrap4'
      });      
      // Activate New Tab Terlapor
      $('.titlecase').on('input', function() {
        var text = $(this).val();
        $(this).val(
          text.replace(
            /\w\S*/g,
            function(txt) {
              return txt.charAt(0).toUpperCase() + txt.substr(1);
            }
          )
        );
      });
    });

    // Remove Tab Function Terlapor
    $(document).on("click", "#myTab-terlapor .close", function () {
      var tabId = $(this).parent().attr("href");
      $(this).parent().parent().remove(); // remove the tab title
      $(tabId).remove(); // remove the tab content
    });

    // inisiate fungsi list jenis_kekerasan
    getJenisKekerasan('klien1');
  });

  $(document).on('change', '.perkiraan-dropdown', function() {
      perkiraan_umur(this);
  });

  function calculateBirthDate(age) {
      const today = new Date();
      const birthYear = today.getFullYear() - age;
      const birthDate = new Date(birthYear, today.getMonth(), today.getDate());
      return birthDate.toISOString().split('T')[0];
  }

  function perkiraan_umur(dropdown) {
      const dropdownValue = $(dropdown).val();
      const inputField = $(dropdown).closest('.input-group').find('input[type="date"]');
      if (dropdownValue == '1') {
          const age = prompt("Masukan Perkiraan Usia : ");
          if (age && !isNaN(age)) {
              const birthDate = calculateBirthDate(age);
              inputField.val(birthDate);
          }
      }
  }

  function required_mode () {
    if ($('#required_mode').is(":checked"))
    {
      $('.required-field').attr("required",true);
      $('.required-lables').show();
    }else{
      $('.required-field').attr("required",false);
      $('.required-lables').hide();
    }
  }
  
  function getJenisKekerasan(field_id='') {
    $("#jenis_kekerasan_"+field_id).select2({
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
    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
      });
      $('.select-tag').select2({
      tags: true,
      theme: 'bootstrap4'
    });
  }

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36251023-1']);
  _gaq.push(['_setDomainName', 'jqueryscript.net']);
  _gaq.push(['_trackPageview']);
  
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
  
  function hapusTTD(sig, sig_text) {
    // Clear the canvas by setting its width to its own width
    var canvas = $("#" + sig + " canvas")[0];
    canvas.width = canvas.width;
    // Clear the corresponding textarea value
    $("#" + sig_text).val('');
  };

  function ubahtabtitle(newTabId) {
    tab_title = $('#nama_klien_'+newTabId).val();
    $('.tab_title_'+newTabId).html(tab_title);
    $('.hubungan_terlapor').html(tab_title);
    $('#nama_klien_ttd_'+newTabId).html(tab_title);
  }

  function ubahtabtitle2(newTabId) {
    tab_title = $('#nama_terlapor_'+newTabId).val();
    $('.tab_title_'+newTabId).html(tab_title);
  }

  function getkotkab(field_id='') {
        province_code = $('#provinsi_id_'+field_id).val();
        if (province_code!='') {
        $.ajax({
          url:'{{ route("api.v1.kotkab") }}?province_code='+province_code,
          type:'GET',
          dataType: 'json',
          success: function( response ) {
                var option = '<option value="">-- Pilih Kotkab --</option>';
                // khusus buat function copyData pelapor ke klien
                if (field_id.includes('klien') && field_id.includes('ktp')) {
                  // jika ada kliennya dan & ktp nya
                  var kotkabID = $('#kota_id_pelapor_ktp').val();
                } else if (field_id.includes('klien') && !(field_id.includes('ktp'))) {
                  // jika ada kliennya dan & tidak ada ktp nya
                  var kotkabID = $('#kota_id_pelapor').val();
                }else{
                  kotkabID = '';
                }

                // untuk update value idnya buat fungsi copyData
                var updated_value = '';
                
                $.each(response.data, function(i, value) {
                    var selected = ''
                    if (kotkabID == value.code) {
                        selected = `selected="selected"`;
                        updated_value = value.code;
                    }
                    option += `<option value="${value.code}" ${selected}>${value.name}</option>`
                });

                if (field_id.includes('klien')) {
                  // jika ada kliennya dan & ktp nya
                  $('#kota_id_'+field_id).val(updated_value).change();
                }

                $('#kota_id_'+field_id).html(option);
            }
        });
      }
    };

    function getkecamatan(field_id='') {
      kota_code = $('#kota_id_'+field_id).val();
      if (kota_code) {        
        $.ajax({
          url:'{{ route("api.v1.kecamatan") }}?kota_code='+kota_code,
          type:'GET',
          dataType: 'json',
          success: function( response ) {
                var option = '<option value="">-- Pilih Kecamatan --</option>';
                // khusus buat function copyData pelapor ke klien
                if (field_id.includes('klien') && field_id.includes('ktp')) {
                  // jika ada kliennya dan & ktp nya
                  var kecamatanID = $('#kecamatan_id_pelapor_ktp').val();
                } else if (field_id.includes('klien') && !(field_id.includes('ktp'))) {
                  // jika ada kliennya dan & tidak ada ktp nya
                  var kecamatanID = $('#kecamatan_id_pelapor').val();
                }else{
                  kecamatanID = '';
                }

                // untuk update value idnya buat fungsi copyData
                var updated_value = '';

                $.each(response.data, function(i, value) {
                    var selected = '';
                    if (kecamatanID == value.code) {
                        selected = `selected="selected"`;
                        updated_value = value.code;
                    }
                    option += `<option value="${value.code}" ${selected}>${value.name}</option>`
                });
                  $('#kecamatan_'+field_id).val(updated_value);

                  if (field_id.includes('klien') && $('#kecamatan_'+field_id).val() != '') {
                    // jika ada kliennya. untuk copyData klien_ktp_klien1
                    kecamatan_code = $('#kecamatan_'+field_id).val();
                    $('#kecamatan_id_'+field_id).val(updated_value).change();
                    // $('#kecamatan_'+field_id).val(updated_value);
                  } else {
                    kecamatan_code = $('#kecamatan_id_'+field_id).val();
                    $('#kecamatan_id_'+field_id).val(updated_value).change();
                  }

                $('#kecamatan_id_'+field_id).html(option);
            }
        });
      }
    };

    function getkelurahan(field_id='') {
      // ini nanti dibenerin lagi, masih ngambil value kecamatan_codenya dari hidden input text, harusnya dari select
      if (field_id.includes('klien') && $('#kecamatan_'+field_id).val() != '') {
        // jika ada kliennya. untuk copyData klien_ktp_klien1
        kecamatan_code = $('#kecamatan_'+field_id).val();
      } else {
        kecamatan_code = $('#kecamatan_id_'+field_id).val();
        // kecamatan_code = $('#kecamatan_'+field_id).val();
      }
      if (kecamatan_code) {        
        $.ajax({
          url:'{{ route("api.v1.kelurahan") }}?kecamatan_code='+kecamatan_code,
          type:'GET',
          dataType: 'json',
          success: function( response ) {
                var option = '<option value="">-- Pilih Kelurahan --</option>';
                // khusus buat function copyData pelapor ke klien
                if (field_id.includes('klien') && field_id.includes('ktp')) {
                  // jika ada kliennya dan & ktp nya
                  var kelurahanID = $('#kelurahan_id_pelapor_ktp').val();
                } else if (field_id.includes('klien') && !(field_id.includes('ktp'))) {
                  // jika ada kliennya dan & tidak ada ktp nya
                  var kelurahanID = $('#kelurahan_id_pelapor').val();
                }else{
                  kelurahanID = '';
                }

                $.each(response.data, function(i, value) {
                    var selected = '';
                    if (kelurahanID == value.code) {
                        selected = `selected="selected"`;
                    }
                    option += `<option value="${value.code}" ${selected}>${value.name}</option>`
                });

                $('#kelurahan_id_'+field_id).html(option);
            }
        });
      }
    };

    function cariData(person) {
        var nik =  $('#nik_'+person).val();
        var url = '{{ route("carik", ":nik") }}';
        url = url.replace(':nik', nik);
        $.ajax({
            url: url,
            type:'GET',
            dataType: 'json',
            success: function( response ) {
              console.log(response);
            }
        });
    }

    function copyDataPelapor(klien_id) {
      if ($('#hubungan_pelapor_'+klien_id).val() == 'Diri Sendiri') {
        $('#nik_klien_'+klien_id).val($('#nik_pelapor').val());
        $('#nama_klien_'+klien_id).val($('#nama_pelapor').val());
        $('#tempat_lahir_klien_'+klien_id).val($('#tempat_lahir_pelapor').val());
        $('#tanggal_lahir_klien_'+klien_id).val($('#tanggal_lahir_pelapor').val());
        $('#jenis_kelamin_klien_'+klien_id).val($('#jenis_kelamin_pelapor').val()).change();
        $('#provinsi_id_klien_ktp_'+klien_id).val($('#provinsi_id_pelapor_ktp').val()).change();
        getkotkab('klien_ktp_'+klien_id);
        $('#alamat_klien_ktp_'+klien_id).val($('#alamat_pelapor_ktp').val());
        // alamat domisili
        $('#provinsi_id_klien_'+klien_id).val($('#provinsi_id_pelapor').val()).change();
        getkotkab('klien_'+klien_id);
        $('#alamat_klien_'+klien_id).val($('#alamat_pelapor').val());
        $('#agama_klien_'+klien_id).val($('#agama_pelapor').val()).change();
        $('#perkawinan_klien_'+klien_id).val($('#perkawinan_pelapor').val()).change();
        $('#pekerjaan_klien_'+klien_id).val($('#pekerjaan_pelapor').val()).change();
        $('#kewarganegaraan_klien_'+klien_id).val($('#kewarganegaraan_pelapor').val()).change();
        $('#status_pendidikan_klien_'+klien_id).val($('#status_pendidikan_pelapor').val()).change();
        $('#pendidikan_klien_'+klien_id).val($('#pendidikan_pelapor').val()).change();
        $('#no_telp_klien_'+klien_id).val($('#no_telp_pelapor').val());
      }
      // else{
      //   // kalau bukan diri sendiri maka reset semua
      //   $('#nik_klien_'+klien_id).val('');
      //   $('#nama_klien_'+klien_id).val('');
      //   $('#tempat_lahir_klien_'+klien_id).val('');
      //   $('#tanggal_lahir_klien_'+klien_id).val('');
      //   $('#provinsi_id_klien_ktp_'+klien_id).val('').change();
      //   getkotkab('klien_ktp_'+klien_id);
      //   $('#kota_id_klien_ktp_'+klien_id).val('').change();
      //   $('#kecamatan_id_klien_ktp_'+klien_id).val('').change();
      //   $('#kecamatan_klien_ktp_'+klien_id).val('').change();
      //   $('#kelurahan_id_klien_ktp_'+klien_id).val('').change();
      //   $('#alamat_klien_ktp_'+klien_id).val('');
      //   // alamat domisili
      //   $('#provinsi_id_klien_'+klien_id).val('').change();
      //   getkotkab('klien_'+klien_id);
      //   $('#kota_id_klien_'+klien_id).val('').change();
      //   $('#kecamatan_id_klien_'+klien_id).val('').change();
      //   $('#kecamatan_klien_'+klien_id).val('').change();
      //   $('#kelurahan_id_klien_'+klien_id).val('').change();
      //   $('#alamat_klien_'+klien_id).val('');
      //   $('#agama_klien_'+klien_id).val('').change();
      //   $('#perkawinan_klien_'+klien_id).val('').change();
      //   $('#pekerjaan_klien_'+klien_id).val('').change();
      //   $('#kewarganegaraan_klien_'+klien_id).val('').change();
      //   $('#status_pendidikan_klien_'+klien_id).val('').change();
      //   $('#pendidikan_klien_'+klien_id).val('').change();
      //   $('#no_telp_klien_'+klien_id).val('');
      // }
    }
</script>
</body>
</html>