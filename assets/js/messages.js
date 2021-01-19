function showMessageBanner (data) {
    const message = document.getElementById("message");
    const {isError, msg} = data;
    message.classList.add(isError ? "message-error" : "message-success");
    message.innerHTML = msg;
    message.style.visibility = "visible";
}

function showBadEdit(data) {
    const {reason, fields} = data;
    const warningArea = document.getElementById("badWarning");
    warningArea.style.visibility = "visible";
    warningArea.innerHTML = reason;
    if (fields != null) {
        fields.forEach(field => {
            document.getElementById(field).style.border = "2px solid red";
        });
    }
}