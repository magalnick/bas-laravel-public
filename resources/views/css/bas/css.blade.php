@php
    // define colors by name
    //$really_really_dark_brown = '#320f03';
    $really_really_dark_brown = '#2c0c03';
    $really_dark_brown = '#421f0b';
    $really_dark_brown_rgba = '66, 31, 11, 0.5';
    $dark_brown = '#5a2f0e';
    $medium_dark_brown = '#a0663e';
    $medium_light_tan = '#e3dccc';
    $light_tan = '#f3eede';
    //$really_light_tan = '#fff9e9';
    //$really_light_tan = '#fffcf0';
    $really_light_tan = '#fffff9';
    $really_dark_blue = '#042C6D';
    $really_dark_blue_rgba = '8, 76, 141, 0.5';
    $logo_blue = '#0091c6';
    //$medium_light_blue = '#00a1e6';
    //$medium_light_blue = '#00b6f9';
    $medium_light_blue = '#00c0ff';
    $medium_dark_red = '#800000';
    $medium_dark_red_rgba = '128, 0, 0, 0.5';
    $white = '#fff';

    // set colors to their usage
    $body_bg     = $print ? $white : $light_tan;
    $body_text   = $really_dark_brown;
    $body_link_a = $really_really_dark_brown;
    $body_link_b = $dark_brown;

    $nav_bg     = $medium_light_blue;
    $nav_text   = $really_dark_brown;
    $nav_link_a = $really_really_dark_brown;
    $nav_link_b = $dark_brown;

    $header_bg     = $really_light_tan;
    $header_text   = $really_dark_brown;
    $header_link_a = $really_really_dark_brown;
    $header_link_b = $dark_brown;
    $header_border = $really_light_tan;

    $main_bg     = $print ? $white : $light_tan;
    $main_text   = $really_really_dark_brown;
    //$main_link_a = $dark_brown;
    $main_link_a = $medium_dark_brown;
    $main_link_b = $really_dark_brown;

    $footer_1_bg     = $medium_light_blue;
    $footer_1_text   = $really_dark_brown;
    $footer_1_link_a = $really_really_dark_brown;
    $footer_1_link_b = $dark_brown;

    //$footer_2_bg     = $really_dark_blue;
    //$footer_2_text   = $really_light_tan;
    //$footer_2_link_a = $really_light_tan;
    //$footer_2_link_b = $medium_light_tan;
    $footer_2_border = $really_dark_blue;
    $footer_2_bg     = $medium_light_blue;
    $footer_2_text   = $really_dark_brown;
    $footer_2_link_a = $really_really_dark_brown;
    $footer_2_link_b = $dark_brown;

    $infobox_bg     = $print ? $white : $really_light_tan;
    $infobox_border = $medium_light_tan;

    $cta_bg       = $really_light_tan;
    $cta_bg_hover = 'transparent';
    $cta_border   = $really_really_dark_brown;
    $cta_text     = $really_really_dark_brown;
    $cta_rgba     = $really_dark_brown_rgba;

    $main_cta_bg         = 'transparent';
    $main_cta_bg_hover   = $really_really_dark_brown;
    $main_cta_border     = $really_really_dark_brown;
    $main_cta_text       = $really_really_dark_brown;
    $main_cta_text_hover = $really_light_tan;
    $main_cta_rgba       = $really_dark_brown_rgba;

    $important_notice = $medium_dark_red;

    $modal_bg             = $print ? $white : $really_light_tan;
    $modal_border         = $medium_dark_red_rgba;
    $modal_section_border = $medium_light_tan;

    $form_field_bg          = $light_tan;
    $form_field_border      = $medium_light_tan;
    $form_field_text        = $really_really_dark_brown;
    $form_field_placeholder = $medium_dark_brown;

    $button_primary_bg         = $medium_light_blue;
    $button_primary_border     = $medium_light_blue;
    $button_primary_text       = $really_really_dark_brown;
    $button_primary_text_hover = $really_light_tan;
    $button_primary_hover      = $logo_blue;

    $figure_caption = $medium_dark_brown;

    $recaptcha_bg     = $print ? $white : $really_light_tan;
    $recaptcha_border = $medium_light_tan;
    $recaptcha_text   = $really_really_dark_brown;
