$(document).ready(function(){
    // set delivery adjustment option
    $("#delivery").on('change', function(){
        $isDeliveryOption = $(this).is(':checked');
        $isDeliveryOption ? $('input[name="adjustmentOption"]').val('delivery') 
                        : $('input[name="adjustmentOption"]').val('payment');
    })

    // payment status
    $(".selectedPaymentOption").on('change', function () {
        paymentStatus = $(this).val();

        // clear class
        $(this).removeClass('btn-outline-warning btn-outline-danger btn-outline-info btn-outline-success ');

        // add class
        switch (paymentStatus) {
            case 'pending':
                $(this).addClass('btn-outline-warning');
                break;
            case 'partial':
                $(this).addClass('btn-outline-info');
                break;
            case 'paid':
                $(this).addClass('btn-outline-success');
                break;
            case 'cancel':
                $(this).addClass('btn-outline-danger');
                break;
            default: '';
        }
        $(this).blur()
    });

    // delivery status
    $(".selectedDeliveryOption").on('change', function () {
        deliveryStatus = $(this).val();

        // clear class
        $(this).removeClass('btn-outline-warning btn-outline-danger btn-outline-info btn-outline-success ');

        // add class
        switch (deliveryStatus) {
            case 'cancel':
                $(this).addClass('btn-outline-danger');
                break;
            case 'pending':
                $(this).addClass('btn-outline-warning');
                break;
            case 'delivering':
                $(this).addClass('btn-outline-info');
                break
            case 'delivered':
                $(this).addClass('btn-outline-success');
                break;
            default: '';
        }
        $(this).blur()
    });
});