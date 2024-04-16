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
                    <b>JENIS KEKERASAN</b>
                    </br>
                    <div style="overflow-x: scroll">
                    <input type="hidden" id="uuid_jenis_hightlight" value="{{ Request::get('row-jenis') }}">
                    <table id="tabelJenisKekerasan" class="table table-sm table-bordered table-hover" style="cursor:pointer; color:black">
                        <thead>
                        <tr>
                        <th>Kode</th>
                        <th>Nama Jenis Kekerasan</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    </div>
                </div>
                <br>

                <div class="post clearfix" style="margin: 0px">
                    <b>BENTUK KEKERASAN</b>
                    </br>
                    <div style="overflow-x: scroll">
                    <input type="hidden" id="uuid_bentuk_hightlight" value="{{ Request::get('row-bentuk') }}">
                    <table id="tabelBentukKekerasan" class="table table-sm table-bordered table-hover" style="cursor:pointer; color:black">
                        <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama Bentuk Kekerasan</th>
                            <th>Nama Jenis Kekerasan</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    </div>
                </div>
                <br>
                
                <div class="post clearfix" style="margin: 0px">
                    <b>KATEGORI KASUS</b>
                    </br>
                    <div style="overflow-x: scroll">
                    <input type="hidden" id="uuid_kategori_hightlight" value="{{ Request::get('row-kategori') }}">
                    <table id="tabelKategoriKasus" class="table table-sm table-bordered table-hover" style="cursor:pointer; color:black">
                        <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama Kategori Kasus</th>
                            <th>Jenis & Bentuk</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    </div>
                </div>

                <div style="border: 1px dashed; padding:10px">
                    <legend>Simulasi Klasifikasi Kasus</legend>
                    <div class="row"> 
                        <div class="col-md-12"> 
                            <div class="form-group"> 
                                <label>Step 1 : Tentukan Jenis Kekerasan <span style="color:red">*</span></label> 
                                <select id="jenis_kekerasan2" onchange="getBentukKekerasan2()" multiple="multiple" style="width: 100%"  data-placeholder="Dapat dipilih lebih dari 1 jenis kekerasan" required></select>
                            </div> 
                        </div> 
                        <div class="col-md-12"> 
                            <div class="form-group"> 
                                <label>Step 2 : Tentukan Bentuk Kekerasan berdasarkan Jenis Kekerasan yang sudah dipilih</label> 
                                <select id="bentuk_kekerasan2" onchange="getKategoriKasus2('klien1')" multiple="multiple" style="width: 100%"  data-placeholder="Dapat dipilih lebih dari 1 bentuk kekerasan"></select> 
                            </div> 
                        </div> 
                        <div class="col-md-12"> 
                            <div class="form-group"> 
                                <label>Step 3 : Tentukan Kategori Kasus</label> 
                                <select id="kategori_kasus2" multiple="multiple" style="width: 100%"  data-placeholder="Dapat dipilih lebih dari 1 kategori kasus"></select> 
                            </div> 
                        </div> 
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    </div>
</section>

<!-- Modal Jenis Kekerasan-->
<div class="modal fade" id="jenisKekerasanModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
            <input type="hidden" name="uuid" id="uuid_jenis">
            <input type="hidden" name="jenis_kode" id="jenis_kode">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                    <label>Nama Jenis Kekerasan<span class="text-danger">*</span></label>
                    <input type="text" class="form-control titlecase required-field-jenis_kekerasan" id="jenis_nama" required>
                    <div class="invalid-feedback" id="valid-jenis_nama">
                        Nama Jenis Kekerasan wajib diisi.
                    </div>
                </div>
                </div>
                
            </div>
            <button type="button" class="btn btn-success btn-block" id="submitJenisKekerasan"><i class="fa fa-check"></i> Simpan</button>
            <button type="button" class="btn btn-danger btn-block" id="deleteJenisKekerasan"><i class="fa fa-trash"></i> Hapus</button>
        </div>
    </div>
    </div>
