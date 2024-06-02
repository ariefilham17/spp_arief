<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Dashboard extends ResourceController
{
    use ResponseTrait;

    public function index()
    {
        $siswa          = array();
        /* //////////////////////////////////////////////////// */
        $db             = \Config\Database::connect();
        /* //////////////////////////////////////////////////// */
        $siswaData      = $db->query("SELECT tsk.*, COUNT(*) jml_siswa FROM tbl_siswa_kategori tsk LEFT JOIN tbl_siswa ts ON ts.kategori = tsk.id WHERE ts.status = 1 GROUP BY ts.kategori")->getResultArray() ?? [];
        $colorBG        = ['#eceffe', '#fbeced', '#fcf5e9'];
        $colorProgress  = ['bg-gradient-primary', 'bg-gradient-danger', 'bg-gradient-warning'];
        $totalSiswa     = array_sum(array_column($siswaData, 'jml_siswa'));
        $pos            = 0;
        foreach ($siswaData as $key => $value) {
            /* //////////////////////////////////////////////////// */
            if (!isset($colorBG[$pos])) $pos = 0;
            $siswa[]    = [
                'nama'          => $value['nama'],
                'jumlah'        => $value['jml_siswa'],
                'persen'        => round($value['jml_siswa'] / $totalSiswa * 100),
                'background'    => $colorBG[$pos],
                'progress'      => $colorProgress[$pos]
            ];
            $pos++;
            /* //////////////////////////////////////////////////// */
        }
        /* //////////////////////////////////////////////////// */
        $keuangan                   = $db->query("SELECT SUM(COALESCE(kredit, 0)) as pemasukan, SUM(COALESCE(debit, 0)) as pengeluaran FROM tbl_keuangan WHERE DATE_FORMAT(tanggal, \"%Y-%m\") = \"2023-10\" AND status = 1")->getResultArray()[0] ?? [];
        $totalUang                  = $db->query("SELECT SUM(COALESCE(debit, 0)-COALESCE(kredit,0)) as saldo FROM tbl_keuangan WHERE DATE_FORMAT(tanggal, \"%Y-%m\") = \"2023-10\" AND status = 1")->getResultArray()[0]['saldo'] ?? 0;
        $pembayaran                 = $db->query("SELECT SUM(total) total FROM tbl_pembayaran WHERE DATE_FORMAT(tanggal, \"%Y-%m\") = \"2023-10\" AND status = 1")->getResultArray()[0]['total'] ?? 0;
        $keuangan['saldo']          = $totalUang + $pembayaran;
        $keuangan['pemasukan']      = number_format($keuangan['pemasukan'] + $pembayaran);
        $keuangan['pengeluaran']    = number_format($keuangan['pengeluaran']);
        $keuangan['saldo']          = number_format($keuangan['saldo']);
        /* //////////////////////////////////////////////////// */
        $c_keuangan                 = $db->query("SELECT tanggal, SUM(COALESCE(kredit, 0)) as pemasukan, SUM(COALESCE(debit, 0)) as pengeluaran FROM tbl_keuangan WHERE DATE_FORMAT(tanggal, \"%Y\") = \"2023\" AND status = 1 GROUP BY YEAR(tanggal), MONTH(tanggal)")->getResultArray() ?? [];
        $c_pembayaran               = $db->query("SELECT tanggal, SUM(total) total FROM tbl_pembayaran WHERE DATE_FORMAT(tanggal, \"%Y\") = \"2023\" AND status = 1  GROUP BY YEAR(tanggal), MONTH(tanggal)")->getResultArray() ?? [];
        $arrPemasukan = $arrPengeluaran = $arrPembayaran = array();
        foreach ($c_keuangan as $value) {
            $arrPemasukan[date('Y-m', strtotime($value['tanggal']))] = (int) $value['pemasukan'];
            $arrPengeluaran[date('Y-m', strtotime($value['tanggal']))] = (int) $value['pemasukan'];
        }
        foreach ($c_pembayaran as $value) {
            isset($arrPemasukan[date('Y-m', strtotime($value['tanggal']))]) ?
                $arrPemasukan[date('Y-m', strtotime($value['tanggal']))] += (int) $value['total'] :
                $arrPemasukan[date('Y-m', strtotime($value['tanggal']))] = (int) $value['total'];
        }
        $chartData = [['name' => 'Pemasukan', 'data' => [], 'name' => 'Pengeluaran', 'data' => []]];
        $tahun = '2023';
        for ($i = 1; $i <= 12; $i++) {
            $bulan  = str_pad($i, 2, '0', STR_PAD_LEFT);
            $key    = $tahun . '-' . $bulan;

            $chartData[0]['data'][$i - 1] = ($arrPemasukan[$key] ?? 0) / 1000;
            $chartData[1]['data'][$i - 1] = ($arrPengeluaran[$key] ?? 0) / 1000;
        }
        /* //////////////////////////////////////////////////// */
        $list_tahun1 = $db->query("SELECT DATE_FORMAT(tanggal,\"%Y\") tahun FROM tbl_keuangan WHERE status = 1 GROUP BY DATE_FORMAT(tanggal,\"%Y\")")->getResultArray() ?? [];
        $list_tahun2 = $db->query("SELECT DATE_FORMAT(tanggal,\"%Y\") tahun FROM tbl_pembayaran WHERE status = 1 GROUP BY DATE_FORMAT(tanggal,\"%Y\")")->getResultArray() ?? [];
        $list_tahun  = array_unique(array_merge(array_column($list_tahun1, 'tahun'), array_column($list_tahun2, 'tahun')));
        /* //////////////////////////////////////////////////// */
        $db->close();
        $response   = [
            'status'    => 200,
            'error'     => null,
            'messages'  => [
                'success'   => 'Berhasil Mengambil Data'
            ],
            'data'      => compact('siswa', 'keuangan', 'chartData', 'list_tahun')
        ];

        return $this->respondCreated($response);
    }

    public function create()
    {
        $tahun = $this->request->getVar('tahun');
        $arrPemasukan = $arrPengeluaran = $arrPembayaran = array();

        $db                         = \Config\Database::connect();
        $c_keuangan                 = $db->query("SELECT tanggal, SUM(COALESCE(kredit, 0)) as pemasukan, SUM(COALESCE(debit, 0)) as pengeluaran FROM tbl_keuangan WHERE DATE_FORMAT(tanggal, \"%Y\") = \"$tahun\" AND status = 1 GROUP BY YEAR(tanggal), MONTH(tanggal)")->getResultArray() ?? [];
        $c_pembayaran               = $db->query("SELECT tanggal, SUM(total) total FROM tbl_pembayaran WHERE DATE_FORMAT(tanggal, \"%Y\") = \"$tahun\" AND status = 1  GROUP BY YEAR(tanggal), MONTH(tanggal)")->getResultArray() ?? [];
        foreach ($c_keuangan as $value) {
            $arrPemasukan[date('Y-m', strtotime($value['tanggal']))] = (int) $value['pemasukan'];
            $arrPengeluaran[date('Y-m', strtotime($value['tanggal']))] = (int) $value['pemasukan'];
        }
        foreach ($c_pembayaran as $value) {
            isset($arrPemasukan[date('Y-m', strtotime($value['tanggal']))]) ?
                $arrPemasukan[date('Y-m', strtotime($value['tanggal']))] += (int) $value['total'] :
                $arrPemasukan[date('Y-m', strtotime($value['tanggal']))] = (int) $value['total'];
        }
        $chartData = [['name' => 'Pemasukan', 'data' => [], 'name' => 'Pengeluaran', 'data' => []]];
        for ($i = 1; $i <= 12; $i++) {
            $bulan  = str_pad($i, 2, '0', STR_PAD_LEFT);
            $key    = $tahun . '-' . $bulan;

            $chartData[0]['data'][$i - 1] = ($arrPemasukan[$key] ?? 0) / 1000;
            $chartData[1]['data'][$i - 1] = ($arrPengeluaran[$key] ?? 0) / 1000;
        }
        $db->close();

        $response   = [
            'status'    => 200,
            'error'     => null,
            'messages'  => [
                'success'   => 'Berhasil Mengambil Data'
            ],
            'data'      => compact('chartData')
        ];

        return $this->respondCreated($response);
    }
}
