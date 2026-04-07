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
        {{-- <section class="col-span-12 rounded-[8px] bg-white shadow-md p-8">
            <div class="flex flex-col gap-2 mb-12">
                <h1 class="text-2xl">Filter data peminjaman ruangan</h1>
                <div class="w-50 border"></div>
            </div>
        </section> --}}
        <section class="col-span-12 rounded-[8px] bg-white shadow-md p-8">
            @livewire('approve-reject-booking')
        </section>
    </main>
@endsection