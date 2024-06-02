<?php

namespace App\Models;

use CodeIgniter\Model;

class JurusanModel extends Model
{
    protected $table        = 'tbl_jurusan';
    protected $primaryKey   = 'id';

    protected $useAutoIncrement = true;
    protected $allowedFields    = ['id', 'kode', 'status'];
}