@endphp
<style>
@@import url('/css/fontawesome/css/font-awesome.min.css');
@@import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap');

body {
    font-family: 'Nunito',Arial,sans-serif;
    background-color: {{ $body_bg }};
    color: {{ $body_text }};
}

a.sr-only {
    color: {{ $body_link_a }};
}

a.nav-link,
span.navbar-text {
    white-space: nowrap;
}

nav.navbar-dark {
    background-color: {{ $nav_bg }} !important;
}
.navbar-dark .navbar-nav .nav-link {
    color: {{ $nav_link_a }};
}
.navbar-dark .navbar-nav .nav-link:hover, .navbar-dark .navbar-nav .nav-link:focus {
    color: {{ $nav_link_b }};
}
.navbar-dark .navbar-brand {
    color: {{ $nav_link_a }};
}
.navbar-dark .navbar-brand:hover, .navbar-dark .navbar-brand:focus {
    color: {{ $nav_link_b }};
}
li.nav-item.active {
    font-weight: bold;
}
li.nav-item.active a.nav-link {
    color: {{ $nav_link_a }} !important;
}

header {
    background-color: {{ $header_bg }};
    /*border-bottom: 1px solid {{ $header_border }};*/
}
header nav.navbar {
    padding: 0;
}
header nav a.nav-link {
    white-space: normal;
}
header nav a.nav-link.disabled {
    color: {{ $header_text }};
}
header nav .navbar-brand,
header nav .navbar-text {
    padding-top: 0;
    padding-bottom: 0;
}

main {
    background-color: {{ $main_bg }};
    color: {{ $main_text }};
    padding-top: 10px;
    padding-bottom: 5px;
}
main a {
    color: {{ $main_link_a }};
}
main a:hover {
    color: {{ $main_link_b }};
    text-decoration: underline;
}
main .row .col-md {
    /*padding-left: 0;*/
}

footer {
    background-color: {{ $footer_1_bg }};
    padding: 15px 0;
    color: {{ $footer_1_text }};
    font-size: 0.85em;
}
footer a {
    color: {{ $footer_1_link_a }};
}
footer a:hover {
    color: {{ $footer_1_link_b }};
    text-decoration: none;
}
footer + footer {
    color: {{ $footer_2_text }};
    background-color: {{ $footer_2_bg }};
    border-top: 1px dotted {{ $footer_2_border }};
}
footer + footer a {
    color: {{ $footer_2_link_a }};
}
footer + footer a:hover {
    color: {{ $footer_2_link_b }};
}
footer nav.navbar {
    padding: .5rem 0;
}
footer .row .col-md {
    padding-top: 10px;
    padding-bottom: 10px;
}
footer nav a.nav-link,
footer nav span.navbar-text {
    white-space: normal;
}


.btn-outline-cta {
    color: {{ $cta_text }};
    background-color: {{ $cta_bg }};
    border-color: {{ $cta_border }};
}
.btn-outline-cta:hover {
    color: {{ $cta_text }};
    background-color: {{ $cta_bg_hover }};
    border-color: {{ $cta_border }};
}
.btn-outline-cta:focus, .btn-outline-cta.focus {
    background-color: {{ $cta_bg_hover }};
    box-shadow: 0 0 0 0.2rem rgba({{ $cta_rgba }});
}
.btn-outline-cta.disabled, .btn-outline-cta:disabled {
    color: {{ $cta_text }};
    background-color: {{ $cta_bg_hover }};
    cursor: default !important;
}
.btn-outline-cta:not(:disabled):not(.disabled):active, .btn-outline-cta:not(:disabled):not(.disabled).active,
.show > .btn-outline-cta.dropdown-toggle {
    color: {{ $cta_text }};
    background-color: {{ $cta_bg }};
    border-color: {{ $cta_border }};
}
.btn-outline-cta:not(:disabled):not(.disabled):active:focus, .btn-outline-cta:not(:disabled):not(.disabled).active:focus,
.show > .btn-outline-cta.dropdown-toggle:focus {
    background-color: {{ $cta_bg_hover }};
    box-shadow: 0 0 0 0.2rem rgba({{ $cta_rgba }});
}

