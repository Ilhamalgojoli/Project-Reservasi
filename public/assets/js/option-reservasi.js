document.addEventListener("DOMContentLoaded", () => {
    const getOption = document.querySelector("#opsi-peminjaman");
    const idAkademik = document.getElementById("Akademik");
    const idNonAkademik = document.getElementById("Non-Akademik");

    const selectOption = (value) => {
        if (value === "Non-Akademik") {
            idNonAkademik.classList.remove("hidden");
            idAkademik.classList.add("hidden");
        } else {
            idNonAkademik.classList.add("hidden");
            idAkademik.classList.remove("hidden");
        }
    };

    getOption.addEventListener('change', (e) =>{
        selectOption(e.target.value);
        console.log(e.target.value);
        console.log(this.value);
    });
});
