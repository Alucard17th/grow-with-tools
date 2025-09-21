@props(['number' => '1','title' => 'Step'])
<div class="col">
    <div class="card h-100 border-0 shadow-sm">
        <div class="card-body p-4">
            <div class="step-index rounded-circle bg-primary text-white fw-bold mb-3">{{ $number }}</div>
            <h6 class="fw-bold mb-2">{{ $title }}</h6>
            <p class="text-secondary mb-0">{{ $slot }}</p>
        </div>
    </div>
</div>