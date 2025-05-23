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
        <div class="mt-4 rounded-2xl overflow-hidden">
          <iframe
            width="100%"
            height="420"
            frameborder="0"
            style="border:0;"
            src="https://www.google.com/maps/embed/v1/view?key=AIzaSyC_F42ahP6FP8h-SGNFgeOvxMPd8hLO0sc&center={{ $location->latitude }},{{ $location->longitude }}&zoom=17"
            allowfullscreen>
          </iframe>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
