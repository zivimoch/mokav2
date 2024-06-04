<div class="heading">
    DATA JUMLAH KORBAN KEKERASAN TERHADAP PEREMPUAN DAN ANAK YANG DITANGANI OLEH PPPA BERDASARKAN KATEGORI KLIEN
    <br>
    TAHUN 2019 – 2024 (JANUARI s/d Maret)
</div>
<div class="content">
  <table border="1">
    <tr>
      <td>No</td>
      <td>Kategori Klien</td>
      <td>Jumlah</td>
    </tr>
    <tr>
      <td>1</td>
      <td>Perempuan Dewasa</td>
      <td>230</td>
    </tr>
    <tr>
      <td>2</td>
      <td>Anak Perempuan</td>
      <td>230</td>
    </tr>
    <tr>
      <td>3</td>
      <td>Anak Laki-laki</td>
      <td>230</td>
    </tr>
  </table>
  <div id="chart3" style="display: block; width: 100%; height: 100%; padding: 0px 20px"></div>
</div>
<script>
function load_data3() {
    // filter 
    pengelompokan = 'tahun';
    basisTanggal = 'tanggal_approve';
    tanggal = '2024-01-01 - 2024-05-07';
    basisWilayah = 'default';
    wilayah = 'default';
    penghitunganUsia = 'lapor';
    regis = 1;
    arsip = 0;

    $.ajax({
      url:'{{ route("api.v1.jumlahkorban") }}?pengelompokan='+pengelompokan+'&basis_tanggal='+basisTanggal+'&tanggal='+tanggal+'&basis_wilayah='+basisWilayah+'&wilayah='+wilayah+'&penghitungan_usia='+penghitunganUsia+'&regis='+regis+'&arsip='+arsip+'&rekaptotal=1',
      type:'GET',
      dataType: 'json',
      success: function (response){
        datas = response.data;
        
        // setup chart
        var options = {
          series: [datas.dewasa_perempuan, datas.anak_perempuan, datas.anak_laki],
          chart: {
            toolbar: {
            show: true
            },
            width: '100%',
            height: '500px',
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
          fontSize: "25px"
        },
        labels: ['Perempuan Dewasa', 'Anak Perempuan', 'Anak Laki-laki'],
        colors: ['#fc03be', '#fcba03', '#36a2eb'],
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
</script>