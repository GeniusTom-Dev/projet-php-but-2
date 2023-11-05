// --- Construct the table ---

function generateTable(selectedDb, table) {
    let columns = getColumns(selectedDb);
    table.innerHTML = "";
    updateTableHeader(selectedDb, columns, table);
    updateTableContent(selectedDb, columns, table);
}

// --- Functions ----

function getColumns(dbName) {
    let columns = {};
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

function updateTableHeader(selectedDb, columns, table) {
    let thead = document.createElement("thead");
    let tr = document.createElement("tr");
    table.insertBefore(thead, table.firstChild);
    for (const [key, value] of Object.entries(columns)) {
        let th = document.createElement("th");
        th.textContent = value;
        tr.appendChild(th);
    }

    /*if (selectedDb === "Topics") {
        let thModifier = document.createElement("th");
        thModifier.textContent = "MODIFIER";
        tr.append(thModifier);
    } else if (selectedDb === "Users") {
        let thDesacActiv = document.createElement("th");
        thDesacActiv.textContent = "Activer/Desactiver";
        tr.append(thDesacActiv);
    }

    let thSupprimer = document.createElement("th");
    thSupprimer.textContent = "SUPPRIMER";
    tr.append(thSupprimer);*/

    thead.append(tr);
    table.head = thead;
}

function updateTableContent(selectedDb, columns, table) {
    let tbody = document.createElement("tbody");
    table.appendChild(tbody);
    let results = JSON.parse(localStorage.getItem("searchResults"));
    for (let line in results) {
        let row = tbody.insertRow();
        let cmp = 0;
        for (const [key, value] of Object.entries(columns)) {
            let cell = row.insertCell(cmp);
            cell.innerHTML = results[line][key];
            ++cmp;
        }

        /*if (selectedDb === "Topics") {
            addModificationColumn(row, cmp);
            ++cmp;
        } else if (selectedDb === "Users") {
            addDesactivateActivateColumn(row, cmp);
            ++cmp;
        }
        addDeleteColumn(row, cmp);
*/
        // RENVOIT L'ID DE LIGNE QUI S'EST FAIT CLIQUÉ
        (function (currentLine) {
            row.addEventListener('click', function () {
                alert('Vous avez cliqué sur la ligne avec l\'ID ' + results[currentLine][Object.entries(columns)[0][0]]);
            });
        })(line);
    }
}

function addModificationColumn(row, cmp) {
    let cell = row.insertCell(cmp);
    cell.innerHTML = '<form method="post" action="/view/homeAdmin.php">\n' +
        '<input type="text" id="newName" name="newName" placeholder="Nouveau Nom">\n' +
        '<br>\n' +
        '<input type="text" id="newInfo" name="newInfo" placeholder="Nouvelle Description">\n' +
        '<button name="Change" value="TOPIC_ID">Modif</button>\n' +
        '</form>';
}

function addDeleteColumn(row, cmp) {
    let cell = row.insertCell(cmp);
    cell.innerHTML = '<form method="post" action="/view/homeAdmin.php">\n' +
        '<button name="Delete" value="TOPIC_ID">X</button>\n' +
        '</form>';
}

function addDesactivateActivateColumn(row, cmp) {
    let cell = row.insertCell(cmp);
    cell.innerHTML = '<form method="post" action="/view/homeAdmin.php">\n' +
        '<button name="action" value="<?=$row[\'USER_ID\']?>" onclick="submit()">\n' +
        '<?php\n' + 'if ($row[\'IS_ACTIVATED\'] == 1){\n' +
        'echo \'Désactiver\';\n' + '}\n' +
        'else{\n' + 'echo \'Activer\';\n' + '}\n' + '?>\n' +
        '</button>\n' +
        '</form>\n';
}



