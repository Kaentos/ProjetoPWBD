function badLogin(reason) {
    let user_input = document.getElementById("l_user");
    let pwd_input = document.getElementById("l_pwd");
    let warningArea = document.getElementById("badWarning");
    warningArea.style.display = "block";
    warningArea.innerHTML = reason;
    borderRed([user_input, pwd_input]);
}

function badRegister(reason) {
    let warningArea = document.getElementById("badWarning");
    warningArea.style.display = "block";
    warningArea.innerHTML = reason;
}

function borderRed(array_input) {
    for (input of array_input) {
        input.style.borderColor = "red";
    }
}