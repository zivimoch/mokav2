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

          {{-- @if (Auth::user()->jabatan != 'Supervisor Kasus')
            <div class="col-md-12 warningSPP">
              <div class="alert alert-danger">
              <h5><i class="fas fa-exclamation-circle"></i> Perhatian!</h5>
              Mohon Periksa Laporan Kinerja Bulan Februari, Maret, April dan Mei. Jika ada Warning mohon untuk diperbaiki sesuai instruksi di warningnya.
              <br>
              Cara mengecek kinerja bulan sebelumnya : <br>
              <ol>
                  <li>Pergi ke halaman <a href="{{ route('kinerja.detail') }}?tahun={{ date('Y') }}&bulan={{ date('m') }}&user_id={{ Auth::user()->uuid }}">Laporan Kinerja</a></li>
                <li>Pilih bulan yang mau dicek (Februari, Maret, April dan Mei)</li>
                <li>Klik "Tampilkan"</li>
                <li>Cek apakah ada warning di bulan tersebut. Jika ada mohon untuk segera ditindak lanjuti</li>
                <li>Evaluasi Laporan Kinerja akan dilakukan setiap akhir bulan</li>
              </ol>              
              </div>
            </div>
          @endif --}}

          <!-- Left col -->
          <section class="col-lg-7 connectedSortable">
            <div class="card card-danger">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-bullhorn"></i>
                  Pengumuman 
                </h3>
                {{-- <div class="col-md-4">
                  <div class="form-group">
                    <label>Pilih Klien<span class="text-danger required-layanan">*</span></label>
                    <select data-placeholder="Pilih nama" style="width: 100%;" class="" id="klien_id_select" onchange="load_select2_petugas()"></select>
                    <div class="col-md-12" style="background-color:aliceblue; padding:10px; display:none" id="detail_data_klien"></div>
                    <div class="invalid-feedback2" id="valid-klien_id_select">
                      Klien wajib ada.
                    </div>  
                  </div>
                </div> --}}
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" onclick="tambahPengumuman()"><i class="nav-icon fas fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                    </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="height: 177px; overflow-y:scroll">
                <div id="kolomPengumuman"></div>
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
                  <button class="btn btn-success btn-sm" onclick="showModalAgenda('{{ now()->format('Y-m-d') }}', 0)"><i class="fas fa-plus"></i> Tambah Agenda</button>
                  <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                    </button>
                </div>
              </div>

              {{-- hapus ini setelah evaluasi selesai dan tercapai --}}
              @if (Auth::user()->jabatan == 'Manajer Kasus')
                <div class="progress" style="height: 25px;">
                  <div class="progress-bar bg-success persen_layanan" role="progressbar" style="width: {{ $dibuatMK }}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"> <span style="font-size:30px" class="persen_title_layanan2">{{ $dibuatMK }}%</span></div>
                  <div class="progress-bar bg-danger persen_layanan" role="progressbar" style="width: {{ $takDibuatMK }}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"> <span style="font-size:30px" class="persen_title_layanan2">{{ $takDibuatMK }}%</span></div>
                </div>
                *Hijau : agenda layanan dibuat oleh MK; Merah : agenda layanan dibuat oleh selain MK <br>
                *Data dari Periode Tanggal Dibuat & Tanggal Agenda
              @endif
              
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
                  {{-- <img class="img-circle elevation-2" src="{{ asset('img/profile/'.Auth::user()->foto) }}" alt="User Avatar"> --}}
                  <img class="img-circle elevation-2 fotoProfile" 
                src="{{ asset('img/profile/'.Auth::user()->foto) }}" 
                onerror="this.onerror=null; this.src='{{ asset('adminlte/dist/img/default-150x150.png') }}'"  
                alt="User Avatar">
                </div>
                <!-- /.widget-user-image -->
                <h3 class="widget-user-username">{{ Auth::user()->name }}</h3>
                <h5 class="widget-user-desc">{{ Auth::user()->jabatan }}</h5>
              </div>
              <div class="card-footer p-0">
                <ul class="nav flex-column">
                  <li class="nav-item" style="font-size: 18px">
                    <a href="{{ route('kasus') }}" class="nav-link">
                      Jumlah Kasus Terselesaikan / Seluruhnya <span class="float-right badge bg-primary">{{ $jumlah_terminasi }} / {{ $jumlah_kasus }}</span>
                    </a>
                  </li>
                  <li class="nav-item" style="font-size: 18px; border-bottom: 1px solid rgb(199, 199, 199);">
                    <a href="{{ route('notifikasi') }}" class="nav-link">
                      Skor Survey Kepuasan Layanan <span class="float-right badge bg-warning">NAN / NAN</span>
                    </a>
                  </li>
                </ul>
              </div>

