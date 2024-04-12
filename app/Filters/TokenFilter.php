<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use \Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Config\Services;

class TokenFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $headers = $request->getHeaders();
        if (!isset($headers['Authorization'])) {
            return Services::response()
                ->setStatusCode(401)
                ->setJSON(['message' => 'Unauthorized']);
        }
        $token = $headers['Authorization']->getValue();
        if (!$token) {
            return Services::response()
                ->setStatusCode(401)
                ->setJSON(['message' => 'Unauthorized']);
        }
        $token = str_replace('Bearer ', '', $token);
        try {
            $decoded = JWT::decode($token, new Key(getenv('JWT_SECRET'), 'HS256'));
            return request();
        } catch (\Firebase\JWT\ExpiredException $e) {
            return Services::response()
                ->setStatusCode(401)
                ->setJSON(['message' => 'Token has expired']);
        } catch (\Exception $e) {
            return Services::response()
                ->setStatusCode(401)
                ->setJSON(['message' => 'Invalid token']);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
