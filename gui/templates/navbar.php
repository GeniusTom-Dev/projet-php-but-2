<header class="flex justify-between items-center mb-2 bg-purple-800 p-2">
    <img src="/gui/assets/logoecho.png" alt="logo echo" class="w-20 h-auto transition-transform duration-300 hover:scale-125 mr-1">
    <div class="flex justify-center items-center ml-16">
        <form method="GET" id="searchForm" class="space-y-4">
            <input type="hidden" name="newSearch" value="1">
            <div class="flex flex-col mb-2">
                <div class="flex justify-center items-center mb-2">
                    <select id="selectOption" name="selectOption"
                            class="h-8 bg-gray-100 p-2 border border-[#b2a5ff] rounded-md mr-4 pt-1 pb-1">
                        <option value="Topics" id="optionTopics">Categories</option>
                        <option value="Users" id="optionUsers">Utilisateurs</option>
                        <option value="Posts" id="optionPosts">Posts</option>
                        <option value="Comments" id="optionComments">Commentaires
                    </select>
                    <input type="text" id="searchText" name="searchText" placeholder="Rechercher..."
                           class="w-1/3 h-8 bg-gray-100 p-2 border border-[#b2a5ff] rounded-md mr-2"/>
                    <input type="submit" value="Rechercher" id="search"
                           class="h-8 pb-1 pt-1 bg-purple-500 text-white p-2 rounded-md hover:bg-purple-700"/>
                </div>
                <div id="searchFilters">
                    {filters}
                </div>
            </div>
        </form>
    </div>
    <div id="menu-icon" class="text-6xl cursor-pointer ml-6" style="color: #b2a5ff">
        &#9776;
    </div>
    <script src="/gui/js/searchBar.js"></script>

</header>