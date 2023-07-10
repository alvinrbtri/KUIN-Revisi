@extends('layouts.auth')

@section('auth-content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-8 p-0 d-none d-xl-inline-block bg-secondary" style="height: 100vh;">
                <img src="{{ asset('img/login_bg.jpg') }}" style="width: 100%; height: 100%; object-fit: cover;" alt="Login Ilustration">
            </div>
    
            <div class="col-xl-4">
                <div class="d-flex mt-3 justify-content-start align-items-center">
                    <img src="{{ asset('img/logo/logo3.png') }}" width="150" alt="">
                </div>
    
                <hr style="border: 1px solid #ddd">
    
                <div class="px-2 mt-4">
                    <h5 style="font-weight: 700;">Forgot Password</h5>
                    <p class="mb-0 text-muted">Enter your email address below and we'll send you a link to reset your password.</p>
                </div>
    
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session('status'))
                    <div class="col-12 px-2 mt-3">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session()->get('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif
    
                <form action="#" class="mt-4 px-2" method="GET">
                    @csrf
    
                    <div class="mt-2">
                        <label for="email">Email<span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" style="height: 55px; border: 1px solid #ddd" name="email" id="email" placeholder="example@gmail.com" value="{{ old('email') }}" required>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
    
                    <div class="mt-5">
                        <button type="submit" class="btn px-4 text-light py-3" style="width: 100%; background: #102099;"><strong>Send Password Reset Link</strong></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
