document.addEventListener("DOMContentLoaded", () => {
    const getOption = document.getElementById("opsi-peminjaman");
    const idAkademik = document.getElementById("Akademik");
    const idNonAkademik = document.getElementById("Non-Akademik");
    const judulForm = document.getElementById("value");

    const selectOption = (value) => {
        if (value === "non-akademik") {
            idNonAkademik.classList.remove("hidden");
            idAkademik.classList.add("hidden");
            judulForm.innerHTML = "Non-Akademik";

            console.log('Aktif');
        } else {
            idNonAkademik.classList.add("hidden");
            idAkademik.classList.remove("hidden");
            judulForm.innerHTML = "Akademik";

            console.log('Aktif');
        }
    };

    getOption.addEventListener('change', (e) =>{
        selectOption(e.target.value);
        console.log(e.target.value);
        console.log(this.value);
    });
});
