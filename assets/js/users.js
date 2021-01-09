function showMessage (data) {
    const message = document.getElementById("message");
    const {isError, msg} = data;
    message.classList.add(isError ? "message-error" : "message-success");
    message.innerHTML = msg;
    message.style.visibility = "visible";
}