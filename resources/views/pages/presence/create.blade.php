@extends('layout.main')

@section('content')
    <div class="w-full p-6 mx-auto">
        <div class="flex flex-wrap -mx-3 row justify-content-center">
            <div class="w-full max-w-full px-3 shrink-0 md:w-8/12 md:flex-0">
                <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                    <form method="POST" action="/presence">
                        @csrf
                        <div class="flex-auto p-6">

                            <div class="w-full max-w-full px-3 shrink-0 md:w-full md:flex-0">
                                <div class="mb-4">
                                    <label for="start_date"
                                        class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Tanggal Mulai</label>
                                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}"
                                        class="form-control @error('start_date') is-invalid @enderror focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" />
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="w-full max-w-full px-3 shrink-0 md:w-full md:flex-0">
                                <div class="mb-4">
                                    <label for="end_date"
                                        class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Tanggal Selesai</label>
                                    <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}"
                                        class="form-control @error('end_date') is-invalid @enderror focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" />
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="w-full max-w-full px-3 shrink-0 md:w-full md:flex-0">
                                <div class="mb-4">
                                    <label for="shift_id"
                                        class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Shift</label>
                                    <select id="shift_id" name="shift_id"
                                        class="form-control @error('shift_id') is-invalid @enderror focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none">
                                        <option value="" selected disabled>Pilih Shift</option>
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
                                    <label for="guard_id"
                                        class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Nama Satpam</label>
                                    <select id="guard_id" name="guard_id"
                                        class="form-control @error('guard_id') is-invalid @enderror focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none">
                                        <option value="" selected disabled>Pilih Nama</option>
                                    </select>
                                    @error('guard_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit"
                                        class="px-8 py-2 font-bold leading-normal text-center text-white align-middle transition-all bg-tosca border-0 rounded-lg shadow-md cursor-pointer text-xs tracking-tight-rem hover:shadow-xs hover:-translate-y-px active:opacity-85">Simpan</button>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function getFormattedDate(date) {
            const d = new Date(date);
            const day = ("0" + d.getDate()).slice(-2);
            const month = ("0" + (d.getMonth() + 1)).slice(-2);
            const year = d.getFullYear();
            return `${year}-${month}-${day}`;
        }
    
        function getDayName(dateStr) {
            const date = new Date(dateStr);
            const options = { weekday: 'long' };
            return new Intl.DateTimeFormat('id-ID', options).format(date);
        }
    
        function updateSatpamDropdown() {
            const startDate = document.getElementById('start_date').value;
            const shift = document.getElementById('shift_id').value;
            const dayName = getDayName(startDate);
    
            if (startDate && shift) {
                fetch('/get-guard', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ day: dayName, shift: shift }),
                })
                .then(response => response.json())
                .then(data => {
                    const guardDropdown = document.getElementById('guard_id');
                    guardDropdown.innerHTML = '';
    
                    data.guardOnShift.forEach(guard => {
                        const option = document.createElement('option');
                        option.value = guard.id;
                        option.textContent = guard.name;
                        guardDropdown.appendChild(option);
                    });
    
                    data.allGuard.forEach(guard => {
                        if (!data.guardOnShift.find(item => item.id === guard.id)) {
                            const option = document.createElement('option');
                            option.value = guard.id;
                            option.textContent = guard.name;
                            guardDropdown.appendChild(option);
                        }
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
        }
    
        document.getElementById('start_date').addEventListener('change', updateSatpamDropdown);
        document.getElementById('shift_id').addEventListener('change', updateSatpamDropdown);
    </script>    
@endsection