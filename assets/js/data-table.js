function validateSearch() {
    var textBox = document.querySelector('.input-search-box');
    if (textBox.value == '') {
        var url = new URL(window.location.href);
        var urlSearchParams = url.searchParams;
        urlSearchParams.set('page', '1');
        urlSearchParams.delete('text');
        urlSearchParams.delete('display');
        url.search = urlSearchParams.toString();
        var newUrl = url.toString();
        window.location.href = newUrl;
    }
}

function search() {
    var textBox = document.querySelector('.input-search-box');
    textBox.style.border = '2px solid #8a8a8a';

    if (textBox.value != '') {
        var url = new URL(window.location.href);
        var urlSearchParams = url.searchParams;
        urlSearchParams.set('page', '1');
        urlSearchParams.set('text', textBox.value.trim());
        urlSearchParams.set('display', 'on');
        url.search = urlSearchParams.toString();
        var newUrl = url.toString();
        window.location.href = newUrl;
    } else {
        textBox.style.border = '2px solid #F44336';
        setTimeout(() => {
            textBox.style.border = '2px solid #8a8a8a';
        }, 2000);
    }
}

function openStage(stageName) {
    var url = new URL(window.location.href);
    var urlSearchParams = url.searchParams;
    urlSearchParams.set('page', '1');
    urlSearchParams.set('stage', stageName);
    url.search = urlSearchParams.toString();
    var newUrl = url.toString();
    window.location.href = newUrl;
}

function selectTableDataId(id) {
    var currentSelectedTableDataId = document.querySelector('[table-data-id="'+id+'"]');
    if (currentSelectedTableDataId.getAttribute('table-data-selected') == 'true') {
        currentSelectedTableDataId.classList.remove('active');
        currentSelectedTableDataId.removeAttribute('table-data-selected');
    } else {
        currentSelectedTableDataId.classList.add('active');
        currentSelectedTableDataId.setAttribute('table-data-selected', 'true');
    }
}

var saveCurrentSelectedTableDataId = '';
function selectUserTableDataId(id) {
    var currentSelectedTableDataId = document.querySelector('[table-data-id="'+id+'"]');

    if (currentSelectedTableDataId.getAttribute('class') == 'table users blocked') {
        currentSelectedTableDataId.classList.add('active');
        currentSelectedTableDataId.setAttribute('table-data-selected', 'true');
    }

    else if (currentSelectedTableDataId.getAttribute('class') == 'table users unblocked') {
        currentSelectedTableDataId.classList.add('active');
        currentSelectedTableDataId.setAttribute('table-data-selected', 'true');
    }
    
    else {
        currentSelectedTableDataId.classList.remove('active');
        currentSelectedTableDataId.removeAttribute('table-data-selected');
    }
}

function markData(id, type) {
    var name = document.querySelector('#'+id).value;
    var allselectedTableDataId = document.querySelectorAll('[table-data-selected="true"]');
    var id = '';

    for (let i = 0; i < allselectedTableDataId.length; i++) {
        if (i === allselectedTableDataId.length - 1) {
            id += allselectedTableDataId[i].getAttribute('table-data-id');
        } else {
            id += allselectedTableDataId[i].getAttribute('table-data-id') + ',';
        }
    }

    if (id != '') {
        console.log(name);
        var http = new XMLHttpRequest();
        var url = '../requests/mark-data.php';
        var params = 'name='+name+'&type='+type+'&id='+id;
        http.open('POST', url, true);
        http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        http.onreadystatechange = function() {
            if(http.readyState == 4 && http.status == 200) {
                if (http.responseText != '') {
                    createNotification(http.responseText, 'error');

                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    createNotification('Marked successfully.', 'success');
    
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                }
            }
        }
        http.send(params);
    }
}

