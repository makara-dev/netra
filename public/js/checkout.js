$(document).ready(function(){
    changeCartBreadCrumbCircle();
    
    showInputOnDropDownSelect();
    
    validateUserPhoneNumber();
    validateAddress();

    onDistrictSelectGetSangkat(ApiUrl, ApiToken);
    onSelecteSangkatChangeTotal();


    //bind dropdown quantity btn
    $('.quantity-btn').on('click', disableProduct);
});

/**
 * Change dropdown select to number input on 10+ quantity select
 * @param   None
 * @returns Nothing
 */
//change dropdown select to Number input on 10+ quantity select
function showInputOnDropDownSelect() {
    $('.dropdown_10').on('click', function(){
    currentValue = $(this).val();
    dropdown = $(this).parent().parent();
    
    form = $(dropdown).siblings('.form-update');
    formId = $(form).attr('id');
    
    wrapper = $('<div></div>')
        .addClass('input-group form-inline');

    label = $('<label></label>')
        .attr('for','quantity')
        .appendTo(wrapper);

    quantityInput = $('<input>')
        .addClass('form-control')
        .attr('name', 'quantity')
        .attr('type','number')
        .attr('value', currentValue)
        .attr('min', 1)
        .attr('form', formId)
        .appendTo(wrapper);
    
    btnWrapper = $('<div></div>')
        .addClass('input-group-append')
        .appendTo(wrapper);

    btn = $('<button></button>')
        .addClass('btn btn-sm btn-primary')
        .attr('type', 'submit')
        .attr('form',formId)
        .html('update quantity')
        .appendTo(btnWrapper);
    
    dropdown.replaceWith(wrapper);
    
    //bind disableProduct onclick event to the update button 
    $(btn).on('click', function(){
        quantity = $(this).parent().siblings("[name='quantity']").val(); //get nearest quantity input
        if( quantity > 0){
            disableProduct();
        }
    });
});
}

/**
 * Disable item on quantity select
 * @param   None
 * @returns Nothing
 */
//disable item on quantity select
function disableProduct(){
    productRow = $('#cartItemRow');   
    $(productRow).addClass('disable-div');
}

/**
 * Add and Remove Cart BreadCrumb
 * @param   None
 * @returns Nothing
 */
function changeCartBreadCrumbCircle(){
    // add and remove cart breadcrumb
    $('.node-1').removeClass('circle-node-active');
    $('.node-1').addClass('circle-node-checked');
    $('.node-2').addClass('circle-node-active');
}

/**
 * Validate phone number and change style
 */
function validateUserPhoneNumber(){
    $('#phone').samask('0000000000')
    $('input[name=paymentRadio]:checked').parent().siblings('.custom-radio-btn').addClass('blue-shadow');
    //remove (-) from phone  input
    $('#phone').on('input', function(){
        phone = $('#phone');

        tel = phone.val();
        tel = tel.replace(/\D/g,'');

        customValidity = (tel.length > 8 && tel.length < 11) ? "" : "Invalid phone number. Valid format is (xxx xxx xxxx or xxx xxx xxxx)";   
        $(phone)[0].setCustomValidity(customValidity)
    });
    $('#form').on('submit',function(){
        phone = $('#phone');

        tel = phone.val();
        tel = tel.replace(/\D/g,'');

        phone.val(tel);
    });
}

/**
 * Get Sangkat by District id
 * @param [Api_Url] API_URL
 * @param [Api_Token] API_TOKEN
 */
function onDistrictSelectGetSangkat(API_URL, API_TOKEN) {
    $('#select-district').on('change', function (e) {
        e.preventDefault();

        district_id = $(this).val();
        dliveryFeeText = $('#dilvery-fee');
        mainUrl = API_URL + '/districts/sangkats/' + district_id;

        // set everything to default
        if ($(this).val() == 0) {
            $('#select-sangkat').empty();

            dliveryFeeText = $('#dilvery-fee').text('0 $');

            defaultTotal = $('#default-total').val();
            $('#total-price').text(defaultTotal);

            selectSangkat.append(new Option('Choose Sangkat', $(this).val(), true, true));
        } else {
            // start ajax request
            $.ajax({
                url: mainUrl,
                type: 'GET',
                data: { _token: API_TOKEN },
                dataType: 'JSON',
                error: function (data) {
                    alert('something went wrong, try refreshing the page.');
                    console.log('Something wrong while trying to get Sangkats!');
                },
                success: function (response) {
                    generateSangkat(response.message);
                }
            });
        }
    });
}

/**
 * Generate option of Sangkat selected tag
 * @param [Json_Data_Messages] sangkats
 * @returns Nothing 
 */
function generateSangkat(sangkats) {
    dliveryFeeText = $('#dilvery-fee');
    selectSangkat = $('#select-sangkat');

    selectSangkat.empty();

    // set everything to default
    if (sangkats.length == 0) {
        selectSangkat.append(new Option('No Sangkat Found', sangkats.length, true, true));

        defaultTotal = $('#default-total').val();
        $('#total-price').text(defaultTotal);

        dliveryFeeText.text('0 $');
    } else {
        sangkats.forEach(sangkat => {
            option = $('<option/>');
            option.attr({
                'id': sangkat.delivery_fee,
                'value': sangkat.sangkat_id
            }).text(sangkat.sangkat_name);

            selectSangkat.append(option);
        });

        dliveryFeeText.text(parseFloat(sangkats[0].delivery_fee) + ' $');

        // set total price
        currentTotal = parseFloat($('#total-price').text().replace(/\,/g , ''));
        deliverFee = parseFloat(sangkats[0].delivery_fee);
        total = currentTotal + deliverFee;
        
        $('#total-price').text(total.toFixed(2));
    }
}

/**
 * Calculate and set delivery and total price on selected sangkat
 * @param   None
 * @returns Nothing
 */
function onSelecteSangkatChangeTotal() {
    currentTotal = parseFloat( $('#total-price').text().replace(/\,/g , '') );
        
    $('#select-sangkat').on('change', function () {
        sangkatPrice = parseFloat($(this).children(':selected').attr('id'));
        total = currentTotal + sangkatPrice;

        $('#dilvery-fee').text(sangkatPrice + ' $');
        $('#total-price').text(total.toFixed(2));
    });
}

/**
 * Validate Sangkats, Destrict and Address before process submit
 * @param   None
 * @returns Nothing
*/
function validateAddress(){
    $('#form-checkout').submit(function () {
        district = $('#select-district').val();
        if (district == 0) {
            alert('Please provide us your District and Sangkat before order');
            return false;
        }
        if ($('#address').val().length == 0) {
            confirm = confirm("Consider provide us your address for better connection service.");
            if (confirm) {
                return false;
            }
        }
    });
}