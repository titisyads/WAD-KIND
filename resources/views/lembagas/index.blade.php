@extends('layouts.admin')  

@section('main-content')  
    <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Lembaga CRUD') }}</h1>  

    <a href="{{ route('lembagas.create') }}" class="btn btn-primary mb-3">New Lembaga</a>   
    <a href="{{ route('lembagas.export') }}" class="btn btn-success mb-3">Export</a>   

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
                <th>Nama Lembaga</th>  
                <th>Kategori</th>        
                <th>Instagram</th>     
                <th>Email</th>           
                <th>Nomor Telepon</th>  
                <th>Pengurus</th>         
                <th>Actions</th>  
            </tr>  
        </thead>  
        <tbody>  
            @foreach ($lembagas as $lembaga)  
                <tr>  
                    <td scope="row">{{ $loop->iteration }}</td>  
                    <td>{{ $lembaga->nama }}</td>  
                    <td>{{ ucfirst($lembaga->kategori) }}</td>   
                    <td>{{ $lembaga->instagram }}</td>  
                    <td>{{ $lembaga->email }}</td>       
                    <td>{{ $lembaga->telepon }}</td>
                    <td>{{ $lembaga->user->name }}</td>      
                    <td>  
                        <div class="d-flex">  
                            <a href="{{ route('lembagas.edit', $lembaga->id) }}" class="btn btn-sm btn-primary mr-2">Edit</a>  
                            <!-- Trigger Modal -->  
                            <button type="button" class="btn btn-sm btn-info mr-2" data-toggle="modal" data-target="#lembagaDetailModal-{{ $lembaga->id }}">Detail</button>  

                            <form action="{{ route('lembagas.destroy', $lembaga->id) }}" method="post">  
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

    <!-- Modals for Each Lembaga -->  
    @foreach ($lembagas as $lembaga)  
        <div class="modal fade" id="lembagaDetailModal-{{ $lembaga->id }}" tabindex="-1" role="dialog" aria-labelledby="lembagaDetailModalLabel-{{ $lembaga->id }}" aria-hidden="true">  
            <div class="modal-dialog" role="document">  
                <div class="modal-content">  
                    <div class="modal-header">  
                        <h5 class="modal-title" id="lembagaDetailModalLabel-{{ $lembaga->id }}">Lembaga Name: {{ $lembaga->nama }}</h5>  
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">  
                            <span aria-hidden="true">&times;</span>  
                        </button>  
                    </div>  
                    <div class="modal-body">  
                        <h4>Details:</h4>  
                        <ul>  
                            <li>Nama Lembaga: {{ $lembaga->nama }}</li>  
                            <li>Kategori: {{ ucfirst($lembaga->kategori) }}</li>  
                            <li>Instagram: {{ $lembaga->instagram }}</li>  
                            <li>Email: {{ $lembaga->email }}</li>  
                            <li>Alamat: {{ $lembaga->alamat }}</li>  
                            <li>Nomor Telepon: {{ $lembaga->telepon }}</li>  
                            <li>Deskripsi: {{ $lembaga->deskripsi }}</li> <!-- Menampilkan deskripsi di modal -->  
                            <li>Logo: <br>  
                                <img src="{{ asset($lembaga->logo) }}" alt="{{ $lembaga->nama }}" width="100">  
                            </li> <!-- Menampilkan logo di modal -->  
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