<?php

namespace App\Controllers\Api;

use App\Models\PembayaranModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Siswa extends ResourceController
{
    use ResponseTrait;

    protected $modelName = 'App\Models\SiswaModel';
    protected $format = 'json';

    public function index()
    {
        $draw           = $this->request->getVar('draw');
        $sort_col       = $this->request->getVar('order[0][column]');
        $sort_type      = $this->request->getVar('order[0][dir]');
        $offset         = $this->request->getVar('start');
        $limit          = $this->request->getVar('length');
        $search         = $this->request->getVar('search[value]');

        $sort[]         = 'tbl_siswa.id';
        $sort[]         = 'tbl_siswa.nama';
        $sort[]         = 'kode_kelas';
        $sort[]         = 'tbl_siswa.nisn';
        $sort[]         = 'tbl_siswa.kategori';

        $data           = array();

        $count          = $this->model
            ->where('status', 1)
            ->like('nama', $search)
            ->countAllResults();

        $raw            = $this->model
            ->select('tbl_siswa.*, tbl_siswa_kategori.nama as kategori, CONCAT(tbl_kelas.level, \' \', tbl_kelas.kode) as kode_kelas')
            ->join('tbl_kelas', 'tbl_kelas.id = tbl_siswa.kelas', 'left')
            ->join('tbl_siswa_kategori', 'tbl_siswa_kategori.id = tbl_siswa.kategori', 'left')
            ->where('tbl_siswa.status', 1)
            ->like('tbl_siswa.nama', $search)
            ->orderBy($sort[$sort_col], $sort_type)
            ->findAll($limit, $offset);

        $no             = $sort_type == 'desc' && $sort[$sort_col] == 'tbl_siswa.id' ? $count : 1;
        foreach ($raw as $value) {
            $data[] = [
                ($sort_type == 'desc' && $sort[$sort_col] == 'id' ? $no-- : $no++),
                $value['nama'],
                $value['kode_kelas'],
                $value['nisn'],
                $value['kategori'],
                '<div class="action d-flex justify-content-around">
                    <i data-id="' . $value['id'] . '" class="detail" data-feather="eye"></i>
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

    public function detail($id = null)
    {
        $data       = $this->model->where('id', $id)->first();

        if (!$data) {
            return $this->failNotFound('Data tidak ditemukan');
        }

        return $this->respond($data);
    }

    public function profil($id = null)
    {
        $data       = $this->model
            ->select('tbl_siswa.*, CONCAT(tbl_kelas.level, \' \', tbl_kelas.kode) as kelas, tbl_siswa_kategori.nama as kategori')
            ->join('tbl_kelas', 'tbl_kelas.id = tbl_siswa.kelas', 'left')
            ->join('tbl_siswa_kategori', 'tbl_siswa_kategori.id = tbl_siswa.kategori', 'left')
            ->where('tbl_siswa.id', $id)
            ->first();

        if (!$data) {
            return $this->failNotFound('Data tidak ditemukan');
        }

        $db                 = \Config\Database::connect();
        $pembayaran         = $db->query("SELECT tp.tanggal, tp.keterangan, tj.nama as jenis,tpd.periode, tpd.biaya, tpd.nominal 
            FROM tbl_pembayaran tp
            LEFT JOIN tbl_pembayaran_detail tpd ON tpd.pembayaran = tp.id
            LEFT JOIN tbl_jenis tj ON tj.id = tpd.biaya
            WHERE tp.id = '$id'
            ORDER BY tp.tanggal DESC")->getResultArray();
        $db->close();

        if (count($pembayaran) > 0) {
            foreach ($pembayaran as $key => $value) {
                $pembayaran[$key]['title'] = 'Pembayaran ' . $value['jenis'] . ($value['periode'] ? ' Periode ' . date('M Y', strtotime($value['periode'])) : '');
                $pembayaran[$key]['tanggal'] = date('d M Y', strtotime($value['tanggal']));
                $pembayaran[$key]['nominal'] = number_format($value['nominal']);
            }
        }

        $data['pembayaran'] = $pembayaran;

        return $this->respond($data);
    }

    // Create data
    public function create()
    {
        $data       = [
            'nama'          => $this->request->getVar('nama'),
            'kelas'         => $this->request->getVar('kelas'),
            'nisn'          => $this->request->getVar('nisn'),
            'jk'            => $this->request->getVar('jk'),
            'tempat_lahir'  => $this->request->getVar('tempat_lahir'),
            'tanggal_lahir' => $this->request->getVar('tanggal_lahir'),
            'kelas'         => $this->request->getVar('kelas'),
            'kategori'      => $this->request->getVar('kategori'),
        ];

        $this->model->insert($data);

        $response   = [
            'status'    => 200,
            'error'     => null,
            'messages'  => [
                'success'   => 'Berhasil Menambahkan Siswa'
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
            'kelas'         => $this->request->getVar('kelas'),
            'nisn'          => $this->request->getVar('nisn'),
            'jk'            => $this->request->getVar('jk'),
            'tempat_lahir'  => $this->request->getVar('tempat_lahir'),
            'tanggal_lahir' => $this->request->getVar('tanggal_lahir'),
            'kelas'         => $this->request->getVar('kelas'),
            'kategori'      => $this->request->getVar('kategori'),
        ];

        $this->model->update($id, $data);

        $response   = [
            'status'    => 200,
            'error'     => null,
            'messages'  => [
                'success'   => 'Berhasil Mengubah Siswa'
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
            return $this->failNotFound('Siswa Tidak Ditemukan');
        }

        $this->model->update($id, ['status' => 0]);

        $response   = [
            'status'    => 200,
            'error'     => null,
            'messages'  => [
                'success'   => 'Berhasil Menghapus Siswa'
            ]
        ];
        return $this->respondCreated($response);
    }
}
