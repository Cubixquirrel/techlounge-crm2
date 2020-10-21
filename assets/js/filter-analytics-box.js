function filterParam() {
    var website = document.querySelector('#filter-website').value;
    var status = document.querySelector('#filter-status').value;

    var filterFromDate = document.querySelector('#filter-from-date').value;
    var filterFromMonth = document.querySelector('#filter-from-month').value;
    var filterFromYear = document.querySelector('#filter-from-year').value;
    var filterToDate = document.querySelector('#filter-to-date').value;
    var filterToMonth = document.querySelector('#filter-to-month').value;
    var filterToYear = document.querySelector('#filter-to-year').value;

    var fromDate = filterFromDate+'-'+filterFromMonth+'-'+filterFromYear;
    var toDate = filterToDate+'-'+filterToMonth+'-'+filterToYear;

    var orderBy = document.querySelector('#filter-order-by').value;

    var url = new URL(window.location.href);
    var urlSearchParams = url.searchParams;
    urlSearchParams.set('page', '1');
    urlSearchParams.set('website', website);
    urlSearchParams.set('status', status);

    urlSearchParams.set('fromDate', fromDate);
    urlSearchParams.set('toDate', toDate);

    urlSearchParams.set('orderBy', orderBy);

    url.search = urlSearchParams.toString();
    var newUrl = url.toString();
    window.location.href = newUrl;
}