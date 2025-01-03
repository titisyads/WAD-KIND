<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Kegiatan Volunteer' }}</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #7DC0F8; 
            --secondary-color: #3b82f6;
            --accent-color: #60a5fa;
            --card-bg: #ffffff;
            --card-shadow: rgba(0, 0, 0, 0.1);
        }

        body {
            background-color: #f8fafc; 
            font-family: 'Inter', sans-serif;
        }

        .hero-section {
            background-color: var(--primary-color); 
            padding: 1rem 0;
            margin-bottom: 1.5rem;
            color: white;
            border-radius: 0 0 1rem 1rem;
        }

        .hero-title {
            font-size: 1.2rem;
            font-weight: 600;
            text-align: center;
            margin-bottom: 0.3rem;
        }

        .hero-section p {
            font-size: 0.9rem;
            text-align: center;
            margin-bottom: 0;
            opacity: 0.9;
        }

        .card {
            border: none;
            border-radius: 0.8rem;
            background-color: var(--card-bg);
            box-shadow: 0 2px 4px var(--card-shadow);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 300px;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px var(--card-shadow);
        }

        .card-img-top {
            height: 120px;
            object-fit: cover;
            border-bottom: 2px solid var(--accent-color);
        }

        .card-body {
            padding: 0.8rem;
            height: 100%;
        }

        .card-title {
            font-size: 1rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.3rem;
        }

        .badge {
            padding: 0.3rem 0.8rem;
            border-radius: 1rem;
            font-size: 0.75rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-kategori {
            background-color: var(--primary-color);
        }

        .badge-berbayar {
            background-color: #eab308;
        }

        .badge-gratis {
            background-color: #22c55e;
        }

        .info-list {
            margin: 0.5rem 0;
        }

        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
            color: #64748b;
            font-size: 0.85rem;
        }

        .info-item i {
            width: 20px;
            height: 20px;
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f1f5f9;
            border-radius: 50%;
            margin-right: 0.5rem;
            color: var(--primary-color);
        }

        .btn {
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-primary {
            background: var(--primary-color);
            border: none;
        }

        .btn-primary:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
        }

        .btn-info {
            background: #e0f2fe;
            color: var(--primary-color);
            border: none;
        }

        .btn-info:hover {
            background: #bae6fd;
            color: var(--primary-color);
        }

        .modal-content {
            border-radius: 1rem;
            overflow: hidden;
        }

        .modal-header {
            background: var(--primary-color);
            color: white;
            border-bottom: none;
        }

        .modal-body {
            padding: 2rem;
        }

        .modal-footer {
            border-top: none;
            padding: 1.5rem 2rem;
        }

        @media (min-width: 768px) {
            .col-md-4 {
                flex: 0 0 auto;
                width: 33.33333%;
            }
        }

        @media (min-width: 992px) {
            .col-lg-3 {
                flex: 0 0 auto;
                width: 25%;
            }
        }
    </style>
