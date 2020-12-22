/* BOTH */
function borderRed(array_input) {
    for (input of array_input) {
        input.style.border = "2px solid red";
    }
}





/* LOGIN */
function badLogin(reason) {
    let user_input = document.getElementById("l_user");
    let pwd_input = document.getElementById("l_pwd");
    let warningArea = document.getElementById("badWarning");
    warningArea.style.visibility = "visible";
    warningArea.innerHTML = reason;
    borderRed([user_input, pwd_input]);
}





/* REGISTER */
function activateLiveCheckRegister() {
    document.getElementById("r_username").addEventListener("keyup", this.checkUsername);
    document.getElementById("r_email").addEventListener("keyup", this.checkEmail);
    document.getElementById("r_pwd").addEventListener("keyup", this.checkPasswords);
    document.getElementById("r_pwd2").addEventListener("keyup", this.checkPasswords);
    document.getElementById("r_name").addEventListener("keyup", this.checkName);
    document.getElementById("r_mobile").addEventListener("keyup", function() { checkContact("mobile") });
    document.getElementById("r_tel").addEventListener("keyup", function() { checkContact("tel") });
}

function checkUsername() {
    const regex = new RegExp("^[a-zA-Z1-9_]{4,16}$");
    let input_username = document.getElementById("r_username");
    let username = input_username.value;
    if (regex.test(username)){
        input_username.classList.add("valid");
        input_username.classList.remove("invalid");
    } else {
        input_username.classList.add("invalid");
        input_username.classList.remove("valid");
    };
}

function checkEmail() {
    const regex = new RegExp("^[a-zA-Z1-9_.-]{1,64}@{1}[a-z-]{1,32}.{1}[a-z]{2,6}$");
    let input_email = document.getElementById("r_email");
    let email = input_email.value;
    if (regex.test(email)){
        input_email.classList.add("valid");
        input_email.classList.remove("invalid");
    } else {
        input_email.classList.add("invalid");
        input_email.classList.remove("valid");
    };
}

function checkPasswords() {
    const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d+!?#$%&_\-.,;]{6,64}$/;
    let input_pwd = document.getElementById("r_pwd");
    let input_pwd2 = document.getElementById("r_pwd2");
    let pwd = input_pwd.value;
    let pwd2 = input_pwd2.getElementById("r_pwd2").value;
    if (regex.test(pwd)) {
        input_pwd.classList.add("valid");
        input_pwd.classList.remove("invalid");
        if (pwd !== pwd2) {
            input_pwd2.classList.add("invalid");
            input_pwd2.classList.remove("valid");
        } else {
            input_pwd.classList.add("valid");
            input_pwd2.classList.add("valid");
            input_pwd.classList.remove("invalid");
            input_pwd2.classList.remove("invalid");
        }
    } else {
        input_pwd.classList.add("invalid");
        input_pwd.classList.remove("valid");
    }
}

function checkName() {
    const regex = new RegExp("^[a-zA-Z]{2,32} {1}[a-zA-Z]{2,32}$");
    let input_name = document.getElementById("r_name");
    let name = input_name.value;
    if (regex.test(name)){
        input_name.classList.add("valid");
        input_name.classList.remove("invalid");
    } else {
        input_name.classList.add("invalid");
        input_name.classList.remove("valid");
    };
}

function checkContact(type) {
    const regex = new RegExp("^[1-9]{9}$");
    let input_contact = document.getElementById("r_"+type);
    let contact = input_contact.value;
    if (type === "tel" && contact === "") {
        input_contact.classList.remove("valid");
        input_contact.classList.remove("invalid");
        return;
    }
    if (regex.test(contact)){
        input_contact.classList.add("valid");
        input_contact.classList.remove("invalid");
    } else {
        input_contact.classList.add("invalid");
        input_contact.classList.remove("valid");
    };
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
        case 6: toRedInputs = [document.getElementById("r_mobile")]; break;
        case 7: toRedInputs = [document.getElementById("r_tel")]; break;
        default: console.log("ERROR CODE");
    }
    borderRed(toRedInputs);
}

function setDataNascLimits() {
    let today = new Date();
    let day = today.getDate();
    let month = today.getMonth()+1;
    let year = today.getFullYear();
    if (day < 10) {
        day = "0" + day;
    }
    if (month < 10) {
        month = "0" + month;
    }
    let min = year - 100 + "-" + month + "-" + day;
    let max = year - 18 + "-" + month + "-" + day;
    document.getElementById("r_date").setAttribute("max", max);
    document.getElementById("r_date").setAttribute("min", min);
}

function addValuesToRegister(user) {
    document.getElementById("r_name").value = user["name"];
    document.getElementById("r_username").value = user["username"];
    document.getElementById("r_email").value = user["email"];
    document.getElementById("r_mobile").value = user["mobile"];
    document.getElementById("r_tel").value = user["tel"] !== "null" ? user["tel"] : "";
}