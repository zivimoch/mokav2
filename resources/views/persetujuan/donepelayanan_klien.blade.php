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
        <div class="post clearfix" id="data_terlapor" style="color:black">
            <div class="alert alert-success alert-dismissible fade show col-md-12" role="alert">
                Terimakasih, konfirmasi anda telah kami terima. Harap menunggu informasi selanjutnya dari petugas mengenai tindak lanjut pengaduan anda. 
            </div>
        </div>
    </div>
    <br/>
    </div>
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