function logout() {
    var logoutButton = document.querySelector('.logout-button');
    logoutButton.removeAttribute('onclick');
    logoutButton.style.cursor = 'wait';
    logoutButton.innerHTML = 'Logging Out...';

    var http = new XMLHttpRequest();
    var url = '../requests/logout.php';
    http.open('POST', url, true);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.onreadystatechange = function() {
        if(http.readyState == 4 && http.status == 200) {
            setTimeout(function() {
                window.location.href = '../views/login.php';
            }, 2000);
        }
    }
    http.send();
}