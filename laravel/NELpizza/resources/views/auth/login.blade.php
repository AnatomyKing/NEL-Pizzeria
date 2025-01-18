@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 400px; margin: 50px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);">
    <h2 class="text-center" style="margin-bottom: 20px;">Login</h2>
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <!-- Email Input -->
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="email" style="font-weight: bold;">Email:</label>
            <input
                type="email"
                name="email"
                id="email"
                class="form-control"
                placeholder="Enter your email"
                required
                style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
        </div>

        <!-- Password Input -->
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="password" style="font-weight: bold;">Password:</label>
            <input
                type="password"
                name="password"
                id="password"
                class="form-control"
                placeholder="Enter your password"
                required
                style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 10px; background-color: #007bff; color: white; border: none; border-radius: 4px; font-size: 16px;">
            Login
        </button>
    </form>

    <!-- Optional Links -->
    <div class="text-center" style="margin-top: 15px;">
        <a href="{{ route('password.request') }}" style="text-decoration: none; color: #007bff;">Forgot your password?</a>
        <br>
        <a href="{{ route('register') }}" style="text-decoration: none; color: #007bff;">Don't have an account? Register</a>
    </div>
</div>
@endsection
