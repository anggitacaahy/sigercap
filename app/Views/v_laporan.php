<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Risiko Bencana Kabupaten Cilacap</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        #mapid {
        height: 350px;
        width: 100%;
        margin-top: 15px;
    }
    </style>
</head>
<body>
    <?= $this->include('template/navbar'); ?>
    <div class="container mt-5">
        <?php if(session()->getFlashdata('status')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('status') ?>
            </div>
        <?php endif; ?>
        <h2 style="text-align: center; color:black; margin-top:80px"> Form Pelaporan Kejadian</h2>
        <form action="/submit_report" method="POST" enctype="multipart/form-data" class="containerlapor">
            <div class="form-group">
                <label for="nomor">Nomor Kejadian:</label>
                <input type="text" class="form-control" id="nomor" name="nomor" required>
            </div>
            <div class="form-group">
                <label for="jenis">Jenis Kejadian:</label>
                <input type="text" class="form-control" id="jenis" name="jenis" required>
            </div>
            <div class="form-group">
                <label for="waktu">Waktu Kejadian:</label>
                <input type="datetime-local" class="form-control" id="waktu" name="waktu" required>
            </div>
            <div class="input-group">
                <div class="input-item">
                    <label for="latitude">Latitude:</label>
                    <input type="text" class="form-control" id="latitude" name="latitude" readonly>
                </div>
                <div class="input-item">
                    <label for="longitude">Longitude:</label>
                    <input type="text" class="form-control" id="longitude" name="longitude" readonly>
                </div>
            </div>
            <div class="form-group">
                <div id="mapid"></div>
            </div>
            <div class="form-group button-group">
                <button type="button" class="btn btn-primary btn-small" onclick="getLocation()">Access by Location</button>
                <button type="button" class="btn btn-secondary btn-small" onclick="pickLocation()">Pick Location</button>
            </div>
            <div class="form-group">
                <label for="kronologi">Kronologi Kejadian:</label>
                <textarea class="form-control" id="kronologi" name="kronologi" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="pengungsi">Jumlah Pengungsi:</label>
                <input type="text" class="form-control" id="pengungsi" name="pengungsi" required>
            </div>
            <div class="form-group">
                <label for="upload">Upload Gambar:</label>
                <input type="file" class="form-control" id="upload" name="upload" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary btn-submit">Submit</button>
        </form>
    </div>
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="main.js"></script>
</body>
</html>
