@extends('layout.main')

@section('content')
        <div class="flex flex-wrap -mx-3">
          <div class="w-full max-w-full px-3 md:flex-none">
            <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
              <!-- Search Form -->
              <div class="p-6 border-b border-slate-200 dark:border-slate-700">
                <form action="{{ route('report.index') }}" method="GET" class="flex flex-wrap items-end gap-4">
                  <div class="mb-4 mr-4 flex flex-col relative">
                    <label for="search" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Cari Laporan</label>
                    <input type="text" 
                           id="search" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Nama Satpam, Tanggal dd-mm-yyyy"
                           class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none"
                           style="max-width: 300px;">
                  </div>
                  <div class="mb-4">
                    <button type="submit" 
                            class="inline-block px-6 py-2 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-blue-500 to-violet-500 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 hover:shadow-soft-xs active:opacity-85">
                      <i class="fas fa-search mr-2"></i>Cari
                    </button>
                  </div>
                </form>
              </div>

              <div class="flex-auto p-6">
                <div class="flex flex-wrap -mx-3">
                  @foreach ($reports as $report)
                  <div class="w-full md:w-1/2 px-3 mb-6">
                    <a href="/report/{{ $report->id }}" class="block">
                      <div class="relative flex flex-col p-6 bg-white border-0 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border hover:shadow-2xl transition-all duration-300 cursor-pointer transform hover:-translate-y-1">
                        <!-- Header with Name and Time -->
                        <div class="flex justify-between items-start mb-4">
                          <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center mr-3">
                              <i class="fas fa-user text-slate-600 dark:text-white"></i>
                            </div>
                            <div>
                              <h6 class="text-base font-semibold text-slate-700 dark:text-white mb-1">{{ $report->guardRelation->name }}</h6>
                              <p class="text-xs text-slate-500 dark:text-slate-400">
                                {{ \Carbon\Carbon::parse($report->created_at)->translatedFormat('d F Y') }} • {{ $report->created_at->format('H:i:s') }}
                              </p>
                            </div>
                          </div>
                          <div class="px-3 py-1 rounded-full" style="background-color: {{ $report->status == 'Aman' ? '#10B981' : '#EF4444' }}20">
                            <span class="text-sm font-medium" style="color: {{ $report->status == 'Aman' ? '#10B981' : '#EF4444' }}">
                              {{ $report->status }}
                            </span>
                          </div>
                        </div>

                        <!-- Description Preview -->
                        <div class="mb-4">
                          <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed line-clamp-2">
                            {{ $report->description }}
                          </p>
                        </div>

                        <!-- Media Preview -->
                        @if($report->media_path)
                        <div class="mb-4">
                          <div class="rounded-xl overflow-hidden">
                            @if(Str::endsWith(strtolower($report->media_path), ['.jpg', '.jpeg', '.png', '.gif']))
                              <img src="{{ asset('storage/' . $report->media_path) }}"
                                   alt="Report Image"
                                   class="w-full h-48 object-cover hover:scale-105 transition-transform duration-300">
                            @elseif(Str::endsWith(strtolower($report->media_path), ['.mp4', '.mov', '.avi']))
                              <div class="relative w-full h-48 bg-slate-200 dark:bg-slate-700 rounded-xl overflow-hidden">
                                <video class="w-full h-full object-cover">
                                  <source src="{{ asset('storage/' . $report->media_path) }}" type="video/mp4">
                                </video>
                                <div class="absolute inset-0 flex items-center justify-center">
                                  <i class="fas fa-play-circle text-4xl text-white opacity-75"></i>
                                </div>
                              </div>
                            @endif
                          </div>
                        </div>
                        @endif

                        <!-- View Detail Indicator -->
                        <div class="flex justify-end items-center mt-4 pt-4 border-t border-slate-200 dark:border-slate-700">
                          <span class="text-sm text-blue-600 dark:text-blue-400 flex items-center">
                            Lihat Detail
                            <i class="fas fa-chevron-right ml-2"></i>
                          </span>
                        </div>
                      </div>
                    </a>
                  </div>
                  @endforeach
                </div>

                <!-- Pagination -->
                <div class="flex justify-between items-center mt-6 px-4">
                  <div class="text-sm text-slate-600 dark:text-slate-400">
                    Showing
                    <span class="font-medium">{{ $reports->firstItem() }}</span>
                    to
                    <span class="font-medium">{{ $reports->lastItem() }}</span>
                    of
                    <span class="font-medium">{{ $reports->total() }}</span>
                    results
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
