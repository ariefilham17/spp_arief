<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Master extends ResourceController
{

    public function index()
    {
        # code...
    }

    public function kelas()
    {
        $result = ['x' => 'xxx'];
        return $this->respond($result);
    }

    public function siswa()
    {
        # code...
    }

    public function pembayaran()
    {
        $result = ['x' => 'xxx'];
        return $this->respond($result);
    }

    public function provinsi()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $output = curl_exec($ch);

        curl_close($ch);
        return $this->respond($output);
    }
}
