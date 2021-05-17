/**
 * Accept new upload image path from file and replace 
 * existence source of image tag.
 * @param [HTML_Class_Name] imageFileClass 
 * @param [HTML_Class_Name] imageSourceClass 
 * @return Alert message on fault, Replace Image on succeed
 */
function imageReplicator(imageFileClass ,imageSourceClass){
    $(imageFileClass).on('change', function () {
        input = this;
        imgPath = $(this).val();
        
        // image file extension
        ext = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();

        webProductImage = $(this).siblings('label').find(imageSourceClass);

        if (input.files && input.files[0] && (ext == "png" || ext == "jpeg" || ext == "jpg")) {
            reader = new FileReader();
            reader.onload = function (e) {
                webProductImage.attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            alert('Select an Image File (png, jpg, jpeg)');
        }
    });
}

/**
 * Replace old image path and delete button to confirm change button.
 * @return Alert on invalid image extension.
 */
function showConfirmBtnOnClick(){
    $('.btn-change').on('click', function(){
        changeId = $(this).attr('id');
        btnInputFileChangeId = '#input-'+changeId;
        // imgChangeId = '#mobile-img-'+changeId;    
        imgChangeId = '#'+changeId;    
        // get form delete and confirm change
        deleteForm = $(this).siblings('.form-delete');
        changeForm = $(this).siblings('.form-change');
    
        // trigger change for file upload
        $(btnInputFileChangeId).trigger('click');
    
        $(btnInputFileChangeId).on('change', function(){
            // call for img replace
            deleteForm.css('display', 'none');
            changeForm.css('display', 'flex');

            input = this;
            imgPath = $(this).val();
            ext = imgPath
                .substring(imgPath.lastIndexOf('.') + 1)
                .toLowerCase();
    
            webProductImage = $(imgChangeId);

            if (input.files && input.files[0] && (ext == "png" || ext == "jpeg" || ext == "jpg")) {
                reader = new FileReader();

                reader.onload = function (e) {
                    webProductImage.attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
            else {
                alert('Select an Image File (png, jpg, jpeg)');
            }
        });
    });
}

/**
 * Check image path on null before processing update submit
 * @param [HTML_Class_Name] btnClassName 
 * @param [HTML_Id_Name]    imageIdName
 * @returns Alert message on null image path.
 */
function onUpdateCheckNullImage(btnClassName, imageIdName){
    $(btnClassName).click(function(){
        // get temporary id of image
        imgTmpId = $(this).children('input').val();
        // check empty web image upload
        if( document.getElementById(imageIdName+imgTmpId).files.length == 0 ){
            alert('Please upload image before submit!');
            return false;
        }
    });
}

/**
 * Check image on null before processing upload submit
 * @param [HTML_Class_Name] btnIdName 
 * @param [HTML_Id_Name]    imageIdName 
 * @return Alert message on null image path.
 */
function onUploadCheckNullImage(btnIdName, imageIdName){
    $(btnIdName).click(function(){
        // check empty web image upload
        if( document.getElementById(imageIdName).files.length == 0 ){
            alert('Please upload image before submit!');
            return false;
        }
    });
}