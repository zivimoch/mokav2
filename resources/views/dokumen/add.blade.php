@extends('layouts.template')

@section('content')
<?php
if (isset($alert) and $alert <> '') {
    echo $alert;
    unset($alert);
}
?>

<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
    <div class="col-sm-6">
    <h1>Buat Dokumen</h1>
    </div>
    <div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item active">Detail Kasus</li>
    </ol>
    </div>
    </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">

<div class="col-md-12 col-sm-12 col-12">
    <h4>Pilih template</h4>
</div>

<div class="col-md-12 col-sm-12 col-12">
    <div class="form-group">
        <input type="text" id="Search" class="form-control" onkeyup="search()" placeholder="Cari template atau kategori...">
    </div>
</div>
{{-- foreach --}}
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
                <table data-order="[]" class="table table-bordered table-striped">
                    <?php 
                    // foreach ($template as $key2) {
                    //     if ($key2['kategori'] == $key['kategori']) {
                    ?>
                            <tr>
                                <td>
                                    <a href="{{ route('dokumen.create') }}">
                                        <div style="height:100%;width:100%">[F-ADV-02] Laporan Hasil Pendampingan Di Pengadilan
                                        </div>
                                    </a>
                                </td>
                            </tr>
                    <?php
                    //     }
                    // } 
                    ?>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
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
                <table data-order="[]" class="table table-bordered table-striped">
                    <?php 
                    // foreach ($template as $key2) {
                    //     if ($key2['kategori'] == $key['kategori']) {
                    ?>
                            <tr>
                                <td>
                                    <a href="{{ route('dokumen.createpsi') }}">
                                        <div style="height:100%;width:100%">[F-PSI-01] Laporan Hasil Psikologi (STIPS)
                                        </div>
                                    </a>
                                </td>
                            </tr>
                    <?php
                    //     }
                    // } 
                    ?>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
{{-- endforeach --}}
</div>
</section>
<script type="text/javascript">
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