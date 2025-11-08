<aside class="sidebar">
    <div class="flex items-center justify-center bg-red-600">
        <a href="#" class="sidebar-logo">
            <img src="{{ asset('assets/basila_images/basila_white.png') }}" alt="site logo" class="light-logo"
                 width="120">
        </a>
    </div>
    <div class="sidebar-menu-area">
        <ul class="sidebar-menu" id="sidebar-menu">
            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
                    <span>Dashboard</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('index') }}"><i
                                class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> AI</a>
                    </li>
                    <li>
                        <a href="{{ route('index2') }}"><i
                                class="ri-circle-fill circle-icon text-warning-600 w-auto"></i> CRM</a>
                    </li>
                    <li>
                        <a href="{{ route('index3') }}"><i class="ri-circle-fill circle-icon text-info-600 w-auto"></i>
                            eCommerce</a>
                    </li>
                    <li>
                        <a href="{{ route('index4') }}"><i
                                class="ri-circle-fill circle-icon text-danger-600 w-auto"></i> Cryptocurrency</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</aside>
