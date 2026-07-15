<?php
namespace App\Filters;
use App\Services\AuthService;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
class ApiAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $header = $request->getHeaderLine('Authorization');
        $user = (new AuthService())->userFromToken(preg_replace('/^Bearer\s+/i', '', $header));
        if (!$user)
            return service('response')->setStatusCode(401)->setJSON(['status' => false, 'message' => 'Valid Bearer token required']);
        service('request')->user = $user;
    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
