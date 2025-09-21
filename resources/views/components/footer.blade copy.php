<footer class="py-5 border-top bg-white">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-6">
                <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                    <img src="{{ asset('img/logo-gwt.svg') }}" alt="Grow With Tools" height="24" class="me-2"> Grow With
                    Tools
                </a>
                <p class="text-secondary mt-3">Value‑driven tools and content for creators and founders.</p>
            </div>
            <div class="col-md-3">
                <h6 class="fw-bold">Company</h6>
                <ul class="list-unstyled">
                    <li><a href="#products" class="link-body-emphasis">Products</a></li>
                    <li><a href="#features" class="link-body-emphasis">Features</a></li>
                    <li><a href="#review" class="link-body-emphasis">For Reviewers</a></li>
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
            <div>Built with Laravel & Bootstrap</div>
        </div>
    </div>
</footer>