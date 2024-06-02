<?= $this->extend('index'); ?>

<?= $this->section('content'); ?>
<div class="middle-content container-xxl p-0">
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Pengaturan</a></li>
                <li class="breadcrumb-item active"><a href="#">Sekolah</a></li>
            </ol>
        </nav>
    </div>

    <form id="data">
        <div class="row layout-spacing layout-top-spacing">
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="widget-content widget-content-area ecommerce-create-section">
                    <div class="row">
                        <div class="col-6">
                            <?php foreach ($data['setting'] ?? [] as $key => $value) { ?>
                                <div class="mb-2">
                                    <label><?= $value['nama'] ?></label>
                                    <input id="<?= $value['kunci'] ?>" type="text" name="<?= $value['kunci'] ?>" value="<?= $value['nilai'] ?>" placeholder="Masukkan <?= $value['nama'] ?>" class="form-control">
                                </div>
                            <?php } ?>
                            <div class="form-group mt-3">
                                <button type="button" class="btn btn-success w-100 _effect--ripple waves-effect waves-light" onclick="prosesData()">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    const prosesData = () => {
        let data = $('#data').serializeArray();

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
                    url: base_url + 'api/setting/update',
                    data: data,
                    success: function(res) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: res?.messages?.success || 'Berhasil membayar tagihan',
                            timer: 2000,
                            showConfirmButton: false
                        });
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
<?= $this->endSection(); ?>