// test onClick show only navbar and hide content
$(document).ready(function(){
    // show transaction when click on hamburger logo
    $('.navbar-toggler-wrapper').on('click', function(){
        activeNavbarTrasaction();
    });

    // hide transaction when click on cross btn
    $('.mobile-btn-close-navbar').on('click', function(){
        deactiveNavbarTransaction(); 
    });

})

// activate navbar animation
function activeNavbarTrasaction(){
    $('#main-content').addClass('d-none');
    $('#main-footer').addClass('d-none');
    $('.mobile-navbar-advertisement').addClass('d-none');

    $('.mobile-featured-list-wrapper').addClass('hide-mobile-featured-list');
    
    window.setTimeout(function (){
        $('.main-navbar-wrapper').css('padding-bottom', 0);
    }, 90);
    
    window.setTimeout(function (){
        $('.navbar-brand-wrapper').addClass('center-logo-animation');
        $('.mobile-btn-close-navbar').addClass('show-close-btn');
    }, 500);
};

// deactive navbar animation
function deactiveNavbarTransaction(){
    $('.navbar-collapse').collapse('hide');
    $('#main-content').removeClass('d-none');
    $('#main-footer').removeClass('d-none');
    $('.mobile-navbar-advertisement').removeClass('d-none');
    $('.main-navbar-wrapper').css('padding-bottom', '1em');

    $('.mobile-btn-close-navbar').removeClass('show-close-btn');

    $('.navbar-brand-wrapper').removeClass('center-logo-animation');
    
    window.setTimeout(function (){
        $('.mobile-featured-list-wrapper').removeClass('hide-mobile-featured-list');
    }, 700);
};