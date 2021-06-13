(function () {
    console.log("Entering homepage script");

    requestTakenBooks();
        /**
     * Get the login button
     */
    var addBtn = document.getElementById('addBook');

    /**
     * Listen for click event on the login button
     */
    addBtn.addEventListener('click', directToAddBook);

})();

function directToAddBook(){
    console.log("Directing.");
    window.location = 'newbook.html';

}

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
    console.log(response);
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

    var returnButton = document.createElement('button');
    returnButton.innerHTML = 'Return';
    returnButton.addEventListener("click", function () {
        returnBook(bookInfo.id);
    });

    var actionsTd = document.createElement('td');
    actionsTd.append(viewButton, returnButton);

    tr.append(titleTd, authorTd, checkoutTd, expirationTd, actionsTd);
    booksTbody.appendChild(tr);
}

function returnBook(bookID) {
    /**
        * Create an object with the user's data
        */

    console.log("HELP I WAS CLICKED!!!!");
    var user = {
        bookid: bookID,
        opType: "return"
    };


    /**
     * Send POST request with user's data to api.php/login
     */
    sendRequest('src/libraryUtility.php', { method: 'POST', data: `data=${JSON.stringify(user)}` }, requestTakenBooks, console.log);

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

    var returnButton = document.createElement('button');
    returnButton.innerHTML = 'Return';
    returnButton.addEventListener("click", function () {
        returnBook(bookInfo.id);
    });
    var actionsTd = document.createElement('td');
    actionsTd.append(viewButton, returnButton);

    tr.append(titleTd, authorTd, checkoutTd, expirationTd, actionsTd);
    booksTbody.appendChild(tr);
}

function loadTables(bookData) {
    console.log("Generating tables");
    var booksTbody = document.querySelector('#checkedBooks tbody');
    booksTbody.innerHTML = "";
    var referatsTbody = document.querySelector('#checkedReferats tbody');
    referatsTbody.innerHTML = "";
    bookData.forEach(function (bookInfo) {
        if (bookInfo.type == "book") {

            appendCheckedBooksTable(bookInfo);
        }
        else {
            appendCheckedRefsTable(bookInfo);
        }

    });
}
