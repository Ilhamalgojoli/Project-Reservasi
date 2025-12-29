document.addEventListener('DOMContentLoaded', () => {
    const btnAdd = document.getElementById('button-add');
    const btnLess = document.getElementById('button-less');
    const containerInput = document.getElementById('container-input');

    const hoverInfo = document.getElementById('hover-info');
    const btnInfo = document.getElementById('button-info');

    var count = 0;
    const limit = 10;

    // Pembungkus untuk container input
    const wrappers = [];

    if (!btnAdd) {
        console.log(btnAdd, "not found");
    }

    // Button tambah untuk menambahkan input asset
    btnAdd.addEventListener('click', (e) => {
        e.preventDefault();

        if (count < limit) {
            const wrapper = document.createElement('div');
            const inputNama = document.createElement('input');
            const inputTotal = document.createElement('input');

            wrapper.className = 'flex flex-row gap-5';

            // Untuk input nama
            inputNama.type = 'text';
            inputNama.placeholder = 'Masukkan nama asset';
            inputNama.className = 'rounded-lg flex-1 py-2 px-3 border border-[#808080] border-opacity-50 text-black';

            // Untuk total type
            inputTotal.type = 'text';
            inputTotal.placeholder = 'Masukkan Total';
            inputTotal.className = 'rounded-lg flex-1 py-2 px-3 border border-[#808080] border-opacity-50 text-black';

            wrapper.append(inputNama, inputTotal)
            containerInput.append(wrapper);

            wrappers.push(wrapper);

            count++;
            console.log(count);
            console.log(limit);

            if (wrappers.length != 0) {
                btnLess.classList.remove('hidden');
            }
        } else {
            console.log('Sudah mencapai limit');
        }

        console.log("click");
    });

    // Button kurang untuk mengurangi jumlah input asset

    btnLess.addEventListener('click', (e) => {
        e.preventDefault();

        if (wrappers.length === 0) {
            return 0;
        }

        const last = wrappers.pop();
        last.remove();

        count--;

        if (wrappers.length === 0) {
            btnLess.classList.add('hidden');
        }
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