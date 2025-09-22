@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Edit TikTok post #{{ $post->id }}</h1>
        <span class="badge {{ in_array($post->status,['published']) ? 'text-bg-success' : 'text-bg-secondary' }}">
            {{ strtoupper($post->status) }}
        </span>
    </div>

    @if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Please fix the errors below:</strong>
        <ul class="mb-0">@foreach ($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
    </div>
    @endif

    @if ($locked)
    <div class="alert alert-warning">
        This post is <strong>{{ $post->status }}</strong> and can no longer be edited.
    </div>
    @endif

    <form method="POST" action="{{ route('posts.update', $post) }}" enctype="multipart/form-data" class="row g-3">
        @csrf
        @method('PUT')
        @php $ro = $locked ? 'readonly' : null; $dis = $locked ? 'disabled' : null; @endphp
        @php $pf = old('platform', $post->platform); @endphp

        <div class="col-md-12">
            <label class="form-label">Platform</label>
            <span class="badge bg-{{ $pf==='tiktok' ? 'dark' : 'danger-subtle' }} text-{{ $pf==='tiktok' ? 'white' : 'dark' }}">{{ $pf }}</span>
            <select name="platform" class="form-select @error('platform') is-invalid @enderror" required>
                <option value="tiktok" {{ $pf==='tiktok' ? 'selected' : '' }}>TikTok</option>
                <option value="instagram" {{ $pf==='instagram' ? 'selected' : '' }}>Instagram
                </option>
            </select>
            @error('platform') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4">
            <label class="form-label">Product</label>
            <input name="product" class="form-control @error('product') is-invalid @enderror"
                value="{{ old('product', $post->product) }}" placeholder="doctor_native or habit_tracker" {{ $ro }}
                required>
            @error('product')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-md-8">
            <label class="form-label">Title (optional)</label>
            <input name="title" class="form-control @error('title') is-invalid @enderror"
                value="{{ old('title', $post->title) }}" maxlength="120" {{ $ro }}>
            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-12">
            <label class="form-label">Caption (<= 2200)</label>
                    <textarea name="caption" rows="4" class="form-control @error('caption') is-invalid @enderror"
                        {{ $ro }}>{{ old('caption', $post->caption) }}</textarea>
                    @error('caption')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-md-4">
            <label class="form-label">Video source</label>
            <select id="video_source" name="video_source"
                class="form-select @error('video_source') is-invalid @enderror" {{ $dis }}>
                @php $vs = old('video_source', $post->file_path ? 'FILE_UPLOAD' : $post->video_source); @endphp
                <option value="PULL_FROM_URL" {{ $vs==='PULL_FROM_URL' ? 'selected' : '' }}>PULL_FROM_URL</option>
                <option value="FILE_UPLOAD" {{ $vs==='FILE_UPLOAD'   ? 'selected' : '' }}>FILE_UPLOAD</option>
            </select>
            @error('video_source')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        {{-- URL input --}}
        <div class="col-md-8 source-url">
            <label class="form-label">Video URL (if PULL_FROM_URL)</label>
            <input name="video_url" class="form-control @error('video_url') is-invalid @enderror"
                value="{{ old('video_url', $post->video_url) }}"
                placeholder="https://your-verified-domain.com/storage/videos/my-video.mp4" {{ $ro }}>
            <div class="form-text">Must be HTTPS and on a verified domain/prefix.</div>
            @error('video_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        {{-- File input --}}
        <div class="col-md-8 source-file">
            <label class="form-label">Upload video file (MP4/MOV)</label>
            <input type="file" name="file" accept="video/mp4,video/quicktime"
                class="form-control @error('file') is-invalid @enderror" {{ $dis }}>
            @if ($post->file_path)
            <div class="form-text">Current: <code>/storage/{{ $post->file_path }}</code></div>
            @endif
            <div class="form-text">We’ll host it under /storage/videos and use that HTTPS URL for TikTok.</div>
            @error('file')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-md-4">
            <label class="form-label">Cover timestamp (ms)</label>
            <input type="number" name="cover_ts_ms" class="form-control @error('cover_ts_ms') is-invalid @enderror"
                value="{{ old('cover_ts_ms', $post->cover_ts_ms ?? 900) }}" min="0" {{ $ro }}>
            @error('cover_ts_ms')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-md-4">
            <label class="form-label">Privacy</label>
            <select name="privacy" class="form-select @error('privacy') is-invalid @enderror" {{ $dis }}>
                @foreach (['PUBLIC_TO_EVERYONE','MUTUAL_FOLLOW_FRIENDS','FOLLOWER_OF_CREATOR','SELF_ONLY'] as $opt)
                <option value="{{ $opt }}" {{ old('privacy', $post->privacy)===$opt ? 'selected' : '' }}>{{ $opt }}
                </option>
                @endforeach
            </select>
            @error('privacy')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-md-4 d-flex align-items-center gap-3 flex-wrap">
            @php
            $checks = [
            'disable_duet' => 'Disable Duet',
            'disable_stitch' => 'Disable Stitch',
            'disable_comment' => 'Disable Comments',
            'brand_organic_toggle' => 'Own brand promo',
            ];
            @endphp
            @foreach ($checks as $name => $label)
            <div class="form-check">
                <input class="form-check-input @error($name) is-invalid @enderror" type="checkbox" name="{{ $name }}"
                    id="{{ $name }}" value="1" {{ old($name, $post->$name) ? 'checked' : '' }} {{ $dis }}>
                <label class="form-check-label" for="{{ $name }}">{{ $label }}</label>
                @error($name)<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            @endforeach
        </div>

        <div class="col-md-4">
            <label class="form-label">Publish at ({{ config('app.timezone') }})</label>
            <input type="datetime-local" name="publish_at"
                class="form-control @error('publish_at') is-invalid @enderror"
                value="{{ old('publish_at', optional($post->publish_at)->setTimezone(config('app.timezone'))->format('Y-m-d\TH:i')) }}"
                {{ $ro }} required>
            @error('publish_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-12">
            @if (!$locked)
            <button class="btn btn-primary">Save changes</button>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
            @else
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">Back</a>
            @endif
        </div>
    </form>
</div>

{{-- Toggle script --}}
<script>
(function() {
    const sourceSelect = document.getElementById('video_source');
    const urlGroup = document.querySelector('.source-url');
    const fileGroup = document.querySelector('.source-file');

    function sync() {
        const v = sourceSelect.value;
        urlGroup.style.display = (v === 'PULL_FROM_URL') ? '' : 'none';
        fileGroup.style.display = (v === 'FILE_UPLOAD') ? '' : 'none';
    }
    if (sourceSelect) {
        sourceSelect.addEventListener('change', sync);
    }
    sync();
})();
</script>
@endsection