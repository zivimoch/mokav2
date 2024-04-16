@extends('layouts.template')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css"/>
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
                            <b>Foto Profile<b>
                        </td>
                        <td>
                            <input type="file" name="image" class="image" id="foto" accept="image/png, image/jpeg" >
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Nama Lengkap<b>
                        </td>
                        <td>
                            <input name="name" type="text" class="form-control titlecase" value="{{ $data->name }}">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Jabatan<b>
                        </td>
                        <td>
                            {{ Auth::user()->jabatan }}
                            {{-- <select name="jabatan" class="select2bs4" style="width: 100%;">
                                @foreach ($jabatan as $item)
                                    <option value="{{ $item }}" {{ $item == $data->jabatan ? 'selected' : '' }}>{{ $item }}</option>
                                @endforeach
                            </select> --}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Supervisor<b>
                        </td>
                        <td>
                            <select name="supervisor_id" class="select2bs4" style="width: 100%;">
                                <option value="0"></option>
                                @foreach ($petugas as $item)
                                    <option value="{{ $item->id }}" {{ $item->id == $data->supervisor_id ? 'selected' : '' }}>{{ $item->name }} ({{ $item->jabatan }})</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Wilayah<b>
                        </td>
                        <td>
                            <select name="kotkab_id" class="form-control select2bs4" id="kotkab_id" style="width: 100%;">
                                <option></option>
                                @foreach ($kotkab as $item)
                                    <option value="{{ $item->code }}" {{ $item->code == $data->kotkab_id ? 'selected' : '' }}>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Email<b>
                        </td>
                        <td>
                            <input name="email" type="email" class="form-control" value="{{ $data->email }}">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Password<b>
                        </td>
                        <td>
                            <a href="#" onclick="ubah('password')" id="ubah_password">ubah</a>
                            <input name="password" type="text" class="form-control" id="password" style="display: none" placeholder="Masuskan password baru">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Tanda Tangan<b>
                        </td>
                        <td>
                            <a href="#" onclick="ubah('sig_user')" id="ubah_sig_user">ubah</a>
                            <br>
                            <img src="{{ asset('img/tandatangan/ttd_user/'.$data->tandatangan) }}" onerror="this.style.display='none'" style="float: left">
                            <div id="sig_user" class="sig" style="width:300px; height:200px; display:none"> 
                                <button onclick="hapusTTD('sig_user','signature_user')" type="button" id="clear" class="btn btn-danger btn-sm" style="position: absolute">Hapus</button> 
                            </div> 
                            <textarea name="tandatangan" id="signature_user" style="display: none"></textarea>
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

{{-- Modal Upload Foto --}}
<div class="modal fade" id="modalFoto" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Crop Foto Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <div class="row">
                        <div class="col-md-8">
                            <img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
                        </div>
                        <div class="col-md-4">
                            <div class="preview"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="crop">Crop</button>
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
{{-- tanda tangan / signature pad --}}
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript" src="{{ asset('source/js/jquery.signature.js') }}"></script>
<link rel="stylesheet" type="text/css" href="http://keith-wood.name/css/jquery.signature.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js" ></script>
{{-- crop foto --}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"></script>
<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2();
            $('.select2bs4').select2();
            $('.select-tag').select2({
            tags: true,
            theme: 'bootstrap4'
        });

        hightlighting();
    });

    function ubah(param) {
        var inputan = $("#" + param);
        var ubahLink = $("#ubah_" + param);

        // Toggle visibility of the password input
        inputan.toggle();

        // Toggle text between "ubah" and "batal"
        var isPasswordVisible = inputan.is(":visible");
        ubahLink.text(isPasswordVisible ? "batal" : "ubah");

        if (ubahLink.text() == "ubah") {
            if (param == 'password') {
                inputan.val('');
            }else{
                hapusTTD('sig_user','signature_user');
            }
        }
    }

    $('#sig_user').signature({syncField: '#signature_user', syncFormat: 'PNG'});
    $("canvas").attr("width", 295);
    function hapusTTD(sig, sig_text) {
        // Clear the canvas by setting its width to its own width
        var canvas = $("#" + sig + " canvas")[0];
        canvas.width = canvas.width;
        // Clear the corresponding textarea value
        $("#" + sig_text).val('');
    };

    function hightlighting() {
        var inputValue = $('#perubahan').val();

        if (inputValue) {
            toastr.success('Berhasil update data!');
            var value = JSON.parse(inputValue);

            $('#data_user').addClass('hightlighting');
        } 
    }

    var $modal = $('#modalFoto');
        var image = document.getElementById('image');
        var cropper;

        $("body").on("change", ".image", function(e){
            var files = e.target.files;
            var done = function (url) {
                image.src = url;
                $modal.modal('show');
            };

            var reader;
            var file;
            var url;

            if (files && files.length > 0) {
                file = files[0];

                if (URL) {
                    done(URL.createObjectURL(file));
                } else if (FileReader) {
                    reader = new FileReader();
                    reader.onload = function (e) {
                        done(reader.result);
                    };
                reader.readAsDataURL(file);
                }
            }
        });

        $modal.on('shown.bs.modal', function () {
            cropper = new Cropper(image, {
                aspectRatio: 1,
                viewMode: 3,
                preview: '.preview'
            });
        }).on('hidden.bs.modal', function () {
            cropper.destroy();
            cropper = null;
        });

        $("#crop").click(function(){
            canvas = cropper.getCroppedCanvas({
                width: 160,
                height: 160,
            });

            canvas.toBlob(function(blob) {
                url = URL.createObjectURL(blob);
                var reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function() {
                    var base64data = reader.result; 
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "{{ env('APP_URL') }}/users/cropimage",
                        data: {'_token': $("meta[name='csrf-token']").attr("content"), 'image': base64data},
                        success: function(data){
                            console.log(data.file);
                            $modal.modal('hide');
                            $('.fotoProfile').attr("src", "{{ asset('img/profile/') }}" + '/' + data.file);
                            $('#foto').val('');
                        }
                    });
                }
            });
        });
</script>
@endsection