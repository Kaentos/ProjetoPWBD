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
function badRegister(reason, code) {
    let warningArea = document.getElementById("badWarning");
    warningArea.style.display = "block";
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