<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('welcome_message');
    }

    public function test()
    {
        $data   = [
            'page'      => "HTML",
            'title'     => 'HTML',
        ];

        return view('page/dashboard/index', $data);
    }
}
