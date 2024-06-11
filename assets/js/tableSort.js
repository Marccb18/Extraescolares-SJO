let searchTable = document.getElementById('search-table');
let table = document.getElementById('table');
let tableBody = table.getElementsByTagName('tbody')[0];
let tableRows = tableBody.getElementsByTagName('tr');

searchTable.addEventListener('keyup', function() {
    let searchTableValue = searchTable.value.toLowerCase();
    for (let i = 0; i < tableRows.length; i++) {
        let tableRow = tableRows[i];
        let tableRowText = tableRow.innerText.toLowerCase();
        if (tableRowText.indexOf(searchTableValue) === -1) {
            tableRow.style.display = 'none';
        } else {
            tableRow.style.display = '';
        }
    }
    if (searchTableValue === '') {
        for (let i = 0; i < tableRows.length; i++) {
            let tableRow = tableRows[i];
            tableRow.style.display = '';
        }
    }
});

searchTable.addEventListener('click', function() {
    searchTable.value = '';
    for (let i = 0; i < tableRows.length; i++) {
        let tableRow = tableRows[i];
        tableRow.style.display = '';
    }
}
);