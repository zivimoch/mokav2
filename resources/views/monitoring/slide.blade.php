<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profil PPPA DKI Jakarta</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/reveal.js/4.2.0/reveal.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="{{ asset('adminlte') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="{{ asset('adminlte') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="{{ asset('adminlte') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <style>
    body {
        font-family: Arial, Helvetica, sans-serif;
    }
    .content {
      padding: 0px 55px 55px 55px;
    }
    /* Custom styles for progress bar span */
    .reveal .progress {
      height: 15px;
    }
    .heading {
        background-color: black;
        font-size: 30px;
        color: aliceblue;
        font-weight: bold;
        margin-bottom: 50px;
        padding: 55px;
    }
    .image_slide {
      width: 100%
    }
  </style>
</head>
<body>
  <div class="reveal">
    <div class="slides">
      <section>
        <img src="{{ asset('img/slides/slide1.png') }}" class="image_slide">
      </section>
      <section>
        <img src="{{ asset('img/slides/slide2.png') }}" class="image_slide">
      </section>
      <section>
        <img src="{{ asset('img/slides/slide3.png') }}" class="image_slide">
      </section>
      <section>
        <img src="{{ asset('img/slides/slide4.png') }}" class="image_slide">
      </section>
      <section>
        <img src="{{ asset('img/slides/slide5.png') }}" class="image_slide">
      </section>
      <section>
        <img src="{{ asset('img/slides/slide6.png') }}" class="image_slide">
      </section>
      <section>
        <img src="{{ asset('img/slides/slide7.png') }}" class="image_slide">
      </section>
      <section>
        <img src="{{ asset('img/slides/slide8.png') }}" class="image_slide">
      </section>
      <section>
        <img src="{{ asset('img/slides/slide9.png') }}" class="image_slide">
      </section>
      <section>
        <img src="{{ asset('img/slides/slide10.png') }}" class="image_slide">
      </section>
      <section>
        <img src="{{ asset('img/slides/slide11.png') }}" class="image_slide">
      </section>
      <section>
        <img src="{{ asset('img/slides/slide12.png') }}" class="image_slide">
      </section>
      <section>
        <img src="{{ asset('img/slides/slide13.png') }}" class="image_slide">
      </section>
      <section>
        <img src="{{ asset('img/slides/slide14.png') }}" class="image_slide">
      </section>
      <section>
        <img src="{{ asset('img/slides/slide15.png') }}" class="image_slide">
      </section>
      <section>
        @include('monitoring.slides.slide2')
      </section>
      <section>
        @include('monitoring.slides.slide3')
      </section>
      {{-- DATA JUMLAH KORBAN KEKERASAN TERHADAP PEREMPUAN DAN ANAK BERDASARKAN KOTA/ KABUPATEN TEMPAT KEJADIAN PERKARA --}}
      <section>
        @include('monitoring.slides.slide4')
      </section>
      {{-- DATA JUMLAH KORBAN KEKERASAN TERHADAP PEREMPUAN DAN ANAK BERDASARKAN KOTA/ KABUPATEN KARTU TANDA PENDUDUK --}}
      <section>
        @include('monitoring.slides.slide4b')
      </section>
      {{-- DATA JUMLAH KORBAN KEKERASAN TERHADAP PEREMPUAN DAN ANAK BERDASARKAN KOTA/ KABUPATEN DOMISILI --}}
      <section>
        @include('monitoring.slides.slide4c')
      </section>
      {{-- DATA JUMLAH KORBAN KEKERASAN TERHADAP PEREMPUAN DAN ANAK BERDASARKAN KOTA/ KABUPATEN PENUGASAN KASATPEL --}}
      <section>
        @include('monitoring.slides.slide4d')
      </section>
      {{-- JUMLAH KORBAN PER BULAN YANG DITANGANI PPPA --}}
      <section>
        @include('monitoring.slides.slide5')
      </section>
      {{-- DATA JUMLAH KORBAN KEKERASAN TERHADAP PEREMPUAN DAN ANAK YANG DITANGANI OLEH PPPA BERDASARKAN KATEGORI KASUS --}}
      <section>
        @include('monitoring.slides.slide6')
      </section>
      {{-- DATA JUMLAH KORBAN KEKERASAN TERHADAP PEREMPUAN DAN ANAK YANG DITANGANI OLEH PPPA BERDASARKAN JENIS KEKERASAN --}}
      <section>
        @include('monitoring.slides.slide6b')
      </section>
      {{-- DATA JUMLAH KORBAN KEKERASAN TERHADAP PEREMPUAN DAN ANAK YANG DITANGANI OLEH PPPA BERDASARKAN BENTUK KEKERASAN --}}
      <section>
        @include('monitoring.slides.slide6c')
      </section>
      {{-- DATA JUMLAH KORBAN KEKERASAN TERHADAP PEREMPUAN DAN ANAK YANG DITANGANI OLEH PPPA BERDASARKAN BENTUK KEKERASAN --}}
      <section>
        @include('monitoring.slides.slide7')
      </section>
      <section>
        <img src="{{ asset('img/slides/slide16.png') }}" class="image_slide">
      </section>
    </div>
  </div>

  <!-- Include the Reveal.js library -->
<script src="{{ asset('adminlte') }}/plugins/jquery/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/reveal.js/4.2.0/reveal.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> 
<script src="{{ asset('adminlte') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
{{-- DataTable --}}
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
    load_data2();
    load_data3();
    load_data4();
    load_data4b();
    load_data4c();
    load_data4d();
    load_data5();
    load_data6();
    load_data6b();
    load_data6c();
    load_data7();

    // Initialize Reveal.js
    Reveal.initialize({
      // Options
      progress: true, // Enable progress bar
      slideNumber: true, // Enable slide number
      disableLayout: true
    });

    // Add a custom fullscreen button
    document.querySelector('.reveal').addEventListener('click', function () {
      if (!document.fullscreenElement) {
        document.documentElement.requestFullscreen();
      }
    });

    document.addEventListener('DOMContentLoaded', function(event) {
        document.addEventListener('wheel', function(event) {
            if (event.ctrlKey) {
                event.preventDefault();
                if (event.deltaY < 0) {
                    // Zoom in
                    zoom(1.1);
                } else {
                    // Zoom out
                    zoom(0.9);
                }
            }
        });
    });
    
    function zoom(scale) {
        var slides = document.querySelectorAll('.reveal .slides > section');
        for (var i = 0; i < slides.length; i++) {
            var slide = slides[i];
            var currentTransform = slide.style.transform;
            slide.style.transform = 'scale(' + scale + ')' + (currentTransform ? ' ' + currentTransform : '');
        }
    }
  </script>
</body>
</html>
