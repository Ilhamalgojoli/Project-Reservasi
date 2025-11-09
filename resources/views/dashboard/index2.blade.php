@extends('layout.layout')
@php
    $title='Reservasi Ruangan';
    $script = '';
@endphp

@section('content')
    <div class="mb-5">
        <h1 class="font-bold text-2xl">{{ $title }}</h1>
    </div>


    <div class="flex flex-col gap-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="col-span-2 bg-[#ffffff] text-black rounded-xl py-8 px-10
            shadow-lg space-x-4 flex justify-start">
                <div class="flex flex-col justify-center items-center gap-5">
                    <div class="flex flex-col gap-2">
                        <div class="flex flex-row gap-10 items-center">
                            <img src="{{ asset("/assets/icon/black-building.png") }}" class="w-8"/>
                            <h2 class="text-2xl text-black font-bold leading-tight pt-4">Nama Gedung</h2>
                        </div>
                        <p class=
                               "text-xl text-[#8B8B8B] pl-[74px]">
                            надвигается туман, надвигается туман, помоги мне, позволь ему помочь тебе, кожа
                            на моем теле ослабевает, я хочу ее снять, я чувствую, как растут новые конечности, это
                            больно,
                            ...</p>
                    </div>
                    <a href="#" class="bg-[#FF0101] text-[#FFFFFF] px-16 py-2 rounded-xl flex justify-center">
                        <iconify-icon icon="typcn:plus" style="font-size:32px;"/>
                    </a>
                </div>
            </div>

            <div class="col-span-2 bg-[#ffffff] text-black rounded-xl py-8 px-10
            shadow-lg space-x-4 flex justify-start">
                <div class="flex flex-col justify-center items-center gap-5">
                    <div class="flex flex-col gap-2">
                        <div class="flex flex-row gap-10 items-center">
                            <img src="{{ asset("/assets/icon/black-building.png") }}" class="w-8"/>
                            <h2 class="text-2xl text-black font-bold leading-tight pt-4">Nama Gedung</h2>
                        </div>
                        <p class=
                               "text-xl text-[#8B8B8B] pl-[74px]">
                            надвигается туман, надвигается туман, помоги мне, позволь ему помочь тебе, кожа
                            на моем теле ослабевает, я хочу ее снять, я чувствую, как растут новые конечности, это
                            больно,
                            ...</p>
                    </div>
                    <a href="#" class="bg-[#FF0101] text-[#FFFFFF] px-16 py-2 rounded-xl flex justify-center">
                        <iconify-icon icon="typcn:plus" style="font-size:32px;"/>
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="col-span-2 bg-[#ffffff] text-black rounded-xl py-8 px-10
            shadow-lg space-x-4 flex justify-start">
                <div class="flex flex-col justify-center items-center gap-5">
                    <div class="flex flex-col gap-2">
                        <div class="flex flex-row gap-10 items-center">
                            <img src="{{ asset("/assets/icon/black-building.png") }}" class="w-8"/>
                            <h2 class="text-2xl text-black font-bold leading-tight pt-4">Nama Gedung</h2>
                        </div>
                        <p class=
                               "text-xl text-[#8B8B8B] pl-[74px]">
                            надвигается туман, надвигается туман, помоги мне, позволь ему помочь тебе, кожа
                            на моем теле ослабевает, я хочу ее снять, я чувствую, как растут новые конечности, это
                            больно,
                            ...</p>
                    </div>
                    <a href="#" class="bg-[#FF0101] text-[#FFFFFF] px-16 py-2 rounded-xl flex justify-center">
                        <iconify-icon icon="typcn:plus" style="font-size:32px;"/>
                    </a>
                </div>
            </div>

            <div class="col-span-2 bg-[#ffffff] text-black rounded-xl py-8 px-10
            shadow-lg space-x-4 flex justify-start">
                <div class="flex flex-col justify-center items-center gap-5">
                    <div class="flex flex-col gap-2">
                        <div class="flex flex-row gap-10 items-center">
                            <img src="{{ asset("/assets/icon/black-building.png") }}" class="w-8"/>
                            <h2 class="text-2xl text-black font-bold leading-tight pt-4">Nama Gedung</h2>
                        </div>
                        <p class=
                               "text-xl text-[#8B8B8B] pl-[74px]">
                            надвигается туман, надвигается туман, помоги мне, позволь ему помочь тебе, кожа
                            на моем теле ослабевает, я хочу ее снять, я чувствую, как растут новые конечности, это
                            больно,
                            ...</p>
                    </div>
                    <a href="#" class="bg-[#FF0101] text-[#FFFFFF] px-16 py-2 rounded-xl flex justify-center">
                        <iconify-icon icon="typcn:plus" style="font-size:32px;"/>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
