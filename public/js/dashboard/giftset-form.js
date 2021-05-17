$(document).ready(function(){
    // important variable and store number of pagination that 
    // containe array of product variants
    paginationPageName = 'paginationPage';

    // find table element in the page return null if not exist
    document.querySelector("table").addEventListener("click", ({target}) => {
        // discard direct clicks on input elements
        if (target.nodeName === "INPUT") return;
        // get the nearest tr
        const tr = target.closest("tr");
        if (tr) {
            // if it exists, get the first checkbox
            const checkbox = tr.querySelector("input[type='checkbox']");
            if(checkbox){
                checkbox.checked = !checkbox.checked;
                // get current active pagination
                currentActivePage = $('.pagination').find('li.active').text();
                onCheckedUpdatePvSession(ApiUrl, ApiToken, currentActivePage, checkbox.value, checkbox.checked, paginationPageName);
            } 
        }
    });

    checkPaginationPageSessionBeforeSubmit(ApiUrl, ApiToken, paginationPageName);
});

/**
 * Store ProductVariant id into session on checked == true.
 * @param [Api_Url] API_URL
 * @param [Api_Token] API_TOKEN
 * @param [Integer] currentPagination
 * @param [Integer] productVariantId
 * @param [String] checkboxStatus
 * @return ...
 */
function onCheckedUpdatePvSession(API_URL, API_TOKEN, currentPagination, productVariantId, checboxStatus, paginationPageName){
    mainUrl = API_URL + '/giftset/productvariant/' + currentPagination +'/'+  productVariantId +'/'+ checboxStatus + '/' + paginationPageName;
    $.ajax({
        url: mainUrl,
        type: 'GET',
        data: { _token: API_TOKEN },
        dataType: 'JSON',
        error: function (data) {
            alert('something went wrong, try refreshing the page.');
            console.log('Something wrong while trying to store productvariant into session!');
        },
        success: function (response) {
            // update the hidden of productVariant[] input
            $('#productVariants').val(response.message);
        }
    });
}

/**
 * Check session storage of pagination page number before process submit.
 * @return [Boolean] true on submit / false on alert message
 */
function checkPaginationPageSessionBeforeSubmit(API_URL, API_TOKEN, paginationPageName){
    $('#submit-btn').on('click', function(){
        var testing = false;
        mainUrl = API_URL + '/giftset/productvariant/getDataSession/' + paginationPageName;
        $.ajax({
            url: mainUrl,
            type: 'GET',
            data: { _token: API_TOKEN },
            async: false,
            dataType: 'JSON',
            error: function (data) {
                alert('something went wrong, try refreshing the page.');
                console.log('Something when wrong while trying to get pagination from server session!');
            },
            success: function (response) {
                var paginationDaraArr = response;
                if(paginationDaraArr == null || response.length == 0) {
                    alert('Please check product variants before process submit!');
                } else {
                    testing = true;
                    $(this).trigger('submit');
                }
            }
        });
        return testing;
    });
}