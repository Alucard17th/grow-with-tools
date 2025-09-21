@extends('layouts.home')


@section('title','Grow With Tools — Apps, Plugins, and Services to Help You Grow')
@push('meta')
<meta name="description"
    content="Grow With Tools builds and ships high‑quality apps, plugins, and custom tools. Hire us or explore our products.">
<meta property="og:title" content="Grow With Tools">
<meta property="og:description" content="Apps, plugins & services that help indie creators and businesses grow.">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url('/') }}">
<meta property="og:image" content="{{ asset('img/og-gwt.png') }}">
@endpush
@push('styles')
<link rel="stylesheet" href="{{ asset('css/landing.css') }}">
@endpush


@section('content')
<main>
    <x-hero-generic />
    <x-logos />
    <x-services />
    <x-products />
    <x-portfolio />
    <!-- <x-pricing /> -->
    <x-testimonials />
    <x-faq />
    <x-newsletter />
    <x-cta-contact />
</main>
@endsection