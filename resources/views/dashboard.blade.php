@extends('layouts.template')

@section('content')
<style>
  .fc-title{
    font-size: 17px;
  }
  .fc-content{
    cursor: pointer;
  }
  .fc-day:hover{
    background-color: yellow;
  }
  .fc-today{
    background-color:rgb(248, 214, 170) !important;
  }
  .modal {  
    overflow-y:auto;
  }
</style>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-7 connectedSortable">
            <div class="card card-danger">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-bullhorn"></i>
                  Pengumuman
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="nav-icon fas fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                    </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="callout callout-info" style="cursor: pointer;">
                  <h5>Jadwal Mas Fajar</h5>

                  <p>Selamat Pagi Bapak Ibu, 

                    Izin menyampaikan ulang jadwal kegiatan harian untuk hari ini.
                    
                    Atas perhatian dan kerjasamanya diucapkan terima kasih lorem ipsum amet...</p>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <!-- Agenda -->
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="nav-icon far fa-calendar-alt"></i>
                  Agenda PPPA Provinsi DKI Jakarta
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                    </button>
                </div>
              </div>
              <!-- /.card-header -->
                <div id="calendar" style="margin: 0px 5px 0px 5px"></div>
            </div>
            <!-- /.card -->
          </section>
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
          <section class="col-lg-5 connectedSortable">
            <!-- Widget: user widget style 2 -->
            <div class="card card-widget widget-user-2">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header bg-warning">
                <div class="widget-user-image">
                  <img class="img-circle elevation-2" src="https://adminlte.io/themes/v3/dist/img/user2-160x160.jpg" alt="User Avatar">
                </div>
                <!-- /.widget-user-image -->
                <h3 class="widget-user-username">{{ Auth::user()->name }}</h3>
                <h5 class="widget-user-desc">{{ Auth::user()->jabatan }}</h5>
              </div>
              <div class="card-footer p-0">
                <ul class="nav flex-column">
                  <li class="nav-item">
                    <a href="{{ route('kasus') }}" class="nav-link">
                      Kasus Yang Ditangani <span class="float-right badge bg-primary">31</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('notifikasi') }}" class="nav-link">
                      Tugas Belum Selesai <span class="float-right badge bg-danger">5</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('notifikasi') }}" class="nav-link">
                      Seluruh Tugas <span class="float-right badge bg-success">12</span>
                    </a>
                  </li>
                </ul>
              </div>
            </div>

          
            <!-- TO DO List -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="nav-icon far fa-calendar-alt"></i>
                  Agenda hari ini, {{ date('d M Y') }}
                </h3>
                <div class="card-tools">
                    <a href="{{ route('kinerja.detail') }}?bulan=2" class="btn btn-tool"><i class="fas fa-tasks"></i> Laporan Kinerja</a>
                    <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                    </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div style="height: 548px; overflow-y:scroll">
                <div style="margin-left: 12px">
                  <b style="font-size:20px" id="agendaAndaHeading2"></b>
                </div>
                <ul class="todo-list" data-widget="todo-list" id="agendaSaya2"></ul>
                <div style="margin-left: 12px">
                  <b style="font-size:20px" id="agendaSemuaHeading2"></b>
                </div>
                <ul class="todo-list" data-widget="todo-list" id="agendaSemua2"></ul>
              </div>
            </div>
          <!-- /.card -->
          </section>
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>

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
        <b style="font-size:20px" id="agendaAndaHeading1"></b>
        <ul class="todo-list" data-widget="todo-list" id="agendaSaya1"></ul>
        <br>
        <b style="font-size:20px" id="agendaSemuaHeading1"></b>
        <ul class="todo-list" data-widget="todo-list" id="agendaSemua1"></ul>
      </div>
    </div>
  </div>
</div>

<script src="{{ asset('adminlte') }}/plugins/select2/js/select2.full.min.js"></script>
<script src="{{ asset('/source/js/validation.js') }}"></script>

<link rel="stylesheet" href="{{ asset('adminlte') }}/plugins/fullcalendar-3.9.0/dist/fullcalendar.css">
<script src="{{ asset('adminlte') }}/plugins/moment/moment.min.js"></script> 
<script src="{{ asset('adminlte') }}/plugins/fullcalendar-3.9.0/dist/fullcalendar.js"></script>
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
                    loadAgenda(event.start._i,1);
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

                today = new Date();
                today = today.toISOString().split('T')[0];
                loadAgenda(today,2);

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
  
  // hapus semua inputan
  $('#judul_kegiatan').val('');
  $('#jam_mulai').val('');
  $('#keterangan').val('');
  $('#klien_id').val('');
  $('#lokasi').val('');
  $('#jam_selesai').val('');
  $('#catatan').val('');
  $('#dokumen_pendukung').val('');
  
  $('#tanggal_mulai').val(tanggal_mulai); 
  $('#modelHeading').html('Tambah Agenda'); 
  $('#ajaxModel').modal('show'); 
  $('#ajaxModelDetail').modal('hide'); 
  
 }

today = new Date();
today = today.toISOString().split('T')[0];
loadAgenda(today,2);
function loadAgenda(tanggal_mulai, id) {
  var SITEURL = "{{ url('/') }}";
  $.ajax({
    type: "GET",
    url: SITEURL + '/agenda/showdate/' + tanggal_mulai,
    success: function (response) {

      $('#agendaSaya'+id).html('');
      agenda_saya = response.data.agenda_saya;
      i = 1;
      agenda_saya.forEach(e => {
        if (e.jam_selesai == null) {
          done = '';
          checked = '';
          disabled = '';
        } else {
          done = 'done';
          checked = 'checked';
          disabled = 'disabled';
        }
        $('#agendaSaya'+id).append('<li class="'+done+'"><div  class="icheck-primary d-inline ml-2"><input type="checkbox" value="" id="todoCheck'+i+'" '+checked+' '+disabled+' onclick="showModal(`'+e.tanggal_mulai+'`,`'+e.uuid+'`)"><label for="todoCheck'+i+'"></label></div><span class="text">'+e.judul_kegiatan+'</span><span class="badge badge-warning badge-lg" style="font-size:13px"><i class="far fa-clock"></i> '+e.jam_mulai+'</span></li>');
        $('#agendaAndaHeading'+id).html('Agenda Anda ('+i+' agenda)')
        i++;
      });

      $('#agendaSemua'+id).html('');
      agenda_semua = response.data.agenda_semua;
      y = 1;
      agenda_semua.forEach(e => {
        $('#agendaSemua'+id).append('<li>'+y+'. <span class="text">'+e.judul_kegiatan+'</span><span class="badge badge-warning badge-lg" style="font-size:13px"><i class="far fa-clock"></i> '+e.jam_mulai+'</span></li>');
        $('#agendaSemuaHeading'+id).html('Agenda Seluruh Petugas ('+y+' agenda)')
        y++;
      });

    }
});
}
    </script>
@endsection