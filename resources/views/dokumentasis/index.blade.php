@extends('layouts.admin')  


@section('main-content')  
    <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Dokumentasi CRUD') }}</h1>  


    <a href="{{ route('dokumentasis.create') }}" class="btn btn-primary mb-3">New Dokumentasi</a>  
    <a href="{{ route('dokumentasis.export') }}" class="btn btn-success mb-3">Export</a>  


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
                <th>Judul</th>  
                <th>Kegiatan</th>  
                <th>Foto</th>        
                <th>Actions</th>  
            </tr>  
        </thead>  
        <tbody>  
            @foreach ($dokumentasi as $item)  
                <tr>  
                    <td scope="row">{{ $loop->iteration }}</td>  
                    <td>{{ $item->judul }}</td>  
                    <td>{{ $item->kegiatan->nama_kegiatan }}</td>  
                    <td>  
                        <img src="{{ asset($item->foto) }}" alt="{{ $item->judul }}" width="50">  
                    </td>  
                    <td>  
                        <div class="d-flex">  
                            <a href="{{ route('dokumentasis.edit', $item->id) }}" class="btn btn-sm btn-primary mr-2">Edit</a>  
                            <!-- Trigger Modal -->  
                            <button type="button" class="btn btn-sm btn-info mr-2" data-toggle="modal" data-target="#dokumentasiDetailModal-{{ $item->id }}">Detail</button>  


                            <form action="{{ route('dokumentasis.destroy', $item->id) }}" method="post">  
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


    <!-- Modals for Each Dokumentasi -->  
    @foreach ($dokumentasi as $item)  
        <div class="modal fade" id="dokumentasiDetailModal-{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="dokumentasiDetailModalLabel-{{ $item->id }}" aria-hidden="true">  
            <div class="modal-dialog" role="document">  
                <div class="modal-content">  
                    <div class="modal-header">  
                        <h5 class="modal-title" id="dokumentasiDetailModalLabel-{{ $item->id }}">Judul: {{ $item->judul }}</h5>  
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">  
                            <span aria-hidden="true">&times;</span>  
                        </button>  
                    </div>  
                    <div class="modal-body">  
                        <h4>Details:</h4>  
                        <ul>  
                            <li>Judul: {{ $item->judul }}</li>  
                            <li>Kegiatan: {{ $item->kegiatan->nama_kegiatan }}</li>  
                            <li>Foto: <br>  
                                <img src="{{ asset($item->foto) }}" alt="{{ $item->judul }}" width="100">  
                            </li> <!-- Menampilkan foto di modal -->  
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


