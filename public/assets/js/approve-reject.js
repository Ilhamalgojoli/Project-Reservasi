function approveButton(id) {
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
        try {
            const req = await fetch(`/dashboard/approve/${id}`, {
                method: "POST",
                headers: {
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                },
            });

            if (!req.ok) {
                const err = await req.json().catch(() => ({}));
                throw new Error(err.message || `Terjadi kesalahan server (${req.status})`)
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
    });
}

function rejectButton(id) {
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
        try {
            const req = await fetch(`/dashboard/reject/${id}`, {
                method: "POST",
                headers: {
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                },
            });

            if (!req.ok) {
                const err = await req.json().catch(() => ({}));
                throw new Error(err.message || `Terjadi kesalahan server (${req.status})`)
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
    });
}
