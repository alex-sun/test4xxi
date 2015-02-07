$(function () {
    $('#newuser').attr('checked', false).change(function () {
        setAction($(this).is(":checked"));
    });
    setAction(false);
});


function setAction(isNewUser) {
    if (isNewUser) {
        $('#firstName,#lastName').css({display: 'block'}).attr("required", "true");
        $('form').get(0).setAttribute('action','./newuser');
    } else {
        $('#firstName,#lastName').css({display: 'none'}).removeAttr('required');
        $('form').get(0).setAttribute('action','./login_check');
    }
}