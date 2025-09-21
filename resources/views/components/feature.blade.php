@props(['icon' => 'star','title' => 'Feature','desc' => ''])
<div class="col-12 col-sm-6 col-lg-4">
    <div class="card h-100 shadow-sm border-0 hover-lift">
        <div class="card-body p-4">
            <div class="icon-wrap rounded-3 bg-primary-subtle text-primary mb-3">
                @svg($icon)
            </div>
            <h5 class="card-title">{{ $title }}</h5>
            <p class="card-text text-secondary">{{ $desc }}</p>
        </div>
    </div>
</div>