function toggleDropdown(dropdownId) {
    const dropdown = document.getElementById(dropdownId);
    dropdown.classList.toggle('hidden');
}

function updateSelectedJam(dropdownId, inputId) {
    const checkboxes = document.querySelectorAll(`#${dropdownId} input[type="checkbox"]`);
    const selected = [];
    checkboxes.forEach(cb => {
        if (cb.checked) selected.push(cb.value);
    });
    document.getElementById(inputId).value = selected.join(', ');
}

function generateJam(start, end, interval = 30) {
    const result = [];

    let [h, m] = start.split(":").map(Number);
    const [endH, endM] = end.split(":").map(Number);

    
    console.log(endH, endM);

    while (h < endH || (h === endH && m <= endM)) {
        result.push(`${String(h).padStart(2,'0')}:${String(m).padStart(2,'0')}`);
        m += interval;
        if (m >= 60) {
            h++;
            m -= 60;
        }
    }
    return result;
}

const dropdownNa = document.getElementById("dropdownJamNonAkademik");
const jamNonAkademik = generateJam("06:30", "22:30");

jamNonAkademik.forEach(jam => {
    dropdownNa.insertAdjacentHTML("beforeend", `
        <label class="flex items-center px-3 py-2 hover:bg-gray-100 cursor-pointer">
            <input
                type="checkbox"
                name="jam_peminjaman[]"
                value="${jam}"
                class="mr-2"
                onchange="updateSelectedJam('dropdownJamNonAkademik','selectedJamNonAkademik')"
            >
            ${jam}
        </label>
    `);
});

const dropdownA = document.getElementById("dropdownJamAkademik");
const jamAkademik = generateJam("06:30", "22:30");

jamAkademik.forEach(jam => {
    dropdownA.insertAdjacentHTML("beforeend", `
        <label class="flex items-center px-3 py-2 hover:bg-gray-100 cursor-pointer">
            <input
                type="checkbox"
                name="jam_peminjaman[]"
                value="${jam}"
                class="mr-2"
                onchange="updateSelectedJam('dropdownJamAkademik','selectedJamAkademik')"
            >
            ${jam}
        </label>
    `);
});