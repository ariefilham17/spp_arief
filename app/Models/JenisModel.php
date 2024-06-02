<?php

namespace App\Models;

use CodeIgniter\Model;

class JenisModel extends Model
{
    protected $table        = 'tbl_jenis';
    protected $primaryKey   = 'id';

    protected $useAutoIncrement = true;
    protected $allowedFields    = ['id', 'tipe', 'nama', 'deskripsi', 'is_bulanan', 'status'];
}
