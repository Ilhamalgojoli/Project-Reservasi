document.addEventListener('DOMContentLoaded', () => {
    const nama = document.getElementById('nama');
    const kode = document.getElementById('kode');
    const jumlah = document.getElementById('jumlah');
    const status = document.getElementById('status');
    const deskripsi = document.getElementById('keterangan');
    const gambar = document.getElementById('gambar');
    const form = document.getElementById('tambah-gedung');
    const btnTambahGedung = document.getElementById('tambah-submit');

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
            });
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