function toggleDropdownJam() {
    const dropdown = document.getElementById('dropdownJam');
    dropdown.classList.toggle('hidden');
}

function updateSelectedJam() {
    const checkboxes = document.querySelectorAll('#dropdownJam input[type="checkbox"]');
    const selected = [];
    checkboxes.forEach(cb => {
        if(cb.checked) selected.push(cb.value);
    });
    document.getElementById('selectedJam').value = selected.join(', ');
}
