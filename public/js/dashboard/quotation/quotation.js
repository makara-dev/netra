
        // VLIDATION: a-z & 0-9
        $(document).ready(function(){
            $("#referNum").on("keyup", function() {
                var value = $(this).val($(this).val().replace(/[^A-Za-z0-9]/g,''));
               console.log(value);
            }); 
        });

        // DATEPICKER
       $(function($) {
            $("#datepicker").datetimepicker();
        });
    
        // FILLTER
        $(document).ready(function(){
            $("#myInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#data-table tr ").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    
        // EXPORT :: Quotation
        function exportTasks(_this) {
            let _url = $(_this).data('href');
            window.location.href = _url;
        }

