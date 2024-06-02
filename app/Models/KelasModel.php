<?php

namespace App\Models;

use CodeIgniter\Model;

class KelasModel extends Model
{
    protected $table        = 'tbl_kelas';
    protected $primaryKey   = 'id';

    protected $useAutoIncrement = true;
    protected $allowedFields    = ['id', 'kode', 'jurusan', 'level', 'status'];
}
