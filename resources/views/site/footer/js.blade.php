<!-- jQuery 3.5.1 & Bootstrap 4.6 bundle JS -->
{{--<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>--}}
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha384-ZvpUoO/+PpLXR1lu4jmpXWu80pZlYUAfxl5NsBMWOEPSjUn/6Z/hRTt8+pR6L4N2" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    const apiUrlPrefix = {!! json_encode(config('app.api_url_base')) !!};

    const setMainPageHeader = function(value) {
        if (typeof value !== 'string') {
            return;
        }
        value = $.trim(value);
        if (value === '') {
            return;
        }
        DomElement.h1().text(value);
    };

    const BAS = {};
    const Router = {
        history: [],
        modules: [],
        requests: [],
        verbs: [ 'GET', 'POST', 'PUT', 'PATCH', 'DELETE' ],

        /**
         * This is the primary function you will use for making AJAX requests. Example:
         *
         *     Router.ajax( 'GET', '/api-services/my-service', { a : "b", c : 2 }, function(data) { ... } );
         *
         * Note that if files are being uploaded, the hasFiles flag MUST be set to
         * true, and the inputData MUST be an instance of new FormData(). Any non-file
         * data being posted can also be part of the FormData object. For example,
         * if submitting a form with name, email & attachment,
         * the data can be submitted as:
         * var name = $("#name")val();
         * var email = $("#email")val();
         * var attachment = $("#attachment")[0].files[0];
         * var formdata = new FormData();
         * formdata.append( "name", name );
         * formdata.append( "email", email );
         * formdata.append( "attachment", attachment );
         *     Router.ajax( 'POST', '/api-services/my-service', formdata, function(data) { ... }, {}, true );
         *
         * Multiple files can be formdata appended in this way for a single request.
         *
         * @param {string} verb HTTP method to use (ie. 'GET', 'POST', 'PUT', 'DELETE')
         * @param {string} path URL path to the API service or web page
         * @param {object} inputData Arguments to pass to the endpoint
         * @param {object|function} successCallback Function to execute when the
         *     result comes back from the API, or an object with config params
         *     (see options argument, below.) If an object, it must contain a
         *     "done" property with the successCallback function.
         * @param {object|function} errorCallback Function to execute when an
         *     error comes back from the API, or an object with config params
         *     (see options argument, below.) If an object, it must contain a
         *     "fail" property with the errorCallback function.
         * @param {object} options Object with optional config params.
         * @param {object} hasFiles Optional boolean stating whether or not there are files present
         * @param {object} auth Object with optional username & password
         * @return {void}
         */
        ajax: function(verb, path, inputData, successCallback, errorCallback, options, hasFiles, auth) {
            var $ = jQuery;
            var that = this;

            if ( typeof verb !== "string" ) {
                throw Error("Undefined verb");
            }
            verb = ( $.trim(verb) ).toUpperCase();
            if ( $.inArray( verb, that.verbs ) < 0 ) {
                throw Error( "Verb must be one of: " + that.verbs.join(", ") );
            }

            if ( typeof path !== "string" ) {
                throw Error("Undefined path");
            }
            path = $.trim(path);
            if ( path === "" ) {
                throw Error("No path specified")
            }

            if ( typeof inputData !== "object" || inputData === null ) {
                throw Error("Input data empty or invalid");
            }

            if ( typeof hasFiles === "undefined" ) {
                hasFiles = false;
            }
            hasFiles = !!hasFiles;
            if ( hasFiles && ( verb === "GET" || verb === "DELETE" ) ) {
                throw Error("Uploading files must be POST, PUT or PATCH");
            }

            var settings = {
                baseUrl: '',
                debug: false,
            };

            if ( typeof options !== 'object' ) {
                options = {};
            }

            if ( typeof successCallback === 'object' ) {
                options = successCallback;
            }
            else if ( typeof successCallback === 'function' ) {
                options.done = successCallback;
            }
            if ( typeof errorCallback === 'function' ) {
                options.fail = errorCallback;
            }

            var dummy = new Date().getTime();
            var dummyKey = "d" + dummy.toString();
            if ( verb === "GET" ) {
                inputData[dummyKey] = dummy.toString();
            }
            else {
                var connector = path.indexOf("?") == -1 ? "?" : "&";
                path += connector + dummyKey + "=" + dummy.toString();
            }

            var config = {
                tags: [],
                beforeSend: function (request) {},
                done: function ( request, responseData, textStatus ) {},
                fail: function ( request, textStatus, errorThrown ) {},
                always: function ( request, textStatus ) {}
            };

            if ( typeof options === 'object' ) {
                $.extend( config, options );
            }

            var request = null;

            var ajaxData = {};
            if (hasFiles) {
                ajaxData = {
                    url: settings.baseUrl + path,
                    type: verb,
                    data: inputData,
                    cache: false,
                    dataType: "json",
                    processData : false,
                    contentType : false,
                };
            }
            else {
                ajaxData = {
                    url: settings.baseUrl + path,
                    type: verb,
                    data: inputData,
                    dataType: "json",
                };
            }

            if ( typeof auth === "object"
                && auth !== null
                && typeof auth.username === "string"
                && $.trim(auth.username) !== ""
                && typeof auth.password === "string"
                && $.trim(auth.password) !== ""
            )
            {
                ajaxData["headers"] = { "Authorization": "Basic " + btoa( auth.username + ":" + auth.password ) };
            }

            var extendMe = {
                beforeSend: function ( jqXHR, requestSettings ) {
                    if ( !settings.debug ) {
                        jqXHR.setRequestHeader( 'Prefer', 'representation=minimal' );
                    }

                    request = that.registerRequest( verb, path, inputData, config.tags, jqXHR, requestSettings );
                    config.beforeSend(request);
                },
                success: function ( responseData, textStatus, jqXHR ) {

                    // jQuery does not properly detect CORS errors.
                    // In those cases, it calls success() instead of
                    // error(). So we have to detect this case ourselves.
                    if (jqXHR.status) {
                        config.done( request, responseData, textStatus );
                    }
                    else {
                        this.error( jqXHR, 'error' );
                    }
                },
                error: function ( jqXHR, textStatus, errorThrown ) {
                    config.fail( request, textStatus, errorThrown );
                },
                complete: function ( jqXHR, textStatus ) {
                    that.purgeInactiveRequests();
                    config.always( request, textStatus );
                }
            };

            $.extend( ajaxData, extendMe );

            $.ajax(ajaxData);
        },

        registerRequest: function( verb, path, inputData, tags, jqXHR, requestSettings ) {
            var $ = jQuery;
            var that = this;

            if ( typeof tags === 'string' ) {
                tags = [tags];
            }
            else if ( typeof tags !== 'object' ) {
                tags = [];
            }

            var request = {
                verb: verb,
                path: path,
                inputData: inputData,
                tags: tags,
                xhr: jqXHR,
                settings: requestSettings
            };

            that.requests.push(request);

            return request;
        },

        /**
         * Cancel one or more requests.
         *
         * @param {string} tag Optional. If present, only the requests having this
         *     tag will be canceled. If not given, all requests will be canceled.
         **/
        cancelRequests: function(tag) {
            var $ = jQuery;
            var that = this;

            $.each( that.requests, function( index, request ) {
                if ( typeof tag === 'undefined' || ( typeof request !=+ 'undefined' && request.tags.indexOf(tag) !== -1 ) ) {
                    if ( request.xhr.readyState < 4 ) {
                        request.xhr.abort();
                    }
                }
            });
            that.purgeInactiveRequests();
        },

        purgeInactiveRequests: function() {
            var $ = jQuery;
            var that = this;

            $.each( that.requests, function( index, request ) {
                if ( typeof request !== 'undefined' && ( request.xhr.readyState === 4 || !request.xhr.readyState ) ) {
                    that.requests.splice( index, 1 );
                }
            });
        },
    };
    const verbs = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'];


    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
