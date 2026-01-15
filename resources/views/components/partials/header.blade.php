@props([
    'title' => null,
    'description' => 'An official university-affiliated recruitment platform managed by IEEE Professional Communication Student Chapter, University of Moratuwa. The site provides a secure login interface for corporate entities to manage career details and publish employment opportunities. It serves as the digital infrastructure for the university\'s annual career fair and year-round talent acquisition.',
    'keywords' => 'CareerX, University of Moratuwa, recruitment, career fair, IEEE, job opportunities, talent acquisition, corporate recruitment',
    'image' => null,
    'url' => null,
])

@php
    $pageTitle = isset($title) ? $title . ' - ' . config('app.name') : config('app.name');
    $siteUrl = $url ?? url()->current();
    $socialImage = $image ?? asset('cover.png');
@endphp

<head>
    {{-- Basic Meta Tags --}}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    {{-- SEO Meta Tags --}}
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $description }}">
    <meta name="keywords" content="{{ $keywords }}">
    <meta name="author" content="IEEE Professional Communication Student Chapter, University of Moratuwa">
    <link rel="canonical" href="{{ $siteUrl }}">
    
    {{-- Open Graph Meta Tags (Facebook, LinkedIn) --}}
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:image" content="{{ $socialImage }}">
    <meta property="og:url" content="{{ $siteUrl }}">
    <meta property="og:site_name" content="CareerX">
    <meta property="og:locale" content="en_US">
    
    {{-- Twitter Card Meta Tags --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $pageTitle }}">
    <meta name="twitter:description" content="{{ $description }}">
    <meta name="twitter:image" content="{{ $socialImage }}">

    {{-- Favicons --}}
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="manifest" href="/site.webmanifest">
    
    {{-- Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
