@extends("layouts.dashboard")
@section("content")
<section>
    <div id="map"></div>

    <div>
        @foreach ($sawahdata as $sawah)
        <input type="hidden" id="geometry-{{ $sawah['id'] }}" value="{{ $sawah['geometry'] }}">
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
        @foreach($sawahdata as $sawah)
        var geometry = document.getElementById('geometry-{{$sawah['id']}}').value;
        
        console.log(geometry);

        var coordinates = JSON.parse(geometry); // Parsing string JSON menjadi array

        // Membuat polygon dengan koordinat yang diparse
        var polygon = L.polygon(coordinates, {
            color: '{{ $sawah['commodity'] == 'Padi' ? 'red' : ($sawah['commodity'] == 'Jagung' ? 'yellow' : ($sawah['commodity'] == 'Tebu' ? 'blue' : 'defaultcolor'))}}',
            weight: 2
        }).bindPopup(
            '<strong>Pemilik       :</strong> {{ $sawah['owner'] }}<br>' +
            '<strong>Komoditas     :</strong> {{ $sawah['commodity'] }}<br>' +
            '<strong>Luas          :</strong> {{ $sawah['area'] }} m<sup>2</sup><br>' +
            '<strong>Tanggal tanam :</strong> {{ \Carbon\Carbon::parse($sawah['planting_date'])->toDateString() }}'
        ).addTo(map);
        @endforeach
    </script>
</section>
@endsection