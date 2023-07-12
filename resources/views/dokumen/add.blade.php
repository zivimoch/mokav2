@extends('layouts.template')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0"><i class="nav-icon fas fa-file-alt"></i> Buat Dokumen</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <a href="http://localhost/suratresmi/template/add" class="btn btn-success float-right">
            <i class="far fa-copy"></i> Blank Template
        </a>
      </div><!-- /.col -->
    </div><!-- /.row -->
</div>
<!-- /.content-header -->
    <div class="col-md-12 col-sm-12 col-12">
        <h4>Pilih template</h4>
    </div>
    <div class="form-group">
        <input type="text" id="Search" class="form-control" onkeyup="search()" placeholder="Cari template atau kategori...">
    </div>
<div class="row">
    @foreach ($template as $item)
    <div class="col-md-4 target" data-toggle="tooltip" data-placement="bottom" title="{{ $item->nama_template }}">
        <a href="{{ route('dokumen.create') }}?uuid={{ $item->uuid }}">
            <div class="info-box" style="text-decoration: inherit;color: black;">
            <span class="info-box-icon bg-info"><i class="far fa-copy"></i></span>
            <div class="info-box-content">
            <span class="info-box-text" style="font-size:15px">{{ $item->nama_template }}</span>
            <span class="info-box-number" style="margin-top: -5px; font-size:13px">{{ $item->pemilik }}</span>
            <span style="margin-top: -5px; font-size:10px">Created by {{ $item->name }}</span>
            <span style="margin-top: -5px; font-size:10px">Created at {{ $item->created_at }}</span>
            <span style="margin-top: -5px; font-size:10px">Modified at {{  $item->updated_at }}
            </div>
            </div>
        </a>
    </div>
    @endforeach
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
  </script>
@endsection