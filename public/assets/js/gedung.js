const { Result } = require("postcss");

document.addEventListener('DOMContentLoaded', () => {
    const nama = document.getElementById('nama');
    const kode = document.getElementById('kode');
    const jumlah = document.getElementById('jumlah');
    const status = document.getElementById('status');
    const deskripsi = document.getElementById('keterangan');
    const gambar = document.getElementById('gambar');
    const btnTambahGedung = document.getElementById('btn-submit');

    btnTambahGedung.addEventListener('click', (e) => {
        e.preventDefault();

        if (nama.value === "" || kode.value === "" ||
            jumlah.value === "" || status.value === "" ||
            deskripsi.value === "") {
            alert("Silahkan isi form tambah gedung!");
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
                confirmButton: 'btn-tetapkan',
                cancelButton: 'btn-batal'
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

                    if (gambar.files.lenght > 0) {
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

                    const data = req.json();

                    if (req.status === 200) {
                        console.log(data.message);
                    }
                } catch (err) {
                    if (req.status === 403) {
                        const errData = await req.json();
                        console.log(errData.message);
                    }
                }
            }
        });
    });
});