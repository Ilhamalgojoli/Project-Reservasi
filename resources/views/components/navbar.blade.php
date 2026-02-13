<div class="navbar-header border-b border-neutral-200 bg-[#e51411]">
    <div class="flex items-center justify-between">
        <div class="col-auto">
            <div class="flex flex-wrap items-center gap-[16px]">
                <button type="button" class="sidebar-toggle">
                    <iconify-icon icon="heroicons:bars-3-16-solid" class="icon non-active"
                        style="font-size: 35px;"></iconify-icon>
                    <iconify-icon icon="mingcute:arrow-right-fill" class="icon active"
                        style="font-size: 35px;"></iconify-icon>
                </button>
                <button type="button" class="sidebar-mobile-toggle d-flex !leading-[0]">
                    <iconify-icon icon="heroicons:bars-3-solid" class="icon !text-[30px]"></iconify-icon>
                </button>
            </div>
        </div>
        <div class="col-auto ">
            <div class="flex flex-wrap items-center gap-3">
                {{--                <button type="button" id="theme-toggle" class="w-10 h-10 bg-neutral-200 dark:bg-neutral-700 dark:text-white rounded-full flex justify-center items-center"> --}}
                {{--                    <span id="theme-toggle-dark-icon" class="hidden"> --}}
                {{--                        <i class="ri-sun-line"></i> --}}
                {{--                    </span> --}}
                {{--                    <span id="theme-toggle-light-icon" class="hidden"> --}}
                {{--                        <i class="ri-moon-line"></i> --}}
                {{--                    </span> --}}
                {{--                </button> --}}
                <div class="hidden sm:inline-block">
                    <button data-dropdown-toggle="dropdownInformation"
                        class="has-indicator w-10 h-10 bg-neutral-200 dark:bg-neutral-700 dark:text-white rounded-full flex justify-center items-center"
                        type="button">
                        <img src="{{ asset('assets/images/lang-flag.png') }}" alt="image"
                            class="w-6 h-6 object-cover rounded-full">
                    </button>
                    <div id="dropdownInformation"
                        class="z-10 hidden bg-white dark:bg-neutral-700 rounded-lg shadow-lg dropdown-menu-sm p-3">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
