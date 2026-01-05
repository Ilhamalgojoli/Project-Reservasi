document.addEventListener('DOMContentLoaded', () => {
    const nama = document.getElementById('nama');
    const kode = document.getElementById('kode');
    const jumlah = document.getElementById('jumlah');
    const status = document.getElementById('status');
    const deskripsi = document.getElementById('keterangan');
    const gambar = document.getElementById('gambar');
    const btnTambahGedung = document.getElementById('btn-submit');

    btnTambahGedung.addEventListener('click', async(e) => {
        try {
            e.preventDefault();

            const jumlahParsing = parseInt(jumlah.value);
            console.log(status.value);

            const formData = new FormData();

            formData.append('id_gedung', kode.value);
            formData.append('nama', nama.value);
            formData.append('jumlah', jumlahParsing);
            formData.append('status', status.value);
            formData.append('keterangan', deskripsi.value);
            formData.append('gambar', gambar.files[0]);

            const req = await fetch(routes.storeData ,{
                method: "POST",
                headers: {
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content 
                },
                body: formData
            });

            if(req.status === 403){
                const errData = await req.json();
                console.log(errData.message);
            }

            const data = req.json();

            if(req.status === 200){
                console.log(data.message);
            }
        } catch (err) {
            console.error(err);
        }
    });
});