const params = new URLSearchParams(window.location.search);

const selectOption = params.get('selectOption');
const searchText = params.get('searchText');
const searchId = params.get('searchId');
const searchUser = params.get('searchUser');
const searchUserId = params.get('searchUserId');
const searchDateMin = params.get('searchDateMin');
const searchDateMax = params.get('searchDateMax');
const searchPostId = params.get('searchPostId');
const searchIsAdmin = params.get('searchIsAdmin');
const searchIsActivated = params.get('searchIsActivated');


if($('#option' + selectOption) !== null) {
    $('#option' + selectOption).attr('selected', true);
}else{
    $('#optionTopics').attr('selected', true);
}

$('#searchText').val(searchText);

if(searchId != null && searchId.val().length > 0){
    $('#searchId').val(searchId);
}

//check if searchIsAdmin is activated
if (searchIsAdmin != null && searchIsAdmin === "on") {
    $('#searchIsAdmin').attr('checked', true);
}

//check if searchIsActivated is activated
if (searchIsActivated != null && searchIsActivated === "on") {
    $('#searchIsActivated').attr('checked', true);
}

if(searchUserId != null && searchUserId.length > 0){
    $('#searchUserId').val(searchUserId);
}

if(searchUser != null && searchUser.length > 0){
    $('#searchUser').val(searchUser);
}

if(searchDateMin != null && searchDateMin.length > 0){
    $('#searchDateMin').val(searchDateMin);
}

if(searchDateMax != null && searchDateMax.length > 0){
    $('#searchDateMax').val(searchDateMax);
}

if(searchPostId != null && searchPostId.length > 0){
    $('#searchPostId').val(searchPostId);
}

const searchInput = document.getElementById('searchInputTopic');
const topicsList = document.getElementById('topicsList');
if(topicsList !== null){
    const optionItems = topicsList.getElementsByTagName('li');
    // sert à placer la liste en dessous de l'input
    const inputRect = searchInput.getBoundingClientRect();
    topicsList.style.left = inputRect.left + 'px';
    topicsList.style.top = (inputRect.bottom + window.scrollY) + 'px';

    // Ajouter un gestionnaire d'événements au clic sur les options
    for (let i = 0; i < optionItems.length; i++) {
        optionItems[i].addEventListener('click', () => {

            // C'EST ICI POUR RECUP LA CATÉGORIE QUI A ÉTÉ SELECTIONNÉ

            searchInput.value = optionItems[i].textContent.trim();
            topicsList.style.display = 'none';
        });
    }
}

if(searchInput !== null){
    searchInput.addEventListener('click', () => {
        topicsList.style.display = 'block';
    });
    searchInput.addEventListener('input', () => {
        const searchText = searchInput.value.toLowerCase();

        for (let i = 0; i < optionItems.length; i++) {
            const option = optionItems[i].textContent.toLowerCase();

            if (option.includes(searchText)) {
                optionItems[i].style.display = 'block';
            } else {
                optionItems[i].style.display = 'none';
            }
        }
    });
}

document.addEventListener('click', (event) => {
    if (event.target !== searchInput && event.target !== topicsList) {
        topicsList.style.display = 'none';
    }
});
console.log("coucou")

console.log(document.getElementById("selectOption"))
document.getElementById("selectOption").addEventListener("change", function () {
    document.getElementById("searchForm").submit();
})