@extends('layout.main')

@section('content')
<div class="flex flex-wrap -mx-3">
    <div class="flex-none w-full max-w-full px-3">
        <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
            <div class="p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                <div class="flex justify-between items-center">
                    <h6 class="dark:text-white">{{ $title }}</h6>
                    <!-- Search Form -->
                    <form action="{{ route('location.index') }}" method="GET" class="flex items-end gap-4">
                        <div class="mb-4 mr-4 flex flex-col relative">
                            <label for="search" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Cari</label>
                            <input type="text" 
                                   id="search" 
                                   name="search" 
                                   value="{{ request('search') }}" 
                                   placeholder="Nama Satpam"
                                   class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none"
                                   style="max-width: 300px;">
                        </div>
                        <div class="mb-4">
                            <button type="submit" 
                                    class="inline-block px-6 py-2 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-blue-500 to-violet-500 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 hover:shadow-soft-xs active:opacity-85">
                                <i class="fas fa-search mr-2"></i>Cari
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="flex-auto px-0 pt-0 pb-2">
                <div class="p-6 overflow-x-auto">
                    <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                        <thead class="align-bottom">
                            <tr>
                                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">No.</th>
                                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Nama Satpam</th>
                                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Shift</th>
                                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Hari</th>
                                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Waktu Mulai</th>
                                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Status</th>
                                <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($locations as $location)
                            <tr>
                                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-80">
                                        {{ $loop->iteration }}
                                    </p>
                                </td>
                                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-80">
                                        {{ $location->guardRelation->name }}
                                    </p>
                                </td>
                                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-80">
                                        {{ $location->attendance->shift->shift_name }}
                                        <span class="text-xs text-gray-500">
                                            ({{ \Carbon\Carbon::parse($location->attendance->shift->start_time)->format('H:i') }} - 
                                            {{ \Carbon\Carbon::parse($location->attendance->shift->end_time)->format('H:i') }})
                                        </span>
                                    </p>
                                </td>
                                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-80">
                                        {{ \Carbon\Carbon::parse($location->attendance->date)->isoFormat('dddd') }}
                                    </p>
                                </td>
                                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-80">
                                        @if($location->attendance->date && $location->attendance->check_in_time)
                                            {{ \Carbon\Carbon::parse($location->attendance->date)
                                                ->setTimeFromTimeString($location->attendance->check_in_time)
                                                ->format('d M Y H:i') }}
                                        @else
                                            -
                                        @endif
                                    </p>
                                </td>
                                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <span class="bg-gradient-to-tl px-2.5 text-xs rounded-1.8 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none {{ $location->is_active ? 'from-emerald-500 to-teal-400 text-white' : 'from-slate-300 to-slate-400 text-black' }}">
                                        {{ $location->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </td>
                                <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('location.showtrack', $location->id) }}" class="text-xs font-semibold leading-tight dark:text-white dark:opacity-80 btn btn-sm btn-info">
                                            <i class="fas fa-map-marker-alt"></i> Lihat Tracking
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-6">
                    {{ $locations->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
