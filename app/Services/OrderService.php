<?php
namespace App\Services;
use App\Models\{OrderModel, ProductModel, CartItemModel, CartModel};
class OrderService
{
    public function __construct(private OrderModel $orders = new OrderModel(), private ProductModel $products = new ProductModel(), private CartItemModel $items = new CartItemModel(), private CartModel $carts = new CartModel(), private CartService $cartService = new CartService())
    {
    }
    public function checkout(array $cart, ?int $userId, array $data): array
    {
        $content = $this->cartService->contents($cart);
        if (!$content['items'])
            throw new \RuntimeException('Your cart is empty.');
        $db = db_connect();
        $db->transStart();
        foreach ($content['items'] as $item) {
            $p = $this->products->find($item['product_id']);
            if ($p['stock'] < $item['quantity'])
                throw new \RuntimeException($p['name'] . ' is out of stock.');
            $this->products->update($p['id'], ['stock' => $p['stock'] - $item['quantity']]);
        }
        $number = 'ORD-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(3)));
        $id = $this->orders->insert(['user_id' => $userId, 'order_number' => $number, 'customer_name' => $data['customer_name'], 'email' => $data['email'], 'phone' => $data['phone'], 'address' => $data['address'], 'total' => $content['total'], 'payment_method' => $data['payment_method'] ?? 'cod']);
        foreach ($content['items'] as $item)
            $db->table('order_items')->insert(['order_id' => $id, 'product_id' => $item['product_id'], 'product_name' => $item['name'], 'price' => $item['unit_price'], 'quantity' => $item['quantity'], 'created_at' => date('Y-m-d H:i:s')]);
        $this->items->where('cart_id', $cart['id'])->delete();
        $this->carts->update($cart['id'], ['status' => 'converted']);
        $db->transComplete();
        if (!$db->transStatus())
            throw new \RuntimeException('Could not place order.');
        return $this->orders->find($id);
    }
}
