@extends('layouts.home')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/landing.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightgallery@2.9.0-beta.1/css/lightgallery-bundle.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.8.3/css/lg-zoom.min.css" integrity="sha512-S/hU6dGSK3D7SRpCvRF/IEufIr6Ikgp5vDiJarhdeFGEnw36hWZ6gVBjnwBbzjA+NEP7D8Gdm+5LL1HEsyiB1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.8.3/css/lg-thumbnail.min.css" integrity="sha512-rKuOh3xlF/027KUPuMok0ESsZ2zWPRzkniD3n5zZKCAtbiVkYw66DR4KtVAGf8dLPLr5DdyQs05BlSmEyXctkQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@section('title', $product['title'] . ' – Grow With Tools')

@push('meta')
<meta name="description" content="{{ $product['subtitle'] ?? $product['desc'] ?? 'Product details' }}">
@endpush

@section('content')
{{-- Breadcrumbs --}}
<nav class="bg-light border-bottom small" aria-label="breadcrumb">
    <div class="container py-2">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/#products') }}">Products</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product['title'] }}</li>
        </ol>
    </div>
</nav>

{{-- Hero --}}
<section class="solution-hero bg-gradient" style="--product-color: {{ $product['color'] ?? '#0d6efd' }};">
    <div class="container py-5 py-lg-6">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <span class="badge text-bg-light mb-3">Product</span>
                <h1 class="display-5 fw-bold mb-2">{{ $product['title'] }}</h1>
                @if(!empty($product['subtitle']))
                <p class="lead text-secondary">{{ $product['subtitle'] }}</p>
                @endif
                <div class="d-flex gap-2 mt-3">
                    <a target="_blank" href="{{ $product['cta']['primary_href'] ?? '#contact' }}"
                        class="btn btn-primary btn-lg">{{ $product['cta']['primary_text'] ?? 'Get started' }}</a>
                    <a target="_blank" href="{{ $product['cta']['secondary_href'] ?? '#contact' }}"
                        class="btn btn-outline-primary btn-lg">{{ $product['cta']['secondary_text'] ?? 'Book a demo' }}</a>
                </div>
                @if(!empty($product['stats']))
                <div class="d-flex flex-wrap gap-4 mt-4">
                    @foreach($product['stats'] as $s)
                    <div>
                        <div class="h3 fw-bold mb-0">{{ $s['kpi'] }}</div>
                        <div class="text-secondary small">{{ $s['label'] }}</div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
            <div class="col-lg-6">
                @if(!empty($product['video']['src']) && $product['video']['src'] != '')
                <div class="ratio ratio-16x9 rounded-4 overflow-hidden shadow-lg">
                    <video controls poster="{{ asset($product['video']['poster'] ?? $product['hero_image'] ?? '') }}"
                        preload="metadata">
                        <source src="{{ asset($product['video']['src']) }}" type="video/mp4">
                    </video>
                </div>
                @elseif(!empty($product['img']))
                <img class="img-fluid rounded-4 shadow-lg" src="{{ asset($product['img']) }}"
                    alt="{{ $product['title'] }}" />
                @endif
            </div>
        </div>
    </div>
</section>

{{-- Problem / Solution / Outcomes --}}
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold">The Problem</h5>
                        <p class="text-secondary mb-0">
                            {{ $product['problem'] ?? 'Inefficient tooling, leaky funnels, or slow stacks make launches risky and expensive.' }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold">Our Approach</h5>
                        <p class="text-secondary mb-0">
                            {{ $product['approach'] ?? 'Lean scoping, reusable components, and analytics from day one to de‑risk delivery.' }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold">Expected Outcomes</h5>
                        <ul class="text-secondary mb-0 small ps-3">
                            @foreach($product['outcomes'] ?? [] as $outcome)
                            <li>{{ $outcome['key_outcome'] }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Features grid --}}
@if(!empty($product['features']))
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">What you get</h2>
            <p class="text-secondary">A complete toolkit—no surprises.</p>
        </div>
        <div class="row g-4">
            @foreach($product['features'] as $f)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 hover-lift">
                    <div class="card-body p-4">
                        <div class="icon-wrap rounded-3 bg-primary-subtle text-primary mb-3">
                            @include('components.svg', ['name' => $f['icon'], 'fillColor' => $product['color']])
                        </div>
                        <h6 class="fw-bold mb-1">{{ $f['title'] }}</h6>
                        <p class="text-secondary mb-0 small">{{ $f['desc'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Gallery --}}
@if(!empty($product['gallery']))
<section class="py-5 solution-gallery" style="--product-color: {{ $product['color'] ?? '#0d6efd' }};">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-3">
            <h2 class="fw-bold mb-0">Gallery</h2>
            <a href="{{ $product['cta']['secondary_href'] ?? '#contact' }}" class="btn btn-outline-primary">Request a
                live demo</a>
        </div>
        <div class="row g-5" id="lightgallery">
            @foreach($product['gallery'] as $idx => $img)
                <a class="col-6 col-md-4 col-lg-3" href="{{ asset($img) }}" data-lg-size="1600-2400">
                    <img class="img-fluid rounded-4 shadow-sm" alt="img1" src="{{ asset($img) }}"  width="250px"/>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Testimonials --}}
