@extends('layouts.admin')  


@section('main-content')  
  <!-- Page Heading -->  
  <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Edit Kegiatan Volunteer') }}</h1>  


  <div class="card">  
    <div class="card-body">  
      <form action="{{ route('kegiatan_volunteers.update', $kegiatanVolunteer->id) }}" method="post" enctype="multipart/form-data">  
        @csrf  
        @method('put')  


        <div class="form-group">  
          <label for="id_lembaga">Nama Lembaga</label>  
          <select class="form-control @error('id_lembaga') is-invalid @enderror" name="id_lembaga" id="id_lembaga">  
            <option value="">-- Pilih Lembaga --</option>  
            @foreach($lembagas as $lembaga)  
                <option value="{{ $lembaga->id }}" {{ old('id_lembaga') ?? $kegiatanVolunteer->id_lembaga == $lembaga->id ? 'selected' : '' }}>{{ $lembaga->nama }}</option>  
            @endforeach  
          </select>  
          @error('id_lembaga')  
            <span class="text-danger">{{ $message }}</span>  
          @enderror  
        </div>  


        <div class="form-group">  
          <label for="nama_kegiatan">Nama Kegiatan</label>  
          <input type="text" class="form-control @error('nama_kegiatan') is-invalid @enderror" name="nama_kegiatan" id="nama_kegiatan" placeholder="Nama Kegiatan" autocomplete="off" value="{{ old('nama_kegiatan') ?? $kegiatanVolunteer->nama_kegiatan }}">  
          @error('nama_kegiatan')  
            <span class="text-danger">{{ $message }}</span>  
          @enderror  
        </div>  


        <div class="form-group">  
          <label for="lokasi">Lokasi</label>  
          <input type="text" class="form-control @error('lokasi') is-invalid @enderror" name="lokasi" id="lokasi" placeholder="Lokasi Kegiatan" autocomplete="off" value="{{ old('lokasi') ?? $kegiatanVolunteer->lokasi }}">  
          @error('lokasi')  
            <span class="text-danger">{{ $message }}</span>  
          @enderror  
        </div>  


        <div class="form-group">  
          <label for="tanggal">Tanggal Kegiatan</label>  
          <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" id="tanggal" placeholder="Tanggal Kegiatan" value="{{ old('tanggal') ?? $kegiatanVolunteer->tanggal }}">  
          @error('tanggal')  
            <span class="text-danger">{{ $message }}</span>  
          @enderror  
        </div>  


        <div class="form-group">  
          <label for="deskripsi">Deskripsi</label>  
          <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" id="deskripsi" placeholder="Deskripsi Kegiatan">{{ old('deskripsi') ?? $kegiatanVolunteer->deskripsi }}</textarea>  
          @error('deskripsi')  
            <span class="text-danger">{{ $message }}</span>  
          @enderror  
        </div>  


        <div class="form-group">  
          <label for="kategori">Kategori</label>  
          <select class="form-control @error('kategori') is-invalid @enderror" name="kategori" id="kategori">  
              <option value="">-- Pilih Kategori --</option>  
              <option value="education" {{ (old('kategori') ?? $kegiatanVolunteer->kategori) == 'education' ? 'selected' : '' }}>Education</option>  
              <option value="health" {{ (old('kategori') ?? $kegiatanVolunteer->kategori) == 'health' ? 'selected' : '' }}>Health</option>  
              <option value="environment" {{ (old('kategori') ?? $kegiatanVolunteer->kategori) == 'environment' ? 'selected' : '' }}>Environment</option>  
              <option value="social service" {{ (old('kategori') ?? $kegiatanVolunteer->kategori) == 'social service' ? 'selected' : '' }}>Social Service</option>  
              <option value="community service" {{ (old('kategori') ?? $kegiatanVolunteer->kategori) == 'community service' ? 'selected' : '' }}>Community Service</option>  
              <option value="animal" {{ (old('kategori') ?? $kegiatanVolunteer->kategori) == 'animal' ? 'selected' : '' }}>Animal</option>  
          </select>  
          @error('kategori')  
              <span class="text-danger">{{ $message }}</span>  
          @enderror  
        </div>  


        <div class="form-group">  
          <label for="kuota">Kuota</label>  
          <input type="number" class="form-control @error('kuota') is-invalid @enderror" name="kuota" id="kuota" placeholder="Kuota Kegiatan" autocomplete="off" value="{{ old('kuota') ?? $kegiatanVolunteer->kuota }}">  
          @error('kuota')  
            <span class="text-danger">{{ $message }}</span>  
          @enderror  
        </div>  


        <div class="form-group">  
          <label for="jenis">Jenis Kegiatan</label>  
          <select class="form-control @error('jenis') is-invalid @enderror" name="jenis" id="jenis">  
              <option value="">-- Pilih Jenis Kegiatan --</option>  
              <option value="berbayar" {{ (old('jenis') ?? $kegiatanVolunteer->jenis) == 'berbayar' ? 'selected' : '' }}>Berbayar</option>  
              <option value="gratis" {{ (old('jenis') ?? $kegiatanVolunteer->jenis) == 'gratis' ? 'selected' : '' }}>Gratis</option>  
          </select>  
          @error('jenis')  
              <span class="text-danger">{{ $message }}</span>  
          @enderror  
        </div>  


        <div class="form-group">  
          <label for="harga">Harga</label>  
          <input type="number" class="form-control @error('harga') is-invalid @enderror" name="harga" id="harga" placeholder="Harga Kegiatan" autocomplete="off" value="{{ old('harga') ?? $kegiatanVolunteer->harga }}">  
          @error('harga')  
            <span class="text-danger">{{ $message }}</span>  
          @enderror  
        </div>  


        <div class="form-group">  
          <label for="banner">Banner Kegiatan</label>  
          <input type="file" class="form-control @error('banner') is-invalid @enderror" name="banner" id="banner">  
          @if ($kegiatanVolunteer->banner)  
            <img src="{{ asset($kegiatanVolunteer->banner) }}" alt="Banner" style="width: 50px; height: auto;" class="mt-2">  
          @endif  
          @error('banner')  
            <span class="text-danger">{{ $message }}</span>  
          @enderror  
        </div>  


        <div class="form-group">  
          <label for="id_pengurus">Nama Pengurus</label>  
          <select class="form-control @error('id_pengurus') is-invalid @enderror" name="id_pengurus" id="id_pengurus">  
              <option value="">-- Pilih Pengurus --</option>  
              @foreach($users as $user)  
                  <option value="{{ $user->id }}" {{ (old('id_pengurus') ?? $kegiatanVolunteer->id_pengurus) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>  
              @endforeach  
          </select>  
          @error('id_pengurus')  
              <span class="text-danger">{{ $message }}</span>  
          @enderror  
        </div>  



        <button type="submit" class="btn btn-primary">Save</button>  
        <a href="{{ route('kegiatan_volunteers.index') }}" class="btn btn-default">Back to list</a>  
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
