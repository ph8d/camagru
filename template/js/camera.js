var video = document.getElementById('web-cam');
var canvas = document.getElementById('canvas');
var context = canvas.getContext('2d');
var pauseWebCam = document.querySelector("#pause-cam");
var unPauseWebCam = document.querySelector("#unpause-cam");

if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia)
{
    navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream)
    {
        video.srcObject = stream;
        video.play();
    });
}

pauseWebCam.addEventListener("click", function () {
    video.pause();
}, false);

unPauseWebCam.addEventListener("click", function () {
    video.play();
}, false);


var showFileSelectedMsg = (function() {
    var executed = false;
    return function() {
        if (!executed) {
            executed = true;

            video.srcObject = null;
            video.style.display = "none";
            var msg = document.createTextNode("File that you've selected will be used to make an image");
            var paragraph = document.createElement("p");
            paragraph.className = "msg-file-selected";
            paragraph.appendChild(msg);
            document.querySelector("#cam-div").appendChild(paragraph);
            pauseWebCam.disabled = true;
            unPauseWebCam.disabled = true;
        }
    };
})();

document.querySelector("#input-file").addEventListener("change", showFileSelectedMsg, false);

var cameraForm = document.querySelector("form");

cameraForm.addEventListener("submit", function (event) {
    event.preventDefault();
    context.drawImage(video, 0, 0, 500, 375);
    sendFormData(canvas.toDataURL());
});

function sendFormData(imgData) {
    var XHR = new XMLHttpRequest();
    var formData = new FormData(cameraForm);
    formData.append("img", imgData);

    XHR.addEventListener("load", function(event) {
        if (event.target.responseText.match(/^img*/)) {
            appendImgReceivedFromServer(event.target.responseText);
        }
    });

    XHR.addEventListener("error", function(event) {
        console.error('There was an error sending form data to the server');
    });

    XHR.open("POST", "/post/create");
    XHR.send(formData);
}

function appendImgReceivedFromServer(imgPath) {
    var newImg = new Image;
    newImg.src = "/" + imgPath;
    newImg.className = "img-result";
    document.querySelector("#user-pictures").appendChild(newImg);
}