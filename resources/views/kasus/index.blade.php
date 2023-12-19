@extends('layouts.template')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><i class="nav-icon fas fa-search"></i> Kasus</h1>
          </div><!-- /.col -->
          <div class="col-sm-6 text-right">
            <input type="checkbox" class="btn-xs" id="kontainerwidth"
                  checked
                  data-bootstrap-switch 
                  data-on-text="Normal"
                  data-off-text="Fullwidth"
                  data-off-color="default" 
                  data-on-color="default">
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    @if ((Auth::user()->jabatan == 'Penerima Pengaduan') || (Auth::user()->supervisor_id == 0))
    <section class="content">
        <div class="container-fluid">
          <div class="card">
              <div class="card-header">
              <h3 class="card-title">Lapor KBG (Laporan masuk dari aplikasi Lapor KBG)</h3>
              </div>
              
              <div class="card-body" style="overflow-x: scroll">
              <table id="tabelLaporKBG" class="table table-sm table-bordered  table-hover" style="cursor:pointer">
              <thead>
              <tr>
              <th>Tgl Pelaporan</th>
              <th>Nama</th>
              <th>Kategori Klien</th>
              <th>Pengaduan</th>
              <th>Status Terkahir</th>
              </tr>
              </thead>
              <tbody>
              </tbody>
              <tfoot>
              <tr>
              <th>Tgl Pelaporan</th>
              <th>Nama</th>
              <th>Kategori Klien</th>
              <th>Pengaduan</th>
              <th>Status</th>
              </tr>
              </tfoot>
              </table>
              </div>
              
              </div>
        </div><!-- /.container-fluid -->
      </section>
      @endif
    
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="card">
            {{-- <div class="card-header">
            <h3 class="card-title">DataTable with default features</h3>
            </div> --}}
            <input type="text" id="arsip" hidden>
            <div class="card-body" style="overflow-x: scroll">
            <table id="tabelKasus" class="table table-sm table-bordered  table-hover" style="cursor:pointer">
            <thead>
            <tr>
            <th>Tgl Pelaporan</th>
            <th>No Regis</th>
            <th>Nama</th>
            <th>Kategori Klien</th>
            <th>Pengaduan</th>
            <th>Status Terkahir</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
            <tr>
            <th>Tgl Pelaporan</th>
            <th>No Regis</th>
            <th>Nama</th>
            <th>Kategori Klien</th>
            <th>Pengaduan</th>
            <th>Status</th>
            </tr>
            </tfoot>
            </table>
            </div>
            
            </div>
      </div><!-- /.container-fluid -->
    </section>

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
              <div class="card-header">
              <h4 class="card-title w-100">
              <a class="d-block w-100" data-toggle="collapse" href="#collapseKelengkapan">
              <b>Kelengkapan Kasus (<span id="kelengkapan_kasus"></span>/6) </b>
              </a>
              </h4>
              </div>
              <div id="collapseKelengkapan" class="collapse show" data-parent="#accordionKelengkapan">
              <div class="card-body">
                  <ol style="padding:15px; margin :-25px 0px -20px 0px">
                      <li>
                          Identifikasi <i class="fa fa-check" id="check_identifikasi"></i>
                          <ul style="margin-left: -25px">
                              <li>
                                  Data Kasus (<span id="persen_title_data"></span>%)
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
        </div>
      </div>
      <div class="modal-footer" id="buttons">
      </div>
    </div>
  </div>
