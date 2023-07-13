function checker() {
    const email = $("#email").val();
    const password = $("#password").val();

    if (email === "" || !isEmail(email)) {
        alert(alerter("email"));
        return false;
    } else if (password == "") {
        alert("Cant leave password blank");
        return false;
    } else if (isPasswordValid(password)) {
        alert(alerter("password"));
        return false;
    }

}
function alerter(name) {
    return `Invalid ${name} format please retry`;
}

function isEmail(email) {
    return /^[\w.+-]+@mahindrauniversity\.edu\.in$/.test(email);
}
// Checks if min 8 chars, has one upper case,one lower case, one special and one number
function isPasswordValid(password) {
    return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/.test(password);
}
