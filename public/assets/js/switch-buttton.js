document.addEventListener('DOMContentLoaded', () => {
    const akademik = document.querySelector('.akademik');
    const nonAkademik = document.querySelector('.non-akademik');

    const tableAkademik = document.querySelector('.tableAkademik');
    const tableNonAkademik = document.querySelector('.tableNonAkademik');

    akademik.addEventListener('click', () => {
        akademik.classList.add('bg-[#E35258]', 'text-white');
        nonAkademik.classList.remove('bg-[#E35258]', 'text-white');

        nonAkademik.classList.add('text-black');
        akademik.classList.remove('text-black');

        tableAkademik.classList.remove('hidden');
        tableNonAkademik.classList.add('hidden');

        console.log('clicked');
    });

    nonAkademik.addEventListener('click', () => {
        nonAkademik.classList.add('bg-[#E35258]', 'text-white');
        akademik.classList.remove('bg-[#E35258]', 'text-white');

        akademik.classList.add('text-black');
        nonAkademik.classList.remove('text-black');


        tableAkademik.classList.add('hidden');
        tableNonAkademik.classList.remove('hidden');

        console.log('clicked');
    });
});
