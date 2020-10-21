function openAddEmail() {
    window.location.href = '../views/add-email.php';
}

function joinDomain() {
    var userName = document.querySelector('#user-name');
    var emailIdBox = document.querySelector('.email-id-box');
    
    if (userName.value.length > 0) {
        var domain = document.querySelector('#domain');
        var domainValue = domain.options[domain.selectedIndex].value;
        if (domainValue != '') {
            emailIdBox.innerHTML = userName.value + '@' + domainValue;
        }
    } else if (userName.value.length == 0) {
        emailIdBox.innerHTML = '';
    }
}

function addEmail() {
    var domain = document.querySelector('#domain');
    var userName = document.querySelector('#user-name');
    var password = document.querySelector('#password');
    var confirmPassword = document.querySelector('#confirm-password');
    var addButton = document.querySelector('.add-button');

    if ((domain.value != '') && (userName.value != '') && (password.value != '') && (confirmPassword.value != '')) {
        domain.style.border = '2px solid #8a8a8a';
        userName.style.border = '2px solid #8a8a8a';
        password.style.border = '2px solid #8a8a8a';
        confirmPassword.style.border = '2px solid #8a8a8a';

        if (password.value == confirmPassword.value) {
            password.style.border = '2px solid #8a8a8a';
            confirmPassword.style.border = '2px solid #8a8a8a';
            addButton.innerHTML = 'Adding...';
            addButton.style.cursor = 'wait';
            addButton.removeAttribute('onclick');

            var http = new XMLHttpRequest();
            var url = '../requests/add-email.php';
            var params = 
            'domain='+domain.value+
            '&userName='+userName.value+
            '&password='+password.value;
            http.open('POST', url, true);
            http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            http.onreadystatechange = function() {
                if(http.readyState == 4 && http.status == 200) {
                    console.log(http.responseText);
                    if (http.responseText == '1') {
                        setTimeout(() => {
                            addButton.innerHTML = 'Email Added';
    
                            setTimeout(() => {
                                window.location.reload();
                            }, 2500);                            
                        }, 2000);
                    } else if (http.responseText == '0') {
                        setTimeout(() => {
                            addButton.innerHTML = 'Email Already Existed';
                            addButton.style.background = 'linear-gradient(120deg, #ff5934 0%, #a50000 100%)';
    
                            setTimeout(() => {
                                addButton.innerHTML = 'Add';
                                userName.style.border = '2px solid rgb(244, 67, 54)';                                
                                addButton.style.background = 'linear-gradient(120deg, #00b5fd 0%, #0047b1 100%)';
                                addButton.setAttribute('onclick', 'addEmail()');
                                addButton.style.cursor = 'pointer';
                            }, 2000);                            
                        }, 2000);
                    }
                }
            }
            http.send(params);
        } else {
            password.style.border = '2px solid rgb(244, 67, 54)';
            confirmPassword.style.border = '2px solid rgb(244, 67, 54)';
        }
    } else {
        if (domain.value == '') {
            domain.style.border = '2px solid rgb(244, 67, 54)';
        }

        if (userName.value == '') {
            userName.style.border = '2px solid rgb(244, 67, 54)';
        }

        if (password.value == '') {
            password.style.border = '2px solid rgb(244, 67, 54)';
        }

        if (confirmPassword.value == '') {
            confirmPassword.style.border = '2px solid rgb(244, 67, 54)';
        }
    }
}