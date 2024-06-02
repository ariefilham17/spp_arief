<?php
$start  = strtotime($startDate);
$end    = strtotime($endDate);
$pos    = $start;
$month  = [];
while ($pos <= $end) {
    $month[] = date('Y-m-d', $pos);
    $pos    = strtotime('+1month', $pos);
}
?>
<form id="biaya" onsubmit="prosesData(); return false;">
    <div class="row mb-4 layout-spacing">
        <div class="col-sm-8">
            <div class="widget-content widget-content-area ecommerce-create-section">
                <div class="table-responsive">
                    <table class="table table-bordered w-auto">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 150px;"></th>
                                <?php foreach ($master as $key => $value) { ?>
                                    <th class="text-center" style="width: 150px;"><?= $value['nama']; ?></th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($month as $key => $m) { ?>
                                <tr>
                                    <td class="text-center">
                                        <?= date('M Y', strtotime($m)); ?>
                                    </td>
                                    <?php
                                    foreach ($master as $key => $value) {
                                        $id         = $value['id'];
                                        $nominal    = $value['nominal'];
                                        $key        = date('Ymd', strtotime($m)) . $value['id'];
                                        $periode    = date('Y-m-d', strtotime($m));
                                    ?>
                                        <?php if (isset($data[$periode][$id])) { ?>
                                            <td class="text-center">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="<?= date('Ymd', strtotime($m)); ?><?= $value['id'] ?>" checked disabled>
                                                    <label class="form-check-label ms-2" for="<?= date('Ymd', strtotime($m)); ?><?= $value['id'] ?>"><?= number_format($data[$periode][$id]) ?></label>
                                                </div>
                                            </td>
                                        <?php } else { ?>
                                            <td class="text-center">
                                                <div class="form-check">
                                                    <input class="form-check-input unpaid" type="checkbox" name="bayar[<?= $periode ?>][<?= $id ?>]" value="<?= $nominal ?>" id="<?= date('Ymd', strtotime($m)); ?><?= $value['id'] ?>">
                                                    <label class="form-check-label ms-2" for="<?= date('Ymd', strtotime($m)); ?><?= $value['id'] ?>"><?= number_format($nominal) ?></label>
                                                </div>
                                            </td>
                                        <?php } ?>
                                    <?php
                                    }
                                    ?>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="widget-content widget-content-area ecommerce-create-section widget-card-four">
                <div class="row">
                    <div class="col-sm-12 mb-4">
                        <table class="table w-100">
                            <thead>
                                <tr>
                                    <th scope="col" colspan="2"><b>Profil Siswa</b></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        Nama
                                    </td>
                                    <td>
                                        <?= $siswa['nama'] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        NISN
                                    </td>
                                    <td>
                                        <?= $siswa['nisn'] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Jenis Kelamin
                                    </td>
                                    <td>
                                        <?= $siswa['jk'] == 'l' ? 'Laki-laki' : 'Perempuan'; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        TTL
                                    </td>
                                    <td>
                                        <?= $siswa['tempat_lahir'] . ', ' . date('d M Y', strtotime($siswa['tanggal_lahir'])) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Kategori
                                    </td>
                                    <td>
                                        <?= $siswa['kategori_siswa']; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <label for="regular-price">Total Bayar</label>
                        <!-- Bg Primary -->
                        <div class="card style-5 bg-dark mb-md-0 mb-4">
                            <div class="card-content">
                                <div class="card-body">
                                    <h5 class="card-title mb-0 text-end total">0</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 mb-4">
                        <label for="keterangan">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" style="resize: none" class="form-control" rows="5" placeholder="Masukkan Keterangan"></textarea>
                    </div>
                    <div class="col-sm-12">
                        <button class="btn btn-success w-100 _effect--ripple waves-effect waves-light">Proses Bayar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>