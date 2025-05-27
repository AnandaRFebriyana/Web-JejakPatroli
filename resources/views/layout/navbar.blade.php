<!-- Navbar -->
<nav class="relative flex flex-wrap items-center justify-between px-0 py-2 mx-6 transition-all ease-in shadow-none duration-250 rounded-2xl lg:flex-nowrap lg:justify-start" navbar-main navbar-scroll="false">
<div class="flex items-center justify-between w-full px-4 py-1 mx-auto flex-wrap-inherit">
  <nav>
    <!-- breadcrumb -->
    <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
      <li class="text-sm leading-normal">
        <a class="text-white opacity-50" href="javascript:;">Halaman</a>
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
        <div class="relative">
          <button type="button" onclick="toggleDropdown(this)" class="flex items-center text-sm font-semibold text-white">
            <i class="fa fa-user sm:mr-1"></i>
            <span class="hidden sm:inline">{{ Auth::guard('admin')->user()->name }}</span>
          </button>

          <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 hidden" id="userDropdown">
            <form action="/logout" method="POST">
              @csrf
              <button type="submit" class="block w-full text-left px-6 py-2.5 text-gray-700 hover:bg-gray-100">
                <div class="flex items-center">
                  <i class="fas fa-sign-out-alt mr-5 text-gray-800 text-base"></i>
                  <span class="font-medium text-base">Keluar</span>
                </div>
              </button>
            </form>
          </div>
        </div>
      </li>
    </ul>
  </div>
</div>
</nav>

<script>
function toggleDropdown(button) {
  const dropdown = button.nextElementSibling;
  dropdown.classList.toggle('hidden');
  
  // Close dropdown when clicking outside
  document.addEventListener('click', function closeDropdown(e) {
    if (!button.contains(e.target) && !dropdown.contains(e.target)) {
      dropdown.classList.add('hidden');
      document.removeEventListener('click', closeDropdown);
    }
  });
}
</script>
<!-- end Navbar -->
