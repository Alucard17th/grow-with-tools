@props(['title' => 'Plan','price' => '','desc' => '','items' => []])
<div class="col-12 col-md-4">
    <div class="card h-100 border-0 shadow-sm">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-1">{{ $title }}</h5>
            <div class="display-6 fw-bold text-primary">{{ $price }}</div>
            <p class="text-secondary">{{ $desc }}</p>
            <ul class="list-unstyled small text-secondary mb-4">
                @foreach($items as $i)<li>• {{ $i }}</li>@endforeach
            </ul>
            <a href="#contact" class="btn btn-primary w-100">Get a quote</a>
        </div>
    </div>
</div>