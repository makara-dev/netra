attributeValueDropdown = $('.attribute-value-select');
$(attributeValueDropdown).on(
    {
        "focus": function () {
            this.selectedIndex = -1;
        }
        , "change": function () {
            this.blur();  //unfocus on the input so same choice selection would still fire
            getProductVariantStock();
        }
    }
);

//might cause error
$(document).ready(function(){
    getProductVariantStock();
    onloadChangeProductSelectedAttribute();
});

function getProductVariantStock() {
    let attributeValues = $.map(
        $(attributeValueDropdown),
        function (item) {
            return item.value;
        }
    );
    
    productId = $('[name=product]').val();

    //for hidden color
    colorId = $('[name=color]').val();
    if (colorId) {
        attributeValues.push(colorId);
    }
    //for product with no variant
    if(attributeValues && attributeValues.length !== 0){
        sendStockCheckRequest(apiUrl, apiToken, attributeValues, productId);
    }
}

function sendStockCheckRequest(url, token, attributeValuesId, productId) {

    $('#productAlert').html('');

    $.ajax({
        url: url,
        type: 'POST',
        data: {
            _token: token,
            product: productId,
            attributeValues: attributeValuesId
        },
        dataType: 'JSON',
        error: function () {
            alert('something went wrong, Try refreshing the page.');
        },
        success: function (data) {
            if (data.status === 'error') {
                alert('Server Error No Product Found.')
            } else {
                
                $('#product-price').html('$'+data.message[1]);
                $('#productAlert').html(data.message[0]);
                if (data.status === 'failed') {
                    $('#productAlert').removeClass('btn-outline-success')
                    $('#productAlert').addClass('btn-outline-danger')
                } else {
                    $('#productAlert').removeClass('btn-outline-danger')
                    $('#productAlert').addClass('btn-outline-success')
                }
            }
        }
    });
}

function onloadChangeProductSelectedAttribute(){
    prAttr1Id = $('#prAttr1').val();
    prAttr2Id = $('#prAttr2').val();

    prAttr1Id.length != 0 ? triggerAttributeSelectedOption('#myopia', prAttr1Id) : null;
    prAttr2Id.length != 0 ? triggerAttributeSelectedOption('#disposal', prAttr2Id) : null;
}

// Trigger the attribute selected option by attributeId
function triggerAttributeSelectedOption(attrTagId, attrId){
    $(attrTagId).val(attrId)
        .prop('selected',true)
        .trigger('change');  
}