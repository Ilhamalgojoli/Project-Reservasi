document.addEventListener('DOMContentLoaded', () => {
    const idRuangan = document.getElementById('idRuangan');
    const status = document.getElementById('status');
    const kapasitas = document.getElementById('kapasitas');
    const btnSubmit = document.getElementById('btn-submit');

    btnSubmit.addEventListener('click', async () => {
        try {
            const formData = new FormData();
            const pathSplit = window.location.pathname.split("/");
            const id = pathSplit[pathSplit.length - 1];

            console.log('id : ' , id);

            formData.append('kode_ruangan', idRuangan.value);
            formData.append('status', status.value);
            formData.append('muatan_kapasitas', kapasitas.value);
            formData.append('gedung_id', id);

            const req = await fetch(routes.storeData, {
                method: "POST",
                headers: {
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            });

            if (req.status === 422) {
                const err = await req.json();
                Swal.fire({
                    title: 'Gagal!',
                    text: err.message || 'Silahkan isi data gedung dengan benar.',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn-ok'
                    }
                })
            }
            const data = await req.json();

            if (data.success) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: data.message,
                    icon: 'success',
                    confirmButtonText: 'OK',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn-ok'
                    }
                })
            }
        } catch (err) {
            console.log(err);
        }
    });
});