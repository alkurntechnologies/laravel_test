$(function() {
    $('.chat_box').hide();
    $('#chat_box_pro').hide();
});

$(function() {
    Pusher.logToConsole = true;

    var pusher = new Pusher('4c0609882e52e8233b8c', {
        cluster: 'ap2',
        forceTLS: true
    });

    let channel = pusher.subscribe('chat');

    // let channel = pusher.subscribe('private-chat');


    // on click on any chat btn render the chat box
    $("chat-toggle").on("click", function(e) {
        $("chat-toggle").removeClass("active");
        $(this).addClass("active");
        e.preventDefault();
        //    $('.chat_box').show();
        let ele = $(this);

        let user_id = ele.attr("data-id");

        let username = ele.attr("data-user");

        let user = ele.attr("data-provider");

        let jobId = ele.attr("data-job-id");

        //    localStorage.setItem("user_id", user_id);
        //    if(localStorage.getItem("user_id")){
        //         $('.close-chat').trigger('click');
        //    }

        cloneChatBox(user_id, username, user, jobId, function() {
            let chatBox;
            if (user == "provider") {
                chatBox = $("#chat_box_pro");

            } else {
                chatBox = $("#chat_box");
            }
            chatBox.show();

            if (!chatBox.hasClass("chat-opened")) {

                chatBox.addClass("chat-opened").slideDown("fast");

                loadLatestMessages(chatBox, user_id, jobId);
                if (user == "provider") {
                    //chatBox.find(".chat-area").animate({ scrollTop: $("#chat_box_pro").find(".chat-area").offset().top + chatBox.find(".chat-area").outerHeight(true) }, 1000, 'swing');
                    // chatBox.find(".chat-area").animate({ scrollTop: $(document).height() }, 1000);

                } else {
                    //chatBox.find(".chat-area").animate({ scrollTop: $("#chat_box").find(".chat-area").offset().top + chatBox.find(".chat-area").outerHeight(true) }, 1000, 'swing');
                    // chatBox.find(".chat-area").animate({ scrollTop: $(document).height() }, 1000);

                }

            }
        });

    });

    // on close chat close the chat box but don't remove it from the dom
    $(".close-chat").on("click", function(e) {
        $(".chat-toggle").removeClass("active");
        $(this).closest('.chat_area').remove();
        $(this).parents("div.chat-opened").removeClass("chat-opened").slideUp("fast");
    });


    // on change chat input text toggle the chat btn disabled state
    $(".chat_input").on("change keyup", function(e) {

        if ($(this).val() != "") {
            $(this).parents(".form-controls").find(".btn-chat1").prop("disabled", false);
        } else {
            $(this).parents(".form-controls").find(".btn-chat1").prop("disabled", true);
        }
    });


    // on click the btn send the message
    $("btn-chat1").on("click", function(e) {
        var user = $(this).attr('data-user');
        var to_user = $(this).attr('data-to-user');
        var jobId = $(this).attr('data-job-id');
        var message;
        var frmId = $(this).closest('form').attr('id');
        var formData = new FormData();
        formData.append('to_user', to_user);
        formData.append('job_id', jobId);
        formData.append('_token', csrf);
        if (user == 'provider') {
            message = $("#text").val();
            formData.append('clip', $("#file-upload")[0].files);

            $("#text").val("");
            $(".custom-file-upload").removeClass("file");
            $(this).parents(".form-controls").find(".btn-chat1").prop("disabled", true);

        } else {
            message = $("#chat_box" + to_user).find(".chat_input").val();
            file = $("#file-upload")[0].files[0];
            formData.append('clip', file);
            // $(this).parents(".form-controls").find("#file-upload").val("");
            $(".btn-chat1").prop("disabled", true);
            $("#file-upload").val("");
            $(".custom-file-upload").removeClass("file");
            $(".chat_input").val("");

        }
        formData.append('message', message);

        send(user, $(this).attr('data-to-user'), message, formData);
    });

    // listen for the send event, this event will be triggered on click the send btn
    channel.bind('send', function(data) {
        displayMessage(data.data);
    });


    // handle the scroll top of any chat box
    // the idea is to load the last messages by date depending of last message
    // that's already loaded on the chat box
    let lastScrollTop = 0;

    $(".chat-area").on("scroll", function(e) {
        let st = $(this).scrollTop();

        if (st < lastScrollTop) {
            fetchOldMessages($(this).parents(".chat-opened").find("#to_user_id").val(), $(this).find(".msg_container:first-child").attr("data-message-id"));
        }

        lastScrollTop = st;
    });

    // listen for the oldMsgs event, this event will be triggered on scroll top
    channel.bind('oldMsgs', function(data) {
        displayOldMessages(data);
    });
});

