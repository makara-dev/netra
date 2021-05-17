//Show Info
function showSectionOnClick(infoSectionArr) {
    $.each(infoSectionArr, (link, infoSection) => {
        $(`#${link}`).click(() => {
            $(`#${infoSection}`).collapse("show");
        });
    });
}

/***
 * 
 * Hide anything that is not the current info Section
 * loop through info section Div
 * get info section when clicked
 * hide anything that is not the current info section
 * 
 ***/
function hideSectionOnClick(infoSectionArr) {
    $.each(infoSectionArr, (link, infoDiv) => {
         $(`#${infoDiv}`).on("show.bs.collapse", e => {
            if (!$(e.target).hasClass("question-collapse")) {
                for (infoDiv in infoSectionArr) {
                    if (infoSectionArr[infoDiv] != e.target.id) {
                        $(`#${infoSectionArr[infoDiv]}`).collapse("hide");
                    }
                }
            }
         });
    });
}
// show default info
function showDefault(id){
    try{
        $(`#${id}`).collapse("show");
    }
    catch{
        $(`#how-to-buy-info`).collapse("show");
    }
}
