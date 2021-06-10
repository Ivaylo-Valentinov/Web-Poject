(function() {
    //sendRequest('src/books.php', {method: 'GET'}, loadBooks, console.log);
})();

function appendTable(bookInfo) {
    var referatsTbody = document.querySelector('#referats tbody');

    var tr = document.createElement('tr');
    tr.setAttribute('class', 'student');//whyy

    var nameTd = document.createElement('td');
    nameTd.innerHTML = bookInfo.title;

    var authorTd = document.createElement('td');
    authorTd.innerHTML = bookInfo.author;

    var viewButton = document.createElement('button');
    viewButton.innerHTML = 'View';

    var checkOutButton = document.createElement('button');
    checkOutButton.innerHTML = 'Check out';

    var actionsTd = document.createElement('td');
    actionsTd.append(viewButton, checkOutButton);

    tr.append(nameTd, authorTd, countTd, actionsTd);
    referatsTbody.appendChild(tr);
}

//function loadBooks(booksData) {
  //  booksData.forEach(function (bookInfo) {
    //    appendTable(bookInfo);
    //});
//}
