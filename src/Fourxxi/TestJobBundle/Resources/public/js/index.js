
var messageId = null;

$(function () {
    if (window.location.hash === '#comment')
        newMessage();
});


function newMessage() {
    messageId = null;
    $('#editform>span').html('New message');
    $('#editform>textarea').val('');
    $('#editform').css({display: 'block'});
    $('#editform>textarea').focus();
}
function editMessage(msgId) {
    messageId = msgId;
    $('#editform>span').html('Edit message #' + messageId);
    $('#editform>textarea').val($('#messagebody-' + messageId).text());
    $('#editform').css({display: 'block'});
    $('#editform>textarea').focus();
}

function saveMessage() {
    var data = {};
    if (messageId) {
        data.id = messageId;
    }
    data.body = $('#body').val();
    $.post("message", data).done(function (data) {
        if (messageId) {
            $('.messagediv[data-messageid=' + messageId + ']').replaceWith(data);
        } else {
            newdiv = $(data);
            $('#messages').append(newdiv);
        }
    });
    $('#editform').css({display: 'none'});
}