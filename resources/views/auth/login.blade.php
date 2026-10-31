@extends('layouts.app')

@section('content')

<div class="container mt-5">


<div class="row justify-content-center">
        <div class="col-md-6 mt-5">
            <div class="card shadow-sm">
                <div class="card-body p-4 ">
                    <h1 class="h4 mb-3">Login to your Alumni account</h1>
                    <form method="POST" action="{{ route('login.store') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control"  required>
                        </div>
                        
                       
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                    <p class="mt-3 mb-0 text-center">
                        Dont have an account? <a href="{{ route('register') }}">Register here</a>
                    </p>
                  
                </div>
            </div>
        </div>
    </div>




</div>

@endsection