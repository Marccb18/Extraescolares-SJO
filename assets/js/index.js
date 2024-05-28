let search = document.getElementById('search');
let optionsMateris = document.getElementsByClassName('materis');
search?.addEventListener('keyup', e => {
    let keyword ='';
    if (e.key === 'Escape' || search.value === '') {
        search.value = '';
        keyword = '';
        search.blur();
    } else {
    keyword = search.value.toLowerCase();
    }

    for (let materi of optionsMateris) {
        let text = materi.textContent.toLowerCase();
        let match = text.includes(keyword);
        let parent = materi.parentElement;
        parent.style.display = match ? 'table-row' : 'none';
    }
});

let optionsProfile = document.getElementById('optionsProfile');
let profile = document.getElementById('user-info-container');

profile.addEventListener('click', () => {
    if (optionsProfile.style.display === 'block') {
        optionsProfile.style.display = 'none';
    } else {
        optionsProfile.style.display = 'block';
    }
}
);

let optionsClases = document.getElementsByClassName('optionClase');
let optionsDias = document.getElementsByClassName('optionDia');
let items = document.getElementsByClassName('itemtitle');
let itemsday = document.getElementsByClassName('itemsub')



function applyFilters() {
    let selectedClase = document.getElementById('select_clases').value;
    console.log(selectedClase);
    let selectedDia = document.getElementById('select_dias').value;
    console.log(selectedDia);

    for (let item of items) {
        let clase = item.textContent;
        let dia = item.parentElement.querySelector('.itemsub').textContent;
        let showItem = (selectedClase === 'Todas' || clase === selectedClase) && 
                        (selectedDia === 'Todos' || dia.includes(selectedDia));

        item.parentElement.style.display = showItem ? 'flex' : 'none';
    }
}

function filterClase() {
    let selectedClase = document.getElementById('select_clases').value;
    for (let item of items) {
        let clase = item.textContent;
        let showItem = selectedClase === 'Todas' || clase === selectedClase;
        item.parentElement.style.display = showItem ? 'flex' : 'none';
    }
}