<?php
namespace App\Repositories;
use App\Models\CategoryModel;
class CategoryRepository
{
    public function __construct(private CategoryModel $categories = new CategoryModel())
    {
    }
    public function active(): array
    {
        return $this->categories->where('is_active', 1)->findAll();
    }
    public function all(): array
    {
        return $this->categories->orderBy('id', 'DESC')->findAll();
    }
    public function save(array $data, ?int $id = null): bool
    {
        return $id ? $this->categories->update($id, $data) : (bool) $this->categories->insert($data);
    }
}
