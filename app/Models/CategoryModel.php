<?php
namespace App\Models;
class CategoryModel extends BaseModel
{
    protected $table = 'categories';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['name', 'slug', 'description', 'is_active'];
}
