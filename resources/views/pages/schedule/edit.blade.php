@extends('layout.main')

@section('content')
    <div class="w-full p-6 mx-auto">
        <div class="flex flex-wrap -mx-3 row justify-content-center">
            <div class="w-full max-w-full px-3 shrink-0 md:w-8/12 md:flex-0">
                <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                    <form method="POST" action="/schedules/guard/{{ $schedule->id }}">
                        @method('put')
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
                                            <option value="{{ $guard->id }}" {{ $schedule->guard_id == $guard->id ? 'selected' : '' }}>
                                                {{ $guard->name }}
                                            </option>
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
                                            <option value="{{ $shift->id }}" {{ $schedule->shift_id == $shift->id ? 'selected' : '' }}>
                                                {{ $shift->start_time }} - {{ $shift->end_time }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('shift_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="w-full max-w-full px-3 shrink-0 md:w-full md:flex-0">
                                <div class="mb-4">
                                    <label for="schedule_date"
                                        class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Tanggal Jadwal</label>
                                    <input type="date" id="schedule_date" name="schedule_date" required
                                    value="{{ old('schedule_date', \Carbon\Carbon::parse($schedule->schedule_date)->format('Y-m-d')) }}"
                                        class="form-control @error('schedule_date') is-invalid @enderror focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full rounded-lg border border-solid border-gray-300 bg-white px-3 py-2 text-gray-700 placeholder:text-gray-500 focus:border-blue-500 focus:outline-none">
                                    @error('schedule_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="w-full max-w-full px-3 shrink-0 md:w-full md:flex-0">
                                <div class="mb-4">
                                    <label for="day" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Hari</label>
                                    <select id="day" name="day" required
                                        class="form-control @error('day') is-invalid @enderror focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none">
                                        <option value="" disabled>Pilih Hari</option>
                                        @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
                                            <option value="{{ $day }}" {{ $day == $schedule->day ? 'selected' : '' }}>{{ $day }}</option>
                                        @endforeach
                                    </select>
                                    @error('day')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    const dateInput = document.getElementById('schedule_date');
                                    const daySelect = document.getElementById('day');

                                    const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

                                    function updateDayFromDate(dateStr) {
                                        const selectedDate = new Date(dateStr);
                                        if (!isNaN(selectedDate)) {
                                            const dayIndex = selectedDate.getDay();
                                            const dayName = days[dayIndex];
                                            daySelect.value = dayName;
                                        }
                                    }

                                    // Trigger saat input tanggal berubah
                                    dateInput.addEventListener('change', function () {
                                        updateDayFromDate(this.value);
                                    });

                                    // Jalankan sekali saat halaman pertama kali dibuka
                                    if (dateInput.value) {
                                        updateDayFromDate(dateInput.value);
                                    }
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
