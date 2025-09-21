<section class="py-5 py-lg-6" id="faq">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="fw-bold">Frequently asked questions</h2>
            <p class="text-secondary">Short, honest answers.</p>
        </div>
        <div class="accordion" id="faqAcc">
            <x-faq-item q="Who can use the TikTok integration?">
                For now, only the site owner (you). No 3rd‑party account posting.
            </x-faq-item>
            <x-faq-item q="Where are my videos hosted?">
                Under <code>/storage/videos</code> on the verified domain or via your configured CDN.
            </x-faq-item>
            <x-faq-item q="What happens after I click Publish?">
                We call TikTok Direct Post init, then poll status until it’s processed.
            </x-faq-item>
        </div>
    </div>
</section>