main .btn-outline-cta {
    color: {{ $main_cta_text }};
    background-color: {{ $main_cta_bg }};
    border-color: {{ $main_cta_border }};
}
main .btn-outline-cta:hover {
    color: {{ $main_cta_text_hover }};
    background-color: {{ $main_cta_bg_hover }};
    border-color: {{ $main_cta_border }};
}
main .btn-outline-cta:focus, main .btn-outline-cta.focus {
    color: {{ $main_cta_text_hover }};
    background-color: {{ $main_cta_bg_hover }};
    box-shadow: 0 0 0 0.2rem rgba({{ $main_cta_rgba }});
}
main .btn-outline-cta.disabled, main .btn-outline-cta:disabled {
    color: {{ $main_cta_text }};
    background-color: {{ $main_cta_bg }};
    border-color: {{ $main_cta_border }};
}
main .btn-outline-cta:not(:disabled):not(.disabled):active, main .btn-outline-cta:not(:disabled):not(.disabled).active,
.show > main .btn-outline-cta.dropdown-toggle {
    color: {{ $main_cta_text }};
    background-color: {{ $main_cta_bg }};
    border-color: {{ $main_cta_border }};
}
main .btn-outline-cta:not(:disabled):not(.disabled):active:focus, main .btn-outline-cta:not(:disabled):not(.disabled).active:focus,
.show > main .btn-outline-cta.dropdown-toggle:focus {
    color: {{ $main_cta_text_hover }};
    background-color: {{ $main_cta_bg_hover }};
    box-shadow: 0 0 0 0.2rem rgba({{ $main_cta_rgba }});
}

.btn-primary {
    color: {{ $button_primary_text }};
    background-color: {{ $button_primary_bg }};
    border-color: {{ $button_primary_border }};
}

.btn-primary:hover {
    color: {{ $button_primary_text_hover }};
    background-color: {{ $button_primary_hover }};
    border-color: {{ $button_primary_hover }};
}

.btn-primary:focus, .btn-primary.focus {
    color: {{ $button_primary_text_hover }};
    background-color: {{ $button_primary_hover }};
    border-color: {{ $button_primary_hover }};
}

.figure-caption {
    color: {{ $figure_caption }};
}

.infobox {
    border: 1px solid {{ $infobox_border }};
    padding: 10px 15px;
    margin-bottom: 1.0rem;
    background-color: {{ $infobox_bg }};
}
.infobox.tight {
    padding: 0;
}
.infobox.close-knit {
    margin-bottom: 0;
}
.infobox.important {
    color: {{ $important_notice }};
    border-color: {{ $important_notice }};
}
.infobox p {
    margin-bottom: 0.7rem;
}

/* Override bootstrap form field colors */
.form-control,
.form-control:focus {
    color: {{ $form_field_text }};
    background-color: {{ $form_field_bg }};
    border: 1px solid {{ $form_field_border }};
}
.form-control::-webkit-input-placeholder {
    color: {{ $form_field_placeholder }} !important;
}
.form-control::-moz-placeholder {
    color: {{ $form_field_placeholder }} !important;
}
.form-control:-ms-input-placeholder {
    color: {{ $form_field_placeholder }} !important;
}
.form-control::-ms-input-placeholder {
    color: {{ $form_field_placeholder }} !important;
}
.form-control::placeholder {
    color: {{ $form_field_placeholder }} !important;
}

/* Override bootstrap modal colors */
.modal-content {
    background-color: {{ $modal_bg }};
    border: 1px solid rgba({{ $modal_border }});
}
.modal-header {
    border-bottom: 1px solid {{ $modal_section_border }};
}
.modal-footer {
    border-top: 1px solid {{ $modal_section_border }};
}

/* Override reCaptcha classes */
.rc-anchor-light.rc-anchor-normal {
    border: 1px solid {{ $recaptcha_border }} !important;
}
.rc-anchor-light {
    background: {{ $recaptcha_bg }} !important;
    color: {{ $recaptcha_text }} !important;
}

textarea.with-count-message {
    /*resize: none;*/
}
.textarea-count-message {
    background-color: {{ $form_field_text }};
    color: {{ $form_field_bg }};
    margin-top: 3px;
    margin-right: 5px;
    font-size: 0.65rem;
    padding: 0 5px;
    border-radius: 0.25rem;
}
</style>
