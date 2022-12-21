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
            {{-- <div class="card-header">
            <h3 class="card-title">DataTable with default features</h3>
            </div> --}}
            
            <div class="card-body" style="overflow-x: scroll">
            <table id="example1" class="table table-bordered  table-hover" style="cursor:pointer">
            <thead>
            <tr>
            <th>Sudah DiTL 2 | Belum DiTL 1</th>
            </tr>
            </thead>
            <tbody>
            <tr id="1">
            <td>
                <div class="d-flex w-100 justify-content-between">
                <h6 class="mb-1">Korban / Pelapor </h6>
                <small>2 hari lalu</small>
                </div>
                <p class="mb-1">Pelapor / Korban menyetujui laporan pengaduan. Silahkan tentukan Supervisor</p>
                <small>Dinda Rika Rahim (29) | </small>
            </td>
            </tr>
            <tr id="2">
                <td>
                    <div class="d-flex w-100 justify-content-between">
                    <h6 class="mb-1">Korban / Pelapor </h6>
                    <small>2 hari lalu</small>
                    </div>
                    <p class="mb-1">Pelapor / Korban menyetujui laporan pengaduan. Silahkan tentukan Supervisor</p>
                    <small>Dinda Rika Rahim (29) | </small>
                </td>
            </tr>
            <tr id="3">
                <td>
                    <div class="d-flex w-100 justify-content-between">
                    <h6 class="mb-1">Korban / Pelapor </h6>
                    <small>2 hari lalu</small>
                    </div>
                    <p class="mb-1">Pelapor / Korban menyetujui laporan pengaduan. Silahkan tentukan Supervisor</p>
                    <small>Dinda Rika Rahim (29) | </small>
                </td>
            </tr>
            </tbody>
            </table>
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
      $("#example1").DataTable({
        "responsive": false, "lengthChange": false, "autoWidth": false
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      
    });

    $('#example1 tbody').on( 'click', 'tr', function () {
        alert('redirect ke : '+this.id);
    } );
  </script>
@endsection