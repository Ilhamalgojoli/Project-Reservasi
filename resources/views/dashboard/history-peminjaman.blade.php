@extends('layout.layout')
@php
    $title = 'History peminjaman';
    $script = '
        <script src="' . asset('assets/js/data-table.js') . '" defer></script>
        <script src="' . asset('assets/js/approve-reject.js') . '" defer></script>  
    ';
@endphp

@section('content')
    <h1 class="text-2xl mb-5 font-bold">{{ $title }}</h1>

    <main class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 3xl:grid-cols-5 gap-6">
        <section class="col-span-12 rounded-[8px] bg-white shadow-md p-8">
            @livewire('history-peminjaman')
        </section>
    </main>
@endsection