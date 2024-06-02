<?php

namespace App\Models;

use CodeIgniter\Model;

class SiswaKategoriModel extends Model
{
    protected $table        = 'tbl_siswa_kategori';
    protected $primaryKey   = 'id';

    protected $useAutoIncrement = true;
    protected $allowedFields    = ['id', 'kode', 'nama', 'status'];
}
