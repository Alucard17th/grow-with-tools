@extends('layouts.home')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
@endpush

@section('title', 'Our Solutions – Grow With Tools')

@push('meta')
    <meta name="description" content="Explore a range of tailored solutions to boost your business growth.">
@endpush

@section('content')
    <section class="py-5 py-lg-6 bg-light" id="solutions">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Our Solutions</h2>
                <p class="text-secondary">Select a platform to view relevant solutions for your business.</p>
            </div>

            <!-- Platform Filter -->
            <div class="row justify-content-center mb-4">
                <div class="col-auto">
                    <select id="platformFilter" class="form-select form-select-lg">
                        <option value="all" selected>All Platforms</option>
                        <option value="Web">Web</option>
                        <option value="iOS">iOS</option>
                        <option value="Android">Android</option>
                        <option value="PWA">PWA</option>
                    </select>
                </div>
            </div>

            <!-- Solutions Grid -->
            <div class="row g-4" id="solutionsGrid">
                @foreach($solutions as $solution)
                    <div class="col-12 col-md-6 col-lg-4 solution-card" data-platform="{{ $solution['platform'] }}">
                        <div class="card h-100 shadow-sm border-0 hover-lift">
                            <img src="{{ asset($solution['img']) }}" class="card-img-top object-cover" alt="{{ $solution['title'] }}">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">{{ $solution['title'] }}</h5>
                                <p class="card-text text-secondary">{{ $solution['desc'] }}</p>
                                <a href="{{ route('solutions.show', $solution['slug']) }}" class="btn btn-outline-primary">Learn More</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const platformFilter = document.getElementById('platformFilter');
        const solutionsGrid = document.getElementById('solutionsGrid');
        
        platformFilter.addEventListener('change', function() {
            const selectedPlatform = platformFilter.value;
            const solutions = solutionsGrid.querySelectorAll('.solution-card');

            solutions.forEach(function(solution) {
                const solutionPlatform = solution.getAttribute('data-platform');
                if (selectedPlatform === 'all' || solutionPlatform.includes(selectedPlatform)) {
                    solution.style.display = 'block'; // Show solution
                } else {
                    solution.style.display = 'none'; // Hide solution
                }
            });
        });
    });
</script>
@endpush
