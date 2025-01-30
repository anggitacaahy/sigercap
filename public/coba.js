document.addEventListener("DOMContentLoaded", () => {
    // Inisialisasi peta
    var map = L.map('mapid').setView([-7.736, 109.006], 10); // Koordinat dan zoom level sesuai lokasi Anda

    // Tambahkan tile layer dari OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Muat GeoJSON
    fetch('http://localhost:8080/public/geojson/Bahaya_Cilacap.geojson')
        .then(response => {
            console.log('Response status:', response.status); // Debugging tambahan
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            console.log('GeoJSON data:', data); // Debugging tambahan
            L.geoJSON(data, {
                style: function(feature) {
                    return {
                        color: 'red', // Warna garis
                        weight: 2 // Ketebalan garis
                    };
                },
                onEachFeature: function(feature, layer) {
                    // Menambahkan popup untuk setiap fitur
                    if (feature.properties && feature.properties.name) {
                        layer.bindPopup(feature.properties.name);
                    }
                }
            }).addTo(map);
        })
        .catch(error => {
            console.error('Error loading the GeoJSON file:', error);
        });
});