<div class="row">
<div class="col-sm-6 border-right">
<div class="description-block">
<h5 class="description-header">{{ $layanan }}</h5>
<span class="description-text">Layanan</span>
</div>
</div>

<div class="col-sm-6">
<div class="description-block">
<h5 class="description-header">{{ $manajemen_layanan }}</h5>
<span class="description-text">Manajemen Layanan</span>
</div>
</div>

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
                  <a href="{{ route('kinerja.detail') }}?tahun={{ date('Y') }}&bulan={{ date('m') }}&user_id={{ Auth::user()->uuid }}" class="btn btn-tool">
                    <button class="btn btn-primary btn-sm"><i class="fas fa-tasks"></i> Laporan Kinerja</button>
                  </a>
                    <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                    </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div style="height: 548px; overflow-y:scroll">
                <div style="padding-left: 12px; margin-top:5px" class="bg-info color-palette">
                  <b style="font-size:20px" id="agendaAndaHeading2"></b>
                </div>
                <ul class="todo-list" data-widget="todo-list" id="agendaSaya2"></ul>

                <div style="padding-left: 12px;" class="bg-success color-palette">
                  <b style="font-size:20px" id="agendaKasusAndaHeading2"></b>
                </div>
                <ul class="todo-list" data-widget="todo-list" id="agendaKasusSaya2"></ul>

                <div class="bg-warning color-palette d-flex justify-content-between align-items-center p-1">
                  <b style="font-size:20px; padding-left:10px" id="agendaSemuaHeading2"></b>
                  <button class="btn btn-dark btn-xs" onclick="loadShareAgenda()">
                      <i class="fas fa-share"></i> Share
                  </button>
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
      <div id="overlayListAgenda" class="overlay dark">
        <div class="cv-spinner">
        <span class="spinner"></span>
        </div>
      </div>
      <div class="modal-header">
        <h5 class="modal-title" id="modelHeading2"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- /.card-header -->
        <div style="padding-left: 12px; margin-top:5px" class="bg-info color-palette">
        <b style="font-size:20px" id="agendaAndaHeading1"></b>
        </div>
        <ul class="todo-list" data-widget="todo-list" id="agendaSaya1"></ul>
        <br>
        <div style="padding-left: 12px; margin-top:5px" class="bg-success color-palette">
        <b style="font-size:20px" id="agendaKasusAndaHeading1"></b>
        </div>
        <ul class="todo-list" data-widget="todo-list" id="agendaKasusSaya1"></ul>
        <br>
        <div style="padding-left: 12px; margin-top:5px" class="bg-warning color-palette">
        <b style="font-size:20px" id="agendaSemuaHeading1"></b>
        </div>
        <ul class="todo-list" data-widget="todo-list" id="agendaSemua1"></ul>
      </div>
    </div>
  </div>
</div>


