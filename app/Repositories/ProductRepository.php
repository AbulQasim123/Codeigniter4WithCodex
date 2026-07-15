<?php
namespace App\Repositories;
use App\Models\ProductModel;
class ProductRepository
{
    public function __construct(private ProductModel $products = new ProductModel())
    {
    }
    public function active(?string $search = null): array
    {
        $b = $this->products->select('products.*, categories.name category_name')->join('categories', 'categories.id=products.category_id')->where('products.is_active', 1);
        if ($search)
            $b->groupStart()->like('products.name', $search)->orLike('products.sku', $search)->groupEnd();
        return $b->orderBy('products.id', 'DESC')->findAll();
    }
    public function find(int $id): ?array
    {
        return $this->products->find($id);
    }
    public function save(array $data, ?int $id = null): bool
    {
        return $id ? $this->products->update($id, $data) : (bool) $this->products->insert($data);
    }
    public function all(): array
    {
        return $this->products->select('products.*, categories.name category_name')->join('categories', 'categories.id=products.category_id')->orderBy('products.id', 'DESC')->findAll();
    }
}
