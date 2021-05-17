$(document).ready(function () {
    onImgUpload(invalidImg);
    
    onCategorySelectGetAttributes(apiUrl, apiToken);
    
    onClickAddProductVariant();
});

//change product img on upload
function onImgUpload(invalidImg) {
    $('.img-file').change(function () {
        input = this;
        imgPath = $(this).val();
        ext = imgPath
            .substring(imgPath.lastIndexOf('.') + 1) //get extension
            .toLowerCase();

        productImg = $('#product-img');
        miniProductImg = $(this).siblings('label').find('.mini-img');

        if (input.files && input.files[0] && (ext == "png" || ext == "jpeg" || ext == "jpg")) {
            reader = new FileReader();

            reader.onload = function (e) {
                //replace img
                productImg.css('max-width', '298px');
                productImg.css('max-height', '400px');
                productImg.attr('src', e.target.result);
                miniProductImg.css('max-height', '100px');
                miniProductImg.attr('src', e.target.result);

                //change label for the next img input
                index = parseInt($(input).attr('data-id'));
                $('.img-label').attr('for', `img-file[${index + 1}]`);
            }
            reader.readAsDataURL(input.files[0]);
        }
        else {
            productImg.attr("src", invalidImg);
            miniProductImg.attr('src', invalidImg)
            alert('Select an Image File (png, jpg, jpeg)');
        }
    });
}

//get products Variant Attribute 
function onCategorySelectGetAttributes(API_URL, API_TOKEN) {
    $("#categorySelect").on('change', function () {
        categoryId = $('#categorySelect :selected').val();
        mainUrl = API_URL + '/' + categoryId;   //get URL api/product/{category_id}

        $.ajax({
            url: mainUrl,
            type: 'GET',
            data: { _token: API_TOKEN },
            dataType: 'JSON',
            error: function (data) {
                alert('something went wrong, Try refreshing the page.');
            },
            success: function (data) {
                $('#productVariantSelect').empty();
                if (data.status == 'error') {
                    alert(data.message);
                } else {
                    generateAttributeDropDown(data.message); //create dropdown on success
                    onSelectChangeButtonVal();
                }
            }
        });
    });

    //trigger once on document ready
    $("#categorySelect").trigger('change');
}

function generateAttributeDropDown(attributes) {
    //create an array of dropdown for attributes
    attributes.forEach(attribute => {
        //form
        formGroup = $('<div></div>').addClass('form-group');

        label = $('<span></span>').html(attribute.attribute_name);
        
        dropdownBtn = $('<button></button>')
            .addClass('btn btn-sm btn-outline-gray dropdown-toggle')
            .attr('type', 'button')
            .attr('id', attribute.attribute_name + 'Toggler')
            .attr('name', attribute.attribute_id)
            .attr('data-toggle', 'dropdown')
            .html('Select ' + attribute.attribute_name);

        dropdown = $('<div></div>')
            .addClass('dropdown-menu')
            .css('max-height', '200px')
            .css('overflow-y', 'auto')
            .attr('aria-labelledby', attribute.attribute_name + 'Toggler');

        attribute.attribute_values.forEach(attributeValue => {
            dropdownItem = $('<a></a>')
                .addClass('dropdown-item')
                .attr('data-value', attributeValue.attribute_value_id)
                .html(attributeValue.attribute_value);
            dropdown.append(dropdownItem);
        });

        //append everything together
        formGroup.append(label);
        formGroup.append(dropdownBtn);
        formGroup.append(dropdown);
        $('#productVariantSelect').append(formGroup);
    });

    //lock color dropdown
    $('[aria-labelledby="colorToggler"] > .dropdown-item').on('click', function(){
        $('#colorToggler').prop('disabled',true);
    });
}

//init dropdown as select 
function onSelectChangeButtonVal() {
    $("#productVariantSelect .dropdown-menu a").on('click', function(){
        selectedText = $(this).text();
        selectedValue = $(this).attr('data-value');
        dropDownBtn = '#' + $(this).parent().attr('aria-labelledby'); // get dropdown-btn ID using dropdown menu [data-aria-labelledby]
        $(dropDownBtn).html(selectedText).val(selectedValue); //replace btn text with selected dropdown

    });
}

