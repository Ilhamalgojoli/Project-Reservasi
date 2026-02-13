document.addEventListener('DOMContentLoaded', () => {
    function initFlatpickr() {
        document.querySelectorAll(".tanggal-peminjaman").forEach(input => {
            if (!input._flatpickr) {
                flatpickr(input, {
                    dateFormat: "Y-m-d",
                    altInput: true,
                    altFormat: "d M Y",
                    allowInput: true,
                });
            }
        });
    }

    initFlatpickr();

    document.addEventListener('click', (e) => {
        if (e.target.classList.contains('icon-calender')) {
            const input = e.target.closest('div').querySelector('.tanggal-peminjaman');
            if (input) input._flatpickr.open();
        }
    });
});