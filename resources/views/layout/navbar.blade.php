<!-- Navbar -->
<nav class="relative flex flex-wrap items-center justify-between px-0 py-2 mx-6 transition-all ease-in shadow-none duration-250 rounded-2xl lg:flex-nowrap lg:justify-start" navbar-main navbar-scroll="false">
<div class="flex items-center justify-between w-full px-4 py-1 mx-auto flex-wrap-inherit">
  <nav>
    <!-- breadcrumb -->
    <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
      <li class="text-sm leading-normal">
        <a class="text-white opacity-50" href="javascript:;">Pages</a>
      </li>
      <li class="text-sm pl-2 capitalize leading-normal text-white before:float-left before:pr-2 before:text-white before:content-['/']" aria-current="page">{{ $title }}</li>
    </ol>
    <h6 class="mb-0 font-bold text-white capitalize">{{ $title }}</h6>
  </nav>
  
  <div class="flex items-center mt-2 grow sm:mt-0 sm:mr-6 md:mr-0 lg:flex lg:basis-auto">
    <div class="flex items-center md:ml-auto md:pr-4"></div>
    <ul class="flex flex-row justify-end pl-0 mb-0 list-none md-max:w-full">
      <li class="flex items-center pl-4 xl:hidden">
        <a href="javascript:;" class="block p-0 text-sm text-white transition-all ease-nav-brand" sidenav-trigger>
          <div class="w-4.5 overflow-hidden">
            <i class="ease mb-0.75 relative block h-0.5 rounded-sm bg-white transition-all"></i>
            <i class="ease mb-0.75 relative block h-0.5 rounded-sm bg-white transition-all"></i>
            <i class="ease relative block h-0.5 rounded-sm bg-white transition-all"></i>
          </div>
        </a>
      </li>

      <!-- dropdown -->
      <li class="flex items-center px-4 relative">
        <a href="javascript:;" class="block p-0 text-sm font-semibold text-white transition-all ease-nav-brand" dropdown-trigger aria-expanded="false">
          <i class="cursor-pointer fa fa-user sm:mr-1"></i>
          <span class="hidden sm:inline">{{ Auth::guard('admin')->user()->name }}</span>
          {{-- <span class="hidden sm:inline">User</span> --}}
        </a>
        
        <ul dropdown-menu class="text-sm transform-dropdown before:font-awesome before:leading-default before:duration-350 before:ease lg:shadow-3xl duration-250 min-w-44 before:sm:right-8 before:text-5.5 pointer-events-none absolute right-0 top-0 z-50 origin-top list-none rounded-lg border-0 border-solid border-transparent dark:shadow-dark-xl dark:bg-slate-850 bg-white bg-clip-padding px-2 py-4 text-left text-slate-500 opacity-0 transition-all before:absolute before:right-auto before:left-0 before:top-0 before:z-50 before:inline-block before:font-normal before:text-white before:antialiased before:transition-all before:content-['\f0d8'] sm:-mr-6 lg:absolute lg:right-0 lg:left-auto lg:mt-2 lg:block lg:cursor-pointer">
          {{-- <li class="relative mb-2">
            <a href="#" class="dark:hover:bg-slate-900 ease py-1.2 clear-both block w-full whitespace-nowrap rounded-lg px-4 transition-colors duration-300 hover:bg-gray-200 hover:text-slate-700" href="javascript:;">
              <div class="flex py-1">
                <div class="my-auto">
                  <i class="fa fa-key inline-flex items-center justify-center mr-4 text-sm text-white bg-gradient-to-tl from-zinc-800 to-zinc-700 dark:bg-gradient-to-tl dark:from-slate-750 dark:to-gray-850 h-9 w-9 max-w-none rounded-xl"></i>
                </div>
                <div class="flex flex-col justify-center">
                  <h6 class="mb-1 text-sm font-normal leading-normal dark:text-white">
                    <span class="font-semibold">Change Password</span>
                  </h6>
                </div>
              </div>
            </a>
          </li> --}}

          <li class="relative">
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="dark:hover:bg-slate-900 ease py-1.2 clear-both block w-full whitespace-nowrap rounded-lg px-4 transition-colors duration-300 hover:bg-gray-200 hover:text-slate-700">
                    <div class="flex py-1">
                        <div class="my-auto">
                            <i class="fa fa-sign-out inline-flex items-center justify-center mr-4 text-sm text-white bg-gradient-to-tl from-zinc-800 to-zinc-700 dark:bg-gradient-to-tl dark:from-slate-750 dark:to-gray-850 h-9 w-9 max-w-none rounded-xl"></i>
                        </div>
                        <div class="flex flex-col justify-center">
                            <h6 class="mb-1 text-sm font-normal leading-normal dark:text-white">
                                <span class="font-semibold">Logout</span>
                            </h6>
                        </div>
                    </div>
                </button>
            </form>
        </li>
          
      </ul>
    </div>
  </div>
</nav>
<!-- end Navbar -->