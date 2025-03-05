// search guard
const searchGuard = document.getElementById('search');
const guardRows = document.querySelectorAll('.guard-row');

searchGuard.addEventListener('input', function () {
    const searchTerm = this.value.trim().toLowerCase();
    guardRows.forEach(row => {
        const name = row.cells[0].textContent.trim().toLowerCase();
        if (name.includes(searchTerm)) {
            row.style.display = 'table-row';
        } else {
            row.style.display = 'none';
        }
    });
});

// search location
const searchLocation = document.getElementById('search');
const locationRows = document.querySelectorAll('.location-row');

searchLocation.addEventListener('input', function () {
    const searchTerm = this.value.trim().toLowerCase();
    locationRows.forEach(row => {
        const name = row.cells[1].textContent.trim().toLowerCase();
        if (name.includes(searchTerm)) {
            row.style.display = 'table-row';
        } else {
            row.style.display = 'none';
        }
    });
});