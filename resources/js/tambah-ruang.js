document.addEventListener('DOMContentLoaded', () => {
    const lantai = document.getElementById('lantai');
    const idRuangan = document.getElementById('idRuangan');
    const status = document.getElementById('status');
    const kapasitas = document.getElementById('kapasitas');
    const btnSubmit = document.getElementById('btn-submit-tambah');
    const formAsset = document.getElementById('form-asset');

    btnSubmit.addEventListener('click', async () => {
        // Hapus pesan error sebelumnya
        document.querySelectorAll('.error-msg').forEach(el => el.remove());

        // Konfirmasi sebelum submit
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Apakah Anda yakin ingin menyimpan data ruangan ini?",
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
                    const formData = new FormData(formAsset);

                    formData.append('lantai', lantai.value);
                    formData.append('kode_ruangan', idRuangan.value);
                    formData.append('status', status.value);
                    formData.append('muatan_kapasitas', kapasitas.value);

                    console.log([...formData.entries()]);

                    const req = await fetch(routes.storeData, {
                        method: "POST",
                        headers: {
                            "Accept": "application/json",
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
                                    const inputs = document.querySelectorAll(`input[name="${baseField}[]"]`);
                                    const inputEl = inputs[index];
                                    
                                    if (inputEl) {
                                        const errorSpan = document.createElement('span');
                                        errorSpan.className = 'error-msg text-[10px] text-red-500 font-bold uppercase ml-1 block mt-1';
                                        errorSpan.textContent = err.errors[field][0];
                                        
                                        inputEl.closest('div.relative.group').appendChild(errorSpan);
                                    }
                                } else {
                                    const fieldMap = {
                                        'lantai': 'lantai',
                                        'kode_ruangan': 'idRuangan',
                                        'status': 'status',
                                        'muatan_kapasitas': 'kapasitas'
                                    };
                                    
                                    const elementId = fieldMap[field] || field;
                                    const inputEl = document.getElementById(elementId);
                                    
                                    if (inputEl) {
                                        const errorSpan = document.createElement('span');
                                        errorSpan.className = 'error-msg text-[10px] text-red-500 font-bold uppercase ml-1 block mt-1';
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

                    if (data.success) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: data.message || 'Ruangan berhasil ditambahkan!',
                            icon: 'success',
                            confirmButtonText: 'OK',
                            buttonsStyling: false,
                            customClass: { confirmButton: 'btn-ok' }
                        }).then(() => {
                            location.reload();
                        });
                    }
                } catch (err) {
                    console.error("Error:", err);
                    Swal.fire({
                        title: 'Error!',
                        text: err.message || 'Terjadi kesalahan saat mengirim data.',
                        icon: 'error',
                        confirmButtonText: 'OK',
                        buttonsStyling: false,
                        customClass: { confirmButton: 'btn-ok' }
                    });
                }
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire({
                    title: 'Dibatalkan',
                    text: 'Tambah ruangan dibatalkan.',
                    icon: 'info',
                    confirmButtonText: 'OK',
                    buttonsStyling: false,
                    customClass: { confirmButton: 'btn-ok' }
                });
            }
        });
    });
});
