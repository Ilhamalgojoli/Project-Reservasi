@extends('layout.layout')
@php
    $title = 'Kelola Ruang';
@endphp

@push('extra_scripts')
    <script src="{{ asset('assets/js/dynamic-input.js') }}" defer></script>
    <script src="{{ asset('assets/js/tambah-ruang.js') }}" defer></script>
    <script src="{{ asset('assets/js/edit-ruangan.js') }}" defer></script>
@endpush

@section('content')
    <div>
        <div class="flex flex-col animate-slide-up">
            {{-- Header Section --}}
            <div class="flex flex-col border-b border-gray-100 pb-8">
                <h1 class="text-4xl font-black text-gray-800 tracking-tighter leading-none">{{ $title }}</h1>
                <p class="text-[10px] font-medium text-gray-400 uppercase tracking-[0.3em] mt-4 ml-1">Master Inventaris &
                    Unit
                    Ruangan</p>
            </div>

            <main class="grid grid-cols-12 gap-4">
                {{-- Search & Filter Section (Moved to Right) --}}
                <div class="col-span-12 lg:col-span-7 xl:col-span-8 animate-slide-up" style="animation-delay: 200ms">
                    @livewire('admin.filters-ruangan')
                </div>

                {{-- Action Card: Tambah Ruangan (Moved to Left) --}}
                <div class="col-span-12 lg:col-span-5 xl:col-span-4 animate-slide-up" style="animation-delay: 100ms">
                    <div
                        class="h-full bg-white p-8 rounded-[8px] shadow-md shadow-gray-100 relative overflow-hidden group border border-gray-50 flex flex-col">
                        <div class="relative z-10 flex flex-col h-full">
                            <div class="flex items-center gap-4 mb-6">
                                <h2 class="text-xl font-black text-gray-800 tracking-tight leading-tight uppercase">
                                    Tambah<br>Unit Ruangan</h2>
                            </div>

                            <p class="text-gray-400 text-xs font-normal leading-relaxed mb-8 italic">
                                Masukkan detail kode ruang, lantai, dan inventaris fasilitas untuk memperbarui peta
                                reservasi.
                            </p>

                            <div class="mt-auto pt-4">
                                <button data-popup-target="popup-tambah"
                                    class="w-full flex items-center justify-center gap-3 bg-white text-gray-900 border border-gray-100 px-8 py-4 rounded-[20px] font-black text-xs uppercase tracking-[0.15em] shadow-xl shadow-gray-100/50 hover:bg-[#e51411] hover:text-white hover:border-[#e51411] hover:scale-[1.02] active:scale-[0.98] transition-all duration-300">
                                    <iconify-icon icon="solar:add-circle-bold" class="text-xl"></iconify-icon>
                                    <span>TAMBAH SEKARANG</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>


                {{-- Table Section --}}
                <section
                    class="col-span-12 rounded-[8px] bg-white shadow-md shadow-gray-100/50 border border-gray-50 p-8 md:p-10 animate-slide-up"
                    style="animation-delay: 300ms">
                    <div class="flex items-center justify-between mb-8 px-2">
                        <div class="flex items-center gap-3">
                            <h3 class="text-sm font-black uppercase tracking-[0.2em] text-gray-800">Inventaris Ruang</h3>
                        </div>
                    </div>
                    @livewire('admin.table-kelola-ruangan', ['id' => request()->route('id')])
                </section>
            </main>

        </div>

        {{-- Pop Up Edit --}}
        <section id="popup-edit"
            class="popup hidden fixed inset-0 bg-gray-900/80 flex items-center justify-center z-[100] p-4 transition-all duration-500">
            <div
                class="bg-white w-full max-w-2xl rounded-[8px] shadow-[0_32px_64px_-16px_rgba(0,0,0,0.3)] overflow-hidden relative animate-slide-up border border-white/20 flex flex-col max-h-[90vh]">
                {{-- Modal Header --}}
                <div class="p-8 flex items-center justify-between bg-white border-b border-gray-100 shrink-0">
                    <div class="flex items-center gap-4 text-gray-800">
                        <div class="p-3 bg-red-50 rounded-[8px] shadow-sm italic text-[#e51411]">
                            <iconify-icon icon="solar:pen-new-square-bold-duotone" class="text-2xl"></iconify-icon>
                        </div>
                        <div>
                            <h2 class="text-2xl font-black tracking-tight leading-none">Edit Ruangan & Aset</h2>
                            <p class="text-[10px] font-medium text-gray-400 uppercase tracking-[0.2em] mt-2">Sinkronisasi
                                data & inventaris aset ruang</p>
                        </div>
                    </div>
                    <button
                        class="popup-close w-12 h-12 flex items-center justify-center rounded-[8px] bg-gray-50 text-gray-400 border border-gray-100 hover:bg-red-50 hover:text-red-500 transition-all duration-300">
                        <iconify-icon icon="solar:close-circle-bold" class="text-2xl"></iconify-icon>
                    </button>
                </div>

                <div class="p-8 flex flex-col gap-8 flex-1 overflow-y-auto custom-scrollbar">
                    {{-- Section 1: Detail Unit --}}
                    <div class="flex flex-col gap-6">
                        <div class="flex flex-col gap-1">
                            <h3 class="text-xl font-black text-gray-800 tracking-tight">Detail Unit</h3>
                            <div class="w-full border-b border-dashed border-gray-200 mt-2"></div>
                        </div>

                        {{-- Layout Awal: Row-based inputs --}}
                        <div class="grid grid-cols-1 gap-5">
                            <div class="flex lg:flex-row sm:flex-col gap-5">
                                <div class="flex-1 flex flex-col gap-2">
                                    <label
                                        class="text-[11px] font-medium uppercase tracking-widest text-gray-400 ml-1">Identitas
                                        Ruangan</label>
                                    <div class="relative group">
                                        <iconify-icon icon="mdi:office-building-marker"
                                            class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#e51411] transition-colors text-lg"></iconify-icon>
                                        <input type="text" id="idRuangan-edit"
                                            class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-800 focus:bg-white focus:ring-4 focus:ring-[#e51411]/5 focus:border-[#e51411] transition-all outline-none"
                                            placeholder="Kode Ruang" />
                                    </div>
                                </div>
                                <div class="flex-1 flex flex-col gap-2">
                                    <label
                                        class="text-[11px] font-medium uppercase tracking-widest text-gray-400 ml-1">Muatan
                                        Kapasitas</label>
                                    <div class="relative group">
                                        <iconify-icon icon="mdi:account-group"
                                            class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#e51411] transition-colors text-lg"></iconify-icon>
                                        <input type="number" id="kapasitas-edit"
                                            class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-800 focus:bg-white focus:ring-4 focus:ring-[#e51411]/5 focus:border-[#e51411] transition-all outline-none"
                                            placeholder="Kapasitas" />
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col gap-2">
                                <label
                                    class="text-[11px] font-medium uppercase tracking-widest text-gray-400 ml-1">Ketersediaan
                                    / Status</label>
                                <div class="relative group">
                                    <iconify-icon icon="solar:shield-check-bold"
                                        class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#e51411] transition-colors text-lg"></iconify-icon>
                                    <select id="status-edit"
                                        class="w-full pl-11 pr-10 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-800 focus:bg-white focus:ring-4 focus:ring-[#e51411]/5 focus:border-[#e51411] transition-all outline-none cursor-pointer">
                                        <option value="Aktif">Aktif</option>
                                        <option value="Tidak Aktif">Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Section 2: Fasilitas --}}
                    <div class="flex flex-col gap-6">
                        <div class="flex flex-col gap-1">
                            <h3 class="text-xl font-black text-gray-800 tracking-tight">Aset Ruangan</h3>
                            <div class="w-full border-b border-dashed border-gray-200 mt-2"></div>
                        </div>

                        <form id="form-edit" class="flex flex-col gap-5">
                            <div id="wrapper-input-edit" class="flex flex-col gap-4">
                                {{-- Dynamically Inserted Here --}}
                            </div>
                        </form>

                        <div class="flex flex-row justify-center gap-4 pt-2">
                            <button data-button-target="wrapper-input-edit"
                                class="button-add group flex items-center justify-center w-12 h-12 bg-[#e51411] text-white rounded-xl hover:bg-red-700 transition-all shadow-md">
                                <iconify-icon icon="solar:add-circle-bold"
                                    class="text-xl group-hover:rotate-90 transition-transform duration-300"></iconify-icon>
                            </button>
                            <button
                                class="button-less hidden flex items-center justify-center w-12 h-12 bg-gray-100 text-gray-400 rounded-xl hover:bg-red-50 hover:text-red-500 transition-all border border-gray-200">
                                <iconify-icon icon="solar:minus-circle-bold" class="text-xl"></iconify-icon>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Action Footer --}}
                <div class="p-8 bg-gray-50/50 border-t border-gray-100">
                    <div class="flex flex-row gap-4">
                        <button type="button" id="btn-hapus"
                            class="flex items-center justify-center gap-2 px-4 py-3.5 sm:px-8 sm:py-5 bg-gray-100 text-gray-400 rounded-[8px] font-black text-xs uppercase tracking-[0.2em] hover:bg-red-50 hover:text-red-500 transition-all border border-gray-200">
                            <iconify-icon icon="solar:trash-bin-trash-bold" class="text-xl"></iconify-icon>
                            Hapus
                        </button>
                        <button type="button" id="btn-submit"
                            class="flex-1 flex items-center justify-center gap-3 px-6 py-3.5 sm:px-12 sm:py-5 bg-[#e51411] text-white rounded-[8px] font-black text-xs uppercase tracking-[0.25em] hover:bg-red-700 hover:-translate-y-1 transition-all shadow-xl">
                            <iconify-icon icon="solar:diskette-bold" class="text-xl"></iconify-icon>
                            UPDATE DATA
                        </button>
                    </div>
                </div>
            </div>
        </section>

        {{-- Pop Up Tambah --}}
        <section id="popup-tambah"
            class="popup hidden fixed inset-0 bg-gray-900/80 flex items-center justify-center z-[100] p-4 transition-all duration-500">
            <div
                class="bg-white w-full max-w-2xl rounded-[8px] shadow-[0_32px_64px_-16px_rgba(0,0,0,0.3)] overflow-hidden relative animate-slide-up border border-white/20 flex flex-col max-h-[90vh]">
                {{-- Modal Header --}}
                <div class="p-8 flex items-center justify-between bg-white border-b border-gray-100 shrink-0">
                    <div class="flex items-center gap-4 text-gray-800">
                        <div class="p-3 bg-red-50 rounded-[8px] shadow-sm italic text-[#e51411]">
                            <iconify-icon icon="solar:home-add-bold-duotone" class="text-2xl"></iconify-icon>
                        </div>
                        <div>
                            <h2 class="text-2xl font-black tracking-tight leading-none">Tambah Ruangan & Aset ruangan
                            </h2>
                            <p class="text-[10px] font-medium text-gray-400 uppercase tracking-[0.2em] mt-2">Daftarkan unit
                                ruangan baru</p>
                        </div>
                    </div>
                    <button
                        class="popup-close w-12 h-12 flex items-center justify-center rounded-[8px] bg-gray-50 text-gray-400 border border-gray-100 hover:bg-red-50 hover:text-red-500 transition-all duration-300">
                        <iconify-icon icon="solar:close-circle-bold" class="text-2xl"></iconify-icon>
                    </button>
                </div>

                <div class="p-8 flex flex-col gap-8 flex-1 overflow-y-auto custom-scrollbar">
                    {{-- Section 1: Parameter Ruangan --}}
                    <div class="flex flex-col gap-6">
                        <div class="flex flex-col gap-1">
                            <h3 class="text-xl font-black text-gray-800 tracking-tight">Detail Unit Baru</h3>
                            <div class="w-full border-b border-dashed border-gray-200 mt-2"></div>
                        </div>

                        <div class="grid lg:grid-cols-1 gap-5">
                            <div class="flex lg:flex-row sm:flex-col gap-5">
                                <div class="flex-1 flex flex-col gap-2">
                                    <label
                                        class="text-[11px] font-medium uppercase tracking-widest text-gray-400 ml-1">Penempatan
                                        Lantai</label>
                                    <div class="relative group">
                                        <iconify-icon icon="mdi:stairs"
                                            class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#e51411] transition-colors text-lg"></iconify-icon>
                                        <select id="lantai"
                                            class="w-full pl-11 pr-10 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-800 focus:bg-white focus:ring-4 focus:ring-[#e51411]/5 focus:border-[#e51411] transition-all outline-none cursor-pointer">
                                            <option value="" disabled selected>Pilih Lantai</option>
                                            @foreach ($lantais as $lantai)
                                                <option value="{{ $lantai['id'] }}">Lantai {{ $lantai['lantai'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="flex-1 flex flex-col gap-2">
                                    <label
                                        class="text-[11px] font-medium uppercase tracking-widest text-gray-400 ml-1">Identitas
                                        / Kode</label>
                                    <div class="relative group">
                                        <iconify-icon icon="mdi:office-building-marker"
                                            class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#e51411] transition-colors text-lg"></iconify-icon>
                                        <input type="text" id="idRuangan"
                                            class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-800 focus:bg-white focus:ring-4 focus:ring-[#e51411]/5 focus:border-[#e51411] transition-all outline-none"
                                            placeholder="Kode Ruangan" />
                                    </div>
                                </div>
                            </div>

                            <div class="flex lg:flex-row sm:flex-col gap-5">
                                <div class="flex-1 flex flex-col gap-2">
                                    <label
                                        class="text-[11px] font-medium uppercase tracking-widest text-gray-400 ml-1">Ketersediaan</label>
                                    <div class="relative group">
                                        <iconify-icon icon="solar:shield-check-bold"
                                            class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#e51411] transition-colors text-lg"></iconify-icon>
                                        <select id="status"
                                            class="w-full pl-11 pr-10 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-800 focus:bg-white focus:ring-4 focus:ring-[#e51411]/5 focus:border-[#e51411] transition-all outline-none">
                                            <option value="Aktif">Aktif</option>
                                            <option value="Tidak Aktif">Tidak Aktif</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="flex-1 flex flex-col gap-2">
                                    <label
                                        class="text-[11px] font-medium uppercase tracking-widest text-gray-400 ml-1">Muatan
                                        Kapasitas</label>
                                    <div class="relative group">
                                        <iconify-icon icon="mdi:account-group"
                                            class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#e51411] transition-colors text-lg"></iconify-icon>
                                        <input type="number" id="kapasitas"
                                            class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-800 focus:bg-white focus:ring-4 focus:ring-[#e51411]/5 focus:border-[#e51411] transition-all outline-none"
                                            placeholder="Kapasitas" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Section 2: Fasilitas --}}
                    <div class="flex flex-col gap-6">
                        <div class="flex flex-col gap-1">
                            <h3 class="text-xl font-black text-gray-800 tracking-tight">Aset Ruangan</h3>
                            <div class="w-full border-b border-dashed border-gray-200 mt-2"></div>
                        </div>

                        <form id="form-asset" class="flex flex-col gap-5">
                            <div id="wrapper-input-tambah" class="flex flex-col gap-4">
                                <div class="flex flex-row sm:flex-col gap-5">
                                    <div class="flex-[1.5] relative group">
                                        <iconify-icon icon="solar:box-minimalistic-bold"
                                            class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#e51411] transition-colors text-lg"></iconify-icon>
                                        <input type="text" name="nama_asset[]" placeholder="Nama Barang"
                                            class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-800 focus:bg-white focus:ring-4 focus:ring-[#e51411]/5 focus:border-[#e51411] transition-all outline-none" />
                                    </div>
                                    <div class="flex-1 relative group">
                                        <iconify-icon icon="solar:database-bold-duotone"
                                            class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#e51411] transition-colors text-lg"></iconify-icon>
                                        <input type="number" name="total_asset[]" placeholder="Jumlah Asset"
                                            class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-800 focus:bg-white focus:ring-4 focus:ring-[#e51411]/5 focus:border-[#e51411] transition-all outline-none" />
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="flex flex-row justify-center gap-4 pt-2">
                            <button data-button-target="wrapper-input-tambah"
                                class="group flex items-center justify-center w-12 h-12 bg-[#e51411] text-white rounded-xl hover:bg-red-700 transition-all shadow-xl shadow-red-900/20 border border-red-400/20">
                                <iconify-icon icon="solar:add-circle-bold"
                                    class="text-xl group-hover:rotate-90 transition-transform duration-300"></iconify-icon>
                            </button>
                            <button
                                class="button-less hidden flex items-center justify-center w-12 h-12 bg-gray-100 text-gray-400 rounded-xl hover:bg-red-50 hover:text-red-500 transition-all border border-gray-200">
                                <iconify-icon icon="solar:minus-circle-bold" class="text-xl"></iconify-icon>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Action Footer --}}
                <div class="p-8 bg-gray-50/50 border-t border-gray-100 shrink-0">
                    <button type="button" id="btn-submit-tambah"
                        class="w-full flex items-center justify-center gap-3 px-12 py-5 bg-[#e51411] text-white rounded-[8px] font-black text-xs uppercase tracking-[0.25em] hover:bg-red-700 hover:-translate-y-1 transition-all shadow-xl">
                        <iconify-icon icon="solar:check-circle-bold" class="text-xl"></iconify-icon>
                        KONFIRMASI REGISTRASI
                    </button>
                </div>
            </div>
        </section>
    </div>

    <script>
        const routes = {
            storeData: "{{ route('tambah.ruang') }}",
            updateData: "{{ route('update.ruang') }}"
        };

        document.addEventListener('DOMContentLoaded', () => {
            // Handle Pop-ups
            const openPopupBtns = document.querySelectorAll('[data-popup-target]');
            const closePopupBtns = document.querySelectorAll('.popup-close');
            const popups = document.querySelectorAll('.popup');

            openPopupBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    const targetId = btn.getAttribute('data-popup-target');
                    const popup = document.getElementById(targetId);
                    if (popup) {
                        popup.classList.remove('hidden');
                    }
                });
            });

            closePopupBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    const popup = btn.closest('.popup');
                    if (popup) {
                        popup.classList.add('hidden');
                    }
                });
            });

            popups.forEach(popup => {
                popup.addEventListener('click', (e) => {
                    if (e.target === popup) {
                        popup.classList.add('hidden');
                    }
                });
            });
        });
    </script>
@endsection
