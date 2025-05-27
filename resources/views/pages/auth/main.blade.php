<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/logo-jejakpatroli.png') }}" />
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo-jejakpatroli.png') }}" />
    <title>Jejak Patroli</title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Nucleo Icons -->
    <link href="{{ asset('../assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('../assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Main Styling -->
    <link href="{{ asset('../assets/css/argon-dashboard-tailwind.css?v=1.0.1') }}" rel="stylesheet" />
    {{-- Alert --}}
    <link rel="stylesheet" href="{{ asset('../assets/css/alert.css') }}">
</head>

<body class="m-0 font-sans antialiased font-normal bg-white text-start text-base leading-default text-slate-500">
    
    @yield('content')

</body>
<!-- plugin for scrollbar  -->
<script src="{{ asset('../assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
<!-- dropdown script -->
<script src="{{ asset('../assets/js/dropdown.js') }}"></script>
<!-- main script file  -->
<script src="{{ asset('../assets/js/argon-dashboard-tailwind.js?v=1.0.1') }}"></script>
<script>
    // Initialize after all scripts are loaded
    window.addEventListener('load', function() {
        console.log('All resources loaded');
        
        // Initialize typing animation
        const elements = document.querySelectorAll('.typing-animation');
        elements.forEach(element => {
            const text = element.innerText;
            element.setAttribute('data-text', text);
            element.innerText = '';

            let index = 0;
            setInterval(() => {
                element.innerText = element.getAttribute('data-text').slice(0, index);
                index++;

                if (index > text.length) {
                    index = 0;
                }
            }, 270);
        });
    });
</script>
</html>