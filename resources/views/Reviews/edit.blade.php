@extends('layouts.admin')  


@section('main-content')  
    <!-- Page Heading -->  
    <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Edit Review') }}</h1>  


    <div class="card">  
        <div class="card-body">  
            <form action="{{ route('reviews.update', $review->id) }}" method="post">  
                @csrf  
                @method('put')  


                <div class="form-group">  
                    <label for="id_user">Nama Pengguna</label>  
                    <select class="form-control @error('id_user') is-invalid @enderror" name="id_user" id="id_user" required disabled>  
                        <option value="{{ $review->user->id }}">{{ $review->user->name }}</option>  
                    </select>  
                    @error('id_user')  
                        <span class="text-danger">{{ $message }}</span>  
                    @enderror  
                </div>  


                <div class="form-group">  
                    <label for="id_kegiatan">Kegiatan</label>  
                    <select class="form-control @error('id_kegiatan') is-invalid @enderror" name="id_kegiatan" id="id_kegiatan" required disabled>  
                        <option value="{{ $review->kegiatan->id }}">{{ $review->kegiatan->nama_kegiatan }}</option>  
                    </select>  
                    @error('id_kegiatan')  
                        <span class="text-danger">{{ $message }}</span>  
                    @enderror  
                </div>  


                <div class="form-group">  
                    <label for="rating">Rating</label>  
                    <select class="form-control @error('rating') is-invalid @enderror" name="rating" id="rating" required>  
                        <option value="">-- Pilih Rating --</option>  
                        <option value="1" {{ (old('rating') ?? $review->rating) == '1' ? 'selected' : '' }}>1</option>  
                        <option value="2" {{ (old('rating') ?? $review->rating) == '2' ? 'selected' : '' }}>2</option>  
                        <option value="3" {{ (old('rating') ?? $review->rating) == '3' ? 'selected' : '' }}>3</option>  
                        <option value="4" {{ (old('rating') ?? $review->rating) == '4' ? 'selected' : '' }}>4</option>  
                        <option value="5" {{ (old('rating') ?? $review->rating) == '5' ? 'selected' : '' }}>5</option>  
                    </select>  
                    @error('rating')  
                        <span class="text-danger">{{ $message }}</span>  
                    @enderror  
                </div>  


                <div class="form-group">  
                    <label for="komentar">Komentar</label>  
                    <textarea class="form-control @error('komentar') is-invalid @enderror" name="komentar" id="komentar" rows="3">{{ old('komentar') ?? $review->komentar }}</textarea>  
                    @error('komentar')  
                        <span class="text-danger">{{ $message }}</span>  
                    @enderror  
                </div>  


                <div class="form-group">  
                    <label for="tanggal">Tanggal</label>  
                    <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" id="tanggal" value="{{ old('tanggal') ?? $review->tanggal }}" required>  
                    @error('tanggal')  
                        <span class="text-danger">{{ $message }}</span>  
                    @enderror  
                </div>  


                <button type="submit" class="btn btn-primary">Update</button>  
                <a href="{{ route('reviews.index') }}" class="btn btn-default">Back to list</a>  
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
