<?php
namespace App\Models;
class CartItemModel extends BaseModel
{
    protected $table = 'cart_items';
    protected $allowedFields = ['cart_id', 'product_id', 'quantity'];
}
