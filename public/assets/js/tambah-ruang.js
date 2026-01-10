document.addEventListener('DOMContentLoaded', () => {
    const idRuangan = document.getElementById('idRuangan');
    const status = document.getElementById('status');
    const kapasitas = document.getElementById('kapasitas');
    const btnSubmit = document.getElementById('btn-submit');

    btnSubmit.addEventListener('click', async () => {

        // Validasi input kosong
        if (idRuangan.value === "" || status.value === "" || kapasitas.value === "") {
            Swal.fire({
                title: 'Gagal!',
                text: 'Form tidak boleh kosong!',
                icon: 'error',
                confirmButtonText: 'OK',
                buttonsStyling: false,
                customClass: { confirmButton: 'btn-ok' }
            });
            return;
        }

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
                    const formData = new FormData();

                    // Mendapatkan id dari url web
                    const pathSplit = window.location.pathname.split("/");
                    const idGedung = pathSplit[pathSplit.length - 1]; 

                    formData.append('kode_ruangan', idRuangan.value);
                    formData.append('status', status.value);
                    formData.append('muatan_kapasitas', kapasitas.value);
                    formData.append('gedung_id', idGedung);

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
