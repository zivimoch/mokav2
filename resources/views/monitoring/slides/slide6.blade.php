<div class="heading">
    DATA JUMLAH KORBAN KEKERASAN TERHADAP PEREMPUAN DAN ANAK YANG DITANGANI OLEH PPPA BERDASARKAN KATEGORI KASUS
    <br>
    TAHUN 2024 (Januari s/d Maret)
</div>
<div class="content">
  <div class="row">
    <div class="col-md-5">
      <table id="tabelChart6" class="table table-sm table-bordered table-hover" style="cursor:pointer; width:100%"></table>  
    </div>
    <div class="col-md-7">
      <div id="chart6" style="display: block; width: 100%; height: 100%; padding: 0px 20px"></div>
    </div>
  </div>
</div>
<script>
    
  var chart6; 
  function load_data6() {
      $("#overlay5").show();
      if ($.fn.DataTable.isDataTable('#tabelChart6')) {
          $('#tabelChart6').DataTable().destroy();
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
      klasifikasi = 'kategori_kasus';

      titleChart6 = $('#titleChart6').html(klasifikasi);
      
      $.ajax({
          url: '{{ route("api.v1.jumlahkorbanklasifikasi") }}?pengelompokan=' + pengelompokan + '&basis_tanggal=' + basisTanggal + '&tanggal=' + tanggal + '&basis_wilayah=' + basisWilayah + '&wilayah=' + wilayah + '&penghitungan_usia=' + penghitunganUsia + '&kategori_klien=' + kategoriKlien + '&regis=' + regis + '&arsip=' + arsip + '&klasifikasi=' + klasifikasi,
          type: 'GET',
          dataType: 'json',
          success: function(response) {
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
              }).buttons().container().appendTo('#tabelChart6_wrapper .col-md-6:eq(0)');

              $('#tabelChart6_filter').css({'float':'right','display':'inline-block; background-color:black'});
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