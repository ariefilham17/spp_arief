<?php

namespace App\Models;

use CodeIgniter\Model;

class PembayaranModel extends Model
{
    protected $table        = 'tbl_pembayaran';
    protected $primaryKey   = 'id';

    protected $useAutoIncrement = true;
    protected $allowedFields    = ['id', 'siswa', 'kelas', 'kategori', 'kode_bayar', 'tanggal', 'total', 'keterangan', 'status'];
}
