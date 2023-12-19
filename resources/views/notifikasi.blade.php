@extends('layouts.template')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Notifikasi</h1>
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
          <ul class="nav nav-tabs nav-justified" id="custom-content-below-tab" role="tablist">
            <li class="nav-item">
            <a class="nav-link active" id="custom-content-below-home-tab" style="color : black" data-toggle="pill" href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Task</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" id="custom-content-below-profile-tab" style="color : black" data-toggle="pill" href="#custom-content-below-profile" role="tab" aria-controls="custom-content-below-profile" aria-selected="false">Notification</a>
            </li>
            </ul>
            <div class="tab-content" id="custom-content-below-tabContent">
            <div class="tab-pane fade show active" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
              <div class="card-body" style="overflow-x: scroll">
                <table id="tabelTask" class="table table-bordered  table-hover" style="cursor:pointer">
                <thead>
                <tr>
                <th>Seluruh Task</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
                </table>
              </div>
            </div>
            <div class="tab-pane fade" id="custom-content-below-profile" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">
              <div class="tab-pane fade show active" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
                <div class="card-body" style="overflow-x: scroll">
                  <table id="tabelNotif" class="table table-bordered  table-hover" style="cursor:pointer">
                  <thead>
                  <tr>
                  <th>Seluruh Notification</th>
                  </tr>
                  </thead>
                  <tbody>
                  </tbody>
                  </table>
                </div>
              </div>
            </div>
            </div>         
          </div>
      </div><!-- /.container-fluid -->
    </section>
    {{-- DataTable --}}


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

<script>
   $(function () {

    $('#tabelTask').DataTable({
      "ordering": true,
      "processing": true,
      "serverSide": true,
      "responsive": false, 
      "lengthChange": false, 
      "autoWidth": false,
      "ajax": '{{ route("notifikasi.pull_all") }}?tipe=task',
      "columns": [
        {
            "mData": "message",
            "mRender": function (data, type, row) {
              belum_tl = '';
              if (row.read == 0) {
                belum_tl = '<span style="background-color:red; color : #fff; font-size:13px; padding:3px"><b>belum di TL</b></span>';
              }

              konten = "<a href=\""+row.url+"\" style=\"color:black\"><div class=\"d-flex w-100 justify-content-between\"><h6 class=\"mb-1\">"+row.name+" </h6><small>"+row.formattedDate+"<div>"+belum_tl+"</div></small></div><p class=\"mb-1\">"+row.message+"</p><small>"+row.kasus+" | "+row.no_reg+"</small></div>";

              return konten;
            }
        }
      ],
      "pageLength": 10,
      "lengthMenu": [
          [10, 25, 50, 100, -1],
          ['10 rows', '25 rows', '50 rows', '100 rows','All'],
      ],
      "dom": 'Blfrtip', // Blfrtip or Bfrtip
      "buttons": ["pageLength", "copy", "csv", "excel", "pdf", "print", 
              {
                className: "btn-info",
                text: 'Refresh',
                  action: function ( ) {
                    $('#tabelTask').DataTable().ajax.reload();
                  }
              }]
      }).buttons().container().appendTo('#tabelTask_wrapper .col-md-6:eq(0)');

      $('#tabelTask_filter').css({'float':'right','display':'inline-block; background-color:black'});

    $('#tabelNotif').DataTable({
      "ordering": true,
      "processing": true,
      "serverSide": true,
      "responsive": false, 
      "lengthChange": false, 
      "autoWidth": false,
      "ajax": '{{ route("notifikasi.pull_all") }}?tipe=notif',
      "columns": [
        {
            "mData": "message",
            "mRender": function (data, type, row) {
              belum_tl = '';
              if (row.read == 0) {
                belum_tl = '<span style="background-color:red; color : #fff; font-size:13px; padding:3px"><b>belum di TL</b></span>';
              }

              konten = "<a href=\""+row.url+"\" style=\"color:black\"><div class=\"d-flex w-100 justify-content-between\"><h6 class=\"mb-1\">"+row.name+" </h6><small>"+row.formattedDate+"<div>"+belum_tl+"</div></small></div><p class=\"mb-1\">"+row.message+"</p><small>"+row.kasus+" | "+row.no_reg+"</small></div>";

              return konten;
            }
        }
      ],
      "pageLength": 10,
      "lengthMenu": [
          [10, 25, 50, 100, -1],
          ['10 rows', '25 rows', '50 rows', '100 rows','All'],
      ],
      "dom": 'Blfrtip', // Blfrtip or Bfrtip
      "buttons": ["pageLength", "copy", "csv", "excel", "pdf", "print", 
              {
                className: "btn-info",
                text: 'Refresh',
                  action: function ( ) {
                    $('#tabelNotif').DataTable().ajax.reload();
                  }
              }]
      }).buttons().container().appendTo('#tabelNotif_wrapper .col-md-6:eq(0)');

      $('#tabelNotif_filter').css({'float':'right','display':'inline-block; background-color:black'});

    });
  </script>
@endsection