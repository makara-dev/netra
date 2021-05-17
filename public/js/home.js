// change mobile carousel wrapper on every resize
$(window).bind('resize', function(e){
    changeMobileCarouselWrapperHeight();
});

/** 
 * change mobile carousel promotion slider img base on clinet height
 * disactivate when width is bigger than 500px
 */
function changeMobileCarouselWrapperHeight(){
    clientWidth = $(window).width();
    newHeight = clientWidth + 5;
    
    if(newHeight > 500) {
        newHeight-=130;
    }

    $('.mobile-carousel-img-wrapper').css('height', newHeight);
    $('.mobile-carousel-img-wrapper').css('max-height', newHeight);
}

/** 
 * respondsive slick carousel slider function [ Promotion-Slider, ... ]
 */
function sliderInit() {
    // product carousel slick slider
    $(".product-carousel").slick({
        slidesToShow: 4,
        slidesToScroll: 4,
        dots: true,
        focusOnSelect: true,
        arrow: false,
        mobileFirst: true,
        responsive: [
            {
                breakpoint: 1100,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 4,
                    infinite: true
                }
            },
            {
                breakpoint: 920,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true
                }
            },
            {
                breakpoint: 720,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 520,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 0,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });

    // instagram feedback slick slider
    $('.instagram-post-body-wrapper').slick({
        slidesToShow: 2,
        slidesToScroll: 1,
        dots: false,
        focusOnSelect: true,
        arrow: false,
        mobileFirst: true,
        responsive: [
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    infinite: true
                }
            },
            {
                breakpoint: 1023,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    infinite: true
                }
            },
        ]
    });
}

/** 
 * Enable and Disable flickity slider
 * Disable when width is smaller than 992px
 */
function isFlickityActivate(){
    // disactivate in mobile version start from 992px
    if ($(window).width() < '992') {
        $('#recommend-flickity-wrapper').removeClass('custom-carousel');
        $('#best-seller-flickity-wrapper').removeClass('custom-carousel');
    } else {
        recommnedProductCarousel();
    };
}

/** 
 * custom flickity slider
 */
function recommnedProductCarousel(){
    $('.custom-carousel').flickity({
        // options
        cellAlign: 'left',
        contain: true,
        freeScroll: true,
        wrapAround: true,
        prevNextButtons: false,
        pageDots: false,
    });
}

/**
 * 
 */
function changeMobilePanoramaWrapperHeight(){
    clientWidth = $(window).width();
    oldHeight = $('.anything-panorama-image-wrapper').height();
    newHeight = ((clientWidth-320)/2);

    result = oldHeight + newHeight;

    if(clientWidth > 500) { result-=100; }
    if(clientWidth > 790) { result-=70; }
    
    $('.anything-panorama-image-wrapper').css('height', result);
    $('.anything-panorama-image-wrapper').css('max-height', result);
}