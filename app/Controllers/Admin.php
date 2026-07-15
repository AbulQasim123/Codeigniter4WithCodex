<?php
namespace App\Controllers;
use App\Models\{OrderModel, UserModel, ActivityLogModel};
use App\Repositories\{ProductRepository, CategoryRepository};
use App\Services\AuditService;
class Admin extends BaseController
{
    private function ok(array $data = [], string $message = 'Saved successfully.')
    {
        return $this->response->setJSON(['ok' => true, 'message' => $message] + $data);
    }
    private function fail(array $errors, int $code = 422)
    {
        return $this->response->setStatusCode($code)->setJSON(['ok' => false, 'errors' => $errors]);
    }
    private function valid(array $rules): array|bool
    {
        if (!$this->validateData($this->request->getPost(), $rules))
            return $this->fail($this->validator->getErrors());
        return true;
    }
    public function dashboard()
    {
        return view('admin/dashboard', ['products' => count((new ProductRepository())->all()), 'orders' => count((new OrderModel())->findAll()), 'customers' => count((new UserModel())->where('role', 'customer')->findAll())]);
    }
    public function products()
    {
        return view('admin/products', ['products' => (new ProductRepository())->all(), 'categories' => (new CategoryRepository())->all()]);
    }
    public function productSave()
    {
        if (($v = $this->valid(['name' => 'required|min_length[2]', 'category_id' => 'required|is_natural_no_zero', 'sku' => 'required|min_length[2]', 'price' => 'required|decimal', 'stock' => 'required|integer'])) !== true)
            return $v;
        $d = $this->request->getPost();
        $d['slug'] = url_title($d['name'], '-', true);
        try {
            $id = (int) ($d['id'] ?? 0);
            (new ProductRepository())->save($d, $id ?: null);
            (new AuditService())->log($id ? 'product.updated' : 'product.created', 'Product: ' . $d['name']);
            return $this->ok(['products' => (new ProductRepository())->all()], 'Product saved.');
        } catch (\Throwable $e) {
            return $this->fail(['sku' => $e->getMessage()]);
        }
    }
    public function productDelete($id)
    {
        (new \App\Models\ProductModel())->delete((int) $id);
        (new AuditService())->log('product.deleted', 'Product ID: ' . $id);
        return $this->ok(['products' => (new ProductRepository())->all()], 'Product deleted.');
    }
    public function categories()
    {
        return view('admin/categories', ['categories' => (new CategoryRepository())->all()]);
    }
    public function categorySave()
    {
        if (($v = $this->valid(['name' => 'required|min_length[2]'])) !== true)
            return $v;
        $d = $this->request->getPost();
        $d['slug'] = url_title($d['name'], '-', true);
        try {
            $id = (int) ($d['id'] ?? 0);
            (new CategoryRepository())->save($d, $id ?: null);
            (new AuditService())->log($id ? 'category.updated' : 'category.created', 'Category: ' . $d['name']);
            return $this->ok(['categories' => (new CategoryRepository())->all()], 'Category saved.');
        } catch (\Throwable $e) {
            return $this->fail(['name' => $e->getMessage()]);
        }
    }
    public function categoryDelete($id)
    {
        (new \App\Models\CategoryModel())->delete((int) $id);
        (new AuditService())->log('category.deleted', 'Category ID: ' . $id);
        return $this->ok(['categories' => (new CategoryRepository())->all()], 'Category deleted.');
    }
    public function orders()
    {
        return view('admin/orders', ['orders' => (new OrderModel())->orderBy('id', 'DESC')->findAll()]);
    }
    public function status($id)
    {
        if (($v = $this->valid(['status' => 'required|in_list[pending,processing,shipped,delivered,cancelled]'])) !== true)
            return $v;
        (new OrderModel())->update((int) $id, ['status' => $this->request->getPost('status')]);
        (new AuditService())->log('order.status', 'Order #' . $id . ' → ' . $this->request->getPost('status'));
        return $this->ok([], 'Order status updated.');
    }
    public function users()
    {
        return view('admin/users', ['users' => (new UserModel())->where('role', 'customer')->findAll()]);
    }
    public function userBlock($id)
    {
        $user = (new UserModel())->find((int) $id);
        if (!$user)
            return $this->fail(['user' => 'User not found'], 404);
        $blocked = $user['is_blocked'] ? 0 : 1;
        (new UserModel())->update((int) $id, ['is_blocked' => $blocked]);
        (new AuditService())->log('user.' . ($blocked ? 'blocked' : 'unblocked'), 'Customer: ' . $user['email']);
        return $this->ok(['blocked' => $blocked], 'Account ' . ($blocked ? 'blocked.' : 'unblocked.'));
    }
    public function logs()
    {
        return view('admin/logs', ['logs' => (new ActivityLogModel())->select('activity_logs.*, users.name')->join('users', 'users.id=activity_logs.user_id', 'left')->orderBy('activity_logs.id', 'DESC')->findAll(300)]);
    }
}
