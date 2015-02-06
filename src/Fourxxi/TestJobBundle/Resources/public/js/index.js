
var messageId = null;

$(function () {
    $('#save').click(function () {
        saveMessage(messageId);
    });
});



function newMessage() {
    messageId = null;
    $('#editform>textarea').focus();
    $('#editform>span').html('New message');
    $('#editform').css({display: 'block'});
    $('#body').val('');
}
function editMessage(msgId, afterUpdate) {
    messageId = msgId;
    $('#editform>span').html('Edit message #' + messageId);
    if (!afterUpdate) {
        $('#editform>textarea').val($('#messagebody-' + messageId).text());
        $('#editform>textarea').focus();
    }
    $('#editform').css({display: 'block'});
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