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
                                      <option value="tanggal_pelaporan" selected>Default ( Berdasarkan Tanggal Pelaporan )</option>
                                      <option value="tanggal_kejadian">Berdasarkan Tanggal Kejadian</option>
                                      <option value="created_at">Berdasarkan Tanggal Input</option>
                                    </select>
                                  </div>
                                  <input type="text" class="form-control daterank" id="filter1Tanggal" value="2023-01-01 - {{ date("Y").'/'.date("m").'/'.date("d") }}">
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
            {{-- pie chart persentase perbandingan perempuan dewasa dan anak --}}
            {{-- <div class="col-md-6">
              <!-- AREA CHART -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Profile PPPA DKI JAKARTA (Data Realtime)</h3>
  
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <div class="chart">
                    <div class="embed-container" style="position: relative; padding-bottom: 59.27%; height: 0; overflow: hidden; max-width: 100%;">
                    <iframe style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"
                      src="https://docs.google.com/presentation/d/e/2PACX-1vRQMNkACECTuOuQH55TJ_WZXbGibpMqutXNOCq5HNs6rHw9fLvhlYC-cENvLqUIHw/embed?start=true&loop=true&delayms=60000" frameborder="0" width="960" height="569" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div> --}}
          </div>
      </div>
      {{-- - performa Petugas <br>
      - rata2 tanggal pelayanan <br>
      - bar chart jumlah kasus perempuan dan anak per bulan <br>
      - profile P2 terupdate <br>
      - pie chart jenis kekerasan <br>
      - pie chart bentuk kekerasan <br>
      - kekerasan berdasarkan wilayah pembagian penanganan (satpel) <br>
      - kekerasan berdasarkan wilayah KTP <br>
      - kekerasan berdasarkan wilayah TKP <br>
      - pie chart usia klien <br>
      - pie chart pendidikan klien <br>
      - pie chart pekerjaan klien <br>
      - pie chart usia terlapor <br>
      - pie chart pendidikan terlapor <br>
      - pie chart pekerjaan terlapor <br>
      - pie layanan advokat <br>
      - pie layanan pararegal <br>
      - pie layanan psikolog <br>
      - pie layanan konselor <br>
      - pie layanan pk <br>
      - pie layanan mk <br>
      - pie layanan urc <br>
      - kinerja <br>
      - sarmut <br> --}}
  </section>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> 

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
    $.ajax({
      url:'{{ route("api.v1.jumlahkorban") }}?pengelompokan='+pengelompokan+'&basis_tanggal='+basisTanggal+'&tanggal='+tanggal+'&basis_wilayah='+basisWilayah+'&wilayah='+wilayah+'&penghitungan_usia='+penghitunganUsia,
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
  }
</script>
@endsection