$(document).ready(function(){
    preventErrorPhoneNumber('#phone');
    search("#myInput", "#myTable tr");
    deleteConfirm('.customer-delete-btn');
    
});

/**
 * Show confirm delete message base on given btn class
 * @param {String} deleteBtn
 * @return show confirm delete message
 */
function deleteConfirm(deleteBtn){
    $(deleteBtn).on('click', function(){
        return confirm('Do you really want to delete this customer record?');
    });
}

/**
 * Check value of input if smaller 8 digits and more than 11 digits it error base on given the id
 * @param {String} phone
 * @return show suggestion messange
 */
 function preventErrorPhoneNumber(phone){
    $(phone).on("change", function() {
        var value = $(this).val();
        var str = value.replace(/\s/g, '');
        if(str.length < 8 || str.length > 11){
            alert("The phone number should be 8 to 11 digits!");
        }
    });
}