</div>

<!-- Modal Bentuk Kekerasan-->
<div class="modal fade" id="bentukKekerasanModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

        <div id="overlayBentuk" class="overlay dark">
            <div class="cv-spinner">
            <span class="spinner"></span>
            </div>
        </div>
        <div class="modal-header">
            <h5 class="modal-title" id="modelHeadingBentukKekerasan"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="alert alert-danger alert-dismissible invalid-feedback" id="error-message-bentuk">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-ban"></i> Gagal!</h4>
            <span id="message-bentuk"></span>
        </div>
        <div class="alert alert-success alert-dismissible invalid-feedback" id="success-message-bentuk">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Success!</h4>
            Data berhasil disimpan.
        </div>
        <div class="modal-body">
            <input type="hidden" name="uuid" id="uuid_bentuk">
            <input type="hidden" name="bentuk_kode" id="bentuk_kode">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                    <label>Nama Jenis Kekerasan<span class="text-danger">*</span></label>
                    <select name="jenis_kode_bentuk" class="form-control required-field-bentuk_kekerasan" id="jenis_kode_bentuk">
                        @foreach ($opsi_jenis_kekerasan as $item)
                            <option value="{{ $item->kode }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback" id="valid-jenis_nama">
                        Nama Jenis Kekerasan wajib diisi.
                    </div>
                </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                    <label>Nama Bentuk Kekerasan<span class="text-danger">*</span></label>
                    <input type="text" class="form-control titlecase required-field-bentuk_kekerasan" id="bentuk_nama" required>
                    <div class="invalid-feedback" id="valid-bentuk_nama">
                        Nama Bentuk Kekerasan wajib diisi.
                    </div>
                </div>
                </div>
                
            </div>
            <button type="button" class="btn btn-success btn-block" id="submitBentukKekerasan"><i class="fa fa-check"></i> Simpan</button>
            <button type="button" class="btn btn-danger btn-block" id="deleteBentukKekerasan"><i class="fa fa-trash"></i> Hapus</button>
        </div>
    </div>
    </div>
</div>

