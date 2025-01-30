<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= base_url('css/main.css') ?>"> <!-- Optional custom CSS -->
    <style>
        :root {
            --main-color: #5f160c; /* Warna utama */
            --second-color: #ffffff; /* Warna sekunder */
            --third-color: #ca3305; /* Warna ketiga */
            --four-color: #381414; /* Warna keempat */
        }

        body {
            background-color: var(--second-color);
            color: var(--main-color);
            font-family: Arial, sans-serif;
        }

        h2, h4 {
            color: var(--main-color);
            margin-bottom: 20px;
        }

        .card {
            background-color: var(--main-color);
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            color: var(--second-color);
            margin-bottom: 20px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }

        .card-header {
            background-color: white;
            color: var(--main-color);
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            padding: 10px;
            text-align: center;
            font-size: 1.2rem;
            font-weight: bold;
        }

        .card-body {
            padding: 20px;
            text-align: center;

        }

        .card-body p {
            font-size: 2.5rem;
            margin: 0;
            color: #ffffff;
        }

        .btn-info {
            background-color: var(--third-color);
            border-color: var(--third-color);
        }

        .btn-info:hover {
            background-color: #b82b04;
            border-color: #b82b04;
        }

        table thead {
            background-color: var(--main-color);
            color: var(--second-color);
        }

        table tbody tr:hover {
            background-color: rgba(95, 22, 12, 0.1);
        }

        .breadcrumb {
            background-color: var(--second-color);
            margin-bottom: 20px;
        }

        .breadcrumb-item + .breadcrumb-item::before {
            color: var(--main-color);
        }

        .table {
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .table thead th {
            background-color: var(--main-color);
            color: var(--second-color);
        }

        .table tbody tr {
            transition: background-color 0.3s;
        }

        .table tbody tr:hover {
            background-color: rgba(95, 22, 12, 0.1);
        }

        .btn-download {
            background-color: var(--main-color);
            border: none;
            color: var(--second-color);
        }

        .btn-download:hover {
            background-color: #381414;
        }

        /* Media Queries for Responsiveness */
        @media (max-width: 1200px) {
            .card-body p {
                font-size: 2rem;
            }

            .card-header {
                font-size: 1.1rem;
            }

            h2, h4 {
                font-size: 1.75rem;
            }
        }

        @media (max-width: 992px) {
            .card-body p {
                font-size: 1.75rem;
            }

            .card-header {
                font-size: 1rem;
            }

            h2, h4 {
                font-size: 1.5rem;
            }

            .table th, .table td {
                font-size: 0.875rem;
            }
        }

        @media (max-width: 768px) {
            .card-body p {
                font-size: 1.5rem;
            }

            .card-header {
                font-size: 0.9rem;
                padding: 10px;
            }

            h2, h4 {
                font-size: 1.25rem;
            }

            .btn-download {
                font-size: 0.875rem;
                padding: 8px 16px;
            }
        }

        @media (max-width: 576px) {
            .card-body p {
                font-size: 1.25rem;
            }

            .card-header {
                font-size: 0.75rem;
                padding: 8px;
            }

            h2, h4 {
                font-size: 1rem;
            }

            .btn-download {
                font-size: 0.75rem;
                padding: 6px 12px;
            }
        }
    </style>
</head>
<body>
    <?= $this->include('template/navbar'); ?> <!-- Navbar -->

    <div class="container mt-5">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard Admin</li>
            </ol>
        </nav>

        <h2 class="text-center">Dashboard Admin</h2>

        <div class="row mt-4 justify-content-center">
            <!-- Statistik -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-center">
                        <i class="bi bi-file-earmark-text me-2"></i> Jumlah Laporan
                    </div>
                    <div class="card-body">
                        <p><?= $reportCount ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-center">
                        <i class="bi bi-person-circle me-2"></i> Jumlah Pengguna
                    </div>
                    <div class="card-body">
                        <p><?= $userCount ?></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Tabel Laporan -->
        <div class="mt-4">
            <h4 class="text-center">Rincian Laporan</h4>
            <table class="table table-striped">
                <thead class="text-center">
                    <tr>
                        <th>ID</th>
                        <th>Jenis Kejadian</th>
                        <th>Waktu</th>
                        <th>Lokasi</th>
                        <th>Kronologi</th>
                        <th>Pengungsi</th>
                        <th>Gambar</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php if (!empty($reports)) : ?>
                        <?php foreach ($reports as $index => $report) : ?>
                            <tr>
                                <td><?= $index + 1 ?></td> 
                                <td><?= esc($report['jenis']) ?></td>
                                <td><?= esc($report['waktu']) ?></td>
                                <td><?= esc($report['latitude']) ?>, <?= esc($report['longitude']) ?></td>
                                <td><?= esc($report['kronologi']) ?></td>
                                <td><?= esc($report['pengungsi']) ?></td>
                                <td>
                                    <img src="<?= base_url('image/' . $report['image_path']) ?>" alt="Gambar Kejadian" width="100">
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada laporan tersedia.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Tabel Pengguna -->
        <div class="mt-4">
            <h4 class="text-center">Rincian Pengguna</h4>
            <table class="table table-striped">
                <thead class="text-center">
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Tanggal Pendaftaran</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php if (!empty($users)) : ?>
                        <?php foreach ($users as $index => $user) : ?>
                            <tr>
                                <td><?= $index + 1 ?></td> 
                                <td><?= esc($user['username']) ?></td>
                                <td><?= esc($user['email']) ?></td>
                                <td><?= esc($user['created_at']) ?></td>
                                <td><?= esc($user['role']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada pengguna tersedia.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
