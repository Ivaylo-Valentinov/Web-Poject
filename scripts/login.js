(function () {

    var login = document.getElementById('login');
    login.addEventListener('click', sendForm);
})();

function sendForm(event) {
    event.preventDefault();

    /**
     * Get the values of the input fields
     */
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;

    var user = {
        username,
        password,
    };

    sendRequest('src/login.php', { method: 'POST', data: `data=${JSON.stringify(user)}` }, load, console.log);
}

/**
 * Handle the received response from the server
 * If there were no errors found on validation, the index.html is loaded.
 * Else the errors are displayed to the user.
 * @param {*} response
 */
function load(response) {
    console.log(response)
    if (response.success) {
        window.location = 'index.html';

    } else {
        var errors = document.getElementById('errors');
        console.log("Login error:", errors);
        errors.innerHTML = response.data;
    }
}

