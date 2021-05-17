
var subTotal = [];
var proNameArr = [];
var remove = [];

function calCulateTotal() {
    //table
    table = $('#productVariantTable');

    // get product name
    productName = $('select.serchproduct').find(':selected').attr('productName');
    if(!productName){
        alert('Please choose product name!'); // if no product selected
        return;
    }
    if($('#quant').val() == ''){
        alert('Please fill in quantity!'); // if no quantity input value
        return;
    }
    
    // check if the product variant already exists
    var tb = $("table tbody");
    checkProduct = true;
    tb.find("tr").each(function () {
        var $tds = $(this).find("td");
        var oldProduct = $tds.eq(0).text(); // first td of this row
        if (oldProduct == productName) {
            checkProduct = false;
        }
    });
    if(checkProduct == false){ // if product already exist alert message
        alert("Product variant already exist!");
        return;
    }

   
    tbody = $('table tbody');
    tr = $('<tr></tr>')
        .addClass('border-bottom')
        .appendTo(tbody);

    // product name input
    productInput = $('<input>')
        .attr('type', 'hidden')
        .attr('name', 'productid')
        .val(productName);
    tdProduct = $('<td></td>')
        .html(productName);
    tdProduct.append(productInput);
    tr.append(tdProduct);

    // price input
    price = $('#price').val();
    priceInput = $('<input>')
        .attr('type', 'hidden')
        .attr('id', 'price')
        .val(price);
    tdPrice = $('<td></td>')
        .html(price);
    tdPrice.append(priceInput);
    tr.append(tdPrice);

    // quantity input
    quan = $('#quant').val();
    quantityInput = $('<input>')
        .attr('type', 'text')
        .attr('class', 'quantity')
        .attr('disabled', 'disabled')
        .val(quan)
        .attr('min', 0);
    tdQuan = $('<td></td>')
        .html(quantityInput);
    tdQuan.append(quantityInput);
    tr.append(tdQuan);
   
    // sub total input
    subTotalInput = $('<input>')
        .attr('type', 'text')
        .attr('class', 'subtotal')
        .attr('disabled', 'disabled')
    tdSub = $('<td></td>')
        .html(subTotalInput);

    // total input
    totalInput = $('<input>')
        .attr('type', 'text')
        .attr('id', 'grandTotal')
        .attr('name', 'total')
        .attr('readonly', true)
    totalTd = $('#tdtotal').html(totalInput);
    totalTd.append(totalInput);

    // calculate final total 
    sumResult = 0;
    function calculateSum() {
        // exchange rate
        var exchangeRate = $('select.exchangerate').find(':selected').attr('rate');
        var price = parseFloat($('#price').val());
        var quantity = $('#quant').val();
        subTotalVlaue = price * quantity;
        subTotalInput.val(subTotalVlaue);

        // sub total
        tdSub.html(subTotalInput);
        tdSub.append(subTotalInput);
        tr.append(tdSub);
        subTotal.push(subTotalVlaue);
        for (i = 0; i < subTotal.length; i++) {
            sumResult += subTotal[i];
        }
        $('#default').remove();
        totalInput.val(parseFloat(sumResult).toFixed(2));
        // calculate with exchange rate
        $('#rielTotal').html(parseFloat(sumResult*exchangeRate).toFixed(2));
    }
    calculateSum();

    //delete product variant icon
    deleteIcon = $('<i class="fas fa-trash"></i>')
        .addClass('text-gray-h cursor-pointer');
    deleteATag = $('<a></a>')
        .attr('class', 'deleteProductVariant')
        .attr('subtotal', subTotalVlaue)
        .append(deleteIcon);
    tdOption = $('<td></td>')
        .append(deleteATag);
    tr.append(tdOption);

    //bind delete product variant
    $('.deleteProductVariant').unbind().click(function () {
        currentSubTotal = $(this).attr('subtotal');
        sumResult = sumResult - currentSubTotal;

        $(this).closest('tr').remove();
        totalInput.val(parseFloat(sumResult).toFixed(2));
        // calculate with exchange rate
        var exchangeRate2 = $('select.exchangerate').find(':selected').attr('rate');
        $('#rielTotal').html(sumResult * exchangeRate2);
    })

};

// find product price specific product name
$('#productvar').on('change', function () {
    productMaxQnt = $('option:selected', this).attr('maxQtn');
    $('#quant').attr('max', productMaxQnt);
    currentPrice = $('option:selected', this).attr('data-price');
    $('#price').val(currentPrice);
});

// get quantity value
$('#quant').on('change', function () {
    maximumQtn = $(this).attr('max');
    currentInputQtn = $(this).val();
    currentPrice = parseFloat($('#price').val());
    if (parseInt(currentInputQtn) < 0) {
        alert("Quantity must be positive number!");
        // set input back to default (0)
        $(this).val(0);
    }
    if (parseInt(currentInputQtn) > parseInt(maximumQtn)) {
        alert('Input quantity is greater thatn available product quantity!');
        // set input back to default (0)
        $(this).val(0);
    }

});

// get exchangeRate
$('.exchangeRate').on('change', function () {
    var items = $('#exchangerate').val() || [],
        totalPrice = 0.000;
    var selection = $(':selected', this);
    if (selection.length) {
        $.each(selection, function (i, v) {
            totalPrice += parseFloat($(v).data('ex'));
            console.log(totalPrice);

        });
    }
});



