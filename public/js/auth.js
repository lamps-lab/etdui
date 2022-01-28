/**
 * If entered email is invalid, tell user.
 * @param {user email} email
 */
function validateEmail(email) {
    var syntax = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // Check if email
    if (syntax.test(email)) {
        return true;
    }
    return false;
}

/**
 * Validate the registration using AJAX.
 */
function registration() {
    var email = $('#email').val();
    var username = $('#username').val();
    var password = $('#password').val();
    var confirmPassword = $('#confirm_password').val();
    var responseKey = $('#g-recaptcha-response').val();

    // Make sure the fields are not empty.
    if (username === "") {
        $('#username-error').text('Username field is required.')
        $('#username-error').attr('hidden', false);
    } else {
        $('#username-error').attr('hidden', true);
    }

    if (password === "") {
        $('#password-error').text('Password field is required.');
        $('#password-error').attr('hidden', false);
    } else {
        $('#password-error').attr('hidden', true);
    }

    if (confirmPassword === "") {
        $('#confirm-password-error').text('Password confirmation field is required.');
        $('#confirm-password-error').attr('hidden', false);
    } else {
        $('#confirm-password-error').attr('hidden', true);
    }

    // Check if the email is in the correct format.
    if (!validateEmail(email)) {
        $('#email-error').text('Incorrect format.')
        $('#email-error').attr('hidden', false);

        if (email === "") {
            $('#email-error').text('Email field is required.');
            $('#email-error').attr('hidden', false);
        }

    } else {

        $('#email-error').attr('hidden', true);

        if (email && username && password && confirmPassword) {
            $.ajax({
                type: "POST",
                url: "../../src/auth/registration_action.php",
                data: {
                    submit: "submit",
                    email: email,
                    username: username,
                    password: password,
                    confirmPassword: confirmPassword,
                    gRecaptchaResponse: responseKey
                },
                success: function(data) {

                    console.log(data);

                    // If the PHP code sends back the code 0, the user did not type the same password in the
                    // confirm password field. Warn the user.
                    if (data.includes("0")) {
                        $('#confirm-password-error').text('Re-entered password must be the same as the original.');
                        $('#confirm-password-error').attr('hidden', false);
                        grecaptcha.reset();
                    } else {
                        $('#confirm-password-error').attr('hidden', true);
                    }

                    // If the PHP code sends back the code 1, the user entered an email that has already been registered.
                    // Warn the user.
                    if (data.includes("1")) {
                        $('#email-error').text('Email is already registered.');
                        $('#email-error').attr('hidden', false);
                        grecaptcha.reset();
                    } else {
                        $('#email-error').attr('hidden', true);
                    }

                    // If the PHP code sends back the code 2, the username is already taken. Warn the user.
                    if (data.includes("2")) {
                        $('#username-error').text('Username is already taken');
                        $('#username-error').attr('hidden', false);
                        grecaptcha.reset();
                    } else {
                        $('#password-error').attr('hidden', true);
                    }

                    // If the PHP code sends back the code 3, the RECAPTCHA process wasn't a success, warn the user.
                    if (data.includes("3")) {
                        $('#recaptcha-error').attr('hidden', false);
                    } else {
                        $('#recaptcha-error').attr('hidden', true);
                    }

                    // If the code returned is 4, the registration was a success and the user is redirected to the
                    // home page.
                    if (data == 4) {
                        window.location = '../../public/views/home.php';
                    }
                }
            });
        }
    }

}

/**
 * Validate the login procedure with the use of AJAX.
 */
function logIn() {
    var email = $('#email').val();
    var password = $('#password').val();
    var responseKey = $('#g-recaptcha-response').val();

    // Check if the fields are empty.
    if (email === "") {
        $('#email-error').text('Email field is required.');
        $('#email-error').attr('hidden', false);
    } else {
        $('#email-error').attr('hidden', true);
    }

    if (password === "") {
        $('#password-error').text('Password field is required.');
        $('#password-error').attr('hidden', false);
    } else {
        $('#password-error').attr('hidden', true);
    }

    if (email && password) {

        $.ajax({
            type: "POST",
            url: "../../src/auth/login_action.php",
            data: {
                submit: "submit",
                email: email,
                password: password,
                gRecaptchaResponse: responseKey
            },
            success: function(data) {

                console.log(data);

                // If the code returned is 0, the email entered has not been
                // registered.
                if (data == 0) {
                    $('#email-error').text('Email is not registered.');
                    $('#email-error').attr('hidden', false);
                    grecaptcha.reset();
                } else {
                    $('#email-error').attr('hidden', true);
                }

                // If the code returned is 1, the login was successful and the
                // user is redirected to the home page.
                if (data == 1) {
                    window.location = "../../public/views/home.php";
                }

                // If the code returned is 2, the password enetered is incorrect.
                if (data == 2) {
                    $('#email-error').attr('hidden', true);
                    $('#password-error').text('Email or password is incorrect');
                    $('#password-error').attr('hidden', false);
                    grecaptcha.reset();
                } else {
                    $('#password-error').attr('hidden', true);
                }

                // If the code returned is 3, the RECAPTCHA was a fail.
                if (data == 3) {
                    $('#recaptcha-error').attr('hidden', false);
                }
            }
        });
    }
}