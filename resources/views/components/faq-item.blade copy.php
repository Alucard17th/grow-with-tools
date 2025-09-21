@props(['q' => 'Question'])
@php($id = Str::uuid())
<div class="accordion-item">
    <h2 class="accordion-header" id="h{{ $id }}">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#c{{ $id }}"
            aria-expanded="false" aria-controls="c{{ $id }}">
            {{ $q }}
        </button>
    </h2>
    <div id="c{{ $id }}" class="accordion-collapse collapse" aria-labelledby="h{{ $id }}" data-bs-parent="#faqAcc">
        <div class="accordion-body">{{ $slot }}</div>
    </div>
</div>