/**
 * loaderHtml
 *
 * @returns {string}
 */
function loaderHtml() {
    return '<i class="fa fa-refresh loader"></i>';
}

/**
 * cloneChatBox
 *
 * this helper function make a copy of the html chat box depending on receiver user
 * then append it to 'chat-overlay' div
 *
 * @param user_id
 * @param username
 * @param callback
 */
function cloneChatBox(user_id, username, user, jobId, callback) {
    if (user == "provider") {
        if ($("#chat_box_pro").length == 0) {

            let cloned = $("#chat_box_pro").clone(true);
            // change cloned box id
            cloned.removeAttr("id");

            cloned.attr("id", "chat_box_pro");

            cloned.find(".chat-user").text(username);

            cloned.find(".btn-chat1").attr("data-to-user", user_id);

            cloned.find(".btn-chat1").attr("data-job-id", jobId);

            cloned.find("#to_user_id").val(user_id);

            $("#chat-overlay-pro").append(cloned);
        }
    } else {
        if ($("#chat_box" + user_id).length == 0) {

            let cloned = $("#chat_box").clone(true);
            // change cloned box id
            cloned.removeAttr("id");

            cloned.attr("id", "chat_box" + user_id);

            cloned.find(".chat-user").text(username);

            cloned.find(".btn-chat1").attr("data-to-user", user_id);

            cloned.find(".btn-chat1").attr("data-job-id", jobId);

            cloned.find("#to_user_id").val(user_id);

            $("#chat-overlay").append(cloned);
        }

    }

    callback();
}

/**
 * loadLatestMessages
 *
 * this function called on load to fetch the latest messages
 *
 * @param container
 * @param user_id
 */
function loadLatestMessages(container, user_id, jobId) {
    let chat_area = container.find(".chat-area");
    chat_area.html("");

    $.ajax({
        url: base_url + "/load-latest-messages",
        data: { user_id: user_id, job_id: jobId },
        method: "GET",
        dataType: "json",
        beforeSend: function() {
            if (chat_area.find(".loader").length == 0) {
                chat_area.html(loaderHtml());
            }
        },
        success: function(response) {
            if (response.state == 1) {
                // response.messages.map(function(val, index) {
                console.log(chat_area)
                chat_area.html(response.message);
                // });
            }
        },
        complete: function() {
            chat_area.find(".loader").remove();
        }
    });
}

/**
 * send
 *
 * this function is the main function of chat as it send the message
 *
 * @param to_user
 * @param message
 */
function send(user, to_user, message, formData) {

    var chat_box = $("#chat_box");

    let chat_area = $(".chat-area");

    $.ajax({
        url: base_url + "/send",
        method: "POST",
        data: formData,
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        dataType: "json",
        beforeSend: function() {
            if (chat_area.find(".loader").length == 0) {
                chat_area.append(loaderHtml());
            }
        },
        success: function(response) {
            if (response.state == 1) {
                var message = appendMessage(response.data);
                chat_area.append(message);
                console.log(chat_area)
                loadLatestMessages(chat_box, response.data.from_id, response.data.job_id);

                // appendReceiveMessage(response, user);
            }

        },
        complete: function() {
            chat_area.find(".loader").remove();
            chat_area.find(".btn-chat1").prop("disabled", true);
            $('#sendMsgBtn').prop("disabled", true);
            $("#chat_box_pro").find(".chat_input").val("");

            chat_area.find(".chat_input").val("");
            chat_area.animate({ scrollTop: chat_area.offset().top + chat_area.outerHeight(true) }, 1000, 'swing');
        }
    });
}

/**
 * fetchOldMessages
 *
 * this function load the old messages if scroll up triggerd
 *
 * @param to_user
 * @param old_message_id
 */
function fetchOldMessages(to_user, old_message_id) {
    let chat_box = $("#chat_box");
    let chat_area = chat_box.find(".chat-area");

    $.ajax({
        url: base_url + "/fetch-old-messages",
        data: { to_user: to_user, old_message_id: old_message_id, _token: $("meta[name='csrf-token']").attr("content") },
        method: "GET",
        dataType: "json",
        beforeSend: function() {
            if (chat_area.find(".loader").length == 0) {
                chat_area.prepend(loaderHtml());
            }
        },
        success: function(response) {},
        complete: function() {
            chat_area.find(".loader").remove();
        }
    });
}

