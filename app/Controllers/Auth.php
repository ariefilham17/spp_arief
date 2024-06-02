<?php

namespace App\Controllers;

class Auth extends BaseController
{
    public function index()
    {
        $session = session();
        $item = $session->get('user') ?? false;
        if ($item) {
            return redirect()->to(base_url());
        }

        return view('login');
    }

    public function logout()
    {
        session()->removeTempdata('user');

        return redirect()->to(base_url('auth'));
    }
}
