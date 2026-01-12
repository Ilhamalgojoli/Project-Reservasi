document.addEventListener('DOMContentLoaded', () => {
    const limit = 10;
    let wrappers = [];
    let count = 0;

    // Button tambah untuk menambahkan input asset
    document.querySelectorAll('[data-button-target]').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();

            const wrapperId = btn.dataset.buttonTarget
            const wrapperInput = document.getElementById(wrapperId);

            if (count < limit) {
                const wrapper = document.createElement('div');
                const inputNama = document.createElement('input');
                const inputTotal = document.createElement('input');

                wrapper.className = 'flex flex-row gap-5';

                // Untuk input nama
                inputNama.type = 'text';
                inputNama.name = 'nama_asset[]';
                inputNama.placeholder = 'Masukkan nama asset';
                inputNama.className = 'rounded-lg flex-1 py-2 px-3 border border-[#808080] border-opacity-50 text-black';

                // Untuk total type
                inputTotal.type = 'text';
                inputTotal.name = 'total_asset[]';
                inputTotal.placeholder = 'Masukkan Total';
                inputTotal.className = 'rounded-lg flex-1 py-2 px-3 border border-[#808080] border-opacity-50 text-black';

                wrapper.append(inputNama, inputTotal);
                wrapperInput.append(wrapper);

                wrappers.push(wrapper);

                count++;
                console.log(count);
                console.log(limit);

                if (wrappers.length != 0) {
                    const lessBtn = btn.parentElement.querySelector('.button-less');
                    lessBtn.classList.remove('hidden');
                }
            } else {
                console.log('Sudah mencapai limit');
            }

            console.log('click');
        });

        if (!btn) {
            console.log(btn, 'not found');
        }
    });

    // Button kurang untuk mengurangi jumlah input asset
    document.querySelectorAll('.button-less').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();

            if (wrappers.length === 0) {
                return;
            }

            const last = wrappers.pop();
            last.remove();

            count--;

            if (wrappers.length < 1 && wrappers.length === 0) {
                btn.classList.add('hidden');
            }

            console.log(wrappers);
        });
    });

    // Close popUp
    document.querySelectorAll(".popup-close").forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();

            btn.closest(".popup").classList.add("hidden");
            console.log("click");

            while (wrappers.length > 0) {
                wrappers.pop().remove();

                count = 0;
            }

            if (wrappers.length === 0) {
                const lessBtn = btn.closest('.popup').querySelector('.button-less');
                lessBtn.classList.add('hidden');
            }

            console.log(window.wrappers);
        });
    });

    // Hover info untuk guide user admin dalam menambahkan ruangan
    // Ga jadi pakai

    // btnInfo.addEventListener('mouseover', () => {
    //     const rect = btnInfo.getBoundingClientRect();

    //     hoverInfo.style.left = rect.left + window.scrollX + btnInfo.offsetWidth - 10 + 'px';
    //     hoverInfo.style.top = rect.top + window.scrollY + btnInfo.offsetHeight - 60 + 'px';

    //     hoverInfo.classList.remove('hidden');
    // });

    // btnInfo.addEventListener('mouseout', () => {
    //     hoverInfo.classList.add('hidden');
    // });
});