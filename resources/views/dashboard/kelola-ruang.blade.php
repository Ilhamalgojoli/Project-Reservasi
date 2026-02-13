@extends('layout.layout')
@php
    $title = 'Kelola Ruang';
    $script = '
            <script src="' . asset('assets/js/data-table.js') . '" defer></script>
            <script src="' . asset('assets/js/popup.js') . '" defer></script>
            <script src="' . asset('assets/js/dynamic-input.js') . '" defer></script>
            <script src="' . asset('assets/js/tambah-ruang.js') . '" defer></script>
            <script src="' . asset('assets/js/edit-ruangan.js') . '" defer></script>
        ';
@endphp

@section('content')
    <h1 class="text-2xl mb-5 font-bold">{{ $title }}</h1>

    <main class="grid sm:grid-cols-1 md:grid-cols-1">
        <!-- Section One -->
        <section class="grid grid-col-2 lg:grid-cols-2 sm:grid-cols-1 md:grid-cols-1 gap-5 justify-between mb-5">
            <div class="col-span-1 md:col-span-2 bg-white shadow-md p-5 rounded-[8px]">
                <div class="flex flex-col gap-2 pb-8 mb-8">
                    <h1 class="font-bold text-2xl">Filter Ruangan</h1>
                    <div class="w-50 border"></div>
                    <p class="text-[#8B8B8B] text-md">Pastikan data yang dipilih telah sesuai
                        untuk menampilkan data ruangan 😄</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-4 md:grid-cols-4 lg:grid-cols-1 gap-10 mb-8">
                    <div class="flex flex-row gap-10 sm:gap-4 sm:flex-col md:flex-col lg:flex-row">
                        <select class="rounded-md flex-1 text-[#000000] py-2 px-3 appearance-none
                                bg-transparent border border-[#808080] border-opacity-50">
                            <option value="" disabled selected>Lantai</option>
                            <option value="akademik">GKU.04</option>
                            <option value="non-akademik">FIT.02</option>
                        </select>
                        <select class="rounded-md flex-1 text-[#000000] py-2 px-3 appearance-none
                                bg-transparent border border-[#808080] border-opacity-50">
                            <option value="" disabled selected>Ruangan</option>
                            <option value="akademik">GKU.04.14</option>
                            <option value="non-akademik">FIT.02.15</option>
                        </select>
                    </div>
                </div>

                <div>
                    <button class="bg-[#ff0000ce] rounded-lg w-[150px] py-2 text-xl font-extrabold">
                        Filter
                    </button>
                </div>
            </div>
            <div class="col-span-1 md:col-span-2 bg-white shadow-md p-5 rounded-[8px]">
                <div class="flex flex-col gap-2 pb-8 mb-8">
                    <p class="text-2xl font-extrabold">Tambah Ruangan</h1>
                    <div class="w-50 border"></div>
                    <p class="text-[#8B8B8B] text-md">Tambah ruang sesuai Gedung yang dipilih 😋</p>
                </div>
                <div class="flex items-center justify-center">
                    <button data-popup-target="popup-tambah" class="bg-[#ff0000ce] rounded-lg px-5 py-2 font-extrabold">
                        Tambah Ruangan +
                    </button>
                </div>
            </div>
        </section>
        <!-- Section Two -->
        <section class="col-span-12 rounded-[8px] bg-white shadow-md p-8">
            @livewire('table-kelola-ruangan', ['id' => request()->route('id')])
        </section>

        <!-- Pop Up Edit -->
        <section id="popup-edit"
            class="popup hidden fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-xl shadow-lg overflow-y-auto relative w-[900px]">
                <div class="flex flex-row justify-between mb-10">
                    <p></p>
                    <h1 class="text-2xl font-bold">Edit Fasilitas Ruangan</h1>
                    <button class="popup-close">
                        <img src="{{ asset('assets/icon/cross.svg') }}" class="" />
                    </button>
                </div>
                <div class="flex flex-col sm:flex-col gap-5">
                    <div class="flex flex-col gap-5">
                        <div class="flex flex-col gap-1">
                            <h1 class="text-2xl">Ruangan</h1>
                            <div class="w-50 border border-dashed border-black border-opacity-25"></div>
                        </div>
                        <div class="flex flex-row gap-5">
                            <input type="text" id="idRuangan-edit" class="rounded-lg flex-1 py-2 px-3 border text-black
                                  border-[#808080] border-opacity-50" placeholder="Kode Ruangan" />
                            <input type="text" id="kapasitas-edit" class="rounded-lg flex-1 py-2 px-3 border text-black
                                  border-[#808080] border-opacity-50" placeholder="Muatan Kapasitas" />
                        </div>
                        <select id="status-edit" class="rounded-md w-[416px] text-[#000000] py-2 px-3 appearance-none
                                    bg-transparent border border-[#808080] border-opacity-50">
                            <option value="" disabled selected>Status</option>
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="flex flex-col gap-5">
                        <div class="flex flex-col gap-1">
                            <h1 class="text-2xl">Fasilitas</h1>
                            <div class="w-50 border border-dashed border-black border-opacity-25"></div>
                        </div>
                        <form id="form-edit">
                            <div id="wrapper-input-edit" class="flex flex-col gap-5">
                                <div class="wrapper flex flex-row gap-5">

                                </div>
                            </div>
                        </form>
                        <div class="flex justify-center flex-row gap-5">
                            <button data-button-target="wrapper-input-edit"
                                class="button-add border rounded-lg flex items-center p-2 bg-[red]">
                                <iconify-icon icon="mingcute:plus-fill"
                                    class="text-3xl sm:text-sm text-white"></iconify-icon>
                            </button>
                            <button class="button-less border rounded-lg flex items-center p-2 hidden bg-[red]">
                                <iconify-icon icon="typcn:minus" class="text-3xl sm:text-sm text-white"></iconify-icon>
                            </button>
                        </div>
                    </div>
                    <div class="flex flex-row gap-5 justify-center">
                        <button type="button" id="btn-hapus"
                            class="w-auto text-white bg-[red] py-3 px-3 rounded-xl font-extrabold">
                            Hapus
                        </button>
                        <button type="button" id="btn-submit"
                            class="w-auto text-white bg-[red] py-3 px-3 rounded-xl font-extrabold">
                            Submit
                        </button>
                    </div>

                </div>
            </div>
        </section>

        <!-- Pop Up Tambah -->
        <section id="popup-tambah"
            class="popup hidden fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-xl shadow-lg overflow-y-auto relative w-[900px]">
                <div class="flex flex-row justify-between mb-10">
                    <p></p>
                    <h1 class="text-2xl font-bold">Tambah Ruangan</h1>
                    <button class="popup-close">
                        <img src="{{ asset('assets/icon/cross.svg') }}" class="" />
                    </button>
                </div>
                <div class="flex flex-col sm:flex-col gap-5">
                    <div class="flex flex-col gap-5">
                        <div class="flex flex-col gap-1">
                            <h1 class="text-2xl">Ruangan</h1>
                            <div class="w-50 border border-dashed border-black border-opacity-25"></div>
                        </div>
                        <div class="flex flex-row gap-5">
                            <select id="lantai" class="rounded-md w-[416px] text-[#000000] py-2 px-3 appearance-none
                                    bg-transparent border border-[#808080] border-opacity-50">
                                <option value="" disabled selected>Lantai</option>
                                @foreach ($lantais as $lantai)
                                    <option value="{{ $lantai['id'] }}">{{ $lantai['lantai'] }}</option>
                                @endforeach
                            </select>
                            <input type="text" id="idRuangan" class="rounded-lg flex-1 py-2 px-3 border text-black
                                    border-[#808080] border-opacity-50" placeholder="Kode Ruangan" />
                        </div>
                        <div class="flex flex-row gap-5">
                            <select id="status" class="rounded-md w-[416px] text-[#000000] py-2 px-3 appearance-none
                                    bg-transparent border border-[#808080] border-opacity-50">
                                <option value="" disabled selected>Status</option>
                                <option value="Aktif">Aktif</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                            </select>
                            <input type="text" id="kapasitas" class="rounded-lg flex-1 py-2 px-3 border text-black
                                    border-[#808080] border-opacity-50" placeholder="Muatan Kapasitas" />
                        </div>
                    </div>
                    <div class="flex flex-col gap-5">
                        <div class="flex flex-col gap-1">
                            <h1 class="text-2xl">Fasilitas</h1>
                            {{-- <iconify-icon icon="mingcute:warning-line" id="button-info"
                                class="text-black text-2xl"></iconify-icon> --}}
                            <div class="w-50 border border-dashed border-black border-opacity-25"></div>

                        </div>
                        <div
                            class="w-[450px] text-center bg-green-200 py-2 rounded-md flex flex-row items-center justify-center gap-1">
                            <iconify-icon icon="mingcute:warning-line"
                                class="text-xl sm:text-sm text-green-600 italic"></iconify-icon>
                            <p class="text-green-600"> Note : klik, tombol tambah
                                jika ingin
                                menambah asset</p>
                        </div>
                        <form id="form-asset">
                            <div id="wrapper-input-tambah" class="flex flex-col gap-5">
                                <div class="flex flex-row gap-5">
                                    <input type="text" name="nama_asset[]" class="rounded-lg flex-1 py-2 px-3 border text-black
                                        border-[#808080] border-opacity-50" placeholder="Masukkan Nama Asset" />
                                    <input type="text" name="total_asset[]" class="rounded-lg flex-1 py-2 px-3 border text-black
                                        border-[#808080] border-opacity-50" placeholder="Masukkan Total" />
                                </div>
                            </div>
                        </form>
                        <div class="flex justify-center flex-row gap-5">
                            <button data-button-target="wrapper-input-tambah"
                                class="border rounded-lg flex items-center p-2 bg-[red]">
                                <iconify-icon icon="mingcute:plus-fill"
                                    class="text-3xl sm:text-sm text-white"></iconify-icon>
                            </button>
                            <button class="button-less border rounded-lg hidden flex items-center p-2 bg-[red]">
                                <iconify-icon icon="typcn:minus" class="text-3xl sm:text-sm text-white"></iconify-icon>
                            </button>
                        </div>
                    </div>
                    <button type="button" id="btn-submit-tambah"
                        class="w-auto text-white bg-[red] py-3 rounded-xl font-extrabold">
                        Submit
                    </button>
                </div>
        </section>
    </main>

    <script>
        const routes = {
            storeData: "{{ route('tambah.ruang') }}",
            updateData: "{{ route('update.ruang') }}"
        };
    </script>
@endsection