@extends('layouts.template')

@section('content')
<style>
  .apexcharts-legend-series {
    margin-top: 15px !important;
  }

  .copy-area {
    height: 300px;
    overflow-y: scroll;
    background-color: rgb(157, 255, 255);
    padding: 10px;
  }

  .card-title { 
    font-weight: bold;
    font-size: 20px;
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
            <div id="accordion1">
              <div class="card card-primary direct-chat direct-chat-primary">
                  <div class="card-header">
                    <h3 class="card-title">Monitoring Aktivitas Kasus</h3>
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-widget="chat-pane-toggle">
                        <i class="fas fa-filter"></i>
                      </button>
                      <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                      </button>
                      <button onclick="load_data1()" type="button" class="btn btn-tool" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collaps">
                        <i class="fas fa-chevron-down"></i>
                      </button>
                    </div>
                  </div>
                  <div class="card-body" style="overflow: hide;">
                    <div id="collapse1" class="collapse" data-parent="#accordion1" style="overflow-x:scroll">

                      <span style="color: red; margin:10px; font-size:20px; font-weight:bold" id="label_monitoring_kasus_mv">
                        *Data reasltime membutuhkan waktu lebih lama untuk ditampilkan. 
                        <a href="#" onclick="load_data1()">Tampilkan Data Terdahulu</a> 
                      </span>

                      <span style="color: red; margin:10px; font-size:20px; font-weight:bold" id="label_monitoring_kasus">
                        *Terakhir direkap oleh sistem pukul {{ $terakhir_update_monitoring_kasus }} . 
                        <a href="#" onclick="load_data1a()">Tampilkan data terupdate saat ini</a> (membutuhkan waktu lebih lama).
                      </span>

                      <div id="overlay1" class="overlay dark" style="position: absolute; height:100%; width:100%; font-size:25px">
                        <div class="cv-spinner">
                          <span style="position: absolute">
                            Klik icon "<i class="fas fa-chevron-down"></i>" jika anda belum mengkliknya
                          </span>
                          <span class="spinner"></span>
                        </div>
                      </div>
                      <div style="padding: 10px">
                        Filter : <span id="filter1"></span>
                      </div>
                      <div style="margin: 10px; ">
                      <table id="tabelMonitoring" class="table table-sm table-bordered  table-hover" style="cursor:pointer">
                        <thead>
                        <tr>
                        <th>Tgl Pelaporan</th>
                        <th>No Regis</th>
                        <th>Nama Klien</th>
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
                                  <select id="filterBasisTanggal1" class="form-control btn-primary">
                                    <option value="tanggal_pelaporan" selected>Default ( Berdasarkan Tanggal Pelaporan )</option>
                                    <option value="tanggal_kejadian">Berdasarkan Tanggal Kejadian (Hanya yang ada Tanggal Kejadiannya)</option>
                                    <option value="created_at">Berdasarkan Tanggal Input</option>
                                  </select>
                                </div>
                                <input type="text" class="form-control daterank" id="filterTanggal1" value="2024-01-01 - {{ date("Y").'/'.date("m").'/'.date("d") }}">
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="">Kasus Anda</label>
                              <br>
                              <div class="icheck-primary d-inline">
                                  <input type="radio" id="filterAnda1a" name="filterAnda1" {{ !in_array(Auth::user()->jabatan, ['Kepala Instansi', 'Super Admin', 'Tenaga Ahli', 'Sekretariat', 'Tim Data']) ? 'checked' : '' }} value="0">
                                <label for="filterAnda1a">
                                    Kasus yang anda tangani saja
                                </label>
                              </div>
                              <div class="icheck-primary d-inline" style="margin-right:15px">
                                <input type="radio" id="filterAnda1b" name="filterAnda1" {{ in_array(Auth::user()->jabatan, ['Kepala Instansi', 'Super Admin', 'Tenaga Ahli', 'Sekretariat', 'Tim Data']) ? 'checked' : '' }} value="1">
                                <label for="filterAnda1b">
                                    Seluruh kasus
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

          <div class="row">
            <div class="col-md-6">
              <div id="accordion0">
                <div class="card card-primary direct-chat direct-chat-primary">
                    <div class="card-header">
                      <h3 class="card-title">Profil PPPA DKI Jakarta (Data Update 1 Jam Sekali)</h3>
                      <div class="card-tools">
                        <a href="https://docs.google.com/presentation/d/1-JZxiRPzt-ndAyCNZauT63gjvnqn9Pd5nhZ5jf0XVMU/export/pptx">
                          <button class="btn btn-warning btn-sm"><i class="fas fa-download"></i> Download PPTX</button>
                        </a>
                        <a href="https://docs.google.com/presentation/d/1-JZxiRPzt-ndAyCNZauT63gjvnqn9Pd5nhZ5jf0XVMU/export/pdf">
                          <button class="btn btn-warning btn-sm"><i class="fas fa-download"></i> Download PDF</button>
                        </a>
                        <button onclick="$('#slidesIframe').get(0).requestFullscreen?.();"  class="btn btn-warning btn-sm"><i class="fas fa-expand"></i> Full Screen</button>

                        <button type="button" class="btn btn-tool" data-toggle="collapse" data-target="#collapse0" aria-expanded="true" aria-controls="collapse">
                          <i class="fas fa-chevron-down"></i>
                        </button>
                      </div>
                    </div>
                    
                    <div class="card-body" style="overflow: hide;">
                      {{-- <div id="overlay0" class="overlay dark" style="position: absolute; height:100%; width:100%; font-size:25px">
                        <div class="cv-spinner">
                          <span style="position: absolute">
                            Klik icon "<i class="fas fa-chevron-down"></i>" jika anda belum mengkliknya
                          </span>
                          <span class="spinner"></span>
                        </div>
                      </div> --}}

                      <div id="collapse0" class="collapse show" data-parent="#accordion0">
                        
                        {{-- <iframe src="{{ route('monitoring.slide') }}" height="500px" width="100%" title="Iframe Example"></iframe> --}}
                          <iframe id="slidesIframe" src="https://docs.google.com/presentation/d/e/2PACX-1vSCBRdBkphe1pMUbNscNCUPMTjBwvmGVSm-GTgd4jDV0i-tQ95VZuXJIShG_QhqbtHyKuboZ5ZdzHS0/embed?start=false&loop=false&delayms=60000" frameborder="0" width="100%" height="500px" allowfullscreen="true" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>
                          {{-- <iframe id="slidesIframe" src="https://docs.google.com/presentation/d/e/2PACX-1vTLdDKe9EgHKSNvZkoI877Zs5pzG0LV8cNhvGr4Pgz9mEDIVsS_56Uf1QTuK_xTO5_S69wknGZYAHzg/embed?start=false&loop=true&delayms=60000" frameborder="0" width="100%" height="500px" allowfullscreen="true" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe> --}}
                        
                          <div class="direct-chat-contacts" style="padding: 10px; height:100%; z-index:100">
                          <div class="row">
                            <div class="col-md-12">
                              <button onclick="load_data0()" type="button" class="btn btn-warning btn-xs float-right" data-widget="chat-pane-toggle">
                                <i class="fas fa-undo"></i> Reset
                              </button>
                            </div>

                            <div class="col-md-12">
                              filter
                            </div>
                          </div>
                        </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
              <div id="accordion11">
                <div class="card card-primary direct-chat direct-chat-primary">
                    <div class="card-header">
                      <h3 class="card-title">Export Data</h3>
                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-widget="chat-pane-toggle">
                          <i class="fas fa-filter"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                        </button>
                        <button onclick="load_data11()" type="button" class="btn btn-tool" data-toggle="collapse" data-target="#collapse11" aria-expanded="true" aria-controls="collapse">
                          <i class="fas fa-chevron-down"></i>
                        </button>
                      </div>
                    </div>
                    
                    <div class="card-body" style="overflow: hide;">
                      {{-- <div id="overlay11" class="overlay dark" style="position: absolute; height:100%; width:100%; font-size:25px">
                        <div class="cv-spinner">
                          <span style="position: absolute">
                            Klik icon "<i class="fas fa-chevron-down"></i>" jika anda belum mengkliknya
                          </span>
                          <span class="spinner"></span>
                        </div>
                      </div> --}}

                      <div id="collapse11" class="collapse show" data-parent="#accordion11">
                        <div style="padding: 10px">
                          Filter : <span id="filter11"></span>
                          <br>
                        </div>
                        <div style="margin: 10px">
                          <table class="datatableall table table-sm table-bordered table-hover" style="cursor:pointer; width:100%">
                            <thead>
                                <tr>
                                    <th style="width: 8%">No</th>
                                    <th>Judul Rekap Data</th>
                                    <th style="width: 12%">Download</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Data master kasus per klien (<span class="filterTanggal11"></span>)</td>
                                    <td><a href="{{ route('export_data_master_klien') }}?format=xlsx" class="btn btn-primary btn-xs export-link">Excel</a> <a href="{{ route('export_data_master_klien') }}?format=csv" class="btn btn-primary btn-xs export-link">CSV</a></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Data master kasus per terlapor (<span class="filterTanggal11"></span>)</td>
                                    <td><a href="{{ route('export_data_master_terlapor') }}?format=xlsx" class="btn btn-primary btn-xs export-link">Excel</a> <a href="{{ route('export_data_master_terlapor') }}?format=csv" class="btn btn-primary btn-xs export-link">CSV</a></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Data master Hubungan Terlapor dengan Korban (Terlapor Siapanya Korban) (<span class="filterTanggal11"></span>)</td>
                                    <td><a href="{{ route('export_data_master_hubungan') }}?format=xlsx" class="btn btn-primary btn-xs export-link">Excel</a> <a href="{{ route('export_data_master_hubungan') }}?format=csv" class="btn btn-primary btn-xs export-link">CSV</a></td>
                                </tr>
                            </tbody>
                        </table> 
                        <br>
                        <div style="border-style: solid; padding:10px">
                        <div style="border-bottom: solid black; font-size:20px">
                          <b>Copy text untuk WhatsApp</b>
                        </div>
                        <div id="accordion">
                          <br>
                          <div class="card">
                            <div class="card-header" id="headingOne">
                              <h5 class="mb-0">
                                <a href="#" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne" onclick="load_rekap1()">
                                  Rekap Data Jumlah Klien
                                </a>
                              </h5>
                            </div>
                        
                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                              <div class="card-body">
                                    <div class="copy-area" id="rangkuman_jumlah_kasus">
                                      *[Rekap Data Jumlah Klien]*<br>
                                      {{ date('d M Y H:i:s') }}<br>
                                      -------------------------------------------------<br>
                                      *Jumlah Seluruh Klien :* <span id="jumlah_seluruh_klien">0</span><br>
                                      -------------------------------------------------<br>
                                      *Perempuan Dewasa :* <span id="jumlah_perempuan_dewasa">0</span><br>
                                      *Anak Perempuan :* <span id="jumlah_anak_perempuan">0</span><br>
                                      *Anak Laki-laki :* <span id="jumlah_anak_laki">0</span><br>
                                      -------------------------------------------------<br>
                                      *a. Kategori Kasus (10 Terbanyak) :*<br>
                                      <div id="wa_kategori_kasus"></div>
                                      *b. Jenis Kekerasan (10 Terbanyak) :*<br>
                                      <div id="wa_jenis_kekerasan"></div>
                                      *c. Bentuk Kekerasan (10 Terbanyak) :*<br>
                                      <div id="wa_bentuk_kekerasan"></div>
                                      ==========================================================<br>
                                      {{-- *Jumlah Klien Berdasarkan Wilayah Penugasan Satpel :* <br>
                                      *1. Jakarta Pusat* (420 Klien) <br>
                                      Perempuan Dewasa : <span id="jumlah_perempuan_dewasa">0</span><br>
                                      Anak Perempuan : <span id="jumlah_anak_perempuan">0</span><br>
                                      Anak Laki-laki : <span id="jumlah_anak_laki">0</span><br>
                                      *a. Kategori Kasus (3 Terbanyak) :*<br>
                                      - Anak Berkonflik Dengan Hukum : 0<br>
                                      - Anak Korban Kekerasan Seksuak : 0<br>
                                      - Perempuan Korban Kekerasan Seksuak : 0<br>
                                      *b. Jenis Kekerasan :*<br>
                                      - Fisik : 0<br>
                                      - Psikis : 0<br>
                                      - Seksual : 0<br>
                                      - Seksual : 0<br>
                                      - Eksploitasi : 0<br>
                                      - Penelantaran : 0<br>
                                      - Tidak Diketahui / Lainnya : 0<br>
                                      - Bukan Kekerasan : 0<br>
                                      *2. Jakarta Utara & Kep.1000* (420 Klien) <br>
                                      Perempuan Dewasa : <span id="jumlah_perempuan_dewasa">0</span><br>
                                      Anak Perempuan : <span id="jumlah_anak_perempuan">0</span><br>
                                      Anak Laki-laki : <span id="jumlah_anak_laki">0</span><br>
                                      *a. Kategori Kasus (3 Terbanyak) :*<br>
                                      - Anak Berkonflik Dengan Hukum : 0<br>
                                      - Anak Korban Kekerasan Seksuak : 0<br>
                                      - Perempuan Korban Kekerasan Seksuak : 0<br>
                                      *b. Jenis Kekerasan :*<br>
                                      - Fisik : 0<br>
                                      - Psikis : 0<br>
                                      - Seksual : 0<br>
                                      - Seksual : 0<br>
                                      - Eksploitasi : 0<br>
                                      - Penelantaran : 0<br>
                                      - Tidak Diketahui / Lainnya : 0<br>
                                      - Bukan Kekerasan : 0<br>
                                      *3. Jakarta Barat*  (420 Klien)<br>
                                      Perempuan Dewasa : <span id="jumlah_perempuan_dewasa">0</span><br>
                                      Anak Perempuan : <span id="jumlah_anak_perempuan">0</span><br>
                                      Anak Laki-laki : <span id="jumlah_anak_laki">0</span><br>
                                      *a. Kategori Kasus (3 Terbanyak) :*<br>
                                      - Anak Berkonflik Dengan Hukum : 0<br>
                                      - Anak Korban Kekerasan Seksuak : 0<br>
                                      - Perempuan Korban Kekerasan Seksuak : 0<br>
                                      *b. Jenis Kekerasan :*<br>
                                      - Fisik : 0<br>
                                      - Psikis : 0<br>
                                      - Seksual : 0<br>
                                      - Seksual : 0<br>
                                      - Eksploitasi : 0<br>
                                      - Penelantaran : 0<br>
                                      - Tidak Diketahui / Lainnya : 0<br>
                                      - Bukan Kekerasan : 0<br>
                                      *4. Jakarta Selatan*  (420 Klien)<br>
                                      Perempuan Dewasa : <span id="jumlah_perempuan_dewasa">0</span><br>
                                      Anak Perempuan : <span id="jumlah_anak_perempuan">0</span><br>
                                      Anak Laki-laki : <span id="jumlah_anak_laki">0</span><br>
                                      *a. Kategori Kasus (3 Terbanyak) :*<br>
                                      - Anak Berkonflik Dengan Hukum : 0<br>
                                      - Anak Korban Kekerasan Seksuak : 0<br>
                                      - Perempuan Korban Kekerasan Seksuak : 0<br>
                                      *b. Jenis Kekerasan :*<br>
                                      - Fisik : 0<br>
                                      - Psikis : 0<br>rangkuman_jumlah_kasus
                                      - Seksual : 0<br>
                                      - Seksual : 0<br>
                                      - Eksploitasi : 0<br>
                                      - Penelantaran : 0<br>
                                      - Tidak Diketahui / Lainnya : 0<br>
                                      - Bukan Kekerasan : 0<br>
                                      *5. Jakarta Timur*  (420 Klien)<br>
                                      Perempuan Dewasa : <span id="jumlah_perempuan_dewasa">0</span><br>
                                      Anak Perempuan : <span id="jumlah_anak_perempuan">0</span><br>
                                      Anak Laki-laki : <span id="jumlah_anak_laki">0</span><br>
                                      *a. Kategori Kasus (3 Terbanyak) :*<br>
                                      - Anak Berkonflik Dengan Hukum : 0<br>
                                      - Anak Korban Kekerasan Seksuak : 0<br>
                                      - Perempuan Korban Kekerasan Seksuak : 0<br>
                                      *b. Jenis Kekerasan :*<br>
                                      - Fisik : 0<br>
                                      - Psikis : 0<br>
                                      - Seksual : 0<br>
                                      - Seksual : 0<br>
                                      - Eksploitasi : 0<br>
                                      - Penelantaran : 0<br>
                                      - Tidak Diketahui / Lainnya : 0<br>
                                      - Bukan Kekerasan : 0<br>
                                      -------------------------------------------------<br> --}}
                                    </div>
                                  <button class="btn btn-primary copy-button" onclick="copyTextExportData('rangkuman_jumlah_kasus')">
                                    <i class="fas fa-copy"></i> Copy Text
                                  </button>
                              </div>
                            </div>
                          </div>
                          <div class="card">
                            <div class="card-header" id="headingTwo">
                              <h5 class="mb-0">
                                <a href="#" class="collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                  Rekap Data Jumlah Layanan
                                </a>
                              </h5>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                              <div class="card-body">

                                <div class="copy-area" id="rekap_data_jumlah_layanan">
                                  Lorem ipsum dolor sit amet consectetur adipisicing elit. Exercitationem dolore, ea alias iure in aliquam deleniti totam atque suscipit nostrum qui vel enim nihil ipsa tenetur est voluptatum, molestias maxime.
                                </div>
                              <button class="btn btn-primary copy-button" onclick="copyTextExportData('rekap_data_jumlah_layanan')">
                                <i class="fas fa-copy"></i> Copy Text
                              </button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                        </div>
                        <div class="direct-chat-contacts" style="padding: 10px; height:100%; z-index:100">
                          <div class="row">
                            <div class="col-md-12">
                              <button onclick="load_data11()" type="button" class="btn btn-warning btn-xs float-right" data-widget="chat-pane-toggle">
                                <i class="fas fa-undo"></i> Reset
                              </button>
                            </div>
                            
                            <div class="col-md-12">
                              <div class="form-group">
                                <label for="">Basis Tanggal</label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <select id="filterBasisTanggal11" class="form-control btn-primary">
                                      <option value="tanggal_approve" selected>Default ( Berdasarkan Tanggal Diregis. Hanya yang sudah dregis )</option>
                                      <option value="tanggal_pelaporan" >Berdasarkan Tanggal Pelaporan</option>
                                      <option value="tanggal_kejadian">Berdasarkan Tanggal Kejadian (Hanya yang ada Tanggal Kejadiannya)</option>
                                      <option value="created_at">Berdasarkan Tanggal Input</option>
                                    </select>
                                  </div>
                                  <input type="text" class="form-control daterank" id="filterTanggal11" value="2024-01-01 - {{ date("Y").'/'.date("m").'/'.date("d") }}">
                                </div>
                              </div>

                              <div class="form-group">
                                <label for="">Basis Wilayah</label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <select class="form-control btn-primary" id="filterBasisWilayah11">
                                      <option value="tkp" selected>Berdasarkan Wilayah TKP</option>
                                      <option value="ktp">Berdasarkan Wilayah KTP</option>
                                      <option value="domisili">Berdasarkan Wilayah Domisili</option>
                                      <option value="satpel">Berdasarkan Wilayah Satpel</option>
                                    </select>
                                  </div>
                                  <select class="form-control" id="filterWilayah11">
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
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <select class="form-control btn-primary" id="filterPenghitunganUsia11">
                                      <option value="lapor">Default (Tanggal Pelaporan dikurangi Tanggal Lahir)</option>
                                      <option value ="today" >Tanggal Hari Ini dikurangi Tanggal Lahir</option>
                                      <option value="kejadian">Tanggal Kejadian dikurangi Tanggal Lahir</option>
                                      <option value="input">Tanggal Input dikurangi Tanggal Lahir</option>
                                    </select>
                                  </div>
                                  <select class="form-control" id="filterKategoriKlien11">
                                    <option value="total" selected>Default ( Semua Kategori Klien )</option>
                                    <option value="dewasa_perempuan">Perempuan Dewasa</option>
                                    <option value="anak_perempuan">Anak Perempuan</option>
                                    <option value="anak_laki">Anak Laki-laki</option>
                                  </select>
                                </div>
                              </div>

                              <div class="form-group">
                                <label for="">Kasus yang Diregis</label>
                                <br>
                                <div class="icheck-primary d-inline" style="margin-right:15px">
                                  <input type="radio" id="filterRegis11a" name="filterRegis11" checked value="0">
                                  <label for="filterRegis11a">
                                      Seluruh kasus
                                  </label>
                                </div>
                                <div class="icheck-primary d-inline">
                                  <input type="radio" id="filterRegis11b" name="filterRegis11" value="1">
                                  <label for="filterRegis11b">
                                      Kasus yang sudah diregis saja
                                  </label>
                                </div>
                                <br>
                                <span style="color: red; font-size:12px">*jika basis tanggal adalah Tanggal Diregis maka otomatis menampilkan kasus yang sudah diregis saja</span>
                              </div>

                              <div class="form-group">
                                <label for="">Kasus yang Diarsipkan</label>
                                <br>
                                <div class="icheck-primary d-inline" style="margin-right:15px">
                                  <input type="radio" id="filterArsip11a" name="filterArsip11" checked value="0">
                                  <label for="filterArsip11a">
                                      Tanpa kasus yang diarsipkan
                                  </label>
                                </div>
                                <div class="icheck-primary d-inline">
                                  <input type="radio" id="filterArsip11b" name="filterArsip11" value="1">
                                  <label for="filterArsip11b">
                                      Dengan kasus yang diarsipkan
                                  </label>
                                </div>
                              </div>
                              
                              <button onclick="load_data11()" type="button" class="btn btn-block btn-primary mt-4" data-widget="chat-pane-toggle">
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

          <div class="row" style="border-style: solid;">
            <div class="col-md-12" style="border-bottom: solid black; padding-top:10px; margin-bottom:15px; padding-bottom:10px">
              <div class="input-group">
                <input type="text" id="Search" class="form-control" onkeyup="search()" placeholder="Cari judul data...">
                <div class="input-group-append">
                  <button class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">Gunakan Filter <i class="fas fa-chevron-down"></i></button>
                </div>
              </div>
              <div class="collapse" id="collapseExample">
                <div class="card card-body bg-dark">
                  <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="">Basis Tanggal</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <select id="filterBasisTanggal11" class="form-control btn-primary">
                            <option value="tanggal_approve" selected>Default ( Berdasarkan Tanggal Diregis. Hanya yang sudah dregis )</option>
                            <option value="tanggal_pelaporan" >Berdasarkan Tanggal Pelaporan</option>
                            <option value="tanggal_kejadian">Berdasarkan Tanggal Kejadian (Hanya yang ada Tanggal Kejadiannya)</option>
                            <option value="created_at">Berdasarkan Tanggal Input</option>
                          </select>
                        </div>
                        <input type="text" class="form-control daterank" id="filterTanggal11" value="2024-01-01 - {{ date("Y").'/'.date("m").'/'.date("d") }}">
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="">Kasus yang Diregis</label>
                      <br>
                      <div class="icheck-primary d-inline" style="margin-right:15px">
                        <input type="radio" id="filterRegis11a" name="filterRegis11" checked value="0">
                        <label for="filterRegis11a">
                            Seluruh kasus
                        </label>
                      </div>
                      <div class="icheck-primary d-inline">
                        <input type="radio" id="filterRegis11b" name="filterRegis11" value="1">
                        <label for="filterRegis11b">
                            Kasus yang sudah diregis saja
                        </label>
                      </div>
                      <br>
                      <span style="color: red; font-size:12px">*jika basis tanggal adalah Tanggal Diregis maka otomatis menampilkan kasus yang sudah diregis saja</span>
                    </div>
                    </div>
      
                  <div class="col-md-6">
                    <div class="form-group">
                    <label for="">Basis Wilayah</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <select class="form-control btn-primary" id="filterBasisWilayah11">
                          <option value="tkp" selected>Berdasarkan Wilayah TKP</option>
                          <option value="ktp">Berdasarkan Wilayah KTP</option>
                          <option value="domisili">Berdasarkan Wilayah Domisili</option>
                          <option value="satpel">Berdasarkan Wilayah Satpel</option>
                        </select>
                      </div>
                      <select class="form-control" id="filterWilayah11">
                        <option value="default" selected>Default ( Semua Wilayah )</option>
                        @foreach ($kota as $item) 
                          <option value="{{ $item->code }}" >{{ $item->name }}</option> 
                        @endforeach 
                        <option value="luar">Luar DKI Jakarta</option>
                      </select>
                    </div>
                  </div>
                  </div>
      
                  <div class="col-md-6">
                  <div class="form-group">
                    <label for="">Kasus yang Diarsipkan</label>
                    <br>
                    <div class="icheck-primary d-inline" style="margin-right:15px">
                      <input type="radio" id="filterArsip10a" name="filterArsip11" value="0">
                      <label for="filterArsip11a">
                          Tanpa kasus yang diarsipkan
                      </label>
                    </div>
                    <div class="icheck-primary d-inline">
                      <input type="radio" id="filterArsip11b" name="filterArsip11" checked value="1">
                      <label for="filterArsip11b">
                          Dengan kasus yang diarsipkan
                      </label>
                    </div>
                  </div>
                  </div>
      
                  <div class="col-md-6">
                  <div class="form-group">
                    <label for="">Basis Penghitungan Usia Klien</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <select class="form-control btn-primary" id="filterPenghitunganUsia11">
                          <option value="lapor" selected>Default (Tanggal Pelaporan dikurangi Tanggal Lahir)</option>
                          <option value ="today" >Tanggal Hari Ini dikurangi Tanggal Lahir</option>
                          <option value="kejadian">Tanggal Kejadian dikurangi Tanggal Lahir</option>
                          <option value="input">Tanggal Input dikurangi Tanggal Lahir</option>
                        </select>
                      </div>
                      <select class="form-control" id="filterKategoriKlien11">
                        <option value="total" selected>Default ( Semua Kategori Klien )</option>
                        <option value="dewasa_perempuan">Perempuan Dewasa</option>
                        <option value="anak_perempuan">Anak Perempuan</option>
                        <option value="anak_laki">Anak Laki-laki</option>
                      </select>
                    </div>
                  </div>
                  </div>
      
                  <div class="col-md-6">
                  <button onclick="load_data10()" type="button" class="btn btn-block btn-primary mt-4" data-widget="chat-pane-toggle">
                    <i class="fas fa-check"></i> Terapkan
                  </button>
                  </div>
                </div>
                </div>
              </div>
            </div>

            <div class="col-md-6 target">
              <div id="accordion10">
                <div class="card card-primary direct-chat direct-chat-primary">
                    <div class="card-header">
                      <h3 class="card-title">Jumlah Detail Layanan</h3>
                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-widget="chat-pane-toggle">
                          <i class="fas fa-filter"></i>
                        </button>
                        <button onclick="load_data10()" type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                        </button>
                        <button onclick="load_data10()" type="button" class="btn btn-tool" data-toggle="collapse" data-target="#collapse10" aria-expanded="true" aria-controls="collapse">
                          <i class="fas fa-chevron-down"></i>
                        </button>
                      </div>
                    </div>
                    
                    <div class="card-body" style="overflow: hide;">
                      <div id="overlay10" class="overlay dark" style="position: absolute; height:100%; width:100%; font-size:25px">
                        <div class="cv-spinner">
                          <span style="position: absolute">
                            Klik icon "<i class="fas fa-chevron-down"></i>" jika anda belum mengkliknya
                          </span>
                          <span class="spinner"></span>
                        </div>
                      </div>

                      <div id="collapse10" class="collapse" data-parent="#accordion10">
                        <div style="padding: 10px">
                          Filter : <span id="filter10"></span>
                          <br>
                          <div style="color: red">
                            *Catatan : 1 agenda kegiatan dapat lebih dari 1 keyword / detail layanan. Contoh : agenda Pendampingan di Kepolisian sambil Konsultasi Hukum
                          </div>
                        </div>
                        <div style="margin: 10px">
                          <table id="tabelChart10" class="table table-sm table-bordered table-hover" style="cursor:pointer; width:100%"></table>  
                        </div>
                        <div class="direct-chat-contacts" style="padding: 10px; height:100%; z-index:100">
                          <div class="row">
                            <div class="col-md-12">
                              <button onclick="load_data10()" type="button" class="btn btn-warning btn-xs float-right" data-widget="chat-pane-toggle">
                                <i class="fas fa-undo"></i> Reset
                              </button>
                            </div>
                            
                            <div class="col-md-12">
                              <div class="form-group">
                                <label for="">Basis Tanggal</label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <select id="filterBasisTanggal10" class="form-control btn-primary">
                                      <option value="tanggal_approve" selected>Default ( Berdasarkan Tanggal Diregis. Hanya yang sudah dregis )</option>
                                      <option value="tanggal_pelaporan" >Berdasarkan Tanggal Pelaporan</option>
                                      <option value="tanggal_kejadian">Berdasarkan Tanggal Kejadian (Hanya yang ada Tanggal Kejadiannya)</option>
                                      <option value="created_at">Berdasarkan Tanggal Input</option>
                                    </select>
                                  </div>
                                  <input type="text" class="form-control daterank" id="filterTanggal10" value="2024-01-01 - {{ date("Y").'/'.date("m").'/'.date("d") }}">
                                </div>
                              </div>

                              <div class="form-group">
                                <label for="">Basis Wilayah</label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <select class="form-control btn-primary" id="filterBasisWilayah10">
                                      <option value="tkp" selected>Berdasarkan Wilayah TKP</option>
                                      <option value="ktp">Berdasarkan Wilayah KTP</option>
                                      <option value="domisili">Berdasarkan Wilayah Domisili</option>
                                      <option value="satpel">Berdasarkan Wilayah Satpel</option>
                                    </select>
                                  </div>
                                  <select class="form-control" id="filterWilayah10">
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
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <select class="form-control btn-primary" id="filterPenghitunganUsia10">
                                      <option value="lapor" selected>Default (Tanggal Pelaporan dikurangi Tanggal Lahir)</option>
                                      <option value ="today" >Tanggal Hari Ini dikurangi Tanggal Lahir</option>
                                      <option value="kejadian">Tanggal Kejadian dikurangi Tanggal Lahir</option>
                                      <option value="input">Tanggal Input dikurangi Tanggal Lahir</option>
                                    </select>
                                  </div>
                                  <select class="form-control" id="filterKategoriKlien10">
                                    <option value="total" selected>Default ( Semua Kategori Klien )</option>
                                    <option value="dewasa_perempuan">Perempuan Dewasa</option>
                                    <option value="anak_perempuan">Anak Perempuan</option>
                                    <option value="anak_laki">Anak Laki-laki</option>
                                  </select>
                                </div>
                              </div>

                              <div class="form-group">
                                <label for="">Kasus yang Diregis</label>
                                <br>
                                <div class="icheck-primary d-inline" style="margin-right:15px">
                                  <input type="radio" id="filterRegis10a" name="filterRegis10" checked value="0">
                                  <label for="filterRegis10a">
                                      Seluruh kasus
                                  </label>
                                </div>
                                <div class="icheck-primary d-inline">
                                  <input type="radio" id="filterRegis10b" name="filterRegis10" value="1">
                                  <label for="filterRegis10b">
                                      Kasus yang sudah diregis saja
                                  </label>
                                </div>
                                <br>
                                <span style="color: red; font-size:12px">*jika basis tanggal adalah Tanggal Diregis maka otomatis menampilkan kasus yang sudah diregis saja</span>
                              </div>

                              <div class="form-group">
                                <label for="">Kasus yang Diarsipkan</label>
                                <br>
                                <div class="icheck-primary d-inline" style="margin-right:15px">
                                  <input type="radio" id="filterArsip10a" name="filterArsip10" value="0">
                                  <label for="filterArsip10a">
                                      Tanpa kasus yang diarsipkan
                                  </label>
                                </div>
                                <div class="icheck-primary d-inline">
                                  <input type="radio" id="filterArsip10b" name="filterArsip10" checked value="1">
                                  <label for="filterArsip10b">
                                      Dengan kasus yang diarsipkan
                                  </label>
                                </div>
                              </div>
                              
                              <button onclick="load_data10()" type="button" class="btn btn-block btn-primary mt-4" data-widget="chat-pane-toggle">
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

            <div class="col-md-6 target">
              <div id="accordion2">
                <div class="card card-primary direct-chat direct-chat-primary">
                    <div class="card-header">
                      <h3 class="card-title">Jumlah Korban Kekerasan</h3>
                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-widget="chat-pane-toggle">
                          <i class="fas fa-filter"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                        </button>
                        <button onclick="load_data2()" type="button" class="btn btn-tool" data-toggle="collapse" data-target="#collapse2" aria-expanded="true" aria-controls="collapse">
                          <i class="fas fa-chevron-down"></i>
                        </button>
                      </div>
                    </div>
                    
                    <div class="card-body" style="overflow: hide;">
                      <div id="overlay2" class="overlay dark" style="position: absolute; height:100%; width:100%; font-size:25px">
                        <div class="cv-spinner">
                          <span style="position: absolute">
                            Klik icon "<i class="fas fa-chevron-down"></i>" jika anda belum mengkliknya
                          </span>
                          <span class="spinner"></span>
                        </div>
                      </div>

                      <div id="collapse2" class="collapse" data-parent="#accordion2">
                        <div style="padding: 10px">
                          Filter : <span id="filter2"></span>
                        </div>
                        <div style="height: 500px;">
                          <div id="chart2" style="display: block; width: 100%; height: 100%; padding: 0px 20px"></div>
                        </div>
                        
                        <div class="direct-chat-contacts" style="padding: 10px; height:100%; z-index:100">
                          <div class="row">
                            <div class="col-md-12">
                              <button onclick="load_data2()" type="button" class="btn btn-warning btn-xs float-right" data-widget="chat-pane-toggle">
                                <i class="fas fa-undo"></i> Reset
                              </button>
                            </div>

                            <div class="col-md-12">
                              <div class="form-group">
                                <label for="">Pengelompokan Tanggal</label>
                                <br>
                                <div class="icheck-primary d-inline" style="margin-right:15px">
                                  <input type="radio" id="filterPengelompokan2a" name="filterPengelompokan2" value="tahun">
                                  <label for="filterPengelompokan2a">
                                      Per Tahun
                                  </label>
                                </div>
                                <div class="icheck-primary d-inline">
                                  <input type="radio" id="filterPengelompokan2b" name="filterPengelompokan2" checked value="bulan">
                                  <label for="filterPengelompokan2b">
                                      Per Bulan
                                  </label>
                                </div>
                              </div>

                              <div class="form-group">
                                <label for="">Basis Tanggal</label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <select id="filterBasisTanggal2" class="form-control btn-primary">
                                      <option value="tanggal_approve" selected>Default ( Berdasarkan Tanggal Diregis. Hanya yang sudah dregis )</option>
                                      <option value="tanggal_pelaporan" >Berdasarkan Tanggal Pelaporan</option>
                                      <option value="tanggal_kejadian">Berdasarkan Tanggal Kejadian (Hanya yang ada Tanggal Kejadiannya)</option>
                                      <option value="created_at">Berdasarkan Tanggal Input</option>
                                    </select>
                                  </div>
                                  <input type="text" class="form-control daterank" id="filterTanggal2" value="2024-01-01 - {{ date("Y").'/'.date("m").'/'.date("d") }}">
                                </div>
                              </div>

                              <div class="form-group">
                                <label for="">Basis Wilayah</label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <select class="form-control btn-primary" id="filterBasisWilayah2">
                                      <option value="default" selected>Default ( Semua Wilayah )</option>
                                      <option value="tkp">Berdasarkan Wilayah TKP</option>
                                      <option value="ktp">Berdasarkan Wilayah KTP</option>
                                      <option value="domisili">Berdasarkan Wilayah Domisili</option>
                                      <option value="satpel">Berdasarkan Wilayah Satpel</option>
                                    </select>
                                  </div>
                                  <select class="form-control" id="filterWilayah2">
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
                                <select class="form-control" id="filterPenghitunganUsia2">
                                  <option value="lapor" selected>Default (Tanggal Pelaporan dikurangi Tanggal Lahir)</option>
                                  <option value ="today" >Tanggal Hari Ini dikurangi Tanggal Lahir</option>
                                  <option value="kejadian">Tanggal Kejadian dikurangi Tanggal Lahir</option>
                                  <option value="input">Tanggal Input dikurangi Tanggal Lahir</option>
                                </select>
                              </div>

                              <div class="form-group">
                                <label for="">Kasus yang Diregis</label>
                                <br>
                                <div class="icheck-primary d-inline" style="margin-right:15px">
                                  <input type="radio" id="filterRegis2a" name="filterRegis2" value="0">
                                  <label for="filterRegis2a">
                                      Seluruh kasus
                                  </label>
                                </div>
                                <div class="icheck-primary d-inline">
                                  <input type="radio" id="filterRegis2b" name="filterRegis2" checked value="1">
                                  <label for="filterRegis2b">
                                      Kasus yang sudah diregis saja
                                  </label>
                                </div>
                                
                                <br>
                                <span style="color: red; font-size:12px">*jika basis tanggal adalah Tanggal Diregis maka otomatis menampilkan kasus yang sudah diregis saja</span>
                              </div>

                              <div class="form-group">
                                <label for="">Kasus yang Diarsipkan</label>
                                <br>
                                <div class="icheck-primary d-inline" style="margin-right:15px">
                                  <input type="radio" id="filterArsip2a" name="filterArsip2" checked value="0">
                                  <label for="filterArsip2a">
                                      Tanpa kasus yang diarsipkan
                                  </label>
                                </div>
                                <div class="icheck-primary d-inline">
                                  <input type="radio" id="filterArsip2b" name="filterArsip2" value="1">
                                  <label for="filterArsip2b">
                                      Dengan kasus yang diarsipkan
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

            <div class="col-md-6 target">
              <div id="accordion3">
                <div class="card card-primary direct-chat direct-chat-primary">
                    <div class="card-header">
                      <h3 class="card-title">Jumlah Korban Kekerasan Berdasarkan Kategori Klien</h3>
                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-widget="chat-pane-toggle">
                          <i class="fas fa-filter"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                        </button>
                        <button onclick="load_data3()" type="button" class="btn btn-tool" data-toggle="collapse" data-target="#collapse3" aria-expanded="true" aria-controls="collapse">
                          <i class="fas fa-chevron-down"></i>
                        </button>
                      </div>
                    </div>
                    
                    <div class="card-body" style="overflow: hide;">
                      <div id="overlay3" class="overlay dark" style="position: absolute; height:100%; width:100%; font-size:25px">
                        <div class="cv-spinner">
                          <span style="position: absolute">
                            Klik icon "<i class="fas fa-chevron-down"></i>" jika anda belum mengkliknya
                          </span>
                          <span class="spinner"></span>
                        </div>
                      </div>

                      <div id="collapse3" class="collapse" data-parent="#accordion3">
                        <div style="padding: 10px">
                          Filter : <span id="filter3"></span>
                        </div>
                        <div style="height: 500px;">
                          <div id="chart3" style="display: block; padding: 0px 20px"></div>
                        </div>
                        
                        <div class="direct-chat-contacts" style="padding: 10px; height:100%; z-index:100">
                          <div class="row">
                            <div class="col-md-12">
                              <button onclick="load_data3()" type="button" class="btn btn-warning btn-xs float-right" data-widget="chat-pane-toggle">
                                <i class="fas fa-undo"></i> Reset
                              </button>
                            </div>

                            <div class="col-md-12">
                              <div class="form-group">
                                <label for="">Basis Tanggal</label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <select id="filterBasisTanggal3" class="form-control btn-primary">
                                      <option value="tanggal_approve" selected>Default ( Berdasarkan Tanggal Diregis. Hanya yang sudah dregis )</option>
                                      <option value="tanggal_pelaporan" >Berdasarkan Tanggal Pelaporan</option>
                                      <option value="tanggal_kejadian">Berdasarkan Tanggal Kejadian (Hanya yang ada Tanggal Kejadiannya)</option>
                                      <option value="created_at">Berdasarkan Tanggal Input</option>
                                    </select>
                                  </div>
                                  <input type="text" class="form-control daterank" id="filterTanggal3" value="2024-01-01 - {{ date("Y").'/'.date("m").'/'.date("d") }}">
                                </div>
                              </div>

                              <div class="form-group">
                                <label for="">Basis Wilayah</label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <select class="form-control btn-primary" id="filterBasisWilayah3">
                                      <option value="default" selected>Default ( Semua Wilayah )</option>
                                      <option value="tkp">Berdasarkan Wilayah TKP</option>
                                      <option value="ktp">Berdasarkan Wilayah KTP</option>
                                      <option value="domisili">Berdasarkan Wilayah Domisili</option>
                                      <option value="satpel">Berdasarkan Wilayah Satpel</option>
                                    </select>
                                  </div>
                                  <select class="form-control" id="filterWilayah3">
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
                                <select class="form-control" id="filterPenghitunganUsia3">
                                  <option value="lapor" selected>Default ( Tanggal Pelaporan dikurangi Tanggal Lahir )</option>
                                  <option value="today">Tanggal Hari Ini dikurangi Tanggal Lahir</option>
                                  <option value="kejadian">Tanggal Kejadian dikurangi Tanggal Lahir</option>
                                  <option value="input">Tanggal Input dikurangi Tanggal Lahir</option>
                                </select>
                              </div>

                              <div class="form-group">
                                <label for="">Kasus yang Diregis</label>
                                <br>
                                <div class="icheck-primary d-inline" style="margin-right:15px">
                                  <input type="radio" id="filterRegis3a" name="filterRegis3" value="0">
                                  <label for="filterRegis3a">
                                      Seluruh kasus
                                  </label>
                                </div>
                                <div class="icheck-primary d-inline">
                                  <input type="radio" id="filterRegis3b" name="filterRegis3" checked value="1">
                                  <label for="filterRegis3b">
                                      Kasus yang sudah diregis saja
                                  </label>
                                </div>
                                
                                <br>
                                <span style="color: red; font-size:12px">*jika basis tanggal adalah Tanggal Diregis maka otomatis menampilkan kasus yang sudah diregis saja</span>
                              </div>

                              <div class="form-group">
                                <label for="">Kasus yang Diarsipkan</label>
                                <br>
                                <div class="icheck-primary d-inline" style="margin-right:15px">
                                  <input type="radio" id="filterArsip3a" name="filterArsip3" checked value="0">
                                  <label for="filterArsip3a">
                                      Tanpa kasus yang diarsipkan
                                  </label>
                                </div>
                                <div class="icheck-primary d-inline">
                                  <input type="radio" id="filterArsip3b" name="filterArsip3" value="1">
                                  <label for="filterArsip3b">
                                      Dengan kasus yang diarsipkan
                                  </label>
                                </div>
                              </div>
                              
                              <button onclick="load_data3()" type="button" class="btn btn-block btn-primary mt-4" data-widget="chat-pane-toggle">
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

            <div class="col-md-6 target">
              <div id="accordion4">
                <div class="card card-primary direct-chat direct-chat-primary">
                    <div class="card-header">
                      <h3 class="card-title">Jumlah Korban Kekerasan Berdasarkan Wilayah (<span id="titleChart4">tkp</span>)</h3>
                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-widget="chat-pane-toggle">
                          <i class="fas fa-filter"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                        </button>
                        <button onclick="load_data4()" type="button" class="btn btn-tool" data-toggle="collapse" data-target="#collapse4" aria-expanded="true" aria-controls="collapse">
                          <i class="fas fa-chevron-down"></i>
                        </button>
                      </div>
                    </div>
                    
                    <div class="card-body" style="overflow: hide;">
                      <div id="overlay4" class="overlay dark" style="position: absolute; height:100%; width:100%; font-size:25px">
                        <div class="cv-spinner">
                          <span style="position: absolute">
                            Klik icon "<i class="fas fa-chevron-down"></i>" jika anda belum mengkliknya
                          </span>
                          <span class="spinner"></span>
                        </div>
                      </div>

                      <div id="collapse4" class="collapse" data-parent="#accordion4">
                        <div style="padding: 10px">
                          Filter : <span id="filter4"></span>
                        </div>
                        
                        <div style="height: 500px;">
                          <div id="chart4" style="display: block; width: 100%; height: 100%; padding: 0px 20px"></div>
                        </div>
                        {{-- Data Tabulasi --}}
                        <div id="accordionTabelChart4" style="margin-bottom:-15px">
                          <div class="card card-light">
                            <div class="card-header" data-toggle="collapse" data-target="#collapseTabelChart4" aria-expanded="true" aria-controls="collapseTabelChart4" style="cursor: pointer;">
                              <h3 class="card-title">
                                  <b>Data Tabulasi</b>
                              </h3>
                              <div class="card-tools">
                                <button type="button" class="btn btn-tool">
                                  <i class="fas fa-chevron-down"></i>
                                </button>
                              </div>
                            </div>
                          <div id="collapseTabelChart4" class="collapse" data-parent="#accordionTabelChart4">
                          <div class="card-body">
                          <div style="margin: 10px; ">
                            <table id="tabelChart4" class="table table-sm table-bordered table-hover" style="cursor:pointer; width:100%"></table>  
                          </div>
                          </div>
                          </div>
                          </div>
                      </div>
     
                        <div class="direct-chat-contacts" style="padding: 10px; height:100%; z-index:100">
                          <div class="row">
                            <div class="col-md-12">
                              <button onclick="load_data4()" type="button" class="btn btn-warning btn-xs float-right" data-widget="chat-pane-toggle">
                                <i class="fas fa-undo"></i> Reset
                              </button>
                            </div>

                            <div class="col-md-12">

                              <div class="form-group">
                                <label for="">Basis Wilayah</label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <select class="form-control btn-primary" id="filterBasisWilayah4">
                                      <option value="tkp" selected>Default (Berdasarkan Wilayah TKP)</option>
                                      <option value="ktp">Berdasarkan Wilayah KTP</option>
                                      <option value="domisili">Berdasarkan Wilayah Domisili</option>
                                      <option value="satpel">Berdasarkan Wilayah Satpel</option>
                                    </select>
                                  </div>
                                </div>
                              </div>

                              <div class="form-group">
                                <label for="">Basis Tanggal</label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <select id="filterBasisTanggal4" class="form-control btn-primary">
                                      <option value="tanggal_approve" selected>Default ( Berdasarkan Tanggal Diregis. Hanya yang sudah dregis )</option>
                                      <option value="tanggal_pelaporan" >Berdasarkan Tanggal Pelaporan</option>
                                      <option value="tanggal_kejadian">Berdasarkan Tanggal Kejadian (Hanya yang ada Tanggal Kejadiannya)</option>
                                      <option value="created_at">Berdasarkan Tanggal Input</option>
                                    </select>
                                  </div>
                                  <input type="text" class="form-control daterank" id="filterTanggal4" value="2024-01-01 - {{ date("Y").'/'.date("m").'/'.date("d") }}">
                                </div>
                              </div>

                              <div class="form-group">
                                <label for="">Basis Penghitungan Usia Klien</label>
                                <select class="form-control" id="filterPenghitunganUsia4">
                                  <option value="lapor" selected>Default ( Tanggal Pelaporan dikurangi Tanggal Lahir )</option>
                                  <option value="today">Tanggal Hari Ini dikurangi Tanggal Lahir</option>
                                  <option value="kejadian">Tanggal Kejadian dikurangi Tanggal Lahir</option>
                                  <option value="input">Tanggal Input dikurangi Tanggal Lahir</option>
                                </select>
                              </div>

                              <div class="form-group">
                                <label for="">Kasus yang Diregis</label>
                                <br>
                                <div class="icheck-primary d-inline" style="margin-right:15px">
                                  <input type="radio" id="filterRegis4a" name="filterRegis4" value="0">
                                  <label for="filterRegis4a">
                                      Seluruh kasus
                                  </label>
                                </div>
                                <div class="icheck-primary d-inline">
                                  <input type="radio" id="filterRegis4b" name="filterRegis4" checked value="1">
                                  <label for="filterRegis4b">
                                      Kasus yang sudah diregis saja
                                  </label>
                                </div>
                                <br>
                                <span style="color: red; font-size:12px">*jika basis tanggal adalah Tanggal Diregis maka otomatis menampilkan kasus yang sudah diregis saja</span>
                              </div>

                              <div class="form-group">
                                <label for="">Kasus yang Diarsipkan</label>
                                <br>
                                <div class="icheck-primary d-inline" style="margin-right:15px">
                                  <input type="radio" id="filterArsip4a" name="filterArsip4" checked value="0">
                                  <label for="filterArsip4a">
                                      Tanpa kasus yang diarsipkan
                                  </label>
                                </div>
                                <div class="icheck-primary d-inline">
                                  <input type="radio" id="filterArsip4b" name="filterArsip4" value="1">
                                  <label for="filterArsip4b">
                                      Dengan kasus yang diarsipkan
                                  </label>
                                </div>
                              </div>
                              
                              <button onclick="load_data4()" type="button" class="btn btn-block btn-primary mt-4" data-widget="chat-pane-toggle">
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

            <div class="col-md-6 target">
              <div id="accordion5">
                <div class="card card-primary direct-chat direct-chat-primary">
                    <div class="card-header">
                      <h3 class="card-title">Jumlah Korban Kekerasan Berdasarkan Klasifikasi Kasus (<span id="titleChart5">kategori_kasus</span>)</h3>
                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-widget="chat-pane-toggle">
                          <i class="fas fa-filter"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                        </button>
                        <button onclick="load_data5()" type="button" class="btn btn-tool" data-toggle="collapse" data-target="#collapse5" aria-expanded="true" aria-controls="collapse">
                          <i class="fas fa-chevron-down"></i>
                        </button>
                      </div>
                    </div>
                    
                    <div class="card-body" style="overflow: hide;">
                      <div id="overlay5" class="overlay dark" style="position: absolute; height:100%; width:100%; font-size:25px">
                        <div class="cv-spinner">
                          <span style="position: absolute">
                            Klik icon "<i class="fas fa-chevron-down"></i>" jika anda belum mengkliknya
                          </span>
                          <span class="spinner"></span>
                        </div>
                      </div>

                      <div id="collapse5" class="collapse" data-parent="#accordion5">
                        <div style="padding: 10px">
                          Filter : <span id="filter5"></span>
                        </div>
                        <div style="height: 500px;">
                          <div id="chart5" style="display: block; padding: 0px 20px"></div>
                        </div>
                        {{-- Data Tabulasi --}}
                        <div id="accordionTabelChart5" style="margin-bottom:-15px">
                          <div class="card card-light">
                            <div class="card-header" data-toggle="collapse" data-target="#collapseTabelChart5" aria-expanded="true" aria-controls="collapseTabelChart5" style="cursor: pointer;">
                              <h3 class="card-title">
                                  <b>Data Tabulasi</b>
                              </h3>
                              <div class="card-tools">
                                <button type="button" class="btn btn-tool">
                                  <i class="fas fa-chevron-down"></i>
                                </button>
                              </div>
                            </div>
                          <div id="collapseTabelChart5" class="collapse" data-parent="#accordionTabelChart5">
                          <div class="card-body">
                          <div style="margin: 10px; ">
                            <table id="tabelChart5" class="table table-sm table-bordered table-hover" style="cursor:pointer; width:100%"></table>  
                          </div>
                          </div>
                          </div>
                          </div>
                      </div>
     
                        <div class="direct-chat-contacts" style="padding: 10px; height:100%; z-index:100">
                          <div class="row">
                            <div class="col-md-12">
                              <button onclick="load_data5()" type="button" class="btn btn-warning btn-xs float-right" data-widget="chat-pane-toggle">
                                <i class="fas fa-undo"></i> Reset
                              </button>
                            </div>
                            
                            <div class="col-md-12">
                              <div class="form-group">
                                <label for="">Basis Klasifikasi</label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <select id="filterKlasifikasi5" class="form-control btn-primary">
                                      <option value="kategori_kasus" selected>Default ( Kategori Kasus )</option>
                                      <option value="jenis_kekerasan" >Jenis Kekerasan</option>
                                      <option value="bentuk_kekerasan" >Bentuk Kekerasan</option>
                                    </select>
                                  </div>
                                </div>
                              </div>

                              <div class="form-group">
                                <label for="">Basis Tanggal</label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <select id="filterBasisTanggal5" class="form-control btn-primary">
                                      <option value="tanggal_approve" selected>Default ( Berdasarkan Tanggal Diregis. Hanya yang sudah dregis )</option>
                                      <option value="tanggal_pelaporan" >Berdasarkan Tanggal Pelaporan</option>
                                      <option value="tanggal_kejadian">Berdasarkan Tanggal Kejadian (Hanya yang ada Tanggal Kejadiannya)</option>
                                      <option value="created_at">Berdasarkan Tanggal Input</option>
                                    </select>
                                  </div>
                                  <input type="text" class="form-control daterank" id="filterTanggal5" value="2024-01-01 - {{ date("Y").'/'.date("m").'/'.date("d") }}">
                                </div>
                              </div>

                              <div class="form-group">
                                <label for="">Basis Wilayah</label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <select class="form-control btn-primary" id="filterBasisWilayah5">
                                      <option value="tkp" selected>Berdasarkan Wilayah TKP</option>
                                      <option value="ktp">Berdasarkan Wilayah KTP</option>
                                      <option value="domisili">Berdasarkan Wilayah Domisili</option>
                                      <option value="satpel">Berdasarkan Wilayah Satpel</option>
                                    </select>
                                  </div>
                                  <select class="form-control" id="filterWilayah5">
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
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <select class="form-control btn-primary" id="filterPenghitunganUsia5">
                                      <option value="lapor" selected>Default (Tanggal Pelaporan dikurangi Tanggal Lahir)</option>
                                      <option value ="today" >Tanggal Hari Ini dikurangi Tanggal Lahir</option>
                                      <option value="kejadian">Tanggal Kejadian dikurangi Tanggal Lahir</option>
                                      <option value="input">Tanggal Input dikurangi Tanggal Lahir</option>
                                    </select>
                                  </div>
                                  <select class="form-control" id="filterKategoriKlien5">
                                    <option value="total" selected>Default ( Semua Kategori Klien )</option>
                                    <option value="dewasa_perempuan">Perempuan Dewasa</option>
                                    <option value="anak_perempuan">Anak Perempuan</option>
                                    <option value="anak_laki">Anak Laki-laki</option>
                                  </select>
                                </div>
                              </div>

                              <div class="form-group">
                                <label for="">Kasus yang Diregis</label>
                                <br>
                                <div class="icheck-primary d-inline" style="margin-right:15px">
                                  <input type="radio" id="filterRegis5a" name="filterRegis5" value="0">
                                  <label for="filterRegis5a">
                                      Seluruh kasus
                                  </label>
                                </div>
                                <div class="icheck-primary d-inline">
                                  <input type="radio" id="filterRegis5b" name="filterRegis5" checked value="1">
                                  <label for="filterRegis5b">
                                      Kasus yang sudah diregis saja
                                  </label>
                                </div>
                                <br>
                                <span style="color: red; font-size:12px">*jika basis tanggal adalah Tanggal Diregis maka otomatis menampilkan kasus yang sudah diregis saja</span>
                              </div>

                              <div class="form-group">
                                <label for="">Kasus yang Diarsipkan</label>
                                <br>
                                <div class="icheck-primary d-inline" style="margin-right:15px">
                                  <input type="radio" id="filterArsip5a" name="filterArsip5" checked value="0">
                                  <label for="filterArsip5a">
                                      Tanpa kasus yang diarsipkan
                                  </label>
                                </div>
                                <div class="icheck-primary d-inline">
                                  <input type="radio" id="filterArsip5b" name="filterArsip5" value="1">
                                  <label for="filterArsip5b">
                                      Dengan kasus yang diarsipkan
                                  </label>
                                </div>
                              </div>
                              
                              <button onclick="load_data5()" type="button" class="btn btn-block btn-primary mt-4" data-widget="chat-pane-toggle">
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

            <div class="col-md-6 target">
              <div id="accordion6">
                <div class="card card-primary direct-chat direct-chat-primary">
                    <div class="card-header">
                      <h3 class="card-title">Jumlah Korban Kekerasan Berdasarkan Kategori Lokasi TKP</h3>
                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-widget="chat-pane-toggle">
                          <i class="fas fa-filter"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                        </button>
                        <button onclick="load_data6()" type="button" class="btn btn-tool" data-toggle="collapse" data-target="#collapse6" aria-expanded="true" aria-controls="collapse">
                          <i class="fas fa-chevron-down"></i>
                        </button>
                      </div>
                    </div>
                    
                    <div class="card-body" style="overflow: hide;">
                      <div id="overlay6" class="overlay dark" style="position: absolute; height:100%; width:100%; font-size:25px">
                        <div class="cv-spinner">
                          <span style="position: absolute">
                            Klik icon "<i class="fas fa-chevron-down"></i>" jika anda belum mengkliknya
                          </span>
                          <span class="spinner"></span>
                        </div>
                      </div>

                      <div id="collapse6" class="collapse" data-parent="#accordion6">
                        <div style="padding: 10px">
                          Filter : <span id="filter6"></span>
                        </div>
                        <div style="height: 500px;">
                          <div id="chart6" style="display: block; padding: 0px 20px"></div>
                        </div>
                        {{-- Data Tabulasi --}}
                        <div id="accordionTabelChart6" style="margin-bottom:-15px">
                          <div class="card card-light">
                            <div class="card-header" data-toggle="collapse" data-target="#collapseTabelChart6" aria-expanded="true" aria-controls="collapseTabelChart6" style="cursor: pointer;">
                              <h3 class="card-title">
                                  <b>Data Tabulasi</b>
                              </h3>
                              <div class="card-tools">
                                <button type="button" class="btn btn-tool">
                                  <i class="fas fa-chevron-down"></i>
                                </button>
                              </div>
                            </div>
                          <div id="collapseTabelChart6" class="collapse" data-parent="#accordionTabelChart6">
                          <div class="card-body">
                          <div style="margin: 10px; ">
                            <table id="tabelChart6" class="table table-sm table-bordered table-hover" style="cursor:pointer; width:100%"></table>  
                          </div>
                          </div>
                          </div>
                          </div>
                      </div>
     
                        <div class="direct-chat-contacts" style="padding: 10px; height:100%; z-index:100">
                          <div class="row">
                            <div class="col-md-12">
                              <button onclick="load_data6()" type="button" class="btn btn-warning btn-xs float-right" data-widget="chat-pane-toggle">
                                <i class="fas fa-undo"></i> Reset
                              </button>
                            </div>
                            
                            <div class="col-md-12">
                              <div class="form-group">
                                <label for="">Basis Tanggal</label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <select id="filterBasisTanggal6" class="form-control btn-primary">
                                      <option value="tanggal_approve" selected>Default ( Berdasarkan Tanggal Diregis. Hanya yang sudah dregis )</option>
                                      <option value="tanggal_pelaporan" >Berdasarkan Tanggal Pelaporan</option>
                                      <option value="tanggal_kejadian">Berdasarkan Tanggal Kejadian (Hanya yang ada Tanggal Kejadiannya)</option>
                                      <option value="created_at">Berdasarkan Tanggal Input</option>
                                    </select>
                                  </div>
                                  <input type="text" class="form-control daterank" id="filterTanggal6" value="2024-01-01 - {{ date("Y").'/'.date("m").'/'.date("d") }}">
                                </div>
                              </div>

                              <div class="form-group">
                                <label for="">Basis Wilayah</label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <select class="form-control btn-primary" id="filterBasisWilayah6">
                                      <option value="tkp" selected>Berdasarkan Wilayah TKP</option>
                                      <option value="ktp">Berdasarkan Wilayah KTP</option>
                                      <option value="domisili">Berdasarkan Wilayah Domisili</option>
                                      <option value="satpel">Berdasarkan Wilayah Satpel</option>
                                    </select>
                                  </div>
                                  <select class="form-control" id="filterWilayah6">
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
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <select class="form-control btn-primary" id="filterPenghitunganUsia6">
                                      <option value="lapor" selected>Default (Tanggal Pelaporan dikurangi Tanggal Lahir)</option>
                                      <option value ="today" >Tanggal Hari Ini dikurangi Tanggal Lahir</option>
                                      <option value="kejadian">Tanggal Kejadian dikurangi Tanggal Lahir</option>
                                      <option value="input">Tanggal Input dikurangi Tanggal Lahir</option>
                                    </select>
                                  </div>
                                  <select class="form-control" id="filterKategoriKlien6">
                                    <option value="total" selected>Default ( Semua Kategori Klien )</option>
                                    <option value="dewasa_perempuan">Perempuan Dewasa</option>
                                    <option value="anak_perempuan">Anak Perempuan</option>
                                    <option value="anak_laki">Anak Laki-laki</option>
                                  </select>
                                </div>
                              </div>

                              <div class="form-group">
                                <label for="">Kasus yang Diregis</label>
                                <br>
                                <div class="icheck-primary d-inline" style="margin-right:15px">
                                  <input type="radio" id="filterRegis6a" name="filterRegis6" value="0">
                                  <label for="filterRegis6a">
                                      Seluruh kasus
                                  </label>
                                </div>
                                <div class="icheck-primary d-inline">
                                  <input type="radio" id="filterRegis6b" name="filterRegis6" checked value="1">
                                  <label for="filterRegis6b">
                                      Kasus yang sudah diregis saja
                                  </label>
                                </div>
                                <br>
                                <span style="color: red; font-size:12px">*jika basis tanggal adalah Tanggal Diregis maka otomatis menampilkan kasus yang sudah diregis saja</span>
                              </div>

                              <div class="form-group">
                                <label for="">Kasus yang Diarsipkan</label>
                                <br>
                                <div class="icheck-primary d-inline" style="margin-right:15px">
                                  <input type="radio" id="filterArsip6a" name="filterArsip6" checked value="0">
                                  <label for="filterArsip6a">
                                      Tanpa kasus yang diarsipkan
                                  </label>
                                </div>
                                <div class="icheck-primary d-inline">
                                  <input type="radio" id="filterArsip6b" name="filterArsip6" value="1">
                                  <label for="filterArsip6b">
                                      Dengan kasus yang diarsipkan
                                  </label>
                                </div>
                              </div>
                              
                              <button onclick="load_data6()" type="button" class="btn btn-block btn-primary mt-4" data-widget="chat-pane-toggle">
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

            <div class="col-md-6 target">
              <div id="accordion7">
                <div class="card card-primary direct-chat direct-chat-primary">
                    <div class="card-header">
                      <h3 class="card-title">Jumlah Berdasarkan Rentang Usia (<span id="titleChart7">korban</span>)</h3>
                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-widget="chat-pane-toggle">
                          <i class="fas fa-filter"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                        </button>
                        <button onclick="load_data7()" type="button" class="btn btn-tool" data-toggle="collapse" data-target="#collapse7" aria-expanded="true" aria-controls="collapse">
                          <i class="fas fa-chevron-down"></i>
                        </button>
                      </div>
                    </div>
                    
                    <div class="card-body" style="overflow: hide;">
                      <div id="overlay7" class="overlay dark" style="position: absolute; height:100%; width:100%; font-size:25px">
                        <div class="cv-spinner">
                          <span style="position: absolute">
                            Klik icon "<i class="fas fa-chevron-down"></i>" jika anda belum mengkliknya
                          </span>
                          <span class="spinner"></span>
                        </div>
                      </div>

                      <div id="collapse7" class="collapse" data-parent="#accordion7">
                        <div style="padding: 10px">
                          Filter : <span id="filter7"></span>
                        </div>
                        <div style="height: 500px;">
                          <div id="chart7" style="display: block; padding: 0px 20px"></div>
                        </div>
                        {{-- Data Tabulasi --}}
                        <div id="accordionTabelChart7" style="margin-bottom:-15px">
                          <div class="card card-light">
                            <div class="card-header" data-toggle="collapse" data-target="#collapseTabelChart7" aria-expanded="true" aria-controls="collapseTabelChart7" style="cursor: pointer;">
                              <h3 class="card-title">
                                  <b>Data Tabulasi</b>
                              </h3>
                              <div class="card-tools">
                                <button type="button" class="btn btn-tool">
                                  <i class="fas fa-chevron-down"></i>
                                </button>
                              </div>
                            </div>
                          <div id="collapseTabelChart7" class="collapse" data-parent="#accordionTabelChart7">
                          <div class="card-body">
                          <div style="margin: 10px; ">
                            <table id="tabelChart7" class="table table-sm table-bordered table-hover" style="cursor:pointer; width:100%"></table>  
                          </div>
                          </div>
                          </div>
                          </div>
                      </div>
     
                        <div class="direct-chat-contacts" style="padding: 10px; height:100%; z-index:100">
                          <div class="row">
                            <div class="col-md-12">
                              <button onclick="load_data7()" type="button" class="btn btn-warning btn-xs float-right" data-widget="chat-pane-toggle">
                                <i class="fas fa-undo"></i> Reset
                              </button>
                            </div>
                            
                            <div class="col-md-12">
                              <div class="form-group">
                                <label for="">Basis Identitas</label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <select id="filterBasisIdentitas7" class="form-control btn-primary">
                                      <option value="korban" selected>Default ( Korban )</option>
                                      <option value="terlapor" >Terlapor</option>
                                      <option value="pelapor">Pelapor</option>
                                    </select>
                                  </div>
                                  {{-- <input type="text" class="form-control daterank" id="filterTanggal7" value="2024-01-01 - {{ date("Y").'/'.date("m").'/'.date("d") }}"> --}}
                                </div>
                              </div>

                              <div class="form-group">
                                <label for="">Basis Tanggal</label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <select id="filterBasisTanggal7" class="form-control btn-primary">
                                      <option value="tanggal_approve" selected>Default ( Berdasarkan Tanggal Diregis. Hanya yang sudah dregis )</option>
                                      <option value="tanggal_pelaporan" >Berdasarkan Tanggal Pelaporan</option>
                                      <option value="tanggal_kejadian">Berdasarkan Tanggal Kejadian (Hanya yang ada Tanggal Kejadiannya)</option>
                                      <option value="created_at">Berdasarkan Tanggal Input</option>
                                    </select>
                                  </div>
                                  <input type="text" class="form-control daterank" id="filterTanggal7" value="2024-01-01 - {{ date("Y").'/'.date("m").'/'.date("d") }}">
                                </div>
                              </div>

                              <div class="form-group">
                                <label for="">Basis Wilayah</label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <select class="form-control btn-primary" id="filterBasisWilayah7">
                                      <option value="tkp" selected>Berdasarkan Wilayah TKP</option>
                                      <option value="ktp">Berdasarkan Wilayah KTP</option>
                                      <option value="domisili">Berdasarkan Wilayah Domisili</option>
                                      <option value="satpel">Berdasarkan Wilayah Satpel</option>
                                    </select>
                                  </div>
                                  <select class="form-control" id="filterWilayah7">
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
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <select class="form-control btn-primary" id="filterPenghitunganUsia7">
                                      <option value="lapor" selected>Default (Tanggal Pelaporan dikurangi Tanggal Lahir)</option>
                                      <option value ="today" >Tanggal Hari Ini dikurangi Tanggal Lahir</option>
                                      <option value="kejadian">Tanggal Kejadian dikurangi Tanggal Lahir</option>
                                      <option value="input">Tanggal Input dikurangi Tanggal Lahir</option>
                                    </select>
                                  </div>
                                  <select class="form-control" id="filterKategoriKlien7">
                                    <option value="total" selected>Default ( Semua Kategori Klien )</option>
                                    <option value="dewasa_perempuan">Perempuan Dewasa</option>
                                    <option value="dewasa_laki">Pria Dewasa (sudah bukan klien lagi)</option>
                                    <option value="anak_perempuan">Anak Perempuan</option>
                                    <option value="anak_laki">Anak Laki-laki</option>
                                  </select>
                                </div>
                              </div>

                              <div class="form-group">
                                <label for="">Kasus yang Diregis</label>
                                <br>
                                <div class="icheck-primary d-inline" style="margin-right:15px">
                                  <input type="radio" id="filterRegis6a" name="filterRegis7" value="0">
                                  <label for="filterRegis7a">
                                      Seluruh kasus
                                  </label>
                                </div>
                                <div class="icheck-primary d-inline">
                                  <input type="radio" id="filterRegis7b" name="filterRegis7" checked value="1">
                                  <label for="filterRegis7b">
                                      Kasus yang sudah diregis saja
                                  </label>
                                </div>
                                <br>
                                <span style="color: red; font-size:12px">*jika basis tanggal adalah Tanggal Diregis maka otomatis menampilkan kasus yang sudah diregis saja</span>
                              </div>

                              <div class="form-group">
                                <label for="">Kasus yang Diarsipkan</label>
                                <br>
                                <div class="icheck-primary d-inline" style="margin-right:15px">
                                  <input type="radio" id="filterArsip7a" name="filterArsip7" checked value="0">
                                  <label for="filterArsip7a">
                                      Tanpa kasus yang diarsipkan
                                  </label>
                                </div>
                                <div class="icheck-primary d-inline">
                                  <input type="radio" id="filterArsip7b" name="filterArsip7" value="1">
                                  <label for="filterArsip7b">
                                      Dengan kasus yang diarsipkan
                                  </label>
                                </div>
                              </div>
                              
                              <button onclick="load_data7()" type="button" class="btn btn-block btn-primary mt-4" data-widget="chat-pane-toggle">
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

            <div class="col-md-6 target">
              <div id="accordion8">
                <div class="card card-primary direct-chat direct-chat-primary">
                    <div class="card-header">
                      <h3 class="card-title">Jumlah Berdasarkan Pendidikan (<span id="titleChart8">korban</span>)</h3>
                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-widget="chat-pane-toggle">
                          <i class="fas fa-filter"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                        </button>
                        <button onclick="load_data8()" type="button" class="btn btn-tool" data-toggle="collapse" data-target="#collapse8" aria-expanded="true" aria-controls="collapse">
                          <i class="fas fa-chevron-down"></i>
                        </button>
                      </div>
                    </div>
                    
                    <div class="card-body" style="overflow: hide;">
                      <div id="overlay8" class="overlay dark" style="position: absolute; height:100%; width:100%; font-size:25px">
                        <div class="cv-spinner">
                          <span style="position: absolute">
                            Klik icon "<i class="fas fa-chevron-down"></i>" jika anda belum mengkliknya
                          </span>
                          <span class="spinner"></span>
                        </div>
                      </div>

                      <div id="collapse8" class="collapse" data-parent="#accordion8">
                        <div style="padding: 10px">
                          Filter : <span id="filter8"></span>
                        </div>
                        <div style="height: 500px;">
                          <div id="chart8" style="display: block; padding: 0px 20px"></div>
                        </div>
                        {{-- Data Tabulasi --}}
                        <div id="accordionTabelChart8" style="margin-bottom:-15px">
                          <div class="card card-light">
                            <div class="card-header" data-toggle="collapse" data-target="#collapseTabelChart8" aria-expanded="true" aria-controls="collapseTabelChart8" style="cursor: pointer;">
                              <h3 class="card-title">
                                  <b>Data Tabulasi</b>
                              </h3>
                              <div class="card-tools">
                                <button type="button" class="btn btn-tool">
                                  <i class="fas fa-chevron-down"></i>
                                </button>
                              </div>
                            </div>
                          <div id="collapseTabelChart8" class="collapse" data-parent="#accordionTabelChart8">
                          <div class="card-body">
                          <div style="margin: 10px; ">
                            <table id="tabelChart8" class="table table-sm table-bordered table-hover" style="cursor:pointer; width:100%"></table>  
                          </div>
                          </div>
                          </div>
                          </div>
                      </div>
     
                        <div class="direct-chat-contacts" style="padding: 10px; height:100%; z-index:100">
                          <div class="row">
                            <div class="col-md-12">
                              <button onclick="load_data8()" type="button" class="btn btn-warning btn-xs float-right" data-widget="chat-pane-toggle">
                                <i class="fas fa-undo"></i> Reset
                              </button>
                            </div>
                            
                            <div class="col-md-12">
                              <div class="form-group">
                                <label for="">Basis Identitas</label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <select id="filterBasisIdentitas8" class="form-control btn-primary">
                                      <option value="korban" selected>Default ( Korban )</option>
                                      <option value="terlapor" >Terlapor</option>
                                      <option value="pelapor">Pelapor</option>
                                    </select>
                                  </div>
                                  {{-- <input type="text" class="form-control daterank" id="filterTanggal7" value="2024-01-01 - {{ date("Y").'/'.date("m").'/'.date("d") }}"> --}}
                                </div>
                              </div>

                              <div class="form-group">
                                <label for="">Basis Tanggal</label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <select id="filterBasisTanggal8" class="form-control btn-primary">
                                      <option value="tanggal_approve" selected>Default ( Berdasarkan Tanggal Diregis. Hanya yang sudah dregis )</option>
                                      <option value="tanggal_pelaporan" >Berdasarkan Tanggal Pelaporan</option>
                                      <option value="tanggal_kejadian">Berdasarkan Tanggal Kejadian (Hanya yang ada Tanggal Kejadiannya)</option>
                                      <option value="created_at">Berdasarkan Tanggal Input</option>
                                    </select>
                                  </div>
                                  <input type="text" class="form-control daterank" id="filterTanggal8" value="2024-01-01 - {{ date("Y").'/'.date("m").'/'.date("d") }}">
                                </div>
                              </div>

                              <div class="form-group">
                                <label for="">Basis Wilayah</label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <select class="form-control btn-primary" id="filterBasisWilayah8">
                                      <option value="tkp" selected>Berdasarkan Wilayah TKP</option>
                                      <option value="ktp">Berdasarkan Wilayah KTP</option>
                                      <option value="domisili">Berdasarkan Wilayah Domisili</option>
                                      <option value="satpel">Berdasarkan Wilayah Satpel</option>
                                    </select>
                                  </div>
                                  <select class="form-control" id="filterWilayah8">
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
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <select class="form-control btn-primary" id="filterPenghitunganUsia8">
                                      <option value="lapor" selected>Default (Tanggal Pelaporan dikurangi Tanggal Lahir)</option>
                                      <option value ="today" >Tanggal Hari Ini dikurangi Tanggal Lahir</option>
                                      <option value="kejadian">Tanggal Kejadian dikurangi Tanggal Lahir</option>
                                      <option value="input">Tanggal Input dikurangi Tanggal Lahir</option>
                                    </select>
                                  </div>
                                  <select class="form-control" id="filterKategoriKlien8">
                                    <option value="total" selected>Default ( Semua Kategori Klien )</option>
                                    <option value="dewasa_perempuan">Perempuan Dewasa</option>
                                    <option value="anak_perempuan">Anak Perempuan</option>
                                    <option value="anak_laki">Anak Laki-laki</option>
                                  </select>
                                </div>
                              </div>

                              <div class="form-group">
                                <label for="">Kasus yang Diregis</label>
                                <br>
                                <div class="icheck-primary d-inline" style="margin-right:15px">
                                  <input type="radio" id="filterRegis6a" name="filterRegis8" value="0">
                                  <label for="filterRegis8a">
                                      Seluruh kasus
                                  </label>
                                </div>
                                <div class="icheck-primary d-inline">
                                  <input type="radio" id="filterRegis8b" name="filterRegis8" checked value="1">
                                  <label for="filterRegis8b">
                                      Kasus yang sudah diregis saja
                                  </label>
                                </div>
                                <br>
                                <span style="color: red; font-size:12px">*jika basis tanggal adalah Tanggal Diregis maka otomatis menampilkan kasus yang sudah diregis saja</span>
                              </div>

                              <div class="form-group">
                                <label for="">Kasus yang Diarsipkan</label>
                                <br>
                                <div class="icheck-primary d-inline" style="margin-right:15px">
                                  <input type="radio" id="filterArsip8a" name="filterArsip8" checked value="0">
                                  <label for="filterArsip8a">
                                      Tanpa kasus yang diarsipkan
                                  </label>
                                </div>
                                <div class="icheck-primary d-inline">
                                  <input type="radio" id="filterArsip8b" name="filterArsip8" value="1">
                                  <label for="filterArsip8b">
                                      Dengan kasus yang diarsipkan
                                  </label>
                                </div>
                              </div>
                              
                              <button onclick="load_data8()" type="button" class="btn btn-block btn-primary mt-4" data-widget="chat-pane-toggle">
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

            <div class="col-md-6 target">
              <div id="accordion9">
                <div class="card card-primary direct-chat direct-chat-primary">
                    <div class="card-header">
                      <h3 class="card-title">Jumlah Berdasarkan Pekerjaan (<span id="titleChart9">korban</span>)</h3>
                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-widget="chat-pane-toggle">
                          <i class="fas fa-filter"></i>
                        </button>
                        <button type="button" class="btn btn-tool"><i class="fas fa-expand"></i>
                        </button>
                        <button onclick="load_data9()" type="button" class="btn btn-tool" data-toggle="collapse" data-target="#collapse9" aria-expanded="true" aria-controls="collapse">
                          <i class="fas fa-chevron-down"></i>
                        </button>
                      </div>
                    </div>
                    
                    <div class="card-body" style="overflow: hide;">
                      <div id="overlay9" class="overlay dark" style="position: absolute; height:100%; width:100%; font-size:25px">
                        <div class="cv-spinner">
                          <span style="position: absolute">
                            Klik icon "<i class="fas fa-chevron-down"></i>" jika anda belum mengkliknya
                          </span>
                          <span class="spinner"></span>
                        </div>
                      </div>

                      <div id="collapse9" class="collapse" data-parent="#accordion9">
                        <div style="padding: 10px">
                          Filter : <span id="filter8"></span>
                        </div>
                        <div style="height: 500px;">
                          <div id="chart9" style="display: block; padding: 0px 20px"></div>
                        </div>
                        {{-- Data Tabulasi --}}
                        <div id="accordionTabelChart9" style="margin-bottom:-15px">
                          <div class="card card-light">
                            <div class="card-header" data-toggle="collapse" data-target="#collapseTabelChart9" aria-expanded="true" aria-controls="collapseTabelChart9" style="cursor: pointer;">
                              <h3 class="card-title">
                                  <b>Data Tabulasi</b>
                              </h3>
                              <div class="card-tools">
                                <button type="button" class="btn btn-tool">
                                  <i class="fas fa-chevron-down"></i>
                                </button>
                              </div>
                            </div>
                          <div id="collapseTabelChart9" class="collapse" data-parent="#accordionTabelChart9">
                          <div class="card-body">
                          <div style="margin: 10px; ">
                            <table id="tabelChart9" class="table table-sm table-bordered table-hover" style="cursor:pointer; width:100%"></table>  
                          </div>
                          </div>
                          </div>
                          </div>
                      </div>
     
                        <div class="direct-chat-contacts" style="padding: 10px; height:100%; z-index:100">
                          <div class="row">
                            <div class="col-md-12">
                              <button onclick="load_data9()" type="button" class="btn btn-warning btn-xs float-right" data-widget="chat-pane-toggle">
                                <i class="fas fa-undo"></i> Reset
                              </button>
                            </div>
                            
                            <div class="col-md-12">
                              <div class="form-group">
                                <label for="">Basis Identitas</label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <select id="filterBasisIdentitas9" class="form-control btn-primary">
                                      <option value="korban" selected>Default ( Korban )</option>
                                      <option value="terlapor" >Terlapor</option>
                                      <option value="pelapor">Pelapor</option>
                                    </select>
                                  </div>
                                  {{-- <input type="text" class="form-control daterank" id="filterTanggal7" value="2024-01-01 - {{ date("Y").'/'.date("m").'/'.date("d") }}"> --}}
                                </div>
                              </div>

                              <div class="form-group">
                                <label for="">Basis Tanggal</label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <select id="filterBasisTanggal9" class="form-control btn-primary">
                                      <option value="tanggal_approve" selected>Default ( Berdasarkan Tanggal Diregis. Hanya yang sudah dregis )</option>
                                      <option value="tanggal_pelaporan" >Berdasarkan Tanggal Pelaporan</option>
                                      <option value="tanggal_kejadian">Berdasarkan Tanggal Kejadian (Hanya yang ada Tanggal Kejadiannya)</option>
                                      <option value="created_at">Berdasarkan Tanggal Input</option>
                                    </select>
                                  </div>
                                  <input type="text" class="form-control daterank" id="filterTanggal9" value="2024-01-01 - {{ date("Y").'/'.date("m").'/'.date("d") }}">
                                </div>
                              </div>

                              <div class="form-group">
                                <label for="">Basis Wilayah</label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <select class="form-control btn-primary" id="filterBasisWilayah9">
                                      <option value="tkp" selected>Berdasarkan Wilayah TKP</option>
                                      <option value="ktp">Berdasarkan Wilayah KTP</option>
                                      <option value="domisili">Berdasarkan Wilayah Domisili</option>
                                      <option value="satpel">Berdasarkan Wilayah Satpel</option>
                                    </select>
                                  </div>
                                  <select class="form-control" id="filterWilayah9">
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
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <select class="form-control btn-primary" id="filterPenghitunganUsia9">
                                      <option value="lapor" selected>Default (Tanggal Pelaporan dikurangi Tanggal Lahir)</option>
                                      <option value ="today" >Tanggal Hari Ini dikurangi Tanggal Lahir</option>
                                      <option value="kejadian">Tanggal Kejadian dikurangi Tanggal Lahir</option>
                                      <option value="input">Tanggal Input dikurangi Tanggal Lahir</option>
                                    </select>
                                  </div>
                                  <select class="form-control" id="filterKategoriKlien9">
                                    <option value="total" selected>Default ( Semua Kategori Klien )</option>
                                    <option value="dewasa_perempuan">Perempuan Dewasa</option>
                                    <option value="anak_perempuan">Anak Perempuan</option>
                                    <option value="anak_laki">Anak Laki-laki</option>
                                  </select>
                                </div>
                              </div>

                              <div class="form-group">
                                <label for="">Kasus yang Diregis</label>
                                <br>
                                <div class="icheck-primary d-inline" style="margin-right:15px">
                                  <input type="radio" id="filterRegis6a" name="filterRegis9" value="0">
                                  <label for="filterRegis9a">
                                      Seluruh kasus
                                  </label>
                                </div>
                                <div class="icheck-primary d-inline">
                                  <input type="radio" id="filterRegis9b" name="filterRegis9" checked value="1">
                                  <label for="filterRegis9b">
                                      Kasus yang sudah diregis saja
                                  </label>
                                </div>
                                <br>
                                <span style="color: red; font-size:12px">*jika basis tanggal adalah Tanggal Diregis maka otomatis menampilkan kasus yang sudah diregis saja</span>
                              </div>

                              <div class="form-group">
                                <label for="">Kasus yang Diarsipkan</label>
                                <br>
                                <div class="icheck-primary d-inline" style="margin-right:15px">
                                  <input type="radio" id="filterArsip9a" name="filterArsip9" checked value="0">
                                  <label for="filterArsip9a">
                                      Tanpa kasus yang diarsipkan
                                  </label>
                                </div>
                                <div class="icheck-primary d-inline">
                                  <input type="radio" id="filterArsip9b" name="filterArsip9" value="1">
                                  <label for="filterArsip9b">
                                      Dengan kasus yang diarsipkan
                                  </label>
                                </div>
                              </div>
                              
                              <button onclick="load_data9()" type="button" class="btn btn-block btn-primary mt-4" data-widget="chat-pane-toggle">
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
<script src="https://cdn.rawgit.com/ashl1/datatables-rowsgroup/fbd569b8768155c7a9a62568e66a64115887d7d0/dataTables.rowsGroup.js"></script>

<!-- InputMask -->
<script src="{{ asset('adminlte') }}/plugins/moment/moment.min.js"></script>
<script src="{{ asset('adminlte') }}/plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- date-range-picker -->
<script src="{{ asset('adminlte') }}/plugins/daterangepicker/daterangepicker.js"></script>
<script>
  $(document).ready(function() {
      $('.datatableall').DataTable({
      "pageLength" : 5,
      "lengthMenu": [
          [10, 25, 50, 100, -1],
          ['10 rows', '25 rows', '50 rows', '100 rows','All'],
      ],
    });
      load_data11();
      // update data whatsaapp
      load_data3();
  });

  function load_rekap1() {
    load_data5('kategori_kasus');
    load_data5('jenis_kekerasan');
    load_data5('bentuk_kekerasan');
  }

  function search() {
        var input = document.getElementById("Search");
        var filter = input.value.toLowerCase();
        var nodes = document.getElementsByClassName('target');

        for (i = 0; i < nodes.length; i++) {
            if (nodes[i].innerText.toLowerCase().includes(filter)) {
                nodes[i].style.display = "block";
            } else {
                nodes[i].style.display = "none";
            }
        }
    }
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

  function copyTextExportData(exportDataId) {
    var text = $('#' + exportDataId)
            .clone()
            .find('span')
            .each(function() {
                $(this).replaceWith($(this).text());
            })
            .end()
            .text()
            .trim()
            .replace(/\s*[\r\n]+\s*/g, "\n");
      var tempInput = $('<textarea>');
      $('body').append(tempInput);
      tempInput.val(text).select();
      document.execCommand('copy');
      tempInput.remove();      
      alert('Text berhasil dicopy ke clipboard');
  }

  function load_data1() {
    // show load 
    $("#overlay1").show();

    $('#label_monitoring_kasus').show();
    $('#label_monitoring_kasus_mv').hide();

    if ($.fn.DataTable.isDataTable('#tabelMonitoring')) {
        $('#tabelMonitoring').DataTable().destroy();
    }
    $('#filter1').html('');
    $('#filter1').append("<span class=\"badge bg-primary\">basis tanggal : "+$('#filter1BasisTanggal2').val()+"</span> ");
    $('#filter1').append("<span class=\"badge bg-primary\">tanggal : "+$('#filter1Tanggal2').val()+"</span> ");
    $('#filter1').append("<span class=\"badge bg-primary\">tampilkan seluruh kasus anda : "+$('input[name="filter2Anda"]:checked').val()+"</span> ");
    $('#filter1').append("<span class=\"badge bg-warning\">Data ini disajikan pada : "+getCurrentDateTime()+"</span> ");

    $('#tabelMonitoring').DataTable({
      "ordering": true,
      "order": [],
      "processing": true,
      "serverSide": true,
      "responsive": false, 
      "lengthChange": false, 
      "autoWidth": false,
      "ajax": {
          "url":  "{{ env('APP_URL') }}/monitoring/monitoringkasusmv?user_id={{ Auth::user()->id }}&basis_tanggal=" + $('#filterBasisTanggal1').val() + "&tanggal=" + $('#filterTanggal1').val() + "&anda=" + $('input[name="filterAnda1"]:checked').val(),
          "error": function(xhr, error, thrown) {
              alert("Data rekapan belum tersedia. Anda dapat menunggu 2 menit lagi atau gunakan Data Realtime");
              console.error("DataTables error: ", xhr.responseText);
          }
      },
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
          $("#overlay1").hide();
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
          
        });
    });
  }

  function load_data1a() {
    // show load 
    $("#overlay1").show();
    $('#label_monitoring_kasus').hide();
    $('#label_monitoring_kasus_mv').show();
    if ($.fn.DataTable.isDataTable('#tabelMonitoring')) {
        $('#tabelMonitoring').DataTable().destroy();
    }
    $('#filter1').html('');
    $('#filter1').append("<span class=\"badge bg-primary\">basis tanggal : "+$('#filter1BasisTanggal2').val()+"</span> ");
    $('#filter1').append("<span class=\"badge bg-primary\">tanggal : "+$('#filter1Tanggal2').val()+"</span> ");
    $('#filter1').append("<span class=\"badge bg-primary\">tampilkan seluruh kasus anda : "+$('input[name="filter2Anda"]:checked').val()+"</span> ");
    $('#filter1').append("<span class=\"badge bg-warning\">Data ini disajikan pada : "+getCurrentDateTime()+"</span> ");

    $('#tabelMonitoring').DataTable({
      "ordering": true,
      "order": [],
      "processing": true,
      "serverSide": true,
      "responsive": false, 
      "lengthChange": false, 
      "autoWidth": false,
      "ajax": "{{ env('APP_URL') }}/monitoring/monitoringkasus?user_id={{ Auth::user()->id }}&basis_tanggal=" + $('#filterBasisTanggal1').val() + "&tanggal=" + $('#filterTanggal1').val() + "&anda=" + $('input[name="filterAnda1"]:checked').val(),
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
          $("#overlay1").hide();
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
          
        });
    });
  }

