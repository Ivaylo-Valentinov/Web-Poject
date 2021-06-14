(function() {
    sendRequest('src/statistics.php', {method: 'GET'}, loadContent, console.log);
})();

function loadContent(content) {
    loadBooks(content.books);
    loadRefs(content.refs);
}

function loadBooks(books) {
    var container = document.getElementById('most-read-books');
    books.forEach(function(book) {
        appendToFlex(book, container);
    });
}

function loadRefs(refs) {
    var container = document.getElementById('most-read-refs');
    refs.forEach(function(ref) {
        appendToFlex(ref, container);
    });
}

function appendToFlex(info, container) {
    var element = document.createElement('p');
    element.setAttribute('class', 'centered');
    element.innerHTML = info.title;

    container.append(element);
}