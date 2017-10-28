function vldRegForm(form) {
    err_mess = "";
    err_mess += vldUsername(form.usr_username.value);
    err_mess += vldPass(form.usr_pass.value);
    if (err_mess == "") {
        return true;
    }
    else {
        alert(err_mess);
        return false;
    }
}

function vldUsername(username) {
    if (username == "") {
        return "Bạn chưa nhập username. \n";
    }
    else return "";
}

function vldPass(pass) {
    if (pass == "") {
        return "Bạn chưa nhập password. \n";
    }
    else return "";
}
