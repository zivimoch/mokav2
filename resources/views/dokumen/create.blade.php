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
<link rel="stylesheet" href="assets/adminlte/plugins/daterangepicker/daterangepicker.css">

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
        <form onsubmit="return checknomordokumen();" method="POST" action="surat/save/add" role="form" id="wzform">
            <?php
            if (isset($alert) and $alert <> '') {
                echo $alert;
                unset($alert);
            }
            ?>
            <input type="text" name="id_template" class="form-control" value="" hidden>
            <input type="text" name="kategori" class="form-control" value="" hidden>
            <input type="text" name="kodeSurat" class="form-control" value="" hidden>
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
                            <label>Nama Dokumen</label>
                            <input type="text" name="judul_surat" class="form-control" id="titleForm" value="">
                        </div>
                        {{-- <div class="form-group">
                            <label>Kode Agenda</label>
                            <input type="text" name="judul_surat" class="form-control" id="titleForm" value="">
                        </div> --}}
                    </div>

                    {{-- <div class="form-group">
                        <label>Setting Expired Dokumen</label>
                        <div class="card collapsed-card target">
                            <div class="card-header" data-card-widget="collapse" style="cursor: pointer;">
                                <span>*kosongkan bila tidak perlu</span>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool"><i class="fa fa-chevron-down"></i>
                                    </button>
                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Pilih Tanggal Expired:</label>
                                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                        <input type="date" class="form-control" name="expired" />
                                    </div>
                                    <label>Ingatkan Berapa Hari Sebelum Expired</label>
                                    <select name="remind" class="form-control select2" style="width: 100%;">
                                        <option value="0">Pilih Berapa Hari</option>
                                        <option value="3">3 Hari</option>
                                        <option value="7">7 Hari</option>
                                        <option value="30">30 Hari</option>
                                    </select>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div> --}}
                    <?php
                    // if (isset($template['levels'])) {
                    //     echo "Dokumen yang dibuat dengan template ini harus diapprove oleh : " . $template['levels'] . "</br>";
                    // }
                    ?>
                    <input type="text" class="input-replace form-control" id="nomordokumen" name="nomordokumen" hidden>

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
                                                    $konten = '<center>
                                                    <p style="text-align: center;"><span style="font-family: arial, helvetica, sans-serif;"><strong><img src="data:image/png;base64,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GBhAEMTT01MqlV69enVyctLLy4vL5QKLuJO+T2A9dDodKhY2b96s1+v37ds3Nja2evVqi8Vy6tQplUrFYrFWrFixePFiYCILXMD5NDk5qVQqEaePEwJvEDn93XHCGvN4vNdff/3HH3/829/+hmEYhJZGRkba29vb2tp4PN7Fixd9fHxkMplKpZJIJJASmJycbLVaIXXodwe5UOzMZjMwncnJyd27d6emphYUFCQkJJSXl9fX1zMYDH9/f4lEsmzZsrCwsEOHDhUWFnI4HMQlSHRLBMYW4sy+gV8XsoUJztJqh8Ph7u6+cePGgICA7777rre39+TJk1wuNz8///Lly3l5eWQymcFgyOXynTt3xsfHg1NWqVRSqdQ7LGeBrFYrj8drb29/4oknBALB4sWLc3JyysvLNRrN7t27BwYGfv31148++igjI+Phhx92LXG+LrmGqVx1QHA9QezGNTbmGtBArrU65/jiURSF2y0WS3Z2dnx8fH9/v16v53K53d3dTU1NMzMzJBIpNTV106ZNLBZraGgIkgEhroan0dwZ7PDkUzqd/sILL4yPj1+5cqW/v7+5uZlMJisUirNnz/78889yuZzFYi1btozFYuFTvZFuDBeAueq6p+DI4O4AvDRrzr03GioujkG/sdls09PTgYGBUGpVWFi4YsWK0tLS8vLyrVu3GgyG6enpkJAQyAG0Wq133XVXbW3tQmT6LcQrcO9gTEzMjh07QkJCiESiUqn08PDw9vaWSqWjo6MkEikrKys3N7etrW1mZsaV388nh0sVmsOFbDZbT08PnosHO6ijowMAnU+uzye4EEhqhUIBsW0/Pz8vLy+5XD48PEwmk7VaLUhz8A7gVSlAC8HkFmQFHKXx8XGozfniiy8++eSTxsZGLpcbGRnZ398fHBx811135eXllZWVSaXSv/71r6iz6OJG6wFKHMElggHvEgqF27ZtQ5zGLIIg4Je+7qxu9HwMw6xWq9lsDggIgFVnMpksFstgMJw8eRJSOCBrAE8aslgsQ0NDc5jDH8UOX0awK2ZnZ5OSkrZs2VJSUtLa2vrVV1898MAD27dvr6ur++CDD1pbW1evXs1isQCdG+1/hULxt7/9TavVuru7gwWKI4U7u+AvVCp1amrqueeew61jh0uu57Jly0pKSpBri9xhS0Lat9lsptPp8FJIRVWpVHQ6nUgk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" /></strong></span></p>
                                                    <p style="text-align: center;"><span style="font-family: arial, helvetica, sans-serif;"><strong>PUSAT PELAYANAN TERPADU PEMBERDAYAAN PEREMPUAN DAN ANAK</strong></span><br /><span style="font-family: arial, helvetica, sans-serif;"><strong>DINAS PEMBERDAYAAN, PERLINDUNGAN ANAK DAN PENGENDALIAN</strong></span><br /><span style="font-family: arial, helvetica, sans-serif;"><strong>PENDUDUK PROVINSI DAERAH KHUSUS {{kota}}</strong></span></p>
                                                    <table style="width: 100%; border-collapse: collapse; height: 36px;" border="0">
                                                    <tbody>
                                                    <tr style="height: 36px;">
                                                    <td style="width: 25.8437%; text-align: right; height: 36px;"><span style="font-family: arial, helvetica, sans-serif;"><strong>&nbsp;</strong></span></td>
                                                    <td style="width: 47.2222%; height: 36px; text-align: center;"><span style="font-family: arial, helvetica, sans-serif;"><strong>SURAT TUGAS<br />NOMOR {{nomordokumen}}&nbsp;</strong></span></td>
                                                    <td style="width: 26.934%; height: 36px;"><img src="data:image/png;base64,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" /></td>
                                                    </tr>
                                                    </tbody>
                                                    </table>
                                                    <p style="text-align: center;"><span style="font-family: arial, helvetica, sans-serif;"><strong>TENTANG<br />MELAKSANAKAN TUGAS PENDAMPINGAN KLIEN AN. {{namaKlien}}<br />(NO.REG. {{nomordokumen}}) DUGAAN KASUS {{kategoriKasus}} DI<br />{{tempatKejadianPerkara}}</strong></span></p>
                                                    <p style="text-align: justify;"><span style="font-family: arial, helvetica, sans-serif;">Dalam rangka {{prihal}}, dengan ini Kepala Pusat Pelayanan Terpadu Pemberdayaan Perempuan dan Anak Provinsi DKI Jakarta,</span></p>
                                                    <p style="text-align: center;"><span style="font-family: arial, helvetica, sans-serif;">MENUGASKAN</span></p>
                                                    <p style="text-align: justify;"><span style="font-family: arial, helvetica, sans-serif;">Kepada :&nbsp;</span></p>
                                                    <table class="editablecontent" style="height: 72px; width: 100%; border-collapse: collapse;" border="0">
                                                    <tbody>
                                                    <tr style="height: 18px;">
                                                    <td style="width: 3.03033%; height: 18px;"><span style="font-family: arial, helvetica, sans-serif;">1.&nbsp;</span></td>
                                                    <td style="width: 10.3305%; height: 18px;"><span style="font-family: arial, helvetica, sans-serif;">Nama</span></td>
                                                    <td style="width: 3.44354%; height: 18px;"><span style="font-family: arial, helvetica, sans-serif;">:</span></td>
                                                    <td style="width: 83.1956%; height: 18px;"><span style="font-family: arial, helvetica, sans-serif;">{{namaPetugas1}}</span></td>
                                                    </tr>
                                                    <tr style="height: 18px;">
                                                    <td style="width: 3.03033%; height: 18px;">&nbsp;</td>
                                                    <td style="width: 10.3305%; height: 18px;"><span style="font-family: arial, helvetica, sans-serif;">Jabatan</span></td>
                                                    <td style="width: 3.44354%; height: 18px;"><span style="font-family: arial, helvetica, sans-serif;">:</span></td>
                                                    <td style="width: 83.1956%; height: 18px;"><span style="font-family: arial, helvetica, sans-serif;">{{jabatanPetugas1}}</span></td>
                                                    </tr>
                                                    <tr style="height: 18px;">
                                                    <td style="width: 3.03033%; height: 18px;"><span style="font-family: arial, helvetica, sans-serif;">2.</span></td>
                                                    <td style="width: 10.3305%; height: 18px;"><span style="font-family: arial, helvetica, sans-serif;">Nama</span></td>
                                                    <td style="width: 3.44354%; height: 18px;"><span style="font-family: arial, helvetica, sans-serif;">:</span></td>
                                                    <td style="width: 83.1956%; height: 18px;"><span style="font-family: arial, helvetica, sans-serif;">{{namaPetugas2}}</span></td>
                                                    </tr>
                                                    <tr style="height: 18px;">
                                                    <td style="width: 3.03033%; height: 18px;">&nbsp;</td>
                                                    <td style="width: 10.3305%; height: 18px;"><span style="font-family: arial, helvetica, sans-serif;">Jabatan</span></td>
                                                    <td style="width: 3.44354%; height: 18px;"><span style="font-family: arial, helvetica, sans-serif;">:</span></td>
                                                    <td style="width: 83.1956%; height: 18px;"><span style="font-family: arial, helvetica, sans-serif;">{{jabatanPetugas2}}</span></td>
                                                    </tr>
                                                    </tbody>
                                                    </table>
                                                    <p style="text-align: justify;"><span style="font-family: arial, helvetica, sans-serif;">&nbsp;Untuk :&nbsp;</span></p>
                                                    <p style="text-align: justify;"><span style="font-family: arial, helvetica, sans-serif;">1. Melaksanakan tugas pendampingan klien an. Arfi Putra Pratama (382/04/2022) Dugaan Kasus Tindak Pidana Perdagangan Orang yang dilaksanakan pada:</span></p>
                                                    <table class="editablecontent" style="height: 72px; width: 100%; border-collapse: collapse;" border="0">
                                                    <tbody>
                                                    <tr style="height: 18px;">
                                                    <td style="width: 8.81543%; height: 18px;"><span style="font-family: arial, helvetica, sans-serif;">hari&nbsp;</span></td>
                                                    <td style="width: 2.75482%; height: 18px;"><span style="font-family: arial, helvetica, sans-serif;">:</span></td>
                                                    <td style="width: 54.9587%; height: 18px;"><span style="font-family: arial, helvetica, sans-serif;">{{hari}}</span></td>
                                                    </tr>
                                                    <tr style="height: 18px;">
                                                    <td style="width: 8.81543%; height: 18px;"><span style="font-family: arial, helvetica, sans-serif;">tanggal</span></td>
                                                    <td style="width: 2.75482%; height: 18px;"><span style="font-family: arial, helvetica, sans-serif;">:</span></td>
                                                    <td style="width: 54.9587%; height: 18px;"><span style="font-family: arial, helvetica, sans-serif;">{{tanggal}}</span></td>
                                                    </tr>
                                                    <tr style="height: 18px;">
                                                    <td style="width: 8.81543%; height: 18px;"><span style="font-family: arial, helvetica, sans-serif;">waktu</span></td>
                                                    <td style="width: 2.75482%; height: 18px;"><span style="font-family: arial, helvetica, sans-serif;">:</span></td>
                                                    <td style="width: 54.9587%; height: 18px;"><span style="font-family: arial, helvetica, sans-serif;">{{waktu}}</span></td>
                                                    </tr>
                                                    <tr style="height: 18px;">
                                                    <td style="width: 8.81543%; height: 18px;"><span style="font-family: arial, helvetica, sans-serif;">tempat</span></td>
                                                    <td style="width: 2.75482%; height: 18px;"><span style="font-family: arial, helvetica, sans-serif;">:</span></td>
                                                    <td style="width: 54.9587%; height: 18px;"><span style="font-family: arial, helvetica, sans-serif;">{{tempat}}</span></td>
                                                    </tr>
                                                    </tbody>
                                                    </table>
                                                    <p style="text-align: justify;"><span style="font-family: arial, helvetica, sans-serif;">2. Melaporkan hasil pelaksanaan tugas kepada Kepala Pusat Pelayanan Terpadu Pemberdayaan Perempuan dan Anak Provinsi DKI Jakarta.</span></p>
                                                    <p style="text-align: center;"><span style="font-family: arial, helvetica, sans-serif;">Tugas ini agar dilaksanakan dengan sebaik-baiknya dan penuh tanggung jawab</span></p>
                                                    <table style="width: 100%; border-collapse: collapse;" border="0">
                                                    <tbody>
                                                    <tr>
                                                    <td style="width: 66.8044%;">&nbsp;</td>
                                                    <td style="width: 33.1956%;">
                                                    <p style="text-align: center;"><span style="font-family: arial, helvetica, sans-serif;">Dikeluarkan di Jakarta</span><br /><span style="font-family: arial, helvetica, sans-serif;">Pada {{tanggalTTD}}</span></p>
                                                    <p style="text-align: center;"><br /><span style="font-family: arial, helvetica, sans-serif;">Kepala Pusat Pelayanan Terpadu</span><br /><span style="font-family: arial, helvetica, sans-serif;">Pemberdayaan Perempuan danAnak</span><br /><span style="font-family: arial, helvetica, sans-serif;">Provinsi DKI Jakarta,</span></p>
                                                    <p style="text-align: center;"><span style="font-family: arial, helvetica, sans-serif;">&nbsp;</span></p>
                                                    <p style="text-align: center;"><span style="font-family: arial, helvetica, sans-serif;">&nbsp;</span></p>
                                                    <p style="text-align: center;"><span style="font-family: arial, helvetica, sans-serif;">{{namaPenandatangan}}</span></p>
                                                    <p style="text-align: center;"><span style="font-family: arial, helvetica, sans-serif;">{{NIP}}</span></p>
                                                    </td>
                                                    </tr>
                                                    </tbody>
                                                    </table>
                                                    </center>';
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
                    <input type="submit" class="btn btn-primary" id="submit" value="Save" />
                </fieldset>
            </div>
            <!-- /.card-body -->
        </form>
    </div>
    <!-- /.card -->
</div>
<script src="{{ asset('adminlte') }}/vendor/phpunit/php-code-coverage/src/Report/Html/Renderer/Template/js/jquery.min.js"></script>
<script src="{{ asset('source') }}/js/wizard.js"></script>
<script src="{{ asset('source') }}/js/main.js"></script>
<script src="{{ asset('adminlte') }}/assets/adminlte/plugins/moment/moment.min.js"></script>
<!-- date-range-picker -->
<script src="{{ asset('adminlte') }}/assets/adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="{{ asset('source') }}/js/replacetemplate.js"></script>
@endsection