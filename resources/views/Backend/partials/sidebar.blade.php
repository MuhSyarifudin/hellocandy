<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0">
            <img src="/admin/assets/img/CANDY.png" class="navbar-brand-img h-100" alt="main_logo">
            @if(auth()->check())
            <p class="text-white text-sm ps-5 mb-0"> Hi, {{ auth()->user()->nama }}</p>
            @endif
        </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <di class="collapse navbar-collapse  w-auto  max-height-vh-100" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('dashboard') ? 'active bg-gradient-primary' : '' }}"
                    href="/dashboard">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">dashboard</i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <!-- Menu untuk Kasir -->
            @if(auth()->user()->role == 'kasir' || auth()->user()->role == 'owner')
            <!-- Manajemen Produk  -->
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('products.index') ? 'active bg-gradient-primary' : '' }}"
                    href="{{ route('products.index') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">inventory</i>
                    </div>
                    <span class="nav-link-text ms-1">Semua Produk</span>
                </a>
            </li>

            <!-- Penjualan -->
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('sales.index') ? 'active bg-gradient-primary' : '' }}"
                    href="/sales">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">shopping_cart</i>
                    </div>
                    <span class="nav-link-text ms-1">Penjualan</span>
                </a>
            </li>

            <!-- Inventaris -->
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('inventory.index') ? 'active bg-gradient-primary' : '' }}"
                    href="/inventory">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">inventory</i>
                    </div>
                    <span class="nav-link-text ms-1">Inventaris</span>
                </a>
            </li>

            <!-- Pengeluaran -->
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('expenses.index') ? 'active bg-gradient-primary' : '' }}"
                    href="/expenses">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">attach_money</i>
                    </div>
                    <span class="nav-link-text ms-1">Pengeluaran</span>
                </a>
            </li>

            <!-- Laporan Mingguan -->
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('weekly-reports.index') ? 'active bg-gradient-primary' : '' }}"
                    href="/weekly-reports">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">calendar_today</i>
                        <!-- You can choose an appropriate icon here -->
                    </div>
                    <span class="nav-link-text ms-1">Laporan Mingguan</span>
                </a>
            </li>

            <!-- Laporan Bulanan -->
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('daily-reports.index') ? 'active bg-gradient-primary' : '' }}"
                    href="/daily-reports">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">bar_chart</i>
                    </div>
                    <span class="nav-link-text ms-1">Laporan Bulanan</span>
                </a>
            </li>
            <!-- Laporan Lengkap -->
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('reports.yearlySummary') ? 'active bg-gradient-primary' : '' }}"
                    href="/reports">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">assessment</i>
                    </div>
                    <span class="nav-link-text ms-1">Laporan Tahunan</span>
                </a>
            </li>
            <!-- Riwayat Penjualan -->
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('sales-history.index') ? 'active bg-gradient-primary' : '' }}"
                    href="/sales-history">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">history</i>
                    </div>
                    <span class="nav-link-text ms-1">Riwayat Penjualan</span>
                </a>
            </li>
            @endif

            <!-- Menu tambahan khusus untuk Owner -->
            @if(auth()->user()->role == 'owner')
            <!-- Manajemen Kategori Produk -->
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('categories.index') ? 'active bg-gradient-primary' : '' }}"
                    href="/categories">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">category</i>
                    </div>
                    <span class="nav-link-text ms-1">Manajemen Kategori</span>
                </a>
            </li>

            <!-- Manajemen Pengguna -->
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('users.index') ? 'active bg-gradient-primary' : '' }}"
                    href="/users">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">person</i>
                    </div>
                    <span class="nav-link-text ms-1">Manajemen Pengguna</span>
                </a>
            </li>


            @endif

            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Account pages
                </h6>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white  {{ request()->routeIs('profile') ? 'active bg-gradient-primary' : '' }}"
                    href="/admin/pages/profile.html">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">person</i>
                    </div>
                    <span class="nav-link-text ms-1">Profile</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="/login">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">exit_to_app</i>
                    </div>
                    <span class="nav-link-text ms-1">Logout</span>
                </a>
            </li>
        </ul>
    </di v>
</aside>