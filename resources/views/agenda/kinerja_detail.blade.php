@extends('layouts.template')

@section('content')
<style>
  .cursor-disabled {
    cursor:not-allowed;
  }
</style>
<style id="style-select2"></style>
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
                      <th>Tanggal</th>
                      <th>Jam</th>
                      <th>Agenda</th>
                      <th>Catatan</th>
                      <th>Validasi</th>
                  </tr>
                  </thead>
                  <tbody></tbody>
                    <tfoot>
                      <th colspan="4"><center>Centang Semua</center></th>
                      <th><div class="icheck-success d-inline d-flex justify-content-around"><input type="checkbox" id="checkAll"><label for="checkAll"></label></div></th>
                    </tfoot>
              </table>

                  <div class="row">
                    <div class="col-md-6 text-center">
                        Jakarta, 31 Januari 2023</br>
                        Yang Membuat,</br>
                        <br>
                        <br>
                        <br>
                        <br>
                        Addzifi Mochamad Gumelar
                    </div>
                    <div class="col-md-6 text-center">
                        Jakarta, 31 Januari 2023</br>
                        Yang Memverifikasi,</br>
                        <br>
                        <br>
                        <br>
                        <br>
                        Sekretariat
                    </div>
                </div>
            </div>
            
            </div>
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
            <div id="collapseOne" class="collapse show" data-parent="#accordion">
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
                    <input type="time" class="form-control" id="jam_selesai" value="{{ $jam_selesai }}">
                </div>
                <div class="form-group">
                <label>Dokumen pendukung <span style="font-size: 12px">(lihat dokumen tersedia <a href="{{ route('dokumen') }}" target="_blank">disini</a>)</span></label>
                <select class="select2" multiple="multiple" data-placeholder="Pilih nama" style="width: 100%;" id="dokumen_pendukung">
                <option value="31">Dokumen konsultasi hukum kasus Eliza Thornberry</option>
                <option value="32">Dokumen Pendampingan pengadilan kasus eliza thornberry</option>
                <option value="33">Pendampingan pengadilan kasus tom delounge</option>
                <option value="34">Mediasi kasus tom delounge</option>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

<script>
 $("#checkAll").click(function () {
     $('input:checkbox').not(this).prop('checked', this.checked);
 });

 function validasi(id) {
  // alert('apakah checked : '+$('#checkboxSuccess'+id).is(':checked'));
  // toastr.success('Berhasil update data', 'Event');
  alert(id);
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
    
    $('#example1').DataTable({
      "ordering": false,
      "processing": true,
      "serverSide": true,
      "responsive": false, 
      "lengthChange": false, 
      "autoWidth": false,
      "ajax": "/api/agenda?tahun=2023&bulan=6&user_id=2",
      "rowsGroup": [0],
      'createdRow': function( row, data, dataIndex ) {
          $(row).attr('id', data.uuid);
      },
      "columns": [
        {"data": "tanggal_mulai", "width":"10%"},
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

              if(row.judul != null){
                dokumen = row.judul;
                var array = dokumen.split(",|");
                for (i=1;i<array.length;i++){
                  dokumens += '<a href="https://facebook.com"><span class="badge bg-primary"><i class="nav-icon fas fa-file-alt"></i> '+array[i]+'</span></a> ';
                };
              }else{
                dokumens = '';
              }
              return catatan+lokasi+'<br>'+dokumens;
            }
        },
        {
            "mRender": function (data, type, row) {
                if (row.name == null) {
                  return '<div class="icheck-success d-inline d-flex justify-content-around"><input type="checkbox" id="checkboxSuccess'+row.uuid+'" onchange="validasi(`'+row.uuid+'`)"><label for="checkboxSuccess'+row.uuid+'"></label></div>'
                }else{
                  return '<div class="icheck-success d-inline d-flex justify-content-around"><input type="checkbox" checked="" id="checkboxSuccess'+row.uuid+'" onchange="validasi(`'+row.uuid+'`)"><label for="checkboxSuccess'+row.uuid+'"></label></div>';
                }
            }
        },
      ],
      "columnDefs": [
        { className: "bg-light", "targets": [ 0 ] },
        { className: "cursor-disabled", "targets": [ 3 ] }
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
              $('#style-select2').html('.select2-selection__choice[title="{{ Auth::user()->name }}"] .select2-selection__choice__remove {display: none;}.select2-results__option[aria-selected=true] {display: none;}');

              $("#success-message").hide();
              $("#error-message").hide();
              $("#overlay").hide();

              $('#modelHeading').html("Tambah Agenda");
              $('#ajaxModel').modal('show'); 

              // hapus semua inputan
              $('#uuid').val('');
              $('#judul_kegiatan').val('');
              $('#tanggal_mulai').val('');
              $('#jam_mulai').val('');
              $('#keterangan').val('');
              $('#klien_id').val('');
              $('#lokasi').val('');
              $('#jam_selesai').val('');
              $('#catatan').val('');
              $('#dokumen_pendukung').select2().val('');
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


       $('#example1 tbody').on( 'click', 'tr', function (evt) {
        $('#style-select2').html('.select2-selection__choice[title="{{ Auth::user()->name }}"] .select2-selection__choice__remove {display: block;}.select2-results__option[aria-selected=true] {display: none;}');

        $("#success-message").hide();
        $("#error-message").hide();

          $.get(`/agenda/edit/`+this.id, function (data) {
              $("#overlay").hide();
              $('#modelHeading').html("Edit Agenda");

              var $cell=$(evt.target).closest('td');
              if($cell.index()<3){
                $('#ajaxModel').modal('show');

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
              
                $("#user_id").val(data.user_id);
                $('#user_id').select2();

                $("#dokumen_pendukung").val(data.dokumen_pendukung);
                $('#dokumen_pendukung').select2();
              }
          });
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

          $('#example1').DataTable().ajax.reload();

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
 })
</script>
@endsection