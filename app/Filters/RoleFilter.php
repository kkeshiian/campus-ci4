<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $requiredRole = $arguments[0] ?? null;

        if (!session('id_user')) {
            return redirect()->to('/auth/login');
        }

        if (!session('Role') || strtolower(session('Role')) !== strtolower($requiredRole)) {
            return service('response')
                ->setStatusCode(403)
                ->setBody("Access Denied. You don't have permission to access this page.");
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
