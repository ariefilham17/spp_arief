<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Biaya extends ResourceController
{
    use ResponseTrait;

    protected $modelName = 'App\Models\BiayaModel';
    protected $format    = 'json';

    public function index()
    {
        $draw           = $this->request->getVar('draw');
        $sort_col       = $this->request->getVar('order[0][column]');
        $sort_type      = $this->request->getVar('order[0][dir]');
        $offset         = $this->request->getVar('start');
        $limit          = $this->request->getVar('length');
        $search         = $this->request->getVar('search[value]');

        $jenis          = $this->request->getVar('jenis');
        $kategori       = $this->request->getVar('kategori');

        $sort[]         = 'tbl_biaya.id';
        $sort[]         = 'tbl_jenis.nama';
        $sort[]         = 'tbl_biaya.nominal';
        $sort[]         = 'tbl_siswa_kategori.nama';

        $count          = $this->model
            ->select('tbl_biaya.*, tbl_siswa_kategori.nama as kategori, tbl_jenis.nama as jenis')
            ->where('tbl_biaya.status', 1)
            ->like('tbl_jenis.nama', $search);

        if ($jenis != "") {
            $count = $count->where('tbl_biaya.jenis', $jenis);
        }

        if ($kategori != "") {
            $count = $count->where('tbl_biaya.kategori', $kategori);
        }

        $count = $count->join('tbl_jenis', 'tbl_jenis.id = tbl_biaya.jenis', 'left')
            ->countAllResults();

        $raw            = $this->model
            ->select('tbl_biaya.*, tbl_siswa_kategori.nama as kategori, tbl_jenis.nama')
            ->where('tbl_biaya.status', 1)
            ->like('tbl_jenis.nama', $search);

        if ($jenis != "") {
            $raw = $raw->where('tbl_biaya.jenis', $jenis);
        }

        if ($kategori != "") {
            $raw = $raw->where('tbl_biaya.kategori', $kategori);
        }

        $raw =  $raw->join('tbl_jenis', 'tbl_jenis.id = tbl_biaya.jenis', 'left')
            ->join('tbl_siswa_kategori', 'tbl_siswa_kategori.id = tbl_biaya.kategori', 'left')
            ->orderBy($sort[$sort_col], $sort_type)
            ->findAll($limit, $offset);

        $data           = array();
        $no             = $sort_type == 'desc' && $sort[$sort_col] == 'tbl_biaya.id' ? $count : 1;
        foreach ($raw as $value) {
            $data[] = [
                ($sort_type == 'desc' && $sort[$sort_col] == 'tbl_biaya.id' ? $no-- : $no++),
                $value['nama'],
                number_format($value['nominal']),
                $value['kategori'],
                '<div class="action d-flex justify-content-around">
                    <i data-id="' . $value['id'] . '" class="edit" data-feather="edit"></i>
                    <i data-id="' . $value['id'] . '" class="delete" data-feather="trash-2"></i>
                </div>'
            ];
        }

        $result         = [
            'draw'                  => $draw,
            'recordsFiltered'       => $count,
            'recordsTotal'          => $count,
            'data'                  => $data,
        ];

        return $this->respond($result);
    }

    // Get Data By ID
    public function show($id = null)
    {
        $data       = $this->model->where('id', $id)->first();
        if (!$data) {
            return $this->failNotFound('Data tidak ditemukan');
        }

        return $this->respond($data);
    }

    // Create data
    public function create()
    {
        $data       = [
            'jenis'     => $this->request->getVar('jenis'),
            'nominal'   => $this->request->getVar('nominal'),
            'kategori'  => $this->request->getVar('kategori'),
            'status'    => 1
        ];

        $exist      = $this->model->where('jenis', $data['jenis'])->where('kategori', $data['kategori'])->first();
        if ($exist) {
            $this->model
                ->where('id', $exist['id'])
                ->set($data)
                ->update();
        } else {
            $this->model->insert($data);
        }

        $response   = [
            'status'    => 200,
            'error'     => null,
            'messages'  => [
                'success'   => 'Berhasil Menambahkan Biaya'
            ]
        ];

        return $this->respondCreated($response);
    }

    // Update Data
    public function update($id = null)
    {
        $id         = $this->request->getVar('id');
        $data       = [
            'jenis'     => $this->request->getVar('jenis'),
            'nominal'   => $this->request->getVar('nominal'),
            'kategori'  => $this->request->getVar('kategori'),
        ];

        $this->model->update($id, $data);

        $response   = [
            'status'    => 200,
            'error'     => null,
            'messages'  => [
                'success'   => 'Berhasil Mengubah Biaya'
            ]
        ];

        return $this->respond($response);
    }

    // Delete Data
    public function delete($id = null)
    {
        $id         = $this->request->getVar('id');
        $data       = $this->model->where('id', $id)->first();

        if (!$data) {
            return $this->failNotFound('Biaya Tidak Ditemukan');
        }

        $this->model->update($id, ['status' => 0]);

        $response   = [
            'status'    => 200,
            'error'     => null,
            'messages'  => [
                'success'   => 'Berhasil Menghapus Biaya'
            ]
        ];
        return $this->respondCreated($response);
    }
}
