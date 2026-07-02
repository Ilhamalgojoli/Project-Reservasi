@extends('layout.layout')
@php
    $title = 'Peminjaman Ruangan';
@endphp

@section('content')
    {{-- Breadcrumbs & Header --}}
    <div class="mb-5 flex flex-col items-start gap-1">
        <div class="flex items-center gap-2 text-[10px] font-black text-[#e51411] uppercase tracking-[0.2em] mb-1">
            <a href="{{ route('index') }}" class="hover:text-red-700 transition-colors text-gray-400">Dashboard</a>
            <span class="text-gray-200">/</span>
            <a href="{{ route('index2') }}" class="hover:text-red-700 transition-colors text-gray-400">Gedung</a>
            <span class="text-gray-200">/</span>
            <span class="text-[#e51411]">Reservasi</span>
        </div>
        <h1 class="text-4xl font-black text-gray-900 tracking-tight">{{ $title }}</h1>
        <p class="text-sm text-gray-400 font-medium max-w-2xl mt-1">
            Pilih ruangan dan atur jadwal peminjaman Anda dengan lebih mudah dan cepat.
        </p>
    </div>

    <main class="grid lg:grid-cols-12 md:grid-cols-1 sm:grid-cols-1 gap-4">
        <div class="lg:col-span-7 flex flex-col gap-4">
            @livewire('user.peminjaman', ['id' => request()->route('id')])
            
            <div class="transition-all duration-500">
                @livewire('user.map-peminjaman', ['id' => request()->route('id')])
            </div>
        </div>

        <section class="lg:col-span-5 flex flex-col gap-4">
            <div class="transition-all duration-500">
                @livewire('user.view-asset')
            </div>

            <div class="transition-all duration-500">
                @livewire('user.kapasitas-ruangan-sidebar', ['id' => request()->route('id')])
            </div>
            
            <div class="transition-all duration-500">
                @livewire('user.peminjaman-per-ruangan')
            </div>
        </section>
    </main>
@endsection
