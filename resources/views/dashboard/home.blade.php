@extends('layout.layout')

@php
    $title = 'Dashboard';
    $script = '
         <script src="' . asset('assets/js/data-table.js') . '" defer></script>
         <script src="' . asset('assets/js/basilaChart.js') . '"></script>
         <script src="' . asset('assets/js/switch-buttton.js') . '"></script>
    ';
@endphp

@section('content')
    <div class="lg:col-span-12 2xl:col-span-8 mb-5">
        <h1 class="font-bold text-2xl">{{ $title }}</h1>
    </div>

    <main class="w-full h-auto space-y-5 mb-5">
        <section class="grid lg:grid-cols-12 sm:grid-cols-1 md:grid-cols-2 gap-5">
            <div class="lg:col-span-8 md:col-span-12 sm:col-span-12 bg-white p-2 rounded-[25px] space-y-10 shadow-xl">
                <div class="grid lg:grid-cols-3 gap-5 md:grid-cols-2 sm:grid-cols-1">
                    <div class="flex-1 bg-[#ffb800] p-4 rounded-[25px] flex flex-row items-center justify-center gap-3">
                        <div class="bg-[#d19c00] rounded-full p-5 flex">
                            <iconify-icon icon="clarity:building-solid" class=""
                                style="font-size: 35px;"></iconify-icon>
                        </div>
                        <div class="text-center flex flex-col gap-2">
                            <h1 class="text-4xl text-white">40</h1>
                            <p class="text-white font-bold">Total Waiting</p>
                        </div>
                    </div>
                    <div class="flex-1 bg-[#e51411] p-4 rounded-[25px] flex flex-row items-center justify-center gap-3">
                        <div class="bg-[#c7110f] rounded-full p-5 flex justify-center">
                            <iconify-icon icon="clarity:building-solid" class=""
                                style="font-size: 35px;"></iconify-icon>
                        </div>
                        <div class="text-center flex flex-col gap-2">
                            <h1 class="text-4xl text-white">40</h1>
                            <p class="text-white font-bold">Total Terpakai</p>
                        </div>
                    </div>
                    <div class="flex-1 bg-[#3ea83f] p-5 rounded-[25px] flex flex-row items-center justify-center gap-3">
                        <div class="bg-[#2f812f] rounded-full p-5 flex justify-center">
                            <iconify-icon icon="clarity:building-solid" class=""
                                style="font-size: 35px;"></iconify-icon>
                        </div>
                        <div class="text-center flex flex-col gap-2">
                            <h1 class="text-4xl text-white">40</h1>
                            <p class="text-white font-bold">Total Tersedia</p>
                        </div>
                    </div>
                </div>
                <h1 class="text-2xl text-center">Penggunaan Ruang Gedung Telkom University</h1>
                <div class="overflow-x-auto text-black">
                    <div id="columnChart" class="overflow-x-auto min-w-[800px]"></div>
                </div>
            </div>
            <div class="lg:col-span-4 md:col-span-12 sm:col-span-12 space-y-5 ">
                <div class="bg-white p-5 rounded-[25px] space-y-5 shadow-xl">
                    <h1 class="font-bold text-2xl">Kegiatan Terkini</h1>

                    <ul class="flex flex-col gap-3 text-black">
                        <li class="flex flex-row items-center gap-5">
                            <iconify-icon icon="icon-park-outline:dot" class="text-[#1BBA9A]"
                                style="font-size: 20px;"></iconify-icon>
                            <span>Ilham baru saja meminjam ruangan</span>
                        </li>

                        <li class="flex flex-row items-center gap-5">
                            <iconify-icon icon="icon-park-outline:dot" class="text-[#1BBA9A]"
                                style="font-size: 20px;"></iconify-icon>
                            <span>Siti melakukan pengajuan peminjaman</span>
                        </li>

                        <li class="flex flex-row items-center gap-5">
                            <iconify-icon icon="icon-park-outline:dot" class="text-[#1BBA9A]"
                                style="font-size: 20px;"></iconify-icon>
                            <span>Budi telah mengembalikan ruangan</span>
                        </li>

                        <li class="flex flex-row items-center gap-5">
                            <iconify-icon icon="icon-park-outline:dot" class="text-[#1BBA9A]"
                                style="font-size: 20px;"></iconify-icon>
                            <span>Dewi menunggu konfirmasi peminjaman</span>
                        </li>

                        <li class="flex flex-row items-center gap-5">
                            <iconify-icon icon="icon-park-outline:dot" class="text-[#1BBA9A]"
                                style="font-size: 20px;"></iconify-icon>
                            <span>Reno melakukan perubahan jadwal</span>
                        </li>
                        <li class="flex flex-row items-center gap-5">
                            <iconify-icon icon="icon-park-outline:dot" class="text-[#1BBA9A]"
                                style="font-size: 20px;"></iconify-icon>
                            <span>Ilham baru saja meminjam ruangan</span>
                        </li>
                        <li class="flex flex-row items-center gap-5">
                            <iconify-icon icon="icon-park-outline:dot" class="text-[#1BBA9A]"
                                style="font-size: 20px;"></iconify-icon>
                            <span>Reno melakukan perubahan jadwal</span>
                        </li>
                        <li class="flex flex-row items-center gap-5">
                            <iconify-icon icon="icon-park-outline:dot" class="text-[#1BBA9A]"
                                style="font-size: 20px;"></iconify-icon>
                            <span>Reno melakukan perubahan jadwal</span>
                        </li>
                        <li class="flex flex-row items-center gap-5">
                            <iconify-icon icon="icon-park-outline:dot" class="text-[#1BBA9A]"
                                style="font-size: 20px;"></iconify-icon>
                            <span>Ilham baru saja meminjam ruangan</span>
                        </li>
                    </ul>
                </div>
                <div class="bg-white p-5 rounded-[25px] shadow-xl justify-center flex flex-col gap-5 sm:items-center">
                    <h1 class="text-2xl font-bold flex justify-end">Ruangan yang sedang diperbaiki</h1>

                    <div id="userOverviewDonutChart" class="apexcharts-tooltip-z-none w-fit"></div>
                </div>
            </div>
        </section>
        <section class="grid grid-cols-12">
            <div class="col-span-12">
                <div class="bg-white p-5 rounded-[25px] flex flex-col shadow-xl gap-5">
                    <div class="bg-[#e51411] p-2 rounded-lg w-fit">
                        <p class="text-white font-bold">Okkupansi</p>
                    </div>
                    <div class="flex flex-row gap-5 overflow-x-auto lg:justify-center">
                        <div class="pieChart min-w-[250px] flex justify-center"></div>
                        <div class="pieChart min-w-[250px] flex justify-center"></div>
                        <div class="pieChart min-w-[250px] flex justify-center"></div>
                        <div class="pieChart min-w-[250px] flex justify-center"></div>
                    </div>
                </div>
            </div>
        </section>
        <section class="grid grid-cols-12">
            <div class="col-span-12">
                <div class="bg-white p-5 rounded-[25px] flex flex-col shadow-xl gap-5">              
                    @livewire('monitorDashboard')
                </div>
            </div>
        </section>
    </main>
@endsection
