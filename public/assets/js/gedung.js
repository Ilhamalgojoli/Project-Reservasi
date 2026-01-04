document.addEventListener('DOMContentLoaded', () => {
    const nama = document.getElementById('nama');
    const kode = document.getElementById('kode');
    const jumlah = document.getElementById('jumlah');
    const status = document.getElementById('status');
    const deskripsi = document.getElementById('keterangan');
    const btnTambahGedung = document.getElementById('btn-submit');

    btnTambahGedung.addEventListener('click', async(e) => {
        try {
            e.preventDefault();

            const jumlahParsing = parseInt(jumlah.value);
            console.log(status.value);
            const req = await fetch(routes.storeData ,{
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content 
                },
                body: JSON.stringify({
                    id_gedung: kode.value,
                    nama: nama.value,
                    jumlah: jumlahParsing,
                    status: status.value,
                    keterangan: deskripsi.value
                })
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