@extends('layouts.auth')

@section('main-content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="text-center mb-4">
                <img src="{{ asset('img/logo.png') }}" alt="KIND Logo" style="width: 150px;">
                <p class="text-muted mt-2">Small Changes do change the future better.</p>
                <h4 class="text-dark mt-4 fw-bold">Start with <span style="color: #8ecbf7">KIND</span></h4>
            </div>

            <div class="card border-0">
                <div class="card-body">
                    <h4 class="text-center mb-4">Sign In</h4>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Username</label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   placeholder="Input your username"
                                   required>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       name="password" 
                                       placeholder="Input your password"
                                       required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword(this)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="text-end mb-3">
                            <a href="{{ route('password.request') }}" class="text-decoration-none text-muted">
                                Forgot Password?
                            </a>
                        </div>

                        <button type="submit" class="btn btn-primary w-100" color>
                            Sign In
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    body {
        background-color: #f8f9fa;
    }
    .form-control {
        border-radius: 8px;
        padding: 10px 15px;
    }
    .btn {
        border-radius: 8px;
        padding: 10px 15px;
    }
    .btn-primary {
        background-color: #8ecbf7;
        border-color: #8ecbf7;
    }
    .btn-primary:hover {
        background-color: #7ab8e4;
        border-color: #7ab8e4;
    }
    .card {
        box-shadow: 0 0 20px rgba(0,0,0,0.05);
        border-radius: 12px;
    }
</style>
@endpush

@push('scripts')
<script>
function togglePassword(button) {
    const input = button.previousElementSibling;
    const type = input.type === 'password' ? 'text' : 'password';
    input.type = type;
    
    const icon = button.querySelector('i');
    icon.classList.toggle('fa-eye');
    icon.classList.toggle('fa-eye-slash');
}
</script>
@endpush
@endsection
