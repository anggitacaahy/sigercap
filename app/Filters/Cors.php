<?php 
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Cors implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Mengatur header untuk mengizinkan semua asal (origin)
        header("Access-Control-Allow-Origin: *");
        // Mengatur metode yang diizinkan
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        // Mengatur header yang diizinkan
        header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

        // Menangani preflight request
        if ($request->getMethod() === 'OPTIONS') {
            header("HTTP/1.1 200 OK");
            exit();
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu melakukan apa-apa setelah request
    }
}

 ?>