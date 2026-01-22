document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.lantai').forEach(selectLantai => {
        selectLantai.addEventListener('change', async function () {
            const form = this.closest('form')
            const ruanganSelect = form.querySelector('.ruangan')

            ruanganSelect.innerHTML = '<option disabled selected>Pilih Ruangan</option>'
            ruanganSelect.disabled = true

            const res = await fetch(`/dashboard/data-ruangan/${this.value}`)
            const data = await res.json()

            if (data.success) {
                data.data.forEach(r => {
                    const opt = document.createElement('option')
                    opt.value = r.id
                    opt.textContent = r.kode_ruangan
                    opt.dataset.muatan = r.muatan_kapasitas
                    ruanganSelect.appendChild(opt)
                })
            }

            ruanganSelect.disabled = false
        })
    })

    document.querySelectorAll('.ruangan').forEach(select => {
        select.addEventListener('change', function () {
            const form = this.closest('form')
            const kapasitas = this.options[this.selectedIndex].dataset.muatan
            
            form.querySelector('.muatan').textContent = `Max ${kapasitas}`
        })
    })
});
