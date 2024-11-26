<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'usr_id';
    protected $allowedFields = ['email', 'password', 'is_active', 'reset_token', 'reset_token_exp'];
}
