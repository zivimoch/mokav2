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
                    <img src="https://mokapppa.jakarta.go.id/storage/institusi/Hrza2eMQa3OMALtbc7vtdYLShrZAsWSMbvlBgThU.png" style="width:100px;margin:30px 0px 20px 0px;"/>
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

            <table class="table" style="width:100%;">
                <tr>
                    <td colspan="4">1. Saya yang bertandatangan dibawah ini setuju / tidak setuju untuk melakukan penanganan atas diri saya / anak keluarga saya : </td>
                </tr>
                <tr>
                    <td style="width: 20%;">Nama Korban</td>
                    <td style="width: 20px;">:</td>
                    <td>{{ $klien->nama }}</td>
                </tr> 
                <!-- <tr>
                    <td style="width: 20%;">Petugas</td>
                    <td style="width: 20px;">:</td>
                    <td><input type="text" class="form-control" value="" disabled /></td>
                </tr>   -->
                <tr>
                    <td style="width: 20%;">Alamat</td>
                    <td style="width: 20px;">:</td>
                    <td>{{ $persetujuan_isi->alamat }}</td>
                </tr>
                <tr>
                    <td style="width: 20%;">Telp</td>
                    <td style="width: 20px;">:</td>
                    <td>{{ $persetujuan_isi->no_telp }}</td>
                </tr>
            </table>
            <table class="table">
            <?php $statement = $persetujuan_isi->isi ? json_decode($persetujuan_isi->isi) : [];?>
                @foreach($persetujuan_item as $p)
                <tr>
                    <td {!! $p->fillable != 1 ? 'colspan="3"' : '' !!}>{{ $p->item }}</td>
                    @if( $p->fillable )
                    <td style="width: 10%;">
                        <div class="checkboxgroup">
                            <input type="radio" id="statement[{{ $p->id }}][yes]" name="statement[{{ $p->id }}]" value="1" checked />
                            <label for="statement[{{ $p->id }}][yes]">Setuju</label>
                        </div>
                    </td>
                    <td style="width: 10%;">
                        <div class="checkboxgroup">
                            <input type="radio" id="statement[{{ $p->id }}][no]" name="statement[{{ $p->id }}]" value="0" />
                            <label for="statement[{{ $p->id }}][no]">Tidak Setuju</label>
                        </div>
                    </td>
                    @endif
                </tr>
                    @if ( count($p->children) > 0 )
                    @foreach($p->children as $c)
                    <tr>
                        <td {!! $c->fillable != 1 ? 'colspan="3"' : '' !!} style="padding-left:3%;">{{ $c->item }}</td>
                        @if( $c->fillable )
                        <td style="width: 20%;">
                            <strong>
                                @if (in_array($c->id, $statement->setuju))
                                    SETUJU
                                @elseif (in_array($c->id, $statement->tidak_setuju))
                                    TIDAK SETUJU
                                @else
                                    -
                                @endif 
                            </strong>
                        </td>
                        @endif
                    </tr>
                        @if ( count($c->children) > 0 )
                        @foreach($c->children as $d)
                        <tr>
                            <td {!! $d->fillable != 1 ? 'colspan="3"' : '' !!} style="padding-left:6%;">{{ $d->item }}</td>
                            @if( $d->fillable )
                            <td style="width: 20%;">
                                <strong>
                                    @if (in_array($d->id, $statement->setuju))
                                        SETUJU
                                    @elseif (in_array($d->id, $statement->tidak_setuju))
                                        TIDAK SETUJU
                                    @else
                                        -
                                    @endif 
                                </strong>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                        @endif
                    @endforeach
                    @endif

                @endforeach
               
            </table>
        </div>
        <br/>
        <center>
            <div class="col-md-4 align-self-center">
                    <label class="" for="">Tanda Tangan:</label>
                    <div id="sig" >
                        <img src="{{ asset('img/tandatangan/'.$persetujuan_isi->tandatangan) }}" alt="">
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
</div>
{{-- tanda tangan / signature pad --}}

</body>