@php
if (!is_array($errors)) {
    $errors = [];
}
@endphp
@if (!empty($errors))
    <div class="row">
        <div class="col-md">
            <div class="infobox">
                {!! join('<br />', $errors) !!}
            </div>
        </div>
    </div>
@endif
