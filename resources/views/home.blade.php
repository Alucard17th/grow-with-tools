@extends('layouts.app')

@section('content')
<div class="container py-5">
  <div class="row align-items-center">
    <div class="col-lg-7">
      <h1 class="display-5 fw-bold">Grow With Tools</h1>
      <p class="lead text-muted">
        Articles, insights, and product pages for my apps (mobile, PWAs, WordPress plugins, online tools).
        This site funnels qualified traffic to each product.
      </p>
      <a class="btn btn-primary btn-lg" href="{{ route('login') }}">Admin Sign in</a>
      <a class="btn btn-outline-secondary btn-lg ms-2" href="{{ route('terms') }}">Terms</a>
      <a class="btn btn-outline-secondary btn-lg ms-2" href="{{ route('privacy') }}">Privacy</a>
    </div>
  </div>
</div>
@endsection
