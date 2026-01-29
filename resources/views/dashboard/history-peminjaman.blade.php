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
        <section class="col-span-12 rounded-2xl bg-white shadow-lg p-8">
            <div class="overflow-x-auto">
                <table id="selection-table-3" class="table bordered-table sm-table mb-0 table-auto border-black p-1">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">Gedung</th>
                            <th scope="col" class="text-center">Ruangan</th>
                            <th scope="col" class="text-center">Kapasitas</th>
                            <th scope="col" class="text-center">Penanggung Jawab</th>
                            <th scope="col" class="text-center">Jenis Peminjaman</th>
                            <th scope="col" class="text-center">shift</th>
                            <th scope="col" class="text-center">Total Peminjaman</th>
                            <th scope="col" class="text-center">Alasan</th>
                            <th scope="col" class="text-center">Alasan Penolakan</th>
                            <th scope="col" class="text-center">Status</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($peminjaman as $data)
                            <tr class="text-black">
                                <td class="text-center">{{ $data->nama_gedung }} / {{ $data->lantai }}</td>
                                <td class="text-center">{{ $data->kode_ruangan }}</td>
                                <td class="text-center">{{ $data->muatan }}</td>
                                <td class="text-center">{{ $data->penanggung_jawab }}</td>
                                <td class="text-center">{{ $data->jenis_peminjaman }}</td>
                                <td class="text-center">{{ $data->jam_mulai }} / {{ $data->jam_selesai }}</td>
                                <td class="text-center">{{ $data->total_menit }} Menit</td>
                                <td class="text-center">{{ $data->keterangan_peminjaman }}</td>
                                <td class="text-center">{{ $data->alasan_penolakan }}</td>
                                <td>
                                    @if ($data->status === "Approve")
                                        <div class="flex items-center justify-center">
                                            <span
                                                class="bg-success-100  text-success-600  px-6 py-1.5 rounded-full font-medium text-sm">{{ $data->status }}</span>
                                        </div>
                                    @elseif ($data->status === "Reject")
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
                                @if ($data->status === "Waiting")
                                    <td class="text-center">
                                        <button type="button" onclick="cancelBookingButton({{ $data->id }})"
                                            class="bg-red-100 dark:bg-red-600/25 px-6 py-1.5 text-sm
                                                text-red-800 dark:text-red-400 
                                                rounded-full inline-flex items-center justify-center">
                                            Cancel Booking
                                        </button>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </main>
@endsection