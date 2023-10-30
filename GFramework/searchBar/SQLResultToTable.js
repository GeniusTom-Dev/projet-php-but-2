// --- Construct the table ---

columns = getColumns(localStorage.getItem("selectedDb"));
updateTableHeader();
updateTableContent();

// --- Functions ----

function getColumns(dbName) {
    var columns = {};
    if (dbName === "Topics") {
        columns = {
            "TOPIC_ID": "ID", "NAME": "NOM", "DESCRIPTION": "DESCRIPTION"
        };
    } else if (dbName === "Users") {
        columns = {
            "USER_ID": "ID",
            "USERNAME": "USERNAME",
            "USER_EMAIL": "EMAIL",
            "USER_BIO": "BIO",
            "IS_ACTIVATED": "IS ACTIVATED",
            "IS_ADMIN": "IS ADMIN",
            "USER_CREATED": "ACCOUNT CREATION",
            "USER_LAST_CONNECTION": "LAST CONNECTION",
        };
    } else if (dbName === "Posts") {
        columns = {
            "POST_ID": "ID",
            "USER_ID": "AUTHOR ID",
            "TITLE": "TITLE",
            "CONTENT": "CONTENT",
            "DATE_POSTED": "DATE POSTED",
        };
    } else if (dbName === "Comments") {
        columns = {
            "COMMENT_ID": "ID",
            "POST_ID": "POST ID",
            "USER_ID": "AUTHOR ID",
            "CONTENT": "CONTENT",
            "DATE_POSTED": "DATE POSTED",
        };
    }
    return columns;
}

function updateTableHeader() {
    var tableHead = document.getElementById("tableHead");
    tableHead.innerHTML = "";
    for (const [key, value] of Object.entries(columns)) {
        var th = document.createElement("th");
        th.textContent = value;
        tableHead.appendChild(th);
    }

    if (localStorage.getItem("selectedDb") === "Topics") {
        var thModifier = document.createElement("th");
        thModifier.textContent = "MODIFIER";
        tableHead.append(thModifier);
    } else if (localStorage.getItem("selectedDb") === "Users") {
        var thDesacActiv = document.createElement("th");
        thDesacActiv.textContent = "Activate/Desactivate";
        tableHead.append(thDesacActiv);
    }

    var thSupprimer = document.createElement("th");
    thSupprimer.textContent = "SUPPRIMER";
    tableHead.append(thSupprimer);
}

function updateTableContent() {
    var tableBody = document.getElementById('tableBody');
    tableBody.innerHTML = "";
    var results = JSON.parse(localStorage.getItem("searchResults"));

    for (var line in results) {
        var row = tableBody.insertRow();
        cmp = 0;
        for (const [key, value] of Object.entries(columns)) {
            var cell = row.insertCell(cmp);
            cell.innerHTML = results[line][key];
            ++cmp;
        }

        if (localStorage.getItem("selectedDb") === "Topics") {
            addModificationColumn(row, cmp);
            ++cmp;
        } else if (localStorage.getItem("selectedDb") === "Users") {
            addDesactivateActivateColumn(row, cmp);
            ++cmp;
        }
        addDeleteColumn(row, cmp);

        // Get id of selected line
        (function (currentLine) {
            row.addEventListener('click', function () {
                alert('Vous avez cliqué sur la ligne avec l\'ID ' + results[currentLine][Object.entries(columns)[0][0]]);
            });
        })(line);
    }
}

function addModificationColumn(row, cmp) {
    var cell = row.insertCell(cmp);
    cell.innerHTML = '<form method="post" action="/projet-php-but-2/View/homeAdmin.php">\n' +
        '<input type="text" id="newName" name="newName" placeholder="Nouveau Nom">\n' +
        '<br>\n' +
        '<input type="text" id="newInfo" name="newInfo" placeholder="Nouvelle Description">\n' +
        '<button name="Change" value="TOPIC_ID">Modif</button>\n' +
        '</form>';
}

function addDeleteColumn(row, cmp) {
    var cell = row.insertCell(cmp);
    cell.innerHTML = '<form method="post" action="/projet-php-but-2/View/homeAdmin.php">\n' +
        '<button name="Delete" value="TOPIC_ID">X</button>\n' +
        '</form>';
}

function addDesactivateActivateColumn(row, cmp) {
    var cell = row.insertCell(cmp);
    cell.innerHTML = '<form method="post" action="/projet-php-but-2/View/homeAdmin.php">\n' +
        '<button name="action" value="<?=$row[\'USER_ID\']?>" onclick="submit()">\n' +
        '<?php\n' + 'if ($row[\'IS_ACTIVATED\'] == 1){\n' +
        'echo \'Désactiver\';\n' + '}\n' +
        'else{\n' + 'echo \'Activer\';\n' + '}\n' + '?>\n' +
        '</button>\n' +
        '</form>\n';
}



