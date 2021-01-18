function showMessage (data) {
    const message = document.getElementById("message");
    const {isError, msg} = data;
    message.classList.add(isError ? "message-error" : "message-success");
    message.innerHTML = msg;
    message.style.visibility = "visible";
}

function showBadEdit(reason, fields=null) {
    const warningArea = document.getElementById("badWarning");
    warningArea.style.visibility = "visible";
    warningArea.innerHTML = reason;
    if (fields != null) {
        fields.forEach(field => {
            borderRed(document.getElementById(field));
        });
    }
}