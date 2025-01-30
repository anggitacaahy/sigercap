<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('index');
    }
    public function analisis()
    {
        return view('v_analisis.php');
    }
    public function risiko()
    {
        return view('v_risiko.php');
    }
    public function laporan()
    {
        return view('v_laporan.php');
    }
    public function profile()
    {
        return view('v_profile.php');
    }
    public function mitigasi()
    {
        return view('v_mitigasi.php');
    }
    public function main()
    {
        return view('template/main.php');
    }
    public function gempa()
    {
        return view('v_gempa.php');
    }
    public function epicentre()
    {
        return view('v_epicentre.php');
    }
    public function data()
    {
        return view('v_data.php');
    }

}
