@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Lead</h1>

    <form action="{{ route('leads.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" name="first_name" class="form-control" id="first_name" value="{{ old('first_name') }}" required>
        </div>

        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" name="last_name" class="form-control" id="last_name" value="{{ old('last_name') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Save Lead</button>
    </form>
</div>
@endsection
