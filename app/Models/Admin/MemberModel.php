<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class MemberModel extends Model
{
    protected $table = 'member';
    protected $primaryKey = 'id';

    protected $autoIncrement = true;

    protected $returnType = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['nama_lengkap', 'email', 'telepon', 'alamat', 'deleted_at'];
}
