<script>
    if (document.querySelector('.pagination-box') !== null) {
        var paginationBox = document.querySelector('.pagination-box');
        var paginationBoxBottom = document.querySelector('.pagination-box.bottom');
        var pageNumberBox = paginationBox.innerHTML.split(',');
        paginationBox.innerHTML = '';
        paginationBoxBottom.innerHTML = '';

        var url = new URL(window.location.href);
        var urlSearchParams = url.searchParams;

        pageNumberBox.forEach(element => {
            if (urlSearchParams.get('text') !== null) {
                var href = '<?php echo $_SERVER["PHP_SELF"]; ?>?page='+element+'&business=<?php echo $_GET["business"]; ?>&website=<?php echo $_GET["website"]; ?>&fromDate=<?php echo $_GET["fromDate"]; ?>&toDate=<?php echo $_GET["toDate"]; ?>&orderBy=<?php echo $_GET["orderBy"]; ?>&text='+urlSearchParams.get('text')+'';
            } else {
                var href = '<?php echo $_SERVER["PHP_SELF"]; ?>?page='+element+'&business=<?php echo $_GET["business"]; ?>&website=<?php echo $_GET["website"]; ?>&fromDate=<?php echo $_GET["fromDate"]; ?>&toDate=<?php echo $_GET["toDate"]; ?>&orderBy=<?php echo $_GET["orderBy"]; ?>';
            }

            if (element == '..') {
                paginationBox.innerHTML += '<a class="page-number-box inactive">'+element+'</a>';
                paginationBoxBottom.innerHTML += '<a class="page-number-box inactive">'+element+'</a>';
            } else {
                if (element == '<?php echo $page; ?>') {
                    paginationBox.innerHTML += '<a class="page-number-box active" href="'+href+'">'+element+'</a>';
                    paginationBoxBottom.innerHTML += '<a class="page-number-box active" href="'+href+'">'+element+'</a>';
                } else {
                    paginationBox.innerHTML += '<a class="page-number-box" href="'+href+'">'+element+'</a>';
                    paginationBoxBottom.innerHTML += '<a class="page-number-box" href="'+href+'">'+element+'</a>';
                }
            }    
        });
    }
</script>