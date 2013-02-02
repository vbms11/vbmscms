
var chatVersion = 0;
var chatPollId = null;
var chatPollUrl = null;
var chatPollRate = 5000;
var chatMaxMesseges = 50;

function chatHandelPoll (result) {
    
    if (result == false) {
        // remove user from room
        chatPollId = null;
    } else {

        // get message
        var newMessages = document.createElement("messages");
        newMessages.innerHTML = result;

        // check version
        for (var i=0; i<newMessages.childNodes.length; i++) {
            if (newMessages.childNodes[i].nodeName == "VERSION") {
                var version = newMessages.childNodes[i].innerHTML;
                if (version == chatVersion)
                    return;
                chatSetVersion(version);
            }
        }

        // append new messages
        var el_chatMessages = document.getElementById("chatMessages");
        for (i=0; i<newMessages.childNodes.length; i++) {
            if (newMessages.childNodes[i].nodeName == "DIV") {
                var newMessage = document.createElement("div");
                newMessage.innerHTML = newMessages.childNodes[i].innerHTML;
                el_chatMessages.appendChild(newMessage);
            }
        }

        // remove old messages
        for (i=el_chatMessages.childNodes.length; i>=chatMaxMesseges; i--) {
            el_chatMessages.parentNode.removeChild(el_chatMessages.childNodes[0]);
        }

        // scroll to bottom
        el_chatMessages.scrollTop = el_chatMessages.scrollHeight;
    }
}

function chatPoll (url) {
    chatPollUrl = url + "&version=" + chatVersion;
    ajaxRequest(chatPollUrl,chatHandelPoll);
}

function chatStartPoll (url) {
    if (chatPollId == null) {
        chatPoll(url);
    } else {
        window.clearInterval(chatPollId);
    }
    chatPollId = window.setInterval("chatPoll('"+url+"');", chatPollRate);
}

function chatHandelKey (e,submitUrl) {
    // if enter was hit submit messege
    if (window.event) {
        e = window.event;
    }
    if (e.keyCode == 13) {
        var messege = document.getElementById("chatInput").value;
        document.getElementById("chatInput").value = "";
        ajaxRequest(submitUrl+"&version="+chatVersion+"&message="+messege,handelMessegeSubmited);
        return false;
    }
    return true;
}

function handelMessegeSubmited (result) {
    if (result == false) {
    } else {
        chatHandelPoll(result);
    }
}

function chatSetVersion (newVersion) {
    if (newVersion > chatVersion) {
        chatVersion = newVersion;
    }
}
