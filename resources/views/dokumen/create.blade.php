@extends('layouts.template')

@section('content')
<style type="text/css">
    .scroll-area {
        height: 800px;
        overflow-y: scroll;
    }

    .scroll-area::-webkit-scrollbar {
        width: 8px;
        background-color: #F5F5F5;
    }

    .scroll-area::-webkit-scrollbar-thumb {
        background-color: #555;
    }

    .editor {
        color: black;
    }

    #wzform fieldset:not(:first-of-type) {
        display: none
    }

    *[contenteditable="true"] {
        background-color: rgba(123, 211, 242, 0.5);
    }

    @media screen {
        @font-face {
            font-family: 'Cambria::Menu';
            font-style: normal;
            font-weight: normal;
            src: local('Cambria'), url('https://themes.googleusercontent.com/font?kit=FuCXqyJXTEEvujaBqOffUw') format('woff');
        }
    }
</style>
<link rel="stylesheet" href="{{ asset('adminlte') }}/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="{{ asset('adminlte') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="{{ asset('source') }}/css/ckeditor.css">
<!-- daterange picker -->

<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
    <div class="col-sm-6">
    <h1><i class="nav-icon fas fa-file-alt"></i> Buat Dokumen</h1>
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

<div class="col-md-12">
    <!-- general form elements -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Buat Dokumen > <span class='titleFormOutput' id='titleFormOutput'></span></h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                </button>
            </div>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form method="POST" action="{{ route('dokumen.store') }}" role="form" id="wzform">
            @csrf
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('response') }}. <a href="{{ route('dokumen') }}">Lihat data</a>
            </div>
            @endif
            @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <b>GAGAL ! </b>
                <br>
                {{ session('response') }}
            </div>
            @endif
            <input type="text" name="uuid" class="form-control" value="{{ $template->uuid }}" hidden>
            <div class="card-body">
                <fieldset>
                    <script>
                        var span = document.getElementById("coba");
                        var tampil = document.getElementById("tampil");

                        function gfg_Run() {
                            tampil.innerHTML = span.textContent;
                        }
                    </script>
                    <div class="form-group">
                        <label>Detail Template</label>
                        <div class="col-md-12" style="background-color:aliceblue; padding:10px">
                            <table>
                                <tr>
                                    <td>
                                        Nama Template
                                    </td>
                                    <td>
                                        : {{ $template->nama_template }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Detail Layanan / Keyword
                                    </td>
                                    <td>
                                        : {{ $template->keyword }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Kepemilikan Template
                                    </td>
                                    <td>
                                        : {{ $template->pemilik }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Created by
                                    </td>
                                    <td>
                                        : {{ $template->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Created at
                                    </td>
                                    <td>
                                        : {{ $template->created_at }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Modified at
                                    </td>
                                    <td>
                                        : {{ $template->updated_at }}
                                    </td>
                                </tr>
                            </table>  
                        </div>
                    </div>
                    <div class="form-card">
                        <div class="form-group">
                            <label>Judul Dokumen</label>
                            <input type="text" name="judul" class="form-control" id="titleForm" value="">
                        </div>
                        <div class="form-card">
                            <label>Agenda Terkait </label>
                            <span style="font-size:13px">(Belum membuat agenda? <a href="#" type="button" data-toggle="modal" data-target="#ajaxModal">klik disini</a>)</span>
                            <select name="uuid_tindak_lanjut" class="form-control select2bs4" id="uuid_tindak_lanjut" style="width:100%">
                                <option value="" selected>Tidak ada agenda terkait yang dipilih</option>
                                @foreach ($agenda as $item)
                                    <option value="{{ $item->uuid_tindak_lanjut }}" >[ {{ $item->tanggal_mulai ? date('d M Y', strtotime($item->tanggal_mulai)) : '' }} | {{ $item->jam_mulai }} ] {{ $item->judul_kegiatan }}</option>
                                @endforeach
                            </select>
                        </div>
                        </br>
                        <div id="tindak_lanjut" style="display: none">
                            <div class="form-group">
                                <label>Detail Agenda</label>
                            <span style="font-size:13px">(<a href="">edit agenda</a>)</span>
                            <div class="col-md-12" style="background-color:aliceblue; padding:10px">
                                    <table>
                                        <tr>
                                            <td>
                                                Judul Agenda
                                            </td>
                                            <td> : </td>
                                            <td id="judul_kegiatan"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Tanggal Mulai
                                            </td>
                                            <td> : </td>
                                            <td id="tanggal_mulai"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Jam Mulai
                                            </td>
                                            <td> : </td>
                                            <td id="jam_mulai"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Keterangan
                                            </td>
                                            <td> : </td>
                                            <td id="keterangan"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Nama Klien
                                            </td>
                                            <td> : </td>
                                            <td id="nama"></td>
                                        </tr>
                                    </table>  
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Lokasi Kegiatan</label>
                                        <input type="text" name="lokasi" class="form-control" id="lokasi">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Jam selesai</label>
                                        <?php
                                        date_default_timezone_set("asia/jakarta");
                                        $jam_selesai = date("h:i");
                                        ?>
                                        <input type="time" name="jam_selesai" class="form-control" id="jam_selesai" value="{{ $jam_selesai }}">
                                    </div>
                                </div>
                            </div>
                          <div class="form-group">
                              <label>Catatan</label>
                              <textarea name="catatan" class="form-control" id="catatan" cols="30" rows="2"></textarea>
                          </div>
                          <span style="font-size: 14px">*Laporan Tindak Lanjut tersimpan pada tanggal : <span id='ct' ></span></span>
                        </br>
                        </br>
                        </div>
                    </div>

                    <input type="button" name="next" class="next action-button btn btn-primary" value="Selanjutnya" id="next1" disabled />
                </fieldset>
                <fieldset>
                    <div class="form-card">
                        <div class="form-group">

                            <body data-editor="DecoupledDocumentEditor" data-collaboration="false">
                                <main>
                                    <div class="centered">
                                        <div class="scroll-area">
                                            <div class="row-editor">
                                                <div class="form-control editor" id="preview">
                                                    <?php
                                                    $konten = json_decode($template->konten);
                                                    preg_match_all('/{{(.*?)}}/', $konten, $variable);

                                                    $a = array_unique($variable[0]);
                                                    foreach ($a as $item) {
                                                        $b = preg_replace('/{{(.*?)}}/is', "$1", $item);
                                                        if (strtolower(substr($b, 0, 9)) == 'loop_list') {
                                                            $konten = str_ireplace($item, '<span class="input-list input-' . $b . '" name="' . $b . '">' . $item . '</span>', $konten);
                                                        } else {
                                                            $konten = str_ireplace($item, '<span class="input-variable input-' . $b . '" name="' . $b . '" contentEditable="true">' . $item . '</span>', $konten);
                                                        }

                                                        $id_table = rand();
                                                        $konten = str_replace('<table class="editablecontent"', '<a href="#" onclick="addRow(' . $id_table . ')">[add row]</a><a href="#" onclick="deleteRow(' . $id_table . ')">[delete row]</a><table contenteditable="true" id="' . $id_table . '"', $konten);
                                                    }
                                                    echo $konten;
                                                    ?>
                                                </div>
                                                <textarea name="konten" id="konten" readonly hidden></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </main>
                            </body>
                        </div>
                    </div>
                    <input type="button" class="previous action-button-previous btn btn-primary" value="Kembali" />
                    <input type="button" class="next action-button btn btn-primary" value="Priview" id="next2" />
                </fieldset>
                <fieldset>
                    <div class="form-card">
                        <div class="form-group">

                            <body data-editor="DecoupledDocumentEditor" data-collaboration="false">
                                <main>
                                    <div class="centered">
                                        <div class="scroll-area">
                                            <div class="row-editor">
                                                <div class="form-control editor">
                                                    <?php
                                                    //replace contenteditable dan tombol tabel
                                                    $konten = str_replace('[add row]', '', $konten);
                                                    $konten = str_replace('[delete row]', '', $konten);
                                                    //hilangkan semua variable
                                                    $konten = preg_replace('/{{(.*?)}}/', '', $konten); ?>
                                                    <div id="last-priview"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </main>
                            </body>
                        </div>
                        <span id="msgbox"></span>
                    </div>
                    <input type="button" name="previous" class="previous action-button-previous btn btn-primary" value="Kembali" />
                    <input type="submit" class="btn btn-success" id="submit" value="Simpan" />
                </fieldset>
            </div>
            <!-- /.card-body -->
        </form>
    </div>
    <!-- /.card -->
</div>

<!-- Modal -->
<div class="modal fade" id="ajaxModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
  
        <div id="overlay" class="overlay dark">
          <div class="cv-spinner">
            <span class="spinner"></span>
          </div>
        </div>
        
        <div class="modal-header">
          <h5 class="modal-title" id="modelHeading">Tambah Agenda</h5>
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
            <input type="text" class="form-control required-field" id="judul_kegiatan_add">
            <div class="invalid-feedback" id="valid-judul_kegiatan">
              Judul Kegiatan wajib diisi.
            </div>
        </div>
        <div class="row">
          <div class="col-md-6">
              <div class="form-group">
                <label><span class="text-danger">*</span>Tanggal</label>
                <input type="date" class="form-control required-field" id="tanggal_mulai_add">
                <div class="invalid-feedback" id="valid-tanggal_mulai">
                  Tanggal Mulai wajib diisi.
                </div>
            </div>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                  <label><span class="text-danger">*</span>Jam mulai</label>
                  <input type="time" class="form-control required-field" id="jam_mulai_add">
                  <div class="invalid-feedback" id="valid-jam_mulai">
                    Jam Mulai wajib diisi.
                  </div>
              </div>
          </div>
        </div>
        <div class="form-group">
            <label>Keterangan</label>
            <textarea name="" class="form-control" id="keterangan_add" cols="30" rows="2"></textarea>
        </div>
        <div class="form-group">
            <label>Penjadwalan Layanan</label>
            <select name="" class="form-control select2bs4" id="penjadwalan_layanan" onchange="penjadwalan_layanan()">
              <option value="0">Tidak</option>
              <option value="1">Ya</option>
            </select>
        </div>
        <div class="form-group" id="klien_id">
          <label>Pilih Klien</label>
          <select class="form-control select2bs4" style="width: 100%;" id="klien_id_add">
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
          <select class="select2bs4" multiple="multiple" data-placeholder="Pilih nama" style="width: 100%;" id="user_id_add">
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
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success btn-block" id="submit2"><i class="fa fa-check"></i> Simpan</button>
        </div>
      </div>
    </div>
  </div>
<script src="{{ asset('source') }}/js/wizard.js"></script>
<script src="{{ asset('source') }}/js/main.js"></script>
<script src="{{ asset('adminlte') }}/plugins/select2/js/select2.full.min.js"></script>
<script src="{{ asset('source') }}/js/replacetemplate.js"></script>

<script src="{{ asset('/source/js/validation.js') }}"></script>

<script>
    $(function () {
        display_ct();
    });
      //Initialize Select2 Elements
  $('.select2bs4').select2({
      theme: 'bootstrap4'
      });
  $('.select-tag').select2({
    tags: true,
    theme: 'bootstrap4'
  });  

  $('#uuid_tindak_lanjut').on('change', function() {
    uuid_tindak_lanjut = $('#uuid_tindak_lanjut').val();

    if (uuid_tindak_lanjut != '') {
    $.ajax({
          url:'{{ route("agenda.show", "") }}/'+uuid_tindak_lanjut,
          type:'GET',
          dataType: 'json',
          success: function( response ) {
            if (response.success) {
                agenda = response.data;
                $('#lokasi').val(agenda.lokasi);
                $('#jam_selesai').val(agenda.jam_selesai);
                $('#catatan').val(agenda.catatan);
                
                $('#judul_kegiatan').html(agenda.judul_kegiatan);
                $('#tanggal_mulai').html(agenda.tanggal_mulai);
                $('#jam_mulai').html(agenda.jam_mulai);
                $('#keterangan').html(agenda.keterangan);
                if (agenda.nama == null) {
                    nama_klien = "<span style='color:red'>AGENDA INI BUKAN PENJADWALAN LAYANAN, TIDAK AKAN MASUK REKAPAN PELAYANAN KASUS.</span>";
                }else{
                    nama_klien = agenda.nama;
                }
                $('#nama').html("<b>"+nama_klien+"</b>");

                $('#tindak_lanjut').show();
            }
            }
        });
    }else{
        $('#tindak_lanjut').hide();
    }
  })

  function display_c(){
        var refresh=1000; // Refresh rate in milli seconds
        mytime=setTimeout('display_ct()',refresh)
    }

    function display_ct() {
        var x = new Date()
        var x1=x.getDate() + "-" + x.getMonth() + 1+ "-" +  x.getFullYear(); 
        x1 = x1 + " " +  x.getHours( )+ ":" +  x.getMinutes() + ":" +  x.getSeconds();
        document.getElementById('ct').innerHTML = x1;
        display_c();
    }


$('#submit2').click(function() {
  if(validateForm()){
    let token   = $("meta[name='csrf-token']").attr("content");
    $.ajax({
      url: `/agenda/store/`,
      type: "POST",
      cache: false,
      data: {
        uuid: $('#uuid').val(),
        judul_kegiatan: $('#judul_kegiatan_add').val(),
        tanggal_mulai: $("#tanggal_mulai_add").val(),
        jam_mulai: $("#jam_mulai_add").val(),
        keterangan: $("#keterangan_add").val(),
        klien_id: $("#klien_id_add").val(),
        user_id: $("#user_id_add").val(),
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
          location.reload();

          // hapus semua inputan
          $('#judul_kegiatan_add').val('');
          $('#tanggal_mulai_add').val('');
          $('#jam_mulai_add').val('');
          $('#keterangan_add').val('');
          $('#klien_id_add').val('');
        }
      },
      error: function (response){
        setTimeout(function(){
          $("#overlay").fadeOut(300);
        },500);

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

 function penjadwalan_layanan() {
    if ($('#penjadwalan_layanan').val() == 0) {
      $("#klien_id").hide();
    } else {
      $("#klien_id").show();
    }
 }
</script>
@endsection