document.addEventListener('DOMContentLoaded', () => {
    const nama = document.getElementById('edit-nama');
    const kode = document.getElementById('edit-kode');
    const jumlah = document.getElementById('edit-jumlah-lantai');
    const status = document.getElementById('edit-status');
    const deskripsi = document.getElementById('edit-keterangan');
    const gambar = document.getElementById('edit-gambar');
    const btnEditGedung = document.getElementById('submit-edit');
    const popUp = document.getElementById('pop-up-edit');
    var x = document.getElementById('lat-edit');
    var y = document.getElementById('lng-edit');

    let id = 0;
    let mapEdit;

    // Untuk mendapatkan data dari database 
    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', async () => {
            try {
                id = btn.dataset.id;
                // Panggil route endpoint dari laravel
                const res = await fetch(`/dashboard/edit-gedung/${id}`);

                const data = await res.json();

                if (!res.ok) {
                    Swal.fire('Error', result.message, 'error');
                    return;
                }

                nama.value = data.data.nama_gedung;
                kode.value = data.data.kode_gedung;
                jumlah.value = data.data.lantai_count;
                status.value = data.data.status || '';
                deskripsi.value = data.data.keterangan;

                if (!mapEdit) {
                    mapEdit = L.map('map-edit').setView([-6.973007, 107.630403], 20);

                    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                    }).addTo(mapEdit);

                    var markersGroup = L.layerGroup().addTo(mapEdit);

                    mapEdit.on('click', function (e) {
                        markersGroup.clearLayers();
                        L.marker(e.latlng).addTo(markersGroup);
                        x.innerHTML = e.latlng.lat;
                        y.innerHTML = e.latlng.lng;
                    });

                    setTimeout(() => mapEdit.invalidateSize(), 200);
                } else {
                    mapEdit.invalidateSize();
                }

                popUp.classList.remove('hidden');
            } catch (err) {
                console.error("Error:", err);
                Swal.fire({
                    title: 'Error!',
                    text: err.message || 'Terjadi kesalahan saat mengirim data.',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn-ok'
                    }
                })
            }
        });
    });

    // Proses update dari data yang sebelum ny diambil 
    btnEditGedung.addEventListener('click', async () => {
        if (nama.value === "" || kode.value === "" ||
            jumlah.value === "" || status.value === "" ||
            deskripsi.value === "") {

            Swal.fire({
                title: 'Error!',
                text: 'Form tidak bolehkosong!.',
                icon: 'error',
                confirmButtonText: 'OK',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn-ok'
                }
            })
            return;
        }

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
                    const jumlahParsing = parseInt(jumlah.value);

                    const formData = new FormData();
                    formData.append('id', id);
                    formData.append('id_gedung', kode.value);
                    formData.append('nama', nama.value);
                    formData.append('jumlah', jumlahParsing);
                    formData.append('status', status.value);
                    formData.append('keterangan', deskripsi.value);

                    if (gambar.files.length > 0) {
                        formData.append('gambar', gambar.files[0]);
                    }

                    const req = await fetch(routes.updateData, {
                        method: "POST",
                        headers: {
                            "Accept": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: formData
                    });

                    if (!req.ok) {
                        const err = await req.json().catch(() => ({}));
                        throw new Error(err.message || `Terjadi kesalahan server (${req.status})`);
                    }

                    const data = await req.json();

                    if (data.success) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: data.message || 'Gedung berhasil diUpdate!.',
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
                    console.error("Error:", err);
                    Swal.fire({
                        title: 'Error!',
                        text: err.message || 'Terjadi kesalahan saat mengirim data.',
                        icon: 'error',
                        confirmButtonText: 'OK',
                        buttonsStyling: false,
                        customClass: {
                            confirmButton: 'btn-ok'
                        }
                    })
                }
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire({
                    title: 'Dibatalkan',
                    text: 'Tambah gedung dibatalkan.',
                    icon: 'info',
                    confirmButtonText: 'OK',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn-ok'
                    }
                })
            }
        });
    });

    // Button delete item gedung
    document.querySelectorAll(".btn-delete").forEach(btn => {
        btn.addEventListener('click', () => {
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
                        const req = await fetch(`/dashboard/delete/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json',
                            }
                        });

                        if (!req.ok) {
                            const err = await req.json().catch(() => ({}));
                            throw new Error(err.message || `Terjadi kesalahan server (${req.status})`);
                        }

                        const data = await req.json();

                        if (data.success) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: data.message,
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
                        })
                    }
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire({
                        title: 'Dibatalkan',
                        text: 'Tambah gedung dibatalkan.',
                        icon: 'info',
                        confirmButtonText: 'OK',
                        buttonsStyling: false,
                        customClass: {
                            confirmButton: 'btn-ok'
                        }
                    })
                }
            });
        });
    });
});