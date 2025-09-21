@props(['title' => 'Project', 'tag' => 'Tag', 'img' => 'img/placeholder.jpg', 'link' => '#contact'])
<div class="col-12 col-md-6 col-lg-3">
    <div class="card h-100 border-0 shadow-sm hover-lift">
        <img src="{{ asset($img) }}" class="card-img-top img-fluid" alt="{{ $title }}">
        <div class="card-body">
            <span class="badge text-bg-light text-dark mb-2">{{ $tag }}</span>
            <h6 class="fw-bold mb-1">{{ $title }}</h6>
            <a href="{{ $link }}" class="small">Discuss a similar build →</a>
        </div>
    </div>
</div>