<!-- Modal Pengumuman-->
<div class="modal fade" id="tambahPengumumanModal" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">

      <div id="overlay" class="overlay dark">
          <div class="cv-spinner">
          <span class="spinner"></span>
          </div>
      </div>
      
      <div class="modal-header">
          <h5 class="modal-title" id="modelHeadingPengumuman">Pengumuman</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <div class="alert alert-danger alert-dismissible invalid-feedback" id="error-message-pengumuman">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h4><i class="icon fa fa-ban"></i> Gagal!</h4>
          <span id="message-pengumuman"></span>
      </div>
      <div class="alert alert-success alert-dismissible invalid-feedback" id="success-message-pengumuman">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h4><i class="icon fa fa-check"></i> Success!</h4>
          Data berhasil disimpan.
      </div>
      <div class="modal-body">
      <input type="hidden" id="uuid_pengumuman">
      <div class="form-group">
        <label>Judul Pengumuman<span class="text-danger">*</span></label>
        <input type="text" class="form-control required-field-pengumuman" id="judul_pengumuman">
        <div class="invalid-feedback" id="valid-judul_pengumuman">
          Judul Pengumuman wajib diisi.
        </div>
      </div>
      <div class="form-group">
          <label>Kategori Pengumuman</label>
          <select class="form-control" id="kategori_pengumuman" onchange="penjadwalan_layanan()">
            <option value="Rapat">Rapat</option>
            <option value="Pelayanan">Pelayanan</option>
            <option value="Kepegawaian">Kepegawaian</option>
            <option value="MOKA">MOKA</option>
          </select>
          <div id="kategori_pengumuman_data"></div>
      </div>
      <div class="col-md-12">
          <div class="form-group">
          <label>Isi Pengumuman<span class="text-danger">*</span></label>
          <textarea class="form-control required-field-pengumuman" id="isi_pengumuman" aria-label="With textarea" style="resize: none;" rows="5"></textarea>
          <div class="invalid-feedback" id="valid-isi_pengumuman">
            Isi Pengumuman wajib diisi.
          </div>
          </div>
      </div>
      {{-- <div class="form-group">
          <label>Bagikan Kepada</label>
          <br>
          <div class="icheck-primary d-inline" checked style="margin-right:15px">
            <input type="radio" id="radioPrimary1" name="bagikan_kepada" value="jabatan" checked>
            <label for="radioPrimary1">
                Menurut Jabatan
            </label>
          </div>
          <div class="icheck-primary d-inline">
            <input type="radio" id="radioPrimary2" name="bagikan_kepada" value="kostum">
            <label for="radioPrimary2">
                Kostum (pilih dibagikan ke siapa)
            </label>
          </div>
      </div>
      <div class="form-group">
        <select multiple="multiple" data-placeholder="Pilih jabatan" style="width: 100%;" class="select2_field" id="jabatan_select2">
          @foreach ($jabatan as $item)
            <option value="{{ $item }}">{{ $item }}</option>
          @endforeach
        </select>
        <div class="invalid-feedback" id="valid-user_id_select2">
          Minimal tag 1 jabatan.
        </div>
      </div>
      <div class="form-group">
        <select multiple="multiple" data-placeholder="Pilih nama" style="width: 100%;" class="user_id_select" id="user_id_select2"></select>
        <div class="invalid-feedback" id="valid-user_id_select2">
          Minimal tag 1 orang.
        </div>
      </div> --}}
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-success btn-block" id="submitPengumuman"><i class="fa fa-check"></i> Simpan</button>
          <button type="button" class="btn btn-danger btn-block" id="deletePengumuman"><i class="fa fa-trash"></i> Hapus</button>
      </div>
      </div>
  </div>
</div>

<!-- Modal Share Agenda-->
<div class="modal fade" id="modalShareAgenda" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div id="overlayShareAgenda" class="overlay dark">
        <div class="cv-spinner">
        <span class="spinner"></span>
        </div>
      </div>
      <div class="modal-header">
        <h5 class="modal-title">Share Agenda</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="shareListAgenda" style="background-color:aqua;overflow-y: scroll; max-height:500px;"></div>
        <label for="">Pilih Agenda Perjabatan</label>
        <select multiple="multiple" style="width: 100%;" class="select2bs4" id="filterJabatan" onchange="loadShareAgenda()">
          <option value="Advokat" selected>Advokat</option>
          <option value="Paralegal">Paralegal</option>
          <option value="Unit Reaksi Cepat">Unit Reaksi Cepat</option>
          <option value="Psikolog" selected>Psikolog</option>
          <option value="Konselor">Konselor</option>
          <option value="Manajer Kasus">Manajer Kasus</option>
          <option value="Pendamping Kasus">Pendamping Kasus</option>
        </select>
      <button class="btn btn-primary copy-button btn-sm" onclick="copyText('shareListAgenda')">
        <i class="fas fa-copy"></i> Copy Text
      </button>
      <button class="btn btn-success btn-sm" onclick="if(confirm('Jumlah karater yang dapat dishare ke WA terbatas. Agar full text dapat menggunakan tombol Copy Text')) shareWA();">
        <i class="fab fa-whatsapp"></i> Share WA
    </button>
    
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
    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    });

    loadPengumuman();
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
          events: "{{ env('APP_URL') }}/agenda",
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
                  url: "{{ env('APP_URL') }}/agenda/showdate/"+tanggal_mulai,
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
   
