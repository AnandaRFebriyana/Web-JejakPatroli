@extends('layout.main')

@section('content')
<!-- table 1 -->
<div class="flex flex-wrap -mx-3">
  <div class="flex-none w-full max-w-full px-3">
    <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
      <div class="p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <h6 class="dark:text-white">Data Satpam</h6>
        <div class="flex justify-end">
            <a href="/guard/create"
            class="inline-block px-8 py-2 mb-4 font-bold leading-normal text-center text-white align-middle transition-all ease-in bg-tosca border-0 rounded-lg shadow-md cursor-pointer text-xs tracking-tight-rem hover:shadow-xs hover:-translate-y-px active:opacity-85">Tambah</a>
        </div>
        <div class="flex md:pr-4">
          <div class="relative flex flex-wrap items-stretch transition-all rounded-lg ease">
            <span class="text-sm ease leading-5.6 absolute z-50 -ml-px flex h-full items-center whitespace-nowrap rounded-lg rounded-tr-none rounded-br-none border border-r-0 border-transparent bg-transparent py-2 px-2.5 text-center font-normal text-slate-500 transition-all">
              <i class="fas fa-search"></i>
            </span>
            <input id="search" type="text" class="pl-9 text-sm focus:shadow-primary-outline ease w-1/100 leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 dark:bg-slate-850 dark:text-white bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow" placeholder="Cari Satpam..." />
          </div>
        </div>
    </div>
      <div class="flex-auto px-0 pt-0 pb-2">
        <div class="p-0 overflow-x-auto">

          <table class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500">
            <thead class="align-bottom">
              <tr>
                <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap">Nama</th>
                {{-- <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap">NIK</th> --}}
                <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap">Email</th>
                <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap">Tanggal Lahir</th>
                <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap">Nomor Telepon</th>
                <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap">Alamat</th>
                <th class="px-6 py-3 font-semibold capitalize align-middle bg-transparent border-b border-collapse border-solid shadow-none dark:border-white/40 dark:text-white tracking-none whitespace-nowrap text-slate-400 opacity-70"></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($guards as $guard)
              <tr class="guard-row">
                <td class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                  <div class="flex px-2 py-1">
                    <div>
                      @if($guard->photo)
                          <img src="{{ asset('storage/' . $guard->photo) }}" class="inline-flex items-center justify-center mr-4 text-sm text-white transition-all duration-200 ease-in-out h-9 w-9 rounded-xl" alt="user_photo" />
                      @else
                          <img src="{{ asset('assets/img/user_profile.jpeg') }}" class="inline-flex items-center justify-center mr-4 text-sm text-white transition-all duration-200 ease-in-out h-9 w-9 rounded-xl" alt="user_default" />
                      @endif
                    </div>
                    <div class="flex flex-col justify-center">
                      <p class="mb-0 text-xs leading-tight dark:text-white dark:opacity-80 text-slate-400">{{ $guard->name }}</p>
                    </div>
                  </div>
                </td>
                {{-- <td class="p-2 text-center align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                  <p class="mb-0 text-xs leading-tight dark:text-white dark:opacity-80 text-slate-400">{{ $guard->nik }}</p>
                </td> --}}
                <td class="p-2 text-center align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                  <p class="mb-0 text-xs leading-tight dark:text-white dark:opacity-80 text-slate-400">{{ $guard->email }}</p>
                </td>
                <td class="p-2 text-center align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                  <p class="mb-0 text-xs leading-tight dark:text-white dark:opacity-80 text-slate-400">{{ \Carbon\Carbon::parse($guard->birth_date)->translatedFormat('d F Y') }}</p>
                </td>
                <td class="p-2 text-center align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                  <p class="mb-0 text-xs leading-tight dark:text-white dark:opacity-80 text-slate-400">{{ $guard->phone_number }}</p>
                </td>
                <td class="p-2 text-center align-middle bg-transparent border-b dark:border-white/40 shadow-transparent break-words max-w-xs">
                  <p class="mb-0 text-xs leading-tight dark:text-white dark:opacity-80 text-slate-400">{{ $guard->address }}</p>
                </td>
                <td class="p-2 text-center align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                  {{-- <a href="/guard/{{ $guard->id }}/edit" class="btn btn-secondary text-xs border-0">
                    <i class="fas fa-edit" aria-hidden="true"></i>
                  </a> --}}
                  <div class="btn-group">
                    <a class="btn btn-secondary text-xs dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="fas fa-edit" aria-hidden="true"></i>
                    </a>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item mb-0 text-xs leading-tight dark:text-white dark:opacity-80 text-slate-400" href="/guard/{{ $guard->id }}/edit">Ubah Data</a></li>
                      <li><hr class="dropdown-divider"></li>
                      <li><a class="dropdown-item mb-0 text-xs leading-tight dark:text-white dark:opacity-80 text-slate-400 passModalEditLink" href="javascript:void(0);"
                        data-guard-id="{{ $guard->id }}" data-bs-toggle="modal" data-bs-target="#passModalEdit">Ubah Password</a></li>
                    </ul>
                  </div>
                  |
                  <a class="btn btn-danger text-xs border-0" data-confirm-delete="true">
                    <i class="fas fa-trash-alt" aria-hidden="true"></i>
                  </a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          @include('pages.guard.change-pass')
          <div class="flex justify-between px-6">
            <div class="mt-3 text-xs text-gray-700">
                Showing
                {{ $guards->firstItem() }}
                to
                {{ $guards->lastItem() }}
                of
                {{ $guards->total() }}
            </div>
            <div class="mt-1">
                {{ $guards->links() }}
            </div>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
