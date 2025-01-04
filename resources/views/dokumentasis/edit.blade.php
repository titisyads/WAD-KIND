@extends('layouts.admin')  


@section('main-content')  
  <!-- Page Heading -->  
  <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Edit Dokumentasi') }}</h1>  


  <div class="card">  
    <div class="card-body">  
      <form action="{{ route('dokumentasis.update', $dokumentasi->id) }}" method="post" enctype="multipart/form-data">  
        @csrf  
        @method('put')  


        <div class="form-group">  
          <label for="judul">Judul Dokumentasi</label>  
          <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" id="judul" placeholder="Judul Dokumentasi" autocomplete="off" value="{{ old('judul') ?? $dokumentasi->judul }}">  
          @error('judul')  
            <span class="text-danger">{{ $message }}</span>  
          @enderror  
        </div>  


        <div class="form-group">  
          <label for="id_kegiatan">Kegiatan</label>  
          <select class="form-control @error('id_kegiatan') is-invalid @enderror" name="id_kegiatan" id="id_kegiatan">  
            <option value="">-- Pilih Kegiatan --</option>  
            @foreach($kegiatanVolunteers as $kegiatan)  
              <option value="{{ $kegiatan->id }}" {{ (old('id_kegiatan') ?? $dokumentasi->id_kegiatan) == $kegiatan->id ? 'selected' : '' }}>{{ $kegiatan->nama_kegiatan }}</option>  
            @endforeach  
          </select>  
          @error('id_kegiatan')  
            <span class="text-danger">{{ $message }}</span>  
          @enderror  
        </div>  


        <div class="form-group">  
          <label for="foto">Foto Dokumentasi</label>  
          <input type="file" class="form-control @error('foto') is-invalid @enderror" name="foto" id="foto">  
          @if ($dokumentasi->foto)  
            <img src="{{ asset($dokumentasi->foto) }}" alt="Foto Dokumentasi" style="width: 50px; height: auto;" class="mt-2">  
          @endif  
          @error('foto')  
            <span class="text-danger">{{ $message }}</span>  
          @enderror  
        </div>  


        <button type="submit" class="btn btn-primary">Update</button>  
        <a href="{{ route('dokumentasis.index') }}" class="btn btn-default">Back to list</a>  
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


