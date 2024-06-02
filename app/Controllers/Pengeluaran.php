<?php

namespace App\Controllers;

use App\Models\JenisModel;

class Pengeluaran extends BaseController
{
    public function index()
    {
        $jenis      = new JenisModel();
        $kategori   = $jenis->where('status', 1)->where('tipe', 3)->get()->getResultArray() ?? [];

        $data   = [
            'page'      => "Pengeluaran",
            'title'     => 'Pengeluaran',
            'data'      => compact('kategori')
        ];

        return view('page/pengeluaran/index', $data);
    }
}