</div>

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
    $(function () {
    $('#tabelLaporKBG').DataTable({
      "ordering": true,
      "processing": true,
      "serverSide": true,
      "responsive": false, 
      "lengthChange": false, 
      "autoWidth": false,
      "ajax": "{{ env('APP_URL') }}/kasus?laporkbg=1",
      'createdRow': function( row, data, dataIndex ) {
          $(row).attr('id', data.uuid);
      },
      "columns": [
        {"data": "tanggal_pelaporan_formatted"},
        {"data": "nama"},
        {
            "mData": "status",
            "mRender": function (data, type, row) {
              dob = new Date(row.tanggal_lahir);
              var today = new Date(row.tanggal_pelaporan);
              var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));

              if (row.jenis_kelamin == 'laki-laki') {
                return 'Anak Laki-laki'
              }else if (age >= 18) {
                return 'Dewasa';
              }else{
                return 'Anak Perempuan';
              }
            }
        },
        {"data": "petugas"},
        {
            "mData": "jenis_kelamin",
            "mRender": function (data, type, row) {
              return '<span class="badge bg-primary">'+row.status+'</span>';
            }
        }
      ],
      "pageLength": 25,
      "lengthMenu": [
          [10, 25, 50, 100, -1],
          ['10 rows', '25 rows', '50 rows', '100 rows','All'],
      ],
      "dom": 'Blfrtip', // Blfrtip or Bfrtip
      "buttons": ["pageLength", "copy", "csv", "excel", "pdf", "print"]
      }).buttons().container().appendTo('#tabelLaporKBG_wrapper .col-md-6:eq(0)');

      $('#tabelLaporKBG_filter').css({'float':'right','display':'inline-block; background-color:black'});

    $('#tabelKasus').DataTable({
      "ordering": true,
      "processing": true,
      "serverSide": true,
      "responsive": false, 
      "lengthChange": false, 
      "autoWidth": false,
      "ajax": "{{ env('APP_URL') }}/kasus",
      'createdRow': function( row, data, dataIndex ) {
          $(row).attr('id', data.uuid);
      },
      "columns": [
        {"data": "tanggal_pelaporan_formatted"},
        {"data": "no_klien"},
        {"data": "nama"},
        {
            "mData": "status",
            "mRender": function (data, type, row) {
              dob = new Date(row.tanggal_lahir);
              var today = new Date(row.tanggal_pelaporan);
              var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));

              if (row.jenis_kelamin == 'laki-laki') {
                return 'Anak Laki-laki'
              }else if (age >= 18) {
                return 'Dewasa';
              }else{
                return 'Anak Perempuan';
              }
            }
        },
        {"data": "petugas"},
        {
            "mData": "jenis_kelamin",
            "mRender": function (data, type, row) {
              return '<span class="badge bg-primary">'+row.status+'</span>';
            }
        }
      ],
      "pageLength": 25,
      "lengthMenu": [
          [10, 25, 50, 100, -1],
          ['10 rows', '25 rows', '50 rows', '100 rows','All'],
      ],
      "dom": 'Blfrtip', // Blfrtip or Bfrtip
      "buttons": ["pageLength", "copy", "csv", "excel", "pdf", "print", {
                className: "btn-info",
                text: 'Lihat Kasus Diarsipkan',
                action: function (x) {
                  arsip = $('#arsip').val();
                  if (arsip == 1) {
                    $('#arsip').val(0);
                    x.currentTarget.innerText = 'Lihat Kasus Diarsipkan';
                  } else {
                    $('#arsip').val(1);
                    x.currentTarget.innerText = 'Lihat Kasus Aktif';
                  }
                  $('#tabelKasus').DataTable().ajax.url("{{ env('APP_URL') }}/kasus?arsip=" + $('#arsip').val()).load();
                  }
              }]
      }).buttons().container().appendTo('#tabelKasus_wrapper .col-md-6:eq(0)');

      $('#tabelKasus_filter').css({'float':'right','display':'inline-block; background-color:black'});
    });

    $('#tabelLaporKBG tbody').on('click', 'tr', function () {
      $.get(`{{ env('APP_URL') }}/kasus/show/`+this.id, function (data) {
          dob = new Date(data.tanggal_lahir);
          var today = new Date();
          var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));

          $('#nama').html(data.nama);
          $('#usia').html(age);
          $('#jenis_kelamin').html(data.jenis_kelamin);
          $('#no_klien').html(data.no_klien);
          $('#status').html(data.status);
          $('#ajaxModal').modal('show');

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
          if ('{{ Auth::user()->jabatan }}' == 'Penerima Pengaduan') {
            $('#buttons').append('<button type="button" class="btn btn-success btn-block" id="terima" onclick="terima_kasus(`'+data.uuid+'`)"><i class="fa fa-check"></i> Terima Kasus</button>');
          }
          $('#buttons').append('<button type="button" class="btn btn-primary btn-block" id="detail" onclick="window.location.assign(`'+"{{route('kasus.show', '')}}"+"/"+data.uuid+'`)"><i class="fa fa-info-circle"></i> Detail Kasus</button>');
          if ('{{ Auth::user()->jabatan }}' == 'Manajer Kasus' || '{{ Auth::user()->jabatan }}' == 'Penerima Pengaduan' || '{{ Auth::user()->supervisor_id }}' == 0) {
              $('#buttons').append('<button type="button" onclick="hapus(`'+data.uuid+'`)" class="btn btn-danger btn-block" id="hapus"><i class="fa fa-trash"></i> Hapus Kasus</button>');
          }
          
          $("#overlay").hide();
        });
    });

    $('#tabelKasus tbody').on('click', 'tr', function () {
      $.get(`{{ env('APP_URL') }}/kasus/show/`+this.id, function (data) {
        dob = new Date(data.tanggal_lahir);
        var today = new Date();
        var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));

        $('#nama').html(data.nama);
        $('#usia').html(age);
        $('#jenis_kelamin').html(data.jenis_kelamin);
        $('#no_klien').html(data.no_klien);
        $('#status').html(data.status);
        $('#ajaxModal').modal('show');

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
        $('#buttons').append('<button type="button" class="btn btn-primary btn-block" id="detail" onclick="window.location.assign(`'+"{{route('kasus.show', '')}}"+"/"+data.uuid+'`)"><i class="fa fa-info-circle"></i> Detail Kasus</button>');
        if ('{{ Auth::user()->jabatan }}' == 'Manajer Kasus' || '{{ Auth::user()->jabatan }}' == 'Penerima Pengaduan' || '{{ Auth::user()->supervisor_id }}' == 0) {
            $('#buttons').append('<button type="button" onclick="hapus(`'+data.uuid+'`)" class="btn btn-danger btn-block" id="hapus"><i class="fa fa-trash"></i> Hapus Kasus</button>');
        }
          
          $("#overlay").hide();
        });
    });

    function terima_kasus(uuid) {
      $.ajax({
            url:"{{ route('formpenerimapengaduan.update', 'uuid') }}",
            data: {
              uuid: uuid,
              created_by : '{{ Auth::user()->id }}', 
              data_update : 'klien', 
              _token: '{{csrf_token()}}',
              _method:'PUT'
            },
            type:'POST',
            dataType: 'json',
            success: function( response ) {
              $("#overlay").hide();
              $('#ajaxModal').modal('hide');
              $('#tabelLaporKBG').DataTable().ajax.reload();
              $('#tabelKasus').DataTable().ajax.reload();
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
                jml_null_kasus = response.nullKasus;
                jml_null_klien = response.nullKlien;
                jml_null_pelapor = response.nullPelapor;
                total_null = jml_null_kasus.length + jml_null_klien.length + jml_null_pelapor.length;
                total_all = parseInt(response.kolomKasus) + parseInt(response.kolomKlien) + parseInt(response.kolomPelapor);
                total_isi = total_all - total_null;
                persentase = (total_isi / total_all) * 100;
                persentase = persentase.toFixed(2);
                $('#persen_title_data').html(persentase);
                $('#persen_data').css('width', persentase+'%');
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
                if (response > 0) {
                    $('#check_pemantauan').show();
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
      if (confirm("Apakah anda yakin ingin menghapus kasus ini?") == true) {
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
                $('#ajaxModal').modal('hide');
            }
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
{{-- 
// alert('redirect ke : '+this.id);
// window.location.assign('{{ route("kasus.detail") }}') --}}
@endsection