function markStage(modalId, selectId) {
    var currentSelect = document.querySelector('#'+selectId);
    var allselectedTableDataId = document.querySelectorAll('[table-data-selected="true"]');
    var id = '';

    for (let i = 0; i < allselectedTableDataId.length; i++) {
        if (i === allselectedTableDataId.length - 1) {
            id += allselectedTableDataId[i].getAttribute('table-data-id');
        } else {
            id += allselectedTableDataId[i].getAttribute('table-data-id') + ',';
        }
    }

    // console.log(currentSelect.value);
    if ((currentSelect.value != '') && (id != '')) {
        var modalMain = document.querySelector('#'+modalId);
        var modalContainer = modalMain.querySelector('.modal-container');
        var modalInputs = modalMain.getElementsByTagName('textarea');
        console.log(modalInputs);
        for (var i = 0; i < modalInputs.length; i++) {
            modalInputs[i].value = '';
            modalInputs[i].style.border = '2px solid #8a8a8a';
        }
        modalContainer.style.animation = 'openModal 0.3s forwards ease';
        setTimeout(() => {
            modalMain.style.display = 'flex';
        }, 400);
    }
}

function markSingleStage(clientId, modalId, selectId) {
    var currentSelect = document.querySelector('#'+selectId);
    var id = clientId;

    // console.log(currentSelect.value);
    if ((currentSelect.value != '') && (id != '')) {
        var modalMain = document.querySelector('#'+modalId);
        var modalContainer = modalMain.querySelector('.modal-container');
        var modalInputs = modalMain.getElementsByTagName('textarea');
        console.log(modalInputs);
        for (var i = 0; i < modalInputs.length; i++) {
            modalInputs[i].value = '';
            modalInputs[i].style.border = '2px solid #8a8a8a';
        }
        modalContainer.style.animation = 'openModal 0.3s forwards ease';
        setTimeout(() => {
            modalMain.style.display = 'flex';
        }, 400);
    }
}

function markComplaintSingleStatus(clientId, selectId) {
    var currentSelect = document.querySelector('#'+selectId);
    if (currentSelect.value != '') {
        var http = new XMLHttpRequest();
        var url = '../requests/mark-complaint-status.php';
        var params = 'clientId='+clientId+'&statusId='+currentSelect.value;
        http.open('POST', url, true);
        http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        http.onreadystatechange = function() {
            if(http.readyState == 4 && http.status == 200) {
                console.log(http.responseText);
                if (http.responseText == '') {
                    setTimeout(() => {
                        createNotification('Marked successfully.', 'success');
    
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    }, 1000);
                } else {
                    createNotification('Not marked.', 'error');

                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                }
            }
        }
        http.send(params);
    }
}

function markDrop(modalId) {
    var allselectedTableDataId = document.querySelectorAll('[table-data-selected="true"]');
    var id = '';

    for (let i = 0; i < allselectedTableDataId.length; i++) {
        if (i === allselectedTableDataId.length - 1) {
            id += allselectedTableDataId[i].getAttribute('table-data-id');
        } else {
            id += allselectedTableDataId[i].getAttribute('table-data-id') + ',';
        }
    }

    // console.log(currentSelect.value);
    if ((id != '')) {
        var modalMain = document.querySelector('#'+modalId);
        var modalContainer = modalMain.querySelector('.modal-container');
        var modalInputs = modalMain.getElementsByTagName('textarea');
        console.log(modalInputs);
        for (var i = 0; i < modalInputs.length; i++) {
            modalInputs[i].value = '';
            modalInputs[i].style.border = '2px solid #8a8a8a';
        }
        modalContainer.style.animation = 'openModal 0.3s forwards ease';
        setTimeout(() => {
            modalMain.style.display = 'flex';
        }, 400);
    }
}

