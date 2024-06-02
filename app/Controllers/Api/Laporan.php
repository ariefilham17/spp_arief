<?php

namespace App\Controllers\Api;

use App\Models\KeuanganModel;
use App\Models\PembayaranModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Laporan extends ResourceController
{

    public function keuangan()
    {
        $ds         = $this->request->getVar('ds');

        $explode    = explode('-', $ds);
        $tahun      = $explode[0] ?? false;
        $bulan      = $explode[1] ?? false;

        if (!$tahun || !$bulan) {
            return $this->failNotFound('Invalid Request');
        }

        $pembayaranModel    = new PembayaranModel();
        $pembayaran         = $pembayaranModel
            ->select('tbl_siswa.nama as siswa, tbl_pembayaran_detail.nominal as nominal, tbl_pembayaran_detail.periode, tbl_pembayaran.tanggal, tbl_jenis.nama as pembayaran')
            ->where('tbl_pembayaran.status', 1)
            ->where('DATE_FORMAT(tbl_pembayaran.tanggal,"%Y-%m") =', $ds)
            ->join('tbl_siswa', 'tbl_siswa.id = tbl_pembayaran.siswa', 'left')
            ->join('tbl_pembayaran_detail', 'tbl_pembayaran.id = tbl_pembayaran_detail.pembayaran', 'left')
            ->join('tbl_jenis', 'tbl_pembayaran_detail.biaya = tbl_jenis.id', 'left')
            ->get()
            ->getResultArray();

        $data = [];
        if (count($pembayaran) > 0) {
            foreach ($pembayaran as $value) {
                $data[] = [
                    'tanggal'       => date('d M Y', strtotime($value['tanggal'])),
                    'dt'            => strtotime($value['tanggal']),
                    'debit'         => NULL,
                    'kredit'        => $value['nominal'],
                    'tipe'          => "Pembayaran",
                    'keterangan'    => 'Pembayaran ' . $value['pembayaran'] . ' ' . $value['siswa'] . ($value['periode'] ? ' Periode ' . date('M Y', strtotime($value['periode'])) : '')
                ];
            }
        }

        $keuanganModel      = new KeuanganModel();
        $keuangan           = $keuanganModel
            ->select('tbl_keuangan.*, tbl_jenis.nama as jenis')
            ->join('tbl_jenis', 'tbl_keuangan.jenis = tbl_jenis.id', 'left')
            ->where('DATE_FORMAT(tbl_keuangan.tanggal,"%Y-%m") =', $ds)
            ->where('tbl_keuangan.status', 1)
            ->get()
            ->getResultArray();

        if (count($keuangan) > 0) {
            foreach ($keuangan as $value) {
                $data[] = [
                    'tanggal'       => date('d M Y', strtotime($value['tanggal'])),
                    'dt'            => strtotime($value['tanggal']),
                    'debit'         => $value['debit'],
                    'kredit'        => $value['kredit'],
                    'tipe'          => $value['debit'] != NULL ? "Pengeluaran" : "Pemasukan",
                    'keterangan'    => $value['jenis']
                ];
            }
        }

        usort($data, fn ($a, $b) => $a['dt'] <=> $b['dt']);

        return $this->respond($data);
    }
}
