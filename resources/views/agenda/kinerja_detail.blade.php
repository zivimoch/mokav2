@extends('layouts.template')

@section('content')
<style>
  .select2-selection__choice[title="{{ Auth::user()->name }}"] .select2-selection__choice__remove {
    display: none;
}
.select2-results__option[aria-selected=true] {
    display: none;
}
</style>
    {{-- DataTable --}}
     <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Laporan Kinerja</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="card">
            {{-- <div class="card-header">
            <h3 class="card-title">DataTable with default features</h3>
            </div> --}}
            
            <div class="card-body" style="overflow-x: scroll">
              <table id="example1" class="table table-sm table-bordered  table-hover" style="cursor:pointer">
        
                <thead>
                  <tr>
                      <th>Hari / Tanggal</th>
                      <th>Jam</th>
                      <th>Agenda</th>
                      <th>Catatan</th>
                      <th>Validasi</th>
                  </tr>
                  </thead>
                  <tbody></tbody>
              </table>

                  <div class="row">
                    <br>
                    <br>
                    <br>
                    <div class="col-md-12 text-center">
                        Jakarta, 31 Januari 2023</br>
                        Yang Membuat,</br>
                        <br>
                        <br>
                        <br>
                        <br>
                        Addzifi Mochamad Gumelar
                    </div>
                </div>
            </div>
            
            </div>
      </div><!-- /.container-fluid -->
    </section>

<!-- Modal -->
<div class="modal fade" id="modalCreate" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div id="overlay" class="overlay dark">
        <div class="cv-spinner">
          <span class="spinner"></span>
        </div>
      </div>
      
      <div class="modal-header">
        <h5 class="modal-title">Buat Agenda #9I21AV</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="alert alert-danger alert-dismissible invalid-feedback" id="valid-message">
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
          <input type="text" name="" id="start" hidden>
          <input type="text" name="" id="end" hidden>
      <div class="form-group">
          <label><span class="text-danger">*</span>Judul kegiatan</label>
          <input type="text" class="form-control required-field" id="judul_kegiatan">
          <div class="invalid-feedback" id="valid-judul_kegiatan">
            Judul Kegiatan wajib diisi.
          </div>
      </div>
      <div class="row">
        <div class="col-md-6">
            <div class="form-group">
              <label><span class="text-danger">*</span>Tanggal</label>
              <input type="date" class="form-control required-field" id="tanggal_mulai">
              <div class="invalid-feedback" id="valid-tanggal_mulai">
                Tanggal Mulai wajib diisi.
              </div>
          </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label><span class="text-danger">*</span>Jam mulai</label>
                <input type="time" class="form-control required-field" id="jam_mulai">
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
          <select name="" class="form-control" id="penjadwalan_layanan">
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
        <select class="select2 required-field" multiple="multiple" data-placeholder="Pilih nama" style="width: 100%;" id="user_id">
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
            <div id="collapseOne" class="collapse show" data-parent="#accordion">
              <div class="alert alert-warning alert-dismissible">
                <i class="icon fas fa-exclamation-triangle"></i> Data Tindak Lanjut hanya tercatat pada akun anda
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
                    <input type="time" class="form-control" id="jam_selesai" value="{{ $jam_selesai }}">
                </div>
                <div class="form-group">
                    <label>Catatan</label>
                    <textarea name="" class="form-control" id="catatan" cols="30" rows="2"></textarea>
                </div>
                <div class="form-group">
                <label>Dokumen pendukung <span style="font-size: 12px">(lihat dokumen tersedia <a href="{{ route('dokumen') }}">disini</a>)</span></label>
                <select class="select2" multiple="multiple" data-placeholder="Pilih nama" style="width: 100%;" id="dokumen_pendukung">
                <option value="31">Dokumen konsultasi hukum kasus Eliza Thornberry</option>
                <option value="32">Dokumen Pendampingan pengadilan kasus eliza thornberry</option>
                <option value="33">Pendampingan pengadilan kasus tom delounge</option>
                <option value="34">Mediasi kasus tom delounge</option>
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

<script src="{{ asset('adminlte') }}/plugins/select2/js/select2.full.min.js"></script>

