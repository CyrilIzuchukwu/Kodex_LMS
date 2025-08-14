@extends('layouts.admin')
@section('content')
    <div>
        <div>
            <h1 class="text-[#1B1B1B] text-xl font-semibold">Welcome back, <span>Admin <span class="text-2xl text-gray-300">&#x1F44B;</span></span></h1>
            <p class="text-[#848484] font-[16px]">You're logged in to the Kodex Control Center.</p>
        </div>

        <div class="grid grid-cols-3 gap-4 mt-10">
            <div style="background-image: url('{{ asset('dashboard_assets/images/img/backg.png') }}')"
                 class="bg-cover bg-center rounded-2xl col-span-2 flex items-center py-10 px-4 gap-[18px]">
                <div><img src="{{ asset('dashboard_assets/images/img/head.png') }}" alt="head"></div>
                <div>
                    <p class="text-[#1B1B1B] font-[16px]">Total Students</p>
                    <h1 class="text-[#1B1B1B] text-2xl font-[24px]">300</h1>
                </div>
            </div>

            <div class="relative flex items-center py-10 px-4 rounded-2xl bg-white shadow-md">
                <div class="flex items-center gap-[18px]">
                    <div>
                        <div><img src="{{ asset('dashboard_assets/images/img/two.png') }}" alt="two"></div>
                    </div>
                    <div>
                        <p class="text-[#1B1B1B] font-[16px]">Total Instructors</p>
                        <h1 class="text-[#1B1B1B] text-2xl font-[24px]">120</h1>
                    </div>
                </div>
                <div class="absolute bottom-0 right-0"><img src="{{ asset('dashboard_assets/images/img/mentoring.png') }}" alt="mentoring"></div>
            </div>

            <div class="relative flex items-center py-10 px-4 rounded-2xl bg-white shadow-md">
                <div class="flex items-center gap-[18px]">
                    <div>
                        <div><img src="{{ asset('dashboard_assets/images/img/book.png') }}" alt="book"></div>
                    </div>
                    <div>
                        <p class="text-[#1B1B1B] font-[16px]">Total courses</p>
                        <h1 class="text-[#1B1B1B] text-2xl font-[24px]">4</h1>
                    </div>
                </div>
                <div class="absolute bottom-0 right-0"><img src="{{ asset('dashboard_assets/images/img/book2.png') }}" alt="book2"></div>
            </div>

            <div class="relative flex items-center py-10 px-4 rounded-2xl bg-white shadow-md">
                <div class="flex items-center gap-[18px]">
                    <div>
                        <div><img src="{{ asset('dashboard_assets/images/img/file.png') }}" alt="file"></div>
                    </div>
                    <div>
                        <p class="text-[#1B1B1B] font-[16px]">Number of Modules</p>
                        <h1 class="text-[#1B1B1B] text-2xl font-[24px]">4</h1>
                    </div>
                </div>
                <div class="absolute bottom-0 right-0"><img src="{{ asset('dashboard_assets/images/img/file2.png') }}" alt="file2"></div>
            </div>

            <div class="relative flex items-center py-10 px-4 rounded-2xl bg-white shadow-md">
                <div class="flex items-center gap-[18px]">
                    <div>
                        <div><img src="{{ asset('dashboard_assets/images/img/login.png') }}" alt="login"></div>
                    </div>
                    <div>
                        <p class="text-[#1B1B1B] font-[16px]">Sign-ups This month</p>
                        <h1 class="text-[#1B1B1B] text-2xl font-[24px]">4</h1>
                    </div>
                </div>
                <div class="absolute bottom-0 right-0"><img src="{{ asset('dashboard_assets/images/img/login2.png') }}" alt="login2"></div>
            </div>

            <!-- Revenue chart -->
            <section class="rounded-2xl bg-white shadow-md p-4 col-span-3">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold">Admin Revenue</h2>
                    <div class="relative">
                        <button id="btn-year" class="flex items-center gap-2 px-3 py-2 border rounded-xl hover:bg-gray-50 dark:hover:bg-slate-800">This Year
                            <svg class="icon" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.25 8.29a.75.75 0 0 1-.02-1.08Z" clip-rule="evenodd"/></svg>
                        </button>
                        <div id="menu-year" class="hidden absolute right-0 mt-2 w-40 bg-white dark:bg-slate-900 border rounded-xl shadow-subtle p-1">
                            <button class="block w-full text-left rounded-lg px-3 py-2 hover:bg-gray-50 dark:hover:bg-slate-800">This Year</button>
                            <button class="block w-full text-left rounded-lg px-3 py-2 hover:bg-gray-50 dark:hover:bg-slate-800">Last Year</button>
                            <button class="block w-full text-left rounded-lg px-3 py-2 hover:bg-gray-50 dark:hover:bg-slate-800">2023</button>
                        </div>
                    </div>
                </div>
                <div class="w-full h-80"><canvas id="chart"></canvas></div>
            </section>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Chart.js setup
        const ctx = document.getElementById("chart").getContext("2d");
        const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        const values = [0, 0, 0, 0, 0, 0, 200000, 1500000, 10000, 20000, 10000, 20000];
        const gradient = ctx.createLinearGradient(0, 0, 0, 200);
        gradient.addColorStop(0, "rgba(245,158,11,.25)");
        gradient.addColorStop(1, "rgba(245,158,11,0)");
        new Chart(ctx, {
            type: "line",
            data: {
                labels: months,
                datasets: [{
                    label: "This Year",
                    data: values,
                    tension: 0.35,
                    borderColor: "#F59E0B",
                    borderWidth: 3,
                    pointRadius: 3,
                    pointHoverRadius: 5,
                    fill: true,
                    backgroundColor: gradient
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: (ctx) => new Intl.NumberFormat("en-NG", { style: "currency", currency: "NGN", maximumFractionDigits: 0 }).format(ctx.raw)
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: "#6B7280" }
                    },
                    y: {
                        grid: { color: "rgba(31,41,55,0.08)" },
                        ticks: {
                            color: "#6B7280",
                            callback: (v) => v / 1000 + "k"
                        }
                    },
                },
            },
        });
    </script>
@endpush
