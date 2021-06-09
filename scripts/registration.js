(function() {
    /**
     * Get the register button
     */
    var register = document.getElementById('registerBtn');
  
    /**
     * Listen for click event on the register button
     */
    register.addEventListener('click', sendForm);
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
    var button = document.getElementById('registerBtn');
    var p = document.createElement('p');
    p.innerHTML = "got here";
    button.after(p);
    /**
     * Get the values of the input fields
     */
    var email = document.getElementById('email').value;
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;
    var confirmPassword = document.getElementById('confirm-password').value;
  
    /**
     * Create an object with the user's data
     */
    var user = {
        username: username,
        password: password,
        confirmPassword: confirmPassword,
        email: email
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

    var button = document.getElementById('email');
    var p = document.createElement('p');
    p.innerHTML = "got here now";
    button.after(p);

    if(response.success) {
        window.location = 'login.html';
    } else {
        var errors = document.getElementById('errors');
        errors.innerHTML = response.data;
    }
  }