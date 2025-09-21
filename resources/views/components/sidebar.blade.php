@props([
// Optional: pass a title/brand or just edit here
'title' => config('app.name', 'Grow With Tools'),
])

{{-- Responsive offcanvas: overlays on < lg, fixed/sidebar on >= lg --}}
<div class="offcanvas offcanvas-start offcanvas-lg bg-body" tabindex="-1" id="offcanvasSidebar"
    aria-labelledby="offcanvasSidebarLabel" style="width: 280px;">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="offcanvasSidebarLabel">{{ $title }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#offcanvasSidebar"
            aria-label="Close"></button>
    </div>

    <div class="offcanvas-body d-flex flex-column p-0">
        <nav class="list-group list-group-flush rounded-0">
            <a href="{{ route('dashboard') }}"
                class="list-group-item list-group-item-action {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                Home
            </a>
            <a href="{{ route('posts.index') }}"
                class="list-group-item list-group-item-action {{ request()->routeIs('posts.index') ? 'active' : '' }}"
                data-bs-toggle="collapse" data-bs-target="#dashboardMenu" aria-expanded="false"
                aria-controls="dashboardMenu">
                Posts
            </a>
            <div class="collapse" id="dashboardMenu">
              <a href="{{ route('posts.index') }}"
                    class="ps-5 list-group-item list-group-item-action {{ request()->routeIs('posts.index') ? 'active' : '' }}">
                    Posts
                </a>
                <a href="{{ route('posts.create') }}"
                    class="ps-5 list-group-item list-group-item-action {{ request()->routeIs('posts.create') ? 'active' : '' }}">
                    Schedule TikTok Post
                </a>
                <a href="{{ route('tiktok.connect') }}"
                    class="ps-5 list-group-item list-group-item-action {{ request()->routeIs('tiktok.connect') ? 'active' : '' }}">
                    Connect TikTok
                </a>
            </div>

            <a href="{{ route('leads.index') }}"
                class="list-group-item list-group-item-action {{ request()->routeIs('leads.index') ? 'active' : '' }}"
                data-bs-toggle="collapse" data-bs-target="#leadsMenu" aria-expanded="false"
                aria-controls="leadsMenu">
                Leads
            </a>
            <div class="collapse" id="leadsMenu">
                <a href="{{ route('leads.index') }}"
                    class="ps-5 list-group-item list-group-item-action {{ request()->routeIs('leads.index') ? 'active' : '' }}">
                    Leads
                </a>
                <a href="{{ route('leads.create') }}"
                    class="ps-5 list-group-item list-group-item-action {{ request()->routeIs('leads.create') ? 'active' : '' }}">
                    Create Lead
                </a>
            </div>

            {{-- add more links as needed --}}
        </nav>
    </div>


    @if (trim($slot))
    <div class="mt-auto p-3 border-top small text-muted">
        {{ $slot }}
    </div>
    @endif
</div>
</div>