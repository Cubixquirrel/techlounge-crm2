function mergeClient() {
    var fromClientId = document.querySelector('[name="fromClientId"]').value;
    var toClientId = document.querySelector('[name="toClientId"]').value;

    var confirmButton = document.querySelector('.merge-button');
    confirmButton.innerHTML = 'Please Wait';
    confirmButton.setAttribute('disabled', 'disabled');

    var http = new XMLHttpRequest();
    var url = '../requests/merge-client.php';
    var params = 'fromClientId='+fromClientId+'&toClientId='+toClientId;
    http.open('POST', url, true);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.onreadystatechange = function() {
        if(http.readyState == 4 && http.status == 200) {
            console.log(http.responseText);
            setTimeout(() => {
                confirmButton.innerHTML = 'Merged Successfully';
                confirmButton.removeAttribute('disabled');

                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            }, 2000);
        }
    }
    http.send(params);
}