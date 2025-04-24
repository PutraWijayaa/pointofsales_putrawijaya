<!-- <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link collapsed" href="/dashboard">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        @if(Auth::user()->hasAnyRole(['admin']))
        <li class="nav-heading">
            Management</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="/users">
                <i class="bi bi-person"></i>
                <span>Users</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="/roles">
                <i class="bi bi-person"></i>
                <span>Role</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i><span>Product</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="/categories">
                        <i class="bi bi-circle"></i><span>Category</span>
                    </a>
                </li>
                <li>
                    <a href="/product">
                        <i class="bi bi-circle"></i><span>Products</span>
                    </a>
                </li>
            </ul>
        </li>
        @endif

        @if(Auth::user()->hasAnyRole(['Kasir']))

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-journal-text"></i><span>Operations</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('pos.create') }}" target="_blank">
                        <i class="bi bi-circle"></i><span>Kasir</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('pos.index') }}">
                        <i class="bi bi-circle"></i><span>Penjualan</span>
                    </a>
                </li>

            </ul>
        </li>
        @endif


        @if(Auth::user()->hasAnyRole(['superadmin']))

        <li class="nav-item">
            <a class="nav-link collapsed" href="/logout">
                <i class="bi bi-box-arrow-right"></i>
                <span>Stock</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i><span>Laporan</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="/categories">
                        <i class="bi bi-circle"></i><span>Bulanan</span>
                    </a>
                </li>
                <li>
                    <a href="/product">
                        <i class="bi bi-circle"></i><span>Mingguan</span>
                    </a>
                </li>
                <li>
                    <a href="/product">
                        <i class="bi bi-circle"></i><span>Harian</span>
                    </a>
                </li>
            </ul>
        </li>
        @endif

        <li class="nav-item">
            <a class="nav-link collapsed" href="/logout">
                <i class="bi bi-box-arrow-left"></i>
                <span>Logout</span>
            </a>
        </li>

    </ul>

</aside> -->

<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        <!-- Dashboard Nav -->
        <li class="nav-item">
            <a class="nav-link" href="/dashboard">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- Admin Section -->
        @if(Auth::user()->hasAnyRole(['admin']))
        <li class="nav-heading">Management</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="/users">
                <i class="bi bi-people"></i>
                <span>Users</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="/roles">
                <i class="bi bi-person-badge"></i>
                <span>Roles</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#products-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-box"></i>
                <span>Products</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="products-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="/categories">
                        <i class="bi bi-circle"></i>
                        <span>Categories</span>
                    </a>
                </li>
                <li>
                    <a href="/product">
                        <i class="bi bi-circle"></i>
                        <span>Products</span>
                    </a>
                </li>
            </ul>
        </li>
        @endif

        <!-- Kasir Section -->
        @if(Auth::user()->hasAnyRole(['Kasir']))
        <li class="nav-heading">Operations</li>

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#operations-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-cash-register"></i>
                <span>POS Operations</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="operations-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('pos.create') }}" target="_blank">
                        <i class="bi bi-circle"></i>
                        <span>Cashier</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('pos.index') }}">
                        <i class="bi bi-circle"></i>
                        <span>Sales</span>
                    </a>
                </li>
            </ul>
        </li>
        @endif

        <!-- Superadmin Section -->
        @if(Auth::user()->hasAnyRole(['pimpinan']))
        <li class="nav-heading">Inventory & Reports</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="/stock">
                <i class="bi bi-boxes"></i>
                <span>Stock</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#reports-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-file-earmark-bar-graph"></i>
                <span>Reports</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="reports-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="/monthly">
                        <i class="bi bi-circle"></i>
                        <span>Monthly</span>
                    </a>
                </li>
                <li>
                    <a href="/weekly">
                        <i class="bi bi-circle"></i>
                        <span>Weekly</span>
                    </a>
                </li>
                <li>
                    <a href="/daily">
                        <i class="bi bi-circle"></i>
                        <span>Daily</span>
                    </a>
                </li>
            </ul>
        </li>
        @endif

        <!-- Logout for all users -->
        <li class="nav-heading">Account</li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="/logout">
                <i class="bi bi-box-arrow-left"></i>
                <span>Logout</span>
            </a>
        </li>

    </ul>
</aside>
