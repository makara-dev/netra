$(document).ready(function(){
    $('#password, #confirm_password').on('keyup', confirmPassword);
    
    //match password confirmation
    function confirmPassword() {
        if ($('#password').val() == $('#confirm_password').val()) {
            $('#message').text('Matching').css('color', 'green');
            return true;
        } else 
            $('#message').text('Not Matching').css('color', 'red');
            return false;
        $
    }

    //change product img on upload
    (function onImgUpload(){
        $('#user-image').change(function() {
            input = this;
            imgPath = $(this).val();
            ext = imgPath
                .substring(imgPath.lastIndexOf(".") + 1)
                .toLowerCase();

            productImg = $("#user-img");
            if (
                input.files &&
                input.files[0] &&
                (ext == "png" || ext == "jpeg" || ext == "jpg")
            ) {
                reader = new FileReader();
                reader.onload = function(e) {
                    productImg.css("max-width", "298px");
                    productImg.css("max-height", "400px");
                    productImg.attr("src", e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                productImg.attr("src", "icon/dashboard/invalid_img.png");
                alert("Select an Image File (png, jpg, jpeg)");
            }
            console.log("replaced");
        });
    })();
});