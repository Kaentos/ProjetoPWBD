function borderRed(array_input) {
    for (const input of array_input) {
        input.style.border = "2px solid red";
    }
}

function showInfoMyDataUser (user) {
    document.getElementById("md_username").value = user["username"];
    document.getElementById("md_email").value = user["email"];
    document.getElementById("md_name").value = user["nome"];
    document.getElementById("md_mobile").value = user["telemovel"];
    document.getElementById("md_tel").value = user["telefone"] == null ? "" : user["telefone"];
    checkMyDataEditButton();
}

/* REGISTER */
const editInputValidations = {
    "md_username": {
        isValid: true,
        regex: new RegExp("^(?=.+[a-zA-Z])[a-zA-Z1-9_]{4,16}$")
    },
    "md_email": {
        isValid: true,
        regex: new RegExp("^[a-zA-Z1-9_.-]{1,64}@{1}[a-z-]{1,32}.{1}[a-z]{2,6}$")
    },
    "md_pwd": {
        isValid: true,
        regex: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d+!?#$%&_\-.,;]{4,64}$/
    },
    "md_cPwd": {
        isValid: false,
        regex: /^[a-zA-Z\d+!?#$%&_\-.,;]{4,64}$/
    },
    "md_name": {
        isValid: true,
        regex: new RegExp("^[a-zA-Z]{2,32} {1}[a-zA-Z]{2,32}$")
    },
    "md_mobile": {
        isValid: true,
        regex: new RegExp("^[1-9]{9}$")
    },
    "md_tel": {
        isValid: true,
        regex: new RegExp("^[1-9]{9}$")
    },
};

const deleteInputValidations = {
    "md_delete_pwd": {
        isValid: false,
        regex: /^[a-zA-Z\d+!?#$%&_\-.,;]{4,64}$/
    }, 
    "md_delete_confirm": {
        isValid: false
    }
}

function activateLiveCheckMyData() {
    const inputs = document.querySelectorAll(".type-input");
    inputs.forEach(node => node.addEventListener("keyup", checkMyDataInput));
    document.getElementById("md_delete_pwd").addEventListener("keyup", checkDeletePassword);
    document.getElementById("md_delete_confirm").addEventListener("change", checkDeleteCheckBox);
    checkMyDataDeleteButton();
}

function checkMyDataEditButton() {
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

function checkMyDataDeleteButton() {
    for (const input in deleteInputValidations) {
        if (!deleteInputValidations[input].isValid) {
            document.getElementById("deleteBtn").classList.add("disabled");
            document.getElementById("deleteBtn").disabled = true;
            return;
        }
    }
    document.getElementById("deleteBtn").classList.remove("disabled");
    document.getElementById("deleteBtn").disabled = false;
}

function checkMyDataInput(event) {
    const {id, value} = event.target;
    if (id === "md_tel" && value === "") {
        editInputValidations[id].isValid = true;
        event.target.classList.remove("valid");
        event.target.classList.remove("invalid");
        checkMyDataEditButton();
        return;
    }
    if (id === "md_pwd2" || id === "md_pwd") {
        checkPasswords();
        checkMyDataEditButton();
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
    checkMyDataEditButton();
}

function checkPasswords() {
    const inputPwd = document.getElementById("md_pwd");
    const inputPwd2 = document.getElementById("md_pwd2");

    if (inputPwd.value.length === 0 && inputPwd2.value.length === 0) {
        editInputValidations["md_pwd"].isValid = true;
        inputPwd.classList.remove("invalid");
        inputPwd2.classList.remove("invalid");
        checkMyDataEditButton();
        return;
    }

    if (editInputValidations["md_pwd"].regex.test(inputPwd.value)) {
        inputPwd.classList.add("valid");
        inputPwd.classList.remove("invalid");
        if (inputPwd.value === inputPwd2.value) {
            editInputValidations["md_pwd"].isValid = true;
            inputPwd2.classList.add("valid");
            inputPwd2.classList.remove("invalid");
        } else {
            editInputValidations["md_pwd"].isValid = false;
            inputPwd2.classList.add("invalid");
            inputPwd2.classList.remove("valid");
        }
    } else {
        editInputValidations["md_pwd"].isValid = false;
        inputPwd.classList.add("invalid");
        inputPwd.classList.remove("valid");
        inputPwd2.classList.add("invalid");
        inputPwd2.classList.remove("valid");
    }
}

function checkDeletePassword(event) {
    const { target } = event;
    if (deleteInputValidations[target.id].regex.test(target.value)) {
        deleteInputValidations[target.id].isValid = true;
        target.classList.add("valid");
        target.classList.remove("invalid");
    } else {
        deleteInputValidations[target.id].isValid = false;
        target.classList.add("invalid");
        target.classList.remove("valid");
    }
    checkMyDataDeleteButton();
}

function checkDeleteCheckBox(event) {
    const { target } = event;
    deleteInputValidations[target.id].isValid = target.checked;
    checkMyDataDeleteButton();
}

function badMyData(code, reason) {
    const warningArea = document.getElementById("badWarning");
    warningArea.style.visibility = "visible";
    warningArea.innerHTML = reason;
    let toRedInputs = undefined;
    switch(code) {
        case 1: toRedInputs = [document.getElementById("md_username")]; break;
        case 2: toRedInputs = [document.getElementById("md_email")]; break;
        case 3: toRedInputs = [document.getElementById("md_pwd"), document.getElementById("md_pwd2")]; break;
        case 5: toRedInputs = [document.getElementById("md_name")]; break;
        case 6: toRedInputs = [document.getElementById("md_mobile")]; break;
        case 7: toRedInputs = [document.getElementById("md_tel")]; break;
        case 8: toRedInputs = [document.getElementById("md_cPwd")]; break;
        case 9: toRedInputs = [document.getElementById("md_delete_pwd")]; break;
        default: return;
    }
    borderRed(toRedInputs);
}

function showMessage (data) {
    const message = document.getElementById("badWarning");
    const {isError, msg} = data;
    message.classList.add(isError ? "message-error" : "message-success");
    message.innerHTML = msg;
    message.style.visibility = "visible";
}