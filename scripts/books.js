(function() {
    sendRequest('src/books.php', {method: 'GET'}, loadBooks, console.log);
})();

function appendTable(bookInfo) {
    var booksTbody = document.querySelector('#books tbody');

    var tr = document.createElement('tr');
    tr.setAttribute('class', 'student');

    var titleTd = document.createElement('td');
    titleTd.innerHTML = bookInfo.title;

    var authorTd = document.createElement('td');
    authorTd.innerHTML = bookInfo.author;

    var countTd = document.createElement('td');
    countTd.innerHTML = bookInfo.count;

    var viewButton = document.createElement('button');
    viewButton.innerHTML = 'View';

    var checkOutButton = document.createElement('button');
    checkOutButton.innerHTML = 'Check out';

    var actionsTd = document.createElement('td');
    actionsTd.append(viewButton, checkOutButton);

    tr.append(titleTd, authorTd, countTd, actionsTd);
    booksTbody.appendChild(tr);
}

function loadBooks(booksData) {
    booksData.forEach(function (bookInfo) {
        appendTable(bookInfo);
    });
}