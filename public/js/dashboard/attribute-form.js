//
$(document).ready(addAttributeValue);

//change btn value on dropdown select
$('#attributeDropdown > .dropdown-item').on('click', function () {
    attributeId = $(this).attr('data-value')
    attributeName = $(this).html()

    attributeBtn = $('#attributeDropdownBtn');
    $(attributeBtn).text(attributeName)
    
    $('[name=attribute]').val(attributeId);

    $('#attributeValueWrapper').removeClass('d-none');
    
    $('.th-name').html(attributeName);

    $(attributeBtn).prop('disabled', true);
});

//change btn value on dropdown select
$('#categoryDropdown > .dropdown-item').on('click', function () {
    id = $(this).val()
    name = $(this).html()

    categoryBtn = $('#categoryBtn');
    $(categoryBtn).text(name)
    $('[name=category]').val(id);
    
    $(categoryBtn).prop('disabled', true);
});

//
function addAttributeValue() {
    index = 0;
     
    $('#addAttributeValueBtn').on('click', function () {
        name = $('#attributeValueInput').val();

        if (!name) {
            alert('input name for attribute value');
            return false;
        }
        
        tbody = $('#attributeValueTbody');
        
        tr = $('<tr></tr>').appendTo(tbody);

        tdIndex = $('<td></td>').html(++index).appendTo(tr);
        
        tdName = $('<td></td>').html(name).appendTo(tr);
        
        deleteIcon = $('<i class="fas fa-trash"></i>').addClass('text-gray-h cursor-pointer');
        deleteATag = $('<a></a>').addClass('btn-delete').append(deleteIcon);
        tdOption = $('<td></td>').append(deleteATag).appendTo(tr);

        input = $('<input></input>')
            .attr('type','hidden')
            .attr('name','attributeValue[]')
            .attr('value',name)
            .appendTo(tr);

        $('#attributeValueInput').val('');

        $(tdOption).on('click',function(){
            $(this).closest('tr').remove();
        })
    });
}


