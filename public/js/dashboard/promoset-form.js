$(document).ready(function(){
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

// =====================================================
//      JS Of Promoset Adding Product Variant Page 
// =====================================================

/**
 * Store ProductVariant id into session on checked == true.
 * @param [Api_Url] API_URL
 * @param [Api_Token] API_TOKEN
 * @param [Integer] currentPagination
 * @param [Integer] productVariantId
 * @param [String] checkboxStatus
 * @param [String] paginationPageName
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


// ===================================
//      JS Of Promoset Add Page 
// ===================================

/**
 * Check promoset discount offer checkbox to enable or disable the input.
 * @param [Dom_Element_Id] checkboxId
 * @param [Dom_Element_Id] tagToHideId
 * @param [Dom_Element_Id] tagToShowId
 * @return void
 */
function onCheckboxCheckEnableDiscountPrice(checkboxId, tagToHideId, tagToShowId) {
    var hidingTag  = $(tagToHideId);
    var showingTag = $(tagToShowId);

    $(checkboxId).on("click", function(){
        var isCheck = $(this).is(':checked');
        
        if(isCheck) { // hide text and show input on true
            hidingTag.addClass("d-none");
            showingTag.removeClass("d-none");
        } else {
            hidingTag.removeClass("d-none");
            showingTag.addClass("d-none");
        }
    })
}

/**
 * Validate data and create a list of giftset table
 * @param [Dom_Element_Id] btnAddId
 * @param [Dom_Element_Id] thumbnailId
 * @param [Dom_Element_Id] setName
 * @param [Dom_Element_Id] purchaseNumId
 * @param [Dom_Element_Id] freeNumId
 * @param [Dom_Element_Id] offerNumId
 * @param [Dom_Element_Id] descriptionSetId
 * @return void
 */
function onClickCreatePromosetListTable(btnAddId, thumbnailId, setName, purchaseNumId, 
                                        freeNumId, offerNumId, descriptionSetId, freePvId) 
{
    $(btnAddId).on("click", function(){
        // validate require fields
        isFieldsValidate = onAddBtnCheckRequireFields(setName, purchaseNumId, freeNumId, offerNumId, freePvId);
        
        // validate null thumbnail
        setThumbnail = onAddBtnCheckNullImage(thumbnailId);

        if(isFieldsValidate && setThumbnail) {

            // update object
            isFieldsValidate.setDescription = $(descriptionSetId).val();
            isFieldsValidate.setThumbnail = setThumbnail;

            // generate list of table
            createSetTableData(isFieldsValidate);

            // clear all fields
            clearAllInputSetData();

        } else {
            alert("Please Enter all Required Fields Before Add To Giftset List!");
        }
    });
}

/**
 * Check null thumbnail and generate warning on null return src if exist.
 * @param [Dom_Element_Id] thumbnailId
 * @warning [This function has no affect to adding process since it generate a 
 *           warning alert message but make to harm to the adding process]
 * @return String Image Path;
 */
function onAddBtnCheckNullImage(thumbnailId){
    if(document.getElementById(thumbnailId).files.length == 0) {
        alert("Please consider upload image before create giftset!");
        return false;
    } else {
        return $("#image-path").attr('src');
    }
}

/**
 * Check all given required fields.
 * @param [Dom_Element_Id] name 
 * @param [Dom_Element_Id] purchaseNum 
 * @param [Dom_Element_Id] freeNum 
 * @param [Dom_Element_Id] offerNum 
 * @return Boolean true/false
 */
function onAddBtnCheckRequireFields(name, purchaseNum, freeNum, offerNum, freePvId) {
    var setFields = new Object();
    var freePvArr = JSON.parse($(freePvId).val());

    // validate set name, set purchase and set free number
    if( $(name).val().length > 0 && 
        freePvArr.length > 0 &&
        $(purchaseNum).val().length > 0 && $(purchaseNum).val() >= 1 && 
        $(freeNum).val().length     > 0 && $(freeNum).val()     >= 1)
    {

        // check duplicate name 
        isDuplicate = false;
        $('.setDataName').each(function(){
            if($(this).text() == $(name).val()){
                alert("Name Already Exists Please Choose Another Name!")
                isDuplicate = true;
            }
        });
        
        if(!isDuplicate){
            // add into object
            setFields.setName        = $(name).val();
            setFields.setPurchaseNum = $(purchaseNum).val();
            setFields.setFreeNum     = $(freeNum).val();
            setFields.setFreePvArr   = freePvArr;
            
            // validate checkbox
            if( $('#discount-checkbox').is(':checked') ){
            if( $(offerNum).val().length > 0 && $(offerNum).val() >= 1 ) {
                setFields.setOfferNum = $(offerNum).val();
                return setFields;
            }
            return false;
            }
            return setFields;
        }
    }
    return false;
}

/**
 * Generate table of object attribute passed by paramter and inject into html 
 * @param [Object] tableBodyDataObj
 * @return void
 */
function createSetTableData(tableBodyDataObj){
    totalPurchasePv = $("#totalPurchasePv").val();
    placeHolderFileImage = $("#promoset-image");

    tbody = $("#list-set-body");

    // set row
    tr = $('<tr></tr>');
    
    td_setName = $("<td class='setDataName' style='vertical-align: middle; text-align: center;'></td>")
        .html(tableBodyDataObj.setName)
        .appendTo(tr);

    td_setPurchaseCondition = $("<td style='vertical-align: middle; text-align: center;'></td>")
        .html(tableBodyDataObj.setPurchaseNum)
        .appendTo(tr);
    
    td_TotalPurchasePv = $("<td style='vertical-align: middle; text-align: center;'></td>")
        .html(totalPurchasePv+'x')
        .appendTo(tr);

    td_setFreeCondition = $("<td style='vertical-align: middle; text-align: center;'></td>")
        .html(tableBodyDataObj.setFreeNum)
        .appendTo(tr);

    td_TotalFreePv = $("<td style='vertical-align: middle; text-align: center;'></td>")
        .html(tableBodyDataObj.setFreePvArr.length+'x')
        .appendTo(tr);
    
    td_discountOffer = $("<td style='vertical-align: middle; text-align: center;'></td>")
        .html( tableBodyDataObj.setOfferNum ? tableBodyDataObj.setOfferNum : "<span style='color: red;'>None</span>" )
        .appendTo(tr);
        
    td_setThumbnail = $("<td style='vertical-align: middle; text-align: center;'></td>")
        .html( tableBodyDataObj.setThumbnail ? "<img style='width: 50px;' src="+tableBodyDataObj.setThumbnail+">"  : "<span style='color: red;'>None</span>" )
        .appendTo(tr);
    
    td_delete = $("<td style='vertical-align: middle; text-align: center;'></td>")
        .addClass('cursor-pointer btn-delete')
        .html('DELETE')
        .appendTo(tr);

    // hiddent input for backend
    // set name
    purchaseNameInput = $('<input>')
        .attr('type', 'hidden')
        .attr('name', 'setNames[]')
        .attr('value', tableBodyDataObj.setName)
        .appendTo(tr);

    // condition purchase
    purchaseConditionInput = $('<input>')
        .attr('type', 'hidden')
        .attr('name', 'purchaseConditions[]')
        .attr('value', tableBodyDataObj.setPurchaseNum)
        .appendTo(tr);

    // condition free
    purchasePvInput = $('<input>')
        .attr('type', 'hidden')
        .attr('name', 'freeConditions[]')
        .attr('value', tableBodyDataObj.setFreeNum)
        .appendTo(tr);

    // free product variants id
    purchasePvInput = $('<input>')
        .attr('type', 'hidden')
        .attr('name', 'freePvIds[]')
        .attr('value', tableBodyDataObj.setFreePvArr)
        .appendTo(tr);

    // discount offer
    purchasePvInput = $('<input>')
        .attr('type', 'hidden')
        .attr('name', 'setDiscountOffers[]')
        .attr('value', tableBodyDataObj.setOfferNum)
        .appendTo(tr);

    // set thumbnail src
    purchasePvInput = $("#promoset-image").clone()
        .attr('name', 'setThumbnailFile[]')
        .appendTo(tr);

    // set description
    purchasePvInput = $('<input>')
        .attr('type', 'hidden')
        .attr('name', 'setDescriptions[]')
        .attr('value', tableBodyDataObj.setDescription)
        .appendTo(tr);

    // bind everything into list set body
    tbody.append(tr);

    // bind delete event to btn
    $(".btn-delete").on("click", function () {
        $(this).closest('tr').remove();
    });
}

/**
 * Check or Uncheck free product variants on modal popup table row
 * @param ...
 * @return ...
 */
function onFreePvRowClickedAddProductVariantArr(){
    $('.pv-data-row').on('click', function(){
        // get checkbox inside selected td by id
        id = $(this).children().first().text();
        checkbox = $('#pvFreeCheckbox'+id);
        
        tempFreePvArr = JSON.parse( $("#temp-free-pv-arr").val() );

        if(checkbox.is(':checked')) {
            // remove freePvId from array
            filterFreePvArr = tempFreePvArr.filter(tempFreePv => tempFreePv !== checkbox.val());
            // update tag
            $('#temp-free-pv-arr').val(JSON.stringify(filterFreePvArr));
            // unset checkbox
            checkbox.prop('checked', false);

        } else {
            // add freePvId to array
            tempFreePvArr.push(checkbox.val());
            // update tag
            $('#temp-free-pv-arr').val(JSON.stringify(tempFreePvArr));
            // set checkbox
            checkbox.prop('checked', true);
        }
    })
}

/**
 * Bind event into modal popup cancel and done button.
 * @param [Dom_Element_Class] doneBtnClass
 * @param [Dom_Element_Class] cancelBtnClass
 * @return void
 */
function modelConfirmBtn(doneBtnClass, cancelBtnClass){

    // confirm, ok, done, create ... buttons event
    $(doneBtnClass).on('click', function(){
        freePvArr = JSON.parse( $("#temp-free-pv-arr").val() );

        // check empty array
        if(freePvArr.length  > 0){
            // replace choose product button to total selected product variants
            $("#hiddenTotalFreePv").removeClass('d-none');
            // set value to tag
            $("#freePvProviders").val(JSON.stringify(freePvArr));
            $("#totalFreePvId").text(freePvArr.length);

            // hide model popup
            $("#freePvModal").modal("hide");

        } else {
            // set total productvariants to 0
            $("#freePvProviders").val('[]');
            $("#totalFreePvId").text(freePvArr.length);

            alert('Please choose product to continue!');
        }
    });

    // cancel, close, undo ... buttons event
    $(cancelBtnClass).on('click', function(){
        freePvArr = JSON.parse( $("#temp-free-pv-arr").val() );

        // unchecked all the checkbox
        $('.pv-checkbox').prop('checked', false);

        // replace choose product button to total selected product variants
        $("#freePvProviders").val('[]');
        $("#totalFreePvId").text('0');
        $('#temp-free-pv-arr').val('[]');
    });
}

/**
 * Clear all required input fields and reset into default value
 * @return void;
 */
function clearAllInputSetData(){
    // clear input set name
    $('#promoset-name').val('');
    // clear set description
    $('#promoset-description').val('');

    // set offer input, purchase num input, free num input to default
    $('#promoset-purchase-number').val(1);
    $('#promoset-free-number').val(1);
    $('#offer-input').val(1);

    // uncheck and remove all checked free productvariants
    $('.pv-checkbox').prop('checked', false);

    // replace choose product button to total selected product variants
    $("#freePvProviders").val('[]');
    $("#totalFreePvId").text('0');
    $('#temp-free-pv-arr').val('[]');
}