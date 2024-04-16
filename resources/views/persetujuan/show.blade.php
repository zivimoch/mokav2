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
    <form action="{{ route('persetujuan.store') }}" method="post" id="form-submit">
        <input type="text" name="uuid" value="{{ Request::segment(3) }}" hidden>
        <div class="row">
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
                    <td colspan="4">{{ $persetujuan_template->konten }}</td>
                </tr>
                <tr>
                    <td style="width: 20%;">Nama Korban</td>
                    <td style="width: 20px;">:</td>
                    <td><input type="text" class="form-control" value="{{ $klien->nama }}" disabled /></td>
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
            </table>
            <table class="table">
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
                        <td style="width: 10%;">
                            <div class="checkboxgroup">
                                <input type="radio" id="statement[{{ $c->id }}][yes]" name="statement[{{ $c->id }}]" value="1" checked />
                                <label for="statement[{{ $c->id }}][yes]">Setuju</label>
                            </div>
                        </td>
                        <td style="width: 10%;">
                            <div class="checkboxgroup">
                                <input type="radio" id="statement[{{ $c->id }}][no]" name="statement[{{ $c->id }}]" value="0" />
                                <label for="statement[{{ $c->id }}][no]">Tidak Setuju</label>
                            </div>
                        </td>
                        @endif
                    </tr>
                        @if ( count($c->children) > 0 )
                        @foreach($c->children as $d)
                        <tr>
                            <td {!! $d->fillable != 1 ? 'colspan="3"' : '' !!} style="padding-left:6%;">{{ $d->item }}</td>
                            @if( $d->fillable )
                            <td style="width: 10%;">
                                <div class="checkboxgroup">
                                    <input type="radio" id="statement[{{ $d->id }}][yes]" name="statement[{{ $d->id }}]" value="1" checked />
                                    <label for="statement[{{ $d->id }}][yes]">Setuju</label>
                                </div>
                            </td>
                            <td style="width: 10%;">
                                <div class="checkboxgroup">
                                    <input type="radio" id="statement[{{ $d->id }}][no]" name="statement[{{ $d->id }}]" value="0" />
                                    <label for="statement[{{ $d->id }}][no]">Tidak Setuju</label>
                                </div>
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
        <center>
            <div class="col-md-4 align-self-center">
                    <label class="" for="">Tanda Tangan:</label>
                    <br/>
                    <div id="sig" >
                    <button id="clear" class="btn btn-danger btn-sm" style="position: absolute">Hapus</button>
                    </div>
                    <textarea class="required-field-agenda" id="signature64" name="tandatangan" style="display: none"></textarea>
                    <div class="invalid-feedback" id="valid-signature64">
                        Tanda Tangan wajib diisi.
                    </div>
                    <br/>
                <tr>
                    <td>
                        <input type="text" name="nama_penandatangan" class="form-control required-field-agenda" id="nama_penandatangan" style="border: none; border-bottom: 2px solid black;" placeholder="Nama Lengkap"/>
                        <div class="invalid-feedback" id="valid-nama_penandatangan">
                            Nama Lengkap wajib diisi.
                        </div>
                    </td>
                </tr>
            </div>
        </center>
        <br/>
        <div class="col-md-12" style="padding-bottom:50px;">
            <button id="submit" class="btn btn-success" style="display:block; width:100%; ">Simpan dan Kirim</button>
        </div>
        </div>
        @csrf
    </form>
</div>
{{-- tanda tangan / signature pad --}}

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.css">
  
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> 
<link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet"> 
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript" src="{{ asset('source/js/jquery.signature.js') }}"></script>
<link rel="stylesheet" type="text/css" href="http://keith-wood.name/css/jquery.signature.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js" ></script>

<script src="{{ asset('/source/js/validation.js') }}"></script>

<script type="text/javascript">
    var sig = $('#sig').signature({syncField: '#signature64', syncFormat: 'PNG'});
    $('#clear').click(function(e) {
        e.preventDefault();
        sig.signature('clear');
        $("#signature64").val('');
    });

    $('#submit').click(function() {
        if(validateForm('agenda') == false){
            return false;
            $('#message').html('Mohon cek ulang data yang wajib diinput.');
            $("#success-message").hide();
            $("#error-message").show();
        }
    })
</script>
</body>