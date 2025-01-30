<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Risiko Bencana Kabupaten Cilacap</title>
    <link rel="stylesheet" href="css/main.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
</head>
<body>
    <!-- Include navbar dari template -->
    <?= $this->include('template/navbar'); ?>

    <!-- Button untuk menampilkan checkbox-container dengan ikon -->
    <button class="show-checkbox-btn" id="show-checkbox-btn">
        <i class='bi bi-stack'></i> <!-- Ikon untuk tampilkan data -->
    </button>

    <button class="current-location-btn" id="current-location-btn">
        <i class='bi bi-geo-alt'></i>
    </button>

    <!-- Checkbox untuk memilih data -->
    <div class="checkbox-container" id="checkbox-container">
        <div class="checkbox-header">
            <i class='bi bi-chevron-double-right' id="hide-checkbox-btn"></i> <!-- Ikon untuk sembunyikan data -->
            <h4 style="color:darkred;">Layer Service</h4>
        </div>
        <input type="checkbox" id="show-risiko" checked >
        <label for="show-risiko">Risiko</label><br>
    </div>

    <!-- Div untuk peta Leaflet -->
    <div id="mapid" class="mapid"></div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const showCheckboxBtn = document.getElementById("show-checkbox-btn");
            const hideCheckboxBtn = document.getElementById("hide-checkbox-btn");
            const checkboxContainer = document.getElementById("checkbox-container");
            const currentLocationBtn = document.getElementById('current-location-btn');

            checkboxContainer.style.display = 'none';

            showCheckboxBtn.addEventListener("click", () => {
                checkboxContainer.style.display = "block";
                showCheckboxBtn.style.display = "none";
            });

            hideCheckboxBtn.addEventListener("click", () => {
                checkboxContainer.style.display = "none";
                showCheckboxBtn.style.display = "block";
            });

            var map = L.map('mapid').setView([-7.536, 109.007], 9.5);

            // Hillshade dari Esri
            L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/Elevation/World_Hillshade/MapServer/tile/{z}/{y}/{x}', {
                attribution: 'Tiles &copy; Esri &mdash; Source: USGS, Esri, TANA, DeLorme, and NPS',
                maxZoom: 18
            }).addTo(map);

            // Menambahkan peta dasar (OpenStreetMap di atas hillshade)
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors',
                opacity: 0.5 // Mengatur transparansi untuk membuat hillshade lebih terlihat
            }).addTo(map);

            function getColor(value) {
            return value <= 0.605606 ? '#ffcc00' :
                    value <= 0.625013 ? '#ffc400' :
                    value <= 0.628786 ? '#ffbb00' :
                    value <= 0.632515 ? '#ffb300' :
                    value <= 0.647007 ? '#ffaa00' :
                    value <= 0.65053 ? '#ffa200' :
                    value <= 0.654005 ? '#FF9900' :
                    value <= 0.66754 ? '#FF9100' :
                    value <= 0.670851 ? '#ff8800' :
                    value <= 0.674131 ? '#ff8000' :
                    '#FF4500';
            }

            var layers = {
            risiko: L.geoJSON(null, {
                onEachFeature: function (feature, layer) {
                    // Menambahkan popup untuk informasi lebih detail
                    layer.bindPopup(`<b>Kabupaten:</b> Cilacap<br>
                                    <b>Kecamatan:</b> ${feature.properties.WADMKC || 'N/A'}<br>
                                    <b>Desa:</b> ${feature.properties.NAMOBJ || 'N/A'}<br>
                                    <b>Indeks Risiko:</b> ${feature.properties.Skor_Risik || 'N/A'}<br>
                                    <b>Kelas Risiko:</b> ${feature.properties.Kelas_Risi || 'N/A'}<br>
                                    <a href="/mitigasi" target="_blank">Mitigasi</a>`);

                // Membuat label desa menggunakan L.divIcon
                var desaLabel = L.marker(layer.getBounds().getCenter(), {
                    icon: L.divIcon({
                        className: 'desa-label',
                        html: `<div>${feature.properties.NAMOBJ || 'N/A'}</div>`,
                    }),
                    interactive: false // Label tidak interaktif
                });

                // Menambahkan marker ke array untuk mengontrol visibilitas
                desaLabels.push(desaLabel);

                // Menambahkan marker ke peta (hanya terlihat pada zoom tertentu)
                if (map.getZoom() >= minZoomForLabels) {
                    desaLabel.addTo(map);
                }
            },
                style: function (feature) {
                    return {
                        color: 'black',
                        weight: 1,
                        opacity: 1,
                        fillColor: getColor(feature.properties.Skor_Risik),
                        fillOpacity: 0.65
                    };
                }
            }),
        };


            // Load GeoJSON untuk layer risiko dan tambahkan ke peta
            loadGeoJSON('/geojson/data.geojson', layers.risiko);
            map.addLayer(layers.risiko); // Layer risiko diaktifkan secara default

            function loadGeoJSON(url, layer) {
                fetch(url)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok ' + response.statusText);
                        }
                        return response.json();
                    })
                    .then(data => {
                        layer.addData(data);
                        updateLegend();
                    })
                    .catch(error => console.error('Error loading GeoJSON:', error));
            }

            var desaLabels = []; // Array untuk menyimpan referensi label
            var minZoomForLabels = 12; // Tingkat zoom minimum untuk menampilkan label

            // Event listener untuk mengontrol visibilitas label desa berdasarkan zoom level
            map.on('zoomend', function () {
                var currentZoom = map.getZoom();
                desaLabels.forEach(label => {
                    if (currentZoom >= minZoomForLabels) {
                        if (!map.hasLayer(label)) {
                            map.addLayer(label);
                        }
                    } else {
                        if (map.hasLayer(label)) {
                            map.removeLayer(label);
                        }
                    }
                });
            });

            function updateLegend() {
                var legend = document.querySelector('.legend');
                if (!legend) {
                    legend = document.createElement('div');
                    legend.className = 'legend';
                    document.body.appendChild(legend);
                }

                // Clear existing content
                legend.innerHTML = '<h4>Legenda</h4>';

                // Add gradient bar
                legend.innerHTML += '<div class="gradient-bar"></div>';

                // Add gradient labels
                legend.innerHTML += '<div class="legend-labels">';
                legend.innerHTML += '<span >Rendah</span>';
                legend.innerHTML += '<span>Sedang</span>';
                legend.innerHTML += '<span>Tinggi</span>';
                legend.innerHTML += '</div>';

                // Function to toggle legend visibility based on layer visibility
                function toggleLegend() {
                    const anyLayerVisible = Object.values(layers).some(layer => map.hasLayer(layer));
                    legend.style.display = anyLayerVisible ? 'block' : 'none';
                }

                // Set up listeners for layer visibility changes
                Object.values(layers).forEach(layer => layer.on('add remove', toggleLegend));
                toggleLegend();
            }

            // Menangani tombol current-location-btn
            currentLocationBtn.addEventListener('click', function () {
            if (!navigator.geolocation) {
                alert("Geolocation is not supported by your browser");
                return;
            }
            currentLocationBtn.classList.add('loading'); // Opsional: Menambahkan kelas loading
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const { latitude, longitude } = position.coords;
                    map.setView([latitude, longitude], 13);

                    // Menampilkan marker di lokasi pengguna
                    const userMarker = L.marker([latitude, longitude]).addTo(map);

                    // Menyimpan referensi marker untuk mengupdate popup
                    userMarker.bindPopup("<b>Informasi Risiko:</b><br>Menunggu data...").openPopup();

                    // Memeriksa risiko di lokasi tersebut
                    checkRiskAtLocation(latitude, longitude, userMarker);

                    currentLocationBtn.classList.remove('loading'); // Menghapus kelas loading
                },
                (error) => {
                    alert('Unable to retrieve your location');
                    currentLocationBtn.classList.remove('loading'); // Menghapus kelas loading
                }
            );
        });

        // Fungsi untuk memeriksa risiko di lokasi tertentu berdasarkan koordinat
        function checkRiskAtLocation(lat, lng, marker) {
            let riskInfo = "Tidak ada data risiko untuk lokasi ini.";

            layers.risiko.eachLayer(function (layer) {
                const bounds = layer.getBounds();
                if (bounds.contains([lat, lng])) {
                    const riskLevel = layer.feature.properties.Kelas || 'Tidak diketahui';
                    riskInfo = `<b>Kabupaten:</b> Cilacap<br><b>Kecamatan:</b> ${layer.feature.properties.WADMKC}<br><b>Indeks Risiko:</b> ${layer.feature.properties.Nilai}<br><b>Kelas:</b> ${layer.feature.properties.Kelas || 'N/A'}<br><a href="/mitigasi" target="_blank">Mitigasi</a>`;
                }
            });

            // Mengupdate konten popup marker
            marker.setPopupContent(`<b>Informasi Risiko:</b><br>${riskInfo}`);
        }
        });
    </script>
</body>
</html>
