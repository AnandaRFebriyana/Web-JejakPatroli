@if (Session::has('alert.config') || Session::has('alert.delete'))
    @if (config('sweetalert.animation.enable'))
        <link rel="stylesheet" href="{{ config('sweetalert.animatecss') }}">
    @endif

    @if (config('sweetalert.theme') != 'default')
        <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-{{ config('sweetalert.theme') }}" rel="stylesheet">
    @endif

    @if (config('sweetalert.alwaysLoadJS') === false && config('sweetalert.neverLoadJS') === false)
        <script src="{{ $cdn ?? asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
    @endif
    <script>
        @if (Session::has('alert.delete'))
            document.addEventListener('click', function(event) {
                if (event.target.matches('[data-confirm-delete]')) {
                    event.preventDefault();
                    Swal.fire({!! Session::pull('alert.delete') !!}).then(function(result) {
                        if (result.isConfirmed) {
                            var form = document.createElement('form');
                            form.action = event.target.href;
                            form.method = 'POST';
                            form.innerHTML = `
                    @csrf
                    @method('DELETE')
                `;
                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                }
            });
        @endif

        // @if (Session::has('alert.config'))
        //     Swal.fire({!! Session::pull('alert.config') !!});
        // @endif
    </script>
@endif

{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

@if(session()->has('success'))
    <script>
        // Swal.fire({
        //     icon: 'success',
        //     title: 'Berhasil!',
        //     text: '{{ session()->get('success') }}',
        //     timer: 1500,
        // });
        swal({
            title: "Berhasil!",
            text: "{{ session()->get('success') }}",
            icon: "success",
            button: "OK",
            timer: 1500,
        });
    </script>
@endif

@if(session()->has('error'))
    <script>
        // Swal.fire({
        //     icon: 'error',
        //     title: '{{ session()->get('error') }}',
        //     timer: 1500,
        // });
        swal({
            title: "Error!",
            text: "{{ session()->get('error') }}",
            icon: "error",
            button: "OK",
            timer: 1500,
        });
    </script>
@endif

@if(session()->has('info'))
    <script>
        // Swal.fire({
        //     icon: 'error',
        //     title: '{{ session()->get('error') }}',
        //     timer: 1500,
        // });
        swal({
            title: "Info!",
            text: "{{ session()->get('info') }}",
            icon: "info",
            button: "OK",
            timer: 1500,
        });
    </script>
@endif