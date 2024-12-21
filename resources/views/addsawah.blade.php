<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Penanda Sawah</title>
    <!-- Styles and Scripts -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>

    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        #sidebar {
            width: 300px;
            height: 100%;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #f8f9fa;
            padding: 15px;
            overflow-y: auto;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        #map {
            margin-left: 300px;
            height: 100%;
            width: calc(100% - 300px);
        }

        .form-label {
            font-weight: bold;
        }

        .btn {
            width: 100%;
        }
    </style>
</head>

<body>
    <div id="sidebar">
        <h4>Tambah Data Sawah</h4>
        <form id="formSawah" method="POST" action="{{ route('store.sawah') }}">
            @csrf
            <div class="mb-3">
                <label for="owner" class="form-label">Pemilik</label>
                <input type="text" class="form-control" id="owner" name="owner">
            </div>
            <div class="mb-3">
                <label for="area" class="form-label">Luas (m²)</label>
                <input type="number" class="form-control" id="area" name="area" step="0.01">
            </div>
            <div class="mb-3">
                <label for="planting_date" class="form-label">Tanggal Tanam</label>
                <input type="date" class="form-control" id="planting_date" name="planting_date">
            </div>
            <div class="mb-3">
                <label for="commodity" class="form-label">Komoditas</label>
                <select id="commodity" name="commodity" class="form-select">
                    <option value="">Pilih</option>
                    <option value="Padi">Padi</option>
                    <option value="Jagung">Jagung</option>
                    <option value="Tebu">Tebu</option>
                </select>
            </div>
            <div class="mb-0">
                <label for="geometry-sawah" class="form-label">Geometri</label>
                <textarea id="geometry-sawah" name="geometry" rows="10" class="form-control" placeholder="Koordinat akan muncul di sini..."></textarea>
            </div>
            <input type="submit" value="Simpan" class="btn btn-dark mt-3">
        </form>
    </div>
    <div id="map"></div>

    <script>
        // Inisialisasi peta
        var map = L.map('map').setView([-7.400956378678989, 109.57867884521296], 15);

        // Menambahkan tile layer
        L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Tiles &copy; Esri'
        }).addTo(map);

        // Membuat grup untuk menggambar
        var drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);

        // Menambahkan kontrol menggambar
        var drawControl = new L.Control.Draw({
            edit: {
                featureGroup: drawnItems
            },
            draw: {
                polygon: true,    // Hanya izinkan menggambar polygon
                polyline: false,
                marker: false,
                rectangle: false,
                circle: false,
                circlemarker: false
            }
        });
        map.addControl(drawControl);

        // Event ketika geometri baru dibuat
        map.on('draw:created', function(event) {
            var layer = event.layer;
            drawnItems.addLayer(layer);

            const geojson = layer.toGeoJSON();
            console.log("GeoJSON Data:", geojson);

            // Menyimpan geometri ke textarea
            const geometryTextarea = document.getElementById('geometry-sawah');
            if (geometryTextarea) {
                let coordinates = geojson.geometry.coordinates;

                if (geojson.geometry.type === 'Polygon') {
                    if (Array.isArray(coordinates[0])) {
                        coordinates = coordinates[0]; // Ambil koordinat pertama
                    }
                    coordinates = coordinates.map(coord => [coord[1], coord[0]]); // Tukar lat dan lng
                }

                // Konversi ke JSON dan tampilkan di textarea
                geometryTextarea.value = JSON.stringify(coordinates);
                console.log("Coordinates:", geometryTextarea.value);
            }
        });

        // Validasi form saat submit
        document.getElementById('formSawah').addEventListener('submit', function(e) {
            const geometryTextarea = document.getElementById('geometry-sawah');
            if (!geometryTextarea || !geometryTextarea.value.trim()) {
                e.preventDefault(); // Cegah submit jika geometri kosong
                alert('Pastikan Anda menggambar geometri pada peta!');
            }
        });
    </script>
</body>

</html>