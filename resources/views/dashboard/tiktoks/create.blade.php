@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="h3 mb-4">Schedule new post</h1>

    {{-- Top summary (optional but useful) --}}
    @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Please fix the errors below:</strong>
        <ul class="mb-0">
            @foreach ($errors->all() as $err)
            <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data" class="row g-3">
        @csrf

        <div class="col-md-12">
            <label class="form-label">Platform</label>
            <select name="platform" class="form-select @error('platform') is-invalid @enderror" required>
                <option value="tiktok" {{ old('platform','tiktok')==='tiktok' ? 'selected' : '' }}>TikTok</option>
                <option value="instagram" {{ old('platform','instagram')==='instagram' ? 'selected' : '' }}>Instagram</option>
            </select>
            @error('platform') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4">
            <label class="form-label">Product</label>
            <input name="product" class="form-control @error('product') is-invalid @enderror"
                value="{{ old('product') }}" placeholder="doctor_native or habit_tracker" required>
            @error('product')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-8">
            <label class="form-label">Title (optional)</label>
            <input name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}"
                maxlength="120">
            @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-12">
            <label class="form-label">Caption (<= 2200)</label>
                    <textarea name="caption" rows="4" class="form-control @error('caption') is-invalid @enderror"
                        required>{{ old('caption') }}</textarea>
                    @error('caption')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
        </div>

        <div class="col-md-4">
            <label class="form-label">Video source</label>
            <select id="video_source" name="video_source"
                class="form-select @error('video_source') is-invalid @enderror">
                <option value="PULL_FROM_URL"
                    {{ old('video_source','PULL_FROM_URL')==='PULL_FROM_URL' ? 'selected' : '' }}>PULL_FROM_URL</option>
                <option value="FILE_UPLOAD" {{ old('video_source')==='FILE_UPLOAD' ? 'selected' : '' }}>FILE_UPLOAD
                </option>
            </select>
            @error('video_source') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- URL input (visible only when PULL_FROM_URL) --}}
        <div class="col-md-8 source-url">
            <label class="form-label">Video URL (if PULL_FROM_URL)</label>
            <input name="video_url" class="form-control @error('video_url') is-invalid @enderror"
                value="{{ old('video_url') }}"
                placeholder="https://your-verified-domain.com/storage/videos/my-video.mp4">
            <div class="form-text">Must be HTTPS and on a verified domain/prefix.</div>
            @error('video_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- File input (visible only when FILE_UPLOAD) --}}
        <div class="col-md-8 source-file">
            <label class="form-label">Upload video file (MP4/MOV)</label>
            <input type="file" name="file" accept="video/mp4,video/quicktime"
                class="form-control @error('file') is-invalid @enderror">
            <div class="form-text">We’ll host it under /storage/videos and use that HTTPS URL for TikTok.</div>
            @error('file') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4">
            <label class="form-label">Cover timestamp (ms)</label>
            <input type="number" name="cover_ts_ms" class="form-control @error('cover_ts_ms') is-invalid @enderror"
                value="{{ old('cover_ts_ms', 900) }}" min="0">
            @error('cover_ts_ms')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4">
            <label class="form-label">Privacy</label>
            <select name="privacy" class="form-select @error('privacy') is-invalid @enderror">
                @foreach (['PUBLIC_TO_EVERYONE','MUTUAL_FOLLOW_FRIENDS','FOLLOWER_OF_CREATOR','SELF_ONLY'] as $opt)
                <option value="{{ $opt }}" {{ old('privacy','PUBLIC_TO_EVERYONE')===$opt ? 'selected' : '' }}>
                    {{ $opt }}
                </option>
                @endforeach
            </select>

            @error('privacy')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4 d-flex align-items-center gap-3 flex-wrap">
            <div class="form-check">
                <input class="form-check-input @error('disable_duet') is-invalid @enderror" type="checkbox"
                    name="disable_duet" id="duet" value="1" {{ old('disable_duet') ? 'checked' : '' }}>
                <label class="form-check-label" for="duet">Disable Duet</label>
                @error('disable_duet')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-check">
                <input class="form-check-input @error('disable_stitch') is-invalid @enderror" type="checkbox"
                    name="disable_stitch" id="stitch" value="1" {{ old('disable_stitch') ? 'checked' : '' }}>
                <label class="form-check-label" for="stitch">Disable Stitch</label>
                @error('disable_stitch')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-check">
                <input class="form-check-input @error('disable_comment') is-invalid @enderror" type="checkbox"
                    name="disable_comment" id="comment" value="1" {{ old('disable_comment') ? 'checked' : '' }}>
                <label class="form-check-label" for="comment">Disable Comments</label>
                @error('disable_comment')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-check">
                <input class="form-check-input @error('brand_organic_toggle') is-invalid @enderror" type="checkbox"
                    name="brand_organic_toggle" id="brand" value="1"
                    {{ old('brand_organic_toggle', true) ? 'checked' : '' }}>
                <label class="form-check-label" for="brand">Own brand promo</label>
                @error('brand_organic_toggle')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-4">
            <label class="form-label">Publish at ({{ config('app.timezone') }})</label>
            <input type="datetime-local" name="publish_at"
                class="form-control @error('publish_at') is-invalid @enderror" value="{{ old('publish_at') }}" required>
            @error('publish_at')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-12">
            <button class="btn btn-primary">Schedule</button>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
        </div>
    </form>
</div>

{{-- Tiny toggle script (no dependencies) --}}
<script>
(function(){
  const sourceSelect = document.getElementById('video_source');
  const urlGroup  = document.querySelector('.source-url');
  const fileGroup = document.querySelector('.source-file');

  function sync() {
    const v = sourceSelect.value;
    urlGroup.style.display  = (v === 'PULL_FROM_URL') ? '' : 'none';
    fileGroup.style.display = (v === 'FILE_UPLOAD')   ? '' : 'none';
  }

  sourceSelect.addEventListener('change', sync);
  sync(); // initial
})();
</script>
@endsection