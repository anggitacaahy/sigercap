<?php

namespace App\Controllers;

use App\Models\ReportModel;
use CodeIgniter\Controller;

class ReportController extends Controller
{
    public function submitReport()
    {
        $session = session();
        $username = $session->get('username');

        $reportModel = new ReportModel();

        // Validasi input
        $validated = $this->validate([
            'nomor' => 'required',
            'jenis' => 'required',
            'waktu' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'kronologi' => 'required',
            'pengungsi' => 'required',
            'upload' => 'uploaded[upload]|is_image[upload]',
        ]);

        if (!$validated) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Upload file
        $file = $this->request->getFile('upload');
        if (!$file->isValid()) {
            return redirect()->back()->withInput()->with('errors', 'File upload failed.');
        }

        $fileName = $file->getName();
        if (!$file->move(FCPATH . 'image', $fileName)) {
            return redirect()->back()->withInput()->with('errors', 'File move failed.');
        }

        // Simpan data ke database
        $reportModel->save([
            'nomor' => $this->request->getPost('nomor'),
            'jenis' => $this->request->getPost('jenis'),
            'waktu' => $this->request->getPost('waktu'),
            'latitude' => $this->request->getPost('latitude'),
            'longitude' => $this->request->getPost('longitude'),
            'kronologi' => $this->request->getPost('kronologi'),
            'pengungsi' => $this->request->getPost('pengungsi'),
            'image_path' => $fileName,
            'username' => $username, // Save the username with the report
        ]);

        return redirect()->back()->with('status', 'Laporan berhasil dikirim.');
    }

    public function reportList()
    {
        $reportModel = new ReportModel();
        $data['reports'] = $reportModel->findAll();

        return view('v_report_list', $data);
    }

    public function userReport()
    {
        $session = session();
        $username = $session->get('username');

        $reportModel = new ReportModel();
        $data['reports'] = $reportModel->where('username', $username)->findAll();

        return view('v_user_report', $data);
    }

}
