(function () {
    console.log("Entering homepage script");

        requestTakenBooks();
})();

function requestTakenBooks() {
    console.log("Requesting taken books");
    var user = {
        user_id: 1,
    };
    sendRequest('src/homepage.php', { method: 'POST', data: `data=${JSON.stringify(user)}` }, load, console.log);
    console.log("After request");

}

/**
 * Handle the received response from the server
 * If there were no errors found on validation, the index.html is loaded.
 * Else the errors are displayed to the user.
 * @param {*} response
 */
function load(response) {
    console.log("Load function");
    //console.log(response["data"]);
    if (response.success) {
        
        loadTables(response["data"]);
    } else {
        var errors = document.getElementById('errors');
        console.log("Login error:", errors);
        errors.innerHTML = response.data;
    }
}

function appendCheckedBooksTable(bookInfo) {
    var booksTbody = document.querySelector('#checkedBooks tbody');

    var tr = document.createElement('tr');
    tr.setAttribute('class', 'book');

    var titleTd = document.createElement('td');
    titleTd.innerHTML = bookInfo.title;

    var authorTd = document.createElement('td');
    authorTd.innerHTML = bookInfo.author;

    var checkoutTd = document.createElement('td');
    checkoutTd.innerHTML = bookInfo.checkout_date;

    var expirationTd = document.createElement('td');
    expirationTd.innerHTML = bookInfo.expiration_date;

    var viewButton = document.createElement('button');
    viewButton.innerHTML = 'Read';

    var checkOutButton = document.createElement('button');
    checkOutButton.innerHTML = 'Return';

    var actionsTd = document.createElement('td');
    actionsTd.append(viewButton, checkOutButton);

    tr.append(titleTd, authorTd, checkoutTd, expirationTd);
    booksTbody.appendChild(tr);
}


function appendCheckedRefsTable(bookInfo) {
    var booksTbody = document.querySelector('#checkedReferats tbody');

    var tr = document.createElement('tr');
    tr.setAttribute('class', 'referat');

    var titleTd = document.createElement('td');
    titleTd.innerHTML = bookInfo.title;

    var authorTd = document.createElement('td');
    authorTd.innerHTML = bookInfo.author;

    var checkoutTd = document.createElement('td');
    checkoutTd.innerHTML = bookInfo.checkout_date;

    var expirationTd = document.createElement('td');
    expirationTd.innerHTML = bookInfo.expiration_date;

    var viewButton = document.createElement('button');
    viewButton.innerHTML = 'Read';

    var checkOutButton = document.createElement('button');
    checkOutButton.innerHTML = 'Return';

    var actionsTd = document.createElement('td');
    actionsTd.append(viewButton, checkOutButton);

    tr.append(titleTd, authorTd, checkoutTd, expirationTd);
    booksTbody.appendChild(tr);
}

function loadTables (bookData) {
    console.log("Generating tables");
    bookData.forEach(function (bookInfo) {
        if(bookInfo.type == "book"){
            appendCheckedBooksTable(bookInfo);
        }
        else{
            appendCheckedRefsTable(bookInfo);
        }
        
    });
}
