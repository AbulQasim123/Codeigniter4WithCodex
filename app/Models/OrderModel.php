<?php
namespace App\Models;
class OrderModel extends BaseModel
{
    protected $table = 'orders';
    protected $allowedFields = ['user_id', 'order_number', 'customer_name', 'email', 'phone', 'address', 'total', 'status', 'payment_method'];
}
