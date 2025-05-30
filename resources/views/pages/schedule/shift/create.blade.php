<!-- Modal -->
<div class="modal fade" id="shiftModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="shiftModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="shiftModalLabel">Jadwal Shift</h1>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="/schedules/shift/store" id="shiftForm">
                    @csrf
                    <div class="w-full max-w-full px-3 shrink-0 md:flex-0">
                        <div class="mb-4 flex flex-col relative">
                            <label for="shift_name"
                                class="inline-block ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Nama Shift</label>
                            <input type="text" name="shift_name" value="{{ old('shift_name') }}"
                                class="form-control focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" />
                            <div class="error-message text-red-500 text-xs mt-1" id="shift_name_error"></div>
                        </div>
                    </div>
                    <div class="w-full max-w-full px-3 shrink-0 md:flex-0">
                        <div class="mb-4 flex flex-col relative">
                            <label for="start_time"
                                class="inline-block ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Waktu Mulai</label>
                            <input type="time" name="start_time" value="{{ old('start_time') }}"
                                class="form-control focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" />
                            <div class="error-message text-red-500 text-xs mt-1" id="start_time_error"></div>
                        </div>
                    </div>
                    <div class="w-full max-w-full px-3 shrink-0 md:flex-0">
                        <div class="mb-4 flex flex-col relative">
                            <label for="end_time"
                                class="inline-block ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Waktu Selesai</label>
                            <input type="time" name="end_time" value="{{ old('end_time') }}"
                                class="form-control focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" />
                            <div class="error-message text-red-500 text-xs mt-1" id="end_time_error"></div>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const shiftForm = document.getElementById('shiftForm');
    const shiftModal = new bootstrap.Modal(document.getElementById('shiftModal'));
    
    // Handle browser back button
    window.addEventListener('popstate', function(event) {
        if (document.getElementById('shiftModal').classList.contains('show')) {
            shiftModal.hide();
        }
    });
    
    // Function to clear error messages
    function clearErrors() {
        document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
        document.querySelectorAll('.form-control').forEach(el => el.classList.remove('border-red-500'));
    }
    
    // Function to show error message
    function showError(field, message) {
        const input = document.querySelector(`[name="${field}"]`);
        const errorDiv = document.getElementById(`${field}_error`);
        input.classList.add('border-red-500');
        errorDiv.textContent = message;
    }
    
    shiftForm.addEventListener('submit', function(e) {
        e.preventDefault();
        clearErrors();
        
        const formData = new FormData(this);
        
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(data => {
                    throw data;
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Show success message
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.success,
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    // Close modal
                    shiftModal.hide();
                    // Redirect to schedules page
                    window.location.href = '/schedules';
                });
            }
        })
        .catch(error => {
            if (error.errors) {
                // Handle validation errors
                Object.keys(error.errors).forEach(field => {
                    showError(field, error.errors[field][0]);
                });
            } else {
                // Handle other errors
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Terjadi kesalahan. Silakan coba lagi.',
                });
            }
        });
    });
    
    // Handle modal close
    document.getElementById('shiftModal').addEventListener('hidden.bs.modal', function () {
        clearErrors();
        if (window.history.state && window.history.state.modal === 'shift') {
            window.history.back();
        }
    });
});
</script>
