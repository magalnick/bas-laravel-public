<script>
    const apiApplicationPrefix = apiUrlPrefix + {!! json_encode($api_application_prefix) !!} + '/' + {!! json_encode($application_token) !!};
    const lists                = {!! json_encode($lists) !!};
    let   adoptionApplication  = null;

    const init = function() {
        getApplication();

        ApplicationDomElement.any('adoption-application-button-submit')
            .off("click")
            .on("click", function (e) {
                let canBeSubmitted       = true;
                let formValidationErrors = [];
                ApplicationDomElement.any('adoption-application-form-validation-errors')
                    .addClass("d-none")
                    .html("");
                for (var field in adoptionApplication.dataFieldInstances) {
                    let dataField = adoptionApplication.dataFieldInstances[field];
                    ApplicationDomElement.any(dataField.fieldElementId()).trigger("validate");
                    if (!dataField.isValid) {
                        formValidationErrors.push('<div class="mt-2">- ' + dataField.configuration.label + '</div>');
                        canBeSubmitted = false;
                    }
                }

                if (!canBeSubmitted) {
                    ApplicationDomElement.any('adoption-application-form-validation-errors')
                        .removeClass("d-none")
                        .append('<div>Please answer these questions before submitting:</div>' + formValidationErrors.join(''));
                    return;
                }

                ApplicationDomElement.any('submit-application-confirmation').modal('show');
            });

        ApplicationDomElement.any('adoption-application-button-archive-or-reopen')
            .off("click")
            .on("click", function (e) {
                ApplicationDomElement.any('archive-or-reopen-application-confirmation').modal('show');
            });

        ApplicationDomElement.any('submit-application-confirmation-submit')
            .off("click")
            .on("click", function(e) {
                ApplicationDomElement.any('submit-application-confirmation').modal('hide');
                applicationAction('submit');
            });

        ApplicationDomElement.any('archive-or-reopen-application-confirmation-archive')
            .off("click")
            .on("click", function(e) {
                ApplicationDomElement.any('archive-or-reopen-application-confirmation').modal('hide');
                applicationAction('archive');
            });

        ApplicationDomElement.any('archive-or-reopen-application-confirmation-reopen')
            .off("click")
            .on("click", function(e) {
                ApplicationDomElement.any('archive-or-reopen-application-confirmation').modal('hide');
                applicationAction('reopen');
            });
    };

    const applicationAction = function(action) {
        hideContentHideErrorsShowLoading();

        let successCallback = function(request, response, status) {
            getApplication();
        };

        let errorCallback = function(request, textStatus, errorThrown) {
            console.log(request.xhr.responseJSON);
            let errors = request.xhr.responseJSON.errors;
            $("#adoption-application-load-errors").html(errors.join('<br />'));
            unInit();
        };

        Router.ajax('POST', apiApplicationPrefix, {"action": action}, successCallback, errorCallback, {}, false, basicAuthCredentials());
    };

    const getApplication = function() {
        ApplicationDomElement.any('adoption-application-action-buttons-editable').addClass('d-none');
        ApplicationDomElement.any('adoption-application-action-buttons-not-editable').addClass('d-none');
        ApplicationDomElement.any('adoption-application-action-buttons-admin').addClass('d-none');
        ApplicationDomElement.any('adoption-application-please-read').addClass('d-none');
        let successCallback = function(request, response, status) {
            adoptionApplication = (
                new AdoptionApplication(
                    response['data']['adoption_application_user'],
                    response['data']['adoption_application'],
                    response['data']['is_editable']
                )
            ).parseForDisplay();

            ApplicationDomElement.any('adoption-application-status').text(response['data']['adoption_application_status']);

            // un-hide action buttons based on app status and admin status
            ApplicationDomElement.any(
                response['data']['is_editable']
                    ? 'adoption-application-action-buttons-editable'
                    : 'adoption-application-action-buttons-not-editable'
            ).removeClass('d-none');
            if (response['data']['is_application_admin']) {
                ApplicationDomElement.any('adoption-application-action-buttons-admin').removeClass('d-none');
            }

            if (response['data']['is_editable']) {
                ApplicationDomElement.any('adoption-application-please-read').removeClass('d-none');
            }

            setMainPageHeaderForAnimalName(response['data']['adoption_application']['animal_name']);
            hideLoadingHideErrorsShowContent();

            @if ($print)
            setTimeout(function() {
                window.print();
            }, 300);
            @endif

        };

        let errorCallback = function(request, textStatus, errorThrown) {
            console.log(request.xhr.responseJSON);
            let errors = request.xhr.responseJSON.errors;
            $("#adoption-application-load-errors").html(errors.join('<br />'));
            unInit();
            authenticate();
        };

        Router.ajax('GET', apiApplicationPrefix, {}, successCallback, errorCallback, {}, false, basicAuthCredentials());
    };

    const unInit = function() {
        hideLoadingHideContentShowErrors();
    };

    const hideLoadingHideErrorsShowContent = function() {
        $("#adoption-application-page-loading").prop("hidden", true);
        $("#adoption-application-page-load-errors").prop("hidden", true);
        $("#adoption-application-page-content").prop("hidden", false);
    };

    const hideLoadingHideContentShowErrors = function() {
        $("#adoption-application-page-loading").prop("hidden", true);
        $("#adoption-application-page-content").prop("hidden", true);
        $("#adoption-application-page-load-errors").prop("hidden", false);
    };

    const hideContentHideErrorsShowLoading = function() {
        $("#adoption-application-page-content").prop("hidden", true);
        $("#adoption-application-page-load-errors").prop("hidden", true);
        $("#adoption-application-page-loading").prop("hidden", false);
    };

    const setMainPageHeaderForAnimalName = function(animalName) {
        let pageHeader = 'Adoption Application';

        if (typeof animalName !== 'string' || $.trim(animalName) === '') {
            animalName = ApplicationDomElement.any('application-data-field-animal_name').val();
        }
        animalName = $.trim(animalName);
        if (animalName !== '') {
            pageHeader += ' - ' + animalName;
        }
        setMainPageHeader(pageHeader);
    };

    const disableOrEnableSubmitApplicationButton = function(disable) {
        if (typeof disable !== 'boolean') {
            return;
        }
        ApplicationDomElement.any('adoption-application-button-submit').prop("disabled", disable);
    };

    const disableSubmitApplicationButton = function() {
        disableOrEnableSubmitApplicationButton(true);
    };

    const enableSubmitApplicationButton = function() {
        disableOrEnableSubmitApplicationButton(false);
    };

    $(document).ready(function() {

        /********************  DO THIS LAST  ********************/
        $(window).bind("hashchange", function(e) {
        });
        /********************  DO THIS LAST  ********************/
    });
