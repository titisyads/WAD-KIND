@extends('layouts.auth')  

@section('main-content')  
<div class="container">  
    <div class="row justify-content-center">  
        <div class="col-xl-10 col-lg-12 col-md-9">  
            <div class="card o-hidden border-0 shadow-lg my-5">  
                <div class="card-body p-0">  
                    <div class="row">  
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>  
                        <div class="col-lg-6">  
                            <div class="p-5">  
                                <div class="text-center">  
                                    <h1 class="h4 text-gray-900 mb-4">{{ __('Register') }}</h1>  
                                </div>  

                                @if ($errors->any())  
                                    <div class="alert alert-danger border-left-danger" role="alert">  
                                        <ul class="pl-4 my-2">  
                                            @foreach ($errors->all() as $error)  
                                                <li>{{ $error }}</li>  
                                            @endforeach  
                                        </ul>  
                                    </div>  
                                @endif  

                                <form method="POST" action="{{ route('register') }}" class="user">  
                                    @csrf  

                                    <div class="form-group">  
                                        <input type="text" class="form-control form-control-user @error('name') is-invalid @enderror" name="name" placeholder="{{ __('Name') }}" value="{{ old('name') }}" required autofocus>  
                                        @error('name')  
                                            <span class="text-danger">{{ $message }}</span>  
                                        @enderror  
                                    </div> 
                                    
                                    <div class="form-group">  
                                        <label for="jenis_kelamin">Jenis Kelamin</label>  
                                        <select class="form-control @error('jenis_kelamin') is-invalid @enderror" name="jenis_kelamin" id="jenis_kelamin" required>  
                                            <option value="">-- Pilih Jenis Kelamin --</option>  
                                            <option value="Laki-Laki" {{ old('jenis_kelamin') == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>  
                                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>  
                                        </select>  
                                        @error('jenis_kelamin')  
                                            <span class="text-danger">{{ $message }}</span>  
                                        @enderror  
                                    </div>  

                                    <div class="form-group">  
                                        <input type="text" class="form-control form-control-user @error('no_telepon') is-invalid @enderror" name="no_telepon" placeholder="{{ __('Nomor Telepon') }}" value="{{ old('no_telepon') }}" required>  
                                        @error('no_telepon')  
                                            <span class="text-danger">{{ $message }}</span>  
                                        @enderror  
                                    </div>  

                                    <div class="form-group">  
                                        <input type="text" class="form-control form-control-user @error('alamat') is-invalid @enderror" name="alamat" placeholder="{{ __('Alamat') }}" value="{{ old('alamat') }}" required>  
                                        @error('alamat')  
                                            <span class="text-danger">{{ $message }}</span>  
                                        @enderror  
                                    </div>  

                                    <div class="form-group">  
                                        <input type="date" class="form-control form-control-user @error('tanggal_lahir') is-invalid @enderror" name="tanggal_lahir" placeholder="{{ __('Tanggal Lahir') }}" value="{{ old('tanggal_lahir') }}" required>  
                                        @error('tanggal_lahir')  
                                            <span class="text-danger">{{ $message }}</span>  
                                        @enderror  
                                    </div>  

                                    <div class="form-group">  
                                        <input type="text" class="form-control form-control-user @error('domisili') is-invalid @enderror" name="domisili" placeholder="{{ __('Domisili') }}" value="{{ old('domisili') }}" required>  
                                        @error('domisili')  
                                            <span class="text-danger">{{ $message }}</span>  
                                        @enderror  
                                    </div>
                                    
                                    
                                    <div class="form-group">  
                                        <input type="email" class="form-control form-control-user @error('email') is-invalid @enderror" name="email" placeholder="{{ __('E-Mail Address') }}" value="{{ old('email') }}" required>  
                                        @error('email')  
                                            <span class="text-danger">{{ $message }}</span>  
                                        @enderror  
                                    </div>  

                                    <div class="form-group">  
                                        <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror" name="password" placeholder="{{ __('Password') }}" required>  
                                        @error('password')  
                                            <span class="text-danger">{{ $message }}</span>  
                                        @enderror  
                                    </div>  

                                    <div class="form-group">  
                                        <input type="password" class="form-control form-control-user @error('password_confirmation') is-invalid @enderror" name="password_confirmation" placeholder="{{ __('Confirm Password') }}" required>  
                                        @error('password_confirmation')  
                                            <span class="text-danger">{{ $message }}</span>  
                                        @enderror  
                                    </div>  

                                    <div class="form-group">  
                                        <button type="submit" class="btn btn-primary btn-user btn-block">  
                                            {{ __('Register') }}  
                                        </button>  
                                    </div>  
                                </form>  

                                <hr>  

                                <div class="text-center">  
                                    <a class="small" href="{{ route('login') }}">  
                                        {{ __('Already have an account? Login!') }}  
                                    </a>  
                                </div>  
                            </div>  
                        </div>  
                    </div>  
                </div>  
            </div>  
        </div>  
    </div>  
</div>  
@endsection