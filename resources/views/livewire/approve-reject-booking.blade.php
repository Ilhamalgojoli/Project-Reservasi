<div class="overflow-x-auto">
    <div class="mb-4">
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari peminjaman..."
            class="w-full px-3 py-2 border rounded-md focus:outline-none text-black">
    </div>
    <table id="table-peminjaman" class="table bordered-table sm-table mb-0 table-auto border-black p-1">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Gedung</th>
                <th class="text-center">Ruangan</th>
                <th class="text-center">Jenis Peminjaman</th>
                <th class="text-center">Kapasitas</th>
                <th class="text-center">Penanggung Jawab</th>
                <th class="text-center">Jenis Peminjaman</th>
                <th class="text-center">Shift</th>
                <th class="text-center">Total Peminjaman</th>
                <th class="text-center">Alasan</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($peminjaman as $data)
                <tr class="text-black">
                    <td>{{ ($peminjaman->currentPage() - 1) * $peminjaman->perPage() + $loop->iteration }}</td>
                    <td>{{ $data->nama_gedung }} / {{ $data->lantai }}</td>
                    <td>{{ $data->kode_ruangan }}</td>
                    <td>{{ $data->jenis_peminjaman }}</td>
                    <td>{{ $data->muatan }}</td>
                    <td class="text-center">{{ $data->penanggung_jawab }}</td>
                    <td class="text-center">{{ $data->jenis_peminjaman }}</td>
                    <td class="text-center">{{ $data->jam_mulai }} / {{ $data->jam_selesai }}</td>
                    <td class="text-center">{{ $data->total_menit }} Menit</td>
                    <td class="text-center">{{ $data->keterangan_peminjaman }}</td>
                    <td class="flex gap-2 justify-center">
                        <button wire:click="$dispatch('confirmApprove', { id: {{ $data->id }} })"
                            class="w-8 h-8 bg-success-100 text-success-600 rounded-full flex items-center justify-center">
                            <iconify-icon icon="mdi:check"></iconify-icon>
                        </button>
                        <button wire:click="$dispatch('confirmDelete', { id: {{ $data->id }}})"
                            class="w-8 h-8 bg-danger-100 dark:bg-danger-600/25 text-danger-600 dark:text-danger-400 rounded-full flex items-center justify-center">
                            <iconify-icon icon="mdi:close"></iconify-icon>
                        </button>
                    </td>
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
        Livewire.on('confirmApprove', (e) => {
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
                    @this.dispatch('approve', { id: e.id });
                }
            });
        });

        Livewire.on('successApprove', (e) => {
            Swal.fire({
                title: 'Berhasil!',
                text: e.text ?? 'Sukses',
                icon: 'success',
                confirmButtonText: 'OK',
                buttonsStyling: false,
                customClass: { confirmButton: 'btn-ok' }
            });
        });

        Livewire.on('confirmDelete', (e) => {
            Swal.fire({
                title: 'Masukkan alasan penolakan',
                input: 'text',
                inputPlaceholder: 'Alasan...',
                showCancelButton: true,
                confirmButtonText: 'Kirim',
                cancelButtonText: 'Batal',
                preConfirm: (alasan) => {
                    if (!alasan) Swal.showValidationMessage('Alasan wajib diisi');
                    return alasan;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log(result.value);
                    @this.dispatch('reject', { id: e.id, alasan: result.value });
                }
            });
        });

        Livewire.on('successReject', (e) => {
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