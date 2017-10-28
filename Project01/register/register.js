function vldRegForm(form) {
    err_mess = "";
    err_mess += vldFullname(form.usr_fullname.value);
    err_mess += vldGender(form.usr_gender.value);
    err_mess += vldUsername(form.usr_username.value);
    err_mess += vldEmail(form.usr_email.value);
    err_mess += vldPass(form.usr_pass.value);
    err_mess += vldCPass(form.usr_cpass.value);
    if (err_mess == "") {
        return true;
    }
    else {
        alert(err_mess);
        return false;
    }
}

function vldFullname(fullname) {
    if (fullname == "") {
        return "Bạn chưa nhập họ tên. \n";
    }
    if (/[^a-zA-Z0-9-_aàáảãạăằắẳẵặâầấẩẫậđeèéẻẽẹêềếểễệiìíỉĩịoòóỏõọôồốổỗộơờớởỡợuùúủũụưừứửữựyỳýỷỹỵAÀÁẢÃẠĂẰẮẲẴẶÂẦẤẨẪẬEÈÉẺẼẸÊỀẾỂỄỆIÌÍỈĨỊOÒÓỎÕỌÔỒỐỔỖỘƠỜỚỞỠỢUÙÚỦŨỤƯỪỨỬỮỰYỲÝỶỸỴ ]/.test(fullname)
        || !/[^ ]/.test(fullname)) {
        return "Họ và tên không hợp lệ. \n";
    }
    else return "";
}

function vldGender(gender) {
    if (gender != "M" && gender != "F" && gender != "O") {
        return "Bạn chưa chọn giới tính. \n";
    }
    else return "";
}

function vldUsername(username) {
    if (username == "") {
        return "Bạn chưa nhập username. \n";
    }
    else if (/[^a-zA-Z0-9-_]/.test(username)) {
        return "Username chỉ được chứa chữ cái, số, dấu _ và dấu -; \n";
    }
    else return "";
}

function vldEmail(email) {
    if (email == "") {
        return "Bạn chưa nhập email. \n";
    }
    else if (!/[@.]/.test(email)) {
        return "Email không hợp lệ. \n";
    }
    else return "";
}

function vldPass(pass) {
    if (pass == "") {
        return "Bạn chưa nhập password. \n";
    }
    else if (pass.length < 6) {
        return "Password phải có ít nhất 6 ký tự. \n";
    }
    else return "";
}

function vldCPass(cpass) {
    if (cpass == "") {
        return "Bạn chưa xác nhận password. \n";
    }
    else if (cpass != pass) {
        return "Password xác nhận không trùng khớp. \n";
    }
    else return "";
}