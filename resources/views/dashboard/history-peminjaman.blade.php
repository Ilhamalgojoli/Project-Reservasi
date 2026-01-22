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
                                <th>Gedung / Lantai</th>
                                <th>Ruangan</th>
                                <th>Kapasitas</th>
                                <th>Penanggung Jawab</th>
                                <th>Jenis Peminjaman</th>
                                <th>Tanggal Peminjaman</th>
                                <th>Jam Peminjaman</th>
                                <th>Alasan</th>
                                <th>Status Peminjaman</th>
                            </tr>
                        </thead>
                        <tbody class="text-black">
                            @foreach($peminjaman as $index => $data)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $data->nama_gedung }} / {{ $data->lantai }}</td>
                                    <td>{{ $data->kode_ruangan }}</td>
                                    <td>{{ $data->muatan }}</td>
                                    <td>{{ $data->penanggung_jawab }}</td>
                                    <td>{{ $data->jenis_peminjaman }}</td>
                                    <td>{{ $data->tanggal_peminjaman }}</td>
                                    <td>
                                        {{ $data->jam_mulai }} - {{ $data->jam_selesai }}
                                    </td>
                                    <td>{{ $data->keterangan_peminjaman }}</td>
                                    <td>
                                        @if ($data->status === "Approve")
                                            <div class="flex items-center justify-center">
                                                <span
                                                    class="bg-success-100  text-success-600  px-6 py-1.5 rounded-full font-medium text-sm">{{ $data->status }}</span>
                                            </div>
                                        @elseif ($data->status === "Rejected")
                                            <div class="flex items-center justify-center">
                                                <span
                                                    class="bg-danger-100  text-danger-600  px-6 py-1.5 rounded-full font-medium text-sm">{{ $data->status }}</span>
                                            </div>
                                        @else
                                            <div class="flex items-center justify-center">
                                                <span
                                                    class="bg-warning-100  text-warning-600  px-6 py-1.5 rounded-full font-medium text-sm">{{ $data->status }}</span>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            @if($peminjaman->isEmpty())
                                <tr>
                                    <td colspan="9" class="py-4 text-center">Belum ada data peminjaman</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>
@endsection