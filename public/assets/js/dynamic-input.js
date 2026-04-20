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
                wrapper.className = 'flex flex-row gap-5';

                const wrapperNama = document.createElement('div');
                wrapperNama.className = 'flex-[1.5] relative group';
                wrapperNama.innerHTML = `
                    <iconify-icon icon="solar:box-minimalistic-bold" 
                        class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#e51411] transition-colors text-lg"></iconify-icon>
                    <input type="text" name="nama_asset[]" placeholder="Nama Barang" 
                        class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-800 focus:bg-white focus:ring-4 focus:ring-[#e51411]/5 focus:border-[#e51411] transition-all outline-none" />
                `;

                const wrapperTotal = document.createElement('div');
                wrapperTotal.className = 'flex-1 relative group';
                wrapperTotal.innerHTML = `
                    <iconify-icon icon="mdi:numeric-count-2" 
                        class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#e51411] transition-colors text-lg"></iconify-icon>
                    <input type="number" name="total_asset[]" placeholder="Qty" 
                        class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-800 focus:bg-white focus:ring-4 focus:ring-[#e51411]/5 focus:border-[#e51411] transition-all outline-none" />
                `;

                wrapper.append(wrapperNama, wrapperTotal);
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
});