function showMessage (data) {
    const message = document.getElementById("message");
    const {isError, msg} = data;
    message.classList.add(isError ? "message-error" : "message-success");
    message.innerHTML = msg;
    message.style.visibility = "visible";
}

function filterUsers (checkbox) {
    isChecked = checkbox.checked;
    const userLines = document.querySelectorAll(".userLine");
    for (line of userLines) {
        if (isChecked) {
            isAproved = line.dataset.aproved;
            if (isAproved == false) {
                line.style.display = "";
            } else {
                line.style.display = "none";
            }
        } else {
            line.style.display = "";
        }
    }
}