@extends('layouts.auth')

@section('auth-content')
    <div class="container-fluid">
        <div class="row justify-content-center align-items-center"
            style="height: 100vh; background-color: rgba(0, 0, 0, 0.5); background-image: url('{{ asset('img/background.jpg') }}'); background-size: cover;">


            <div class="col-xl-4" style="border: 3px solid rgba(221, 221, 221, 0.8); 
            background-color: white;
            border-radius: 10px;">
                <div class="d-flex mt-3 justify-content-start align-items-center">
                    <img src="{{ asset('img/logo/logo3.png') }}" width="150" alt="">
                </div>

                <hr style="border: 3px solid rgba(128, 128, 128, 0.8)">


                <div class="px-2 mt-4">
                    <h5 style="font-weight: 700; ">Welcome Back!</h5>
                    <p class="mb-0 text-muted" style="color: black;">Please login!</p>
                </div>


                @if (session()->has('error') == true)
                    <div class="col-12 px-2 mt-3">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <span>
                                {{ session('error') }}
                            </span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif

                <form action="{{ url('/handleLogin') }}" class="mt-4 px-2" method="POST" >
                    @csrf
                    <div class="mt-2">
                        <label for="email">Email<span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('email') is-invalid border-danger @enderror"
                            style="height: 55px; border: 1px solid #ddd" name="email" id="email"
                            placeholder="example@gmail.com" value="{{ old('email') }}">
                        @error('email')
                            <span class="text-danger" style="font-size: 13px">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mt-4">
                        <label for="password">Password<span class="text-danger">*</span></label>
                        <input type="password" class="form-control @error('password') is-invalid border-danger @enderror"
                            style="height: 55px; border: 1px solid #ddd" name="password" id="password"
                            placeholder="Enter your password">
                        @error('password')
                            <span class="text-danger" style="font-size: 13px">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mt-3 mb-3">
                        <button type="submit" class="btn px-4 text-light py-3"
                            style="width: 100%; background: #102099;"><strong>Log In</strong></button>
                    </div>

                </form>
                {{-- <a href="{{ url('/forgot-password') }}" class="forgot-pass-link">Lupa Password?</a> --}}

                
            </div>

        </div>
    </div>
@endsection
