search("#myInput", "#myTable tr");

/**
 * Show the data research base on given input filed and table id
 * @param {String} inputID
 * @param {String} tableID
 * @return show the recod researched
 */
function search(inputID, tableID){
    $(inputID).on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(tableID).filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
}