/**
 * getMessageSenderHtml
 *
 * this is the message template for the sender
 *
 * @param message
 * @returns {string}
 */
function getMessageSenderHtml(message) {
    return `
           <div class="row msg_container base_sent" data-message-id="${message.id}">
        <div class="col-md-10 col-xs-10">
            <div class="messages msg_sent text-right">
            @if(message.message != null)
                <p>${message.message}</p>
            @else
                <p><img src="` + base_url + 'storage/app' + message.file + `" width="50" height="50" class="img-responsive"></p>
            @endif
                <time datetime="${message.dateTimeStr}"> ${message.fromUserName} • ${message.dateHumanReadable} </time>
            </div>
        </div>
        <div class="col-md-2 col-xs-2 avatar">
            <img src="` + base_url + '/images/user-avatar.png' + `" width="50" height="50" class="img-responsive">
        </div>
    </div>
    `;
}

/**
 * getMessageReceiverHtml
 *
 * this is the message template for the receiver
 *
 * @param message
 * @returns {string}
 */
function getMessageReceiverHtml(message) {
    return `
           <div class="row msg_container base_receive div-reciever" data-message-id="${message.id}">
           <div class="col-md-2 col-xs-2 avatar">
             <img src="` + base_url + '/images/user-avatar.png' + `" width="50" height="50" class="img-responsive">
           </div>
        <div class="col-md-10 col-xs-10">
            <div class="messages msg_receive text-left text-recieve">
            @if(message.message != null)
                <p>${message.message}</p>
            @else
                <p><img src="` + base_url + 'storage/app' + message.file + `" width="50" height="50" class="img-responsive"></p>
            @endif
                <time datetime="${message.dateTimeStr}"> ${message.dateHumanReadable} </time>
            </div>
        </div>
    </div>
    `;
}

/**
 * This function called by the send event triggered from pusher to display the message
 *
 * @param message
 */
function displayMessage(message) {
    let alert_sound = document.getElementById("chat-alert-sound");

    if ($("#current_user").val() == message.from_user_id) {

        let messageLine = getMessageSenderHtml(message);

        $("#chat_box").find(".chat-area").append(messageLine);

    } else if ($("#current_user").val() == message.to_user_id) {

        alert_sound.play();

        // for the receiver user check if the chat box is already opened otherwise open it
        cloneChatBox(message.from_user_id, message.fromUserName, function() {

            let chatBox = $("#chat_box");

            if (!chatBox.hasClass("chat-opened")) {

                chatBox.addClass("chat-opened").slideDown("fast");

                loadLatestMessages(chatBox, message.from_id, message.job_id);

                // chatBox.find(".chat-area").animate({ scrollTop: chatBox.find(".chat-area").offset().top + chatBox.find(".chat-area").outerHeight(true) }, 800, 'swing');
            } else {

                let messageLine = getMessageReceiverHtml(message);

                // append the message for the receiver user
                $("#chat_box").find(".chat-area").append(messageLine);
            }
        });
    }
}

function displayOldMessages(data) {
    if (data.data.length > 0) {

        data.data.map(function(val, index) {
            $("#chat_box").find(".chat-area").prepend(val);
        });
    }
}

function myFunction(item, index) {
    $('#chatThread_' + item['id']).hide();
    $('#chat' + item['id']).on("click", function() {
        id = $(this).attr('data-id');
        user_id = $(this).attr('data-user-id');
        job_id = $(this).attr('data-job-id');
        console.log(job_id)
        $('#chatThread_' + id).show();

        var container = $('#chatThread_' + id);

        container.find(".chat-btn1").attr("data-to-user", user_id);
        container.find(".chat-btn1").attr("data-job-id", job_id);

        container.find("#to_user_id").val(user_id);

        $('.nav-link').each(function() {
            if ($(this).hasClass('active')) {
                var previousId = $(this).attr('data-id');

                if (id != previousId) {
                    $('#chatThread_' + previousId).hide();
                    $(this).removeClass('active');
                    $('#supportInfo' + previousId).hide();
                }
            }

        });


        $('#supportInfo' + id).show();
        $('#supportInfo' + id).addClass('support');
        $('#chat' + item['id']).addClass('active');
        // var chatBox = $('#chat' + item['id']);    
        loadMessages(item['id'], user_id, job_id);
        // container.find(".chat-msgs").animate({ scrollTop: container.find(".chat-msgs").offset().top + container.find(".chat-msgs").outerHeight(true) }, 1000, 'swing');

    });
}

