<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-blue-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{Auth::user()->name }} {{ __( "logged in!") }}
                </div>
            </div>
        </div>
    </div>
    <div class="py-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Kartu Statistik -->
            <div class="bg-white dark:bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="grid grid-cols-4 gap-5 p-6">
                    <div class="max-w-sm p-6 mb-2 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-blue-800 dark:border-gray-700">
                        <a href="#">
                            <h2 class="mb-4 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">SLIK Diterima</h2>
                        </a>
                        <div class="flex flex-auto justify-between mb-2">
                            <h1 class="mb-3 font-bold size-10 text-3xl text-white dark:text-white">{{ $jumlahRegslik  }}</h1>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-9 text-white">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 0 1 9 9v.375M10.125 2.25A3.375 3.375 0 0 1 13.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 0 1 3.375 3.375M9 15l2.25 2.25L15 12" />
                            </svg>
                        </div>
                        <a href="{{ route('reports.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Read more
                            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                            </svg>
                        </a>
                    </div>
                    <div class="max-w-sm p-6 mb-2 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-blue-800 dark:border-gray-700">
                        <a href="#">
                            <h2 class="mb-4 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">SLIK Ditolak</h2>
                        </a>
                        <div class="flex flex-auto justify-between mb-2">
                            <h1 class="mb-3 font-bold size-10 text-3xl text-white dark:text-white">{{ $jumlahRegslik  }}</h1>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-9 text-white">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </div>
                        <a href="{{ route('reports.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Read more
                            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                            </svg>
                        </a>
                    </div>
                    <div class="max-w-sm p-6 mb-2 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-blue-800 dark:border-gray-700">
                        <a href="#">
                            <h2 class="mb-4 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Register Hari Ini</h2>
                        </a>
                        <div class="flex flex-auto justify-between mb-2">
                            <h1 class="mb-3 font-bold size-10 text-3xl text-white dark:text-white">{{ $jumlahRegslik  }}</h1>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-9 text-white">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>

                        </div>
                        <a href="{{ route('regsliks.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Read more
                            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                            </svg>
                        </a>
                    </div>
                    <div class="max-w-sm p-6 mb-2 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-blue-800 dark:border-gray-700">
                        <a href="#">
                            <h2 class="mb-4 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Total Register</h2>
                        </a>
                        <div class="flex flex-auto justify-between mb-2">
                            <h1 class="mb-3 font-bold size-10 text-3xl text-white dark:text-white">{{ $jumlahRegslik  }}</h1>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-9 text-white">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                            </svg>
                        </div>
                        <a href="{{ route('regsliks.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Read more
                            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                            </svg>
                        </a>
                    </div>

                    
                </div>
            </div>

            <!-- Chart Container -->
            <!-- Chart Container -->
            <div class="bg-white dark:bg-white mt-8 p-6 rounded-lg shadow-lg">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-black text-center mb-4">Grafik Register SLIK per Bulan</h3>
                <div class="w-full h-[400px]">
                    <canvas id="loanChart" class="w-full h-full"></canvas>
                </div>
            </div>

        </div>
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const monthNames = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        const months = [1, 2, 3, 4, 5, 6];
        const jumlahRegisterSLIK = [12, 19, 8, 15, 10, 17];

        const monthLabels = months.map(month => monthNames[month - 1]);

        const ctx = document.getElementById('loanChart').getContext('2d');
        const loanChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: monthLabels,
                datasets: [{
                    label: 'Jumlah Register SLIK per Bulan',
                    data: jumlahRegisterSLIK,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            }
        });
    </script>

</x-app-layout>
