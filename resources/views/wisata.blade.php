@extends("layouts.dashboard")
@section("content")
<section>
    <div id="map"></div>

    <div>
        @foreach ($wisatadata as $wisata)
        <input type="hidden" id="geometry-{{ $wisata['id'] }}" value="{{ $wisata['geometry'] }}">
        @endforeach
    </div>

    <script>
        var map = L.map('map').setView([-7.400956378678989, 109.57867884521296], 15);
        
        L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
        }).addTo(map);

        @foreach($wisatadata as $wisata)
        var geometry = document.getElementById('geometry-{{$wisata['id']}}').value;

        console.log(geometry);
        var coordinates = JSON.parse(geometry);

        var marker = L.marker(coordinates).addTo(map);
        marker.bindPopup(
            '<strong>Nama Wisata :</strong> {{ $wisata['name'] }}<br>' +
            '<strong>Deskripsi    :</strong> {{ $wisata['description'] }}<br>'
        );
        @endforeach
    </script>
</section>
@endsection