<?php

namespace App\Models;

use CodeIgniter\Model;

class AdministratorModel extends Model
{
    protected $table        = 'tbl_administrator';
    protected $primaryKey   = 'id';

    protected $useAutoIncrement = true;
    protected $allowedFields    = ['id', 'nama', 'user', 'pass', 'role', 'akses', 'status'];
}
