@extends('layout.main')

@section('content')
    <div class="w-full p-6 mx-auto">
        <div class="flex flex-wrap -mx-3 row justify-content-center">
            <div class="w-full max-w-full px-3 shrink-0 md:w-8/12 md:flex-0">
                <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                    <form method="POST" action="/schedules/guard/store">
                        @csrf
                        <div class="flex-auto p-6">
                            <div class="w-full max-w-full px-3 shrink-0 md:w-full md:flex-0">
                                <div class="mb-4">
                                    <label for="guard_id"
                                        class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Nama Satpam</label>
                                    <select id="guard_id" name="guard_id" required
                                        class="form-control @error('guard_id') is-invalid @enderror focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none">
                                        <option value="" selected disabled>Pilih Nama</option>
                                        @foreach ($guards as $guard)
                                            <option value="{{ $guard->id }}">{{ $guard->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('guard_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="w-full max-w-full px-3 shrink-0 md:w-full md:flex-0">
                                <div class="mb-4">
                                    <label for="shift_id"
                                        class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Shift</label>
                                    <select id="shift_id" name="shift_id" required
                                        class="form-control @error('shift_id') is-invalid @enderror focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none">
                                        <option value="">Pilih Shift</option>
                                        @foreach ($shifts as $shift)
                                            <option value="{{ $shift->id }}">{{ $shift->start_time }} - {{ $shift->end_time }}</option>
                                        @endforeach
                                    </select>
                                    @error('shift_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="w-full max-w-full px-3 shrink-0 md:w-full md:flex-0">
                                <div class="mb-4">
                                    <label for="start_date"
                                        class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Tanggal Mulai</label>
                                    <input type="date" id="start_date" name="start_date" required
                                        class="form-control @error('start_date') is-invalid @enderror focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full rounded-lg border border-solid border-gray-300 bg-white px-3 py-2 text-gray-700 placeholder:text-gray-500 focus:border-blue-500 focus:outline-none">
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="w-full max-w-full px-3 shrink-0 md:w-full md:flex-0">
                                <div class="mb-4">
                                    <label for="end_date"
                                        class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Tanggal Selesai</label>
                                    <input type="date" id="end_date" name="end_date" required
                                        class="form-control @error('end_date') is-invalid @enderror focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full rounded-lg border border-solid border-gray-300 bg-white px-3 py-2 text-gray-700 placeholder:text-gray-500 focus:border-blue-500 focus:outline-none">
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div id="schedule_preview" class="mb-4">
                                <h6 class="font-bold text-xs text-slate-700 dark:text-white/80 mb-2">Preview Jadwal:</h6>
                                <div id="schedule_list" class="text-sm"></div>
                            </div>

                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    const startDateInput = document.getElementById('start_date');
                                    const endDateInput = document.getElementById('end_date');
                                    const scheduleList = document.getElementById('schedule_list');
                                    const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

                                    function updateSchedulePreview() {
                                        const startDate = new Date(startDateInput.value);
                                        const endDate = new Date(endDateInput.value);

                                        if (!isNaN(startDate) && !isNaN(endDate)) {
                                            let html = '<ul class="list-disc pl-4">';
                                            let currentDate = new Date(startDate);

                                            while (currentDate <= endDate) {
                                                const dayIndex = currentDate.getDay();
                                                const dayName = days[dayIndex];
                                                const formattedDate = currentDate.toLocaleDateString('id-ID', {
                                                    day: 'numeric',
                                                    month: 'long',
                                                    year: 'numeric'
                                                });

                                                html += `<li>${dayName}, ${formattedDate}</li>`;
                                                
                                                // Increment date by 1 day
                                                currentDate.setDate(currentDate.getDate() + 1);
                                            }

                                            html += '</ul>';
                                            scheduleList.innerHTML = html;
                                        } else {
                                            scheduleList.innerHTML = '';
                                        }
                                    }

                                    startDateInput.addEventListener('change', updateSchedulePreview);
                                    endDateInput.addEventListener('change', updateSchedulePreview);
                                });
                            </script>

                            <div class="modal-footer">
                                <button type="submit" class="inline-block px-8 py-2 mb-4 font-bold leading-normal text-center text-white align-middle transition-all ease-in bg-tosca border-0 rounded-lg shadow-md cursor-pointer text-xs tracking-tight-rem hover:shadow-xs hover:-translate-y-px active:opacity-85">Simpan</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
