@extends('layout.layout')
@php
    $title = 'Kelola Persetujuan Peminjaman';
    $script = '
        <script src="' . asset('assets/js/data-table.js') . '" defer></script>
        <script src="' . asset('assets/js/popup.js') . '" defer></script>
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
                        class=
                            "bg-[#FF0000] px-12 rounded-lg w-[250px]
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
                            <th scope="col">Gedung</th>
                            <th scope="col">Ruangan</th>
                            <th scope="col">Kapasitas</th>
                            <th scope="col" class="text-center">Penanggung Jawab</th>
                            <th scope="col" class="text-center">Jenis Peminjaman</th>
                            <th scope="col" class="text-center">Alasan</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>GKU</td>
                            <td>GKU.07.13</td>
                            <td>35</td>
                            <td class="text-center">Budi Santoso</td>
                            <td class="text-center">Akademik</td>
                            <td class="text-center">Koordinasi Proyek</td>
                            <td class="text-center">
                                <div class="flex flex-row gap-2 items-center justify-center">
                                    <button onclick="confirmButton()"
                                        class="bg-[#5ADF53] px-2 py-2 rounded-full transition-all duration-300 hover:scale-105">
                                        <img src="{{ asset('assets/icon/approve.png') }}" class="w-5 h-5" />
                                    </button>
                                    <button id="btn-reject"
                                        class="bg-[#FF0000] px-2 py-2 rounded-full transition-all duration-300 hover:scale-105">
                                        <img src="{{ asset('assets/icon/reject.png') }}" class="w-5 h-5" />
                                    </button>
                                    <button
                                        class="bg-[#19ACF5] px-2 py-2 rounded-full transition-all duration-300 hover:scale-105">
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
                                    <button onclick="confirmButton()"
                                        class="bg-[#5ADF53] px-2 py-2 rounded-full transition-all duration-300 hover:scale-105">
                                        <img src="{{ asset('assets/icon/approve.png') }}" class="w-5 h-5" />
                                    </button>
                                    <button id="btn-reject"
                                        class="bg-[#FF0000] px-2 py-2 rounded-full transition-all duration-300 hover:scale-105">
                                        <img src="{{ asset('assets/icon/reject.png') }}" class="w-5 h-5" />
                                    </button>
                                    <button
                                        class="bg-[#19ACF5] px-2 py-2 rounded-full transition-all duration-300 hover:scale-105">
                                        <img src="{{ asset('assets/icon/eyes.png') }}" class="w-5 h-5" />
                                    </button>
                                </div>
                            </td>
                        </tr>
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
    <script>
        function confirmButton() {
            Swal.fire({
                title: "Yakin akan menyetujui?",
                text: "Anda tidak akan dapat mengembalikan ini!",
                icon: "warning",
                showCancelButton: true,
                cancelButtonText: "Batal",
                confirmButtonText: "Menyetujui",
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-5 rounded-lg',
                    cancelButton: 'bg-gray-300 hover:bg-gray-400 text-black font-bold py-2 px-5 rounded-lg ml-2',
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your file has been deleted.",
                        icon: "success"
                    });
                }
            });
        }
    </script>
@endsection
