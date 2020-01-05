
$(document).ready(function(){
    $("#addContent").click(function(e){
        document.getElementById("adminIframe").contentWindow.postMessage("moduleMenu", "*");
    });
});

function onMessage (e) {
    if (e.data == "confirm") {
        alert("receved message confirm");
    }
    switch (e.data) {
        case "confirm":
            document.getElemenetById("adminIframe").contentWindow.postMessage("confirmDone", "*");
            break;
        case "close":
            document.location.href = $(".adminIframe")[0].location.href;
            break;
    }
};

if ( window.addEventListener ) {
    window.addEventListener('message', onMessage, false);
} else if ( window.attachEvent ) { // ie8
    window.attachEvent('onmessage', onMessage);
}
 