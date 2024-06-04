<div class="heading">
  DATA JUMLAH KORBAN KEKERASAN TERHADAP  PEREMPUAN DAN ANAK  BERDASARKAN KOTA/ KABUPATEN PENUGASAN KASATPEL 
    <br>
    TAHUN 2024 (Januari s/d Maret)
</div>
<div class="content">
  <div class="row">
    <div class="col-md-5">
      <table id="tabelChart4d" class="table table-sm table-bordered table-hover" style="cursor:pointer; width:100%"></table>  
    </div>
    <div class="col-md-7">
      <div id="chart4d" style="display: block; width: 100%; height: 100%; padding: 0px 20px"></div>
    </div>
  </div>
</div>
<script>
  var chart4d; 
  function load_data4d() {
      if ($.fn.DataTable.isDataTable('#tabelChart4d')) {
          $('#tabelChart4d').DataTable().destroy();
      }

      pengelompokan = 'tahun';
      basisTanggal = 'tanggal_approve';
      tanggal = '2024-01-01 - 2024-05-07';
      basisWilayah = 'satpel';
      regis = 1;
      arsip = 0;

      $.ajax({
          url: '{{ route("api.v1.jumlahkorbanwilayah") }}?pengelompokan=' + pengelompokan + '&basis_tanggal=' + basisTanggal + '&tanggal=' + tanggal + '&basis_wilayah=' + basisWilayah + '&regis=' + regis + '&arsip=' + arsip + '&rekaptotal=1',
          type: 'GET',
          dataType: 'json',
          success: function(response) {
              var jumlah = Object.values(response.data);
              var labels = Object.keys(response.data);

              if (!chart4d) {
                  // Create chart instance if it doesn't exist
                  var options = {
                      series: jumlah,
                      chart: {
                          toolbar: {
                              show: true
                          },
                          width: '100%',
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
                      colors: ['#080708', '#fc03be', '#fcba03', '#36a2eb', '#36eb6f', '#7e36eb', '#eb3636'],
                      responsive: [{
                          breakpoint: 500,
                          options: {
                              chart: {
                                  width: 600
                              },
                              legend: {
                                  position: 'bottom'
                              }
                          }
                      }]
                  };

                  chart4d = new ApexCharts(document.querySelector("#chart4d"), options);
                  chart4d.render();
              } else {
                  // Update chart data if it exists
                  chart4d.updateOptions({
                      series: jumlah,
                      labels: labels
                  });
              }

              // Data Tabulasi 
              const dataSet = Object.entries(response.data_seluruh_kota);
              new DataTable('#tabelChart4d', {
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

              $('#tabelChart4d_filter').css({'float':'right','display':'inline-block; background-color:black'});
          },
          error: function(response) {
              setTimeout(function() {
              }, 500);
              alert(response);
          }
      }).done(function(response) {
          setTimeout(function() {
          }, 500);
      });
  }
</script>