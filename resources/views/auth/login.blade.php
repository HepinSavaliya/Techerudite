@extends('layout.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Customer Login</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('login') }}" method="POST">
            @csrf
            @if($message = Session::get('error'))
                <div class="alert alert-danger">{{ $message }}</div>
            @endif
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" value="{{ old('email') }}" id="email" placeholder="Enter Email Address">
                @error('email') 
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password">
                @error('password') 
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
@endsection