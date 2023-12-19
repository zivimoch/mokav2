@extends('layouts.template')

@section('content')
<style>
  .fc-title{
    font-size: 20px;
  }
  .fc-content{
    cursor: pointer;
  }
  .fc-day:hover{
    background-color: yellow;
  }
  .fc-today{
    background-color:antiquewhite !important;
  }
  .modal {
    overflow-y:auto;
  }
</style>
<link rel="stylesheet" href="{{ asset('adminlte') }}/plugins/fullcalendar-3.9.0/dist/fullcalendar.css">
<script src="{{ asset('adminlte') }}/plugins/moment/moment.min.js"></script> 
<script src="{{ asset('adminlte') }}/plugins/fullcalendar-3.9.0/dist/fullcalendar.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->   
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><i class="nav-icon far fa-calendar-alt"></i> Agenda</h1>
          </div>
          <div class="col-sm-6">
            <a href="{{ route('kinerja') }}" class="btn btn-success float-right">
              <i class="fas fa-tasks"></i> Laporan Kinerja
            </a>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- /.col -->
          <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-body">
                <!-- THE CALENDAR -->
                <div id="calendar"></div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->

<!-- Modal -->
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
        <select class="" multiple="multiple" data-placeholder="Pilih nama" style="width: 100%;" id="user_id">
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

<!-- Modal Detail Agenda-->
<div class="modal fade" id="ajaxModelDetail" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      
      <div class="modal-header">
        <h5 class="modal-title" id="modelHeading2"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- /.card-header -->
        <b style="font-size:20px" id="agendaAndaHeading"></b>
        <ul class="todo-list" data-widget="todo-list" id="agendaSaya"></ul>
        <br>
        <b style="font-size:20px" id="agendaSemuaHeading"></b>
        <ul class="todo-list" data-widget="todo-list" id="agendaSemua"></ul>
      </div>
    </div>
  </div>
</div>
<!-- Bootstrap -->
<script src="{{ asset('adminlte') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('adminlte') }}/plugins/select2/js/select2.full.min.js"></script>
<!-- jQuery UI -->
<script src="{{ asset('adminlte') }}/plugins/jquery-ui/jquery-ui.min.js"></script>

<script src="{{ asset('/source/js/validation.js') }}"></script>

<script>
$(document).ready(function () {
   var SITEURL = "{{ url('/') }}";
     
   $.ajaxSetup({
       headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
   });
     
   var calendar = $('#calendar').fullCalendar({
          eventColor: '#378006',
          eventTextColor: '#fff',
          eventTextSize: '20px',
          editable: false,
          events: SITEURL + "/agenda",
          displayEventTime: false,
          eventRender: function (event, element, view) {
              if (event.allDay === 'true') {
                      event.allDay = true;
              } else {
                      event.allDay = false;
              }
          },
          selectable: true,
          selectHelper: true,
          select: function (start, end, allDay) {
            showModal($.fullCalendar.formatDate(start, "Y-MM-DD"),0);
          },
          eventClick: function (event) {
              tanggal_mulai = event.start._i;
              $('#modelHeading2').html('Agenda Tanggal : '+tanggal_mulai); 
              $('#ajaxModelDetail').modal('show'); 
              $.ajax({
                  type: "GET",
                  url: SITEURL + '/agenda/showdate/' + tanggal_mulai,
                  success: function (response) {
                    $('#agendaSaya').html('');
                    agenda_saya = response.data.agenda_saya;
                    i = 1;
                    agenda_saya.forEach(e => {
                      if (e.jam_selesai == null) {
                        done = '';
                        checked = '';
                        disabled = 'disabled';
                      } else {
                        done = 'done';
                        checked = 'checked';
                        disabled = 'disabled';
                      }
                      $('#agendaSaya').append('<li class="'+done+'"><div  class="icheck-primary d-inline ml-2"><input type="checkbox" value="" id="todoCheck'+i+'" '+checked+' '+disabled+' onclick="showModal(`'+e.tanggal_mulai+'`,`'+e.uuid+'`)"><label for="todoCheck'+i+'"></label></div><span class="text">'+e.judul_kegiatan+'</span><span class="badge badge-warning badge-lg" style="font-size:13px"><i class="far fa-clock"></i> '+e.jam_mulai+'</span></li>');
                      $('#agendaAndaHeading').html('Agenda Anda ('+i+' agenda)')
                      i++;
                    });

                    $('#agendaSemua').html('');
                    agenda_semua = response.data.agenda_semua;
                    y = 1;
                    agenda_semua.forEach(e => {
                      $('#agendaSemua').append('<li>'+y+'. <span class="text">'+e.judul_kegiatan+'</span><span class="badge badge-warning badge-lg" style="font-size:13px"><i class="far fa-clock"></i> '+e.jam_mulai+'</span></li>');
                      $('#agendaSemuaHeading').html('Agenda Seluruh Petugas ('+y+' agenda)')
                      y++;
                    });
                  }
              });
          }

      });

      $('#submit').click(function() {
        if(validateForm('agenda')){
          let token   = $("meta[name='csrf-token']").attr("content");
          $.ajax({
            url: `/agenda/store/`,
            type: "POST",
            cache: false,
            data: {
              uuid: $('#uuid').val(),
              judul_kegiatan: $('#judul_kegiatan').val(),
              tanggal_mulai: $("#tanggal_mulai").val(),
              jam_mulai: $("#jam_mulai").val(),
              keterangan: $("#keterangan").val(),
              klien_id: $("#klien_id").val(),
              user_id: $("#user_id").val(),
              lokasi: $("#lokasi").val(),
              jam_selesai: $("#jam_selesai").val(),
              catatan: $("#catatan").val(),
              dokumen_pendukung: $("#dokumen_pendukung").val(),
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
                calendar.fullCalendar( 'refetchEvents' );
                calendar.fullCalendar('unselect');

                // hapus semua inputan
                $('#judul_kegiatan').val('');
                $('#tanggal_mulai').val('');
                $('#jam_mulai').val('');
                $('#keterangan').val('');
                $('#klien_id').val('');
                $('#lokasi').val('');
                $('#jam_selesai').val('');
                $('#catatan').val('');
                $('#dokumen_pendukung').val('');
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
    
   });
    
   function displayMessage(message) {
       toastr.success(message, 'Event');
   } 

  function display_c(){
    var refresh=1000; // Refresh rate in milli seconds
    mytime=setTimeout('display_ct()',refresh)
  }

  function display_ct() {
    var x = new Date();
    var x1=x.getDate() + "-" + x.getMonth() + 1+ "-" +  x.getFullYear(); 
    x1 = x1 + " " +  x.getHours( )+ ":" +  x.getMinutes() + ":" +  x.getSeconds();
    document.getElementById('ct').innerHTML = x1;
    display_c();
  }
     
  function penjadwalan_layanan() {
    if ($('#penjadwalan_layanan').val() == 0) {
      $("#klien_id").hide();
    } else {
      $("#klien_id").show();
    }
 }

$(function () {
    display_ct();
    $("#klien_id").hide();
    //Initialize Select2 Elements
    $('.select2').select2()
    $('#user_id').select2();

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
});
    
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
  
  $('#tanggal_mulai').val(tanggal_mulai); 
  $('#modelHeading').html('Tambah Agenda'); 
  $('#ajaxModel').modal('show'); 
  $('#ajaxModelDetail').modal('hide'); 
  
 }
</script>
</body>
@endsection