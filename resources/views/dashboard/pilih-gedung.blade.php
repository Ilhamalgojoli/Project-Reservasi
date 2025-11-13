@extends('layout.layout')
@php
    $title = 'Kelola Gedung';
    $script = '
        <script src="' . asset('assets/js/popup.js') . '" defer></script>
    ';
@endphp

@section('content')
    <div class="flex flex-row mb-5 justify-between">
        <h1 class="font-bold text-2xl">{{ $title }}</h1>
        <button id="btn-gedung"
            class="
            bg-[#FF0101] rounded-lg px-5 py-2 font-bold transition-all 
            duration-300 hover:scale-105
            ">
            + Gedung
        </button>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-5">

        <!-- Card One -->
        <div class="bg-[#ffffff] text-black rounded-xl py-2 px-2
                shadow-lg space-x-4 flex justify-start">
            <div class="flex flex-col justify-center items-center gap-5 mb-5">
                <div class="flex flex-col gap-2 text-center">
                    <img src="{{ asset('assets/basila_images/gambar-gedung.png') }}" class="w-auto" />
                    <div class="flex flex-row gap-10 justify-center items-center">
                        <img src="{{ asset('/assets/icon/black-building.png') }}" class="w-8" />
                        <h2 class="text-black font-bold leading-tight pt-4 md:text-xl sm:text-md lg:text-2xl">Nama Gedung
                        </h2>
                    </div>
                    <p class=
                               "text-lg text-[#8B8B8B]">
                        надвигается туман, надвигается туман, помоги мне, позволь ему помочь тебе, кожа
                        на моем теле ослабевает, я хочу ее снять, я чувствую, как растут новые конечности, это
                        больно,
                        ...</p>
                </div>
                <a href="{{ route('index7') }}"
                    class="bg-[#FF0101] text-[#FFFFFF] px-16 py-2 rounded-xl flex justify-center transition-all duration-300 hover:scale-105">
                    <iconify-icon icon="typcn:plus" style="font-size:32px;" />
                </a>
            </div>
        </div>

        <!-- Card Two -->
        <div class="bg-[#ffffff] text-black rounded-xl py-2 px-2
                shadow-lg space-x-4 flex justify-between">
            <div class="flex flex-col justify-center items-center gap-5 mb-5">
                <div class="flex flex-col gap-2 text-center">
                    <img src="{{ asset('assets/basila_images/gambar-gedung.png') }}" class="w-auto" />
                    <div class="flex flex-row gap-10 justify-center items-center">
                        <img src="{{ asset('/assets/icon/black-building.png') }}" class="w-8" />
                        <h2 class="text-2xl text-black font-bold leading-tight pt-4">Nama Gedung</h2>
                    </div>
                    <p class=
                               "text-lg text-[#8B8B8B]">
                        надвигается туман, надвигается туман, помоги мне, позволь ему помочь тебе, кожа
                        на моем теле ослабевает, я хочу ее снять, я чувствую, как растут новые конечности, это
                        больно,
                        ...</p>
                </div>
                <a href="{{ route('index7') }}"
                    class="bg-[#FF0101] text-[#FFFFFF] px-16 py-2 rounded-xl flex justify-center transition-all duration-300 hover:scale-105">
                    <iconify-icon icon="typcn:plus" style="font-size:32px;" />
                </a>
            </div>
        </div>

        <!-- Card Three -->
        <div class="bg-[#ffffff] text-black rounded-xl py-2 px-2
                shadow-lg space-x-4 flex justify-between">
            <div class="flex flex-col justify-center items-center gap-5 mb-5">
                <div class="flex flex-col gap-2 text-center">
                    <img src="{{ asset('assets/basila_images/gambar-gedung.png') }}" class="w-auto" />
                    <div class="flex flex-row gap-10 justify-center items-center">
                        <img src="{{ asset('/assets/icon/black-building.png') }}" class="w-8" />
                        <h2 class="text-2xl text-black font-bold leading-tight pt-4">Nama Gedung</h2>
                    </div>
                    <p class=
                               "text-lg text-[#8B8B8B]">
                        надвигается туман, надвигается туман, помоги мне, позволь ему помочь тебе, кожа
                        на моем теле ослабевает, я хочу ее снять, я чувствую, как растут новые конечности, это
                        больно,
                        ...</p>
                </div>
                <a href="{{ route('index7') }}"
                    class="bg-[#FF0101] text-[#FFFFFF] px-16 py-2 rounded-xl flex justify-center transition-all duration-300 hover:scale-105">
                    <iconify-icon icon="typcn:plus" style="font-size:32px;" />
                </a>
            </div>
        </div>

        <!-- Pop Up -->
        <section id="pop-up-gedung"
            class="hidden fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-xl shadow-lg 
                overflow-y-auto relative flex-col">
                <div class="flex flex-row justify-between mb-10">
                    <p></p>
                    <h1 class="text-2xl font-bold">Tambah Gedung</h1>
                    <button id="cls-btn-gedung">
                        <img src="{{ asset('assets/icon/cross.svg') }}" class="" />
                    </button>
                </div>
                <div class="flex sm:flex-col md:flex-col lg:flex-row gap-10 mb-5">
                    <div class="flex flex-col  gap-5">
                        <div class="flex flex-col">
                            <label class="text-black">Nama Gedung</label>
                            <input type="text" class="rounded-lg" />
                        </div>
                        <div class="flex flex-col">
                            <label class="text-black">Kode Gedung</label>
                            <input type="text" class="rounded-lg" />
                        </div>
                    </div>
                    <div class="flex flex-col gap-5">
                        <div class="flex flex-col">
                            <label class="text-black">Jumlah Lantai</label>
                            <input type="text" class="rounded-lg" />
                        </div>
                        <div class="flex flex-col">
                            <label class="text-black">Jumlah Ruangan</label>
                            <input type="text" class="rounded-lg" />
                        </div>
                    </div>
                </div>
                <div class="flex flex-col gap-10">
                    <select class="rounded-xl w-auto sm:w-auto text-black">
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
    </div>
@endsection
