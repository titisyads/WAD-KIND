@extends('layouts.admin')  


@section('main-content')  
    <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Review Management') }}</h1>  


    <a href="{{ route('reviews.create') }}" class="btn btn-primary mb-3">New Review</a>  
    <a href="{{ route('reviews.export') }}" class="btn btn-success mb-3">Export</a>  


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
                <th>Nama Pengguna</th>  
                <th>Kegiatan</th>  
                <th>Rating</th>  
                <th>Komentar</th>  
                <th>Tanggal</th>  
                <th>Actions</th>  
            </tr>  
        </thead>  
        <tbody>  
            @foreach ($reviews as $review)  
                <tr>  
                    <td scope="row">{{ $loop->iteration }}</td>  
                    <td>{{ $review->user->name }}</td>  
                    <td>{{ $review->kegiatan->nama_kegiatan }}</td>  
                    <td>{{ $review->rating }}</td>  
                    <td>{{ $review->komentar }}</td>  
                    <td>{{ \Carbon\Carbon::parse($review->tanggal)->format('d-m-Y') }}</td>      
                    <td>  
                        <div class="d-flex">  
                            <a href="{{ route('reviews.edit', $review->id) }}" class="btn btn-sm btn-primary mr-2">Edit</a>  
                           
                            <!-- Trigger Modal -->  
                            <button type="button" class="btn btn-sm btn-info mr-2" data-toggle="modal" data-target="#reviewDetailModal-{{ $review->id }}">Detail</button>  


                            <form action="{{ route('reviews.destroy', $review->id) }}" method="post">  
                                @csrf  
                                @method('delete')  
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this review?')">Delete</button>  
                            </form>  
                        </div>  
                    </td>  
                </tr>  
            @endforeach  
        </tbody>  
    </table>  


    <!-- Modals for Each Review -->  
    @foreach ($reviews as $review)  
        <div class="modal fade" id="reviewDetailModal-{{ $review->id }}" tabindex="-1" role="dialog" aria-labelledby="reviewDetailModalLabel-{{ $review->id }}" aria-hidden="true">  
            <div class="modal-dialog" role="document">  
                <div class="modal-content">  
                    <div class="modal-header">  
                        <h5 class="modal-title" id="reviewDetailModalLabel-{{ $review->id }}">Review by: {{ $review->user->name }}</h5>  
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">  
                            <span aria-hidden="true">&times;</span>  
                        </button>  
                    </div>  
                    <div class="modal-body">  
                        <h4>Details:</h4>  
                        <ul>  
                            <li>Nama Pengguna: {{ $review->user->name }}</li>  
                            <li>Kegiatan: {{ $review->kegiatan->nama_kegiatan }}</li>  
                            <li>Rating: {{ $review->rating }}</li>  
                            <li>Komentar: {{ $review->komentar }}</li>  
                            <li>Tanggal: {{ \Carbon\Carbon::parse($review->tanggal)->format('d-m-Y') }}</li>  
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
