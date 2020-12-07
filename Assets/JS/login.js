function incorrectData(user) {
    let user_input = document.getElementById("user");
    let pwd_input = document.getElementById("pwd");
    user_input.value = user;
    borderRed([user_input, pwd_input]);
}

function borderRed(array_input) {
    for (input of array_input) {
        input.style.borderColor = "red";
    }
}