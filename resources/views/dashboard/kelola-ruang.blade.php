@extends('layout.layout')
@php
    $title = 'Kelola Ruang';
    $script = '
        <script src="' . asset('assets/js/data-table.js') . '" defer></script>
        <script src="' . asset('assets/js/popup.js') . '" defer></script>    
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

                <div class="grid grid-cols-1 sm:grid-cols-4 md:grid-cols-4 lg:grid-cols-1 gap-10 mb-5">
                    <div class="flex flex-row gap-10 sm:gap-4 sm:flex-col md:flex-col lg:flex-row">
                        <div class="flex flex-col flex-1 gap-5">
                            <h1 class="text-lg font-normal">Lantai</h1>
                            <select class="rounded-xl"></select>
                        </div>
                        <div class="flex flex-col flex-1 gap-5">
                            <h1 class="text-lg font-normal">Ruangan</h1>
                            <select class="rounded-xl"></select>
                        </div>
                    </div>
                </div>

                <div>
                    <button class="bg-[#ff0000ce] rounded-lg px-5 py-2">
                        Filter
                    </button>
                </div>
            </div>
            <div class="col-span-1 md:col-span-2 bg-white shadow-lg p-5 rounded-xl">
                <div class="flex flex-col gap-2 pb-8 mb-8">
                    <h1 class="font-bold text-2xl">Tambah Ruangan</h1>
                    <div class="w-50 border"></div>
                    <p class="text-[#8B8B8B] text-md">Tambah ruang sesuai Gedung yang dipilih 😋</p>
                </div>
                <div class="flex items-center justify-center">
                    <button id="btn-tambah-ruang" class="bg-[#ff0000ce] rounded-lg px-5 py-2">
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

        <!-- Pop Up 1 -->
        <section id="pop-up" class="hidden fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-xl shadow-lg overflow-y-auto relative">
                <div class="flex flex-row justify-between mb-10">
                    <p></p>
                    <h1 class="text-2xl font-bold">Edit Ruangan</h1>
                    <button id="cls-btn">
                        <img src="{{ asset('assets/icon/cross.svg') }}" class="" />
                    </button>
                </div>
                <div class="flex flex-row gap-10 mb-5 sm:flex-col">
                    <div class="flex flex-col  gap-5">
                        <div class="flex flex-col">
                            <label class="text-black">Ac</label>
                            <input type="text" class="rounded-lg" />
                        </div>
                        <div class="flex flex-col">
                            <label class="text-black">Meja</label>
                            <input type="text" class="rounded-lg" />
                        </div>
                    </div>
                    <div class="flex flex-col gap-5">
                        <div class="flex flex-col">
                            <label class="text-black">Kursi</label>
                            <input type="text" class="rounded-lg" />
                        </div>
                        <div class="flex flex-col">
                            <label class="text-black">Proyektor</label>
                            <input type="text" class="rounded-lg" />
                        </div>
                    </div>
                </div>
                <div class="flex flex-col gap-10">
                    <select class="rounded-xl w-[508px] sm:w-auto text-black">
                        <option value="" disabled selected>Status</option>
                        <option value="akademik">Aktif</option>
                        <option value="non-akademik">Tidak Aktif</option>
                    </select>
                    <button class="w-[508px] text-white bg-[red] py-2 rounded-xl">
                        submit
                    </button>
                </div>
            </div>
        </section>

        <!-- Pop Up 2 -->
        <section id="pop-up-ruangan"
            class="hidden fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-xl shadow-lg overflow-y-auto relative">
                <div class="flex flex-row justify-between mb-10">
                    <p></p>
                    <h1 class="text-2xl font-bold">Tambah Ruangan</h1>
                    <button id="cls-btn-ruangan">
                        <img src="{{ asset('assets/icon/cross.svg') }}" class="" />
                    </button>
                </div>
                <div class="flex flex-col gap-10 mb-5 sm:flex-col">
                    <div class="flex flex-col">
                        <label class="text-black">Kode Ruangan</label>
                        <input type="text" class="rounded-lg" />
                    </div>
                    <div class="flex flex-row gap-10 mb-5 sm:flex-col">
                        <div class="flex flex-col  gap-5">
                            <div class="flex flex-col">
                                <label class="text-black">Ac</label>
                                <input type="text" class="rounded-lg" />
                            </div>
                            <div class="flex flex-col">
                                <label class="text-black">Meja</label>
                                <input type="text" class="rounded-lg" />
                            </div>
                        </div>
                        <div class="flex flex-col gap-5">
                            <div class="flex flex-col">
                                <label class="text-black">Kursi</label>
                                <input type="text" class="rounded-lg" />
                            </div>
                            <div class="flex flex-col">
                                <label class="text-black">Proyektor</label>
                                <input type="text" class="rounded-lg" />
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col gap-10">
                        <select class="rounded-xl w-[508px] sm:w-auto text-black">
                            <option value="" disabled selected>Status</option>
                            <option value="akademik">Aktif</option>
                            <option value="non-akademik">Tidak Aktif</option>
                        </select>
                        <button class="w-auto text-white bg-[red] py-2 rounded-xl">
                            submit
                        </button>
                    </div>
                </div>
        </section>
    </main>
@endsection
