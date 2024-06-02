<?php

namespace App\Controllers;

class Administrator extends BaseController
{
    public function index()
    {
        $role   = [
            'Super Admin',
            'Admin',
            'Tata Usaha',
        ];

        $data   = [
            'page'      => "Administrator",
            'title'     => 'Administrator',
            'data'      => compact('role')
        ];

        return view('page/administrator/index', $data);
    }
}
