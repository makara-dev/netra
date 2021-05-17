$(document).ready(function () {
    onImgUpload(invalidImg);
    onSelectChangeButtonVal();
    onClickAddProductVariant()
});

$('.delete-pv-btn').on('click',function(){
    row = $(this).closest('tr');
    productVariantId = $(this).val();

    $("#popUpModal").css('display', 'flex');
    $("#popUpModal").css('display', '-webkit-flex');

    $.ajax({
        url: apiUrl + '/productvariant/' + productVariantId,
        type: 'DELETE',
        data: { _token: apiToken },
        dataType: 'JSON',
        error: function (data) {
            alert('something went wrong, Try refreshing the page.');
            $("#popUpModal").css('display', 'none');
        },
        success: function (data) {
            if (data.status == 'success') {
                row.remove();
            }
            $("#popUpModal").css('display', 'none');
            alert(data.message);
        }
    });
})

//change product img on upload
function onImgUpload(invalidImg) {
    $('.img-file').change(function () {
        input = this;
        imgPath = $(this).val();
        ext = imgPath
            .substring(imgPath.lastIndexOf('.') + 1) //get extension
            .toLowerCase();

        productImg = $('#product-img');
        miniProductImg = $(this).parent().find('.mini-img');

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
        } else {
            alert('Select an Image File (png, jpg, jpeg)');
        }
    });
}

//init dropdown as select 
function onSelectChangeButtonVal() {
    $(".attribute-dropdown .dropdown-menu .dropdown-item").click(function () {
        text = $(this).html();
        val = $(this).val();
        dropDownBtn = $(this).parent().siblings('.dropdown-toggle'); // get dropdown-btn ID using dropdown menu [data-aria-labelledby]

        $(dropDownBtn).html(text).val(val); //replace btn text with selected dropdown
    })
}

//add product variant
pv_index = 0;
function onClickAddProductVariant() {
    $('#addProductVariantBtn').on('click', function () {
        //get attributes
        attributes = $('.attribute-dropdown span');
        selectedAttributeValues = $('.attribute-dropdown .dropdown-toggle');

        //check if all attribute is empty
        temp = $(selectedAttributeValues).map(function(){
            return $(this).val();
        }).toArray();

        //return on every attribute value select empty
        if(isAllEmpty(temp)){
            alert('Select an attribute')
            return false;
        }

        //table
        table = $('#productVariantTable');

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

        //sku
        attributeNamesArr =  $(selectedAttributeValues).map(function() {
            return ' ' + $.trim($(this).html());
        }).get();
        attributeNames = attributeNamesArr.reduce((accumulator, item) => {
            return accumulator + item;
        });
        productName = $('#productName').val();
        skuInput = $('<input>')
            .addClass('form-control')
            .attr('type', 'text')
            .attr('name', `newProductVariantSkus[${pv_index}]`) //hidden input for attribute value id gotten from DropDownBtn
            .prop('readonly',true)
            .val(productName + attributeNames);
        tdSku = $('<td></td>');
        tdSku.append(skuInput);
        tr.append(tdSku);

        //quantity
        quantity = $('#quantityNumInput').val();
        quantityInput = $('<input>')
            .addClass('form-control')
            .attr('type', 'number')
            .attr('name', `newQuantities[${pv_index}]`) //hidden input for attribute value id gotten from DropDownBtn
            .attr('min', 0)
            .attr('step','0.01')
            .val(quantity);
        tdQuantity = $('<td></td>');
        tdQuantity.append(quantityInput);
        tr.append(tdQuantity);

        //cost
        cost = $('#costInput').val();
        costInput = $('<input>')
            .addClass('form-control')
            .attr('type', 'number')
            .attr('name', `newCosts[${pv_index}]`) //hidden input for attribute value id gotten from DropDownBtn
            .attr('min', 0)
            .attr('step','0.01')
            .val(cost);
        tdCost = $('<td></td>');
        tdCost.append(costInput);
        tr.append(tdCost);
        
        //price
        price = $('#priceInput').val();
        priceInput = $('<input>')
            .addClass('form-control')
            .attr('type', 'number')
            .attr('name', `newPrices[${pv_index}]`) //hidden input for attribute value id gotten from DropDownBtn
            .attr('min', 0)
            .attr('step','0.01')
            .val(price);
        tdPrice = $('<td></td>');
        tdPrice.append(priceInput);
        tr.append(tdPrice);


        
        //loop through attribute values select btn
        $(selectedAttributeValues).each(function () {
            attrVal = $(this).val();
            text = capitalizeFirstLetter($(this).html());

            //hidden attribute_values input for product variant
            select = $('<select>')
                .addClass('form-control')
                .attr('name',`newAttributeValues[${pv_index}][]`); //hidden input for attribute value id gotten from DropDownBtn
            
            allAttributeValues = $(this).siblings('.dropdown-menu').find('.dropdown-item');

            $(allAttributeValues).each(function(){
                val = $(this).val();
                text = $(this).text();

                option = $('<option>')
                    .val(val)
                    .html(text)
                    .appendTo(select);
                
                if(attrVal == val){
                    option.prop('selected', true);
                }
            });


            td = $('<td></td>').append(select);
            tr.append(td);
        });

        //delete product variant icon
        deleteIcon = $('<i class="fas fa-trash"></i>')
            .addClass('text-gray-h cursor-pointer');
        deleteATag = $('<button></button>')
            .addClass('btn btn-link')
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

//call api to delete image
$('.delete-img-btn').on('click',function(){
    image_id = $(this).val();
    imageLabel = $(this).parent().siblings('.img-toggler').find('.mini-img');
    
    if(!image_id){
        imageLabel.attr('src',invalidImg)
        $('#product-img').attr('src',invalidImg);
        return false;
    }

    $("#popUpModal").css('display', 'flex');
    $("#popUpModal").css('display', '-webkit-flex');

    $.ajax({
        url: apiUrl + '/image/' + image_id,
        type: 'DELETE',
        data: { _token: apiToken },
        dataType: 'JSON',
        error: function (data) {
            alert('something went wrong, Try refreshing the page.');
            $("#popUpModal").css('display', 'none');
        },
        success: function (data) {
            if (data.status == 'success') {
                imageLabel.attr('src',invalidImg)

                //check if thumbnail
                id = $(imageLabel).siblings('.img-file').attr('id')
                if(id == 'img-file[0]'){
                    $('#product-img').attr('src',invalidImg)
                }
            }
            alert(data.message);
            $("#popUpModal").css('display', 'none');
        }
    });
})




