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
                    <div class="bg-[#EAEAEA] rounded-md  w-fit flex text-black">
                        <button class="akademik bg-[#e51411] text-white rounded-md font-bold px-4 py-2 cursor-pointer">
                            Jadwal Akademik
                        </button>
                        <button class="non-akademik font-bold px-4 py-2 cursor-pointer rounded-md">
                            Jadwal Non-Akademik
                        </button>
                    </div>
                    <div class="tableAkademik overflow-x-auto">
                        <table id="selection-table-1"
                            class="table bordered-table sm-table mb-0 table-auto border-black p-1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Gedung</th>
                                    <th>Ruangan</th>
                                    <th>Tanggal</th>
                                    <th>Shift</th>
                                    <th>Kode Matkul</th>
                                    <th>Mata Kuliah</th>
                                    <th>Kapasitas</th>
                                    <th>Penanggung Jawab</th>
                                    <th>Kapasitas</th>
                                    <th>Kontak</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Gedung A</td>
                                    <td>Ruang 101</td>
                                    <td>2025-11-12</td>
                                    <td>10:30 - 12:30</td>
                                    <td>IF101</td>
                                    <td>Pemrograman Dasar</td>
                                    <td>40</td>
                                    <td>HMU</td>
                                    <td>40</td>
                                    <td>0812-3456-7890</td>
                                    <td class="text-green-600 font-semibold">Sedang Berlangsung</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Gedung B</td>
                                    <td>Ruang 202</td>
                                    <td>2025-11-12</td>
                                    <td>13:00 - 15:00</td>
                                    <td>IF203</td>
                                    <td>Struktur Data</td>
                                    <td>35</td>
                                    <td>HMU</td>
                                    <td>35</td>
                                    <td>0821-9876-5432</td>
                                    <td class="text-yellow-600 font-semibold">Telah Selesai</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Gedung C</td>
                                    <td>Ruang 305</td>
                                    <td>2025-11-13</td>
                                    <td>15:30 - 17:30</td>
                                    <td>IF305</td>
                                    <td>Basis Data</td>
                                    <td>45</td>
                                    <td>HMU</td>
                                    <td>45</td>
                                    <td>0852-6543-2109</td>
                                    <td class="text-blue-600 font-semibold"></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Gedung D</td>
                                    <td>Ruang 210</td>
                                    <td>2025-11-13</td>
                                    <td>08:00 - 10:00</td>
                                    <td>IF410</td>
                                    <td>Kecerdasan Buatan</td>
                                    <td>50</td>
                                    <td>HMU</td>
                                    <td>50</td>
                                    <td>0813-4321-7654</td>
                                    <td class="text-red-600 font-semibold">Dibatalkan</td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Gedung E</td>
                                    <td>Ruang 108</td>
                                    <td>2025-11-14</td>
                                    <td>09:30 - 11:30</td>
                                    <td>IF501</td>
                                    <td>Pemrograman Web</td>
                                    <td>38</td>
                                    <td>HMU</td>
                                    <td>38</td>
                                    <td>0896-7890-1234</td>
                                    <td class="text-blue-600 font-semibold">Terjadwal</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tableNonAkademik kaoverflow-x-auto hidden">
                        <table id="selection-table-2" class="table bordered-table sm-table mb-0 table-auto">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Gedung</th>
                                    <th>Ruangan</th>
                                    <th>Shift</th>
                                    <th>Kegiatan</th>
                                    <th>Penanggung Jawab</th>
                                    <th>Kapasitas</th>
                                    <th>Kontak</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Gedung Serbaguna</td>
                                    <td>Aula Utama</td>
                                    <td>08:00 - 10:00</td>
                                    <td>Seminar Kepemimpinan Mahasiswa</td>
                                    <td>Rafi Pratama</td>
                                    <td>100</td>
                                    <td>0812-3456-7890</td>
                                    <td class="text-green-600 font-semibold">Sedang Berlangsung</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Gedung B</td>
                                    <td>Ruang 205</td>
                                    <td>10:30 - 12:00</td>
                                    <td>Pelatihan Desain Grafis</td>
                                    <td>Sinta Ayu</td>
                                    <td>45</td>
                                    <td>0821-9876-5432</td>
                                    <td class="text-blue-600 font-semibold">Segera Dimulai</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Gedung C</td>
                                    <td>Lapangan Tengah</td>
                                    <td>13:00 - 15:30</td>
                                    <td>Turnamen Futsal Antar Jurusan</td>
                                    <td>Dimas Aditya</td>
                                    <td>80</td>
                                    <td>0852-6543-2109</td>
                                    <td class="text-yellow-600 font-semibold">Menunggu Jadwal</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Gedung D</td>
                                    <td>Ruang 108</td>
                                    <td>15:30 - 17:30</td>
                                    <td>Rapat Persiapan Festival Kampus</td>
                                    <td>Nurul Hidayah</td>
                                    <td>60</td>
                                    <td>0813-4321-7654</td>
                                    <td class="text-gray-600 font-semibold">Telah Selesai</td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Gedung E</td>
                                    <td>Ruang 305</td>
                                    <td>09:00 - 11:00</td>
                                    <td>Pameran Karya Seni Mahasiswa</td>
                                    <td>Arga Saputra</td>
                                    <td>70</td>
                                    <td>0896-7890-1234</td>
                                    <td class="text-red-600 font-semibold">Dibatalkan</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
