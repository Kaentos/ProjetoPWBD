function badLogin() {
    let user_input = document.getElementById("l_user");
    let pwd_input = document.getElementById("l_pwd");
    borderRed([user_input, pwd_input]);
}

function borderRed(array_input) {
    for (input of array_input) {
        input.style.borderColor = "red";
    }
}