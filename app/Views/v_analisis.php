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
        <input type="checkbox" id="show-bahaya">
        <label for="show-bahaya">Bahaya</label><br>
        <input type="checkbox" id="show-kerentanan">
        <label for="show-kerentanan">Kerentanan</label><br>
        <input type="checkbox" id="show-kapasitas">
        <label for="show-kapasitas">Kapasitas</label><br>
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

        var map = L.map('mapid').setView([-7.536, 109.007], 10.5);

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
            switch (value) {
                case 'Tinggi': return '#ff2200';
                case 'Sedang': return '#FFFF00';
                case 'Rendah': return '#38A800';
                default: return '#000000';
            }
        }
        function getHazard(value) {
            return value <= 0.605606 ? '#ffcc00' :
                    value <= 0.625013 ? '#ffc400' :
                    value <= 0.628786 ? '#ffbb00' :
                    value <= 0.632515 ? '#ffb300' :
                    value <= 0.647007 ? '#ffaa00' :
                    value <= 0.65053 ? '#ffa200' :
                    value <= 0.654005 ? '#FF9900' :
                    value <= 0.66754 ? '#FF9100' :
                    value <= 0.670851 ? '#ff8800' :
                    value <= 0.73 ? '#ff8000' :
                    value <= 0.75 ? '#ff7700' :
                    value <= 0.77 ? '#ff6f00' :
                    value <= 0.79 ? '#ff6600' :
                    value <= 0.81 ? '#ff5e00' :
                    value <= 0.83 ? '#ff5500' :
                    value <= 0.85 ? '#ff4d00' :
                    value <= 0.86 ? '#ff4400' :
                    value <= 0.88 ? '#ff3c00' :
                    value <= 0.90 ? '#ff3300' :
                    value <= 0.92 ? '#ff2a00' :
                    '#FF4500';
        }

        var layers = {
            bahaya: L.geoJSON(null, {
                onEachFeature: function (feature, layer) {
                    layer.bindPopup(`<b>Kabupaten:</b> Cilacap<br>
                                    <b>Kelas Bahaya:</b> ${feature.properties.Kelas_Baha || 'N/A'}`);
                },
                style: function (feature) {
                    return {
                        color: 'black',
                        weight: 2,
                        opacity: 0.4,
                        fillColor: getColor(feature.properties.Kelas_Baha),
                        fillOpacity: 0.4
                    };
                }
            }),
            kerentanan: L.geoJSON(null, {
                    onEachFeature: function (feature, layer) {
                        function formatDecimal(num, maxLength) {
                            if (typeof num !== 'number') {
                                console.error('Input is not a number:', num);
                                return 'N/A';
                            }
                            
                            let str = num.toFixed(5);
                            if (str.length > maxLength) {
                                return str.substring(0, maxLength - 6) + '...';
                            }
                            return str;
                        }

                        var kerentananValue = feature.properties.Kerentan_1 || 0;
                        var formattedKerentananValue = formatDecimal(kerentananValue, 7);

                        layer.bindPopup(`<b>Kabupaten:</b> Cilacap<br>
                                        <b>Kecamatan:</b> ${feature.properties.WADMKC || 'N/A'}<br>
                                        <b>Nilai Kerentanan:</b> ${formattedKerentananValue}<br>
                                        <b>Kelas Kerentanan:</b> ${feature.properties.Kelas_Kere || 'N/A'}`);
                        layer.bindTooltip(`<b></b> ${feature.properties.NAMOBJ || 'N/A'}`, {
                            permanent: true, 
                            direction: 'top',
                            className: 'kecamatan-label'// Gunakan kelas CSS yang telah didefinisikan
                        });                    },
                        style: function (feature) {
                            return {
                                color: '#ffffff',
                                weight: 2,
                                opacity: 1,
                                fillColor: getHazard(feature.properties.Kerentan_1),
                                fillOpacity: 0.6
                            };
                        }
                }),
            kapasitas: L.geoJSON(null, {
                onEachFeature: function (feature, layer) {
                    function formatDecimal(num, maxLength) {
                        if (typeof num !== 'number') {
                            console.error('Input is not a number:', num);
                            return 'N/A';
                        }
                        
                        let str = num.toFixed(5);
                        if (str.length > maxLength) {
                            return str.substring(0, maxLength - 6) + '...';
                        }
                        return str;
                    }

                    var kapasitasValue = feature.properties.Skor_Kapas || 0;
                    var formattedKapasitasValue = formatDecimal(kapasitasValue, 7);

                    layer.bindPopup(`<b>Kabupaten:</b> Cilacap<br>
                                    <b>Kecamatan:</b> ${feature.properties.WADMKC || 'N/A'}<br>
                                    <b>Nilai Kapasitas:</b> ${formattedKapasitasValue}<br>
                                    <b>Kelas Kapasitas:</b> ${feature.properties.Kelas_Kapa || 'N/A'}`)
                    layer.bindTooltip(`<b></b> ${feature.properties.NAMOBJ || 'N/A'}`, {
                            permanent: true, 
                            direction: 'top',
                            className: 'kecamatan-label'
                        });                    },
                    style: function (feature) {
                        return {
                            color: '#ffffff',
                            weight: 2,
                            opacity: 1,
                            fillColor: getHazard(feature.properties.Kelas_Kapa),
                            fillOpacity: 0.6
                        };
                    }                                    
            }),
        };

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

        loadGeoJSON('/geojson/data.geojson', layers.bahaya);
        loadGeoJSON('/geojson/data.geojson', layers.kerentanan);
        loadGeoJSON('/geojson/data.geojson', layers.kapasitas);

        var legendControl;

        L.control.legend = function (options) {
            return new L.Control.Legend(options);
        };

        L.Control.Legend = L.Control.extend({
        onAdd: function (map) {
            var div = L.DomUtil.create('div', 'legend');
            div.innerHTML += '<b>Legenda</b><br>';
            div.innerHTML += '<div class="gradient-bar"></div>';
            div.innerHTML += '<div class="legend-labels">';
            div.innerHTML += '<span>Rendah</span>';
            div.innerHTML += '<span>Sedang</span>';
            div.innerHTML += '<span>Tinggi</span>';
            div.innerHTML += '</div>';
            return div;
        }
    });

        function updateLegend() {
            if (document.getElementById('show-bahaya').checked || 
                document.getElementById('show-kerentanan').checked || 
                document.getElementById('show-kapasitas').checked) {
                if (!legendControl) {
                    legendControl = L.control.legend({ position: 'bottomright' }).addTo(map);
                }
            } else {
                if (legendControl) {
                    map.removeControl(legendControl);
                    legendControl = null;
                }
            }
        }

        document.querySelectorAll('.checkbox-container input[type=checkbox]').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const layer = layers[this.id.replace('show-', '')];
                if (this.checked) {
                    layer.addTo(map);
                } else {
                    map.removeLayer(layer);
                    map.closePopup();
                }
                updateLegend();
            });
        });

        function showCurrentLocationPopup(lat, lng) {
            let popupContent = 'Tidak ada informasi tersedia.';

            // Menentukan layer yang aktif
            const activeLayers = Object.keys(layers).filter(layerKey => map.hasLayer(layers[layerKey]));

            if (activeLayers.length > 0) {
                let foundLayer = null;

                // Mencari satu layer yang mencakup lokasi pengguna
                for (let layerKey of activeLayers) {
                    const layer = layers[layerKey];
                    layer.eachLayer(function(layer) {
                        if (layer.getBounds().contains([lat, lng])) {
                            // Jika ditemukan layer yang cocok, ambil konten popup dari layer tersebut
                            foundLayer = layer;
                            return;
                        }
                    });

                    if (foundLayer) break; // Keluar dari loop jika sudah ditemukan
                }

                if (foundLayer) {
                    popupContent = foundLayer.getPopup().getContent();
                }
            }

            L.popup()
                .setLatLng([lat, lng])
                .setContent(popupContent)
                .openOn(map);
        }
        currentLocationBtn.addEventListener('click', () => {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(position => {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;

                    // Set view to current location
                    map.setView([lat, lng], 13);

                    // Show popup with information from active layers or default message
                    showCurrentLocationPopup(lat, lng);
                }, () => {
                    alert('Unable to retrieve your location');
                });
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        });
    });
    </script>
</body>
</html>
