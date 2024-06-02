<form id="biaya" onsubmit="prosesData(); return false;">
    <div class="row mb-4 layout-spacing">
        <div class="col-sm-8">
            <div class="widget-content widget-content-area ecommerce-create-section">
                <div class="table-responsive">
                    <table class="table table-bordered w-auto">
                        <thead>
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Nama</th>
                                <th>Nominal</th>
                                <th>Pilih</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($master as $key => $value) { ?>
                                <tr>
                                    <td scope="col" class="text-center"><?= $key + 1 ?></td>
                                    <td style="width: 150px;"><?= $value['nama']; ?></td>
                                    <td style="width: 150px;" class="text-end"><?= number_format($value['nominal']); ?></td>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input class="form-check-input unpaid" type="checkbox" name="bayar[<?= $value['id'] ?>]" value="<?= $value['nominal'] ?>" id="check-<?= $value['id'] ?>">
                                        </div>
                                    </td>
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