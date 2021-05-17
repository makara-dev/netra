// VLIDATION: a-z & 0-9
$(document).ready(function () {
    $("#refer-num").on("keyup", function () {
        var value = $(this).val(
            $(this)
                .val()
                .replace(/[^A-Za-z0-9]/g, "")
        );
    });
    onDistrictSelectGetSangkat(ApiUrl, ApiToken);
    // getSumTotal();
});

// DATEPICKER
$(function ($) {
    $("#datepicker").datetimepicker();
});

// FILLTER
// $(document).ready(function () {
//     $("#search").on("keyup", function () {
//         var value = $(this).val().toLowerCase();
//         $("#data-table tr ").filter(function () {
//             $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
//         });
//     });
// });

// EXPORT :: Quotation
function exportTasks(_this) {
    let _url = $(_this).data("href");
    window.location.href = _url;
}

// add product variant into table
var sumbTotal = [];
var proNameArr = [];
var remove = [];
$("#btnAddProductVariant").on("click", function () {
    //table
    product_va_id = $("#product_va_id").val();
    product_va_name = $("select.serchproduct")
        .find(":selected")
        .attr("product_va_name");
    quantity = $("#quantity").val();
    proQuantity = $("#proQuantity").val();
    proQuantity = $("#proQuantity").val();
    exchangeRate = $("select.exchangerate")
        .find(":selected")
        .attr("data-exchange");
    // alert(exchangeRate);

    if (parseInt(quantity) > parseInt(proQuantity)) {
        alert("Quantity out of mount!");
        return;
    }

    if (product_va_id == "") {
        alert("Please select product!");
        return;
    }

    if ($(".exchangerate option:selected").val() === "") {
        alert("Please select excange price!");
        return;
    }

    if (quantity == "" || quantity < 1) {
        alert("Please insert quantity!");
        return;
    }
    // check if the attribute already exists
    var tb = $("table tbody");
    checkProduct = true;
    tb.find("tr").each(function (i) {
        var $tds = $(this).find("td"),
            old_pro_va_name = $tds.eq(0).text();
        if (old_pro_va_name == product_va_name) {
            alert("Product variant already exist!");
            checkProduct = false;
        }
    });
    //table
    if (checkProduct == false) {
        return;
    } else {
        table = $("#productVariantTable");

        tbody = $("table tbody");
        tr = $("<tr></tr>").addClass("border-bottom").appendTo(tbody);
        productInput = $("<input>")
            .attr("type", "hidden")
            .attr("name", "productid")
            .val(product_va_name);
        tdProduct = $("<td></td>").html(product_va_name);
        tdProduct.append(productInput);
        tr.append(tdProduct);
        // price
        priceInput = $("<input>")
            .attr("type", "hidden")
            .attr("name", "price")
            .val(price);
        tdPrice = $("<td></td>").html(price);
        tdPrice.append(priceInput);
        tr.append(tdPrice);

        // cost
        costInput = $("<input>")
            .attr("type", "hidden")
            .attr("name", "cost")
            .val(cost);
        tdCost = $("<td></td>").html(cost);
        tdCost.append(costInput);
        tr.append(tdCost);

        // exchange rate

        // exchangeInput = $("<input>")
        //     .attr("type", "hidden")
        //     .attr("id", "exchnage")
        //     .val(exchangeRate);
        // tdExchange = $("<td></td>").html(exchangeRate);
        // tdExchange.append(exchangeInput);
        // tr.append(tdExchange);

        // quantity
        quantityInput = $("<input>")
            .attr("type", "hidden")
            .attr("name", "quantities")
            .val(quantity);
        tdQuan = $("<td></td>").html(quantity);
        tdQuan.append(quantityInput);
        tr.append(tdQuan);

        // total price, cost grand total
        totalPrice = quantity * price;
        totalPriceIn = $("<input>")
            .attr("type", "hidden")
            .attr("name", `prices`)
            .val(totalPrice);
        tdTotalPrice = $("<td></td>").html(totalPrice);
        tdTotalPrice.append(totalPriceIn);
        tr.append(tdTotalPrice);

        totalCost = quantity * cost;
        totalCostIn = $("<input>")
            .attr("type", "hidden")
            .attr("name", `costs`)
            .val(totalCost);
        tdTotalCost = $("<td></td>").html(totalCost);
        tdTotalCost.append(totalCostIn);
        tr.append(tdTotalCost);

        grandTotal = totalPrice;
        grandToTalIn = $("<input>")
            .attr("type", "hidden")
            .attr("name", `subtotal`)
            .val(grandTotal);
        tdGrandTotal = $("<td></td>").html(grandTotal);
        tdGrandTotal.append(grandToTalIn);
        tr.append(tdGrandTotal);

        // product var id
        productVarInput = $("<input>")
            .attr("type", "hidden")
            .attr("name", `productVariantRows[]`)
            .val(product_va_id);
        tdProductVarInput = $("<td></td>");
        li = $("<li></li>").html(product_va_id);
        tdProductVarInput.append(li);
        li.append(productVarInput);
        tr.append(tdProductVarInput);
    }

    // hid id
    $("td:nth-child(8)").hide();

    //delete product variant icon
    deleteIcon = $('<i class="fas fa-trash"></i>').addClass(
        "text-gray-h cursor-pointer"
    );
    deleteATag = $("<a></a>")
        .attr("class", "deleteProductVariant")
        .append(deleteIcon);
    tdOption = $("<td></td>").append(deleteATag);
    tr.append(tdOption);

    // bind delete product variant
    $("#quantity").each(function () {
        $(".deleteProductVariant").on("click", function () {
            $(this).closest("tr").remove();
            getSumTotal();
        });
    });

    getSumTotal();
});

