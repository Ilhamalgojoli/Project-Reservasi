@extends('layout.layout')
@php
    $title = 'Reservasi Ruangan';
@endphp

@push('extra_scripts')
    <script src="{{ asset('assets/js/hover-card.js') }}" defer></script>
@endpush

@section('content')
    <div class="mb-5 flex flex-col gap-2">
        <h1 class="font-extrabold text-3xl text-gray-800 tracking-tight">{{ $title }}</h1>
        <p class="text-gray-400 text-sm font-medium">Pilih gedung tujuan untuk melihat ketersediaan ruangan</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10 mb-10">
        @foreach ($datas as $data)
            <div class="group relative bg-white rounded-2xl shadow-sm hover:shadow-2xl transition-all duration-500 overflow-hidden flex flex-col border border-gray-100 h-full">
                
                {{-- Building Image & Hover Overlay --}}
                <div class="relative h-64 overflow-hidden">
                    <img src="{{ $data['gambar'] ? asset('storage/' . $data['gambar']) : asset('assets/basila_images/DefaultBuilding.png') }}"
                        alt="{{ $data['nama_gedung'] }}"
                        class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-110" />
                    
                    {{-- Gradient Overlay (Mobile always, Desktop hover) --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-100 lg:opacity-0 lg:group-hover:opacity-100 transition-opacity duration-500 z-10"></div>
                    
                    {{-- Action Button --}}
                    <div class="absolute inset-0 flex items-center justify-center translate-y-10 lg:translate-y-20 lg:group-hover:translate-y-0 opacity-100 lg:opacity-0 lg:group-hover:opacity-100 transition-all duration-500 z-20">
                        <a href="{{ route('pilih-ruang', ['id' => $data['id']]) }}"
                            class="flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-[#e51411] to-[#ff413d] text-white rounded-full font-bold shadow-xl hover:shadow-red-500/50 hover:scale-105 transition-all active:scale-95">
                            <iconify-icon icon="solar:globus-bold" class="text-xl"></iconify-icon>
                            <span>Pilih Gedung</span>
                        </a>
                    </div>

                    {{-- Status Badge (Optional top-right) --}}
                    <div class="absolute top-4 right-4 z-20">
                        <span class="bg-white text-emerald-600 text-[10px] font-extrabold px-3 py-1 rounded-full shadow-sm flex items-center gap-1 uppercase tracking-tighter border border-emerald-100">
                             <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                             Tersedia
                        </span>
                    </div>
                </div>

                {{-- Building Info Section --}}
                <div class="p-6 flex flex-col flex-1 gap-3">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex flex-col gap-1">
                            <h2 class="text-xl font-extrabold text-gray-800 leading-tight group-hover:text-[#e51411] transition-colors">
                                {{ $data['nama_gedung'] }}
                            </h2>
                            <div class="flex items-center gap-1.5 text-gray-400 text-xs font-semibold">
                                <iconify-icon icon="solar:map-point-bold" class="text-[#e51411]"></iconify-icon>
                                <span>Area Kampus Utama</span>
                            </div>
                        </div>
                        <div class="flex flex-col items-end">
                            <span class="text-[10px] uppercase font-bold text-gray-300 tracking-widest leading-none mb-1">ID</span>
                            <span class="text-xs font-black text-gray-400">#GD-0{{ $data['id'] }}</span>
                        </div>
                    </div>
                    
                    <div class="w-10 h-1 bg-gray-100 group-hover:w-20 group-hover:bg-[#e51411] transition-all duration-500 rounded-full"></div>

                    <p class="text-gray-500 text-sm leading-relaxed line-clamp-2 italic">
                        {{ $data['keterangan'] ?: 'Gedung ini merupakan fasilitas akademik yang mendukung kegiatan belajar mengajar.' }}
                    </p>
                </div>
            </div>
        @endforeach
    </div>
@endsection