function loadMessages(from_user, user_id, job_id) {
    let chat_area = $('#chatThread_' + from_user);
    chat_area.find(".chat-msgs").html("");

    $.ajax({
        url: base_url + "/load-messages",
        data: { user_id: user_id, job_id: job_id, _token: csrf },
        method: "GET",
        dataType: "json",
        beforeSend: function() {
            if (chat_area.find(".chat-msgs").find(".loader").length == 0) {
                chat_area.find(".chat-msgs").html(loaderHtml());
            }
        },
        success: function(response) {
            if (response.state == 1) {
                // response.message.map(function(val, index) {
                chat_area.find(".chat-msgs").append(response.message);
                // });

            }
        },
        complete: function() {
            chat_area.find(".loader").remove();
            if (chat_area.find(".chat-msgs")[0].scrollHeight - chat_area.find(".chat-msgs").innerHeight() > chat_area.find(".chat-msgs").scrollTop()) {
                chat_area.find(".chat-msgs").stop().animate({ scrollTop: chat_area.find(".chat-msgs")[0].scrollHeight }, 10);
            }
        }


    });
}

$('#clip').change(function() {
    $(this).parents(".write-msg-div").find(".chat-btn1").prop("disabled", false);
});

$('#file-upload').change(function() {
    $(this).parents(".form-controls").find(".btn-chat1").prop("disabled", false);
    $(".btn-chat1").prop("disabled", false);
});

$(".chat-btn1").on("click", function(e) {
    $(this).parents(".write-msg-div").find(".chat-btn1").prop("disabled", true);
    var user = $(this).attr('data-user');
    var to_user = $(this).attr('data-to-user');
    var from_user = $(this).attr('data-from-user');
    var job_id = $(this).attr('data-job-id');
    var message;
    var frmId = $(this).closest('form').attr('id');
    var formData = new FormData($('#' + frmId)[0]);
    formData.append('to_user', to_user);
    formData.append('job_id', job_id);

    formData.append('_token', csrf);
    // console.log(frmId);
    $.each($("#chatThread_" + from_user).find("#file-upload")[0].files, function(i, file) {
        formData.append('file', file);
    });

    if (user == 'provider') {

        // file = $("#chatThread_" + from_user).find("#clip")[0].files[0];

        // if (file) {
        //     fileMessage = file;
        // } else {
        //     fileMessage = null;
        // }

        message = $("#chatThread_" + from_user).find(".input-chat").val();

    } else {


        message = $("#chatThread_" + from_user).find(".input-chat").val();
    }
    formData.append('message', message);
    console.log(message);
    $('.paperclip').find('span:first').text('');
    sendMessage(user, to_user, message, from_user, formData);

});

function sendMessage(user, to_user, message, from_user, formData) {

    let chat_box = $("#chatThread_" + from_user);

    let chat_area = chat_box.find(".chat-msgs");

    $.ajax({
        url: base_url + "/send",
        // data: { 'fileMessage': fileMessage, 'to_user': to_user, 'message': message, '_token': csrf },
        method: "POST",
        data: formData,
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        dataType: "json",
        beforeSend: function() {
            if (chat_area.find(".loader").length == 0) {
                chat_area.append(loaderHtml());
            }
        },
        success: function(response) {
            if (response.state == 1) {
                var message = response.data;
                // chat_area.append(message);
                chat_box.find("#clip").val("");
                chat_box.find(".input-chat").val("");
                // updateChat($("#chatThread_" + from_user));
                loadLatestMessages(chat_box, message.from_id, message.job_id);
            }
            // showRecievedMessage(response, user, from_user);
        },
        complete: function() {
            chat_area.find(".loader").remove();
            chat_box.find(".chat-btn1").prop("disabled", true);
            chat_box.find(".input-chat").val("");
            // chat_area.animate({ scrollTop: chat_area.offset().top + chat_area.outerHeight(true) }, 1000, 'swing');
        }
    });
}

$(".input-chat").on("change keyup", function(e) {
    if ($(this).val() != "") {
        $(this).parents(".write-msg-div").find(".chat-btn1").prop("disabled", false);
    } else {
        $(this).parents(".write-msg-div").find(".chat-btn1").prop("disabled", true);
    }
});

