<?php
namespace App\Services;
use App\Models\{CartModel, CartItemModel, ProductModel};
class CartService
{
    public function __construct(private CartModel $carts = new CartModel(), private CartItemModel $items = new CartItemModel(), private ProductModel $products = new ProductModel())
    {
    }
    public function cart(?int $userId, string $key): array
    {
        $b = $this->carts->where('status', 'active');
        $cart = $userId ? $b->where('user_id', $userId)->first() : $b->where('session_key', $key)->first();
        if (!$cart) {
            $id = $this->carts->insert(['user_id' => $userId, 'session_key' => $key]);
            $cart = $this->carts->find($id);
        }
        return $cart;
    }
    public function contents(array $cart): array
    {
        $rows = $this->items->select('cart_items.*,products.name,products.price,products.sale_price,products.stock,products.image')->join('products', 'products.id=cart_items.product_id')->where('cart_id', $cart['id'])->findAll();
        $total = 0;
        foreach ($rows as &$r) {
            $r['unit_price'] = (float) ($r['sale_price'] ?: $r['price']);
            $r['line_total'] = $r['unit_price'] * $r['quantity'];
            $total += $r['line_total'];
        }
        return ['items' => $rows, 'total' => $total];
    }
    public function add(array $cart, int $productId, int $quantity): void
    {
        $p = $this->products->find($productId);
        if (!$p || !$p['is_active'])
            throw new \RuntimeException('Product is not available.');
        if ($quantity < 1 || $quantity > $p['stock'])
            throw new \RuntimeException('Requested quantity is not in stock.');
        $existing = $this->items->where(['cart_id' => $cart['id'], 'product_id' => $productId])->first();
        $new = $quantity + ($existing['quantity'] ?? 0);
        if ($new > $p['stock'])
            throw new \RuntimeException('Not enough stock.');
        $existing ? $this->items->update($existing['id'], ['quantity' => $new]) : $this->items->insert(['cart_id' => $cart['id'], 'product_id' => $productId, 'quantity' => $quantity]);
    }
    public function update(array $cart, int $itemId, int $quantity): void
    {
        $item = $this->items->where(['id' => $itemId, 'cart_id' => $cart['id']])->first();
        if (!$item)
            throw new \RuntimeException('Cart item not found.');
        if ($quantity <= 0) {
            $this->items->delete($itemId);
            return;
        }
        $p = $this->products->find($item['product_id']);
        if ($quantity > $p['stock'])
            throw new \RuntimeException('Not enough stock.');
        $this->items->update($itemId, ['quantity' => $quantity]);
    }
}
