<script>
    const localStorageFieldUsername = {!! json_encode(config('bas.auth.local_storage.username')) !!};
    const localStorageFieldPassword = {!! json_encode(config('bas.auth.local_storage.password')) !!};
    const localStorageFieldUserHash = {!! json_encode(config('bas.auth.local_storage.user_hash')) !!};
    const localStorageFieldEmail    = {!! json_encode(config('bas.auth.local_storage.email')) !!};
    const apiAuthenticatePrefix     = apiUrlPrefix + "authenticate";

    var callInitOnSuccessfulAuthentication = true;

    const authenticateInit = function() {
        $('#authentication-form').on('show.bs.modal', function (e) {
            grecaptcha.reset();
            $("#authentication-form-grecaptcha-response").val('');
            $("#authentication-form-tag").removeClass('was-validated');
            $("#authentication-form-errors").hide();
            $("#authentication-form-errors-error-list").html('');
            setTimeout(function() {
                DomElement.any('authentication-form-first-name').focus();
            }, 500);
            checkIfAuthenticationFormCanSubmit();
        });

        $('#login-token-form').on('show.bs.modal', function (e) {
            $("#login-token-form-token").val('');
            $("#login-token-form-tag").removeClass('was-validated');
            $("#login-token-form-errors").hide();
            $("#login-token-form-errors-error-list").html('');
            $("#login-token-form-email-text").html(localStorage.getItem(localStorageFieldEmail));
            setTimeout(function() {
                DomElement.any('login-token-form-token').focus();
            }, 500);
        });

        $("#authentication-form-tag")
            .off("submit")
            .on("submit", function(e) {
                return false;
            });

        $("#login-token-form-tag")
            .off("submit")
            .on("submit", function(e) {
                $("#login-token-form-submit").trigger('click');
                return false;
            });

        $("#login-token-form-submit")
            .off("click")
            .on("click", function(e) {
                let form  = $("#login-token-form-tag");
                let token = $("#login-token-form-token");
                form.addClass('was-validated');
                if (form[0].checkValidity() === false) {
                    token.focus();
                    return;
                }

                let successCallback = function(request, response, status) {
                    localStorage.clear();
                    localStorage.setItem(localStorageFieldUsername, response['data'][localStorageFieldUsername]);
                    localStorage.setItem(localStorageFieldPassword, response['data'][localStorageFieldPassword]);
                    $("#login-token-form-token").val('');
                    $("#login-token-form").modal('hide');
                    $("#login-token-form-submit-waiting").hide();
                    $("#login-token-form-submit").show();
                    authenticate();
                };

                let errorCallback = function(request, textStatus, errorThrown) {
                    let errors = request.xhr.responseJSON.errors;
                    $("#login-token-form-errors").show(300);
                    $("#login-token-form-errors-error-list").html(errors.join('<br />'));
                    $("#login-token-form-submit-waiting").hide();
                    $("#login-token-form-submit").show();
                };

                $(e.target).hide();
                $("#login-token-form-submit-waiting").show();

                let username = $.trim(localStorage.getItem(localStorageFieldUserHash));
                let password = $.trim(token.val());
                Router.ajax('POST', apiAuthenticatePrefix + '/login', {}, successCallback, errorCallback, {}, false, {"username": username, "password": password});
            });

        $("#authentication-form-submit")
            .off("click")
            .on("click", function(e) {
                let form = $("#authentication-form-tag");
                form.addClass('was-validated');
                if (!checkIfAuthenticationFormCanSubmit()) {
                    return;
                }
                if (form[0].checkValidity() === false) {
                    return;
                }

                let successCallback = function(request, response, status) {
                    localStorage.setItem(localStorageFieldUserHash, response['data'][localStorageFieldUserHash]);
                    localStorage.setItem(localStorageFieldEmail, response['data'][localStorageFieldEmail]);
                    $("#authentication-form-grecaptcha-response").val('');
                    checkIfAuthenticationFormCanSubmit();
                    grecaptcha.reset();
                    hideAuthenticationFormShowLoginTokenForm();
                    $("#authentication-form-submit-waiting").hide();
                    $("#authentication-form-submit").show();
                };

                let errorCallback = function(request, textStatus, errorThrown) {
                    let errors = request.xhr.responseJSON.errors;
                    $("#authentication-form-errors").show(300);
                    $("#authentication-form-errors-error-list").html(errors.join('<br />'));
                    $("#authentication-form-grecaptcha-response").val('');
                    checkIfAuthenticationFormCanSubmit();
                    grecaptcha.reset();
                    $("#authentication-form-submit-waiting").hide();
                    $("#authentication-form-submit").show();
                };

                $(e.target).hide();
                $("#authentication-form-submit-waiting").show();

                let firstName          = $.trim($("#authentication-form-first-name").val());
                let lastName           = $.trim($("#authentication-form-last-name").val());
                let email              = $.trim($("#authentication-form-email").val());
                let grecaptchaResponse = $.trim($("#authentication-form-grecaptcha-response").val());

                let data = {
                    "first_name": firstName,
                    "last_name": lastName,
                    "email": email,
                    "grecaptcha_response": grecaptchaResponse,
                };
                Router.ajax('POST', apiAuthenticatePrefix + '/get-started', data, successCallback, errorCallback);
            });

        $("#authentication-form-first-name, #authentication-form-last-name, #authentication-form-email")
            .off("change")
            .on("change", function(e) {
                checkIfAuthenticationFormCanSubmit();
            });

        waitForRecaptchaThenCallAuthenticate();
    };

    const hideAuthenticationFormShowLoginTokenForm = function() {
        $('#authentication-form').modal('hide');
        $('#login-token-form').modal('show');
    };

    // This function is for the page load. We want to immediately check the authenticate,
    // which will immediately pop open the first/last/email form,
    // which will immediately want to put the reCaptcha widget in.
    // However, if the reCaptcha hasn't completed downloading yet, then there will be an error.
    // So this function is recursively calling itself with a short timeout until reCaptcha is available,
    // at which point it will call authenticate().
    const waitForRecaptchaThenCallAuthenticate = function() {
        setTimeout(function() {
            if (recaptchaIsReady) {
                grecaptcha.render(
                    'grecaptcha',
                    {
                        'sitekey': recaptchaSiteKey,
                        'callback': 'authRecaptchaCallbackSuccess',
                        'expired-callback': 'authRecaptchaCallbackExpired',
                        'error-callback': 'authRecaptchaCallbackError',
                    }
                );
                authenticate();
            } else {
                waitForRecaptchaThenCallAuthenticate();
            }
        }, 10);
    };

    const basicAuthCredentials = function() {
        return {
            "username": $.trim(localStorage.getItem(localStorageFieldUsername)),
            "password": $.trim(localStorage.getItem(localStorageFieldPassword)),
        };
    };

    const authenticate = function() {
        let basicAuthCreds = basicAuthCredentials();
        if (basicAuthCreds.username === '' || basicAuthCreds.password === '') {
            @if ($authentication_required)
            $('#authentication-form').modal('show');
            @endif
            return;
        }

        let successCallback = function(request, response, status) {
            localStorage.setItem(localStorageFieldUsername, response['data'][localStorageFieldUsername]);
            localStorage.setItem(localStorageFieldPassword, response['data'][localStorageFieldPassword]);
            let timeout = 1000 * 60 * 10; // 10 minutes
            //let timeout = 1000 * 30; // 30 seconds
            setTimeout(function() {
                authenticate();
            }, timeout);

            // there's an assumption that the page requiring authentication
            // may have an init function that would need to be called once upon successful authentication
            if (typeof init === 'function' && callInitOnSuccessfulAuthentication) {
                callInitOnSuccessfulAuthentication = false;
                init();
            }
        };

        let errorCallback = function(request, textStatus, errorThrown) {
            //console.log(request.xhr.responseJSON);
            localStorage.setItem(localStorageFieldUsername, '');
            localStorage.setItem(localStorageFieldPassword, '');
            @if ($authentication_required)
            $('#authentication-form').modal('show');
            @endif

            // there's an assumption that the page requiring authentication
            // may have an un-init function that would need to be called once upon failed authentication
            // in case there's an authentication failure mid-stream of the page in action
            if (typeof unInit === 'function') {
                callInitOnSuccessfulAuthentication = true;
                unInit();
            }
        };

        Router.ajax('GET', apiAuthenticatePrefix, {}, successCallback, errorCallback, {}, false, basicAuthCreds);
    };

    const checkIfAuthenticationFormCanSubmit = function() {
        let submitButton = $("#authentication-form-submit");

        let firstName = $.trim($("#authentication-form-first-name").val());
        let lastName = $.trim($("#authentication-form-last-name").val());
        let email = $.trim($("#authentication-form-email").val());
        let grecaptchaResponse = $.trim($("#authentication-form-grecaptcha-response").val());
        if (firstName === '' || lastName === '' || email === '' || grecaptchaResponse === '') {
            submitButton.prop("disabled", true);
            return false;
        }

        submitButton.prop("disabled", false);
        return true;
    };

    var authRecaptchaCallbackSuccess = function(response) {
        $("#authentication-form-grecaptcha-response").val(response);
        checkIfAuthenticationFormCanSubmit();
        // console.log(response);
    };

    var authRecaptchaCallbackExpired = function() {
        $("#authentication-form-grecaptcha-response").val('');
        checkIfAuthenticationFormCanSubmit();
    };

    var authRecaptchaCallbackError = function(response) {
        $("#authentication-form-grecaptcha-response").val('');
        checkIfAuthenticationFormCanSubmit();
        console.log(response);
    };

    $(document).ready(function() {
        authenticateInit();
    });
</script>
