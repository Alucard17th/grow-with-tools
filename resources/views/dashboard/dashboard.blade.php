@extends('layouts.app')

@section('content')
<div class="container py-2">

    {{-- Flash messages --}}
    @if(session('ok'))
    <div class="alert alert-success">{{ session('ok') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Dashboard header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Dashboard</h1>
        <small class="text-muted">{{ now()->format('F j, Y H:i') }}</small>
    </div>

    {{-- Summary Cards --}}
    <div class="row g-4 mb-5">
        <div class="col-6 col-md-3">
            <div class="card shadow rounded-4 border-0 p-3 text-center">
                <h5 class="mb-1">Total Posts</h5>
                <div class="display-6 fw-bold">{{ $postsStats['total'] }}</div>
                <span class="text-muted small">All scheduled posts</span>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow rounded-4 border-0 p-3 text-center">
                <h5 class="mb-1">Published</h5>
                <div class="display-6 fw-bold text-success">{{ $postsStats['published'] }}</div>
                <span class="text-muted small">Successfully posted</span>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow rounded-4 border-0 p-3 text-center">
                <h5 class="mb-1">Failed</h5>
                <div class="display-6 fw-bold text-danger">{{ $postsStats['failed'] }}</div>
                <span class="text-muted small">Posts with errors</span>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow rounded-4 border-0 p-3 text-center">
                <h5 class="mb-1">Total Leads</h5>
                <div class="display-6 fw-bold">{{ $leadsStats['total'] }}</div>
                <span class="text-muted small">Collected from forms</span>
            </div>
        </div>
    </div>

    {{-- Recent Posts Table --}}
    <div class="row">
        <div class="col-md-7">
            <div class="card mb-5 shadow-sm rounded-4 border-0">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Posts</h5>
                    <a href="{{ route('posts.create') }}" class="btn btn-sm btn-primary">Schedule Post</a>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Caption</th>
                                <th>Publish At</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($posts as $post)
                            <tr>
                                <td>{{ $post->id }}</td>
                                <td>{{ $post->title }}</td>
                                <td class="text-truncate" style="max-width: 250px;">{{ $post->caption }}</td>
                                <td>{{ optional($post->publish_at)->format('Y-m-d H:i') }}</td>
                                <td>
                                    <span
                                        class="badge 
                                    {{ $post->status === 'published' ? 'bg-success' : ($post->status === 'failed' ? 'bg-danger' : 'bg-warning') }}">
                                        {{ ucfirst($post->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('posts.edit', $post) }}"
                                        class="btn btn-sm btn-outline-secondary">Edit</a>
                                    <form method="POST" action="{{ route('posts.destroy', $post) }}"
                                        class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-3">No posts yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            {{-- Recent Leads Table --}}
            <div class="card shadow-sm rounded-4 border-0">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Leads</h5>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($leads as $lead)
                            <tr>
                                <td>{{ $lead->id }}</td>
                                <td>{{ $lead->full_name }}</td>
                                <td>{{ $lead->email }}</td>
                                <td>
                                    <span class="badge 
                                    {{ $lead->status === 'contacted' ? 'bg-success' : 'bg-warning' }}">
                                        {{ ucfirst($lead->status) }}
                                    </span>
                                </td>
                                <td>{{ $lead->created_at->format('Y-m-d H:i') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-3">No leads yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>




</div>
@endsection