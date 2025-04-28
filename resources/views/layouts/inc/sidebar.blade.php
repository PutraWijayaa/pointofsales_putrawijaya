<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        <!-- Dashboard -->
        <li class="nav-item">
            <a class="nav-link {{ request()->is('dashboard') ? '' : 'collapsed' }}" href="/dashboard">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- Admin Section -->
        @if (Auth::user()->hasAnyRole(['admin']))
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
            <a class="nav-link collapsed" href="/popular-products">
                <i class="bi bi-graph-up"></i>
                <span>Top Product</span>
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
        @if (Auth::user()->hasAnyRole(['Kasir']))
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

        <!-- Pimpinan Section -->
        @if (Auth::user()->hasAnyRole(['pimpinan']))
        <li class="nav-heading">Inventory & Reports</li>

        <li class="nav-item">
            <a class="nav-link {{ request()->is('report') ? '' : 'collapsed' }}" href="{{ route('stock.report') }}">
                <i class="bi bi-box-seam"></i>
                <span>Stock</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->is('history') ? '' : 'collapsed' }}" href="{{ route('stock.history') }}">
                <i class="bi bi-clock-history"></i>
                <span>Stock History</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->is('monthly') || request()->is('weekly') || request()->is('daily') ? '' : 'collapsed' }}"
                data-bs-target="#reports-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-bar-chart-line"></i>
                <span>Reports</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="reports-nav"
                class="nav-content collapse {{ request()->is('monthly') || request()->is('weekly') || request()->is('daily') ? 'show' : '' }}"
                data-bs-parent="#sidebar-nav">
                <li>
                    <a href="/monthly" class="{{ request()->is('monthly') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i>
                        <span>Monthly</span>
                    </a>
                </li>
                <li>
                    <a href="/weekly" class="{{ request()->is('weekly') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i>
                        <span>Weekly</span>
                    </a>
                </li>
                <li>
                    <a href="/daily" class="{{ request()->is('daily') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i>
                        <span>Daily</span>
                    </a>
                </li>
            </ul>
        </li>
        @endif

        <!-- Logout -->
        <li class="nav-heading">Account</li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="/logout">
                <i class="bi bi-box-arrow-left"></i>
                <span>Logout</span>
            </a>
        </li>

    </ul>
</aside>
