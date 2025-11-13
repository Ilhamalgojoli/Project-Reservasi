@extends('layout.layout')
@php
    $title = 'Reservasi Ruangan';
    $script = '';
@endphp

@section('content')
    <div class="mb-5">
        <h1 class="font-bold text-2xl">{{ $title }}</h1>
    </div>

    <main class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-5">
        <!-- Card One -->
        <section class="bg-[#ffffff] text-black rounded-xl py-2 px-2
                shadow-lg space-x-4 flex justify-start">
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
                <a href="{{ route('index3') }}"
                    class="bg-[#FF0101] text-[#FFFFFF] px-16 py-2 rounded-xl flex justify-center transition-all duration-300 hover:scale-105">
                    <iconify-icon icon="typcn:plus" style="font-size:32px;" />
                </a>
            </div>
        </section>
        <!-- Card Two -->
        <section class="bg-[#ffffff] text-black rounded-xl py-2 px-2
                shadow-lg space-x-4 flex justify-start">
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
                <a href="{{ route('index3') }}"
                    class="bg-[#FF0101] text-[#FFFFFF] px-16 py-2 rounded-xl flex justify-center transition-all duration-300 hover:scale-105">
                    <iconify-icon icon="typcn:plus" style="font-size:32px;" />
                </a>
            </div>
        </section>
        <!-- Card Three -->
        <section class="bg-[#ffffff] text-black rounded-xl py-2 px-2
                shadow-lg space-x-4 flex justify-start">
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
                <a href="{{ route('index3') }}"
                    class="bg-[#FF0101] text-[#FFFFFF] px-16 py-2 rounded-xl flex justify-center transition-all duration-300 hover:scale-105">
                    <iconify-icon icon="typcn:plus" style="font-size:32px;" />
                </a>
            </div>
        </section>
    </main>
@endsection
