document.addEventListener("DOMContentLoaded", () => {
    const cards = document.querySelectorAll(".card-container");

    cards.forEach(card => {
        const overlay = card.querySelector(".overlay");
        const btnKelola = card.querySelector(".button-kelola");

        card.addEventListener("mouseover", () => {
            overlay.classList.remove("lg:hidden");
            btnKelola.classList.remove("lg:hidden");
        });

        card.addEventListener("mouseout", () => {
            overlay.classList.add("lg:hidden");
            btnKelola.classList.add("lg:hidden");
        });
    });
});
