$(document).ready(function(){
    deleteConfirm('.exrate-delete-btn');

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