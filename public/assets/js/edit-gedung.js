document.addEventListener('DOMContentLoaded', async () => {
    const nama = document.getElementById('edit-nama');
    const kode = document.getElementById('edit-kode');
    const jumlah = document.getElementById('edit-jumlah-lantai');
    const status = document.getElementById('edit-status');
    const deskripsi = document.getElementById('edit-keterangan');
    const gambar = document.getElementById('edit-gambar');
    const btnTambahGedung = document.getElementById('submit-edit');
    const popUp = document.getElementById('pop-up-edit');

    document.querySelectorAll(".edit-btn").forEach(btn => {
        btn.addEventListener('click', async () => {
            try {
                const id = btn.dataset.id;

                const res = await fetch(`/dashboard/edit/${id}`);

                const data = await res.json();

                if (!res.ok) {
                    Swal.fire('Error', result.message, 'error');
                    return;
                }

                nama.value = data.data.nama_gedung;
                kode.value = data.data.kode_gedung;
                jumlah.value = data.data.jumlah_lantai;
                status.value = data.data.status || '';
                deskripsi.value = data.data.keterangan;

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

    btnTambahGedung.addEventListener('click', async () => {

        if (nama.value === "" || kode.value === "" ||
            jumlah.value === "" || status.value === "" ||
            deskripsi.value === "") {

            Swal.fire({
                title: 'Gagal!',
                text: errData.message || 'Form tidak bolehkosong!.',
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
                    console.log(status.value);

                    const formData = new FormData();

                    formData.append('id_gedung', kode.value);
                    formData.append('nama', nama.value);
                    formData.append('jumlah', jumlahParsing);
                    formData.append('status', status.value);
                    formData.append('keterangan', deskripsi.value);

                    if (gambar.files.length > 0) {
                        formData.append('gambar', gambar.files[0]);
                    }

                    const req = await fetch(routes.storeData, {
                        method: "POST",
                        headers: {
                            "Accept": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: formData
                    });

                    if (req.status === 403) {
                        const errData = await res.json();
                        Swal.fire({
                            title: 'Gagal!',
                            text: errData.message || 'Silahkan isi data gedung dengan benar.',
                            icon: 'error',
                            confirmButtonText: 'OK',
                            buttonsStyling: false,
                            customClass: {
                                confirmButton: 'btn-ok'
                            }
                        });
                        return;
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
});