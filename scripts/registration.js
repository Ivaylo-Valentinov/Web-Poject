(function() {
    var register = document.getElementById('registerBtn');
  
    register.addEventListener('click', sendForm);
  })();
  
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

    sendRequest('src/registration.php', {method: 'POST', data: `data=${JSON.stringify(user)}`}, load, console.log);
  }
  
  function load(response) {

    if(response.success) {
        window.location = 'login.html';
    } else {
        var errors = document.getElementById('errors');
        errors.innerHTML = response.data;
    }
  }