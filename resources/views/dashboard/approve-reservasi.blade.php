@extends('layout.layout')
@php
    $title = 'Kelola Persetujuan Peminjaman';
    $script = '
        <script src="' . asset('assets/js/data-table.js') . '" defer></script>
        <script src="' . asset('assets/js/popup.js') . '" defer></script>
        <script src="' . asset('assets/js/approve-reject.js') . '" defer></script>  
    ';
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
            <div class="grid grid-cols-1 sm:grid-cols-4 md:grid-cols-4 lg:grid-cols-1 gap-10 mb-5">
                <div class="flex flex-row gap-10 sm:gap-4 sm:flex-col md:flex-col lg:flex-row">
                    <select
                        class="rounded-xl flex-1 text-[#808080] py-2 px-3 appearance-none
                        bg-transparent border border-[#808080] border-opacity-50">
                        <option value="" disabled selected>Jenis Peminjaman</option>
                        <option value="akademik">Akademik</option>
                        <option value="non-akademik">Non Akademik</option>
                    </select>
                    <select
                        class="rounded-xl flex-1 text-[#808080] py-2 px-3 appearance-none
                        bg-transparent border border-[#808080] border-opacity-50">
                        <option value="" disabled selected>Gedung</option>
                        <option value="akademik">GKU</option>
                        <option value="non-akademik">FIT</option>
                    </select>
                </div>
                <div class="flex flex-row gap-10 sm:gap-4 sm:flex-col md:flex-col lg:flex-row">
                    <select
                        class="rounded-xl sm:w-auto md:w-auto lg:w-[728px] text-[#808080] py-2 px-3 appearance-none
                        bg-transparent border border-[#808080] border-opacity-50">
                        <option value="" disabled selected>Lantai</option>
                        <option value="akademik">GKU.04</option>
                        <option value="non-akademik">FIT.02</option>
                    </select>
                    <button
                        class="bg-[#FF0000] px-12 rounded-lg w-[250px]
                        transition-all duration-300 hover:scale-105 sm:py-2 py-2 font-bold text-xl">
                        Filter
                    </button>
                </div>
            </div>
        </section>
        <section class="col-span-12 rounded-2xl bg-white shadow-lg p-8">
            <div class="overflow-x-auto">
                <table id="selection-table-2" class="table bordered-table sm-table mb-0 table-auto border-black p-1">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">Gedung</th>
                            <th scope="col">Ruangan</th>
                            <th scope="col">Kapasitas</th>
                            <th scope="col" class="text-center">Penanggung Jawab</th>
                            <th scope="col" class="text-center">Jenis Peminjaman</th>
                            <th scope="col" class="text-center">Alasan</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($peminjaman as $data)
                            <tr>
                                <td class="text-start">{{ $data->nama_gedung }} / {{ $data->lantai }}</td>
                                <td>{{ $data->kode_ruangan }}</td>
                                <td>{{ $data->muatan }}</td>
                                <td class="text-center">{{ $data->penanggung_jawab }}</td>
                                <td class="text-center">{{ $data->jenis_peminjaman }}</td>
                                <td class="text-center">{{ $data->keterangan_peminjaman }}</td>
                                <td>
                                    <button
                                        class="btn-popup w-8 h-8 bg-primary-50 dark:bg-primary-600/10 text-primary-600 dark:text-primary-400 rounded-full inline-flex items-center justify-center">
                                        <iconify-icon icon="iconamoon:eye-light"></iconify-icon>
                                    </button>

                                    <!-- APPROVE -->
                                    <button type="button" onclick="approveButton({{ $data->id }})"
                                        class="w-8 h-8 bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400 rounded-full inline-flex items-center justify-center">
                                        <iconify-icon icon="mdi:check"></iconify-icon>
                                    </button>

                                    <!-- REJECT -->
                                    <button type="button" onclick="rejectButton({{ $data->id }})"
                                        class="w-8 h-8 bg-danger-100 dark:bg-danger-600/25 text-danger-600 dark:text-danger-400 rounded-full inline-flex items-center justify-center">
                                        <iconify-icon icon="mdi:close"></iconify-icon>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Pop Up -->
        <section id="pop-up-reject"
            class="hidden fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-xl shadow-lg overflow-y-auto relative space-y-8">
                <h1 class="text-2xl font-bold text-center">Tolak Peminjaman</h1>
                <div class="flex flex-col gap-5">
                    <label class="text-xl text-black">Alasan</label>
                    <textarea class="rounded-lg p-8 border border-gray-300 w-full text-black"></textarea>
                </div>
                <div class="flex flex-row gap-5 justify-end">
                    <button id="cls-btn-reject" class="w-auto text-white bg-[gray] px-5 py-2 rounded-xl">
                        Batal
                    </button>
                    <button class="w-auto text-white bg-[red] px-5 py-2 rounded-xl">
                        Tolak
                    </button>
                </div>
            </div>
        </section>
    </main>
@endsection