@extends('pages.auth.main')

@section('content')
<style>
    .bg-gradient-to-tl {
        background-image: linear-gradient(0deg,rgba(36, 44, 59, 1) 0%, rgba(55, 182, 233, 1) 100%);
        opacity: 1;
    }    
    .transition-all {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.25, 0.1, 0.25, 1);
    transition-duration: 150ms;
    background-color: #003366; /* Dark Blue */
    }

    .transition-all:focus {
        outline: 2px solid #1E3A8A; /* Blue Outline when focused */
        outline-offset: 2px; /* Slightly offset the outline for better visibility */
    }

    </style>
<div class="container sticky top-0 z-sticky">
    <div class="flex flex-wrap -mx-3">
        <div class="w-full max-w-full px-3 flex-0"></div>
    </div>
</div>
<a href="/" class="fixed top-6 left-8 flex items-center text-gray-700 hover:text-gray-900 transition-colors z-50">
    <svg class="w-5 h-5 mr-2 font-bold" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
        xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
    </svg>
    <span class="text-base font-semibold">Kembali</span>
</a>

<main class="mt-0 transition-all duration-200 ease-in-out">
    <section>
        <div class="relative flex items-center min-h-screen p-0 overflow-hidden bg-center bg-cover">
            <div class="container z-1">
                <div class="flex flex-wrap -mx-3">
                    <div class="flex flex-col w-full max-w-full px-3 mx-auto lg:mx-0 shrink-0 md:flex-0 md:w-7/12 lg:w-5/12 xl:w-4/12 z-10">
                        <div class="relative flex flex-col min-w-0 break-words bg-transparent border-0 shadow-none lg:py4 dark:bg-gray-950 rounded-2xl bg-clip-border">

                            @if (session()->has('error'))
                                <div class="alert alert-danger">
                                    <span class="message">{{ session('error') }}</span>
                                    <span class="close" onclick="this.parentElement.style.display='none';">&times;</span>
                                </div>
                            @endif

                            <div class="p-6 pb-0 mb-0">
                                <h4 class="font-bold">Masuk</h4>
                                <p class="mb-0">Masukkan Email dan Password anda untuk masuk</p>
                            </div>
                            <div class="flex-auto p-6">
                                <form action="/login" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Email" autofocus
                                            class="form-control focus:shadow-primary-outline dark:bg-gray-950 dark:placeholder:text-white/80 dark:text-white/80 text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding p-3 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                                        @error('email')
                                            <div class="invalid-feedback text-red-500 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-4 relative">
                                        <input type="password" id="password" name="password" placeholder="Password"
                                            class="form-control pr-10 focus:shadow-primary-outline dark:bg-gray-950 dark:placeholder:text-white/80 dark:text-white/80 text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding p-3 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />

                                        <span onclick="togglePassword('password', this)"
                                            class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer text-gray-500">
                                            <i class="fas fa-eye-slash" id="icon-password"></i>
                                        </span>

                                        @error('password')
                                            <div class="invalid-feedback text-red-500 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="text-center">
                                        <button type="submit"
                                            class="inline-block w-full px-16 py-3.5 mt-6 mb-0 font-bold leading-normal text-center text-white align-middle transition-all bg-tosca border-0 rounded-lg cursor-pointer hover:-translate-y-px active:opacity-85 hover:shadow-xs text-sm ease-in tracking-tight-rem shadow-md bg-150 bg-x-25">
                                            Masuk</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="absolute top-0 right-0 flex-col justify-center hidden w-6/12 h-full max-w-full px-3 pr-0 my-auto text-center flex-0 lg:flex">
                        <div class="relative flex flex-col justify-center h-full bg-gradient-to-b from-[#37B6E9] to-[#242C3B] px-24 m-4 overflow-hidden rounded-xl ">
                            <span class="absolute top-0 left-0 w-full h-full bg-center bg-cover bg-gradient-to-tl from-zinc-800 opacity-60"></span>
                            <img src="{{ asset('assets/img/logo-jejakpatroli.png') }}" alt="Logo Jejak Patroli" style="width: 240px; margin-bottom: 4px" class="z-10 mx-auto h-auto">
                            <h3 class="z-20 mt-2 font-bold text-white typing-animation">Selamat Datang di Jejak Patroli !!!</h3>
                            <p class="z-20 text-white ">
                            Di mana pemantauan aktivitas lapangan menjadi mudah, memastikan tracking real time dan pelaporan komprehensif untuk patroli keamanan dan observasi lapangan.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

<script>
    function togglePassword(fieldId, iconSpan) {
        const field = document.getElementById(fieldId);
        const icon = iconSpan.querySelector('i');

        if (field.type === "password") {
            field.type = "text";
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        } else {
            field.type = "password";
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        }
    }
</script>
