@extends('layout.main')

@section('content')
<!-- table 1 -->
<div class="flex flex-wrap -mx-3">
  <div class="flex-none w-full max-w-full px-3">
    <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
      <div class="p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <h6 class="dark:text-white">Tracking Patroli Satpam</h6>
        <h6 class="dark:text-white">Data Tracking</h6>
        <div class="flex justify-end">
            <button data-bs-toggle="modal" data-bs-target="#locModal"
              class="inline-block px-8 py-2 mb-4 font-bold leading-normal text-center text-white align-middle transition-all ease-in bg-tosca border-0 rounded-lg shadow-md cursor-pointer text-xs tracking-tight-rem hover:shadow-xs hover:-translate-y-px active:opacity-85">Tambah</button>
            @include('pages.location.create')
        </div>
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
                <th class="px-6 py-3 font-bold text-center uppercase text-xxs">Tanggal</th>
                <th class="px-6 py-3 font-bold text-center uppercase text-xxs">Check In</th>
                <th class="px-6 py-3 font-bold text-center uppercase text-xxs">Check Out</th>
                <th class="px-6 py-3 font-bold text-center uppercase text-xxs">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($locations as $index => $location)
              <tr class="location-row">
                <td class="p-2 text-center">{{ $index + 1 }}</td>
                <td class="p-2 text-center">{{ $location->location_name }}</td>
                <td class="p-2 text-center">{{ \Carbon\Carbon::parse($location->created_at)->format('Y-m-d') }}</td>
                <td class="p-2 text-center">{{ $location->check_in }}</td>
                <td class="p-2 text-center">{{ $location->check_out }}</td>
                <td class="p-2 text-center">
                  <!-- Tombol Show Tracking -->
                  <a href="{{ route('location.show', $location->id) }}" class="text-xs text-green-500">
                    <i class="fas fa-map-marked-alt"></i> Show Tracking
                  </a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          @include('pages.location.edit')
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
