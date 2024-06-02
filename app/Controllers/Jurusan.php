<?php

namespace App\Controllers;

class Jurusan extends BaseController
{
    public function index()
    {
        $data   = [
            'page'      => "Jurusan",
            'title'     => 'Jurusan',
        ];

        return view('page/jurusan/index', $data);
    }
}
