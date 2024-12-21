<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GIS Desa Lengkong - SINGLE</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin="" />

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl5/39d3vb8+K6i2eMxHQe4Pw5UmC4/pvSKgwoVZ15"
        crossorigin="anonymous">

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

        .content {
            padding-top: 70px;
            background-color: #f0f0f0;
        }

        .list-group-item:hover,
        .list-group-item:active,
        .list-group-item.active {
            background-color: #000;
            color: #fff;
            border: none;
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
            <div class="d-flex flex-column" id="list-tab" role="tablist">
                <a class="btn mb-2"
                    style="background-color: black; color: white;"
                    id="list-home-list"
                    href="{{ route('sawah') }}"
                    role="tab"
                    aria-controls="list-home">
                    Persawahan
                </a>
                <a class="btn mb-2"
                    style="background-color: black; color: white;"
                    id="list-profile-list"
                    href="{{ route('jalan') }}"
                    role="tab"
                    aria-controls="list-profile">
                    Kondisi Jalan
                </a>
                <a class="btn mb-2" 
                    style="background-color: black; color: white;"
                    id="list-messages-list"
                    href="{{ route('wisata') }}"
                    role="tab"
                    aria-controls="list-messages">
                    Wisata Edukasi
                </a>
                <a class="btn mb-2"
                    style="background-color: black; color: white;"
                    id="list-messages-list"
                    href="{{ route('addsawah') }}"
                    role="tab"
                    aria-controls="list-messages">
                    Tambah Data Sawah
                </a>
                <a class="btn mb-2"
                    style="background-color: black; color: white;"
                    id="list-messages-list"
                    href="{{ route('addjalan') }}"
                    role="tab"
                    aria-controls="list-messages">
                    Tambah Data Jalan
                </a>
                <a class="btn mb-2"
                    style="background-color: black; color: white;"
                    id="list-messages-list"
                    href="{{ route('addwisata') }}"
                    role="tab"
                    aria-controls="list-messages">
                    Tambah Data Wisata
                </a>
            </div>
        </div>


        <!-- Content -->
        <div class="container" style="margin-left: 250px;">
            @yield('content')
        </div>
    </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-mzA7Kz2LkgDb68/33B4mExjAU1Nf0cf1SmA4BfbkniFIqjN8gaRrTlZeLih6k1g7" crossorigin="anonymous"></script>

</body>

</html>