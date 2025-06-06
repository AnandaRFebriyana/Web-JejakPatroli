<!-- sidenav  -->
<aside class="fixed inset-y-0 flex-wrap items-center justify-between block w-full p-0 my-4 overflow-y-auto antialiased transition-transform duration-200 -translate-x-full bg-white border-0 shadow-xl dark:shadow-none dark:bg-slate-850 max-w-64 ease-nav-brand z-990 xl:ml-6 rounded-2xl xl:left-0 xl:translate-x-0" aria-expanded="false">
    <div class="h-19">
      <i class="absolute top-0 right-0 p-4 opacity-50 cursor-pointer fas fa-times dark:text-white text-slate-400 xl:hidden" sidenav-close></i>
      <a class="block px-8 py-6 m-0 text-sm whitespace-nowrap dark:text-white text-slate-700" href="/dashboard">
        <img src="{{ asset('assets/img/logo-jejakpatroli.png') }}" class="inline h-full max-w-full transition-all duration-200 dark:hidden ease-nav-brand max-h-8" alt="main_logo" />
        <img src="{{ asset('assets/img/logo-jejakpatroli.png') }}" class="hidden h-full max-w-full transition-all duration-200 dark:inline ease-nav-brand max-h-8" alt="main_logo" />
        <span class="ml-1 font-semibold transition-all duration-200 ease-nav-brand">Jejak Patroli</span>
      </a>
    </div>
    <hr class="h-px mt-0 bg-transparent bg-gradient-to-r from-transparent via-black/40 to-transparent dark:bg-gradient-to-r dark:from-transparent dark:via-white dark:to-transparent" />
    <div class="items-center block w-auto max-h-screen overflow-auto h-sidenav grow basis-full">
      <ul class="flex flex-col pl-0 mb-0">

        <li class="mt-0.5 w-full">
          <a class="{{ Request::is('dashboard') ? 'bg-blue-500/13 rounded-lg font-semibold text-slate-700' : '' }} dark:text-white dark:opacity-80 py-2.7 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors" href="/dashboard">
            <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
              <i class="relative top-0 text-sm leading-normal text-blue-500 ni ni-tv-2"></i>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Dashboard</span>
          </a>
        </li>

        <li class="mt-0.5 w-full">
          <a class="{{ Request::is('guard*') ? 'bg-blue-500/13 rounded-lg font-semibold text-slate-700' : '' }} dark:text-white dark:opacity-80 py-2.7 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors" href="/guard">
            <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
              <i class="relative top-0 text-sm leading-normal text-cyan-500 ni ni-single-copy-04"></i>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Data Satpam</span>
          </a>
        </li>

        <li class="mt-0.5 w-full">
          <a class="{{ Request::is('schedule*') ? 'bg-blue-500/13 rounded-lg font-semibold text-slate-700' : '' }} dark:text-white dark:opacity-80 py-2.7 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors" href="/schedules">
            <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
              <i class="relative top-0 text-sm leading-normal text-orange-500 ni ni-calendar-grid-58"></i>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Data Jadwal</span>
          </a>
        </li>

        <li class="mt-0.5 w-full">
          <a class="{{ Request::is('location') ? 'bg-blue-500/13 rounded-lg font-semibold text-slate-700' : '' }} dark:text-white dark:opacity-80 py-2.7 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors" href="/location">
            <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center fill-current stroke-0 text-center xl:p-2.5">
              <i class="relative top-0 text-sm leading-normal text-red-500 ni ni-map-big"></i>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Data Tracking</span>
          </a>
        </li>

        <li class="mt-0.5 w-full">
          <a class="{{ Request::is('presence*') ? 'bg-blue-500/13 rounded-lg font-semibold text-slate-700' : '' }} dark:text-white dark:opacity-80 py-2.7 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors" href="/presence">
            <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center fill-current stroke-0 text-center xl:p-2.5">
              <i class="relative top-0 text-sm leading-normal text-yellow-500 ni ni-folder-17"></i>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Data Kehadiran</span>
          </a>
        </li>

        <li class="mt-0.5 w-full">
          <a class="{{ Request::is('report*') ? 'bg-blue-500/13 rounded-lg font-semibold text-slate-700' : '' }} dark:text-white dark:opacity-80 py-2.7 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors" href="/report">
            <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center fill-current stroke-0 text-center xl:p-2.5">
              <i class="relative top-0 text-sm leading-normal text-emerald-500 ni ni-collection"></i>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Laporan</span>
          </a>
        </li>

      </ul>
    </div>
  </aside>
  <!-- end sidenav -->
