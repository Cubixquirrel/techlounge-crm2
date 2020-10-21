function updateMessage(type) {
    var select = document.querySelector("select[name='messageId']");
    var optionId = select.options[select.selectedIndex].value;

    var http = new XMLHttpRequest();
    var url = '../requests/get-message.php';
    var params = 'messageId='+optionId+'&type='+type+'';
    http.open('POST', url, true);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.onreadystatechange = function() {
        if(http.readyState == 4 && http.status == 200) {
            document.querySelector("textarea").setAttribute("placeholder", this.responseText);
        }
    }
    http.send(params);
}

function sendMessage(type) {
    var sendButton = document.getElementById('send-'+type);
    var clientId = document.querySelector("input[name='clientId']").value;
    var select = document.querySelector("select[name='messageId']");
    var optionId = select.options[select.selectedIndex].value;

    if (document.querySelector("select[name='emailId']") !== null) {
        var emailId = document.querySelector("select[name='emailId']").value;
    }

    if (select.value != '') {
        sendButton.setAttribute('disabled', 'disabled');
        sendButton.style.cursor = 'wait';
        sendButton.innerHTML = 'Sending...';

        var http = new XMLHttpRequest();
        var url = '../requests/send-message.php';
        if (document.querySelector("select[name='emailId']") !== null) {
            var params = 'clientId='+clientId+'&emailId='+emailId+'&messageId='+optionId+'&type='+type+'';
        } else {
            var params = 'clientId='+clientId+'&messageId='+optionId+'&type='+type+'';
        }
        http.open('POST', url, true);
        http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        http.onreadystatechange = function() {
            if(http.readyState == 4 && http.status == 200) {
                console.log(http.responseText);
                if (http.responseText == 'Sent') {
                    setTimeout(function(){
                        sendButton.innerHTML = 'Message Sent';

                        setTimeout(function(){ 
                            window.location.reload();
                        }, 2000);
                    }, 1000);
                } else {
                    setTimeout(function(){
                        sendButton.innerHTML = 'Message Failed';

                        setTimeout(function(){ 
                            window.location.reload();
                        }, 1000);
                    }, 1000);
                }
            }
        }
        http.send(params);
    }
};

function updateTimeline(type) {
    var clientId = document.querySelector("input[name='clientId']").value;
    var select = document.querySelector("select[name='messageId']");
    var optionId = select.options[select.selectedIndex].value;

    if (select.value != '') {
        var http = new XMLHttpRequest();
        var url = '../requests/update-send-message.php';
        var params = 'clientId='+clientId+'&messageId='+optionId+'&type='+type+'';
        http.open('POST', url, true);
        http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        http.onreadystatechange = function() {
            if(http.readyState == 4 && http.status == 200) {
                console.log(this.responseText);
            }
        }
        http.send(params);
    }
}