@extends('layout.main')

@section('content')
<div class="flex flex-wrap -mx-3">
  <div class="w-full max-w-full px-3 md:flex-none">
    <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
      <div class="flex-auto p-5 pt-7">
        <div class="w-full px-3 mb-6">
          <div class="relative flex flex-col p-4 bg-white border-0 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
            <div class="flex justify-between items-start">
              <div class="flex-auto">
                <div class="mb-2 text-sm leading-tight dark:text-white/80">
                  <span class="font-semibold text-slate-700 dark:text-white">Nama:</span>
                  <span class="text-slate-700 dark:text-white">{{ $report->guardRelation->name }}</span>
                </div>
                <div class="mb-2 text-sm leading-tight dark:text-white/80">
                  <span class="font-semibold text-slate-700 dark:text-white">Lokasi:</span>
                  <span class="text-slate-700 dark:text-white">{{ $report->location->location_name }}</span>
                </div>
                <div class="text-sm leading-tight dark:text-white/80 mb-2">
                  <span class="font-semibold text-slate-700 dark:text-white">Status:</span>
                  <span class="text-slate-700 dark:text-white sm:ml-2" style="background-color: {{ $report->status == 'Aman' ? 'green' : 'red' }}; padding: 2px 4px; border-radius: 4px; color: white;">
                    {{ $report->status }}
                  </span>
                </div>
                <div class="mb-2 text-sm leading-tight dark:text-white/80">
                  <span class="font-semibold text-slate-700 dark:text-white">Deskripsi:</span>
                  <span class="text-slate-700 dark:text-white">{{ $report->description }}</span>
                </div>
                <div class="mb-2 text-sm leading-tight dark:text-white/80">
                    <span class="font-semibold text-slate-700 dark:text-white">Lampiran:</span>
                    <div class="mt-3 flex flex-wrap">
                        @php
                            $rawAttachment = $report->attachment;
                            $attachments = [];

                            if (!empty($rawAttachment)) {
                                $attachments = [$rawAttachment];
                            }
                        @endphp

                        @forelse ($attachments as $attachment)
                            <div class="max-w-1/3 p-2">
                                <img src="{{ asset('storage/' . $attachment) }}" alt="Lampiran" class="max-w-64 h-auto rounded-lg" />
                            </div>
                        @empty
                            <p class="text-slate-500 dark:text-white/50">Tidak ada lampiran tersedia.</p>
                        @endforelse
                    </div>
                </div>



                {{-- <div class="mb-2 text-sm leading-tight dark:text-white/80">
                    <span class="font-semibold text-slate-700 dark:text-white">Lampiran:</span>
                    <div class="mt-3 flex flex-wrap">
                        @php
                            $rawAttachment = $report->attachment;
                            $decoded = json_decode($rawAttachment, true);
                            $attachments = [];

                            if (is_array($decoded)) {
                                $attachments = $decoded;
                            } elseif (is_string($decoded) && !empty($decoded)) {
                                $attachments = [$decoded];
                            }
                        @endphp

                        @forelse ($attachments as $attachment)
                            <div class="max-w-1/3 p-2">
                                @if(\Illuminate\Support\Facades\Storage::exists($attachment))
                                    <img src="{{ asset('storage/' . $attachment) }}" alt="Lampiran" class="max-w-64 h-auto rounded-lg" />
                                @else
                                    <img src="{{ asset('assets/img/default_image.png') }}" alt="Lampiran tidak ditemukan" class="max-w-64 h-auto rounded-lg" />
                                @endif
                            </div>
                        @empty
                            <p class="text-slate-500 dark:text-white/50">Tidak ada lampiran tersedia.</p>
                        @endforelse
                    </div>
                </div> --}}


                {{-- <div class="mb-2 text-sm leading-tight dark:text-white/80">
                    <span class="font-semibold text-slate-700 dark:text-white">Lampiran:</span>
                    <div class="mt-3 flex flex-wrap">
                        @php
                            $attachments = is_array(json_decode($report->attachment)) ? json_decode($report->attachment) : [];
                        @endphp

                        @forelse ($attachments as $attachment)
                            <div class="max-w-1/3 p-2">
                                @if($attachment && \Illuminate\Support\Facades\Storage::exists($attachment))
                                    <img src="{{ asset('storage/' . $attachment) }}" alt="Lampiran" class="max-w-64 h-auto rounded-lg" />
                                @else
                                    <img src="{{ asset('assets/img/default_image.png') }}" alt="Lampiran tidak ditemukan" class="max-w-64 h-auto rounded-lg" />
                                @endif
                            </div>
                        @empty
                            <p class="text-slate-500 dark:text-white/50">Tidak ada lampiran tersedia.</p>
                        @endforelse
                    </div>
                </div> --}}

                {{-- <div class="mb-2 text-sm leading-tight dark:text-white/80">
                  <span class="font-semibold text-slate-700 dark:text-white">Lampiran:</span>
                  <div class="mt-3 flex">
                    @if(isset($report->attachment) && is_array(json_decode($report->attachment)))
                        @foreach(json_decode($report->attachment) as $attachment)
                            <div class="max-w-1/3 p-2">
                                <img src="{{ asset('storage/' . $attachment) }}" alt="Lampiran" class="max-w-64 h-auto rounded-lg">
                            </div>
                        @endforeach
                    @endif
                  </div>
              </div> --}}
              </div>
              <div class="text-right">
                <h6 class="text-md leading-normal dark:text-white">{{ \Carbon\Carbon::parse($report->created_at)->translatedFormat('l, d F Y') }}</h6>
                <span class="text-sm leading-tight dark:text-white/80">{{ $report->created_at->format('H:i:s') }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
