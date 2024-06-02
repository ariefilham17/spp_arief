<?php

namespace App\Controllers;

class Kelas extends BaseController
{
    public function index()
    {
        $data   = [
            'page'      => "Kelas",
            'title'     => 'Kelas',
            'data'      => []
        ];

        return view('page/kelas/index', $data);
    }
}
