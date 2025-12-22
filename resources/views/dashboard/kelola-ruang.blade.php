@extends('layout.layout')
@php
    $title = 'Kelola Ruang';
    $script = '
        <script src="' . asset('assets/js/data-table.js') . '" defer></script>
        <script src="' . asset('assets/js/popup.js') . '" defer></script>
        <script src="' . asset('assets/js/dynamic-input.js') . '" defer></script>
    ';
@endphp

@section('content')
    <h1 class="text-2xl mb-5">{{ $title }}</h1>

    <main class="grid sm:grid-cols-1 md:grid-cols-1">
        <!-- Section One -->
        <section class="grid grid-col-2 lg:grid-cols-2 sm:grid-cols-1 md:grid-cols-1 gap-5 justify-between mb-5">
            <div class="col-span-1 md:col-span-2 bg-white shadow-lg p-5 rounded-xl">
                <div class="flex flex-col gap-2 pb-8 mb-8">
                    <h1 class="font-bold text-2xl">Filter Ruangan</h1>
                    <div class="w-50 border"></div>
                    <p class="text-[#8B8B8B] text-md">Pastikan data yang dipilih telah sesuai
                        untuk menampilkan data ruangan 😄</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-4 md:grid-cols-4 lg:grid-cols-1 gap-10 mb-8">
                    <div class="flex flex-row gap-10 sm:gap-4 sm:flex-col md:flex-col lg:flex-row">
                        <select
                            class="rounded-md flex-1 text-[#000000] py-2 px-3 appearance-none
                            bg-transparent border border-[#808080] border-opacity-50">
                            <option value="" disabled selected>Lantai</option>
                            <option value="akademik">GKU.04</option>
                            <option value="non-akademik">FIT.02</option>
                        </select>
                        <select
                            class="rounded-md flex-1 text-[#000000] py-2 px-3 appearance-none
                            bg-transparent border border-[#808080] border-opacity-50">
                            <option value="" disabled selected>Ruangan</option>
                            <option value="akademik">GKU.04.14</option>
                            <option value="non-akademik">FIT.02.15</option>
                        </select>
                    </div>
                </div>

                <div>
                    <button class="bg-[#ff0000ce] rounded-lg w-[150px] py-2 text-xl font-extrabold">
                        Filter
                    </button>
                </div>
            </div>
            <div class="col-span-1 md:col-span-2 bg-white shadow-lg p-5 rounded-xl">
                <div class="flex flex-col gap-2 pb-8 mb-8">
                    <p class="text-2xl font-extrabold">Tambah Ruangan</h1>
                    <div class="w-50 border"></div>
                    <p class="text-[#8B8B8B] text-md">Tambah ruang sesuai Gedung yang dipilih 😋</p>
                </div>
                <div class="flex items-center justify-center">
                    <button id="btn-tambah-ruang" class="bg-[#ff0000ce] rounded-lg px-5 py-2 font-extrabold">
                        Tambah Ruangan +
                    </button>
                </div>
            </div>
        </section>
        <!-- Section Two -->
        <section class="col-span-12 rounded-2xl bg-white shadow-lg p-8">
            <div class="overflow-x-auto">
                <table id="selection-table-3" class="table bordered-table sm-table mb-0 table-auto border-black p-1">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Ruangan</th>
                            <th scope="col">Fasilitas</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <td>1</td>
                        <td>GKU.07.13</td>
                        <td>
                            AC: 20</br>
                            Kursi: 20</br>
                            Meja: 20 </br>
                            Proyektor: 1
                        </td>
                        <td>
                            Aktif
                        </td>
                        <td>
                            <button id="open-pop-up" class="rounded-full bg-[#ff9d007e] px-4 py-3">
                                <iconify-icon icon="mingcute:edit-2-line" class="text-white"></iconify-icon>
                            </button>
                        </td>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Pop Up Edit -->
        <section id="pop-up" class="hidden fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-xl shadow-lg overflow-y-auto relative w-[900px]">
                <div class="flex flex-row justify-between mb-10">
                    <p></p>
                    <h1 class="text-2xl font-bold">Edit Fasilitas Ruangan</h1>
                    <button id="cls-btn">
                        <img src="{{ asset('assets/icon/cross.svg') }}" class="" />
                    </button>
                </div>
                <div class="flex flex-col sm:flex-col gap-5">
                    <div class="flex flex-col gap-5">
                        <div class="flex flex-col gap-1">
                            <h1 class="text-2xl">Ruangan</h1>
                            <div class="w-50 border border-dashed border-black border-opacity-25"></div>
                        </div>
                        <select
                            class="rounded-md w-[416px] text-[#000000] py-2 px-3 appearance-none
                                bg-transparent border border-[#808080] border-opacity-50">
                            <option value="" disabled selected>Status</option>
                            <option value="akademik">Aktif</option>
                            <option value="non-akademik">Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="flex flex-col gap-5">
                        <div class="flex flex-col gap-1">
                            <h1 class="text-2xl">Fasilitas</h1>
                            <div class="w-50 border border-dashed border-black border-opacity-25"></div>
                        </div>
                        <textarea
                            class="rounded-lg py-2 px-3 h-24 border border-[#808080]
                            border-opacity-50 text-black"
                            placeholder="Fasilitas"></textarea>
                    </div>
                    <button class="w-auto text-white bg-[red] py-3 rounded-xl font-extrabold">
                        Submit
                    </button>
                </div>
            </div>
        </section>

        <!-- Pop Up Tambah -->
        <section id="pop-up-ruangan"
            class="hidden fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-xl shadow-lg overflow-y-auto relative w-[900px]">
                <div class="flex flex-row justify-between mb-10">
                    <p></p>
                    <h1 class="text-2xl font-bold">Tambah Ruangan</h1>
                    <button id="cls-btn-ruangan">
                        <img src="{{ asset('assets/icon/cross.svg') }}" class="" />
                    </button>
                </div>
                <div class="flex flex-col sm:flex-col gap-5">
                    <div class="flex flex-col gap-5">
                        <div class="flex flex-col gap-1">
                            <h1 class="text-2xl">Ruangan</h1>
                            <div class="w-50 border border-dashed border-black border-opacity-25"></div>
                        </div>
                        <div class="flex flex-row gap-5">
                            <input type="text"
                                class="rounded-lg flex-1 py-2 px-3 border
                              border-[#808080] border-opacity-50"
                                placeholder="Lantai" />
                            <input type="text"
                                class="rounded-lg flex-1 py-2 px-3 border
                              border-[#808080] border-opacity-50"
                                placeholder="Kode Ruangan" />
                        </div>
                        <select
                            class="rounded-md w-[416px] text-[#000000] py-2 px-3 appearance-none
                                bg-transparent border border-[#808080] border-opacity-50">
                            <option value="" disabled selected>Status</option>
                            <option value="akademik">Aktif</option>
                            <option value="non-akademik">Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="flex flex-col gap-5">
                        <div class="flex flex-col gap-1">
                            <div class="flex flex-row justify-between">
                                <h1 class="text-2xl">Fasilitas</h1>
                                <iconify-icon icon="mingcute:warning-line" id="button-info"
                                    class="text-black text-2xl"></iconify-icon>
                            </div>
                            <div class="w-50 border border-dashed border-black border-opacity-25"></div>
                        </div>
                        <div id="container-input" class="flex flex-col gap-5">

                        </div>
                        <div class="flex justify-center flex-row gap-5">
                            <button id="button-add" class="border rounded-lg flex items-center p-2">
                                <iconify-icon icon="mingcute:plus-fill"
                                    class="text-4xl sm:text-sm text-[#ff0000ce]"></iconify-icon>
                            </button>
                            <button id="button-less" class="border rounded-lg flex items-center p-2 hidden">
                                <iconify-icon icon="typcn:minus"
                                    class="text-4xl sm:text-sm text-[#ff0000ce]"></iconify-icon>
                            </button>
                        </div>
                    </div>
                    <button class="w-auto text-white bg-[red] py-3 rounded-xl font-extrabold">
                        Submit
                    </button>
                </div>
        </section>

        <section id="hover-info" class="hidden flex items-center justify-center z-50 absolute bottom-full mb-2 left-1/2 -translate-x-1/2">
            <div class="bg-white shadow-md py-2 rounded-lg px-2 w-[280px] text-center">
                <p>Tekan Tombol Tambah Jika Ingin MenambahKan Asset Ruangan</p>
            </div>
        </section>
    </main>
@endsection
