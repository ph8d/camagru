document.querySelectorAll(".like").forEach(function(elem) {
    elem.addEventListener("click", likeHandler, false);
});

function likeHandler(event) {
    var XHR = new XMLHttpRequest();
    var postId = this.getAttribute("data-post-id");
    var likeCounter = event.currentTarget;

    XHR.addEventListener("load", function(event) {
        toggleLikeStatus(event.target.responseText, likeCounter);
        updateLikeCounter(postId, likeCounter);
    });

    XHR.addEventListener("error", function(event) {
        console.error('There was an error sending form data to the server');
    });

    XHR.open("POST", "/like/toggle");
    XHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    XHR.send("post_id=" + postId);
}

function updateLikeCounter(postId, targetElement) {
    var XHR = new XMLHttpRequest();

    XHR.addEventListener("load", function(event) {
        targetElement.innerHTML = "Like " + event.target.responseText;
    });

    XHR.addEventListener("error", function(event) {
        console.error('There was an error sending data to the server');
    });

    XHR.open("POST", "/like/count");
    XHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    XHR.send("post_id=" + postId);
}

function toggleLikeStatus(serverResponse, likeCounter) {
    if (serverResponse === '1') {
        likeCounter.className = "like liked";
    } else {
        likeCounter.className = "like unliked";
    }
}