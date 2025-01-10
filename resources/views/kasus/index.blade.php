@extends('layouts.template')
@section('content')
<!-- daterange picker -->
<link rel="stylesheet" href="{{ asset('adminlte') }}/plugins/daterangepicker/daterangepicker.css">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><i class="nav-icon fas fa-search"></i> Kasus</h1>
          </div><!-- /.col -->
          <div class="col-sm-6 text-right">
            <input type="checkbox" class="btn-xs" id="kontainerwidth"
            {{ Auth::user()->settings_kontainer_width == 'normal' ? 'checked' : '' }}
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
    @if (in_array(Auth::user()->jabatan, ['Penerima Pengaduan', 'Super Admin', 'Tenaga Ahli', 'Kepala Instansi', 'Tim Data']))
    <section class="content">
      <div class="container-fluid">

      <div id="accordion1">
        <div class="card card-light direct-chat direct-chat-light">
            <div class="card-header">
              <h3 class="card-title">Lapor KBG (Laporan masuk dari aplikasi Lapor KBG) <span class="badge bg-danger"><span id="jumlah_kasus_laporKBG"></span></span></h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collaps1">
                  <i class="fas fa-chevron-down"></i>
                </button>
              </div>
            </div>
            
            <div id="collapse1" class="collapse" data-parent="#accordion1">
              <div class="card-body" style="overflow-x: scroll">
                <table id="tabelLaporKBG" class="table table-sm table-bordered  table-hover" style="cursor:pointer">
                  <thead>
                  <tr>
                  <th>Tgl Pelaporan</th>
                  <th>Nama Klien</th>
                  <th>Kategori Klien</th>
                  <th>Pengaduan</th>
                  <th>Status Terakhir</th>
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
                  <th>Status Terakhir</th>
                  </tr>
                  </tfoot>
                  </table>
                </div>
              </div>
            </div>
        </div>
      </div>
      </section>
      @endif
    
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="card">
            {{-- <div class="card-header">
            <h3 class="card-title">DataTable with default features</h3>
            </div> --}}
            <div class="card-body" style="overflow-x: scroll">
              Filter aktif : 
              <span class="badge bg-primary">Basis Tanggal : <span id="filterBasisTanggal"></span> </span>
              <span class="badge bg-warning">Periode : <span id="filterTanggal"></span>  </span>
              <span class="badge bg-primary">Basis Wilayah : <span id="filterBasisWilayah"></span>  </span>
              <span class="badge bg-primary">Wilayah : <span id="filterWilayah"></span>  </span>
              <span class="badge bg-primary">Basis Perhitungan Usia : <span id="filterPenghitunganUsia"></span>  </span>
              <span class="badge bg-primary">Kategori Klien : <span id="filterKategori"></span>  </span>
              <span class="badge bg-primary">Tampilkan Seluruh Kasus : <span id="filterAnda"></span>  </span>
              <span class="badge bg-primary">Intervensiku : <span id="filterIntervensiku"></span>  </span>
              <span class="badge bg-primary">Pemantauan : <span id="filterPemantauan"></span>  </span>
              <span class="badge bg-primary">Arsip : <span id="filterArsip"></span>  </span>
              <span class="badge bg-primary">Terminasi : <span id="filterTerminasi"></span>  </span>
            <table id="tabelKasus" class="table table-sm table-bordered  table-hover" style="cursor:pointer">
            <thead>
            <tr>
            <th>Tgl Pelaporan</th>
            <th>No Regis</th>
            <th>Nama Klien</th>
            <th>Kategori Klien</th>
            <th>Pengaduan</th>
            <th>Status Terakhir</th>
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
            <th>Status Terakhir</th>
            </tr>
            </tfoot>
            </table>
            <b>Keterangan : </b><br>
            <table>
              <tr>
                <td>
                  <div style="background-color:rgb(255, 205, 205); width: 100px; height: 20px; display: inline-block; vertical-align: middle;"></div>
                </td>
                <td>
                  Warna merah artinya MK perlu segera melakukan Pemantauan & Evaluasi. Dan Petugas Layanan Lain memastikan laporan intervensi sudah diinputkan semua.
                  <br>
                  Gunakan <a href="#" onclick="$('#modalFilterKasus').modal('show'); return false;"><b>Filter</b></a> untuk menampilkan Kasus yang perlu segera dilakukan Pemantauan & Evaluasi.
                </td>
              </tr>
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

