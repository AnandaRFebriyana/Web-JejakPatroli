@extends('layout.main')

@section('content')
    
  <!-- row 1 -->
  <div class="flex flex-wrap -mx-3">
    <!-- card1 -->
    <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
      <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
        <div class="flex-auto p-4">
          <div class="flex flex-row -mx-3">
            <div class="flex-none w-2/3 max-w-full px-3">
              <div>
                <p class="mb-0 font-sans text-sm font-semibold leading-normal uppercase dark:text-white dark:opacity-60">Izin Satpam</p>
                <h5 class="mb-2 font-bold dark:text-white">{{ $permitToday }}</h5>
                <p class="mb-0 dark:text-white dark:opacity-60">
                  <span class="text-sm font-bold leading-normal text-emerald-500"></span>
                  hari ini
                </p>
              </div>
            </div>
            <div class="px-3 text-right basis-1/3">
              <div class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-blue-500 to-violet-500">
                <i class="ni leading-none ni-check-bold text-lg relative top-3.5 text-white"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- card2 -->
    <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
      <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
        <div class="flex-auto p-4">
          <div class="flex flex-row -mx-3">
            <div class="flex-none w-2/3 max-w-full px-3">
              <div>
                <p class="mb-0 font-sans text-sm font-semibold leading-normal uppercase dark:text-white dark:opacity-60">Total Kehadiran</p>
                <h5 class="mb-2 font-bold dark:text-white">{{ $attendance['totalAttendance'] }}</h5>
                <p class="mb-0 dark:text-white dark:opacity-60">
                  <span class="text-sm font-bold leading-normal text-emerald-500">{{ round($attendance['percentage'], 2) }}%</span>
                  bulan ini
                </p>
              </div>
            </div>
            <div class="px-3 text-right basis-1/3">
              <div class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-red-600 to-orange-600">
                <i class="ni leading-none ni-calendar-grid-58 text-lg relative top-3.5 text-white"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- card3 -->
    <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
      <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
        <div class="flex-auto p-4">
          <div class="flex flex-row -mx-3">
            <div class="flex-none w-2/3 max-w-full px-3">
              <div>
                <p class="mb-0 font-sans text-sm font-semibold leading-normal uppercase dark:text-white dark:opacity-60">Total Laporan</p>
                <h5 class="mb-2 font-bold dark:text-white">{{ $report['totalReports'] }}</h5>
                <p class="mb-0 dark:text-white dark:opacity-60">
                  <span class="text-sm font-bold leading-normal text-emerald-500">{{ round($report['percentage'], 2) }}%</span>
                  bulan ini
                </p>
              </div>
            </div>
            <div class="px-3 text-right basis-1/3">
              <div class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-emerald-500 to-teal-400">
                <i class="ni leading-none ni-paper-diploma text-lg relative top-3.5 text-white"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- card4 -->
    <div class="w-full max-w-full px-3 sm:w-1/2 sm:flex-none xl:w-1/4">
      <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
        <div class="flex-auto p-4">
          <div class="flex flex-row -mx-3">
            <div class="flex-none w-2/3 max-w-full px-3">
              <div>
                <p class="mb-0 font-sans text-sm font-semibold leading-normal uppercase dark:text-white dark:opacity-60">Total Izin</p>
                <h5 class="mb-2 font-bold dark:text-white">{{ $permitStats['totalPermissions'] }}</h5>
                <p class="mb-0 dark:text-white dark:opacity-60">
                  <span class="text-sm font-bold leading-normal text-emerald-500">{{ round($permitStats['percentage'], 2) }}%</span>
                  bulan ini
                </p>
              </div>
            </div>
            <div class="px-3 text-right basis-1/3">
              <div class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-orange-500 to-yellow-500">
                <i class="ni leading-none ni-send text-lg relative top-3.5 text-white"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- cards row 1 -->
  <div class="flex flex-wrap mt-6 -mx-3">
    <div class="w-full max-w-full px-3 mt-0 mb-6 lg:mb-0 lg:flex-none">
      <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl dark:bg-gray-950 border-black-125 rounded-2xl bg-clip-border">

        <div class="p-4 pb-0 rounded-t-4">
          <div class="flex justify-between">
            <h6 class="dark:text-white">Data Izin Satpam</h6>
          </div>
          <div class="flex flex-wrap justify-end">
            <div class="mb-4 mx-4 flex flex-col relative">
                <label for="start-date" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Tanggal Mulai</label>
                <input type="date" id="start-date" name="start-date" class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" style="max-width: 250px;">
            </div>
            <div class="mb-4 mx-4 flex flex-col relative">
                <label for="end-date" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Tanggal Akhir</label>
                <input type="date" id="end-date" name="end-date" class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" style="max-width: 250px;">
            </div>
            <div class="mb-4 mx-4 flex flex-col relative">
              <button id="filter-button" class="inline-block px-8 py-2 mb-4 font-bold leading-normal text-center text-white align-middle transition-all ease-in bg-tosca border-0 rounded-lg shadow-md cursor-pointer text-xs tracking-tight-rem hover:shadow-xs hover:-translate-y-px active:opacity-85">Filter</button>
            </div>
          </div>
        </div>
        
        <div class="overflow-x-auto">
          <table class="items-center w-full mb-4 align-top border-collapse border-gray-200 dark:border-white/40">
            <thead class="align-bottom">
              <tr>
                <th class="mb-0 text-center text-xs font-semibold leading-tight dark:text-white dark:opacity-60 p-2 align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">No</th>
                <th class="mb-0 text-center text-xs font-semibold leading-tight dark:text-white dark:opacity-60 p-2 align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">Nama Satpam</th>
                <th class="mb-0 text-center text-xs font-semibold leading-tight dark:text-white dark:opacity-60 p-2 align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">Tanggal Izin</th>
                <th class="mb-0 text-center text-xs font-semibold leading-tight dark:text-white dark:opacity-60 p-2 align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">Alasan</th>
                <th class="mb-0 text-center text-xs font-semibold leading-tight dark:text-white dark:opacity-60 p-2 align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">Surat Keterangan</th>
              </tr>
            </thead>
            <tbody id="data-table-body">
              @foreach ($permissions as $index => $permit)
              <tr>
                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
                    <h6 class="mb-0 text-center text-sm leading-normal dark:text-white">{{ $index + 1 }}</h6>
                </td>
                <td class="p-2 align-middle bg-transparent border-b w-3/10 whitespace-nowrap dark:border-white/40">
                    <h6 class="mb-0 text-center text-sm leading-normal dark:text-white">{{ $permit->guardRelation->name }}</h6>
                </td>
                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
                    <h6 class="mb-0 text-center text-sm leading-normal dark:text-white">{{ \Carbon\Carbon::parse($permit->permission_date)->translatedFormat('d F Y') }}</h6>
                </td>
                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
                    <h6 class="mb-0 text-center text-sm leading-normal dark:text-white">{{ $permit->reason }}</h6>
                </td>
                <td class="p-2 text-sm leading-normal align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
                  <div class="flex-1 text-center">
                      <a href="{{ asset('storage/' . $permit->information) }}" class="btn btn-success text-xs border-0" download>
                          <h6 class="mb-0 text-sm leading-normal text-white">Unduh</h6>
                      </a>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          <div class="flex justify-between px-6 mb-1">
            <div class="mt-3 text-xs text-gray-700">
                Showing
                {{ $permissions->firstItem() }}
                to
                {{ $permissions->lastItem() }}
                of
                {{ $permissions->total() }}
            </div>
            <div class="mt-1">
                {{ $permissions->links() }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- end cards -->
</div>
</main>
<script>
document.getElementById('filter-button').addEventListener('click', function() {
    const startDate = document.getElementById('start-date').value;
    const endDate = document.getElementById('end-date').value;
    // console.log('Start Date:', startDate);
    // console.log('End Date:', endDate);

    fetch('/filter-permission', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            'start-date': startDate,
            'end-date': endDate
        })
    })
    .then(response => response.json())
    .then(data => {
        // console.log('Data:', data);

        const tableBody = document.getElementById('data-table-body');
        tableBody.innerHTML = '';

        const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        data.forEach((item, index) => {
            // console.log('Item:', item);

            const date = new Date(item.permission_date);
            const day = date.getDate();
            const monthIndex = date.getMonth();
            const year = date.getFullYear();
            const formattedDate = `${day} ${monthNames[monthIndex]} ${year}`;

            const row = `
            <tr>
                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
                    <h6 class="mb-0 text-center text-sm leading-normal dark:text-white">${index + 1}</h6>
                </td>
                <td class="p-2 align-middle bg-transparent border-b w-3/10 whitespace-nowrap dark:border-white/40">
                    <h6 class="mb-0 text-center text-sm leading-normal dark:text-white">${item.guard_relation.name}</h6>
                </td>
                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
                    <h6 class="mb-0 text-center text-sm leading-normal dark:text-white">${formattedDate}</h6>
                </td>
                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
                    <h6 class="mb-0 text-center text-sm leading-normal dark:text-white">${item.reason}</h6>
                </td>
                <td class="p-2 text-sm leading-normal align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
                  <div class="flex-1 text-center">
                      <a href="/storage/${item.information}" class="btn btn-success text-xs border-0" download>
                          <h6 class="mb-0 text-sm leading-normal text-white">Unduh</h6>
                      </a>
                  </div>
                </td>
              </tr>
            `;
            tableBody.insertAdjacentHTML('beforeend', row);
        });
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
</script>
@endsection