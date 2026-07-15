<?php
namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $admin = session('admin_user');
        if (!$admin || $admin['role'] !== 'admin')
            return redirect()->to('/login')->with('error', 'Admin access required.');
    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
