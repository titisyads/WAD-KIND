@extends('layouts.admin')  


@section('main-content')  
    <!-- Page Heading -->  
    <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Edit Volunteer') }}</h1>  


    <div class="card">  
        <div class="card-body">  
            <form action="{{ route('volunteers.update', $volunteer->id) }}" method="post">  
                @csrf  
                @method('put')  




                <div class="form-group">  
                    <label for="status">Status</label>  
                    <select class="form-control @error('status') is-invalid @enderror" name="status" id="status" required>  
                        <option value="">-- Pilih Status --</option>  
                        <option value="pending" {{ (old('status') ?? $volunteer->status) == 'pending' ? 'selected' : '' }}>Pending</option>  
                        <option value="approved" {{ (old('status') ?? $volunteer->status) == 'approved' ? 'selected' : '' }}>Approved</option>  
                        <option value="rejected" {{ (old('status') ?? $volunteer->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>  
                    </select>  
                    @error('status')  
                        <span class="text-danger">{{ $message }}</span>  
                    @enderror  
                </div>  


                <button type="submit" class="btn btn-primary">Update</button>  
                <a href="{{ route('volunteers.index') }}" class="btn btn-default">Back to list</a>  
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
