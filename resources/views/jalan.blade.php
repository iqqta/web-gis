@extends("layouts.dashboard")
@section("content")
<section>
    <div id="map"></div>

    <div>
        @foreach ($jalandata as $jalan)
        <input type="hidden" id="geometry-{{ $jalan['id'] }}" value="{{ $jalan['geometry'] }}">
        @endforeach
    </div>

    <script>
        // Inisialisasi peta
        var map = L.map('map').setView([-7.400956378678989, 109.57867884521296], 15);

        // Tambahkan tile layer
        L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
        }).addTo(map);

        // Ambil data dari elemen HTML dan parse JSON geometry
        @foreach($jalandata as $jalan)
        var geometry = document.getElementById('geometry-{{$jalan['id']}}').value;
        
        console.log(geometry);

        var coordinates = JSON.parse(geometry); // Parsing string JSON menjadi array

        // Membuat polyline dengan koordinat yang diparse
        var polyline = L.polyline(coordinates, {
            color: '{{ $jalan['condition'] == 'baik' ? 'blue' : ($jalan['condition'] == 'sedang' ? 'yellow' : ($jalan['condition'] == 'buruk' ? 'red' : 'defaultcolor'))}}', // Anda bisa menyesuaikan warnanya sesuai dengan kondisi jalan
            weight: 3,
            opacity: 0.7
        }).bindPopup(
            '<strong>Nama Jalan     :</strong> {{ $jalan['road_name'] }}<br>' +
            '<strong>Kondisi Jalan  :</strong> {{ $jalan['condition'] }}<br>' 
        ).addTo(map);
        @endforeach
    </script>
</section>
@endsection
