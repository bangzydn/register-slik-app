<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
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
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Kartu Statistik -->
            <div class="bg-white dark:bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="grid grid-cols-4 gap-5 p-6">
                    <div class="bg-blue-800 p-6 rounded-2xl flex items-center justify-between shadow-xl border-2">
                        <div>
                            <div class="font-bold text-xl text-white">SLIK diterima</div>
                            <div class="font-extrabold text-white text-4xl">300</div>
                        </div>
                        <div class="text-4xl pt-2"><i class="fi fi-ss-book-open-cover"></i></div>
                    </div>
                    <div class="bg-blue-800 p-6 rounded-2xl flex items-center justify-between shadow-xl border-2">
                        <div>
                            <div class="font-bold text-xl text-white">SLIK Ditolak</div>
                            <div class="font-extrabold text-white text-4xl">300</div>
                        </div>
                        <div class="text-4xl pt-2"><i class="fi fi-sr-text"></i></div>
                    </div>
                    <div class="bg-blue-800 p-6 rounded-2xl flex items-center justify-between shadow-xl border-2">
                        <div>
                            <div class="font-bold text-xl text-white">Register Hari Ini</div>
                            <div class="font-extrabold text-white text-4xl">300</div>
                        </div>
                        <div class="text-4xl pt-2"><i class="fi fi-ss-source-data"></i></div>
                    </div>
                    <div class="bg-blue-800 p-6 rounded-2xl flex items-center justify-between shadow-xl border-2">
                        <div>
                            <div class="font-bold text-xl text-white">Register Bulan Ini</div>
                            <div class="font-extrabold text-white text-4xl">300</div>
                        </div>
                        <div class="text-4xl pt-2"><i class="fi fi-sr-box"></i></div>
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
