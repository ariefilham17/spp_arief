<?php

namespace App\Models;

use CodeIgniter\Model;

class BiayaModel extends Model
{
    protected $table        = 'tbl_biaya';
    protected $primaryKey   = 'id';

    protected $useAutoIncrement = true;
    protected $allowedFields    = ['id', 'jenis', 'kelas', 'kategori', 'nominal', 'status'];
}
