<?php
namespace App\Controllers;
use App\Repositories\{ProductRepository, CategoryRepository};
use App\Services\{CartService, OrderService};
class Store extends BaseController
{
    private function identity(): array
    {
        $s = session();
        return [(int) ($s->get('user.id') ?: 0) ?: null, $s->get('cart_key') ?: $this->newKey()];
    }
    private function newKey(): string
    {
        $k = bin2hex(random_bytes(20));
        session()->set('cart_key', $k);
        return $k;
    }
    public function index()
    {
        return view('store/home', ['products' => (new ProductRepository())->active($this->request->getGet('q')), 'categories' => (new CategoryRepository())->active()]);
    }
    public function cart()
    {
        [$u, $k] = $this->identity();
        $cart = (new CartService())->cart($u, $k);
        return view('store/cart', ['content' => (new CartService())->contents($cart)]);
    }
    public function addCart($id)
    {
        try {
            [$u, $k] = $this->identity();
            $svc = new CartService();
            $cart = $svc->cart($u, $k);
            $svc->add($cart, (int) $id, (int) ($this->request->getPost('quantity') ?: 1));
            if ($this->request->isAJAX())
                return $this->response->setJSON(['ok' => true, 'message' => 'Added to cart.', 'count' => array_sum(array_column($svc->contents($cart)['items'], 'quantity'))]);
            return redirect()->back()->with('success', 'Added to cart.');
        } catch (\Throwable $e) {
            if ($this->request->isAJAX())
                return $this->response->setStatusCode(422)->setJSON(['ok' => false, 'message' => $e->getMessage()]);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function updateCart($id)
    {
        try {
            [$u, $k] = $this->identity();
            $svc = new CartService();
            $cart = $svc->cart($u, $k);
            $svc->update($cart, (int) $id, (int) $this->request->getPost('quantity'));
            $c = $svc->contents($cart);
            if ($this->request->isAJAX())
                return $this->response->setJSON(['ok' => true, 'message' => 'Cart updated.', 'count' => array_sum(array_column($c['items'], 'quantity')), 'total' => $c['total']]);
            return redirect()->to('/cart')->with('success', 'Cart updated.');
        } catch (\Throwable $e) {
            if ($this->request->isAJAX())
                return $this->response->setStatusCode(422)->setJSON(['ok' => false, 'message' => $e->getMessage()]);
            return redirect()->to('/cart')->with('error', $e->getMessage());
        }
    }
    public function checkout()
    {
        [$u, $k] = $this->identity();
        $svc = new CartService();
        return view('store/checkout', ['content' => $svc->contents($svc->cart($u, $k))]);
    }
    public function placeOrder()
    {
        try {
            [$u, $k] = $this->identity();
            $cart = (new CartService())->cart($u, $k);
            $order = (new OrderService())->checkout($cart, $u, $this->request->getPost());
            return redirect()->to('/order/' . $order['order_number'])->with('success', 'Order placed successfully.');
        } catch (\Throwable $e) {
            return redirect()->to('/checkout')->with('error', $e->getMessage());
        }
    }
    public function order($number)
    {
        $o = (new \App\Models\OrderModel())->where('order_number', $number)->first();
        if (!$o)
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        return view('store/order', ['order' => $o]);
    }
}
