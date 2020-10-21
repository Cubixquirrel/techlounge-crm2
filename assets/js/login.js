document.onreadystatechange = function () {
    var state = document.readyState;
    if (state == 'interactive') {
        document.querySelector('.loader').style.display = "flex";
        document.querySelector('.loader').style.visibility = "visible";
    } else if (state == 'complete') {
        document.querySelector('.loader').style.visibility = "hidden";
        document.querySelector('body').style.visibility = "visible";
    }
}

function login() {
    var loginId = document.querySelector('#login-id');
    var loginPassword = document.querySelector('#login-password');
    var loginButton = document.querySelector('.login-button');

    loginId.style.border = '2px solid #8a8a8a';
    loginPassword.style.border = '2px solid #8a8a8a';

    if ((loginId.value != '') && (loginPassword.value != '')) {
        loginButton.removeAttribute('onclick');
        loginButton.style.cursor = 'wait';
        loginButton.innerHTML = 'Please Wait...';

        var http = new XMLHttpRequest();
        var url = '../requests/login.php';
        var params = 
        'loginId='+loginId.value+
        '&loginPassword='+loginPassword.value;

        http.open('POST', url, true);
        http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        http.onreadystatechange = function() {
            if(http.readyState == 4 && http.status == 200) {
                // console.log(http.responseText);
                setTimeout(function() {
                    var responses = http.responseText.split('__%__');
                    if (responses[0] == 'true') {
                        loginButton.innerHTML = 'Welcome ' + responses[1] + ' !';

                        setTimeout(function() {
                            window.location.href = '../index.php';
                        }, 2000);
                    } else {
                        if (responses[0] == 'Incorrect ID') {
                            loginId.style.border = '2px solid #F44336';
                        }
                        else if (responses[0] == 'Incorrect Password') {
                            loginPassword.style.border = '2px solid #F44336';
                        }
                        loginButton.innerHTML = http.responseText;
                        loginButton.style.background = 'linear-gradient(120deg, #ff5934 0%, #a50000 100%)';
                        // loginButton.style.border = '2px solid #ff5934';

                        setTimeout(() => {
                            loginButton.style.cursor = 'pointer';
                            loginButton.setAttribute('onclick', 'login()');
                            loginButton.innerHTML = 'Login';
                            loginButton.style.background = 'linear-gradient(120deg, #00b5fd 0%, #0047b1 100%)';
                            // loginButton.style.border = '2px solid #00b5fd';
                        }, 3000);
                    }
                }, 2000);
            }
        }
        http.send(params);
    } else {
        var allFields = [loginId, loginPassword];
        var i;
        for (i = 0; i < allFields.length; i++) {
            if(allFields[i].value.length < 1){
                allFields[i].style.border = '2px solid #F44336';
            }
        }
    }
}

function switchPassword() {
    var loginPassword = document.querySelector('#login-password');
    var passwordIcon = document.querySelector('.password-icon');

    if (loginPassword.getAttribute('type') == 'password') {
        loginPassword.setAttribute('type', 'text');
        passwordIcon.setAttribute('class', 'icon-eye-off password-icon');
    } else {
        loginPassword.setAttribute('type', 'password');
        passwordIcon.setAttribute('class', 'icon-eye1 password-icon');
    }
}