document.addEventListener('DOMContentLoaded', () => {
    const akademik = document.querySelector('.akademik');
    const nonAkademik = document.querySelector('.non-akademik');

    akademik.addEventListener('click', () => {
        akademik.classList.add('bg-[#E35258]', 'text-white');
        nonAkademik.classList.remove('bg-[#E35258]', 'text-white');

        nonAkademik.classList.add('text-black');
        akademik.classList.remove('text-black');

        console.log('clicked');
    });

    nonAkademik.addEventListener('click', () => {
        nonAkademik.classList.add('bg-[#E35258]', 'text-white');
        akademik.classList.remove('bg-[#E35258]', 'text-white');

        akademik.classList.add('text-black');
        nonAkademik.classList.remove('text-black');

        console.log('clicked');
    });
});