function load_data2() {
  // show load 
  $("#overlay2").show();
  // filter 
  pengelompokan = $('input[name="filterPengelompokan2"]:checked').val();
  basisTanggal = $('#filterBasisTanggal2').val();
  tanggal = $('#filterTanggal2').val();
  basisWilayah = $('#filterBasisWilayah2').val();
  wilayah = $('#filterWilayah2').val();
  penghitunganUsia = $('#filterPenghitunganUsia2').val();
  regis = $('input[name="filterRegis2"]:checked').val();
  arsip = $('input[name="filterArsip2"]:checked').val();
  $.ajax({
    url:'{{ route("api.v1.jumlahkorban") }}?pengelompokan='+pengelompokan+'&basis_tanggal='+basisTanggal+'&tanggal='+tanggal+'&basis_wilayah='+basisWilayah+'&wilayah='+wilayah+'&penghitungan_usia='+penghitunganUsia+'&regis='+regis+'&arsip='+arsip,
    type:'GET',
    dataType: 'json',
    success: function (response){
      // setup filter
      $('#filter2').html('');
      $.each(response.filter, function(key, value) {
        $('#filter2').append("<span class=\"badge bg-primary\">"+key.replace(/_/g, ' ')+" : "+value.replace(/_/g, ' ')+"</span> ");
      });
      $('#filter2').append("<span class=\"badge bg-warning\">Data ini disajikan pada : "+getCurrentDateTime()+"</span> ");
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
      tooltip: {
        style: {
          fontSize: '25px'
        }
      },
      colors: ['#545454', '#fc03be', '#fcba03', '#36a2eb'],
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
      
      var chart = new ApexCharts(document.querySelector("#chart2"), options);
      chart.render();
      // hapus dulu char yang lama kemudian buat lagi
      chart.destroy();
      var chart = new ApexCharts(document.querySelector("#chart2"), options);
      chart.render();
    },
    error: function (response){
        setTimeout(function(){
        $("#overlay2").fadeOut(300);
        },500);
        alert(response);
    }
    }).done(function() { //loading submit form
        setTimeout(function(){
        $("#overlay2").fadeOut(300);
        },500);
  });
}


  function load_data3() {
    // show load 
    $("#overlay3").show();
    // filter 
    pengelompokan = 'tahun';
    basisTanggal = $('#filterBasisTanggal3').val();
    tanggal = $('#filterTanggal3').val();
    basisWilayah = $('#filterBasisWilayah3').val();
    wilayah = $('#filterWilayah3').val();
    penghitunganUsia = $('#filterPenghitunganUsia3').val();
    regis = $('input[name="filterRegis3"]:checked').val();
    arsip = $('input[name="filterArsip3"]:checked').val();
    $.ajax({
      url:'{{ route("api.v1.jumlahkorban") }}?pengelompokan='+pengelompokan+'&basis_tanggal='+basisTanggal+'&tanggal='+tanggal+'&basis_wilayah='+basisWilayah+'&wilayah='+wilayah+'&penghitungan_usia='+penghitunganUsia+'&regis='+regis+'&arsip='+arsip+'&rekaptotal=1',
      type:'GET',
      dataType: 'json',
      success: function (response){
        // setup filter
        $('#filter3').html('');
        $.each(response.filter, function(key, value) {
          $('#filter3').append("<span class=\"badge bg-primary\">"+key.replace(/_/g, ' ')+" : "+value.replace(/_/g, ' ')+"</span> ");
        });
        $('#filter3').append("<span class=\"badge bg-warning\">Data ini disajikan pada : "+getCurrentDateTime()+"</span> ");
        datas = response.data;

        // update data whatsapp 
        $('#jumlah_seluruh_klien').html(datas.seluruh_klien);
        $('#jumlah_perempuan_dewasa').html(datas.dewasa_perempuan);
        $('#jumlah_anak_perempuan').html(datas.anak_perempuan);
        $('#jumlah_anak_laki').html(datas.anak_laki);
        
        
        // setup chart
        var options = {
          series: [datas.dewasa_perempuan, datas.anak_perempuan, datas.anak_laki],
          chart: {
            toolbar: {
            show: true
            },
            height: '100%',
            type: 'pie'
          },
          tooltip: {
            style: {
              fontSize: '25px'
            }
          },
         dataLabels: {
              enabled: true,
              style: {
                fontSize: "30px",
              }
            },
        legend: {
          fontSize: "20px"
        },
        labels: ['Perempuan Dewasa', 'Anak Perempuan', 'Anak Laki-laki'],
        colors: ['#fc03be', '#fcba03', '#36a2eb'],
        responsive: [{
          breakpoint: 500,
          options: {
            chart: {
              height: '100%'
            },
            legend: {
              position: 'bottom'
            }
          }
        }]
        };
        
        var chart = new ApexCharts(document.querySelector("#chart3"), options);
        chart.render();
        // hapus dulu char yang lama kemudian buat lagi
        chart.destroy();
        var chart = new ApexCharts(document.querySelector("#chart3"), options);
        chart.render();
      },
      error: function (response){
          setTimeout(function(){
          $("#overlay3").fadeOut(300);
          },500);
          alert(response);
      }
      }).done(function() { //loading submit form
          setTimeout(function(){
          $("#overlay3").fadeOut(300);
          },500);
    });
  }

  var chart4; 
  function load_data4() {
      $("#overlay4").show();
      if ($.fn.DataTable.isDataTable('#tabelChart4')) {
          $('#tabelChart4').DataTable().destroy();
      }

      pengelompokan = 'tahun';
      basisTanggal = $('#filterBasisTanggal4').val();
      tanggal = $('#filterTanggal4').val();
      basisWilayah = $('#filterBasisWilayah4').val();
      regis = $('input[name="filterRegis4"]:checked').val();
      arsip = $('input[name="filterArsip4"]:checked').val();
      titleChart4 = $('#titleChart4').html(basisWilayah);

      $.ajax({
          url: '{{ route("api.v1.jumlahkorbanwilayah") }}?pengelompokan=' + pengelompokan + '&basis_tanggal=' + basisTanggal + '&tanggal=' + tanggal + '&basis_wilayah=' + basisWilayah + '&regis=' + regis + '&arsip=' + arsip + '&rekaptotal=1',
          type: 'GET',
          dataType: 'json',
          success: function(response) {
              $('#filter4').html('');
              $.each(response.filter, function(key, value) {
                  $('#filter4').append("<span class=\"badge bg-primary\">" + key.replace(/_/g, ' ') + " : " + value.toString().replace(/_/g, ' ') + "</span> ");
              });
              $('#filter4').append("<span class=\"badge bg-warning\">Data ini disajikan pada : " + getCurrentDateTime() + "</span> ");
              var jumlah = Object.values(response.data);
              var labels = Object.keys(response.data);

              if (!chart4) {
                  // Create chart instance if it doesn't exist
                  var options = {
                      series: jumlah,
                      chart: {
                          toolbar: {
                              show: true
                          },
                          height: '100%',
                          type: 'pie'
                      },
                      tooltip: {
                          style: {
                              fontSize: '25px'
                          }
                      },
                      dataLabels: {
                          enabled: true,
                          style: {
                              fontSize: "30px",
                          }
                      },
                      legend: {
                          fontSize: "20px"
                      },
                      labels: labels,
                      colors: ['#080708', '#fc03be', '#fcba03', '#36a2eb', '#36eb6f', '#7e36eb', '#eb3636', '#eb8a36'],
                      responsive: [{
                          breakpoint: 500,
                          options: {
                              chart: {
                                height: '100%',
                              },
                              legend: {
                                  position: 'bottom'
                              }
                          }
                      }]
                  };

                  chart4 = new ApexCharts(document.querySelector("#chart4"), options);
                  chart4.render();
              } else {
                  // Update chart data if it exists
                  chart4.updateOptions({
                      series: jumlah,
                      labels: labels
                  });
              }

              // Data Tabulasi 
              const dataSet = Object.entries(response.data_seluruh_kota);
              new DataTable('#tabelChart4', {
                  "columns": [
                      { title: 'Nama Kota' },
                      { title: 'Jumlah Korban' },
                  ],
                  "data": dataSet,
                  "dom": 'Blfrtip', // Blfrtip or Bfrtip
                  "ordering": true,
                  "responsive": false, 
                  "lengthChange": false, 
                  "pageLength": 5,
                  "autoWidth": false,
                  "order": [[1, 'desc']],
                  "lengthMenu": [
                    [5, 10, 25, 50, 100, -1],
                    ['10 rows', '25 rows', '50 rows', '100 rows','All'],
                  ],
                  buttons: ["pageLength", "copy", "csv", "excel"],
              }).buttons().container().appendTo('#tabelChart4_wrapper .col-md-6:eq(0)');

              $('#tabelChart4_filter').css({'float':'right','display':'inline-block; background-color:black'});
          },
          error: function(response) {
              setTimeout(function() {
                  $("#overlay4").fadeOut(300);
              }, 500);
              alert(response);
          }
      }).done(function() {
          setTimeout(function() {
              $("#overlay4").fadeOut(300);
          }, 500);
      });
  }

  var chart5; 
  function load_data5(klasifikasi) {
      $("#overlay5").show();
      if (klasifikasi != null) {
        wa = 1;
      } else {
        wa = 0;
      }

      if (wa == 0) {
      // jika null berarti bukan untuk update data wa
        if ($.fn.DataTable.isDataTable('#tabelChart5')) {
            $('#tabelChart5').DataTable().destroy();
        } 
      }

      pengelompokan = 'tahun';
      basisTanggal = $('#filterBasisTanggal5').val();
      tanggal = $('#filterTanggal5').val();
      basisWilayah = $('#filterBasisWilayah5').val();
      wilayah = $('#filterWilayah5').val();
      penghitunganUsia = $('#filterPenghitunganUsia5').val();
      kategoriKlien = $('#filterKategoriKlien5').val();
      regis = $('input[name="filterRegis5"]:checked').val();
      arsip = $('input[name="filterArsip5"]:checked').val();
      if (klasifikasi == null) {
        // jika tidak null berarti untuk update data wa
        klasifikasi = $('#filterKlasifikasi5').val();
      }

      titleChart5 = $('#titleChart5').html(klasifikasi);
      
      $.ajax({
          url: '{{ route("api.v1.jumlahkorbanklasifikasi") }}?pengelompokan=' + pengelompokan + '&basis_tanggal=' + basisTanggal + '&tanggal=' + tanggal + '&basis_wilayah=' + basisWilayah + '&wilayah=' + wilayah + '&penghitungan_usia=' + penghitunganUsia + '&kategori_klien=' + kategoriKlien + '&regis=' + regis + '&arsip=' + arsip + '&klasifikasi=' + klasifikasi,
          type: 'GET',
          dataType: 'json',
          success: function(response) {
              $('#filter5').html('');
              $.each(response.filter, function(key, value) {
                  $('#filter5').append("<span class=\"badge bg-primary\">" + key.replace(/_/g, ' ') + " : " + value.toString().replace(/_/g, ' ') + "</span> ");
              });
              $('#filter5').append("<span class=\"badge bg-warning\">Data ini disajikan pada : " + getCurrentDateTime() + "</span> ");
              var datas = response.data;
              var jumlah = Object.values(response.data);
              var labels = Object.keys(response.data);

              // update data whatsapp
              Object.entries(datas).forEach(([key, value]) => {
                  $('#wa_'+klasifikasi).append(`- ${key}: ${value}<br>`);
              });

              if (!chart5) {
                  // Create chart instance if it doesn't exist
                  var options = {
                      series: jumlah,
                      chart: {
                          toolbar: {
                              show: true
                          },
                          height: '100%',
                          type: 'pie'
                      },
                      tooltip: {
                          style: {
                              fontSize: '25px'
                          }
                      },
                      dataLabels: {
                          enabled: true,
                          style: {
                              fontSize: "30px",
                          }
                      },
                      legend: {
                          fontSize: "20px"
                      },
                      labels: labels,
                      colors: ['#080708', '#fc03be', '#fcba03', '#36a2eb', '#36eb6f', '#7e36eb', '#eb3636', '#eb8a36', '#ebe536', '#36e2eb', '#a936eb'],
                      responsive: [{
                          breakpoint: 500,
                          options: {
                              chart: {
                                height: '100%',
                              },
                              legend: {
                                  position: 'bottom'
                              }
                          }
                      }]
                  };

                  chart5 = new ApexCharts(document.querySelector("#chart5"), options);
                  chart5.render();
              } else {
                  // Update chart data if it exists
                  chart5.updateOptions({
                      series: jumlah,
                      labels: labels
                  });
              }

              if (wa == 0) {
                // Data Tabulasi 
                const dataSet = Object.entries(response.data_seluruh);
                new DataTable('#tabelChart5', {
                    "columns": [
                        { title: klasifikasi },
                        { title: 'Jumlah Korban' },
                    ],
                    "data": dataSet,
                    "dom": 'Blfrtip', // Blfrtip or Bfrtip
                    "ordering": true,
                    "responsive": false, 
                    "lengthChange": false, 
                    "pageLength": 10,
                    "autoWidth": false,
                    "order": [[1, 'desc']],
                    "lengthMenu": [
                      [5, 10, 25, 50, 100, -1],
                      ['10 rows', '25 rows', '50 rows', '100 rows','All'],
                    ],
                    buttons: ["pageLength", "copy", "csv", "excel"],
                }).buttons().container().appendTo('#tabelChart5_wrapper .col-md-6:eq(0)');

                $('#tabelChart5_filter').css({'float':'right','display':'inline-block; background-color:black'});
            }
          },
          error: function(response) {
              setTimeout(function() {
                  $("#overlay5").fadeOut(300);
              }, 500);
              alert(response);
          }
      }).done(function() {
          setTimeout(function() {
              $("#overlay5").fadeOut(300);
          }, 500);
      });
  }

  var chart6; 
  function load_data6() {
      $("#overlay6").show();
      if ($.fn.DataTable.isDataTable('#tabelChart6')) {
          $('#tabelChart6').DataTable().destroy();
      }

      pengelompokan = 'tahun';
      basisTanggal = $('#filterBasisTanggal6').val();
      tanggal = $('#filterTanggal6').val();
      basisWilayah = $('#filterBasisWilayah6').val();
      wilayah = $('#filterWilayah6').val();
      penghitunganUsia = $('#filterPenghitunganUsia6').val();
      kategoriKlien = $('#filterKategoriKlien6').val();
      regis = $('input[name="filterRegis6"]:checked').val();
      arsip = $('input[name="filterArsip6"]:checked').val();

      $.ajax({
          url: '{{ route("api.v1.jumlahkorbankategorilokasi") }}?pengelompokan=' + pengelompokan + '&basis_tanggal=' + basisTanggal + '&tanggal=' + tanggal + '&basis_wilayah=' + basisWilayah + '&wilayah=' + wilayah + '&penghitungan_usia=' + penghitunganUsia + '&kategori_klien=' + kategoriKlien + '&regis=' + regis + '&arsip=' + arsip,
          type: 'GET',
          dataType: 'json',
          success: function(response) {
              $('#filter6').html('');
              $.each(response.filter, function(key, value) {
                  $('#filter6').append("<span class=\"badge bg-primary\">" + key.replace(/_/g, ' ') + " : " + value.toString().replace(/_/g, ' ') + "</span> ");
              });
              $('#filter6').append("<span class=\"badge bg-warning\">Data ini disajikan pada : " + getCurrentDateTime() + "</span> ");
              var jumlah = Object.values(response.data);
              var labels = Object.keys(response.data);

              if (!chart6) {
                  // Create chart instance if it doesn't exist
                  var options = {
                      series: jumlah,
                      chart: {
                          toolbar: {
                              show: true
                          },
                          height: '100%',
                          type: 'pie'
                      },
                      tooltip: {
                          style: {
                              fontSize: '25px'
                          }
                      },
                      dataLabels: {
                          enabled: true,
                          style: {
                              fontSize: "30px",
                          }
                      },
                      legend: {
                          fontSize: "20px"
                      },
                      labels: labels,
                      colors: ['#080708', '#fc03be', '#fcba03', '#36a2eb', '#36eb6f', '#7e36eb', '#eb3636', '#eb8a36', '#ebe536', '#36e2eb', '#a936eb'],
                      responsive: [{
                          breakpoint: 500,
                          options: {
                              chart: {
                                height: '100%',
                              },
                              legend: {
                                  position: 'bottom'
                              }
                          }
                      }]
                  };

                  chart6 = new ApexCharts(document.querySelector("#chart6"), options);
                  chart6.render();
                  
              } else {
                  // Update chart data if it exists
                  chart6.updateOptions({
                      series: jumlah,
                      labels: labels
                  });
              }

              // Data Tabulasi 
              const dataSet = Object.entries(response.data_seluruh);
              new DataTable('#tabelChart6', {
                  "columns": [
                      { title: 'Kategori Lokasi TKP' },
                      { title: 'Jumlah Korban' },
                  ],
                  "data": dataSet,
                  "dom": 'Blfrtip', // Blfrtip or Bfrtip
                  "ordering": true,
                  "responsive": false, 
                  "lengthChange": false, 
                  "pageLength": 10,
                  "autoWidth": false,
                  "order": [[1, 'desc']],
                  "lengthMenu": [
                    [5, 10, 25, 50, 100, -1],
                    ['10 rows', '25 rows', '50 rows', '100 rows','All'],
                  ],
                  buttons: ["pageLength", "copy", "csv", "excel"],
              }).buttons().container().appendTo('#tabelChart6_wrapper .col-md-6:eq(0)');

              $('#tabelChart6_filter').css({'float':'right','display':'inline-block; background-color:black'});
              $("#overlay6").hide();
          },
          error: function(response) {
              setTimeout(function() {
                  $("#overlay6").fadeOut(300);
              }, 500);
              alert(response);
          }
      }).done(function() {
          setTimeout(function() {
              $("#overlay6").fadeOut(300);
          }, 500);
      });
  }


  var chart7; 
  function load_data7() {
      $("#overlay7").show();
      if ($.fn.DataTable.isDataTable('#tabelChart7')) {
          $('#tabelChart7').DataTable().destroy();
      }

      pengelompokan = 'tahun';
      basisTanggal = $('#filterBasisTanggal7').val();
      tanggal = $('#filterTanggal7').val();
      basisWilayah = $('#filterBasisWilayah7').val();
      wilayah = $('#filterWilayah7').val();
      penghitunganUsia = $('#filterPenghitunganUsia7').val();
      kategoriKlien = $('#filterKategoriKlien7').val();
      regis = $('input[name="filterRegis7"]:checked').val();
      arsip = $('input[name="filterArsip7"]:checked').val();
      basisIdentitas = $('#filterBasisIdentitas7').val();
      titleChart7 = $('#titleChart7').html(basisIdentitas);

      $.ajax({
          url: '{{ route("api.v1.jumlahkorbanidentitas") }}?pengelompokan=' + pengelompokan + '&basis_tanggal=' + basisTanggal + '&tanggal=' + tanggal + '&basis_wilayah=' + basisWilayah + '&wilayah=' + wilayah + '&penghitungan_usia=' + penghitunganUsia + '&kategori_klien=' + kategoriKlien + '&regis=' + regis + '&arsip=' + arsip + '&basis_identitas=' + basisIdentitas + '&identitas=usia',
          type: 'GET',
          dataType: 'json',
          success: function(response) {
              $('#filter7').html('');
              $.each(response.filter, function(key, value) {
                  $('#filter7').append("<span class=\"badge bg-primary\">" + key.replace(/_/g, ' ') + " : " + value.toString().replace(/_/g, ' ') + "</span> ");
              });
              $('#filter7').append("<span class=\"badge bg-warning\">Data ini disajikan pada : " + getCurrentDateTime() + "</span> ");
              var jumlah = Object.values(response.data);
              var labels = Object.keys(response.data);

              if (!chart7) {
                  // Create chart instance if it doesn't exist
                  var options = {
                      series: jumlah,
                      chart: {
                          toolbar: {
                              show: true
                          },
                          height: '100%',
                          type: 'pie'
                      },
                      tooltip: {
                          style: {
                              fontSize: '25px'
                          }
                      },
                      dataLabels: {
                          enabled: true,
                          style: {
                              fontSize: "30px",
                          }
                      },
                      legend: {
                          fontSize: "20px"
                      },
                      labels: labels,
                      colors: ['#080708', '#fc03be', '#fcba03', '#36a2eb', '#36eb6f', '#7e36eb', '#eb3636', '#eb8a36', '#ebe536', '#36e2eb', '#a936eb'],
                      responsive: [{
                          breakpoint: 500,
                          options: {
                              chart: {
                                height: '100%',
                              },
                              legend: {
                                  position: 'bottom'
                              }
                          }
                      }]
                  };

                  chart7 = new ApexCharts(document.querySelector("#chart7"), options);
                  chart7.render();
              } else {
                  // Update chart data if it exists
                  chart7.updateOptions({
                      series: jumlah,
                      labels: labels
                  });
              }

              // Data Tabulasi 
              const dataSet = Object.entries(response.data_seluruh);
              new DataTable('#tabelChart7', {
                  "columns": [
                      { title: 'Rentang Usia' },
                      { title: 'Jumlah '+basisIdentitas },
                  ],
                  "data": dataSet,
                  "dom": 'Blfrtip', // Blfrtip or Bfrtip
                  "ordering": true,
                  "responsive": false, 
                  "lengthChange": false, 
                  "pageLength": 10,
                  "autoWidth": false,
                  "order": [[0, 'asc']],
                  "lengthMenu": [
                    [5, 10, 25, 50, 100, -1],
                    ['10 rows', '25 rows', '50 rows', '100 rows','All'],
                  ],
                  buttons: ["pageLength", "copy", "csv", "excel"],
              }).buttons().container().appendTo('#tabelChart7_wrapper .col-md-6:eq(0)');

              $('#tabelChart7_filter').css({'float':'right','display':'inline-block; background-color:black'});
          },
          error: function(response) {
              setTimeout(function() {
                  $("#overlay7").fadeOut(300);
              }, 500);
              alert(response);
          }
      }).done(function() {
          setTimeout(function() {
              $("#overlay7").fadeOut(300);
          }, 500);
      });
  }

  var chart8; 
  function load_data8() {
      $("#overlay8").show();
      if ($.fn.DataTable.isDataTable('#tabelChart8')) {
          $('#tabelChart8').DataTable().destroy();
      }

      pengelompokan = 'tahun';
      basisTanggal = $('#filterBasisTanggal8').val();
      tanggal = $('#filterTanggal8').val();
      basisWilayah = $('#filterBasisWilayah8').val();
      wilayah = $('#filterWilayah8').val();
      penghitunganUsia = $('#filterPenghitunganUsia8').val();
      kategoriKlien = $('#filterKategoriKlien8').val();
      regis = $('input[name="filterRegis8"]:checked').val();
      arsip = $('input[name="filterArsip8"]:checked').val();
      basisIdentitas = $('#filterBasisIdentitas8').val();
      titleChart8 = $('#titleChart8').html(basisIdentitas);

      $.ajax({
          url: '{{ route("api.v1.jumlahkorbanidentitas") }}?pengelompokan=' + pengelompokan + '&basis_tanggal=' + basisTanggal + '&tanggal=' + tanggal + '&basis_wilayah=' + basisWilayah + '&wilayah=' + wilayah + '&penghitungan_usia=' + penghitunganUsia + '&kategori_klien=' + kategoriKlien + '&regis=' + regis + '&arsip=' + arsip + '&basis_identitas=' + basisIdentitas + '&identitas=pendidikan',
          type: 'GET',
          dataType: 'json',
          success: function(response) {
              $('#filter8').html('');
              $.each(response.filter, function(key, value) {
                  $('#filter8').append("<span class=\"badge bg-primary\">" + key.replace(/_/g, ' ') + " : " + value.toString().replace(/_/g, ' ') + "</span> ");
              });
              $('#filter8').append("<span class=\"badge bg-warning\">Data ini disajikan pada : " + getCurrentDateTime() + "</span> ");
              var jumlah = Object.values(response.data);
              var labels = Object.keys(response.data);

              if (!chart8) {
                  // Create chart instance if it doesn't exist
                  var options = {
                      series: jumlah,
                      chart: {
                          toolbar: {
                              show: true
                          },
                          height: '100%',
                          type: 'pie'
                      },
                      tooltip: {
                          style: {
                              fontSize: '25px'
                          }
                      },
                      dataLabels: {
                          enabled: true,
                          style: {
                              fontSize: "30px",
                          }
                      },
                      legend: {
                          fontSize: "20px"
                      },
                      labels: labels,
                      colors: ['#080708', '#fc03be', '#fcba03', '#36a2eb', '#36eb6f', '#7e36eb', '#eb3636', '#eb8a36', '#ebe536', '#36e2eb', '#a936eb'],
                      responsive: [{
                          breakpoint: 500,
                          options: {
                              chart: {
                                height: '100%',
                              },
                              legend: {
                                  position: 'bottom'
                              }
                          }
                      }]
                  };

                  chart8 = new ApexCharts(document.querySelector("#chart8"), options);
                  chart8.render();
              } else {
                  // Update chart data if it exists
                  chart8.updateOptions({
                      series: jumlah,
                      labels: labels
                  });
              }

              // Data Tabulasi 
              const dataSet = Object.entries(response.data_seluruh);
              new DataTable('#tabelChart8', {
                  "columns": [
                      { title: 'Pendidikan' },
                      { title: 'Jumlah '+basisIdentitas },
                  ],
                  "data": dataSet,
                  "dom": 'Blfrtip', // Blfrtip or Bfrtip
                  "ordering": true,
                  "responsive": false, 
                  "lengthChange": false, 
                  "pageLength": 10,
                  "autoWidth": false,
                  "order": [[1, 'desc']],
                  "lengthMenu": [
                    [5, 10, 25, 50, 100, -1],
                    ['10 rows', '25 rows', '50 rows', '100 rows','All'],
                  ],
                  buttons: ["pageLength", "copy", "csv", "excel"],
              }).buttons().container().appendTo('#tabelChart8_wrapper .col-md-6:eq(0)');

              $('#tabelChart8_filter').css({'float':'right','display':'inline-block; background-color:black'});
          },
          error: function(response) {
              setTimeout(function() {
                  $("#overlay8").fadeOut(300);
              }, 500);
              alert(response);
          }
      }).done(function() {
          setTimeout(function() {
              $("#overlay8").fadeOut(300);
          }, 500);
      });
  }

  var chart9; 
  function load_data9() {
      $("#overlay9").show();
      if ($.fn.DataTable.isDataTable('#tabelChart9')) {
          $('#tabelChart9').DataTable().destroy();
      }

      pengelompokan = 'tahun';
      basisTanggal = $('#filterBasisTanggal9').val();
      tanggal = $('#filterTanggal9').val();
      basisWilayah = $('#filterBasisWilayah9').val();
      wilayah = $('#filterWilayah9').val();
      penghitunganUsia = $('#filterPenghitunganUsia9').val();
      kategoriKlien = $('#filterKategoriKlien9').val();
      regis = $('input[name="filterRegis9"]:checked').val();
      arsip = $('input[name="filterArsip9"]:checked').val();
      basisIdentitas = $('#filterBasisIdentitas9').val();
      titleChart8 = $('#titleChart9').html(basisIdentitas);

      $.ajax({
          url: '{{ route("api.v1.jumlahkorbanidentitas") }}?pengelompokan=' + pengelompokan + '&basis_tanggal=' + basisTanggal + '&tanggal=' + tanggal + '&basis_wilayah=' + basisWilayah + '&wilayah=' + wilayah + '&penghitungan_usia=' + penghitunganUsia + '&kategori_klien=' + kategoriKlien + '&regis=' + regis + '&arsip=' + arsip + '&basis_identitas=' + basisIdentitas + '&identitas=pekerjaan',
          type: 'GET',
          dataType: 'json',
          success: function(response) {
              $('#filter9').html('');
              $.each(response.filter, function(key, value) {
                  $('#filter9').append("<span class=\"badge bg-primary\">" + key.replace(/_/g, ' ') + " : " + value.toString().replace(/_/g, ' ') + "</span> ");
              });
              $('#filter9').append("<span class=\"badge bg-warning\">Data ini disajikan pada : " + getCurrentDateTime() + "</span> ");
              var jumlah = Object.values(response.data);
              var labels = Object.keys(response.data);

              if (!chart9) {
                  // Create chart instance if it doesn't exist
                  var options = {
                      series: jumlah,
                      chart: {
                          toolbar: {
                              show: true
                          },
                          height: '100%',
                          type: 'pie'
                      },
                      tooltip: {
                          style: {
                              fontSize: '25px'
                          }
                      },
                      dataLabels: {
                          enabled: true,
                          style: {
                              fontSize: "30px",
                          }
                      },
                      legend: {
                          fontSize: "20px"
                      },
                      labels: labels,
                      colors: ['#080708', '#fc03be', '#fcba03', '#36a2eb', '#36eb6f', '#7e36eb', '#eb3636', '#eb8a36', '#ebe536', '#36e2eb', '#a936eb'],
                      responsive: [{
                          breakpoint: 500,
                          options: {
                              chart: {
                                height: '100%',
                              },
                              legend: {
                                  position: 'bottom'
                              }
                          }
                      }]
                  };

                  chart9 = new ApexCharts(document.querySelector("#chart9"), options);
                  chart9.render();
              } else {
                  // Update chart data if it exists
                  chart9.updateOptions({
                      series: jumlah,
                      labels: labels
                  });
              }

              // Data Tabulasi 
              const dataSet = Object.entries(response.data_seluruh);
              new DataTable('#tabelChart9', {
                  "columns": [
                      { title: 'Pendidikan' },
                      { title: 'Jumlah '+basisIdentitas },
                  ],
                  "data": dataSet,
                  "dom": 'Blfrtip', // Blfrtip or Bfrtip
                  "ordering": true,
                  "responsive": false, 
                  "lengthChange": false, 
                  "pageLength": 10,
                  "autoWidth": false,
                  "order": [[1, 'desc']],
                  "lengthMenu": [
                    [5, 10, 25, 50, 100, -1],
                    ['10 rows', '25 rows', '50 rows', '100 rows','All'],
                  ],
                  buttons: ["pageLength", "copy", "csv", "excel"],
              }).buttons().container().appendTo('#tabelChart9_wrapper .col-md-6:eq(0)');

              $('#tabelChart9_filter').css({'float':'right','display':'inline-block; background-color:black'});
          },
          error: function(response) {
              setTimeout(function() {
                  $("#overlay9").fadeOut(300);
              }, 500);
              alert(response);
          }
      }).done(function() {
          setTimeout(function() {
              $("#overlay9").fadeOut(300);
          }, 500);
      });
  }

  function load_data10() {
    $("#overlay10").show();
    if ($.fn.DataTable.isDataTable('#tabelChart10')) {
        $('#tabelChart10').DataTable().destroy();
    }

    // Retrieve filter values
    const pengelompokan = 'tahun';
    const basisTanggal = $('#filterBasisTanggal10').val();
    const tanggal = $('#filterTanggal10').val();
    const basisWilayah = $('#filterBasisWilayah10').val();
    const wilayah = $('#filterWilayah10').val();
    const penghitunganUsia = $('#filterPenghitunganUsia10').val();
    const kategoriKlien = $('#filterKategoriKlien10').val();
    const regis = $('input[name="filterRegis10"]:checked').val();
    const arsip = $('input[name="filterArsip10"]:checked').val();

    $.ajax({
        url: '{{ route("api.v1.jumlahlayanan") }}',
        type: 'GET',
        dataType: 'json',
        data: {
            pengelompokan: pengelompokan,
            basis_tanggal: basisTanggal,
            tanggal: tanggal,
            basis_wilayah: basisWilayah,
            wilayah: wilayah,
            penghitungan_usia: penghitunganUsia,
            kategori_klien: kategoriKlien,
            regis: regis,
            arsip: arsip
        },
        success: function(response) {
            // Clear previous filters
            $('#filter10').html('');
            $.each(response.filter, function(key, value) {
                $('#filter10').append("<span class=\"badge bg-primary\">" + key.replace(/_/g, ' ') + " : " + value.toString().replace(/_/g, ' ') + "</span> ");
            });
            $('#filter10').append("<span class=\"badge bg-warning\">Data ini disajikan pada : " + getCurrentDateTime() + "</span> ");

            // Initialize DataTable with the response data
            let dataTable = new DataTable('#tabelChart10', {
                data: response.data_seluruh, 
                columns: [
                    { "title": "Jabatan", "data": "jabatan" },
                    { "title": "Keyword / Detail Layanan", "data": "nama" },
                    { "title": "Jumlah", "data": "total" }
                ],
                dom: 'Blfrtip', // Blfrtip or Bfrtip
                ordering: true,
                // rowsGroup: [0],
                responsive: false, 
                lengthChange: false, 
                pageLength: 10,
                autoWidth: false,
                order: [[0, 'asc'], [2, 'desc']],
                lengthMenu: [
                    [5, 10, 25, 50, 100, -1],
                    ['10 rows', '25 rows', '50 rows', '100 rows', 'All'],
                ],
                buttons: ["pageLength", "copy", "csv", "excel"]
            });

            dataTable.buttons().container().appendTo('#tabelChart10_wrapper .col-md-6:eq(0)');
            $('#tabelChart10_filter').css({'float': 'right', 'display': 'inline-block; background-color:black'});
            $("#overlay10").hide();
        },
        error: function(response) {
            setTimeout(function() {
                $("#overlay10").fadeOut(300);
            }, 500);
            alert("Error: " + response.responseText);
        }
    }).done(function() {
        setTimeout(function() {
            $("#overlay10").fadeOut(300);
        }, 500);
    });
}

    function load_data11() {
        $("#overlay11").show();
        $("#overlay11").hide();

        // Retrieve filter values
        const params = {
                basisTanggal: $('#filterBasisTanggal11').val(),
                tanggal: $('#filterTanggal11').val(),
                basisWilayah: $('#filterBasisWilayah11').val(),
                wilayah: $('#filterWilayah11').val(),
                penghitunganUsia: $('#filterPenghitunganUsia11').val(),
                kategoriKlien: $('#filterKategoriKlien11').val(),
                regis: $('input[name="filterRegis11"]:checked').val(),
                arsip: $('input[name="filterArsip11"]:checked').val()
            };

            $('#filter11').html('');
            $.each(params, function(key, value) {
                $('#filter11').append("<span class=\"badge bg-primary\">" + key + ' : ' +value + "</span> ");
            });
            $('#filter11').append("<span class=\"badge bg-warning\">Data ini disajikan pada : " + getCurrentDateTime() + "</span> ");

            $('.filterTanggal11').html($('#filterTanggal11').val());
            // Update the href attributes for all links with class .export-link
            $('.export-link').each(function() {
                var href = $(this).attr('href');
                var newHref = updateUrlParameters(href, params);
                $(this).attr('href', newHref);
            });

    }

    function updateUrlParameters(url, newParams) {
        var [baseUrl, queryString] = url.split('?');
        var queryParams = new URLSearchParams(queryString);

        // Merge new parameters with existing ones
        for (const key in newParams) {
            queryParams.set(key, newParams[key]);
        }

        return baseUrl + '?' + queryParams.toString();
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
            // centang indikator pemanatauan & evaluasi
            if (response.pemantauan_terakhir > 0) {
                $('#check_pemantauan').show();
                kelengkapan_kasus = kelengkapan_kasus + 1;
                $('#kelengkapan_kasus').html(kelengkapan_kasus);
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