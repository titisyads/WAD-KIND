<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organizations</title>
    
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

        .card {
            border: none;
            border-radius: 0.8rem;
            background-color: var(--card-bg);
            box-shadow: 0 2px 4px var(--card-shadow);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px var(--card-shadow);
        }

        .card-img-container {
            height: 200px;
            overflow: hidden;
            border-radius: 0.8rem 0.8rem 0 0;
        }

        .card-img-top {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 1rem;
            background-color: #f8f9fa;
        }

        .badge {
            padding: 0.3rem 0.8rem;
            border-radius: 1rem;
            font-size: 0.75rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background-color: var(--primary-color);
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
    </style>
</head>
<body>
    @include('layouts.partial.menu_user')

    <div class="hero-section">
        <div class="container">
            <h1 class="text-center mb-4">Partner Organizations</h1>
            
            <!-- Form Filter -->
            <div class="filter-section mt-3">
                <form action="" method="GET" class="row g-3 justify-content-center">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Search organizations..." 
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="kategori" class="form-select">
                            <option value="">All Categories</option>
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

    <div class="container py-4">
        <div class="row g-4">
            @forelse ($lembagas as $lembaga)
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-img-container">
                            <img src="{{ asset($lembaga->logo) }}" class="card-img-top" alt="{{ $lembaga->nama }}">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold mb-3">{{ $lembaga->nama }}</h5>
                            <span class="badge mb-3">{{ ucfirst($lembaga->kategori) }}</span>
                            
                            <ul class="info-list list-unstyled">
                                <li class="info-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>{{ $lembaga->alamat }}</span>
                                </li>
                                <li class="info-item">
                                    <i class="fas fa-phone"></i>
                                    <span>{{ $lembaga->telepon }}</span>
                                </li>
                                <li class="info-item">
                                    <i class="fas fa-envelope"></i>
                                    <span>{{ $lembaga->email }}</span>
                                </li>
                                @if($lembaga->instagram)
                                    <li class="info-item">
                                        <i class="fab fa-instagram"></i>
                                        <span>{{ $lembaga->instagram }}</span>
                                    </li>
                                @endif
                            </ul>
                        </div>
                        <div class="card-footer bg-white border-0">
                            <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#detailModal{{ $lembaga->id }}">
                                View Details
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Detail Modal -->
                <div class="modal fade" id="detailModal{{ $lembaga->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: var(--primary-color); color: white;">
                                <h5 class="modal-title">{{ $lembaga->nama }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <img src="{{ asset($lembaga->logo) }}" class="img-fluid rounded" alt="{{ $lembaga->nama }}">
                                    </div>
                                    <div class="col-md-8">
                                        <h5 class="fw-bold mb-3">About Organization</h5>
                                        <p>{{ $lembaga->deskripsi }}</p>

                                        <h5 class="fw-bold mb-3 mt-4">Contact Information</h5>
                                        <ul class="list-unstyled">
                                            <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> {{ $lembaga->alamat }}</li>
                                            <li class="mb-2"><i class="fas fa-phone me-2"></i> {{ $lembaga->telepon }}</li>
                                            <li class="mb-2"><i class="fas fa-envelope me-2"></i> {{ $lembaga->email }}</li>
                                            @if($lembaga->instagram)
                                                <li class="mb-2"><i class="fab fa-instagram me-2"></i> {{ $lembaga->instagram }}</li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center">No organizations found.</p>
                </div>
            @endforelse
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

