@extends('layouts.template')

@section('content')
<style>
  .cursor-disabled {
    cursor:not-allowed;
  }
</style>
    {{-- DataTable --}}
     <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><i class="fas fa-tasks"></i> Laporan Kinerja</h1>
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
            <input type="hidden" id="uuid_agenda_hightlight" value="{{ Request::get('row-agenda') }}">
              <table id="tabelAgenda" class="table table-sm table-bordered  table-hover" style="cursor:pointer">
        
                <thead>
                  <tr>
                      <th>Tanggal</th>
                      <th>Jam</th>
                      <th>Agenda</th>
                      <th>Tindak Lanjut</th>
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
    
    $('#tabelAgenda').DataTable({
      "ordering": false,
      "processing": true,
      "serverSide": true,
      "responsive": false, 
      "lengthChange": false, 
      "autoWidth": false,
      "ajax": "/agenda/api_index?tahun={{ request()->get('tahun') }}&bulan={{ request()->get('bulan') }}&user_id={{ Auth::user()->id }}",
      "rowsGroup": [0],
      'createdRow': function( row, data, dataIndex ) {
          $(row).attr('id', data.uuid);
          rowHightlight = $('#uuid_agenda_hightlight').val();
          console.log(rowHightlight);
          if (data.uuid == rowHightlight) {
            $(row).attr('class', 'hightlighting');
          }
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
            "mData": "judul_kegiatan",
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
            "mData": "catatan",
            "mRender": function (data, type, row) {
              catatan = lokasi = '';

              if (row.catatan) {
                catatan = row.catatan+'<br>';
              }

              if (row.lokasi) {
                lokasi = 'Lokasi : '+row.lokasi;
              }

              if(row.judul != null){
                dokumen = row.judul;
                dokumens = '';
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
              showModalAgenda("{{ date('Y-m-d') }}",0);
            }
        }]
      }).buttons().container().appendTo('#tabelAgenda_wrapper .col-md-6:eq(0)');


       $('#tabelAgenda tbody').on( 'click', 'tr', function (evt) {
        $("#success-message").hide();
        $("#error-message").hide();
        showModalAgenda('',this.id);
        });

    $('#tabelAgenda_filter').css({'float':'right','display':'inline-block'});
</script>
{{-- include modal agenda --}}
@include('agenda.modal')
@endsection