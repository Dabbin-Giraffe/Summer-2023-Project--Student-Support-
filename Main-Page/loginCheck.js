function checker() {
    const email = $("#email").val();
    const password = $("#password").val();

    if (email === "" || !isEmail(email)) {
        alert(alerter("email"));
        return false;
    } else if (password === "") {
        alert("Cant leave password blank");
        return false;
    } else if (!isPasswordValid(password)) {
        alert(alerter("password"));
        return false;
    }

}
function alerter(name) {
    return `Invalid ${name} format please retry`;
}

function isEmail(email) {
    return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(
        email
    );
}
// Checks if min 8 chars, has one upper case,one lower case, one special and one number
function isPasswordValid(password) {
    var passwordPattern =
        /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
    return passwordPattern.test(password);
}
