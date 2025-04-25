@extends('layout.main')

@section('content')
        <div class="flex flex-wrap -mx-3">
          <div class="w-full max-w-full px-3  md:flex-none">
            <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
              <div class="flex-auto p-5 pt-7">
                <div class="flex flex-wrap -mx-3">
                  @foreach ($reports as $report)
                  <div class="w-full md:w-1/2 px-3 mb-6">
                    <div class="relative flex flex-col p-4 bg-white border-0 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                      <div class="flex justify-between items-center">
                        <div class="flex-auto">
                          <div class="mb-2 text-sm leading-tight dark:text-white/80">
                            <span class="font-semibold text-slate-700 dark:text-white">Nama:</span>
                            <span class="text-slate-700 dark:text-white">{{ $report->guardRelation->name }}</span>
                          </div>
                          <div class="mb-2 text-sm leading-tight dark:text-white/80">
                            <span class="font-semibold text-slate-700 dark:text-white">Lokasi:</span>
                            <span class="text-slate-700 dark:text-white">{{ $report->location->location_name }}</span>
                          </div>
                          <div class="text-sm leading-tight dark:text-white/80">
                            <span class="font-semibold text-slate-700 dark:text-white">Status:</span>
                            <span class="text-slate-700 dark:text-white sm:ml-2" style="background-color: {{ $report->status == 'Aman' ? 'green' : 'red' }}; padding: 2px 4px; border-radius: 4px; color: white;">
                              {{ $report->status }}
                            </span>
                          </div>
                        </div>
                        <div class="text-right">
                          <h7 class="text-md leading-normal dark:text-white">{{ \Carbon\Carbon::parse($report->created_at)->translatedFormat('d F Y') }}</h7>
                          <span class="text-sm leading-tight dark:text-white/80">{{ $report->created_at->format('H:i:s') }}</span>
                        </div>
                      </div>
                      <div class="flex justify-end mt-4">
                        <a href="/report/{{ $report->id }}"
                           class="inline-block dark:text-white px-4 py-2.5 mb-0 font-bold text-center align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer leading-normal text-sm ease-in bg-150 hover:-translate-y-px active:opacity-85 bg-x-25 text-slate-700">
                           <i class="mr-2 fas fa-eye text-slate-700" aria-hidden="true"></i>Lihat Detail
                        </a>
                      </div>
                    </div>
                  </div>
                  @endforeach
                </div>
                <div class="flex justify-between px-6">
                  <div class="mt-3 text-xs text-gray-700">
                      Showing
                      {{ $reports->firstItem() }}
                      to
                      {{ $reports->lastItem() }}
                      of
                      {{ $reports->total() }}
                  </div>
                  <div class="mt-1">
                      {{ $reports->links() }}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        @endsection
