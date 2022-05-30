<div id="adoption-application-page-content" class="row" hidden>
    <div class="col-md">
        @if (!$print)
            <div id="adoption-application-please-read" class="row infobox close-knit">
                <p>
                    This questionnaire has been designed to help you and The Baja Animal Sanctuary decide if you and your family are, at this moment,
                    adequately prepared to assume the level of responsible ownership that we are trying to ensure for our adoptive animals.
                </p>
                <p>
                    Our primary concern is to place each animal in the best possible home for that animal.
                    Pet ownership is a serious responsibility.
                    We are asking you to make a lifetime commitment to the pet you adopt.
                </p>
                <p>
                    It is very stressful for the animals, and for you, when an adoption does not work out and the pet is returned to us.
                    Because of this we will ask to do a home visit during the Foster Period before you permanently adopt one of our animals.
                </p>
            </div>
        @endif
        <div id="adoption-application-details"></div>
    </div>
    @if (!$print)
    <div class="col-md-3">
        <div id="adoption-application-action-buttons-editable">
            <div class="infobox close-knit">
                <button id="adoption-application-button-submit" class="btn btn-outline-cta" style="width: 100%;">Submit Your Application</button>
            </div>
            <div id="adoption-application-form-validation-errors" class="infobox important close-knit d-none"></div>
        </div>
        <div id="adoption-application-action-buttons-not-editable">
            <div class="infobox close-knit">
                Status:
                <span id="adoption-application-status"></span>
            </div>
            <div class="infobox">
                <div><a href="{{ $application_token }}/print" class="btn btn-outline-cta" style="width: 100%;">Print Application</a></div>
                <div id="adoption-application-action-buttons-admin">
                    <div class="mt-2"><button id="adoption-application-button-archive-or-reopen" class="btn btn-outline-cta" style="width: 100%;">Reopen or Archive</button></div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<div id="adoption-application-page-load-errors" class="row" hidden>
    <div id="adoption-application-load-errors" class="col-md infobox"></div>
</div>

<div id="adoption-application-page-loading" class="row">
    <div class="col-md-3 h2">
        <i class="fa fa-circle-o-notch fa-spin" aria-hidden="true"></i>
    </div>
</div>

<!-- begin submit application confirmation -->
<div
    class="modal fade"
    id="submit-application-confirmation"
    tabindex="-1"
    aria-labelledby="submit-application-confirmation-label"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="submit-application-confirmation-label">Please confirm</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm">
                        <p>
                            Thank you for your interest in adopting from The Baja Animal Sanctuary.
                        </p>
                        <p>
                            A Sanctuary volunteer will be in contact to let you know the status of your application.
                        </p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="submit-application-confirmation-submit" type="button" class="btn btn-outline-cta">Yes, Submit My Application!</button>
            </div>
        </div>
    </div>
</div>
<!-- end submit application confirmation -->

<!-- begin archive/reopen application confirmation -->
<div
    class="modal fade"
    id="archive-or-reopen-application-confirmation"
    tabindex="-1"
    aria-labelledby="archive-or-reopen-application-confirmation-label"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="archive-or-reopen-application-confirmation-label">Reopen or Archive Application</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm">
                        <p>
                            Continuing with either option will remove this application from your queue on the
                            <a href="{{ $bas_view['pages']['adoption-applications']['path'] }}">Adoption Application Overview</a>
                            page.
                        </p>
                        <ul>
                            <li>
                                After clicking the "Reopen" button:
                                <ol>
                                    <li>The applicant will be able to further edit this application.</li>
                                    <li>It will *not* be in your list of submitted applications until it is re-submitted.</li>
                                    <li>It is up to you to directly inform the applicant that they need to re-submit the application.</li>
                                </ol>
                            </li>
                            <li>
                                After clicking the "Archive" button:
                                <ol>
                                    <li>This page will look the same as it does now.</li>
                                    <li>It won't be in your list of submitted applications.</li>
                                </ol>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="archive-or-reopen-application-confirmation-reopen" type="button" class="btn btn-outline-cta">Reopen</button>
                <button id="archive-or-reopen-application-confirmation-archive" type="button" class="btn btn-outline-cta">Archive</button>
            </div>
        </div>
    </div>
</div>
<!-- end archive/reopen application confirmation -->
