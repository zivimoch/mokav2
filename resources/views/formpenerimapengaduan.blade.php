<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LAPOR KGB</title>
    <!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap CSS CDN -->
<link
  rel="stylesheet"
  href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
/>

<!-- Bootstrap JS CDN (popper.js is required for dropdowns and tooltips) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="{{ asset('adminlte') }}/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('adminlte') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    
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
    </style>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js"></script>
    <script src="{{ asset('source/js//formtowizard.js') }}"></script>
    <script src="{{ asset('adminlte') }}/plugins/select2/js/select2.full.min.js"></script>
    
    <script>
        $( function() {
            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });

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

<body>
<h1 style="margin:45px auto 30px auto;" class="text-center">LAPOR KEKERASAN BERBASIS GENDER</h1>
<div class="row wrap"><div class="col-lg-12">

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
            @if (Auth::user()->jabatan == "Penerima Pengaduan")
                <a href="{{ route('kasus.show', session('uuid')) }}" class="btn btn-success">Lihat Kasus</a>
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
            <legend>A. Identitas Pelapor</legend>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>NIK</label>
                  <input name="nik_pelapor" type="number" class="form-control titlecase"/>
                  </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Nama Lengkap</label>
                  <input name="nama_pelapor" type="text" class="form-control titlecase" required value="{{ old('nama_pelapor') }}"/>
                  </div>
              </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                    <label>Tempat Lahir</label>
                    <input name="tempat_lahir_pelapor" type="text" class="form-control titlecase" value="{{ old('tempat_lahir_pelapor') }}"/>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <input name="tanggal_lahir_pelapor" type="date" class="form-control" value=""/>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-3">
                        <label>Provinsi Domisili</label>
                        <select name="provinsi_id_pelapor" class="form-control select2bs4" id="provinsi_id_pelapor" style="width:100%" onchange="getkotkab('pelapor')">
                            <option value="" selected></option>
                            @foreach ($provinsi as $item)
                                <option value="{{ $item->code }}" >{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Kota Domisili</label>
                            <select name="kota_id_pelapor" class="form-control select2bs4" id="kota_id_pelapor" style="width: 100%" onchange="getkecamatan('pelapor')">
                                <option value="" selected></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Kecamatan Domisili</label>
                            <select name="kecamatan_id_pelapor" class="form-control select2bs4" id="kecamatan_id_pelapor" style="width: 100%">
                                <option value="" selected></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Kelurahan Domisili</label>
                            <input name="kelurahan_pelapor" type="text" class="form-control titlecase" value=""/>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="form-group">
                <label>Alamat Domisili</label>
                <textarea class="form-control" name="alamat_pelapor"></textarea>
                </div>
                <div class="form-group">
                    <label>No Telp</label>
                    <input name="no_telp_pelapor" type="number" class="form-control" value="" />
                </div>
                <div class="form-group"> 
                  <label>Hubungan Dengan Klien (Pelapor siapanya Klien?)</label> 
                  <select name="hubungan_pelapor" class="form-control select2bs4" style="width:100%" required> 
                          <option value="" selected></option> 
                          @foreach ($hubungan_dengan_klien as $item) 
                          <option value="{{ $item }}" >{{ $item }}</option> 
                          @endforeach  
                      </select> 
                  </div>
        </fieldset>

        <fieldset>
            <legend>B. Identitas Klien</legend>
            
            <ul class="nav nav-tabs" id="myTab">
              <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#klien1"><span  id="tab_title_klien1">Nama Klien</span> <button type="button" class="close" aria-label="Close" style="margin-left:10px; margin-right:-5px" onclick="return confirm('Hapus data klien ini?');"><span aria-hidden="true">&times;</span></button></a>
              </li>
            
              <li class="nav-item add-tab-item add-tab">
                <span id="add-tab" class="btn btn-primary" style="margin-bottom: -18px;">
                  Tambah Klien
                </span>
              </li>
            </ul>

            <div class="tab-content" style="padding-top: 25px">

              <div id="klien1" class="tab-pane fade show active">
                <div class="row" id="menu_klien1">
                  <div class="col-sm-6">
                    <div class="card">
                      <div class="card-body">
                        <h5 class="card-title">Klien Perempuan Dewasa</h5>
                        <p class="card-text">Klien dengan jenis kelamin perempuan yang usianya 18 tahun keatas.</p>
                        <a href="#" class="btn btn-primary" onclick="buatformulir('perempuan', 'klien1')">Buat Formulir</a>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="card">
                      <div class="card-body">
                        <h5 class="card-title">Klien Anak</h5>
                        <p class="card-text">Klien dengan jenis kelamin perempuan / laki-laki yang usianya dibawah 18 tahun.</p>
                        <a href="#" class="btn btn-primary" onclick="buatformulir('anak', 'klien1')">Buat Formulir</a>
                      </div>
                    </div>
                  </div>
                </div>

                <div id="formulir_klien1"></div>
              </div>

            </div>
        </fieldset>

        <fieldset>
          <legend>C. Identitas Terlapor</legend>

          <ul class="nav nav-tabs" id="myTab-terlapor">
            <li class="nav-item">
              <a class="nav-link active" data-toggle="tab" href="#terlapor1"><span  id="tab_title_terlapor1">Nama Terlapor</span> <button type="button" class="close" aria-label="Close" style="margin-left:10px; margin-right:-5px" onclick="return confirm('Hapus data klien ini?');"><span aria-hidden="true">&times;</span></button></a>
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
                    <input name="nik_terlapor[]" type="number" class="form-control titlecase" id="nik_terlapor_terlapor1"/> 
                </div> 
              </div>
              <div class="col-md-6">
                <div class="form-group"> 
                    <label>Nama Lengkap</label> 
                    <input name="nama_terlapor[]" type="text" class="form-control titlecase" id="nama_terlapor_terlapor1" onkeyup="ubahtabtitle2('terlapor1')" required /> 
                </div> 
              </div>
            </div>
            <div class="row"> 
                <div class="col-md-4"> 
                    <div class="form-group"> 
                        <label>Tempat Lahir</label> 
                        <input name="tempat_lahir_terlapor[]" type="text" class="form-control titlecase" /> 
                    </div> 
                </div> 
                <div class="col-md-4"> 
                    <div class="form-group"> 
                        <label>Tanggal Lahir</label> 
                        <input name="tanggal_lahir_terlapor[]" type="date" class="form-control" /> 
                    </div> 
                </div> 
                <div class="col-md-4"> 
                    <div class="form-group"> 
                        <label>Jenis Kelamin</label> 
                        <select name="jenis_kelamin_terlapor[]" 
                        id="jenis_kelamin_terlapor1" class="form-control select2bs4" style="width:100%"> 
                        <option value="perempuan" selected>Perempuan</option> 
                        <option value="laki-laki">Laki-Laki</option> 
                    </select> 
                </div> 
            </div> 
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
                            <select name="kecamatan_id_terlapor[]" id="kecamatan_id_terlapor_terlapor1" class="form-control select2bs4" style="width:100%"> <option value="">
                                </option> </select> 
                            </div> 
                        </div> 
                        <div class="col-md-3"> 
                            <div class="form-group"> 
                                <label>Kelurahan Domisili</label> 
                                <input type="text" name="kelurahan_terlapor[]" class="form-control titlecase"> 
                            </div> 
                        </div> 
                    </div> 
                </div> 
                <div class="form-group"> 
                    <label>Alamat Domisili</label> 
                    <textarea name="alamat_terlapor[]" class="form-control" id="alamat_terlapor_terlapor1"></textarea> 
                </div> 
                <div class="form-group"> 
                    <label>No Telp</label> 
                    <input name="no_telp_terlapor[]" id="no_telp_terlapor_terlapor1" type="number" class="form-control"/> 
                </div> <div class="row"> 
                    <div class="col-md-6"> 
                        <div class="form-group"> 
                            <label>Status Pendidikan</label> 
                            <select name="status_pendidikan_terlapor[]" id="status_pendidikan_terlapor_terlapor1" class="form-control select2bs4" style="width:100%"> 
                                <option value=""></option> 
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
                                <label>Suku</label> 
                                <select name="suku_terlapor[]" id="suku_terlapor_terlapor1" class="form-control select2bs4" style="width:100%"> 
                                    <option value="" selected></option>  
                                    @foreach ($suku as $item) 
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
                                <select name="pekerjaan_telapor[]" id="pekerjaan_terlapor_terlapor1" class="form-control select2bs4" style="width:100%"> 
                                    <option value="" selected></option>  
                                    @foreach ($pekerjaan as $item) 
                                    <option value="{{ $item }}" >{{ $item }}</option> 
                                    @endforeach
                                </select> 
                            </div>
                        </div> 
                        <div class="col-md-6"> 
                            <div class="form-group"> 
                                <label>Penghasilan per Bulan</label> 
                                <input name="penghasilan_terlapor[]" id="penghasilan_terlapor_terlapor1" type="number" class="form-control" /> 
                            </div>
                        </div> 
                    </div>  
                    <div class="row"> 
                        <div class="col-md-6">
                            <div class="form-group"> 
                                <label>Status Perkawinan</label> 
                                <select name="perkawinan_terlapor[]" id="perkawinan_terlapor_terlapor1" class="form-control select2bs4" style="width:100%"> 
                                    <option value="" selected></option> 
                                    @foreach ($status_perkawinan as $item) 
                                    <option value="{{ $item }}" >{{ $item }}</option> 
                                    @endforeach 
                                </select> 
                            </div>
                        </div> 
                        <div class="col-md-6"> 
                            <div class="form-group"> 
                                <label>Jumlah Anak</label> 
                                <input name="jumlah_anak_terlapor[]" id="jumlah_anak_terlapor_terlapor1" type="number" class="form-control" /> 
                            </div>
                        </div>
                    </div> 
                    <div class="form-group"> 
                        <label>Hubungan Dengan Klien (Terlapor siapanya Klien?)</label> 
                        <select name="hubungan_terlapor[]" id="hubungan_klien_terlapor1" class="form-control select2bs4" style="width:100%"> 
                                <option value="" selected></option> 
                                @foreach ($hubungan_dengan_klien as $item) 
                                <option value="{{ $item }}" >{{ $item }}</option> 
                                @endforeach  
                            </select> 
                        </div>
            </div>

          </div>
      </fieldset>

      <fieldset>
        <legend>D. Data Kasus</legend>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label>Tanggal Pelaporan</label>
              <input name="tanggal_pelaporan" type="date" class="form-control" required />
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Tanggal Kejadian</label>
              <input name="tanggal_kejadian" type="date" class="form-control" required />
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Kategori Lokasi</label>
              <select name="tempat_kejadian" id="tempat_kejadian" class="form-control select2bs4" style="width: 100%" required>
                <option value="" selected></option>
                @foreach ($tempat_kejadian as $item) 
                <option value="{{ $item }}" >{{ $item }}</option> 
                @endforeach
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label>Media Pengaduan</label>
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
              <label>Sumber Rujukan</label>
              <select name="sumber_rujukan" id="sumber_rujukan" class="form-control select2bs4" style="width: 100%">
                <option value="" selected></option>
                @foreach ($sumber_rujukan as $item) 
                <option value="{{ $item }}" >{{ $item }}</option> 
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Sumber Informasi Mengetahui PPPA</label>
              <select name="sumber_informasi" id="sumber_informasi" class="form-control select2bs4" style="width: 100%" required>
                <option value="" selected></option>
                @foreach ($sumber_informasi as $item) 
                <option value="{{ $item }}" >{{ $item }}</option> 
                @endforeach
              </select>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
              <div class="col-md-3">
                  <label>Provinsi TKP</label>
                  <select name="provinsi_id_kasus" class="form-control select2bs4" id="provinsi_id_kasus" style="width:100%" onchange="getkotkab('kasus')" required>
                      <option value="" selected></option>
                      @foreach ($provinsi as $item) 
                      <option value="{{ $item->code }}" >{{ $item->name }}</option> 
                      @endforeach
                  </select>
              </div>
              <div class="col-md-3">
                  <div>
                      <label>Kota TKP</label>
                      <select name="kota_id_kasus" class="form-control select2bs4" id="kota_id_kasus" style="width: 100%" onchange="getkecamatan('kasus')" required>
                          <option value="" selected></option>
                      </select>
                  </div>
              </div>
              <div class="col-md-3">
                  <div class="form-group">
                      <label>Kecamatan TKP</label>
                      <select name="kecamatan_id_kasus" id="kecamatan_id_kasus" class="form-control select2bs4" style="width: 100%">
                          <option value="" selected></option>
                      </select>
                  </div>
              </div>
              <div class="col-md-3">
                  <div class="form-group">
                      <label>Kelurahan TKP</label>
                      <input type="text" name="kelurahan_kasus" class="form-control titlecase" required>
                  </div>
              </div>
              </div>
          </div>
          <div class="form-group">
          <label>Alamat TKP</label>
          <textarea class="form-control" name="alamat_kasus" required></textarea>
          </div>
          <div class="form-group">
          <label>Deskripsi Kasus</label>
          <textarea class="form-control" name="deskripsi_kasus" required></textarea>
          </div>
      </fieldset>
      
      {{-- <fieldset>
        <legend>E. Surat Pernyataan Persetujuan</legend>
      </fieldset> --}}
        <p>
            <button id="SaveAccount" class="btn btn-primary submit">Submit form</button>
        </p>
    </form>

</div></div>
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
      // Generate Unique ID for new tab Klien
      var newTabId =
        Math.random().toString(36).substring(2, 15) +
        Math.random().toString(36).substring(2, 15);
      console.log(newTabId);

      // Add New Tab Klien
      $("#myTab li.add-tab").before(
        '<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#' +
          newTabId +
          '"><span  id="tab_title_'+ newTabId +'">Nama Klien ' +
          ($("#myTab li:not(.add-tab)").length + 1) +
          '</span> <button type="button" class="close" aria-label="Close" style="margin-left:10px; margin-right:-5px"><span aria-hidden="true">&times;</span></button></a></li>'
      );

      // Add New Tab Content Klien
      $(".tab-content").append(
        '<div id="' + newTabId + '" class="tab-pane fade"></div>'
      );
      konten = "<div class=\"row\" id=\"menu_"+ newTabId +"\"> <div class=\"col-sm-6\"> <div class=\"card\"> <div class=\"card-body\"> <h5 class=\"card-title\">Klien Perempuan Dewasa</h5> <p class=\"card-text\">Klien dengan jenis kelamin perempuan yang usianya 18 tahun keatas.</p> <a href=\"#\" class=\"btn btn-primary\" onclick=\"buatformulir('perempuan', '" + newTabId + "')\">Buat Formulir</a> </div> </div> </div> <div class=\"col-sm-6\"> <div class=\"card\"> <div class=\"card-body\"> <h5 class=\"card-title\">Klien Anak</h5> <p class=\"card-text\">Klien dengan jenis kelamin perempuan / laki-laki yang usianya dibawah 18 tahun.</p> <a href=\"#\" class=\"btn btn-primary\" onclick=\"buatformulir('anak', '" + newTabId + "')\">Buat Formulir</a> </div> </div> </div> </div> <div id=\"formulir_"+ newTabId +"\"></div>";
      $("#"+newTabId).append(konten);

      // Activate New Tab Klien
    });

    // Remove Tab Function Klien
    $(document).on("click", "#myTab .close", function () {
      var tabId = $(this).parent().attr("href");
      $(this).parent().parent().remove(); // remove the tab title
      $(tabId).remove(); // remove the tab content
    });

    // Add Tab Function Terlapor
    no_form_terlapor = 0;
    $("#add-tab-terlapor").click(function () {
      // Generate Unique ID for new tab Terlapor
      var newTabId =
        Math.random().toString(36).substring(2, 15) +
        Math.random().toString(36).substring(2, 15);
      console.log(newTabId);

      // Add New Tab Terlapor
      $("#myTab-terlapor li.add-tab").before(
        '<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#' +
          newTabId +
          '"><span  id="tab_title_'+ newTabId +'">Nama Terlapor ' +
          ($("#myTab-terlapor li:not(.add-tab)").length + 1) +
          '</span> <button type="button" class="close" aria-label="Close" style="margin-left:10px; margin-right:-5px"><span aria-hidden="true">&times;</span></button></a></li>'
      );

      // Add New Tab Content Terlapor
      $(".tab-content-terlapor").append(
        '<div id="' + newTabId + '" class="tab-pane fade"></div>'
      );
      $("#"+newTabId).append("<div class=\"row\"><div class=\"col-md-6\"><div class=\"form-group\"> <label>NIK</label> <input name=\"nik_terlapor[]\" type=\"number\" class=\"form-control titlecase\" id=\"nik_terlapor_"+ newTabId +"\" /> </div></div><div class=\"col-md-6\"><div class=\"form-group\"> <label>Nama Lengkap</label> <input name=\"nama_terlapor[]\" type=\"text\" class=\"form-control titlecase\" id=\"nama_terlapor_"+ newTabId +"\" onkeyup=\"ubahtabtitle2('"+newTabId+"')\" required /> </div></div></div> <div class=\"row\"> <div class=\"col-md-4\"> <div class=\"form-group\"> <label>Tempat Lahir</label> <input name=\"tempat_lahir_terlapor[]\" type=\"text\" class=\"form-control titlecase\" /> </div> </div> <div class=\"col-md-4\"> <div class=\"form-group\"> <label>Tanggal Lahir</label> <input name=\"tanggal_lahir_terlapor[]\" type=\"date\" class=\"form-control\" /> </div> </div> <div class=\"col-md-4\"> <div class=\"form-group\"> <label>Jenis Kelamin</label> <select name=\"jenis_kelamin_terlapor[]\" id=\"jenis_kelamin_"+ newTabId +"\" class=\"form-control select2bs4\" style=\"width:100%\"> <option value=\"perempuan\" selected>Perempuan</option> <option value=\"laki-laki\">Laki-Laki</option> </select> </div> </div> </div> <div class=\"form-group\"> <div class=\"row\"> <div class=\"col-md-3\"> <label>Provinsi Domisili</label> <select name=\"provinsi_id_terlapor[]\" id=\"provinsi_id_terlapor_"+newTabId+"\" class=\"form-control select2bs4\" onchange=\"getkotkab('terlapor_"+ newTabId +"')\" style=\"width:100%\"> <option value=\"\" selected></option> @foreach ($provinsi as $item) <option value=\"{{ $item->code }}\" >{{ $item->name }}</option> @endforeach </select> </div> <div class=\"col-md-3\"> <div class=\"form-group\"> <label>Kota Domisili</label> <select name=\"kota_id_terlapor[]\" id=\"kota_id_terlapor_"+newTabId+"\" class=\"form-control select2bs4\" style=\"width:100%\" onchange=\"getkecamatan('terlapor_"+ newTabId +"')\"> <option value=\"\" selected></option> </select> </div> </div> <div class=\"col-md-3\"> <div class=\"form-group\"> <label>Kecamatan Domisili</label> <select name=\"kecamatan_id_terlapor[]\" id=\"kecamatan_id_terlapor_"+newTabId+"\" class=\"form-control select2bs4\" style=\"width:100%\"> <option value=\"\" selected></option> </select> </div> </div> <div class=\"col-md-3\"> <div class=\"form-group\"> <label>Kelurahan Domisili</label> <input type=\"text\" name=\"kelurahan_terlapor[]\" class=\"form-control titlecase\"> </div> </div> </div> </div> <div class=\"form-group\"> <label>Alamat Domisili</label> <textarea name=\"alamat_terlapor[]\" class=\"form-control\" id=\"alamat_terlapor_"+ newTabId +"\"></textarea> </div> <div class=\"form-group\"> <label>No Telp</label> <input name=\"no_telp_terlapor[]\" id=\"no_telp_terlapor_"+ newTabId +"\" type=\"number\" class=\"form-control\"/> </div> <div class=\"row\"> <div class=\"col-md-6\"> <div class=\"form-group\"> <label>Status Pendidikan</label> <select name=\"status_pendidikan_terlapor[]\" id=\"status_pendidikan_terlapor_"+ newTabId +"\" class=\"form-control select2bs4\" style=\"width:100%\"> <option value=\"\"></option> @foreach ($status_pendidikan as $item) <option value=\"{{ $item }}\" >{{ $item }}</option> @endforeach </select> </div> </div> <div class=\"col-md-6\"> <div class=\"form-group\"> <label>Pendidikan terakhir</label> <select name=\"pendidikan_terlapor[]\" id=\"pendidikan_terlapor_"+ newTabId +"\" class=\"form-control select2bs4\" style=\"width:100%\"> <option value=\"\" selected></option> @foreach ($pendidikan_terakhir as $item) <option value=\"{{ $item }}\" >{{ $item }}</option> @endforeach </select> </div> </div> </div> <div class=\"row\"><div class=\"col-md-6\"><div class=\"form-group\"> <label>Agama</label> <select name=\"agama_terlapor[]\" id=\"agama_terlapor_"+ newTabId +"\" class=\"form-control select2bs4\" style=\"width:100%\"> <option value=\"\" selected></option> @foreach ($agama as $item) <option value=\"{{ $item }}\" >{{ $item }}</option> @endforeach </select> </div></div> <div class=\"col-md-6\"><div class=\"form-group\"> <label>Suku</label> <select name=\"suku_terlapor[]\" id=\"suku_terlapor_"+ newTabId +"\" class=\"form-control select2bs4\" style=\"width:100%\"> <option value=\"\" selected></option>  @foreach ($suku as $item) <option value=\"{{ $item }}\" >{{ $item }}</option> @endforeach </select> </div></div></div> <div class=\"row\"><div class=\"col-md-6\"><div class=\"form-group\"> <label>Pekerjaan</label> <select name=\"pekerjaan_telapor[]\" id=\"pekerjaan_terlapor_"+ newTabId +"\" class=\"form-control select2bs4\" style=\"width:100%\"> <option value=\"\" selected></option>  @foreach ($pekerjaan as $item) <option value=\"{{ $item }}\" >{{ $item }}</option> @endforeach</select> </div></div> <div class=\"col-md-6\"> <div class=\"form-group\"> <label>Penghasilan per Bulan</label> <input name=\"penghasilan_terlapor[]\" id=\"penghasilan_terlapor_"+ newTabId +"\" type=\"number\" class=\"form-control\" /> </div></div> </div>  <div class=\"row\"> <div class=\"col-md-6\"><div class=\"form-group\"> <label>Status Perkawinan</label> <select name=\"perkawinan_terlapor[]\" id=\"perkawinan_terlapor_"+ newTabId +"\" class=\"form-control select2bs4\" style=\"width:100%\"> <option value=\"\" selected></option> @foreach ($status_perkawinan as $item) <option value=\"{{ $item }}\" >{{ $item }}</option> @endforeach </select> </div></div> <div class=\"col-md-6\"> <div class=\"form-group\"> <label>Jumlah Anak</label> <input name=\"jumlah_anak_terlapor[]\" id=\"jumlah_anak_terlapor_"+ newTabId +"\" type=\"number\" class=\"form-control\" /> </div></div></div> <div class=\"form-group\"> <label>Hubungan Dengan Klien (Terlapor siapanya Klien?)</label> <select name=\"hubungan_terlapor[]\" id=\"hubungan_klien_"+ newTabId +"\" class=\"form-control select2bs4\" style=\"width:100%\"> <option value=\"\" selected></option> @foreach ($hubungan_dengan_klien as $item) <option value=\"{{ $item }}\" >{{ $item }}</option> @endforeach  </select> </div>");
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
  });


  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36251023-1']);
  _gaq.push(['_setDomainName', 'jqueryscript.net']);
  _gaq.push(['_trackPageview']);
  
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
  
  function buatformulir(jenis_klien, newTabId) {
    let no_form_klien = ($("#myTab li:not(.add-tab)").length - 1);

    $('#menu_'+newTabId).hide();
    if (jenis_klien == "perempuan") { //formulir klien perempuan anak
      $('#formulir_'+newTabId).append("<h3> <center>Formulir Klien Perempuan Dewasa</center> </h3> <div class=\"row\"> <div class=\"col-md-6\"> <div class=\"form-group\"> <label>NIK</label> <input name=\"nik_klien[]\" id=\"nik_klien_"+ newTabId +"\" type=\"number\" class=\"form-control\"/> </div> </div> <div class=\"col-md-6\"> <div class=\"form-group\"> <label>Nama Lengkap</label> <input name=\"nama_klien[]\" id=\"nama_klien_"+ newTabId +"\" type=\"text\" class=\"form-control titlecase\" onkeyup=\"ubahtabtitle('"+newTabId+"')\" required /> </div> </div> </div> <div class=\"row\"> <div class=\"col-md-4\"> <div class=\"form-group\"> <label>Tempat Lahir</label> <input name=\"tempat_lahir_klien[]\" id=\"tempat_lahir_klien\" type=\"text\" class=\"form-control titlecase\" required/> </div> </div> <div class=\"col-md-4\"> <div class=\"form-group\"> <label>Tanggal Lahir</label> <input name=\"tanggal_lahir_klien[]\" id=\"tanggal_lahir_klien\" type=\"date\" class=\"form-control\" required/> </div> </div> <div class=\"col-md-4\"> <div class=\"form-group\"> <label>Jenis Kelamin</label> <select name=\"jenis_kelamin_klien[]\" id=\"jenis_kelamin_"+ newTabId +"\" class=\"form-control select2bs4\" style=\"width:100%\"> <option value=\"perempuan\" selected>Perempuan</option> <option value=\"perempuan\">Perempuan</option> </select> </div> </div> </div> <div class=\"form-group\"> <div class=\"row\"> <div class=\"col-md-3\"> <label>Provinsi KTP</label> <select name=\"provinsi_id_klien[]\" id=\"provinsi_id_klien_"+newTabId+"\" class=\"form-control select2bs4\" onchange=\"getkotkab('klien_"+ newTabId +"')\" style=\"width:100%\" required> <option value=\"\" selected></option> @foreach ($provinsi as $item) <option value=\"{{ $item->code }}\" >{{ $item->name }}</option> @endforeach </select> </div> <div class=\"col-md-3\"> <div class=\"form-group\"> <label>Kota KTP</label> <select name=\"kota_id_klien[]\" id=\"kota_id_klien_"+newTabId+"\" class=\"form-control select2bs4\" style=\"width:100%\" onchange=\"getkecamatan('klien_"+ newTabId +"')\" required> <option value=\"\" selected></option> </select> </div> </div> <div class=\"col-md-3\"> <div class=\"form-group\"> <label>Kecamatan KTP</label> <select name=\"kecamatan_id_klien[]\" id=\"kecamatan_id_klien_"+newTabId+"\" class=\"form-control select2bs4\" style=\"width:100%\" required> <option value=\"\" selected></option> </select> </div> </div> <div class=\"col-md-3\"> <div class=\"form-group\"> <label>Kelurahan KTP</label> <input type=\"text\" name=\"kelurahan_klien[]\" class=\"form-control titlecase\" required> </div> </div> </div> </div> <div class=\"form-group\"> <label>Alamat KTP</label> <textarea name=\"alamat_klien[]\" class=\"form-control\" id=\"alamat_klien_"+newTabId+"\" required></textarea> </div> <div class=\"form-group\"> <label>No Telp</label> <input name=\"no_telp_klien[]\" id=\"no_telp_klien_"+newTabId+"\" type=\"number\" class=\"form-control\"/> </div> <div class=\"row\"> <div class=\"col-md-6\"><div class=\"form-group\"> <label>Status Pendidikan</label> <select name=\"status_pendidikan_klien[]\" id=\"status_pendidikan_klien_"+newTabId+"\" class=\"form-control select2bs4\" style=\"width:100%\" required> <option value=\"\" selected></option> @foreach ($status_pendidikan as $item) <option value=\"{{ $item }}\" >{{ $item }}</option> @endforeach </select> </div></div> <div class=\"col-md-6\"><div class=\"form-group\"> <label>Pendidikan terakhir</label> <select name=\"pendidikan_klien[]\" id=\"pendidikan_klien_"+newTabId+"\" class=\"form-control select2bs4\" style=\"width:100%\" required> <option value=\"\" selected></option> @foreach ($pendidikan_terakhir as $item) <option value=\"{{ $item }}\" >{{ $item }}</option> @endforeach </select> </div></div> </div> <div class=\"row\"> <div class=\"col-md-6\"><div class=\"form-group\"> <label>Agama</label> <select name=\"agama_klien[]\" id=\"agama_klien_"+newTabId+"\" class=\"form-control select2bs4\" style=\"width:100%\"> <option value=\"\" selected></option> @foreach ($agama as $item) <option value=\"{{ $item }}\" >{{ $item }}</option> @endforeach </select> </div></div> <div class=\"col-md-6\"><div class=\"form-group\"> <label>Suku</label> <select name=\"suku_klien[]\" id=\"suku_klien_"+newTabId+"\" class=\"form-control select2bs4\" style=\"width:100%\"> <option value=\"\" selected></option>  @foreach ($suku as $item) <option value=\"{{ $item }}\" >{{ $item }}</option> @endforeach </select> </div></div> </div> <div class=\"row\"> <div class=\"col-md-6\"><div class=\"form-group\"> <label>Pekerjaan</label> <select name=\"pekerjaan_klien[]\" id=\"pekerjaan_klien_"+newTabId+"\" class=\"form-control select2bs4\" style=\"width:100%\"> <option value=\"\" selected></option>  @foreach ($pekerjaan as $item) <option value=\"{{ $item }}\" >{{ $item }}</option> @endforeach </select> </div></div> <div class=\"col-md-6\"> <div class=\"form-group\"> <label>Penghasilan per Bulan</label> <input name=\"penghasilan_klien[]\" id=\"penghasilan_klien\" type=\"number\" class=\"form-control\" /> </div> </div> </div> <div class=\"row\"> <div class=\"col-md-6\"><div class=\"form-group\"> <label>Status Perkawinan</label> <select name=\"perkawinan_klien[]\" id=\"perkawinan_klien_"+newTabId+"\" class=\"form-control select2bs4\" style=\"width:100%\"> <option value=\"\" ></option> @foreach ($status_perkawinan as $item) <option value=\"{{ $item }}\" >{{ $item }}</option> @endforeach</select> </div></div> <div class=\"col-md-6\"> <div class=\"form-group\"> <label>Jumlah Anak</label> <input name=\"jumlah_anak_klien[]\" id=\"jumlah_anak_klien_"+newTabId+"\" type=\"number\" class=\"form-control\" /> </div> </div> </div> <div class=\"form-group\"> <label>Hubungan Dengan Terlapor (Klien siapanya Terlapor?)</label> <select name=\"hubungan_klien[]\" id=\"hubungan_klien_"+newTabId+"\" class=\"form-control select2bs4\" style=\"width:100%\" required> <option value=\"\" selected></option>  @foreach ($hubungan_dengan_terlapor as $item) <option value=\"{{ $item }}\" >{{ $item }}</option> @endforeach </select> </div> <div class=\"row\"> <div class=\"col-md-4\"><div class=\"form-group\"> <label>Kondisi Khusus</label> <select name=\"kondisi_khusus_klien["+no_form_klien+"][]\" id=\"kondisi_khusus_klien_"+newTabId+"\" class=\"form-control select2bs4\" style=\"width:100%\" multiple=\"multiple\"> @foreach ($kekhususan as $item) <option value=\"{{ $item }}\" >{{ $item }}</option> @endforeach </select> </div></div> <div class=\"col-md-4\"><div class=\"form-group\"> <label>Difabel Type</label> <select name=\"difabel_type["+no_form_klien+"][]\" id=\"difabel_type_"+newTabId+"\" class=\"form-control select2bs4\" style=\"width:100%\" multiple=\"multiple\"> @foreach ($difabel_type as $item) <option value=\"{{ $item }}\" >{{ $item }}</option> @endforeach</select> </div></div> <div class=\"col-md-4\"><div class=\"form-group\"> <label>Program Pemerintah Yang Aktif</label> <select name=\"program_pemerintah["+no_form_klien+"][]\" id=\"program_pemerintah_"+newTabId+"\" class=\"form-control select2bs4\" style=\"width:100%\" multiple=\"multiple\"> @foreach ($program_pemerintah as $item) <option value=\"{{ $item }}\" >{{ $item }}</option> @endforeach</select> </div></div> </div> <div class=\"row\"> <div class=\"col-md-6\"> <div class=\"form-group\"> <label>Kategori Kasus</label> <select name=\"kategori_kasus["+no_form_klien+"][]\" id=\"kategori_kasus_"+newTabId+"\" class=\"form-control select2bs4\" multiple=\"multiple\" required> <option></option> @foreach ($kategori_kasus as $item) <option value=\"{{ $item }}\" >{{ $item }}</option> @endforeach</select> </div> </div> <div class=\"col-md-6\"> <div class=\"form-group\"> <label>Tindak Kekerasan</label> <select name=\"tindak_kekerasan["+no_form_klien+"][]\" id=\"tindak_kekerasan_"+newTabId+"\" class=\"form-control select2bs4\" multiple=\"multiple\" required> <option></option> @foreach ($tindak_kekerasan as $item) <option value=\"{{ $item }}\" >{{ $item }}</option> @endforeach</select> </div> </div> </div> <div class=\"row\"> <div class=\"col-md-3\"> <div class=\"form-group\"> <label>No. LP</label> <input name=\"no_lp[]\" id=\"no_lp_"+ newTabId +"\" type=\"text\" class=\"form-control\" /> </div> </div> <div class=\"col-md-3\"> <div class=\"form-group\"> <label>Pasal</label> <select name=\"pasal["+no_form_klien+"][]\" id=\"pasal_"+newTabId+"\" class=\"form-control select2bs4\"  multiple=\"multiple\"> @foreach ($pasal as $item) <option value=\"{{ $item }}\" >{{ $item }}</option> @endforeach</select> </div> </div> <div class=\"col-md-3\"> <label>Pengadilan Negri</label> <select name=\"pengadilan_negri[]\" id=\"pengadilan_negri_"+newTabId+"\" class=\"form-control select2bs4\"> <option value=\"\" selected></option> @foreach ($pengadilan_negri as $item) <option value=\"{{ $item }}\" >{{ $item }}</option> @endforeach</select> </div> <div class=\"col-md-3\"> <label>Klien LPSK?</label> <select name=\"lpsk_klien[]\" id=\"lpsk_"+newTabId+"\" class=\"form-control select2bs4\"> <option value=\"0\" selected>Tidak</option> <option value=\"1\">Ya</option> </select> </div> </div> </div> <div class=\"form-group\"> <label>Isi Putusan</label> <textarea name=\"isi_putusan[]\" class=\"form-control\" id=\"isi_putusan_"+ newTabId +"\"></textarea> </div>");
    }else{ //formulir klien anak
      $('#formulir_'+newTabId).append("<h3><center>Formulir Klien Anak</center></h3> <div class=\"row\"> <div class=\"col-md-6\"> <div class=\"form-group\"> <label>NIK</label> <input name=\"nik_klien[]\" id=\"nik_klien_"+ newTabId +"\" type=\"number\" class=\"form-control\"/> </div> </div> <div class=\"col-md-6\"> <div class=\"form-group\"> <label>Nama Lengkap</label> <input name=\"nama_klien[]\" id=\"nama_klien_"+ newTabId +"\" type=\"text\" class=\"form-control titlecase\" onkeyup=\"ubahtabtitle('"+newTabId+"')\" required /> </div> </div> </div> <div class=\"row\"> <div class=\"col-md-4\"> <div class=\"form-group\"> <label>Tempat Lahir</label> <input name=\"tempat_lahir_klien[]\" id=\"tempat_lahir_klien\" type=\"text\" class=\"form-control titlecase\" required/> </div> </div> <div class=\"col-md-4\"> <div class=\"form-group\"> <label>Tanggal Lahir</label> <input name=\"tanggal_lahir_klien[]\" id=\"tanggal_lahir_klien\" type=\"date\" class=\"form-control\" required/> </div> </div> <div class=\"col-md-4\"> <div class=\"form-group\"> <label>Jenis Kelamin</label> <select name=\"jenis_kelamin_klien[]\" id=\"jenis_kelamin_"+ newTabId +"\" class=\"form-control select2bs4\" style=\"width:100%\"> <option value=\"perempuan\" selected>Perempuan</option> <option value=\"laki-laki\">Laki-Laki</option> </select> </div> </div></div> <div class=\"form-group\"> <div class=\"row\"> <div class=\"col-md-3\"> <label>Provinsi Domisili</label> <select name=\"provinsi_id_klien[]\" id=\"provinsi_id_klien_"+newTabId+"\"\" class=\"form-control select2bs4\" style=\"width:100%\" onchange=\"getkotkab('klien_"+ newTabId +"')\" required> <option value=\"\" selected></option> @foreach ($provinsi as $item) <option value=\"{{ $item->code }}\" >{{ $item->name }}</option> @endforeach </select> </div> <div class=\"col-md-3\"> <div class=\"form-group\"> <label>Kota Domisili</label> <select name=\"kota_id_klien[]\" id=\"kota_id_klien_"+newTabId+"\"\" class=\"form-control select2bs4\" style=\"width:100%\" onchange=\"getkecamatan('klien_"+ newTabId +"')\" required> <option value=\"\" selected></option> </select> </div> </div> <div class=\"col-md-3\"> <div class=\"form-group\"> <label>Kecamatan Domisili</label> <select name=\"kecamatan_id_klien[]\" id=\"kecamatan_id_klien_"+newTabId+"\" class=\"form-control select2bs4\" style=\"width:100%\" required> <option value=\"\" selected></option> </select> </div> </div> <div class=\"col-md-3\"> <div class=\"form-group\"> <label>Kelurahan Domisili</label> <input type=\"text\" name=\"kelurahan_klien[]\" class=\"form-control titlecase\" required> </div> </div> </div> </div> <div class=\"form-group\"> <label>Alamat Domisili</label> <textarea name=\"alamat_klien[]\" class=\"form-control\" id=\"alamat_klien\" required></textarea> </div> <div class=\"form-group\"> <label>No Telp</label> <input name=\"no_telp_klien[]\" id=\"no_telp_klien\" type=\"number\" class=\"form-control\"/> </div> <div class=\"row\"> <div class=\"col-md-4\"><div class=\"form-group\"> <label>Status Pendidikan</label> <select name=\"status_pendidikan_klien[]\" id=\"status_pendidikan_klien\" class=\"form-control select2bs4\" style=\"width:100%\" required> <option value=\"\" selected></option> @foreach ($status_pendidikan as $item) <option value=\"{{ $item }}\" >{{ $item }}</option> @endforeach </select> </div> </div> <div class=\"col-md-4\"><div class=\"form-group\"> <label>Pendidikan terakhir</label> <select name=\"pendidikan_klien[]\" id=\"pendidikan_klien\" class=\"form-control select2bs4\" style=\"width:100%\" required> <option value=\"\" selected></option> @foreach ($pendidikan_terakhir as $item) <option value=\"{{ $item }}\" >{{ $item }}</option> @endforeach </select> </div></div> <div class=\"col-md-4\"><div class=\"form-group\"> <label>Kelas</label> <select name=\"kelas[]\" id=\"kelas\" class=\"form-control select2bs4\" style=\"width:100%\"> <option value=\"\" selected></option> @foreach ($kelas as $item) <option value=\"{{ $item }}\" >{{ $item }}</option> @endforeach </select> </div> </div> </div> <div class=\"row\"> <div class=\"col-md-6\"><div class=\"form-group\"> <label>Agama</label> <select name=\"agama_klien[]\" id=\"agama_klien\" class=\"form-control select2bs4\" style=\"width:100%\"> <option value=\"\" selected></option> @foreach ($agama as $item) <option value=\"{{ $item }}\" >{{ $item }}</option> @endforeach </select> </div></div> <div class=\"col-md-6\"><div class=\"form-group\"> <label>Suku</label> <select name=\"suku_klien[]\" id=\"suku_klien\" class=\"form-control select2bs4\" style=\"width:100%\"> <option value=\"\" selected></option> @foreach ($suku as $item) <option value=\"{{ $item }}\" >{{ $item }}</option> @endforeach </select> </div></div></div> <div class=\"row\"> <div class=\"col-md-4\"> <div class=\"form-group\"> <label>Nama Ibu</label> <input name=\"nama_ibu[]\" id=\"nama_ibu_"+ newTabId +"\" type=\"text\" class=\"form-control titlecase\"/> </div> </div> <div class=\"col-md-4\"> <div class=\"form-group\"> <label>Tempat Lahir Ibu</label> <input name=\"tempat_lahir_ibu[]\" id=\"tempat_lahir_ibu_"+ newTabId +"\" type=\"text\" class=\"form-control titlecase\" /> </div> </div> <div class=\"col-md-4\"> <div class=\"form-group\"> <label>Tanggal Lahir Ibu</label> <input name=\"tanggal_lahir_ibu[]\" id=\"tanggal_lahir_ibu_"+ newTabId +"\" type=\"date\" class=\"form-control titlecase\" /> </div> </div> </div> <div class=\"row\"> <div class=\"col-md-4\"> <div class=\"form-group\"> <label>Nama Ayah</label> <input name=\"nama_ayah[]\" id=\"nama_ayah_"+ newTabId +"\" type=\"text\" class=\"form-control titlecase\"/> </div> </div> <div class=\"col-md-4\"> <div class=\"form-group\"> <label>Tempat Lahir Ayah</label> <input name=\"tempat_lahir_ayah[]\" id=\"tempat_lahir_ayah_"+ newTabId +"\" type=\"text\" class=\"form-control titlecase\" /> </div> </div> <div class=\"col-md-4\"> <div class=\"form-group\"> <label>Tanggal Lahir Ayah</label> <input name=\"tanggal_lahir_ayah[]\" id=\"tanggal_lahir_ayah_"+ newTabId +"\" type=\"date\" class=\"form-control titlecase\" /> </div> </div> </div> <div class=\"row\"> <div class=\"col-md-6\"> <div class=\"form-group\"> <label>Anak Ke</label> <input name=\"anak_ke[]\" id=\"anak_ke_"+ newTabId +"\" type=\"number\" class=\"form-control\"/> </div> </div> <div class=\"col-md-6\"> <div class=\"form-group\"> <label>Jumlah Saudara</label> <input name=\"jumlah_anak_klien[]\" id=\"jumlah_anak_klien_"+ newTabId +"\" type=\"number\" class=\"form-control\" /> </div> </div> </div> <div class=\"form-group\"> <label>Hubungan Dengan Terlapor (Klien siapanya Terlapor?)</label> <select name=\"hubungan_klien[]\" id=\"hubungan_klien\" class=\"form-control select2bs4\" style=\"width:100%\" required> <option value=\"\" selected></option> @foreach ($hubungan_dengan_terlapor as $item) <option value=\"{{ $item }}\" >{{ $item }}</option> @endforeach </select> </div>  <div class=\"row\"> <div class=\"col-md-4\"><div class=\"form-group\"> <label>Kondisi Khusus</label> <select name=\"kondisi_khusus_klien["+no_form_klien+"][]\" id=\"kondisi_khusus_klien_"+newTabId+"\" class=\"form-control select2bs4\" style=\"width:100%\" multiple=\"multiple\"> @foreach ($kekhususan as $item) <option value=\"{{ $item }}\" >{{ $item }}</option> @endforeach </select> </div></div> <div class=\"col-md-4\"><div class=\"form-group\"> <label>Difabel Type</label> <select name=\"difabel_type["+no_form_klien+"][]\" id=\"difabel_type_"+newTabId+"\" class=\"form-control select2bs4\" style=\"width:100%\" multiple=\"multiple\"> @foreach ($difabel_type as $item) <option value=\"{{ $item }}\" >{{ $item }}</option> @endforeach</select> </div></div> <div class=\"col-md-4\"><div class=\"form-group\"> <label>Program Pemerintah Yang Aktif</label> <select name=\"program_pemerintah["+no_form_klien+"][]\" id=\"program_pemerintah_"+newTabId+"\" class=\"form-control select2bs4\" style=\"width:100%\" multiple=\"multiple\"> @foreach ($program_pemerintah as $item) <option value=\"{{ $item }}\" >{{ $item }}</option> @endforeach</select> </div></div> </div> <div class=\"row\"> <div class=\"col-md-6\"> <div class=\"form-group\"> <label>Kategori Kasus</label> <select name=\"kategori_kasus["+no_form_klien+"][]\" id=\"kategori_kasus_"+newTabId+"\" class=\"form-control select2bs4\" multiple=\"multiple\" required> @foreach ($kategori_kasus as $item) <option value=\"{{ $item }}\" >{{ $item }}</option> @endforeach</select> </div> </div> <div class=\"col-md-6\"> <div class=\"form-group\"> <label>Tindak Kekerasan</label> <select name=\"tindak_kekerasan["+no_form_klien+"][]\" id=\"tindak_kekerasan_"+newTabId+"\" class=\"form-control select2bs4\" multiple=\"multiple\" required> @foreach ($tindak_kekerasan as $item) <option value=\"{{ $item }}\" >{{ $item }}</option> @endforeach</select> </div> </div> </div> <div class=\"row\"> <div class=\"col-md-3\"> <div class=\"form-group\"> <label>No. LP</label> <input name=\"no_lp[]\" id=\"no_lp_"+ newTabId +"\" type=\"text\" class=\"form-control\" /> </div> </div> <div class=\"col-md-3\"> <div class=\"form-group\"> <label>Pasal</label> <select name=\"pasal["+no_form_klien+"][]\" id=\"pasal_"+newTabId+"\" class=\"form-control select2bs4\" multiple=\"multiple\"> @foreach ($pasal as $item) <option value=\"{{ $item }}\" >{{ $item }}</option> @endforeach</select> </div> </div> <div class=\"col-md-3\"> <label>Pengadilan Negri</label> <select name=\"pengadilan_negri[]\" id=\"pengadilan_negri_"+newTabId+"\" class=\"form-control select2bs4\"> <option value=\"\" selected></option> @foreach ($pengadilan_negri as $item) <option value=\"{{ $item }}\" >{{ $item }}</option> @endforeach</select> </div> <div class=\"col-md-3\"> <label>Klien LPSK?</label> <select name=\"lpsk_klien[]\" id=\"lpsk_"+newTabId+"\" class=\"form-control select2bs4\"> <option value=\"0\" selected>Tidak</option> <option value=\"1\">Ya</option> </select> </div> </div> </div> <div class=\"form-group\"> <label>Isi Putusan</label> <textarea name=\"isi_putusan[]\" class=\"form-control\" id=\"isi_putusan_"+ newTabId +"\"></textarea> </div>");
    }

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
      });
    $('.select-tag').select2({
      tags: true,
      theme: 'bootstrap4'
    });

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
  }

  function ubahtabtitle(newTabId) {
    tab_title = $('#nama_klien_'+newTabId).val();
    $('#tab_title_'+newTabId).html(tab_title);
  }

  function ubahtabtitle2(newTabId) {
    tab_title = $('#nama_terlapor_'+newTabId).val();
    $('#tab_title_'+newTabId).html(tab_title);
  }

  function getkotkab(field_id='') {
        province_code = $('#provinsi_id_'+field_id).val();
        
        $.ajax({
          url:'{{ route("api.v1.kotkab") }}?province_code='+province_code,
          type:'GET',
          dataType: 'json',
          success: function( response ) {
                var option = '<option value="">-- Pilih Kotkab --</option>';
                var kotkabID = ''
                $.each(response.data, function(i, value) {
                    var selected = ''
                    if (kotkabID == value.code) {
                        selected = `selected="selected"`
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
                var kecamatanID = ''
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

    $(document).ready(function () {
      //Initialize Select2 Elements
      $('.select2bs4').select2({
        theme: 'bootstrap4'
        });
        $('.select-tag').select2({
        tags: true,
        theme: 'bootstrap4'
      });
    });
</script>
</body>
</html>