@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Data Disabilitas</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jmlDisabilitas }} Jiwa</div>
                        </div>
                        @if (auth()->user()->role === 'super_admin')
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-grey text-uppercase mb-1">
                                    Menunggu Konfirmasi
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <span class="badge bg-warning text-dark" style="font-size: 1rem; padding: 6px 12px;">
                                        {{ $jmlDisabilitasWating ?? 0 }}
                                    </span>
                                </div>
                            </div>
                        @else
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Data Anak Yatim</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jmlYatim }} Jiwa</div>
                        </div>
                        @if (auth()->user()->role === 'super_admin')
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-grey text-uppercase mb-1">
                                    Menunggu Konfirmasi
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <span class="badge bg-warning text-dark" style="font-size: 1rem; padding: 6px 12px;">
                                        {{ $jmlYatimWating ?? 0 }}
                                    </span>
                                </div>
                            </div>
                        @else
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Data Lansia
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $jmlLansia }} Jiwa</div>
                                </div>
                            </div>
                        </div>
                        @if (auth()->user()->role === 'super_admin')
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-grey text-uppercase mb-1">
                                    Menunggu Konfirmasi
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <span class="badge bg-warning text-dark" style="font-size: 1rem; padding: 6px 12px;">
                                        {{ $jmlLansiaWating ?? 0 }}
                                    </span>
                                </div>
                            </div>
                        @else
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <!-- Area Chart -->
        <div class="col-xl-12 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik</h6>
                    <form method="GET" action="{{ route('beranda') }}" class="d-flex align-items-center gap-2 mb-0">

                        <select name="tahun" id="tahun" class="form-control form-control-sm w-auto"
                            onchange="this.form.submit()">
                            @foreach ($tahunList as $tahun)
                                <option value="{{ $tahun }}" {{ $tahun == $selectedYear ? 'selected' : '' }}>
                                    {{ $tahun }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>

                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="kategoriChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('kategoriChart').getContext('2d');

        const kategoriChart = new Chart(ctx, {
            type: 'bar',
            data: {
                // labels: {!! json_encode($tahunList) !!}, // array tahun: [2021, 2022, 2023, ...]
                datasets: [{
                        label: 'Yatim',
                        data: {!! json_encode($dataYatimPerBulan) !!},
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.7)',
                        tension: 0.4
                    },
                    {
                        label: 'Lansia',
                        data: {!! json_encode($dataLansiaPerBulan) !!},
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.7)',
                        tension: 0.4
                    },
                    {
                        label: 'Disabilitas',
                        data: {!! json_encode($dataDisabilitasPerBulan) !!},
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    title: {
                        display: true,
                        text: 'Perkembangan Jumlah Warga per Kategori per Tahun'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

@endsection
