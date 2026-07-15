<?php
namespace App\Models;
class UserModel extends BaseModel
{
    protected $table = 'users';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['name', 'email', 'password_hash', 'role', 'is_blocked', 'profile_image'];
}
