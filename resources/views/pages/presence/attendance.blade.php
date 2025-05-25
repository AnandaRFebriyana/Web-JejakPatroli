@extends('layout.main')
@section('content')
        <div class="flex flex-wrap -mx-3">
          <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
              <div class="p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                <h6 class="dark:text-white">Presensi</h6>
                {{-- <div class="flex justify-end">
                    <a href="/presence/create"
                    class="inline-block px-8 py-2 mb-4 font-bold leading-normal text-center text-white align-middle transition-all ease-in bg-tosca border-0 rounded-lg shadow-md cursor-pointer text-xs tracking-tight-rem hover:shadow-xs hover:-translate-y-px active:opacity-85">Tambah</a>
                </div> --}}
                {{-- <div class="flex flex-wrap">
                  <div class="mb-4 mx-4 flex flex-col relative">
                      <label for="start-date" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Tanggal Mulai</label>
                      <input type="date" id="start-date" name="start-date" class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" style="max-width: 250px;">
                  </div>
                  <div class="mb-4 mx-4 flex flex-col relative">
                      <label for="end-date" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Tanggal Akhir</label>
                      <input type="date" id="end-date" name="end-date" class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" style="max-width: 250px;">
                  </div>
                  <div class="mb-4 mx-4 flex flex-col relative">
                    <button id="filter-button" class="inline-block px-8 py-2 mb-4 font-bold leading-normal text-center text-white align-middle transition-all ease-in bg-tosca border-0 rounded-lg shadow-md cursor-pointer text-xs tracking-tight-rem hover:shadow-xs hover:-translate-y-px active:opacity-85">Filter</button>
                  </div>
                </div> --}}
            </div>

            {{-- Search Form --}}
            <div class="flex flex-wrap mt-4 px-6">
                <form action="{{ route('presence.index') }}" method="GET" class="flex flex-wrap w-full">
                    <div class="mb-4 mr-4 flex flex-col relative">
                        <label for="search" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Cari</label>
                        <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Nama Satpam, Jam Kerja, Tanggal, Status"
                            class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" style="max-width: 300px;">
                    </div>
                    <div class="mb-4 mr-4 flex flex-col relative justify-end">
                        <button type="submit" class="inline-block px-8 py-2 font-bold leading-normal text-center text-white align-middle transition-all ease-in bg-blue-500 border-0 rounded-lg shadow-md cursor-pointer text-xs tracking-tight-rem hover:shadow-xs hover:-translate-y-px active:opacity-85">Cari</button>
                    </div>
                </form>
            </div>

            <div class="flex-auto px-0 pt-0 pb-2">
              <div class="p-0 overflow-x-auto">

                <table class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500">
                  <thead class="align-bottom">
                    <tr>
                      <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap">Tanggal Presensi</th>
                      <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap">Jam Kerja</th>
                      <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap">Nama Satpam</th>
                      <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap">Jam Masuk</th>
                      <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap">Jam Pulang</th>
                      <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap">Status</th>
                      <th class="px-6 py-3 font-semibold capitalize align-middle bg-transparent border-b border-collapse border-solid shadow-none dark:border-white/40 dark:text-white tracking-none whitespace-nowrap text-slate-400 opacity-70"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($attendances as $attendance)
                    <tr>
                      <td class="p-2 text-center align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                        <p class="mb-0 text-xs leading-tight dark:text-white dark:opacity-80 text-slate-400">{{ $attendance->date->translatedFormat('l, d-m-Y') }}</p>
                      </td>
                      <td class="p-2 text-center align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                        <p class="mb-0 text-xs leading-tight dark:text-white dark:opacity-80 text-slate-400">{{ $attendance->shift->start_time }} - {{ $attendance->shift->end_time }}</p>
                      </td>
                      <td class="p-2 text-center align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                        <p class="mb-0 text-xs leading-tight dark:text-white dark:opacity-80 text-slate-400">{{ $attendance->guardRelation->name }}</p>
                      </td>
                      <td class="p-2 text-center align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                        <p class="mb-0 text-xs leading-tight dark:text-white dark:opacity-80 text-slate-400">{{ $attendance->check_in_time ? $attendance->check_in_time : '-' }}</p>
                      </td>
                      <td class="p-2 text-center align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                        <p class="mb-0 text-xs leading-tight dark:text-white dark:opacity-80 text-slate-400">{{ $attendance->check_out_time ? $attendance->check_out_time : '-' }}</p>
                      </td>
                      <td class="p-2 text-center align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                        @if ($attendance->status == 'Hadir')
                            <span class="bg-gradient-to-tl from-emerald-500 to-teal-400 px-2.5 text-xs rounded-1.8 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white">Hadir</span>
                        @elseif ($attendance->status == 'Terlambat')
                            <span style="background-color: #f59e0b;" class="px-2.5 text-xs rounded-1.8 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white">Terlambat</span>
                        @elseif ($attendance->check_in_time == null && $attendance->check_out_time == null && $attendance->date < now()->startOfDay())
                            <span class="bg-gradient-to-tl from-red-600 to-orange-600 px-2.5 text-xs rounded-1.8 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white">Tidak Hadir</span>
                        @elseif ($attendance->check_in_time == null && $attendance->check_out_time == null && $attendance->date == now()->toDateString() && now()->format('H:i:s') > $attendance->shift->end_time)
                            <span class="bg-gradient-to-tl from-red-600 to-orange-600 px-2.5 text-xs rounded-1.8 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white">Tidak Hadir</span>
                        @else
                            <span class="bg-gradient-to-tl from-slate-600 to-slate-300 px-2.5 text-xs rounded-1.8 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white">Belum Absen</span>
                        @endif
                      </td>
                      <td class="p-2 text-center align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                        {{-- <a href="/presence/{{ $attendance->id }}/edit" class="btn btn-secondary text-xs border-0">
                          <i class="fas fa-edit"></i>
                        </a>
                        | --}}
                        <a href="/presence/{{ $attendance->id }}" class="btn btn-primary text-xs border-0">
                          <i class="fas fa-eye" aria-hidden="true" ></i>
                        </a>
                        |
                        <a href="/presence/{{ $attendance->id }}/delete" class="btn btn-danger text-xs border-0 fas fa-trash-alt" data-confirm-delete="true"">
                            <i aria-hidden="true" ></i>
                        </a>
                      </td>
                    </tr>
                    @endforeach
                </tbody>
                </table>
                <div class="flex justify-between px-6">
                  <div class="mt-3 text-xs text-gray-700">
                      Showing
                      {{ $attendances->firstItem() }}
                      to
                      {{ $attendances->lastItem() }}
                      of
                      {{ $attendances->total() }}
                  </div>
                  <div class="mt-1">
                      {{ $attendances->links() }}
                  </div>
                </div>
            </div>
          </div>
        </div>
      </div>
@endsection
