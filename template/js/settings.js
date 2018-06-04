var settingsForm = document.querySelector("#form-settings");

settingsForm.addEventListener("submit", function (event) {
    event.preventDefault();
    sendFromData();
});

function sendFromData() {
    var XHR = new XMLHttpRequest();
    var formData = new FormData(settingsForm);

    XHR.addEventListener("load", function(event) {
        alert("Settings was successfully changed!");
    });

    XHR.addEventListener("error", function(event) {
        console.error('There was an error sending form data to the server');
    });

    XHR.open("POST", "/settings/save");
    XHR.send(formData);
}