
var messageId = null;

$(function () {
    $('#save').click(function () {
        saveMessage(messageId);
    });
    $('#savenew').click(function () {
        saveMessage(null);
    });
});



function newMessage() {    
    $('#editform').css({display: 'block'});
    $('#editform>textarea').focus();
    $('#editform>span').html('New message');
}
function editMessage(msgId, afterUpdate) {
    messageId = msgId;
    $('#editform>span').html('Edit message #' + messageId);
    if (!afterUpdate) {
        $('#editform>textarea').val($('#messagebody-' + messageId).text());
        $('#editform>textarea').focus();
    }
    $('#save').css({display: 'inline-block'});
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
            msgId = newdiv.attr('data-messageid');
            editMessage(msgId, true);
        }
//        $('#save').css({display: 'none'});
//        $('#editform>span').html('New message');
    });
    messageId = null;
}