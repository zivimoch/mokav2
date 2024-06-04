<style>
  .apexcharts-legend-series {
    margin-top: 15px !important;
  }
</style>
<div class="heading">
    DATA KORBAN YANG DITANGANI OLEH PPPA DKI JAKARTA
    <br>
    Tahun 2019 – 2024 (Januari s/d Maret)
</div>
<div class="content">
    <div id="chart2" style="display: block; width: 100%; height: 100%; padding: 0px 20px"></div>
</div>

<script>


function load_data2() {
        // show load 
        $.ajax({
            url:'{{ route("api.v1.jumlahkorban") }}?pengelompokan=tahun&basis_tanggal=tanggal_approve&tanggal=2024-01-01%20-%202024-05-04&basis_wilayah=default&wilayah=default&penghitungan_usia=lapor&regis=1&arsip=0',
            type:'GET',
            dataType: 'json',
            success: function (response){
                pengelompokan = 'bulan';
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
                height: 500,
                type: 'line',
                fontSize:'300px'
            },
            tooltip: {
                style: {
                fontSize: '25px'
                }
            },
            colors: ['#545454', '#fc03be', '#fcba03', '#36a2eb'],
            dataLabels: {
                enabled: true
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
</script>