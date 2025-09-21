<footer class="py-5 border-top bg-white">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-6">
                <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                    <img src="{{ asset('img/logo.png') }}" alt="Grow With Tools" height="32" class="me-2"> Grow With
                    Tools
                </a>
                <p class="text-secondary mt-3">Value‑driven tools and services for creators and businesses.</p>
            </div>
            <div class="col-md-3">
                <h6 class="fw-bold">Explore</h6>
                <ul class="list-unstyled">
                    <li><a href="{{route('home')}}#products" class="link-body-emphasis">Products</a></li>
                    <li><a href="{{route('home')}}#services" class="link-body-emphasis">Services</a></li>
                    <li><a href="{{route('home')}}#portfolio" class="link-body-emphasis">Portfolio</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h6 class="fw-bold">Legal</h6>
                <ul class="list-unstyled">
                    <li><a href="{{ route('terms') }}" class="link-body-emphasis">Terms of Service</a></li>
                    <li><a href="{{ route('privacy') }}" class="link-body-emphasis">Privacy Policy</a></li>
                </ul>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center pt-4 mt-4 border-top small text-secondary">
            <div>© {{ date('Y') }} Grow With Tools</div>
            {{-- <div>Built with Laravel & Bootstrap</div> --}}
        </div>
    </div>
</footer>