// exchange rate
$("#exchange_id").on("change", function () {
    var table = document.getElementById("tbodyRow"),
        sumTotalPrice = 0.0;
    sumTotalCost = 0.0;
    sumTotal = 0.0;
    for (var i = 0; i < table.rows.length; i++) {
        sumTotalPrice += parseFloat(table.rows[i].cells[4].innerHTML);
        sumTotalCost += parseFloat(table.rows[i].cells[5].innerHTML);
        sumTotal += parseFloat(table.rows[i].cells[6].innerHTML);
    }
    exchangeRate = 0.0;
    var selection = $(":selected", this);
    if (selection.length) {
        $.each(selection, function (i, v) {
            exchangeRate += parseFloat($(v).data("exchange_rate"));
        });
    }
    delivery_fee = $("#delivery_fee").val();

    sumTotalPrice *= exchangeRate;
    sumTotalCost *= exchangeRate;
    sumTotal *= exchangeRate;
    $("#tdTotalPrice").val(sumTotalPrice);
    $("#tdTotalCost").val(sumTotalCost);
    $("#tdTotal").val(sumTotal);
    $("#delivery_fee").val(delivery_fee * exchangeRate);
    // $("#exchange_rate").val(sumTotal);
});

// function get sum total
function getSumTotal() {
    var table = document.getElementById("tbodyRow");
    product_va_id = $("#product_va_id").val();
        sumTotalPrice = 0.0;
    sumTotalCost = 0.0;
    sumTotal = 0.0;
    for (var i = 0; i < table.rows.length; i++) {
        sumTotalPrice += parseFloat(table.rows[i].cells[4].innerHTML);
        sumTotalCost += parseFloat(table.rows[i].cells[5].innerHTML);
        sumTotal += parseFloat(table.rows[i].cells[6].innerHTML);
    }
    // alert(i);
    $("#tdTotalPrice").val(sumTotalPrice);
    $("#tdTotalCost").val(sumTotalCost);
    $("#tdTotal").val(sumTotal);
}
// find product price specific product name
$(".productType").on("change", function () {
    // var items = $(this).val() || [],
    price = 0.0;
    cost = 0.0;
    quantity = 0.0;
    proQuantity = 0.0;
    var selection = $(":selected", this);
    if (selection.length) {
        $.each(selection, function (i, v) {
            price += parseFloat($(v).data("price"));
            cost += parseFloat($(v).data("cost"));
            quantity += parseFloat($(v).data("quantity"));
            proQuantity += parseFloat($(v).data("quantity"));
        });
    }
    $("#price").val(price);
    $("#cost").val(cost);
    $("#quantity").val(quantity);
    $("#proQuantity").val(proQuantity);
});

/**
 * Get Sangkat by District id
 * @param [Api_Url] API_URL
 * @param [Api_Token] API_TOKEN
 */
function onDistrictSelectGetSangkat(API_URL, API_TOKEN) {
    $("#select-district").on("change", function (e) {
        e.preventDefault();

        district_id = $(this).val();
        dliveryFeeText = $("#delivery_fee");
        mainUrl = API_URL + "/districts/sangkats/" + district_id;

        // set everything to default
        if ($(this).val() == 0) {
            $("#select-sangkat").empty();

            dliveryFeeText = $("#delivery_fee").text("0 $");

            // defaultTotal = $('#default-total').val();
            // $('#total-price').text(defaultTotal);

            selectSangkat.append(
                new Option("Choose Sangkat", $(this).val(), true, true)
            );
        } else {
            // start ajax request
            $.ajax({
                url: mainUrl,
                type: "GET",
                data: { _token: API_TOKEN },
                dataType: "JSON",
                error: function (data) {
                    alert("something went wrong, try refreshing the page.");
                    console.log(
                        "Something wrong while trying to get Sangkats!"
                    );
                },
                success: function (response) {
                    generateSangkat(response.message);
                },
            });
        }
    });
    // Input valut to delivery fee using delivery price from sakat
    $("#select-sangkat").on("change", function () {
        val = $("#select-sangkat").val();
        $("#delivery_fee").val(val);
    });
}

/**
 * Generate option of Sangkat selected tag
 * @param [Json_Data_Messages] sangkats
 * @returns Nothing
 */
function generateSangkat(sangkats) {
    dliveryFeeText = $("#delivery_fee");
    selectSangkat = $("#select-sangkat");

    selectSangkat.empty();

    // set everything to default
    if (sangkats.length == 0) {
        selectSangkat.append(
            new Option("No Sangkat Found", sangkats.length, true, true)
        );
    } else {
        sangkats.forEach((sangkat) => {
            option = $("<option/>");
            option
                .attr({
                    value: sangkat.delivery_fee,
                    id: sangkat.sangkat_id,
                })
                .text(sangkat.sangkat_name);

            selectSangkat.append(option);
        });
        deliverFee = parseFloat(sangkats[0].delivery_fee);
        dliveryFeeText.val(deliverFee);
    }
}
