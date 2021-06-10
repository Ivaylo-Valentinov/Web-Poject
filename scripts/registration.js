(function() {
    var register = document.getElementById('registerBtn');
  
    register.addEventListener('click', sendForm);
  })();
  
  /**
  * Handle the click event by sending an asynchronous request to the server
  * @param {*} event
  */
  function sendForm(event) {
     event.preventDefault();
  
    var email = document.getElementById('email').value;
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;
    var confirmPassword = document.getElementById('confirm-password').value;
  
    var user = {
        username,
        password,
        confirmPassword,
        email
    };
  
    /**
     * Send POST request with user's data to registration.php
     */
    sendRequest('src/registration.php', {method: 'POST', data: `data=${JSON.stringify(user)}`}, load, console.log);
  }
  
  /**
  * Handle the received response from the server
  * If there were no errors found on validation, the login.html is loaded.
  * Else the errors are displayed to the user.
  * @param {*} response
  */
  function load(response) {

    if(response.success) {
        window.location = 'login.html';
    } else {
        var errors = document.getElementById('errors');
        errors.innerHTML = response.data;
    }
  }