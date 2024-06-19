<!DOCTYPE html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>

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
<script>
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
</script>
</body>
</html>