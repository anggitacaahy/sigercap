<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'email', 'password', 'role'];
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getUserByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    public function isAdmin($userId)
    {
        $user = $this->find($userId);
        return $user && $user['role'] === 'admin';
    }
    public function getUserCount()
    {
        return $this->countAllResults();
    }
}
