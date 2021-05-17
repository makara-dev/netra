$(document).ready(function(){
    deleteConfirm('.adjustment-delete-btn');

});

/**
 * Show confirm delete message base on given btn class
 * @param {String} deleteBtn
 * @return show confirm delete message
 */
function deleteConfirm(deleteBtn){
    $(deleteBtn).on('click', function(){
        return confirm('Do you really want to delete this adjustment record?');
    });
}

// AUTO FILL DATETIME
var now = new Date();
var f = now.getFullYear() + "/" +
    ('0' + (now.getMonth() + 1)).slice(-2) + "/" +
    ('0' + now.getDate()).slice(-2) + "  " +
    ('0' + now.getHours()).slice(-2) + ":" +
    ('0' + now.getMinutes()).slice(-2);
$("#datepicker").val(f);

function addProduct() {
    //table
    table = $('#productVariantTable');

    tbody = $('table tbody');
    tr = $('<tr></tr>')
        .addClass('border-bottom')
        .appendTo(tbody);

    //product variant id
    var pro_variants = [];
    productVariantId = $('select.products').find(':selected').val();
    productVariantIdInput = $('<input>')
    .attr('type', 'hidden')
    .attr('class', 'productvariantid')
    .attr('name', 'productvariantid[]')
    .val(productVariantId);
    tdProductVariant = $('<td></td>')
    .html(productVariantId);
    tdProductVariant.append(productVariantIdInput);
    tr.append(tdProductVariant);
    
    // product variant
    productVariantName = $('select.products').find(':selected').attr('data-productvariant');
    productVariantInput = $('<input>')
    .attr('type', 'hidden')
    .attr('name', 'productvariant[]')
    .val(productVariantName);
    tdProductVariant = $('<td></td>')
    .html(productVariantName);
    tdProductVariant.append(productVariantInput);
    tr.append(tdProductVariant);
    
    // product name
    // productName = $('select.products').find(':selected').attr('data-product');
    // productInput = $('<input>')
    // .attr('type', 'hidden')
    // .val(productName);
    // tdProduct = $('<td></td>')
    // .html(productName);
    // tdProduct.append(productInput);
    // tr.append(tdProduct);
    
    //type
    var myParent = document.body;
    //Create array of options to be added
    var array = ["Addition","Subtractions"];
    //Create and append select list
    var selectList = document.createElement("select");
    selectList.id = "mySelect";
    selectList.name = "types[]";
    myParent.appendChild(selectList);
    //Create and append the options
    for (var i = 0; i < array.length; i++) {
        var option = document.createElement("option");
        option.value = array[i];
        option.text = array[i];
        selectList.appendChild(option);
    }
    tdType = $('<td></td>').html(selectList);
        tdType.append(selectList);
        tr.append(tdType);

    // quantity
    quantityInput = $('<input>')
    .attr('type', 'number')
    .attr('id', 'quant')
    .attr('class', 'quantity')
    .attr('name', 'quantity[]')
    .val(0)
    .attr('onkeypress', 'return event.charCode >= 48')
    .attr('min', 0);
    tdQuan = $('<td></td>')
        .html(quantityInput);
    tdQuan.append(quantityInput);
    tr.append(tdQuan);
    
    // $(document).ready(function(){
	// 	$(".quantity").each(function() {
	// 		$(this).keyup(function(){
	// 			calculateSum();
	// 		});
	// 	});
	// });

    //delete product variant icon
    deleteIcon = $('<i class="fas fa-trash"></i>')
        .addClass('text-gray-h cursor-pointer');
    deleteATag = $('<a></a>')
        .attr('id', 'deleteProductVariant')
        .append(deleteIcon);
    tdOption = $('<td></td>')
        .addClass('text-center')
        .append(deleteATag);
        tr.append(tdOption);

    //bind delete product variant
    $(deleteATag).on('click',function(){
        $(this).closest('tr').remove();
    })

}

//sum quantity
function calculateSum() {
    var sum = 0;
    $(".quantity").each(function() {
        if(!isNaN(this.value) && this.value.length!=0) {
            sum += parseFloat(this.value);
        }
    });
    $("#total").html(sum.toFixed(2));
}
