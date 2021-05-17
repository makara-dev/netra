$(document).ready(function(){
    // activate slider on mobile screen
    if($(window).width() < 991) {
        mobileSlider();
        recommendProductSlider(2.5);
    }
    recommendProductSlider();
    
    $('.child-img-wrapper').on('click', function(){
        replacePreviewImageByChild(this, '.preview-product-image-wrapper');
    });

    // onClick rating start set rating score
    $('.star').on('click', function(){
        ratingValue = $(this).val();
        $('#rating-score').val(ratingValue);
    });

    // check empty rating score and review comment before submit
    $(".submit-btn").on('click', function(){
        customerRatingScore = $('#rating-score').val();
        customerComment = $('#review-comment').val();
        if(customerComment.length == 0 || customerRatingScore.length == 0){
            alert('Please give us some review before click submit')
            return false;
        };
    });
});


// replace preview image by selected child image
function replacePreviewImageByChild(childImgClassWrapper, parentImgClassWrapper) {
    childPath = $(childImgClassWrapper).find('img').attr('src');
    previewPath = $(parentImgClassWrapper);

    if(previewPath.length != 0) {
        previewPath.find('img').attr('src', childPath)
    } else {
        console.log("Incorrect parent path, or doens't exist");
    }
}

// product preview slider
function mobileSlider(){
    $('.child-product-img-wrapper').slick({
        infinite: true,
        arrows:true,
        slidesToShow: 1,
        slidesToScroll: 1,
        prevArrow: $('.prev-arrow'),
        nextArrow: $('.next-arrow'),
    });
}

// recommend product slider ( You might also like )
function recommendProductSlider(slideToShowOption = 4){
    $('.recommend-card-carousel').slick({
        infinite: true,
        arrows:true,
        dots: true,
        slidesToShow: slideToShowOption,
        slidesToScroll: 1,
        prevArrow: $('.recommend-prev-btn'),
        nextArrow: $('.recommend-next-btn'),
    });
}