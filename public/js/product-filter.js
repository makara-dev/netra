// auto detect screen width to and show filter for desktop version
$(window).bind('resize', function(e){
    if($(window).width() > '995') {
        isHideFilter('open');
    }
});

$(document).ready(function() {
    arr = JSON.parse(localStorage.getItem('checked')) || [];
    arr.forEach(function(checked, i) {
        $('.filter-checkbox').eq(i).prop('checked', checked);
    });

    $('.filter-checkbox').on('mousedown touchstart', onClickBox);
    $('#clear-filter-btn').click(onClearFilter);

    // show and hide mobile filter navigation by click
    showFilter();
    hideFilter();

    // show and hide mobile filter navigation by page refresh
    if($(window).width() > '995') {
        filterStatus = localStorage.setItem("active-filter", "open");
    } else {
        filterStatus = localStorage.getItem('active-filter');
    }
    isHideFilter(filterStatus);

});

function onClearFilter() { 
    $('.filter-checkbox').prop('checked',false);
    localStorage.clear();

    //refresh page without query param
    window.location = window.location.href.split('?')[0];
    return false;
}

//submit form on checkbox click
function onClickBox() {

    let wasChecked = this.checked;

    //make it work like radio box [clear other checkbox]
    let name = $(this).attr('name');
    $(`[name=${name}]`).each(function() {
        $(this).prop('checked', false); 
    }); 
    
    if(!wasChecked){
        $(this).prop('checked', true);
    }

    arr = $('.filter-checkbox').map(function() {
        return this.checked;
    }).get();
    
    localStorage.setItem("checked", JSON.stringify(arr));

    this.form.submit();
}

// show filter dropdown animation
function showFilter(){
    $('.filter-toggler-icon').on('click', function(){
        var totalHeight = 0;

        // get all childs height
        $('.filter-menu-wrapper').children().each(function(){
            totalHeight += $(this).outerHeight(true);
        });

        $('.filter-menu-wrapper').css('height', totalHeight);

        $('.filter-close-btn').addClass('show-filter-close-btn');

        localStorage.setItem("active-filter", "open");
    });
}

// hide filter dropdown animation
function hideFilter() {
    $('.filter-close-btn').on('click', function(){
        $(this).removeClass('show-filter-close-btn');
        
        $('.filter-menu-wrapper').css('height', '40');
        localStorage.setItem("active-filter", "close");
    });
}

// show or hide filter by refreshing page 
function isHideFilter(filterStatus){
    switch (filterStatus) {
        case null:{
            $('.filter-close-btn').trigger('click');
        }   break;
        case 'open':{
            $('.filter-toggler-icon').trigger('click');
        }   break;
        case 'close':{
            $('.filter-close-btn').trigger('click');
        }   break;
        default:
            break;
    }
}