function restoreData() {
    var restoreButton = document.querySelector('#restore');
    var allselectedTableDataId = document.querySelectorAll('[table-data-selected="true"]');
    var id = '';

    for (let i = 0; i < allselectedTableDataId.length; i++) {
        if (i === allselectedTableDataId.length - 1) {
            id += allselectedTableDataId[i].getAttribute('table-data-id');
        } else {
            id += allselectedTableDataId[i].getAttribute('table-data-id') + ',';
        }
    }

    if (id != '') {
        restoreButton.innerHTML = 'Restoring';
        restoreButton.removeAttribute('onclick');

        var http = new XMLHttpRequest();
        var url = '../requests/restore-data.php';
        var params = 'id='+id;
        http.open('POST', url, true);
        http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        http.onreadystatechange = function() {
            if(http.readyState == 4 && http.status == 200) {
                if (http.responseText != '') {
                    setTimeout(() => {
                        restoreButton.innerHTML = 'Restored';
    
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);                    
                    }, 1000);
                }
            }
        }
        http.send(params);
    }
}

function holdUser() {
    var holdButton = document.querySelector('#hold');
    var allselectedTableDataId = document.querySelectorAll('[table-data-selected="true"]');
    var id = '';

    for (let i = 0; i < allselectedTableDataId.length; i++) {
        if (i === allselectedTableDataId.length - 1) {
            id += allselectedTableDataId[i].getAttribute('table-data-id');
        } else {
            id += allselectedTableDataId[i].getAttribute('table-data-id') + ',';
        }
    }

    if (id != '') {
        holdButton.innerHTML = 'Blocking';
        holdButton.removeAttribute('onclick');

        var http = new XMLHttpRequest();
        var url = '../requests/hold-user.php';
        var params = 'id='+id;
        http.open('POST', url, true);
        http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        http.onreadystatechange = function() {
            if(http.readyState == 4 && http.status == 200) {
                if (http.responseText != '') {
                    setTimeout(() => {
                        holdButton.innerHTML = 'Blocked';
    
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);                    
                    }, 1000);
                }
            }
        }
        http.send(params);
    }
}

function unHoldUser() {
    var unHoldButton = document.querySelector('#un-hold');
    var allselectedTableDataId = document.querySelectorAll('[table-data-selected="true"]');
    var id = '';

    for (let i = 0; i < allselectedTableDataId.length; i++) {
        if (i === allselectedTableDataId.length - 1) {
            id += allselectedTableDataId[i].getAttribute('table-data-id');
        } else {
            id += allselectedTableDataId[i].getAttribute('table-data-id') + ',';
        }
    }

    if (id != '') {
        unHoldButton.innerHTML = 'Unblocking';
        unHoldButton.removeAttribute('onclick');

        var http = new XMLHttpRequest();
        var url = '../requests/un-hold-user.php';
        var params = 'id='+id;
        http.open('POST', url, true);
        http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        http.onreadystatechange = function() {
            if(http.readyState == 4 && http.status == 200) {
                if (http.responseText != '') {
                    setTimeout(() => {
                        unHoldButton.innerHTML = 'Unblocked';
    
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);                    
                    }, 1000);
                }
            }
        }
        http.send(params);
    }
}

function addUser() {
    window.location.href = '../views/add-user.php';
}

function editUser() {
    if (document.querySelectorAll('[table-data-selected="true"]')[0] !== undefined) {
        var currentSelectedTableDataId = document.querySelectorAll('[table-data-selected="true"]')[0];
        var userId = currentSelectedTableDataId.getAttribute('table-data-id');

        window.location.href = '../views/edit-user.php?userId='+userId;
    }
}

function viewTimeline(formId) {
    window.location.href = '../views/timeline.php?clientId='+formId;
}

function viewComplaintTimeline(formId) {
    window.location.href = '../views/timeline-complaint.php?formId='+formId;
}