//add product variant
pv_index = 0;
function onClickAddProductVariant() {
    $('#addProductVariantBtn').on('click', function () {
        //get attributes
        attributes = $('#productVariantSelect span');
        attributeValues = $('#productVariantSelect button');

        //check if all attribute is empty
        temp = $(attributeValues).map(function(){
            return $(this).val();
        }).toArray();

        //return on every attribute value select empty
        if(isAllEmpty(temp)){
            alert('Select an attribute')
            return false;
        }

        //table
        table = $('table');

        if ($('table thead').length === 0) { //check if heading exist
            //thead
            thead = $('<thead></thead>')
                .addClass('font-20 border-bottom')
                .appendTo(table);

            tr = $('<tr></tr>')
                .addClass('border-bottom')
                .appendTo(thead);

            $(attributes).each(function () {  //loop from attribute dropdown
                val = capitalizeFirstLetter($(this).text());
                th = $('<th></th>')
                    .html(val)
                    .appendTo(tr);
            });

            thCost = $('<th></th>')
                .html('Cost')
                .appendTo(tr); 
            
            thPrice = $('<th></th>')
                .html('Price')
                .appendTo(tr); 
           
            thQuantity = $('<th></th>')
                .html('Quantity')
                .appendTo(tr); 
            
            thOption = $('<th></th>')
                .html('Options')
                .appendTo(tr);  

            tbody = $('<tbody></tbody>')
                .attr('id', 'productVariantTableContent')
                .appendTo(table);
        }

        //append tbody
        tbody = $('table tbody');
        tr = $('<tr></tr>')
            .addClass('border-bottom')
            .appendTo(tbody);

        index_input = $('<input>')
        .attr('type', 'hidden')
        .attr('name',`productVariantRows[]`) //hidden input for attribute value id gotten from DropDownBtn
        .val(pv_index)
        .appendTo(tr);

        //loop through attribute values select btn
        $(attributeValues).each(function () {
            attrVal = $(this).val();

            //hidden attribute_values input for product variant
            input = $('<input>')
                .attr('type', 'hidden')
                .attr('name',`attributeValues[${pv_index}][]`) //hidden input for attribute value id gotten from DropDownBtn
                .val(attrVal);

            val = capitalizeFirstLetter($(this).html());
            td = $('<td></td>')
                .html(val)
                .append(input);
            tr.append(td);
        });

        //cost
        cost = $('#costInput').val();
        costInput = $('<input>')
            .attr('type', 'hidden')
            .attr('name', `costs[${pv_index}]`) //hidden input for attribute value id gotten from DropDownBtn
            .val(cost);
        tdCost = $('<td></td>')
            .html(cost);
            tdCost.append(costInput);
        tr.append(tdCost);
        
        //price
        price = $('#priceInput').val();
        priceInput = $('<input>')
            .attr('type', 'hidden')
            .attr('name', `prices[${pv_index}]`) //hidden input for attribute value id gotten from DropDownBtn
            .val(price);
        tdPrice = $('<td></td>')
            .html(price);
            tdPrice.append(priceInput);
        tr.append(tdPrice);

        //quantity
        quantity = $('#quantityNumInput').val();
        quantityInput = $('<input>')
            .attr('type', 'hidden')
            .attr('name', `quantities[${pv_index}]`) //hidden input for attribute value id gotten from DropDownBtn
            .val(quantity);
        tdQuantity = $('<td></td>')
            .html(quantity);
        tdQuantity.append(quantityInput);
        tr.append(tdQuantity);
        
        //delete product variant icon
        deleteIcon = $('<i class="fas fa-trash"></i>')
            .addClass('text-gray-h cursor-pointer');
        deleteATag = $('<a></a>')
            .attr('id', 'deleteProductVariant')
            .append(deleteIcon);
        tdOption = $('<td></td>')
            .append(deleteATag);
            
        tr.append(tdOption);

        //bind delete product variant
        $(deleteATag).on('click',function(){
            $(this).closest('tr').remove();
        })

        pv_index++;
    });

    function capitalizeFirstLetter(str) {
        //Uppercase First letter + rest of the string
        return str.charAt(0).toUpperCase() + str.slice(1);
    }
    function isAllEmpty(arr){
        result = arr.reduce(function(total, val){
            return total += val;
        })
        return (result === '');
    }
}

