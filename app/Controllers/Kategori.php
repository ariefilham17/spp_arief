<?php

namespace App\Controllers;

class Kategori extends BaseController
{
    public function index()
    {
        $data   = [
            'page'      => "Kategori",
            'title'     => 'Kategori',
        ];

        return view('page/kategori/index', $data);
    }
}
