(function () {
    var logoutLink = document.getElementById('logout');
    logoutLink.addEventListener('click', logout);
})();

function logout(event) {
    event.preventDefault();

    sendRequest('src/logout.php', {method: 'GET'}, redirect, console.log);
}

function redirect() {
    window.location = 'login.html';
}
