<section class="py-5 py-lg-6 bg-light" id="products">
    <div class="container">
        <div class="d-flex align-items-end justify-content-between mb-4">
            <div>
                <h2 class="fw-bold mb-1">Products</h2>
                <p class="text-secondary mb-0">Commercial apps and plugins you can use today.</p>
            </div>
            <a href="#contact" class="btn btn-outline-primary">Request a demo</a>
        </div>

        <div class="row g-4">
            @forelse (config('solutions.products', []) as $p)
            <x-product-card :title="$p['title']" :slug="$p['slug']" :platform="$p['platform']" :img="$p['img']" :href="($p['href'] ?? '#contact')">
                {{ $p['desc'] }}
            </x-product-card>
            @empty
            <div class="col-12">
                <div class="alert alert-info mb-0">No products yet—check back soon.</div>
            </div>
            @endforelse
        </div>
    </div>
</section>