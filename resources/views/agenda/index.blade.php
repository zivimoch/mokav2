@extends('layouts.template')

@section('content')
<!-- fullCalendar -->
<link rel="stylesheet" href="{{ asset('adminlte') }}/plugins/fullcalendar/main.css">
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
            <h1>Agenda</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Calendar</li>
            </ol>
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

          <div class="col-md-3">
            <div class="sticky-top mb-3">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">Draggable Events</h4>
                </div>
                <div class="card-body">
                  <!-- the events -->
                  <div id="external-events">
                    <div class="external-event bg-success">Lunch</div>
                    <div class="external-event bg-warning">Go home</div>
                    <div class="external-event bg-info">Do homework</div>
                    <div class="external-event bg-primary">Work on UI design</div>
                    <div class="external-event bg-danger">Sleep tight</div>
                    <div class="checkbox">
                      <label for="drop-remove">
                        <input type="checkbox" id="drop-remove">
                        remove after drop
                      </label>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Create Event</h3>
                </div>
                <div class="card-body">
                  <div class="btn-group" style="width: 100%; margin-bottom: 10px;">
                    <ul class="fc-color-picker" id="color-chooser">
                      <li><a class="text-primary" href="#"><i class="fas fa-square"></i></a></li>
                      <li><a class="text-warning" href="#"><i class="fas fa-square"></i></a></li>
                      <li><a class="text-success" href="#"><i class="fas fa-square"></i></a></li>
                      <li><a class="text-danger" href="#"><i class="fas fa-square"></i></a></li>
                      <li><a class="text-muted" href="#"><i class="fas fa-square"></i></a></li>
                    </ul>
                  </div>
                  <!-- /btn-group -->
                  <div class="input-group">
                    <input id="new-event" type="text" class="form-control" placeholder="Event Title">

                    <div class="input-group-append">
                      <button id="add-new-event" type="button" class="btn btn-primary">Add</button>
                    </div>
                    <!-- /btn-group -->
                  </div>
                  <!-- /input-group -->
                </div>
              </div>
            </div>
          </div>
          <!-- /.col -->
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
<div class="modal fade" id="modalCreate" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Buat Agenda #S92JAQ</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <input type="text" name="" id="start" hidden>
          <input type="text" name="" id="end" hidden>
      <div class="form-group">
          <label>Judul kegiatan</label>
          <input type="text" class="form-control" id="title">
      </div>
      <div class="row">
        <div class="col-md-6">
            <div class="form-group">
              <label>Tanggal</label>
              <input type="date" class="form-control" id="title">
          </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Jam mulai</label>
                <input type="time" class="form-control" id="jam">
            </div>
        </div>
      </div>
      <div class="form-group">
        <label>Tempat</label>
        <input type="text" class="form-control" id="title">
      </div>
      <div class="form-group">
          <label>Keterangan</label>
          <textarea name="" class="form-control" id="" cols="30" rows="2"></textarea>
      </div>
      <div class="form-group">
          <label>Penjadwalan Layanan</label>
          <select name="" class="form-control" id="penadjawalan_layanan">
            <option value="0">Tidak</option>
            <option value="1">Ya</option>
          </select>
      </div>
      <div class="form-group" id="klien_id">
        <div class="alert alert-warning alert-dismissible">
          <i class="icon fas fa-exclamation-triangle"></i> Penjadwalan Layanan membutuhkan Dokumen Pendukung untuk Tindak Lanjutnya
        </div>
        <label>Pilih Klien</label>
        <select class="form-control select2" style="width: 100%;">
          <option>silahkan pilih</option>
          <option>Tini</option>
          <option>Tina</option>
          <option>Toni</option>
          <option>Tono</option>
          <option>Tino</option>
          <option>Tanos</option>
        </select>
      </div>
      <div class="form-group">
        <label>Tag</label>
        <select class="select2" multiple="multiple" data-placeholder="Pilih nama" style="width: 100%;">
        <option>Addzifi Mochamad Gumelar</option>
        <option>Alexander Graham Bell</option>
        <option>Thomas Alfa Edison</option>
        <option>Tony Stark</option>
        <option>Rudy Tabootie</option>
        </select>
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
                  <i class="icon fas fa-exclamation-triangle"></i> Data Tindak Lanjut hanya tercatat pada akun anda
                </div>
              <div class="card-body">
                  <div class="form-group">
                      <label>Jam selesai</label>
                      <input type="time" class="form-control" id="jam">
                  </div>
                  <div class="form-group">
                      <label>Catatan</label>
                      <textarea name="" class="form-control" id="" cols="30" rows="2"></textarea>
                  </div>
                  <div class="form-group">
                  <label>Dokumen pendukung <span style="font-size: 12px">(lihat dokumen tersedia <a href="{{ route('dokumen') }}">disini</a>)</span></label>
                  <select class="select2" multiple="multiple" data-placeholder="Pilih nama" style="width: 100%;">
                  <option>Dokumen konsultasi hukum kasus Eliza Thornberry</option>
                  <option>Dokumen Pendampingan pengadilan kasus eliza thornberry</option>
                  <option>Pendampingan pengadilan kasus tom delounge</option>
                  <option>Mediasi kasus tom delounge</option>
                  </select>
                  </div>
                  <span style="font-size: 14px">*Laporan Tindak Lanjut tersimpan pada tanggal : <span id='ct' ></span></span>
              </div>
              </div>
              </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-block" id="submit">Simpan</button>
      </div>
    </div>
  </div>
