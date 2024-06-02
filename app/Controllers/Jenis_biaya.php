<?php

namespace App\Controllers;

class Jenis_biaya extends BaseController
{
    public function index()
    {
        $data   = [
            'page'      => "Jenis biaya",
            'title'     => 'Jenis biaya',
        ];

        return view('page/jenis_biaya/index', $data);
    }
}
