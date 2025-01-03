<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dokumentasi Kegiatan</title>
    
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

        .card {
            border: none;
            border-radius: 0.8rem;
            background-color: var(--card-bg);
            box-shadow: 0 2px 4px var(--card-shadow);
            transition: transform 0.3s ease;
            margin-bottom: 1.5rem;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
            border-radius: 0.8rem 0.8rem 0 0;
        }

        .filter-section {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }

        .filter-section .form-control,
        .filter-section .form-select {
            border: none;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .badge-kegiatan {
            background-color: var(--primary-color);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            font-size: 0.8rem;
        }

        .modal-content {
            border-radius: 1rem;
        }

        .modal-header {
            background: var(--primary-color);
            color: white;
        }
    </style>
</head>
<body>
    @include('layouts.partial.menu_user')

    <div class="hero-section">
        <div class="container">
            <h1 class="hero-title">Dokumentasi Kegiatan</h1>
            <p class="text-center">Galeri foto kegiatan volunteer</p>

            <!-- Filter Section -->
            <div class="filter-section">
                <form action="" method="GET" class="row g-3 justify-content-center">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Cari judul dokumentasi..." 
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="sort" class="form-select">
                            <option value="">Urutkan Berdasarkan</option>
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                            <option value="kegiatan" {{ request('sort') == 'kegiatan' ? 'selected' : '' }}>Nama Kegiatan</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-light w-100">Filter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            @forelse($dokumentasis as $dokumentasi)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="{{ asset($dokumentasi->foto) }}" class="card-img-top" alt="{{ $dokumentasi->judul }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $dokumentasi->judul }}</h5>
                            <span class="badge badge-kegiatan mb-2">
                                {{ $dokumentasi->kegiatan->nama_kegiatan }}
                            </span>
                            <p class="text-muted mb-2">
                                <i class="fas fa-calendar-alt me-2"></i>
                                {{ $dokumentasi->created_at->format('d M Y') }}
                            </p>
                            <button class="btn btn-primary w-100" data-bs-toggle="modal" 
                                    data-bs-target="#imageModal{{ $dokumentasi->id }}">
                                Lihat Detail
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="imageModal{{ $dokumentasi->id }}" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ $dokumentasi->judul }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <img src="{{ asset($dokumentasi->foto) }}" class="img-fluid rounded" 
                                     alt="{{ $dokumentasi->judul }}">
                                <div class="mt-3">
                                    <h6>Kegiatan:</h6>
                                    <p>{{ $dokumentasi->kegiatan->nama_kegiatan }}</p>
                                    <h6>Tanggal Upload:</h6>
                                    <p>{{ $dokumentasi->created_at->format('d M Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p>Tidak ada dokumentasi yang tersedia.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($dokumentasis->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $dokumentasis->links() }}
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
