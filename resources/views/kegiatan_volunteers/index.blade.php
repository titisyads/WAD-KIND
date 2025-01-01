@extends('layouts.admin')  


@section('main-content')  
    <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Kegiatan Volunteer') }}</h1>  


    <a href="{{ route('kegiatan_volunteers.create') }}" class="btn btn-primary mb-3">New Kegiatan Volunteer</a>  
    <a href="{{ route('kegiatan_volunteers.export') }}" class="btn btn-success mb-3">Export</a>  


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
                <th>Nama Kegiatan</th>  
                <th>Lembaga</th>        
                <th>Kategori</th>  
                <th>Tanggal</th>    
                <th>Lokasi</th>  
                <th>Kuota</th>
                <th>Pengurus</th>  
                <th>Actions</th>  
            </tr>  
        </thead>  
        <tbody>  
            @foreach ($kegiatanVolunteers as $kegiatan)  
                <tr>  
                    <td scope="row">{{ $loop->iteration }}</td>  
                    <td>{{ $kegiatan->nama_kegiatan }}</td>  
                    <td>{{ $kegiatan->lembaga->nama }}</td> <!-- Menampilkan nama lembaga terkait -->  
                    <td>{{ ucfirst($kegiatan->kategori) }}</td>  
                    <td>{{ \Carbon\Carbon::parse($kegiatan->tanggal)->format('d-m-Y') }}</td> <!-- Format tanggal -->  
                    <td>{{ $kegiatan->lokasi }}</td>      
                    <td>{{ $kegiatan->kuota }}</td>  
                    <td>{{ $kegiatan->user->name }}</td>    
                    <td>  
                        <div class="d-flex">  
                            <a href="{{ route('checkout.index', $kegiatan->id) }}" class="btn btn-sm btn-success mr-2">Checkout</a>
                            <a href="{{ route('kegiatan_volunteers.edit', $kegiatan->id) }}" class="btn btn-sm btn-primary mr-2">Edit</a>  
                            <!-- Trigger Modal -->  
                            <button type="button" class="btn btn-sm btn-info mr-2" data-toggle="modal" data-target="#kegiatanDetailModal-{{ $kegiatan->id }}">Detail</button>  


                            <form action="{{ route('kegiatan_volunteers.destroy', $kegiatan->id) }}" method="post">  
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


    <!-- Modals for Each Kegiatan Volunteer -->  
    @foreach ($kegiatanVolunteers as $kegiatan)  
        <div class="modal fade" id="kegiatanDetailModal-{{ $kegiatan->id }}" tabindex="-1" role="dialog" aria-labelledby="kegiatanDetailModalLabel-{{ $kegiatan->id }}" aria-hidden="true">  
            <div class="modal-dialog" role="document">  
                <div class="modal-content">  
                    <div class="modal-header">  
                        <h5 class="modal-title" id="kegiatanDetailModalLabel-{{ $kegiatan->id }}">Kegiatan: {{ $kegiatan->nama_kegiatan }}</h5>  
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">  
                            <span aria-hidden="true">&times;</span>  
                        </button>  
                    </div>  
                    <div class="modal-body">  
                        <h4>Details:</h4>  
                        <ul>  
                            <li>Nama Kegiatan: {{ $kegiatan->nama_kegiatan }}</li>  
                            <li>Lembaga: {{ $kegiatan->lembaga->nama ?? 'N/A' }}</li>  
                            <li>Kategori: {{ ucfirst($kegiatan->kategori) }}</li>  
                            <li>Lokasi: {{ $kegiatan->lokasi }}</li>  
                            <li>Tanggal: {{ \Carbon\Carbon::parse($kegiatan->tanggal)->format('d-m-Y') }}</li> <!-- Format tanggal -->  
                            <li>Kuota: {{ $kegiatan->kuota }}</li>  
                            <li>Jenis Kegiatan: {{ ucfirst($kegiatan->jenis) }}</li>  
                            <li>Harga: {{ $kegiatan->harga ?? 'N/A' }}</li>  
                            <li>Deskripsi: {{ $kegiatan->deskripsi }}</li>  
                            <li>Banner: <br>  
                                @if($kegiatan->banner)  
                                    <img src="{{ asset($kegiatan->banner) }}" alt="{{ $kegiatan->nama_kegiatan }}" width="100">  
                                @else  
                                    N/A  
                                @endif  
                            </li>  
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
