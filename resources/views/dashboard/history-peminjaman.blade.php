@extends('layout.layout')
@php
    $title = 'History peminjaman';
@endphp

@section('content')
    <div class="mb-5 flex flex-col gap-2">
        <h1 class="font-extrabold text-3xl text-gray-800 tracking-tight">{{ $title }}</h1>
        <p class="text-gray-400 text-sm font-medium">Riwayat peminjaman ruangan</p>
    </div>

    <main class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 3xl:grid-cols-5 gap-6">
        <section class="col-span-12 rounded-[8px] bg-white shadow-md p-8">
            @if (session('role_name') === 'MAHASISWA' && 'DOSEN')
                @livewire('history-peminjaman-user')
            @endif
            @if (session('role_name') === 'SUPERADMIN')
                @livewire('history-peminjaman-admin')
            @endif
        </section>
    </main>
@endsection
