@props(['author' => 'User','role' => 'Role'])
<div class="col-12 col-md-4">
    <div class="card h-100 border-0 shadow-sm">
        <div class="card-body p-4">
            <p class="fs-5 mb-4">{{ $slot }}</p>
            <div class="d-flex align-items-center gap-3">
                <img src="https://avatar.iran.liara.run/username?username={{ $author }}" class="rounded-circle" width="44" height="44"
                    alt="{{ $author }}">
                <div>
                    <div class="fw-semibold">{{ $author }}</div>
                    <div class="text-secondary small">{{ $role }}</div>
                </div>
            </div>
        </div>
    </div>
</div>