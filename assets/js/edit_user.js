function borderRed(array_input) {
    for (const input of array_input) {
        input.style.border = "2px solid red";
    }
}

function showInfoEditUser (user) {
    document.getElementById("eu_id").value = user["id"];
    document.getElementById("eu_username").value = user["username"];
    document.getElementById("eu_email").value = user["email"];
    document.getElementById("eu_name").value = user["nome"];
    document.getElementById("eu_mobile").value = user["telemovel"];
    document.getElementById("eu_tel").value = user["telefone"] == null ? "" : user["telefone"];
    if (user["tipoId"] == 0) {
        document.getElementById("eu_pwd").required = true;
        document.getElementById("eu_pwd2").required = true;
    }
}

/* REGISTER */
const editInputValidations = {
    "eu_username": {
        isValid: true,
        regex: new RegExp("^(?=.+[a-zA-Z])[a-zA-Z1-9_]{4,16}$")
    },
    "eu_email": {
        isValid: true,
        regex: new RegExp("^[a-zA-Z1-9_.-]{1,64}@{1}[a-z-]{1,32}.{1}[a-z]{2,6}$")
    },
    "eu_pwd": {
        isValid: true,
        regex: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d+!?#$%&_\-.,;]{4,64}$/
    },
    "eu_name": {
        isValid: true,
        regex: new RegExp("^[a-zA-Z]{2,32} {1}[a-zA-Z]{2,32}$")
    },
    "eu_mobile": {
        isValid: true,
        regex: new RegExp("^[1-9]{9}$")
    },
    "eu_tel": {
        isValid: true,
        regex: new RegExp("^[1-9]{9}$")
    },
};

function activateLiveCheckEditUser() {
    const inputs = document.querySelectorAll(".type-input");
    inputs.forEach(node => node.addEventListener("keyup", checkEditUserInput));
}

function checkEditUserButton() {
    for (const input in editInputValidations) {
        if (!editInputValidations[input].isValid) {
            document.getElementById("editBtn").classList.add("disabled");
            document.getElementById("editBtn").disabled = true;
            return;
        }
    }
    document.getElementById("editBtn").classList.remove("disabled");
    document.getElementById("editBtn").disabled = false;
}

function checkEditUserInput(event) {
    const {id, value} = event.target;
    if (id === "eu_tel" && value === "") {
        editInputValidations[id].isValid = true;
        event.target.classList.remove("valid");
        event.target.classList.remove("invalid");
        checkEditUserButton();
        return;
    }
    if (id === "eu_pwd2" || id === "eu_pwd") {
        checkPasswords();
        checkEditUserButton();
        return;
    }
    if (editInputValidations[id].regex.test(value)) {
        editInputValidations[id].isValid = true;
        event.target.classList.add("valid");
        event.target.classList.remove("invalid");
    } else {
        editInputValidations[id].isValid = false;
        event.target.classList.add("invalid");
        event.target.classList.remove("valid");
    }
    checkEditUserButton();
}

function checkPasswords() {
    const inputPwd = document.getElementById("eu_pwd");
    const inputPwd2 = document.getElementById("eu_pwd2");

    if (inputPwd.value.length === 0 && inputPwd2.value.length === 0) {
        editInputValidations["eu_pwd"].isValid = true;
        inputPwd.classList.remove("invalid");
        inputPwd2.classList.remove("invalid");
        checkEditUserButton();
        return;
    }

    if (editInputValidations["eu_pwd"].regex.test(inputPwd.value)) {
        inputPwd.classList.add("valid");
        inputPwd.classList.remove("invalid");
        if (inputPwd.value === inputPwd2.value) {
            editInputValidations["eu_pwd"].isValid = true;
            inputPwd2.classList.add("valid");
            inputPwd2.classList.remove("invalid");
        } else {
            editInputValidations["eu_pwd"].isValid = false;
            inputPwd2.classList.add("invalid");
            inputPwd2.classList.remove("valid");
        }
    } else {
        editInputValidations["eu_pwd"].isValid = false;
        inputPwd.classList.add("invalid");
        inputPwd.classList.remove("valid");
        inputPwd2.classList.add("invalid");
        inputPwd2.classList.remove("valid");
    }
}

function badEdit(code, reason) {
    const warningArea = document.getElementById("badWarning");
    warningArea.style.visibility = "visible";
    warningArea.innerHTML = reason;
    let toRedInputs = undefined;
    switch(code) {
        case 1: toRedInputs = [document.getElementById("eu_username")]; break;
        case 2: toRedInputs = [document.getElementById("eu_email")]; break;
        case 3: toRedInputs = [document.getElementById("eu_pwd"), document.getElementById("eu_pwd2")]; break;
        case 5: toRedInputs = [document.getElementById("eu_name")]; break;
        case 6: toRedInputs = [document.getElementById("eu_mobile")]; break;
        case 7: toRedInputs = [document.getElementById("eu_tel")]; break;
        case 8: toRedInputs = [document.getElementById("eu_userType")]; break;
        case 9: toRedInputs = [document.getElementById("eu_linha")]; break;
        default: return;
    }
    borderRed(toRedInputs);
}