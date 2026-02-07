@extends('layout.layout')
@php
    $title = 'Peminjaman Ruangan';

    $script = '
        <script src="' . asset('assets/js/option-reservasi.js') . '" defer></script>
        <script src="' . asset('assets/js/pemilihan-jam.js') . '" defer></script>
        <script src="' . asset('assets/js/peminjaman.js') . '" defer></script>
    ';
@endphp

@section('content')
    <h1 class="text-2xl font-bold mb-5">{{ $title }}</h1>

    <main class="grid lg:grid-cols-12 md:grid-cols-1 sm:grid-cols-1 gap-6">
        @livewire('peminjaman', ['id' => request()->route('id')])
        <section class="col-span-5 space-y-5">
            <div class="bg-white shadow-md p-5 rounded-lg">
                <h1 class="text-2xl font-bold mb-2">Asset Ruangan</h1>
                <ul id="asset-ruangan" class="flex flex-col gap-3 text-black">

                </ul>
            </div>
            <div class="bg-white shadow-md p-5 rounded-lg">
                <h1 class="text-2xl font-bold">Place Holder</h1>
            </div>
        </section>
    </main>
    <script>
        routes = {
            storeData: "{{ route('store.pinjamRuang') }}"
        };
    </script>
@endsection