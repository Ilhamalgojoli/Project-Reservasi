document.addEventListener('DOMContentLoaded', () => {
    const nama = document.getElementById('nama');
    const kode = document.getElementById('kode');
    const jumlah = document.getElementById('jumlah');
    const status = document.getElementById('status');
    const deskripsi = document.getElementById('keterangan');
    const gambar = document.getElementById('gambar');
    const form = document.getElementById('tambah-gedung');
    const btnTambahGedung = document.getElementById('btn-submit');

    btnTambahGedung.addEventListener('click', async(e) => {

        if (nama.value === "" || kode.value === "" ||
            jumlah.value === "" || status.value === "" ||
            deskripsi.value === "") {
            alert("Silahkan isi form tambah gedung!");
            return;
        }

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

            const data = await req.json();

            if (req.status === 200) {
                console.log(data.message);
                form.reset();
                alert(data.message);
                return;
            }
        } catch (err) {
            console.error(err);
        }
    });
});