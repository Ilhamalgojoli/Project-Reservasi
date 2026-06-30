document.addEventListener('DOMContentLoaded', () => {
    const idRuangan = document.getElementById('idRuangan-edit');
    const status = document.getElementById('status-edit');
    const kapasitas = document.getElementById('kapasitas-edit');
    const btnSubmit = document.getElementById('btn-submit');
    const popUp = document.getElementById('popup-edit');
    const form = document.getElementById('form-edit');
    const btnHapus = document.getElementById('btn-hapus');

    let id = 0;

    document.addEventListener('click', async (e) => {
        const btn = e.target.closest('.edit-btn');
        if (btn) {
            console.log('click');
            id = btn.dataset.id;

            const res = await fetch(`/ruangan/detail/${id}`);
            const data = await res.json();

            idRuangan.value = data.data.kode_ruangan;
            status.value = data.data.status;
            kapasitas.value = data.data.muatan_kapasitas;

            const wrapperEdit = document.getElementById('wrapper-input-edit');
            wrapperEdit.innerHTML = '';

            data.data.asset.forEach(asset => {
                const row = document.createElement('div');
                row.className = 'wrapper flex flex-row sm:flex-col gap-5';

                row.innerHTML = `
                    <input type="hidden" name="asset_id[]" value="${asset.id}">
                    <div class="flex-[1.5] relative group">
                        <iconify-icon icon="solar:box-minimalistic-bold" 
                            class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#e51411] transition-colors text-lg"></iconify-icon>
                        <input type="text" name="nama_asset[]" value="${asset.nama_asset}" placeholder="Nama Barang" 
                            class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-800 focus:bg-white focus:ring-4 focus:ring-[#e51411]/5 focus:border-[#e51411] transition-all outline-none" />
                    </div>
                    <div class="flex-1 relative group">
                        <iconify-icon icon="solar:database-bold-duotone" 
                            class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#e51411] transition-colors text-lg"></iconify-icon>
                        <input type="text" inputmode="numeric" name="total_asset[]" value="${asset.jumlah_asset}" placeholder="Jumlah Asset" 
                            class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-800 focus:bg-white focus:ring-4 focus:ring-[#e51411]/5 focus:border-[#e51411] transition-all outline-none" />
                    </div>
                    <button type="button" onclick="window.destroyAsset(${asset.id})"
                        class="flex items-center justify-center w-12 h-12 bg-gray-100 text-gray-400 rounded-xl hover:bg-red-50 hover:text-red-500 transition-all border border-gray-200">
                        <iconify-icon icon="solar:minus-circle-bold" class="text-xl"></iconify-icon>
                    </button>
                `;
                wrapperEdit.append(row);
            });

            popUp.classList.remove('hidden');
        }
    });

    btnSubmit.addEventListener('click', async () => {
        document.querySelectorAll('.error-msg-edit').forEach(el => el.remove());

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
                        
                        if (req.status === 422 && err.errors) {
                            for (const field in err.errors) {
                                const parts = field.split('.');
                                const baseField = parts[0];
                                const index = parts.length > 1 ? parseInt(parts[1]) : null;

                                if (baseField === 'total_asset' || baseField === 'nama_asset') {
                                    const inputs = document.querySelectorAll(`#form-edit input[name="${baseField}[]"]`);
                                    const inputEl = inputs[index];
                                    
                                    if (inputEl) {
                                        const errorSpan = document.createElement('span');
                                        errorSpan.className = 'error-msg-edit text-[10px] text-red-500 font-bold uppercase ml-1 block mt-1';
                                        errorSpan.textContent = err.errors[field][0];
                                        
                                        inputEl.closest('div.relative.group').appendChild(errorSpan);
                                    }
                                } else {
                                    const fieldMap = {
                                        'kode_ruangan': 'idRuangan-edit',
                                        'status': 'status-edit',
                                        'kapasitas': 'kapasitas-edit'
                                    };
                                    
                                    const elementId = fieldMap[field] || field;
                                    const inputEl = document.getElementById(elementId);
                                    
                                    if (inputEl) {
                                        const errorSpan = document.createElement('span');
                                        errorSpan.className = 'error-msg-edit text-[10px] text-red-500 font-bold uppercase ml-1 block mt-1';
                                        errorSpan.textContent = err.errors[field][0];
                                        
                                        const container = inputEl.closest('div.flex-1.flex.flex-col.gap-2, div.flex.flex-col.gap-2');
                                        if (container) {
                                            container.appendChild(errorSpan);
                                        } else {
                                            inputEl.parentElement.appendChild(errorSpan);
                                        }
                                    }
                                }
                            }
                            throw new Error(err.message || 'Lengkapi form dengan benar!');
                        }
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
            } else {
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

    btnHapus.addEventListener('click', () => {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Apakah Anda yakin ingin menghapus unit ruangan ini beserta seluruh asetnya?",
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
                    const parseId = parseInt(id);

                    const req = await fetch(`/dashboard/ruangan/${parseId}`, {
                        method: 'DELETE',
                        headers: {
                            "Accept": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                        },
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
            } else {
                Swal.fire({
                    title: 'Dibatalkan',
                    text: 'Hapus ruangan dibatalkan.',
                    icon: 'info',
                    confirmButtonText: 'OK',
                    buttonsStyling: false,
                    customClass: { confirmButton: 'btn-ok' }
                });
            }
        });
    });

    window.destroyAsset = async function (id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Apakah Anda yakin ingin menghapus aset ini dari ruangan?",
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
                    const req = await fetch(`/dashboard/asset/${id}`, {
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
                            text: res.message || 'Asset berhasil dihapus!.',
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
            } else {
                Swal.fire({
                    title: 'Dibatalkan',
                    text: 'Hapus aset dibatalkan.',
                    icon: 'info',
                    confirmButtonText: 'OK',
                    buttonsStyling: false,
                    customClass: { confirmButton: 'btn-ok' }
                });
            }
        })
    }
});