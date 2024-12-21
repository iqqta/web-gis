<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GIS Desa Lengkong</title>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-draw/dist/leaflet.draw.css" />
    <script src="https://unpkg.com/leaflet-draw/dist/leaflet.draw.js"></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            color: #333;
        }

        #map {
            height: 90vh;
            width: 100%;
            margin-top: 10px;
            border-radius: 10px;
        }

        .form-data.d-none {
            display: none;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar bg-white">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">Sistem Informasi Geografis Desa Lengkong</span>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="d-flex">
        <div style="width: 250px; position: fixed; top: 56px; bottom: 0; left: 0; margin-top: 5px; padding-left: 10px;">
            <form id="formType" class="d-flex flex-column" method="POST" action="{{route('store.jalan') }}">
                @csrf
                <!-- Dropdown Pilihan -->
                <div class="mb-3">
                    <label for="typeSelector" class="form-label">Pilih Tipe Penanda</label>
                    <select id="typeSelector" class="form-select" name="type">
                        <option value=""> Pilih </option>
                        <option value="sawah">Sawah</option>
                        <option value="jalan">Jalan</option>
                        <option value="wisata">Wisata</option>
                    </select>
                </div>

                <!-- Form Sawah -->
                <div id="formSawah" class="form-data d-none">
                    <div class="mb-3">
                        <label for="owner" class="form-label">Pemilik</label>
                        <input type="text" class="form-control" id="owner" name="owner">
                    </div>
                    <div class="mb-3">
                        <label for="area" class="form-label">Luas (m<sup>2</sup>)</label>
                        <input type="number" class="form-control" id="area" name="area" step="0.01">
                    </div>
                    <div class="mb-3">
                        <label for="planting_date" class="form-label">Tanggal Tanam</label>
                        <input type="date" class="form-control" id="planting_date" name="planting_date">
                    </div>
                    <div class="mb-3">
                        <label for="commodity" class="form-label">Komoditas</label>
                        <select id="commodity" name="commodity" class="form-select">
                            <option value=""> Pilih </option>
                            <option value="Padi">Padi</option>
                            <option value="Jagung">Jagung</option>
                            <option value="Blue">Tebu</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="geometry" class="form-label">Geometri</label><br>
                        <textarea id="geometry-sawah" name="geometry" rows="5" cols="80" class="form-control" placeholder="Koordinat akan muncul di sini..."></textarea>
                    </div>
                </div>

                <!-- Form Jalan -->
                <div id="formJalan" class="form-data d-none">
                    <div class="mb-3">
                        <label for="road_name" class="form-label">Nama Jalan</label>
                        <input type="text" class="form-control" id="road_name" name="road_name">
                    </div>
                    <div class="mb-3">
                        <label for="condition" class="form-label">Kondisi</label>
                        <input type="text" class="form-control" id="condition" name="condition">
                    </div>
                    <div class="mb-3">
                        <label for="geometry" class="form-label">Geometri</label><br>
                        <textarea id="geometry-jalan" name="geometry" rows="12" cols="80" class="form-control" placeholder="Koordinat akan muncul di sini..." readonly></textarea>
                    </div>
                </div>

                <!-- Form Wisata -->
                <div id="formWisata" class="form-data d-none">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Wisata</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="geometry" class="form-label">Geometri</label><br>
                        <textarea id="geometry-wisata" name="geometry" rows="10" cols="80" class="form-control" placeholder="Koordinat akan muncul di sini..." readonly></textarea>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <input type="submit" value="Simpan" class="btn btn-dark mt-3"></input>
            </form>
        </div>

        <!-- Main Content -->
        <div class="container" style="margin-left: 250px;">
            <div id="map"></div>
        </div>
    </div>

    <script>
        var map = L.map('map').setView([-7.400956378678989, 109.57867884521296], 15);
        L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Tiles &copy; Esri'
        }).addTo(map);

        var drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);

        var drawControl = new L.Control.Draw({
            edit: {
                featureGroup: drawnItems
            },
            draw: {}
        });
        map.addControl(drawControl);

        const updateDrawControl = (type) => {
            map.removeControl(drawControl);
            const drawOptions = {
                polygon: false,
                polyline: false,
                marker: false,
                circle: false,
                rectangle: false,
                circlemarker: false
            };
            if (type === 'sawah') drawOptions.polygon = true;
            if (type === 'jalan') drawOptions.polyline = true;
            if (type === 'wisata') drawOptions.marker = true;
            drawControl = new L.Control.Draw({
                edit: {
                    featureGroup: drawnItems
                },
                draw: drawOptions
            });
            map.addControl(drawControl);
        };

        const updateAction = (type) => {
            const form = document.getElementById('formType');
            switch (type) {
                case 'sawah':
                    form.action = "{{ route('store.sawah') }}";
                    break;
                case 'jalan':
                    form.action = "{{ route('store.jalan') }}";
                    break;
                case 'wisata':
                    form.action = "{{ route('store.wisata') }}";
                    break;
                default:
                    form.action = "#"; // Kosongkan action jika tipe tidak dipilih
            }
        };

        document.getElementById('typeSelector').addEventListener('change', (e) => {
            const selectedType = e.target.value;
            updateDrawControl(selectedType);
            document.querySelectorAll('.form-data').forEach(form => form.classList.add('d-none'));
            if (selectedType) document.getElementById(`form${selectedType.charAt(0).toUpperCase() + selectedType.slice(1)}`).classList.remove('d-none');
        });

        map.on('draw:created', function(event) {
            console.log('Draw created event triggered');
            var layer = event.layer;
            drawnItems.addLayer(layer);

            const selectedType = document.getElementById('typeSelector').value;
            if (!selectedType) {
                alert('Silakan pilih tipe terlebih dahulu!');
                return;
            }

            const geojson = layer.toGeoJSON();
            console.log(geojson); // Debug log

            const geometryTextarea = document.getElementById(`geometry-${selectedType}`);
            console.log(`Geometry Textarea:`, geometryTextarea ? geometryTextarea.value : 'Textarea not found');
            if (geometryTextarea) {
                let coordinates = geojson.geometry.coordinates;

                // Handle different types of geometry
                if (geojson.geometry.type === 'Point') {
                    // For Marker, coordinates is a pair [lat, lng]
                    coordinates = [coordinates[1], coordinates[0]]; // Swap lat and lng
                } else if (geojson.geometry.type === 'Polygon') {
                    // For Polygon, coordinates may be an array of arrays
                    if (Array.isArray(coordinates[0])) {
                        coordinates = coordinates[0]; // For Polygon, get the first array
                    }
                    // Swap lat and lng for all coordinates
                    coordinates = coordinates.map(coord => [coord[1], coord[0]]);
                } else if (geojson.geometry.type === 'LineString') {
                    // For Polyline, coordinates is an array of points [lat, lng]
                    coordinates = coordinates.map(coord => [coord[1], coord[0]]); // Swap lat/lng for polyline
                }

                // Convert to plain text with brackets retained
                const coordinatesText = JSON.stringify(coordinates); // This will keep the array structure as text

                geometryTextarea.value = coordinatesText; // Set plain text value with brackets
                console.log("Swapped Coordinates:", coordinatesText);
            } else {
                alert('Textarea untuk tipe ini tidak ditemukan!');
            }
        });


        document.getElementById('formType').addEventListener('submit', function(e) {
            const selectedType = document.getElementById('typeSelector').value;
            const geometryTextarea = document.getElementById(`geometry-${selectedType}`);
            console.log("Geometry Textarea Value Before Submit:", geometryTextarea.value);

            if (!geometryTextarea || !geometryTextarea.value.trim()) {
                e.preventDefault(); // Cegah submit jika geometry kosong
                alert('Pastikan Anda menggambar geometri pada peta!');
                return;
            }
        });
    </script>
</body>

</html>