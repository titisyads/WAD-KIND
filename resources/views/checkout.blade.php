@extends('layouts.user')

@section('content')  
<div class="container">  
    @if (session('error'))  
        <div class="alert alert-danger">  
            {{ session('error') }}  
        </div>  
    @endif  
    <br>
    <h1>Checkout Kegiatan: {{ $kegiatan->nama_kegiatan }}</h1>  
    
    <p><strong>Lokasi:</strong> {{ $kegiatan->lokasi }}</p>  
    <p><strong>Deskripsi:</strong> {{ $kegiatan->deskripsi }}</p>  
    <p><strong>Tanggal:</strong> {{ $kegiatan->tanggal }}</p>  
    <p><strong>Harga:</strong> {{ number_format($kegiatan->harga) }}</p>  

    <form action="{{ route('checkout.process') }}" method="POST">    
        @csrf  
        <input type="hidden" name="kegiatan_id" value="{{ $kegiatan->id }}">  
        <button type="submit" class="btn btn-primary">Checkout</button>  
    </form>  
</div>
<br>

@endsection