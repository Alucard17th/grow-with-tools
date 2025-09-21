@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Lead</h1>

    <form action="{{ route('leads.update', $lead) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="email" value="{{ $lead->email }}" required>
        </div>

        <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" name="first_name" class="form-control" id="first_name" value="{{ $lead->first_name }}" required>
        </div>

        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" name="last_name" class="form-control" id="last_name" value="{{ $lead->last_name }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Lead</button>
    </form>
</div>
@endsection
