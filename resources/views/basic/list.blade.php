@extends('layouts.admin')  

@section('main-content')  
    <!-- Page Heading -->  
    <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('User List') }}</h1>  


    <!-- Success Message -->  
    @if (session('message'))  
        <div class="alert alert-success">  
            {{ session('message') }}  
        </div>  
    @endif  

    <!-- User Table -->  
    <table class="table table-bordered table-striped">  
        <thead>  
            <tr>  
                <th>No</th>  
                <th>Full Name</th>  
                <th>Nomor Telepon</th>  
                <th>Jenis Kelamin</th>  
                <th>Email</th>  
                <th>Alamat</th>  
                <th>Tanggal Lahir</th>  
                <th>Domisili</th>  
                <th>Aksi</th>  
            </tr>  
        </thead>  
        <tbody>  
            @foreach ($users as $user)  
                <tr>  
                    <td scope="row">{{ $loop->iteration }}</td>  
                    <td>{{ $user->name }}</td>  
                    <td>{{ $user->no_telepon }}</td>  
                    <td>{{ $user->jenis_kelamin }}</td>  
                    <td>{{ $user->email }}</td>  
                    <td>{{ $user->alamat }}</td>  
                    <td>{{ \Carbon\Carbon::parse($user->tanggal_lahir)->format('d-m-Y') }}</td> <!-- Format Tanggal -->  
                    <td>{{ $user->domisili }}</td>  
                    <td>  
                        <div class="d-flex">  
                            <a href="{{ route('basic.edit', $user->id) }}" class="btn btn-sm btn-primary mr-2">Edit</a>  
                            <form action="{{ route('basic.destroy', $user->id) }}" method="post" onsubmit="return confirm('Are you sure to delete this?')">  
                                @csrf  
                                @method('delete')  
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>  
                            </form>  
                        </div>  
                    </td>  
                </tr>  
            @endforeach  
        </tbody>  
    </table>  

    <!-- Pagination Links -->  
    {{ $users->links() }}  

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