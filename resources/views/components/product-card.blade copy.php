@props(['title' => 'Product','platform' => '', 'img' => 'img/placeholder.jpg'])
<div class="col-12 col-md-6 col-lg-4">
    <div class="card h-100 border-0 shadow-sm hover-lift">
        <img src="{{ asset($img) }}" class="card-img-top object-cover" alt="{{ $title }}">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <h5 class="card-title mb-0">{{ $title }}</h5>
                <span class="badge text-bg-secondary">{{ $platform }}</span>
            </div>
            <p class="card-text text-secondary">{{ $slot }}</p>
            <div class="d-flex gap-2">
                <a href="#cta" class="btn btn-primary">Learn more</a>
                <a href="#cta" class="btn btn-outline-primary">Get it</a>
            </div>
        </div>
    </div>
</div>