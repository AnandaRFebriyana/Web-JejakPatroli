@extends('layout.main')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<style>
    #map {
        height: 500px !important;
        width: 100% !important;
        border-radius: 0.75rem;
        position: relative !important;
        z-index: 0 !important;
    }
    .map-container {
        height: 500px;
        width: 100%;
        position: relative;
        border-radius: 0.75rem;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .leaflet-container {
        height: 100%;
        width: 100%;
    }
    .custom-popup .leaflet-popup-content-wrapper {
        background: rgba(255,255,255,0.9);
        border-radius: 10px;
    }
    .patrol-info {
        padding: 5px;
    }
    .patrol-info h4 {
        margin: 0 0 5px;
        color: #333;
    }
    .patrol-info p {
        margin: 0;
        color: #666;
    }
    .status-badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 9999px;
        font-size: 12px;
        font-weight: 500;
    }
    .status-active {
        background-color: #dcfce7;
        color: #166534;
    }
    .status-inactive {
        background-color: #f3f4f6;
        color: #374151;
    }
    .patrol-stats {
        background: white;
        padding: 10px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        margin-bottom: 10px;
    }
    .patrol-stats p {
        margin: 5px 0;
    }
    .legend {
        background: white;
        padding: 10px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        position: absolute;
        bottom: 20px;
        right: 20px;
        z-index: 1000;
    }
    .legend-item {
        display: flex;
        align-items: center;
        margin: 5px 0;
    }
    .legend-color {
        width: 20px;
        height: 20px;
        margin-right: 8px;
        border-radius: 50%;
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Tracking Lokasi Satpam</h6>
                            @if(!isset($showAllTracks))
                            <p class="text-sm mb-0">
                                Nama Satpam: <strong class="text-primary">{{ $location->guardRelation->name }}</strong>
                            </p>
                            <p class="text-sm mb-0">
                                Tanggal: <strong>{{ \Carbon\Carbon::parse($location->created_at)->format('d M Y') }}</strong>
                            </p>
                            <p class="text-sm mb-0">
                                Shift: <strong>{{ $location->attendance->shift->shift_name }} 
                                ({{ \Carbon\Carbon::parse($location->attendance->shift->start_time)->format('H:i') }} - 
                                {{ \Carbon\Carbon::parse($location->attendance->shift->end_time)->format('H:i') }})</strong>
                            </p>
                            <p class="text-sm mb-0">
                                Status: 
                                <span class="status-badge {{ $location->is_active ? 'status-active' : 'status-inactive' }}">
                                    {{ $location->is_active ? 'Sedang Berpatroli' : 'Selesai' }}
                                </span>
                            </p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    @if(!isset($showAllTracks))
                    <!-- Patrol Stats -->
                    <div class="patrol-stats mx-4">
                        <div class="row">
                            <div class="col-md-4">
                                <p class="text-sm text-muted">Waktu Mulai</p>
                                <p class="font-weight-bold">{{ $location->attendance->check_in_time }}</p>
                            </div>
                            <div class="col-md-4">
                                <p class="text-sm text-muted">Waktu Selesai</p>
                                <p class="font-weight-bold">{{ $location->attendance->check_out_time ?? 'Masih Berpatroli' }}</p>
                            </div>
                            <div class="col-md-4">
                                <p class="text-sm text-muted">Total Titik Patroli</p>
                                <p class="font-weight-bold">{{ $trackingPoints->count() }} titik</p>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Map Card -->
                    <div class="mx-4">
                        <div class="map-container">
                            <div id="map"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize map with a default center (will be updated)
    const map = L.map('map', {
        center: [-7.9666204, 112.6326321], // Default to Malang City coordinates
        zoom: 14,
        zoomControl: true,
        scrollWheelZoom: true
    });

    // Add OpenStreetMap tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(map);

    @if(isset($showAllTracks))
    // Handle multiple tracks
    const allTracks = @json($allLocations);
    const bounds = L.latLngBounds();
    
    Object.entries(allTracks).forEach(([attendanceId, points], trackIndex) => {
        if (points.length > 0) {
            const coordinates = points.map(point => [point.latitude, point.longitude]);
            
            // Create path with unique color
            const hue = (trackIndex * 137.508) % 360;
            const color = `hsl(${hue}, 70%, 50%)`;
            
            // Draw the path
            const path = L.polyline(coordinates, {
                color: color,
                weight: 4,
                opacity: 0.8,
                lineJoin: 'round'
            }).addTo(map);

            // Add markers
            coordinates.forEach((coord, index) => {
                const point = points[index];
                const isFirst = index === 0;
                const isLast = index === coordinates.length - 1;
                
                let markerColor = 'blue';
                if (isFirst) markerColor = 'green';
                if (isLast) markerColor = 'red';

                const marker = L.marker(coord, {
                    icon: L.icon({
                        iconUrl: `https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-${markerColor}.png`,
                        iconSize: [25, 41],
                        iconAnchor: [12, 41],
                        popupAnchor: [1, -34],
                    })
                }).addTo(map);

                const time = new Date(point.created_at).toLocaleTimeString();
                marker.bindPopup(`
                    <div class="patrol-info">
                        <h4>${point.guard_relation.name}</h4>
                        <p>Waktu: ${time}</p>
                        <p>Shift: ${point.attendance.shift.shift_name}</p>
                    </div>
                `);

                bounds.extend(coord);
            });
        }
    });

    // Fit map to show all tracks
    if (!bounds.isEmpty()) {
        map.fitBounds(bounds, { padding: [50, 50] });
    }
    @else
    // Single track display
    const locationId = {{ $location->id }};
    const patrolCoordinates = @json($trackingPoints->map(function($point) {
        return [$point->latitude, $point->longitude];
    }));

    if (patrolCoordinates.length > 0) {
        // Create and add the patrol path
        const patrolPath = L.polyline(patrolCoordinates, {
            color: '#2563eb',
            weight: 4,
            opacity: 0.8,
            lineJoin: 'round'
        }).addTo(map);

        // Only add markers for first and last points
        const firstPoint = patrolCoordinates[0];
        const lastPoint = patrolCoordinates[patrolCoordinates.length - 1];

        // Add start marker (green)
        const startMarker = L.marker(firstPoint, {
            icon: L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
            })
        }).addTo(map);

        // Add end marker (red)
        const endMarker = L.marker(lastPoint, {
            icon: L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
            })
        }).addTo(map);

        // Add popups for start and end markers
        const firstPointData = @json($trackingPoints)[0];
        const lastPointData = @json($trackingPoints)[patrolCoordinates.length - 1];
        
        const startTime = new Date(firstPointData.created_at).toLocaleTimeString();
        const endTime = new Date(lastPointData.created_at).toLocaleTimeString();
        
        startMarker.bindPopup(`
            <div class="patrol-info">
                <h4>Titik Awal</h4>
                <p>Waktu: ${startTime}</p>
            </div>
        `);

        endMarker.bindPopup(`
            <div class="patrol-info">
                <h4>Titik Akhir</h4>
                <p>Waktu: ${endTime}</p>
            </div>
        `);

        // Fit map to show all points
        map.fitBounds(patrolPath.getBounds(), { padding: [50, 50] });
    }
    @endif
});
</script>
@endpush
