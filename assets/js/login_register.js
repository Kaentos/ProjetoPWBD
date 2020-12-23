"use strict";

/* BOTH */
function borderRed(array_input) {
    for (const input of array_input) {
        input.style.border = "2px solid red";
    }
}





/* LOGIN */
const loginInputValidations = {
    "l_user" : {
        isValid: false,
        minLength: 4,
        maxLength: 128
    },
    "l_pwd" : {
        isValid: false,
        minLength: 4,
        maxLength: 64
    },
};
function activateLiveCheckLogin() {
    document.getElementById("loginBtn").classList.add("disabled");
    document.getElementById("loginBtn").disabled = true;
    document.getElementById("l_user").addEventListener("keyup", checkLoginInput);
    document.getElementById("l_pwd").addEventListener("keyup", checkLoginInput);
}

function checkLoginButton() {
    for (const id in loginInputValidations) {
        if (!loginInputValidations[id].isValid) {
            document.getElementById("loginBtn").classList.add("disabled");
            document.getElementById("loginBtn").disabled = true;
            return;
        }
    }
    document.getElementById("loginBtn").classList.remove("disabled");
    document.getElementById("loginBtn").disabled = false;
}

function checkLoginInput(event) {
    const {id, value} = event.target;
    if (value.length >= loginInputValidations[id].minLength && value.length <= loginInputValidations[id].maxLength) {
        loginInputValidations[id].isValid = true;
        event.target.classList.add("valid");
        event.target.classList.remove("invalid");
    } else {
        loginInputValidations[id].isValid = false;
        event.target.classList.add("invalid");
        event.target.classList.remove("valid");
    }
    checkLoginButton();
}


function badLogin(reason) {
    const userInput = document.getElementById("l_user");
    const pwdInput = document.getElementById("l_pwd");
    const warningArea = document.getElementById("badWarning");
    warningArea.style.visibility = "visible";
    warningArea.innerHTML = reason;
    borderRed([userInput, pwdInput]);
}





/* REGISTER */
const registerInputValidations = {
    "r_username": {
        isValid: false,
        regex: new RegExp("^(?=.+[a-zA-Z])[a-zA-Z1-9_]{4,16}$")
    },
    "r_email": {
        isValid: false,
        regex: new RegExp("^[a-zA-Z1-9_.-]{1,64}@{1}[a-z-]{1,32}.{1}[a-z]{2,6}$")
    },
    "r_pwd": {
        isValid: false,
        regex: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d+!?#$%&_\-.,;]{4,64}$/
    },
    "r_name": {
        isValid: false,
        regex: new RegExp("^[a-zA-Z]{2,32} {1}[a-zA-Z]{2,32}$")
    },
    "r_mobile": {
        isValid: false,
        regex: new RegExp("^[1-9]{9}$")
    },
    "r_tel": {
        isValid: true,
        regex: new RegExp("^[1-9]{9}$")
    },
};

function activateLiveCheckRegister() {
    document.getElementById("registerBtn").classList.add("disabled");
    document.getElementById("registerBtn").disabled = true;
    document.getElementById("r_username").addEventListener("keyup", checkRegisterInput);
    document.getElementById("r_email").addEventListener("keyup", checkRegisterInput);
    document.getElementById("r_pwd").addEventListener("keyup", checkRegisterInput);
    document.getElementById("r_pwd2").addEventListener("keyup", checkRegisterInput);
    document.getElementById("r_name").addEventListener("keyup", checkRegisterInput);
    const inputContacts = document.querySelectorAll(".contact");
    inputContacts.forEach(node => node.addEventListener("keyup", checkRegisterInput));
}

function checkRegisterButton() {
    for (const input in registerInputValidations) {
        if (!registerInputValidations[input].isValid) {
            document.getElementById("registerBtn").classList.add("disabled");
            document.getElementById("registerBtn").disabled = true;
            return;
        }
    }
    document.getElementById("registerBtn").classList.remove("disabled");
    document.getElementById("registerBtn").disabled = false;
}

function checkRegisterInput(event) {
    const {id, value} = event.target;
    if (id === "r_tel" && value === "") {
        registerInputValidations[id].isValid = true;
        event.target.classList.remove("valid");
        event.target.classList.remove("invalid");
        checkRegisterButton();
        return;
    }
    if (id === "r_pwd2" || id === "r_pwd") {
        checkPasswords();
        checkRegisterButton();
        return;
    }
    if (registerInputValidations[id].regex.test(value)) {
        registerInputValidations[id].isValid = true;
        event.target.classList.add("valid");
        event.target.classList.remove("invalid");
    } else {
        registerInputValidations[id].isValid = false;
        event.target.classList.add("invalid");
        event.target.classList.remove("valid");
    }
    checkRegisterButton();
}

function checkPasswords() {
    const inputPwd = document.getElementById("r_pwd");
    const inputPwd2 = document.getElementById("r_pwd2");
    if (registerInputValidations["r_pwd"].regex.test(inputPwd.value)) {
        inputPwd.classList.add("valid");
        inputPwd.classList.remove("invalid");
        if (inputPwd.value === inputPwd2.value) {
            registerInputValidations["r_pwd"].isValid = true;
            inputPwd2.classList.add("valid");
            inputPwd2.classList.remove("invalid");
        } else {
            registerInputValidations["r_pwd"].isValid = false;
            inputPwd2.classList.add("invalid");
            inputPwd2.classList.remove("valid");
        }
    } else {
        registerInputValidations["r_pwd"].isValid = false;
        inputPwd.classList.add("invalid");
        inputPwd.classList.remove("valid");
    }
}

function badRegister(reason, code) {
    let warningArea = document.getElementById("badWarning");
    warningArea.style.visibility = "visible";
    warningArea.innerHTML = reason;
    var toRedInputs = undefined;
    switch(code) {
        case 1: toRedInputs = [document.getElementById("r_username")]; break;
        case 2: toRedInputs = [document.getElementById("r_email")]; break;
        case 3: toRedInputs = [document.getElementById("r_pwd"), document.getElementById("r_pwd2")]; break;
        case 5: toRedInputs = [document.getElementById("r_name")]; break;
        case 6: toRedInputs = [document.getElementsByName("r_mobile")]; break;
        case 7: toRedInputs = [document.getElementsByName("r_tel")]; break;
        default: return;
    }
    borderRed(toRedInputs);
}

function addValuesToRegister(user) {
    document.getElementById("r_name").value = user["name"];
    document.getElementById("r_username").value = user["username"];
    document.getElementById("r_email").value = user["email"];
    document.getElementsByName("r_mobile").value = user["mobile"];
    document.getElementsByName("r_tel").value = user["tel"] !== "null" ? user["tel"] : "";
}