<?php

namespace App\Controllers\Api;

use App\Models\PembayaranDetailModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Database\Exceptions\DatabaseException;

class Pembayaran extends ResourceController
{
    protected $modelName = 'App\Models\PembayaranModel';
    protected $format = 'json';

    public function index()
    {
        $draw           = $this->request->getVar('draw');
        $sort_col       = $this->request->getVar('order[0][column]');
        $sort_type      = $this->request->getVar('order[0][dir]');
        $offset         = $this->request->getVar('start');
        $limit          = $this->request->getVar('length');
        $search         = str_replace(',', '', $this->request->getVar('search[value]'));

        $sort[]         = 'tbl_pembayaran.id';
        $sort[]         = 'tbl_pembayaran.tanggal';
        $sort[]         = 'tbl_siswa.nama';
        $sort[]         = 'tbl_pembayaran.nominal';
        $sort[]         = 'tbl_pembayaran.keterangan';

        $raw          = $this->model
            ->select('tbl_pembayaran.*, tbl_siswa.nama as nama, CONCAT(tbl_kelas.level, \' \', tbl_kelas.kode) as kode_kelas')
            ->join('tbl_siswa', 'tbl_pembayaran.siswa = tbl_siswa.id', 'left')
            ->join('tbl_kelas', 'tbl_pembayaran.kelas = tbl_kelas.id', 'left')
            ->where('tbl_pembayaran.status', 1)
            ->where('(tbl_siswa.nama LIKE "%' . $search . '%" OR tbl_pembayaran.keterangan LIKE "%' . $search . '%" OR tbl_pembayaran.total LIKE "%' . $search . '%" )')
            ->orderBy('tbl_pembayaran.tanggal', 'asc')->get($limit, $offset)->getResultArray();


        $count = $this->model
            ->select('tbl_pembayaran.*, tbl_siswa.nama as nama, CONCAT(tbl_kelas.level, \' \', tbl_kelas.kode) as kode_kelas')
            ->join('tbl_siswa', 'tbl_pembayaran.siswa = tbl_siswa.id', 'left')
            ->join('tbl_kelas', 'tbl_pembayaran.kelas = tbl_kelas.id', 'left')
            ->where('tbl_pembayaran.status', 1)
            ->where('(tbl_siswa.nama LIKE "%' . $search . '%" OR tbl_pembayaran.keterangan LIKE "%' . $search . '%" OR tbl_pembayaran.total LIKE "%' . $search . '%" )')
            ->orderBy('tbl_pembayaran.tanggal', 'asc')->countAllResults();

        $data           = array();
        $no             = $sort_type == 'desc' && $sort[$sort_col] == 'tbl_pembayaran.id' ? $count : 1;

        foreach ($raw as $value) {
            $data[] = [
                ($sort_type == 'desc' && $sort[$sort_col] == 'tbl_pembayaran.id' ? $no-- : $no++),
                date('d M Y', strtotime($value['tanggal'])),
                $value['nama'],
                $value['kode_kelas'],
                number_format($value['total']),
                $value['keterangan'],
                '<div class="action d-flex justify-content-around">
                    <i data-id="' . $value['id'] . '" class="detail" data-feather="printer"></i>
                    <i data-id="' . $value['id'] . '" class="edit" data-feather="eye"></i>
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

    public function siswa()
    {
        $q = $this->request->getVar('q') ?? "";

        $db      = \Config\Database::connect();
        $builder = $db->table('tbl_siswa')
            ->select('tbl_siswa.id, CONCAT(tbl_siswa.nama, \' - \' ,tbl_kelas.level, \' \', tbl_kelas.kode) as title')
            ->join('tbl_kelas', 'tbl_siswa.kelas = tbl_kelas.id', 'left')
            ->where('tbl_siswa.status', 1)
            ->like('tbl_siswa.nama', $q)
            ->get()->getResultArray() ?? [];

        $db->close();

        return $this->respond(['items' => $builder]);
    }

    public function tagihan()
    {
        $siswa_id       = $this->request->getVar('siswa_id');
        $tahun          = $this->request->getVar('tahun');
        $exp_tahun      = explode('-', $tahun);
        $startTahun     = $exp_tahun[0] ?? false;
        $endTahun       = $exp_tahun[1] ?? false;

        if (!$startTahun || !$endTahun || !$siswa_id) {
            return $this->failNotFound('Invalid Request');
        }

        $startDate      = $startTahun . '-07-01';
        $endDate        = $endTahun . '-07-01';

        $db             = \Config\Database::connect();
        $siswa          = $db->query("SELECT ts.*, tsk.nama as kategori_siswa
        FROM tbl_siswa ts
        LEFT JOIN tbl_siswa_kategori tsk ON tsk.id = ts.kategori
        WHERE ts.status = 1 
        AND ts.id = '$siswa_id'")->getRowArray();

        if (!$siswa) {
            $db->close();
            return $this->failNotFound('Siswa tidak ditemukan');
        }

        $siswa_kategori = $siswa['kategori'];

        $master         = $db->query("SELECT tj.nama, tb.* 
            FROM tbl_jenis tj, tbl_biaya tb 
            WHERE tj.id = tb.jenis 
            AND tj.tipe = 1
            AND tj.status = 1 
            AND tb.status = 1
            AND tj.is_bulanan = 1
            AND tb.kategori = '$siswa_kategori'")->getResultArray() ?? [];

        if (count($master) < 1) {
            $db->close();
            return $this->failNotFound('Tagihan Tidak Ditemukan');
        }

        $master_id      = implode(',', array_column($master, 'id'));

        $rawData        = $db->query("SELECT * FROM tbl_pembayaran tp, tbl_pembayaran_detail tpd 
            WHERE tp.id = tpd.pembayaran
            AND tp.siswa = '$siswa_id'
            AND tp.status = 1
            AND tpd.biaya IN ($master_id)
            AND tpd.periode BETWEEN '$startDate' AND '$endDate'")->getResultArray() ?? [];

        $data = array();
        foreach ($rawData as $key => $value) {
            $periode        = $value['periode'];
            $biaya          = $value['biaya'];
            $nominal          = $value['nominal'];

            $data[$periode][$biaya] = $nominal;
        }

        $db->close();

        return view('api/pembayaran/tagihan', compact('startDate', 'endDate', 'master', 'data', 'siswa'));
    }

    public function lainnya()
    {
        $siswa_id       = $this->request->getVar('siswa_id');

        if (!$siswa_id) {
            return $this->failNotFound('Invalid Request');
        }

        $db             = \Config\Database::connect();
        $siswa          = $db->query("SELECT ts.*, tsk.nama as kategori_siswa
            FROM tbl_siswa ts
            LEFT JOIN tbl_siswa_kategori tsk ON tsk.id = ts.kategori
            WHERE ts.status = 1 
            AND ts.id = '$siswa_id'")->getRowArray();

        if (!$siswa) {
            $db->close();
            return $this->failNotFound('Siswa tidak ditemukan');
        }

        $master         = $db->query(
            'SELECT tj.nama, tb.* FROM tbl_jenis tj
            LEFT JOIN tbl_biaya tb ON tb.jenis = tj.id
            WHERE tb.status = 1 AND tj.status = 1 AND is_bulanan = 0 AND tb.kategori = "' . $siswa['kategori'] . '"'
        )->getResultArray();

        $db->close();

        return view('api/pembayaran/lainnya', compact('master', 'siswa'));
    }

    public function bayar_bulanan()
    {
        $siswa_id           = $this->request->getVar('siswa');
        $keterangan         = $this->request->getVar('keterangan');
        $bayar              = $this->request->getVar('bayar');
        $total              = 0;
        $pembayaran_detail  = [];
        $db                 = \Config\Database::connect();
        $siswa              = $db->query("SELECT id, nama, kelas, kategori FROM tbl_siswa WHERE status = 1 AND id = '$siswa_id'")->getRowArray();

        if (!$siswa) {
            $db->close();
            return $this->failNotFound('Siswa tidak ditemukan');
        }

        $kelas              = $siswa['kelas'];
        $kategori           = $siswa['kategori'];

        if (count($bayar) > 0) {
            foreach ($bayar as $periode => $d_bayar) {
                foreach ($d_bayar as $id => $nominal) {
                    $pembayaran_detail[] = [
                        'biaya'     => $id,
                        'nominal'   => $nominal,
                        'periode'   => $periode
                    ];

                    $total += (int) $nominal;
                }
            }
        } else {
            return $this->failServerError('Item wajib ada!');
        }

        $pembayaran     = [
            'siswa'         => $siswa_id,
            'kelas'         => $kelas,
            'kategori'      => $kategori,
            'keterangan'    => $keterangan,
            'total'         => $total,
        ];
        $id = 0;
        try {
            $db->transException(true)->transStart();
            $db->table('tbl_pembayaran')->insert($pembayaran);
            $id = $db->insertID();
            $db->transComplete();

            foreach ($pembayaran_detail as $key => $value) {
                $pembayaran_detail[$key]['pembayaran'] = $id;
            }

            $db->table('tbl_pembayaran_detail')->insertBatch($pembayaran_detail);
            $db->transComplete();
        } catch (DatabaseException $e) {
            $db->transRollback();
            $db->close();
            return $this->failServerError($e);
        }
        $db->close();

        $response   = [
            'status'    => 200,
            'error'     => null,
            'messages'  => [
                'success'   => 'Berhasil Membayar Tagihan'
            ],
            'data'      => [
                'id' => $id
            ]
        ];

        return $this->respondCreated($response);
    }

    public function bayar_lainnya()
    {
        $siswa_id           = $this->request->getVar('siswa');
        $keterangan         = $this->request->getVar('keterangan');
        $bayar              = $this->request->getVar('bayar');
        $total              = 0;
        $pembayaran_detail  = [];
        $db                 = \Config\Database::connect();
        $siswa              = $db->query("SELECT id, nama, kelas, kategori FROM tbl_siswa WHERE status = 1 AND id = '$siswa_id'")->getRowArray();

        if (!$siswa) {
            $db->close();
            return $this->failNotFound('Siswa tidak ditemukan');
        }

        $kelas              = $siswa['kelas'];
        $kategori           = $siswa['kategori'];

        if (count($bayar) > 0) {
            foreach ($bayar as $id => $nominal) {
                $pembayaran_detail[] = [
                    'biaya'     => $id,
                    'nominal'   => $nominal,
                    'periode'   => null
                ];

                $total += (int) $nominal;
            }
        } else {
            return $this->failServerError('Item wajib ada!');
        }

        $pembayaran     = [
            'siswa'         => $siswa_id,
            'kelas'         => $kelas,
            'kategori'      => $kategori,
            'keterangan'    => $keterangan,
            'total'         => $total,
        ];

        $id = 0;
        try {
            $db->transException(true)->transStart();
            $db->table('tbl_pembayaran')->insert($pembayaran);
            $id = $db->insertID();
            $db->transComplete();

            foreach ($pembayaran_detail as $key => $value) {
                $pembayaran_detail[$key]['pembayaran'] = $id;
            }

            $db->table('tbl_pembayaran_detail')->insertBatch($pembayaran_detail);
            $db->transComplete();
        } catch (DatabaseException $e) {
            $db->transRollback();
            $db->close();
            return $this->failServerError($e);
        }
        $db->close();

        $response   = [
            'status'    => 200,
            'error'     => null,
            'messages'  => [
                'success'   => 'Berhasil Membayar Tagihan'
            ],
            'data'      => [
                'id' => $id
            ]
        ];

        return $this->respondCreated($response);
    }

    public function detail($id = '')
    {
        $data          = $this->model
            ->select('tbl_pembayaran.*, tbl_siswa.nama as nama, CONCAT(tbl_kelas.level, \' \', tbl_kelas.kode) as kode_kelas')
            ->join('tbl_siswa', 'tbl_pembayaran.siswa = tbl_siswa.id', 'left')
            ->join('tbl_kelas', 'tbl_pembayaran.kelas = tbl_kelas.id', 'left')
            ->where('tbl_pembayaran.status', 1)
            ->where('tbl_pembayaran.id', $id)
            ->get()
            ->getRowArray();

        if (!$data) {
            return $this->failNotFound('Data tidak ditemukan');
        }

        $detailPembayaran = new PembayaranDetailModel();
        $data['detail'] = $detailPembayaran
            ->select('tbl_pembayaran_detail.*, tbl_jenis.nama')
            ->join('tbl_biaya', 'tbl_biaya.id = tbl_pembayaran_detail.biaya')
            ->join('tbl_jenis', 'tbl_jenis.id = tbl_biaya.jenis')
            ->where('pembayaran', $id)
            ->get()
            ->getResultArray() ?? [];

        $data['tanggal'] = date("d M Y H:i", strtotime($data['tanggal']));
        $data['total'] = number_format($data['total']);

        foreach ($data['detail'] as $key => $value) {
            $data['detail'][$key]['keterangan'] = $value['nama'] . ' ' . ($value['periode'] ? date('M Y', strtotime($value['periode'])) : '');
            $data['detail'][$key]['nominal'] = number_format($value['nominal']);
        }

        return $this->respond($data);
    }


    // Delete Data
    public function delete($id = null)
    {
        $id         = $this->request->getVar('id');
        $data       = $this->model->where('id', $id)->first();

        if (!$data) {
            return $this->failNotFound('Pembayaran Tidak Ditemukan');
        }

        $this->model->update($id, ['status' => 0]);

        $response   = [
            'status'    => 200,
            'error'     => null,
            'messages'  => [
                'success'   => 'Berhasil Menghapus Pembayaran'
            ]
        ];
        return $this->respondCreated($response);
    }
}
