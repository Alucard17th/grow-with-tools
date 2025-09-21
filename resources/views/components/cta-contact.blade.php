<section class="py-5 py-lg-6 bg-gradient-2" id="contact">
    <div class="container text-center">
        <h2 class="fw-bold mb-3">Tell us what you’re building</h2>
        <p class="lead text-secondary">We’ll reply with a plan and timeline.</p>
    </div>

    <!-- Form Section -->
    <div class="container">
        <form class="row g-4" action="https://formspree.io/f/mblavekw" method="POST">
            <div class="col-md-6">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" required>
                <div id="emailHelp" class="form-text">We’ll never share your email with anyone else.</div>
            </div>
            <div class="col-md-6">
                <label for="message" class="form-label">Message</label>
                <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
            </div>
            <div class="col-12">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="termsCheck" required>
                    <label class="form-check-label" for="termsCheck">
                        By contacting us, you agree to our <a href="{{ route('terms') }}">Terms</a> & 
                        <a href="{{ route('privacy') }}">Privacy</a>.
                    </label>
                </div>
            </div>
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-primary btn-lg">Submit</button>
            </div>
        </form>
    </div>
</section>
