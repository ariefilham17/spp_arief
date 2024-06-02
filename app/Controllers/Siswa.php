<?php

namespace App\Controllers;

use App\Models\SiswaKategoriModel;
use App\Models\KelasModel;

class Siswa extends BaseController
{
    public function index()
    {
        $kelasModel     = new KelasModel();
        $kelas          = $kelasModel
            ->select('tbl_kelas.id, CONCAT(tbl_kelas.level, \' \',  \' \', tbl_kelas.kode) as nama')
            ->where('tbl_kelas.status', 1)
            ->findAll();

        $kategoriModel  = new SiswaKategoriModel();
        $kategori       = $kategoriModel->where('status', 1)->findAll();

        $data       = [
            'page'      => "Siswa",
            'title'     => 'Siswa',
            'data'      => compact('kelas', 'kategori'),
        ];

        return view('page/siswa/index', $data);
    }
}
