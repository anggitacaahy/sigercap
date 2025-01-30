// Inisialisasi peta
var map = L.map("mapid").setView([-7.732049, 109.031729], 13);

// Tambahkan layer OpenStreetMap
L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
  maxZoom: 19,
}).addTo(map);

// Variabel marker untuk menampung marker lokasi
var marker;

// Fungsi untuk mendapatkan lokasi saat ini
function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else {
    alert("Geolocation is not supported by this browser.");
  }
}

// Fungsi untuk menampilkan posisi saat ini
function showPosition(position) {
  var lat = position.coords.latitude;
  var lon = position.coords.longitude;

  document.getElementById("latitude").value = lat;
  document.getElementById("longitude").value = lon;

  if (marker) {
    map.removeLayer(marker);
  }

  marker = L.marker([lat, lon]).addTo(map);
  map.setView([lat, lon], 13);
}

// Fungsi untuk memilih lokasi dengan klik pada peta
function pickLocation() {
  map.on("click", function (e) {
    var lat = e.latlng.lat;
    var lng = e.latlng.lng;

    document.getElementById("latitude").value = lat;
    document.getElementById("longitude").value = lng;

    if (marker) {
      map.removeLayer(marker);
    }

    marker = L.marker([lat, lng]).addTo(map);
  });
}