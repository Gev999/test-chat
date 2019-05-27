const inputFields = $('.sign-up-field');

for (let i = 0; i < inputFields.length; ++i) {
    const item = inputFields.eq(i);
    const count = item.attr('type')=='text'?5:8;
    item.blur(()=>{
        if (item.val().trim().length < count) {
            addErrMsg(item, count);
        }
    });

    item.keydown(()=> {
        removeErrMsg(item);
    });
}

$('form').submit((event)=>{
    for (let i = 0; i < inputFields.length; ++i) {
        const count = inputFields.eq(i).attr('type')=='text'?5:8;
        if (inputFields.eq(i).val().trim().length < count && inputFields.eq(i).val().trim().length > 0) {
            event.preventDefault();
        }
    }
});

function addErrMsg(item, count) {
    if (!item.hasClass('err-input')) {
        item.addClass('err-input');
        item.after("<p class='err-msg sign-in-err form-text text-muted'>The count of chars must be more than " + count + "</p>");
    }
}

function removeErrMsg(item) {
    if (item.hasClass('err-input')) {
        item.removeClass('err-input');
        item.next().remove();
    }
}