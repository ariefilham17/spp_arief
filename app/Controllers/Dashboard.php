<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        $data   = [
            'page'      => "Dashboard",
            'title'     => 'Dashboard',
        ];

        return view('page/dashboard/index', $data);
    }
}
