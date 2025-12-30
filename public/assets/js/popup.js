document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll("[data-popup-target]").forEach(btn => {
        btn.addEventListener("click", () => {
            const popupId = btn.dataset.popupTarget;
            const popup = document.getElementById(popupId);

            if(popup){
                popup.classList.remove("hidden");
            }

            console.log("click");
        });
    });

    document.querySelectorAll(".popup-close").forEach(btn => {
        btn.addEventListener('click', () => {
            btn.closest(".popup").classList.add("hidden");
            console.log("click");

            while(window.wrappers.length > 0){
                window.wrappers.pop().remove(); 

                window.count = 0 ;
            }
            
            if(window.wrappers.length === 0){
                const lessBtn = btn.closest('.popup').querySelector('.button-less');
                lessBtn.classList.add('hidden');
            }

            console.log(window.wrappers);
        });
    });

    document.querySelectorAll(".popup").forEach(popup => {
        popup.addEventListener("click", (e) => {
            if(e.target === popup){
                popup.classList.add("hidden");
            }
        });
    });
});
