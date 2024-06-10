let search = document.getElementById('search');
let optionsMateris = document.getElementsByClassName('materis');
search?.addEventListener('keyup', e => {
    let keyword ='';
    if (e.key === 'Escape') {
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

let filterClass=document.getElementById('select_clases')

filterClass?.addEventListener('change',applyFilters)

let filterDay=document.getElementById('select_dias')

filterDay?.addEventListener('change',applyFilters)


function applyFilters() {
    let selectedClase = document.getElementById('select_clases').value;
    let selectedDia = document.getElementById('select_dias').value;
    for (let item of items) {
        let clase = item.textContent;
        let dia = item.parentElement.querySelector('.itemsub').textContent;
        let showItem = (selectedClase === 'Todas' || clase === selectedClase) && 
                        (selectedDia === 'Todos' || dia.includes(selectedDia));

        item.parentElement.style.display = showItem ? 'flex' : 'none';
    }
}
let selectedClase_2 = document.getElementById('select_clases2');

selectedClase_2?.addEventListener('change', filterClase);
function filterClase() {
    
    for (let item of items) {
        let clase = item.textContent;
        let showItem = selectedClase_2.value === 'Todas' || clase === selectedClase_2.value;
        item.parentElement.style.display = showItem ? 'flex' : 'none';
    }
}

let dateSesions = document.getElementById('date-sesion');
dateSesions?.addEventListener('change', filterDate);

function filterDate() {
    let selectedDate = document.getElementById('date-sesion').value;
    /* pasar a selectedDate a formato español numerico recuerda que siempre hay 2 digitos en dia y mes */
    let date = new Date(selectedDate);
    let day = date.getDate();
    let month = date.getMonth() + 1;
    let year = date.getFullYear();
    selectedDate = `${day < 10 ? '0' + day : day}-${month < 10 ? '0' + month : month}-${year}`;
console.log(selectedDate);
    let datesOfSesiones= document.getElementsByClassName('historic-card')
    for (let date of datesOfSesiones) {
        console.log(date.children[0].textContent);
        let showDate = selectedDate == '' || date.children[0].textContent == selectedDate;
        date.style.display = showDate ? 'block' : 'none';
    }
}