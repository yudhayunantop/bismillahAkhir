<?php

namespace App\Models;

use CodeIgniter\Model;

class PersewaanModel extends Model
{
    protected $table = 'persewaan';
    protected $primaryKey = 'ID_PERSEWAAN';
    protected $allowedFields = ['ID_MESIN', 
                                'ID_USER', 
                                'ID_PERUSAHAAN',
                                'ID_PERSEWAAN_DETAIL'];

    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    protected $createdField  = 'CREATED_AT';
    protected $updatedField  = 'UPDATED_AT';
    protected $deletedField = 'DELETED_AT';

}
