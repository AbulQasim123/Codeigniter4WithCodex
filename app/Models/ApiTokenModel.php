<?php
namespace App\Models;
class ApiTokenModel extends BaseModel
{
    protected $table = 'api_tokens';
    protected $useTimestamps = false;
    protected $allowedFields = ['user_id', 'token', 'expires_at', 'created_at'];
}
