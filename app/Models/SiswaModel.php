<?php

namespace App\Models;

use CodeIgniter\Model;

class SiswaModel extends Model
{
    protected $table        = 'tbl_siswa';
    protected $primaryKey   = 'id';

    protected $useAutoIncrement = true;
    protected $allowedFields    = ['id', 'nama', 'nisn', 'jk', 'tempat_lahir', 'tanggal_lahir', 'kelas', 'kategori', 'status'];
}
