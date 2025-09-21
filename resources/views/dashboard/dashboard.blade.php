@extends('layouts.app')

@section('content')
<div class="container py-5">
  @if(session('ok')) <div class="alert alert-success">{{ session('ok') }}</div> @endif
  @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Dashboard</h1>
    <div class="d-flex gap-2">
      <a class="btn btn-outline-secondary" href="{{ route('tiktok.connect') }}">Connect TikTok</a>
      <a class="btn btn-primary" href="{{ route('posts.create') }}">Schedule TikTok Post</a>
    </div>
  </div>

  <div class="card">
    <div class="card-header d-flex justify-content-between">
      <span>Scheduled Posts</span>
    </div>
  
    <div class="card-footer">
      
    </div>
  </div>
</div>
@endsection
