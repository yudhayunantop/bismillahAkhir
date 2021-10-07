<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = "user_aplikasi";
    protected $primaryKey = "ID_USER";
    protected $allowedFields = ['USERNAME', 'PASSWORD'];

    public function getUser($username)
    {
            return $this->where([
                            'USERNAME' => $username,
                                ])
                            ->first();
    }
}