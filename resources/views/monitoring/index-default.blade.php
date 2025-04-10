@extends('layouts.template')

@section('content')
<style>
  .apexcharts-legend-series {
    margin-top: 15px !important;
  }
</style>
 <!-- daterange picker -->
 <link rel="stylesheet" href="{{ asset('adminlte') }}/plugins/daterangepicker/daterangepicker.css">

  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0"><i class="nav-icon fas fa-tv  "></i> Monitoring</h1>
        </div><!-- /.col -->
        <div class="col-sm-6 text-right">
          <input type="checkbox" class="btn-xs" id="kontainerwidth"
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
  <section class="content">
      <div class="container-fluid">

        <div class="row">
          {{-- grafik batang jumlah kasus kekerasan berdasarkan periodenya (bisa pertahun atau dikostum lebih detail) --}}
          <div class="col-md-12">
            <div id="accordion2">
              <div class="card card-primary direct-chat direct-chat-primary">
                  <div class="card-header">
                    <h3 class="card-title">Monitoring Aktivitas Kasus</h3>
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-widget="chat-pane-toggle">
                        <i class="fas fa-filter"></i>
                      </button>
                      <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                      </button>
                      <button onclick="load_data2()" type="button" class="btn btn-tool" data-toggle="collapse" data-target="#collapse2" aria-expanded="true" aria-controls="collaps">
                        <i class="fas fa-chevron-down"></i>
                      </button>
                    </div>
                  </div>
                  
                  <div class="card-body" style="overflow: hidden;">
                    <div id="overlay2" class="overlay dark" style="position: absolute; height:100%; width:100%">
                      <div class="cv-spinner">
                        <span class="spinner"></span>
                      </div>
                    </div>
                    <div id="collapse2" class="collapse" data-parent="#accordion2" style="overflow-x:scroll">
                      <div style="padding: 10px">
                        Filter : <span id="filter2"></span>
                      </div>
                      <div style="margin: 10px; ">
                      <table id="tabelMonitoring" class="table table-sm table-bordered  table-hover" style="cursor:pointer">
                        <thead>
                        <tr>
                        <th>Tgl Pelaporan</th>
                        <th>No Regis</th>
                        <th>Nama</th>
                        <th>Penerima Pengaduan</th>
                        <th>Manajer Kasus</th>
                        <th>Supervisor Kasus</th>
                        <th>Skor Total</th>
                        <th>Kelengkapan Data</th>
                        <th>Data Klasifikasi</th>
                        <th>Komponen Petugas</th>
                        <th>Surat Persetujuan</th>
                        <th>Kronologis</th>
                        <th>BPSS</th>
                        <th>Progres Layanan</th>
                        <th>Pemantauan & Evaluasi</th>
                        <th>Terminasi</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                        <tr>
                          <tr>
                          <th>Tgl Pelaporan</th>
                          <th>No Regis</th>
                          <th>Nama</th>
                          <th>Penerima Pengaduan</th>
                          <th>Manajer Kasus</th>
                          <th>Supervisor Kasus</th>
                          <th>Skor Total</th>
                          <th>Kelengkapan Data</th>
                          <th>Data Klasifikasi</th>
                          <th>Komponen Petugas</th>
                          <th>Surat Persetujuan</th>
                          <th>Kronologis</th>
                          <th>BPSS</th>
                          <th>Progres Layanan</th>
                          <th>Pemantauan & Evaluasi</th>
                          <th>Terminasi</th>
                        </tr>
                        </tfoot>
                        </table>       
                      </div>
                      <div class="direct-chat-contacts" style="padding: 10px; height:100%; z-index:100">
                        <div class="row">
                          <div class="col-md-12">
                            <button onclick="load_data1()" type="button" class="btn btn-warning btn-xs float-right" data-widget="chat-pane-toggle">
                              <i class="fas fa-undo"></i> Reset
                            </button>
                          </div>

                          <div class="col-md-12">

                            <div class="form-group">
                              <label for="">Basis Tanggal</label>
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <select id="filter1BasisTanggal2" class="form-control btn-primary">
                                    <option value="tanggal_pelaporan" selected>Default ( Berdasarkan Tanggal Pelaporan )</option>
                                    <option value="tanggal_kejadian">Berdasarkan Tanggal Kejadian</option>
                                    <option value="created_at">Berdasarkan Tanggal Input</option>
                                  </select>
                                </div>
                                <input type="text" class="form-control daterank" id="filter1Tanggal2" value="2024-01-01 - {{ date("Y").'/'.date("m").'/'.date("d") }}">
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="">Kasus Anda</label>
                              <br>
                              <div class="icheck-primary d-inline">
                                  <input type="radio" id="radioPrimary2b" name="filter2Anda" {{ !in_array(Auth::user()->jabatan, ['Kepala Instansi', 'Super Admin', 'Tenaga Ahli', 'Sekretariat', 'Tim Data']) ? 'checked' : '' }} value="0">
                                <label for="radioPrimary2b">
                                    Kasus yang anda tangani saja
                                </label>
                              </div>
                              <div class="icheck-primary d-inline" style="margin-right:15px">
                                <input type="radio" id="radioPrimary1b" name="filter2Anda" {{ in_array(Auth::user()->jabatan, ['Kepala Instansi', 'Super Admin', 'Tenaga Ahli', 'Sekretariat', 'Tim Data']) ? 'checked' : '' }} value="1">
                                <label for="radioPrimary1b">
                                    Seluruh kasus
                                </label>
                              </div>
                            </div>
                            
                            <button onclick="load_data2()" type="button" class="btn btn-block btn-primary mt-4" data-widget="chat-pane-toggle">
                              <i class="fas fa-check"></i> Terapkan
                            </button>
                          </div>
                        </div>
                      </div>

                      </div>
                  </div>
                  </div>
              </div>
          </div>
        </div>

          <div class="row">
            {{-- grafik batang jumlah kasus kekerasan berdasarkan periodenya (bisa pertahun atau dikostum lebih detail) --}}
            <div class="col-md-6">
              <div id="accordion1">
                <div class="card card-primary direct-chat direct-chat-primary">
                    <div class="card-header">
                      <h3 class="card-title">Jumlah Korban Kekerasan</h3>
                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-widget="chat-pane-toggle">
                          <i class="fas fa-filter"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                        </button>
                        <button onclick="load_data1()" type="button" class="btn btn-tool" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collaps1">
                          <i class="fas fa-chevron-down"></i>
                        </button>
                      </div>
                    </div>
                    
                    <div class="card-body" style="overflow: hidden;">
                      <div id="overlay1" class="overlay dark" style="position: absolute; height:100%; width:100%">
                        <div class="cv-spinner">
                          <span class="spinner"></span>
                        </div>
                      </div>

                      <div id="collapse1" class="collapse" data-parent="#accordion1">
                        <div style="padding: 10px">
                          Filter : <span id="filter1"></span>
                        </div>
                        
                        <div id="chart" style="display: block; width: 100%; height: 100%; padding: 0px 20px"></div>
                        
                        <div class="direct-chat-contacts" style="padding: 10px; height:100%; z-index:100">
                          <div class="row">
                            <div class="col-md-12">
                              <button onclick="load_data1()" type="button" class="btn btn-warning btn-xs float-right" data-widget="chat-pane-toggle">
                                <i class="fas fa-undo"></i> Reset
                              </button>
                            </div>

                            <div class="col-md-12">
                              <div class="form-group">
                                <label for="">Pengelompokan Tanggal</label>
                                <br>
                                <div class="icheck-primary d-inline" style="margin-right:15px">
                                  <input type="radio" id="radioPrimary1" name="filter1Pengelompokan" value="tahun">
                                  <label for="radioPrimary1">
                                      Per Tahun
                                  </label>
                                </div>
                                <div class="icheck-primary d-inline">
                                  <input type="radio" id="radioPrimary2" name="filter1Pengelompokan" checked value="bulan">
                                  <label for="radioPrimary2">
                                      Per Bulan
                                  </label>
                                </div>
                              </div>

                              <div class="form-group">
                                <label for="">Basis Tanggal</label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <select id="filter1BasisTanggal" class="form-control btn-primary">
                                      <option value="tanggal_approve" selected>Default ( Berdasarkan Tanggal Diregis )</option>
                                      <option value="tanggal_pelaporan" >Berdasarkan Tanggal Pelaporan</option>
                                      <option value="tanggal_kejadian">Berdasarkan Tanggal Kejadian</option>
                                      <option value="created_at">Berdasarkan Tanggal Input</option>
                                    </select>
                                  </div>
                                  <input type="text" class="form-control daterank" id="filter1Tanggal" value="2024-01-01 - {{ date("Y").'/'.date("m").'/'.date("d") }}">
                                </div>
                              </div>

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

                              <div class="form-group">
                                <label for="">Basis Penghitungan Usia Klien</label>
                                <select class="form-control" id="filter1PenghitunganUsia">
                                  <option selected>Default ( Tanggal Hari Ini dikurangi Tanggal Lahir )</option>
                                  <option value="lapor">Tanggal Pelaporan dikurangi Tanggal Lahir</option>
                                  <option value="kejadian">Tanggal Kejadian dikurangi Tanggal Lahir</option>
                                  <option value="input">Tanggal Input dikurangi Tanggal Lahir</option>
                                </select>
                              </div>

                              <div class="form-group">
                                <label for="">Kasus yang Diregis</label>
                                <br>
                                <div class="icheck-primary d-inline" style="margin-right:15px">
                                  <input type="radio" id="radioPrimary1a" name="filter1Regis" checked value="0">
                                  <label for="radioPrimary1a">
                                      Seluruh kasus
                                  </label>
                                </div>
                                <div class="icheck-primary d-inline">
                                  <input type="radio" id="radioPrimary2a" name="filter1Regis" value="1">
                                  <label for="radioPrimary2a">
                                      Kasus yang sudah diregis saja
                                  </label>
                                </div>
                              </div>

                              <div class="form-group">
                                <label for="">Kasus yang Diarsipkan</label>
                                <br>
                                <div class="icheck-primary d-inline" style="margin-right:15px">
                                  <input type="radio" id="radioPrimary1b" name="filter1Arsip" checked value="0">
                                  <label for="radioPrimary1b">
                                      Tanpa kasus yang diarsipkan
                                  </label>
                                </div>
                                <div class="icheck-primary d-inline">
                                  <input type="radio" id="radioPrimary2b" name="filter1Arsip" value="1">
                                  <label for="radioPrimary2b">
                                      Dengan kasus yang diarsipkan
                                  </label>
                                </div>
                              </div>
                              
                              <button onclick="load_data1()" type="button" class="btn btn-block btn-primary mt-4" data-widget="chat-pane-toggle">
                                <i class="fas fa-check"></i> Terapkan
                              </button>
                            </div>
                          </div>
                        </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
          </div>
      </div>
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
      <div class="modal-footer" id="buttons">
      </div>
    </div>
  </div>
