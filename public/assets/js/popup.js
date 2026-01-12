document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll("[data-popup-target]").forEach(btn => {
        btn.addEventListener("click", () => {
            const popupId = btn.dataset.popupTarget;
            const popup = document.getElementById(popupId);

            if (popup) {
                popup.classList.remove("hidden");
            }
        });
    });

    document.querySelectorAll(".popup-close").forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();

            btn.closest(".popup").classList.add("hidden");
            console.log("click");

            console.log(window.wrappers);
        });
    });

    document.querySelectorAll(".popup").forEach(popup => {
        popup.addEventListener("click", (e) => {
            if (e.target === popup) {
                popup.classList.add("hidden");
            }
        });
    });
});
