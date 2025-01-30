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
        <input type="checkbox" id="show-batas" checked> <!-- Checkbox dalam keadaan checked secara default -->
        <label for="show-batas">Batas Kecamatan</label><br>
    </div>

    <!-- Div untuk peta Leaflet -->
    <div id="mapid" class="mapid"></div>

    <!-- Div untuk legenda -->
    <div id="legend" class="legend"></div>      

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const showCheckboxBtn = document.getElementById("show-checkbox-btn");
            const hideCheckboxBtn = document.getElementById("hide-checkbox-btn");
            const checkboxContainer = document.getElementById("checkbox-container");
            const currentLocationBtn = document.getElementById('current-location-btn');
            const showBatasCheckbox = document.getElementById('show-batas');

            checkboxContainer.style.display = 'none';

            showCheckboxBtn.addEventListener("click", () => {
                checkboxContainer.style.display = "block";
                showCheckboxBtn.style.display = "none";
            });

            hideCheckboxBtn.addEventListener("click", () => {
                checkboxContainer.style.display = "none";
                showCheckboxBtn.style.display = "block";
            });

            var map = L.map('mapid').setView([-7.536, 109.007], 10.3);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            // Fungsi untuk mendapatkan warna berdasarkan magnitudo gempa
            function getEarthquakeColor(magnitude) {
                return magnitude > 5 ? 'red' :
                       magnitude > 4 ? 'orange' :
                       magnitude > 3 ? 'yellow' :
                       'green'; // Magnitudo < 3
            }

            // Layer untuk batas administrasi
            var adminLayer = L.geoJSON(null, {
                style: function (feature) {
                    return {
                        color: 'var(--third-color)', 
                        weight: 2,
                        opacity: 1
                    };
                },
                onEachFeature: function (feature, layer) {
                    // Menambahkan tooltip dengan nama kecamatan
                    layer.bindTooltip(feature.properties.WADMKC, {
                        permanent: true, // Membuat label selalu terlihat
                        direction: 'center', // Posisikan label di tengah
                        className: 'kecamatan-label' // Kelas CSS untuk styling
                    }).openTooltip();
                }
            });

            // Menampilkan GeoJSON data titik gempa
            var gempaLayer = L.geoJSON(null, {
                onEachFeature: function (feature, layer) {
                    layer.bindPopup(`<b>Lokasi:</b> ${feature.properties.place}<br>
                                    <b>Magnitudo:</b> ${feature.properties.mag} SR<br>
                                    <b>Kedalaman:</b> ${feature.properties.depth} Km`);
                },
                pointToLayer: function (feature, latlng) {
                    return L.circleMarker(latlng, {
                        radius: 8,
                        fillColor: getEarthquakeColor(feature.properties.mag),
                        color: '#000',
                        weight: 1,
                        opacity: 1,
                        fillOpacity: 0.8
                    });
                }
            }).addTo(map);

            // Load data GeoJSON dari file
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
                    })
                    .catch(error => console.error('Error loading GeoJSON:', error));
            }

            // Memuat GeoJSON titik gempa
            loadGeoJSON('/geojson/gempa.geojson', gempaLayer);

            // Memuat GeoJSON batas administrasi dan langsung menambahkannya ke peta
            loadGeoJSON('/geojson/admin_kec.geojson', adminLayer);
            adminLayer.addTo(map); // Tambahkan langsung ke peta
            addLegend(map);

            // Fungsi untuk menampilkan popup lokasi saat ini
            function showCurrentLocationPopup(lat, lng) {
                let popupContent = 'Tidak ada informasi gempa untuk lokasi ini.';

                gempaLayer.eachLayer(function (layer) {
                    if (layer.getBounds().contains([lat, lng])) {
                        popupContent = layer.getPopup().getContent();
                    }
                });

                L.popup()
                    .setLatLng([lat, lng])
                    .setContent(popupContent)
                    .openOn(map);
            }

            // Tombol untuk mendapatkan lokasi saat ini
            currentLocationBtn.addEventListener('click', () => {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(position => {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;

                        // Set view to current location
                        map.setView([lat, lng], 13);

                        // Tampilkan popup dengan informasi gempa dari lokasi saat ini
                        showCurrentLocationPopup(lat, lng);
                    }, () => {
                        alert('Unable to retrieve your location');
                    });
                } else {
                    alert("Geolocation is not supported by this browser.");
                }
            });

            // Tambah event listener untuk checkbox "Batas Kecamatan"
            showBatasCheckbox.addEventListener('change', (e) => {
                if (e.target.checked) {
                    adminLayer.addTo(map); // Tampilkan layer
                } else {
                    map.removeLayer(adminLayer); // Sembunyikan layer
                }
            });

            // Fungsi untuk menambahkan legenda pada peta
            function addLegend(map) {
                var legend = L.control({ position: 'bottomright' });

                legend.onAdd = function (map) {
                    var div = L.DomUtil.create('div', 'legend'),
                        grades = [0, 3, 4, 5],
                        labels = [];

                    div.innerHTML += '<strong>Magnitudo Gempa</strong><br>';
                    for (var i = 0; i < grades.length; i++) {
                        div.innerHTML +=
                            '<i style="background:' + getEarthquakeColor(grades[i] + 1) + '"></i> ' +
                            grades[i] + (grades[i + 1] ? '&ndash;' + grades[i + 1] + '<br>' : '+');
                    }
                    return div;
                };

                legend.addTo(map);
            }
            });
    </script>
</body>
</html>
