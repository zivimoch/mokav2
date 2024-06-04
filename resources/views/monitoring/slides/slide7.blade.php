<div class="heading">
    DATA JUMLAH KORBAN KEKERASAN TERHADAP  PEREMPUAN DAN ANAK BERDASARKAN KATEGORI LOKASI TKP
    <br>
    TAHUN 2024 (Januari s/d Maret)
</div>
<div class="content">
  <div class="row">
    <div class="col-md-5">
      <table id="tabelChart7" class="table table-sm table-bordered table-hover" style="cursor:pointer; width:100%"></table>  
    </div>
    <div class="col-md-7">
      <div id="chart7" style="display: block; width: 100%; height: 100%; padding: 0px 20px"></div>
    </div>
  </div>
</div>
<script>
    
  var chart7; 
  function load_data7() {
      if ($.fn.DataTable.isDataTable('#tabelChart7')) {
          $('#tabelChart7').DataTable().destroy();
      }

      pengelompokan = 'tahun';
      basisTanggal = 'tanggal_approve';
      tanggal = '2024-01-01 - 2024-05-07';
      basisWilayah = 'tkp';
      wilayah = 'default';
      penghitunganUsia = 'lapor';
      kategoriKlien = 'total';
      regis = 1;
      arsip = 0;

      $.ajax({
        url: '{{ route("api.v1.jumlahkorbankategorilokasi") }}?pengelompokan=' + pengelompokan + '&basis_tanggal=' + basisTanggal + '&tanggal=' + tanggal + '&basis_wilayah=' + basisWilayah + '&wilayah=' + wilayah + '&penghitungan_usia=' + penghitunganUsia + '&kategori_klien=' + kategoriKlien + '&regis=' + regis + '&arsip=' + arsip,
          type: 'GET',
          dataType: 'json',
          success: function(response) {
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
                      colors: ['#080708', '#fc03be', '#fcba03', '#36a2eb', '#36eb6f', '#7e36eb', '#eb3636', '#eb8a36', '#ebe536', '#36e2eb', '#a936eb'],
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
              }).buttons().container().appendTo('#tabelChart7_wrapper .col-md-6:eq(0)');

              $('#tabelChart7_filter').css({'float':'right','display':'inline-block; background-color:black'});
          },
          error: function(response) {
              setTimeout(function() {
              }, 500);
              alert(response);
          }
      }).done(function() {
          setTimeout(function() {
          }, 500);
      });
  }
</script>