<!-- Modal Filter Kasus-->
<div class="modal fade" id="modalFilterKasus" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
      
      <div class="modal-header">
          <h5 class="modal-title" id="modelHeadingCatatan">Filter Kasus</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
      </div>

      <div class="modal-body">


    <div class="col-md-12">
      <div class="form-group">
        <label for="">Basis Tanggal</label>
        <div class="input-group">
          <div class="input-group-prepend">
            <select id="filter1BasisTanggal" class="form-control btn-primary">
              <option value="tanggal_pelaporan" selected>Default ( Berdasarkan Tanggal Pelaporan )</option>
              <option value="tanggal_approve">Berdasarkan Tanggal Diregis</option>
              <option value="tanggal_kejadian">Berdasarkan Tanggal Kejadian</option>
              <option value="created_at">Berdasarkan Tanggal Input</option>
            </select>
          </div>
          <input type="text" class="form-control daterank" id="filter1Tanggal" value="{{ date('Y') }}-01-01 - {{ date("Y").'/'.date("m").'/'.date("d") }}">
        </div>
      </div>
    </div>

    <div class="col-md-12">
    <div class="form-group">
      <label for="">Basis Wilayah</label>
      <div class="input-group">
        <div class="input-group-prepend">
          <select class="form-control btn-primary" id="filter1BasisWilayah">
            <option value="default" selected>Default ( Semua Wilayah )</option>
            <option value="tkp">Berdasarkan Wilayah TKP</option>
            <option value="ktp">Berdasarkan Wilayah KTP</option>
            <option value="satpel">Berdasarkan Wilayah Satpel</option>
          </select>
        </div>
        <select class="form-control" id="filter1Wilayah">
          <option value="default" selected>Default ( Semua Wilayah )</option>
          @foreach ($kota as $item) 
            <option value="{{ $item->code }}" >{{ $item->name }}</option> 
          @endforeach 
          <option value="luar">Luar DKI Jakarta</option>
        </select>
      </div>
    </div>
    </div>

    <div class="col-md-12">
      <div class="form-group">
      <label for="">Kategori Klien</label>
      <div class="input-group">
        <div class="input-group-prepend">
          <select class="form-control btn-primary" id="filter1PenghitunganUsia">
            <option selected>Default ( Tanggal Hari Ini dikurangi Tanggal Lahir )</option>
            <option value="lapor">Tanggal Pelaporan dikurangi Tanggal Lahir</option>
            <option value="kejadian">Tanggal Kejadian dikurangi Tanggal Lahir</option>
            <option value="input">Tanggal Input dikurangi Tanggal Lahir</option>
          </select>
        </div>
        <select class="form-control" id="filter1Kategori">
          <option selected value="semua">Default ( Semua Kategori Klien )</option>
          <option value="dewasa">Klien Perempuan Dewasa</option>
          <option value="anak">Klien Anak</option>
        </select>
      </div>
    </div>
    </div>

      <div class="col-md-12">
          <div class="form-group">
              <label for="">Kasus Anda</label>
              <br>
              <div class="icheck-primary d-inline">
                  <input type="radio" id="radioPrimary2b" name="filter1Anda" {{ !in_array(Auth::user()->jabatan, ['Kepala Instansi', 'Super Admin', 'Tenaga Ahli', 'Sekretariat', 'Tim Data']) ? 'checked' : '' }} value="0">
                <label for="radioPrimary2b">
                    Kasus yang anda tangani saja
                </label>
              </div>
              <div class="icheck-primary d-inline" style="margin-right:15px">
                <input type="radio" id="radioPrimary1b" name="filter1Anda" {{ in_array(Auth::user()->jabatan, ['Kepala Instansi', 'Super Admin', 'Tenaga Ahli', 'Sekretariat', 'Tim Data']) ? 'checked' : '' }} value="1">
                <label for="radioPrimary1b">
                    Seluruh kasus
                </label>
              </div>
            </div>
      </div>

      <div class="col-md-12">
          <div class="form-group">
              <label for="">Intervensi Anda</label>
              <br>
              <div class="icheck-primary d-inline">
                  <input type="radio" id="radioPrimary2f" name="filter1Intervensiku" value="1">
                <label for="radioPrimary2f">
                    Kasus yang BELUM ADA agenda intervensinya dari anda
                </label>
              </div>
              <div class="icheck-primary d-inline" style="margin-right:15px">
                <input type="radio" id="radioPrimary1f" name="filter1Intervensiku" checked value="0">
                <label for="radioPrimary1f">
                    Seluruh kasus
                </label>
              </div>
            </div>
      </div>

      <div class="col-md-12">
        <div class="form-group">
            <label for="">Pemantauan & Evaluasi</label>
            <br>
            <div class="icheck-primary d-inline" style="margin-right:15px">
              <input type="radio" id="radioPrimary1d" name="filter1Pemantauan" value="1">
              <label for="radioPrimary1d">
                  Kasus yang perlu segera dilakukan Pemantauan & Evaluasi saja
              </label>
            </div>
            <div class="icheck-primary d-inline">
              <input type="radio" id="radioPrimary2d" name="filter1Pemantauan" value="0" checked>
              <label for="radioPrimary2d">
                Seluruh kasus
              </label>
            </div>
          </div>
    </div>

    <div class="col-md-12">
      <div class="form-group">
          <label for="">Terminasi</label>
          <br>
          <div class="icheck-primary d-inline" style="margin-right:15px">
            <input type="radio" id="radioPrimary1e" name="filter1Terminasi" value="1">
            <label for="radioPrimary1e">
                Kasus yang sudah diterminasi
            </label>
          </div>
          <div class="icheck-primary d-inline">
            <input type="radio" id="radioPrimary2e" name="filter1Terminasi" value="0" checked>
            <label for="radioPrimary2e">
              Seluruh kasus
            </label>
          </div>
        </div>
  </div>

      <div class="col-md-12">
        <div class="form-group">
            <label for="">Arsip</label>
            <br>
            <div class="icheck-primary d-inline" style="margin-right:15px">
              <input type="radio" id="radioPrimary1c" name="filter1Arsip" checked value="0">
              <label for="radioPrimary1c">
                  Kasus yang aktif saja
              </label>
            </div>
            <div class="icheck-primary d-inline">
              <input type="radio" id="radioPrimary2c" name="filter1Arsip" value="1">
              <label for="radioPrimary2c">
                  Kasus yang diarsipkan saja
              </label>
            </div>
          </div>
    </div>
    </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-success btn-block" onclick="submitFilterKasus()"><i class="fa fa-check"></i> Terapkan</button>
          <button type="button" class="btn btn-warning btn-block" onclick="location.reload()"><i class="fas fa-undo"></i> Reset</button>
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
<!-- InputMask -->
<script src="{{ asset('adminlte') }}/plugins/moment/moment.min.js"></script>
<script src="{{ asset('adminlte') }}/plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- date-range-picker -->
<script src="{{ asset('adminlte') }}/plugins/daterangepicker/daterangepicker.js"></script>

