@php
    $app_name = env('APP_NAME', 'Baja Animal Sanctuary');
    $legal_name = "{$app_name}, A.C.";
@endphp
</div>

@include('site.auth.authentication-form')

<div id="main-toasts"></div>
</main>

@if ($not_print)
@include('site.footer.1')
@include('site.footer.2')
@endif
@include('site.footer.js')

@include('site.auth.authentication-js')

@php
    $page_js = isset($js) ? "js.{$js}" : null;
@endphp
@if (!is_null($page_js))
@include($page_js)
@endif
</body>
</html>
