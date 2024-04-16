@extends('layouts.template')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css"/>

<link rel="stylesheet" href="{{ asset('adminlte') }}/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">

<style>
    .kbw-signature { width: 300px; height: 200px;}
    .sig canvas{
        width: 300px !important;
        height: 200px;
        border-style: solid;
    }
    .preview {
        text-align: center;
        overflow: hidden;
        width: 160px; 
        height: 160px;
        margin: 10px;
        border: 1px solid red;
    }
    .modal-lg{
        max-width: 1000px !important;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css"/>

<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>User Settings</h1>
        </div>
        <div class="col-sm-6 text-right">
          <input type="checkbox" class="btn-xs" id="kontainerwidth"
          {{ Auth::user()->settings_kontainer_width == 'normal' ? 'checked' : '' }}
                data-bootstrap-switch 
                data-on-text="Normal"
                data-off-text="Fullwidth"
                data-off-color="default" 
                data-on-color="default">
        </div>
      </div>
    </div>
  </section>

<section class="content">
@if (Session::has('perubahan'))
    {{-- ini ketika submit perubahan --}}
    <input type="hidden" id="perubahan" value="{{ Session::get('perubahan') }}">
@endif
<div class="container-fluid">
<div class="row">
    <div class="col-md-3">

        <div class="card card-primary">
            <div class="card-body box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle fotoProfile" src="{{ asset('img/profile/'.Auth::user()->foto) }}" alt="User profile picture" style="width:500px"
                    onerror="this.onerror=null; this.src='{{ asset('adminlte/dist/img/default-150x150.png') }}'">
                </div>
            </div>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-bars"></i>
                    Menu
                </h3>
            </div>
            @include('users.menu')
        </div>
    </div>    

    <div class="col-md-9">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="{{ $header['icon'] }}"></i>
                    {{ $header['title'] }}
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('users.update', 'uuid') }}" method="POST">
                @csrf
                @method('put')
                <input name="uuid" type="hidden" value="{{ $data->uuid }}">
                <table class="table table-bottom table-sm" id="data_user">
                    <tr>
                        <td>
                            <b>Tabel Agenda / Intervensi<b>
                            <br>
                        </td>
                        <td>
                            
                            <div class="icheck-primary d-inline" style="margin-right:15px">
                                <input type="radio" id="radioPrimary1" name="settings_tabel_intervensi" {{ Auth::user()->settings_tabel_intervensi == 1 ? 'checked' : '' }} value="1">
                                <label for="radioPrimary1">
                                    <img src="{{ asset('img/invervensiv1.png') }}" style="max-width: 200px">
                                    <br>MOKA V1
                                </label>
                                </div>
                                <div class="icheck-primary d-inline">
                                <input type="radio" id="radioPrimary2" name="settings_tabel_intervensi" {{ Auth::user()->settings_tabel_intervensi == 2 ? 'checked' : '' }} value="2">
                                <label for="radioPrimary2">
                                    <img src="{{ asset('img/invervensiv2.png') }}" style="max-width: 200px">
                                    <br>Case Action Plan
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Navbar Background Color<b>
                            <br>
                        </td>
                        <td>
                            
                            <div class="icheck-primary d-inline" style="margin-right:15px">
                                <input type="radio" id="radioPrimaryb1" name="settings_navbar_bg_color_option" {{ Auth::user()->settings_navbar_bg_color == 'default' ? 'checked' : '' }} value="default">
                                <label for="radioPrimaryb1">
                                    Default
                                </label>
                                </div>
                                <div class="icheck-primary d-inline">
                                <input type="radio" id="radioPrimaryb2" name="settings_navbar_bg_color_option" {{ Auth::user()->settings_navbar_bg_color != 'default' ? 'checked' : '' }} value="costum">
                                <label for="radioPrimaryb2">
                                    Costum<br>
                                    <div class="form-group">
                                        <div class="input-group my-colorpicker2">
                                            <input type="text" class="form-control" name="settings_navbar_bg_color" value="{{ Auth::user()->settings_navbar_bg_color }}">
                                            <div class="input-group-append">
                                            <span class="input-group-text"><i class="fas fa-square"></i></span>
                                            </div>
                                        </div>
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Ukuran Layout<b>
                            <br>
                        </td>
                        <td>
                            
                            <div class="icheck-primary d-inline" style="margin-right:15px">
                                <input type="radio" id="radioPrimaryc1" name="settings_kontainer_width" {{ Auth::user()->settings_kontainer_width == 'normal' ? 'checked' : '' }} value="normal">
                                <label for="radioPrimaryc1">
                                    Selalu Normal
                                </label>
                                </div>
                                <div class="icheck-primary d-inline">
                                <input type="radio" id="radioPrimaryc2" name="settings_kontainer_width" {{ Auth::user()->settings_kontainer_width == 'fullwidth' ? 'checked' : '' }} value="fullwidth">
                                <label for="radioPrimaryc2">
                                    Selalu Full Width
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <button type="submit" class="btn btn-block btn-success btn-sm"><i class="fas fa-check"></i> Simpan</button>
                        </td>
                    </tr>
                </table>
                </form>
            </div>
        </div>
    </div>
</div>

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
<script src="https://cdn.rawgit.com/ashl1/datatables-rowsgroup/fbd569b8768155c7a9a62568e66a64115887d7d0/dataTables.rowsGroup.js"></script>
<script src="{{ asset('vendor/tinymce4/tinymce.min.js') }}"></script>
<script src="{{ asset('adminlte') }}/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<script>
    $(function () {
        //color picker with addon
    $('.my-colorpicker2').colorpicker()
    $('.my-colorpicker2').on('colorpickerChange', function(event) {
        $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    })
        hightlighting();
    });

    function hightlighting() {
        var inputValue = $('#perubahan').val();

        if (inputValue) {
            toastr.success('Berhasil update data!');
            var value = JSON.parse(inputValue);

            $('#data_user').addClass('hightlighting');
        } 
    }
</script>
@endsection