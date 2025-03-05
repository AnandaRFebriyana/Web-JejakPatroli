@extends('layout.main')

@section('content')
<div class="flex flex-wrap -mx-3">
  <div class="w-full max-w-full px-3 mt-6 md:w-7/12 md:flex-none">
    <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
      <div class="p-6 px-4 pb-0 mb-0 border-b-0 rounded-t-2xl">
        <h6 class="mb-0 dark:text-white">Detail Kehadiran</h6>
      </div>
      <div class="flex-auto p-4 pt-6">
        <ul class="flex flex-col pl-0 mb-0 rounded-lg">
          <li class="relative flex p-6 mb-2 border-0 rounded-t-inherit rounded-xl bg-gray-50 dark:bg-slate-850">
            <div class="flex flex-col">
              <span class="mb-2 text-sm leading-tight dark:text-white/80">Nama Satpam: <span class="font-semibold text-slate-700 dark:text-white sm:ml-2">{{ $attendance->guardRelation->name }}</span></span>
              <span class="mb-2 text-sm leading-tight dark:text-white/80">Jam Kerja: <span class="font-semibold text-slate-700 dark:text-white sm:ml-2">{{ $attendance->shift->start_time }} - {{ $attendance->shift->end_time }}</span></span>
              <span class="mb-2 text-sm leading-tight dark:text-white/80">Jam Masuk: <span class="font-semibold text-slate-700 dark:text-white sm:ml-2">{{ $attendance->check_in_time ?? '-' }}</span></span>
              <span class="mb-2 text-sm leading-tight dark:text-white/80">Jam Pulang: <span class="font-semibold text-slate-700 dark:text-white sm:ml-2">{{ $attendance->check_out_time ?? '-' }}</span></span>
              <span class="mb-2 text-sm leading-tight dark:text-white/80">Alamat Presensi: <span class="font-semibold text-slate-700 dark:text-white sm:ml-2">{{ $attendance->location_address }}</span></span>           
              <span class="text-sm leading-tight dark:text-white/80">Bukti Kehadiran: 
                <span class="font-semibold text-slate-700 dark:text-white sm:ml-2">
                    @if($attendance->photo)
                        <img src="{{ asset('storage/' . $attendance->photo) }}" style="max-width: 200px; height: auto;" class="rounded-lg shadow-lg mt-2">
                    @else
                         Tidak Ada
                    @endif
                </span>
            </span>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
  
  <div class="w-full max-w-full px-3 mt-6 md:w-5/12 md:flex-none">
    <div class="relative flex flex-col h-full min-w-0 mb-6 break-words bg-white border-0 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
      <div class="p-6 px-4 pb-0 mb-0 border-b-0 rounded-t-2xl">
        <div class="flex flex-wrap -mx-3">
          <div class="max-w-full px-3 md:w-1/2 md:flex-none">
            <h6 class="mb-0 dark:text-white">Lokasi Presensi</h6>
          </div>
          <div class="flex items-center justify-end max-w-full px-3 dark:text-white/80 md:w-1/2 md:flex-none">
            <i class="mr-2 far fa-calendar-alt"></i>
            <small>{{ $attendance->date->translatedFormat('l, d-m-Y') }}</small>
          </div>
        </div>
      </div>
      <div class="flex-auto p-4">
        <div id="map" style="height: 400px;"></div>
      </div>
    </div>
  </div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  var latitude = {{ $attendance->latitude ?? 0 }};
  var longitude = {{ $attendance->longitude ?? 0 }};
  
  if (latitude !== 0 && longitude !== 0) {
    var map = L.map('map').setView([latitude, longitude], 13);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    L.marker([latitude, longitude]).addTo(map)
      .bindPopup('Lokasi Presensi')
      .openPopup();
  } else {
    var map = L.map('map').setView([-6.200000, 106.816666], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
  }

  var targetLatitude = -8.157617462676438;
  var targetLongitude = 113.72278314484412;
  var allowedDistance = 400;

  var circle = L.circle([targetLatitude, targetLongitude], {
      color: 'blue',
      fillColor: '#cce6ff',
      fillOpacity: 0.4,
      radius: allowedDistance
  }).addTo(map);
});
</script>
@endsection