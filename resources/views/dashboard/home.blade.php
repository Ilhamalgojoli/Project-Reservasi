@extends('layout.layout')

@php
    $title = 'Dashboard';
    $script = '
            <script src="' . asset('assets/js/data-table.js') . '" defer></script>
            <script src="' . asset('assets/js/basilaChart.js') . '"></script>
        ';
@endphp

@section('content')
    <div class="lg:col-span-12 2xl:col-span-8 mb-5">
        <h1 class="font-bold text-2xl">{{ $title }}</h1>
    </div>

    <main class="w-full h-auto space-y-5 mb-5">
        <section class="grid lg:grid-cols-12 sm:grid-cols-1 md:grid-cols-2 gap-5">
            @livewire('home')
            <div class="lg:col-span-4 md:col-span-12 sm:col-span-12 space-y-5 ">
                @livewire('kegiatan-terkini')
                @livewire('aktif-tidak-aktif-ruangan')
        </section>
        <section class="grid grid-cols-12">
            @livewire('okkupansi-ruangan')
        </section>
        <section class="grid grid-cols-12">
            <div class="col-span-12">
                <div class="bg-white p-5 rounded-[8px] flex flex-col shadow-md gap-5">
                    @livewire('monitorDashboard')
                </div>
            </div>
        </section>
    </main>
@endsection