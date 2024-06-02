<?php

namespace App\Controllers;

use App\Models\SiswaKategoriModel;
use App\Models\KelasModel;
use App\Models\PembayaranDetailModel;
use App\Models\PembayaranModel;
use App\Models\SettingModel;

class Pembayaran extends BaseController
{
    public function index()
    {
        $data   = [
            'page'      => "Pembayaran",
            'title'     => 'Pembayaran',
        ];

        return view('page/pembayaran/index', $data);
    }

    public function bulanan()
    {

        $data   = [
            'page'      => "Form Pembayaran",
            'title'     => 'Form Pembayaran',
            'data'      => [],
        ];

        return view('page/pembayaran/form', $data);
    }

    public function lainnya()
    {
        $kelasModel     = new KelasModel();
        $kelas          = $kelasModel
            ->select('tbl_kelas.id, CONCAT(tbl_kelas.level, \' \',  \' \', tbl_kelas.kode) as nama')
            ->where('tbl_kelas.status', 1)
            ->findAll();

        $kategoriModel  = new SiswaKategoriModel();
        $kategori       = $kategoriModel->where('status', 1)->findAll();

        $data   = [
            'page'      => "Form Pembayaran",
            'title'     => 'Form Pembayaran',
            'data'      => compact('kelas', 'kategori'),
        ];

        return view('page/pembayaran/lainnya', $data);
    }

    public function nota($id =  '')
    {
        $model          = new SettingModel();
        $settingData    = $model->where('status', 1)->get()->getResultArray() ?? [];
        $setting        = array();

        foreach ($settingData as $key => $value) {
            $setting[$value['kunci']] = $value['nilai'];
        }

        $model          = new PembayaranModel();
        $data           = $model
            ->select('tbl_pembayaran.*, tbl_siswa.nama as nama, tbl_siswa.nisn as nisn, CONCAT(tbl_kelas.level, \' \', tbl_kelas.kode) as kode_kelas')
            ->join('tbl_siswa', 'tbl_pembayaran.siswa = tbl_siswa.id', 'left')
            ->join('tbl_kelas', 'tbl_pembayaran.kelas = tbl_kelas.id', 'left')
            ->where('tbl_pembayaran.status', 1)
            ->where('tbl_pembayaran.id', $id)
            ->get()
            ->getRowArray();

        if (!$data) {
            return exit("<script>alert('Data tidak ditemukan');window.close();</script>");
        }

        $detailPembayaran = new PembayaranDetailModel();
        $data['detail'] = $detailPembayaran
            ->select('tbl_pembayaran_detail.*, tbl_jenis.nama')
            ->join('tbl_biaya', 'tbl_biaya.id = tbl_pembayaran_detail.biaya')
            ->join('tbl_jenis', 'tbl_jenis.id = tbl_biaya.jenis')
            ->where('pembayaran', $id)
            ->get()
            ->getResultArray() ?? [];

        $data['jam']                = date("H:i", strtotime($data['tanggal']));
        $data['tanggal']            = date("d F Y", strtotime($data['tanggal']));
        $data['total_raw']          = $data['total'];
        $data['total']              = number_format($data['total']);

        foreach ($data['detail'] as $key => $value) {
            $data['detail'][$key]['keterangan'] = $value['nama'] . ' ' . ($value['periode'] ? date('M Y', strtotime($value['periode'])) : '');
            $data['detail'][$key]['nominal'] = number_format($value['nominal']);
        }

        return view('page/pembayaran/nota', compact('setting', 'data'));
    }
}
