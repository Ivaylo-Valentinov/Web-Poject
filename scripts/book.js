(function () {
    var params = getParams(window.location.href);
    if (!params.bookId) {
        window.location = 'index.html';
    }

    var bookObject = document.getElementById('book-object');
    var bookLink = document.getElementById('book-link');

    bookObject.setAttribute('data', params.bookId); 
    bookLink.setAttribute('href', params.bookId);
    bookLink.innerHTML = params.bookId;
})();
