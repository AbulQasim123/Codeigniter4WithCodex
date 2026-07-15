<?php
namespace App\Models;
class CartModel extends BaseModel
{
    protected $table = 'carts';
    protected $allowedFields = ['user_id', 'session_key', 'status'];
}
