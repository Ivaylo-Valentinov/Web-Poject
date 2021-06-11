(function() {
    sendRequest('src/referats.php', {method: 'GET'}, loadReferats, console.log);
})();

function appendTable(referatInfo) {
    var referatsTbody = document.querySelector('#referats tbody');

    var tr = document.createElement('tr');
    tr.setAttribute('class', 'student');//whyy

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

function loadReferats(referatsData) {
    referatsData.forEach(function (referatInfo) {
        appendTable(referatInfo);
    });
}
