@extends('layouts.template')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dokumen</h1>
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
            <th>Layanan</th>
            <th>Template</th>
            <th>Judul</th>
            <th>Status</th>
            </tr>
            </thead>
            <tbody>
            <tr id="1">
            <td>2 Januari 2022</td>
            <td>Hukum</td>
            <td>F-ADV-01 / 2 Jan 2020 / Rev. 3</td>
            <td>Dokumen konsultasi hukum kasus Eliza Thornberry</td>
            <td><span class="badge bg-warning">Tertaut</span></td>
            </tr>
            <tr id="2">
            <td>2 Januari 2022</td>
            <td>Hukum</td>
            <td>F-ADV-01 / 2 Jan 2020 / Rev. 3</td>
            <td>Dokumen konsultasi hukum kasus Eliza Thornberry</td>
            <td></td>
            </tr>
            <tr id="3">
            <td>2 Januari 2022</td>
            <td>Hukum</td>
            <td>F-ADV-01 / 2 Jan 2020 / Rev. 3</td>
            <td>Dokumen konsultasi hukum kasus Eliza Thornberry</td>
            <td><span class="badge bg-warning">Tertaut</span></td>
            </tr>
            <tr id="4">
            <td>2 Januari 2022</td>
            <td>Hukum</td>
            <td>F-ADV-01 / 2 Jan 2020 / Rev. 3</td>
            <td>Dokumen konsultasi hukum kasus Eliza Thornberry</td>
            <td><span class="badge bg-warning">Tertaut</span></td>
            </tr>
            <tr id="5">
            <td>2 Januari 2022</td>
            <td>Hukum</td>
            <td>F-ADV-01 / 2 Jan 2020 / Rev. 3</td>
            <td>Dokumen konsultasi hukum kasus Eliza Thornberry</td>
            <td><span class="badge bg-warning">Tertaut</span></td>
            </tr>
            <tr id="6">
            <td>2 Januari 2022</td>
            <td>Hukum</td>
            <td>F-ADV-01 / 2 Jan 2020 / Rev. 3</td>
            <td>Dokumen konsultasi hukum kasus Eliza Thornberry</td>
            <td><span class="badge bg-warning">Tertaut</span></td>
            </tr>
            <tr id="7">
            <td>2 Januari 2022</td>
            <td>Hukum</td>
            <td>F-ADV-01 / 2 Jan 2020 / Rev. 3</td>
            <td>Dokumen konsultasi hukum kasus Eliza Thornberry</td>
            <td><span class="badge bg-warning">Tertaut</span></td>
            </tr>
            <tr id="8">
            <td>2 Januari 2022</td>
            <td>Hukum</td>
            <td>F-ADV-01 / 2 Jan 2020 / Rev. 3</td>
            <td>Dokumen konsultasi hukum kasus Eliza Thornberry</td>
            <td><span class="badge bg-warning"></span></td>
            </tr>
            <tr id="10">
            <td>2 Januari 2022</td>
            <td>Hukum</td>
            <td>F-ADV-01 / 2 Jan 2020 / Rev. 3</td>
            <td>Dokumen konsultasi hukum kasus Eliza Thornberry</td>
            <td><span class="badge bg-warning">Tertaut</span></td>
            </tr>
            <tr id="11">
            <td>2 Januari 2022</td>
            <td>Hukum</td>
            <td>F-ADV-01 / 2 Jan 2020 / Rev. 3</td>
            <td>Dokumen konsultasi hukum kasus Eliza Thornberry</td>
            <td><span class="badge bg-warning">Tertaut</span></td>
            </tr>
            <tr id="1">
            <td>2 Januari 2022</td>
            <td>Hukum</td>
            <td>F-ADV-01 / 2 Jan 2020 / Rev. 3</td>
            <td>Dokumen konsultasi hukum kasus Eliza Thornberry</td>
            <td><span class="badge bg-warning">Tertaut</span></td>
            </tr>
            </tbody>
            <tfoot>
            <tr>
            <th>Tanggal</th>
            <th>Layanan</th>
            <th>Detail Layanan</th>
            <th>Judul</th>
            <th>Status</th>
            </tr>
            </tfoot>
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
        "responsive": false, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", 
              {
                className: "btn-success",
                text: 'Template',
                  action: function ( ) {
                    window.location.assign('{{ route("template") }}')
                  }
              },
              {
                className: "btn-info",
                text: 'Buat Dokumen',
                  action: function ( ) {
                    window.location.assign('{{ route("dokumen.add") }}')
                  }
              }]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });

    $('#example1 tbody').on( 'click', 'tr', function () {
        alert('redirect ke : '+this.id);
        window.location.assign('{{ route("dokumen.add") }}')
    } );
  </script>
@endsection