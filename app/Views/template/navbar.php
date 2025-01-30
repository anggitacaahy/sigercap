<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<header>
    <a class="logo">
        <img src="/img/logo.png" alt="">
        <span class="logo-text">SIGERCAP</span>
    </a>
    <div class="menu-icon" id="menu-icon" onclick="toggleMenu()">&#9776;</div>
    <ul class="navbar-custom" id="navbar">
        <li><a href="/">Beranda</a></li>
        <li class="dropdown">
            <a>Peta</a>
            <div class="dropdown-content">
                <a href="risiko">Peta Risiko</a>
                <a href="data">Data Dasar</a>
                <a href="analisis">Peta Bahaya, Peta Kerentanan, Peta Kapasitas</a>
            </div>
        </li>
        <li class="dropdown">
            <a>Laporkan Bencana</a>
            <div class="dropdown-content">
                <a href="laporan">Laporkan Bencana</a>
                <a href="report-list">Daftar Kejadian</a>
            </div>
        </li>
        <li><a href="/mitigasi">Mitigasi</a></li>
        <li class="dropdown">
            <a>Informasi Gempa</a>
            <div class="dropdown-content">
                <a href="https://earthquake.usgs.gov/earthquakes/map/?currentFeatureId=us7000ncx9&extent=-18.8543,90.65905&extent=14.81738,153.28112" target="_blank" class="map-link">Gempa Terkini</a>
                <a href="/epicentre">Titik Kejadian Gempa</a>
            </div>
        </li>        
        <?php if (session()->has('logged_in')) : ?>
            <li class="dropdown">
            <a class="dropbtn">
                <i class="fas fa-user"></i> 
            </a>
            <div class="dropdown-content">
                <a href="/profile">Profil</a>
                <a href="/logout">Logout</a>
            </div>
        </li>
        <?php else : ?>
            <li><a href="/login">Login</a></li>
        <?php endif; ?>
    </ul>
</header>
<script>
document.addEventListener("DOMContentLoaded", () => {
  const menuIcon = document.getElementById("menu-icon");
  const navbar = document.querySelector(".navbar-custom");
  const dropdowns = document.querySelectorAll(".navbar-custom .dropdown");

  menuIcon.addEventListener("click", () => {
    navbar.classList.toggle("active");
  });

  dropdowns.forEach((dropdown) => {
    dropdown.addEventListener("click", (event) => {
      event.stopPropagation(); // Menghindari klik pada menu utama menutup dropdown
      dropdown.classList.toggle("active");

      // Menutup dropdown lain jika ada
      dropdowns.forEach((otherDropdown) => {
        if (otherDropdown !== dropdown) {
          otherDropdown.classList.remove("active");
        }
      });
    });
  });
  document.addEventListener("click", () => {
    dropdowns.forEach((dropdown) => {
      dropdown.classList.remove("active");
    });
  });
});
</script>