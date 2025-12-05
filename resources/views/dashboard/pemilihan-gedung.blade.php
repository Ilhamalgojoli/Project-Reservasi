@extends('layout.layout')
@php
    $title = 'Reservasi Ruangan';
    $script = '
        <script src="' . asset('assets/js/hover-card.js') . '" defer></script>
    ';
@endphp

@section('content')
    <div class="mb-5">
        <h1 class="font-bold text-2xl">{{ $title }}</h1>
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
                        </div>
                        <p class=
                               "text-[#8B8B8B] text-md">
                            надвигается туман, надвигается туман, помоги мне, позволь ему помочь тебе, кожа
                            на моем теле ослабевает, я хочу ее снять, я чувствую, как растут новые конечности, это
                            больно,
                            ...</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
