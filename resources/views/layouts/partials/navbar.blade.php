<ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3"> SIMOTAS</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="index.html">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Pages
    </div>

    <!-- Nav Item - Pages Collapse Menu -->

    <li class="nav-item active">
        <a class="nav-link text-white font-weight-bold active" href="{{ route('beranda') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
        </a>
        <a class="nav-link text-white font-weight-bold" href="{{ route('disabilitas') }}">
            <i class="text-white fas fa-fw fa-file-alt"></i>
            <span>Data Disabilitas</span>
        </a>
        <a class="nav-link text-white font-weight-bold" href="{{ route('yatim.index') }}">
            <i class="text-white fas fa-fw fa-file-alt"></i>
            <span>Data Anak Yatim</span>
        </a>
        <a class="nav-link text-white font-weight-bold" href="{{ route('lansia.index') }}">
            <i class="text-white fas fa-fw fa-file-alt"></i>
            <span>Data Lansia</span>
        </a>
        <a class="nav-link text-white font-weight-bold" href="{{ route('report.show') }}">
            <i class="text-white fas fa-fw fa-file-alt"></i>
            <span>Laporan</span>
        </a>
        <a class="nav-link text-white font-weight-bold" href="{{ route('bansos.index') }}">
            <i class="text-white fas fa-fw fa-file-alt"></i>
            <span>Management Bansos</span>
        </a>
        @can('viewAny', \App\Models\User::class)
            <a class="nav-link text-white font-weight-bold" href="{{ route('user.index') }}">
                <i class="text-white fas fa-fw fa-file-alt"></i>
                <span>Management User</span>
            </a>
        @endcan


    </li>



</ul>
