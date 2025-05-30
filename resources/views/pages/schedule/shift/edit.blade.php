<div class="modal fade" id="shiftModalEdit" tabindex="-1" aria-labelledby="shiftModalEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="shiftModalEditLabel">Jadwal Shift</h5>
          <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="formEdit" method="POST">
                @method('put')
                @csrf
                <input type="hidden" name="shift_id" id="shift_id">

                <div class="w-full max-w-full px-3 shrink-0 md:flex-0">
                    <div class="mb-4 flex flex-col relative">
                        <label for="shift_name"
                            class="inline-block ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Nama Shift</label>
                        <input type="text" name="shift_name" id="shift_name"
                            class="form-control focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none @error('shift_name') border-red-500 @enderror" />
                        @error('shift_name')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="w-full max-w-full px-3 shrink-0 md:flex-0">
                    <div class="mb-4 flex flex-col relative">
                        <label for="start_time"
                            class="inline-block ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Waktu Mulai</label>
                        <input type="time" name="start_time" id="start_time"
                            class="form-control focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none @error('start_time') border-red-500 @enderror" />
                        @error('start_time')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="w-full max-w-full px-3 shrink-0 md:flex-0">
                    <div class="mb-4 flex flex-col relative">
                        <label for="end_time"
                            class="inline-block ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Waktu Selesai</label>
                        <input type="time" name="end_time" id="end_time"
                            class="form-control focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none @error('end_time') border-red-500 @enderror" />
                        @error('end_time')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
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
    const formEdit = document.getElementById('formEdit');
    const shiftModalEdit = new bootstrap.Modal(document.getElementById('shiftModalEdit'));
    
    // Handle browser back button
    window.addEventListener('popstate', function(event) {
        if (document.getElementById('shiftModalEdit').classList.contains('show')) {
            shiftModalEdit.hide();
        }
    });
    
    // Function to handle edit button click
    window.editShift = function(id) {
        fetch(`/schedules/shift/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('shift_id').value = data.id;
                document.getElementById('shift_name').value = data.shift_name;
                document.getElementById('start_time').value = data.start_time;
                document.getElementById('end_time').value = data.end_time;
                formEdit.action = `/schedules/shift/${id}`;
                
                // Show the modal
                shiftModalEdit.show();
            })
            .catch(error => {
                console.error('Error:', error);
            });
    };
    
    // Handle form submission
    formEdit.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const id = document.getElementById('shift_id').value;
        
        fetch(`/schedules/shift/${id}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
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
                    shiftModalEdit.hide();
                    // Redirect to schedules page
                    window.location.href = '/schedules';
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
    
    // Handle modal close
    document.getElementById('shiftModalEdit').addEventListener('hidden.bs.modal', function () {
        // Remove from browser history if it was added
        if (window.history.state && window.history.state.modal === 'shiftEdit') {
            window.history.back();
        }
    });
});
</script>