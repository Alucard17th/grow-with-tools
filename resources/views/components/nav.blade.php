{{-- resources/views/components/nav.blade.php --}}
@props(['showAdmin' => false])
<nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top gwt-navbar">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">
            <img src="{{ asset('img/logo.png') }}" alt="Grow With Tools" height="48" class="me-2">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain"
            aria-controls="navMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center gap-lg-3">

                {{-- NEW: Solutions mega menu --}}
                <li class="nav-item dropdown dropdown-mega position-static">
                    <a class="nav-link dropdown-toggle" href="#" id="solutionsDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                        Solutions
                    </a>

                    <div class="dropdown-menu mega-menu p-0 border-0 shadow-lg" aria-labelledby="solutionsDropdown">
                        <div class="container py-4">
                            <div class="row text-end py-2 mb-2">
                                <div class="col">
                                    <a class="text-decoration-none" href="{{ route('solutions.index') }}">
                                        See all solutions
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="row g-3 row-cols-1 row-cols-md-2 row-cols-lg-3">
                                @foreach (config('solutions.products', []) as $t)
                                <a class="col text-decoration-none" href="{{ route('solutions.show', $t['slug']) }}">
                                    <div style="background: linear-gradient(180deg, {{ $t['bg'] ?? '#0d6efd' }} 0%, #ffffff 100%);"
                                        class="gwt-sol-tile h-100 rounded-4 p-4 d-flex flex-column shadow-sm hover-lift">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <h6 class="mb-0 text-dark fw-bold">{{ $t['title'] ?? 'Solution' }}</h6>
                                            <img src="{{ asset($t['img'] ?? 'img/placeholder.png') }}" alt=""
                                                class="sol-img">
                                        </div>
                                        <p class="mb-0 small text-muted">{{ $t['desc'] ?? '' }}</p>
                                    </div>
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </li>
                {{-- /Solutions --}}

                <li class="nav-item"><a class="nav-link" href="{{route('home')}}#services">Services</a></li>
                <li class="nav-item"><a class="nav-link" href="{{route('home')}}#products">Products</a></li>
                <li class="nav-item"><a class="nav-link" href="{{route('home')}}#portfolio">Portfolio</a></li>
                <!-- <li class="nav-item"><a class="nav-link" href="{{route('home')}}#pricing">Pricing</a></li> -->
                <li class="nav-item"><a class="nav-link" href="{{route('home')}}#faq">FAQ</a></li>
                <li class="nav-item"><a class="btn btn-primary" href="{{route('home')}}#contact">Contact</a></li>

                @if($showAdmin)
                <li class="nav-item dropdown ms-lg-2">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Admin</a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
                    </ul>
                </li>
                @endif
            </ul>
        </div>
    </div>
</nav>