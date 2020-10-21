function addBusiness() {
    var addButton = document.querySelector('.add-button');

    var businessName = document.querySelector('#business-name');

    if (businessName.value != '') {
        addButton.innerHTML = 'Adding';
        addButton.removeAttribute('onclick');

        var http = new XMLHttpRequest();
        var url = '../requests/add-business.php';
        var params = 'businessName='+businessName.value;
        http.open('POST', url, true);
        http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        http.onreadystatechange = function() {
            if(http.readyState == 4 && http.status == 200) {
                console.log(http.responseText);
                if (http.responseText == 'Business Inserted') {
                    setTimeout(() => {
                        addButton.innerHTML = 'Added';

                        setTimeout(() => {
                            // addButton.innerHTML = 'Add New';
                            // addButton.setAttribute('onclick', 'addUser()');  
                            window.location.reload();
                        }, 1000);
                    }, 1000);
                } else {
                    setTimeout(() => {
                        addButton.innerHTML = http.responseText;
                        addButton.setAttribute('class', 'add-button error');

                        setTimeout(() => {
                            addButton.innerHTML = 'Add';
                            addButton.setAttribute('class', 'add-button');
                            addButton.setAttribute('onclick', 'addBusiness()');  
                            // window.location.reload();                          
                        }, 2000);
                    }, 1000);
                }
            }
        }
        http.send(params);
        
        // console.log(roleId, teamId);
    }
}