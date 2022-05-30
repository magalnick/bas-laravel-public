@php
    $app_name      = $bas['name'];
    $title_tagline = "{$app_name} | {$bas['tagline']}";
    $page_title    = $bas_view['pages'][$page]['title'];
    $page_title    = $custom_page_title ?? $page_title;
    $base_url      = config('app.url');
    $page_url      = $base_url . $bas_view['pages'][$page]['path'];
    $description   = $bas_view['pages'][$page]['description'] ?? $bas['mission_statement'];
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>{{ $page_title }} | {{ $title_tagline }}</title>
    <meta name="description" content="{{ $description }}" />
    <link rel="canonical" href="{{ $page_url }}" />

    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{ $page_title }} | {{ $title_tagline }}" />
    <meta property="og:description" content="{{ $description }}" />
    <meta property="og:url" content="{{ $page_url }}" />
    <meta property="og:site_name" content="{{ $app_name }}" />
    <meta property="og:image" content="{{ $base_url }}/images/logo.png" />
    <meta property="og:image:width" content="120" />
    <meta property="og:image:height" content="116" />

    <!-- Bootstrap 4.6 CSS - this *MUST* be the first CSS instantiated on the page -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <!-- Styles -->
    @include('css.bas.css')
    @php
        $page_css = isset($css) ? "css.{$css}" : null;
    @endphp
    @if (!is_null($page_css))
        @include($page_css)
    @endif
</head>
<body>
<a href="#main-content" class="sr-only sr-only-focusable">Skip to main content</a>
@if ($not_print)
    @include('site.nav')
    @include('site.banner')
@endif
<main id="main-content">
<div class="container">
    <div class="row">
        <h1 id="main-page-h1">{{ $page_title }}</h1>
    </div>
