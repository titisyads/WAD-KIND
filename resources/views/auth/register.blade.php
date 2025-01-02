@extends('layouts.auth')

@section('main-content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="text-center mb-5">
                <img src="{{ asset('img/logo.png') }}"alt="KIND Logo" style="width: 180px; margin-bottom: 1.5rem;">
                <p class="text-muted" style="font-size: 0.95rem; margin-bottom: 1.5rem;">Small Changes do change the future better.</p>
                <h4 class="fw-bold" style="font-size: 1.5rem;">Start with <span class="text-primary">KIND</span></h4>
            </div>

            <div class="card border-0 bg-white">
                <div class="card-body p-4">
                    <h4 class="text-center mb-4 fw-bold">Register</h4>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label text-muted mb-1">Name</label>
                            <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                   name="name" value="{{ old('name') }}" required placeholder="Enter your name"
                                   style="font-size: 0.95rem;">
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted mb-1">Gender</label>
                            <select class="form-select form-select-lg @error('jenis_kelamin') is-invalid @enderror" 
                                    name="jenis_kelamin" required style="font-size: 0.95rem;">
                                <option value="">Select gender</option>
                                <option value="Laki-Laki" {{ old('jenis_kelamin') == 'Laki-Laki' ? 'selected' : '' }}>Male</option>
                                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Female</option>
                            </select>
                            @error('jenis_kelamin')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted mb-1">Phone Number</label>
                            <input type="text" class="form-control form-control-lg @error('no_telepon') is-invalid @enderror" 
                                   name="no_telepon" value="{{ old('no_telepon') }}" required placeholder="Enter your phone number"
                                   style="font-size: 0.95rem;">
                            @error('no_telepon')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted mb-1">Address</label>
                            <input type="text" class="form-control form-control-lg @error('alamat') is-invalid @enderror" 
                                   name="alamat" value="{{ old('alamat') }}" required placeholder="Enter your address"
                                   style="font-size: 0.95rem;">
                            @error('alamat')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted mb-1">Date of Birth</label>
                            <input type="date" class="form-control form-control-lg @error('tanggal_lahir') is-invalid @enderror" 
                                   name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required
                                   style="font-size: 0.95rem;">
                            @error('tanggal_lahir')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted mb-1">Domicile</label>
                            <input type="text" class="form-control form-control-lg @error('domisili') is-invalid @enderror" 
                                   name="domisili" value="{{ old('domisili') }}" required placeholder="Enter your domicile"
                                   style="font-size: 0.95rem;">
                            @error('domisili')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted mb-1">Email Address</label>
                            <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" required placeholder="Enter your email"
                                   style="font-size: 0.95rem;">
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-muted mb-1">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                       name="password" required placeholder="Create a password"
                                       style="font-size: 0.95rem;">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword(this)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold mb-3">
                            Register
                        </button>

                        <div class="text-center">
                            <a href="{{ route('login') }}" class="text-decoration-none text-muted" style="font-size: 0.9rem;">
                                Already have an account? Login here
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .form-control, .form-select {
        border: 1.5px solid #e0e0e0;
        transition: all 0.2s ease;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
    }
    
    .input-group .btn {
        border: 1.5px solid #e0e0e0;
        border-left: none;
    }
    
    .btn-primary {
        background-color: #0d6efd;
        border: none;
        transition: all 0.2s ease;
    }
    
    .btn-primary:hover {
        background-color: #0b5ed7;
        transform: translateY(-1px);
    }
    
    .invalid-feedback {
        font-size: 0.85rem;
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