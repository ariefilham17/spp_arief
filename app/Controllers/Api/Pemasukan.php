<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Pemasukan extends ResourceController
{
    use ResponseTrait;

    protected $modelName = 'App\Models\KeuanganModel';
    protected $format    = 'json';

    public function index()
    {
        $draw           = $this->request->getVar('draw');
        $sort_col       = $this->request->getVar('order[0][column]');
        $sort_type      = $this->request->getVar('order[0][dir]');
        $offset         = $this->request->getVar('start');
        $limit          = $this->request->getVar('length');
        $search         = str_ireplace([',', '.'], '', $this->request->getVar('search[value]'));
        $sort[]         = 'tbl_keuangan.id';
        $sort[]         = 'tbl_keuangan.tanggal';
        $sort[]         = 'tbl_jenis.nama';
        $sort[]         = 'tbl_keuangan.deskripsi';
        $sort[]         = 'tbl_keuangan.kredit';

        $count          = $this->model->where('tbl_keuangan.status', 1)->like('deskripsi', $search)->countAllResults();
        $raw            = $this->model
            ->select('tbl_keuangan.*, tbl_jenis.nama as kategori')
            ->join('tbl_jenis', 'tbl_jenis.id = tbl_keuangan.jenis', 'left')
            ->where('tbl_keuangan.status', 1)
            ->where('tbl_jenis.tipe', 2)
            ->where('(tbl_keuangan.deskripsi LIKE "%' . $search . '%" OR tbl_jenis.nama LIKE "%' . $search . '%" OR tbl_keuangan.kredit LIKE "%' . $search . '%" OR tbl_keuangan.kredit LIKE "%' . $search . '%" )')
            ->orderBy($sort[$sort_col], $sort_type)
            ->findAll($limit, $offset);
        $data           = array();
        $no             = $sort_type == 'desc' && $sort[$sort_col] == 'id' ? $count : 1;
        foreach ($raw as $value) {
            $data[] = [
                ($sort_type == 'desc' && $sort[$sort_col] == 'id' ? $no-- : $no++),
                date('d M y H:i', strtotime($value['tanggal'])),
                $value['kategori'],
                $value['deskripsi'],
                number_format($value['kredit'] ?? 0),
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
            'deskripsi'     => $this->request->getVar('deskripsi'),
            'kredit'        => $this->request->getVar('nominal'),
            'debit'         => NULL,
            'jenis'         => $this->request->getVar('jenis'),
        ];

        $this->model->insert($data);

        $response   = [
            'status'    => 200,
            'error'     => null,
            'messages'  => [
                'success'   => 'Berhasil Menambahkan Pemasukan'
            ]
        ];

        return $this->respondCreated($response);
    }

    // Update Data
    public function update($id = null)
    {
        $id         = $this->request->getVar('id');
        $data       = [
            'deskripsi'     => $this->request->getVar('deskripsi'),
            'kredit'        => $this->request->getVar('nominal'),
            'debit'         => NULL,
            'jenis'         => $this->request->getVar('jenis'),
        ];

        $this->model->update($id, $data);

        $response   = [
            'status'    => 200,
            'error'     => null,
            'messages'  => [
                'success'   => 'Berhasil Mengubah Pemasukan'
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
            return $this->failNotFound('Pemasukan Tidak Ditemukan');
        }

        $this->model->update($id, ['status' => 0]);

        $response   = [
            'status'    => 200,
            'error'     => null,
            'messages'  => [
                'success'   => 'Berhasil Menghapus Pemasukan'
            ]
        ];
        return $this->respondCreated($response);
    }
}
