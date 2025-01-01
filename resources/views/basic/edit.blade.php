@extends('layouts.admin')  

@section('main-content')  
    <!-- Page Heading -->  
    <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Edit User') }}</h1>  

    <!-- Main Content goes here -->  
    <div class="card">  
        <div class="card-body">  
            <form action="{{ route('users.update', $user->id) }}" method="post">  
                @csrf  
                @method('put')  

                <div class="form-group">  
                  <label for="name">Nama</label>  
                  <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Nama Lengkap" autocomplete="off" value="{{ old('name') ?? $user->name }}">  
                  @error('name')  
                    <span class="text-danger">{{ $message }}</span>  
                  @enderror  
                </div>  
                
                <div class="form-group">  
                  <label for="no_telepon">Nomor Telepon</label>  
                  <input type="text" class="form-control @error('no_telepon') is-invalid @enderror" name="no_telepon" id="no_telepon" placeholder="Nomor Telepon" autocomplete="off" value="{{ old('no_telepon') ?? $user->no_telepon }}">  
                  @error('no_telepon')  
                    <span class="text-danger">{{ $message }}</span>  
                  @enderror  
                </div>  

                <div class="form-group">  
                  <label for="jenis_kelamin">Jenis Kelamin</label>  
                  <select class="form-control @error('jenis_kelamin') is-invalid @enderror" name="jenis_kelamin" id="jenis_kelamin">  
                      <option value="">-- Pilih Jenis Kelamin --</option>  
                      <option value="Laki-Laki" {{ (old('jenis_kelamin') ?? $user->jenis_kelamin) == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>  
                      <option value="Perempuan" {{ (old('jenis_kelamin') ?? $user->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>  
                  </select>  
                  @error('jenis_kelamin')  
                      <span class="text-danger">{{ $message }}</span>  
                  @enderror  
                </div>  


                <div class="form-group">  
                  <label for="alamat">Alamat</label>  
                  <input type="text" class="form-control @error('alamat') is-invalid @enderror" name="alamat" id="alamat" placeholder="Alamat" autocomplete="off" value="{{ old('alamat') ?? $user->alamat }}">  
                  @error('alamat')  
                    <span class="text-danger">{{ $message }}</span>  
                  @enderror  
                </div>  

                <div class="form-group">  
                  <label for="tanggal_lahir">Tanggal Lahir</label>  
                  <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') ?? $user->tanggal_lahir }}">  
                  @error('tanggal_lahir')  
                    <span class="text-danger">{{ $message }}</span>  
                  @enderror  
                </div>  

                <div class="form-group">  
                  <label for="domisili">Domisili</label>  
                  <input type="text" class="form-control @error('domisili') is-invalid @enderror" name="domisili" id="domisili" placeholder="Domisili" autocomplete="off" value="{{ old('domisili') ?? $user->domisili }}">  
                  @error('domisili')  
                    <span class="text-danger">{{ $message }}</span>  
                  @enderror  
                </div>  

                <div class="form-group">  
                  <label for="email">Email</label>  
                  <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Email" autocomplete="off" value="{{ old('email') ?? $user->email }}">  
                  @error('email')  
                    <span class="text-danger">{{ $message }}</span>  
                  @enderror  
                </div>  

                <div class="form-group">  
                  <label for="password">Password</label>  
                  <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Password (Kosongkan jika tidak ingin mengganti)" autocomplete="off">  
                  @error('password')  
                    <span class="text-danger">{{ $message }}</span>  
                  @enderror  
                </div>  

                <button type="submit" class="btn btn-primary">Save</button>  
                <a href="{{ route('users.index') }}" class="btn btn-default">Back to list</a>  
            </form>  
        </div>  
    </div>  

    <!-- End of Main Content -->  
@endsection  

@push('notif')  
    @if (session('success'))  
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">  
            {{ session('success') }}  
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">  
                <span aria-hidden="true">&times;</span>  
            </button>  
        </div>  
    @endif  

    @if (session('warning'))  
        <div class="alert alert-warning border-left-warning alert-dismissible fade show" role="alert">  
            {{ session('warning') }}  
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">  
                <span aria-hidden="true">&times;</span>  
            </button>  
        </div>  
    @endif  

    @if (session('status'))  
        <div class="alert alert-success border-left-success" role="alert">  
            {{ session('status') }}  
        </div>  
    @endif  
@endpush