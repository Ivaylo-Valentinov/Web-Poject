(function() {
    sendRequest('src/referats.php', {method: 'GET'}, loadReferats, console.log);

    var searchBtn = document.getElementById('searchBtn');
    searchBtn.addEventListener('click', sendReferatRequest);

})();

function appendTable(referatInfo) {
    var referatsTbody = document.querySelector('#referats tbody');

    var tr = document.createElement('tr');
    tr.setAttribute('class', 'student');

    var nameTd = document.createElement('td');
    nameTd.innerHTML = referatInfo.title;

    var authorTd = document.createElement('td');
    authorTd.innerHTML = referatInfo.author;

    var viewButton = document.createElement('button');
    viewButton.innerHTML = 'View';

    var checkOutButton = document.createElement('button');
    checkOutButton.innerHTML = 'Check out';

    var actionsTd = document.createElement('td');
    actionsTd.append(viewButton, checkOutButton);

    tr.append(nameTd, authorTd, actionsTd);
    referatsTbody.appendChild(tr);
}

function sendReferatRequest(event) {
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

        sendRequest('src/searchReferat.php', {method: 'POST', data: `data=${JSON.stringify(request)}`}, loadSpecificReferats, console.log);
    }
}

function cancelSearch(event) {
    event.preventDefault();

    var referatsTbody = document.querySelector('#referats tbody');
    while (referatsTbody.firstChild) {
        referatsTbody.removeChild(referatsTbody.firstChild);
    }

    sendRequest('src/referats.php', {method: 'GET'}, loadReferats, console.log);
    
    var searchBar = document.getElementById('searchBar');
    searchBar.value = '';

    var cancelBtn = document.getElementsByClassName('cancel')[0];
    cancelBtn.parentNode.removeChild(cancelBtn);

}

function loadReferats(referatsData) {
    referatsData.forEach(function (referatInfo) {
        appendTable(referatInfo);
    });
}

function loadSpecificReferats(referatsData) {
    
    var referatsTbody = document.querySelector('#referats tbody');
    while (referatsTbody.firstChild) {
        referatsTbody.removeChild(referatsTbody.firstChild);
    }

    referatsData.forEach(function (referatInfo) {
        appendTable(referatInfo);
    });
}

