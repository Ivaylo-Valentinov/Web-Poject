(function () {
    var login = document.getElementById('login');

    login.addEventListener('click', sendForm);
})();

function sendForm(event) {
    event.preventDefault();

    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;

    var user = {
        username,
        password,
    };

    sendRequest('src/login.php', { method: 'POST', data: `data=${JSON.stringify(user)}` }, load, console.log);
}

function load(response) {
    if (response.success) {
        window.location = 'index.html';

    } else {
        var errors = document.getElementById('errors');
        console.log("Login error:", errors);
        errors.innerHTML = response.data;
    }
}

