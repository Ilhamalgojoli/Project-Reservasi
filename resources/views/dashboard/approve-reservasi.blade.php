@extends('layout.layout')
@php
    $title = 'Kelola Persetujuan Peminjaman';
    $script = ' ';
@endphp

@section('content')
    <h1 class="text-2xl font-bold mb-5">{{ $title }}</h1>

    <main class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 3xl:grid-cols-5 gap-6">
        <section class="col-span-12 rounded-2xl bg-white shadow-lg p-8">
            <div class="flex flex-col gap-2 mb-12">
                <h1 class="text-2xl">Persetujuan Peminjaman</h1>
                <div class="w-50 border"></div>
                <p class="text-[#BDBDBD]">Filter data peminjaman ruangan</p>
            </div>
            <div class="flex flex-row gap-6 sm:flex-col md:flex-col lg:flex-row mb-4 text-black">
                <div class="flex flex-col gap-2">
                    <h1 class="text-lg font-light">Jenis Peminjaman</h1>
                    <select class="rounded-xl w-[550px] sm:w-auto">
                        <option value="" disabled selected>Pilih Jenis Peminjaman</option>
                        <option value="akademik">Akademik</option>
                        <option value="non-akademik">Non Akademik</option>
                    </select>
                </div>
                <div class="flex flex-col gap-2">
                    <h1 class="text-lg font-light">Gedung</h1>
                    <select class="rounded-xl w-[550px] sm:w-auto">
                        <option value="" disabled selected>Pilih Gedung</option>
                        <option value="akademik">GKU</option>
                    </select>
                </div>
            </div>
            <button class="bg-[#FF0000] px-12 rounded-lg sm:py-2 py-2 font-bold text-xl">Filter</button>
        </section>
        <section class="col-span-12 rounded-2xl bg-white shadow-lg p-8">
            <div class="overflow-x-auto">
                <table id="selection-table-1" class="table bordered-table sm-table mb-0 table-auto border-black p-1">
                    <thead>
                        <tr>
                            <th scope="col">Gedung</th>
                            <th scope="col">Ruangan</th>
                            <th scope="col">Kapasitas</th>
                            <th scope="col" class="text-center">Penanggung Jawab</th>
                            <th scope="col" class="text-center">Jenis Peminjaman</th>
                            <th scope="col" class="text-center">Alasan</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-[#6d6d6d]">
                        <tr>
                            <td>GKU</td>
                            <td>GKU.07.13</td>
                            <td>35</td>
                            <td class="text-center">Budi Santoso</td>
                            <td class="text-center">Akademik</td>
                            <td class="text-center">Koordinasi Proyek</td>
                            <td class="text-center">
                                <div class="flex flex-row gap-2 items-center justify-center">
                                    <button class="bg-[#5ADF53] px-2 py-2 rounded-full">
                                        <img src="{{ asset('assets/icon/approve.png') }}" class="w-5 h-5" />
                                    </button>
                                    <button class="bg-[#FF0000] px-2 py-2 rounded-full ">
                                        <img src="{{ asset('assets/icon/reject.png') }}" class="w-5 h-5" />
                                    </button>
                                    <button class="bg-[#19ACF5] px-2 py-2 rounded-full ">
                                        <img src="{{ asset('assets/icon/eyes.png') }}" class="w-5 h-5" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>GKU</td>
                            <td>GKU.02.09</td>
                            <td>30</td>
                            <td class="text-center">Yusuf</td>
                            <td class="text-center">Non-Akademik</td>
                            <td class="text-center">Organisasi</td>
                            <td class="text-center">
                                <div class="flex flex-row gap-2 items-center justify-center">
                                    <button class="bg-[#5ADF53] px-2 py-2 rounded-full">
                                        <img src="{{ asset('assets/icon/approve.png') }}" class="w-5 h-5" />
                                    </button>
                                    <button class="bg-[#FF0000] px-2 py-2 rounded-full ">
                                        <img src="{{ asset('assets/icon/reject.png') }}" class="w-5 h-5" />
                                    </button>
                                    <button class="bg-[#19ACF5] px-2 py-2 rounded-full ">
                                        <img src="{{ asset('assets/icon/eyes.png') }}" class="w-5 h-5" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
@endsection
