<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/analisis', 'Home::analisis');
$routes->get('/risiko', 'Home::risiko');
$routes->get('/laporan', 'Objek::formlapor');
$routes->get('profile', 'Objek::profile');
$routes->get('/mitigasi', 'Home::mitigasi');
$routes->get('/gempa', 'Home::gempa');
$routes->get('/epicentre', 'Home::epicentre');
$routes->get('/register', 'Objek::register');
$routes->post('/register', 'Objek::store');
$routes->get('/login', 'Objek::login');
$routes->post('/login', 'Objek::authenticate');
$routes->get('/logout', 'Objek::logout');
$routes->get('/main', 'Home::main');
$routes->get('/data', 'Home::data');
$routes->get('/epicentre', 'Home::epicentre');

$routes->post('/submit_report', 'ReportController::submitReport');
$routes->get('/report-list', 'ReportController::reportList');
$routes->get('/user-report', 'ReportController::userReport');

$routes->get('/admin/dashboard', 'Admin::index');
$routes->get('/admin/downloadPDF', 'Admin::downloadPDF');
