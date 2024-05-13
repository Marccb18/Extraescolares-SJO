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
