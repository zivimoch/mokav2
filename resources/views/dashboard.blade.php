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
                    <a href="{{ route('kinerja.detail') }}?tahun={{ date('Y') }}&bulan={{ date('m') }}&user_id={{ Auth::user()->id }}" class="btn btn-tool"><i class="fas fa-tasks"></i> Laporan Kinerja</a>
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
<!-- Modal List Agenda-->
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
<script src="{{ asset('source') }}/js/jquery-clock-timepicker.min.js"></script>

{{-- include modal agenda --}}
@include('agenda.modal')
<!-- Script -->
<script>
  $(document).ready(function () {

   var SITEURL = "{{ url('/') }}";
     
   $.ajaxSetup({
       headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
   });
     
   calendar = $('#calendar').fullCalendar({
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
            showModalAgenda($.fullCalendar.formatDate(start, "Y-MM-DD"),0);
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
   });

   function displayMessage(message) {
       toastr.success(message, 'Event');
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
        $('#agendaSaya'+id).append('<li class="'+done+'"><div  class="icheck-primary d-inline ml-2"><input type="checkbox" value="" id="todoCheck'+i+'" '+checked+' '+disabled+' onclick="showModalAgenda(`'+e.tanggal_mulai+'`,`'+e.uuid+'`)"><label for="todoCheck'+i+'"></label></div><span class="text">'+e.judul_kegiatan+'</span><span class="badge badge-warning badge-lg" style="font-size:13px"><i class="far fa-clock"></i> '+e.jam_mulai+'</span></li>');
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