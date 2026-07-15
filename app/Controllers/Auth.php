<?php
namespace App\Controllers;
use App\Services\{AuthService, AuditService};
use App\Models\UserModel;
class Auth extends BaseController
{
    private function active(): array
    {
        return session('admin_user') ?: session('user') ?: [];
    }
    private function key(): string
    {
        return session('admin_user') ? 'admin_user' : 'user';
    }
    public function login()
    {
        return view('auth/login');
    }
    public function register()
    {
        return view('auth/register');
    }
    public function create()
    {
        if (!$this->validateData($this->request->getPost(), ['name' => 'required|min_length[2]', 'email' => 'required|valid_email', 'password' => 'required|min_length[8]']))
            return view('auth/register', ['errors' => $this->validator->getErrors()]);
        try {
            (new AuthService())->register($this->request->getPost());
            return redirect()->to('/login')->with('success', 'Account created. Please sign in.');
        } catch (\Throwable $e) {
            return view('auth/register', ['errors' => ['email' => $e->getMessage()]]);
        }
    }
    public function attempt()
    {
        if (!$this->validateData($this->request->getPost(), ['email' => 'required|valid_email', 'password' => 'required']))
            return view('auth/login', ['errors' => $this->validator->getErrors()]);
        $u = (new AuthService())->login((string) $this->request->getPost('email'), (string) $this->request->getPost('password'));
        if (!$u || $u['is_blocked'])
            return view('auth/login', ['errors' => ['email' => $u ? 'Your account is blocked.' : 'Invalid email or password.']]);
        $i = ['id' => $u['id'], 'name' => $u['name'], 'role' => $u['role'], 'email' => $u['email'], 'profile_image' => $u['profile_image']];
        if ($u['role'] === 'admin') {
            session()->set('admin_user', $i);
            (new AuditService())->log('admin.login', 'Admin signed in', $u['id']);
            return redirect()->to('/admin');
        }
        session()->set('user', $i);
        (new AuditService())->log('auth.login', 'Customer signed in', $u['id']);
        return redirect()->to('/');
    }
    public function logout()
    {
        session()->remove('user');
        return redirect()->to('/');
    }
    public function adminLogout()
    {
        session()->remove('admin_user');
        return redirect()->to('/login');
    }
    public function profile()
    {
        if (!session('user') && !session('admin_user'))
            return redirect()->to('/login');
        return view(session('admin_user') ? 'auth/admin_profile' : 'auth/profile', ['profile' => (new UserModel())->find($this->active()['id'])]);
    }
    public function profileUpdate()
    {
        if (!$this->validateData($this->request->getPost(), ['name' => 'required|min_length[2]']))
            return redirect()->back()->with('errors', $this->validator->getErrors());
        $key = $this->key();
        (new UserModel())->update($this->active()['id'], ['name' => $this->request->getPost('name')]);
        session()->set($key . '.name', $this->request->getPost('name'));
        return redirect()->back()->with('success', 'Profile updated.');
    }
    public function passwordUpdate()
    {
        if (!$this->validateData($this->request->getPost(), ['current_password' => 'required', 'password' => 'required|min_length[8]']))
            return redirect()->back()->with('errors', $this->validator->getErrors());
        $u = (new UserModel())->find($this->active()['id']);
        if (!password_verify($this->request->getPost('current_password'), $u['password_hash']))
            return redirect()->back()->with('errors', ['current_password' => 'Current password is incorrect.']);
        (new UserModel())->update($u['id'], ['password_hash' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT)]);
        return redirect()->back()->with('success', 'Password updated.');
    }
}
