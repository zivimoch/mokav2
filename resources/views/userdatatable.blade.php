@extends('layouts.template')

@section('content')
    <!-- Scripts -->
    <!-- Page Heading -->
    <table id="example1" class="table table-sm table-bordered  table-hover" style="cursor:pointer">
        
        <thead>
        <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Email</th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>

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
            

    $(document).ready(function () {
        $('#example1').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('dashboard.datatables') }}",
            "columns": [
                {"data": "id"},
                {"data": "name"},
                {"data": "email"}
            ],
            lengthMenu: [
                [10, 25, 50, 100, -1],
                ['10 rows', '25 rows', '50 rows', '100 rows','All'],
            ],
            dom: 'Bfrtip', // Blfrtip or Bfrtip
            buttons: ["pageLength", "copy", "csv", "excel", "pdf", "print", "colvis"]
        });
    });
</script>

@endsection