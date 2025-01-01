@extends('layouts.admin')  


@section('main-content')  
    <!-- Page Heading -->  
    <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Create Volunteer') }}</h1>  


    <div class="card">  
        <div class="card-body">  
            <form action="{{ route('volunteers.store') }}" method="post">  
                @csrf  


                <div class="form-group">  
                    <label for="id_user">Nama Pengguna</label>  
                    <select class="form-control @error('id_user') is-invalid @enderror" name="id_user" id="id_user" required>  
                        <option value="">-- Pilih Pengguna --</option>  
                        @foreach($users as $user)  
                            <option value="{{ $user->id }}" {{ old('id_user') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>  
                        @endforeach  
                    </select>  
                    @error('id_user')  
                        <span class="text-danger">{{ $message }}</span>  
                    @enderror  
                </div>  


                <div class="form-group">  
                    <label for="id_kegiatan">Kegiatan</label>  
                    <select class="form-control @error('id_kegiatan') is-invalid @enderror" name="id_kegiatan" id="id_kegiatan" required>  
                        <option value="">-- Pilih Kegiatan --</option>  
                        @foreach($kegiatanVolunteers as $kegiatan)  
                            <option value="{{ $kegiatan->id }}" {{ old('id_kegiatan') == $kegiatan->id ? 'selected' : '' }}>{{ $kegiatan->nama_kegiatan }}</option>  
                        @endforeach  
                    </select>  
                    @error('id_kegiatan')  
                        <span class="text-danger">{{ $message }}</span>  
                    @enderror  
                </div>  


                <div class="form-group">  
                    <label for="status">Status</label>  
                    <select class="form-control @error('status') is-invalid @enderror" name="status" id="status" required>  
                        <option value="">-- Pilih Status --</option>  
                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>  
                        <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>Approved</option>  
                        <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>  
                    </select>  
                    @error('status')  
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


