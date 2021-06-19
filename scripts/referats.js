(function() {
    initialLoad();
    var searchBtn = document.getElementById('searchBtn');
    searchBtn.addEventListener('click', sendBookRequest);

    var addBtn = document.getElementById('addBook');
    addBtn.addEventListener('click', directToAddBook);

})();


function directToAddBook(){
    window.location = 'newbook.html';
}

function initialLoad() {
    sendRequest('src/referats.php', {method: 'GET'}, loadBooks, console.log);
}

function appendTable(bookInfo) {
    var booksTbody = document.querySelector('#referats tbody');

    var tr = document.createElement('tr');
    tr.setAttribute('class', 'book');

    var titleTd = document.createElement('td');
    titleTd.innerHTML = bookInfo.title;

    var authorTd = document.createElement('td');
    authorTd.innerHTML = bookInfo.author;

    var viewButton = document.createElement('button');
    viewButton.innerHTML = 'Read';
    viewButton.addEventListener('click', function() {
        openBookPage(bookInfo.id);
    });

    var checkOutButton = document.createElement('button');
    checkOutButton.innerHTML = 'Check out';
    checkOutButton.addEventListener("click", function () {
        checkoutBook(bookInfo.id);
    });

    if(bookInfo.isTaken) {
        checkOutButton.disabled = true;
        viewButton.disabled = false;
    } else {
        checkOutButton.disabled = false;
        viewButton.disabled = true;
    }

    var actionsTd = document.createElement('td');
    actionsTd.append(viewButton, checkOutButton);

    tr.append(titleTd, authorTd, actionsTd);
    booksTbody.appendChild(tr);
}

function sendBookRequest(event) {
    event.preventDefault();

    var closing = document.getElementsByClassName('cancel');
    if(closing.length === 0) {
        var cancelBtn = document.createElement('button');
        cancelBtn.innerHTML = 'Cancel Search';
        cancelBtn.setAttribute('class', 'cancel');
        cancelBtn.addEventListener('click', cancelSearch);

        var searchBtn = document.getElementById('searchBtn');
        searchBtn.after(cancelBtn);
    }


     var searchInfo = document.getElementById("searchBar").value;

    if(searchInfo.length > 0) {

        var request = {
            searchInfo
        }
        sendRequest('src/searchReferat.php', {method: 'POST', data: `data=${JSON.stringify(request)}`}, loadSpecificBooks, console.log);
    }
}

function cancelSearch(event) {
    event.preventDefault();

    var booksTbody = document.querySelector('#referats tbody');
    while (booksTbody.firstChild) {
        booksTbody.removeChild(booksTbody.firstChild);
    }

    sendRequest('src/referats.php', {method: 'GET'}, loadBooks, console.log);
    
    var searchBar = document.getElementById('searchBar');
    searchBar.value = '';

    var cancelBtn = document.getElementsByClassName('cancel')[0];
    cancelBtn.parentNode.removeChild(cancelBtn);

}

function loadBooks(booksData) {
    var booksTbody = document.querySelector('#referats tbody');
    booksTbody.innerHTML = "";
    booksData.forEach(function (bookInfo) {
        appendTable(bookInfo);
    });
}

function openBookPage(link) {
    window.location = 'book.html?bookId=' + link;
}

function loadSpecificBooks(booksData) {
 
    var booksTbody = document.querySelector('#referats tbody');
    while (booksTbody.firstChild) {
        booksTbody.removeChild(booksTbody.firstChild);
    }

    booksData.forEach(function (bookInfo) {
        appendTable(bookInfo);
    });
}


function checkoutBook(bookID) {
       var user = {
           bookid: bookID,
           opType: "check"
       };

       sendRequest('src/libraryUtility.php', { method: 'POST', data: `data=${JSON.stringify(user)}` }, initialLoad, console.log);
   
}
