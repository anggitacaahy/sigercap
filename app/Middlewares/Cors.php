<?php

namespace App\Middlewares;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Middleware\Middleware;

class Cors extends Middleware
{
    public function handle(RequestInterface $request, ResponseInterface $response, $next)
    {
        // Set header untuk mengizinkan akses dari semua origin
        $response = $response->setHeader('Access-Control-Allow-Origin', '*')
                             ->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE')
                             ->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization')
                             ->setHeader('Access-Control-Max-Age', '3600');

        // Lanjutkan proses request
        $response = $next($request, $response);

        return $response;
    }
}
