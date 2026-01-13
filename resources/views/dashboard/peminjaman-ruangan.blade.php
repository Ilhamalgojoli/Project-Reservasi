@extends('layout.layout')
@php
    $title = 'Peminjaman Ruangan';

    $script = '
        <script src="' . asset('assets/js/option-reservasi.js') . '" defer></script>
        <script src="' . asset('assets/js/pemilihan-jam.js') . '" defer></script>
    ';
@endphp

@section('content')
    <h1 class="text-2xl font-bold mb-5">{{ $title }}</h1>

    <main class="grid lg:grid-cols-1 md:grid-cols-1 sm:grid-cols-1 gap-6">
        <section class="bg-white p-10 rounded-2xl shadow-lg">
            <div class="flex flex-col gap-8">
                <div class="flex flex-col gap-2 pb-8 mb-8">
                    <h1 class="font-bold text-2xl">Gedung Gku</h1>
                    <div class="w-50 border"></div>
                    <p class="text-[#8B8B8B] text-md">Pastikan data yang dipilih telah sesuai
                        untuk menampilkan data ruangan 😄</p>
                </div>

                <div class="flex flex-row gap-5 md:flex-row sm:flex-col">
                    <!-- Fakultas -->
                    <select
                        class="rounded-md flex-1 md:w-auto sm:w-auto text-[#808080] py-2 px-3 appearance-none
               bg-transparent border border-[#808080] border-opacity-50 font-bold">
                        <option value="" disabled selected>Pilih Fakultas / Direktorat</option>
                        <option value="fakultas_teknik">Fakultas Teknik</option>
                        <option value="fakultas_ekonomi">Fakultas Ekonomi</option>
                        <option value="fakultas_sastra">Fakultas Sastra</option>
                        <!-- bisa ditambah sesuai data asli -->
                    </select>

                    <!-- Prodi -->
                    <select
                        class="rounded-md flex-1 md:w-auto sm:w-auto text-[#808080] py-2 px-3 appearance-none
               bg-transparent border border-[#808080] border-opacity-50 font-bold">
                        <option value="" disabled selected>Pilih Prodi</option>
                        <option value="prodi_informatika">Informatika</option>
                        <option value="prodi_akuntansi">Akuntansi</option>
                        <option value="prodi_bahasa">Bahasa Inggris</option>
                        <!-- bisa ditambah sesuai data asli -->
                    </select>
                </div>

                <div class="flex flex-col flex-1 gap-5">
                    <select id="opsi-peminjaman"
                        class="rounded-md md:w-auto sm:w-auto text-[#808080] py-2 px-3 appearance-none
                        bg-transparent border border-[#808080] border-opacity-50 font-bold">
                        <option value="" disabled selected>Pilih Jenis Peminjaman</option>
                        <option value="Akademik">Akademik</option>
                        <option value="Non-Akademik">Non Akademik</option>
                    </select>
                </div>

                <div>
                    <p class="text-xl font-bold" id="value">Akademik</p>
                    <div class="border border-black border-opacity-50"></div>
                </div>

                <!-- Akademik -->
                <div class="space-y-5" id="Akademik">
                    <div class="grid grid-cols-1 sm:grid-cols-4 md:grid-cols-4 lg:grid-cols-1 gap-10">
                        <div class="flex flex-row gap-10 sm:gap-5 sm:flex-col md:flex-col lg:flex-row">
                            <div class="flex flex-col flex-1 gap-5">
                                <select
                                    class="rounded-md md:w-auto sm:w-auto text-[#808080] py-2 px-3 appearance-none
                                    bg-transparent border border-[#808080] border-opacity-50 font-bold">
                                    <option disabled selected>Kode Mata Kuliah</option>
                                    <option value="">Fakultas</option>
                                    <option value="">Prodi</option>
                                    <option value="">Pribadi</option>
                                </select>
                            </div>
                            <div class="flex flex-col flex-1 gap-5">
                                <select
                                    class="rounded-md md:w-auto sm:w-auto text-[#808080] py-2 px-3 appearance-none
                                    bg-transparent border border-[#808080] border-opacity-50 font-bold">
                                    <option disabled selected>Lantai</option>
                                    <option value="GKU.07.01">GKU.01</option>
                                    <option value="GKU.07.02">GKU.02</option>
                                    <option value="GKU.07.03">GKU.03</option>
                                    <option value="GKU.07.04">GKU.07</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-4 md:grid-cols-4 lg:grid-cols-1 gap-10">
                        <div class="flex flex-row gap-10 sm:gap-5 sm:flex-col md:flex-col lg:flex-row">
                            <div class="flex flex-col flex-1 gap-5">
                                <select
                                    class="rounded-md md:w-auto sm:w-auto text-[#808080] py-2 px-3 appearance-none
                                    bg-transparent border border-[#808080] border-opacity-50 font-bold">
                                    <option disabled selected>Ruangan</option>
                                    <option value="GKU.07.01">GKU.07.01</option>
                                    <option value="GKU.07.02">GKU.07.02</option>
                                    <option value="GKU.07.03">GKU.07.03</option>
                                    <option value="GKU.07.04">GKU.07.04</option>
                                </select>
                            </div>
                            <div class="flex flex-col flex-1 relative">
                                <input type="date"
                                    class="rounded-lg py-2 px-3 border border-[#808080] text-[#808080]
                                    border-opacity-50 font-bold appearance-none"
                                    style="
                                        appearance:none;
                                        -webkit-appearance:none;
                                        -moz-appearance:none;
                                    "
                                    placeholder="Tanggal" />
                                <iconify-icon icon="solar:calendar-linear"
                                    onclick="this.previousElementSibling.showPicker()"
                                    class="text-black absolute right-2 top-2.5 text-2xl cursor-pointer"></iconify-icon>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-4 md:grid-cols-4 lg:grid-cols-1 gap-10">
                        <div class="flex flex-row gap-10 sm:gap-5 sm:flex-col md:flex-col lg:flex-row">
                            <div class="flex flex-col flex-1 gap-5">
                                <!-- Input yang menampilkan pilihan -->
                                <input type="text" id="selectedJam" readonly placeholder="Pilih Jam Peminjaman"
                                    class="w-full border border-gray-400 rounded-md py-2 px-3 cursor-pointer text-black"
                                    onclick="toggleDropdownJam()" />

                                <div class="relative w-64 text-black">
                                    <!-- Dropdown checkbox -->
                                    <div id="dropdownJam"
                                        class="absolute w-full border border-gray-400 rounded-md mt-1 bg-white hidden max-h-48 overflow-y-auto z-10">
                                        <label class="flex items-center px-3 py-2 hover:bg-gray-100 cursor-pointer">
                                            <input type="checkbox" value="08:00 - 09:00" class="mr-2"
                                                onchange="updateSelectedJam()">
                                            08:00 - 09:00
                                        </label>
                                        <label class="flex items-center px-3 py-2 hover:bg-gray-100 cursor-pointer">
                                            <input type="checkbox" value="09:00 - 10:00" class="mr-2"
                                                onchange="updateSelectedJam()">
                                            09:00 - 10:00
                                        </label>
                                        <label class="flex items-center px-3 py-2 hover:bg-gray-100 cursor-pointer">
                                            <input type="checkbox" value="10:00 - 11:00" class="mr-2"
                                                onchange="updateSelectedJam()">
                                            10:00 - 11:00
                                        </label>
                                        <label class="flex items-center px-3 py-2 hover:bg-gray-100 cursor-pointer">
                                            <input type="checkbox" value="11:00 - 12:00" class="mr-2"
                                                onchange="updateSelectedJam()">
                                            11:00 - 12:00
                                        </label>
                                        <!-- Tambahkan jam sesuai kebutuhan -->
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col flex-1 relative">
                                <input type="text"
                                    class="rounded-lg py-2 px-3 border border-[#808080] text-black
                                    border-opacity-50 font-bold"
                                    placeholder="Kapasitas" />
                                <iconify-icon icon="mdi:people-outline"
                                    class="text-black absolute right-2 top-2.5 text-2xl cursor-pointer"></iconify-icon>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-4 md:grid-cols-4 lg:grid-cols-1 gap-10">
                        <div class="flex flex-row gap-10 sm:gap-5 sm:flex-col md:flex-col lg:flex-row">
                            <div class="flex flex-col flex-1 relative">
                                <input type="text"
                                    class="rounded-lg py-2 px-3 border border-[#808080] text-black
                                    border-opacity-50 font-bold"
                                    placeholder="Penanggung Jawab" />
                            </div>
                            <div class="flex flex-col flex-1 relative">
                                <input type="text"
                                    class="rounded-lg py-2 px-3 border border-[#808080] text-black
                                    border-opacity-50 font-bold"
                                    placeholder="Kontak Penanggung Jawab" />
                            </div>
                        </div>
                    </div>

                    <div class="flex lg:flex-row sm:flex-col md:flex-col gap-5">
                        <div class="flex flex-col flex-1 gap-5">
                            <textarea
                                class="rounded-lg py-2 px-3 h-24 border border-[#808080] text-[#808080] font-bold
                                border-opacity-50"
                                placeholder="Deskripsi"></textarea>
                        </div>
                    </div>
                </div>
                <!-- Non-Akademik -->
                <div class="space-y-5 hidden" id="Non-Akademik">
                    <div class="grid grid-cols-1 sm:grid-cols-4 md:grid-cols-4 lg:grid-cols-1 gap-10">
                        <div class="flex flex-row gap-10 sm:gap-5 sm:flex-col md:flex-col lg:flex-row">
                            <div class="flex flex-col flex-1 gap-5">
                                <select
                                    class="rounded-md md:w-auto sm:w-auto text-[#808080] py-2 px-3 appearance-none
                                    bg-transparent border border-[#808080] border-opacity-50 font-bold">
                                    <option disabled selected>Lantai</option>
                                    <option value="GKU.07.01">GKU.01</option>
                                    <option value="GKU.07.02">GKU.02</option>
                                    <option value="GKU.07.03">GKU.03</option>
                                    <option value="GKU.07.04">GKU.07</option>
                                </select>
                            </div>
                            <div class="flex flex-col flex-1 gap-5">
                                <select
                                    class="rounded-md md:w-auto sm:w-auto text-[#808080] py-2 px-3 appearance-none
                                    bg-transparent border border-[#808080] border-opacity-50 font-bold">
                                    <option disabled selected>Ruangan</option>
                                    <option value="GKU.07.01">GKU.07.01</option>
                                    <option value="GKU.07.02">GKU.07.02</option>
                                    <option value="GKU.07.03">GKU.07.03</option>
                                    <option value="GKU.07.04">GKU.07.04</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-4 md:grid-cols-4 lg:grid-cols-1 gap-10">
                        <div class="flex flex-row gap-10 sm:gap-5 sm:flex-col md:flex-col lg:flex-row">
                            <div class="flex flex-col flex-1 relative">
                                <input type="date"
                                    class="rounded-lg py-2 px-3 border border-[#808080] text-[#808080]
                                    border-opacity-50 font-bold appearance-none"
                                    style="
                                        appearance:none;
                                        -webkit-appearance:none;
                                        -moz-appearance:none;
                                    "
                                    placeholder="Tanggal" />
                                <iconify-icon icon="solar:calendar-linear"
                                    onclick="this.previousElementSibling.showPicker()"
                                    class="text-black absolute right-2 top-2.5 text-2xl cursor-pointer"></iconify-icon>
                            </div>
                            <div class="flex flex-col flex-1 gap-5">
                                <select
                                    class="rounded-md md:w-auto sm:w-auto text-[#808080] py-2 px-3 appearance-none
                                    bg-transparent border border-[#808080] border-opacity-50 font-bold">
                                    <option disabled selected>Jadwal</option>
                                    <option value="08.00 - 08.50">08.00 - 08.50</option>
                                    <option value="08.50 - 09.40">08.50 - 09.40</option>
                                    <option value="09.40 - 10.30">09.40 - 10.30</option>
                                    <option value="10.30 - 11.20">10.30 - 11.20</option>
                                    <option value="11.20 - 12.10">11.20 - 12.10</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-4 md:grid-cols-4 lg:grid-cols-1 gap-10">
                        <div class="flex flex-row gap-10 sm:gap-5 sm:flex-col md:flex-col lg:flex-row">
                            <div class="flex flex-col flex-1 relative">
                                <input type="text"
                                    class="rounded-lg py-2 px-3 border border-[#808080] text-black
                                    border-opacity-50 font-bold"
                                    placeholder="Kapasitas" />
                                <iconify-icon icon="mdi:people-outline"
                                    class="text-black absolute right-2 top-2.5 text-2xl cursor-pointer"></iconify-icon>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-4 md:grid-cols-4 lg:grid-cols-1 gap-10">
                        <div class="flex flex-row gap-10 sm:gap-5 sm:flex-col md:flex-col lg:flex-row">
                            <div class="flex flex-col flex-1 relative">
                                <input type="text"
                                    class="rounded-lg py-2 px-3 border border-[#808080] text-black
                                    border-opacity-50 font-bold"
                                    placeholder="Penanggung Jawab" />
                            </div>
                            <div class="flex flex-col flex-1 relative">
                                <input type="text"
                                    class="rounded-lg py-2 px-3 border border-[#808080] text-black
                                    border-opacity-50 font-bold"
                                    placeholder="Kontak Penanggung Jawab" />
                            </div>
                        </div>
                    </div>

                    <div class="flex lg:flex-row sm:flex-col md:flex-col gap-5">
                        <div class="flex flex-col flex-1 gap-5">
                            <textarea
                                class="rounded-lg py-2 px-3 h-24 border border-[#808080] text-[#808080] font-bold
                                border-opacity-50"
                                placeholder="Deskripsi"></textarea>
                        </div>
                    </div>
                </div>
                <div class="w-auto flex justify-center">
                    <button class="bg-[#FF0101] w-[150px] font-bold py-2 rounded-md">
                        Submit
                    </button>
                </div>
            </div>
        </section>
    </main>
@endsection
