@extends('layout.layout')
@php
    $title = 'Kelola Persetujuan Peminjaman';
@endphp

@push('extra_scripts')
    <script src="{{ asset('assets/js/popup.js') }}" defer></script>
@endpush

@section('content')
    <div class="mb-5 flex flex-col gap-2">
        <h1 class="font-extrabold text-3xl text-gray-800 tracking-tight">{{ $title }}</h1>
        <p class="text-gray-400 text-sm font-medium">Daftar peminjaman ruangan yang perlu disetujui</p>
    </div>

    <main class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 3xl:grid-cols-5 gap-6">
        {{-- <section class="col-span-12 rounded-[8px] bg-white shadow-md p-8">
            <div class="flex flex-col gap-2 mb-12">
                <h1 class="text-2xl">Filter data peminjaman ruangan</h1>
                <div class="w-50 border"></div>
            </div>
        </section> --}}
        <section class="col-span-12 rounded-[8px] bg-white shadow-md p-8">
            @livewire('admin.approve-reject-booking')
        </section>
    </main>
@endsection