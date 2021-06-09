
(function () {
    /**
     * Get the login button
     */
    var login = document.getElementById('login');

    /**
     * Listen for click event on the login button
     */
    login.addEventListener('click', sendForm);
})();

/**
 * Handle the click event by sending an asynchronous request to the server
 * @param {*} event
 */
function sendForm(event) {
    /**
     * Prevent the default behavior of the clicking the form submit button
     */
    event.preventDefault();
    console.log("login pressed!")
    /**
     * Get the values of the input fields
     */
    var userName = document.getElementById('email').value;
    var password = document.getElementById('password').value;
    var rememberMe = document.getElementById('remember-me').checked;

    /**
     * Create an object with the user's data
     */
    var user = {
        userName,
        password,
        remember: rememberMe
    };

    console.log("Username: ", userName, "Password:", password);
    console.log("Json string: ", JSON.stringify(user));
    /**
     * Send POST request with user's data to api.php/login
     */
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
        window.location = 'homepage.html';

    } else {
        var errors = document.getElementById('errors');
        console.log("Login error:", errors);
        errors.innerHTML = response.data;
    }
}