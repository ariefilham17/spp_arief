<?= $this->extend('index'); ?>

<?= $this->section('content'); ?>
<div class="row layout-top-spacing">
    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
        <div class="widget widget-card-four">
            <div class="widget-content">
                <div class="w-header">
                    <div class="w-info">
                        <h6 class="value">Pemasukan</h6>
                    </div>
                </div>

                <div class="w-content">

                    <div class="w-info">
                        <p class="value masuk"></p>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
        <div class="widget widget-card-four">
            <div class="widget-content">
                <div class="w-header">
                    <div class="w-info">
                        <h6 class="value">Pengeluaran</h6>
                    </div>
                </div>

                <div class="w-content">

                    <div class="w-info">
                        <p class="value keluar"></p>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
        <div class="widget widget-card-five">
            <div class="widget-content">
                <div class="account-box">

                    <div class="info-box">
                        <div class="icon">
                            <span>
                                <img src="/src/assets/img/money-bag.png" alt="money-bag">
                            </span>
                        </div>

                        <div class="balance-info">
                            <h6>Total Saldo</h6>
                            <p class="saldo"></p>
                        </div>
                    </div>

                    <div class="card-bottom-section" style="margin-top: 50px;">
                        <div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-9 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
        <div class="widget widget-chart-three">
            <div class="widget-heading">
                <div class="">
                    <h5 class="">Grafik Keuangan Sekolah</h5>
                </div>

                <div class="task-action">
                    <div class="dropdown ">
                        <a class="dropdown-toggle" href="#" role="button" id="uniqueVisitors" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal">
                                <circle cx="12" cy="12" r="1"></circle>
                                <circle cx="19" cy="12" r="1"></circle>
                                <circle cx="5" cy="12" r="1"></circle>
                            </svg>
                        </a>

                        <div class="dropdown-menu left" aria-labelledby="uniqueVisitors" id="changeuniqueVisitor"></div>
                    </div>
                </div>
            </div>

            <div class="widget-content">
                <div id="uniqueVisits"></div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
        <div class="widget-four">
            <div class="widget-heading">
                <h5 class="">Siswa by Kategori</h5>
            </div>
            <div class="widget-content">
                <div class="vistorsBrowser"></div>
            </div>
        </div>
    </div>

</div>

<?= $this->section('style'); ?>
<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
<link href="/src/plugins/src/apex/apexcharts.css" rel="stylesheet" type="text/css">
<link href="/src/assets/css/light/dashboard/dash_1.css" rel="stylesheet" type="text/css" />
<link href="/src/assets/css/dark/dashboard/dash_1.css" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->
<?= $this->endSection(); ?>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script src="/src/plugins/src/apex/apexcharts.min.js"></script>

<script>
    var d_1options1 = {
        chart: {
            height: 350,
            type: 'bar',
            toolbar: {
                show: false,
            }
        },
        colors: ['#622bd7', '#ffbb44'],
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
                endingShape: 'rounded',
                borderRadius: 10,

            },
        },
        dataLabels: {
            enabled: false
        },
        legend: {
            position: 'bottom',
            horizontalAlign: 'center',
            fontSize: '14px',
            markers: {
                width: 10,
                height: 10,
                offsetX: -5,
                offsetY: 0
            },
            itemMargin: {
                horizontal: 10,
                vertical: 8
            }
        },
        grid: {
            borderColor: '#e0e6ed',
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        series: [{
            name: 'Pemasukan',
            data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
        }, {
            name: 'Pengeluaran',
            data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
        }],
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        },
        fill: {
            type: 'gradient',
            gradient: {
                shade: "dark",
                type: 'vertical',
                shadeIntensity: 0.3,
                inverseColors: false,
                opacityFrom: 1,
                opacityTo: 0.8,
                stops: [0, 100]
            }
        },
        tooltip: {
            marker: {
                show: false,
            },
            theme: "dark",
            y: {
                formatter: function(val) {
                    return val
                }
            }
        },
        responsive: [{
            breakpoint: 767,
            options: {
                plotOptions: {
                    bar: {
                        borderRadius: 0,
                        columnWidth: "50%"
                    }
                }
            }
        }, ]
    }

    var d_1options3 = {
        chart: {
            id: 'sparkline1',
            type: 'area',
            height: 160,
            sparkline: {
                enabled: true
            },
        },
        stroke: {
            curve: 'smooth',
            width: 2,
        },
        series: [{
            name: 'Sales',
            data: [38, 60, 38, 52, 36, 40, 28]
        }],
        labels: ['1', '2', '3', '4', '5', '6', '7'],
        yaxis: {
            min: 0
        },
        colors: ['#4361ee'],
        tooltip: {
            x: {
                show: false,
            }
        },
        grid: {
            show: false,
            xaxis: {
                lines: {
                    show: false
                }
            },
            padding: {
                top: 5,
                right: 0,
                left: 0
            },
        },
        fill: {
            type: "gradient",
            gradient: {
                type: "vertical",
                shadeIntensity: 1,
                inverseColors: !1,
                opacityFrom: .40,
                opacityTo: .05,
                stops: [100, 100]
            }
        }
    }

    var d_1C_3 = new ApexCharts(
        document.querySelector("#uniqueVisits"),
        d_1options1
    );
    d_1C_3.render();

    const getData = () => {
        $.get(`${base_url}/api/dashboard`).then((res) => {
            let siswa = res?.data?.siswa?.map((e) => {
                return `<div class="browser-list">
                        <div class="w-icon" style="background: ${e?.background || ""}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-globe">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="2" y1="12" x2="22" y2="12"></line>
                                <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                            </svg>
                        </div>
                        <div class="w-browser-details">
                            <div class="w-browser-info">
                                <h6>${e?.nama}</h6>
                                <p class="browser-count">${e?.persen}%</p>
                            </div>
                            <div class="w-browser-stats">
                                <div class="progress">
                                    <div class="progress-bar ${e?.progress}" role="progressbar" style="width: ${e?.persen}%" aria-valuenow="${e?.persen}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>`
            }).join('');

            $('.vistorsBrowser').html(siswa);

            $('.value.keluar').html(res?.data?.keuangan?.pengeluaran + ' <span>bulan ini</span>');
            $('.value.masuk').html(res?.data?.keuangan?.pemasukan + ' <span>bulan ini</span>');
            $('.saldo').html(res?.data?.keuangan?.saldo);

            d_1C_3.updateOptions({
                series: res?.data?.chartData
            });

            let tahun = res?.data?.list_tahun?.map((e) => {
                return `<a class="dropdown-item" href="javascript:void(0);" onclick="loadChartData('${e}')">${e}</a>`;
            }).join('');

            $('#changeuniqueVisitor').html(tahun);
        })
    }

    const loadChartData = (tahun) => {
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: base_url + 'api/dashboard',
            data: {
                tahun
            },
            success: function(res) {
                if (res?.data?.chartData) {
                    d_1C_3.updateOptions({
                        series: res?.data?.chartData
                    });
                }
            },
            error: function(err) {
                console.log(err);
            }
        })
    }

    $(document).ready(function() {
        getData();
    });
</script>

<?= $this->endSection(); ?>