loadAgenda('{{  date("Y-m-d") }}',2);
function loadAgenda(tanggal_mulai, id) {
 $('#overlayListAgenda').show();
  $.ajax({
    type: "GET",
    url: "{{ env('APP_URL') }}/agenda/showdate/" + tanggal_mulai,
    success: function (response) {

      $('#agendaSaya'+id).html('');
      agenda_saya = response.data.agenda_saya;
      i = 1;
      $('#agendaAndaHeading'+id).html('');
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

        nama_klien = '';
        if (e.nama != null) {
          nama_klien = '<br>Klien : <a href="#" onclick="modal_klien(`'+e.uuid_klien+'`)">'+e.nama+'</a>';
        }
        $('#agendaSaya'+id).append('<li class="'+done+'"><div  class="icheck-primary d-inline ml-2"><input type="checkbox" value="" id="todoCheck'+i+'" '+checked+' '+disabled+' onclick="showModalAgenda(`'+e.tanggal_mulai+'`,`'+e.uuid+'`,{{ Auth::user()->id }})"><label for="todoCheck'+i+'"></label></div><span class="text">'+e.judul_kegiatan+'</span><span class="badge badge-warning badge-lg" style="font-size:13px"><i class="far fa-clock"></i> '+e.jam_mulai+'</span>'+nama_klien+'</li>');
        $('#agendaAndaHeading'+id).html('Agenda Anda ('+i+' agenda)')
        i++;
      });

      $('#agendaKasusSaya'+id).html('');
      agenda_kasus_saya = response.data.agenda_kasus_saya;
      x = 1;
      $('#agendaKasusAndaHeading'+id).html('');
      agenda_kasus_saya.forEach(e => {
        nama_klien = '';
        if (e.nama != null) {
          nama_klien = '<br>Klien : <a href="#" onclick="modal_klien(`'+e.uuid_klien+'`)">'+e.nama+'</a>';
        }
        $('#agendaKasusSaya'+id).append('<li>'+x+'. <span class="text">'+e.judul_kegiatan+'</span><span class="badge badge-warning badge-lg" style="font-size:13px"><i class="far fa-clock"></i> '+e.jam_mulai+'</span>'+nama_klien+'<br>Petugas : '+e.petugas+'</li>');
        $('#agendaKasusAndaHeading'+id).html('Agenda Kasus Yang Anda Tangani ('+x+' agenda)');
        x++;
      });

      $('#agendaSemua'+id).html('');
      agenda_semua = response.data.agenda_semua;
      y = 1;
      $('#agendaSemuaHeading'+id).html('');
      agenda_semua.forEach(e => {
        nama_klien = '';
        if (e.nama != null) {
          nama_klien = '<br>Klien : <a href="#" onclick="modal_klien(`'+e.uuid_klien+'`)">'+e.nama+'</a>';
        }
        $('#agendaSemua'+id).append('<li>'+y+'. <span class="text">'+e.judul_kegiatan+'</span><span class="badge badge-warning badge-lg" style="font-size:13px"><i class="far fa-clock"></i> '+e.jam_mulai+'</span>'+nama_klien+'<br>Petugas : '+e.petugas+'</li>');
        $('#agendaSemuaHeading'+id).html('Agenda Seluruh Petugas ('+y+' agenda)')
        y++;
      });
      $('#overlayListAgenda').hide();
    }
});
}

