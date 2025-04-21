<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tracking Realtime Satpam</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        #map { height: 100vh; }
    </style>
</head>
<body>

<div id="map"></div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    const map = L.map('map').setView([-7.8, 110.36], 15); // posisi default
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap'
    }).addTo(map);

    let marker = null;

    function updateLocation() {
        fetch('/api/latest-tracking?satpam_id=1') // ganti ID sesuai satpam
            .then(res => res.json())
            .then(data => {
                if (data.latitude && data.longitude) {
                    const pos = [data.latitude, data.longitude];
                    if (marker) {
                        marker.setLatLng(pos);
                    } else {
                        marker = L.marker(pos).addTo(map).bindPopup("Satpam").openPopup();
                    }
                    map.setView(pos, 16);
                }
            });
    }

    setInterval(updateLocation, 3000);
    updateLocation();
</script>

</body>
</html>