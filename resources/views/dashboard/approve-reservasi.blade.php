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
        <section class="col-span-12 rounded-[8px] bg-white shadow-md p-8">
            <div class="flex flex-col gap-2 mb-12">
                <h1 class="text-2xl">Persetujuan Peminjaman</h1>
                <div class="w-50 border"></div>
                <p class="text-[#BDBDBD]">Filter data peminjaman ruangan</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-4 md:grid-cols-4 lg:grid-cols-1 gap-10 mb-5">
                <div class="flex flex-row gap-10 sm:gap-4 sm:flex-col md:flex-col lg:flex-row">
                    <select class="rounded-xl flex-1 text-[#808080] py-2 px-3 appearance-none
                                bg-transparent border border-[#808080] border-opacity-50">
                        <option value="" disabled selected>Jenis Peminjaman</option>
                        <option value="akademik">Akademik</option>
                        <option value="non-akademik">Non Akademik</option>
                    </select>
                    <select class="rounded-xl flex-1 text-[#808080] py-2 px-3 appearance-none
                                bg-transparent border border-[#808080] border-opacity-50">
                        <option value="" disabled selected>Gedung</option>
                        <option value="akademik">GKU</option>
                        <option value="non-akademik">FIT</option>
                    </select>
                </div>
                <div class="flex flex-row gap-10 sm:gap-4 sm:flex-col md:flex-col lg:flex-row">
                    <select class="rounded-xl sm:w-auto md:w-auto lg:w-[728px] text-[#808080] py-2 px-3 appearance-none
                                bg-transparent border border-[#808080] border-opacity-50">
                        <option value="" disabled selected>Lantai</option>
                        <option value="akademik">GKU.04</option>
                        <option value="non-akademik">FIT.02</option>
                    </select>
                    <button class="bg-[#FF0000] px-12 rounded-lg w-[250px]
                        transition-all duration-300 hover:scale-105 sm:py-2 py-2 font-bold text-xl">
                        Filter
                    </button>
                </div>
            </div>
        </section>
        <section class="col-span-12 rounded-[8px] bg-white shadow-md p-8">
            @livewire('approve-reject-booking')
        </section>
    </main>
@endsection