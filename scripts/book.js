(function () {
    var params = getParams(window.location.href);
    if (!params.bookId) {
        window.location = 'index.html';
    }

    sendRequest(`src/checkoutBook.php?id=${params.bookId}`, { method: 'GET' }, loadBook, notSuccessfulOpening);
})();

function loadBook(bookInfo) {
    if (!bookInfo.link) {
       notSuccessfulOpening();
    }

    var bookObject = document.getElementById('book-object');
    var bookLink = document.getElementById('book-link');

    bookObject.setAttribute('data', bookInfo.link); 
    bookLink.setAttribute('href', bookInfo.link);
    bookLink.innerHTML = bookInfo.link;
}

function notSuccessfulOpening() {
    window.location = 'index.html';
}