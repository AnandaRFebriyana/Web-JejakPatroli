@extends('layout.main')

@section('content')
    <div class="flex flex-wrap -mx-3">
        <div class="w-full max-w-full px-3 mt-0 mb-6">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <div class="flex justify-between items-center">
                        <h6 class="dark:text-white">Jadwal Satpam</h6>
                        <div class="flex space-x-8">
                            <!-- Button untuk modal shift -->
                            <button data-bs-toggle="modal" data-bs-target="#shiftScheduleModal"
                                class="inline-block px-6 py-2 mb-4 mr-4 font-bold leading-normal text-center text-white align-middle transition-all ease-in bg-blue-500 border-0 rounded-lg shadow-md cursor-pointer text-xs tracking-tight-rem hover:shadow-xs hover:-translate-y-px active:opacity-85">
                                <i class="fas fa-clock mr-2"></i>Jadwal Shift
                            </button>
                            <a href="/schedules/guard/create" 
                                class="inline-block px-6 py-2 mb-4 ml-0 font-bold leading-normal text-center text-white align-middle transition-all ease-in bg-tosca border-0 rounded-lg shadow-md cursor-pointer text-xs tracking-tight-rem hover:shadow-xs hover:-translate-y-px active:opacity-85">
                                <i class="fas fa-plus mr-2"></i>Tambah Jadwal
                            </a>
                        </div>
                    </div>

                    <div class="mb-3 flex items-center space-x-4">
                        <select id="dayFilter"
                            class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none">
                            <option value="" {{ !request('day') ? 'selected' : '' }}>Semua</option>
                            <option value="Senin" {{ request('day') == 'Senin' ? 'selected' : '' }}>Senin</option>
                            <option value="Selasa" {{ request('day') == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                            <option value="Rabu" {{ request('day') == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                            <option value="Kamis" {{ request('day') == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                            <option value="Jumat" {{ request('day') == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                            <option value="Sabtu" {{ request('day') == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                            <option value="Minggu" {{ request('day') == 'Minggu' ? 'selected' : '' }}>Minggu</option>
                        </select>
                    </div>
                </div>

                <div class="flex-auto px-0 pt-0 pb-2">
                    <div class="p-0 overflow-x-auto">
                        <table class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500">
                            <thead class="align-bottom">
                                <tr>
                                    <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap">Nama Satpam</th>
                                    <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap">Hari</th>
                                    <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap">Shift</th>
                                    <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap">Tanggal</th>
                                    <th class="px-6 py-3 font-semibold capitalize align-middle bg-transparent border-b border-collapse border-solid shadow-none dark:border-white/40 dark:text-white tracking-none whitespace-nowrap text-slate-400 opacity-70"></th>
                                </tr>
                            </thead>
                            <tbody class="border-t">
                                @foreach($schedules as $schedule)
                                <tr>
                                    <td class="p-2 text-center align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                        <p class="mb-0 text-xs leading-tight dark:text-white dark:opacity-80 text-slate-400">{{ $schedule->guardRelation->name }}</p>
                                    </td>
                                    <td class="p-2 text-center align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                        <p class="mb-0 text-xs leading-tight dark:text-white dark:opacity-80 text-slate-400">{{ $schedule->day }}</p>
                                    </td>
                                    <td class="p-2 text-center align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                        <p class="mb-0 text-xs leading-tight dark:text-white dark:opacity-80 text-slate-400">{{ $schedule->shift->start_time }} - {{ $schedule->shift->end_time }}</p>
                                    </td>
                                    <td class="p-2 text-center align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                        <p class="mb-0 text-xs leading-tight dark:text-white dark:opacity-80 text-slate-400">{{ $schedule->schedule_date }}</p>
                                    </td>
                                    <td class="p-2 text-center align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                        <a href="/schedules/guard/{{ $schedule->id }}/edit" class="btn btn-secondary text-xs border-0">
                                            <i class="fas fa-edit" aria-hidden="true"></i>
                                        </a>
                                        |
                                        <a href="/schedules/guard/{{ $schedule->id }}/delete" class="btn btn-danger text-xs border-0 fas fa-trash-alt" data-confirm-delete="true">
                                            <i aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="flex justify-between px-6">
                            <div class="mt-3 text-xs text-gray-700">
                                Showing
                                {{ $schedules->firstItem() }}
                                to
                                {{ $schedules->lastItem() }}
                                of
                                {{ $schedules->total() }}
                            </div>
                            <div class="mt-1">
                                {{ $schedules->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Jadwal Shift -->
    <div class="modal fade" id="shiftScheduleModal" tabindex="-1" aria-labelledby="shiftScheduleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-bold" id="shiftScheduleModalLabel">Jadwal Shift</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="flex justify-end mb-4">
                        <button data-bs-toggle="modal" data-bs-target="#shiftModal"
                            class="inline-block px-6 py-2 font-bold leading-normal text-center text-white align-middle transition-all ease-in bg-tosca border-0 rounded-lg shadow-md cursor-pointer text-xs tracking-tight-rem hover:shadow-xs hover:-translate-y-px active:opacity-85">
                            <i class="fas fa-plus mr-2"></i>Tambah Shift
                        </button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500">
                            <thead class="align-bottom">
                                <tr>
                                    <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap">Shift</th>
                                    <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap">Waktu Mulai</th>
                                    <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap">Waktu Selesai</th>
                                    <th class="px-6 py-3 font-semibold capitalize align-middle bg-transparent border-b border-collapse border-solid shadow-none tracking-none whitespace-nowrap text-slate-400 opacity-70"></th>
                                </tr>
                            </thead>
                            <tbody class="border-t">
                                @foreach($shifts as $shift)
                                <tr>
                                    <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                        <p class="mb-0 text-xs leading-tight text-slate-400">{{ $shift->shift_name }}</p>
                                    </td>
                                    <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                        <p class="mb-0 text-xs leading-tight text-slate-400">{{ $shift->start_time }}</p>
                                    </td>
                                    <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                        <p class="mb-0 text-xs leading-tight text-slate-400">{{ $shift->end_time }}</p>
                                    </td>
                                    <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                        <a href="javascript:void(0);" class="btn btn-secondary text-xs border-0 shiftModalEditLink"
                                            data-shift-id="{{ $shift->id }}" data-bs-toggle="modal" data-bs-target="#shiftModalEdit">
                                            <i class="fas fa-edit" aria-hidden="true"></i>
                                        </a>
                                        |
                                        <a href="/schedules/shift/{{ $shift->id }}/delete" class="btn btn-danger text-xs border-0 fas fa-trash-alt" data-confirm-delete="true">
                                            <i aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('pages.schedule.shift.create')
    @include('pages.schedule.shift.edit')

    <script>
        document.getElementById('dayFilter').addEventListener('change', function() {
            var day = this.value;
            window.location.href = '/schedules?day=' + day;
        });
    </script>
@endsection
