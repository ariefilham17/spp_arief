<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Pembayaran</title>
</head>

<style>
    html,
    body {
        font-family: 'arial';
        font-size: 11px;
    }

    .table-item {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .table-item tr.header td {
        background-color: #000;
        color: #fff;
        text-align: center;
    }

    .table-item tr td {
        border: 1px solid #000;
        padding: 5px;
    }

    .center {
        text-align: center;
    }

    .right {
        text-align: right;
    }

    .bold {
        font-weight: bold;
    }

    .w-100 {
        width: 100%;
    }

    .w-70 {
        width: 70%;
    }

    .w-50 {
        width: 50%;
    }

    .w-30 {
        width: 30%;
    }

    table tbody tr td,
    table thead tr th {
        padding: 5px;
    }
</style>
<?php
if (!function_exists('penyebut')) {
    function penyebut($nilai)
    {
        $nilai = abs($nilai);
        $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " " . $huruf[$nilai];
        } else if ($nilai < 20) {
            $temp = penyebut($nilai - 10) . " belas";
        } else if ($nilai < 100) {
            $temp = penyebut($nilai / 10) . " puluh" . penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " seratus" . penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = penyebut($nilai / 100) . " ratus" . penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " seribu" . penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = penyebut($nilai / 1000) . " ribu" . penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = penyebut($nilai / 1000000) . " juta" . penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = penyebut($nilai / 1000000000) . " milyar" . penyebut(fmod($nilai, 1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = penyebut($nilai / 1000000000000) . " trilyun" . penyebut(fmod($nilai, 1000000000000));
        }
        return $temp;
    }
}
?>

<body>
    <!-- KOP NOTA -->
    <table class="w-100">
        <tbody>
            <tr>
                <td width="70" rowspan="3" class="center">
                    <img src="<?= base_url('src/assets/img/logo_instansi.jpg')  ?>" alt="" srcset="" style="width: 60px;">
                </td>
                <td>
                    <h3 style="margin: 0;"><?= $setting['nama_sekolah'] ?? '' ?></h3>
                </td>
            </tr>
            <tr>
                <td><?= $setting['alamat_sekolah'] ?? '' ?></td>
            </tr>
            <tr>
                <td>Telp. <?= $setting['telepon_sekolah'] ?? '' ?> | Website : <?= $setting['web_sekolah'] ?? '' ?> | Email : <?= $setting['email_sekolah'] ?? '' ?></td>
            </tr>
        </tbody>
    </table>
    <!-- END KOP NOTA -->
    <!-- JUDUL -->
    <h2 class="w-100 center" style="border-top: 1px solid #000; border-bottom: 1px solid #000; padding: 10px 0; margin-bottom: 0">BUKTI PEMBAYARAN SISWA</h2>
    <!-- END JUDUL -->
    <!-- INFORMASI PEMBAYARAN -->
    <table class="w-100">
        <tbody>
            <tr>
                <td class="w-50" style="padding: 0">
                    <table>
                        <tbody>
                            <tr>
                                <td>KODE</td>
                                <td>:</td>
                                <td><?= str_pad($data['id'], 7, '0', STR_PAD_LEFT); ?></td>
                            </tr>
                            <tr>
                                <td>TANGGAL</td>
                                <td>:</td>
                                <td><?= $data['tanggal']; ?></td>
                            </tr>
                            <tr>
                                <td>JAM</td>
                                <td>:</td>
                                <td><?= $data['jam'] ?></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td class="w-50" style="padding: 0">
                    <table>
                        <tbody>
                            <tr>
                                <td>NIS</td>
                                <td>:</td>
                                <td><?= $data['nisn']; ?></td>
                            </tr>
                            <tr>
                                <td>NAMA</td>
                                <td>:</td>
                                <td><?= $data['nama']; ?></td>
                            </tr>
                            <tr>
                                <td>KELAS</td>
                                <td>:</td>
                                <td><?= $data['kode_kelas']; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <!-- END INFORMASI PEMBAYARAN -->
    <!-- ITEM -->
    <table class="w-100" cellspacing="0" style="margin: 10px 0;">
        <thead>
            <tr>
                <td style="width: 50px;border-top: 1px solid #000; border-bottom: 1px solid #000;" class="center">
                    <h3 style="margin: 0;">No</h3>
                </td>
                <td style="border-top: 1px solid #000; border-bottom: 1px solid #000;">
                    <h3 style="margin: 5px;">Keterangan</h3>
                </td>
                <td style="width: 200px;border-top: 1px solid #000; border-bottom: 1px solid #000;">
                    <h3 style="margin: 5px;">Nominal</h3>
                </td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['detail'] ?? [] as $key => $value) { ?>
                <tr>
                    <td class="center"><?= $key + 1 ?>.</td>
                    <td><?= $value['keterangan'] ?></td>
                    <td class="right"><?= $value['nominal'] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <!-- END ITEM -->
    <div style="height: 1px; width: 100%; border-bottom: 1px solid #000;"></div>
    <table class="w-100">
        <tr>
            <td class="w-70" style="vertical-align: top;">
                <h3 style="margin: 0;">Terbilang :</h3><br>
                <i><?= ucwords(penyebut($data['total_raw'] ?? 0) . ' rupiah') ?></i>
            </td>
            <td class="w-30">
                <div style="display: flex; align-items: center;border-bottom: 1px solid #000;">
                    <h3 style="margin: 0;">Total</h3>
                    <div style="margin-left: auto;"><?= $data['total'] ?></div>
                </div>
                <div class="center" style="margin-top: 10px;">
                    <?= $setting['kota_sekolah'] ?? '' ?>, <?= date("d F Y") ?> <br>
                    Yang Menerima,
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td>
                Catatan : <br>
                - Disimpan sebagai bukti pembayaran yang SAH<br>
                - Uang yang sudah dibayarkan tidak dapat diminta kembali.<br>
            </td>
            <td class="center">
                <?= $setting['nama_tata_usaha'] ?? '' ?>
            </td>
        </tr>
    </table>
</body>
<script>
    window.print();
    setTimeout(() => {
        window.close()
    }, 2000);
</script>

</html>