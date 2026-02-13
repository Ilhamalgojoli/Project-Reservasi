<div class="overflow-x-auto pb-5">
    <table class="text-sm table bordered-table sm-table mb-0 table-auto border-black p-1">
        <thead>
            <tr class="uppercase text-[12px]">
                <th scope="col" class="text-center">No</th>
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
                    <td class="text-center">
                        {{ ($peminjaman->currentPage() - 1) * $peminjaman->perPage() + $loop->iteration }}
                    </td>
                    <td class="text-center">{{ $data->nama_gedung }} / {{ $data->lantai }}</td>
                    <td class="text-center">{{ $data->kode_ruangan }}</td>
                    <td class="text-center">{{ $data->muatan }}</td>
                    <td class="text-center">{{ $data->penanggung_jawab }}</td>
                    <td class="text-center">{{ $data->jenis_peminjaman }}</td>
                    <td class="text-center">{{ $data->jam_mulai }} / {{ $data->jam_selesai }}</td>
                    <td class="text-center">{{ $data->total_menit }} Menit</td>
                    <td class="text-center">{{ $data->keterangan_peminjaman }}</td>
                    <td class="text-center">
                        @if ($data->status === "Reject")
                            {{ $data->alasan_penolakan }}
                        @elseif ($data->status === "Approve")
                            <p class="italic">Peminjaman diapprove</p>
                        @elseif ($data->status === 'Waiting')
                            <p class="italic">Menunggu Persetujuan</p>
                        @endif
                    </td>
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
                        <td>
                            <button wire:click="$dispatch('cancel', { id: {{ $data->id }}})"
                                class="bg-red-100 dark:bg-red-600/25 px-6 py-1.5 text-sm
                                text-red-800 dark:text-red-400 rounded-full inline-flex items-center justify-center">
                                Cancel Booking
                            </button>
                        </td>
                    @else
                        <td class="text-center">
                            <p
                                class="bg-gray-100 text-gray-500 px-4 py-1.5 text-sm rounded-full inline-flex items-center justify-center">
                                No Action</p>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4 text-black">
        {{ $peminjaman->links(data: ['scrollTo' => false]) }}
    </div>
</div>

@script
<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('cancel', (e) => {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Apakah Anda yakin ingin menyimpan data ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Konfirmasi',
                cancelButtonText: 'Batal',
                buttonsStyling: false,
                reverseButtons: true,
                customClass: {
                    confirmButton: 'btn-confirm',
                    cancelButton: 'btn-cancel',
                    actions: 'flex justify-center gap-4'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.dispatch('cancelBooking', { id: e.id });
                }
            });
        });

        Liveire.on('successCancel', (e) => {
            Swal.fire({
                title: 'Berhasil!',
                text: e.text ?? 'Sukses',
                icon: 'success',
                confirmButtonText: 'OK',
                buttonsStyling: false,
                customClass: { confirmButton: 'btn-ok' }
            });
        });
    });
</script>
@endscript