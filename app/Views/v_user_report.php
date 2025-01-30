<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sistem Informasi Risiko Bencana Kabupaten Cilacap</title>
<link rel="stylesheet" href="css/main.css" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<body>
<?= $this->include('template/navbar'); ?>
<div class="container mt-5" style="padding-top: 4%;">
    <h2 style="text-align: center;">LAPORAN DAMPAK KEJADIAN BENCANA GEMPA BUMI</h2> <br>
    <?php if (session()->getFlashdata('status')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('status') ?>
        </div>
    <?php endif; ?>
    <input type="text" id="search-input" class="form-control mb-3" placeholder="Cari laporan...">
    <?php if (!empty($reports)): ?>
        <div class="table-responsive">
            <table class="table table-striped" style="padding-top: 2%;">
                <thead>
                    <tr class="text-center">
                        <th>Nomor Kejadian</th>
                        <th>Jenis Kejadian</th>
                        <th>Waktu Kejadian</th>
                        <th>Lokasi Kejadian</th>
                        <th>Kronologi</th>
                        <th>Pengungsi</th>
                        <th>Foto Kejadian</th>
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
    <?php else: ?>
        <p>No reports found.</p>
    <?php endif; ?>
</div>
<script src="main.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
const searchInput = document.getElementById('search-input');
const tableRows = document.querySelectorAll('.table tbody tr');

searchInput.addEventListener('input', function() {
    const searchValue = searchInput.value.toLowerCase();
    
    tableRows.forEach(row => {
        const cells = row.querySelectorAll('td');
        let found = false;

        cells.forEach(cell => {
            if (cell.textContent.toLowerCase().includes(searchValue)) {
                found = true;
            }
        });

        row.style.display = found ? '' : 'none';
    });
});
});
</script>
</body>
</html>
