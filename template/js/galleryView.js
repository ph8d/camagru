var commentsContainer = document.querySelector("#post-comment-section");
var btnComments = document.querySelector(".top-action-btn.comments");
var btnAddComment = document.querySelector("#add-comment");
var textAreaComment = document.querySelector("#post-bottom-action-section textarea");
var btnLike = document.querySelector(".top-action-btn.like");
var btnLikeImg = document.querySelector(".top-action-btn.like img");
var likeCounter = document.querySelector("#like-count");
var btnDeletePost = document.querySelector(".top-action-btn.delete");
var postId = document.querySelector("#add-comment").getAttribute("data-post-id");

document.addEventListener("DOMContentLoaded", function () {
    loadComments();
    addListeners();
});

function addListeners() {

    btnLike.addEventListener("click", likeHandler, false);
    if (btnDeletePost) {
        btnDeletePost.addEventListener("click", deletePost, false);
    }
    btnAddComment.addEventListener("mousedown", addComment, false);

    commentsContainer.addEventListener("click", deleteComment, false);

    textAreaComment.addEventListener("change", textAreaAutoResize, false);
    textAreaComment.addEventListener("cut", delayedTextAreaAutoResize, false);
    textAreaComment.addEventListener("paste", delayedTextAreaAutoResize, false);
    textAreaComment.addEventListener("drop", delayedTextAreaAutoResize, false);
    textAreaComment.addEventListener("keydown", function (event) {
        delayedTextAreaAutoResize(event);
        if (event.keyCode === 13 && event.shiftKey === false) {
            addComment();
        }
    }, false);

}

btnComments.onclick = function () {
    textAreaComment.focus();
};


function deletePost() {

    if (confirm("Are you sure you want to delete this post?")) {
        var XHR = new XMLHttpRequest();

        XHR.addEventListener("load", function(event) {
            if (event.target.responseText === "true") {
                window.location.href = '/gallery';
            }
        });

        XHR.addEventListener("error", function(event) {
            console.error('There was an error sending data to the server');
        });

        XHR.open("POST", "/post/delete");
        XHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        XHR.send("post_id=" + postId);
    }

}

/* Like handling */

function likeHandler() {
    var XHR = new XMLHttpRequest();

    XHR.addEventListener("load", function(event) {
        toggleLikeStatus(event.target.responseText);
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
        targetElement.innerHTML = "Likes " + event.target.responseText;
    });

    XHR.addEventListener("error", function(event) {
        console.error('There was an error sending data to the server');
    });

    XHR.open("POST", "/like/count");
    XHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    XHR.send("post_id=" + postId);
}

function toggleLikeStatus(serverResponse) {
    if (serverResponse === "1")
        btnLikeImg.src = "/img/heart-shape-silhouette.svg";
    else
        btnLikeImg.src = "/img/heart.svg";
}


/* Comments Handling */

function textAreaAutoResize(event) {

    var heightLimit = 72;

    event.target.style.height = '22px';
    event.target.style.height = Math.min(event.target.scrollHeight, heightLimit) + 'px';

}

function delayedTextAreaAutoResize(event) {
    window.setTimeout(textAreaAutoResize, 0, event);
}

function loadComments() {

    var xhttp = new XMLHttpRequest();

    xhttp.open("POST", '/comment/load', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("post_id=" + postId);

    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            commentsContainer.innerHTML = this.responseText;
            commentsContainer.style.display = "";
        }
    };
}

function fixedEncodeURIComponent (str) {
    return encodeURIComponent(str).replace(/[!'()*]/g, function(c) {
        return '%' + c.charCodeAt(0).toString(16);
    });
}

function addComment() {

    if (textAreaComment.value.trim()) {

        var xhttp = new XMLHttpRequest();

        var commentText = textAreaComment.value.replace(/</g, "&lt;").replace(/>/g, "&gt;").trim();
        commentText = fixedEncodeURIComponent(commentText);

        xhttp.open("POST", '/comment/add', true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("post_id=" + postId + "&" + "text=" + commentText);

        xhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                textAreaComment.value = '';
                textAreaComment.style.height = "22px";
                loadComments();
            }
        };
        return true;
    }
    return false;
}

function deleteComment(event) {
    if (event.target !== event.currentTarget && event.target.getAttribute("data-comment-id")) {
        var xhttp = new XMLHttpRequest();

        var commentId = event.target.getAttribute("data-comment-id");

        xhttp.open("POST", '/comment/remove', true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("comment_id=" + commentId);

        xhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                loadComments();
            }
        };
    }
    event.stopPropagation();
}