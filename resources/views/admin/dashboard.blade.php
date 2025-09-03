@extends('layouts.admin')
@section('content')
    <div class="px-4 md:px-6">
        <h1 class="text-[#1B1B1B] text-xl font-semibold">Welcome back, <span>{{ auth()->user()->name }} <span
                    class="text-2xl text-gray-300">&#x1F44B;</span></span></h1>
        <p class="text-[#848484] font-[16px]">You're logged in to the {{ site_settings()->site_name ?? config('app.name') }}
            Control Center.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-6 px-4 sm:px-6 lg:px-4">
        <!-- Total Students Card -->
        <div style="background-image: url('{{ asset('dashboard_assets/images/img/backg.png') }}')"
            class="bg-cover bg-center rounded-2xl flex items-center py-8 px-4 gap-4 sm:gap-6 col-span-1 sm:col-span-2">
            <div class=" flex items-center justify-center rounded-full w-14 h-14 bg-[#F5CE9F] ">
                <span class="hgi hgi-stroke hgi-student text-[#8C530D] text-3xl font-light"></span>
            </div>
            <div>
                <p class="text-[#1B1B1B] text-sm sm:text-base">Total Students</p>
                <h1 class="text-[#1B1B1B] text-xl sm:text-2xl font-bold">{{ $metric['total_students'] }}</h1>
            </div>
        </div>

        <!-- Total Instructors Card -->
        <div class="relative flex items-center py-8 px-4 rounded-2xl bg-white shadow-md">
            <div class="flex items-center gap-4 sm:gap-6">
                <div class=" flex items-center justify-center rounded-full w-14 h-14 bg-[#F5CE9F] ">
                    <span class="hgi  hgi-stroke hgi-mentoring text-[#8C530D] text-3xl font-light"></span>
                </div>
                <div>
                    <p class="text-[#1B1B1B] text-sm sm:text-base">Total Instructors</p>
                    <h1 class="text-[#1B1B1B] text-xl sm:text-2xl font-bold">{{ $metric['total_instructors'] }}</h1>
                </div>
            </div>
            <div class="absolute bottom-0 right-0"><img src="{{ asset('dashboard_assets/images/img/mentoring.png') }}"
                    alt="mentoring" class="w-16 h-16 sm:w-20 sm:h-20"></div>
        </div>

        <!-- Total Courses Card -->
        <div class="relative flex items-center py-8 px-4 rounded-2xl bg-white shadow-md">
            <div class="flex items-center gap-4 sm:gap-6">
                <div class=" flex items-center justify-center rounded-full w-14 h-14 bg-[#F5CE9F] ">
                    <span class="hgi hgi-stroke hgi-book-02 text-[#8C530D] text-3xl font-light"></span>
                </div>
                <div>
                    <p class="text-[#1B1B1B] text-sm sm:text-base">Total Courses</p>
                    <h1 class="text-[#1B1B1B] text-xl sm:text-2xl font-bold">{{ $metric['total_courses'] }}</h1>
                </div>
            </div>
            <div class="absolute bottom-0 right-0"><img src="{{ asset('dashboard_assets/images/img/book2.png') }}"
                    alt="book2" class="w-16 h-16 sm:w-20 sm:h-20"></div>
        </div>

        <!-- Number of Modules Card -->
        <div class="relative flex items-center py-8 px-4 rounded-2xl bg-white shadow-md">
            <div class="flex items-center gap-4 sm:gap-6">
                <div class=" flex items-center justify-center rounded-full w-14 h-14 bg-[#F5CE9F] ">
                    <span class="hgi hgi-stroke hgi-file-02 text-[#8C530D] text-3xl font-light"></span>
                </div>
                <div>
                    <p class="text-[#1B1B1B] text-sm sm:text-base">Number of Modules</p>
                    <h1 class="text-[#1B1B1B] text-xl sm:text-2xl font-bold">{{ $metric['total_modules'] }}</h1>
                </div>
            </div>
            <div class="absolute bottom-0 right-0"><img src="{{ asset('dashboard_assets/images/img/file2.png') }}"
                    alt="file2" class="w-16 h-16 sm:w-20 sm:h-20"></div>
        </div>

        <!-- Sign-ups This Month Card -->
        <div class="relative flex items-center py-8 px-4 rounded-2xl bg-white shadow-md">
            <div class="flex items-center gap-4 sm:gap-6">
                <div class=" flex items-center justify-center rounded-full w-14 h-14 bg-[#F5CE9F] ">
                    <span class="hgi hgi-stroke hgi-login-03 text-[#8C530D] text-3xl font-light"></span>
                </div>
                <div>
                    <p class="text-[#1B1B1B] text-sm sm:text-base">Sign-ups This Month</p>
                    <h1 class="text-[#1B1B1B] text-xl sm:text-2xl font-bold">{{ $metric['total_sign_ups_this_month'] }}
                    </h1>
                </div>
            </div>
            <div class="absolute bottom-0 right-0"><img src="{{ asset('dashboard_assets/images/img/login2.png') }}"
                    alt="login2" class="w-16 h-16 sm:w-20 sm:h-20"></div>
        </div>

        <!-- Revenue Chart Section -->
        <section class="rounded-2xl bg-white shadow-md p-4 col-span-1 sm:col-span-2 lg:col-span-3">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-base sm:text-lg font-semibold">Admin Revenue</h2>
                <div class="relative">
                    <select id="select-year"
                        class="flex items-center w-50 px-3 py-2 border rounded-xl bg-white text-sm sm:text-base text-gray-900 hover:bg-gray-50 dark:hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:focus:ring-slate-700 appearance-none cursor-pointer">
                        <option value="current-month">Current Month</option>
                        <option value="last-month">Last Month</option>
                        <option value="last-3-months">Last 3 Months</option>
                        <option value="last-6-months">Last 6 Months</option>
                        <option value="last-year">Last Year</option>
                    </select>
                </div>
            </div>
            <div class="w-full h-64 sm:h-80">
                <canvas id="chart"></canvas>
            </div>
        </section>
    </div>

    <script>
        // Toggle dropdown menu for year selection
        document.getElementById('btn-year').addEventListener('click', () => {
            const menu = document.getElementById('menu-year');
            menu.classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (event) => {
            const menu = document.getElementById('menu-year');
            const button = document.getElementById('btn-year');
            if (!menu.contains(event.target) && !button.contains(event.target)) {
                menu.classList.add('hidden');
            }
        });
    </script>
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
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: (ctx) => new Intl.NumberFormat("en-NG", {
                                style: "currency",
                                currency: "NGN",
                                maximumFractionDigits: 0
                            }).format(ctx.raw)
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: "#6B7280"
                        }
                    },
                    y: {
                        grid: {
                            color: "rgba(31,41,55,0.08)"
                        },
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
