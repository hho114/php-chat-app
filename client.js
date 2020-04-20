

var pollServer = function () {
    $.get('chat.php', function (result) {

        if (!result.success) {
            console.log("Error polling server for new messages!");

            return;
        }

        $.each(result.messages, function (idx) {

            var chatBubble;
            var colors = ['#7FFFD4', '#FFEBCD', '#6495ED', '#FF8C00', '#8FBC8F', '#F08080', '#87CEFA', '#FF69B4', '#40E0D0', "#F5DEB3"];
            var random_color = colors[this.usr_id % 10];//pick random color base on user id

            if (this.sent_by == 'self') {
                chatBubble = $('<div class="row bubble-sent pull-right">' +
                    "Me: " + this.message +
                    '</div><div class="clearfix"></div>');
            } else {
                chatBubble = $('<div class="row bubble-recv" style="background-color:' + random_color + '">' +
                    this.usr_name + ": " + this.message +
                    '</div><div class="clearfix"></div>');
            }

            $('#chatPanel').append(chatBubble);


        });

        setTimeout(pollServer, 5000);
    });
}

$(document).on('ready', function () {
    pollServer();

    $('button').click(function () {
        $(this).toggleClass('active');
    });
});

$('#sendMessageBtn').on('click', function (event) {
    event.preventDefault();

    var message = $('#chatMessage').val();

    $.post('chat.php', {
        'message': message
    }, function (result) {

        $('#sendMessageBtn').toggleClass('active');


        if (!result.success) {
            alert("There was an error sending your message");
        } else {
            console.log("Message sent!");
            $('#chatMessage').val('');
        }
    });

});

