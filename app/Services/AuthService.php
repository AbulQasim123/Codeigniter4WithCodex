<?php
namespace App\Services;
use App\Models\UserModel;
use App\Models\ApiTokenModel;
class AuthService
{
    public function __construct(private UserModel $users = new UserModel(), private ApiTokenModel $tokens = new ApiTokenModel())
    {
    }
    public function register(array $data, string $role = 'customer'): array
    {
        if ($this->users->where('email', $data['email'])->first())
            throw new \RuntimeException('Email is already registered.');
        $id = $this->users->insert(['name' => $data['name'], 'email' => $data['email'], 'password_hash' => password_hash($data['password'], PASSWORD_DEFAULT), 'role' => $role]);
        return $this->users->find($id);
    }
    public function login(string $email, string $password): ?array
    {
        $user = $this->users->where('email', $email)->first();
        return $user && password_verify($password, $user['password_hash']) ? $user : null;
    }
    public function issueToken(int $userId): string
    {
        $token = bin2hex(random_bytes(48));
        $this->tokens->insert(['user_id' => $userId, 'token' => hash('sha256', $token), 'expires_at' => date('Y-m-d H:i:s', strtotime('+30 days')), 'created_at' => date('Y-m-d H:i:s')]);
        return $token;
    }
    public function userFromToken(?string $token): ?array
    {
        if (!$token)
            return null;
        $row = $this->tokens->where('token', hash('sha256', $token))->where('expires_at >=', date('Y-m-d H:i:s'))->first();
        return $row ? $this->users->find($row['user_id']) : null;
    }
}
