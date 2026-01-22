<aside class="sidebar">
    <button type="button" class="sidebar-close-btn !mt-6">
        <iconify-icon icon="radix-icons:cross-2" class="text-neutral-200"></iconify-icon>
    </button>
    <div class="bg-[#FF0101]">
        <a href="{{ route('index') }}" class="sidebar-logo background-primary flex items-center justify-center">
            <img src="{{ asset('assets/basila_images/basila_white.png') }}" alt="site logo" class="light-logo"
                 width="120">
            <img src="{{ asset('assets/basila_images/logo_basila.png') }}" alt="site logo" class="logo-icon" width="30">
        </a>
    </div>
    <div class="sidebar-menu-area">
        <ul class="sidebar-menu" id="sidebar-menu">
            <div class="identitas flex flex-col items-center gap-3 my-16">
                <img src="{{ asset('assets/basila_images/favicon.png') }}"
                     class="w-20 object-cover mx-auto object-top"
                     alt="logo basila" id="logo">
                <div class="flex flex-col items-center w-full gap-2">
                    <h1 class="uppercase text-xl truncate overflow-hidden whitespace-nowrap max-w-[80%]"
                        id="sidebar-name">Admin - Ilham</h1>
                    <h5 class="text-sm font-normal" id="sidebar-nim">607062300081</h5>
                </div>
            </div>
            <li class="mb-4">
                <a href="https://basila.telkomuniversity.ac.id/basilav2/">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="dropdown mb-4">
                <a href="javascript:void(0)">
                    <iconify-icon icon="mdi:office-building" class="menu-icon"></iconify-icon>
                    <span>Building Management</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('index') }}">
                            <iconify-icon icon="mdi:dot" class="" style="font-size: 50px;"></iconify-icon>
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('index6') }}" class="">
                            <iconify-icon icon="mdi:dot" class="" style="font-size: 50px;"></iconify-icon>
                            Pengelolaan Ruangan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('index2') }}">
                            <iconify-icon icon="mdi:dot" class="" style="font-size: 50px;"></iconify-icon>
                            Peminjaman Ruangan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('approve-reservasi') }}">
                            <iconify-icon icon="mdi:dot" class="" style="font-size: 50px;"></iconify-icon>
                            Persetujuan Peminjaman
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('history-peminjaman') }}">
                            <iconify-icon icon="mdi:dot" class="" style="font-size: 50px;"></iconify-icon>
                            History Peminjaman
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</aside>
