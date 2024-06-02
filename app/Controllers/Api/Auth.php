<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Auth extends ResourceController
{
    use ResponseTrait;

    protected $modelName = 'App\Models\AdministratorModel';
    protected $format    = 'json';

    public function login()
    {
        $user   = $this->request->getVar('user');
        $pass   = $this->request->getVar('pass');

        $admin  = $this->model->where('user', $user)->where('status', 1)->first();

        if (!$admin) {
            return $this->failNotFound('User tidak ditemukan');
        }

        if ($admin['pass'] !== $pass) {
            return $this->failNotFound('Username atau passwordd tidak cocok!');
        }

        if (!$admin['akses']) {
            return $this->failNotFound('Kamu tidak memiliki akses!');
        }

        $session = \Config\Services::session();
        $session->setFlashdata('user', $admin);
        $session->markAsTempdata('user', strtotime(date('Y-m-d 23:59:59')) - time());

        $response   = [
            'status'    => 200,
            'error'     => null,
            'messages'  => [
                'success'   => "Berhasil Masuk"
            ]
        ];

        return $this->respond($response);
    }
}