</head>
<body>
    @include('layouts.partial.menu_user')

    <div class="hero-section">
        <div class="container">
            <h1 class="hero-title">{{ $title ?? 'Kegiatan Volunteer' }}</h1>
            <p class="lead">Bergabung dalam kegiatan sosial dan berbagi kebaikan bersama</p>
            
            <!-- Form Filter -->
            <div class="filter-section mt-3">
                <form action="" method="GET" class="row g-3 justify-content-center">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Cari nama kegiatan..." 
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="kategori" class="form-select">
                            <option value="">Semua Kategori</option>
                            <option value="education" {{ request('kategori') == 'education' ? 'selected' : '' }}>Education</option>
                            <option value="health" {{ request('kategori') == 'health' ? 'selected' : '' }}>Health</option>
                            <option value="environment" {{ request('kategori') == 'environment' ? 'selected' : '' }}>Environment</option>
                            <option value="social service" {{ request('kategori') == 'social service' ? 'selected' : '' }}>Social Service</option>
                            <option value="community service" {{ request('kategori') == 'community service' ? 'selected' : '' }}>Community Service</option>
                            <option value="animal" {{ request('kategori') == 'animal' ? 'selected' : '' }}>Animal</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-light w-100">Filter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .btn-back-to-home {
            background-color: #7DC0F8;
            color: white;
            padding: 6px 12px;  
            font-size: 0.875rem;  
            font-weight: 600;
            border-radius: 50px;
            border: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;  
        }

        .btn-back-to-home:hover {
            background-color: #7DC0F8;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        .btn-back-to-home i {
            font-size: 1rem;  
        }
    </style>

    <!-- Styke untuk filter -->
    <style>
        .filter-section {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 1rem;
            border-radius: 0.5rem;
        }
        
        .filter-section .form-control,
        .filter-section .form-select {
            border: none;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .filter-section .btn {
            border: none;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>

        <div class="container">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="row g-3">
        @forelse ($kegiatanVolunteers as $kegiatan)
            <div class="col-md-4 col-lg-3">
                <div class="card h-100">
                    @if($kegiatan->banner)
                        <img src="{{ asset($kegiatan->banner) }}" class="card-img-top" alt="{{ $kegiatan->nama_kegiatan }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title mb-3">{{ $kegiatan->nama_kegiatan }}</h5>
                        <p class="text-muted mb-3">{{ $kegiatan->lembaga->nama }}</p>

                        <div class="mb-3">
                            <span class="badge badge-kategori">{{ ucfirst($kegiatan->kategori) }}</span>
                            <span class="badge badge-{{ $kegiatan->jenis === 'berbayar' ? 'berbayar' : 'gratis' }}">
                                {{ ucfirst($kegiatan->jenis) }}
                            </span>
                        </div>

                        <p class="card-text text-muted">{{ Str::limit($kegiatan->deskripsi, 100) }}</p>

                        <ul class="info-list list-unstyled">
                            <li class="info-item">
                                <i class="fas fa-calendar-alt"></i>
                                <span>{{ \Carbon\Carbon::parse($kegiatan->tanggal)->format('d M Y') }}</span>
                            </li>
                            <li class="info-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>{{ $kegiatan->lokasi }}</span>
                            </li>
                            <li class="info-item">
                                <i class="fas fa-users"></i>
                                <span>Kuota: {{ $kegiatan->kuota }} orang</span>
                            </li>
                            @if($kegiatan->jenis === 'berbayar')
                                <li class="info-item">
                                    <i class="fas fa-money-bill"></i>
                                    <span>Rp {{ number_format($kegiatan->harga, 0, ',', '.') }}</span>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <div class="card-footer bg-white border-0 pt-0">
                        <div class="d-flex justify-content-between align-items-center gap-2">
                            <button type="button" class="btn btn-info flex-grow-1" data-bs-toggle="modal" data-bs-target="#detailModal{{ $kegiatan->id }}">
                                Detail
                            </button>
                            <button class="btn btn-primary flex-grow-1" data-bs-toggle="modal" data-bs-target="#daftarModal{{ $kegiatan->id }}">
                                Daftar
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Modal -->
            <div class="modal fade" id="detailModal{{ $kegiatan->id }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $kegiatan->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="detailModalLabel{{ $kegiatan->id }}">{{ $kegiatan->nama_kegiatan }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-5">
                                    @if($kegiatan->banner)
                                        <img src="{{ asset($kegiatan->banner) }}" class="img-fluid rounded w-100" style="object-fit: cover; height: 100%;" alt="{{ $kegiatan->nama_kegiatan }}">
                                    @endif
                                </div>
                                <div class="col-md-7">
                                    <h5>Deskripsi</h5>
                                    <p>{{ $kegiatan->deskripsi }}</p>

                                    <h5>Lokasi dan Waktu</h5>
                                    <p><strong>Lokasi:</strong> {{ $kegiatan->lokasi }}</p>
                                    <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($kegiatan->tanggal)->format('d M Y') }}</p>

                                    <h5>Kontak</h5>
                                    <p>{{ $kegiatan->kontak }}</p>

                                    <h5>Biaya</h5>
                                    @if($kegiatan->jenis === 'berbayar')
                                        <p>Rp {{ number_format($kegiatan->harga, 0, ',', '.') }}</p>
                                    @else
                                        <p>Gratis</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Daftar Modal -->
            <div class="modal fade" id="daftarModal{{ $kegiatan->id }}" tabindex="-1" aria-labelledby="daftarModalLabel{{ $kegiatan->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="daftarModalLabel{{ $kegiatan->id }}">Konfirmasi Pendaftaran</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Apakah Anda ingin mendaftar pada kegiatan <strong>{{ $kegiatan->nama_kegiatan }}</strong>?</p>
                        </div>
                        <div class="modal-footer">
                            @if($kegiatan->jenis === 'gratis')
                                <form action="{{ route('kegiatan.register') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id_user" value="{{ auth()->user()->id }}">
                                    <input type="hidden" name="id_kegiatan" value="{{ $kegiatan->id }}">
                                    <button type="submit" class="btn btn-primary">Daftar</button>
                                </form>
                            @else
                                <a href="{{ route('checkout.index', ['kegiatan' => $kegiatan->id]) }}" class="btn btn-primary">
                                    Lanjut ke Pembayaran
                                </a>
                            @endif
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">Tidak ada kegiatan volunteer saat ini.</p>
        @endforelse
    </div>



        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
