@extends('layout.layout')
@php
    $title = 'Peminjaman Ruangan';

    $script = ' ';
@endphp

@section('content')
    <h1 class="text-2xl font-bold mb-5">{{ $title }}</h1>

    <div class="grid grid-cols-1 md:grid-cols-4 sm:grid-cols-4 gap-6">
        <div class="col-span-12 bg-white p-10 rounded-2xl">
            <div class="flex flex-col gap-8">
                <div class="flex flex-col gap-2 pb-8 mb-8">
                    <h1 class="font-bold text-2xl">Gedung Gku</h1>
                    <div class="w-50 border"></div>
                    <p class="text-[#8B8B8B] text-md">Pastikan data yang dipilih telah sesuai
                        untuk menampilkan data ruangan 😄</p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-4 md:grid-cols-4 lg:grid-cols-1 gap-10">
                    <div class="flex flex-row gap-10 sm:gap-5 sm:flex-col md:flex-col lg:flex-row">
                        <div class="flex flex-col flex-1 gap-5">
                            <h1 class="text-lg font-normal">Jenis Peminjaman</h1>
                            <select class="rounded-xl"></select>
                        </div>
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
            </div>
        </div>
    </div>
@endsection
