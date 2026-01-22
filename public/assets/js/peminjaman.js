document.addEventListener('DOMContentLoaded', () => {
    const formNonAkademik = document.getElementById('non-akademik');
    const formAkademik = document.getElementById('akademik');
    const btnSubmitNonAkademik = document.getElementById('btn-non-akademik');
    const btnSubmitAkademik = document.getElementById('btn-akademik');
    const fakultas = document.getElementById('fakultas');
    const prodi = document.getElementById('prodi');
    const opsiPeminjaman = document.getElementById('opsi-peminjaman');

    // Akademik Submit
    btnSubmitAkademik.addEventListener('click', () => {
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
                    const formData = new FormData(formAkademik);

                    formData.append('fakultas', fakultas.value);
                    formData.append('prodi', prodi.value);
                    formData.append('jenis_peminjaman', opsiPeminjaman.value);

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
                        throw new Error(err.message || 'Terjadi Kesalahan!');
                    }

                    const data = await req.json(); 

                    if (data.success) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: data.message || 'Gedung berhasil ditambahkan!.',
                            icon: 'success',
                            confirmButtonText: 'OK',
                            buttonsStyling: false,
                            customClass: {
                                confirmButton: 'btn-ok'
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
            } else {
                Swal.fire({
                    title: 'Dibatalkan',
                    text: 'Tambah gedung dibatalkan.',
                    icon: 'info',
                    confirmButtonText: 'OK',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn-ok'
                    }
                });
            }
        });
    });

    // Submit Non akademik
    btnSubmitNonAkademik.addEventListener('click', () => {
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
                    const formData = new FormData(formNonAkademik);

                    formData.append('fakultas', fakultas.value);
                    formData.append('prodi', prodi.value);
                    formData.append('jenis_peminjaman', opsiPeminjaman.value);

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
                        throw new Error(err.message || `Terjadi kesalahan server (${req.status})`);
                    }

                    const data = await req.json();

                    if (data.success) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: data.message || 'Gedung berhasil ditambahkan!.',
                            icon: 'success',
                            confirmButtonText: 'OK',
                            buttonsStyling: false,
                            customClass: {
                                confirmButton: 'btn-ok'
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
            } else {
                Swal.fire({
                    title: 'Dibatalkan',
                    text: 'Tambah gedung dibatalkan.',
                    icon: 'info',
                    confirmButtonText: 'OK',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn-ok'
                    }
                });
            }
        });
    });
});