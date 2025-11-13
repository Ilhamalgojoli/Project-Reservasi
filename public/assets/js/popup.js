document.addEventListener("DOMContentLoaded", () => {
    function popUp(popUpBody, btnPopUp, cross) {

        // Atau cek di dalam fungsi nya lansung biar break kalau ketemu null
        if(!popUpBody && !btnPopUp && !cross)
            return null ;

        console.log("pop-up :", popUpBody);
        console.log("btn: ", btnPopUp);
        console.log("btn-close: ", cross)

        popUpBody.addEventListener("click", (e) => {
            if (e.target === popUpBody) {
                popUpBody.classList.add("hidden");
            }
        });

        btnPopUp.addEventListener("click", () => {
            popUpBody.classList.remove("hidden");
        });

        cross.addEventListener("click", () => {
            popUpBody.classList.add("hidden");
        });
    }

    const popupRuangan = document.getElementById("pop-up");
    const btnPopUpRuangan = document.getElementById("open-pop-up");
    const closeRuangan = document.getElementById("cls-btn");

    // if (popupRuangan && btnPopUpRuangan && closeRuangan) {
    popUp(popupRuangan, btnPopUpRuangan, closeRuangan);
    // }

    const popUpTambahRuang = document.getElementById("pop-up-ruangan");
    const btnPopUpTambahRuang = document.getElementById("btn-tambah-ruang");
    const closeTambahRuangan = document.getElementById("cls-btn-ruangan");

    popUp(popUpTambahRuang, btnPopUpTambahRuang, closeTambahRuangan);

    const popUpGedung = document.getElementById("pop-up-gedung");
    const btnPopUpGedung = document.getElementById("btn-gedung");
    const closePopUpGedung = document.getElementById("cls-btn-gedung");
    
    // Cek dlu si element nya ada nga baru render function nya,
    // Kalo lansung panggil dia bakal panggil 2 2 nya.

    // if (popUpGedung && btnPopUpGedung && closePopUpGedung) {
    popUp(popUpGedung, btnPopUpGedung, closePopUpGedung);
    // }

    const popUpReject = document.getElementById("pop-up-reject");
    const btnReject = document.getElementById("btn-reject");
    const clsBtnReject = document.getElementById("cls-btn-reject");
    
    popUp(popUpReject, btnReject, clsBtnReject);
});
