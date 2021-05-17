$(document).ready(function(){
    preventErrorDiscount("#customer-discount");
    deleteConfirm('.cusgroup-delete-btn');
    preventErrorDiscountSubmit('#customer-creation-form', '#customer-discount', '#msg');

});

/**
 * Show confirm delete message base on given btn class
 * @param {String} deleteBtn
 * @return show confirm delete message
 */
function deleteConfirm(deleteBtn){
    $(deleteBtn).on('click', function(){
        return confirm('Do you really want to delete this customer group record?');
    });
}

/**
 * Check value of input discount if more than 100% it error base on given the id
 * @param {String} discount
 * @return show suggestion messange
 */
function preventErrorDiscount(discount){
    $(discount).on("change", function() {
        var value = $(this).val();
        if(value > 100 || value < 0){
            alert("Discount percentage should not be more than 100% or less than 0!");
        }
    });
}

/**
 * Check value of input discount if more than 100% it error after click on btn add cus group
 * @param {String} cusForm
 * @param {String} cusDiscount
 * @param {String} message
 * @return show suggestion messange
 */
function preventErrorDiscountSubmit(cusForm, cusDiscount, message){
    $(cusForm).on('submit', function (e) {
        var value = $(cusDiscount).val();
        if (value > 100 || value < 0) {
            e.preventDefault()
            $(message).addClass('alert alert-danger').html('Discount percentage should not be more than 100% or less than 0!')
        }
    })
}