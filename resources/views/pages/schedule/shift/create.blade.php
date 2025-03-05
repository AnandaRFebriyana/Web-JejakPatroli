<!-- Modal -->
<div class="modal fade" id="shiftModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="shiftModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="shiftModalLabel">Jadwal Shift</h1>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="/schedules/shift/store">
                    @csrf
                    <div class="w-full max-w-full px-3 shrink-0 md:flex-0">
                        <div class="mb-4 flex flex-col relative">
                            <label for="shift_name"
                                class="inline-block ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Nama Shift</label>
                            <input type="text" name="shift_name" value="{{ old('shift_name') }}"
                                class="form-control focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" />
                            <div class="invalid-feedback tex`xt-red-500 mt-1"></div>
                        </div>
                    </div>
                    <div class="w-full max-w-full px-3 shrink-0 md:flex-0">
                        <div class="mb-4 flex flex-col relative">
                            <label for="start_time"
                                class="inline-block ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Waktu Mulai</label>
                            <input type="time" name="start_time" value="{{ old('start_time') }}"
                                class="form-control focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" />
                            <div class="invalid-feedback text-red-500 mt-1"></div>
                        </div>
                    </div>
                    <div class="w-full max-w-full px-3 shrink-0 md:flex-0">
                        <div class="mb-4 flex flex-col relative">
                            <label for="end_time"
                                class="inline-block ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Waktu Selesai</label>
                            <input type="time" name="end_time" value="{{ old('end_time') }}"
                                class="form-control focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" />
                            <div class="invalid-feedback text-red-500 mt-1"></div>
                        </div>
                    </div>
                
                    <div class="modal-footer">
                        <button type="submit" class="inline-block px-8 py-2 mb-4 font-bold leading-normal text-center text-white align-middle transition-all ease-in bg-tosca border-0 rounded-lg shadow-md cursor-pointer text-xs tracking-tight-rem hover:shadow-xs hover:-translate-y-px active:opacity-85">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
