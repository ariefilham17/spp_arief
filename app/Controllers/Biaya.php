<?php

namespace App\Controllers;

use App\Models\JenisModel;
use App\Models\SiswaKategoriModel;

class Biaya extends BaseController
{
    public function index()
    {
        $jenisModel     = new JenisModel();
        $jenis          = $jenisModel->where('tipe', 1)->where('status', 1)->findAll();

        $kategoriModel  = new SiswaKategoriModel();
        $kategori       = $kategoriModel->where('status', 1)->findAll();

        $data           = [
            'page'      => "Biaya",
            'title'     => 'Biaya',
            'data'      => compact('jenis', 'kategori')
        ];

        return view('page/biaya/index', $data);
    }
}
