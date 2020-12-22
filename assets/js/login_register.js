/* BOTH */
function borderRed(array_input) {
    for (input of array_input) {
        input.style.border = "2px solid red";
    }
}





/* LOGIN */
var login_input_validations = {
    "user" : false,
    "pwd" : false,
};
function activateLiveCheckLogin() {
    document.getElementById("loginBtn").classList.add("disabled");
    document.getElementById("loginBtn").disabled = true;
    document.getElementById("l_user").addEventListener("keyup", this.checkUser);
    document.getElementById("l_pwd").addEventListener("keyup", this.checkPassword);
}

function checkLoginButton() {
    for (let input in login_input_validations) {
        if (!login_input_validations[input]) {
            document.getElementById("loginBtn").classList.add("disabled");
            document.getElementById("loginBtn").disabled = true;
            return;
        }
    }
    document.getElementById("loginBtn").classList.remove("disabled");
    document.getElementById("loginBtn").disabled = false;
}

function checkUser() {
    let input_user = document.getElementById("l_user");
    let user = input_user.value;
    if (user.length >= 4 && user.length <= 128) {
        login_input_validations["user"] = true;
        input_user.classList.add("valid");
        input_user.classList.remove("invalid");
    } else {
        login_input_validations["user"] = false;
        input_user.classList.add("invalid");
        input_user.classList.remove("valid");
    }
    checkLoginButton();
}

function checkPassword() {
    let input_pwd = document.getElementById("l_pwd");
    let pwd = input_pwd.value;
    if (pwd.length >= 4 && pwd.length <= 64) {
        login_input_validations["pwd"] = true;
        input_pwd.classList.add("valid");
        input_pwd.classList.remove("invalid");
    } else {
        login_input_validations["pwd"] = false;
        input_pwd.classList.add("invalid");
        input_pwd.classList.remove("valid");
    }
    checkLoginButton();
}


function badLogin(reason) {
    let user_input = document.getElementById("l_user");
    let pwd_input = document.getElementById("l_pwd");
    let warningArea = document.getElementById("badWarning");
    warningArea.style.visibility = "visible";
    warningArea.innerHTML = reason;
    borderRed([user_input, pwd_input]);
}





/* REGISTER */
var register_input_validations = {
    "username": false,
    "email": false,
    "pwd": false,
    "mobile": false,
    "tel": true
};

function activateLiveCheckRegister() {
    document.getElementById("registerBtn").classList.add("disabled");
    document.getElementById("registerBtn").disabled = true;
    document.getElementById("r_username").addEventListener("keyup", this.checkUsername);
    document.getElementById("r_email").addEventListener("keyup", this.checkEmail);
    document.getElementById("r_pwd").addEventListener("keyup", this.checkPasswords);
    document.getElementById("r_pwd2").addEventListener("keyup", this.checkPasswords);
    document.getElementById("r_name").addEventListener("keyup", this.checkName);
    const input_contacts = document.querySelectorAll("#r_contact");
    input_contacts.forEach(node => node.addEventListener("keyup", this.checkContact));
}

function checkRegisterButton() {
    for (let input in register_input_validations) {
        if (!register_input_validations[input]) {
            document.getElementById("registerBtn").classList.add("disabled");
            document.getElementById("registerBtn").disabled = true;
            return;
        }
    }
    document.getElementById("registerBtn").classList.remove("disabled");
    document.getElementById("registerBtn").disabled = false;
}

function checkUsername() {
    const regex = new RegExp("^[a-zA-Z1-9_]{4,16}$");
    let input_username = document.getElementById("r_username");
    let username = input_username.value;
    if (regex.test(username)){
        register_input_validations["username"] = true;
        input_username.classList.add("valid");
        input_username.classList.remove("invalid");
    } else {
        register_input_validations["username"] = false;
        input_username.classList.add("invalid");
        input_username.classList.remove("valid");
    };
    checkRegisterButton();
}

function checkEmail() {
    const regex = new RegExp("^[a-zA-Z1-9_.-]{1,64}@{1}[a-z-]{1,32}.{1}[a-z]{2,6}$");
    let input_email = document.getElementById("r_email");
    let email = input_email.value;
    if (regex.test(email)){
        register_input_validations["email"] = true;
        input_email.classList.add("valid");
        input_email.classList.remove("invalid");
    } else {
        register_input_validations["email"] = false;
        input_email.classList.add("invalid");
        input_email.classList.remove("valid");
    };
    checkRegisterButton();
}

function checkPasswords() {
    const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d+!?#$%&_\-.,;]{4,64}$/;
    let input_pwd = document.getElementById("r_pwd");
    let input_pwd2 = document.getElementById("r_pwd2");
    let pwd = input_pwd.value;
    let pwd2 = input_pwd2.value;
    if (regex.test(pwd)) {
        input_pwd.classList.add("valid");
        input_pwd.classList.remove("invalid");
        if (pwd !== pwd2) {
            register_input_validations["pwd"] = false;
            input_pwd2.classList.add("invalid");
            input_pwd2.classList.remove("valid");
        } else {
            register_input_validations["pwd"] = true;
            input_pwd.classList.add("valid");
            input_pwd2.classList.add("valid");
            input_pwd.classList.remove("invalid");
            input_pwd2.classList.remove("invalid");
        }
    } else {
        register_input_validations["pwd"] = false;
        input_pwd.classList.add("invalid");
        input_pwd.classList.remove("valid");
    }
    checkRegisterButton();
}

function checkName() {
    const regex = new RegExp("^[a-zA-Z]{2,32} {1}[a-zA-Z]{2,32}$");
    let input_name = document.getElementById("r_name");
    let name = input_name.value;
    if (regex.test(name)){
        register_input_validations["name"] = true;
        input_name.classList.add("valid");
        input_name.classList.remove("invalid");
    } else {
        register_input_validations["name"] = false;
        input_name.classList.add("invalid");
        input_name.classList.remove("valid");
    };
    checkRegisterButton();
}

function checkContact(event) {
    const regex = new RegExp("^[1-9]{9}$");
    let {value : contact, dataset} = event.target;
    if (dataset.type === "tel" && contact === "") {
        register_input_validations[dataset.type] = true;
        event.target.classList.remove("valid");
        event.target.classList.remove("invalid");
        checkRegisterButton();
        return;
    }
    if (regex.test(contact)){
        register_input_validations[dataset.type] = true;
        event.target.classList.add("valid");
        event.target.classList.remove("invalid");
    } else {
        register_input_validations[dataset.type] = false;
        event.target.classList.add("invalid");
        event.target.classList.remove("valid");
    };
    checkRegisterButton();
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