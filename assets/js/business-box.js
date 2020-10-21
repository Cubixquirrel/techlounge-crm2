function openViewsWithBusiness(businessName) {
    var url = new URL(window.location.href);
    var urlSearchParams = url.searchParams;
    urlSearchParams.set('page', '1');
    urlSearchParams.set('business', businessName);
    urlSearchParams.set('website', 'ALL');
    urlSearchParams.set('status', 'ALL');
    urlSearchParams.set('payVendor', 'ALL');
    urlSearchParams.set('amount', 'ALL');
    urlSearchParams.set('sales', 'ALL');
    urlSearchParams.set('processor', 'ALL');
    urlSearchParams.delete('stage');

    url.search = urlSearchParams.toString();
    var newUrl = url.toString();
    window.location.href = newUrl;
}