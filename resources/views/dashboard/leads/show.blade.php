@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Lead Details</h1>

    <div class="mb-3">
        <strong>Email:</strong> {{ $lead->email }}
    </div>
    <div class="mb-3">
        <strong>Full Name:</strong> {{ $lead->first_name }} {{ $lead->last_name }}
    </div>
    <div class="mb-3">
        <strong>Status:</strong> {{ $lead->status }}
    </div>
    <div class="mb-3">
        <strong>Created At:</strong> {{ $lead->created_at }}
    </div>

    <a href="{{ route('leads.index') }}" class="btn btn-secondary">Back to Leads</a>
</div>
@endsection
