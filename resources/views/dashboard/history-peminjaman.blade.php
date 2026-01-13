@extends('layout.layout')
@php
    $title = 'History peminjaman';
    $script = '

    ';
@endphp

@section('content')
    <h1 class="text-2xl mb-5 font-bold">{{ $title }}</h1>

    <main class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 3xl:grid-cols-5 gap-6">
        <section class="col-span-12 rounded-2xl bg-white shadow-lg p-8">
            <div class="flex flex-col gap-5">
                <div class="tableAkademik overflow-x-auto">
                    <table id="selection-table-1" class="table bordered-table sm-table mb-0 table-auto border-black p-1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Gedung</th>
                                <th>Ruangan</th>
                                <th>Kapasitas</th>
                                <th>Penanggung Jawab</th>
                                <th>Jenis Peminjaman</th>
                                <th>Status Peminjaman</th>
                                <th>Alasan</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>
@endsection
