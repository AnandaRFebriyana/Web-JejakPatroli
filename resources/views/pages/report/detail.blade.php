@extends('layout.main')

@section('content')
<div class="flex flex-wrap -mx-3">
    <div class="w-full max-w-full px-3 md:flex-none">
        <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
            <!-- Header Section -->
            <div class="p-6 border-b border-slate-200 dark:border-slate-700">
                <div class="flex justify-between items-center">
                    <h6 class="text-xl font-semibold text-slate-700 dark:text-white">Detail Laporan Patroli</h6>
                    <a href="/report" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 transition-colors duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </a>
                </div>
            </div>

            <div class="flex-auto p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column - Basic Information -->
                    <div class="space-y-6">
                        <!-- Guard Information -->
                        <div class="bg-slate-50 dark:bg-slate-800 rounded-xl p-6">
                            <h6 class="text-lg font-semibold text-slate-700 dark:text-white mb-4">Informasi Satpam</h6>
                            <div class="flex items-center space-x-4">
                                <div class="w-16 h-16 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center">
                                    <i class="fas fa-user text-2xl text-slate-600 dark:text-white"></i>
                                </div>
                                <div>
                                    <h6 class="text-lg font-semibold text-slate-700 dark:text-white">{{ $report->guardRelation->name }}</h6>
                                    <p class="text-sm text-slate-500 dark:text-slate-400">Satpam Patroli</p>
                                </div>
                            </div>
                        </div>



                        <!-- Time Information -->
                        <div class="bg-slate-50 dark:bg-slate-800 rounded-xl p-6">
                            <h6 class="text-lg font-semibold text-slate-700 dark:text-white mb-4">Waktu Patroli</h6>
                            <div class="space-y-2">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-calendar text-slate-500"></i>
                                    <span class="text-slate-700 dark:text-white">{{ \Carbon\Carbon::parse($report->created_at)->translatedFormat('d F Y') }}</span>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-clock text-slate-500"></i>
                                    <span class="text-slate-700 dark:text-white">{{ $report->created_at->format('H:i:s') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Report Details -->
                    <div class="space-y-6">
                        <!-- Status Information -->
                        <div class="bg-slate-50 dark:bg-slate-800 rounded-xl p-6">
                            <h6 class="text-lg font-semibold text-slate-700 dark:text-white mb-4">Status Patroli</h6>
                            <div class="inline-block px-4 py-2 rounded-full" style="background-color: {{ $report->status == 'Aman' ? '#10B981' : '#EF4444' }}20">
                                <span class="text-lg font-medium" style="color: {{ $report->status == 'Aman' ? '#10B981' : '#EF4444' }}">
                                    {{ $report->status }}
                                </span>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="bg-slate-50 dark:bg-slate-800 rounded-xl p-6">
                            <h6 class="text-lg font-semibold text-slate-700 dark:text-white mb-4">Deskripsi Laporan</h6>
                            <p class="text-slate-700 dark:text-white leading-relaxed">
                                {{ $report->description }}
                            </p>
                        </div>

                        <!-- Media Section -->
                        @php
                            $attachments = json_decode($report->attachment, true);
                        @endphp

                        @if($attachments && count($attachments) > 0)
                            @foreach($attachments as $file)
                                <div class="bg-slate-50 dark:bg-slate-800 rounded-xl p-6">
                                    <h6 class="text-lg font-semibold text-slate-700 dark:text-white mb-4">Dokumentasi</h6>
                                    <div class="rounded-xl overflow-hidden">
                                        @if(Str::endsWith(strtolower($file), ['.jpg', '.jpeg', '.png', '.gif']))
                                            <img src="{{ asset('storage/' . $file) }}" alt="Lampiran" style="max-width:200px;">
                                        @elseif(Str::endsWith(strtolower($file), ['.mp4', '.mov', '.avi']))
                                            <video controls style="max-width:200px;">
                                                <source src="{{ asset('storage/' . $file) }}" type="video/mp4">
                                                Browser tidak mendukung video.
                                            </video>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="bg-slate-50 dark:bg-slate-800 rounded-xl p-6">
                                <h6 class="text-lg font-semibold text-slate-700 dark:text-white mb-4">Dokumentasi</h6>
                                <span class="text-slate-500">Tidak ada lampiran.</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<pre>media_path: {{ $report->media_path }}</pre>
<pre>asset: {{ asset('storage/' . $report->media_path) }}</pre>
@endsection
