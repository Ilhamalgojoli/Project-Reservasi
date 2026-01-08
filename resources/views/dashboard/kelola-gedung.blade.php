@extends('layout.layout')
@php
    $title = 'Kelola Gedung';
    $script = '
        <script src="' . asset('assets/js/popup.js') . '" defer></script>
        <script src="' . asset('assets/js/hover-card.js') . '" defer></script>
        <script src="' . asset('assets/js/tambah-gedung.js') . '" defer></script>
        <script src="' . asset('assets/js/edit-gedung.js') . '" defer></script>
    ';
@endphp

@section('content')
    <div class="flex flex-row mb-5 justify-between sm:gap-5">
        <h1 class="font-bold text-2xl">{{ $title }}</h1>
        <button data-popup-target = "pop-up-gedung"
            class="
            bg-[#FF0101] rounded-lg px-5 py-2 sm:px-1 sm:py-1 font-extrabold transition-all
            duration-300 hover:scale-105 flex justify-center items-center gap-2
            ">
            <iconify-icon icon="mingcute:plus-fill" class="text-2xl sm:text-sm"></iconify-icon>
            <span class="font-extrabold mt-1 sm:text-sm">Tambah Gedung</span>
        </button>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-5">
        @foreach ($datas as $data)
            <div class="bg-[#ffffff] text-black rounded-xl py-1 px-1
                shadow-lg space-x-4 flex flex-col">
                <div class="flex flex-col justify-center items-center gap-5 mb-2">
                    <div class="flex flex-col gap-2 w-full ">
                        <div class="relative w-auto h-64 card-container">
                            <img src="{{ $data['gambar'] ? asset('storage/' . $data['gambar']) : asset('assets/basila_images/DefaultBuilding.png') }}"
                                class="w-full h-full object-cover rounded-lg" />

                            <div
                                class="overlay absolute inset-0 bg-gradient-to-t from-black/70 to-transparent rounded-lg z-20 lg:hidden">
                            </div>

                            <!-- icon menu -->
                            <div class="absolute top-3 right-3 z-30">

                            </div>

                            <!-- button -->
                            <div class="button-kelola absolute top-[110px] left-1/2 -translate-x-1/2 z-30 lg:hidden">
                                <a id="btn-gedung" href="{{ route('kelola-ruang', ['id' => $data['id']]) }}"
                                    class="bg-[#FF0101] rounded-lg px-5 py-2 font-extrabold transition-all
                                    duration-300 hover:scale-105 flex justify-center items-center gap-2 text-white">
                                    <iconify-icon icon="mingcute:plus-fill" class="text-2xl"></iconify-icon>
                                    <span class="font-extrabold mt-1">Kelola Ruangan</span>
                                </a>
                            </div>
                        </div>
                        <div class="flex flex-col px-5 gap-3">
                            <div class="flex flex-row justify-between items-center">
                                <h2 class="text-black font-bold leading-tight md:text-xl sm:text-md lg:text-2xl">
                                    {{ $data['nama_gedung'] }}
                                </h2>
                                <button data-id="{{ $data['id'] }}" class="edit-btn">
                                    <iconify-icon icon="basil:edit-outline" class="text-4xl opacity-50"></iconify-icon>
                                </button>
                            </div>
                            <p class=
                               "text-[#8B8B8B] text-md">
                                {{ $data['keterangan'] }}
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-row gap-4">
                        <div
                            class="bg-[#FF0101] w-[120px] h-[100px] rounded-2xl
                        flex flex-col justify-center items-center">
                            <h1 class="text-white text-2xl">{{ $data['ruangan_count'] ?? '0' }}</h1>
                            <p class="text-white font-bold text-sm">Jumlah</p>
                            <p class="text-white font-bold text-sm">Ruangan</p>
                        </div>
                        <div
                            class="bg-[#FF0101] w-[120px] h-[100px] rounded-2xl
                        flex flex-col justify-center items-center">
                            <h1 class="text-white text-2xl">{{ $data['jumlah_lantai'] }}</h1>
                            <p class="text-white font-bold text-sm">Jumlah</p>
                            <p class="text-white font-bold text-sm">Lantai</p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pop Up Tambah-->
    <section id="pop-up-gedung"
        class="popup hidden fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50">
        <div
            class="bg-white p-6 rounded-xl shadow-lg
                overflow-y-auto relative flex-col w-[900px] sm:w-[80%] md:w-[600px] lg:w-[700px]">
            <form id="tambah-gedung">
                <div class="flex flex-row justify-between mb-10">
                    <h1 class="text-2xl font-bold">Tambah Gedung</h1>
                    <button class="popup-close">
                        <img src="{{ asset('assets/icon/cross.svg') }}" class="" />
                    </button>
                </div>

                <div class="flex sm:flex-col md:flex-col lg:flex-col gap-5 w-full">
                    <input id="gambar" type="file"
                        class="rounded-lg py-2 px-3 border border-[#808080] border-opacity-50 text-[#808080] cursor-pointer"
                        accept="image/*" />

                    <div class="flex sm:flex-col md:flex-col lg:flex-row gap-5 mb-5">
                        <div class="flex flex-col gap-5 flex-1">
                            <input type="text"
                                class="rounded-lg py-2 px-3 border text-black
                                border-[#808080] border-opacity-50"
                                id="nama" placeholder="Nama Gedung" />
                            <input type="text"
                                class="rounded-lg py-2 px-3 border text-black
                                border-[#808080] border-opacity-50"
                                id="kode" placeholder="Kode Gedung" />
                        </div>
                        <div class="flex flex-col gap-5 flex-1">
                            <input type="text"
                                class="rounded-lg py-2 px-3 border border-[#808080] text-black
                                border-opacity-50"
                                id="jumlah" placeholder="Jumlah Lantai " />
                            <select id="status"
                                class="rounded-xl sm:w-auto text-[#808080] py-2 px-3 appearance-none
                                bg-transparent border border-[#808080] border-opacity-50">
                                <option value="" disabled selected>Status</option>
                                <option value="Aktif">Aktif</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col gap-5">
                    <textarea class="rounded-lg py-2 px-3 h-24 border border-[#808080]
                        border-opacity-50 text-black"
                        id="keterangan" placeholder="Deskripsi"></textarea>
                    <button id="tambah-submit" type="button"
                        class="w-auto text-white bg-[red] py-2 rounded-xl font-extrabold">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- Pop Up Edit -->
    <section id="pop-up-edit"
        class="popup hidden fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50">
        <div
            class="bg-white p-6 rounded-xl shadow-lg
                overflow-y-auto relative flex-col w-[900px] sm:w-[80%] md:w-[600px] lg:w-[700px]">
            <div class="flex flex-row justify-between mb-10">
                <h1 class="text-2xl font-bold">Edit Gedung</h1>
                <button class="popup-close">
                    <img src="{{ asset('assets/icon/cross.svg') }}" class="" />
                </button>
            </div>

            <div class="flex sm:flex-col md:flex-col lg:flex-col gap-5 w-full">
                <input id="edit-gambar" type="file"
                    class="rounded-lg py-2 px-3 border border-[#808080] border-opacity-50 text-[#808080] cursor-pointer"
                    accept="image/*" />

                <div class="flex sm:flex-col md:flex-col lg:flex-row gap-5 mb-5">
                    <div class="flex flex-col gap-5 flex-1">
                        <input type="text" id="edit-nama"
                            class="rounded-lg py-2 px-3 border text-black
                          border-[#808080] border-opacity-50"
                            placeholder="Nama Gedung" />
                        <input type="text" id="edit-kode"
                            class="rounded-lg py-2 px-3 border text-black
                          border-[#808080] border-opacity-50"
                            placeholder="Kode Gedung" />
                    </div>
                    <div class="flex flex-col gap-5 flex-1">
                        <input type="text" id="edit-jumlah-lantai"
                            class="rounded-lg py-2 px-3 border border-[#808080] text-black
                            border-opacity-50"
                            placeholder="Jumlah Lantai " />
                        <select id="edit-status"
                            class="rounded-xl sm:w-auto text-[#808080] py-2 px-3 appearance-none
                            bg-transparent border border-[#808080] border-opacity-50 text-black">
                            <option value="" disabled>Status</option>
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-5">
                <textarea class="rounded-lg py-2 px-3 h-24 border border-[#808080]
                border-opacity-50 text-black"
                    id="edit-keterangan" placeholder="Deskripsi"></textarea>
                <div class="flex flex-row justify-center gap-5">
                    <button type="button"
                        class="btn-delete w-auto px-2 text-white bg-[red] py-2 rounded-xl font-extrabold flex flex-row items-center">
                        <iconify-icon icon="mdi:garbage-can-outline" class="text-xl"></iconify-icon>
                        Hapus
                    </button>
                    <button id="submit-edit" type="button"
                        class="w-auto px-2 text-white bg-[red] py-2 rounded-xl font-extrabold">
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </section>

    <script>
        const routes = {
            storeData: "{{ route('tambah.gedung') }}",
            updateData: "{{ route('update.gedung') }}"
        };
    </script>
@endsection
