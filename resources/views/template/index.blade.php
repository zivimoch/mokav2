@extends('layouts.template')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Template</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <a href="http://localhost/suratresmi/template/add" class="btn btn-success float-right">
            <i class="fa fa-plus"></i> Buat Template
        </a>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="col-md-12 col-sm-12 col-12">
    <div class="form-group">
        <input type="text" id="Search" class="form-control" onkeyup="search()" placeholder="Cari template atau kategori...">
    </div>
</div>


    <div class="col-md-12">
        <div class="card collapsed-card target">
            <div class="card-header" data-card-widget="collapse" style="cursor: pointer;">
                <h3 class="card-title">Surat Tugas</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool"><i class="fa fa-chevron-down"></i>
                    </button>
                </div>
                <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table data-order="[]" class="NormalTable table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nama Template</th>
                            <th>Kategori</th>
                            <th>Dibuat Oleh</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                                                        <tr>
                                    <td>Perjanjian Pengadaan Barang Tanpa Dp</td>
                                    <td>Purchasing</td>
                                    <td>Sumarno</td>
                                    <td><a href='./template/edit/P58wnxXw' title="Edit">edit</a> | <a href='./template/delete/P58wnxXw' title="Trash" onClick="return confirm('Anda yakin akan menghapus?')">delete</a></td>
                                </tr>
                                            </tbody>
                    <tfoot>
                        <tr>
                            <th>Nama Template</th>
                            <th>Kategori</th>
                            <th>Dibuat Oleh</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <div class="col-md-12">
        <div class="card collapsed-card target">
            <div class="card-header" data-card-widget="collapse" style="cursor: pointer;">
                <h3 class="card-title">Psikolog</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool"><i class="fa fa-chevron-down"></i>
                    </button>
                </div>
                <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table data-order="[]" class="NormalTable table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nama Template</th>
                            <th>Kategori</th>
                            <th>Dibuat Oleh</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                                                        <tr>
                                    <td>[F-PSI-01] Laporan Hasil Psikologi (STIPS)</td>
                                    <td>Psikolog</td>
                                    <td>Koordinator Psikolog</td>
                                    <td><a href='{{ route('template.createpsi') }}' title="Edit">edit</a> | <a href='./template/delete/x7zS2734' title="Trash" onClick="return confirm('Anda yakin akan menghapus?')">delete</a></td>
                                </tr>
                                            </tbody>
                    <tfoot>
                        <tr>
                            <th>Nama Template</th>
                            <th>Kategori</th>
                            <th>Dibuat Oleh</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <div class="col-md-12">
        <div class="card collapsed-card target">
            <div class="card-header" data-card-widget="collapse" style="cursor: pointer;">
                <h3 class="card-title">Hukum</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool"><i class="fa fa-chevron-down"></i>
                    </button>
                </div>
                <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table data-order="[]" class="NormalTable table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nama Template</th>
                            <th>Kategori</th>
                            <th>Dibuat Oleh</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                                                        <tr>
                                    <td>Nah Ini Bener</td>
                                    <td>Marketing</td>
                                    <td>Indraco</td>
                                    <td><a href='./template/edit/x7zS2734' title="Edit">edit</a> | <a href='./template/delete/x7zS2734' title="Trash" onClick="return confirm('Anda yakin akan menghapus?')">delete</a></td>
                                </tr>
                                            </tbody>
                    <tfoot>
                        <tr>
                            <th>Nama Template</th>
                            <th>Kategori</th>
                            <th>Dibuat Oleh</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
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

<script>
    // Javascript Serch saat pilih template buat dokumen
    function search() {
        var input = document.getElementById("Search");
        var filter = input.value.toLowerCase();
        var nodes = document.getElementsByClassName('target');

        for (i = 0; i < nodes.length; i++) {
            if (nodes[i].innerText.toLowerCase().includes(filter)) {
                nodes[i].style.display = "block";
            } else {
                nodes[i].style.display = "none";
            }
        }
    }
    $(function() {

//Datemask dd/mm/yyyy
$('#datemask').inputmask('dd/mm/yyyy', {
    'placeholder': 'dd/mm/yyyy'
})

$("table.NormalTable").DataTable({
    "responsive": true,
    "autoWidth": false,
});
$("#example1").DataTable({
    "responsive": true,
    "autoWidth": false,
});
$('#example2').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": false,
    "info": true,
    "autoWidth": false,
    "responsive": true,
});
});
//Bootstrap Duallistbox
$('.duallistbox').bootstrapDualListbox()
  </script>
@endsection