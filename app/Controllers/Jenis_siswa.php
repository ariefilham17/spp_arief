<?php

namespace App\Controllers;

class Jenis_siswa extends BaseController
{
    public function index()
    {
        $data   = [
            'page'      => "Jenis siswa",
            'title'     => 'Jenis siswa',
        ];

        return view('page/jenis_siswa/index', $data);
    }
}
