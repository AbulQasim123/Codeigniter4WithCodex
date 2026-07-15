<?php
namespace App\Controllers;
use App\Models\UserModel;
use App\Services\AuthService;
class AdminSetup extends BaseController
{
    public function register()
    {
        if ((new UserModel())->where('role', 'admin')->first())
            return redirect()->to('/login')->with('error', 'Admin setup has already been completed.');
        return view('auth/admin_register');
    }
    public function create()
    {
        try {
            if ((new UserModel())->where('role', 'admin')->first())
                throw new \RuntimeException('Admin setup has already been completed.');
            (new AuthService())->register($this->request->getPost(), 'admin');
            return redirect()->to('/login')->with('success', 'Admin account created. Sign in to manage your store.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
