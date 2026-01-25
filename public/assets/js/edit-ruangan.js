document.addEventListener('DOMContentLoaded', () => {
    const idRuangan = document.getElementById('idRuangan-edit');
    const status = document.getElementById('status-edit');
    const kapasitas = document.getElementById('kapasitas-edit');
    const btnSubmit = document.getElementById('btn-submit');
    const popUp = document.getElementById('popup-edit');
    const form = document.getElementById('form-edit');

    let id = 0;

    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', async () => {
            console.log('click');
            id = btn.dataset.id;

            const res = await fetch(`/dashboard/edit-ruangan/${id}`);
            const data = await res.json();

            idRuangan.value = data.data.kode_ruangan;
            status.value = data.data.status;
            kapasitas.value = data.data.muatan_kapasitas;

            const wrapperEdit = document.getElementById('wrapper-input-edit');
            wrapperEdit.innerHTML = '';

            data.data.asset.forEach(asset => {

                const row = document.createElement('div');
                row.className = 'wrapper flex flex-row gap-5';

                const inputId = document.createElement('input');
                inputId.type = 'hidden';
                inputId.name = 'asset_id[]';
                inputId.value = asset.id;

                const inputNama = document.createElement('input');
                inputNama.type = 'text';
                inputNama.name = 'nama_asset[]';
                inputNama.value = asset.nama_asset;
                inputNama.placeholder = 'Masukkan Nama Asset';
                inputNama.className = 'rounded-lg flex-1 py-2 px-3 border border-[#808080] text-black';

                const inputJumlah = document.createElement('input');
                inputJumlah.type = 'text';
                inputJumlah.name = 'total_asset[]';
                inputJumlah.value = asset.jumlah_asset;
                inputJumlah.placeholder = 'Masukkan Total';
                inputJumlah.className = 'rounded-lg flex-1 py-2 px-3 border border-[#808080] text-black';

                const buttonDelete = document.createElement('button');
                buttonDelete.type = 'button';
                buttonDelete.onclick = () => destroyAsset(asset.id);
                buttonDelete.className = 'border rounded-lg flex items-center p-2 bg-[red]';

                const icon = document.createElement('iconify-icon');
                icon.icon = 'typcn:minus';
                icon.className = 'text-3xl sm:text-sm text-white';

                buttonDelete.append(icon);
                row.append(inputId, inputNama, inputJumlah, buttonDelete);
                wrapperEdit.append(row);
            });

            popUp.classList.remove('hidden');
        });
    });

    btnSubmit.addEventListener('click', async () => {
        // Konfirmasi sebelum aksi
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Apakah Anda yakin ingin menyimpan perubahan?",
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
        }).then(async (result) => {
            if (result.isConfirmed) {
                try {
                    const formData = new FormData(form);

                    const parseId = parseInt(id);

                    formData.append('id', parseId);
                    formData.append('kode_ruangan', idRuangan.value)
                    formData.append('status', status.value);
                    formData.append('kapasitas', kapasitas.value);

                    const req = await fetch(routes.updateData, {
                        method: "POST",
                        headers: {
                            "Accept": "Application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: formData
                    });

                    if (!req.ok) {
                        const err = await req.json().catch(() => ({}));
                        throw new Error(err.message || `Terjadi kesalahan server (${req.status})`);
                    }

                    const data = await req.json();

                    Swal.fire({
                        title: 'Berhasil!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonText: 'OK',
                        buttonsStyling: false,
                        customClass: { confirmButton: 'btn-ok' }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    })
                } catch (err) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat mengirim data.',
                        icon: 'error',
                        confirmButtonText: 'OK',
                        buttonsStyling: false,
                        customClass: { confirmButton: 'btn-ok' }
                    });
                }
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire({
                    title: 'Dibatalkan',
                    text: 'Perubahan dibatalkan.',
                    icon: 'info',
                    confirmButtonText: 'OK',
                    buttonsStyling: false,
                    customClass: { confirmButton: 'btn-ok' }
                });
            }
        });
    });

    async function destroyAsset(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Apakah Anda yakin ingin menyimpan data ini?",
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
        }).then(async (result) => {
            if (result.isConfirmed) {
                try {
                    const req = await fetch(`/dashboard/delete-asset/${id}`, {
                        method: "DELETE",
                        headers: {
                            "Accept": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                        },
                    });

                    if (!req.ok) {
                        const err = await req.json().catch(() => ({}));
                        throw new Error(err.message || `Terjadi kesalahan server (${req.status})`);
                    }

                    const res = await req.json();

                    if (res.success) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: res.message || 'Gedung berhasil ditambahkan!.',
                            icon: 'success',
                            confirmButtonText: 'OK',
                            buttonsStyling: false,
                            customClass: {
                                confirmButton: 'btn-ok'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    }
                } catch (err) {
                    Swal.fire({
                        title: 'Error!',
                        text: err.message || 'Terjadi kesalahan saat mengirim data.',
                        icon: 'error',
                        confirmButtonText: 'OK',
                        buttonsStyling: false,
                        customClass: {
                            confirmButton: 'btn-ok'
                        }
                    });
                }
            }
        })
    }
});