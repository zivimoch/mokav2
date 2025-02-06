<!doctype html>
<html lang="en">
<head>
    <title>Pernyataan Persetujuan Wali</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="icon" href="" >
    <style>
        body {
            background: #eee;
        }
        .container {
            background: #fff;
        }
        .wrapper {
            position: relative;
            width: 100%;
            max-width: 330px;
            height: 200px;
            -moz-user-select: none;
            -webkit-user-select: none;
            -ms-user-select: none;
            user-select: none;
            border: solid 1px #ddd;
            margin: 10px 0px;
        }

        .checkboxgroup{
            display:inline-block;
            text-align:center;
        }
        .checkboxgroup label {
            display:block;
        }
        
        .kbw-signature { width: 100%; height: 200px;}
        #sig canvas{
            width: 100% !important;
            height: auto;
            border-style: solid;
        }
    </style>    
<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap CSS CDN -->
<link
  rel="stylesheet"
  href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
/>
</head>
<body style="background-color:#eee">
@if ($persetujuan_isi->tandatangan)
<div class="container">
    <div class="row">
        @if (app('request')->input('success') == 1)
        <div class="alert alert-success alert-dismissible fade show col-md-12" role="alert">
            Konfirmasi anda telah kami terima. Harap menunggu informasi selanjutnya dari petugas mengenai tindak lanjut pengaduan anda. 
        </div>
        @endif
        <div class="col-md-12 text-center">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                <img src="https://mokapppa.jakarta.go.id/v2/img/favicon.png" style="width:100px;margin:30px 0px 20px 0px;"/>
                {{-- <img src="{{ asset('storage/institusi/'.$persetujuan->kasus->institusi->logo) }}" style="width:200px;margin:30px 0px 20px 0px;"/> --}}
                    <p>
                        <span style="font-weight:bold;text-transform: uppercase;">Pusat Perlindungan Perempuan dan Anak Provinsi DKI Jakarta</span><br/>
                        Jalan Raya Bekasi Timur KM.18, Jatinegara Kaum, Pulo Gadung, RT.7/RW.6, Jatinegara Kaum, Kec. Pulo Gadung, Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13930
                    </p>
                </div>
                <div class="col-md-12">
                    <hr style="border:solid 2px #000;"/>
                    <hr style="border:solid 1px #000;margin-top:-13px;"/>
                </div>
            </div>
        </div>
        
    </div>

    

    <div class="col-md-12">

        {{-- <table class="table" style="width:100%;">
            <tr>
                <td colspan="4">{{ $persetujuan_template->konten }}</td>
            </tr>
            <tr>
                <td style="width: 20%;">Nama Korban</td>
                <td style="width: 20px;">:</td>
                <td><input type="text" class="form-control" value="{{ $klien->nama }}" /></td>
            </tr> 
            <!-- <tr>
                <td style="width: 20%;">Petugas</td>
                <td style="width: 20px;">:</td>
                <td><input type="text" class="form-control" value="" disabled /></td>
            </tr>   -->
            <tr>
                <td style="width: 20%;">Alamat</td>
                <td style="width: 20px;">:</td>
                <td>
                    <textarea name="alamat" class="form-control required-field-agenda" id="alamat" required>{{ $klien->alamat }}</textarea>
                    <div class="invalid-feedback" id="valid-alamat">
                        Alamat wajib diisi.
                    </div>
                </td>
            </tr>
            <tr>
                <td style="width: 20%;">Telp</td>
                <td style="width: 20px;">:</td>
                <td>
                    <input type="number" name="no_telp" class="form-control required-field-agenda" id="no_telp" value="{{ $klien->no_telp }}" required/>
                    <div class="invalid-feedback" id="valid-no_telp">
                        Nomor Telpon wajib diisi.
                    </div>
                </td>
            </tr>
        </table> --}}

        <input type="text" class="form-control" value="{{ $klien->nama }}" hidden/>
        <textarea name="alamat" class="form-control required-field-agenda" id="alamat" hidden>{{ $klien->alamat }}</textarea>
        <input type="number" name="no_telp" class="form-control required-field-agenda" id="no_telp" value="{{ $klien->no_telp }}" hidden/>
        <td colspan="4">{{ $persetujuan_template->konten }}</td>
        <br>
        <br>
        <div class="post clearfix" style="color:black">
            <b>A. DATA KASUS</b>
            <table class="table table-bottom table-sm">
                <tr id="sumber_rujukan_kasus">
                    <td style="width: 200px">Rujukan</td>
                    <td style="width: 1%">:</td>
                    <td>
                        <span class="data_kasus">{{ $kasus->sumber_rujukan }}</span> 
                    </td>
                </tr>
                <tr id="media_pengaduan_kasus">
                    <td style="width: 200px">Media Pengaduan</td>
                    <td style="width: 1%">:</td>
                    <td>
                        <span class="data_kasus">{{ $kasus->media_pengaduan }}</span> 
                    </td>
                </tr>
                <tr id="sumber_informasi_kasus">
                    <td style="width: 200px">Sumber Informasi</td>
                    <td style="width: 1%">:</td>
                    <td>
                        <span class="data_kasus">{{ $kasus->sumber_informasi }}</span> 
                    </td>
                </tr>
                <tr id="tanggal_pelaporan_kasus">
                    <td style="width: 200px">Tanggal Pelaporan</td>
                    <td style="width: 1%">:</td>
                    <td>
                        <span class="data_kasus">
                            {{ $kasus->tanggal_pelaporan ? date('d M Y', strtotime($kasus->tanggal_pelaporan)) : '' }}
                        </span> 
                    </td>
                </tr>
                <tr id="tanggal_kejadian_kasus">
                    <td style="width: 200px">Tanggal Kejadian</td>
                    <td style="width: 1%">:</td>
                    <td>
                        <span class="data_kasus">
                            {{ $kasus->tanggal_kejadian ? date('d M Y', strtotime($kasus->tanggal_kejadian)) : '' }}
                            ({{ $kasus->perkiraan_tanggal_kejadian == 0 ? 'Bukan Perkiraan' : 'Perkiraan'}})
                        </span> 
                    </td>
                </tr>
                <tr id="kategori_lokasi_kasus">
                    <td style="width: 200px">Kategori Lokasi TKP</td>
                    <td style="width: 1%">:</td>
                    <td>
                        <span class="data_kasus">{{ isset($kasus->kategori_lokasi) ? $kasus->kategori_lokasi : 'TIDAK DIKETAHUI' }}</span> 
                    </td>
                </tr>
                <tr id="alamat_kasus">
                    <td style="width: 200px">Alamat TKP</td>
                    <td style="width: 1%">:</td>
                    <td>
                        <span class="data_kasus">{{ isset($kasus->alamat) ? $kasus->alamat : 'TIDAK DIKETAHUI' }}</span> 
                        <b>Provinsi</b> <span class="data_kasus">{{ isset($kasus->provinsi) ? $kasus->provinsi : 'TIDAK DIKETAHUI' }}</span>,
                        <b>Kota</b> <span class="data_kasus">{{ isset($kasus->kota) ? $kasus->kota : 'TIDAK DIKETAHUI' }}</span>, 
                        <b>Kecamatan</b> <span class="data_kasus">{{ isset($kasus->kecamatan) ? $kasus->kecamatan : 'TIDAK DIKETAHUI' }}</span>,
                        <b>Kelurahan</b> <span class="data_kasus">{{ isset($kasus->kelurahan) ? $kasus->kelurahan : 'TIDAK DIKETAHUI' }}</span>
                    </td>
                </tr>
                <tr id="ringkasan_kasus">
                    <td style="width: 200px">Ringkasan</td>
                    <td style="width: 1%">:</td>
                    <td><span class="data_kasus">{!! nl2br($kasus->ringkasan) !!}</span></td>
                </tr>
            </table>
        </div>

        <div class="post clearfix" style="color:black">
            <b id="anchor_pelaporan">B. IDENTITAS PELAPOR</b>
            <br>
                <table class="table table-bottom table-sm">
                    <tr id="nik_pelapor">
                        <td style="width: 200px">NIK</td>
                        <td style="width: 1%">:</td>
                        <td><span class="data_pelapor">{{ isset($pelapor->nik) ? $pelapor->nik : 'TIDAK DIKETAHUI' }}</span></td>
                    </tr>
                    <tr id="nama_pelapor">
                        <td style="width: 200px">Nama</td>
                        <td style="width: 1%">:</td>
                        <td><span class="data_pelapor">{{ $pelapor->nama }}</span></td>
                    </tr>
                    <tr id="tanggal_lahir_pelapor">
                        <td style="width: 200px">Tempat/Tgl Lahir</td>
                        <td style="width: 1%">:</td>
                        <td>
                            <span class="data_pelapor" id="tempat_lahir_pelapor">{{ isset($pelapor->tempat_lahir) ? $pelapor->tempat_lahir : 'TIDAK DIKETAHUI' }}</span> 
                            <span class="data_pelapor">
                                {{ $pelapor->tanggal_lahir ? date('d M Y', strtotime($pelapor->tanggal_lahir)) : 'TIDAK DIKETAHUI' }} {{ $pelapor->tanggal_lahir ? '('.Carbon\Carbon::parse($pelapor->tanggal_lahir)->age.' tahun)' : ' '}} 
                                ({{ $pelapor->perkiraan_tanggal_lahir == 0 ? 'Bukan Perkiraan' : 'Perkiraan'}})
                            </span> 
                        </td>
                    </tr>
                    <tr id="jenis_kelamin_pelapor">
                        <td style="width: 200px">Jenis Kelamin</td>
                        <td style="width: 1%">:</td>
                        <td>
                            <span class="data_pelapor">{{ $pelapor->jenis_kelamin }}</span> 
                        </td>
                    </tr>
                    <tr id="alamat_ktp_pelapor">
                        <td style="width: 200px">Alamat KTP</td>
                        <td style="width: 1%">:</td>
                        <td><span class="data_pelapor">{{ isset($pelapor->alamat_ktp) ? $pelapor->alamat_ktp : 'TIDAK DIKETAHUI' }}</span> 
                            <b>Provinsi</b> <span class="data_pelapor">{{ $pelapor->provinsi_ktp }}</span>,
                            <b>Kota</b> <span class="data_pelapor">{{ $pelapor->kota_ktp }}</span>, 
                            <b>Kecamatan</b> <span class="data_pelapor">{{ $pelapor->kecamatan_ktp }}</span>,
                            <b>Kelurahan</b> <span class="data_pelapor">{{ $pelapor->kelurahan_ktp }}</span>
                        </td>
                    </tr>
                    <tr id="alamat_pelapor">
                        <td style="width: 200px">Alamat Domisili</td>
                        <td style="width: 1%">:</td>
                        <td><span class="data_pelapor">{{ isset($pelapor->alamat) ? $pelapor->alamat : 'TIDAK DIKETAHUI' }}</span> 
                            <b>Provinsi</b> <span class="data_pelapor">{{ $pelapor->provinsi }}</span>,
                            <b>Kota</b> <span class="data_pelapor">{{ $pelapor->kota }}</span>, 
                            <b>Kecamatan</b> <span class="data_pelapor">{{ $pelapor->kecamatan }}</span>,
                            <b>Kelurahan</b> <span class="data_pelapor">{{ $pelapor->kelurahan }}</span>
                        </td>
                    </tr>
                    <tr id="agama_pelapor">
                        <td style="width: 200px">Agama</td>
                        <td style="width: 1%">:</td>
                        <td>
                            <span class="data_pelapor">{{ isset($pelapor->agama) ? $pelapor->agama : 'TIDAK DIKETAHUI' }}</span>
                        </td>
                    </tr>
                    <tr id="status_kawin_pelapor">
                        <td style="width: 200px">Status Perkawinan</td>
                        <td style="width: 1%">:</td>
                        <td>
                            <span class="data_pelapor">{{ isset($pelapor->status_kawin) ? $pelapor->status_kawin : 'TIDAK DIKETAHUI' }}</span>
                        </td>
                    </tr>
                    <tr id="pekerjaan_pelapor">
                        <td style="width: 200px">Pekerjaan</td>
                        <td style="width: 1%">:</td>
                        <td>
                            <span class="data_pelapor">{{ isset($pelapor->pekerjaan) ?  $pelapor->pekerjaan : 'TIDAK DIKETAHUI' }}</span>
                        </td>
                    </tr>
                    <tr id="kewarganegaraan_pelapor">
                        <td style="width: 200px">Kewarganegaraan</td>
                        <td style="width: 1%">:</td>
                        <td>
                            <span class="data_pelapor">{{ isset($pelapor->kewarganegaraan) ? $pelapor->kewarganegaraan : 'TIDAK DIKETAHUI' }}</span>
                        </td>
                    </tr>
                    <tr id="pendidikan_pelapor">
                        <td style="width: 200px">Pendidikan</td>
                        <td style="width: 1%">:</td>
                        <td>
                            <span class="data_pelapor">{{ isset($pelapor->pendidikan) ? $pelapor->pendidikan : 'TIDAK DIKETAHUI' }}</span>
                            (<span class="data_pelapor">{{ isset($pelapor->status_pendidikan) ? $pelapor->status_pendidikan : 'TIDAK DIKETAHUI' }}</span>
                            )
                        </td>
                    </tr>
                    <tr id="no_telp_pelapor">
                        <td style="width: 200px">No Telp</td>
                        <td style="width: 1%">:</td>
                        <td>
                            <span class="data_pelapor">{{ isset($pelapor->no_telp) ? $pelapor->no_telp : 'TIDAK DIKETAHUI' }}</span> 
                        </td>
                    </tr>
                    <tr id="hubungan_pelapor">
                        <td style="width: 200px">Hubungan dengan klien (Pelapor siapanya Klien?)</td>
                        <td style="width: 1%">:</td>
                        <td>
                            <span class="data_pelapor">{{ isset($klien->hubungan_pelapor) ? $klien->hubungan_pelapor : 'TIDAK DIKETAHUI' }}</span>
                        </td>
                    </tr>
                </table>
        </div>


        <div class="post clearfix" style="color:black">
            <b>C. IDENTITAS KORBAN</b>
            <table class="table table-bottom table-sm">
                <tr id="nik_klien">
                    <td style="width: 200px">NIK</td>
                    <td style="width: 1%">:</td>
                    <td><span class="data_klien">{{ isset($klien->nik) ? $klien->nik : 'TIDAK DIKETAHUI' }}</span></td>
                </tr>
                <tr id="nama_klien">
                    <td style="width: 200px">Nama</td>
                    <td style="width: 1%">:</td>
                    <td><span class="data_klien">{{ $klien->nama }}</span> </td>
                </tr>
                <tr id="tanggal_lahir_klien">
                    <td style="width: 200px">Tempat/Tgl Lahir</td>
                    <td style="width: 1%">:</td>
                    <td>
                        <span class="data_klien" id="tempat_lahir_klien">{{ isset($klien->tempat_lahir) ? $klien->tempat_lahir : 'TIDAK DIKETAHUI' }}</span> 
                        <span class="data_klien">
                            {{ $klien->tanggal_lahir ? date('d M Y', strtotime($klien->tanggal_lahir)) : '' }} ({{ $klien->tanggal_lahir ? Carbon\Carbon::parse($klien->tanggal_lahir)->age.' tahun' : ' '}})
                            ({{ $klien->perkiraan_tanggal_lahir == 0 ? 'Bukan Perkiraan' : 'Perkiraan'}})
                        </span> 
                    </td>
                </tr>
                <tr id="jenis_kelamin_klien">
                    <td style="width: 200px">Jenis Kelamin</td>
                    <td style="width: 1%">:</td>
                    <td>
                        <span class="data_klien">{{ $klien->jenis_kelamin }}</span> 
                    </td>
                </tr>
                <tr id="alamat_ktp_klien">
                    <td style="width: 200px">Alamat KTP</td>
                    <td style="width: 1%">:</td>
                    <td>
                        <span class="data_klien">{{ isset($klien->alamat_ktp) ? $klien->alamat_ktp : 'TIDAK DIKETAHUI' }}</span> 
                        <b>Provinsi</b> <span class="data_klien">{{ $klien->provinsi_ktp }}</span>,
                        <b>Kota</b> <span class="data_klien">{{ $klien->kota_ktp }}</span>, 
                        <b>Kecamatan</b> <span class="data_klien">{{ $klien->kecamatan_ktp }}</span>,
                        <b>Kelurahan</b> <span class="data_klien">{{ $klien->kelurahan_ktp }}</span>
                    </td>
                </tr>
                <tr id="alamat_klien">
                    <td style="width: 200px">Alamat Domisili</td>
                    <td style="width: 1%">:</td>
                    <td><span class="data_klien">{{ isset($klien->alamat) ? $klien->alamat : 'TIDAK DIKETAHUI' }}</span> 
                        <b>Provinsi</b> <span class="data_klien">{{ $klien->provinsi }}</span>,
                        <b>Kota</b> <span class="data_klien">{{ $klien->kota }}</span>, 
                        <b>Kecamatan</b> <span class="data_klien">{{ $klien->kecamatan }}</span>,
                        <b>Kelurahan</b> <span class="data_klien">{{ $klien->kelurahan }}</span>
                    </td>
                </tr>
                <tr id="agama_klien">
                    <td style="width: 200px">Agama</td>
                    <td style="width: 1%">:</td>
                    <td>
                        <span class="data_klien">{{ isset($klien->agama) ? $klien->agama : 'TIDAK DIKETAHUI' }}</span>
                    </td>
                </tr>
                <tr id="status_kawin_klien">
                    <td style="width: 200px">Status Perkawinan</td>
                    <td style="width: 1%">:</td>
                    <td>
                        <span class="data_klien">{{ isset($klien->status_kawin) ? $klien->status_kawin : 'TIDAK DIKETAHUI' }}</span>
                    </td>
                </tr>
                <tr id="pekerjaan_klien">
                    <td style="width: 200px">Pekerjaan</td>
                    <td style="width: 1%">:</td>
                    <td>
                        <span class="data_klien">{{ isset($klien->pekerjaan) ? $klien->pekerjaan : 'TIDAK DIKETAHUI' }}</span>
                    </td>
                </tr>
                <tr id="kewarganegaraan_klien">
                    <td style="width: 200px">Kewarganegaraan</td>
                    <td style="width: 1%">:</td>
                    <td>
                        <span class="data_klien">{{ isset($klien->kewarganegaraan) ? $klien->kewarganegaraan : 'TIDAK DIKETAHUI' }}</span>
                    </td>
                </tr>
                <tr id="pendidikan_klien">
                    <td style="width: 200px">Pendidikan</td>
                    <td style="width: 1%">:</td>
                    <td>
                        <span class="data_klien">{{ isset($klien->pendidikan) ? $klien->pendidikan : 'TIDAK DIKETAHUI' }}</span>
                        (<span class="data_klien">{{ $klien->status_pendidikan }}</span>)
                    </td>
                </tr>
                <tr id="no_telp_klien">
                    <td style="width: 200px">No Telp</td>
                    <td style="width: 1%">:</td>
                    <td>
                        <span class="data_klien">{{ isset($klien->no_telp) ? $klien->no_telp : 'TIDAK DIKETAHUI' }}</span> 
                    </td>
                </tr>
                <tr id="kedisabilitasan_klien">
                    <td style="width: 200px">Kedisabilitasan</td>
                    <td style="width: 1%">:</td>
                    <td>
                        <span class="data_klien">{{ isset($klien->kedisabilitasan) ? $klien->kedisabilitasan : 'TIDAK DIKETAHUI' }}</span>
                    </td>
                </tr>
            </table>
        </div>

        <div class="post clearfix" id="data_terlapor" style="color:black">
            <b>D. IDENTITAS TERLAPOR</b>
            <?php $no_terlapor = 1;?>
            @foreach ($terlapor as $item_terlapor)
            <br>
            <b> Terlapor {{ $no_terlapor }}</b>
                <table class="table table-bottom table-sm">
                    <tr id="nik_terlapor{{ $no_terlapor }}">
                        <td style="width: 200px">NIK</td>
                        <td style="width: 1%">:</td>
                        <td><span class="data_terlapor{{ $no_terlapor }}">{{ isset($item_terlapor->nik) ? $item_terlapor->nik : 'TIDAK DIKETAHUI'  }}</span></td>
                    </tr>
                    <tr id="nama_terlapor{{ $no_terlapor }}">
                        <td style="width: 200px">Nama</td>
                        <td style="width: 1%">:</td>
                        <td><span class="data_terlapor{{ $no_terlapor }}">{{ isset($item_terlapor->nama) ? $item_terlapor->nama : 'TIDAK DIKETAHUI' }}</span></td>
                    </tr>
                    <tr id="tempat_tanggal_lahir_terlapor{{ $no_terlapor }}">
                        <td style="width: 200px">Tempat/Tgl Lahir</td>
                        <td style="width: 1%">:</td>
                        <td>
                            <span class="data_terlapor{{ $no_terlapor }}" id="tempat_lahir_terlapor{{ $no_terlapor }}">{{ isset($item_terlapor->tempat_lahir) ? $item_terlapor->tempat_lahir : 'TIDAK DIKETAHUI' }}</span> 
                            <span class="data_terlapor{{ $no_terlapor }}">
                                {{ $item_terlapor->tanggal_lahir ? date('d M Y', strtotime($item_terlapor->tanggal_lahir)) : 'TIDAK DIKETAHUI' }} {{ $item_terlapor->tanggal_lahir ? '('.Carbon\Carbon::parse($item_terlapor->tanggal_lahir)->age.' tahun)' : ' '}}
                                ({{ $item_terlapor->perkiraan_tanggal_lahir == 0 ? 'Bukan Perkiraan' : 'Perkiraan'}})
                            </span> 
                        </td>
                    </tr>
                    <tr id="jenis_kelamin_terlapor{{ $no_terlapor }}">
                        <td style="width: 200px">Jenis Kelamin</td>
                        <td style="width: 1%">:</td>
                        <td>
                            <span class="data_terlapor{{ $no_terlapor }}">{{ $item_terlapor->jenis_kelamin }}</span> 
                        </td>
                    </tr>
                    <tr id="alamat_terlapor_ktp{{ $no_terlapor }}">
                        <td style="width: 200px">Alamat KTP</td>
                    <td style="width: 1%">:</td>
                    <td><span class="data_terlapor{{ $no_terlapor }}">{{ isset($item_terlapor->alamat_ktp) ? $item_terlapor->alamat_ktp : 'TIDAK DIKETAHUI' }}</span> 
                        <b>Provinsi</b> <span class="data_terlapor{{ $no_terlapor }}">{{ $item_terlapor->provinsi_ktp }}</span>,
                        <b>Kota</b> <span class="data_terlapor{{ $no_terlapor }}">{{ $item_terlapor->kota_ktp }}</span>, 
                        <b>Kecamatan</b> <span class="data_terlapor{{ $no_terlapor }}">{{ $item_terlapor->kecamatan_ktp }}</span>,
                        <b>Kelurahan</b> <span class="data_terlapor{{ $no_terlapor }}">{{ $item_terlapor->kelurahan_ktp }}</span>
                    </td>
                    </tr>
                    <tr id="alamat_terlapor{{ $no_terlapor }}">
                        <td style="width: 200px">Alamat Domisili</td>
                    <td style="width: 1%">:</td>
                    <td><span class="data_terlapor{{ $no_terlapor }}">{{ isset($item_terlapor->alamat) ? $item_terlapor->alamat : 'TIDAK DIKETAHUI' }}</span> 
                        <b>Provinsi</b> <span class="data_terlapor{{ $no_terlapor }}">{{ $item_terlapor->provinsi }}</span>,
                        <b>Kota</b> <span class="data_terlapor{{ $no_terlapor }}">{{ $item_terlapor->kota }}</span>, 
                        <b>Kecamatan</b> <span class="data_terlapor{{ $no_terlapor }}">{{ $item_terlapor->kecamatan }}</span>,
                        <b>Kelurahan</b> <span class="data_terlapor{{ $no_terlapor }}">{{ $item_terlapor->kelurahan }}</span>
                    </td>
                    </tr>
                    <tr id="agama_terlapor{{ $no_terlapor }}">
                        <td style="width: 200px">Agama</td>
                        <td style="width: 1%">:</td>
                        <td>
                            <span class="data_terlapor{{ $no_terlapor }}">{{ isset($item_terlapor->agama) ? $item_terlapor->agama : 'TIDAK DIKETAHUI' }}</span>
                        </td>
                    </tr>
                    <tr id="status_kawin_terlapor{{ $no_terlapor }}">
                        <td style="width: 200px">Status Perkawinan</td>
                        <td style="width: 1%">:</td>
                        <td>
                            <span class="data_terlapor{{ $no_terlapor }}">{{ isset($item_terlapor->status_kawin) ? $item_terlapor->status_kawin : 'TIDAK DIKETAHUI'  }}</span>
                        </td>
                    </tr>
                    <tr id="pekerjaan_terlapor{{ $no_terlapor }}">
                        <td style="width: 200px">Pekerjaan</td>
                        <td style="width: 1%">:</td>
                        <td>
                            <span class="data_terlapor{{ $no_terlapor }}">{{ isset($item_terlapor->pekerjaan) ? $item_terlapor->pekerjaan : 'TIDAK DIKETAHUI'  }}</span>
                        </td>
                    </tr>
                    <tr id="kewarganegaraan_terlapor{{ $no_terlapor }}">
                        <td style="width: 200px">Kewarganegaraan</td>
                        <td style="width: 1%">:</td>
                        <td>
                            <span class="data_terlapor{{ $no_terlapor }}">{{ isset($item_terlapor->kewarganegaraan) ? $item_terlapor->kewarganegaraan : 'TIDAK DIKETAHUI'  }}</span>
                        </td>
                    </tr>
                    <tr id="pendidikan_terlapor{{ $no_terlapor }}">
                        <td style="width: 200px">Pendidikan</td>
                        <td style="width: 1%">:</td>
                        <td>
                            <span class="data_terlapor{{ $no_terlapor }}">{{ isset($item_terlapor->pendidikan) ? $item_terlapor->pendidikan : 'TIDAK DIKETAHUI' }}</span>
                            (<span class="data_terlapor{{ $no_terlapor }}">{{ isset($item_terlapor->status_pendidikan) ? $item_terlapor->status_pendidikan : 'TIDAK DIKETAHUI' }}</span>)
                        </td>
                    </tr>
                    <tr id="no_telp_terlapor{{ $no_terlapor }}">
                        <td style="width: 200px">No Telp</td>
                        <td style="width: 1%">:</td>
                        <td>
                            <span class="data_terlapor{{ $no_terlapor }}">{{ isset($item_terlapor->no_telp) ? $item_terlapor->no_telp : 'TIDAK DIKETAHUI' }}</span> 
                        </td>
                    </tr>
                    <tr id="hubungan_terlapor{{ $no_terlapor }}">
                        <td style="width: 200px">Hubungan dengan klien (Terlapor siapanya Klien?)</td>
                        <td style="width: 1%">:</td>
                        <td>
                            <span class="data_terlapor{{ $no_terlapor }}">{!! isset($item_terlapor->hubungan_terlapor)  || env('mode_iso') ? $item_terlapor->hubungan_terlapor : '<span style="background-color:red;font-weight:bold; padding:5px; color:#fff">Perhatian! Hubungan Terlapor Dengan Klien Mohon Untuk Diisi</span>' !!}</span>
                        </td>
                    </tr>
                </table>
                <script>
                    $(document).ready(function () {
                        getkotkab('terlapor{{ $no_terlapor }}');
                    });
                </script>
                <?php $no_terlapor++;?>
            @endforeach
        </div>
    </div>
    <br/>
    <center>
        <div class="col-md-4 align-self-center">
                <label class="" for="">Tanda Tangan:</label>
                <div id="sig" >
                    <img src="{{ asset('img/tandatangan/ttd_klien/'.$persetujuan_isi->tandatangan) }}" alt="">
                </div>
                <div style="border: none; border-bottom: 2px solid black;">
                    {{ $persetujuan_isi->nama_penandatangan }}
                </div>
        </div>
    </center>
    <br/>
    <br/>
    <br/>
    <br/>
    </div>
@else
<div class="alert alert-danger alert-dismissible fade show col-md-12" role="alert">
    <center><h1> Menunggu Tanda Tangan</h1></center>
</div>
@endif
</div>

{{-- ini untuk notifikasi ketika diklik redirect --}}
<input type="hidden" id="notif_receiver" data-notif="{{ Request::get('notif') }}" value="{{ Request::get('notif') }}">
{{-- socket --}}
<script src="https://cdn.socket.io/4.0.1/socket.io.min.js" integrity="sha384-LzhRnpGmQP+lOvWruF/lgkcqD+WDVt9fU3H4BWmwP5u5LTmkUGafMcpZKNObVMLU" crossorigin="anonymous"></script>
<script>
    $(function() {
        // ketika di local
        socket = io(window.location.hostname+':'+3000);
        // ketika di server
        // socket = io(window.location.hostname,  {path: '/socket/socket.io'});

        // untuk notif2 dari action yang tidak menggunakan ajax alias reload halaman
        if ($('#notif_receiver').val()) {
        var notif_receiver = $('#notif_receiver').data('notif'); 
        socket.emit('notif_count', {
            receiver_id : notif_receiver
        });
        }
    });
</script>
</body>