<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="apple-touch-icon" sizes="100x100" href="{{ asset('assets/img/logo-jejakpatroli.png') }}" />
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}" />
    <title>{{ $title }} - Jejak Patroli</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Google Fonts - Open Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons from CDNJS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Nucleo Icons -->
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />

    <!-- Popper -->
    <script src="https://unpkg.com/@popperjs/core@2"></script>

    <!-- Main Styling -->
    <link href="{{ asset('assets/css/argon-dashboard-tailwind.css?v=1.0.1') }}" rel="stylesheet" />

    <style>
      /* Custom Styling */
      body {
        font-family: 'Open Sans', sans-serif;
        background-color: #f8f9fa;
      }

      .bg-tosca {
        background-color: #1e4b81;  /* Darker blue */
        opacity: 0.9;
        z-index: 0;
      }

      input[type="date"]::-webkit-calendar-picker-indicator,
      input[type="time"]::-webkit-calendar-picker-indicator {
        margin-right: 0.7rem; 
      }

      input[type="password"] {
        margin-right: 0.7rem; 
      }

      .main-content {
        background-color: #f8f9fa;
        min-height: 100vh;
      }

      .top-navbar {
        background-color: #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      }

      .card {
        background-color: #fff;
        border: none;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
      }
    </style>

    @yield('styles')
  </head>
  <body class="bg-light">
    <div class="absolute w-full bg-tosca min-h-75"></div>
    @include('layout.sidebar')
    
    <main class="relative h-full max-h-screen transition-all duration-200 ease-in-out xl:ml-68 rounded-xl">
      @include('layout.navbar')
      
      <!-- content -->
      <div class="w-full px-6 py-6 mx-auto">
        @yield('content')
        @include('sweetalert::alert')
      </div>
      {{-- end content --}}
    </main>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
  </body>
</html>
