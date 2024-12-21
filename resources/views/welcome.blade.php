<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Geometry</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-draw/dist/leaflet.draw.css"/>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-draw/dist/leaflet.draw.js"></script>
</head>
<body>
    <h1>Form Geometry (Polygon)</h1>
    <form action="#" method="POST">
        <label for="geometry">Polygon Lokasi (Koordinat GeoJSON):</label><br>
        <textarea id="geometry" name="geometry" rows="6" cols="80" placeholder="Koordinat Polygon dalam format GeoJSON akan muncul di sini..." readonly></textarea>
        <br><br>

        <div id="map" style="width: 600px; height: 400px;"></div>
        <br>

        <button type="submit">Simpan</button>
    </form>

    <script>
        // Inisialisasi Peta
        var map = L.map('map').setView([-7.123456, 110.987654], 12); // Pusatkan peta di koordinat default

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Tambahkan fitur Leaflet Draw
        var drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);

        var drawControl = new L.Control.Draw({
            edit: {
                featureGroup: drawnItems
            },
            draw: {
                polygon: true,
                polyline: true,
                circle: true,
                rectangle: true,
                marker: true
            }
        });

        map.addControl(drawControl);

        // Event listener untuk menangkap Polygon yang digambar
        map.on('draw:created', function (event) {
            var layer = event.layer;
            drawnItems.addLayer(layer);

            // Dapatkan data GeoJSON dari Polygon yang digambar
            var geojson = layer.toGeoJSON();

            // Menyimpan GeoJSON dalam input teks
            document.getElementById('geometry').value = JSON.stringify(geojson);
        });
    </script>
</body>
</html>
