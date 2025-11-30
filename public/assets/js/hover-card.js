document.addEventListener("DOMContentLoaded", () => {
    const cards = document.querySelectorAll(".card-container");

    cards.forEach(card => {
        const overlay = card.querySelector(".overlay");
        const btnKelola = card.querySelector(".button-kelola");

        card.addEventListener("mouseover", () => {
            overlay.classList.remove("hidden");
            btnKelola.classList.remove("hidden");
        });

        card.addEventListener("mouseout", () => {
            overlay.classList.add("hidden");
            btnKelola.classList.add("hidden");
        });
    });
});
