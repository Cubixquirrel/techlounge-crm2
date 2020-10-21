function updateUAM() {
    if (document.querySelector('[name="uam"]').value.length > 0) {
        document.querySelector('.uam-box').innerHTML = document.querySelector('[name="uam"]').value;
        document.querySelector('[name="remarks"]').innerHTML = 'UDYAM REGISTRATION NO. ' + document.querySelector('[name="uam"]').value.toUpperCase();
        document.querySelector('[name="remarks"]').value = 'UDYAM REGISTRATION NO. ' + document.querySelector('[name="uam"]').value.toUpperCase();
    } else {
        document.querySelector('.uam-box').innerHTML = '';
        document.querySelector('[name="remarks"]').innerHTML = '';
        document.querySelector('[name="remarks"]').value  = '';
    }
}

function updateDlApplicationNumber() {
    if (document.querySelector('[name="dlApplicationNumber"]').value.length > 0) {
        document.querySelector('.dl-application-number-box').innerHTML = document.querySelector('[name="dlApplicationNumber"]').value;
        document.querySelector('[name="remarks"]').innerHTML = 'APPLICATION NUMBER NO. ' + document.querySelector('[name="dlApplicationNumber"]').value.toUpperCase();
        document.querySelector('[name="remarks"]').value = 'APPLICATION NUMBER NO. ' + document.querySelector('[name="dlApplicationNumber"]').value.toUpperCase();
    } else {
        document.querySelector('.dl-application-number-box').innerHTML = '';
        document.querySelector('[name="remarks"]').innerHTML = '';
        document.querySelector('[name="remarks"]').value  = '';
    }
}

function updateDateSlot() {
    if (document.querySelector('[name="dateSlot"]').value.length > 0) {
        document.querySelector('.date-slot-box').innerHTML = document.querySelector('[name="dateSlot"]').value;
    } else {
        document.querySelector('.date-slot-box').innerHTML = '';
    }
}

function updateLoginIdPassword() {
    if (document.querySelector('[name="loginIdPassword"]').value.length > 0) {
        document.querySelector('[name="remarks"]').innerHTML = 'APPLICATION NUMBER NO. ' + document.querySelector('[name="dlApplicationNumber"]').value.toUpperCase() + "\n" + '& LOGIN DETAILS: ' + document.querySelector('[name="loginIdPassword"]').value.toUpperCase();
        document.querySelector('[name="remarks"]').value = 'APPLICATION NUMBER NO. ' + document.querySelector('[name="dlApplicationNumber"]').value.toUpperCase() + "\n" + '& LOGIN DETAILS: ' + document.querySelector('[name="loginIdPassword"]').value.toUpperCase();
    } else {
        document.querySelector('[name="remarks"]').innerHTML = '';
        document.querySelector('[name="remarks"]').value  = '';
    }
}

function updateDlDetailDocument() {
    if (document.querySelector('[name="dlDetailDocument"]').value.length > 0) {
        document.querySelector('.dl-detail-document-box').innerHTML = document.querySelector('[name="dlDetailDocument"]').value;
        document.querySelector('[name="remarks"]').innerHTML = 'DL Detail / Document: ' + document.querySelector('[name="dlDetailDocument"]').value;
        document.querySelector('[name="remarks"]').value = 'DL Detail / Document: ' + document.querySelector('[name="dlDetailDocument"]').value;
    } else {
        document.querySelector('.dl-detail-document-box').innerHTML = '';
        document.querySelector('[name="remarks"]').innerHTML = '';
        document.querySelector('[name="remarks"]').value  = '';
    }
}

