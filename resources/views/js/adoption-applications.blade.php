<script>
    const defaultApplicationType = {!! json_encode($application_type) !!};
    const apiApplicationPrefix   = apiUrlPrefix + {!! json_encode($api_application_prefix) !!};

    const init = function() {
        DomElement.any('adoption-applications-new-application')
            .off("click")
            .on("click", function(e) {
                newApplication(defaultApplicationType);
            });

        getApplications();
    };

    const getApplications = function() {
        let successCallback = function(request, response, status) {
            let adoptionApplications = response['data']['adoption_applications'];
            if (adoptionApplications.length === 0 && !response['data']['is_admin']) {
                newApplication(defaultApplicationType);
                return;
            }

            /******************************/
            /* user's application listing */
            /******************************/
            DomElement.any('adoption-applications-list')
                .html('')
                .append(adoptionApplicationListHeader());

            $.each(
                adoptionApplications,
                function(i, application) {
                    var row = adoptionApplicationListRow(application);
                    DomElement.any('adoption-applications-list').append(row);
                }
            );

            // add a little space on the bottom of the list because the close-knit infobox puts the footer too close
            DomElement.any('adoption-applications-list').append('<div class="row">&nbsp;</div>');

            if (adoptionApplications.length > 0) {
                DomElement.any('adoption-applications-list-your').prop("hidden", false);
            }

            /*****************************/
            /* admin application listing */
            /*****************************/
            // defensive coding - if not admin, break out of function now
            if (!response['data']['is_admin']) {
                hideLoadingShowContent();
                return;
            }

            let adminApplications = response['data']['adoption_applications_admin'];
            DomElement.any('adoption-applications-list-admin').html('');
            if (adminApplications.length === 0) {
                DomElement.any('adoption-applications-list-admin').append(noSubmittedApplicationsRow());
            } else {
                DomElement.any('adoption-applications-list-admin').append(adminApplicationListHeader());
            }

            $.each(
                adminApplications,
                function(i, application) {
                    var row = adminApplicationListRow(application);
                    DomElement.any('adoption-applications-list-admin').append(row);
                }
            );

            // add a little space on the bottom of the list because the close-knit infobox puts the footer too close
            DomElement.any('adoption-applications-list-admin').append('<div class="row">&nbsp;</div>');
            DomElement.any('adoption-applications-list-admin-wrapper').prop("hidden", false);
            hideLoadingShowContent();
        };

        let errorCallback = function(request, textStatus, errorThrown) {
            unInit();
            authenticate();
        };

        hideContentShowLoading();
        Router.ajax('GET', apiApplicationPrefix, {}, successCallback, errorCallback, {}, false, basicAuthCredentials());
    };

    const noSubmittedApplicationsRow = function() {
        let o = '';
        o += '<div class="row infobox close-knit font-weight-bold">';
        o += '<div class="col-sm">There are no submitted applications to review at this time.</div>';
        o += '</div>';

        return o;
    };

    const adminApplicationListHeader = function() {
        let o = '';
        o += '<div class="row infobox close-knit font-weight-bold">';
        o += '<div class="col-sm">Animal name</div>';
        o += '<div class="col-sm-4">Applicant</div>';
        o += '<div class="col-sm-3">Submitted</div>';
        o += '</div>';

        return o;
    };

    const adminApplicationListRow = function(application) {
        let animalName = $.trim(application.animal_name);
        if (animalName === '') {
            animalName = '(none selected yet)';
        }

        let o = '';
        o += '<div class="row infobox close-knit">';
        o += '<div class="col-sm"><a href="/{{ $page }}/' + application.token + '">' + animalName + '</a></div>';
        o += '<div class="col-sm-1"><a href="/{{ $page }}/' + application.token + '">(' + application.type + ')</a></div>';
        o += '<div class="col-sm-4"><a href="/{{ $page }}/' + application.token + '">' + application.applicant + '</a></div>';
        o += '<div class="col-sm-3"><a href="/{{ $page }}/' + application.token + '">' + application.submitted + '</a></div>';
        o += '</div>';

        return o;
    };

    const adoptionApplicationListHeader = function() {
        let o = '';
        o += '<div class="row infobox close-knit font-weight-bold">';
        o += '<div class="col-sm">Animal name</div>';
        o += '<div class="col-sm-2">Status</div>';
        o += '<div class="col-sm-3">Started</div>';
        o += '<div class="col-sm-3">Last updated</div>';
        o += '</div>';

        return o;
    };

    const adoptionApplicationListRow = function(application) {
        let animalName = $.trim(application.animal_name);
        if (animalName === '') {
            animalName = '(none selected yet)';
        }

        let o = '';
        o += '<div class="row infobox close-knit">';
        o += '<div class="col-sm"><a href="/{{ $page }}/' + application.token + '">' + animalName + '</a></div>';
        o += '<div class="col-sm-1"><a href="/{{ $page }}/' + application.token + '">(' + application.type + ')</a></div>';
        o += '<div class="col-sm-2"><a href="/{{ $page }}/' + application.token + '">' + application.status + '</a></div>';
        o += '<div class="col-sm-3"><a href="/{{ $page }}/' + application.token + '">' + application.created + '</a></div>';
        o += '<div class="col-sm-3"><a href="/{{ $page }}/' + application.token + '">' + application.updated + '</a></div>';
        o += '</div>';

        return o;
    };

    const newApplication = function(applicationType) {
        if (typeof applicationType !== 'string') {
            return;
        }
        applicationType = $.trim(applicationType);
        if (applicationType === '') {
            return;
        }

        let successCallback = function(request, response, status) {
            let adoptionApplication = response['data']['adoption_application'];
            if (!adoptionApplication) {
                return;
            }
            console.log(adoptionApplication);
            document.location.href = '/{{ $page }}/' + adoptionApplication.token;
        };

        let errorCallback = function(request, textStatus, errorThrown) {
            console.log(request.xhr.responseJSON);
            unInit();
            authenticate();
        };

        Router.ajax('POST', apiApplicationPrefix, {'application_type': applicationType}, successCallback, errorCallback, {}, false, basicAuthCredentials());
    };

    const unInit = function() {
        hideContentShowLoading();
    };

    const hideLoadingShowContent = function() {
        DomElement.any('adoption-applications-page-loading').prop("hidden", true);
        DomElement.any('adoption-applications-page-content').prop("hidden", false);
    };

    const hideContentShowLoading = function() {
        DomElement.any('adoption-applications-page-content').prop("hidden", true);
        DomElement.any('adoption-applications-page-loading').prop("hidden", false);

        DomElement.any('adoption-applications-list-admin').html('');
        DomElement.any('adoption-applications-list').html('');
        DomElement.any('adoption-applications-list-admin-wrapper').prop("hidden", true);
        DomElement.any('adoption-applications-list-your').prop("hidden", true);
    };

    $(document).ready(function() {

        /********************  DO THIS LAST  ********************/
        $(window).bind("hashchange", function(e) {
        });
        /********************  DO THIS LAST  ********************/
    });
</script>
