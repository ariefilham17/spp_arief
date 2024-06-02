<?php

namespace App\Models;

use CodeIgniter\Model;

class PembayaranDetailModel extends Model
{
    protected $table        = 'tbl_pembayaran_detail';
    protected $primaryKey   = 'id';

    protected $useAutoIncrement = true;
    protected $allowedFields    = ['id', 'periode', 'pembayaran', 'biaya', 'nominal'];
}
