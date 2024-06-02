<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Administrator extends ResourceController
{
    use ResponseTrait;

    protected $modelName = 'App\Models\AdministratorModel';
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
        $sort[]         = 'nama';
        $sort[]         = 'user';
        $sort[]         = 'role';

        $count          = $this->model->where('status', 1)->like('nama', $search)->countAllResults();
        $raw            = $this->model->where('status', 1)->like('nama', $search)->orderBy($sort[$sort_col], $sort_type)->findAll($limit, $offset);
        $data           = array();
        $no             = $sort_type == 'desc' && $sort[$sort_col] == 'id' ? $count : 1;

        foreach ($raw as $value) {
            $data[] = [
                ($sort_type == 'desc' && $sort[$sort_col] == 'id' ? $no-- : $no++),
                $value['nama'],
                $value['user'],
                $value['role'],
                '<div class="action d-flex justify-content-around">
                    <i data-id="' . $value['id'] . '" class="pass" data-feather="lock"></i>
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
    public function edit($id = null)
    {
        $data       = $this->model->where('id', $id)->first();
        if (!$data) {
            return $this->failNotFound('Data tidak ditemukan');
        }

        $data['akses'] = !empty($data['akses']) ? json_decode($data['akses']) : [];
        return $this->respond($data);
    }

    // Create data
    public function create()
    {
        $data       = [
            'nama'          => $this->request->getVar('nama'),
            'user'          => $this->request->getVar('user'),
            'pass'          => $this->request->getVar('pass'),
            'role'          => $this->request->getVar('role'),
            'akses'         => !empty($this->request->getVar('access')) ? json_encode($this->request->getVar('access')) : NULL,
        ];

        $this->model->insert($data);

        $response   = [
            'status'    => 200,
            'error'     => null,
            'messages'  => [
                'success'   => 'Berhasil Menambahkan Administrator'
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
            'user'          => $this->request->getVar('user'),
            'role'          => $this->request->getVar('role'),
            'akses'         => !empty($this->request->getVar('access')) ? json_encode($this->request->getVar('access')) : NULL,
        ];

        $this->model->update($id, $data);

        $response   = [
            'status'    => 200,
            'error'     => null,
            'messages'  => [
                'success'   => 'Berhasil Mengubah Administrator'
            ]
        ];

        return $this->respond($response);
    }

    // Update Password
    public function updatePassword($id = null)
    {
        $data       = [
            'pass'          => $this->request->getVar('pass'),
        ];

        $this->model->update($id, $data);

        $response   = [
            'status'    => 200,
            'error'     => null,
            'messages'  => [
                'success'   => 'Berhasil Mengubah Password Administrator'
            ]
        ];

        return $this->respond($response);
    }

    // Delete Data
    public function delete($id = null)
    {
        $id         = $this->request->getVar('id');
        $data       = $this->model->where('tipe', 1)->where('id', $id)->first();

        if (!$data) {
            return $this->failNotFound('Administrator Tidak Ditemukan');
        }

        $this->model->update($id, ['status' => 0]);

        $response   = [
            'status'    => 200,
            'error'     => null,
            'messages'  => [
                'success'   => 'Berhasil Menghapus Administrator'
            ]
        ];
        return $this->respondCreated($response);
    }
}
