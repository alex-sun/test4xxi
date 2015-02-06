
var messageId = null;

$(function () {
    $('#save').click(function () {
        saveMessage(messageId);
    });
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

function saveMessage(msgId) {
    var data = {};
    if (msgId) {
        data.id = msgId;
    }
    data.body = $('#body').val();
    $.post("message", data).done(function (data) {
        if (msgId) {
            $('.messagediv[data-messageid=' + msgId + ']').replaceWith(data);
        } else {
            newdiv = $(data);
            $('#messages').append(newdiv);
        }
    });
    $('#editform').css({display: 'none'});
    messageId = null;
}