function displayForm(clientId) {
    var currentProcessButton = document.querySelector('#process-button-' + clientId);
    
    if (currentProcessButton.getAttribute('data-selected') == 'false') {
        currentProcessButton.innerText = 'Loading...';

        var http = new XMLHttpRequest();
        var url = '../requests/view-form.php';
        var params = 'clientId='+clientId+'&formId=&request=hover';
        http.open('POST', url, true);
        http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        http.onreadystatechange = function() {
            if(http.readyState == 4 && http.status == 200) {
                setTimeout(() => {
                    var allForm = this.response.split("||");

                    var content = '';
                    for (var i = 0; i < allForm.length-1; i++) {
                        var formName = allForm[i].split("=")[0];
                        var formId = allForm[i].split("=")[1];
                        content += '<a href="../views/form.php?clientId='+clientId+'&formId='+formId+'&request=click" style="display: block">'+formName+'</a>';                        
                    }

                    if (formName != '') {
                        createViewFormBox(content, clientId);
                    } else {
                        createViewFormBox('No Forms Available', clientId);
                    }

                    currentProcessButton.setAttribute('data-selected', 'true');
                    currentProcessButton.innerHTML = 'View Form';
                }, 1000);
            }
        }
        http.send(params);
    } else {
        removeViewFormBox(clientId);
        currentProcessButton.setAttribute('data-selected', 'false');
    }
}

function createViewFormBox(data, id) {
    var viewFormBox = document.createElement('div');
    viewFormBox.setAttribute('class', 'view-form-box');
    viewFormBox.innerHTML = data;

    var appendIn = document.querySelector('#process-button-'+id).parentNode.querySelector('.view-form-box-main');
    appendIn.appendChild(viewFormBox);
    appendIn.classList.add('active');
}

function removeViewFormBox(id) {
    var appendIn = document.querySelector('#process-button-'+id).parentNode.querySelector('.view-form-box-main');
    appendIn.innerHTML = '';
    appendIn.classList.remove('active');
}

function exportData(csv) {
    if (csv == '') {
        var url = new URL(window.location.href);
        var urlSearchParams = url.searchParams;
        urlSearchParams.set('export', 'true');
        url.search = urlSearchParams.toString();
        var newUrl = url.toString();
        window.location.href = newUrl;
    }
}

function updateInterestedTimeline(id) {
    var interestedButton = document.querySelector('#interested-'+id);
    
    interestedButton.removeAttribute('onclick');
    interestedButton.innerHTML = 'Adding...';

    var http = new XMLHttpRequest();
    var url = '../requests/update-interested.php';
    var params = 'clientId='+id+'&message=Interested&type=comment';
    http.open('POST', url, true);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.onreadystatechange = function() {
        if(http.readyState == 4 && http.status == 200) {
            console.log(http.responseText);
            if (http.responseText == 'Comment Added') {
                setTimeout(() => {
                    interestedButton.innerHTML = 'Added';
                    
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                }, 1000);
            }
        }
    }
    http.send(params);
}

function updateNotInterestedTimeline(id) {
    var notInterestedButton = document.querySelector('#not-interested-'+id);
    var notInterestedMessage = document.querySelector('#not-interested-message-'+id);
    
    console.log(notInterestedButton.value);

    if (notInterestedButton.value != '') {
        notInterestedButton.removeAttribute('onchange');
        notInterestedMessage.innerHTML = 'Dropping...';

        var http = new XMLHttpRequest();
        var url = '../requests/update-not-interested.php';
        var params = 'clientId='+id+'&message='+notInterestedButton.value+'&type=comment';
        http.open('POST', url, true);
        http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        http.onreadystatechange = function() {
            if(http.readyState == 4 && http.status == 200) {
                console.log(http.responseText);
                if (http.responseText == 'Data Dropped') {
                    setTimeout(() => {
                        notInterestedMessage.innerHTML = 'Dropped';
                        
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    }, 1000);
                }
            }
        }
        http.send(params);
    }
}

function capturePayment(formId, paymentId) {
    var captureButton = document.querySelector('#capture-button-'+formId);
    captureButton.innerText = '(Capturing...)';

    var http = new XMLHttpRequest();
    var url = '../requests/capture-payment.php';
    var params = 'clientId='+formId+'&paymentId='+paymentId;
    http.open('POST', url, true);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.onreadystatechange = function() {
        if(http.readyState == 4 && http.status == 200) {
            console.log(http.responseText);
            if (http.responseText == 'Payment Captured') {
                setTimeout(() => {
                    captureButton.innerText = '(Captured)';
                    
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                }, 1000);
            }
        }
    }
    http.send(params);
}