</script>
<script>
    class ApplicationDomElement extends DomElement {
        static adoptionApplicationDetails() {
            return $("#adoption-application-details");
        }
    }

    class AdoptionApplication {
        constructor(applicationUser, applicationData, isEditable) {
            // class level properties
            this.applicationUser    = applicationUser;
            this.applicationData    = applicationData;
            this.token              = {!! json_encode($application_token) !!};
            this.type               = {!! json_encode($application_type) !!};
            this.status             = {!! json_encode($application_status) !!};
            this.isEditable         = {!! $print ? 'false' : json_encode($is_editable) !!};
            this.configUser         = {!! json_encode($application_config_user, JSON_PRETTY_PRINT) !!};
            this.configCommon       = {!! json_encode($application_config_common, JSON_PRETTY_PRINT) !!};
            this.configForType      = {!! json_encode($application_config_for_type, JSON_PRETTY_PRINT) !!};
            this.dataFieldInstances = {};

            @if (!$print)
            if (typeof isEditable === 'boolean') {
                this.isEditable = isEditable;
            }
            @endif

            // since this object is only getting instantiated on page load or re-login load
            // and not during standard usage when bumping around on the page
            // clear out the areas that accumulate data in this function
            ApplicationDomElement.adoptionApplicationDetails().html('');

            // initialize the auto-save toast
            Toast.singleton('auto-save').icon('save').header('Auto-saving application...').top();
        }

        animalName() {
            return this.applicationData.animal_name;
        }

        parseForDisplay() {

            // show user details
            for (var field in this.configUser) {
                let config    = this.configUser[field];
                let dataField = this.dataFieldInstance(config, this.applicationUser[field], true);
                if (dataField === null) {
                    continue;
                }

                // the user details are static, so no need to set event listeners
                // or add it to this.dataFieldInstances
                // these only need to render
                ApplicationDomElement.adoptionApplicationDetails().append(
                    (new ApplicationDataFieldDisplay(dataField)).render()
                );
            }

            // show common fields
            for (var field in this.configCommon) {
                let config    = this.configCommon[field];
                let dataField = this.dataFieldInstance(config, this.applicationData[field], true);
                if (dataField === null) {
                    continue;
                }

                // render first to write the element into the DOM
                // then set the event listener, which can't be set on something that doesn't exist yet
                ApplicationDomElement.adoptionApplicationDetails().append(
                    (new ApplicationDataFieldDisplay(dataField)).render()
                );
                dataField.setEventListeners();
                this.dataFieldInstances[field] = dataField;
            }

            // show fields for the application type (ie. dog, cat, chinchilla)
            for (var field in this.configForType) {
                let config = this.configForType[field];
                let value
                    = typeof this.applicationData.object_data[field] === 'undefined'
                    ? config.default_value
                    : this.applicationData.object_data[field];
                let dataField = this.dataFieldInstance(config, value, false);
                if (dataField === null) {
                    continue;
                }

                // render first to write the element into the DOM
                // then set the event listener, which can't be set on something that doesn't exist yet
                ApplicationDomElement.adoptionApplicationDetails().append(
                    (new ApplicationDataFieldDisplay(dataField)).render()
                );
                dataField.setEventListeners();
                this.dataFieldInstances[field] = dataField;
            }

            // add a little space on the bottom of the list because the close-knit infobox puts the footer too close
            ApplicationDomElement.adoptionApplicationDetails().append('<div class="row">&nbsp;</div>');

            return this;
        }

        dataFieldInstance(config, value, isCommon) {
            switch (config.type) {
                case 'static':
                    return new ApplicationDataField_static(config, value, isCommon);
                case 'text':
                    return new ApplicationDataField_text(config, value, isCommon, this.isEditable);
                case 'date':
                    return new ApplicationDataField_date(config, value, isCommon, this.isEditable);
                case 'phone':
                    return new ApplicationDataField_phone(config, value, isCommon, this.isEditable);
                case 'textarea':
                    return new ApplicationDataField_textarea(config, value, isCommon, this.isEditable);
                case 'radio':
                    return new ApplicationDataField_radio(config, value, isCommon, this.isEditable);
                case 'checkbox':
                    return new ApplicationDataField_checkbox(config, value, isCommon, this.isEditable);
                case 'checkbox_group':
                    return new ApplicationDataField_checkbox_group(config, value, isCommon, this.isEditable);
                case 'select':
                    return new ApplicationDataField_select(config, value, isCommon, this.isEditable);
                case 'number':
                    return new ApplicationDataField_number(config, value, isCommon, this.isEditable);
                default:
                    return null;
            }
        }
    }

    class ApplicationDataFieldDisplay {
        constructor(applicationDataField) {
            this.applicationDataField = applicationDataField;
        }

        render() {
            let o = '';
            o += '<div class="row infobox close-knit align-items-center">';
            o += '<div class="col-sm-5">' + this.applicationDataField.configuration.label + '</div>';
            o += '<div class="col-sm-7">' + this.applicationDataField.render() + '</div>';
            o += '</div>';

            return o;
        }
    }

    class ApplicationDataField {
        constructor(configuration, value, isCommon, isEditable) {
            this.configuration = configuration;
            this.value         = value;
            this.isCommon      = isCommon;
            this.isEditable    = isEditable;
            this.isValid       = false;
        }

        formElementId() {
            return 'application-data-form-' + this.configuration.id;
        }

        fieldElementId() {
            return 'application-data-field-' + this.configuration.id;
        }

        setEventListenersForTextLikeInputs() {
            if (!this.isEditable) {
                return this;
            }

            ApplicationDomElement.any(this.formElementId())
                .off("submit")
                .on("submit", {"instance": this}, function(e) {
                    let that = e.data.instance;
                    ApplicationDomElement.any(that.fieldElementId()).trigger("save");
                    return false;
                });

            ApplicationDomElement.any(this.fieldElementId())
                .off("focus")
                .on("focus", function(e) {
                    disableSubmitApplicationButton();
                })
                .off("blur")
                .on("blur", function(e) {
                    $(e.target).trigger("save");
                })
                .off("save")
                .on("save", {"instance": this}, function(e) {
                    let that = e.data.instance;
                    $(e.target).trigger("validate");
                    if (!that.isValid) {
                        enableSubmitApplicationButton();
                        return;
                    }

                    // dynamic function call on successful form field validation
                    if (typeof that.configuration.success !== 'undefined') {
                        (new Function(that.configuration.success + "();")());
                    }

                    let type = that.isCommon ? "common" : adoptionApplication.type;
                    that.submitPatchFieldData(type, that.configuration.id, that.value);
                })
                .off("validate")
                .on("validate", {"instance": this}, function(e) {
                    let that  = e.data.instance;
                    let value = $.trim($(e.target).val());
                    $(e.target).val(value);

                    if (!that.validate()) {
                        $(e.target).addClass('is-invalid');
                        return;
                    }
                    $(e.target).removeClass('is-invalid');
                    that.value = value;
                });

            return this;
        }

        submitPatchFieldData(type, field, value) {
            let successCallback = function(request, response, status) {
                enableSubmitApplicationButton();
                setTimeout(function() {
                    Toast.singleton('auto-save').hide();
                }, 1500);
                let applicationField = adoptionApplication.dataFieldInstances[request.inputData.field];
                applicationField.handleSuccessfulResponse(response);
            };

            let errorCallback = function(request, textStatus, errorThrown) {
                enableSubmitApplicationButton();
                Toast.singleton('auto-save').hide();
                console.log(request.xhr.responseJSON);
                let applicationField = adoptionApplication.dataFieldInstances[request.inputData.field];
                applicationField.handleErrorResponse(request);
                ApplicationDomElement.any(applicationField.fieldElementId()).addClass('is-invalid');
            };

            Toast.singleton('auto-save').show();

            let patchData = {
                "type": type,
                "field": field,
                "value": value,
            };

            Router.ajax('PATCH', apiApplicationPrefix, patchData, successCallback, errorCallback, {}, false, basicAuthCredentials());
        }

        handleSuccessfulResponse(response) {
            //
        }

        handleErrorResponse(request) {
            //
        }

        validate() {
            // preemptively set to false, reset to true only at the end if returning true
            this.isValid = false;

            let form = ApplicationDomElement.any(this.formElementId());
            if (form[0].checkValidity() === false) {
                return false;
            }

            this.isValid = true;
            return true;
        }
    }

    class ApplicationDataField_static extends ApplicationDataField {
        constructor(configuration, value, isCommon) {
            super(configuration, value, isCommon, false);
        }

        render() {
            return this.value;
        }

        setEventListeners() {
            return this;
        }
    }

    class ApplicationDataField_text extends ApplicationDataField {
        constructor(configuration, value, isCommon, isEditable) {
            super(configuration, value, isCommon, isEditable);
        }

        render() {
            if (!this.isEditable) {
                return this.value;
            }

            return this.renderFormField();
        }

        renderFormField() {
            let o = '';
            o += '<form id="' + this.formElementId() + '" novalidate><input type="text" id="' + this.fieldElementId() + '" value="' + this.value + '" class="form-control mr-sm-2" maxlength="' + this.configuration.max + '" ' + (this.configuration.is_required ? 'required ' : '') + '/></form>';

            return o;
        }

        setEventListeners() {
            return this.setEventListenersForTextLikeInputs();
        }
    }

    class ApplicationDataField_date extends ApplicationDataField {
        constructor(configuration, value, isCommon, isEditable) {
            super(configuration, value, isCommon, isEditable);
        }

        render() {
            if (!this.isEditable) {
                return this.value;
            }

            return this.renderFormField();
        }

        renderFormField() {
            let o = '';
            o += '<form id="' + this.formElementId() + '" novalidate><input type="date" id="' + this.fieldElementId() + '" value="' + this.value + '" class="form-control mr-sm-2" min="' + this.configuration.min + '" max="' + this.configuration.max + '" ' + (this.configuration.is_required ? 'required ' : '') + '/></form>';

            return o;
        }

        setEventListeners() {
            return this.setEventListenersForTextLikeInputs();
        }
    }

    class ApplicationDataField_textarea extends ApplicationDataField {
        constructor(configuration, value, isCommon, isEditable) {
            super(configuration, value, isCommon, isEditable);
        }

        render() {
            if (!this.isEditable) {
                const regex = /\n/g;
                return this.value.replace(regex, "<br />");
            }

            return this.renderFormField();
        }

        renderFormField() {
            let o = '';
            o += '<form id="' + this.formElementId() + '" novalidate>';
            o += '<textarea id="' + this.fieldElementId() + '" class="form-control mr-sm-2 with-count-message" rows="4" maxlength="' + this.configuration.max + '" ' + (this.configuration.is_required ? 'required ' : '') + '>' + this.value + '</textarea>';
            o += '<span class="pull-right label label-default textarea-count-message" id="' + this.countMessageElementId() + '">' + this.value.length + ' / ' + this.configuration.max + '</span>';
            o += '</form>';

            return o;
        }

        setEventListeners() {
            ApplicationDomElement.any(this.fieldElementId())
                .off("keyup")
                .on("keyup", {"instance": this}, function(e) {
                    let that       = e.data.instance;
                    let textLength = $(e.target).val().length;
                    ApplicationDomElement.any(that.countMessageElementId()).html(textLength + ' / ' + that.configuration.max);
                });

            return this.setEventListenersForTextLikeInputs();
        }

        countMessageElementId() {
            return 'application-data-form-textarea-count-message-' + this.configuration.id;
        }
    }

    class ApplicationDataField_phone extends ApplicationDataField_text {
        constructor(configuration, value, isCommon, isEditable) {
            super(configuration, value, isCommon, isEditable);
            this.value = this.formatRaw(value);
        }

        formatRaw(phoneNumber) {
            phoneNumber = $.trim(phoneNumber);
            if (phoneNumber === '') {
                return '';
            }

            let areaCode = phoneNumber.substring(2, 5);
            let prefix   = phoneNumber.substring(5, 8);
            let suffix   = phoneNumber.substring(8, 12);
            return `+1 (${areaCode}) ${prefix}-${suffix}`;
        }

        renderFormField() {
            let o = '';
            o += '<form id="' + this.formElementId() + '" novalidate><input type="tel" id="' + this.fieldElementId() + '" value="' + this.value + '" class="form-control mr-sm-2" data-format="+1 (ddd) ddd-dddd" placeholder="(000) 000-0000" maxlength="' + this.configuration.max + '" ' + (this.configuration.is_required ? 'required ' : '') + '/></form>';

            return o;
        }

        handleSuccessfulResponse(response) {
            ApplicationDomElement.any(this.fieldElementId()).val(
                this.formatRaw(response.data[this.configuration.id])
            );
        }
    }

    class ApplicationDataField_radio extends ApplicationDataField {
        constructor(configuration, value, isCommon, isEditable) {
            super(configuration, value, isCommon, isEditable);
        }

        render() {
            return this.value;
        }

        setEventListeners() {
            return this;
        }
    }

    class ApplicationDataField_checkbox extends ApplicationDataField {
        constructor(configuration, value, isCommon, isEditable) {
            super(configuration, value, isCommon, isEditable);
        }

        render() {
            if (!this.isEditable) {
                return this.configuration.static_label[+this.value];
            }

            return this.renderFormField();
        }

        renderFormField() {
            let o = '';
            o += '<div class="form-check mb-4">';
            o += '<form id="' + this.formElementId() + '" novalidate>';
            o += '<input type="checkbox" id="' + this.fieldElementId() + '" value="' + this.value + '" class="form-check-input" ' + (this.value ? 'checked ' : '') + (this.configuration.is_required ? 'required ' : '') + '/>';
            if (this.configuration.is_required && typeof this.configuration.invalid_feedback === 'string') {
                o += '<div class="invalid-feedback" style="margin-top: 1rem; padding-top: .25rem;">' + this.configuration.invalid_feedback + '</div>';
            }
            o += '</form></div>';

            return o;
        }

        setEventListeners() {
            if (!this.isEditable) {
                return this;
            }

            ApplicationDomElement.any(this.formElementId())
                .off("submit")
                .on("submit", function(e) {
                    return false;
                });

            ApplicationDomElement.any(this.fieldElementId())
                .off("click")
                .on("click", {"instance": this}, function(e) {
                    let that = e.data.instance;
                    $(e.target).trigger("validate");
                    if (!that.isValid) {
                        return;
                    }

                    let type  = that.isCommon ? "common" : adoptionApplication.type;
                    let value = that.value ? 1 : 0;
                    that.submitPatchFieldData(type, that.configuration.id, value);
                })
                .off("validate")
                .on("validate", {"instance": this}, function(e) {
                    let that      = e.data.instance;
                    let isChecked = $(e.target).is(":checked");

                    if (!that.validate() && !isChecked) {
                        $(e.target).addClass('is-invalid');
                        return;
                    }
                    $(e.target).removeClass('is-invalid');
                    that.value = isChecked;
                });

            return this;
        }
    }

    class ApplicationDataField_checkbox_group extends ApplicationDataField {
        constructor(configuration, value, isCommon, isEditable) {
            if (typeof value !== 'object') {
                value = [];
            }
            super(configuration, value, isCommon, isEditable);
        }

        checkboxElementId(index) {
            return this.fieldElementId() + '-' + index.toString();
        }

        render() {
            if (this.isEditable) {
                return this.renderFormFields();
            }

            return this.renderStatic();
        }

        renderStatic() {
            let o = '';
            let values = this.value.map(i => {
                return this.configuration.static_labels[i];
            });
            o += values.join('<br />');
            return o;
        }

        renderFormFields() {
            let o = '';
            o += '<div class="form-check mb-4">';
            o += '<form id="' + this.formElementId() + '" novalidate>';

            // using this style of loop because the loop style for (i in ...) treats i as a string
            // since that loop is meant to iterate through object keys, which are strings in JSON
            for (var i = 0; i < this.configuration.static_labels.length; i++) {
                let staticLabel = this.configuration.static_labels[i];
                let checked     = this.value.includes(i) ? 'checked ' : '';
                let elementId   = this.checkboxElementId(i);

                o += '<div class="form-group form-check">';
                o += '<input type="checkbox" id="' + elementId + '" class="form-check-input" ' + checked + '/>';
                o += '<label class="form-check-label" for="' + elementId + '">' + staticLabel + '</label>';
                o += '</div>';
            }

            // this hidden field is so there is a form field of the exact element ID name
            // so that the parent process looping through all main fields can have a validate listener to trigger
            o += '<input type="hidden" id="' + this.fieldElementId() + '" />';
            if (this.configuration.is_required && typeof this.configuration.invalid_feedback === 'string') {
                o += '<div class="invalid-feedback" style="margin-top: 1rem; padding-top: .25rem;">' + this.configuration.invalid_feedback + '</div>';
            }
            o += '</form></div>';

            return o;
        }

        setEventListeners() {
            if (!this.isEditable) {
                return this;
            }

            ApplicationDomElement.any(this.formElementId())
                .off("submit")
                .on("submit", function(e) {
                    return false;
                })
                .off("save")
                .on("save", {"instance": this}, function(e) {
                    let that   = e.data.instance;
                    let values = [];

                    for (var i = 0; i < that.configuration.static_labels.length; i++) {
                        if (ApplicationDomElement.any(that.checkboxElementId(i)).is(":checked")) {
                            values.push(i);
                        }
                    }

                    if (values.length === 0 && that.configuration.is_required) {
                        ApplicationDomElement.any(that.fieldElementId()).trigger("validate");
                        return;
                    }

                    that.value = values;

                    let type = that.isCommon ? "common" : adoptionApplication.type;
                    that.submitPatchFieldData(type, that.configuration.id, values);
                });

            // this covers all checkboxes in the group
            ApplicationDomElement.any(this.formElementId() + ' input[type=checkbox]')
                .off("click")
                .on("click", {"instance": this}, function(e) {
                    let that = e.data.instance;

                    // call validate against the main hidden field
                    ApplicationDomElement.any(that.fieldElementId()).trigger("validate");
                    if (!that.isValid) {
                        return;
                    }

                    ApplicationDomElement.any(that.formElementId()).trigger("save");
                });

            // this is the hidden field that exists so the validate action can be put on the main field name
            ApplicationDomElement.any(this.fieldElementId())
                .off("validate")
                .on("validate", {"instance": this}, function(e) {
                    let that = e.data.instance;

                    // if any of the checkboxes are checked, this will be true
                    // if none are checked, this will be false
                    let isChecked = ApplicationDomElement.any(
                        that.formElementId() + ' input[type=checkbox]'
                    ).is(":checked");

                    // if required and nothing is checked, set all checkboxes as required so validation will fail
                    // otherwise (ie. not required or anything is checked) set all checkboxes as not required,
                    // which will allow validation to pass
                    let isRequired = that.configuration.is_required && !isChecked;
                    ApplicationDomElement.any(
                        that.formElementId() + ' input[type=checkbox]'
                    ).prop("required", isRequired);

                    if (!that.validate() && !isChecked) {
                        $(e.target).addClass('is-invalid');
                        return;
                    }
                    $(e.target).removeClass('is-invalid');
                })
                .off("validate-force-fail")
                .on("validate-force-fail", {"instance": this}, function(e) {
                    let that = e.data.instance;

                    // uncheck all checkboxes in group, set as required, run the validate() method
                    ApplicationDomElement.any(
                        that.formElementId() + ' input[type=checkbox]'
                    ).prop("checked", false).prop("required", true);
                    if (!that.validate()) {
                        $(e.target).addClass('is-invalid');
                    }
                });

            return this;
        }

        handleErrorResponse(request) {
            ApplicationDomElement.any(this.fieldElementId()).trigger("validate-force-fail");
        }
    }

    class ApplicationDataField_select extends ApplicationDataField {
        constructor(configuration, value, isCommon, isEditable) {
            super(configuration, value, isCommon, isEditable);
        }

        render() {
            if (!this.isEditable) {
                return this.renderStatic();
            }

            return this.renderFormField();
        }

        renderStatic() {
            if (this.value === '') {
                return '';
            }

            return (new Function("return lists." + this.configuration.list))()[this.value];
        }

        renderFormField() {
            let selectList = (new Function("return lists." + this.configuration.list))();
            let o = '';
            o += '<form id="' + this.formElementId() + '" novalidate>';
            o += '<select id="' + this.fieldElementId() + '" class="form-control mr-sm-2" ' + (this.configuration.is_required ? 'required ' : '') + '>';
            o += '<option value="">Select</option>';
            for (var option in selectList) {
                let display = selectList[option];
                o += '<option value="' + option + '" class="form-check-input" ' + (option === this.value ? 'selected ' : '') + '>' + display + '</option>';
            }
            o += '</select>';
            o += '</form>';

            return o;
        }

        setEventListeners() {
            return this.setEventListenersForTextLikeInputs();
        }
    }

    class ApplicationDataField_number extends ApplicationDataField_text {
        constructor(configuration, value, isCommon, isEditable) {
            super(configuration, value, isCommon, isEditable);
        }

        renderFormField() {
            let o = '';
            let minMaxDigits = '';
            if (typeof this.configuration.min !== 'undefined') {
                minMaxDigits += ' min="' + this.configuration.min + '"';
            }
            if (typeof this.configuration.max !== 'undefined') {
                minMaxDigits += ' max="' + this.configuration.max + '"';
            }
            if (typeof this.configuration.digits !== 'undefined') {
                minMaxDigits += ' minlength="' + this.configuration.digits + '" maxlength="' + this.configuration.digits + '"';
            }
            o += '<form id="' + this.formElementId() + '" novalidate><input type="number" id="' + this.fieldElementId() + '" value="' + this.value + '" class="form-control mr-sm-2" ' + minMaxDigits + (this.configuration.is_required ? 'required ' : '') + '/></form>';

            return o;
        }
    }
</script>