</div>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> 
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
  // remove class content agar bisa lebih besar tampilannya
  $('#kontainer').removeClass('container');
  //Date range picker
  $('.daterank').daterangepicker(
    {
        locale: {
            format: 'YYYY-MM-DD'
        }
    }
  );

  // data1 : diagram garis jumlah korban kekerasan
  function load_data1() {
    // show load 
    $("#overlay1").show();
    // filter 
    pengelompokan = $('input[name="filter1Pengelompokan"]:checked').val();
    basisTanggal = $('#filter1BasisTanggal').val();
    tanggal = $('#filter1Tanggal').val();
    basisWilayah = $('#filter1BasisWilayah').val();
    wilayah = $('#filter1Wilayah').val();
    penghitunganUsia = $('#filter1PenghitunganUsia').val();
    regis = $('input[name="filter1Regis"]:checked').val();
    arsip = $('input[name="filter1Arsip"]:checked').val();
    $.ajax({
      url:'{{ route("api.v1.jumlahkorban") }}?pengelompokan='+pengelompokan+'&basis_tanggal='+basisTanggal+'&tanggal='+tanggal+'&basis_wilayah='+basisWilayah+'&wilayah='+wilayah+'&penghitungan_usia='+penghitunganUsia+'&regis='+regis+'&arsip='+arsip,
      type:'GET',
      dataType: 'json',
      success: function (response){
        // setup filter
        $('#filter1').html('');
        $.each(response.filter, function(key, value) {
          $('#filter1').append("<span class=\"badge bg-primary\">"+key.replace(/_/g, ' ')+" : "+value.replace(/_/g, ' ')+"</span> ");
        });
        $('#filter1').append("<span class=\"badge bg-warning\">Data ini disajikan pada : "+getCurrentDateTime()+"</span> ");
        datas = response.data;
        
        // setup chart
        var options = {
          series: [
          {
            name: "Total Seluruh Kasus",
            data: datas.seluruh_klien
          },
          {
            name: "Perempuan Dewasa",
            data: datas.dewasa_perempuan
          },
          {
            name: "Anak Perempuan",
            data: datas.anak_perempuan
          },
          {
            name: "Anak Laki-laki",
            data: datas.anak_laki
          }
        ],
          chart: {
          height: 380,
          type: 'line'
        },
        colors: ['#545454', '#fcba03', '#fc03be', '#36a2eb'],
        dataLabels: {
          enabled: true,
        },
        stroke: {
          width: [5, 5, 5, 5],
          curve: 'straight',
          dashArray: [8, 0, 0, 0]
        },
        title: {
          text: 'Sumber : Database PPPA Prov. DKI Jakarta',
          align: 'left'
        },
        grid: {
          borderColor: '#e7e7e7',
          row: {
            colors: ['#f3f3f3', 'transparent', 'transparent', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.5
          },
        },
        markers: {
          size: 1
        },
        xaxis: {
          categories: response.periode,
          title: {
            text: pengelompokan.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                      return letter.toUpperCase();
                  })
          }
        },
        yaxis: {
          y: 0,
          labels: {
            formatter: function(val) {
              return val.toFixed(0);
            }
          },
          title: {
            text: 'Jumlah Kasus'
          },
          min: 0
        },
        legend: {
          position: 'top',
          horizontalAlign: 'right',
          floating: true,
          offsetY: -25,
          offsetX: -5
        }
        };
        
        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
        // hapus dulu char yang lama kemudian buat lagi
        chart.destroy();
        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
      },
      error: function (response){
          setTimeout(function(){
          $("#overlay1").fadeOut(300);
          },500);
          alert(response);
      }
      }).done(function() { //loading submit form
          setTimeout(function(){
          $("#overlay1").fadeOut(300);
          },500);
    });
  }

  function load_data2() {

    if ($.fn.DataTable.isDataTable('#tabelMonitoring')) {
        $('#tabelMonitoring').DataTable().destroy();
    }
    $('#filter2').html('');
    $('#filter2').append("<span class=\"badge bg-primary\">basis tanggal : "+$('#filter1BasisTanggal2').val()+"</span> ");
    $('#filter2').append("<span class=\"badge bg-primary\">tanggal : "+$('#filter1Tanggal2').val()+"</span> ");
    $('#filter2').append("<span class=\"badge bg-primary\">tampilkan seluruh kasus anda : "+$('input[name="filter2Anda"]:checked').val()+"</span> ");
    $('#filter2').append("<span class=\"badge bg-warning\">Data ini disajikan pada : "+getCurrentDateTime()+"</span> ");

    $('#tabelMonitoring').DataTable({
      "ordering": true,
      "order": [],
      "processing": true,
      "serverSide": true,
      "responsive": false, 
      "lengthChange": false, 
      "autoWidth": false,
      "ajax": "{{ env('APP_URL') }}/monitoring/monitoringkasus?user_id={{ Auth::user()->id }}&basis_tanggal=" + $('#filter1BasisTanggal2').val() + "&tanggal=" + $('#filter1Tanggal2').val() + "&anda=" + $('input[name="filter2Anda"]:checked').val(),
      'createdRow': function( row, data, dataIndex ) {
          $(row).attr('id', data.uuid);
        if (!data.no_klien) {
            $(row).find('td:eq(1)').css('background-color', '#ff828c');
        }
        if (!data.manajer_kasus) {
            $(row).find('td:eq(4)').css('background-color', '#ff828c');
        }
        if (!data.supervisor_kasus) {
            $(row).find('td:eq(5)').css('background-color', '#ff828c');
        }
        // perhitungan ini ada di https://docs.google.com/spreadsheets/d/1P9OIQcoRT9pS8SllrkaAPdFXqTXGfxlIawCYiUJLYis/edit#gid=1082026075
        // sheet 2 (DESAIN TABEL MONITORING KASUS)
        if (data.skor < 93) {
            $(row).find('td:eq(6)').css('background-color', '#ff828c').css('font-weight', 'bold').css('font-size', '18px');
        }else{
          $(row).find('td:eq(6)').css('background-color', '#82ff88').css('font-weight', 'bold').css('font-size', '18px');
        }
        if (data.kelengkapan_data < 40) {
            $(row).find('td:eq(7)').css('background-color', '#ff828c');
        }else{
          $(row).find('td:eq(7)').css('background-color', '#82ff88');
        }
        if (data.data_klasifikasi < 100) {
            $(row).find('td:eq(8)').css('background-color', '#ff828c');
        }else{
          $(row).find('td:eq(8)').css('background-color', '#82ff88');
        }
        if (data.komponen_petugas < 100) {
            $(row).find('td:eq(9)').css('background-color', '#ff828c');
        }else{
          $(row).find('td:eq(9)').css('background-color', '#82ff88');
        }
        if (data.surat_persetujuan < 100) {
            $(row).find('td:eq(10)').css('background-color', '#ff828c');
        }else{
          $(row).find('td:eq(10)').css('background-color', '#82ff88');
        }
        if (data.kronologis < 100) {
            $(row).find('td:eq(11)').css('background-color', '#ff828c');
        }else{
          $(row).find('td:eq(11)').css('background-color', '#82ff88');
        }
        if (data.bpss < 100) {
            $(row).find('td:eq(12)').css('background-color', '#ff828c');
        }else{
          $(row).find('td:eq(12)').css('background-color', '#82ff88');
        }
        if (data.progres_layanan < 100) {
            $(row).find('td:eq(13)').css('background-color', '#ff828c');
        }else{
          $(row).find('td:eq(13)').css('background-color', '#82ff88');
        } 
        if (data.pemantauan_evaluasi < 100) {
            $(row).find('td:eq(14)').css('background-color', '#ff828c');
        }else{
          $(row).find('td:eq(14)').css('background-color', '#82ff88');
        }
        if (data.terminasi_kasus < 100) {
            $(row).find('td:eq(15)').css('background-color', '#ff828c');
        }else{
          $(row).find('td:eq(15)').css('background-color', '#82ff88');
        }
      },
      "columns": [
        {"data": "tanggal_pelaporan"},
        {"data": "no_klien"},
        {"data": "nama"},
        {"data": "penerima_pengaduan"},
        {"data": "manajer_kasus"},
        {"data": "supervisor_kasus"},
        {"data": "skor"},
        {"data": "kelengkapan_data"},
        {"data": "data_klasifikasi"},
        {"data": "komponen_petugas"},
        {"data": "surat_persetujuan"},
        {"data": "kronologis"},
        {"data": "bpss"},
        {"data": "progres_layanan"},
        {"data": "pemantauan_evaluasi"},
        {"data": "terminasi_kasus"}
      ],
        "initComplete": function(settings, json) {
          $("#overlay2").hide();
        },
      "pageLength": 25,
      "lengthMenu": [
          [10, 25, 50, 100, -1],
          ['10 rows', '25 rows', '50 rows', '100 rows','All'],
      ],
      "dom": 'Blfrtip', // Blfrtip or Bfrtip
      "buttons": ["pageLength", "copy", "excel", "pdf"]
      }).buttons().container().appendTo('#tabelMonitoring_wrapper .col-md-6:eq(0)');
      $('#tabelMonitoring_filter').css({'float':'right','display':'inline-block; background-color:black'});

      $('#tabelMonitoring tbody').on('click', 'tr', function () {
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
        $('#buttons').append('<a href="' + "{{ route('kasus.show', '') }}" + '/' + data.uuid + '" class="btn btn-primary btn-block" id="detail"><i class="fa fa-info-circle"></i> Detail Kasus (Bisa New Tab)</a>');

        // list petugas
        $('#listPetugas').html('');
        listPetugas = data.list_petugas;
        listPetugas.forEach(e => {
          $('#listPetugas').append('<li><b>'+e.name+'</b> ('+e.jabatan+')</li>')
        });
          
          $("#overlay").hide();
        });
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
            if (response.deadline_pemantauan <= 10 || response.terakhir_pemantauan == null) {
                // kalau deadlinenya kurang dari 10 hari berarti harusnya udah dilakukan Pemantauan & Evaluasi lagi
                $('.warningIntervensi').show();
            } else {
                $('.warningIntervensi').hide();
                $('#check_pemantauan').show();
                kelengkapan_kasus = kelengkapan_kasus + 1;
                $('#kelengkapan_kasus').html(kelengkapan_kasus);

                $('#messagePemantauan').html(response.message);
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



  function getCurrentDateTime() {
        var currentDate = new Date();
        var day = currentDate.getDate();
        var month = currentDate.toLocaleString('default', { month: 'short' });
        var year = currentDate.getFullYear();
        var hours = currentDate.getHours();
        var minutes = currentDate.getMinutes();
        var seconds = currentDate.getSeconds();

        var formattedDateTime = ("0" + day).slice(-2) + ' ' + month + ' ' + year + ' ' + 
                                ("0" + hours).slice(-2) + ':' + 
                                ("0" + minutes).slice(-2) + ':' + 
                                ("0" + seconds).slice(-2);

        return formattedDateTime;
    }


    // Initial display
    $('#currentDateTime').text(getCurrentDateTime());

    // Update every second
    setInterval(function() {
        $('#currentDateTime').text(getCurrentDateTime());
    }, 1000);
</script>
@endsection