function loadShareAgenda() {
  $('#overlayShareAgenda').show();
  $('#modalShareAgenda').modal('show');

  let start = new Date().toISOString().split("T")[0]; 
    let end = new Date();
    end.setMonth(end.getMonth() + 1);
    end = end.toISOString().split("T")[0];
    filterJabatan = $('#filterJabatan').val();
    $.ajax({
      type: "GET",
      url: `{{ env('APP_URL') }}/agenda?lebih_detail=1&start=${start}&end=${end}&jabatan=`+encodeURIComponent(JSON.stringify(filterJabatan)),
      success: function (response) {
        let days = {};

        // Convert month numbers to Indonesian month names
        const monthNames = [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ];
        
        // Convert day names to Indonesian
        const dayNames = [
            "Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"
        ];

        // Group activities by date
        response.forEach(item => {
            if (!days[item.tanggal_mulai]) {
                days[item.tanggal_mulai] = [];
            }
            days[item.tanggal_mulai].push(item);
        });

        let result = "";
        $.each(days, function(date, activities) {
            let dateObj = new Date(date);
            let dayName = dayNames[dateObj.getDay()];
            let monthName = monthNames[dateObj.getMonth()];
            let formattedDate = `${dayName}, ${dateObj.getDate()} ${monthName} ${dateObj.getFullYear()}<br>`;
            
            result += `${formattedDate}`;

            activities.forEach((item, index) => {
              result += `${index + 1}. ${item.judul_kegiatan}, klien <b>${(item.nama ?? "").trim()}</b> ${(item.no_klien ? `(${item.no_klien.trim()})` : "")}, petugas <b>${(item.petugas ?? "").trim()}</b>. (MK <b>${(item.manajer_kasus ?? "-").trim()}</b>) — ${item.jam_mulai}<br>`;
            });

            result += `<br>`; // Add spacing between dates
        });

        $('#shareListAgenda').html(result);
        $('#overlayShareAgenda').hide();
      }
  });
}

function loadPengumuman() {
  $.ajax({
      url: `{{ env('APP_URL') }}/pengumuman/index`,
      type: "GET",
      cache: false,
      success: function (response){
          $('#kolomPengumuman').html('');
          
          data = response.data;
          data.forEach(e => {
              $('#kolomPengumuman').prepend("<div class=\"callout callout-danger\" style=\"cursor: pointer;\" onclick=\"editPengumuman('"+e.uuid+"')\"><div class=\"d-flex w-100 justify-content-between\"><h6 class=\"mb-1\"><b>"+e.judul+"</b><br>Diumumkan oleh : "+e.name+"</h6><small>"+e.created_at_formatted+" lalu</small> </div><p style=\"text-align: justify\">"+e.konten.replace(/\n/g, '<br>')+"</p></div>");
          });
      },
      error: function (response){
          console.log(response);
      }
      });
}