<!-- Modal Kategori Kasus-->
<div class="modal fade" id="kategoriKasusModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

        <div id="overlayKategori" class="overlay dark">
            <div class="cv-spinner">
            <span class="spinner"></span>
            </div>
        </div>
        
        <div class="modal-header">
            <h5 class="modal-title" id="modelHeadingKategori"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="alert alert-danger alert-dismissible invalid-feedback" id="error-message-kategori">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-ban"></i> Gagal!</h4>
            <span id="message-kategori"></span>
        </div>
        <div class="alert alert-success alert-dismissible invalid-feedback" id="success-message-kategori">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Success!</h4>
            Data berhasil disimpan.
        </div>
        <div class="modal-body">
            <input type="hidden" name="uuid" id="uuid_kategori">
            <input type="hidden" name="kategori_kode" id="kategori_kode">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Nama Jenis Kekerasan<span class="text-danger">*</span></label>
                        <select name="jenis_kode_bentuk" id="jenis_kode_kategori" class="form-control required-field-kategori_kasus" onchange="getBentukKekerasan()" multiple="multiple" style="width: 100%"  data-placeholder="Dapat dipilih lebih dari 1 jenis kekerasan" required></select>
                    </div>
                    <div class="form-group">
                        <label>Nama Bentuk Kekerasan<span class="text-danger">*</span></label>
                        <select name="bentuk_kode_kategori" id="bentuk_kode_kategori" class="form-control required-field-kategori_kasus" multiple="multiple" style="width: 100%"  data-placeholder="Dapat dipilih lebih dari 1 jenis kekerasan" required></select>
                        <div class="invalid-feedback" id="valid-bentuk_kode_kategori">
                            Nama Jenis Kekerasan wajib diisi.
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Nama Kategori Kasus<span class="text-danger">*</span></label>
                        <input type="text" class="form-control titlecase required-field-kategori_kasus" id="kategori_nama" required>
                        <div class="invalid-feedback" id="valid-kategori_nama">
                            Nama Kategori Kasus wajib diisi.
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Usia<span class="text-danger">*</span></label>
                        <select name="usia" class="form-control required-field-kategori_kasus" id="usia">
                            <option value="semua" selected>Semua</option>
                            <option value="dewasa">Dewasa</option>
                            <option value="anak">Anak</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Jenis Kelamin<span class="text-danger">*</span></label>
                        <select name="jenis_kelamin" class="form-control required-field-kategori_kasus" id="jenis_kelamin">
                            <option value="semua" selected>Semua</option>
                            <option value="perempuan" selected>Perempuan</option>
                            <option value="laki-laki">Laki-laki</option>
                        </select>
                    </div>
                    <div class="form-group"> 
                        <label>Hubungan Dengan Terlapor (Klien siapanya Terlapor?)</label> 
                        <select name="terlapor" id="terlapor" class="form-control select2bs4" style="width:100%" multiple> 
                            @foreach ($hubungan_dengan_terlapor as $item) 
                                <option value="{{ $item }}" >{{ $item }}</option> 
                            @endforeach 
                        </select> 
                    </div> 
                    <div class="form-group"> 
                        <label>Lokasi</label> 
                        <select name="lokasi" id="lokasi" class="form-control select2bs4" style="width:100%" multiple> 
                            @php
                            $no_kategori_lokasi = 1;   
                            @endphp
                            @foreach ($kategori_lokasi as $group => $groupItems)
                                <optgroup label="{{ $no_kategori_lokasi.'. '. $group }}">
                                    @foreach ($groupItems as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </optgroup>
                                @php
                                $no_kategori_lokasi++;
                                @endphp
                            @endforeach
                        </select> 
                    </div> 
                    <div class="form-group">
                        <label>Definisi<span class="text-danger">*</span></label>
                        <textarea type="text" class="form-control titlecase required-field-kategori_kasus" id="definisi" required></textarea>
                        <div class="invalid-feedback" id="valid-kategori_nama">
                            Definisi wajib diisi.
                        </div>
                    </div>
                    <div class="form-group"> 
                        <label>Dasar Hukum</label> 
                        <select name="dasar_hukum" id="dasar_hukum" class="form-control select-tag" style="width:100%" multiple></select> 
                    </div> 
                </div>
                
            </div>
            <button type="button" class="btn btn-success btn-block" id="submitKategoriKasus"><i class="fa fa-check"></i> Simpan</button>
            <button type="button" class="btn btn-danger btn-block" id="deleteKategoriKasus"><i class="fa fa-trash"></i> Hapus</button>
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
        // inisialize all function 
        getJenisKekerasan();
        getBentukKekerasan();

        getJenisKekerasan2();
        getBentukKekerasan2();
        getKategoriKasus2();
        
        // JENIS KEKERASAN
        $('#tabelJenisKekerasan').DataTable({
        "ordering": false,
        "processing": true,
        "serverSide": true,
        "responsive": false, 
        "lengthChange": false, 
        "autoWidth": false,
        "ajax": "{{ env('APP_URL') }}/settingjeniskekerasan/",
        'createdRow': function( row, data, dataIndex ) {
            $(row).attr('id', data.uuid);

            rowHightlight = $('#uuid_jenis_hightlight').val();
            if (data.uuid == rowHightlight) {
                $(row).attr('class', 'hightlighting');
            }
        },
        "columns": [
            {"data": "kode"},
            {"data": "nama"}
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
                        $('#deleteJenisKekerasan').hide();
                        $('#jenis_kode').val('');
                        $('#jenis_nama').val('');
                        $('#modelHeading').html("Tambah Jenis Kekerasan");
                        $('#jenisKekerasanModal').modal('show'); 
                        $("#overlay").hide();
                        //reset uuid riwayat
                        $('#uuid_jenis').val('');
                    }
                }]
        }).buttons().container().appendTo('#tabelJenisKekerasan_wrapper .col-md-6:eq(0)');

        $('#tabelJenisKekerasan_filter').css({'float':'right','display':'inline-block; background-color:black'});
        
        });

        $('#tabelJenisKekerasan tbody').on('click', 'tr', function () {
            $("#success-message").hide();
            $("#error-message").hide();
            $.get(`{{ env('APP_URL') }}/settingjeniskekerasan/edit/`+this.id, function (data) {
                $("#overlay").hide();
                $('#modelHeading').html("Edit Jenis Kekerasan");
                $('#jenisKekerasanModal').modal('show');
                $('#deleteJenisKekerasan').show();

                $('#uuid_jenis').val(data.uuid);
                $('#jenis_kode').val(data.kode);
                $('#jenis_nama').val(data.nama);
            });
        });

        $('#submitJenisKekerasan').click(function() {
            if(validateForm('jenis_kekerasan')){
                let token   = $("meta[name='csrf-token']").attr("content");
                $.ajax({
                url: "{{ route('settingjeniskekerasan.store') }}",
                type: "POST",
                cache: false,
                data: {
                    uuid: $('#uuid_jenis').val(),
                    kode: $("#jenis_kode").val(),
                    nama: $("#jenis_nama").val(),
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

                        $('#tabelJenisKekerasan').DataTable().ajax.reload();

                        // hapus semua inputan
                        $('#jenis_kode').val('');
                        $('#jenis_nama').val('');
                        // untuk hightlight row yang baru
                        data = response.data;
                        $('#uuid_jenis_hightlight').val(data.uuid);
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

        $('#deleteJenisKekerasan').click(function() {
        if (confirm("Apakah anda yakin ingin menghapus jenis kekerasan ini?") == true) {
            let token   = $("meta[name='csrf-token']").attr("content");
            uuid = $('#uuid_jenis').val();
            $.ajax({
            url: `{{ env('APP_URL') }}/settingjeniskekerasan/destroy/`+uuid,
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

                    $('#tabelJenisKekerasan').DataTable().ajax.reload();

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

    $(function () {
        // BENTUK KEKERASAN
        $('#tabelBentukKekerasan').DataTable({
        "ordering": false,
        "processing": true,
        "serverSide": true,
        "responsive": false, 
        "lengthChange": false, 
        "autoWidth": false,
        "ajax": "{{ env('APP_URL') }}/settingbentukkekerasan/",
        "rowsGroup": [2],
        'createdRow': function( row, data, dataIndex ) {
            $(row).attr('id', data.uuid);

            rowHightlight = $('#uuid_bentuk_hightlight').val();
            if (data.uuid == rowHightlight) {
                $(row).attr('class', 'hightlighting');
            }
        },
        "columns": [
            {"data": "bentuk_kode"},
            {"data": "bentuk_nama"},
            {"data": "jenis_nama"}
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
                        $('#deleteBentukKekerasan').hide();
                        $('#bentuk_kode').val('');
                        $('#bentuk_nama').val('');
                        $('#jenis_kode').val('');
                        $('#modelHeadingBentukKekerasan').html("Tambah Bentuk Kekerasan");
                        $('#bentukKekerasanModal').modal('show'); 
                        $("#overlayBentuk").hide();
                        //reset uuid riwayat
                        $('#uuid_bentuk').val('');
                    }
                }]
        }).buttons().container().appendTo('#tabelBentukKekerasan_wrapper .col-md-6:eq(0)');

        $('#tabelBentukKekerasan_filter').css({'float':'right','display':'inline-block; background-color:black'});
        
        });

        $('#tabelBentukKekerasan tbody').on('click', 'tr', function () {
            $("#success-message-bentuk").hide();
            $("#error-message-bentuk").hide();
            $.get(`{{ env('APP_URL') }}/settingbentukkekerasan/edit/`+this.id, function (data) {
                $("#overlayBentuk").hide();
                $('#modelHeadingBentukKekerasan').html("Edit Bentuk Kekerasan");
                $('#bentukKekerasanModal').modal('show');
                $('#deleteBentukKekerasan').show();

                $('#uuid_bentuk').val(data.uuid);
                $('#jenis_kode_bentuk').val(data.jenis_kekerasan_kode);
                $('#bentuk_nama').val(data.nama);
                $('#bentuk_kode').val(data.kode);
            });
        });

        $('#submitBentukKekerasan').click(function() {
            if(validateForm('bentuk_kekerasan')){
                let token   = $("meta[name='csrf-token']").attr("content");
                $.ajax({
                url: "{{ route('settingbentukkekerasan.store') }}",
                type: "POST",
                cache: false,
                data: {
                    uuid: $('#uuid_bentuk').val(),
                    jenis_kode: $("#jenis_kode_bentuk").val(),
                    kode: $("#bentuk_kode").val(),
                    nama: $("#bentuk_nama").val(),
                    _token: token
                },
                success: function (response){
                    if (response.success != true) {
                        console.log(response);
                        $('#message-bentuk').html(JSON.stringify(response));
                        $("#success-message-bentuk").hide();
                        $("#error-message-bentuk").show();
                    }else{
                        $('#message-bentuk').html(response.message);
                        $("#success-message-bentuk").show();
                        $("#error-message-bentuk").hide();

                        $('#tabelBentukKekerasan').DataTable().ajax.reload();

                        // hapus semua inputan
                        $('#jenis_kode_bentuk').val('');
                        $('#bentuk_kode').val('');
                        $('#bentuk_nama').val('');
                        // untuk hightlight row yang baru
                        data = response.data;
                        $('#uuid_bentuk_hightlight').val(data.uuid);
                    }
                },
                error: function (response){
                    setTimeout(function(){
                    $("#overlay").fadeOut(300);
                    },500);
                    console.log(response);

                    $('#message-bentuk').html(JSON.stringify(response));
                    $("#success-message-bentuk").hide();
                    $("#error-message-bentuk").show();
                }
                }).done(function() { //loading submit form
                    setTimeout(function(){
                    $("#overlayBentuk").fadeOut(300);
                    },500);
                });
            }else{
                $('#message-bentuk').html('Mohon cek ulang data yang wajib diinput.');
                $("#success-message-bentuk").hide();
                $("#error-message-bentuk").show();
            }
        });

        $('#deleteBentukKekerasan').click(function() {
        if (confirm("Apakah anda yakin ingin menghapus bentuk kekerasan ini?") == true) {
            let token   = $("meta[name='csrf-token']").attr("content");
            uuid = $('#uuid_bentuk').val();
            $.ajax({
            url: `{{ env('APP_URL') }}/settingbentukkekerasan/destroy/`+uuid,
            type: "POST",
            cache: false,
            data: {
                _method:'DELETE',
                _token: token
            },
            success: function (response){
                if (response.success != true) {
                    console.log(response);
                    $('#message-bentuk').html(JSON.stringify(response));
                    $("#success-message-bentuk").hide();
                    $("#error-message-bentuk").show();
                }else{
                    $('#bentukKekerasanModal').modal('hide');
                    $("#success-message").hide();
                    $("#error-message").hide();

                    $('#tabelBentukKekerasan').DataTable().ajax.reload();

                    // hapus semua inputan
                    $('#jenis_kode_bentuk').val('');
                    $('#bentuk_kode').val('');
                    $('#bentuk_nama').val('');
                }
            },
            error: function (response){
                setTimeout(function(){
                $("#overlayBentuk").fadeOut(300);
                },500);
                console.log(response);

                $('#message-bentuk').html(JSON.stringify(response));
                $("#success-message-bentuk").hide();
                $("#error-message-bentuk").show();
            }
            }).done(function() { //loading submit form
                setTimeout(function(){
                $("#overlayBentuk").fadeOut(300);
                },500);
            });
        }
    });

    $(function () {
        // KATEGORI KASUS
        $('#tabelKategoriKasus').DataTable({
        "ordering": false,
        "processing": true,
        "serverSide": true,
        "responsive": false, 
        "lengthChange": false, 
        "autoWidth": false,
        "ajax": "{{ env('APP_URL') }}/settingkategorikasus/",
        'createdRow': function( row, data, dataIndex ) {
            $(row).attr('id', data.uuid);

            rowHightlight = $('#uuid_kategori_hightlight').val();
            if (data.uuid == rowHightlight) {
                $(row).attr('class', 'hightlighting');
            }
        },
        "columns": [
            { "data": "kategori_kode" },
            { "data": "kategori_nama" },
            {
                "data": "kategori_jenis_bentuk",
                "render": function (data, type, row) {
                    br = data.replace(/&lt;br&gt;/g, '<br>');
                    b = br.replace(/&lt;/g, '<').replace(/&gt;/g, '>');
                    return b; 
                }
            }
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
                        // $('#deleteKategoriKasus').hide();
                        $('#submitKategoriKasus').show();
                        $('#deleteKategoriKasus').hide();
                        $('#jenis_kode_kategori').val('').change();
                        $('#bentuk_kode_kategori').val('').change();
                        $('#kategori_kode').val('');
                        $('#kategori_nama').val('');
                        $("#usia").val('semua');
                        $("#jenis_kelamin").val('semua');
                        $("#terlapor").val('').change();
                        $("#lokasi").val('').change();
                        $("#definisi").val('');
                        $("#dasar_hukum").val('').change();
                        $('#modelHeadingKategori').html("Tambah Kategori Kasus");
                        $('#kategoriKasusModal').modal('show'); 
                        $("#overlayKategori").hide();
                        //reset uuid 
                        $('#uuid_kategori').val('');
                    }
                }]
        }).buttons().container().appendTo('#tabelKategoriKasus_wrapper .col-md-6:eq(0)');

        $('#tabelKategoriKasus_filter').css({'float':'right','display':'inline-block; background-color:black'});
        
        });

        $('#tabelKategoriKasus tbody').on('click', 'tr', function () {
            $("#success-message-kategori").hide();
            $("#error-message-kategori").hide();
            $.get(`{{ env('APP_URL') }}/settingkategorikasus/edit/`+this.id, function (data) {
                $("#overlayKategori").hide();
                $('#modelHeadingKategori').html("Edit Kategori Kasus");
                $('#kategoriKasusModal').modal('show');
                $('#submitKategoriKasus').hide();
                $('#deleteKategoriKasus').show();

                $('#uuid_kategori').val(data.uuid);
                $('#jenis_kode').val();
                $('#bentuk_kode').val();
                $('#kategori_kode').val(data.nama);
                $('#kategori_nama').val(data.nama);
                $("#usia").val(data.usia);
                $("#jenis_kelamin").val(data.jenis_kelamin);
                $("#terlapor").val(data.terlapor);
                $("#lokasi").val(data.lokasi);
                $("#definisi").val(data.definisi);
                $("#dasar_hukum").val(data.dasar_hukum);
            });
        });

        $('#submitKategoriKasus').click(function() {
            if(validateForm('kategori_kasus')){
                let token   = $("meta[name='csrf-token']").attr("content");
                $.ajax({
                url: "{{ route('settingkategorikasus.store') }}",
                type: "POST",
                cache: false,
                data: {
                    uuid: $('#uuid_kategori').val(),
                    jenis_kode: $("#jenis_kode_kategori").val(),
                    bentuk_kode: $("#bentuk_kode_kategori").val(),
                    kode: $("#kategori_kode").val(),
                    nama: $("#kategori_nama").val(),
                    usia: $("#usia").val(),
                    jenis_kelamin: $("#jenis_kelamin").val(),
                    terlapor: $("#terlapor").val(),
                    lokasi: $("#lokasi").val(),
                    definisi: $("#definisi").val(),
                    dasar_hukum: $("#dasar_hukum").val(),
                    _token: token
                },
                success: function (response){
                    if (response.success != true) {
                        console.log(response);
                        $('#message-kategori').html(JSON.stringify(response));
                        $("#success-message-kategori").hide();
                        $("#error-message-kategori").show();
                    }else{
                        $('#message-kategori').html(response.message);
                        $("#success-message-kategori").show();
                        $("#error-message-kategori").hide();

                        $('#tabelKategoriKasus').DataTable().ajax.reload();

                        // hapus semua inputan
                        $('#uuid_kategori').val('');
                        $('#jenis_kode_kategori').val('').change();
                        $('#bentuk_kode_kategori').val('').change();
                        $('#kategori_kode').val('');
                        $('#kategori_nama').val('');
                        $("#usia").val('semua');
                        $("#jenis_kelamin").val('semua');
                        $("#terlapor").val('').change();
                        $("#lokasi").val('').change();
                        $("#definisi").val('');
                        $("#dasar_hukum").val('').change();
                        // untuk hightlight row yang baru
                        data = response.data;
                        $('#uuid_kategori_hightlight').val(data.uuid);
                    }
                },
                error: function (response){
                    setTimeout(function(){
                    $("#overlayKategori").fadeOut(300);
                    },500);
                    console.log(response);

                    $('#message-kategori').html(JSON.stringify(response));
                    $("#success-message-kategori").hide();
                    $("#error-message-kategori").show();
                }
                }).done(function() { //loading submit form
                    setTimeout(function(){
                    $("#overlayKategori").fadeOut(300);
                    },500);
                });
            }else{
                $('#message-kategori').html('Mohon cek ulang data yang wajib diinput.');
                $("#success-message-kategori").hide();
                $("#error-message-kategori").show();
            }
        });

        $('#deleteKategoriKasus').click(function() {
        if (confirm("Apakah anda yakin ingin menghapus kategori ini?") == true) {
            let token   = $("meta[name='csrf-token']").attr("content");
            uuid = $('#uuid_kategori').val();
            $.ajax({
            url: `{{ env('APP_URL') }}/settingkategorikasus/destroy/`+uuid,
            type: "POST",
            cache: false,
            data: {
                _method:'DELETE',
                _token: token
            },
            success: function (response){
                if (response.success != true) {
                    console.log(response);
                    $('#message-kategori').html(JSON.stringify(response));
                    $("#success-message-kategori").hide();
                    $("#error-message-kategori").show();
                }else{
                    $('#kategoriKasusModal').modal('hide');
                    $("#success-message-kategori").hide();
                    $("#error-message-kategori").hide();

                    $('#tabelKategoriKasus').DataTable().ajax.reload();

                    // hapus semua inputan
                    $('#uuid_kategori').val('');
                    $('#jenis_kode_kategori').val('').change();
                    $('#bentuk_kode_kategori').val('').change();
                    $('#kategori_kode').val('');
                    $('#kategori_nama').val('');
                    $("#usia").val('');
                    $("#jenis_kelamin").val('');
                    $("#terlapor").val('').change();
                    $("#lokasi").val('').change();
                    $("#definisi").val('');
                    $("#dasar_hukum").val('').change();
                }
            },
            error: function (response){
                setTimeout(function(){
                $("#overlayKategori").fadeOut(300);
                },500);
                console.log(response);

                $('#message-kategori').html(JSON.stringify(response));
                $("#success-message-kategori").hide();
                $("#error-message-kategori").show();
            }
            }).done(function() { //loading submit form
                setTimeout(function(){
                $("#overlayKategori").fadeOut(300);
                },500);
            });
            
        }
    });
    
    function getJenisKekerasan() {
        $("#jenis_kode_kategori").select2({
            ajax: { 
            url: '{{ route("api.v1.jeniskekerasan") }}',
            type: "GET",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {                         
                search: params.term, // search term
                };
            },
            processResults: function (response) {
            $("#overlay").hide();
                return {
                results: response
                };
            },
            cache: false
            }
        });
        //Initialize Select2 Elements
        $('.select2bs4').select2({
        theme: 'bootstrap4'
        });
        $('.select-tag').select2({
        tags: true,
        theme: 'bootstrap4'
        });
    }

    function getBentukKekerasan() {
        jenis_kekerasan = $('#jenis_kode_kategori').val();
        console.log(jenis_kekerasan);
        $("#bentuk_kode_kategori").select2({
            ajax: { 
            url: '{{ route("api.v1.bentukkekerasan") }}',
            type: "GET",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                jenis_kekerasan: jenis_kekerasan, // munculkan bentuk berdasarkan jenis kekerasan yang sudah dipilih
                search: params.term, // search term
                };
            },
            processResults: function (response) {
            $("#overlay").hide();
                return {
                results: response
                };
            },
            cache: false
            }
        });
        //Initialize Select2 Elements
        $('.select2bs4').select2({
        theme: 'bootstrap4'
        });
        $('.select-tag').select2({
        tags: true,
        theme: 'bootstrap4'
        });
    }

    function getJenisKekerasan2() {
    $("#jenis_kekerasan2").select2({
        ajax: { 
          url: '{{ route("api.v1.jeniskekerasan") }}',
          type: "GET",
          dataType: 'json',
          delay: 250,
          data: function (params) {
            return {
              search: params.term, // search term
            };
          },
          processResults: function (response) {
          $("#overlay").hide();
            return {
              results: response
            };
          },
          cache: false
        }
    });
    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
      });
      $('.select-tag').select2({
      tags: true,
      theme: 'bootstrap4'
    });
  }

  function getBentukKekerasan2() {
    jenis_kekerasan = $('#jenis_kekerasan2').val();
    $("#bentuk_kekerasan2").select2({
        ajax: { 
          url: '{{ route("api.v1.bentukkekerasan") }}',
          type: "GET",
          dataType: 'json',
          delay: 250,
          data: function (params) {
            return {
              jenis_kekerasan: jenis_kekerasan, // munculkan bentuk berdasarkan jenis kekerasan yang sudah dipilih
              search: params.term, // search term
            };
          },
          processResults: function (response) {
          $("#overlay").hide();
            return {
              results: response
            };
          },
          cache: false
        }
    });
    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
      });
      $('.select-tag').select2({
      tags: true,
      theme: 'bootstrap4'
    });
  }

  function getKategoriKasus2() {
    jenis_kekerasan = $('#jenis_kekerasan2').val();
    bentuk_kekerasan = $('#bentuk_kekerasan2').val();
    $("#kategori_kasus2").select2({
        ajax: { 
          url: '{{ route("api.v1.kategorikasus") }}',
          type: "GET",
          dataType: 'json',
          delay: 250,
          data: function (params) {
            return {
              jenis_kekerasan: jenis_kekerasan, // munculkan kategori kasus berdasarkan jenis kekerasan yang sudah dipilih
              bentuk_kekerasan: bentuk_kekerasan, // munculkan kategori kasus berdasarkan jenis kekerasan yang sudah dipilih
              search: params.term, // search term
            };
          },
          processResults: function (response) {
          $("#overlay").hide();
            return {
              results: response
            };
          },
          cache: false
        }
    });
    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
      });
      $('.select-tag').select2({
      tags: true,
      theme: 'bootstrap4'
    });
  }
</script>
@endsection