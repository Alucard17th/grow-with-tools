<nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top gwt-navbar">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">
            <img src="{{ asset('img/logo-gwt.svg') }}" alt="Grow With Tools" height="28" class="me-2"> Grow With Tools
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain"
            aria-controls="navMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center gap-lg-3">
                <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
                <li class="nav-item"><a class="nav-link" href="#products">Products</a></li>
                <li class="nav-item"><a class="nav-link" href="#how">How it works</a></li>
                <li class="nav-item"><a class="nav-link" href="#faq">FAQ</a></li>
                {{-- <li class="nav-item"><a class="btn btn-primary" href="{{ route('tiktok.redirect') }}">Connect TikTok</a> --}}
                </li>
            </ul>
        </div>
    </div>
</nav>