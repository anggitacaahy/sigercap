<?php

namespace App\Controllers;

use App\Models\ReportModel;
use App\Models\UserModel;
use CodeIgniter\Controller;

class Admin extends Controller
{
    protected $session;
    protected $reportModel;
    protected $userModel;

    public function __construct()
    {
        $this->session = session();
        $this->reportModel = new ReportModel();
        $this->userModel = new UserModel(); // Assuming you need user count as well
    }

    public function index()
    {
        // Pastikan hanya admin yang dapat mengakses
        if (!$this->session->get('logged_in') || $this->session->get('role') !== 'admin') {
            return redirect()->to('/');
        }

        // Count the number of reports
        $reportCount = $this->reportModel->countAll();

        // Count the number of users (optional, only if you need this)
        $userCount = $this->userModel->countAll();

        // Prepare data to pass to the view
        $data = [
            'reportCount' => $reportCount,
            'userCount' => $userCount, // Optional
            'reports' => $this->reportModel->findAll(),
            'users' => $this->userModel->findAll(),
        ];

        return view('admin/dashboard', $data);
    }
    
}
