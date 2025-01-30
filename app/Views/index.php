<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Risiko Bencana Kabupaten Cilacap</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #ca3305;
            --text-color: white;
            --overlay-color: rgba(0, 0, 0, 0.5);
        }
    </style>
    <link rel="shortcut icon" type="" href="/icon.png">
</head>
<body>
    <?= $this->include('template/navbar'); ?>

    <!-- Background slideshow -->
    <div class="background">
        <!-- Slide 1 -->
        <div class="slides active" style="background-image: url('img/clp.jpg');" role="img" aria-label="Gempa Bumi"></div>
        <!-- Slide 3 -->
        <div class="slides" style="background-image: url('img/clp3.jpg');" role="img" aria-label="Home"></div>
        <!-- Slide 4 -->
        <div class="slides" style="background-image: url('img/gempa.jpg');" role="img" aria-label="Home"></div>

        <!-- Teks di tengah -->
        <div class="home-text">
            <h1>SISTEM INFORMASI RISIKO</h1>
            <h1>BENCANA GEMPA BUMI</h1>
            <h2>KABUPATEN CILACAP</h2>
            <a href="/risiko" class="btn">SIGERCAP</a>
        </div>

        <!-- Tombol navigasi -->
        <button class="slider-nav prev" onclick="prevSlide()" aria-label="Previous slide">&#10094;</button>
        <button class="slider-nav next" onclick="nextSlide()" aria-label="Next slide">&#10095;</button>
    </div>  

    <!-- Script untuk slide -->
    <script src="main.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        let currentSlide = 0;
        const slides = document.querySelectorAll('.slides');

        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.classList.remove('active');
                if (i === index) {
                    slide.classList.add('active');
                }
            });
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }

        function prevSlide() {
            currentSlide = (currentSlide - 1 + slides.length) % slides.length;
            showSlide(currentSlide);
        }

        // Auto-slide setiap 5 detik
        let slideInterval = setInterval(nextSlide, 5000);

        // Hentikan auto-slide saat tombol navigasi diklik
        document.querySelectorAll('.slider-nav').forEach(button => {
            button.addEventListener('click', () => {
                clearInterval(slideInterval);
                slideInterval = setInterval(nextSlide, 5000); // Reset auto-slide timer
            });
        });

        // Navigate slides with keyboard
        document.addEventListener('keydown', (event) => {
            if (event.key === 'ArrowRight') {
                nextSlide();
            } else if (event.key === 'ArrowLeft') {
                prevSlide();
            }
        });
    </script>
</body>
</html>
