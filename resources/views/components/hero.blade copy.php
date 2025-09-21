<section class="py-5 py-lg-6 bg-gradient position-relative overflow-hidden" id="home">
    <div class="container position-relative">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <span class="badge rounded-pill text-bg-light mb-3">Made for makers • Built with Laravel +
                    Bootstrap</span>
                <h1 class="display-5 fw-bold lh-1 mb-3">Launch faster. <span class="text-primary">Grow smarter.</span>
                </h1>
                <p class="lead text-secondary">Apps, PWAs, plugins, and tools crafted to help you ship products—and an
                    integrated TikTok scheduler to reach users where they already are.</p>
                <div class="d-flex gap-2 mt-3">
                    {{-- <a href="{{ route('tiktok.redirect') }}" class="btn btn-primary btn-lg">Connect TikTok</a> --}}
                    <a href="#products" class="btn btn-outline-primary btn-lg">Explore Products</a>
                </div>
                <div class="d-flex align-items-center gap-3 mt-4 small text-muted">
                    <div class="d-flex align-items-center gap-2"><i class="bi bi-shield-check"></i> Privacy-first</div>
                    <div class="vr"></div>
                    <div class="d-flex align-items-center gap-2"><i class="bi bi-lightning-charge"></i> Fast &
                        lightweight</div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="ratio ratio-16x9 shadow-lg rounded-4 border demo-video">
                    <!-- Replace with your hosted demo mp4 to show reviewers -->
                    <video controls poster="{{ asset('img/hero-poster.jpg') }}">
                        <source src="{{ asset('video/demo-tiktok-flow.mp4') }}" type="video/mp4">
                    </video>
                </div>
                <p class="mt-2 text-muted small">Demo: schedule & publish a TikTok post end‑to‑end using the sandbox
                    environment.</p>
            </div>
        </div>
    </div>
</section>