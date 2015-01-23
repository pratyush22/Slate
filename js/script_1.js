function verifyNameLength(name) {
    alert(typeof name);
    return false;
}

function verifyUserInput() {
    var fullName = document.getElementById("name").value;
    var password = document.getElementById("password").value;
    alert(fullName);
    alert(password);
    return verifyNameLength(fullName);
}