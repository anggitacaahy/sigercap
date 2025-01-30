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
        <label for="show-bahaya" style="font-weight: bold;">Bahaya</label><br>
        <input type="checkbox" id="show-bahaya">
        <label for="show-bahaya">Bahaya</label><br>
        <label for="show-kerentanan" style="font-weight:bold">Kerentanan</label><br>
        <label for="show-kerentanan-sosial" style="font-weight: 500;">Kerentanan Sosial</label><br>
        <input type="checkbox" id="show-sosialPenduduk">
        <label for="show-sosialPenduduk">Kepadatan Penduduk</label><br>
        <input type="checkbox" id="show-sosialRentan">
        <label for="show-sosialRentan">Ratio Umur Rentan</label><br>
        <input type="checkbox" id="show-sosialCacat">
        <label for="show-sosialCacat">Ratio Penduduk Cacat</label><br>
        <input type="checkbox" id="show-sosialRatio">
        <label for="show-sosialRatio">Ratio Jenis Kelamin</label><br>
        <input type="checkbox" id="show-sosialKemiskinan">
        <label for="show-sosialKemiskinan">Ratio Kemiskinan</label><br>
        <label for="show-kerentanan-fisik" style="font-weight: 500;">Kerentanan Fisik</label><br>
        <input type="checkbox" id="show-fisik">
        <label for="show-fisik">Kerugian Fisik</label><br>
        <label for="show-kerentanan-ekonomi" style="font-weight: 500;">Kerentanan Ekonomi</label><br>
        <input type="checkbox" id="show-ekonomi">
        <label for="show-ekonomi">Kerugian Ekonomi</label><br>
        <label for="show-kapasitas" style="font-weight: bold;">Kapasitas</label><br>
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

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        function getColor(value) {
            switch (value) {
                case 'Tinggi': return '#FF2000';
                case 'Sedang': return '#FFFF00';
                case 'Rendah': return '#38A800';
                default: return '#000000';
            }
        }
        function getHazard(value) {
            return value <= 0.1 ? '#38A800' :
                    value <= 0.2 ? '#5EBD00' :
                    value <= 0.3 ? '#8BD100' :
                    value <= 0.4 ? '#C1E800' :
                    value <= 0.5 ? '#FFFF00' :
                    value <= 0.6 ? '#FFBF00' :
                    value <= 0.7 ? '#FF8000' :
                    value <= 0.8 ? '#FF4000' :
                    value <= 0.9 ? '#FF2000' :
                    '#FF4500';
        }

        var layers = {
            bahaya: L.geoJSON(null, {
                onEachFeature: function (feature, layer) {
                    layer.bindPopup(`<b>Kabupaten:</b> Cilacap<br>
                                    <b>Kelas Bahaya:</b> ${feature.properties.Kelas_Baha || 'N/A'}`);                },
                style: function (feature) {
                    return {
                        color: 'black',
                        weight: 2,
                        opacity: 0.5,
                        fillColor: getColor(feature.properties.Kelas_Baha),
                        fillOpacity: 0.4
                    };
                }
            }),
            sosialPenduduk: L.geoJSON(null, {
                onEachFeature: function (feature, layer) {
                    function formatDecimal(num, maxLength) {
                        if (typeof num !== 'number') {
                            console.error('Input is not a number:', num);
                            return 'N/A';
                        }
                        
                        let str = num.toFixed(0);
                        if (str.length > maxLength) {
                            return str.substring(0, maxLength - 6) + '...';
                        }
                        return str;
                    }

                    var kerentananValue = feature.properties.Kpdtn_Pdd || 0;
                    var formattedKerentananValue = formatDecimal(kerentananValue, 7);

                    layer.bindPopup(`<b>Kabupaten:</b> Cilacap<br>
                                    <b>Kecamatan:</b> ${feature.properties.Kecamatan || 'N/A'}<br>
                                    <b>Desa:</b> ${feature.properties.NAMOBJ || 'N/A'}<br>
                                    <b>Kepadatan Penduduk:</b> ${formattedKerentananValue} Jiwa/Km2<br>
                                    <b>Kelas:</b> ${feature.properties.Skor_Kpdtn || 'N/A'}`);
                    layer.bindTooltip(`<b></b> ${feature.properties.NAMOBJ || 'N/A'}`, {
                            permanent: true, 
                            direction: 'top',
                            className: 'kecamatan-label'
                        });                 },
                style: function (feature) {
                    return {
                        color: '#ffffff',
                        weight: 2,
                        opacity: 1,
                        fillColor: getColor(feature.properties.Skor_Kpdtn),
                        fillOpacity: 0.6
                    };
                }
            }),
            sosialRentan: L.geoJSON(null, {
                onEachFeature: function (feature, layer) {
                    function formatDecimal(num, maxLength) {
                        if (typeof num !== 'number') {
                            console.error('Input is not a number:', num);
                            return 'N/A';
                        }
                        
                        let str = num.toFixed(2);
                        if (str.length > maxLength) {
                            return str.substring(0, maxLength - 6) + '...';
                        }
                        return str;
                    }

                    var kerentananValue = feature.properties.Ratio_Umur || 0;
                    var formattedKerentananValue = formatDecimal(kerentananValue, 7);

                    layer.bindPopup(`<b>Kabupaten:</b> Cilacap<br>
                                    <b>Kecamatan:</b> ${feature.properties.Kecamatan || 'N/A'}<br>
                                    <b>Desa:</b> ${feature.properties.NAMOBJ || 'N/A'}<br>
                                    <b>Ratio:</b> ${formattedKerentananValue}<br>
                                    <b>Kelas:</b> ${feature.properties.Kelas_Rent || 'N/A'}`);
                                    layer.bindTooltip(`<b></b> ${feature.properties.NAMOBJ || 'N/A'}`, {
                            permanent: true, 
                            direction: 'top',
                            className: 'kecamatan-label'
                        }); 
                },
                style: function (feature) {
                    return {
                        color: '#ffffff',
                        weight: 2,
                        opacity: 1,
                        fillColor: getColor(feature.properties.Kelas_Rent),
                        fillOpacity: 0.6
                    };
                }
            }),
            sosialRatio: L.geoJSON(null, {
                onEachFeature: function (feature, layer) {
                    function formatDecimal(num, maxLength) {
                        if (typeof num !== 'number') {
                            console.error('Input is not a number:', num);
                            return 'N/A';
                        }
                        
                        let str = num.toFixed(2);
                        if (str.length > maxLength) {
                            return str.substring(0, maxLength - 6) + '...';
                        }
                        return str;
                    }

                    var kerentananValue = feature.properties.Sex_Ratio || 0;
                    var formattedKerentananValue = formatDecimal(kerentananValue, 7);

                    layer.bindPopup(`<b>Kabupaten:</b> Cilacap<br>
                                    <b>Kecamatan:</b> ${feature.properties.Kecamatan || 'N/A'}<br>
                                    <b>Desa:</b> ${feature.properties.NAMOBJ || 'N/A'}<br>
                                    <b>Ratio:</b> ${formattedKerentananValue}<br>
                                    <b>Kelas:</b> ${feature.properties.Kelas_Rati || 'N/A'}`);
                    layer.bindTooltip(`<b></b> ${feature.properties.NAMOBJ || 'N/A'}`, {
                            permanent: true, 
                            direction: 'top',
                            className: 'kecamatan-label'
                        }); 
                },
                style: function (feature) {
                    return {
                        color: '#ffffff',
                        weight: 2,
                        opacity: 1,
                        fillColor: getColor(feature.properties.Kelas_Rati),
                        fillOpacity: 0.6
                    };
                }
            }),
            sosialKemiskinan: L.geoJSON(null, {
                onEachFeature: function (feature, layer) {
                    function formatDecimal(num, maxLength) {
                        if (typeof num !== 'number') {
                            console.error('Input is not a number:', num);
                            return 'N/A';
                        }
                        
                        let str = num.toFixed(0);
                        if (str.length > maxLength) {
                            return str.substring(0, maxLength - 8) + '...';
                        }
                        return str;
                    }

                    var kerentananValue = feature.properties.Rasio_Pend || 0;
                    var formattedKerentananValue = formatDecimal(kerentananValue, 8);

                    layer.bindPopup(`<b>Kabupaten:</b> Cilacap<br>
                                    <b>Ratio:</b> ${formattedKerentananValue}<br>
                                    <b>Desa:</b> ${feature.properties.NAMOBJ || 'N/A'}<br>
                                    <b>Kelas:</b> ${feature.properties.Kelas_Mis || 'N/A'}`);
                    layer.bindTooltip(`<b></b> ${feature.properties.NAMOBJ || 'N/A'}`, {
                            permanent: true, 
                            direction: 'top',
                            className: 'kecamatan-label'
                        }); 
                },
                style: function (feature) {
                    return {
                        color: '#ffffff',
                        weight: 2,
                        opacity: 1,
                        fillColor: getColor(feature.properties.Kelas_Mis),
                        fillOpacity: 0.6
                    };
                }
            }),
            sosialCacat: L.geoJSON(null, {
                onEachFeature: function (feature, layer) {
                    function formatDecimal(num, maxLength) {
                        if (typeof num !== 'number') {
                            console.error('Input is not a number:', num);
                            return 'N/A';
                        }
                        
                        let str = num.toFixed(2);
                        if (str.length > maxLength) {
                            return str.substring(0, maxLength - 6) + '...';
                        }
                        return str;
                    }

                    var kerentananValue = feature.properties.Rasio_Pe_1 || 0;
                    var formattedKerentananValue = formatDecimal(kerentananValue, 7);

                    layer.bindPopup(`<b>Kabupaten:</b> Cilacap<br>
                                    <b>Kecamatan:</b> ${feature.properties.Kecamatan || 'N/A'}<br>
                                    <b>Desa:</b> ${feature.properties.NAMOBJ || 'N/A'}<br>
                                    <b>Ratio:</b> ${formattedKerentananValue}<br>
                                    <b>Kelas:</b> ${feature.properties.Kelas_Cat || 'N/A'}`);
                    layer.bindTooltip(`<b></b> ${feature.properties.NAMOBJ || 'N/A'}`, {
                            permanent: true, 
                            direction: 'top',
                            className: 'kecamatan-label'
                        }); 
                },
                style: function (feature) {
                    return {
                        color: '#ffffff',
                        weight: 2,
                        opacity: 1,
                        fillColor: getColor(feature.properties.Kelas_Cat),
                        fillOpacity: 0.6
                    };
                }
            }),
            fisik: L.geoJSON(null, {
                onEachFeature: function (feature, layer) {
                    function formatDecimal(num, maxLength) {
                        if (typeof num !== 'number') {
                            console.error('Input is not a number:', num);
                            return 'N/A';
                        }
                        
                        let str = num.toFixed(0);
                        if (str.length > maxLength) {
                            return str.substring(0, maxLength - 6) + '...';
                        }
                        return str;
                    }

                    var kerentananValue = feature.properties.Kerugian_F || 0;
                    var formattedKerentananValue = formatDecimal(kerentananValue, 7);

                    layer.bindPopup(`<b>Kabupaten:</b> Cilacap<br>
                                    <b>Kecamatan:</b> ${feature.properties.Kecamatan || 'N/A'}<br>
                                    <b>Desa:</b> ${feature.properties.NAMOBJ || 'N/A'}<br>
                                    <b>Kerugian Fisik:</b> ${formattedKerentananValue}<br>
                                    <b>Kelas:</b> ${feature.properties.Kelas_Kere || 'N/A'}`);
                    layer.bindTooltip(`<b></b> ${feature.properties.NAMOBJ || 'N/A'}`, {
                            permanent: true, 
                            direction: 'top',
                            className: 'kecamatan-label'
                        });                 },
                style: function (feature) {
                    return {
                        color: '#ffffff',
                        weight: 2,
                        opacity: 1,
                        fillColor: getColor(feature.properties.Kelas_Kere),
                        fillOpacity: 0.6
                    };
                }
            }),
            ekonomi: L.geoJSON(null, {
                onEachFeature: function (feature, layer) {
                    function formatDecimal(num, maxLength) {
                        if (typeof num !== 'number') {
                            console.error('Input is not a number:', num);
                            return 'N/A';
                        }
                        
                        let str = num.toFixed(2);
                        if (str.length > maxLength) {
                            return str.substring(0, maxLength - 6) + '...';
                        }
                        return str;
                    }

                    var kerentananValue = feature.properties.Kerugian_E || 0;
                    var formattedKerentananValue = formatDecimal(kerentananValue, 7);

                    layer.bindPopup(`<b>Kabupaten:</b> Cilacap<br>
                                    <b>Kecamatan:</b> ${feature.properties.Kecamatan || 'N/A'}<br>
                                    <b>Desa:</b> ${feature.properties.NAMOBJ || 'N/A'}<br>
                                    <b>Kerugian Ekonomi:</b> ${formattedKerentananValue}<br>
                                    <b>Kelas:</b> ${feature.properties.Kelas_Kere || 'N/A'}`);
                    layer.bindTooltip(`<b></b> ${feature.properties.NAMOBJ || 'N/A'}`, {
                            permanent: true, 
                            direction: 'top',
                            className: 'kecamatan-label'
                        }); 
                },
                style: function (feature) {
                    return {
                        color: '#ffffff',
                        weight: 2,
                        opacity: 1,
                        fillColor: getColor(feature.properties.Kelas_Kere),
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

                    var kapasitasValue = feature.properties.Kelas_Kapa || 0;
                    var formattedKapasitasValue = formatDecimal(kapasitasValue, 7);

                    layer.bindPopup(`<b>Kabupaten:</b> Cilacap<br>
                                    <b>Kecamatan:</b> ${feature.properties.Kecamatan || 'N/A'}<br>
                                    <b>Nilai Kapasitas:</b> ${formattedKapasitasValue}<br>
                                    <b>Kelas Kapasitas:</b> ${feature.properties.Kelas_Kapa || 'N/A'}`);
                    layer.bindTooltip(`<b></b> ${feature.properties.NAMOBJ || 'N/A'}`, {
                            permanent: true, 
                            direction: 'top',
                            className: 'kecamatan-label'
                        }); 
                },
                style: function (feature) {
                    return {
                        color: '#ffffff',
                        weight: 2,
                        opacity: 1,
                        fillColor: getColor(feature.properties.Kelas_Kapa),
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
        loadGeoJSON('/geojson/data.geojson', layers.sosialPenduduk);
        loadGeoJSON('/geojson/data.geojson', layers.sosialRentan);
        loadGeoJSON('/geojson/data.geojson', layers.sosialCacat);
        loadGeoJSON('/geojson/data.geojson', layers.sosialRatio);
        loadGeoJSON('/geojson/data.geojson', layers.sosialKemiskinan);
        loadGeoJSON('/geojson/data.geojson', layers.fisik);
        loadGeoJSON('/geojson/data.geojson', layers.ekonomi);
        loadGeoJSON('/geojson/data.geojson', layers.kapasitas);

        // Inisialisasi legendControl sebagai null
        var legendControl = null;

        // Definisikan L.control.legend untuk membuat custom control legenda
        L.control.legend = function (options) {
            return new L.Control.Legend(options);
        };

        // Definisikan L.Control.Legend untuk menambahkan legenda pada peta
        L.Control.Legend = L.Control.extend({
            onAdd: function (map) {
                // Buat elemen div untuk legenda
                var div = L.DomUtil.create('div', 'legend');
                div.innerHTML += '<b>Legenda</b><br>';
                div.innerHTML += '<div class="gradient-bar"></div>'; // Bar gradient
                div.innerHTML += '<div class="legend-labels">';
                div.innerHTML += '<span>Rendah</span>';
                div.innerHTML += '<span>Sedang</span>';
                div.innerHTML += '<span>Tinggi</span>';
                div.innerHTML += '</div>';
                return div;
            }
        });

        // Fungsi untuk memperbarui tampilan legenda berdasarkan status checkbox
        function updateLegend() {
            // Periksa apakah ada checkbox yang aktif
            const anyLayerChecked = document.getElementById('show-bahaya').checked || 
                document.getElementById('show-sosialPenduduk').checked || 
                document.getElementById('show-sosialRentan').checked || 
                document.getElementById('show-sosialCacat').checked || 
                document.getElementById('show-sosialKemiskinan').checked || 
                document.getElementById('show-sosialRatio').checked || 
                document.getElementById('show-fisik').checked || 
                document.getElementById('show-ekonomi').checked || 
                document.getElementById('show-kapasitas').checked;

                if (anyLayerChecked) {
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
