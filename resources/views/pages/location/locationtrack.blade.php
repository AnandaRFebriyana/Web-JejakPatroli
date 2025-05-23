@extends('layout.main')

@section('content')
<div class="flex flex-wrap -mx-3">
  <div class="flex-none w-full max-w-full px-3">
    <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
      <div class="p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <h6 class="dark:text-white">Tracking Patroli Satpam</h6>
        <p class="text-sm mt-2 text-slate-500">
            Nama Satpam: <strong>{{ $location->guardRelation->name }}</strong>
        </p>
      </div>
      <div class="flex-auto px-6 pt-4 pb-6">
        <div id="map" style="height: 420px; width: 100%; border-radius: 0.75rem; overflow: hidden;"></div>
      </div>
    </div>
  </div>
</div>

<!-- Google Maps JS API -->
<script
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC_F42ahP6FP8h-SGNFgeOvxMPd8hLO0sc&callback=initMap"
  async
  defer
></script>

<script>
  function initMap() {
    const center = { lat: parseFloat('{{ $location->latitude }}'), lng: parseFloat('{{ $location->longitude }}') };
    const map = new google.maps.Map(document.getElementById("map"), {
      zoom: 17,
      center: center,
    });

    const patrolPathCoordinates = [
      center,
      { lat: center.lat + 0.0001, lng: center.lng + 0.0001 },
      { lat: center.lat + 0.0002, lng: center.lng + 0.0002 },
    ];

    const patrolPath = new google.maps.Polyline({
      path: patrolPathCoordinates,
      geodesic: true,
      strokeColor: '#0000FF',
      strokeOpacity: 1.0,
      strokeWeight: 4,
    });

    patrolPath.setMap(map);
  }
</script>
@endsection
