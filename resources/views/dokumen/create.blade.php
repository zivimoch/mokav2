@extends('layouts.template')

@section('content')
<style type="text/css">
    .scroll-area {
        height: 800px;
        overflow-y: scroll;
    }

    .scroll-area::-webkit-scrollbar {
        width: 8px;
        background-color: #F5F5F5;
    }

    .scroll-area::-webkit-scrollbar-thumb {
        background-color: #555;
    }

    .editor {
        color: black;
    }

    #wzform fieldset:not(:first-of-type) {
        display: none
    }

    *[contenteditable="true"] {
        background-color: rgba(123, 211, 242, 0.5);
    }

    @media screen {
        @font-face {
            font-family: 'Cambria::Menu';
            font-style: normal;
            font-weight: normal;
            src: local('Cambria'), url('https://themes.googleusercontent.com/font?kit=FuCXqyJXTEEvujaBqOffUw') format('woff');
        }
    }
</style>
<link rel="stylesheet" type="text/css" href="{{ asset('source') }}/css/ckeditor.css">
<!-- daterange picker -->

<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
    <div class="col-sm-6">
    <h1><i class="nav-icon fas fa-file-alt"></i> Buat Dokumen</h1>
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

<div class="col-md-12">
    <!-- general form elements -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Buat Dokumen > <span class='titleFormOutput' id='titleFormOutput'></span></h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                </button>
            </div>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form method="POST" action="{{ route('dokumen.store') }}" role="form" id="wzform">
            @csrf
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('response') }}
            </div>
            @endif
            @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <b>GAGAL ! </b>
                <br>
                {{ session('response') }}
            </div>
            @endif
            <input type="text" name="uuid" class="form-control" value="{{ $template->uuid }}" hidden>
            <div class="card-body">
                <fieldset>
                    <script>
                        var span = document.getElementById("coba");
                        var tampil = document.getElementById("tampil");

                        function gfg_Run() {
                            tampil.innerHTML = span.textContent;
                        }
                    </script>
                    <div class="form-card">
                        <div class="form-group">
                            <label>Judul Dokumen</label>
                            <input type="text" name="judul" class="form-control" id="titleForm" value="">
                        </div>
                        <div class="form-group">
                            <label>Detail Template</label>
                            <div class="col-md-12" style="background-color:aliceblue; padding:10px">
                                <table>
                                    <tr>
                                        <td>
                                            Nama Template
                                        </td>
                                        <td>
                                            : {{ $template->nama_template }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Detail Kasus / Keyword
                                        </td>
                                        <td>
                                            : {{ $template->keyword }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Kepemilikan Template
                                        </td>
                                        <td>
                                            : {{ $template->pemilik }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Created by
                                        </td>
                                        <td>
                                            : {{ $template->name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Created at
                                        </td>
                                        <td>
                                            : {{ $template->created_at }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Modified at
                                        </td>
                                        <td>
                                            : {{ $template->updated_at }}
                                        </td>
                                    </tr>
                                </table>  
                            </div>
                        </div>
                    </div>

                    <input type="button" name="next" class="next action-button btn btn-primary" value="Selanjutnya" id="next1" disabled />
                </fieldset>
                <fieldset>
                    <div class="form-card">
                        <div class="form-group">

                            <body data-editor="DecoupledDocumentEditor" data-collaboration="false">
                                <main>
                                    <div class="centered">
                                        <div class="scroll-area">
                                            <div class="row-editor">
                                                <div class="form-control editor" id="preview">
                                                    <?php
                                                    $konten = json_decode($template->konten);
                                                    preg_match_all('/{{(.*?)}}/', $konten, $variable);

                                                    $a = array_unique($variable[0]);
                                                    foreach ($a as $item) {
                                                        $b = preg_replace('/{{(.*?)}}/is', "$1", $item);
                                                        if (strtolower(substr($b, 0, 9)) == 'loop_list') {
                                                            $konten = str_ireplace($item, '<span class="input-list input-' . $b . '" name="' . $b . '">' . $item . '</span>', $konten);
                                                        } else {
                                                            $konten = str_ireplace($item, '<span class="input-variable input-' . $b . '" name="' . $b . '" contentEditable="true">' . $item . '</span>', $konten);
                                                        }

                                                        $id_table = rand();
                                                        $konten = str_replace('<table class="editablecontent"', '<a href="#" onclick="addRow(' . $id_table . ')">[add row]</a><a href="#" onclick="deleteRow(' . $id_table . ')">[delete row]</a><table contenteditable="true" id="' . $id_table . '"', $konten);
                                                    }
                                                    echo $konten;
                                                    ?>
                                                </div>
                                                <textarea name="konten" id="konten" readonly hidden></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </main>
                            </body>
                        </div>
                    </div>
                    <input type="button" class="previous action-button-previous btn btn-primary" value="Kembali" />
                    <input type="button" class="next action-button btn btn-primary" value="Priview" id="next2" />
                </fieldset>
                <fieldset>
                    <div class="form-card">
                        <div class="form-group">

                            <body data-editor="DecoupledDocumentEditor" data-collaboration="false">
                                <main>
                                    <div class="centered">
                                        <div class="scroll-area">
                                            <div class="row-editor">
                                                <div class="form-control editor">
                                                    <?php
                                                    //replace contenteditable dan tombol tabel
                                                    $konten = str_replace('[add row]', '', $konten);
                                                    $konten = str_replace('[delete row]', '', $konten);
                                                    //hilangkan semua variable
                                                    $konten = preg_replace('/{{(.*?)}}/', '', $konten); ?>
                                                    <div id="last-priview"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </main>
                            </body>
                        </div>
                        <span id="msgbox"></span>
                    </div>
                    <input type="button" name="previous" class="previous action-button-previous btn btn-primary" value="Kembali" />
                    <input type="submit" class="btn btn-success" id="submit" value="Simpan" />
                </fieldset>
            </div>
            <!-- /.card-body -->
        </form>
    </div>
    <!-- /.card -->
</div>
<script src="{{ asset('source') }}/js/wizard.js"></script>
<script src="{{ asset('source') }}/js/main.js"></script>
<script src="{{ asset('source') }}/js/replacetemplate.js"></script>
@endsection