<section class="py-5 border-top" id="review">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-lg-7">
                <h3 class="fw-bold mb-3">For TikTok Reviewers</h3>
                <ul class="list-unstyled lh-lg">
                    <li>• <strong>Product:</strong> Grow With Tools (web dashboard)</li>
                    <li>• <strong>Capabilities used:</strong> Content Posting API (Direct Post)</li>
                    <li>• <strong>Scopes:</strong> <code>user.info.basic</code>, <code>video.publish</code></li>
                    <li>• <strong>Flow:</strong> Connect (OAuth+PKCE) → Select video (upload or URL) → Configure post →
                        Init → Status fetch → Success</li>
                    <li>• <strong>Domain for media:</strong>
                        <code>{{ parse_url(config('app.url'), PHP_URL_HOST) }}</code> under
                        <code>/storage/videos/</code></li>
                    <li>• <strong>Demo:</strong> See hero video above; end‑to‑end flow on this domain.</li>
                </ul>
                {{-- <a href="{{ route('tiktok.redirect') }}" class="btn btn-outline-primary">Start sandbox connect</a> --}}
            </div>
            <div class="col-lg-5">
                <div class="border rounded-4 p-3 bg-light">
                    <h6 class="fw-bold">Compliance</h6>
                    <ul class="small text-secondary mb-0">
                        <li>Transparent Terms & Privacy pages.</li>
                        <li>Clear user intent: creator posts to their own account only.</li>
                        <li>No 3rd‑party sharing or scraping.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>