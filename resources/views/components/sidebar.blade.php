<aside class="sidebar">
    <button type="button" class="sidebar-close-btn !mt-6">
        <iconify-icon icon="radix-icons:cross-2" class="text-neutral-200"></iconify-icon>
    </button>
    <div class="bg-[#e51411]">
        <a href="{{ route('index') }}" class="sidebar-logo background-primary flex items-center justify-center">
            <img src="{{ asset('assets/basila_images/basila_white.png') }}" alt="site logo" class="light-logo"
                width="120">
            <img src="{{ asset('assets/basila_images/logo_basila.png') }}" alt="site logo" class="logo-icon"
                width="30">
        </a>
    </div>
    <div class="sidebar-menu-area">
        <ul class="sidebar-menu" id="sidebar-menu">
            <li class="w-full !pl-0">
                <div class="identitas w-full flex flex-col items-center justify-center gap-4 my-10">
                    <img src="{{ session('profilephoto') ?? asset('assets/basila_images/favicon.png') }}" 
                        class="w-28 h-28 rounded-full aspect-square object-cover object-top border-2 border-red-100 shadow-sm flex-shrink-0"
                        alt="profile photo" id="logo">
                    <div class="flex flex-col items-center w-full gap-1 px-4 text-center">
                        <h1 class="uppercase text-lg font-bold text-gray-800 tracking-tight truncate w-full"
                            id="sidebar-name">{{ session('username') }}</h1>
                        <h5 class="text-[11px] font-medium text-gray-400 uppercase tracking-widest leading-none mt-1" id="sidebar-nim">{{ session('nim') }}</h5>
                    </div>
                </div>
            </li>
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
                    @if (session('role_name') === 'BAA')
                        <li>
                            <a href="{{ route('pengelolaan-gedung') }}" class="">
                                <iconify-icon icon="mdi:dot" class="" style="font-size: 50px;"></iconify-icon>
                                Pengelolaan Ruangan
                            </a>
                        </li>
                    @endif
                    <li>
                        <a href="{{ route('index2') }}">
                            <iconify-icon icon="mdi:dot" class="" style="font-size: 50px;"></iconify-icon>
                            Peminjaman Ruangan
                        </a>
                    </li>
                    @if (session('role_name') === 'BAA')
                        <li>
                            <a href="{{ route('approve-reservasi') }}">
                                <iconify-icon icon="mdi:dot" class="" style="font-size: 50px;"></iconify-icon>
                                Persetujuan Peminjaman
                            </a>
                        </li>
                    @endif
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
