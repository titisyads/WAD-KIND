@extends('layouts.admin')

@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Checkout') }}</h1>

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
                <th>Nama User</th>
                <th>Nama Kegiatan</th>
                <th>Metode Pembayaran</th>
                <th>Status</th>
                <th>Jumlah Bayar</th>
                <th>Tanggal Checkout</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($checkouts as $checkout)
                <tr>
                    <td scope="row">{{ $loop->iteration }}</td>
                    <td>{{ $checkout->user->name }}</td>
                    <td>{{ $checkout->kegiatan->nama_kegiatan }}</td>
                    <td>{{ ucfirst($checkout->metode_pembayaran) ?? 'N/A' }}</td>
                    <td>{{ ucfirst($checkout->status) }}</td>
                    <td>Rp{{ number_format($checkout->jumlah_bayar, 0, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($checkout->tanggal_checkout)->format('d-m-Y') }}</td>
                    <td>
                        <div class="d-flex">
                            <!-- Detail Modal Trigger -->
                            <button type="button" class="btn btn-sm btn-info mr-2" data-toggle="modal" data-target="#checkoutDetailModal-{{ $checkout->id }}">Detail</button>

                            <!-- Delete Form -->
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modals for Each Checkout -->
    @foreach ($checkouts as $checkout)
        <div class="modal fade" id="checkoutDetailModal-{{ $checkout->id }}" tabindex="-1" role="dialog" aria-labelledby="checkoutDetailModalLabel-{{ $checkout->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="checkoutDetailModalLabel-{{ $checkout->id }}">Detail Checkout</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul>
                            <li><strong>Nama User:</strong> {{ $checkout->user->name }}</li>
                            <li><strong>Nama Kegiatan:</strong> {{ $checkout->kegiatan->nama_kegiatan }}</li>
                            <li><strong>Metode Pembayaran:</strong> {{ ucfirst($checkout->metode_pembayaran) ?? 'N/A' }}</li>
                            <li><strong>Status:</strong> {{ ucfirst($checkout->status) }}</li>
                            <li><strong>Jumlah Bayar:</strong> Rp{{ number_format($checkout->jumlah_bayar, 0, ',', '.') }}</li>
                            <li><strong>Tanggal Checkout:</strong> {{ \Carbon\Carbon::parse($checkout->tanggal_checkout)->format('d-m-Y') }}</li>
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
