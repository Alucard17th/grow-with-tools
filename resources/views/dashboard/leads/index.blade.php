@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Leads</h1>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('leads.create') }}" class="btn btn-primary mb-3">Add Lead</a>
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <span>Scheduled Posts</span>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Email</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($leads as $lead)
                    <tr>
                        <td>{{ $lead->id }}</td>
                        <td>{{ $lead->email }}</td>
                        <td>{{ $lead->first_name }} {{ $lead->last_name }}</td>
                        <td>{{ $lead->status }}</td>
                        <td>{{ $lead->created_at }}</td>
                        <td>
                            <a href="{{ route('leads.edit', $lead) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('leads.destroy', $lead) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $leads->links() }}
        </div>
    </div>

</div>
@endsection