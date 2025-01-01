@extends('layouts.admin')  


@section('main-content')  
    <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Volunteer Management') }}</h1>  


    <a href="{{ route('volunteers.create') }}" class="btn btn-primary mb-3">New Volunteer</a>  
    <a href="{{ route('volunteers.export') }}" class="btn btn-success mb-3">Export</a>  


    @if (session('success'))  
        <div class="alert alert-success">  
            {{ session('success') }}  
        </div>  
    @endif
   
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif


    <table class="table table-bordered table-striped">  
        <thead>  
            <tr>  
                <th>No</th>  
                <th>Nama Volunteer</th>  
                <th>Kegiatan</th>  
                <th>Status</th>  
                <th>User Email</th>  
                <th>Actions</th>  
            </tr>  
        </thead>  
        <tbody>  
            @foreach ($volunteers as $volunteer)  
                <tr>  
                    <td scope="row">{{ $loop->iteration }}</td>  
                    <td>{{ $volunteer->user->name }}</td>  
                    <td>{{ $volunteer->kegiatan->nama_kegiatan }}</td>  
                    <td>{{ ucfirst($volunteer->status) }}</td>  
                    <td>{{ $volunteer->user->email }}</td>      
                    <td>  
                        <div class="d-flex">  
                            <a href="{{ route('volunteers.edit', $volunteer->id) }}" class="btn btn-sm btn-primary mr-2">Edit Status</a>  
                           
                            <!-- Trigger Modal -->  
                            <button type="button" class="btn btn-sm btn-info mr-2" data-toggle="modal" data-target="#volunteerDetailModal-{{ $volunteer->id }}">Detail</button>  


                            <form action="{{ route('volunteers.destroy', $volunteer->id) }}" method="post">  
                                @csrf  
                                @method('delete')  
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this?')">Delete</button>  
                            </form>  
                        </div>  
                    </td>  
                </tr>  
            @endforeach  
        </tbody>  
    </table>  


    <!-- Modals for Each Volunteer -->  
    @foreach ($volunteers as $volunteer)  
        <div class="modal fade" id="volunteerDetailModal-{{ $volunteer->id }}" tabindex="-1" role="dialog" aria-labelledby="volunteerDetailModalLabel-{{ $volunteer->id }}" aria-hidden="true">  
            <div class="modal-dialog" role="document">  
                <div class="modal-content">  
                    <div class="modal-header">  
                        <h5 class="modal-title" id="volunteerDetailModalLabel-{{ $volunteer->id }}">Volunteer Name: {{ $volunteer->user->name }}</h5>  
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">  
                            <span aria-hidden="true">&times;</span>  
                        </button>  
                    </div>  
                    <div class="modal-body">  
                        <h4>Details:</h4>  
                        <ul>  
                            <li>Nama Volunteer: {{ $volunteer->user->name }}</li>  
                            <li>Kegiatan: {{ $volunteer->kegiatan->nama_kegiatan }}</li>  
                            <li>Status: {{ ucfirst($volunteer->status) }}</li>  
                            <li>User Email: {{ $volunteer->user->email }}</li>  
                        </ul>  
                    </div>  
                    <div class="modal-footer">  
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>  
                    </div>  
                </div>  
            </div>  
        </div>  
    @endforeach  


@endsection
