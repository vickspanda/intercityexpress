document.getElementById("signUpForm").addEventListener("submit", function(event) {
    let isValid = true;

    // Validate Password
    const password = document.getElementById("pass_password");
    const passwordError = document.getElementById("passwordError");
    const confirmPassword = document.getElementById("confirm_password");
    const confirmPasswordError = document.getElementById("confirmPasswordError");
    if (password.value === "") {
        password.classList.add("invalid");
        passwordError.style.display = "inline";
        isValid = false;
    } else {
        password.classList.remove("invalid");
        passwordError.style.display = "none";
    }
    if (password.value !== confirmPassword.value) {
        confirmPassword.classList.add("invalid");
        confirmPasswordError.style.display = "inline";
        isValid = false;
    } else {
        confirmPassword.classList.remove("invalid");
        confirmPasswordError.style.display = "none";
    }
    // Prevent form submission if validation fails
    if (!isValid) {
        event.preventDefault();
    }
});

document.getElementById("pass_password").addEventListener("input", function() {
    const password = document.getElementById("pass_password");
    const passwordError = document.getElementById("passwordError");
    if (password.value.length < 8) {
        password.classList.add("invalid");
        passwordError.style.display = "inline";
    } else {
        password.classList.remove("invalid");
        passwordError.style.display = "none";
    }
});

document.getElementById("confirm_password").addEventListener("input", function() {
    const password = document.getElementById("pass_password");
    const confirmPassword = document.getElementById("confirm_password");
    const confirmPasswordError = document.getElementById("confirmPasswordError");
    if (password.value !== confirmPassword.value) {
        confirmPassword.classList.add("invalid");
        confirmPasswordError.style.display = "inline";
    } else {
        confirmPassword.classList.remove("invalid");
        confirmPasswordError.style.display = "none";
    }
});
