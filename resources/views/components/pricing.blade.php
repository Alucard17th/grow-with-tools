<section class="py-5 py-lg-6 bg-white" id="pricing">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Simple pricing</h2>
            <p class="text-secondary">Transparent engagement models.</p>
        </div>
        <div class="row g-4">
            <x-pricing-card title="Starter" price="$1,200+" desc="Small enhancements, audits, fixes."
                :items="['1–2 weeks','1 round of revisions','Email support']" />
            <x-pricing-card title="Build" price="$6,000+" desc="Scoped feature or plugin."
                :items="['2–6 weeks','Design + Dev','Basic analytics']" />
            <x-pricing-card title="Studio" price="Custom" desc="Full product or long‑term retainer."
                :items="['Roadmap + UX','Multi‑platform','Priority support']" />
        </div>
    </div>
</section>