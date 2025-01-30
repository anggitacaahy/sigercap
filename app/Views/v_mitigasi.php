<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mitigasi Gempa Bumi</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
    body {
        font-family: Arial, sans-serif;
        line-height: 1.6;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }

    main {
        padding: 2rem;
        margin: 0;
        width: 90%;
        max-width: 1200px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .info-card {
        background: #ffffff;
        padding: 1.5rem;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 1.5rem;
        cursor: pointer;
        transition: box-shadow 0.3s, transform 0.3s;
        width: 100%;
        max-width: 600px; /* Maksimal lebar card */
    }

    .info-card:hover {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        transform: translateY(-5px);
    }

    .info-card h2 {
        margin-bottom: 0.5rem;
        font-size: 1.5rem;
        color: var(--main-color);
        display: flex;
        align-items: center;
        font-weight: 600;
    }

    .info-card h2 i {
        color: var(--main-color);
        font-size: 1.5rem;
        margin-right: 0.5rem;
    }

    .info-card-content {
        display: none;
        margin-top: 1rem;
        font-size: 0.9rem;
        color: #555;
    }

    .info-card-content ul {
        list-style-type: disc;
        padding-left: 1.5rem;
    }

    .info-card-content ul li {
        margin-bottom: 0.5rem;
        line-height: 1.4;
    }

    .action-btn {
        display: inline-block;
        padding: 0.5rem 1rem;
        background: #e74c3c;
        color: #ffffff;
        text-decoration: none;
        border-radius: 4px;
        transition: background 0.3s, transform 0.3s;
        margin-top: 1rem;
        font-size: 0.9rem;
        font-weight: 600;
        text-align: center;
        display: block;
    }

    .action-btn:hover {
        background: #c0392b;
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {
        .info-card {
            margin-bottom: 1rem;
        }
    }

    .info-card-content i {
    color: var(--main-color);
    margin-right: 0.5rem;
    font-size: 1rem; /* Sesuaikan ukuran ikon */
}

    </style>
</head>
<body>
    <?= $this->include('template/navbar'); ?>

    <main>
        <div id="info" class="info-card">
            <h2><i class="fas fa-info-circle"></i> Mitigasi Bencana</h2>
            <div class="info-card-content">
                <p>Mitigasi bencana adalah serangkaian upaya untuk mengurangi risiko bencana melalui pembangunan fisik, penyadaran, dan peningkatan kemampuan masyarakat dalam menghadapi ancaman bencana.</p>
                <p><strong>Langkah-Langkah Mitigasi Bencana:</strong></p>
                <ul>
                    <li><i class="fas fa-calendar-check"></i> Menyusun rencana darurat dan evakuasi yang jelas.</li>
                    <li><i class="fas fa-tools"></i> Memperkuat infrastruktur dan bangunan untuk mengurangi kerusakan saat bencana.</li>
                    <li><i class="fas fa-info-circle"></i> Mengedukasi masyarakat tentang bahaya bencana dan cara-cara untuk menghadapi bencana tersebut.</li>
                </ul>
            </div>
        </div>

        <div id="pre-disaster" class="info-card">
            <h2><i class="fas fa-calendar-check"></i> Pra Bencana</h2>
            <div class="info-card-content">
                <p>Persiapan sebelum bencana gempa bumi dapat menyelamatkan banyak nyawa. Beberapa langkah penting meliputi:</p>
                <ul>
                    <li><i class="fas fa-map-signs"></i> Menyiapkan rencana untuk penyelamatan diri apabila gempa bumi terjadi.</li>
                    <li><i class="fas fa-cogs"></i> Melakukan latihan yang bermanfaat dalam menghadapi reruntuhan saat gempa bumi, seperti merunduk, perlindungan terhadap kepala, berpegangan, atau bersembunyi di bawah meja.</li>
                    <li><i class="fas fa-fire-extinguisher"></i> Menyiapkan alat pemadam kebakaran, alat keselamatan standar, dan persediaan obat-obatan.</li>
                    <li><i class="fas fa-home-lg"></i> Membangun konstruksi rumah yang tahan terhadap guncangan gempa bumi dengan fondasi yang kuat, serta merenovasi bagian bangunan yang rentan.</li>
                    <li><i class="fas fa-map-marker-alt"></i> Memperhatikan daerah rawan gempa bumi dan aturan seputar penggunaan lahan yang dikeluarkan oleh pemerintah.</li>
                </ul>
            </div>
        </div>

        <div id="during-disaster" class="info-card">
            <h2><i class="fa-solid fa-house-crack"></i> Saat Bencana</h2>
            <div class="info-card-content">
                <div id="dalamBangunan">
                    <h3 style="color: var(--main-color);"><i class="fas fa-building"></i> Di Dalam Bangunan</h3>
                    <ul>
                        <li><i class="fas fa-table"></i> Guncangan akan terasa beberapa saat. Selama jangka waktu itu, upayakan keselamatan diri Anda dengan cara berlindung di bawah meja untuk menghindari dari benda-benda yang mungkin jatuh dan jendela kaca. Lindungi kepala dengan bantal atau helm, atau berdirilah di bawah pintu. Bila sudah terasa aman, segera lari keluar rumah.</li>
                        <li><i class="fas fa-fire"></i> Jika sedang memasak, segera matikan kompor serta mencabut dan mematikan semua peralatan yang menggunakan listrik untuk mencegah terjadinya kebakaran.</li>
                        <li><i class="fas fa-glass-cheers"></i> Bila keluar rumah, perhatikan kemungkinan pecahan kaca, genteng, atau material lain. Tetap lindungi kepala dan segera menuju ke lapangan terbuka, jangan berdiri dekat tiang, pohon, atau sumber listrik atau gedung yang mungkin roboh.</li>
                        <li><i class="fas fa-elevator"></i> Jangan gunakan lift apabila sudah terasa guncangan. Gunakan tangga darurat untuk evakuasi keluar bangunan. Apabila sudah di dalam elevator, tekan semua tombol atau gunakan interphone untuk panggilan kepada pengelola bangunan.</li>
                        <li><i class="fas fa-caret-square-up"></i> Kenali bagian bangunan yang memiliki struktur kuat, seperti pada sudut bangunan.</li>
                        <li><i class="fas fa-shield-alt"></i> Apabila Anda berada di dalam bangunan yang memiliki petugas keamanan, ikuti instruksi evakuasi.</li>
                    </ul>
                </div>

                <div id="dalamMobil">
                    <h3 style="color: var(--main-color);"><i class="fas fa-car"></i> Di Dalam Mobil</h3>
                    <ul>
                        <li><i class="fas fa-car-crash"></i> Segera berhenti di tempat yang aman, jauh dari bangunan, pohon, jembatan, atau tiang listrik.</li>
                        <li><i class="fas fa-car-side"></i> Tetap tinggal di dalam mobil sampai guncangan berhenti.</li>
                        <li><i class="fas fa-truck-monster"></i> Hindari berhenti di bawah jembatan atau terowongan.</li>
                        <li><i class="fas fa-road"></i> Setelah guncangan berhenti, lanjutkan perjalanan dengan hati-hati dan hindari jalan yang rusak.</li>
                    </ul>
                </div>
            </div>
        </div>

        <div id="post-disaster" class="info-card">
            <h2><i class="fas fa-ambulance"></i> Pasca Bencana</h2>
            <div class="info-card-content">
                <p>Setelah gempa bumi, penting untuk melakukan langkah-langkah pemulihan berikut:</p>
                <ul>
                    <li><i class="fas fa-house-crack"></i> Tetap waspada terhadap gempa bumi susulan.</li>
                    <li><i class="fas fa-building"></i> Ketika berada di dalam bangunan, evakuasi diri Anda setelah gempa bumi berhenti. Perhatikan reruntuhan maupun benda-benda yang membahayakan pada saat evakuasi.</li>
                    <li><i class="fas fa-table"></i> Jika berada di dalam rumah, tetap berada di bawah meja yang kuat.</li>
                    <li><i class="fas fa-fire-extinguisher"></i> Periksa keberadaan api dan potensi terjadinya bencana kebakaran.</li>
                    <li><i class="fas fa-mountain"></i> Berdirilah di tempat terbuka jauh dari gedung dan instalasi listrik dan air. Apabila di luar bangunan dengan tebing di sekeliling, hindari daerah yang rawan longsor.</li>
                    <li><i class="fas fa-car-side"></i> Jika di dalam mobil, berhentilah tetapi tetap berada di dalam mobil. Hindari berhenti di bawah atau di atas jembatan atau rambu-rambu lalu lintas.</li>
                </ul>
            </div>
        </div>
    </main>
    <script>
        document.querySelectorAll('.info-card').forEach(card => {
            card.addEventListener('click', () => {
                const content = card.querySelector('.info-card-content');
                const isVisible = content.style.display === 'block';

                document.querySelectorAll('.info-card-content').forEach(c => {
                    c.style.display = 'none';
                });

                content.style.display = isVisible ? 'none' : 'block';
            });
        });
    </script>
</body>
</html>