</div>
<!-- Bootstrap -->
<script src="{{ asset('adminlte') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('adminlte') }}/plugins/select2/js/select2.full.min.js"></script>
<!-- jQuery UI -->
<script src="{{ asset('adminlte') }}/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- fullCalendar 2.2.5 -->
<script src="{{ asset('adminlte') }}/plugins/moment/moment.min.js"></script> 
<script src="{{ asset('adminlte') }}/plugins/fullcalendar/main.js"></script>
<!-- AdminLTE for demo purposes -->


<script>
  $(function () {
    display_ct();
    $("#klien_id").hide();
    $('#penadjawalan_layanan').change(function () {
      if ($('#penadjawalan_layanan').val() == 0) {
        $("#klien_id").hide();
      } else {
        $("#klien_id").show();
      }
    })
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    /* initialize the external events
     -----------------------------------------------------------------*/
    function ini_events(ele) {
      ele.each(function () {

        // create an Event Object (https://fullcalendar.io/docs/event-object)
        // it doesn't need to have a start or end
        var eventObject = {
          title: $.trim($(this).text()) // use the element's text as the event title
        }

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject)

        // make the event draggable using jQuery UI
        $(this).draggable({
          zIndex        : 1070,
          revert        : true, // will cause the event to go back to its
          revertDuration: 0  //  original position after the drag
        })

      })
    }

    ini_events($('#external-events div.external-event'))

    /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date()
    var d    = date.getDate(),
        m    = date.getMonth(),
        y    = date.getFullYear()

    var Calendar = FullCalendar.Calendar;
    var Draggable = FullCalendar.Draggable;

    var containerEl = document.getElementById('external-events');
    var checkbox = document.getElementById('drop-remove');
    var calendarEl = document.getElementById('calendar');

    // initialize the external events
    // -----------------------------------------------------------------

    new Draggable(containerEl, {
      itemSelector: '.external-event',
      eventData: function(eventEl) {
        return {
          title: eventEl.innerText,
          backgroundColor: window.getComputedStyle( eventEl ,null).getPropertyValue('background-color'),
          borderColor: window.getComputedStyle( eventEl ,null).getPropertyValue('background-color'),
          textColor: window.getComputedStyle( eventEl ,null).getPropertyValue('color'),
        };
      }
    });

    var calendar = new Calendar(calendarEl, {
      headerToolbar: {
        left  : 'prev,next today',
        center: 'title',
        right : 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      themeSystem: 'bootstrap',
      //Random default events
      events: [
        {
          title          : 'All Day Event',
          start          : new Date(y, m, 2),
          backgroundColor: '#f56954', //red
          borderColor    : '#f56954', //red
        },
        {
          title          : 'Long Event',
          start          : new Date('2023-01-11'),
          backgroundColor: '#f39c12', //yellow
          borderColor    : '#f39c12' //yellow
        },
        {
          title          : 'Meeting',
          start          : new Date(y, m, d, 10, 30),
          allDay         : false,
          backgroundColor: '#0073b7', //Blue
          borderColor    : '#0073b7' //Blue
        },
        {
          title          : 'Lunch',
          start          : new Date(y, m, d, 12, 0),
          end            : new Date(y, m, d, 14, 0),
          allDay         : false,
          backgroundColor: '#00c0ef', //Info (aqua)
          borderColor    : '#00c0ef' //Info (aqua)
        },
        {
          title          : 'Birthday Party',
          start          : new Date(y, m, d + 1, 19, 0),
          end            : new Date(y, m, d + 1, 22, 30),
          allDay         : false,
          backgroundColor: '#00a65a', //Success (green)
          borderColor    : '#00a65a' //Success (green)
        },
        {
          title          : 'Click for Google',
          start          : new Date(y, m, 28),
          end            : new Date(y, m, 29),
          url            : 'https://www.google.com/',
          backgroundColor: '#3c8dbc', //Primary (light-blue)
          borderColor    : '#3c8dbc' //Primary (light-blue)
        }
      ],
      editable  : true,
      droppable : true, 
      selectable: true,
      select: function (start, end, allDay) {
          $('#modalCreate').modal('show'); 
      },
    });

    calendar.render();
    // $('#calendar').fullCalendar()
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
</script>
</body>
@endsection