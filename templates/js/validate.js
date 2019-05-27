function validate(inputFields) {

    for (let i = 0; i < inputFields.length; ++i) {
        const item = inputFields.eq(i);
        item.blur(()=>{
            if (item.val().trim() == '') {
                addErrMsg(item);
            }
        });

        item.keydown(()=> {
            removeErrMsg(item);
        });
    }

    $('form').submit((event)=>{
        for (let i = 0; i < inputFields.length; ++i) {
            if (inputFields.eq(i).val().trim() == '') {
                addErrMsg(inputFields.eq(i));
                event.preventDefault();
            }
        }
    });

    function addErrMsg(item) {
        if (!item.hasClass('err-input')) {
            item.addClass('err-input');
            item.after("<p class='err-msg sign-in-err form-text text-muted'>Please fill in the field</p>");
        }
    }

    function removeErrMsg(item) {
        if (item.hasClass('err-input')) {
            item.removeClass('err-input');
            item.next().remove();
        }
    }
}