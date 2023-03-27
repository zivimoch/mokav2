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

<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="hold-transition layout-top-nav">
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

  <div class="content-wrapper">
    <div class="content">
      <div class="container">
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

<script>
  //loading submit form
  $(document).ajaxSend(function() {
    $("#overlay").fadeIn(300);　
  });
</script>
</body>
</html>
