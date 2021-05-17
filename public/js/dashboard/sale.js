$("#sale-submit").on('click', function () {
    checkInputField();
});

$("#sale-edit").on('click',function () {
    checkInputField();
});

function checkInputField() {
    var date = $("#datetime").val();
    var sale_note = $("#sale-note").val();
    var staff_note = $("#staff-note").val();
    var reference_num = $("#reference-num").val();
    var total1 = $("#total").val();
    var paid1 = $("#paid").val();
    var total = parseInt(total1);
    var paid = parseInt(paid1);
    // check field if empty
    if (reference_num == "") {
        alert("Reference number cannot be empty!");
        return;
    }
    if (total == "") {
        alert("Total cannot be empty!");
        return;
    }
    if (paid == "") {
        alert("Paid cannot be empty!");
        return;
    }
    if (sale_note == "") {
        alert("Sale note cannot be empty!");
        return;
    }
    if (staff_note == "") {
        alert("Staff note cannot be empty!");
        return;
    }

    // check reference number
    var regex = new RegExp("^[a-zA-Z0-9 ]+$");
    if (!regex.test(reference_num) && reference_num != "") {
        alert("Reference num input only string and number!");
        return;
    }

    // check total
    if (total < 0) {
        alert("Total must bigger or equal to 0!");
    }
}
$(":input").change(function () {
    var total1 = $("#total").val();
    var paid1 = $("#paid").val();
    var total = parseInt(total1);
    var paid = parseInt(paid1);
    // check paid
    if (paid > total) {
        alert("Paid must smaller or equal to Total!");
    }
});

// auto get date
function getDate() {
    var now = new Date();
    var date =
        now.getFullYear() +
        "/" +
        ("0" + (now.getMonth() + 1)).slice(-2) +
        "/" +
        ("0" + now.getDate()).slice(-2) +
        "  " +
        ("0" + now.getHours()).slice(-2) +
        ":" +
        ("0" + now.getMinutes()).slice(-2);
    $("#datetimepicker").val(date);
}
