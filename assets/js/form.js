function sendFirstOTP(clientId, formId, link) {
    var firstOTPButton = document.querySelector('.first-otp-button');

    firstOTPButton.innerHTML = 'Sending...';
    firstOTPButton.setAttribute('disabled', 'disabled');

    var http = new XMLHttpRequest();
    var url = '../requests/send-otp.php';
    var params = 'clientId='+clientId+'&formId='+formId+'&link='+link+'';
    http.open('POST', url, true);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.onreadystatechange = function() {
        if(http.readyState == 4 && http.status == 200) {
            firstOTPButton.innerHTML = 'Link Sent';

            setTimeout(() => {
                firstOTPButton.innerHTML = 'Send First OTP Email / SMS';
                firstOTPButton.removeAttribute('disabled');
            }, 2000);
        }
    }
    http.send(params);
}

function sendFinalOTP(clientId, formId, link) {
    var finalOTPButton = document.querySelector('.final-otp-button');

    finalOTPButton.innerHTML = 'Sending...';
    finalOTPButton.setAttribute('disabled', 'disabled');

    var http = new XMLHttpRequest();
    var url = '../requests/send-otp.php';
    var params = 'clientId='+clientId+'&formId='+formId+'&link='+link+'';
    http.open('POST', url, true);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.onreadystatechange = function() {
        if(http.readyState == 4 && http.status == 200) {
            finalOTPButton.innerHTML = 'Link Sent';

            setTimeout(() => {
                finalOTPButton.innerHTML = 'Send First OTP Email / SMS';
                finalOTPButton.removeAttribute('disabled');
            }, 2000);
        }
    }
    http.send(params);
}

function copyFirstOTP(value) {
    var tempInput = document.createElement("input");
    tempInput.style = "position: absolute; left: -1000px; top: -1000px";
    tempInput.value = value;
    document.body.appendChild(tempInput);
    tempInput.select();
    document.execCommand("copy");
    document.body.removeChild(tempInput);

    document.querySelector('.first-otp-link').innerHTML = 'Copied!';

    setTimeout(() => {
        document.querySelector('.first-otp-link').innerHTML = 'Copy OTP Link';
    }, 1500);
}

function copyFinalOTP(value) {
    var tempInput = document.createElement("input");
    tempInput.style = "position: absolute; left: -1000px; top: -1000px";
    tempInput.value = value;
    document.body.appendChild(tempInput);
    tempInput.select();
    document.execCommand("copy");
    document.body.removeChild(tempInput);

    document.querySelector('.final-otp-link').innerHTML = 'Copied!';

    setTimeout(() => {
        document.querySelector('.final-otp-link').innerHTML = 'Copy OTP Link';
    }, 1500);
}

function copyOTP(value) {
    var tempInput = document.createElement("input");
    tempInput.style = "position: absolute; left: -1000px; top: -1000px";
    tempInput.value = value;
    document.body.appendChild(tempInput);
    tempInput.select();
    document.execCommand("copy");
    document.body.removeChild(tempInput);

    var currentTarget = event.currentTarget;
    currentTarget.innerHTML = 'Copied!';

    setTimeout(() => {
        currentTarget.innerHTML = 'Copy OTP';
    }, 1500);
}

function setClipboard(value) {
    var tempInput = document.createElement("input");
    tempInput.style = "position: absolute; left: -1000px; top: -1000px";
    tempInput.value = value;
    document.body.appendChild(tempInput);
    tempInput.select();
    document.execCommand("copy");
    document.body.removeChild(tempInput);

    document.querySelector('.copied-box').innerHTML = 'Copied!';

    setTimeout(() => {
        document.querySelector('.copied-box').innerHTML = '';
    }, 1500);
}

function viewComplaint() {
    var viewComplaintInnerBox = document.querySelector('.view-complaint-inner-box');
    if (viewComplaintInnerBox.style.display == 'none') {
        viewComplaintInnerBox.style.display = 'block';
    } else {
        viewComplaintInnerBox.style.display = 'none';
    }
}