<script>
    class DomElement {
        static any(id) {
            return $("#" + id);
        }

        static title() {
            return $("title");
        }

        static h1() {
            return $("#main-page-h1");
        }

        static toasts() {
            return $("#main-toasts");
        }

        static toastWrapper(toastId) {
            return $("#main-toasts-wrapper-id-" + toastId);
        }

        static toast(toastId) {
            return $("#main-toasts-id-" + toastId);
        }
    }

    const _toasts = {};
    class Toast {
        static singleton(toastId) {
            if (typeof toastId !== 'string') {
                toastId = '';
            }
            toastId = $.trim(toastId);
            if (toastId === '') {
                toastId = 'main';
            }

            if (typeof _toasts[toastId] !== 'object') {
                _toasts[toastId] = new Toast(toastId);
            }

            return _toasts[toastId];
        }

        static list() {
            return _toasts;
        }

        constructor(toastId) {
            this.toastId = toastId;
            DomElement.toasts().append('<div id="main-toasts-wrapper-id-' + toastId + '"></div>');
            this.init();
        }

        init() {
            this.headerIcon      = '';
            this.headerText      = '';
            this.headerMini      = '';
            this.bodyText        = '';
            this.showOnBottom    = true;
            this.dataDelay       = 0;
            this.showCloseButton = false;
        }

        closeButton() {
            this.showCloseButton = true;
            return this;
        }

        // setting to 0 will prevent auto hide
        autoHideIn(milliseconds) {
            this.dataDelay = milliseconds;
            return this;
        }

        top() {
            this.showOnBottom = false;
            return this;
        }

        bottom() {
            this.showOnBottom = true;
            return this;
        }

        // this should be a font awesome icon without the "fa-" on it, such as "paw" to render the "fa-paw" icon
        icon(value) {
            this.headerIcon = $.trim(value);
            return this;
        }

        header(value) {
            this.headerText = $.trim(value);
            return this;
        }

        mini(value) {
            this.headerMini = $.trim(value);
            return this;
        }

        body(value) {
            this.bodyText = $.trim(value);
            return this;
        }

        show() {
            let o = '';

            // if there's no header or body clear the whole thing out
            if (this.headerText === '' && this.bodyText === '') {
                DomElement.toastWrapper(this.toastId).html(o);
                return;
            }

            let classTopBottom = this.showOnBottom ? 'bottom-0' : 'top-0';
            let styleTopBottom = this.showOnBottom ? 'bottom: 0' : 'top: 40px';

            o += '<div class="position-fixed ' + classTopBottom + ' right-0 p-3" style="z-index: 5000; right: 0; ' + styleTopBottom + ';">';
            o += '<div id="main-toasts-id-' + this.toastId + '" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" ' + (this.dataDelay <= 0 ? 'data-autohide="false"' : 'data-delay="' + this.dataDelay + '"') + '>';
            if (this.headerText !== '') {
                o += '<div class="toast-header">';
                if (this.headerIcon !== '') {
                    o += '<i class="fa fa-' + this.headerIcon + ' mr-2" aria-hidden="true"></i>';
                }
                o += '<strong class="mr-auto">' + this.headerText + '</strong>';
                if (this.headerMini !== '') {
                    o += '<small class="ml-2">' + this.headerMini + '</small>';
                }
                if (this.showCloseButton) {
                    o += '<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">';
                    o += '<span aria-hidden="true">&times;</span>';
                    o += '</button>';
                }
                o += '</div>';
            }
            if (this.bodyText !== '') {
                o += '<div class="toast-body">';
                o += this.bodyText;
                o += '</div>';
            }
            o += '</div>';
            o += '</div>';

            DomElement.toastWrapper(this.toastId).html(o);
            DomElement.toast(this.toastId).toast('show');
        }

        hide() {
            DomElement.toast(this.toastId).toast('hide');
        }

        destroy() {
            DomElement.toastWrapper(this.toastId).html('');
            this.init();
        }
    }
</script>
<script src="https://www.google.com/recaptcha/api.js?onload=recaptchaOnloadCallback&render=explicit" async defer></script>
<script>
    const recaptchaSiteKey = {!! json_encode(config('services.google.recaptcha.site_key')) !!};
    var   recaptchaIsReady = false;
    var recaptchaOnloadCallback = function() {
        recaptchaIsReady = true;
    };
</script>
