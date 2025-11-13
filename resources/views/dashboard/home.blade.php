@extends('layout.layout')

@php
    $title = 'Dashboard';
    $script = '
         <script src="' . asset('assets/js/data-table.js') . '" defer></script>
    ';
@endphp

@section('content')
    <div class="lg:col-span-12 2xl:col-span-8 mb-5">
        <h1 class="font-bold text-2xl">{{ $title }}</h1>
    </div>

    <div class="flex flex-col space-y-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div
                class="bg-[#2CCA49] text-white rounded-xl py-8
            shadow-lg flex items-center justify-center space-x-4">
                <div class="flex flex-col text-center items-center ">
                    <div class="flex flex-row gap-2 items-center">
                        <img src="{{ asset('/assets/basila_images/building.png') }}" class="w-12 mb-3" />
                        <h2 class="text-4xl text-white font-bold leading-tight">13</h2>
                    </div>
                    <p class="text-2xl font-bold text-white">Ruang Tersedia</p>
                </div>
            </div>

            <div
                class="bg-[#BDBDBD] text-white rounded-xl py-8
            shadow-lg flex items-center justify-center space-x-4">
                <div class="flex flex-col text-center items-center ">
                    <div class="flex flex-row gap-2 items-center">
                        <img src="{{ asset('/assets/basila_images/building.png') }}" class="w-12 mb-3" />
                        <h2 class="text-4xl text-white font-bold leading-tight">20</h2>
                    </div>
                    <p class="text-2xl font-bold text-white">Rata rata Ruangan</p>
                </div>
            </div>

            <div
                class="bg-[#e51411] text-white rounded-xl py-8
            shadow-lg flex items-center justify-center space-x-4">
                <div class="flex flex-col text-center items-center ">
                    <div class="flex flex-row gap-2 items-center">
                        <img src="{{ asset('/assets/basila_images/disable-building.png') }}" class="w-16 mb-3" />
                        <h2 class="text-4xl text-white font-bold leading-tight">42</h2>
                    </div>
                    <p class="text-2xl font-bold text-white">Ruang Terpakai</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4">
            <div class="card-body col-span-12 bg-white rounded-xl p-8 shadow-lg space-y-4">
                <h1 class="text-2xl text-shadow">Jadwal Akademik</h1>
                <div class="overflow-x-auto">
                    <table id="selection-table-1" class="table bordered-table sm-table mb-0 table-auto border-black p-1">
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
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4">
            <div class="card-body col-span-12 bg-white rounded-xl p-8 shadow-lg space-y-4">
                <h1 class="text-2xl text-shadow">Jadwal Non-Akademik</h1>
                <div class="overflow-x-auto">
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
    </div>
@endsection
