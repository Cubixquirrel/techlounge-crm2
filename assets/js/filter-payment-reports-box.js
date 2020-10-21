function filterParam() {
    var payVendor = document.querySelector('#filter-pay-vendor').value;
    var payStatus = document.querySelector('#filter-pay-status').value;

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
    urlSearchParams.set('payVendor', payVendor);
    urlSearchParams.set('payStatus', payStatus);

    urlSearchParams.set('fromDate', fromDate);
    urlSearchParams.set('toDate', toDate);

    urlSearchParams.set('orderBy', orderBy);

    url.search = urlSearchParams.toString();
    var newUrl = url.toString();
    window.location.href = newUrl;
}