function tambahPengumuman() {
  $("#overlay").hide();
  $("#success-message-pengumuman").hide();
  $("#error-message-pengumuman").hide();
  $('#uuid_pengumuman').val('');
  $('#deletePengumuman').hide();
  $('#submitPengumuman').show();
  $('#judul_pengumuman').val('');
  $('#kategori_pengumuman').show();
  $('#isi_pengumuman').val('');
  $('#judul_pengumuman').prop('disabled', false);
  $('#isi_pengumuman').prop('disabled', false);
  $('#kategori_pengumuman_data').hide();
  $('#tambahPengumumanModal').modal('show');
}

    $('#submitPengumuman').click(function() {
        if(validateForm('pengumuman')){
            let token   = $("meta[name='csrf-token']").attr("content");
            $.ajax({
            url: "{{ route('pengumuman.store') }}",
            type: "POST",
            cache: false,
            data: {
                uuid: $('#uuid_pengumuman').val(),
                judul: $("#judul_pengumuman").val(),
                konten: $("#isi_pengumuman").val(),
                kategori: $("#kategori_pengumuman").val(),
                _token: token
            },
            success: function (response){
                if (response.success != true) {
                    $('#message-pengumuman').html(JSON.stringify(response));
                    $("#success-message-pengumuman").hide();
                    $("#error-message-pengumuman").show();
                }else{
                    $('#message-pengumuman').html(response.message);
                    $("#success-message-pengumuman").show();
                    $("#error-message-pengumuman").hide();
                    loadPengumuman();

                    // hapus semua inputan
                    $('#uuid_pengumuman').val('');
                    $("#judul_pengumuman").val('');
                    $("#isi_pengumuman").val('');
                    $('#tambahPengumumanModal').scrollTop(0);
                }
            },
            error: function (response){
                setTimeout(function(){
                $("#overlay").fadeOut(300);
                },500);
                console.log(response);

                $('#message-pengumuman').html(JSON.stringify(response));
                $("#success-message-pengumuman").hide();
                $("#error-message-pengumuman").show();
            }
            }).done(function() { //loading submit form
                setTimeout(function(){
                $("#overlay").fadeOut(300);
                },500);
            });
        }else{
            $('#message-pengumuman').html('Mohon cek ulang data yang wajib diinput.');
            $("#success-message-pengumuman").hide();
            $("#error-message-pengumuman").show();
        }
    });

    $('#deletePengumuman').click(function() {
        if(validateForm('pengumuman')){
            let token   = $("meta[name='csrf-token']").attr("content");
            $.ajax({
            url: "{{ route('pengumuman.store') }}",
            type: "POST",
            cache: false,
            data: {
                uuid: $('#uuid_pengumuman').val(),
                _token: token
            },
            success: function (response){
                if (response.success != true) {
                    $('#message-pengumuman').html(JSON.stringify(response));
                    $("#success-message-pengumuman").hide();
                    $("#error-message-pengumuman").show();
                }else{
                    $('#message-pengumuman').html(response.message);
                    $("#success-message-pengumuman").show();
                    $("#error-message-pengumuman").hide();
                    loadPengumuman();

                    // hapus semua inputan
                    $('#uuid_pengumuman').val('');
                    $("#pengumuman_kasus").val('');
                    $('#tambahPengumumanModal').scrollTop(0);
                }
            },
            error: function (response){
                setTimeout(function(){
                $("#overlay").fadeOut(300);
                },500);
                console.log(response);

                $('#message-pengumuman').html(JSON.stringify(response));
                $("#success-message-pengumuman").hide();
                $("#error-message-pengumuman").show();
            }
            }).done(function() { //loading submit form
                setTimeout(function(){
                $("#overlay").fadeOut(300);
                },500);
            });
        }else{
            $('#message-pengumuman').html('Mohon cek ulang data yang wajib diinput.');
            $("#success-message-pengumuman").hide();
            $("#error-message-pengumuman").show();
        }
    });

    function editPengumuman(uuid) {
        // gak ada edit langsung hapus saja, ini hanya show
        $("#success-message-pengumuman").hide();
        $("#error-message-pengumuman").hide();
        $('#submitPengumuman').hide();
        $('#judul_pengumuman').prop('disabled', true);
        $('#isi_pengumuman').prop('disabled', true);
        $('#tambahPengumumanModal').modal('show');
        $('#kategori_pengumuman').hide();
        $('#kategori_pengumuman_data').show();
        let token   = $("meta[name='csrf-token']").attr("content");
        $.ajax({
        url: `{{ env('APP_URL') }}/pengumuman/edit/`+uuid,
        type: "GET",
        cache: false,
        success: function (response){
            data = response.data;
            if (data.created_by == '{{ Auth::user()->id }}') {
                $('#deletePengumuman').show();
            }else{
                $('#deletePengumuman').hide();
            }
            $('#uuid_pengumuman').val(data.uuid);
            $("#judul_pengumuman").val(data.judul);
            $("#isi_pengumuman").val(data.konten);
            $("#kategori_pengumuman_data").html(data.kategori);
            $('#tambahPengumumanModal').scrollTop(0);
        },
        error: function (response){
            setTimeout(function(){
            $("#overlay").fadeOut(300);
            },500);
            console.log(response);

            $('#message-pengumuman').html(JSON.stringify(response));
            $("#success-message-pengumuman").hide();
            $("#error-message-pengumuman").show();
        }
        }).done(function() { //loading submit form
            setTimeout(function(){
            $("#overlay").fadeOut(300);
            },500);
        });
    }
</script>
@endsection