<?= $this->extend('index'); ?>

<?= $this->section('content'); ?>
<?php
$start  = strtotime(date('Y', strtotime('-1 year')) . '-01-01');
$end    = strtotime('2035-01-01');
$pos    = $start;
$year  = [];
while ($pos <= $end) {
    $tStart     = date('Y', $pos);
    $pos        = strtotime('+1year', $pos);
    $tEnd       = date('Y', $pos);
    $year[]    = [$tStart, $tEnd];
}
?>

<div class="middle-content container-xxl p-0">
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Pembayaran</a></li>
                <li class="breadcrumb-item active"><a href="#">Bulanan</a></li>
            </ol>
        </nav>
    </div>

    <div class="row layout-spacing layout-top-spacing">
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="widget-content widget-content-area ecommerce-create-section">
                <div class="row">
                    <div class="col-6">
                        <div class="mb-2">
                            <label>Siswa</label>
                            <select name="" id="select-siswa" placeholder="Pilih Siswa" class="form-control" autocomplete="off" value="">
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Tahun Ajaran</label>
                            <select name="" id="select-tahun" class="form-control">
                                <option value="">Pilih Tahun Ajaran</option>
                                <?php foreach ($year as $key => $value) { ?>
                                    <option value="<?= $value[0] . '-' . $value[1] ?>"><?= $value[0] . ' - ' . $value[1]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success w-100 _effect--ripple waves-effect waves-light" onclick="getDataTagihan()">Cari Tagihan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="listTagihan"></div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script src="/src/plugins/src/tomSelect/tom-select.base.js"></script>

<script>
    let siswa = new TomSelect("#select-siswa", {
        valueField: 'id',
        labelField: 'title',
        searchField: 'title',
        load: function(query, callback) {
            var url = `${base_url}api/pembayaran/siswa?q=` + encodeURIComponent(query);
            fetch(url)
                .then(response => response.json())
                .then(json => {
                    callback(json.items);
                }).catch(() => {
                    callback();
                });
        },
        render: {
            option: function(item, escape) {
                return `<div>${ escape(item.title) }</div>`;
            },
            item: function(item, escape) {
                return `<div>${ escape(item.title) }</div>`;
            }
        },
        onChange: (value) => {
            $('#listTagihan').empty();
        }
    });

    let tahun = new TomSelect("#select-tahun", {
        sortField: {
            field: "text",
            direction: "asc"
        },
        onChange: (value) => {
            $('#listTagihan').empty();
        }
    });

    const getDataTagihan = () => {
        let siswa_id = $('#select-siswa').val();
        let tahun = $('#select-tahun').val();

        if (!siswa_id || !tahun) {
            Swal.fire({
                icon: 'warning',
                title: 'Gagal',
                text: "Lengkapi data filter terlebih dahulu",
                timer: 1000,
                showConfirmButton: false
            });
            return;
        }

        $.ajax({
            type: "POST",
            url: base_url + 'api/pembayaran/tagihan',
            data: {
                siswa_id,
                tahun,
            },
            success: function(res) {
                $('#listTagihan').html(res);
            },
            error: function(err) {
                console.log(err);
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: err?.responseJSON || 'Gagal mengambil data!',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        })
        return;

    }

    $(document).on('click', '.unpaid', () => {
        let total = 0;

        $('.unpaid:checked').each((i, el) => {
            let value = parseInt($(el).val());
            total += value;
        });

        $('.total').html(total.toLocaleString('en-US'));

        console.log(total);
    });

    const prosesData = () => {
        let siswa = $('#select-siswa').val();
        let checked = $('.unpaid:checked').length;
        if (checked < 1) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Item tagihan tidak ada',
                timer: 2000,
                showConfirmButton: false
            });
            return;
        }

        let data = $('#biaya').serializeArray();
        data.push({
            name: 'siswa',
            value: siswa
        });

        Swal.fire({
            title: 'Do you want to save the changes?',
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonText: 'Save',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: base_url + 'api/pembayaran/bayar_bulanan',
                    data: data,
                    success: function(res) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: res?.messages?.success || 'Berhasil membayar tagihan',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        if (res?.data?.id) {
                            window.open(`${base_url}/pembayaran/nota/${res?.data?.id}`);
                        }
                        setTimeout(() => {
                            window.location.reload();
                        }, 2100);
                    },
                    error: function(err) {
                        console.log(err);
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: err.responseJSON.messages?.error || 'Kesalahan pada server',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                })

            }
        })
    }
</script>

<?= $this->endSection(); ?>

<?= $this->section('style'); ?>
<link rel="stylesheet" type="text/css" href="/src/plugins/src/tomSelect/tom-select.default.min.css">
<link rel="stylesheet" type="text/css" href="/src/plugins/css/light/tomSelect/custom-tomSelect.css">
<link rel="stylesheet" type="text/css" href="/src/plugins/css/dark/tomSelect/custom-tomSelect.css">
<link rel="stylesheet" type="text/css" href="/src/assets/css/light/apps/ecommerce-create.css">
<link rel="stylesheet" type="text/css" href="/src/assets/css/dark/apps/ecommerce-create.css">

<style>
    .form-check-input:checked {
        background-color: #4361ee !important;
        border-color: #4361ee !important;
    }
</style>
<?= $this->endSection(); ?>