<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Risiko Bencana Kabupaten Cilacap</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
</head>
<body>
    <?= $this->include('template/navbar'); ?>
    <div class="container mt-5">
        <h2>Data Laporan Bencana Gempa Bumi</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nomor Kejadian</th>
                    <th>Jenis Kejadian</th>
                    <th>Waktu Kejadian</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                    <th>Kronologi Kejadian</th>
                    <th>Jumlah Pengungsi</th>
                    <th>Gambar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reports as $report): ?>
                    <tr>
                        <td><?= $report['nomor']; ?></td>
                        <td><?= $report['jenis']; ?></td>
                        <td><?= $report['waktu']; ?></td>
                        <td><?= $report['latitude']; ?></td>
                        <td><?= $report['longitude']; ?></td>
                        <td><?= $report['kronologi']; ?></td>
                        <td><?= $report['pengungsi']; ?></td>
                        <td><img src="/uploads/<?= $report['upload']; ?>" alt="Gambar Laporan" width="100"></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="main.js"></script>
</body>
</html>
