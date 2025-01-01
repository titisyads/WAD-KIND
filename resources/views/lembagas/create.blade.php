@extends('layouts.admin')  

@section('main-content')  
    <!-- Page Heading -->  
    <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Create Lembaga') }}</h1>  

    <div class="card">  
        <div class="card-body">  
            <form action="{{ route('lembagas.store') }}" method="post" enctype="multipart/form-data">  
                @csrf  
                <div class="form-group">  
                    <label for="nama">Nama Lembaga</label>  
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" id="nama" placeholder="Nama Lembaga" autocomplete="off" value="{{ old('nama') }}">  
                    @error('nama')  
                        <span class="text-danger">{{ $message }}</span>  
                    @enderror  
                </div>  

                <div class="form-group">  
                    <label for="alamat">Alamat</label>  
                    <input type="text" class="form-control @error('alamat') is-invalid @enderror" name="alamat" id="alamat" placeholder="Alamat" autocomplete="off" value="{{ old('alamat') }}">  
                    @error('alamat')  
                        <span class="text-danger">{{ $message }}</span>  
                    @enderror  
                </div>  

                <div class="form-group">  
                    <label for="telepon">Telepon</label>  
                    <input type="text" class="form-control @error('telepon') is-invalid @enderror" name="telepon" id="telepon" placeholder="Telepon" autocomplete="off" value="{{ old('telepon') }}">  
                    @error('telepon')  
                        <span class="text-danger">{{ $message }}</span>  
                    @enderror  
                </div>  

                <div class="form-group">  
                    <label for="email">Email</label>  
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Email" autocomplete="off" value="{{ old('email') }}">  
                    @error('email')  
                        <span class="text-danger">{{ $message }}</span>  
                    @enderror  
                </div>  

                <div class="form-group">  
                    <label for="instagram">Instagram</label>  
                    <input type="text" class="form-control @error('instagram') is-invalid @enderror" name="instagram" id="instagram" placeholder="Instagram" autocomplete="off" value="{{ old('instagram') }}">  
                    @error('instagram')  
                        <span class="text-danger">{{ $message }}</span>  
                    @enderror  
                </div>  

                <div class="form-group">  
                    <label for="kategori">Kategori</label>  
                    <select class="form-control @error('kategori') is-invalid @enderror" name="kategori" id="kategori">  
                        <option value="">-- Pilih Kategori --</option>  
                        <option value="education" {{ old('kategori') == 'education' ? 'selected' : '' }}>Education</option>  
                        <option value="health" {{ old('kategori') == 'health' ? 'selected' : '' }}>Health</option>  
                        <option value="environment" {{ old('kategori') == 'environment' ? 'selected' : '' }}>Environment</option>  
                        <option value="social service" {{ old('kategori') == 'social service' ? 'selected' : '' }}>Social Service</option>  
                        <option value="community service" {{ old('kategori') == 'community service' ? 'selected' : '' }}>Community Service</option>  
                        <option value="animal" {{ old('kategori') == 'animal' ? 'selected' : '' }}>Animal</option>  
                    </select>  
                    @error('kategori')  
                        <span class="text-danger">{{ $message }}</span>  
                    @enderror  
                </div>  

                <div class="form-group">  
                    <label for="deskripsi">Deskripsi</label>  
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" id="deskripsi" placeholder="Deskripsi Lembaga">{{ old('deskripsi') }}</textarea>  
                    @error('deskripsi')  
                        <span class="text-danger">{{ $message }}</span>  
                    @enderror  
                </div>  

                <div class="form-group">  
                    <label for="logo">Logo Lembaga</label>  
                    <input type="file" class="form-control @error('logo') is-invalid @enderror" name="logo" id="logo">  
                    @error('logo')  
                        <span class="text-danger">{{ $message }}</span>  
                    @enderror  
                </div> 
                
                <div class="form-group">
                    <label for="pengurus_id">Nama Pengurus</label>
                    <select class="form-control @error('pengurus_id') is-invalid @enderror" name="pengurus_id" id="pengurus_id">
                        <option value="">-- Pilih User --</option>
                        @foreach($user as $u)
                            <option value="{{ $u->id }}" {{ old('pengurus_id') == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                        @endforeach
                    </select>
                    @error('pengurus_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Save</button>  
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

    @if (session('status'))  
        <div class="alert alert-success border-left-success" role="alert">  
            {{ session('status') }}  
        </div>  
    @endif  
@endpush