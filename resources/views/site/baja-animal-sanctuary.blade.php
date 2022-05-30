@php
    $bas                     = config('bas');
    $bas_view                = config('bas.view');
    $print                   = $print ?? false;
    $not_print               = !$print;
    $authentication_required = $authentication_required ?? false;
@endphp
@include('site.header')
@include($page)
@include('site.footer')
