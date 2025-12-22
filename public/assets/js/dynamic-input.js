document.addEventListener('DOMContentLoaded', () => {
    const btnAdd = document.getElementById('button-add');
    const btnLess = document.getElementById('button-less');
    const containerInput = document.getElementById('container-input');
    var count = 1;
    const limit = 10;

    const wrappers = [];

    if (!btnAdd) {
        console.log(btnAdd, "not found");
    }

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

            if(wrappers.length != 0){
                btnLess.classList.remove('hidden');
            }
        } else {
            console.log('Sudah mencapai limit');
        }
    });

    btnLess.addEventListener('click', (e) => {
        e.preventDefault();

        if(wrappers.length === 0) {
            return 0;
        }

        const last = wrappers.pop();
        last.remove();

        count--;

        if(wrappers.length === 0){
            btnLess.classList.add('hidden');
        }
    });

});