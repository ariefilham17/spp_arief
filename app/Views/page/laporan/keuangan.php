<?= $this->extend('index'); ?>

<?= $this->section('content'); ?>
<div class="middle-content container-xxl p-0">
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Laporan</li>
                <li class="breadcrumb-item active" aria-current="page">Keuangan</li>
            </ol>
        </nav>
    </div>

    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
            <div class="widget-content widget-content-area br-8">
                <div class="row mb-3">
                    <div class="col-xl-2 col-lg-2 col-sm-12">
                        <input type="text" class="form-control w-100" id="ds" placeholder="Pilih Tanggal Mulai">
                    </div>
                    <div class="col-xl-2 col-lg-2 col-sm-12 text-end">
                        <button onclick="getDataKeuangan()" class="btn btn-primary w-100 _effect--ripple waves-effect waves-light">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-filter">
                                <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                            </svg>
                            <span class="btn-text-inner">Filter</span>
                        </button>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-sm-12 text-end">
                        <button onclick="printDataKeuangan()" class="btn btn-primary w-100 _effect--ripple waves-effect waves-light">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-printer">
                                <polyline points="6 9 6 2 18 2 18 9"></polyline>
                                <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                                <rect x="6" y="14" width="12" height="8"></rect>
                            </svg>
                            <span class="btn-text-inner">Ekspor</span>
                        </button>
                    </div>
                </div>
                <table id="zero-config" class="table dt-table-hover" style="width:100%; display: none;">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">Tipe</th>
                            <th class="text-center">Deskripsi</th>
                            <th class="text-center">Pemasukan</th>
                            <th class="text-center">Pengeluaran</th>
                            <th class="text-center">Saldo</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot></tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>


<?= $this->section('script'); ?>
<script src="/src/plugins/src/flatpickr/flatpickr.js?v=1.0.0"></script>
<script src="/src/plugins/src/flatpickr/month-select.js"></script>
<script>
    $('#ds').flatpickr({
        static: true,
        altInput: true,
        altFormat: 'm-Y',
        dateFormat: 'Y-m-d',
        plugins: [
            new monthSelectPlugin({
                shorthand: true, //defaults to false
                dateFormat: "Y-m", //defaults to "F Y"
                altFormat: "m-Y", //defaults to "F Y"
            })
        ]
    });

    const getDataKeuangan = () => {
        let ds = $('#ds').val();

        if (ds) {
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: base_url + '/api/laporan/keuangan',
                data: {
                    ds
                },
                success: function(res) {
                    let saldo = kredit = debit = 0;

                    const html = res?.map((e, i) => {
                        e.kredit ? saldo += parseInt(e?.kredit) : saldo -= e.debit;
                        kredit += parseInt(e?.kredit ? e?.kredit : 0);
                        debit += parseInt(e?.debit ? e?.debit : 0);

                        return `<tr>
                            <td class="text-center">${i + 1}</td>
                            <td class="text-center">${e?.tanggal}</td>
                            <td class="text-center">${e?.tipe}</td>
                            <td>${e?.keterangan}</td>
                            <td class="text-end">${e?.kredit ? parseInt(e?.kredit).toLocaleString('en-US') : ''}</td>
                            <td class="text-end">${e?.debit ? parseInt(e?.debit).toLocaleString('en-US') : ''}</td>
                            <td class="text-end">${saldo ? parseInt(saldo).toLocaleString('en-US') : ''}</td>
                        </tr>`
                    }).join('');

                    $('#zero-config tbody').html(html || '<tr><td colspan="7" class="text-center">Belum ada data</tr></td>');
                    $('#zero-config tfoot').empty();

                    if (res?.length > 0) {
                        $('#zero-config tfoot').html(`<tr>
                            <th colspan="4" class="text-end">Total</th>
                            <th class="text-end">${parseInt(kredit).toLocaleString('en-US')}</th>
                            <th class="text-end">${parseInt(debit).toLocaleString('en-US')}</th>
                            <th class="text-end">${parseInt(saldo).toLocaleString('en-US')}</th>
                        </tr>`);
                    }
                    $('#zero-config').show();
                },
                error: function(err) {
                    console.log(err);
                }
            })
        }
    }

    const printDataKeuangan = () => {
        let ds = $('#ds').val();
        if (ds) {
            window.open(base_url + 'laporan/print/keuangan?ds=' + ds);
        }
    }
</script>
<?= $this->endSection(); ?>


<?= $this->section('style'); ?>
<link href="/src/plugins/src/flatpickr/flatpickr.css" rel="stylesheet" type="text/css">
<link href="/src/plugins/src/noUiSlider/nouislider.min.css" rel="stylesheet" type="text/css">

<link href="/src/assets/css/light/scrollspyNav.css" rel="stylesheet" type="text/css" />
<link href="/src/plugins/css/light/flatpickr/custom-flatpickr.css" rel="stylesheet" type="text/css">

<link href="/src/assets/css/dark/scrollspyNav.css" rel="stylesheet" type="text/css" />
<link href="/src/plugins/css/dark/flatpickr/custom-flatpickr.css" rel="stylesheet" type="text/css">
<link href="/src/plugins/src/flatpickr/month-picker.css" rel="stylesheet" type="text/css">

<style>
    .form-control:disabled:not(.flatpickr-input),
    .form-control[readonly]:not(.flatpickr-input) {
        background-color: #fff;
        color: #3b3f5c;
    }

    .edit {
        width: 15px;
        height: 15px;
        stroke: #4361ee;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
        fill: none;
    }

    .delete {
        width: 15px;
        height: 15px;
        stroke: #4361ee;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
        fill: none;
    }

    .flatpickr-wrapper {
        display: block;
    }
</style>
<?= $this->endSection(); ?>