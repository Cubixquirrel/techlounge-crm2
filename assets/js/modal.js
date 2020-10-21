function closeModal(modalId) {
    var modalMain = document.querySelector('#'+modalId);
    var modalContainer = modalMain.querySelector('.modal-container');
    var modalInputs = modalMain.getElementsByTagName('textarea');
    // console.log(modalInputs);
    for (var i = 0; i < modalInputs.length; i++) {
        modalInputs[i].value = '';
    }
    modalContainer.style.animation = 'closeModal 0.3s forwards ease';
    setTimeout(() => {
        modalMain.style.display = 'none';
    }, 400);
}

function confirmStage(modalId, selectId) {
    var currentSelect = document.querySelector('#'+selectId);
    var remarks = document.querySelector('#remarks');
    var confirmButton = document.querySelector('.confirm-button');
    var allselectedTableDataId = document.querySelectorAll('[table-data-selected="true"]');
    var id = '';

    for (let i = 0; i < allselectedTableDataId.length; i++) {
        if (i === allselectedTableDataId.length - 1) {
            id += allselectedTableDataId[i].getAttribute('table-data-id');
        } else {
            id += allselectedTableDataId[i].getAttribute('table-data-id') + ',';
        }
    }

    if ((remarks.value != '') && (id != '')) {
        remarks.style.border = '2px solid #8a8a8a';

        confirmButton.removeAttribute('onclick');
        confirmButton.style.cursor = 'wait';
        confirmButton.innerHTML = 'Marking to ' + currentSelect.value;

        var http = new XMLHttpRequest();
        var url = '../requests/mark-stage.php';
        var params = 'id='+id+'&stage='+currentSelect.value+'&remarks='+remarks.value;
        http.open('POST', url, true);
        http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        http.onreadystatechange = function() {
            console.log(http.responseText);
            if(http.readyState == 4 && http.status == 200) {
                if (http.responseText == 'Marked successfully') {
                    setTimeout(() => {
                        confirmButton.innerHTML = 'Marked Successfully';
        
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    }, 2000);
                } else {
                    window.location.reload();
                }
            }
        }
        http.send(params);
    } else if (remarks.value == '') {
        remarks.style.border = '2px solid #F44336';
    }
}

function confirmSingleStage(clientId, modalId, selectId) {
    var currentSelect = document.querySelector('#'+selectId);
    var remarks = document.querySelector('#remarks-'+clientId);
    var confirmButton = document.querySelector('#confirm-button-'+clientId);
    var id = clientId;

    if ((remarks.value != '') && (id != '')) {
        remarks.style.border = '2px solid #8a8a8a';

        confirmButton.removeAttribute('onclick');
        confirmButton.style.cursor = 'wait';
        confirmButton.innerHTML = 'Marking to ' + currentSelect.value;

        var http = new XMLHttpRequest();
        var url = '../requests/mark-stage.php';
        var params = 'id='+id+'&stage='+currentSelect.value+'&remarks='+remarks.value;
        http.open('POST', url, true);
        http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        http.onreadystatechange = function() {
            console.log(http.responseText);
            if(http.readyState == 4 && http.status == 200) {
                if (http.responseText == 'Marked successfully') {
                    setTimeout(() => {
                        confirmButton.innerHTML = 'Marked Successfully';
        
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    }, 2000);
                } else {
                    window.location.reload();
                }
            }
        }
        http.send(params);
    } else if (remarks.value == '') {
        remarks.style.border = '2px solid #F44336';
    }
}

function confirmDrop(modalId) {
    var remarks = document.querySelector('#remarks');
    var confirmButton = document.querySelector('.confirm-button');
    var allselectedTableDataId = document.querySelectorAll('[table-data-selected="true"]');
    var id = '';

    for (let i = 0; i < allselectedTableDataId.length; i++) {
        if (i === allselectedTableDataId.length - 1) {
            id += allselectedTableDataId[i].getAttribute('table-data-id');
        } else {
            id += allselectedTableDataId[i].getAttribute('table-data-id') + ',';
        }
    }

    if ((remarks.value != '') && (id != '')) {
        remarks.style.border = '2px solid #8a8a8a';

        confirmButton.removeAttribute('onclick');
        confirmButton.style.cursor = 'wait';
        confirmButton.innerHTML = 'Dropping';

        var http = new XMLHttpRequest();
        var url = '../requests/mark-drop.php';
        var params = 'id='+id+'&remarks='+remarks.value;
        http.open('POST', url, true);
        http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        http.onreadystatechange = function() {
            console.log(http.responseText);
            if(http.readyState == 4 && http.status == 200) {
                if (http.responseText == 'Dropped successfully') {
                    setTimeout(() => {
                        confirmButton.innerHTML = 'Dropped Successfully';
        
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    }, 2000);
                } else {
                    window.location.reload();
                }
            }
        }
        http.send(params);
    } else if (remarks.value == '') {
        remarks.style.border = '2px solid #F44336';
    }
}