function appendMessage(message) {
    var file = message['file'];
    var extension = message['extension'];
    var date = message['dateHumanReadable'];

    if (message['message'] != null) {
        return `
            <div class="div-reciever">
                <div class="text-recieve">
                        ${message.message}
                   
                    <span > ` + date + ` </div> </div>`;
    } else if (extension == 'pdf') {
        return `
        <div class="div-reciever">
            <div class="text-recieve">
            <p> <a href="` + base_url + '/storage/app/' + file + `" download><i
            class="fa fa-file-pdf"></i></a></p>
               
                <span > ` + date + ` </div> </div>`;
    } else if (extension == 'doc' || extension == 'docx') {
        return `
            <div class="div-reciever">
                <div class="text-recieve">
                <p > < a href = "` + base_url + '/storage/app/' + file + `"
                download > < i
                class = "fa fa-file-word" > < /i></a > < /p>
                   
                    <span > ` + date + ` </div> </div>`;
    } else if (extension == 'xlsx') {
        return `
        <div class="div-reciever">
            <div class="text-recieve">
            <p > < a href = "` + base_url + '/storage/app/' + file + `"
            download > < i
            class = "fa fa-file-excel-o" > < /i></a > < /p>
               
                <span > ` + date + ` </div> </div>`;
    } else if (extension == 'jpg' || extension == 'png' || extension == 'jpeg') {
        return `
        <div class="div-reciever">
            <div class="text-recieve">
           <p> <img src= "` + base_url + '/storage/app/' + file + `"
            width = "50"
            height = "50"
            class = "img-responsive"></p> 
               
                <span > ` + date + ` </div> </div>`;
    }
}

function firstChat(thread) {
    $('#chat' + thread).trigger('click');
    id = $('#chat' + thread).attr('data-id');
    user_id = $('#chat' + thread).attr('data-user-id');
    job_id = $('#chat' + thread).attr('data-job-id');
    $('#chatThread_' + id).show();
    console.log(job_id)
    var container = $('#chatThread_' + id);

    container.find(".chat-btn1").attr("data-to-user", user_id);

    container.find("#to_user_id").val(user_id);

    container.find(".chat-btn1").attr("data-job-id", job_id);;

    loadMessages(thread, user_id, job_id);
    // container.find(".chat-msgs").animate({ scrollTop: container.find(".chat-msgs").offset().top + container.find(".chat-msgs").outerHeight(true) }, 1000, 'swing');

}

function updateChat(thread) {
    console.log(thread)
        // $('#chat' + thread).trigger('click');
    id = thread.attr('data-id');
    user_id = thread.attr('data-user-id');
    job_id = thread.attr('data-job-id');
    // $('#chatThread_' + id).show();
    console.log(job_id)
    var container = $('#chatThread_' + from_user);

    container.find(".chat-btn1").attr("data-to-user", user_id);

    container.find("#to_user_id").val(user_id);

    container.find(".chat-btn1").attr("data-job-id", job_id);;

    loadMessages(container, user_id, job_id);
    // container.find(".chat-msgs").animate({ scrollTop: container.find(".chat-msgs").offset().top + container.find(".chat-msgs").outerHeight(true) }, 1000, 'swing');

}

function appendReceiveMessage(response, user) {
    let alert_sound = document.getElementById("chat-alert-sound");
    if ($("#current_user").val() != response.to_user) {
        alert_sound.play();
        let messageLine = getMessageReceiverHtml(response.data);
        // append the message for the receiver user
        if (user == 'provider') {
            chat_box = $("#chat_box");
        } else {
            chat_box = $("#chat_box_pro");
        }
        let chat_area = chat_box.find(".chat-area");

        if (user == 'provider') {
            console.log(1)
            chat_area.append(messageLine);
        } else {
            console.log(2)
            chat_area.append(messageLine);
        }
    }
}

function showRecievedMessage(response, user, from_user) {
    let alert_sound = document.getElementById("chat-alert-sound");
    if ($("#current_user").val() != response.to_user) {
        alert_sound.play();
        let messageLine = getMessageReceiverHtml(response.data);
        // append the message for the receiver user
        let chat_box = $("#chatThread_" + from_user);
        let chat_area = chat_box.find(".chat-area");

        chat_area.append(messageLine);
    }
}

$('#searchChat').change(function() {
    var search = $(this).val();
    console.log(search);
    $.ajax({
        url: base_url + "/chat-search",
        data: { 'search': search, '_token': csrf },
        method: "POST",
        dataType: "json",
        success: function(response) {
            if (response.state == 1) {
                var message = appendMessage(response.data);
                chat_area.append(message);
                chat_box.find("#clip").val("");

            }
            showRecievedMessage(response, user, from_user);
        },
        complete: function() {
            chat_area.find(".loader").remove();
            chat_box.find(".chat-btn1").prop("disabled", true);
            chat_box.find(".input-chat").val("");
            // chat_area.animate({ scrollTop: chat_area.offset().top + chat_area.outerHeight(true) }, 1000, 'swing');
        }
    });
})