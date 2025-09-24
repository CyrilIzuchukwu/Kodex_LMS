@extends('layouts.admin')
@section('content')
    @php
        $name = explode(' ', auth()->user()->name, 2);
        $user_name = $name[0];
    @endphp

    <div class="px-4 md:px-6 py-4">
        <h1 class="text-gray-900 text-2xl md:text-3xl font-bold font-Inter tracking-tight">
            Hi, <span class="inline-flex items-center">{{ ucfirst($user_name) }}.</span>
        </h1>
        <p class="text-gray-600 text-base md:text-lg font-medium font-Inter mt-2">
            You're logged in to the {{ site_settings()->site_name ?? config('app.name') }} Control Center.
        </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-6 px-0 sm:px-0 lg:px-0">
        <!-- Total Students Card -->
        <div style="background-image: url('{{ asset('dashboard_assets/images/img/backg.png') }}')" class="bg-cover bg-center rounded-2xl flex items-center py-8 px-4 gap-4 sm:gap-6 col-span-1 sm:col-span-2">
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
            <div class="absolute bottom-0 right-0">
                <img src="{{ asset('dashboard_assets/images/img/mentoring.png') }}" alt="mentoring" class="w-16 h-16 sm:w-20 sm:h-20">
            </div>
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
            <div class="absolute bottom-0 right-0">
                <img src="{{ asset('dashboard_assets/images/img/book2.png') }}" alt="book2" class="w-16 h-16 sm:w-20 sm:h-20">
            </div>
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
            <div class="absolute bottom-0 right-0">
                <img src="{{ asset('dashboard_assets/images/img/file2.png') }}" alt="file2" class="w-16 h-16 sm:w-20 sm:h-20">
            </div>
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
            <div class="absolute bottom-0 right-0">
                <img src="{{ asset('dashboard_assets/images/img/login2.png') }}" alt="login2" class="w-16 h-16 sm:w-20 sm:h-20">
            </div>
        </div>

        <!-- Revenue Chart Section -->
        <section class="rounded-2xl bg-white shadow-md p-4 col-span-1 sm:col-span-2 lg:col-span-3">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-base sm:text-lg font-semibold">Admin Revenue</h2>
                <div class="relative">
                    <select id="select-year" class="flex items-center px-3 py-2 border rounded-xl bg-white text-sm sm:text-base text-gray-900 hover:bg-gray-50 dark:hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:focus:ring-slate-700 appearance-none cursor-pointer" style="width: 160px;">
                        <option value="current_month">Current month</option>
                        <option value="last_month">Last month</option>
                        <option value="last_3_months">Last 3 months</option>
                        <option value="last_6_months">Last 6 months</option>
                        <option value="last_year">Last year</option>
                    </select>
                </div>
            </div>
            <div class="w-full h-64 sm:h-80">
                <canvas id="chart"></canvas>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        const ctx = document.getElementById("chart").getContext("2d");

        // Gradient for line fill
        const gradient = ctx.createLinearGradient(0, 0, 0, 200);
        gradient.addColorStop(0, "rgba(245,158,11,.25)");
        gradient.addColorStop(1, "rgba(245,158,11,0)");

        // Initialize an empty chart
        const revenueChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: [],   // filled dynamically
                datasets: [{
                    label: "Revenue",
                    data: [],
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
                            label: (ctx) =>
                                new Intl.NumberFormat("en-NG", {
                                    style: "currency",
                                    currency: "NGN",
                                    maximumFractionDigits: 0
                                }).format(ctx.raw)
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
                    }
                },
            },
        });

        // Fetch and update chart
        function fetchRevenue(period = 'current_month') {
            fetch(`{{ route('admin.dashboard') }}?period=${period}`)
                .then(res => res.json())
                .then(data => {
                    // Access nested 'original' object
                    revenueChart.data.labels = data.original.labels;
                    revenueChart.data.datasets[0].data = data.original.values;
                    revenueChart.data.datasets[0].label = data.original.label;
                    revenueChart.update();
                })
                .catch(err => console.error('Error fetching revenue data:', err));
        }

        // Detect dropdown + load initial
        const selectYear = document.getElementById('select-year');
        fetchRevenue(selectYear.value);

        // Handle dropdown change
        selectYear.addEventListener('change', (e) => {
            fetchRevenue(e.target.value);
        });
    </script>
@endpush
