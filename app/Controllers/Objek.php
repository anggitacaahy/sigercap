<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\ReportModel;

class Objek extends BaseController
{
    public function register()
    {
        return view('auth/register');
    }

    public function store()
    {
        $validationRules = [
            'username' => 'required|min_length[3]|max_length[50]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]|max_length[255]',
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $userModel = new UserModel();
        $data = [
            'username' => $this->request->getVar('username'),
            'email'    => $this->request->getVar('email'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
        ];
        $userModel->save($data);
        return redirect()->to('/login');
    }

    public function login()
    {
        return view('auth/login');
    }

    public function authenticate()
    {
        $session = session();
        $userModel = new UserModel();
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        
        $data = $userModel->where('email', $email)->first();
    
        if ($data) {
            $pass = $data['password'];
            $authenticatePassword = password_verify($password, $pass);
            if ($authenticatePassword) {
                $ses_data = [
                    'id'       => $data['id'],
                    'username' => $data['username'],
                    'email'    => $data['email'],
                    'role'     => $data['role'],
                    'logged_in' => TRUE
                ];
                $session->set($ses_data);
                return redirect()->to('/admin/dashboard');
            } else {
                $session->setFlashdata('msg', 'Password Salah');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('msg', 'Email Tidak Ditemukan');
            return redirect()->to('/login');
        }
    }
    
    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }

    public function profile()
    {
        $session = session();

        // Check if the user is logged in
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userModel = new UserModel();
        $userId = $session->get('id');
        $data['user'] = $userModel->find($userId);

        return view('v_profile', $data);
    }

    public function formlapor()
    {
        $session = session();

        // Check if the user is logged in
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userModel = new UserModel();
        $userId = $session->get('id');
        $data['user'] = $userModel->find($userId);

        return view('v_laporan', $data);
    }

    public function dashboard()
    {
        $session = session();

        // Pastikan pengguna adalah admin
        if (!$session->get('logged_in') || $session->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        $userModel = new UserModel();
        $reportModel = new ReportModel();
        
        // Ambil data untuk dashboard
        $data['userCount'] = $userModel->countAllResults();
        $data['reportCount'] = $reportModel->countAllResults();
        $data['recentReports'] = $reportModel->orderBy('created_at', 'DESC')->findAll(5);

        return view('admin/dashboard', $data);
    }

/*     public function reports()
    {
        $reportModel = new ReportModel();
        $data['reports'] = $reportModel->findAll();

        return view('v_tabellaporan.php', $data);
    } */
}
