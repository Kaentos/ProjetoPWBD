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