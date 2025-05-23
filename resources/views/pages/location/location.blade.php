@extends('layout.main')

@section('content')
<!-- table 1 -->
<div class="flex flex-wrap -mx-3">
  <div class="flex-none w-full max-w-full px-3">
    <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
      <div class="p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <h6 class="dark:text-white">Tracking Patroli Satpam</h6>
        <h6 class="dark:text-white">Data Tracking</h6>

        <div class="flex md:pr-4">
          <div class="relative flex flex-wrap items-stretch transition-all rounded-lg ease">
            <span class="text-sm ease leading-5.6 absolute z-50 -ml-px flex h-full items-center whitespace-nowrap rounded-lg rounded-tr-none rounded-br-none border border-r-0 border-transparent bg-transparent py-2 px-2.5 text-center font-normal text-slate-500 transition-all">
              <i class="fas fa-search"></i>
            </span>
            <input id="search" type="text" class="pl-9 text-sm focus:shadow-primary-outline ease w-1/100 leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow" placeholder="Cari Satpam" />
          </div>
        </div>
      </div>
      <div class="flex-auto px-0 pt-0 pb-2">
        <div class="p-0 overflow-x-auto">
            <table class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500">
                <thead class="align-bottom">
                  <tr>
                    <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap">No</th>
                    <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap">Nama Satpam</th>
                    <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap">Tanggal</th>
                    <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                    @if ($location)
                      <tr class="border-b border-gray-200 dark:border-gray-700">
                        <td class="p-3 text-center">1</td>
                        <td class="p-3 text-center">
                            {{ $location->guardRelation ? $location->guardRelation->name : 'Tidak ditemukan' }}
                        </td>
                        <td class="p-3 text-center">{{ \Carbon\Carbon::parse($location->created_at)->format('Y-m-d') }}</td>
                        <td class="p-3 text-center">
                          <a href="{{ route('location.showtrack', ['location' => $location->id]) }}" class="inline-flex items-center px-3 py-1 text-xs font-medium text-xxx bg-green-500 rounded hover:bg-green-600">
                            <i class="fas fa-map-marked-alt mr-1"></i> Tampilkan Tracking
                          </a>
                        </td>
                      </tr>
                    @else
                      <tr>
                        <td colspan="4" class="text-center">Data lokasi tidak ditemukan</td>
                      </tr>
                    @endif
                  </tbody>
              </table>
          @include('pages.location.edit')
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
