<style>
  .apexcharts-legend-series {
    margin-top: 15px !important;
  }
</style>
<div class="heading">
    DATA KORBAN YANG DITANGANI OLEH PPPA DKI JAKARTA
    <br>
    Tahun 2019 s/d <span class="today"></span>
</div>
<div class="content">
    <div id="chart2" style="display: block; width: 100%; height: 100%; padding: 0px 20px"></div>
</div>

<script>
function load_data2() {
    // // show load 
    $.ajax({
        url:'{{ route("api.v1.jumlahkorban") }}?pengelompokan=tahun&basis_tanggal=tanggal_approve&tanggal='+tahun+'-01-01%20-%20'+tanggal+'&basis_wilayah=default&wilayah=default&penghitungan_usia=lapor&regis=1&arsip=0',
        type:'GET',
        dataType: 'json',
        success: function (response){
            pengelompokan = 'tahun';
            datas = response.data;
            data_seluruh = datas.seluruh_klien;
            periode = response.periode;
            
            // Insert data tahun lalu (manual selama belum migrasi)
            data_seluruh = [1179, 947, 1313, 1455, 1682].concat(data_seluruh);
            tahun_seluruh = [2019, 2020, 2021, 2022, 2023].concat(periode);
        // setup chart
        var options = {
            series: [
            {
            name: "Total Seluruh Kasus",
            data: data_seluruh
            }
        ],
            chart: {
            height: 500,
            type: 'bar',
            fontSize:'300px'
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
                fontWeight: "bold"
              }
        },
        title: {
            text: 'Sumber : Database PPPA Prov. DKI Jakarta',
            align: 'left'
        },
        markers: {
            size: 1
        },
        xaxis: {
            categories: tahun_seluruh,
            labels: {
              style: {
                fontSize: "30px",
                fontWeight: "bold"
              }
            },
            title: {
            text: pengelompokan.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                        return letter.toUpperCase();
                    }),
              style: {
                fontSize: "30px",
                fontWeight: "bold"
              }
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
</script>