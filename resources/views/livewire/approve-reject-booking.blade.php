<div class="overflow-x-auto">
    <table id="selection-table-2" class="table bordered-table sm-table mb-0 table-auto border-black p-1">
        <thead>
            <tr>
                <th class="text-center">Gedung</th>
                <th>Ruangan</th>
                <th>Kapasitas</th>
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
                <tr>
                    <td>{{ $data->nama_gedung }} / {{ $data->lantai }}</td>
                    <td>{{ $data->kode_ruangan }}</td>
                    <td>{{ $data->muatan }}</td>
                    <td class="text-center">{{ $data->penanggung_jawab }}</td>
                    <td class="text-center">{{ $data->jenis_peminjaman }}</td>
                    <td class="text-center">{{ $data->jam_mulai }} / {{ $data->jam_selesai }}</td>
                    <td class="text-center">{{ $data->total_menit }} Menit</td>
                    <td class="text-center">{{ $data->keterangan_peminjaman }}</td>
                    <td class="flex gap-2 justify-center">
                        <!-- APPROVE -->
                        <button onclick="Swal.fire({
                                title: 'Yakin ingin approve?',
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonText: 'Ya',
                                cancelButtonText: 'Batal'
                            }).then((result) => {
                                if(result.isConfirmed){
                                    @this.approve({{ $data->id }});
                                }
                            })"
                            class="w-8 h-8 bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400 rounded-full flex items-center justify-center">
                            <iconify-icon icon="mdi:check"></iconify-icon>
                        </button>
                        <!-- REJECT -->
                        <button onclick="Swal.fire({
                                title: 'Masukkan alasan penolakan',
                                input: 'text',
                                inputPlaceholder: 'Alasan...',
                                showCancelButton: true,
                                confirmButtonText: 'Kirim',
                                cancelButtonText: 'Batal',
                                preConfirm: (alasan) => {
                                    if(!alasan) Swal.showValidationMessage('Alasan wajib diisi');
                                    return alasan;
                                }
                            }).then((result) => {
                                if(result.isConfirmed){
                                    @this.reject({{ $data->id }}, result.value);
                                }
                            })"
                            class="w-8 h-8 bg-danger-100 dark:bg-danger-600/25 text-danger-600 dark:text-danger-400 rounded-full flex items-center justify-center">
                            <iconify-icon icon="mdi:close"></iconify-icon>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
