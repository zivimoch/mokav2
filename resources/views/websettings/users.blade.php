@extends('layouts.template')

@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Web Settings</h1>
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
@if (Session::has('data'))
    {{-- ini ketika submit perubahan --}}
    <input type="hidden" id="perubahan" value="{{ Session::get('data') }}">
@endif
<div class="container-fluid">
<div class="row">
    <div class="col-md-3">
        <div class="card card-primary" style="margin-bottom:0px">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-bars"></i>
                    Menu
                </h3>
            </div>
            @include('websettings.menu')
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
                <div class="post clearfix" style="margin: 0px">
                    <div style="overflow-x: scroll">
                    <input type="hidden" id="uuid_users_hightlight" value="{{ Request::get('row-users') }}">
                    <table id="tabelUsers" class="table table-sm table-bordered table-hover" style="cursor:pointer; color:black">
                        <thead>
                        <tr>
                        <th>Nama Lengkap</th>
                        <th>Jabatan</th>
                        <th>Supervisor</th>
                        <th>Wilayah</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>

<!-- Modal Users-->
<div class="modal fade" id="usersModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

        <div id="overlay" class="overlay dark">
            <div class="cv-spinner">
            <span class="spinner"></span>
            </div>
        </div>
        
        <div class="modal-header">
            <h5 class="modal-title" id="modelHeading"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="alert alert-danger alert-dismissible invalid-feedback" id="error-message">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-ban"></i> Gagal!</h4>
            <span id="message"></span>
        </div>
        <div class="alert alert-success alert-dismissible invalid-feedback" id="success-message">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Success!</h4>
            Data berhasil disimpan.
        </div>
        <div class="modal-body">
            <input type="hidden" name="uuid" id="uuid">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Nama Lengkap<span class="text-danger">*</span></label>
                        <input type="text" class="form-control titlecase required-field-users" id="name" required>
                        <div class="invalid-feedback" id="valid-users_nama">
                            Nama Lengkap wajib diisi.
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Email<span class="text-danger">*</span></label>
                        <input type="email" class="form-control required-field-users" id="email" required>
                        <div class="invalid-feedback" id="valid-users_email">
                            Email wajib diisi.
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Password</label>
                        <input type="text" class="form-control" id="password" required>
                    </div>
                </div>
                <div class="col-md-12">
                        <div class="form-group">
                        <label>Jabatan<span class="text-danger">*</span></label>
                        <select name="jabatan" class="form-control select2bs4 required-field-jabatan" id="jabatan">
                            @foreach ($jabatan as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="valid-jabatan">
                            Jabatan wajib diisi.
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                        <div class="form-group">
                        <label>Supervisor</label>
                        <select name="supervisor_id" class="form-control select2bs4" id="supervisor_id">
                            <option value="0"></option>
                            @foreach ($petugas as $item)
                                <option value="{{ $item->id }}">{{ $item->name }} ({{ $item->jabatan }})</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="valid-jabatan">
                            Supervisor wajib diisi.
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                        <div class="form-group">
                        <label>Wilayah</label>
                        <select name="kotkab_id" class="form-control select2bs4" id="kotkab_id">
                            <option></option>
                            @foreach ($kotkab as $item)
                                <option value="{{ $item->code }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                        <div class="form-group">
                        <label>Aktif</label>
                        <select name="active" class="form-control select2bs4" id="active">
                            <option value="1">Aktif</option>
                            <option value="0">Non Aktif</option>
                        </select>
                    </div>
                </div>
            </div>
            *User Aktif / Non Aktif untuk label di kasus <br>
            ^User Hapus / DIsabled untuk akses login
            <button type="button" class="btn btn-success btn-block" id="submitUsers"><i class="fa fa-check"></i> Simpan</button>
            <button type="button" class="btn btn-danger btn-block" id="deleteUsers"><i class="fa fa-trash"></i> Hapus / Disabled User</button>
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
<script src="{{ asset('/source/js/validation.js') }}"></script>
<script>
    $(function () {
    //Initialize Select2 Elements
    $('.select2').select2();
        $('.select2bs4').select2();
        $('.select-tag').select2({
        tags: true,
        theme: 'bootstrap4'
    });

    $('#tabelUsers').DataTable({
        "ordering": false,
        "processing": true,
        "serverSide": true,
        "responsive": false, 
        "lengthChange": false, 
        "autoWidth": false,
        "ajax": "{{ env('APP_URL') }}/settingusers/",
        'createdRow': function( row, data, dataIndex ) {
            $(row).attr('id', data.uuid);

            rowHightlight = $('#uuid_users_hightlight').val();
            if (data.uuid == rowHightlight) {
                $(row).attr('class', 'hightlighting');
            }
            if (data.deleted_at != null) {
                $(row).attr('class', 'warning_table');
            } else if (data.active == 0){
                $(row).attr('class', 'disabled_table');
            }
        },
        "columns": [
            {"data": "name"},
            {"data": "jabatan"},
            {"data": "supervisor"},
            {"data": "kota"}
        ],
        "pageLength": 10,
        "lengthMenu": [
            [10, 25, 50, 100, -1],
            ['10 rows', '25 rows', '50 rows', '100 rows','All'],
        ],
        "dom": 'Blfrtip', // Blfrtip or Bfrtip
        "buttons": ["pageLength", "copy", "csv", "excel", "pdf", "print",
                {
                    className: "btn-info",
                    text: 'Tambah',
                    action: function ( ) {
                        $('#deleteUsers').hide();
                        $('#uuid').val('');
                        $('#name').val('');
                        $('#email').val('');
                        $('#password').val('');
                        $('#modelHeading').html("Tambah User");
                        $('#usersModal').modal('show'); 
                        $("#overlay").hide();
                    }
                }]
        }).buttons().container().appendTo('#tabelUsers_wrapper .col-md-6:eq(0)');

        $('#tabelUsers_filter').css({'float':'right','display':'inline-block; background-color:black'});
        
        });

        $('#tabelUsers tbody').on('click', 'tr', function () {
            $("#success-message").hide();
            $("#error-message").hide();
            $.get(`{{ env('APP_URL') }}/settingusers/edit/`+this.id, function (data) {
                $("#overlay").hide();
                $('#modelHeading').html("Edit Users");
                $('#usersModal').modal('show');
                $('#deleteUsers').show();

                $('#uuid').val(data.uuid);
                $('#name').val(data.name);
                $('#email').val(data.email);
                $('#jabatan').val(data.jabatan).change();
                $('#supervisor_id').val(data.supervisor_id).change();
                $('#kotkab_id').val(data.kotkab_id).change();
                $('#aktif').val(data.aktif).change();
                $('#password').val('');
            });
        });

        $('#submitUsers').click(function() {
            if(validateForm('users')){
                let token   = $("meta[name='csrf-token']").attr("content");
                $.ajax({
                url: "{{ route('settingusers.store') }}",
                type: "POST",
                cache: false,
                data: {
                    uuid: $('#uuid').val(),
                    name: $("#name").val(),
                    email: $("#email").val(),
                    password: $("#password").val(),
                    jabatan: $("#jabatan").val(),
                    supervisor_id: $("#supervisor_id").val(),
                    kotkab_id: $("#kotkab_id").val(),
                    active: $("#active").val(),
                    _token: token
                },
                success: function (response){
                    if (response.success != true) {
                        console.log(response);
                        $('#message').html(JSON.stringify(response));
                        $("#success-message").hide();
                        $("#error-message").show();
                    }else{
                        $('#message').html(response.message);
                        $("#success-message").show();
                        $("#error-message").hide();

                        $('#tabelUsers').DataTable().ajax.reload();

                        // hapus semua inputan
                        $('#uuid').val('');
                        $('#name').val('');
                        $('#email').val('');
                        $('#password').val('');
                        // untuk hightlight row yang baru
                        data = response.data;
                        $('#uuid_users_hightlight').val(data.uuid);
                    }
                },
                error: function (response){
                    setTimeout(function(){
                    $("#overlay").fadeOut(300);
                    },500);
                    console.log(response);

                    $('#message').html(JSON.stringify(response));
                    $("#success-message").hide();
                    $("#error-message").show();
                }
                }).done(function() { //loading submit form
                    setTimeout(function(){
                    $("#overlay").fadeOut(300);
                    },500);
                });
            }else{
                $('#message').html('Mohon cek ulang data yang wajib diinput.');
                $("#success-message").hide();
                $("#error-message").show();
            }
        });

        $('#deleteUsers').click(function() {
        if (confirm("Apakah anda yakin ingin menghapus user ini?") == true) {
            let token   = $("meta[name='csrf-token']").attr("content");
            uuid = $('#uuid').val();
            $.ajax({
            url: `{{ env('APP_URL') }}/settingusers/destroy/`+uuid,
            type: "POST",
            cache: false,
            data: {
                _method:'DELETE',
                _token: token
            },
            success: function (response){
                if (response.success != true) {
                    console.log(response);
                    $('#message').html(JSON.stringify(response));
                    $("#success-message").hide();
                    $("#error-message").show();
                }else{
                    $('#jenisKekerasanModal').modal('hide');
                    $("#success-message").hide();
                    $("#error-message").hide();

                    $('#tabelUsers').DataTable().ajax.reload();

                    // hapus semua inputan
                    $('#tanggal').val('');
                    $('#jam').val('');
                    $('#keterangan').val('');
                }
            },
            error: function (response){
                setTimeout(function(){
                $("#overlay").fadeOut(300);
                },500);
                console.log(response);

                $('#message').html(JSON.stringify(response));
                $("#success-message").hide();
                $("#error-message").show();
            }
            }).done(function() { //loading submit form
                setTimeout(function(){
                $("#overlay").fadeOut(300);
                },500);
            });
            
        }
    });
</script>
@endsection