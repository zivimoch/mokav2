<!DOCTYPE html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex, nofollow">
  <!-- PWA  -->
<meta name="theme-color" content="#6777ef"/>
<link rel="apple-touch-icon" href="{{ asset('logo.png') }}">
<link rel="manifest" href="{{ asset('/manifest.json') }}">

  <title>MOKA</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">


  <link rel="stylesheet" href="{{ asset('adminlte') }}/plugins/fontawesome-free/css/all.min.css">

  <link rel="stylesheet" href="{{ asset('/source/css/main.css') }}">
  
  <link rel="stylesheet" href="{{ asset('adminlte') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  
  <link rel="stylesheet" href="{{ asset('adminlte') }}/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
  
  <link rel="stylesheet" href="{{ asset('adminlte') }}/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  
  <link rel="stylesheet" href="{{ asset('adminlte') }}/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="{{ asset('adminlte') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  
  <link rel="stylesheet" href="{{ asset('adminlte') }}/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  
  <link rel="stylesheet" href="{{ asset('adminlte') }}/plugins/bs-stepper/css/bs-stepper.min.css">
  
  <link rel="stylesheet" href="{{ asset('adminlte') }}/plugins/dropzone/min/dropzone.min.css">
  
  <link rel="stylesheet" href="{{ asset('adminlte') }}/dist/css/adminlte.min.css?v=3.2.0">

<link rel="stylesheet" href="{{ asset('adminlte') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{ asset('adminlte') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="{{ asset('adminlte') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
{{-- toast, bikin alert yang melayang dan hilang --}}
<link rel="stylesheet" href="{{ asset('adminlte') }}/plugins/toastr/toastr.min.css">
<link rel="shortcut icon" href="{{ asset('img/favicon.png') }}" >

<meta name="csrf-token" content="{{ csrf_token() }}">

<audio id="notif_audio">
  <source src="{{ asset('sounds') }}/notify.ogg" type="audio/ogg" muted="muted">
  <source src="{{ asset('sounds') }}/notify.mp3" type="audio/mpeg" muted="muted">
  <source src="{{ asset('sounds') }}/notify.wav" type="audio/wav" muted="muted">
</audio>

</head>
<body class="hold-transition layout-top-nav">
{{-- ubah ini dan style wrapper saat production  --}}
@php
    $url = request()->url();
    $urlSegments = explode('/', $url);
    $firstSegment = isset($urlSegments[3]) ? $urlSegments[3] : null;
@endphp
@if($firstSegment === 'latihan')
<div class="alert alert-danger alert-dismissible" style="position: fixed; z-index:10000; width:100%;">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <center><b>MOKA.V2 (LATIHAN)</b></center>
</div>
<div class="alert" style="width:100%;"></div>
@endif
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  @include('layouts.navbar')
  <!-- /.navbar -->

  {{-- @include('admin.layout.sidebar') --}}


<script src="{{ asset('adminlte') }}/plugins/jquery/jquery.min.js"></script>
<script src="{{ asset('adminlte') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('adminlte') }}/dist/js/adminlte.min.js?v=3.2.0"></script>
<script src="{{ asset('adminlte') }}/plugins/moment/moment.min.js"></script>
{{-- toast, bikin alert yang melayang dan hilang --}}
<script src="{{ asset('adminlte') }}/plugins/toastr/toastr.min.js"></script>
<div class="content-wrapper">
    <div class="content">
      <div class="container" id="kontainer">
      @yield('content')
    </div>
  </div>
  </div>
    
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 2.1
    </div>
    <strong>Copyright &copy; 2022 <a href="">MOKA ONLINE</a>.</strong> All rights reserved.
  </footer>
</div>

<!-- Modal timeOutModal-->
<div class="modal fade bd-example-modal-lg" id="timeOutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-body" style="text-align: center">
        <h4 style="font-weight:bold; background-color:rgb(174, 149, 114); color:#fff">SESI HABIS, JANGAN BIARKAN MOKA ANDA TERLALU LAMA</h4>
      </br>
      <center>
        <img src="{{ asset('img/mocha.gif') }}" alt="" class="img-fluid">
        <br>
        <br>
        <button type="button" class="btn btn-primary btn-lg" onclick="location.reload()">Reload Halaman</button>
      </center>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="ajaxModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      {{-- <div id="overlay" class="overlay dark">
        <div class="cv-spinner">
          <span class="spinner"></span>
        </div>
      </div> --}}
      
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="ribbon-wrapper ribbon-xl">
          <div class="ribbon bg-danger text-xl warningTerminasi">
          CLOSED
          </div>
      </div>
      <div class="card-body box-profile">
      <div class="text-center">
      <img class="profile-user-img img-fluid img-circle" src="{{ asset('adminlte') }}/dist/img/default-150x150.png" alt="User profile picture">
      </div>
      <h3 class="profile-username text-center" id="nama"></h3>
      <p class="text-muted text-center"> (<span id="usia"></span>) <span id="jenis_kelamin"></span></p>
      <p class="text-center" id="no_klien"></p>
      <ul class="list-group list-group-unbordered mb-3">
      <h5><span class="float-right badge bg-primary btn-block" id="status"></span></h5>
      </ul>
      </div>
      <div class="card" style="margin-top:-30px; margin-bottom:0px">
          <div id="accordionKelengkapan" style="margin-bottom:-15px">
              <div class="card card-light">
                <div class="card-header" data-toggle="collapse" data-target="#collapseKelengkapan" aria-expanded="true" aria-controls="collapseKelengkapan" style="cursor: pointer;">
                  <h3 class="card-title">
                      <b>Kelengkapan Kasus (<span id="kelengkapan_kasus"></span>/6) </b>
                  </h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool">
                      <i class="fas fa-chevron-down"></i>
                    </button>
                  </div>
                </div>
              <div id="collapseKelengkapan" class="collapse show" data-parent="#accordionKelengkapan">
              <div class="card-body">
                  <ol style="padding:15px; margin :-25px 0px -20px 0px">
                      <li>
                          Identifikasi <i class="fa fa-check" id="check_identifikasi"></i>
                          <ul style="margin-left: -25px">
                            <li style="color: blue; cursor: pointer; font-weight:bold" onclick="alert('Field yang dibutuhkan untuk diisi :\n1. Data Kasus : \nMedia Pengagduan, Sumber Informasi, Tanggal Pelaporan, Tanggal Kejadian, Kategori Lokasi, Ringkasan, TKP\n2. Data Pelapor :\n Nama Lengkap, Jenis Kelamin\n3. Data Korban :\nNama Lengkap, Tempat Lahir, Tanggal Lahir, Jenis Kelamin, Alamat KTP, Alamat Domisili, Agama, Status Kawin, Pekerjaan, Kewargangaraan, Status Pendidikan, Pendidikan, Hubungan dengan Pelapor\n4. Data Terlapor :\nNama Lengkap, Tempat Lahir, Tanggal Lahir, Jenis Kelamin, Agama, Pekerjaan, Kewarganegaraan, Status Pendidikan, Pendidikan')">
                                Kelengkapan Data (<span id="persen_title_data"></span>%) <i class="far fa-check-circle"></i>
                                <div class="progress progress-xs">
                                    <div class="progress-bar bg-success progress-bar-striped" id="persen_data" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                            </li>
                              <li>
                                  Persetujuan Supervisor <i class="far fa-check-circle" id="check_persetujuan_spv"></i>
                              </li>
                              <li>
                                  Tanda Tangan SPP <i class="far fa-check-circle" id="check_ttd_spp"></i>
                              </li>
                          </ul>
                      </li>
                      <li>
                          Asesmen <i class="fa fa-check" id="check_asesmen"></i>
                      </li>
                      <li>
                          Perencanaan Intervensi <i class="fa fa-check" id="check_perencanaan"></i>
                      </li>
                      <li>
                          Pelaksanaan Intervensi  <i class="fa fa-check" id="check_pelaksanaan"></i>
                          <br>
                          (<span class="persen_title_layanan"></span>%)
                          <div class="progress progress-xs">
                              <div class="progress-bar bg-success progress-bar-striped persen_layanan" role="progressbar" aria-valuemin="0">
                              </div>
                          </div>
                      </li>
                      <li>
                          Pemantauan & Evaluasi <i class="fa fa-check" id="check_pemantauan"></i>
                      </li>
                      <li>
                          Terminasi <i class="fa fa-check" id="check_terminasi"></i>
                      </li>
                  </ol>
              </div>
              </div>
              </div>
          </div>

          <div style="margin-bottom:-15px">
            <div class="card card-light">
              <div class="card-header" data-toggle="collapse" data-target="#accordionListPetugas" aria-expanded="true" aria-controls="accordionListPetugas" style="cursor: pointer;">
                <h3 class="card-title">
                    <b>Petugas </b>
                </h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool">
                    <i class="fas fa-chevron-down"></i>
                  </button>
                </div>
              </div>
            <div id="accordionListPetugas" class="collapse" data-parent="#accordionListPetugas">
            <div class="card-body">
                <ol style="padding:15px; margin :-25px 0px -20px 0px" id="listPetugas"></ol>
            </div>
            </div>
            </div>
        </div>
        </div>
      </div>
      <div class="modal-footer" id="buttons"></div>
    </div>
  </div>
</div>

@if (((env('APP_URL') == 'http://127.0.0.1:8000') || ($firstSegment === 'latihan')) && isset(Auth::user()->id))
{{-- MOKA V2.0 ANNOUCMENT BOX  --}}
<style>
  .chat-box {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 500px;
    background: #f2f2f2;
    border: 1px solid #ccc;
    border-radius: 5px;
    z-index: 10000000;
  }

  .chat-header {
    background: #333;
    color: #fff;
    padding: 0px 15px 0px 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .chat-title {
    margin: 0;
  }

  .toggle-button,
  .close-button {
    background: none;
    border: none;
    color: #fff;
    font-size: 30px;
    cursor: pointer;
    padding: 0;
    margin: 0;
  }

  .toggle-button {
    margin-right: -100px !important; /* Adjust the margin as needed */
  }

  .chat-body {
    display: block;
    padding: 15px;
  }

  .chat-body.hidden {
    display: none;
  }
</style>

<div class="chat-box">
  <div class="chat-header">
      <div class="chat-title">Anda Login Sebagai : </div>
      <button class="toggle-button">-</button>
      <button class="close-button">×</button> <!-- Close button added -->
  </div>
  <div class="chat-body">
      <div class="card card-widget widget-user-2">
          <!-- Add the bg color to the header using any of the bg-* classes -->
          <div class="widget-user-header bg-warning">
              <div class="widget-user-image">
                  <img class="img-circle elevation-2 fotoProfile"
                      src="{{ asset('img/profile/'.Auth::user()->foto) }}"
                      onerror="this.onerror=null; this.src='{{ asset('adminlte/dist/img/default-150x150.png') }}'"
                      alt="User Avatar">
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username">{{ Auth::user()->name }}</h3>
              <h5 class="widget-user-desc">{{ Auth::user()->jabatan }}</h5>
          </div>
      </div>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function () {
      const chatBox = document.querySelector(".chat-box");
      const chatBody = document.querySelector(".chat-body");
      const toggleButton = document.querySelector(".toggle-button");
      const closeButton = document.querySelector(".close-button");

      toggleButton.addEventListener("click", function () {
          chatBody.classList.toggle("hidden");
          toggleButton.textContent = chatBody.classList.contains("hidden") ? "+" : "-";
      });

      closeButton.addEventListener("click", function () {
          chatBox.remove(); // Remove the chat-box
      });
  });

  $(document).ready(function () {
      $(".toggle-button").click(function () {
          $(".chat-body").slideToggle();
          if ($(".toggle-button").text() === "-") {
              $(".toggle-button").text("+");
          } else {
              $(".toggle-button").text("-");
          }
      });
  });
</script>

{{-- END MOKA V2.0  --}}
@endif
{{-- ini untuk notifikasi ketika diklik redirect --}}
<input type="hidden" id="notif_receiver" data-notif="{{ Request::get('notif') }}" value="{{ Request::get('notif') }}">
{{-- socket --}}
<script src="{{ asset('adminlte') }}/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script src="https://cdn.socket.io/4.0.1/socket.io.min.js" integrity="sha384-LzhRnpGmQP+lOvWruF/lgkcqD+WDVt9fU3H4BWmwP5u5LTmkUGafMcpZKNObVMLU" crossorigin="anonymous"></script>
<script src="{{ asset('adminlte') }}/plugins/select2/js/select2.full.min.js"></script>



{{-- PWA --}}
<script src="{{ asset('/sw.js') }}"></script>
<script>
// PWA START
   if ("serviceWorker" in navigator) {
      // Register a service worker hosted at the root of the
      // site using the default scope.
      navigator.serviceWorker.register("/sw.js").then(
      (registration) => {
         console.log("Service worker registration succeeded:", registration);
      },
      (error) => {
         console.error(`Service worker registration failed: ${error}`);
      },
    );
  } else {
     console.error("Service workers are not supported.");
  }
// PWA END 

// search klien end
function klien_search() {
        let searchQuery = $('#klien_search').val();
        // if (searchQuery.length >= 1) {
            $.ajax({
                url: '/get_klien?uuid=1&petugas=1&no_klien=1',
                type: 'POST',
                data: {
                    search: searchQuery,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    $('#search_results').empty();
                    highlightedIndex = -1; // Reset highlighted index
                    if (data.length > 0) {
                        $.each(data, function(index, item) {
                            $('#search_results').append('<a href="#" class="list-group-item list-group-item-action small-item" data-id="' + item.id + '">' + item.text + '<br> <span style="font-size:13px">' + item.no_klien + ' </span> </a>');
                        });
                      } else {
                        $('#search_results').append('<a href="#" class="list-group-item list-group-item-action small-item" >Klien tidak ditemukan</a>');
                      }
                      $('#search_results').show(); // Show results
                },
                error: function() {
                    console.log('Error occurred while searching.');
                }
            });
        // } else {
        //     $('#search_results').hide(); // Hide results if input is empty
        // }
    }

  $(document).ready(function() {

    let selectedId = null;
    let highlightedIndex = -1; 
    // $('#klien_search').on('input', function() {
    // });
    $(document).on('keydown', '#klien_search', function(e) {
        const items = $('#search_results .list-group-item');
        if (e.key === 'ArrowDown') {
            highlightedIndex = (highlightedIndex + 1) % items.length; // Loop back to start
            updateHighlight(items);
            e.preventDefault();
        } else if (e.key === 'ArrowUp') {
            highlightedIndex = (highlightedIndex - 1 + items.length) % items.length; // Loop back to end
            updateHighlight(items);
            e.preventDefault(); 
        } else if (e.key === 'Enter') {
            if (highlightedIndex >= 0 && highlightedIndex < items.length) {
                const selectedItem = items.eq(highlightedIndex);
                selectItem(selectedItem);
            }
        }
    });
    function updateHighlight(items) {
        items.removeClass('list-group-item-active'); // Remove previous highlight
        if (highlightedIndex >= 0 && highlightedIndex < items.length) {
            items.eq(highlightedIndex).addClass('list-group-item-active'); // Highlight current item
        }
    }
    function selectItem(item) {
        selectedId = item.data('id');
        $('#klien_search').val(item.text());
        $('#search_results').hide(); 
        highlightedIndex = -1; 
    }
    $(document).on('click', '.list-group-item', function() {
        selectItem($(this)); 
    });
    $('#search_btn').on('click', function() {
        if (selectedId) {
          modal_klien(selectedId); 
        } else {
            alert("Klien tidak ditemukan");
        }
    });
    $(document).click(function(e) {
        if (!$(e.target).closest('.input-group').length) {
            $('#search_results').hide();
        }
    });
});
// search klien end

function modal_klien(uuid) {
  $.ajax({
        url: '/kasus/show/'+uuid,
        type: 'GET',
        success: function(data) {
          dob = new Date(data.tanggal_lahir);
          var today = new Date();
          var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));

          $('#nama').html(data.nama);
          $('#usia').html(age);
          $('#jenis_kelamin').html(data.jenis_kelamin);
          $('#no_klien').html(data.no_klien);
          $('#status').html(data.status);

          $('#check_persetujuan_spv, #check_ttd_spp, #check_identifikasi, #check_asesmen, .warningAsesmen, .warningSPP, #modalAsesmen, #check_perencanaan, #check_pelaksanaan, #check_pemantauan, #check_terminasi, .warningTerminasi').hide();
        
          check_kelengkapan_data(data.id);
          check_kelengkapan_persetujuan_spv(data.id);
          check_kelengkapan_spp(data.id);
          check_kelengkapan_asesmen(data.id);
          check_kelengkapan_perencanaan(data.id);
          check_kelengkapan_pemantauan(data.id);
          check_kelengkapan_terminasi(data.id);
          kelengkapan_kasus = 0;
          kelengkapan_identifikasi = 0;
          $('#kelengkapan_kasus').html(kelengkapan_kasus);
            
          //munculkan tombol
          $('#buttons').html('');
          $('#buttons').append('<a href="#" onclick="alert(`Fitur belum tersedia`)" class="btn btn-warning btn-block" id="rekap"><i class="fas fa-stream"></i> Rekap Kasus</a>');
          // $('#buttons').append('<a href="#" onclick="rekap_kasus(`' + data.uuid + '`)" class="btn btn-warning btn-block" id="rekap"><i class="fas fa-stream"></i> Rekap Kasus</a>');
          $('#buttons').append('<a href="' + "{{ route('kasus.show', '') }}" + '/' + data.uuid + '" class="btn btn-primary btn-block" id="detail"><i class="fa fa-info-circle"></i> Detail Kasus (Bisa New Tab)</a>');
          if ( data.no_klien == null && "{{ in_array(Auth::user()->jabatan, ['Manajer Kasus', 'Penerima Pengaduan', 'Super Admin']) }}") {
              $('#buttons').append('<button type="button" onclick="hapus(`'+data.uuid+'`)" class="btn btn-danger btn-block" id="hapus"><i class="fa fa-trash"></i> Hapus Kasus</button>');
          }else{
            $('#buttons').append('<div btn-block>*Anda tidak memiliki akses atau kasus ini sudah ada no regisnya sehingga anda tidak dapat menghapus kasus ini</div>');
          }

          // list petugas
          $('#listPetugas').html('');
          listPetugas = data.list_petugas;
          listPetugas.forEach(e => {
            $('#listPetugas').append('<li><b>'+e.name+'</b> ('+e.jabatan+')</li>')
          });
            
            $("#overlay").hide();
          $('#ajaxModal').modal('show');
        },
        error: function() {
            console.log('Error occurred while searching.');
        }
    });
}

  $(function() {
    if ($('#kontainerwidth').length == 1) {
     
    if($('#kontainerwidth').is(":checked")){
          $('#kontainer').addClass('container');
        } else {
          $('#kontainer').removeClass('container');
        } 
    }
    $(".titlecase").on("input", function() {
    var originalText = $(this).val();
    var cursorPosition = this.selectionStart; // Get cursor position

    // Split the original text into parts based on cursor position
    var textBeforeCursor = originalText.substring(0, cursorPosition);
    var textAfterCursor = originalText.substring(cursorPosition);

    // Preserve existing casing while capitalizing the first letter of each word
    var newText = capitalizeWords(textBeforeCursor) + textAfterCursor;

    // Update the input field with the modified text
    $(this).val(newText);

    // Restore cursor position after updating input field
    var newCursorPosition = cursorPosition;
    this.setSelectionRange(newCursorPosition, newCursorPosition);
});

function capitalizeWords(text) {
    return text.replace(/\b\w/g, function(txt) {
        return txt.toUpperCase();
    });
}

    // initialized all select2
    $( ".select2_field" ).select2();

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    })
    $('#kontainerwidth').on('switchChange.bootstrapSwitch', function (event, state) {
        if($(this).is(":checked")){
          $('#kontainer').addClass('container');
        } else {
          $('#kontainer').removeClass('container');
        }
      });
    loadnotif();
    // ketika di local
    socket = io(window.location.hostname+':'+3000);
    // ketika di server
    // socket = io(window.location.hostname,  {path: '/socket/socket.io'});
    
    socket.emit('join_room', {room:'user_', id_room:'{{ Auth::user()->id }}'});

    socket.on('notif_count', (data) => {
        loadnotif();
        $('#notif_audio')[0].play();
        $('#notif_bell').addClass('bell');
        $('#notif_text').css('color', 'yellow');
    });

    // untuk notif2 dari action yang tidak menggunakan ajax alias reload halaman
    if ($('#notif_receiver').val()) {
      var notif_receiver = $('#notif_receiver').data('notif'); 
      socket.emit('notif_count', {
        receiver_id : notif_receiver
      });
      }
  });

  // Prevent dropdown from closing when clicking on tab links
  document.querySelectorAll('.nav-tabs .nav-link').forEach(function(link) {
      link.addEventListener('click', function(event) {
          event.preventDefault();
          event.stopPropagation();
          $(this).tab('show');
      });
  });
  //loading submit form semua form
  // $(document).ajaxSend(function() {
  //   $("#overlay").fadeIn(300);　
  // });
  // TimeOut
  var activityTimeout = setTimeout(inActive, 3600000); //1 jam
  function resetActive(){
      // $(document.body).attr('class', 'active');
      clearTimeout(activityTimeout);
      activityTimeout = setTimeout(inActive, 3600000); //1 jam
  }
  function inActive(){
      $('#timeOutModal').modal({backdrop: 'static', keyboard: false});
  }
  // Check for mousemove, could add other events here such as checking for key presses ect.
  $(document).bind('mousemove', function(){resetActive()});

  function loadnotif(){
    $.ajax({
        url:'{{ route("notifikasi.pull_notif") }}',
        type:'GET',
        dataType: 'json',
        success: function( response ) {
            // kosongkan dulu
            $('#count_task').html('');
            $('#count_notif').html('');
            $('#notif_count').html('');
            $('#task_list').html('');
            $('#notif_list').html('');

            task = response.task;
            notif = response.notif;
            $('#count_task').html(task.length);
            $('#count_notif').html(notif.length);
            notif_count = parseInt(task.length);
            if (notif_count>0) {
                $('#notif_count').html('<span class="badge-notif badge-notif-danger">'+notif_count+'</span>');   
            }

            // load task
            task.forEach(e => {
              if (e.kasus != null) {
                kasus = e.kasus;
              }else{
                kasus = '';
              }

              if (e.no_reg != null) {
                no_reg = '| '+e.no_reg;
              }else{
                no_reg = '';
              }
              $('#task_list').prepend('<a href=\"'+e.url+'\" class=\"list-group-item list-group-item-action flex-column align-items-start\"> <div class=\"d-flex w-100 justify-content-between\"> <h6 class=\"mb-1\"><b>'+e.from+'</b></h6> <small>'+e.formattedDate+' lalu</small> </div> <p class=\"mb-1\">'+e.message+'</p> <small> '+kasus+' '+no_reg+' </small> </a>')
            });
            // load notif
            notif.forEach(e => {
              if (e.kasus != null) {
                kasus = e.kasus;
              }else{
                kasus = '';
              }

              if (e.no_reg != null) {
                no_reg = '| '+e.no_reg;
              }else{
                no_reg = '';
              }
              $('#notif_list').prepend('<a href=\"'+e.url+'\" class=\"list-group-item list-group-item-action flex-column align-items-start\"> <div class=\"d-flex w-100 justify-content-between\"> <h6 class=\"mb-1\"><b>'+e.from+'</b></h6> <small>'+e.formattedDate+' lalu</small> </div> <p class=\"mb-1\">'+e.message+'</p> <small> '+kasus+' '+no_reg+' </small> </a>')
            });
        }
    });
  }

  function read_all() {
    $.ajax({
        url:'{{ route("notifikasi.read_all") }}',
        type:'GET',
        dataType: 'json',
        success: function( response ) {
          loadnotif();
        }
    });
  }

  function check_kelengkapan_data(klien_id) {
        $.ajax({
            url: `{{ env('APP_URL') }}/check_kelengkapan_data/`+klien_id,
            type: "GET",
            cache: false,
            success: function (response){
                // nol kan dulu persentasenya 
                $('.persen_data').css('width','0%');
                // update persentase
                $('#persen_title_data').html(response);
                $('#persen_data').css('width', response+'%');
            },
            error: function (response){
                alert("Error");
                console.log(response);
            }
        });
    }

    function check_kelengkapan_persetujuan_spv(klien_id) {
        $.ajax({
            url: `{{ env('APP_URL') }}/check_kelengkapan_persetujuan_spv/`+klien_id,
            type: "GET",
            cache: false,
            success: function (response){
                if (response) {
                    $('#check_persetujuan_spv').show();
                    kelengkapan_identifikasi = kelengkapan_identifikasi + 1;
                    if (kelengkapan_identifikasi > 1) {
                        $('#check_identifikasi').show();
                        kelengkapan_kasus = kelengkapan_kasus + 1;
                        $('#kelengkapan_kasus').html(kelengkapan_kasus);
                    }
                }
            },
            error: function (response){
                alert("Error");
                console.log(response);
            }
            });
    }

    function check_kelengkapan_spp(klien_id) {
        $.ajax({
            url: `{{ env('APP_URL') }}/check_kelengkapan_spp/`+klien_id,
            type: "GET",
            cache: false,
            success: function (response){
                if (response) {
                    $('#check_ttd_spp').show();
                    kelengkapan_identifikasi = kelengkapan_identifikasi + 1;
                    if (kelengkapan_identifikasi > 1) {
                        $('#check_identifikasi').show();
                        kelengkapan_kasus = kelengkapan_kasus + 1;
                        $('#kelengkapan_kasus').html(kelengkapan_kasus);
                    }
                    $('#modalAsesmen').show();
                }else{
                    $('.warningSPP').show();
                }
            },
            error: function (response){
                alert("Error");
                console.log(response);
            }
            });
    }

    function check_kelengkapan_asesmen(klien_id) {
        $.ajax({
            url: `{{ env('APP_URL') }}/check_kelengkapan_asesmen/`+klien_id,
            type: "GET",
            cache: false,
            success: function (response){
                if (response) {
                    $('#check_asesmen').show();
                    kelengkapan_kasus = kelengkapan_kasus + 1;
                    $('#kelengkapan_kasus').html(kelengkapan_kasus);
                    $('.warningAsesmen').hide();
                }else{
                    $('.warningAsesmen').show();
                }
            },
            error: function (response){
                alert("Error");
                console.log(response);
            }
            });
    }

    function check_kelengkapan_perencanaan(klien_id) {
        $.ajax({
            url: `{{ env('APP_URL') }}/check_kelengkapan_perencanaan/`+klien_id,
            type: "GET",
            cache: false,
            success: function (response){
                if (response > 0) {
                    $('#check_perencanaan').show();
                    kelengkapan_kasus = kelengkapan_kasus + 1;
                    $('#kelengkapan_kasus').html(kelengkapan_kasus);
                }
                check_kelengkapan_pelaksanaan(response, klien_id);
            },
            error: function (response){
                alert("Error");
                console.log(response);
            }
            });
    }

    function check_kelengkapan_pelaksanaan(jml_perencanaan, klien_id) {
        $.ajax({
            url: `{{ env('APP_URL') }}/check_kelengkapan_pelaksanaan/`+klien_id,
            type: "GET",
            cache: false,
            success: function (response){
                // nol kan dulu persentasenya 
                $('.persen_layanan').css('width','0%');
                // update persentase
                persentase = (response / jml_perencanaan) * 100
                persentase = persentase.toFixed(2);
                $('.persen_title_layanan').html(persentase);
                $('.persen_layanan').css('width', persentase+'%');
                if (persentase == 100) {
                    $('#check_pelaksanaan').show();
                    kelengkapan_kasus = kelengkapan_kasus + 1;
                    $('#kelengkapan_kasus').html(kelengkapan_kasus);
                }
            },
            error: function (response){
                alert("Error");
                console.log(response);
            }
          });
    }

    function check_kelengkapan_pemantauan(klien_id) {
      $.ajax({
          url: `{{ env('APP_URL') }}/check_kelengkapan_pemantauan/`+klien_id,
          type: "GET",
          cache: false,
          success: function (response){
              // centang indikator pemanatauan & evaluasi
              if (response.pemantauan_terakhir > 0) {
                  $('#check_pemantauan').show();
                  kelengkapan_kasus = kelengkapan_kasus + 1;
                  $('#kelengkapan_kasus').html(kelengkapan_kasus);
              }
          },
          error: function (response){
              // alert("Error");
              console.log(response);
          }
          });
    }

    function check_kelengkapan_terminasi(klien_id) {
        $.ajax({
            url: `{{ env('APP_URL') }}/check_kelengkapan_terminasi/`+klien_id,
            type: "GET",
            cache: false,
            success: function (response){
                if (response!='') {
                    $('#check_terminasi').show();
                    kelengkapan_kasus = kelengkapan_kasus + 1;
                    $('#kelengkapan_kasus').html(kelengkapan_kasus);
                    $('.warningTerminasi').show();
                    $('#alasan_terminasi').html(response.alasan);
                }
            },
            error: function (response){
                alert("Error");
                console.log(response);
            }
            });
    }

function hapus(uuid) {
  if (confirm("Apakah anda yakin ingin menghapus kasus ini? Seluruh task & notifikasi terkait kasus ini akan dihapus juga.") == true) {
    let token   = $("meta[name='csrf-token']").attr("content");
    $.ajax({
    url: `{{ env('APP_URL') }}/kasus/destroy/`+uuid,
    type: "POST",
    cache: false,
    data: {
        _method:'DELETE',
        _token: token
    },
    success: function (response){
        if (response.success != true) {
            console.log(response);
        }else{
            $('#tabelKasus').DataTable().ajax.reload();
            $('#tabelLaporKBG').DataTable().ajax.reload();
            $('#ajaxModal').modal('hide');
        }
        loadnotif();
    },
    error: function (response){
        setTimeout(function(){
        $("#overlay").fadeOut(300);
        },500);
        console.log(response);
    }
    }).done(function() { //loading submit form
        setTimeout(function(){
        $("#overlay").fadeOut(300);
        },500);
    });
  }
}
</script>
</body>
</html>