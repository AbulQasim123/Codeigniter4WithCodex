<?php
namespace App\Models;
class ProductModel extends BaseModel
{
    protected $table = 'products';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['category_id', 'name', 'slug', 'sku', 'description', 'price', 'sale_price', 'stock', 'image', 'is_active'];
}
