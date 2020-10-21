function filterParam() {
    var website = document.querySelector('#filter-website').value;
    var status = document.querySelector('#filter-status') !== null;
    var payVendor = document.querySelector('#filter-pay-vendor') !== null;
    var amount = document.querySelector('#filter-amount').value;
    var assignedTo = document.querySelector('#filter-assigned-to') !== null;
    var processor = document.querySelector('#filter-processor') !== null;

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
    urlSearchParams.set('payVendor', payVendor);
    urlSearchParams.set('amount', amount);
    if (status) {
        var newStatus = document.querySelector('#filter-status').value;
        urlSearchParams.set('status', newStatus);
    } else {
        urlSearchParams.set('status', 'ALL');
    }
    if (payVendor) {
        var newPayVendor = document.querySelector('#filter-pay-vendor').value;
        urlSearchParams.set('payVendor', newPayVendor);
    } else {
        urlSearchParams.set('payVendor', 'ALL');
    }
    if (assignedTo) {
        var newAssignedTo = document.querySelector('#filter-assigned-to').value;
        urlSearchParams.set('sales', newAssignedTo);
    } else {
        urlSearchParams.set('sales', 'ALL');
    }
    if (processor) {
        var newProcessor = document.querySelector('#filter-processor').value;
        urlSearchParams.set('processor', newProcessor);
    } else {
        urlSearchParams.set('processor', 'ALL');
    }

    urlSearchParams.set('fromDate', fromDate);
    urlSearchParams.set('toDate', toDate);

    urlSearchParams.set('orderBy', orderBy);

    url.search = urlSearchParams.toString();
    var newUrl = url.toString();
    window.location.href = newUrl;
}