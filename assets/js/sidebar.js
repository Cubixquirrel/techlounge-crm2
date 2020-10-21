var sidebar = document.querySelector('#sidebar');
var sidebarMenuOpen = document.querySelector('#sidebar-menu-open');
var sidebarMenuClose = document.querySelector('#sidebar-menu-close');
var sidebarShadow = document.querySelector('.sidebar-shadow');

function swapSidebar(state) {
    if (state == 'open') {
        sidebar.style.transform = 'translateX(0%)';
        sidebarShadow.style.display = 'block';  
    } else if (state == 'close') {
        sidebar.style.transform = 'translateX(-100%)';
        setTimeout(() => {
            sidebarShadow.style.display = 'none';            
        }, 250);
    }
}

function openViews(pageLink) {
    window.location.href = '../views/'+pageLink;
}

function swicthFilter() {
    var sortingMain = document.querySelector('.sorting-main');
    var openFilter = document.querySelector('.open-filter');

    if (sortingMain.getAttribute('style') == 'display: none;') {
        sortingMain.setAttribute('style', 'display: block;');
        openFilter.innerHTML = 'Close Filter';
    } else {
        sortingMain.setAttribute('style', 'display: none;');
        openFilter.innerHTML = 'Open Filter';
    }
}

document.addEventListener("DOMContentLoaded", function(event) {
    var sortingMain = document.querySelector('.sorting-main');
    var openFilter = document.querySelector('.open-filter');

    var url = new URL(window.location.href);
    var urlSearchParams = url.searchParams;

    urlSearchParams.forEach(function(value, index) {
        if (urlSearchParams.get(index) !== null) {
            if (
                ((index == 'website') && (value != 'ALL')) || 
                ((index == 'status') && (value != 'ALL')) || 
                ((index == 'payStatus') && (value != 'ALL')) || 
                ((index == 'payVendor') && (value != 'ALL')) || 
                ((index == 'amount') && (value != 'ALL')) || 
                ((index == 'sales') && (value != 'ALL')) || 
                ((index == 'processor') && (value != 'ALL'))
            ) {
                sortingMain.setAttribute('style', 'display: block;');
                openFilter.innerHTML = 'Close Filter';
            }
        }
    });
});