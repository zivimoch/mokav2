@extends('layouts.template')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><i class="nav-icon fas fa-tv"></i> Monitoring</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
              <div class="col-md-6">
                
                <div class="card card-primary direct-chat direct-chat-primary">
                  <div class="card-header">
                  <h3 class="card-title">Grafik Klien</h3>
                  <div class="card-tools">
                  <button type="button" class="btn btn-tool" title="Contacts" data-widget="chat-pane-toggle">
                  <i class="fas fa-calendar"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                  </button>
                  </div>
                  </div>
                  
                  <div class="card-body" style="display: block;">
                  
                  <canvas id="myChart" height="223" class="chartjs-render-monitor" style="display: block; width: 447px; height: 223px;" width="447"></canvas>
                  
                  <div class="direct-chat-contacts" style="padding: 10px">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="">Periode</label>
                          <input type="text" class="form-control">
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  </div>
                  
                  </div>
                <!-- /.card -->
              </div>
              <div class="col-md-6">
                <!-- AREA CHART -->
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Profile P2TP2A DKI JAKARTA</h3>
    
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
              </div>
            </div>
        </div>
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
        - sarmut <br>
    </section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
//line chart
const labels = 'lorem';
  
const data = {
      labels: labels,
      datasets: [{
        label: 'Total kasus perempuan',
        backgroundColor: 'rgba(255, 99, 132)',
        borderColor: 'rgba(255, 99, 132)',
        data:  [53,42,99,77,39,73,57,55,57,63,52,41],
      }, {
        label: 'Total kasus anak perempuan',
        backgroundColor: 'rgb(255, 200, 99)',
        borderColor: 'rgb(255, 200, 99)',
        data:  [45,34,52,41,35,45,46,46,57,56,39,51],
      }, {
        label: 'Total kasus anak laki-laki',
        backgroundColor: 'rgb(99, 133, 255)',
        borderColor: 'rgb(99, 133, 255)',
        data:  [10,8,10,18,19,17,11,14,13,23,9,15],
      }
    ]
    };

  const config = {
    type: 'line',
    data: data,
    options: {}
  };

  const myChart = new Chart(
      document.getElementById('myChart'),
      config
  );
</script>
@endsection