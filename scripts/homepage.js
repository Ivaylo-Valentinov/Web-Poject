(function () {
    requestTakenBooks();
})();

function directToAddBook(){
    window.location = 'newbook.html';
}

function requestTakenBooks() {
    var user = {
        user_id: 1,
    };
    sendRequest('src/homepage.php', { method: 'POST', data: `data=${JSON.stringify(user)}` }, load, console.log);
}

function load(response) {
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
    viewButton.addEventListener('click', function() {
        openBookPage(bookInfo.id);
    });

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
    var user = {
        bookid: bookID,
        opType: "return"
    };

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
    viewButton.addEventListener('click', function() {
        openBookPage(bookInfo.id);
    });

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

function openBookPage(link) {
    window.location = 'book.html?bookId=' + link;
}
