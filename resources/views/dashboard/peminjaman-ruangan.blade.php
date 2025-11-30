@extends('layout.layout')
@php
    $title = 'Peminjaman Ruangan';

    $script = '
        <script src="' . asset('assets/js/option-reservasi.js') . '" defer></script>
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

                <div class="flex flex-col flex-1 gap-5">
                    <h1 class="text-lg font-normal">Jenis Peminjaman</h1>
                    <select id="opsi-peminjaman" class="rounded-xl lg:w-[730px] sm:w-auto md:w-auto text-black">
                        <option value="" disabled selected>Pilih Jenis Peminjaman</option>
                        <option value="Akademik">Akademik</option>
                        <option value="Non-Akademik">Non Akademik</option>
                    </select>
                </div>
    
                <!-- Akademik -->
                <div class="space-y-5" id="Akademik">
                    <div class="grid grid-cols-1 sm:grid-cols-4 md:grid-cols-4 lg:grid-cols-1 gap-10">
                        <div class="flex flex-row gap-10 sm:gap-5 sm:flex-col md:flex-col lg:flex-row">
                            <div class="flex flex-col flex-1 gap-5">
                                <h1 class="text-lg font-normal">Lantai</h1>
                                <select class="rounded-xl text-black">
                                    <option disabled selected>Pilih Ruangan</option>
                                    <option value="GKU.07.01">GKU.01</option>
                                    <option value="GKU.07.02">GKU.02</option>
                                    <option value="GKU.07.03">GKU.03</option>
                                    <option value="GKU.07.04">GKU.07</option>
                                </select>
                            </div>
                            <div class="flex flex-col flex-1 gap-5">
                                <h1 class="text-lg font-normal">Ruangan</h1>
                                <select class="rounded-xl text-black">
                                    <option disabled selected>Pilih Ruangan</option>
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
                            <div class="flex flex-col flex-1 gap-5">
                                <h1 class="text-lg font-normal">Peminjaman</h1>
                                <select class="rounded-xl text-black">
                                    <option disabled selected>Target peminjaman</option>
                                    <option value="">Fakultas</option>
                                    <option value="">Prodi</option>
                                    <option value="">Pribadi</option>
                                </select>
                            </div>
                            <div class="flex flex-col flex-1 gap-5">
                                <h1 class="text-lg font-normal">Penjadwalan</h1>
                                <select class="rounded-xl text-black">
                                    <option disabled selected>Pilih Jadwal</option>
                                    <option value="08.00 - 08.50">08.00 - 08.50</option>
                                    <option value="08.50 - 09.40">08.50 - 09.40</option>
                                    <option value="09.40 - 10.30">09.40 - 10.30</option>
                                    <option value="10.30 - 11.20">10.30 - 11.20</option>
                                    <option value="11.20 - 12.10">11.20 - 12.10</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="flex lg:flex-row sm:flex-col md:flex-col gap-5">
                        <div class="flex flex-col flex-1 gap-5">
                            <h1 class="text-lg font-normal">Kapasitas</h1>
                            <input class="py-2 rounded-xl border-[#ebebeb] lg:w-auto sm:w-auto md:auto"
                                placeholder="Max Room 35, Example" type="text" />
                        </div>
                        <div class="flex flex-col flex-1 gap-5">
                            <h1 class="text-lg font-normal">Catatan / Alasan</h1>
                            <textarea class="rounded-xl w-auto"></textarea>
                        </div>
                    </div>
                </div>
                <!-- Non-Akademik -->
                <div class="space-y-5 hidden" id="Non-Akademik">
                    <div class="grid grid-cols-1 sm:grid-cols-4 md:grid-cols-4 lg:grid-cols-1 gap-10">
                        <div class="flex flex-row gap-10 sm:gap-5 sm:flex-col md:flex-col lg:flex-row">
                            <div class="flex flex-col flex-1 gap-5">
                                <h1 class="text-lg font-normal">Lantai</h1>
                                <select class="rounded-xl text-black">
                                    <option disabled selected>Pilih Ruangan</option>
                                    <option value="GKU.07.01">GKU.01</option>
                                    <option value="GKU.07.02">GKU.02</option>
                                    <option value="GKU.07.03">GKU.03</option>
                                    <option value="GKU.07.04">GKU.07</option>
                                </select>
                            </div>
                            <div class="flex flex-col flex-1 gap-5">
                                <h1 class="text-lg font-normal">Ruangan</h1>
                                <select class="rounded-xl"></select>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-4 md:grid-cols-4 lg:grid-cols-1 gap-10">
                        <div class="flex flex-row gap-10 sm:gap-5 sm:flex-col md:flex-col lg:flex-row">
                            <div class="flex flex-col flex-1 gap-5">
                                <h1 class="text-lg font-normal">Kapasitas</h1>
                                <input class="py-2 rounded-xl border-[#ebebeb] lg:w-auto sm:w-auto md:auto"
                                    placeholder="Max Room 35, Example" type="text" />
                            </div>
                            <div class="flex flex-col flex-1 gap-5">
                                <h1 class="text-lg font-normal">Penjadwalan</h1>
                                <select class="rounded-xl border border-gray-300 p-2 text-black">
                                    <option value="08.00 - 08.50">08.00 - 08.50</option>
                                    <option value="08.50 - 09.40">08.50 - 09.40</option>
                                    <option value="09.40 - 10.30">09.40 - 10.30</option>
                                    <option value="10.30 - 11.20">10.30 - 11.20</option>
                                    <option value="11.20 - 12.10">11.20 - 12.10</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <button
                        class="
                            bg-[#FF0101] px-5 py-2 rounded-lg text-xl font-bold
                        ">
                        Submit
                    </button>
                </div>
            </div>
        </section>
    </main>
@endsection
