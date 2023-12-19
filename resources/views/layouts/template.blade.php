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

<meta name="csrf-token" content="{{ csrf_token() }}">

<audio id="notif_audio">
  <source src="{{ asset('sounds') }}/notify.ogg" type="audio/ogg" muted="muted">
  <source src="{{ asset('sounds') }}/notify.mp3" type="audio/mpeg" muted="muted">
  <source src="{{ asset('sounds') }}/notify.wav" type="audio/wav" muted="muted">
</audio>

</head>
<body class="hold-transition layout-top-nav">
{{-- ubah ini dan style wrapper saat production  --}}
{{-- <div class="alert alert-danger" style="position: fixed; z-index:10000; width:100%;">
  <center><b>MOKA.V2 (BETA). Isi <a href="https://s.id/bugmokav2" target="_blank">Formulir Temuan</a></b></center>
</div> --}}
{{-- <div class="alert alert-danger" style="width:100%;"></div> --}}
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
      <b>Version</b> 2.0
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
{{-- ini untuk notifikasi ketika diklik redirect --}}
<input type="hidden" id="notif_receiver" data-notif="{{ Request::get('notif') }}" value="{{ Request::get('notif') }}">
{{-- socket --}}
<script src="{{ asset('adminlte') }}/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script src="https://cdn.socket.io/4.0.1/socket.io.min.js" integrity="sha384-LzhRnpGmQP+lOvWruF/lgkcqD+WDVt9fU3H4BWmwP5u5LTmkUGafMcpZKNObVMLU" crossorigin="anonymous"></script>
<script src="{{ asset('adminlte') }}/plugins/select2/js/select2.full.min.js"></script>
<script>
  $(function() {
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
  $(document).ajaxSend(function() {
    $("#overlay").fadeIn(300);　
  });
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