@extends('layouts.dash')

@section('dash-content')
    <div class="row mx-2">
        <div class="col-12">
            <div class="card">
                <form action="/update_password" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="">
                            <label for="current_password">Current Password</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" id="current_password" placeholder="Enter your current password">
                            @error('current_password')
                            <span class="text-danger" style="font-size: 12px">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <label for="new_password">New Password</label>
                            <input type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" id="new_password" placeholder="Enter your new password">
                            @error('new_password')
                            <span class="text-danger" style="font-size: 12px">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        
                        <div class="mt-3">
                            <label for="new_password_confirmation">Confirm New Password</label>
                            <input type="password" class="form-control" name="new_password_confirmation" id="new_password_confirmation" placeholder="Confirm your new password">
                        </div>

                        <div class="mt-4">
                            <button class="btn btn-info">Change Password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection