@extends('layout.layout')
@php
    $title = 'Kelola Gedung';
    $script = '
        <script src="' . asset('assets/js/popup.js') . '" defer></script>
        <script src="' . asset('assets/js/hover-card.js') . '" defer></script>
    ';
@endphp

@section('content')
    <div class="flex flex-row mb-5 justify-between">
        <h1 class="font-bold text-2xl">{{ $title }}</h1>
        <button id="btn-gedung"
            class="
            bg-[#FF0101] rounded-lg px-5 py-2 font-extrabold transition-all
            duration-300 hover:scale-105 flex justify-center items-center gap-2">
            <iconify-icon icon="mingcute:plus-fill" class="text-2xl"></iconify-icon>
            <span class="font-extrabold mt-1">Tambah Gedung</span>
        </button>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-5">

        <!-- Card One -->
        <div class="bg-[#ffffff] text-black rounded-xl py-1 px-1
                shadow-lg space-x-4 flex flex-col">
            <div class="flex flex-col justify-center items-center gap-5 mb-2">
                <div class="flex flex-col gap-2">
                    <div class="relative w-auto h-64 card-container">

                        <img src="{{ asset('assets/basila_images/gambar-gedung.png') }}"
                            class="w-full h-full object-cover rounded-lg" />
                        <div class="overlay absolute inset-0 bg-gradient-to-t from-black/70 to-transparent rounded-lg z-20 hidden"
                            ></div>

                        <div class="button-kelola absolute top-[110px] left-[150px] z-30 hidden">
                            <a id="btn-gedung" href="{{ route("index7") }}"
                                class="bg-[#FF0101] rounded-lg px-5 py-2 font-extrabold transition-all cursor-pointer
                                duration-300 hover:scale-105 flex justify-center items-center gap-2 mx-auto text-white">
                                <iconify-icon icon="mingcute:plus-fill" class="text-2xl"></iconify-icon>
                                <span class="font-extrabold mt-1">Tambah Gedung</span>
                            </a>
                        </div>
                    </div>
                    <div class="flex flex-col px-5 gap-3">
                        <div class="flex flex-row gap-10 justify-between items-center">
                            <h2 class="text-black font-bold leading-tight md:text-xl sm:text-md lg:text-2xl">Nama
                                Gedung
                            </h2>
                            <iconify-icon icon="basil:edit-outline" class="text-4xl opacity-50"
                                id="edit-gedung"></iconify-icon>
                        </div>
                        <p class=
                               "text-[#8B8B8B] text-md">
                            надвигается туман, надвигается туман, помоги мне, позволь ему помочь тебе, кожа
                            на моем теле ослабевает, я хочу ее снять, я чувствую, как растут новые конечности, это
                            больно,
                            ...</p>
                    </div>
                </div>
                <div class="flex flex-row gap-4">
                    <div class="bg-[#FF0101] w-[120px] h-[100px] rounded-2xl
                        flex flex-col justify-center items-center">
                        <h1 class="text-white text-2xl">30</h1>
                        <p class="text-white font-bold text-sm">Jumlah</p>
                        <p class="text-white font-bold text-sm">Ruangan</p>
                    </div>
                    <div class="bg-[#FF0101] w-[120px] h-[100px] rounded-2xl
                        flex flex-col justify-center items-center">
                        <h1 class="text-white text-2xl">30</h1>
                        <p class="text-white font-bold text-sm">Jumlah</p>
                        <p class="text-white font-bold text-sm">Lantai</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Pop Up -->
    <section id="pop-up-gedung" class="hidden fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-xl shadow-lg
                overflow-y-auto relative flex-col w-[900px] sm:w-[80%] md:w-[600px] lg:w-[700px]">
            <div class="flex flex-row justify-between mb-10">
                <h1 class="text-2xl font-bold">Tambah Gedung</h1>
                <button id="cls-btn-gedung">
                    <img src="{{ asset('assets/icon/cross.svg') }}" class="" />
                </button>
            </div>

            <div class="flex sm:flex-col md:flex-col lg:flex-col gap-5 w-full">
                <div class="flex flex-col gap-3">
                    <label for="gambar" class="rounded-lg py-2 px-3 border border-[#808080] border-opacity-50 text-[#808080] cursor-pointer">
                        Klik untuk menambahkan gambar
                    </label>

                    <input id="gambar" type="file" class="hidden" />
                </div>

                <div class="flex sm:flex-col md:flex-col lg:flex-row gap-5 mb-5">
                    <div class="flex flex-col gap-5 flex-1">
                        <input type="text"
                            class="rounded-lg py-2 px-3 border
                          border-[#808080] border-opacity-50"
                            placeholder="Nama Gedung" />
                        <input type="text"
                            class="rounded-lg py-2 px-3 border
                          border-[#808080] border-opacity-50"
                            placeholder="Kode Gedung" />
                    </div>
                    <div class="flex flex-col gap-5 flex-1">
                        <input type="text"
                            class="rounded-lg py-2 px-3 border border-[#808080]
                            border-opacity-50"
                            placeholder="Jumlah Lantai " />
                        <select
                            class="rounded-xl sm:w-auto text-[#808080] py-2 px-3 appearance-none
                        bg-transparent border border-[#808080] border-opacity-50">
                            <option value="" disabled selected>Status</option>
                            <option value="akademik">Aktif</option>
                            <option value="non-akademik">Tidak Aktif</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-5">
                <textarea class="rounded-lg py-2 px-3 h-24 border border-[#808080]
                border-opacity-50"
                    placeholder="Deskripsi"></textarea>
                <button class="w-auto text-white bg-[red] py-2 rounded-xl font-extrabold">
                    Submit
                </button>
            </div>
        </div>
    </section>
@endsection
