@extends('layout.layout')
@php
    $title = 'Peminjaman Ruangan';

    $script = '';
@endphp

@section('content')
    <h1 class="text-2xl font-bold mb-5">{{ $title }}</h1>

    <main class="grid lg:grid-cols-12 md:grid-cols-1 sm:grid-cols-1 gap-6">
        @livewire('peminjaman', ['id' => request()->route('id')])
        <section class="col-span-5 space-y-5">
            @livewire('view-asset')
            @livewire('map-peminjaman')
        </section>
    </main>
@endsection