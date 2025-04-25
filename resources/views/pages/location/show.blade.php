@extends('layout.main')

@section('content')
  <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">Tracking Lokasi Real Time: {{ $location->location_name }}</h2>

  <div id="map" style="height: 500px; border-radius: 12px; overflow: hidden;"></div>

  {{-- Leaflet CSS & JS --}}
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

  <script>
    // Koordinat fallback jika tidak ada data
    const latitude = {{ $location->latitude ?? -8.157581 }};
    const longitude = {{ $location->longitude ?? 113.722996 }};

    const map = L.map('map').setView([latitude, longitude], 17);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    L.marker([latitude, longitude])
      .addTo(map)
      .bindPopup("Lokasi: {{ $location->location_name }}")
      .openPopup();
  </script>
@endsection