<div class="navbar-header bg-[rgb(226,19,19)] dark:bg-[rgb(39 49 66)] border-neutral-200 dark:border-neutral-600 z-50">
    <div class="flex items-center justify-between">
        <div class="col-auto">
            <div class="flex flex-wrap items-center gap-[16px]">
                <button type="button" class="sidebar-toggle text-white">
                    <iconify-icon icon="heroicons:bars-3-solid" class="icon non-active text-neutral-200"></iconify-icon>
                    <iconify-icon icon="iconoir:arrow-right" class="icon active"></iconify-icon>
                </button>
                <button type="button" class="sidebar-mobile-toggle d-flex !leading-[0]">
                    <iconify-icon icon="heroicons:bars-3-solid"
                        class="icon !text-[30px] text-neutral-200"></iconify-icon>
                </button>
            </div>
        </div>
        <div class="col-auto">
            <div class="flex flex-wrap items-center gap-3"></div>
            <button data-dropdown-toggle="dropdownProfile" class="flex justify-center items-center rounded-full"
                type="button">
                <img src="{{ session('profilephoto') ? session('profilephoto') : asset('assets/basila_images/favicon.png') }}"
                    alt="image" class="w-10 h-10 object-cover rounded-full object-top">
            </button>
            <div id="dropdownProfile" class="z-10 hidden bg-white  rounded-lg shadow-lg dropdown-menu-sm p-3">
                <div
                    class="py-3 px-4 rounded-lg bg-primary-50 dark:bg-primary-600/25 mb-4 flex items-center justify-between gap-2">
                    <div class="flex items-center gap-3">
                        {{-- <img src="{{ session('profilephoto') }}" alt="image"
                                class="w-10 h-10 rounded-full"> --}}
                        <div class="flex flex-col">
                            <h6 class="text-lg text-neutral-900 font-semibold mb-0 normal-case">
                                {{ session('username') }}</h6>
                            <span class="text-neutral-500">{{ session('role_name') }}</span>
                        </div>
                    </div>
                    <button type="button" class="text-red-400 hover:text-danger-600 ">
                        <iconify-icon icon="radix-icons:cross-1" class="icon text-xl"></iconify-icon>
                    </button>
                </div>

                <div class="max-h-[400px] overflow-y-auto scroll-sm pe-2">
                    <ul class="flex flex-col">
                        <li>
                            <a class="text-black px-0 py-2 hover:text-primary-600 flex items-center gap-4"
                                href="">
                                <iconify-icon icon="solar:user-linear" class="icon text-xl"></iconify-icon> My
                                Profile
                            </a>
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit"
                                    class="text-black px-0 py-2 hover:text-danger-600 flex items-center gap-4 w-full text-left">
                                    <iconify-icon icon="lucide:power" class="icon text-xl"></iconify-icon>
                                    Log Out
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