@if(!empty($product['testimonials']))
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="fw-bold">What clients say</h2>
        </div>
        <div class="row g-4">
            @foreach($product['testimonials'] as $t)
            <div class="col-12 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4">
                        <p class="fs-5">“{{ $t['text'] }}”</p>
                        <div class="small text-secondary">— {{ $t['author'] }}, {{ $t['role'] }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Pricing / Plans --}}
@if(!empty($product['price_cards']))
<section class="py-5 bg-light solution-pricing" style="--product-color: {{ $product['color'] ?? '#0d6efd' }};">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Flexible plans</h2>
        </div>
        <div class="row g-4 justify-content-center">
            @foreach($product['price_cards'] as $pc)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-1">{{ $pc['title'] }}</h5>
                        <div class="display-6 fw-bold text-primary">{{ $pc['price'] }}</div>
                        <p class="text-secondary">{{ $pc['desc'] }}</p>
                        <a target="_blank" href="{{ $pc['url'] ?? '#contact' }}"
                            class="btn btn-primary w-100">{{ $product['cta']['primary_text'] ?? 'Get a quote' }}</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- FAQ --}}
@if(!empty($product['faqs']))
<section class="py-5" id="faq">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="fw-bold">FAQ</h2>
        </div>
        <div class="accordion" id="faqAcc">
            @foreach($product['faqs'] as $i => $f)
            <div class="accordion-item">
                <h2 class="accordion-header" id="h{{ $i }}">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#c{{ $i }}">
                        {{ $f['q'] }}
                    </button>
                </h2>
                <div id="c{{ $i }}" class="accordion-collapse collapse" data-bs-parent="#faqAcc">
                    <div class="accordion-body">{{ $f['a'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Final CTA --}}
<section class="py-5 bg-gradient-2 solution-cta" style="--product-color: {{ $product['color'] ?? '#0d6efd' }};">
    <div class="container text-center">
        <h2 class="fw-bold mb-2">Ready to ship {{ strtolower($product['title']) }}?</h2>
        <p class="text-secondary lead">We’ll reply with a plan and timeline.</p>
        <a target="_blank" href="{{ $product['cta']['primary_href'] ?? '#contact' }}"
            class="btn btn-primary btn-lg">{{ $product['cta']['primary_text'] ?? 'Start now' }}</a>
    </div>
</section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/lightgallery@2.9.0-beta.1/lightgallery.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.8.3/plugins/zoom/lg-zoom.min.js" integrity="sha512-fwxc/NvaA3du4ZRE6J/Ilrqi2xwOB1QfHBR4neA+ha13/pkweiRfPgBiV4VbfAf/Vi3rXAXdQ3zexUJ1V2bWrg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.8.3/plugins/thumbnail/lg-thumbnail.min.js" integrity="sha512-jZxB8WysJ6S6e4Hz5IZpAzR1WiflBl0hBxriHGlLkUN32T18+rD1aLNifa1KTll/zx8lIfWVP1NqEjHi/Khy5w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">
lightGallery(document.getElementById('lightgallery'), {
    plugins: [lgZoom, lgThumbnail],
    licenseKey: 'your_license_key',
    speed: 500,
    // ... other settings
});
</script>
@endpush