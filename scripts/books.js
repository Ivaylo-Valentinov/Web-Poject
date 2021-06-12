(function() {
    sendRequest('src/books.php', {method: 'GET'}, loadBooks, console.log);

    var searchBtn = document.getElementById('searchBtn');
    searchBtn.addEventListener('click', sendBookRequest);

})();

function appendTable(bookInfo) {
    var booksTbody = document.querySelector('#books tbody');

    var tr = document.createElement('tr');
    tr.setAttribute('class', 'book');

    var titleTd = document.createElement('td');
    titleTd.innerHTML = bookInfo.title;

    var authorTd = document.createElement('td');
    authorTd.innerHTML = bookInfo.author;

    var countTd = document.createElement('td');
    countTd.innerHTML = bookInfo.count;

    var viewButton = document.createElement('button');
    viewButton.innerHTML = 'View';
    viewButton.addEventListener('click', function() {
        openBookPage(bookInfo.link);
    });

    var checkOutButton = document.createElement('button');
    checkOutButton.innerHTML = 'Check out';

    var actionsTd = document.createElement('td');
    actionsTd.append(viewButton, checkOutButton);

    tr.append(titleTd, authorTd, countTd, actionsTd);
    booksTbody.appendChild(tr);
}

function sendBookRequest(event) {
    event.preventDefault();

     var searchInfo = document.getElementById("searchBar").value;

    if(searchInfo.length > 0) {

        var request = {
            searchInfo
        }
        sendRequest('src/searchBooks.php', {method: 'POST', data: `data=${JSON.stringify(request)}`}, loadSpecificBooks, console.log);
    }
}

function loadBooks(booksData) {
    booksData.forEach(function (bookInfo) {
        appendTable(bookInfo);
    });
}

function openBookPage(link) {
    window.location = 'book.html?bookId=' + link;
}

function loadSpecificBooks(booksData) {
 
    var booksTbody = document.querySelector('#books tbody');
    while (booksTbody.firstChild) {
        booksTbody.removeChild(booksTbody.firstChild);
    }

    booksData.forEach(function (bookInfo) {
        appendTable(bookInfo);
    });
}
