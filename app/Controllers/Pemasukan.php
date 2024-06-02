<?php

namespace App\Controllers;

use App\Models\JenisModel;

class Pemasukan extends BaseController
{
    public function index()
    {
        $jenis      = new JenisModel();
        $kategori   = $jenis->where('status', 1)->where('tipe', 2)->get()->getResultArray() ?? [];

        $data   = [
            'page'      => "Pemasukan",
            'title'     => 'Pemasukan',
            'data'      => compact('kategori')
        ];

        return view('page/pemasukan/index', $data);
    }
}
