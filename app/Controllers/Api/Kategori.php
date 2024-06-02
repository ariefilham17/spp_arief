<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Kategori extends ResourceController
{
    use ResponseTrait;

    protected $modelName = 'App\Models\JenisModel';
    protected $format    = 'json';

    public function index()
    {
        $draw           = $this->request->getVar('draw');
        $sort_col       = $this->request->getVar('order[0][column]');
        $sort_type      = $this->request->getVar('order[0][dir]');
        $offset         = $this->request->getVar('start');
        $limit          = $this->request->getVar('length');
        $search         = $this->request->getVar('search[value]');
        $sort[]         = 'id';
        $sort[]         = 'tipe';
        $sort[]         = 'nama';
        $sort[]         = 'deskripsi';

        $count          = $this->model->whereIn('tipe', [2, 3])->where('status', 1)->like('nama', $search)->countAllResults();
        $raw            = $this->model->whereIn('tipe', [2, 3])->where('status', 1)->like('nama', $search)->orderBy($sort[$sort_col], $sort_type)->findAll($limit, $offset);
        $data           = array();
        $no             = $sort_type == 'desc' && $sort[$sort_col] == 'id' ? $count : 1;

        foreach ($raw as $value) {
            $data[] = [
                ($sort_type == 'desc' && $sort[$sort_col] == 'id' ? $no-- : $no++),
                $value['tipe'] == "2" ? 'Pemasukan' : 'Pengeluaran',
                $value['nama'],
                $value['deskripsi'],
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
        $data       = $this->model->whereIn('tipe', [2, 3])->where('id', $id)->first();
        if (!$data) {
            return $this->failNotFound('Data tidak ditemukan');
        }

        return $this->respond($data);
    }

    // Create data
    public function create()
    {
        $data       = [
            'nama'          => $this->request->getVar('nama'),
            'tipe'          => $this->request->getVar('tipe'),
            'deskripsi'     => $this->request->getVar('deskripsi'),
            'is_bulanan'    => 0,
        ];

        $this->model->insert($data);

        $response   = [
            'status'    => 200,
            'error'     => null,
            'messages'  => [
                'success'   => 'Berhasil Menambahkan Kategori'
            ]
        ];

        return $this->respondCreated($response);
    }

    // Update Data
    public function update($id = null)
    {
        $id         = $this->request->getVar('id');
        $data       = [
            'nama'          => $this->request->getVar('nama'),
            'tipe'          => $this->request->getVar('tipe'),
            'deskripsi'     => $this->request->getVar('deskripsi'),
            'is_bulanan'    => 0,
        ];

        $this->model->update($id, $data);

        $response   = [
            'status'    => 200,
            'error'     => null,
            'messages'  => [
                'success'   => 'Berhasil Mengubah Kategori'
            ]
        ];

        return $this->respond($response);
    }

    // Delete Data
    public function delete($id = null)
    {
        $id         = $this->request->getVar('id');
        $data       = $this->model->whereIn('tipe', [2, 3])->where('id', $id)->first();

        if (!$data) {
            return $this->failNotFound('Kategori Tidak Ditemukan');
        }

        $this->model->update($id, ['status' => 0]);

        $response   = [
            'status'    => 200,
            'error'     => null,
            'messages'  => [
                'success'   => 'Berhasil Menghapus Kategori'
            ]
        ];
        return $this->respondCreated($response);
    }
}