function updateMessage(printGid, cid, printLink, fromMobileNumber) {
    var fromEmail = document.querySelector("[name='fromEmail']");
    var subject = document.querySelector("[name='subject']");
    var messageDisplay = document.querySelector("[name='messageDisplay']");
    var selectType = document.querySelector("#type");
    var selectTypeOption = selectType.options[selectType.selectedIndex].value;

    if ((selectType.value == 'Delivery Of Udyam Registration Number') || (selectType.value == 'Print Udyam Registration Certificate')) {
        document.querySelector('[name="printGid"]').value = printGid;
    } else {
        document.querySelector('[name="printGid"]').value = '';
    }

    subject.setAttribute('readonly', 'readonly');
    messageDisplay.setAttribute('readonly', 'readonly');
    messageDisplay.setAttribute('contenteditable', 'false');

    document.querySelector('[name="uam"]').value = ''; 
    document.querySelector('[name="dlApplicationNumber"]').value = '';
    document.querySelector('[name="dateSlot"]').value = '';
    document.querySelector('[name="loginIdPassword"]').value = '';
    document.querySelector('[name="dlDetailDocument"]').value = '';

    document.querySelector('[name="remarks"]').innerText = '';
    document.querySelector('[name="remarks"]').value  = '';

    document.querySelector('#uam').style.display = 'none';
    document.querySelector('#dl-application-number').style.display = 'none';
    document.querySelector('#date-slot').style.display = 'none';
    document.querySelector('#login-id-password').style.display = 'none';
    document.querySelector('#dl-detail-document').style.display = 'none';

    if ((selectType.value == 'Delivery Of Udyam Registration Number') || (selectType.value == 'Print Udyam Registration Certificate')) {
        document.querySelector('#uam').style.display = 'block';
    }
    else if ((selectType.value == "Delivery of Learners Licence") || (selectType.value == "Delivery of Learners Permanent Driving Licence")) {
        document.querySelector('#date-slot').style.display = 'block';
        document.querySelector('#dl-application-number').style.display = 'block';
    }
    else if ((selectType.value == 'Delivery of Permanent Driving Licence') || (selectType.value == 'Delivery of Driving Licence Renewal')) {
        document.querySelector('#dl-application-number').style.display = 'block';
    }
    else if ((selectType.value == 'Driving Licence Detail Document Pending') || (selectType.value == 'Driving Licence Aadhaar DL Issue')) {
        document.querySelector('#dl-detail-document').style.display = 'block';
    }
    else if ((selectType.value == "Delivery of Food Licence Application")) {
        document.querySelector('#dl-application-number').style.display = 'block';
        document.querySelector('#login-id-password').style.display = 'block';
    }
    else if ((selectType.value == 'Delivered') || (selectType.value == 'Call Not Picked, Reached, Switched Off')) {
        subject.removeAttribute('readonly');
        messageDisplay.removeAttribute('readonly');
        messageDisplay.setAttribute('contenteditable', 'true');
    }
    
    if (selectType.value != '') {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var response = JSON.parse(this.responseText);
            document.querySelector("[name='subject']").value = response[0];
            document.querySelector("[name='messageDisplay']").innerHTML = response[1];
            document.querySelector("[name='message']").innerHTML = response[1];
            if ((selectType.value == "Delivery of Learners Licence") || (selectType.value == 'Delivery of Permanent Driving Licence') || (selectType.value == "Delivery of Learners Permanent Driving Licence") || (selectType.value == 'Delivery of Driving Licence Renewal')) {
                document.querySelector('.form-mobile-number-box').innerHTML = fromMobileNumber;
            }
        }
    };

    var template = selectType.value.split(' ').join('-').toLowerCase();
    xhttp.open("GET", "../template/email/"+template+".php?fromEmail="+fromEmail.value+"&type="+selectTypeOption+"&cid="+cid+"&printLink="+printLink+"", true);
    xhttp.send();
    } else {
        subject.setAttribute('readonly', 'readonly');
        messageDisplay.setAttribute('readonly', 'readonly');
        messageDisplay.setAttribute('contenteditable', 'false');
        subject.value = '';
        messageDisplay.innerText = '';

        document.querySelector('[name="uam"]').value = ''; 
        document.querySelector('[name="dlApplicationNumber"]').value = '';
        document.querySelector('[name="dateSlot"]').value = '';
        document.querySelector('[name="loginIdPassword"]').value = '';
        document.querySelector('[name="dlDetailDocument"]').value = '';

        document.querySelector('[name="remarks"]').innerText = '';
        document.querySelector('[name="remarks"]').value  = '';

        document.querySelector('#uam').style.display = 'none';
        document.querySelector('#dl-application-number').style.display = 'none';
        document.querySelector('#date-slot').style.display = 'none';
        document.querySelector('#login-id-password').style.display = 'none';
        document.querySelector('#dl-detail-document').style.display = 'none';
    }
}

function makeFileList() {
    var input = document.getElementById("attachment");
    var ul = document.getElementById("attachment-list");
    while (ul.hasChildNodes()) {
        ul.removeChild(ul.firstChild);
    }
    for (var i = 0; i < input.files.length; i++) {
        var li = document.createElement("li");
        li.innerHTML = input.files[i].name;
        ul.appendChild(li);
    }
    if(!ul.hasChildNodes()) {
        var li = document.createElement("li");
        li.innerHTML = 'No Files Selected';
        ul.appendChild(li);
    }
}

$(document).ready(function (e) {
    $("#send-email-form").on('submit',(function(e) {
        e.preventDefault();

        document.querySelector("[name='message']").innerHTML = document.querySelector("[name='messageDisplay']").innerHTML;

        var subject = document.querySelector('[name="subject"]');
        var message = document.querySelector('[name="message"]');
        var remarks = document.querySelector('[name="remarks"]');
        var sendButton = document.querySelector('#send-email');

        if ((subject.value != '') && (message.value != '') && (remarks.value != '')) {
            sendButton.setAttribute('disabled', 'disabled');
            sendButton.innerHTML = 'Sending...';    

            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    console.log(data);
                    sendButton.innerHTML = 'Email Sent';

                    setTimeout(function() {
                        sendButton.removeAttribute('disabled');
                        sendButton.innerHTML = '<i class="fas fa-envelope-open"></i> Send';
                    }, 2500);
                }
            });
        }
    }));
});