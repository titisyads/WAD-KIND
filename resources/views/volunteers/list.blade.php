<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Volunteer Activities</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #7DC0F8;
            --secondary-color: #3b82f6;
            --success-color: #22c55e;
            --warning-color: #eab308;
            --danger-color: #ef4444;
            --card-shadow: rgba(0, 0, 0, 0.1);
        }

        body {
            background-color: #f8fafc;
            font-family: 'Inter', sans-serif;
        }

        .hero-section {
            background-color: var(--primary-color);
            padding: 2rem 0;
            margin-bottom: 2rem;
            color: white;
            border-radius: 0 0 1rem 1rem;
        }

        .card {
            border: none;
            border-radius: 0.8rem;
            box-shadow: 0 2px 4px var(--card-shadow);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .status-pending {
            background-color: var(--warning-color);
            color: white;
        }

        .status-approved {
            background-color: var(--success-color);
            color: white;
        }

        .status-rejected {
            background-color: var(--danger-color);
            color: white;
        }

        .activity-image {
            height: 200px;
            object-fit: cover;
            border-radius: 0.8rem 0.8rem 0 0;
        }

        .info-list {
            list-style: none;
            padding: 0;
        }

        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
            color: #64748b;
        }

        .info-item i {
            width: 24px;
            margin-right: 0.5rem;
            color: var(--primary-color);
        }
    </style>
</head>
<body>
    @include('layouts.partial.menu_user')

    <div class="hero-section">
        <div class="container">
            <h1 class="text-center mb-2">My Volunteer Activities</h1>
            <p class="text-center mb-0">Track your volunteer registration status</p>
        </div>
    </div>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            @forelse($volunteers as $volunteer)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100">
                        <img src="{{ asset($volunteer->kegiatan->banner) }}" 
                             alt="{{ $volunteer->kegiatan->nama_kegiatan }}" 
                             class="activity-image">
                        
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h5 class="card-title mb-0">{{ $volunteer->kegiatan->nama_kegiatan }}</h5>
                                <span class="status-badge status-{{ $volunteer->status }}">
                                    {{ ucfirst($volunteer->status) }}
                                </span>
                            </div>

                            <p class="text-muted mb-3">{{ $volunteer->kegiatan->lembaga->nama }}</p>

                            <ul class="info-list">
                                <li class="info-item">
                                    <i class="fas fa-calendar"></i>
                                    <span>{{ \Carbon\Carbon::parse($volunteer->kegiatan->tanggal)->format('d M Y') }}</span>
                                </li>
                                <li class="info-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>{{ $volunteer->kegiatan->lokasi }}</span>
                                </li>
                                <li class="info-item">
                                    <i class="fas fa-tag"></i>
                                    <span>{{ ucfirst($volunteer->kegiatan->kategori) }}</span>
                                </li>
                                @if($volunteer->kegiatan->jenis === 'berbayar')
                                    <li class="info-item">
                                        <i class="fas fa-money-bill"></i>
                                        <span>Rp {{ number_format($volunteer->kegiatan->harga, 0, ',', '.') }}</span>
                                    </li>
                                @endif
                            </ul>
                        </div>

                        <div class="card-footer bg-white border-0">
                            <button type="button" class="btn btn-primary w-100" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#detailModal{{ $volunteer->id }}">
                                View Details
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Detail Modal -->
                <div class="modal fade" id="detailModal{{ $volunteer->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: var(--primary-color); color: white;">
                                <h5 class="modal-title">Activity Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <img src="{{ asset($volunteer->kegiatan->banner) }}" 
                                             alt="{{ $volunteer->kegiatan->nama_kegiatan }}" 
                                             class="img-fluid rounded">
                                    </div>
                                    <div class="col-md-6">
                                        <h4>{{ $volunteer->kegiatan->nama_kegiatan }}</h4>
                                        <p class="text-muted">{{ $volunteer->kegiatan->lembaga->nama }}</p>
                                        
                                        <div class="mb-3">
                                            <h6>Registration Status</h6>
                                            <span class="status-badge status-{{ $volunteer->status }}">
                                                {{ ucfirst($volunteer->status) }}
                                            </span>
                                        </div>

                                        <h6>Activity Description</h6>
                                        <p>{{ $volunteer->kegiatan->deskripsi }}</p>

                                        <h6>Contact Information</h6>
                                        <p>{{ $volunteer->kegiatan->kontak }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                        <h4>No Activities Yet</h4>
                        <p class="text-muted">You haven't registered for any volunteer activities.</p>
                        <a href="{{ route('kegiatan_volunteers.list') }}" class="btn btn-primary mt-3">
                            Browse Activities
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
