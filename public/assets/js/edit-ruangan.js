document.addEventListener('click', () => {
    const idRuangan = document.getElementById('');
    const status = document.getElementById('');
    const kapasitas = document.getElementById('');
    const btnSubmit = document.getElementById('');

    document.querySelectorAll(".edit-ruangan").forEach(btn => {
        btn.document.addEventListener('click', async () => {
            const pathSplit = window.location.pathname.split('/');
            const id = pathSplit[pathSplit - 1];

            const res = await fetch();
            const data = await res.json();

            idRuangan.value = data.data.kode_ruangan;
            status.value = data.data.status;
            kapasitas.value = data.data.muatan_kapasitas;
        });
    });

    btn.addEventListener('click', async () => {

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
                    const req = await fetch(routes.updateData, {
                        // logic fetch tetep di sini
                    });

                    const data = await req.json();

                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Data berhasil diperbarui.',
                        icon: 'success',
                        confirmButtonText: 'OK',
                        buttonsStyling: false,
                        customClass: { confirmButton: 'btn-ok' }
                    });
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
});