<script>
  $('.daterank').daterangepicker(
    {
        locale: {
            format: 'YYYY-MM-DD'
        }
    }
  );
    $(function () {
      // initialization
      var basisTanggal = $('#filter1BasisTanggal').val();
      var tanggal = $('#filter1Tanggal').val();
      var basis_wilayah = $('#filter1BasisWilayah').val();
      var wilayah = $('#filter1Wilayah').val();
      var anda = $('input[name="filter1Anda"]:checked').val();
      var intervensiku = $('input[name="filter1Intervensiku"]:checked').val();
      var pemantauan = $('input[name="filter1Pemantauan"]:checked').val();
      var arsip = $('input[name="filter1Arsip"]:checked').val();
      var terminasi = $('input[name="filter1Terminasi"]:checked').val();
      var penghitungan_usia = $('#filter1PenghitunganUsia').val();
      var kategori = $('#filter1Kategori').val();
      $('#filterBasisTanggal').html(basisTanggal);
      $('#filterTanggal').html(tanggal);
      $('#filterBasisWilayah').html(basis_wilayah);
      $('#filterWilayah').html(wilayah);
      $('#filterAnda').html(anda);
      $('#filterArsip').html(arsip);
      $('#filterTerminasi').html(terminasi);
      $('#filterIntervensiku').html(intervensiku);
      $('#filterPemantauan').html(pemantauan);
      $('#filterPenghitunganUsia').html(penghitungan_usia);
      $('#filterKategori').html(kategori);

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
      "buttons": ["pageLength", "copy", "csv", "excel", "pdf", "print"],
      "initComplete": function(settings, json) {
        // Check if DataTables API is available
        if ($.fn.DataTable.isDataTable('#tabelLaporKBG')) {
            // Get the DataTable instance
            var table = $('#tabelLaporKBG').DataTable();

            // Get the information about the current state
            var pageInfo = table.page.info();

            // Get the total number of records
            var totalRecords = pageInfo.recordsTotal;

            $('#jumlah_kasus_laporKBG').html(totalRecords+' kasus');
        } else {
            console.error("DataTable initialization failed.");
        } 
      }
      }).buttons().container().appendTo('#tabelLaporKBG_wrapper .col-md-6:eq(0)');

      $('#tabelLaporKBG_filter').css({'float':'right','display':'inline-block; background-color:black'});

    $('#tabelKasus').DataTable({
      "ordering": true,
      "order": [],
      "processing": true,
      "serverSide": true,
      "responsive": false, 
      "lengthChange": false, 
      "autoWidth": false,
      "ajax": "{{ env('APP_URL') }}/kasus?basis_tanggal=" + $('#filter1BasisTanggal').val() + "&basis_wilayah=" + $('#filter1BasisWilayah').val() + "&wilayah=" + $('#filter1Wilayah').val() + "&tanggal=" + $('#filter1Tanggal').val() + "&arsip=" + $('input[name="filter1Arsip"]:checked').val() + "&terminasi=" + $('input[name="filter1Terminasi"]:checked').val() + "&pemantauan=" + $('input[name="filter1Pemantauan"]:checked').val() + "&anda=" + $('input[name="filter1Anda"]:checked').val() + "&intervensiku=" + $('input[name="filter1Intervensiku"]:checked').val(),
      'createdRow': function( row, data, dataIndex ) {
          $(row).attr('id', data.uuid);

          if (data.jatuh_tempo >= 172 && (data.jumlah_terminasi == 0 || data.jumlah_terminasi == null) && {{ env('mode_iso') }} == 0) {
            $(row).attr('class', 'warning_table');
          }
      },
      "columns": [
        {"data": "tanggal_pelaporan_formatted"},
        {"data": "no_klien"},
        {
            "mData": "nama",
            "mRender": function (data, type, row) {
              return row.nama+' ('+row.usia+')';
            }
          },
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
            "mData": "status_terakhir",
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
      "buttons": ["pageLength", "copy", "excel", "pdf", {
                className: "btn-info",
                text: 'Filter',
                action: function (x) {

                  $('#modalFilterKasus').modal('show');
                  // arsip = $('#arsip').val();
                  // $('#tabelKasus').DataTable().ajax.url("{{ env('APP_URL') }}/kasus?arsip=" + $('#arsip').val()).load();
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
          $('#buttons').append('<a href="#" onclick="alert(`Fitur belum tersedia`)" class="btn btn-warning btn-block" id="rekap"><i class="fas fa-stream"></i> Rekap Kasus</a>');
          // $('#buttons').append('<a href="#" onclick="rekap_kasus(`' + data.uuid + '`)" class="btn btn-warning btn-block" id="rekap"><i class="fas fa-stream"></i> Rekap Kasus</a>');
          $('#buttons').append('<a href="' + "{{ route('kasus.show', '') }}" + '/' + data.uuid + '" class="btn btn-primary btn-block" id="detail"><i class="fa fa-info-circle"></i> Detail Kasus (Bisa New Tab)</a>');
          if ( data.no_klien == null && "{{ in_array(Auth::user()->jabatan, ['Manajer Kasus', 'Penerima Pengaduan', 'Super Admin']) }}") {
              $('#buttons').append('<button type="button" onclick="hapus(`'+data.uuid+'`)" class="btn btn-danger btn-block" id="hapus"><i class="fa fa-trash"></i> Hapus Kasus</button>');
          }else{
            $('#buttons').append('<div>*Anda tidak memiliki akses atau kasus ini sudah ada no regisnya sehingga anda tidak dapat menghapus kasus ini</div>');
          }

          // list petugas
          listPetugas = data.list_petugas;
          listPetugas.forEach(e => {
            $('#listPetugas').append('<li>'+e.name+' ('+e.jabatan+')</li>')
          });
          
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

              // Update jumlah kasus laporKBG dalam badge
              if ($.fn.DataTable.isDataTable('#tabelLaporKBG')) {
                  // Get the DataTable instance
                  var table = $('#tabelLaporKBG').DataTable();

                  // Get the information about the current state
                  var pageInfo = table.page.info();

                  // Get the total number of records
                  var totalRecords = pageInfo.recordsTotal;

                  $('#jumlah_kasus_laporKBG').html(totalRecords+' kasus');
              } else {
                  console.error("DataTable initialization failed.");
              } 
            }
        });
    }

    function submitFilterKasus() {
      var basisTanggal = $('#filter1BasisTanggal').val();
      var tanggal = $('#filter1Tanggal').val();
      var basis_wilayah = $('#filter1BasisWilayah').val();
      var wilayah = $('#filter1Wilayah').val();
      var anda = $('input[name="filter1Anda"]:checked').val();
      var intervensiku = $('input[name="filter1Intervensiku"]:checked').val();
      var pemantauan = $('input[name="filter1Pemantauan"]:checked').val();
      var arsip = $('input[name="filter1Arsip"]:checked').val();
      var terminasi = $('input[name="filter1Terminasi"]:checked').val();
      var penghitungan_usia = $('#filter1PenghitunganUsia').val();
      var kategori = $('#filter1Kategori').val();
      var url = "{{ env('APP_URL') }}/kasus?basis_tanggal=" + basisTanggal + "&tanggal=" + tanggal + "&basis_wilayah=" + basis_wilayah + "&wilayah=" + wilayah + "&arsip=" + arsip + "&terminasi=" + terminasi + "&pemantauan=" + pemantauan + "&anda=" + anda + "&intervensiku=" + intervensiku + "&penghitungan_usia=" + penghitungan_usia + "&kategoriklien=" + kategori;

      $('#filterBasisTanggal').html(basisTanggal);
      $('#filterTanggal').html(tanggal);
      $('#filterBasisWilayah').html(basis_wilayah);
      $('#filterWilayah').html(wilayah);
      $('#filterAnda').html(anda);
      $('#filterIntervensiku').html(intervensiku);
      $('#filterPemantauan').html(pemantauan);
      $('#filterArsip').html(arsip);
      $('#filterTerminasi').html(terminasi);
      $('#filterPenghitunganUsia').html(penghitungan_usia);
      $('#filterKategori').html(kategori);

      $('#tabelKasus').DataTable().ajax.url(url).load();

      $('#modalFilterKasus').modal('hide');
    }

    function rekap_kasus(uuid) {
      $.ajax({
            url:"{{ route('kasus.rekap') }}",
            data: {
              uuid: uuid,
              _token: '{{csrf_token()}}'
            },
            type:'POST',
            dataType: 'json',
            success: function( response ) {
              console.log(response);
            }
        });
    }
  </script>
{{-- 
// alert('redirect ke : '+this.id);
// window.location.assign('{{ route("kasus.detail") }}') --}}
@endsection