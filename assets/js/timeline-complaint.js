function sendComplaintMessage(formId) {
    var sendButton = document.querySelector('#send-button');
    var message = document.querySelector('#message');

    sendButton.setAttribute('disabled', 'disabled');
    sendButton.innerHTML = 'Sending';

    var http = new XMLHttpRequest();
    var url = '../requests/send-complaint-message.php';
    var params = 'formId='+formId+'&message='+message.value;
    http.open('POST', url, true);

    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    http.onreadystatechange = function() {
        if(http.readyState == 4 && http.status == 200) {          
          console.log(http.responseText);
          setTimeout(function() {
            sendButton.innerHTML = 'Sent';

            setTimeout(function() { 
              sendButton.innerHTML = 'Send';
              sendButton.removeAttribute('disabled');
              window.location.reload();
            }, 1000);
          }, 1000);
        }
    }
    http.send(params);
}

function closeComplaint(formId) {
    var closeButton = document.querySelector('#close-button');

    closeButton.setAttribute('disabled', 'disabled');
    closeButton.innerHTML = 'Closing';

    var http = new XMLHttpRequest();
    var url = '../requests/close-complaint.php';
    var params = 'formId='+formId;
    http.open('POST', url, true);

    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    http.onreadystatechange = function() {
        if(http.readyState == 4 && http.status == 200) {          
          console.log(http.responseText);
          setTimeout(function() {
            closeButton.innerHTML = 'Closed';
            window.location.reload();
          }, 1000);
        }
    }
    http.send(params);
}