<script src="{{ asset('/source/js/validation.js') }}"></script>
<script>

  $(function () {
    display_ct();
    $("#klien_id").hide();
    $('#penjadwalan_layanan').change(function () {
      if ($('#penjadwalan_layanan').val() == 0) {
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
    });
    
    $('#example1').DataTable({
      "ordering": false,
      "processing": true,
      "serverSide": true,
      "responsive": false, 
      "lengthChange": false, 
      "autoWidth": false,
      "ajax": "/api/agenda?tahun=2023&bulan=3&user_id=2",
      "rowsGroup": [0],
      'createdRow': function( row, data, dataIndex ) {
          $(row).attr('id', data.id);
      },
      "columns": [
        {"data": "tanggal_mulai"},
        {
            "mData": "jam_mulai",
            "mRender": function (data, type, row) {
              if (row.jam_selesai != null) {
                return row.jam_mulai+' - '+row.jam_selesai;
              }else{
                return row.jam_mulai;
              }
            }
        },
        {
            "mData": "jam_mulai",
            "mRender": function (data, type, row) {
              judul_kegiatan = keterangan = '';
              if (row.judul_kegiatan != null) {
                judul_kegiatan = '<b>'+row.judul_kegiatan+'</b>';
              }

              if (row.keterangan != null) {
                keterangan = '</br>'+row.keterangan;
              }
              return judul_kegiatan+keterangan;
            }
        },
        {
            "mData": "jam_mulai",
            "mRender": function (data, type, row) {
              catatan = lokasi = '';
              
              if (row.lokasi) {
                lokasi = '</br>Lokasi : '+row.lokasi;
              }

              if (row.catatan) {
                catatan = row.catatan;
              }
              return catatan+lokasi;
            }
        },
        {
            "mRender": function (data, type, row) {
              return '<div class="icheck-success d-inline d-flex justify-content-around bd-highlight"><input type="checkbox" checked="" id="checkboxSuccess1"><label for="checkboxSuccess1"></label></div>';
            }
        },
      ],
      "columnDefs": [
        { className: "bg-light", "targets": [ 0 ] }
      ],
      "pageLength": 25,
      "lengthMenu": [
          [10, 25, 50, 100, -1],
          ['10 rows', '25 rows', '50 rows', '100 rows','All'],
      ],
      "dom": 'Blfrtip', // Blfrtip or Bfrtip
      "buttons": ["pageLength", "copy", "csv", "excel", "pdf", "print", 
        {
          className: "btn-success",
          text: 'Tambah',
            action: function ( ) {
              $("#overlay").hide();
              $('#modalCreate').modal('show'); 
            }
        },
        {
          className: "btn-info",
          text: 'Lihat agenda',
            action: function ( ) {
              window.location.assign('{{ route("agenda") }}')
            }
        }]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

    $('#example1 tbody').on( 'click', 'tr', function () {
      $("#overlay").hide();
      alert('redirect ke : '+this.id);
      $('#modalCreate').modal('show'); 
    });

    $('#example1_filter').css({'float':'right','display':'inline-block'});
  
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

 $('#submit').click(function() {
  if(validateForm()){
    let token   = $("meta[name='csrf-token']").attr("content");
    $.ajax({
      url: `/agenda/store/`,
      type: "POST",
      cache: false,
      data: {
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
          console.log(response);
          $('#message').html(JSON.stringify(response));
          $("#success-message").hide();
          $("#valid-message").show();
        }else{
          $('#message').html(response.message);
          $("#success-message").show();
          $("#valid-message").hide();

          $('#example1').DataTable().ajax.reload();
        }
        if (response.success) {
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

        console.log(response);

        $('#message').html(JSON.stringify(response));
        $("#success-message").hide();
        $("#valid-message").show();
      }
    }).done(function() { //loading submit form
        setTimeout(function(){
          $("#overlay").fadeOut(300);
        },500);
      });
  }else{
    $('#message').html('Mohon cek ulang data yang wajib diinput.');
    $("#success-message").hide();
    $("#valid-message").show();
  }
 })
</script>
@endsection