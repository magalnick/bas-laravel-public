<!-- begin first/last/email form -->
<div
    class="modal fade"
    id="authentication-form"
    data-backdrop="static"
    tabindex="-1"
    aria-labelledby="authentication-form-label"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="authentication-form-label">Please tell us who you are to get started</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row" id="authentication-form-errors">
                    <div class="col-sm">
                        <div class="infobox important" id="authentication-form-errors-error-list"></div>
                    </div>
                </div>
                <form id="authentication-form-tag" novalidate>
                    <div class="row">
                        <div class="col-sm">
                            <label class="sr-only" for="authentication-form-first-name">First name</label>
                            <input type="text" class="form-control mb-2 mr-sm-2" id="authentication-form-first-name" placeholder="First name" required />
                            <div class="invalid-feedback">Please enter your first name</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            <label class="sr-only" for="authentication-form-last-name">Last name</label>
                            <input type="text" class="form-control mb-2 mr-sm-2" id="authentication-form-last-name" placeholder="Last name" required />
                            <div class="invalid-feedback">Please enter your last name</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            <label class="sr-only" for="authentication-form-email">Email</label>
                            <input type="email" class="form-control mb-2 mr-sm-2" id="authentication-form-email" placeholder="Email" required />
                            <div class="invalid-feedback">Please enter a valid email address</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm" id="grecaptcha"></div>
                        <input type="hidden" class="form-control" id="authentication-form-grecaptcha-response" value="" />
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="authentication-form-submit" type="button" class="btn btn-outline-cta" style="width: 100px;" disabled>Next <i class="fa fa-angle-right" aria-hidden="true"></i></button>
                <button id="authentication-form-submit-waiting" type="button" class="btn btn-outline-cta" style="width: 100px; display: none;" disabled><i class="fa fa-circle-o-notch fa-spin" aria-hidden="true"></i></button>
            </div>
        </div>
    </div>
</div>
<!-- end first/last/email form -->

<!-- begin login token form -->
<div
    class="modal fade"
    id="login-token-form"
    data-backdrop="static"
    tabindex="-1"
    aria-labelledby="login-token-form-label"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="login-token-form-label">Please check your email</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row" id="login-token-form-errors">
                    <div class="col-sm">
                        <div class="infobox important" id="login-token-form-errors-error-list"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <p>
                            We sent an email with a one-time use login token to:
                            <br />
                            <span id="login-token-form-email-text"></span>
                        </p>
                    </div>
                </div>
                <form id="login-token-form-tag" novalidate>
                    <div class="row">
                        <div class="col-sm">
                            <label class="sr-only" for="login-token-form-token">Login token</label>
                            <input type="number" min="{!! json_encode(config('bas.auth.login_token_range.min')) !!}" max="{!! json_encode(config('bas.auth.login_token_range.max')) !!}" class="form-control mb-2 mr-sm-2" id="login-token-form-token" placeholder="Login token" required />
                            <div class="invalid-feedback">Please enter the {!! json_encode(config('bas.auth.login_token_range.size')) !!} digit number from the email we sent</div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="login-token-form-submit" type="button" class="btn btn-outline-cta" style="width: 100px;">Log in <i class="fa fa-angle-right" aria-hidden="true"></i></button>
                <button id="login-token-form-submit-waiting" type="button" class="btn btn-outline-cta" style="width: 100px; display: none;" disabled><i class="fa fa-circle-o-notch fa-spin" aria-hidden="true"></i></button>
            </div>
        </div>
    </div>
</div>
<!-- end login token form -->
