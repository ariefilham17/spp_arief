<?php

namespace App\Models;

use CodeIgniter\Model;

class KeuanganModel extends Model
{
    protected $table        = 'tbl_keuangan';
    protected $primaryKey   = 'id';

    protected $useAutoIncrement = true;
    protected $allowedFields    = ['id', 'tanggal', 'jenis', 'deskripsi', 'kredit', 'debit', 'status',];
}
