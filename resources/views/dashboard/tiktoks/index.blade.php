@extends('layouts.app')

@section('content')
<div class="container py-5">
    @if(session('ok')) 
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('ok') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div> 
    @endif

    @if(session('error')) 
    <div class="alert alert-danger alert-dismissible fade show">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div> 
    @endif

    @php
    $igToken = \App\Models\InstagramToken::where('user_id', auth()->id())->first();
    $tiktokToken = \App\Models\TikTokToken::where('user_id', auth()->id())->first();
    @endphp

    @if($tiktokToken && $tiktokToken->expires_at && $tiktokToken->expires_at->isFuture())
    <div class="alert alert-success">
        TikTok connected (TikTok User ID: {{ $tiktokToken->tiktok_user_id }}) —
        Expires {{ $tiktokToken->expires_at->diffForHumans() }}
    </div>
    @else
    <div class="alert alert-warning d-flex align-items-center justify-content-between">
        TikTok not connected or token expired
        <a class="btn btn-outline-secondary" href="{{ route('tiktok.connect') }}">
            Connect TikTok
        </a>
    </div>
    @endif

    @if($igToken && $igToken->expires_at && $igToken->expires_at->isFuture())
    <div class="alert alert-success">
        Instagram connected (IG User ID: {{ $igToken->ig_user_id }}) — Expires
        {{ optional($igToken->expires_at)->diffForHumans() }}
    </div>
    @else
    <div class="alert alert-warning d-flex align-items-center justify-content-between">
        Instagram not connected or token expired
        <a class="btn btn-outline-secondary" href="{{ route('instagram.redirect') }}">
            Connect Instagram
        </a>
    </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Dashboard</h1>
        <div class="d-flex gap-2">


            <a class="btn btn-primary" href="{{ route('posts.create') }}">Schedule TikTok Post</a>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <span>Scheduled Posts</span>
        </div>
        <div class="table-responsive">
            <table class="table mb-0 align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>Caption</th>
                        <th>Publish At</th>
                        <th>Status</th>
                        <th>Platform</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $p)
                    <tr>
                        <td>{{ $p->id }}</td>
                        <td><span class="badge text-bg-secondary">{{ $p->product }}</span></td>
                        <td class="text-truncate" style="max-width: 380px;">
                            {{ \Illuminate\Support\Str::limit($p->caption, 120) }}
                        </td>
                        <td>{{ optional($p->publish_at)->setTimezone(config('app.timezone'))->format('Y-m-d H:i') }}
                        </td>
                        <td>
                            <span class="badge text-bg-{{ [
                  'queued'=>'warning','draft'=>'secondary','init'=>'info',
                  'publishing'=>'info','published'=>'success','failed'=>'danger'
                ][$p->status] ?? 'secondary' }}">{{ $p->status }}</span>
                            @if($p->tiktok_post_url)
                            <a href="{{ $p->tiktok_post_url }}" target="_blank" class="ms-2">View</a>
                            @endif
                        </td>
                        <td>{{ ucfirst($p->platform) }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-1">
                                <form method="POST" action="{{ route('posts.publishNow', $p) }}">
                                    @csrf
                                    <button class="btn btn-sm btn-outline-primary">Publish now</button>
                                </form>
                                <a href="{{ route('posts.edit', $p) }}"
                                    class="btn btn-sm btn-outline-secondary">Edit</a>
                                <form method="POST" action="{{ route('posts.destroy', $p) }}" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">No posts yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $posts->links() }}
        </div>
    </div>
</div>
@endsection